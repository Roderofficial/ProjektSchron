<?php
if(!isset($_GET["token"])){
    http_response_code(400);
    echo 'Token jest wymagany!';
    exit();

}

if(!isset($_GET["email"])){
    http_response_code(400);
    echo 'E-Mail jest wymagany!';
    exit();
}


require_once($_SERVER["DOCUMENT_ROOT"].'/config/database.php');

use Medoo\Medoo;

$token_data = $database->select("user", ["[>]password_recovery" => ["userid" => "user_id"]], ["user.username"], 
["password_recovery.token" => $_GET["token"], "user.email" => $_GET["email"], "password_recovery.expire_date[>=]" => Medoo::raw('NOW()')]);

//if not found
if(empty($token_data)){
    http_response_code(404);
    exit();
}


?>