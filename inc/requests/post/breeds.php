<?php
if(!isset($_GET["id"]) || !is_numeric($_GET["id"])){
    http_response_code(400);
    echo 'id wymagane';
    exit();
}

require_once($_SERVER["DOCUMENT_ROOT"].'/config/database.php');
$points = $database->select('category_breed',[
    'category_breed.id','category_breed.text'
],
[
        'category_breed.category_id' => $_GET["id"]
]);

header('Content-Type: application/json; charset=utf-8');

echo json_encode($points);
?>