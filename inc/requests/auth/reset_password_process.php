<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/config/config.php');
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
if(!isset($_POST["token"]) || !isset($_POST["email"]) || !isset($_POST["password1"]) || !isset($_POST["password2"])){
    http_response_code(400);
    exit();
}

if($_POST["password1"]  != $_POST["password2"]){
    http_response_code(400);
    echo "Hasła nie są takie same";
    exit();
}

if (strlen($_POST['password1']) < 8 || strlen($_POST['password1']) > 255) {
    http_response_code(403);
    echo 'Hasło jest zbyt krótkie lub zbyt długie.';
    exit();
}

//Database import
require_once($_SERVER["DOCUMENT_ROOT"].'/config/database.php');
use Medoo\Medoo;

//Check token in database
$token_info = $database->select(
    "user",
    ["[>]password_recovery" => ["userid" => "user_id"]],
    ["user.username", "user.userid"],
    ["password_recovery.token" => $_POST["token"], "user.email" => $_POST["email"], "password_recovery.expire_date[>=]" => Medoo::raw('NOW()')]
);

//Remove tokens
$database->delete("password_recovery", ["user_id" => $token_info[0]["userid"]]);

//Update password
$password_hash = password_hash($_POST['password1'], PASSWORD_ARGON2ID);
$database->update("user", ["password" => $password_hash], ["userid" => $token_info[0]["userid"]]);
?>