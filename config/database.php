<?php
require_once($_SERVER['DOCUMENT_ROOT']. '/assets/libs/medoo/Medoo.php');
// Using Medoo namespace.
$db_login = "schron_prod";
$db_password = "g3qpGNHO74HwJFzS";
$db_host = "167.86.120.16";
$db_database = "schron_production";
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
