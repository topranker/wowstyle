
<?php  
$dir = preg_replace('/\b\w*admin\w*\b/i', '', trim( __DIR__));
include_once $dir . '/head.php' ; 
include $dir.'/menu.php' ; 
?>

<div style="background-color:#F30004; padding:20px;">
<?php
$error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);
 
if (! $error) {
    $error = 'Oops! An unknown error happened. <a style="color:#ffffff" href="'.site_name.'/admin/index.php">return back</a>';
}
?>


    
        <h1>There was a problem inserting data to database</h1>
        <p class="error"><?php echo $error; ?></p>  
 </div>
<!-- footer -->
<?php include $_SERVER["DOCUMENT_ROOT"] . site_name.'/footer.php' ; ?>