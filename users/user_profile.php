
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
<h1> Thank you for registering with wowstyle</h1></br>
<div class="first-user-boks-info">
<a href="<?php echo site_name ?>/users/user_details.php"><input class="change-your-details" type="button" value="Change details"></a>
</div>

<div class="dashboard-box strong">
				<div class="dashboard-box-heading">Available Store Credit</div>
				<div class="dashboard-box-value cfont">
					
						$0.00
					
				</div>
		</div>
</div>
</div>



</div>


<!-- sidebar -->
<div class="right" > 


           
            
            
       
           
        
<?php  include $_SERVER["DOCUMENT_ROOT"] . site_name.'/sidebarheader.php' ; ?>

</div>



<!-- footer -->
<?php include $_SERVER["DOCUMENT_ROOT"] . site_name.'/footer.php' ; ?>