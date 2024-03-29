<?php
include_once 'includes/register.inc.php';
include_once $_SERVER["DOCUMENT_ROOT"] . site_name.'/classes/functions.php';
?>

        <!-- Registration form to be output if the POST variables are not
        set or if the registration script caused an error. -->
        <h1>Register with us</h1>
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>
        <ul>
            <li>Usernames may contain only digits, upper and lowercase letters and underscores</li>
            <li>Emails must have a valid email format</li>
            <li>Passwords must be at least 6 characters long</li>
            <li>Passwords must contain
                <ul>
                    <li>At least one uppercase letter (A..Z)</li>
                    <li>At least one lowercase letter (a..z)</li>
                    <li>At least one number (0..9)</li>
                </ul>
            </li>
            <li>Your password and confirmation must match exactly</li>
        </ul>
        <form action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" method="post"  name="registration_form">
        	<input type='text' name='firstName' id='firstName' />:First Name*<br>
            <input type='text' name='lastName' id='lastName' />:Last Name*<br>
            <input type='text' name='username' id='username' />:Username*<br>
             <input type="text" name="email" id="email" />:Email*<br>
             <input type="password" name="password" id="password"/>:Password*<br>
             <input type="password" name="confirmpwd" id="confirmpwd" />:Confirm password*<br>
             

            <input type="button" 
                   value="Register" 
                   onclick="return regformhash(this.form,
                   					this.form.firstName,
                                    this.form.lastName,
                                   this.form.username,
                                   this.form.email,
                                   this.form.password,
                                   this.form.confirmpwd);" /> 
        </form>
        <p style="margin-top:20px">Return to the <a href="login.php" style="color:red">login page</a>.</p>
 