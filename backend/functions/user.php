<?php

    //@ Encrypt
    function encryptUser($id_user, $password_user, $type, $secret_key){

        $user_value_txt = "type=$type&id_user=$id_user&password_user=$password_user";
        $user_value_hash = openssl_encrypt($user_value_txt, 'AES-256-CBC', $secret_key, 0, 'v_for_encryption');
        return $user_value_hash;
    }

    //@ Decrypt
    function decryptUser($user_value_hash, $secret_key){

        $user_value_txt = openssl_decrypt($user_value_hash, 'AES-256-CBC', $secret_key, 0, 'v_for_encryption');
        parse_str($user_value_txt, $user_value);
        return $user_value;
    }

    //@ Validate 
    function validateUser($user_value_hash, $id_user, $password_user, $secret_key){

        $user_value = decryptUser($user_value_hash, $secret_key);

        if(!($user_value['id_user'] == $id_user)){
            
            // if id user is wrong
            return false;
            exit;
        }

        if(!($user_value['password_user'] == $password_user)){
            
            // if id user is wrong
            return false;
            exit;
        }

        return true;
    }

    
    //@ Set Session User
    function setUser($id_user, $password_user, $type, $token_name, $secret_key, $connect){

        try{
            $user_value_hash = encryptUser($id_user, $password_user, $type,  $secret_key);
    
            setcookie($token_name, $user_value_hash, time() + (86400 * 30), "/");
            $_SESSION[$token_name] = $user_value_hash;
        }
        catch(Exception $e){
            echo $e;
        }

    }

    //@ Set first name
    function getFirstName($fullName){
        preg_match('/^(\S+)/', trim($fullName), $matches);
        return ucfirst($matches[1] ?? '');
    }

?>