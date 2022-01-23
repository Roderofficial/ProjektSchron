<?php
@session_start();
if(!isset($_SESSION["userdata"]["userid"])){
    http_response_code(400);
    exit();
}

require_once($_SERVER['DOCUMENT_ROOT']."/config/database.php");
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
 ["classfield.id", "classfield.title", "classfield.created_at", "classfield.expire_at", "classfield.location", "classfield.cost","classfield_photo.photo_hash",
],[
    "user.userid" => $_SESSION["userdata"]["userid"]
]
);
foreach($classfields as $key => $value){

    $classfields[$key]['cost'] = cost_formatter($value['cost']);
    $classfields[$key]['link'] = '/post/'.clean($value['title'])."-".$value['id'];
}


echo json_encode($classfields);
