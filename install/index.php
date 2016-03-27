<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>install your website</title>
</head>

<body>
<?php
$Result = array('status' => 'error', 'message' => '');
function replace_in_file($FilePath, $OldText, $NewText)
{
    
    if(file_exists($FilePath)===TRUE)
    {
        if(is_writeable($FilePath))
        {
            try
            {
                $FileContent = file_get_contents($FilePath);
                $FileContent = str_replace($OldText, $NewText, $FileContent);
                if(file_put_contents($FilePath, $FileContent) > 0)
                {
                    $Result["status"] = 'success';
                }
                else
                {
                   echo $Result["message"] = 'Error while writing file';
                }
            }
            catch(Exception $e)
            {
                $Result["message"] = 'Error : '.$e;
            }
        }
        else
        {
            echo $Result["message"] = 'File '.$FilePath.' is not writable !';
        }
    }
    else
    {
        $Result["message"] = 'File '.$FilePath.' does not exist !';
    }
    return $Result;
}

$error = "";

if(isset($_POST['install'])) {

	if($_POST['host'] == "" || $_POST['db_username'] == "" || $_POST['db_password'] =="" || $_POST['db_name'] =="" || $_POST['site_name']==""){
		$error = "All filed are required!";
		echo "<script>setTimeout(function() { alert('$error'); }, 1); </script>";
	} else {
	if ($error==""){
	$Result = replace_in_file("../config/psl-config.php", "localhost", $_POST['host']);
	if($Result['status'] == "success"){	
	replace_in_file("../config/psl-config.php", "root", $_POST['db_username']);
	replace_in_file("../config/psl-config.php", "pass", $_POST['db_password']);
	replace_in_file("../config/psl-config.php", "db_name", $_POST['db_name']);
	replace_in_file("../config/psl-config.php", "/site_name", $_POST['site_name']);
	$dbconn = mysql_connect($_POST['host'],$_POST['db_username'],$_POST['db_password']);
mysql_select_db($_POST['db_name'],$dbconn);

$file = 'users.sql';

if($fp = file_get_contents($file)) {
  $var_array = explode(';',$fp);
  foreach($var_array as $value) {
    mysql_query($value.';',$dbconn);
  }

}
echo "<script>alert(".$Result['status']."', your website is now installed')<script>";	
	}else {
echo "<script>setTimeout(function() { alert('gabim ".$Result['status']."'); }, 1); </script>";
}
	}
} 
} 
?>

<style>
body {
	width:80%;
	margin:10%;
	margin-top:5%;
	background-color:#CBCBCB;
}

.install-form {
	background-color:#FF0004;
	padding:3%;
	padding-left:10%;
}

.install-form input {
	margin-bottom:10px;
	height:30px;
	width:300px;
}
</style>
<a>Remember you can install your website just once!</a></br>

<h1>Instalation form:</h1>
<a>The default email:admin@gmail.com and password:Admin1</a>
<form class="install-form" method="post" action="">
<input type="text" name="host">Localhost</br>
<input type="text" name="db_username">DB username</br>
<input type="password" name="db_password">DB password</br>
<input type="text" name="db_name">DB name</br>
<input type="text" name="site_name" value="" > if this is a parent diractory write the name of the directory.example:(yoursite.com/diractory) you write "/diractory" else leve it blank </br>
<input  type="submit" name="install" value="install" >
</form>
</body>
</html>
