<?php
if(empty($_GET['userid']) || !is_numeric($_GET['userid'])){
    http_response_code(400);
    exit();
}

require_once($_SERVER['DOCUMENT_ROOT']."/config/database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/config/config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/inc/functions/sfm.php");

require_once($_SERVER["DOCUMENT_ROOT"] . '/config/database.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/assets/libs/mekrodb.php');


//Database data
DB::$user = $db_login;
DB::$password = $db_password;
DB::$dbName = $db_database;
DB::$host = $db_host; //defaults to localhost if omitted
DB::$encoding = 'utf8'; // defaults to latin1 if omitted
DB::debugMode(False);

$where = new WhereClause("and");
$where->add("classfield_photo.main=%i", 1);
$where->add("classfield.enabled=%i", 1);

$where->add("classfield.user_id=%i", intval($_GET['userid']));

use Medoo\Medoo;

$query_params = array();

//Category validate
$categories = $database->select("classfield_category", "ctid");
if (!(!isset($_GET["category-select"]) || empty($_GET["category-select"]) || !is_numeric($_GET["category-select"]) || !in_array($_GET["category-select"], $categories))) {
    $query_params["classfield_categoryid"] = intval($_GET["category-select"]);
    $where->add("classfield_categoryid=%i", intval($_GET["category-select"]));
}


//Append 
$query_params['ORDER']['classfield.created_at'] = 'DESC';


//Location validation
if (isset($_GET['osm_id']) && !empty($_GET['osm_id'])) {

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
        if ($location_data["features"][0]["properties"]["place_rank"] == 8) {
            $query_params["geo_wojewodztwo.osm_id"] = $_GET['osm_id'];
            $where->add("geo_wojewodztwo.osm_id=%s", $_GET['osm_id']);
        }
        //sprawdzanie czy to miejscowość
        elseif ($location_data["features"][0]["properties"]["place_rank"] >= 12 && $location_data["features"][0]["properties"]["place_rank"] <= 18) {
            //sprawdzanie czy użytkownik podał promień
            if (isset($_GET['radius']) && is_numeric($_GET["radius"]) && $_GET["radius"] > 0) {
                //Promień jest podany
                $query_params['OR']["classfield.osm_id"] = $_GET['osm_id'];
                $query_params['OR']['"tak"'] = Medoo::raw('distance(geo_lat, geo_long, ' . $location_data["features"][0]["geometry"]["coordinates"][1] . ',' . $location_data["features"][0]["geometry"]["coordinates"][0] . ',' . $_GET["radius"] . ')');

                $subclause = $where->addClause('or'); // add a sub-clause with ORs
                $subclause->add(
                    "classfield.osm_id=%s",
                    $_GET['osm_id']
                );
                $radiusquery = 'distance(geo_lat, geo_long, ' . $location_data["features"][0]["geometry"]["coordinates"][1] . ',' . $location_data["features"][0]["geometry"]["coordinates"][0] . ',' . $_GET["radius"] . ') =%s';
                $subclause->add($radiusquery, "tak");
            } else {
                //Promienia nie ma lub jest równy 0
                $query_params["classfield.osm_id"] = $_GET['osm_id'];
                //$where->add("classfield.osm_id=%s", $_GET['osm_id']);

                //Or search name and state
                $osm_query = $where->addClause('or');
                $osm_query_a = $osm_query->addClause('AND');

                //Location explode
                $location_explode = explode(",", $location_data["features"][0]["properties"]["display_name"]);
                $osm_query_a->add("osm_name=%s", $location_data["features"][0]["properties"]["address"]["state"]);
                $osm_query_a->add("LOWER(location) = LOWER(%s)", $location_explode[0]);
            }
        }
    }
}


//COST FILTER
if ((isset($_GET['cost_min']) && is_numeric($_GET['cost_min']) && $_GET['cost_min'] >= 0) || (isset($_GET['cost_max']) && is_numeric($_GET['cost_max']) && $_GET['cost_max'] >= 0)) {
    $costclause = $where->addClause('and'); // add a sub-clause with ORs
    if ((isset($_GET['cost_min']) && is_numeric($_GET['cost_min']) && $_GET['cost_min'] >= 0)) {
        $costclause->add("cost>=%i", $_GET['cost_min']);
    }
    if ((isset($_GET['cost_max']) && is_numeric($_GET['cost_max']) && $_GET['cost_max'] >= 0)) {
        $costclause->add("cost<=%i", $_GET['cost_max']);
    }
}

//Q search
if (isset($_GET["q"]) && !empty($_GET["q"])) {
    $q = str_ireplace(array(
        '\'', '"',
        ',', ';', '<', '>'
    ), ' ', $_GET["q"]);

    $q = '%' . $q . '%';

    $qa = $where->addClause('or');
    $qa->add("LOWER(title) LIKE LOWER(%s)", $q);
    //$qa->add("LOWER(description) LIKE LOWER(%s)", $q);

}

$classfields = DB::query("SELECT classfield.id, classfield.title, classfield.created_at,classfield.location, classfield.cost,classfield_photo.photo_hash FROM classfield INNER JOIN classfield_photo ON classfield.id = classfield_photo.classfield_id INNER JOIN geo_wojewodztwo ON classfield.woj_id = geo_wojewodztwo.id WHERE %l ORDER BY classfield.created_at DESC;", $where);



foreach($classfields as $key => $value){

    $classfields[$key]['cost'] = cost_formatter($value['cost']);
    $classfields[$key]['link'] = '/post/'.clean($value['title'])."-".$value['id'];
}


echo json_encode($classfields);
