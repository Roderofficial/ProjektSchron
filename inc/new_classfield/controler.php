<?php
@session_start();
require_once($_SERVER["DOCUMENT_ROOT"].'/inc/functions/secure.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/config/database.php');
require_login(); 

$placeholderdata = $database->select("user", ["location_public", "email_public", "phone_public"], ["userid" => $_SESSION["userdata"]["userid"]]);
$placeholder = $placeholderdata[0];

?>