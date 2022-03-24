<?php
if(!isset($_GET["id"]) || !is_numeric($_GET["id"])){
    http_response_code(400);
    echo 'id wymagane';
    exit();
}

require_once($_SERVER["DOCUMENT_ROOT"].'/config/database.php');
$points = $database->select('category_has_detail',[
    "[>]classfield_detail_points" => ["classfield_detail_points_id" => "id"]
],[
    'classfield_detail_points.id','classfield_detail_points.text','classfield_detail_points.background'
],
[
        'category_has_detail.category_id' => $_GET["id"]
]);

header('Content-Type: application/json; charset=utf-8');

echo json_encode($points);
?>