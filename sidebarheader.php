<div class="subscribe-div">
<?php 
$subscribe_yes = false;
$subscribe_no = true;
 include 'subscribe.php' ;?> 
<form class="subscribe" method="post" action="" >
<input class="subscribe-input" type="email"  placeholder="Subscribe.." name="email"  /> </br>
<input class="subscribeButton" name="subscribe" type="submit"  value="Subscribe"  />
</form>
<?php 
if ($subscribe_no == false){
	echo "<script>setTimeout(function() { alert('There was a problem with your email!'); }, 1); </script>";
	
}

if($subscribe_yes == true) {
	echo "<script>setTimeout(function() { alert('Your e-mail has been added to our mailing list! Thank you'); }, 1);</script>";
}
?>
</div>

<div class="sidebarheader"> <h3> Latest Clothes: </h3></div>
<?php
$product_name = "";
if ($prep_stmt = "SELECT p.id , p.product_name , p.price , p.quantity , p.product_color , p.size , p.gender ,p.category , i.product_id , i.images_path 
FROM products as p , images_tbl as i where p.id =i.product_id  ORDER by id DESC ");
$stmt = $mysqli->prepare($prep_stmt);
if ($stmt) {

$stmt->execute();    // Execute the prepared query.
$stmt->store_result();
$stmt->bind_result($id , $product_name, $price, $quantity, $color , $size , $gender, $category, $product_id, $images_path);
$limit=0;
$nr = "";
while($row = $stmt->fetch()){
	if($limit == 5){
		break;
	}

if($nr==$product_id) {
	
continue;	
}

?>
<div>



<div class="sidebarbody">
<ul>
<?php  ?>
<li ><a href="<?php echo site_name ?>/show.php?p-id=<?php echo $id; ?>"> <img src="<?php echo $images_path; ?>" /> <p><?php echo $product_name;?></p> </a></li>
</ul>


</div>



</div>
<?php $nr=$product_id; ++$limit; 
}
}

?>


