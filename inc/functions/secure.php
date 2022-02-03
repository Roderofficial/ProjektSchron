<?php

function require_login(){
    ob_start();
    @session_start();
    if(!isset($_SESSION["userdata"]["userid"])){
        http_response_code(401);
        header("Location: /error/401");
        
        exit();
    }
}

?>