<?php
require_once($_SERVER['DOCUMENT_ROOT']. '/assets/libs/medoo/Medoo.php');
// Using Medoo namespace.
use Medoo\Medoo;

$database = new Medoo([
    // [required]
    'type' => 'mysql',
    'host' => '167.86.120.16',
    'database' => 'schron',
    'username' => 'root',
    'password' => '@Maniaczyn123!mysql',
    'charset' => 'utf8',
 

    'option' => [
        PDO::ATTR_CASE => PDO::CASE_NATURAL
    ],

]);
