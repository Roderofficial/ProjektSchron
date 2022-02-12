<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/config/database.php');

$categories = $database->select("classfield_category", ["ctid(id)", "category_title(text)", "category_icon(icon)", "color"], 
["ORDER" => [
    "orderby" => "DESC"
]]
);
header('Content-Type: application/json; charset=utf-8');
echo json_encode($categories);


?>