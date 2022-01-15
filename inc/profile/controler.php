<?php
if (!isset($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])){
    http_response_code(404);
    exit();
}

require_once($_SERVER["DOCUMENT_ROOT"].'/config/database.php');
require_once($_SERVER["DOCUMENT_ROOT"] .'/inc/functions/sfm.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/config/config.php');

$data = $database->select("user",
["[>]user_roles" => ["user_roleID" => "id"]],
["user.userid", "user.username", "user.date_created", "user.avatar_hash", "user.banner_hash", "user.verified", "user.about", "user.banned", "user.phone_public", "user.email_public", "user.user_roleID", "user_roles.role_name", "user_roles.role_icon"], 
[
    'user.userid' => htmlspecialchars($_GET['id'])
    
]);

if(empty($data)){
    http_response_code(404);
    exit();
}

$data = $data[0];

//Ban detect
if ($data['banned'] == 1) {
    http_response_code(403);
    exit();
}

//verified badge
if ($data['verified'] == 1) {
    $data['verified_badge'] =  verified_badge();
} else {
    $data['verified_badge'] = null;
}

?>