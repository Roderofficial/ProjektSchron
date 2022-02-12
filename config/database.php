<?php
require_once($_SERVER['DOCUMENT_ROOT']. '/assets/libs/medoo/Medoo.php');
// Using Medoo namespace.
//PROD
$db_login = "schron_prod";
$db_password = "g3qpGNHO74HwJFzS";
$db_host = "10.8.0.1";
$db_database = "schron_production";


// //TESTS
// $db_login = "root";
// $db_password = "Radekp123!!!";
// $db_host = "10.8.0.1";
// $db_database = "schron";
// use Medoo\Medoo;

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
