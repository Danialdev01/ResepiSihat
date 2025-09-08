<?php 

function createBahan(){

}

//@ Update num 
function updateNumLikesRecipe($id_recipe, $num, $connect){

    $recipe_sql = $connect->prepare("SELECT num_likes_recipe FROM recipes WHERE id_recipe = :id_recipe");
    $recipe_sql->execute([":id_recipe" => $id_recipe]);
    $recipe = $recipe_sql->fetch(PDO::FETCH_ASSOC);
    $new_num = $recipe['num_likes_recipe'] + $num;
    
    // update like counter recipe
    $update_like_recipe_sql = $connect->prepare("UPDATE recipes SET num_likes_recipe = :num_likes_recipe WHERE id_recipe = :id_recipe");
    $update_like_recipe_sql->execute([
        ":num_likes_recipe" => $new_num,
        ":id_recipe" => $id_recipe
    ]);

}

//@ Like Recipe
function likeRecipe($id_recipe, $id_user, $type, $connect){


    try{

        if($type == "like"){

            // add new like
            $like_recipe_sql = $connect->prepare("INSERT INTO likes (id_user, id_recipe, id_comment, created_date_like) VALUES (:id_user, :id_recipe, NULL, NOW())");
            $like_recipe_sql->execute([
                ":id_user" => $id_user,
                ":id_recipe" => $id_recipe
            ]);

            updateNumLikesRecipe($id_recipe, 1 , $connect);

            return encodeObj("200", "Like resepi", "success");

        }
        else if($type == "dislike"){

            $delete_like_recipe_sql = $connect->prepare("DELETE FROM likes WHERE id_recipe = :id_recipe AND id_user = :id_user"); 
            $delete_like_recipe_sql->execute([
                ":id_recipe" => $id_recipe,
                ":id_user" => $id_user
            ]);

            updateNumLikesRecipe($id_recipe, -1, $connect);

            return encodeObj("200", "Dislike resepi", "success");

        }
        else{
            $connect->rollBack();
            return encodeObj("400", "Error type like", "error");

        }


    }
    catch(Exception $e){

        return encodeObj("400", "Ralat like resepi", "error");

    }

}

//@ Bookmark Recipe
function bookmarkRecipe($id_recipe, $id_user, $type, $connect){


    try{

        if($type == "bookmark"){

            // add new like
            $bookmark_recipe_sql = $connect->prepare("INSERT INTO bookmarks (id_user, id_recipe, created_date_bookmark) VALUES (:id_user, :id_recipe, NOW())");
            $bookmark_recipe_sql->execute([
                ":id_user" => $id_user,
                ":id_recipe" => $id_recipe
            ]);

            return encodeObj("200", "Simpan resepi", "success");

        }
        else if($type == "disbookmark"){

            $delete_like_recipe_sql = $connect->prepare("DELETE FROM bookmarks WHERE id_recipe = :id_recipe AND id_user = :id_user"); 
            $delete_like_recipe_sql->execute([
                ":id_recipe" => $id_recipe,
                ":id_user" => $id_user
            ]);

            return encodeObj("200", "Buang simpanan resepi", "success");

        }
        else{
            $connect->rollBack();
            return encodeObj("400", "Error type like", "error");

        }


    }
    catch(Exception $e){

        return encodeObj("400", "Ralat simpan resepi. $e", "error");

    }

}

//@ Comment Recipe
function commentRecipe($id_recipe, $id_user, $text_comment, $connect){

    try{

        if(!empty($text_comment)){

            $insert_comment = $connect->prepare("
                INSERT INTO comments (id_user, id_recipe, text_comment, created_date_comment, status_comment) 
                VALUES (:user_id, :recipe_id, :comment_text, NOW(), 1)
            ");

            $insert_comment->execute([
                ':user_id' => $id_user,
                ':recipe_id' => $id_recipe,
                ':comment_text' => $text_comment
            ]);

            return encodeObj("200", "Berjaya komen resepi", "success");


        }
        else{

            return encodeObj("400", "Sila isi komen sebelum menghantar.", "error");
        }

    }
    catch(Exception $e){
        return encodeObj("400", "Ralat komen resepi. $e", "error");

    }

}