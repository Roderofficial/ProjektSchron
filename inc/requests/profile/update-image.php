<?php
@session_start();
if(!isset($_SESSION['login']) || $_SESSION['login'] != 1){
    http_response_code(400);
    exit();
}
if(!isset($_FILES["file"]["name"])){
    http_response_code(400);
    exit();
}
if(!isset($_POST["type"])){
    http_response_code(400);
    exit();
}

require_once($_SERVER['DOCUMENT_ROOT'] . '/config/database.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/inc/functions/sfm.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/config/config.php');



switch ($_POST["type"]){
    case "background":
        $location_image = $banner_location;
        $update_column = "banner_hash";
        break;

    case "avatar":
        $location_image = $avatar_locations;
        $update_column = "avatar_hash";
        break;

    default:
        http_response_code(400);
        exit();
        break;
}



$allowedExts = array("gif", "jpeg", "jpg", "png");
$tmp_end = explode(".", $_FILES["file"]["name"]);
$extension = end($tmp_end);
if (!((($_FILES["file"]["type"] == "image/gif")
        || ($_FILES["file"]["type"] == "image/jpeg")
        || ($_FILES["file"]["type"] == "image/jpg")
        || ($_FILES["file"]["type"] == "image/png"))
    && ($_FILES["file"]["size"] < 5000000)
    && in_array($extension, $allowedExts)
)){
    http_response_code(406);
    echo 'Obraz nie spełnia wymagań!';
    exit();
}

$newfilename = generateRandomString(30).'.'.$extension;

if ((!move_uploaded_file($_FILES['file']['tmp_name'], $_SERVER['DOCUMENT_ROOT'].$location_image.$newfilename))) {
    http_response_code(410);
    exit();
} 






$data = $database->update("user", [
        $update_column => $newfilename
],
    [
        "userid" => $_SESSION['userdata']['userid']
    ]
);


echo $location_image . $newfilename;
?>