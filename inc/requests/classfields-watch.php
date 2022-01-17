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



$classfields = $results;
foreach($classfields as $key => $value){

    $classfields[$key]['cost'] = cost_formatter($value['cost']);
    $classfields[$key]['link'] = '/post/'.clean($value['title'])."-".$value['id'];
}



$returndata['total'] = $count_filtered[0]["COUNT(classfield.id)"];
$returndata['totalNotFiltered'] = $total_count[0]["COUNT(classfield.id)"];

$returndata['rows'] = $classfields;


echo json_encode($returndata);
