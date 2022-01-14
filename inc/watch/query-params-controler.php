<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/config/database.php');

$query_params = array();

//Category validate
$categories = $database->select("classfield_category", "ctid");
if(!(!isset($_GET["category-select"]) || empty($_GET["category-select"]) || !is_numeric($_GET["category-select"]) || !in_array($_GET["category-select"], $categories))){
    $query_params["classfield_categoryid"] = intval($_GET["category-select"]);
}

//Standard params limit, offset
//Validate data
if (!isset($_GET['offset']) || !isset($_GET['limit']) || !is_numeric($_GET['offset']) || !isset($_GET['limit'])) {
    http_response_code(400);
    exit();
}

//Append 
$query_params['LIMIT'] = [intval($_GET['offset']), intval($_GET['limit'])];
$query_params['ORDER']['classfield.created_at'] = 'DESC';


//Location validation
if(isset($_GET['osm_id']) && !empty($_GET['osm_id'])){

    //Request to osm
    $link = "https://nominatim.openstreetmap.org/lookup?osm_ids=" . htmlspecialchars($_GET['osm_id']) . "&format=geojson";
    $ch = curl_init($link);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $userAgent = 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.2 (KHTML, like Gecko) Chrome/22.0.1216.0 Safari/537.2';
    curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $location_data_raw = curl_exec($ch);
    curl_close($ch);

    //location json decode
    $location_data = json_decode($location_data_raw, 1);


    //IF LOCATION EXIST
    if (isset($location_data["features"][0]["properties"]["place_rank"])) {
        //sprawdzanie czy to województwo
        if($location_data["features"][0]["properties"]["place_rank"] == 8){
            $query_params["geo_wojewodztwo.osm_id"] = $_GET['osm_id'];

        }
        //sprawdzanie czy to miejscowość
        elseif ($location_data["features"][0]["properties"]["place_rank"] >= 12 && $location_data["features"][0]["properties"]["place_rank"] >= 18){
            //sprawdzanie czy użytkownik podał promień
            if(isset($_GET['radius']) && is_numeric($_GET["radius"]) && $_GET["radius"] > 0){
                //Promień jest podany
                $query_params['OR']["classfield.osm_id"] = $_GET['osm_id'];

            }else{
                //Promienia nie ma lub jest równy 0
                $query_params["classfield.osm_id"] = $_GET['osm_id'];
            }

        }

        
    }
}




// var_dump($query_params);


// $data = $database->debug()->select("classfield", [
//     "[>]geo_wojewodztwo" => ["woj_id" => "id"]
// ],
//  ['classfield.id'],$query_params);

// var_dump($data);

?>