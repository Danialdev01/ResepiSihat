<?php


//@ Check user
function checkUser(?string $email_user, ?int $id_user, $connect){
    if ($id_user === null && $email_user === null) {
        throw new InvalidArgumentException('Either ID or email must be provided');
    }

    $sql = "SELECT * FROM users WHERE ";
    $conditions = [];
    $params = [];

    if ($id_user !== null) {
        $conditions[] = "id_user = :id";
        $params[':id'] = $id_user;
    }

    // Add email condition if provided
    if ($email_user !== null) {
        $conditions[] = "email_user = :email";
        $params[':email'] = $email_user;
    }

    // Combine conditions with AND
    $sql .= implode(" AND ", $conditions);
    
    // Prepare and execute the query
    $stmt = $connect->prepare($sql);
    $stmt->execute($params);
    
    // Fetch the user
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    return [
        'exists' => $user !== false,
        'user' => $user ?: null,
    ];
}

function checkUserPassword($email_user, $password_user, $connect){

    $userInfo = checkUser($email_user, NULL, $connect);

    if($userInfo['exists'] == true){

        if(password_verify($password_user, $userInfo['user']['password_user'])){

            $status = encodeObj("200", "Sign up success", "success");

            $user_value = [
                "id_user" => $userInfo['user']['id_user'],
                "email_user" => $userInfo['user']['email_user'],
            ];
                
            $user_value = json_encode($user_value);
            return addJson($status, $user_value);

            exit;
        }
        else{
            return encodeObj("400", "Password not correct", "error");
            exit;
        }
    }
    else{
        return encodeObj("400", "User not exits", "error");

    }
}

//@ Verify User
function verifySessionUser($token_name, $secret_key, $connect){

    $type_user = "user";

    if(isset($_SESSION[$token_name]) || isset($_COOKIE[$token_name])){
        
        // set user session based on cookie
        if(!isset($_SESSION[$token_name])){
            $_SESSION[$token_name] = $_COOKIE[$token_name];
        }

        // decrypt user token
        $user_value_hash = $_SESSION[$token_name];
        $user_value = decryptUser($user_value_hash, $secret_key);
        
        // get user value 
        $id_user = validateInput($user_value['id_user']);
        $password_user = validateInput($user_value['password_user']);
        $type_user_value = validateInput($user_value['type']);

        // identify user type
        if($type_user_value != $type_user){
            return encodeObj("400", "Not Correct Value", "error");
            exit;
        }
        
        // based on db
        $user_sql = $connect->prepare("SELECT * FROM users WHERE id_user = ?");
        $user_sql->execute([$id_user]);
        $user = $user_sql->fetch(PDO::FETCH_ASSOC);
        
        if($user == false){
            return encodeObj("400", "Password not correct $password_user", "error");
        }

        if($user['password_user'] != NULL){

            if(password_verify($password_user, $user['password_user'])){
    
                $status = encodeObj("200", "Loggin Success", "success");
                
                $user_value = [
                    "id_user" => $user['id_user'],
                    "email_user" => $user['email_user'],
                    "name_user" => $user['name_user'],
                    "password_user" => $user_value['password_user']
                ];
                
                $user_value = json_encode($user_value);
                return addJson($status, $user_value);
    
            }
            else{
                return encodeObj("400", "Password not correct $password_user", "error");
            }
        }
        elseif($user['password_gsso_user'] != NULL){
            if(password_verify($password_user, $user['password_gsso_user'])){
    
                $status = encodeObj("200", "Loggin Success", "success");
                
                $user_value = [
                    "id_user" => $user['id_user'],
                    "email_user" => $user['email_user'],
                    "name_user" => $user['name_user'],
                    "password_user" => $user['password_gsso_user']
                ];
                
                $user_value = json_encode($user_value);
                return addJson($status, $user_value);
            }
            else{
                return encodeObj("400", "Password not correct", "error");
            }
        }
        else{
            $u = $user['id_user'];
            return encodeObj("400", "Password not set $u", "error");
        }
    }
    else{

        return encodeObj("400", "Pengguna belum Log Masuk", "error");
    }
}

//@ Create user
function createUser($name_user, $email_user, $password_user, $type, $confirm_password_user, $connect){

    try{

        $email_user = validateInput($email_user);
        $name_user = validateInput($name_user);
        $created_date_user = date("Y-m-d");
        $password_user = validateInput($password_user);
        $confirm_password_user = validateInput($confirm_password_user);

        $user = checkUser($email_user, NULL, $connect);

        // check if user exit
        if($user['exists'] != null){
            return encodeObj("400", "User Exits", "error");
        }

        // check if password confirm correct
        if($password_user != $confirm_password_user){
    
            return encodeObj("400", "Confirm password not identical", "error");
        }

        // hash password user
        $password_user_hashed = password_hash($password_user, PASSWORD_DEFAULT);

        if($type == 1){
            $password_gsso_user = NULL;
            $password_user = $password_user_hashed;
        }
        else if($type == 2){
            $password_gsso_user = $password_user_hashed;
            $password_user = NULL;
        }
        else{
            return encodeObj("400", "User type not correct", "error");
        }

        $create_user_sql = $connect->prepare("
            INSERT INTO users(id_user, email_user, name_user, password_user, password_gsso_user, modify_date_user, logged_date_user, status_user) 
            VALUES (NULL, :email_user , :name_user , :password_user , :password_gsso_user , :modify_date_user , NULL , 1)
        ");

        $create_user_sql->execute([
            ":email_user" => $email_user,
            ":name_user" => $name_user,
            ":password_user" => $password_user,
            ":password_gsso_user" => $password_gsso_user,
            ":modify_date_user" => $created_date_user
        ]);

        $id_user = $connect->lastInsertId();
    
        $status = encodeObj("200", "Sign up success", "success");
        $user = [
    
            "id_user" => $id_user,
            "email_user" => $email_user,
            "name_user" => $name_user,
            "password_user" => $password_user
        ];
    
        $user = json_encode($user);
        return addJson($status, $user);
    }

    catch(PDOException $e){
        return encodeObj("400", "Error Login", "error");
        exit;
    }

}

function setLogginDate($connect, $id_user){
    $update_logged_date_user = $connect->prepare("UPDATE users SET logged_date_user = :logged_date_user WHERE id_user = :id_user");
    $update_logged_date_user->execute([
        ":logged_date_user" => date("Y-m-d"),
        ":id_user" => $id_user
    ]);
}

?>