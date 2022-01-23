<?php
@session_start();
if (!isset($_SESSION['userdata']['userid'])) {
    http_response_code(401);
    echo 'Użytkownik niezalogowany!';
    exit();
}

//Validate if post id exist
if (!isset($_POST['id']) || !is_numeric($_POST['id']) || empty($_POST['id'])) {
    http_response_code(400);
    echo "Id ogłoszenia jest wymagane";
    exit();
}

//Database require etc.
require_once($_SERVER["DOCUMENT_ROOT"] . '/config/database.php');

//Check if classfield exist in database
$results = $classfields = $database->select(
    "classfield",
    [
        "[>]user" => ["user_id" => "userid"]

    ],
    [
        "classfield.id", "user.userid","classfield.expire_at"
    ],
    [
        "classfield.id" => $_POST['id']
    ]
);


//Check if classfield exist
if (count($results) == 0) {
    http_response_code(400);
    echo "Ogłoszenie o takim id nie istnieje";
    exit();
}

//Check if deleter is author 
if ($results[0]["userid"] != $_SESSION["userdata"]["userid"]) {
    http_response_code(400);
    echo "Nie masz uprawnień aby wykonać tę operację.";
    exit();
}

$end_date = strtotime($results[0]["expire_at"]);
$current_date = time();

$datediff = $end_date - $current_date;
$difference =  round($datediff / (60 * 60 * 24));



if(!($difference <= 14)){
    http_response_code(400);
    echo 'Nie można odświeżyć ogłoszenia. Ogłoszenie można odświeżyć dopiero <b>14 dni</b> przed terminem wygaśnięcia.';
    exit();
}

//Refresh
$now_datetime = new DateTime();
$new_date = date_add($now_datetime, date_interval_create_from_date_string('30 days'));


$database->update("classfield", ["expire_at" => $new_date->format('Y-m-d')], ["id" => $_POST['id']]);





?>