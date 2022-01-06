<?php
if(!isset($_POST['post_id']) || empty($_POST['post_id'])){
    http_response_code(400);
    exit();
}

require_once($_SERVER["DOCUMENT_ROOT"].'/config/database.php');
$data = $database->select("classfield", ["email", "phone"], ["id" => $_POST["post_id"]]);
header('Content-Type: application/json; charset=utf-8');
echo json_encode($data[0]);


?>