   <?php

   @session_start();
   @session_destroy();
    $config = [
        // Location where to redirect users once they authenticate with a provider
        'callback' => 'http://localhost/inc/requests/auth/social_login.php',

        // Providers specifics
        'providers' => [
            'Facebook' => [
                'enabled' => true,     // Optional: indicates whether to enable or disable Twitter adapter. Defaults to false
                'keys' => [
                    'id' => '1010413889820967', // Required: your Twitter consumer key
                    'secret' => '03db1ab080a1e659d31f00bbe5680ba7'  // Required: your Twitter consumer secret
                ]
            ],
            'Google' => ['enabled' => true,
             'keys' => ['id' => '416110151599-6nh6gfcj7uo1duvrphcgprnngektsvk1.apps.googleusercontent.com', 
             'secret' => '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'],
                'scope'    => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
                'authorize_url_parameters' => [
                    'approval_prompt' => 'force', // to pass only when you need to acquire a new refresh token.
                    'access_type' => 'offline'
                ]
            
            ],
        ]
    ];

    // Include Hybridauth's basic autoloader
    require $_SERVER['DOCUMENT_ROOT'] . '/assets/libs/socialauth/autoload.php';
    

    // Import Hybridauth's namespace

    // And so on
    try {
        // Feed configuration array to Hybridauth
        $hybridauth = new Hybridauth\Hybridauth($config);

        // Then we can proceed and sign in with Twitter as an example. If you want to use a diffirent provider, 
        // simply replace 'Twitter' with 'Google' or 'Facebook'.

        // Attempt to authenticate users with a provider by name
        // This call will basically do one of 3 things...
        // 1) Redirect away (with exit) to show an authentication screen for a provider (e.g. Facebook's OAuth confirmation page)
        // 2) Finalize an incoming authentication and store access data in a session
        // 3) Confirm a session exists and do nothing
        $adapter = $hybridauth->authenticate('Facebook');

        // Returns a boolean of whether the user is connected with Twitter
        $isConnected = $adapter->isConnected();

        // Retrieve the user's profile
        $userProfile = $adapter->getUserProfile();

        // Inspect profile's public attributes
        var_dump($userProfile);

        // Disconnect the adapter (log out)
        $adapter->disconnect();
    } catch (\Exception $e) {
        echo "Ooophs, we got an error: " . $e->getMessage();
        echo " <br />Error code: " . $e->getCode();
    }

    ?>
