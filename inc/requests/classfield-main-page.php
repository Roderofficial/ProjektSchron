<?php
require_once($_SERVER['DOCUMENT_ROOT']."/config/database.php");
require_once($_SERVER['DOCUMENT_ROOT']."/config/config.php");
function clean($string)
{
    $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

    return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}

$classfields = $database->select("classfield",
 ["[>]user" => ["user_id" => "userid"],
  "[>]classfield_photo" => ["id" => "classfield_id", "AND" => [
                "main=" => 1
            ]
        ]

 ],
 ["classfield.id", "classfield.title", "classfield.created_at", "classfield.location", "classfield_photo.photo_hash",
 "userdata" => ["user.username", "user.userid"]
 ],
[
    'LIMIT' => 19
]);

foreach($classfields as $key => $value){
    $classfields[$key]['link'] = '/post/'.clean($value['title'])."-".$value['id'];
}

echo json_encode($classfields);
?>