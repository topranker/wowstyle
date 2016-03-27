<header class="mainheader">
<div class="first-header">
<div class="login-register-top">
<ul>
<?php 


if (admin_login_check($mysqli) == true ) {
    $logged = 'in';

	echo "<li>Hello,". htmlentities($_SESSION['first_name']) ." <a href='".site_name."/admin/admin_login.php?1' name='link1'>Log out</a></li>";
	
        if ($_SERVER['QUERY_STRING'] == 1){
             
             include_once 'admin/includes/logout.php';
        }
	echo"<li><a href='".site_name."/admin/index.php'>My account</a></li>";
	
}else if (user_login_check($mysqli) == true){
	
	echo "<li>Hello,". htmlentities($_SESSION['first_name']) ." <a href='".site_name."/login.php?1' name='link1'>Log out</a></li>";
	echo"<li><a href='".site_name."/users/user_profile.php?my-account'>My account</a></li>";
        if ($_SERVER['QUERY_STRING'] == 1){
             
             include_once 'users/includes/logout.php';
        }
		
		
		
} else {
    $logged = 'out';
	echo "<li><a href='".site_name."/login.php'>Login</a>
<a href='".site_name."/register.php'>Register</a></li>";
}  ?>
<li>24/7 Customer Service (800) 927-7671</li>

</ul>
</div>
</div>
<div class="top-header">
<div class="logo-header">
<a href="<?php echo site_name; ?>/index.php"><img src="<?php echo site_name; ?>/img/logo.png" class="logo"  ></a>
</div>


<div class="searchtext">
<form action="<?php echo site_name ?>/search.php" >

<input type="txt" type="search" class="search" name="search" placeholder="Search.." />
<input type="button" value="Search" class="search-button">
</form>
</div>
<div class="shopping-cart">
<a id="viewCart" href="<?php echo site_name ?>/my_cart.php" ><img src="<?php echo site_name ?>/img/mycart.png"></a>
</div>
</div>
<div class="main-nav-top">
<nav class="nav-top">
<ul>
<li class="<?php echo $ha; ?>"><a href="<?php echo site_name ?>/">Home</a></li>
<li class="<?php echo $ma; ?>"><a href="http://<?php echo $_SERVER['SERVER_NAME']. site_name ?>/man.php">Man</a></li>
<li class="<?php echo $wo; ?>"><a href="<?php echo site_name ?>/woman.php">Woman</a></li>
<li class="<?php echo $gi; ?>"><a href="<?php echo site_name ?>/girls.php">Girls</a></li>
<li class="<?php echo $bo; ?>"><a href="<?php echo site_name ?>/boys.php">Boys</a></li>
<li class="<?php echo $ba; ?>"><a href="<?php echo site_name ?>/baby.php">Baby</a></li>
<li class="<?php echo $ca; ?>"><a href="<?php echo site_name ?>/contact.php">Contact</a></li>

</ul>

</nav>
</div>
</header>
<?php 



?>

