<?php
function require_login(){
    @session_start();
    if(!isset($_SESSION["userdata"]["userid"])){
        http_response_code(401);
        exit();
    }
}

?>