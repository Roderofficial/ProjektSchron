<?php
//Validate data
if(!isset($_GET['offset']) || !isset($_GET['limit']) || !is_numeric($_GET['offset']) || !isset($_GET['limit'])){
    http_response_code(400);
    exit();
}

//Search validate
if(!isset($_GET['search'])){
    $search = null;
}else{
    $search = htmlspecialchars($_GET['search']);
}

//Query params controler
require_once($_SERVER["DOCUMENT_ROOT"].'/inc/watch/query-params-controler.php');


require_once($_SERVER['DOCUMENT_ROOT']."/config/database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/config/config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/inc/functions/sfm.php");



$classfields = $database->select("classfield",
 ["[>]user" => ["user_id" => "userid"],
  "[>]classfield_photo" => ["id" => "classfield_id", "AND" => [
                "main=" => 1
            ]
        ]

 ],
 ["classfield.id", "classfield.title", "classfield.created_at", "classfield.location", "classfield.cost","classfield_photo.photo_hash",
],[
    'LIMIT' => [$_GET['offset'], $_GET['limit']],
    'ORDER' => [
        "classfield.created_at" => 'DESC'
    ],
    'OR' =>[
        'classfield.title[~]' => $search

    ]
]);
foreach($classfields as $key => $value){

    $classfields[$key]['cost'] = cost_formatter($value['cost']);
    $classfields[$key]['link'] = '/post/'.clean($value['title'])."-".$value['id'];
}

//COUNT ROWS FILTERED
$classfields = $database->select("classfield",
 ["[>]user" => ["user_id" => "userid"],
  "[>]classfield_photo" => ["id" => "classfield_id", "AND" => [
                "main=" => 1
            ]
  ],
    "[>]geo_wojewodztwo" => ["woj_id" => "id"]

 ],
 ["classfield.id", "classfield.title", "classfield.created_at", "classfield.location", "classfield.cost","classfield_photo.photo_hash",
],$query_params);
foreach ($classfields as $key => $value) {

    $classfields[$key]['cost'] = cost_formatter($value['cost']);
    $classfields[$key]['link'] = '/post/' . clean($value['title']) . "-" . $value['id'];
}

//REMOVE FROM QUERY LIMIT AND OFFSET FOR COUNT AND TOTAL
unset($query_params['LIMIT']);


$total = $database->count("classfield", $query_params);
$returndata['total'] = $total;
$returndata['totalNotFiltered'] = $total;

$returndata['rows'] = $classfields;


echo json_encode($returndata);
