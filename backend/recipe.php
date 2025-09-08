<?php

    session_start();

    include '../config/connect.php';
    include '../backend/functions/system.php';
    include '../backend/functions/user.php';
    include '../backend/functions/csrf-token.php';
    include '../backend/models/recipe.php';

    checkCSRFToken();

    //@ Create recipe
    if(isset($_POST['create_recipe'])){

        try{
            // // filter input
            // $email_user = validateInput($_POST['email_user']);
            // $name_user = validateInput($_POST['name_user']);
            // $password_user = validateInput($_POST['password_user']);
            // $confirm_password_user = validateInput($_POST['confirm_password_user']);

            // // create user
            // $user = createUser($name_user, $email_user, $password_user, 1, $confirm_password_user, $connect);
            // $user = json_decode($user, true);

            // if($user['status'] == "success"){

            //     // login user
            //     setUser($user['id_user'], $password_user, "user", $token_name, $secret_key, $connect);
            //     setLogginDate($connect, $user['id_user']);
            //     log_activity_message("../log/user_activity_log", "Login Success");
            //     header("Location:../user/");
            // }
            // else{
            //     redirectWithAlert("../", "error", $user['message']);
            // }

        }
        catch(Exception $e){
            redirectWithAlert("../", "error", "Ralat hasilkan resepi");
        }
    }

    //@ Like recipe 
    else if(isset($_POST['like_recipe'])){

        try{

            $id_recipe = validateInput($_POST['id_recipe']);
            
            $user = decryptUser($_SESSION[$token_name], $secret_key);
            $id_user = $user['id_user'];
            
            $type = validateInput($_POST['type']);
            
            $likeRecipe = likeRecipe($id_recipe, $id_user, $type, $connect);
            $likeRecipe = json_decode($likeRecipe, true);

            if($likeRecipe['status'] == "success"){
                
                alert_message("success", "Berjaya ". $type ." recipe");
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            }
            else{
                redirectWithAlert("../", "error", $likeRecipe['message']);
            }

        }
        catch(Exception $e){
            redirectWithAlert("../", "error", "Login Error");
        }

    }

    //@ Bookmark recipe
    else if(isset($_POST['bookmark_recipe'])){

        try{

            $id_recipe = validateInput($_POST['id_recipe']);
            
            $user = decryptUser($_SESSION[$token_name], $secret_key);
            $id_user = $user['id_user'];
            
            $type = validateInput($_POST['type']);
            
            $bookmarkRecipe = bookmarkRecipe($id_recipe, $id_user, $type, $connect);
            $bookmarkRecipe = json_decode($bookmarkRecipe, true);

            if($bookmarkRecipe['status'] == "success"){
                
                alert_message("success", $bookmarkRecipe['message']);
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            }
            else{
                redirectWithAlert("../", "error", $bookmarkRecipe['message']);
            }

        }
        catch(Exception $e){
            redirectWithAlert("../", "error", "Login Error");
        }

    }

    //@ Comment recipe 
    else if(isset($_POST['comment_recipe'])){

        try{

            $id_recipe = validateInput($_POST['id_recipe']);
            
            $user = decryptUser($_SESSION[$token_name], $secret_key);
            $id_user = $user['id_user'];
            
            $text_comment = validateInput($_POST['text_comment']);
            
            $commentRecipe = commentRecipe($id_recipe, $id_user, $text_comment, $connect);
            $commentRecipe = json_decode($commentRecipe, true);

            if($commentRecipe['status'] == "success"){
                
                alert_message("success", "Berjaya komen recipe");
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            }
            else{
                redirectWithAlert("../", "error", $commentRecipe['message']);
            }

        }
        catch(Exception $e){
            redirectWithAlert("../", "error", "Login Error");
        }

    }
    

    else{
        redirectWithAlert("../", "error", "Error Function");
    }

?>