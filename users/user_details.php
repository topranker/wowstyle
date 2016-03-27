
<!-- main header --!>


<?php 
$dir = preg_replace('/\b\w*users\w*\b/i', '', trim( __DIR__));

?>
<?php  include $dir . '/head.php' ; ?>
<?php  include $_SERVER["DOCUMENT_ROOT"] . site_name.'/menu.php' ; ?>

<?php 




?>
<!-- body -->

<?php if (!user_login_check($mysqli)){
	echo "you are not loged in";
	return;
}?>


<!-- container -->
<div class="left" > 
<div class="leftProducts">
<div style="padding:5px">
<h1> Check or change your details</h1></br>

<?php

$result = "";

if(isset($_POST['b1'])){
	$value = $_POST['first_name'];
	if (!$value == ""){
	$col = "first_name";
	$session_name = "first_name";
	if (!changeDetails($mysqli, $value, $col, $session_name)){
		$result = "can not update your details";
	} else {
	$result = "updated";	
	}
	}
} else if(isset($_POST['b2'])){
	$value = $_POST['last_name'];
	if (!$value == ""){
	$col = "last_name";
	$session_name = "last_name";
	if (!changeDetails($mysqli, $value, $col, $session_name)){
		$result = "can not update your details";
	} else {
	$result = "updated";	
	}
	}

} else if(isset($_POST['b3'])){
	$value = $_POST['username'];
	if (!$value == ""){
	$col = "username";
	$session_name = "username";
	if (!check_if_exists($mysqli, "members", $col, $value)){
	
	if (!changeDetails($mysqli, $value, $col, $session_name)){
		$result = "can not update your details";
	} else {
	$result = "updated";	
	}
	}   else {
		$result = "this username exists, please choose another username";
	}
	}


} else if(isset($_POST['b4'])){
	$value = $_POST['email'];
	$value = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $value = filter_var($value, FILTER_VALIDATE_EMAIL);
	if (!$value == ""){
	$col = "email";
	$session_name = "email";
	if (!check_if_exists($mysqli, "members", $col, $value)){
	
	if (!changeDetails($mysqli, $value, $col, $session_name)){
		$result = "can not update your details";
	} else {
	$result = "updated";	
	}
	}   else {
		$result = "this email exists, please check your email";
	}
	} else {
		$result = "error , there is a mistake with your email";
	}

} else if(isset($_POST['p'])){
	$password = $_POST['p'];
	
	$password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $result = '<p class="error">Invalid password configuration.</p>';
    }
	
	$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
	$value = hash('sha512', $password . $random_salt);
	if (!$value == ""){
	$col = "password";
	$session_name = "password";
	if (!changeDetails($mysqli, $random_salt, "salt", "")){
		$result = "can not update your details";
	} else {
	$result = "updated";	
	}
	
	if (!changeDetails($mysqli, $value, $col, "")){
		$result = "can not update your details";
	} else {
	$result = "updated";	
	}
	
	} else {
		$result = "error , there is a mistake with your email";
	}
	
}
?>

<ul class="user-details">

<form method="post" name="action" action="">
<li>First name: <input type="submit" value="change" name="b1">
<input type="text" name="first_name" value="<?php echo htmlentities($_SESSION['first_name']); ?>"> </li><?php if(isset($_POST['b1'])){ echo $result; }?></br>

<li>Last name: <input type="submit"value="change" name="b2">
<input type="text" name="last_name" value="<?php echo htmlentities($_SESSION['last_name']); ?>" ></li><?php if(isset($_POST['b2'])){ echo $result; }?></br>

<li>Username: <input type="submit"value="change" name="b3">
<input type="text" name="username" value="<?php echo htmlentities($_SESSION['username']); ?>"></li><?php if(isset($_POST['b3'])){ echo $result; }?></br>

<li>Email: <input type="submit"value="change" name="b4">
<input type="text" name="email" value="<?php echo htmlentities($_SESSION['email']); ?>"></li><?php if(isset($_POST['b4'])){ echo $result; }?></br>

<li>Password: <input style="margin-right:17%" type="password" id="password" name="password" value=""></li><?php if(isset($_POST['b5'])){ echo $result; }?></br>
<li><label>Retype Password:</label> 
<input type="password" style="float:inherit; margin-left:4%" name="password1" id="password1" value="">
<input type="button" onClick="return passHash(this.form , this.form.password, this.form.password1);" style="float:right" value="change" ></li><?php if(isset($_POST['p'])){ echo $result; }?></br>
</ul>
</form>
</div>
</div>


</div>


<!-- sidebar -->
<div class="right" > 


            
            
            
       
           
        
<?php  include $_SERVER["DOCUMENT_ROOT"] . site_name.'/sidebarheader.php' ; ?>

</div>



<!-- footer -->
<?php include $_SERVER["DOCUMENT_ROOT"] . site_name.'/footer.php' ; ?>