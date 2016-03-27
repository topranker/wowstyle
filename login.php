
<!-- main header --!>
<?php 
$la = "active";
?>
<?php  include 'head.php' ; ?>
<?php  include 'menu.php' ; ?>

<?php 




?>

<!-- body -->

<!-- latest clothes -->



<div class="left" > 

<div class="login-body">
<?php 

if (user_login_check($mysqli) == true) {
	header('Location: index.php');
                        
        } else {
                        
						echo '<h1 style="margin:10px">Login to start your activity</h1>';
                        
?>     
<?php

		if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
   
echo "<p>If you don't have a login, please <a style='color:red' href='register.php'>register</a></p>";
  }  //this close the login_check
  
  if ($logged == 'out') {
?>

<div class="login-body">

 <form action="<?php echo site_name ?>/users/includes/process_login.php" method="post" name="login_form">                      
           <input type="text" name="email" /> :Email </br>
            <input type="password"  name="password" id="password" action="formhash(this.form, this.form.password);" /> :Password </br>
            <input type="button" 
                   value="Login" class="send-form" 
                   onclick="formhash(this.form, this.form.password);" /> 
        </form>


</div>
<?php } 
?>


</div>


</div>

<!-- sidebar -->
<div class="right" > 

<?php  include 'sidebarheader.php' ; ?>


</div>



<!-- footer -->
<?php include 'footer.php' ; ?>
