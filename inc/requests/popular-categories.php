<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/config/database.php');

use Medoo\Medoo;

$database->debug()->select("classfield", ["classfield_categoryid", Medoo::raw("count(*)")])

?>