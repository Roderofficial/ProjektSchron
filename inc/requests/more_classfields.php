<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/database.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/config/config.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/inc/functions/sfm.php");

if(!isset($_GET["lat"]) || !is_numeric($_GET["lat"])){
    http_response_code(400);
    exit();
}
if (!isset($_GET["lon"]) || !is_numeric($_GET["lon"])) {
    http_response_code(400);
    exit();
}
$distance_raw = "distanceshow(`geo_lat`, `geo_long`, ". $_GET["lat"] . ", " . $_GET["lon"] . ")";
use Medoo\Medoo;

$classfields = $database->select(
    "classfield",
    [
        "[>]user" => ["user_id" => "userid"],
        "[>]classfield_photo" => [
            "id" => "classfield_id", "AND" => [
                "main=" => 1
            ]
        ]

    ],
    [
        "classfield.id", "classfield.title", "classfield.created_at", "classfield.location", "classfield.cost", "classfield_photo.photo_hash",
        "userdata" => ["user.username", "user.userid"]
    ],
    [
        'LIMIT' => 12,
        'ORDER' => Medoo::raw($distance_raw),
        "classfield.enabled" => 1
    ]
);

foreach ($classfields as $key => $value) {

    $classfields[$key]['cost'] = cost_formatter($value['cost']);
    $classfields[$key]['link'] = '/post/' . clean($value['title']) . "-" . $value['id'];
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($classfields);
?>