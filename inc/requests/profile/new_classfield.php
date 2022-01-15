<?php
//Chapta
@session_start();
require_once($_SERVER['DOCUMENT_ROOT']. '/config/config.php');
require_once($_SERVER['DOCUMENT_ROOT']. '/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/assets/libs/htmlsanitizer/HTMLPurifier.auto.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/inc/functions/sfm.php');


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
if(!isset($_POST['title']) || empty($_POST['title'])){
    http_response_code(400);
    echo 'tytuł jest wymagany';
    exit();
}
if(strlen($_POST['title']) < 10 || strlen($_POST['title']) > 80){
    http_response_code(400);
    echo 'Tytuł jest zbyt krótki lub zbyt długi 10<>80';
    exit();
}

//Description
if(!isset($_POST['description']) || empty($_POST['description'])){
    http_response_code(400);
    echo 'Opis jest wymagany!';
    exit();
}

$puffier_config = HTMLPurifier_Config::createDefault();
$puffier_config->set('HTML.Allowed', 'p,ul[style],ol,li,s,u,i,b,span[style],br,strong,em');
$puffier_config->set('CSS.AllowedProperties', 'text-align,text-decoration');
$purifier = new HTMLPurifier($puffier_config);
$_POST['description'] = $purifier->purify($_POST['description']);

//Validate description size
if (strlen(strip_tags($_POST['description'])) < 100 || strlen(strip_tags($_POST['description'])) > 6000) {
    http_response_code(400);
    echo 'Opis jest za krótki lub za długi. 100<>6000';
    exit();
}

//Strict phones, emails na links in description and title
//PHONE
$regex_phone = "/(?:(?:(?:(?:\+|00)\d{2})?[ -]?(?:(?:\(0?\d{2}\))|(?:0?\d{2})))?[ -]?(?:\d{3}[- ]?\d{2}[- ]?\d{2}|\d{2}[- ]?\d{2}[- ]?\d{3}|\d{7})|(?:(?:(?:\+|00)\d{2})?[ -]?\d{3}[ -]?\d{3}[ -]?\d{3}))/";
$_POST['description'] = preg_replace($regex_phone, "[usunięto telefon]", $_POST['description']);
$_POST['title'] = preg_replace($regex_phone, "[usunięto telefon]", $_POST['title']);

//EMAIL
$regex_email = "/[^@\s]*@[^@\s]*\.[^@\s]*/";
$_POST['description'] = preg_replace($regex_email, "[usunięto email]", $_POST['description']);
$_POST['title'] = preg_replace($regex_email, "[usunięto email]", $_POST['title']);
//LINKS
$regex_urls = "/(http(s?):\/\/)?(www\.)?+[a-zA-Z0-9\.\-\_]+(\.[a-zA-Z]{2,3})+(\/[a-zA-Z0-9\_\-\s\.\/\?\%\#\&\=]*)*/";
$_POST['description'] = preg_replace($regex_urls, "[usunięto link]", $_POST['description']);
$_POST['title'] = preg_replace($regex_urls, "[usunięto link]", $_POST['title']);



//category validate
$category_ids = $database->select("classfield_category","ctid");
if(!isset($_POST['category']) || empty($_POST['category']) || !in_array($_POST['category'], $category_ids)){
    http_response_code(400);
    echo 'Niepoprawna kategoria';
    exit();
}

//cost validate
if(!isset($_POST['cost']) || !is_numeric(intval($_POST['cost'])) || $_POST['cost'] < 0){
    http_response_code(400);
    echo 'Niepoprawna cena';
    exit();
}
$_POST['cost'] = intval($_POST['cost']);


if(!isset($_POST['email']) || empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    http_response_code(400);
    echo 'Adres email nie jest poprawny';
    exit();
}

if(!isset($_POST['phone']) || empty($_POST['phone']) || !preg_match('/(?<!\w)(\(?(\+|00)?48\)?)?[ -]?\d{3}[ -]?\d{3}[ -]?\d{3}(?!\w)/', $_POST['phone'])){
    http_response_code(400);
    echo 'Telefon jest niepoprawny!';
    exit();
}

//LOCATION ANALIZER
if(!isset($_POST['osm_id']) || empty($_POST['osm_id'])){
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



$location_data = json_decode($location_data_raw,1);

if(!isset($location_data["features"][0]["properties"]["place_rank"])){
    http_response_code(400);
    echo 'Nie ma takiej lokalizacji!';
    exit();
}

if(!($location_data["features"][0]["properties"]["place_rank"] >= 12 || $location_data["features"][0]["properties"]["place_rank"] <= 18)){
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


//Zdjęcia
if(!isset($_FILES["images"])){
    http_response_code(400);
    echo 'Wymagane jest minimum jedno zdjęcie.';
    exit();
}
$filenameupload = [];

for ($i = 0; $i < count($_FILES['images']['name']); $i++) {

    //Generate filename
    $new_file_name = generateRandomString(20).".".pathinfo($_FILES["images"]["name"][$i], PATHINFO_EXTENSION); 

    //Check size
    if($_FILES['images']['size'][$i] > 5000000){
        http_response_code(413);
        echo "Zdjęcie ". $_FILES["images"]["name"][$i]. "jest za duże. Maksymalny rozmiar to 4.80MB";
        exit();
    }

    //Check error
    if($_FILES['images']["error"][$i] == 1){
        http_response_code(400);
        echo 'Wystąpił problem z przesłaniem zdjęcia '. $_FILES["images"]["name"][$i];
        exit();
    }

    if(!in_array($_FILES['images']["type"][$i], $filetype_allowed)){
        http_response_code(400);
        echo 'Niedozwolone rozszerzenie pliku ' . $_FILES["images"]["name"][$i];
        exit();
    }

    //File move
    if (move_uploaded_file($_FILES['images']['tmp_name'][$i], $_SERVER['DOCUMENT_ROOT'] . $images_classfield_location.$new_file_name)) {
        $filenameupload[] = $new_file_name;
    } else {
        http_response_code(400);
        echo "Błąd podczas przesyłania pliku " . $_FILES["images"]["name"][$i];
        exit();
    }

}

//ADD CLASSFIELD TO DATABASE
$database->insert("classfield", 
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
    "phone" => $_POST["phone"]


]);

//Check if classfield addes successfull
if($database->error != NULL){
    http_response_code(500);
    echo "Błąd podczas dodawania ogłoszenia, skontaktuj się z administratorem";
    exit();
}

//Get id insert
$insert_id = $database->id();

//Add images
//Primary image add
$database->insert("classfield_photo",[
    "photo_hash" => $filenameupload[0],
    "classfield_id" => $insert_id,
    "main" => 1
]);
unset($filenameupload[0]);

//Add other images
foreach($filenameupload as $single_image_name){
    $database->insert("classfield_photo", [
        "photo_hash" => $single_image_name,
        "classfield_id" => $insert_id,
        "main" => 0
    ]);
}


echo '/post/'.clean($_POST['title']).'-'.$insert_id;



 




?>