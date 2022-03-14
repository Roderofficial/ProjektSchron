<?php
if(!isset($_GET["domain"])){
    header("Location: /");
    exit();
}

try {
    $subdomain = join('.', explode('.', $_GET["domain"], -2));
} catch (Exception $e) {
    header("Location: /");
    exit();
}
if(empty($subdomain)){
    header("Location: /");
    exit();
}

require_once($_SERVER["DOCUMENT_ROOT"] . '/config/database.php');
$userid = $database->select("user", "userid", ["subdomain" => $subdomain]);
if(empty($userid)){
    header("Location: /");
    exit();
}else{
    header("Location: /profile/".$userid[0]);
    exit();  
}
?>