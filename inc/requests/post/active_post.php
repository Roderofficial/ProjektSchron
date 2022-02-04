<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/inc/functions/secure.php');
@session_start();
require_login(0);

//Validate if post id exist
if (!isset($_POST['id']) || !is_numeric($_POST['id']) || empty($_POST['id'])) {
    http_response_code(400);
    echo "Id ogłoszenia jest wymagane";
    exit();
}

//Database require etc.
require($_SERVER["DOCUMENT_ROOT"] . '/config/database.php');

use Medoo\Medoo;

//Check if classfield exist in database
$results = $classfields = $database->select(
    "classfield",
    [
        "[>]user" => ["user_id" => "userid"]

    ],
    [
        "classfield.id", "user.userid", "classfield.enabled"
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
    http_response_code(403);
    echo "Nie masz uprawnień aby wykonać tę operację.";
    exit();
}

//Check if disabled
if (intval($results[0]["enabled"]) == 1) {
    http_response_code(403);
    echo "To ogłoszenie jest już aktywne.";
    exit();
}

$now_datetime = new DateTime();
$new_date = date_add($now_datetime, date_interval_create_from_date_string('30 days'));

$database->update("classfield", ["enabled" => 1, "expire_at" => $now_datetime->format('Y-m-d'), "updated_at" => Medoo::raw("NOW()")], ["id" => $_POST['id']]);
