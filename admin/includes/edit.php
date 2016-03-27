<?php
echo "u kry";
?>
<form method="post" action="?<?php echo $_SERVER['QUERY_STRING']?>">
<?php

	echo $_SESSION['get_product_id'];
	
	$a = 3;
$b = doSomething( $a, 5 );
echo " |".$a."/".$b;

?>
<input type="text" name="pname">Product name
<input type="submit" name="submit" value="Update">
</form>