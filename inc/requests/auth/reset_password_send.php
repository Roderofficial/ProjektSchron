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


//Medoo check if email exist in database
require_once($_SERVER['DOCUMENT_ROOT']. '/config/database.php');


?>