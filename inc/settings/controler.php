<?php
//Check if user is already logged
require_once($_SERVER["DOCUMENT_ROOT"] . '/inc/functions/secure.php');
@session_start();
require_login();

require($_SERVER["DOCUMENT_ROOT"].'/config/database.php');
$data = $database->select("user",[
    "[>]user_roles" => ["user_roleID" => "id"]
],[
    "user.userid", "user.subdomain","user.username","user.email","user.date_created","user.verified","user.about","user.banned","user.phone_public","user.email_public", "user.location_public","user_roles.role_name","user_roles.role_icon"
],
["user.userid" => $_SESSION['userdata']['userid']]);

$data = $data[0];
?>