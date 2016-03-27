
<!-- main header --!>
<?php 


$la = "active";
?>
<?php  include_once '../head.php' ; ?>
<?php  include_once '../menu.php' ; ?>
<script type="text/javascript">
    document.title = "Admin login"
</script>
<?php 

if (admin_login_check($mysqli) == true) {
	header('Location: index.php');
                        
        } else {
                        
						echo '<h1 style="margin:10px">Login as admin to start your activity</h1>';
                        
?>      



<!-- body -->

<!-- latest clothes -->



<div class="left" > 
<?php

		if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
if ($logged == 'out') {   
echo "<p>If you don't have a login, please <a style='color:red' href='register.php'>register</a></p>";
  }  //this close the login_check
  
  
?>

<div class="login-body">
<h1>Login</h1>
 <form action="<?php echo site_name ?>/admin/includes/process_login.php" method="post"  name="login_form">                      
           <input type="text" name="email" /> :Email </br>
            <input type="password"  name="password" id="password" /> :Password </br>
            <input type="button" 
                   value="Login" class="send-form"
                   onclick="formhash(this.form, this.form.password);" /> 
        </form>


</div>
<?php } 
?>

</div>

<!-- sidebar -->
<div class="right" > 




</div>



<!-- footer -->
<?php include '../footer.php' ; ?>
