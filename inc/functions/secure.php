<?php

function require_login($redirect =1){
    ob_start();
    @session_start();
    if(!isset($_SESSION["userdata"]["userid"])){
        http_response_code(401);
        if($redirect == 1){
            header("Location: /error/401");
        } else {
            echo "Użytkownik niezalogowany!";
        }
        
        
        exit();
    }

    //Check banned
    require($_SERVER["DOCUMENT_ROOT"].'/config/database.php');
    $banned_count = $database->count("user", ["userid" => $_SESSION["userdata"]["userid"], "banned" => 1]);
    if($banned_count > 0){
        @session_start();
        @session_destroy();

        http_response_code(403);
        if ($redirect == 1) {
            header("Location: /error/403");
        }else{
            echo "Użytkownik zbanowany!";
        }

        exit();
    }

}

?>