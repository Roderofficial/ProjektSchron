<?php
require_once($_SERVER['DOCUMENT_ROOT']. '/assets/libs/medoo/Medoo.php');
// Using Medoo namespace.
$db_login = "root";
$db_password = "Radekp123!!!";
$db_host = "167.86.120.16";
$db_database = "schron";
use Medoo\Medoo;

$database = new Medoo([
    // [required]
    'type' => 'mysql',
    'host' => '167.86.120.16',
    'database' => 'schron',
    'username' => 'root',
    'password' => 'Radekp123!!!',
    'charset' => 'utf8',
 

    'option' => [
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ],

]);
