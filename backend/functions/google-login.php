<?php

    require __DIR__ . "/../../vendor/autoload.php";
    
    function generateGoogleUrl($clientId, $clientSecret, $redirectUri){

        $client = new Google\Client;
    
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
    
        $client->addScope("email");
        $client->addScope("profile");

        $client->addScope("email");
        $client->addScope("profile");
        
        return $client->createAuthUrl();
    }

    function getGoogleUserInfo($code, $clientId, $clientSecret, $redirectUri){

        $client = new Google\Client;

        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);

        // check if code is valid  
        if(!isset($code)){
            exit("Login Failed");
        }

        // get access token
        $token = $client->fetchAccessTokenWithAuthCode($code);

        // check if access token is available 
        if (!isset($token["access_token"])) {
            exit("Access token is not defined. Login Failed.");
        }

        // check access token
        $client->setAccessToken($token["access_token"]);
        $oauth = new Google\Service\Oauth2($client);
        return $oauth->userinfo->get();

    }

    function initializeGoogleClient($clientId, $clientSecret, $redirectUri): Google\Client {
        global $clientId, $clientSecret, $redirectUri;
        
        $client = new Google\Client;
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        
        return $client;
    }

    function getAccessToken(Google\Client $client): array{
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        
        if (!isset($token['access_token'])) {
            throw new RuntimeException('Access token is not defined. Login Failed.');
        }
        
        $client->setAccessToken($token['access_token']);
        return $token;
    }

?>