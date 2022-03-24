<?php
if(!isset($_GET["id"]) || !is_numeric($_GET["id"])){
    echo'id wymagane';
    http_response_code(400);
    exit();
  
}

require_once($_SERVER["DOCUMENT_ROOT"] . '/config/database.php');
$points = $database->select('classfield_has_detail', 'detail_id', ["classfield_id" => $_GET["id"]]);
header('Content-Type: application/json; charset=utf-8');

echo json_encode($points);


?>