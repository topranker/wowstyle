<?php
$dir = preg_replace('/\b\w*admin\w*\b/i', '', trim( __DIR__));
$dir = preg_replace('/\b\w*includes\w*\b/i', '', trim( $dir));
include_once $dir .'/config/db_connect.php' ;
include_once $dir .'/config/psl-config.php' ;
 
$error_msg = "";
 
if (isset($_POST['username'], $_POST['email'], $_POST['p'])) {
    // Sanitize and validate the data passed in
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
	$first_name = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING);
	$last_name = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        $error_msg .= '<p class="error">The email address you entered is not valid</p>';
    }
 
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="error">Invalid password configuration.</p>';
    }
 
    // Username validity and password validity have been checked client side.
    // This should should be adequate as nobody gains any advantage from
    // breaking these rules.
    //
 
    $prep_stmt = "SELECT id FROM admin WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
 
   // check existing email  
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows == 1) {
            // A user with this email address already exists
            $error_msg .= '<p class="error">A user with this email address already exists.</p>';
                        
        }
                
    } else {
        $error_msg .= '<p class="error">Database error Line 39</p>';
                
    }
 
    // check existing username
    $prep_stmt = "SELECT id FROM admin WHERE username = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
 
    if ($stmt) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $stmt->store_result();
 
                if ($stmt->num_rows == 1) {
                        // A user with this username already exists
                        $error_msg .= '<p class="error">A user with this username already exists</p>';
                        
                }
                
        } else {
                $error_msg .= '<p class="error">Database error line 55</p>';
                
        }
 
    // TODO: 
    // We'll also have to account for the situation where the user doesn't have
    // rights to do registration, by checking what type of user is attempting to
    // perform the operation.
 	
	
 
    if (empty($error_msg)) {
		
        // Create a random salt
        //$random_salt = hash('sha512', uniqid(openssl_random_pseudo_bytes(16), TRUE)); // Did not work
        $random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
 
        // Create salted password 
        $password = hash('sha512', $password . $random_salt);
 		$date = date("Y-m-d H:i:s");
        // Insert the new user into the database 
        if ($insert_stmt = $mysqli->prepare("INSERT INTO admin (first_name, last_name, username, email, password, salt, last_log_date ) VALUES (?, ?, ?, ?, ?, ?, ?)")) {
            
			$insert_stmt->bind_param('sssssss', $first_name, $last_name, $username, $email, $password, $random_salt, $date);
            // Execute the prepared query.
			
            if (! $insert_stmt->execute()) {
                header('Location: ../error.php?err=Registration failure: INSERT');
            } else {
				header('Location: ./register_success.php');
			}
        }
        
    }
}