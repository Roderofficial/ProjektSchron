<?php
//Phpmailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require $_SERVER["DOCUMENT_ROOT"] . '/assets/libs/PHPMailer/src/Exception.php';
require $_SERVER["DOCUMENT_ROOT"] . '/assets/libs/PHPMailer/src/PHPMailer.php';
require $_SERVER["DOCUMENT_ROOT"] . '/assets/libs/PHPMailer/src/SMTP.php';

//Other require
require_once($_SERVER['DOCUMENT_ROOT'].'/config/config.php');
require_once($_SERVER["DOCUMENT_ROOT"].'/inc/functions/sfm.php');
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
require_once($_SERVER['DOCUMENT_ROOT'].'/inc/password_recovery/reset_mail_template.php');
use Medoo\Medoo;


//Find user in database
$accounts = $database->select("user", ["userid","username"], ["email" => $_POST['email']]);

if(!empty($accounts)){

    $recovery_token = generateRandomString(150);
    $sender_ip = get_client_ip();

    //Try delete old password recoveries
    $database->delete("password_recovery",["user_id" => $accounts[0]["userid"]]);


    //insert new record
    $database->insert("password_recovery", ["token" => $recovery_token, "user_id" => $accounts[0]["userid"], "reset_ip" => $sender_ip, "expire_date" => Medoo::raw("date_add(now(),interval 1 day)")]);


    $reset_password_link = "https://getpet.pl/resetuj-haslo?token=".$recovery_token."&email=".$_POST['email'];

    $vars_to_replace = array(
        '%displayname%'       => $accounts[0]["username"],
        '%reset_link%'        => $reset_password_link,
        '%sender_ip%' => $sender_ip
    );

    $password_reset_mail_template = strtr($password_reset_mail_template, $vars_to_replace);
    


    //PHPMAILER
    $mail = new PHPMailer(true);

    

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $config["mail"]["host"];                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $config["mail"]["username"];                     //SMTP username
        $mail->Password   = $config["mail"]["password"];                               //SMTP password
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->SMTPSecure = false;
        $mail->SMTPAutoTLS = false;
        $mail->CharSet = 'UTF-8';
        $mail->Hostname = 'localhost';
        $mail->XMailer    = ''; 

        //Recipients
        $mail->setFrom($config["mail"]["username"], 'GetPet.pl');
        $mail->addAddress($_POST['email']);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = "Reset hasła do konta ". $accounts[0]["username"]." w serwisie GetPet.pl";
        $mail->Body    = $password_reset_mail_template;

        $mail->send();
    } catch (Exception $e) {
        error_log($e);
        error_log($mail->ErrorInfo);
    }




}


?>