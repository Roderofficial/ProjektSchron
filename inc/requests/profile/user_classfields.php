<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/inc/functions/secure.php');
@session_start();
require_login();

if (!isset($_GET["state"]) || !in_array(intval($_GET["state"]), array(1,0))) {
    http_response_code(400);
    exit();
}
$state  = $_GET["state"];

require($_SERVER['DOCUMENT_ROOT']."/config/database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/config/config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/inc/functions/sfm.php");

header('Content-Type: application/json; charset=utf-8');

$classfields = $database->select("classfield",
 ["[>]user" => ["user_id" => "userid"],
  "[>]classfield_photo" => ["id" => "classfield_id", "AND" => [
                "main=" => 1
            ]
        ]

 ],
 ["classfield.id", "classfield.title", "classfield.created_at", "classfield.expire_at", "classfield.enabled", "classfield.location", "classfield.cost","classfield_photo.photo_hash",
],[
    "AND" =>[
        "user.userid" => $_SESSION["userdata"]["userid"],
        "classfield.enabled" => intval($state)
    ],
    "ORDER" => [
        "created_at" => "DESC"
    ]
    

]
);
foreach($classfields as $key => $value){

    $classfields[$key]['cost'] = cost_formatter($value['cost']);
    $classfields[$key]['link'] = '/post/'.clean($value['title'])."-".$value['id'];
}


echo json_encode($classfields);
