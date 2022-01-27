<?php
@session_start();
if (!isset($_SESSION['userdata']['userid'])) {
    http_response_code(401);
    echo 'Użytkownik niezalogowany!';
    exit();
}

//Validate if post id exist
if (!isset($_POST['id']) || !is_numeric($_POST['id']) || empty($_POST['id'])) {
    http_response_code(400);
    echo "Id ogłoszenia jest wymagane";
    exit();
}

//Database require etc.
require_once($_SERVER["DOCUMENT_ROOT"] . '/config/database.php');

//Check if classfield exist in database
$results = $classfields = $database->select(
    "classfield",
    [
        "[>]user" => ["user_id" => "userid"]

    ],
    [
        "classfield.id", "user.userid", "classfield.enabled"
    ],
    [
        "classfield.id" => $_POST['id']
    ]
);


//Check if classfield exist
if (count($results) == 0) {
    http_response_code(400);
    echo "Ogłoszenie o takim id nie istnieje";
    exit();
}

//Check if deleter is author 
if ($results[0]["userid"] != $_SESSION["userdata"]["userid"]) {
    http_response_code(403);
    echo "Nie masz uprawnień aby wykonać tę operację.";
    exit();
}

//Check if disabled
if (intval($results[0]["enabled"]) == 0) {
    http_response_code(403);
    echo "To ogłoszenie jest już archiwalne.";
    exit();
}

$now_datetime = new DateTime();
$now_datetime = $now_datetime->format('Y-m-d');

$database->update("classfield", ["enabled" => 0, "expire_at" => $now_datetime], ["id" => $_POST['id']]);

?>