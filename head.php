<?php 

include 'config/db_connect.php' ;
include  'classes/functions.php' ;

sec_session_start();
if (admin_login_check($mysqli) == true || user_login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
<!DOCTYPE html>
<html>
<head>
<title>wow clothes</title>

<link rel="stylesheet" type="text/css" href="<?php echo site_name ?>/css/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo site_name ?>/css/slide.css">
<link rel="stylesheet" type="text/css" href="<?php echo site_name ?>/css/contact-form.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<link href="<?php echo site_name ?>/jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo site_name ?>/jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css">
<link href="<?php echo site_name ?>/jQueryAssets/jquery.ui.button.min.css" rel="stylesheet" type="text/css">
<script src="<?php echo site_name ?>/jQueryAssets/jquery-1.11.1.min.js" type="text/javascript"></script>
<script src="<?php echo site_name ?>/jQueryAssets/jquery.ui-1.10.4.button.min.js" type="text/javascript"></script>
<script src="<?php echo site_name ?>/admin/js/sha512.js" type="text/javascript"></script>
<script src="<?php echo site_name ?>/admin/js/forms.js" type="text/javascript"></script>
<script src="<?php echo site_name ?>/admin/js/functions.js" type="text/javascript"></script>
</head>

<body>
<div class="wrapper">
