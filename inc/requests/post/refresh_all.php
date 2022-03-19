<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/inc/functions/secure.php');
@session_start();
require_login(0);

use Medoo\Medoo;
//Database require etc.
require($_SERVER["DOCUMENT_ROOT"] . '/config/database.php');

//Check if classfield exist in database
$count = $classfields = $database->count(
    "classfield",
    [
        "expire_at[<]" => Medoo::raw("date_add(now(),interval 30 day)"),
        "enabled" => 1,
        "user_id" => $_SESSION["userdata"]["userid"]
    ]
);

echo $count;

$database->update("classfield",
[
    "expire_at" => Medoo::raw("date_add(now(),interval 90 day)"),
],[
    "expire_at[<]" => Medoo::raw("date_add(now(),interval 30 day)"),
    "enabled" => 1,
    "user_id" => $_SESSION["userdata"]["userid"]
]
);


