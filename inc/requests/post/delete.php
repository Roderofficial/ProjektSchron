<?php
//Validate if user is logged in
require_once($_SERVER["DOCUMENT_ROOT"] . '/inc/functions/secure.php');
@session_start();
require_login(0);

//Validate if post id exist
if(!isset($_POST['id']) || !is_numeric($_POST['id']) || empty($_POST['id'])){
    http_response_code(400);
    echo "Id ogłoszenia jest wymagane";
    exit();
}

//Database require etc.
require($_SERVER["DOCUMENT_ROOT"].'/config/database.php');

//Check if classfield exist in database
$results = $classfields = $database->select(
    "classfield",
    [
        "[>]user" => ["user_id" => "userid"],
        "[>]classfield_photo" => [
            "id" => "classfield_id", "AND" => [
                "main=" => 1
            ]
        ]

    ],
    [
        "classfield.id", "user.userid"
    ],
    [
        "classfield.id" => $_POST['id']
    ]
);
 

//Check if classfield exist
if(count($results) == 0){
    http_response_code(400);
    echo "Ogłoszenie o takim id nie istnieje";
    exit();
}

//Check if deleter is author 
if($results[0]["userid"] != $_SESSION["userdata"]["userid"]){
    http_response_code(400);
    echo "Nie masz uprawnień aby wykonać tę operację.";
    exit();
}

$database->delete("classfield", ["classfield.id" =>  $_POST['id']]);



?>