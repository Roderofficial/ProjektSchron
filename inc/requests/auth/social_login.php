<!doctype html>
<html lang="pl">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>Logowanie Facebook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>

<body>

    <div class="container d-flex h-100 mb-3 mt-3">
        <div class="row justify-content-center align-self-center" style="margin:auto;">
            <div class="spinner-border justify-content-center" style="width: 3rem; height: 3rem;" role="status">
            </div>
            <h3>Logowanie za pomocą Facebook</h3>
        </div>
    </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>

<?php
// Include Hybridauth's basic autoloader
require $_SERVER['DOCUMENT_ROOT'] . '/assets/libs/socialauth/autoload.php';
require_once($_SERVER["DOCUMENT_ROOT"] . '/config/database.php');
$config = [
    // Location where to redirect users once they authenticate with Facebook
    // For this example we choose to come back to this same script
    'callback' => 'https://getpet.pl/inc/requests/auth/social_login.php',

    // Facebook application credentials
    'keys' => [
        'id' => '1010413889820967', // Required: your Facebook application id
        'secret' => '03db1ab080a1e659d31f00bbe5680ba7'  // Required: your Facebook application secret 
    ]
];

try {
    // Instantiate Facebook's adapter directly
    $adapter = new Hybridauth\Provider\Facebook($config);

    // Attempt to authenticate the user with Facebook
    $adapter->authenticate();

    // Returns a boolean of whether the user is connected with Facebook
    $isConnected = $adapter->isConnected();
    //Successfull login into facebook
    if ($isConnected == True) {
        $userProfile = $adapter->getUserProfile();
        //var_dump($userProfile->emailVerified);

        //Check if user has verified email
        if (empty($userProfile->emailVerified)) {
            http_response_code(403);
            echo 'Musisz posiadać zweryfikowany email na portalu społecznościowym aby się zalogować.';
            exit();
        }


        // //Validate email
        $validate_has_user = $database->has("user", ["email" => $userProfile->emailVerified]);


        //Login when user exist in database
        if ($validate_has_user) {
            $results = $database->select("user", ["userid", "username", "email", "banned", "password", "avatar_hash"], ["email" => $userProfile->emailVerified]);

            //Check password member when exist
            if ($results[0]['banned'] == 1) {
                http_response_code(403);
                exit();
            }
            @session_start();
            $_SESSION['userdata']['userid'] = $results[0]['userid'];
            $_SESSION['userdata']['username'] = $results[0]['username'];
            $_SESSION['userdata']['avatar'] = $results[0]['avatar_hash'];
            $_SESSION['login'] = True;
        } else {
            //Register user
            $database->insert("user", [
                "username" => $userProfile->displayName,
                "email" => strtolower($userProfile->emailVerified),
                "provider" => "facebook"
            ]);


            //LOGIN
            $results = $database->select("user", "*", ["email" => strtolower($userProfile->emailVerified)]);
            @session_start();
            $_SESSION['userdata']['userid'] = $results[0]['userid'];
            $_SESSION['userdata']['username'] = $results[0]['username'];
            $_SESSION['userdata']['avatar'] = $results[0]['avatar_hash'];
            $_SESSION['login'] = True;
        }



        // Disconnect the adapter (log out)
        $adapter->disconnect();

        echo "<script>self.close();</script>";
    }
} catch (\Exception $e) {
    error_log($e->getMessage());
}

?>