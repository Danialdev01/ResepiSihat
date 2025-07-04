<?php

    function generateCSRFToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    function verifyCSRFToken($token) {
        if (hash_equals($_SESSION['csrf_token'], $token)) {
            return true;
        } else {
            return false;
        }
    }

    function checkCSRFToken(){
        if(!(isset($_POST['token']) && verifyCSRFToken($_POST['token']))){
            log_activity_message("../log/error_log", "Invalid Token");
            alert_message("error", "Token not set");
            header("Location:../");
            exit();
        }
    }

?>