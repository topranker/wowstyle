
<!-- main header --!>
<?php 
$la = "active";
?>
<?php  include  'head.php' ; ?>
<?php  include $_SERVER["DOCUMENT_ROOT"] . site_name.'/menu.php' ; ?>

<?php 




?>

<!-- body -->

<!-- latest clothes -->
<?php  include $_SERVER["DOCUMENT_ROOT"] . site_name.'/lastclothes.php' ; ?>


<div class="left" > 
<div class="register-body">
<?php  include $_SERVER["DOCUMENT_ROOT"] . site_name.'/users/register.php' ; ?>
</div>
</div>

<!-- sidebar -->
<div class="right" > 

<?php  include $_SERVER["DOCUMENT_ROOT"] . site_name.'/sidebarheader.php' ; ?>


</div>



<!-- footer -->
<?php include $_SERVER["DOCUMENT_ROOT"] . site_name.'/footer.php' ; ?>