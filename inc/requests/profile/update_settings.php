<?php
@session_start();
var_dump($_POST);
if(!isset($_POST['type']) || empty($_POST['type'])){
    echo 'Kod błędu: US01';
    http_response_code(400);
    exit();
}

//requires
require_once($_SERVER["DOCUMENT_ROOT"].'/config/database.php');


if($_POST["type"] == "displaydata"){

    $email_update = 0;
    $displayname_update = 0;
    //DISPLAYDATA UPDATE
    //Check if post email exist
    if(isset($_POST["email"]) && !empty($_POST["email"])){
        //check if email is valid
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo 'Podano niepoprawny email';
            http_response_code(400);
            exit();
        }
        //check if email is same than old


        //Check if some other has this email
        $email_count = $database->count("user", ["email" => $_POST["email"]]);
        if ($email_count != 0) {
            $old_email = $database->select("user", ["email"], ["email" => $_POST["email"]]);
            if ($old_email == $_POST['email']) {
                echo 'Podany adres email jest już przypisany do innego konta';
                http_response_code(400);
                exit();
            }
        }


        //If email validate successfull
        $email_update = 1;

    }

    //Display name update
    if(isset($_POST["displayname"]) && !empty($_POST["displayname"])){
        //Check displayname length
        if(strlen($_POST['displayname']) < 5 || strlen($_POST['displayname']) > 32){
            echo 'Nazwa użytkownika jest zbyt długa lub krótka';
            http_response_code(400);
            exit();
        }

        $displayname_update = 1;
    }

    //Update data if successfull
    if($email_update == 1){
        $database->update("user",["email" => $_POST["email"]], ["userid" => $_SESSION['userdata']['userid']]);
    }

    if($displayname_update == 1){
        $database->update("user", ["username" => $_POST["displayname"]], ["userid" => $_SESSION['userdata']['userid']]);
        $_SESSION["userdata"]["username"] = $_POST["displayname"];
    }


}
//PASSWORD CHANGE
else if($_POST["type"] == "password"){
    if(!isset($_POST["oldpassword"]) || empty($_POST["oldpassword"]) || !isset($_POST["newpassword1"]) || empty($_POST["newpassword1"]) || !isset($_POST["newpassword2"]) || empty($_POST["newpassword2"])){
        http_response_code(400);
        echo "Wszystkie pola muszą być wypełnione!";
        exit();
    }

    //check is new password is two time same
    if($_POST["newpassword1"] != $_POST["newpassword2"]){
        http_response_code(400);
        echo "Nowe hasło nie jest takie samo w obu polach";
        exit();
    }

    //password requirements
    if (strlen($_POST['newpassword1']) < 8 || strlen($_POST['newpassword1']) > 255) {
        http_response_code(400);
        echo 'Hasło jest zbyt krótkie lub zbyt długie. Minimum 8 znaków.';
        exit();
    }


    //check if old password is valid
    $old_password = $database->select("user",["password"],["userid" => $_SESSION['userdata']['userid']]);
    if(!(password_verify($_POST["oldpassword"], $old_password[0]["password"]))){
        http_response_code(400);
        echo 'Stare hasło nie jest poprawne.';
        exit();
    }

    //update password
    $new_password_hash = password_hash($_POST['newpassword1'], PASSWORD_ARGON2ID);
    $database->update("user", ["password" => $new_password_hash],["userid" => $_SESSION['userdata']['userid']]);
}
//update about user info
elseif ($_POST['type'] == 'details'){
    //Validate phone
    $regex_phone = "/(?:(?:(?:(?:\+|00)\d{2})?[ -]?(?:(?:\(0?\d{2}\))|(?:0?\d{2})))?[ -]?(?:\d{3}[- ]?\d{2}[- ]?\d{2}|\d{2}[- ]?\d{2}[- ]?\d{3}|\d{7})|(?:(?:(?:\+|00)\d{2})?[ -]?\d{3}[ -]?\d{3}[ -]?\d{3}))/";
    if(isset($_POST["phone"])){
        if(!empty($_POST["phone"]) && !preg_match('/(?<!\w)(\(?(\+|00)?48\)?)?[ -]?\d{3}[ -]?\d{3}[ -]?\d{3}(?!\w)/', $_POST['phone'])){
            //phone was invalid and not empty
            http_response_code(400);
            echo 'Podano niepoprawny numer telefonu!';
            exit();
        }
        $valid['phone'] =1;

    }
}



?>