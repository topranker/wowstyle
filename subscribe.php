<?php

if(isset($_POST['subscribe'])){
	$to = "vilsonisaku93@gmail.com";
$from = "no-reply@wowstyle.com";

$headers = "From: " . $from . "\r\n";

$subject = "New subscription";
$body = "New user subscription: " . $_POST['email'];


if( filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) )
{ 
    if (mail($to, $subject, $body, $headers, "-f " . $from))
    {
        
		$subscribe_yes = true;
    }
    else
    {
		$subscribe_no = false;
       
	    
    }
}
else
{
	$subscribe_no = false;
	
}
	
}

?>