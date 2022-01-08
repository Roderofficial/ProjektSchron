<?php
//Check if user is already logged
@session_start();
if(!isset($_SESSION['login']) || $_SESSION['login'] != 1){
    http_response_code(401);
    exit();
}

require_once($_SERVER["DOCUMENT_ROOT"].'/config/database.php');
$data = $database->select("user",[
    "[>]user_roles" => ["user_roleID" => "id"]
],[
    "user.userid","user.username","user.email","user.date_created","user.verified","user.about","user.banned","user.phone_public","user.email_public","user.website_public","user_roles.role_name","user_roles.role_icon"
],
["user.userid" => $_SESSION['userdata']['userid']]);

$data = $data[0];
?>