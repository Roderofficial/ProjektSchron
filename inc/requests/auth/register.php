<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/config/config.php');
// Validate chapta
if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
    $secret = $grechapta_secret;
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
    $responseData = json_decode($verifyResponse);
    if (!($responseData->success)) { 
        http_response_code(403);
        echo 'Walidacja Rechapta NIE przeszła pomyślnie. Spróbuj ponownie!.';
        exit();
    }
} else {
    http_response_code(400);
    echo 'Brak rechapty!';
    exit();
}
if(!isset($_POST['email']) || empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
    http_response_code(403);
    echo 'Podano niepoprawny adres e-mail';
    exit();
}

if (!isset($_POST['username']) || empty($_POST['username'])) {
    http_response_code(403);
    echo 'Nazwa użytkownika nie może być pusta';
    exit();
}
if(strlen($_POST['username']) < 5 || strlen($_POST['username']) > 32){
    http_response_code(403);
    echo 'Nazwa użytkownika jest zbyt krótka lub za długa.';
    exit();
}

//Password validate
if (strlen($_POST['password']) < 5 || strlen($_POST['password']) > 32) {
    http_response_code(403);
    echo 'Hasło jest wymagane.';
    exit();
}
if (strlen($_POST['password']) < 8 || strlen($_POST['password']) > 255) {
    http_response_code(403);
    echo 'Hasło jest zbyt krótkie lub zbyt długie.';
    exit();
}

//Medoo check if email exist in database
require_once($_SERVER['DOCUMENT_ROOT']. '/config/database.php');

$count = $database->count("user", ["email" => strtolower($_POST['email'])]);
if($count > 0){
    http_response_code(403);
    echo 'Konto o podanym adresie e-mail już istnieje.';
    exit();

}

//insert account into database
$password_hash =password_hash($_POST['password'], PASSWORD_ARGON2ID);
$database->insert("user",[
    "username" => $_POST['username'],
    "email" => strtolower($_POST['email']),
    "password" => $password_hash
]);


//LOGIN
$results = $database->select("user", "*", ["email" => strtolower($_POST['email'])]);
@session_start();
$_SESSION['userdata']['userid'] = $results[0]['userid'];
$_SESSION['userdata']['username'] = $results[0]['username'];
$_SESSION['userdata']['avatar'] = $results[0]['avatar_hash'];
$_SESSION['login'] = True;







?>