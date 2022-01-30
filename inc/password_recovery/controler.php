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

$token_data = $database->select("user", "user.displayname", ["password_recovery.token" => $_GET["token"], "user.email" => $_GET["email"]])

?>