<?php
$dir = preg_replace('/\b\w*users\w*\b/i', '', trim( __DIR__));
$dir = preg_replace('/\b\w*includes\w*\b/i', '', trim( $dir));
include_once $dir . '/config/db_connect.php';
include_once $_SERVER["DOCUMENT_ROOT"] . site_name.'/classes/functions.php';
 
sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['email'], $_POST['p'])) {
    $email = $_POST['email'];
    $password = $_POST['p']; // The hashed password.
 	
    if (user_login($email, $password, $mysqli) == true) {
        // Login success 
        header('Location: ' . site_name .'/users/user_profile.php');
    } else {
        // Login failed 
        header('Location: ' . site_name .'/login.php?error=1');
    }
} else {
    // The correct POST variables were not sent to this page. 
    echo 'Invalid Request';
}