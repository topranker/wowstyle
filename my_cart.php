
<!-- main header --!>


<?php 


?>
<?php  include 'head.php' ; ?>
<?php  include 'menu.php' ; ?>

<?php 




?>
<!-- body -->




<!-- container -->
<div class="left" > 
<div class="leftProducts">
<div style="padding:5px">
<?php if (user_login_check($mysqli) == true){

 include 'users/mycart.php' ;

} else if (admin_login_check($mysqli)){
	
} else {
	echo "you need to login to view your cart!";
	?>
 <div class="login-body">

 <form action="<?php echo site_name ?>/users/includes/process_login.php" method="post" name="login_form">                      
       <input type="text" name="email" /> :Email </br>
       <input type="password"  name="password" id="password"/> :Password </br>
       <input type="button" value="Login" class="send-form" onclick="formhash(this.form, this.form.password);" /> 
 </form>


</div>
<?php 
}
?>
</div>
</div>


</div>


<!-- sidebar -->
<div class="right" > 


          
            
            
       
           
        
<?php  include $_SERVER["DOCUMENT_ROOT"] . site_name.'/sidebarheader.php' ; ?>

</div>



<!-- footer -->
<?php include $_SERVER["DOCUMENT_ROOT"] . site_name.'/footer.php' ; ?>
