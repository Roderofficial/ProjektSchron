<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/inc/functions/secure.php');
@session_start();
require_login();

//State mode
if (!isset($_GET["state"]) || !in_array(intval($_GET["state"]), array(1,0))) {
    http_response_code(400);
    exit();
}
//Select sort
if (!isset($_GET["sortid"]) || !in_array(intval($_GET["sortid"]), array(0,1,2,3))) {
    $_GET["sortid"] = 0;
}
$order_by_mode = ["expire_at", "expire_at", "created_at", "create_at"];
$order_by_type = ["DESC", "ASC", "DESC", "ASC"];


//Query search
if (!isset($_GET["q"])) {
    $q = "";
}else{
    $q = $_GET["q"];
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
    "OR" =>[
            "title[~]" => $q,
            "id[~]" => $q
    ],
    "ORDER" => [
            $order_by_mode[$_GET["sortid"]] => $order_by_type[$_GET["sortid"]]
    ]
    

]
);
foreach($classfields as $key => $value){

    $classfields[$key]['cost'] = cost_formatter($value['cost']);
    $classfields[$key]['link'] = '/post/'.clean($value['title'])."-".$value['id'];
}


echo json_encode($classfields);
