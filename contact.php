
<!-- main header --!>
<?php 
$ca = "active";
?>
<?php  include __DIR__. '/head.php' ; ?>
<?php  include $_SERVER["DOCUMENT_ROOT"] . site_name.'/menu.php' ; ?>

<?php 


$ca = "active";



?>

<!-- body -->

<!-- latest clothes -->
<?php  include $_SERVER["DOCUMENT_ROOT"] . site_name.'/lastclothes.php' ; ?>




<div class="left" > 

<?php
 	
	if (isset($_POST["contact"])) {
		
		
		$firstName = $_POST['first-name'];
		$lastName = $_POST['last-name'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$message = $_POST['message'];
		
		$from = 'Demo Contact Form'; 
		$to = 'vilsonisaku93@gmail.com'; 
		$subject = 'Message from wow clothes Contact ';
		$error = '';
		$body ="From: $firstName\n E-Mail: $email\n Message:\n $message";
		// Check if name has been entered
		if (!$_POST['first-name']) {
			
			echo $error = 'Please enter your first name';
		} else {
		
		if (!$_POST['last-name']) {
			echo $error = 'Please enter your last name';
			} else {
				// Check if email has been entered and is valid
				if (!$_POST['email'] || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
				echo $error = 'Please enter a valid email address';
				}else {
					//Check if message has been entered
							if (!$_POST['message']) {
							echo $error = 'Please enter your message';
						}
				}
			}
		}
		
		
		
		
		
// If there are no errors, send the email
if ($error==='') {
	if (mail ($to, $subject, $body, $from)) {
		echo $result='<div  style=" background-color:#65FF59; margin:10px; font-size:20px" >Thank You! Your message was successfully sent</div>';
	} else {
		echo $result='<div class="alert alert-danger">Sorry there was an error sending your message. Please try again later.</div>';
	}
}

	}
	
?>


  <div class="contact-body"> 
    <label  class="required-form">All fields marked with * are required</label>
    <form class="contact-form" method="post"  action="">
    <div class="first-name-form" >
    <input type="text" name="first-name"  placeholder="first name">
    <label class="label1">*First Name</label>
    
    </div>
    
    <div class="last-name-form" >
    <input type="text" name="last-name" placeholder="last name" />
    <label class="label2">*Last Name</label>
    
    </div>
   
    
    <div class="email-form" >
    <input type="text" name="email" placeholder="your email" />
    <label class="label3">*Email</label>
    
    </div>
  
    
    <div class="phone-form" >
    <input type="tel" name="phone" placeholder="phone number" />
    <label class="label4"> Phone</label>
    
    </div>

    
    <div class="text-form" >
    <label class="label5">Message*</label>
    <textarea rows="8" cols="50" name="message" placeholder="write your message" ></textarea>
    </div>
  
    
    <div  >
    <input type="submit" name="contact" value="Send Message" class="send-form" >
    
    </div>
    </form>
    
  </div>


</div>

<!-- sidebar -->
<div class="right" > 

<?php  include $_SERVER["DOCUMENT_ROOT"] . site_name.'/sidebarheader.php' ; ?>


</div>




<!-- footer -->
<?php include $_SERVER["DOCUMENT_ROOT"] . site_name.'/footer.php' ; ?>
<script type="text/javascript">
$(function() {
	$( "#Button1" ).button(); 
});
</script>
