<?php
if(isset($_POST["register"])) {
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["picture"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image

    $check = getimagesize($_FILES["picture"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
?>

<div class="register-body">
<h1>Register Now</h1>
<form method="post" action="" >
<div class="first-last-name-register">
<input type="text" name="first-name" >
<label>First Name</label></br>
<input type="text" name="last-name" >
<label>Last Name</label></br>
</div>
<input type="text" name="username">
<label>Username</label></br>
<input type="text" name="email">
<label>Email</label></br>
<input type="password" name="password" >
<label>Password</label></br>
<input type="date" name="date">
<label>Your Birthday</label></br>
<p>
  <label>
    <input type="radio" name="gender" value="male" id="gender_0">
    male</label>
  <br>
  <label>
    <input type="radio" name="gender" value="female" id="gender_1">
    female</label>
  <br>
</p>
<label style="font-size:14px">Select image to upload</label>
<input style="font-size:14px" type="file" name="picture"></br>

<input type="submit" name="register" class="send-form">
</form>
</div>