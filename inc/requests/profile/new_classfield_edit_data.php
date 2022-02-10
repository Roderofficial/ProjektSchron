<?php
    @session_start();
    require_once($_SERVER["DOCUMENT_ROOT"].'/inc/functions/secure.php');
    require_once($_SERVER["DOCUMENT_ROOT"].'/config/database.php');
    require_once($_SERVER["DOCUMENT_ROOT"].'/config/config.php');
    require_login();

    if(!isset($_GET["id"]) || !is_numeric($_GET["id"])){
        http_response_code(400);
        exit();
    }

    header('Content-Type: application/json; charset=utf-8');

    $data = $database->select(
        "classfield",
        ["[>]user" => ["user_id" => "userid"], "[>]classfield_category" => ["classfield_categoryid" => "ctid"]],
        ['classfield.title', 'classfield.description', 'classfield.cost', 'classfield.osm_id', 'classfield.location' ,'classfield.phone','classfield.email', 'classfield.classfield_categoryid'],
        [
            'classfield.id' => htmlspecialchars($_GET["id"]),
            'classfield.user_id' => $_SESSION["userdata"]["userid"]

        ]
    );
    if ($data == Null) {
        http_response_code(404);
        exit();
    }
    $data = $data[0];

    $photos = $database->select("classfield_photo", "photo_hash",["classfield_id" => $_GET["id"]]);
    
    $data["photos"] = $photos;
    $data["description"] = nl2br($data["description"]);
    echo json_encode($data);


?>