<?php
//Chapta
@session_start();
require($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');
require($_SERVER['DOCUMENT_ROOT'] . '/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/libs/htmlsanitizer/HTMLPurifier.auto.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/functions/sfm.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/functions/secure.php');
require_login(0);

use Medoo\Medoo;


if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
    $secret = $grechapta_secret;
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);
    if (!($responseData->success)) {
        http_response_code(403);
        echo 'Walidacja Rechapta NIE przeszła pomyślnie. Spróbuj ponownie!.';
        exit();
    }
} else {
    http_response_code(400);
    echo 'Brak rechapty!';
    exit();
}






//title
if (!isset($_POST['title']) || empty($_POST['title'])) {
    http_response_code(400);
    echo 'tytuł jest wymagany';
    exit();
}
if (strlen($_POST['title']) < 10 || strlen($_POST['title']) > 80) {
    http_response_code(400);
    echo 'Tytuł jest zbyt krótki lub zbyt długi 10<>80';
    exit();
}

//Sanitize title
$_POST['title'] = strip_tags($_POST["title"]);

//Description
if (!isset($_POST['description']) || empty($_POST['description'])) {
    http_response_code(400);
    echo 'Opis jest wymagany!';
    exit();
}

$puffier_config = HTMLPurifier_Config::createDefault();
$puffier_config->set('HTML.Allowed', 'p,ul[style],ol,li,s,u,i,b,span[style],strong,em');
$puffier_config->set('CSS.AllowedProperties', 'text-align,text-decoration');
$purifier = new HTMLPurifier($puffier_config);
$_POST['description'] = $purifier->purify($_POST['description']);

//Validate description size
if (strlen(strip_tags($_POST['description'])) < 100 || strlen(strip_tags($_POST['description'])) > 6000) {
    http_response_code(400);
    echo 'Opis jest za krótki lub za długi. 100><6000';
    exit();
}

//Strict phones, emails na links in description and title
//PHONE
$regex_phone = "/(?:(?:(?:(?:\+|00)\d{2})?[ -]?(?:(?:\(0?\d{2}\))|(?:0?\d{2})))?[ -]?(?:\d{3}[- ]?\d{2}[- ]?\d{2}|\d{2}[- ]?\d{2}[- ]?\d{3}|\d{7})|(?:(?:(?:\+|00)\d{2})?[ -]?\d{3}[ -]?\d{3}[ -]?\d{3}))/";
$_POST['title'] = preg_replace($regex_phone, "[usunięto telefon]", $_POST['title']);

//EMAIL
$regex_email = "/[^@\s]*@[^@\s]*\.[^@\s]*/";
$_POST['title'] = preg_replace($regex_email, "[usunięto email]", $_POST['title']);
//LINKS
$regex_urls = "/(http(s?):\/\/)?(www\.)?+[a-zA-Z0-9\.\-\_]+(\.[a-zA-Z]{2,3})+(\/[a-zA-Z0-9\_\-\s\.\/\?\%\#\&\=]*)*/";
$_POST['title'] = preg_replace($regex_urls, "[usunięto link]", $_POST['title']);



//category validate
$category_ids = $database->select("classfield_category", "ctid");
if (!isset($_POST['category']) || empty($_POST['category']) || !in_array($_POST['category'], $category_ids)) {
    http_response_code(400);
    echo 'Niepoprawna kategoria';
    exit();
}

//cost validate
if (!isset($_POST['cost']) || !is_numeric(intval($_POST['cost'])) || $_POST['cost'] < 0) {
    http_response_code(400);
    echo 'Niepoprawna cena';
    exit();
}
$_POST['cost'] = intval($_POST['cost']);


if (!isset($_POST['email']) || empty($_POST['email'])) {
    $_POST["email"] = null;
} else {
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo 'Adres email nie jest poprawny';
        exit();
    } else {
        $email = $_POST['email'];
    }
}

if (!isset($_POST['phone']) || empty($_POST['phone']) || !preg_match('/(?<!\w)(\(?(\+|00)?48\)?)?[ -]?\d{3}[ -]?\d{3}[ -]?\d{3}(?!\w)/', $_POST['phone'])) {
    http_response_code(400);
    echo 'Telefon jest niepoprawny!';
    exit();
}

//LOCATION ANALIZER
if (!isset($_POST['osm_id']) || empty($_POST['osm_id'])) {
    http_response_code(400);
    echo 'Lokalizacja jest wymagana!';
    exit();
}
//Location request to api
$link = "https://nominatim.openstreetmap.org/lookup?osm_ids=" . htmlspecialchars($_POST['osm_id']) . "&format=geojson";
$ch = curl_init($link);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$userAgent = 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.2 (KHTML, like Gecko) Chrome/22.0.1216.0 Safari/537.2';
curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
curl_setopt($ch, CURLOPT_HEADER, 0);
$location_data_raw = curl_exec($ch);
curl_close($ch);



$location_data = json_decode($location_data_raw, 1);

if (!isset($location_data["features"][0]["properties"]["place_rank"])) {
    http_response_code(400);
    echo 'Nie ma takiej lokalizacji!';
    exit();
}

if (!($location_data["features"][0]["properties"]["place_rank"] >= 12 || $location_data["features"][0]["properties"]["place_rank"] <= 18)) {
    http_response_code(400);
    echo 'Nieprawidłowy zakres miejscowości!';
    exit();
}
if (!$location_data["features"][0]["properties"]["address"]["country_code"] == "pl") {
    http_response_code(400);
    echo 'Lokalizacja musi być w Polsce';
    exit();
}
$location_name = (explode(", ", $location_data["features"][0]["properties"]["display_name"]))[0];


//Województwo 
$wojewodztwo = $database->select("geo_wojewodztwo", "id", ["osm_name" => $location_data["features"][0]["properties"]["address"]["state"]]);


//Zdjęcia
if (!isset($_FILES["images"])) {
    http_response_code(400);
    echo 'Wymagane jest minimum jedno zdjęcie.';
    exit();
}
$filenameupload = [];

for ($i = 0; $i < count($_FILES['images']['name']); $i++) {

    //Generate filename
    $new_file_name = generateRandomString(20) . "." . pathinfo($_FILES["images"]["name"][$i], PATHINFO_EXTENSION);

    //Check size
    if ($_FILES['images']['size'][$i] > 5000000) {
        http_response_code(413);
        echo "Zdjęcie " . $_FILES["images"]["name"][$i] . "jest za duże. Maksymalny rozmiar to 4.80MB";
        exit();
    }

    //Check error
    if ($_FILES['images']["error"][$i] == 1) {
        http_response_code(400);
        echo 'Wystąpił problem z przesłaniem zdjęcia ' . $_FILES["images"]["name"][$i];
        exit();
    }

    if (!in_array($_FILES['images']["type"][$i], $filetype_allowed)) {
        http_response_code(400);
        echo 'Niedozwolone rozszerzenie pliku ' . $_FILES["images"]["name"][$i];
        exit();
    }

    //File move
    if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $_SERVER['DOCUMENT_ROOT'] . $images_classfield_location . $new_file_name)) {
        $filenameupload[] = $new_file_name;
    } else {
        http_response_code(400);
        echo "Błąd podczas przesyłania pliku " . $_FILES["images"]["name"][$i];
        exit();
    }
}

//Validat detail points
if (isset($_POST["point_details"])) {
    $points_detail = $database->select(
        'category_has_detail',
        [
            "[>]classfield_detail_points" => ["classfield_detail_points_id" => "id"]
        ],
        'classfield_detail_points.id',
        [
            'category_has_detail.category_id' => $_POST["category"]
        ]
    );
    if (array_diff($_POST["point_details"], $points_detail)) {
        echo "Niepoprawne wartości Details Points. Skontaktuj się z administratorem serwisu.";
        http_response_code(400);
        exit();
    }
}

//Validate d_pet_name

if (isset($_POST["d_pet_name"]) || !empty($_POST["d_pet_name"])) {
    if (strlen($_POST['d_pet_name']) > 32) {
        echo "Maksymalna długość imienia zwierzaka to 32 znaki.";
        http_response_code(400);
        exit();
    }else{
        $d_name = $_POST['d_pet_name'];
    }
}else{
    $d_name = NULL;
}


//Validate d_breed
if (isset($_POST["d_breed"])) {
    if ($_POST["d_breed"] != NULL || !empty($_POST["d_breed"])) {

        //get ids breeds for category
        $breeds_ids = $database->select("category_breed", "id", ["category_id" => $_POST['category']]);
        if(in_array($_POST["d_breed"], $breeds_ids)){
            $d_breed = $_POST["d_breed"];
        }else{
            echo "Podana rasa zwierzaka jest nieprawidłowa";
            http_response_code(400);
            exit();
        }
    } else {
        $d_breed = NULL;
    }
}


//Validate gender
if(isset($_POST["d_gender"]) && !empty($_POST["d_gender"])){

    if(in_array($_POST["d_gender"], [0,1])){
        $d_gender = $_POST["d_gender"];
    }else{
        echo "Podana płeć jest nieprawidłowa";
        http_response_code(400);
        exit();
    }

}else{
    $d_gender = NULL;
}

//Validate size
if (isset($_POST["d_size"]) && !empty($_POST["d_size"])) {

    if (in_array($_POST["d_size"], [1, 2, 3, 4])) {
        $d_size = $_POST["d_size"];
    } else {
        echo "Podana wiekość jest nieprawidłowa.";
        http_response_code(400);
        exit();
    }
} else {
    $d_size = NULL;
}



//////////////////////////UPDAING (END VALIDATION HERE)
if (isset($_POST["mode"]) && $_POST["mode"] == "edit") {
    //////////////////////
    //      EDIT MODE   //
    //////////////////////

    //Check if in edit mode insert id post exist
    if (!isset($_POST["update_id"]) || !is_numeric($_POST["update_id"])) {
        http_response_code(400);
        echo "Wymagane ID do aktualizacji";
        exit();
    }


    //Check if exist
    $old_classfield = $database->select("classfield", ["user_id"], ["id" => $_POST["update_id"]]);

    if (count($old_classfield) == 0) {
        http_response_code(404);
        echo 'Ogłoszenie nie istnieje!';
        exit();
    }

    if ($old_classfield[0]["user_id"] != $_SESSION["userdata"]["userid"]) {
        http_response_code(403);
        echo 'Brak uprawnień!';
        exit();
    }





    //Update classfield
    $database->update(
        "classfield",
        [
            "classfield_categoryid" => $_POST['category'],
            "title" => $_POST["title"],
            "description" => $_POST["description"],
            "location" => $location_name,
            "geo_long" => strval($location_data["features"][0]["geometry"]["coordinates"][0]),
            "geo_lat" => strval($location_data["features"][0]["geometry"]["coordinates"][1]),
            "osm_id" => $_POST['osm_id'],
            "user_id" => $_SESSION['userdata']['userid'],
            "updated_at" => Medoo::raw('NOW()'),
            "cost" => strval($_POST['cost']),
            "email" => $_POST["email"],
            "phone" => $_POST["phone"],
            "woj_id" => $wojewodztwo[0],
            "breed" => $d_breed,
            "gender" => $d_gender,
            "name" => $d_name,
            "size" => $d_size
        ],
        ["id" => $_POST["update_id"]]
    );

    //Download old images
    $old_images = $database->select("classfield_photo", "photo_hash", ["classfield_id" => $_POST["update_id"]]);
    $database->delete("classfield_photo", ["classfield_id" => $_POST["update_id"]]);

    //Add new images
    //Add images
    //Primary image add


    $database->insert("classfield_photo", [
        "photo_hash" => $filenameupload[0],
        "classfield_id" => $_POST["update_id"],
        "main" => 1
    ]);
    unset($filenameupload[0]);

    //Add other images
    foreach ($filenameupload as $single_image_name) {
        $database->insert("classfield_photo", [
            "photo_hash" => $single_image_name,
            "classfield_id" => $_POST["update_id"],
            "main" => 0
        ]);
    }



    //Remove old images

    foreach ($old_images as $value) {
        try {
            //Remove image from files
            unlink($_SERVER['DOCUMENT_ROOT'] . $images_classfield_location . $value);
        } catch (Exception $e) {
        }
    }

    //Remove old points details
    $database->delete('classfield_has_detail', ['classfield_id' => $_POST["update_id"]]);
    //Add points details
    if(isset($points_detail) &&!empty($points_detail)){
        foreach ($_POST["point_details"] as $value) {
            $database->insert('classfield_has_detail', [
                'classfield_id' => $_POST["update_id"],
                'detail_id' => $value
            ]);
        }
    }




    echo '/post/' . clean($_POST['title']) . '-' . $_POST["update_id"];
} else {
    //////////////////////
    //      NEW MODE    //
    //////////////////////


    //Normal insert into database
    //ADD CLASSFIELD TO DATABASE
    $database->insert(
        "classfield",
        [
            "classfield_categoryid" => $_POST['category'],
            "title" => $_POST["title"],
            "description" => $_POST["description"],
            "location" => $location_name,
            "geo_long" => strval($location_data["features"][0]["geometry"]["coordinates"][0]),
            "geo_lat" => strval($location_data["features"][0]["geometry"]["coordinates"][1]),
            "osm_id" => $_POST['osm_id'],
            "user_id" => $_SESSION['userdata']['userid'],
            "cost" => strval($_POST['cost']),
            "email" => $_POST["email"],
            "phone" => $_POST["phone"],
            "woj_id" => $wojewodztwo[0],
            "expire_at" => Medoo::raw("DATE_ADD(NOW(), INTERVAL 90 DAY)"),
            "breed" => $d_breed,
            "gender" => $d_gender,
            "name" => $d_name,
            "size" => $d_size
        ]
    );

    // //Check if classfield addes successfull
    if ($database->error != NULL) {
        http_response_code(500);
        echo "Błąd podczas dodawania ogłoszenia, skontaktuj się z administratorem";
        var_dump($database->error);
        var_dump($database->errorInfo);
        exit();
    }
    // //Get id insert
    $insert_id = $database->id();

    //Add images
    //Primary image add


    $database->insert("classfield_photo", [
        "photo_hash" => $filenameupload[0],
        "classfield_id" => $insert_id,
        "main" => 1
    ]);
    unset($filenameupload[0]);

    //Add other images
    foreach ($filenameupload as $single_image_name) {
        $database->insert("classfield_photo", [
            "photo_hash" => $single_image_name,
            "classfield_id" => $insert_id,
            "main" => 0,
        ]);
    }

    //Add points details
    foreach ($_POST["point_details"] as $value) {
        $database->insert('classfield_has_detail', [
            'classfield_id' => $insert_id,
            'detail_id' => $value
        ]);
    }


    echo '/post/' . clean($_POST['title']) . '-' . $insert_id;
}
