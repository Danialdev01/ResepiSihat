<?php
    // date time
    date_default_timezone_set("Asia/Kuala_Lumpur"); 

    $env = parse_ini_string(file_get_contents(__DIR__.'/.env'));

    //@ ENV
    $webname = $env['WEBNAME'];
    // php 
    $hostname = $env['HOSTNAME'];
    $username = $env['USERNAME'];
    $password = $env['PASSWORD'];
    $dbname = $env['DBNAME'];
    $secret_key = $env['SECRET_KEY'];
    $domain = $env['DOMAIN'];
    $token_name = "ResipiSihat";

    // Google SSO
    $clientId = $env['GOOGLE_CLIENT_ID'];
    $clientSecret = $env['GOOGLE_CLIENT_SECRET'];
    $redirectUri = $domain . $env['REDIRECT_URI'];

    // GROK AI
    $ai_api_key = $env['AI_API_KEY'];

    //@ MYSQL connect
    $dsn = 'mysql:host='. $hostname .';dbname='. $dbname;
    
    try{
        // connect to db
        $connect = new PDO($dsn, $username, $password);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $error){
        echo $error->getMessage();
        session_destroy();
        exit;
    }

    // error reporting 
    error_reporting(E_ALL ^ E_DEPRECATED);

    function errorHandler($errno, $errstr, $errfile, $errline){echo "ERROR : [$errno] $errstr - ( $errfile | line $errline)";}
    set_error_handler("errorHandler");

?>