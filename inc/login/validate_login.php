<?php

require_once $_SERVER["DOCUMENT_ROOT"]. '/assets/libs/Formr/class.formr.php';
$form = new Formr\Formr('bootstrap5');
$data = $form->validate('password, email');

//VALIDATE EMAIL AND PASSWORD IF EXIST
if(empty($data['email']) || empty($data['password']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
    http_response_code(400);
    exit();
}

//Check email in database
require_once($_SERVER["DOCUMENT_ROOT"]."/config/database.php");

$results = $database->select("user", ["userid","username", "email", "password", "avatar_hash"],
 [
        "email" => $data['email'],
    ],
    [
        "LIMIT" => [0, 1]
    ]);

//Check if any result exist
if(empty($results)){
    http_response_code(404);
    exit();
}

//Check password member when exist
if(password_verify($data['password'], $results[0]['password'])){
    @session_start();
    $_SESSION['userdata']['userid'] = $results[0]['userid'];
    $_SESSION['userdata']['username'] = $results[0]['username'];
    $_SESSION['userdata']['avatar'] = $results[0]['avatar_hash'];
    $_SESSION['login'] = True;


}else{
    http_response_code(404);
    exit();
}

var_dump($_SESSION);




?>