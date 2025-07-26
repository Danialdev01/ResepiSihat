<?php

    session_start();

    include '../config/connect.php';
    include '../backend/functions/system.php';
    include '../backend/functions/csrf-token.php';
    include '../backend/functions/google-login.php';
    include '../backend/models/user.php';
    include '../backend/functions/user.php';
    require __DIR__ . "/../vendor/autoload.php";

    if(empty($_GET['code'])){
        redirectWithAlert("../", "error", "Google Login Error");
    }

    try{

        $client = initializeGoogleClient($clientId, $clientSecret, $redirectUri);
        $token = getAccessToken($client);

        $oauth = new Google\Service\Oauth2($client);
        $userinfo = $oauth->userinfo->get();

        $pwd_gsso = "pwd" . $userinfo->email;

        if (empty($userinfo->email)) {
            redirectWithAlert("../", "error", "Incomplete Data");
            return;
        }

        $userInfo = checkUser($userinfo->email, NULL, $connect);

        if($userInfo['exists'] == true){
            
            // login user
            setUser($userInfo['user']['id_user'], $pwd_gsso , "user", $token_name, $secret_key, $connect);
            setLogginDate($connect, $userInfo['user']['id_user']);
            log_activity_message("../log/user_activity_log", "Login Success");
            header("Location:../user/");
        }
        else{
            // signup new user
            $user = createUser($userinfo->givenName, $userinfo->email, $pwd_gsso, 2, $pwd_gsso, $connect);
            $user = json_decode($user, true);

            if($user['id'] == 200){

                // login newuser
                setUser($user['id_user'], $user['password_user'], "user", $token_name, $secret_key, $connect);
                setLogginDate($connect, $user['id_user']);
                log_activity_message("../log/user_activity_log", "Login Success");
                header("Location:../user/");
            }
            else{
                redirectWithAlert("../", "error", "Login Error: " . $user['message']);
            }
        }

    }
    catch(Exception $e){
        redirectWithAlert("../", "error", "Login Error: $e");
    }
    
?>