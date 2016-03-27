<?php


 
function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name
    $secure = true;
	
	$path = '/';
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
   ini_set('session.use_only_cookies', 1) ;
    // Gets current cookies params.
    setcookie(session_name(),
        '', time() - 42000, 
        "/", 
        site_name, 
        $secure, 
        $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session 
    // regenerated the session, delete the old one. 
}


function admin_login($email, $password, $mysqli) {
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $mysqli->prepare("SELECT id, first_name, last_name, username, password, salt 
        FROM admin
       WHERE email = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $email);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
 
        // get variables from result.
        $stmt->bind_result($user_id, $first_name, $last_name, $username, $db_password, $salt);
        $stmt->fetch();
 
        // hash the password with the unique salt.
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts 
 
            if (checkbrute($user_id, $mysqli) == true) {
                // Account is locked 
                // Send an email to user saying their account is locked
				
                return false;
            } else {
                // Check if the password in the database matches
                // the password the user submitted.
				
                if ($db_password == $password) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
					
                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
					$first_name = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $first_name);
					$last_name = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $last_name);
					
					$_SESSION['first_name'] = $first_name;
					$_SESSION['last_name'] = $last_name;
                    $_SESSION['username'] = $username;
					$_SESSION['email'] = $email;
                    $_SESSION['login_string'] = hash('sha512', 
                              $password . $user_browser);
							  
					  
                    // Login successful.
                    return true;
						
                } else {
                    // Password is not correct
                    // We record this attempt in the database
					
                    $now = date("Y-m-d H:i:s"); 
                    $mysqli->query("INSERT INTO login_attempts(user_id, time)
                                    VALUES ('$user_id', '$now')");
                    return false;
                }
            }
        } else {
            // No user exists.
            return false;
        }
    }
}


function user_login($email, $password, $mysqli) {
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $mysqli->prepare("SELECT id,first_name, last_name, username, password, salt 
        FROM members
       WHERE email = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $email);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
 
        // get variables from result.
        $stmt->bind_result($user_id, $first_name, $last_name, $username, $db_password, $salt);
        $stmt->fetch();
 
        // hash the password with the unique salt.
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts 
 
            if (checkbrute($user_id, $mysqli) == true) {
                // Account is locked 
                // Send an email to user saying their account is locked
				
                return false;
            } else {
                // Check if the password in the database matches
                // the password the user submitted.
				
                if ($db_password == $password) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
					
                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
					$_SESSION['email'] = $email;
					$_SESSION['first_name'] = $first_name;
					$_SESSION['last_name'] = $last_name;
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512', $password . $user_browser);
							  
					  
                    // Login successful.
                    return true;
						
                } else {
                    // Password is not correct
                    // We record this attempt in the database
					
                    $now = date("Y-m-d H:i:s"); 
                    $mysqli->query("INSERT INTO login_attempts(user_id, time)
                                    VALUES ('$user_id', '$now')");
                    return false;
                }
            }
        } else {
            // No user exists.
            return false;
        }
    }
}


function checkbrute($user_id, $mysqli) {
    // Get timestamp of current time 
    $now = date("Y-m-d H:i:s");
 
    // All login attempts are counted from the past 2 hours. 
    $valid_attempts = $now - (2 * 60 * 60);
 
    if ($stmt = $mysqli->prepare("SELECT time 
                             FROM login_attempts 
                             WHERE user_id = ? 
                            AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);
 
        // Execute the prepared query. 
        $stmt->execute();
        $stmt->store_result();
 
        // If there have been more than 10 failed logins 
        if ($stmt->num_rows > 10) {
            return true;
        } else {
            return false;
        }
    }
}


function admin_login_check($mysqli) {

    // Check if all session variables are set 
    if (isset($_SESSION['user_id'], 
                        $_SESSION['username'], 
                        $_SESSION['login_string'])) {

        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
 		
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        $stmt = $mysqli->prepare("SELECT password FROM admin WHERE id = ? LIMIT 1");
            // Bind "$user_id" to parameter. 
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();
 
            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($password);
                $stmt->fetch();
				
                $login_check = hash('sha512', $password . $user_browser);
 				
                if ($login_check == $login_string) {
                    // Logged In!!!! 
                    return true;
                } else {
                    // Not logged in 
                    return false;
                }
            } else {
                // Not logged in 
				
                return false;
            }
        
    } else {
        // Not logged in 
        return false;
    }
}


function user_login_check($mysqli) {

    // Check if all session variables are set 
    if (isset($_SESSION['user_id'], 
                        $_SESSION['username'], 
                        $_SESSION['login_string'])) {

        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
 		
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        $stmt = $mysqli->prepare("SELECT password FROM members WHERE id = ? LIMIT 1");
            // Bind "$user_id" to parameter. 
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();
 
            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($password);
                $stmt->fetch();
				
                $login_check = hash('sha512', $password . $user_browser);
 				
                if ($login_check == $login_string) {
                    // Logged In!!!! 
                    return true;
                } else {
                    // Not logged in 
                    return false;
                }
            } else {
                // Not logged in 
				
                return false;
            }
        
    } else {
        // Not logged in 
        return false;
    }
}



function esc_url($url) {
 
    if ('' == $url) {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

// upload image source code
function GetImageExtension($imagetype)
   	 {
       if(empty($imagetype)) return false;
       switch($imagetype)
       {
           case 'image/bmp': return '.bmp';
           case 'image/gif': return '.gif';
           case 'image/jpeg': return '.jpg';
           case 'image/png': return '.png';
           default: return false;
       }
     }

//get all products id in one array variable	 
function getProductsID ($mysqli){
	$stmt = $mysqli->prepare("SELECT id FROM products");
	$allID = array();
	$stmt->execute();
	$stmt->store_result();
	if($stmt->num_rows > 0) {
		$stmt->bind_result($id);
                
				$i = 0;
		while($row = $stmt->fetch()){
			$allID[$i] = $id;
			$i += 1;
		}
		return $allID;
	}
	return false;
}

//update members details
function changeDetails  ($mysqli , $value, $col,$session_name) {
	$id = $_SESSION['user_id'];
	if ($stmt = $mysqli->prepare("update members set $col='$value' where id=?")){
	$stmt->bind_param('i', $id);
	
	if ($stmt->execute()){
		$stmt->store_result();
		$stmt->fetch();
		if (!$session_name == ""){
	
		$_SESSION[$session_name] = $value;
		
	}
		return true;
	
	}
	}
	return false;
}

//check if exists function for all tables
function check_if_exists ($mysqli, $table , $col, $value ) {

	if ($stmt = $mysqli->prepare("select $col from $table where $col ='$value'")){
	
	$stmt->execute();
	$stmt->store_result();
	
	if($stmt->num_rows > 0) {
		$stmt->fetch();
		
		return true;
	
	}
	}
	$stmt ->close();
	return false;
}

function update_categories($mysqli, $button , $category_id_all){
if(isset($_POST[$button])){
	$p=0; //create a int variable and initialize it with zero
	while(count($category_id_all) > $p) { //check if the numbers of the id's in array are more than zero
		if ( $_POST['n'.$p] == ""){
		echo "<script>setTimeout(function() { alert('Empty category is not allowed!'); }, 1); </script>";
		return false;
		}
		$cat_name1 = $_POST['n'.$p];  // get the first id in a variable
		$cat_name = preg_replace("/[^A-Za-z0-9]/", "-", $cat_name1);
		if ( $cat_name1 !== $cat_name){
		echo "<script>setTimeout(function() { alert('Space is not allowed! , we replace unallowed characters with (-)'); }, 1); </script>";
		
		}
	if ($prep_stmt = "UPDATE category SET name = '$cat_name' WHERE parent = 1 and category_id = '$category_id_all[$p]' order by category_id"); 
	$stmt = $mysqli->prepare($prep_stmt);
	
		$stmt->execute();    // Execute the prepared query.
        $stmt->store_result(); 
		$p+=1; // we give plus one to this varible to check all vaules in array
}
return true;
}
}

function update_this_category($mysqli,$name,$parent){
	if($mysqli->query("UPDATE category  SET name='$name' WHERE $parent")){
	return true;
}
return false;
}

function add_this_category($mysqli,$name){
	if($mysqli->query("INSERT INTO category (name,parent) VALUES ('$name' ,NULL)")){
	return true;
}
return false;
}

function update_subcategories($mysqli, $button , $subcategory_parent_all){
if(isset($_POST[$button])){
	$p=0; //create a int variable and initialize it with zero
	while(count($subcategory_parent_all) > $p) { //check if the numbers of the id's in array are more than zero
		
		$cat_name = $_POST['sub'.$p];  // get the first id in a variable
		
	if ($prep_stmt = "UPDATE category SET name = '$cat_name' WHERE category_id = '$subcategory_parent_all[$p]' ORDER BY category_id "); 
	$stmt = $mysqli->prepare($prep_stmt);
	
		$stmt->execute();    // Execute the prepared query.
        $stmt->store_result(); 
		$p+=1; // we give plus one to this varible to check all vaules in array
}
return true;
}
}

function get_all_subcategories_from_category_db ($mysqli,$get){
$subcategory_names = array();
if ($prep_stmt = "SELECT name FROM category WHERE parent = (select category_id from category where name = '$get') ");
$stmt = $mysqli->prepare($prep_stmt);
if ($stmt) {
$stmt->execute();    // Execute the prepared query.
$stmt->store_result();
$stmt->bind_result($name);
$i=0;
if ($stmt->num_rows > 0) {	
		while($row = $stmt->fetch()) {
		$subcategory_names[$i] = $name;
		$i= $i+1;
			}						
		}	
}
return $subcategory_names;
}


function get_all_categories_from_db ($mysqli){
$category_names = array();
if ($prep_stmt = "SELECT name FROM category WHERE parent = 1 order by category_id ");
$stmt = $mysqli->prepare($prep_stmt);
if ($stmt) {
$stmt->execute();    // Execute the prepared query.
$stmt->store_result();
$stmt->bind_result($name);
$i=0;
if ($stmt->num_rows > 0) {	
		while($row = $stmt->fetch()) {
		$category_names[$i] = $name;
		$i= $i+1;
			}						
		}	
}
return $category_names;
}

function get_all_id_categories_from_db ($mysqli){
$category_ids = array();
if ($prep_stmt = "SELECT category_id FROM category WHERE parent = 1 order by category_id) ");
$stmt = $mysqli->prepare($prep_stmt);
if ($stmt) {
$stmt->execute();    // Execute the prepared query.
$stmt->store_result();
$stmt->bind_result($category_id);
$i=0;
if ($stmt->num_rows > 0) {	
		while($row = $stmt->fetch()) {
		$category_ids[$i] = $category_id;
		$i= $i+1;
			}						
		}	
}
return $category_ids;
}

function is_subcategory($mysqli,$id){
	if($stmt = $mysqli->prepare("SELECT parent FROM category WHERE parent='$id'")){
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($parent);
	if($stmt->num_rows > 0){
	return false;
}
}
return true;
}

function delete_subcategory ($mysqli, $cat_id){

	
	if($mysqli->query("DELETE from category where category_id = '$cat_id'")){ //delete a subcategory from db
	
		return true;
	}

	return false;
}

function delete_category ($mysqli, $cat_id){
	if($mysqli->query("DELETE from category where category_id = '$cat_id' or parent='$cat_id'")){ //delete a category and all it's subcategories from db
		echo "<script>setTimeout(function() { alert('Category is now deleted'); }, 1); </script>";
		return true;
	}
	return false;
}

function get_all_products_from_db ($mysqli, $limit, $end){
$products_name = array(); // create a array to take all products details
if ($limit != 0){
if ($prep_stmt = "SELECT product_name, category, price, quantity, clicks FROM products order by id DESC limit $limit offset $end");
} else {
	if ($prep_stmt = "SELECT product_name, category, price, quantity, clicks, id FROM products order by id DESC limit $end");
}
$stmt = $mysqli->prepare($prep_stmt);
if ($stmt) {
$stmt->execute();    // Execute the prepared query.
$stmt->store_result();
$stmt->bind_result($name, $category,$price,$quantity, $clicks, $id);
$i=0;
if ($stmt->num_rows > 0) {	//check if the numbers of the rows are more then 0
		while($row = $stmt->fetch()) { //fetch the statement
		$products_name[0][$i] = $name;
		$products_name[1][$i] = $category;
		$products_name[2][$i] = $quantity;
		$products_name[3][$i] = $price;
		$products_name[4][$i] = $clicks;
		$products_name[5][$i] = $id;
		$i= $i+1;
			}						
		}	
}
return $products_name;
}

function get_all_products_id_db ($mysqli){
$category_names = array();
if ($prep_stmt = "SELECT id FROM products order by id DESC");
$stmt = $mysqli->prepare($prep_stmt);
if ($stmt) {
$stmt->execute();    // Execute the prepared query.
$stmt->store_result();
$stmt->bind_result($id);
$i=0;
if ($stmt->num_rows > 0) {	
		while($row = $stmt->fetch()) {
		$category_names[$i] = $id;
		
		$i= $i+1;
			}						
		}	
}
return $category_names;
}

function delete_product ($mysqli, $id){
if ($id==""){
	return false;
}
$deleted=false;
if ($mysqli ->query("DELETE FROM products WHERE id='$id' "));
	if ($prep_stmt= "SELECT images_path FROM images_tbl WHERE product_id = '$id'");
	$stmt = $mysqli -> prepare ($prep_stmt);
	if ($stmt){
	$stmt -> execute();
	$stmt -> store_result();
	$stmt -> bind_result($images_path);
	if($stmt->num_rows >0){
		while($row=$stmt->fetch()){
			unlink($_SERVER['DOCUMENT_ROOT'] .$images_path);
			$deleted = true;
		}
	}
	if($deleted && $mysqli->query("DELETE FROM images_tbl WHERE product_id='$id' ")){
	return true;
	} else {
	echo "alert('Could not delete the images path from database!');";	
	}
	
}
return false;

}

function is_category_null($mysqli){
$site_name = "";
if ($prep_stmt= "SELECT name FROM category WHERE parent is null");
	$stmt = $mysqli -> prepare ($prep_stmt);
	if ($stmt){
	$stmt -> execute();
	$stmt -> store_result();
	
	if($stmt->num_rows >0){
$stmt -> bind_result($name);
		while($stmt->fetch()){
			return $name;
		}
	}
return false;
}
}

function doSomething( &$arg )
{
    $return = $arg;
    $arg += 1;
    return $return;
}
