<?php

    session_start();

    include '../config/connect.php';
    include '../backend/functions/system.php';
    include '../backend/functions/csrf-token.php';
    include '../backend/models/user.php';
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
                header("Location:../user/");
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
                header("Location:../user/");
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

    //  @ Singout
    else if(isset($_POST['update_user'])){

        try{

            $id_user = validateInput($_POST['id_user']);
            $name_user = validateInput($_POST['name_user']);
            $email_user = validateInput($_POST['email_user']);

            $updateUser = updateUser($id_user, $name_user, $email_user, $connect);

            $updateUser = json_decode($updateUser, true);

            if($updateUser['status'] == "success"){
                redirectWithAlert($_SERVER["HTTP_REFERER"] , "success", $updateUser['message']);
            }
            else{
                redirectWithAlert($_SERVER["HTTP_REFERER"] , "error", $updateUser['message']);
            }
            
        }
        catch(Exception $e){
            redirectWithAlert("../", "error", "Error update user");

        }

    }

    //  @ Change Profile Picture
    else if(isset($_POST['change_pfp'])){

        try{

            $userId = validateInput($_POST['id_user']);

            $check_pfp_user_sql = $connect->prepare("SELECT pfp_user FROM users WHERE id_user = :id_user");
            $check_pfp_user_sql->execute(['id_user' => $userId]);
            $check_pfp_user = $check_pfp_user_sql->fetch(PDO::FETCH_ASSOC);

            if($check_pfp_user && $check_pfp_user['pfp_user']) {
                $oldFilePath = '../uploads/profiles/' . $check_pfp_user['pfp_user'];
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath); // Delete old profile picture
                }
            }

            // Check if file was uploaded
            if (!(isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK)) {
                redirectWithAlert($_SERVER["HTTP_REFERER"] , "error", "Sila pilih fail imej");
                exit;
            }

            $file = $_FILES['profile_picture'];
            
            // Validate file type and size
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $maxFileSize = 5 * 1024 * 1024; // 5MB
            
            if (!in_array($file['type'], $allowedTypes)) {
                redirectWithAlert($_SERVER["HTTP_REFERER"] , "error", "Hanya fail imej (JPEG, PNG, GIF, WEBP) yang dibenarkan");
                exit;
            }
            
            if ($file['size'] > $maxFileSize) {
                redirectWithAlert($_SERVER["HTTP_REFERER"] , "error", "Saiz fail terlalu besar. Maksimum 5MB dibenarkan");
                exit;
            }
            
            // Create uploads directory if it doesn't exist
            $uploadDir = '../uploads/profiles/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
                
            // Generate unique filename
            $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $fileName = 'profile_' . $userId . '_' . time() . '.' . $fileExtension;
            $filePath = $uploadDir . $fileName;
            
            // Move uploaded file
            if (!(move_uploaded_file($file['tmp_name'], $filePath))) {
                redirectWithAlert($_SERVER["HTTP_REFERER"] , "error", "Ralat ketika memuat naik fail");
                exit;
            } 

            // Update database
            $stmt = $connect->prepare("UPDATE users SET pfp_user = ? WHERE id_user = ?");
            if ($stmt->execute([$fileName, $userId])) {

                redirectWithAlert($_SERVER["HTTP_REFERER"] , "success", "Berjaya ubah gambar profil");
                exit;
            } else {
                $response['message'] = 'Ralat ketika mengemas kini pangkalan data';
                echo json_encode($response);
                exit;
            }

        }
        catch(Exception $e){

            redirectWithAlert("../", "error", "Error upload image");
        }

    }

    else{
        redirectWithAlert("../", "error", "Error Function");
    }

?>