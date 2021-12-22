<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/inc/functions/sfm.php");
#validate get data
function generate_images($data){
    $return_data = '';
    foreach($data as $value){
        $return_data .= '<div class="swiper-slide"><img src="/assets/images/test-dogs/'.$value["photo_hash"].'"></div>';
        
    }
    return $return_data;

}
if(!isset($_GET['posttitle']) || empty($_GET['posttitle'])){
    http_response_code(400);
    exit();
}
$tmp = (explode("-", $_GET['posttitle']));
$id = end($tmp);

//Database check
require_once($_SERVER['DOCUMENT_ROOT'].'/config/database.php');
$data = $database->select("classfield", 
["[>]user" => ["user_id" => "userid"], "[>]classfield_category" => ["classfield_categoryid" => "ctid"]],
['classfield.title', 'classfield.description', 'classfield.location', 'classfield.cost', 'classfield.created_at', 'classfield_category.category_title','classfield_category.category_icon', "userdata" => ["user.username", "user.userid","user.avatar_hash"]],
[
    'classfield.id' => htmlspecialchars($id)
]
);
if($data == Null){
    http_response_code(404);
    exit();
}
$data = $data[0];

//Download images
$images = $database->select(
    "classfield_photo",
    ['classfield_photo.photo_hash', 'classfield_photo.main'],
    [
        'classfield_photo.classfield_id' => htmlspecialchars($id)
    ]
);
$data['images'] = generate_images($images);
$data['cost'] = cost_formatter($data['cost']);


?>