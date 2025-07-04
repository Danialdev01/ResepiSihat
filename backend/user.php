<?php

    session_start();

    include '../config/connect.php';
    include '../backend/functions/system.php';
    include '../backend/functions/csrf-token.php';
    include '../backend/models/user.php';
    include '../backend/models/tag.php';
    include '../backend/functions/user.php';

    checkCSRFToken();

    //@ Signup
    if(isset($_POST['signup'])){

        try{
            // filter input
            $email_user = validateInput($_POST['email_user']);
            $name_user = validateInput($_POST['name_user']);
            $password_user = validateInput($_POST['password_user']);
            $confirm_password_user = validateInput($_POST['confirm_password_user']);

            // create user
            $user = createUser($name_user, $email_user, $password_user, 1, $confirm_password_user, $connect);
            $user = json_decode($user, true);

            if($user['status'] == "success"){

                // login user
                setUser($user['id_user'], $password_user, "user", $token_name, $secret_key, $connect);
                setLogginDate($connect, $user['id_user']);
                log_activity_message("../log/user_activity_log", "Login Success");
                header("Location:../guest/");
            }
            else{
                redirectWithAlert("../", "error", $user['message']);
            }

        }
        catch(Exception $e){
            redirectWithAlert("../", "error", "Signup Error");
        }
    }
    //@ Login
    else if(isset($_POST['signin'])){

        try{
            $email_user = validateInput($_POST['email_user']);
            $password_user = validateInput($_POST['password_user']);
            
            $userCheck = checkUserPassword($email_user, $password_user, $connect);
            $userCheck = json_decode($userCheck, true);

            if($userCheck['status'] == "success"){
                    
                $user = setUser($userCheck['id_user'], $password_user, "user", $token_name, $secret_key, $connect);

                setLogginDate($connect, $userCheck['id_user']);
                log_activity_message("../log/user_activity_log", "Login Success");
                header("Location:../guest/");
            }
            else{
                redirectWithAlert("../", "error", $userCheck['message']);
            }

        }
        catch(Exception $e){
            redirectWithAlert("../", "error", "Login Error");
        }

    }
    //  @ Singout
    else if(isset($_POST['signout'])){

        try{
            session_destroy();
            setcookie($token_name, 2, time() - 3600 , "/");
            redirectWithAlert("../", "success", "Logout");

        }
        catch(Exception $e){
            redirectWithAlert("../", "error", "Login Error");

        }

    }

    //@ Set cred key
    else if(isset($_POST['set_cred_key'])){

        try{
            if(isset($_POST['cred_key']) && $_POST['cred_key'] == $secret_key){

                $_SESSION['cred_key'] = $_POST['cred_key'];
                redirectWithAlert($_SERVER["HTTP_REFERER"], "success", "Login Key Correct");
            }
            else{
            
                redirectWithAlert("../", "error", "Error Function");
            }
        }
        catch(Exception $e){
            redirectWithAlert("../", "error", "Error : $e");
        }
    }

    //@ New Tag
    else if(isset($_POST['new_tag'])){

        try{
            
            $new_tag = createTag(
                $_POST['id_user'], 
                $_POST['name_tag'], 
                $connect
            );

            $new_tag = json_decode($new_tag, true);

            if($new_tag['status'] == "success"){

                log_activity_message("../log/user_activity_log", "Add Tag Success");
                header("Location: " . $_SERVER["HTTP_REFERER"]);   
            }
            else{
                // redirectWithAlert($_SERVER["HTTP_REFERER"], "error", "Add Tag Error Proses");
                // var_dump($new_tag);

            }
        }
        catch(Exception $e){
            redirectWithAlert("../", "error", "Error : $e");
        }
    }
    else{
        redirectWithAlert("../", "error", "Error Function");
    }

?>