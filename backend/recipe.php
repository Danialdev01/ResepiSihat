<?php

    session_start();

    include '../config/connect.php';
    include '../backend/functions/system.php';
    include '../backend/functions/user.php';
    include '../backend/functions/file.php';
    include '../backend/functions/csrf-token.php';
    include '../backend/models/recipe.php';

    checkCSRFToken();

    //@ Create recipe
    if(isset($_POST['create_recipe'])){

        try{
            $user = decryptUser($_SESSION[$token_name], $secret_key);
            $id_user = $user['id_user'];

            $name_recipe = validateInput($_POST['name_recipe']);
            $desc_recipe = validateInput($_POST['desc_recipe']);
            $category_recipe = validateInput($_POST['category_recipe']);
            $tutorial_recipe = validateInput($_POST['tutorial_recipe']);
            $ingredient_recipe = validateInput($_POST['ingredient_recipe']);
            $cooking_time_recipe = validateInput($_POST['cooking_time_recipe']);
            $url_resource_recipe = validateInput($_POST['url_resource_recipe']);
            $visibility_recipe = validateInput($_POST['visibility_recipe']);

            // create recipe
            $createRecipe = createRecipe($id_user, $name_recipe, $_FILES['image_recipe'], $desc_recipe, $category_recipe, $tutorial_recipe, $ingredient_recipe, $cooking_time_recipe,  $url_resource_recipe, $visibility_recipe, $connect);
            $createRecipe = json_decode($createRecipe, true);

            if($createRecipe['status'] == "success"){

                alert_message("success", "Berjaya hasil recipe");
                log_activity_message("../log/user_activity_log", "Berjaya hasil recipe");
                header("Location:../user/");
            }
            else{
                redirectWithAlert("../", "error", $createRecipe['message']);
            }

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

    //@ Delete recipe 
    else if(isset($_POST['delete_recipe'])){

        try{

            $id_recipe = validateInput($_POST['id_recipe']);
            
            $user = decryptUser($_SESSION[$token_name], $secret_key);
            $id_user = $user['id_user'];

            $check_recipe_sql = $connect->prepare("SELECT id_user FROM recipes WHERE id_recipe = :id_recipe");
            $check_recipe_sql->execute([
                ":id_recipe" => $id_recipe
            ]);
            $check_recipe = $check_recipe_sql->fetch(PDO::FETCH_ASSOC);
            
            if($check_recipe['id_user'] == $id_user){

                // batalkan recipe
                $disactive_recipe_sql = $connect->prepare("UPDATE recipes SET status_recipe = 0 WHERE id_recipe = :id_recipe");
                $disactive_recipe_sql->execute([
                    ":id_recipe" => $id_recipe
                ]);
                    
                alert_message("success", "Berjaya batalkan recipe");
                header("Location:../user/");
            }
            else{
                redirectWithAlert("../", "error", "Resepi bukan milik pengguna");
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