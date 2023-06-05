<?php
//Rewrtie this file with your own database credentials
//Change the name of this file to database.php
require_once($_SERVER['DOCUMENT_ROOT']. '/assets/libs/medoo/Medoo.php');
// Using Medoo namespace.
//PROD
$db_login = "";
$db_password = "";
$db_host = "";
$db_database = "";


use Medoo\Medoo;

$database = new Medoo([
    // [required]
    'type' => 'mysql',
    'host' => $db_host,
    'database' => $db_database,
    'username' => $db_login,
    'password' => $db_password,
    'charset' => 'utf8',
 
    'option' => [
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ],

]);
