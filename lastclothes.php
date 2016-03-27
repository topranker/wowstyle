<div class="top-slideshow">

<?php
$prod_id = array();

if ($prep_stmt = "SELECT p.id , p.product_name , p.price , p.quantity , p.product_color , p.size , p.gender ,p.category , i.product_id , i.images_path 
FROM products as p , images_tbl as i where p.id = i.product_id  ORDER by id DESC");
$stmt = $mysqli->prepare($prep_stmt);

if ($stmt) {
$fig_id = 0;
$stmt->execute();    // Execute the prepared query.
$stmt->store_result();
$stmt->bind_result($id , $product_name, $price, $quantity, $color , $size , $gender, $category, $product_id, $images_path);

if($stmt->num_rows > 0){
	
$i=0;
$limit=0; // inicial the limit with zero
$nr = ""; //this is a variable usefull for copying the product_id
while($row = $stmt->fetch()){
$fig_id = $fig_id + 1;
$prod_id[$i] = $id;
if($limit == 7){  // we decide how mutch product we want to put 
		break;
	}

if($nr==$product_id) {  //check if the previows copied product to  $nr variable is the same with the actual product id and continue.
continue;	
}


?>

<div class="slide">
<figure class="fig-id<?php echo $fig_id ?>"><a href="<?php echo site_name ?>/show.php?p-id=<?php echo $id ?>"><img src="<?php echo $images_path ?>"  alt="" >
<div class="caption"><figcaption><a id="p-name"><?php echo $product_name ?></a><a id="category">Category: <?php echo $category ?></a>
<a id="price">Price: <?php echo $price ?>$</a></a></figcaption></div></figure>
</div>
<?php 
$i += 1;
$nr=$product_id;  ++$limit; 
}
}
}
$prod_id = array_filter($prod_id);

if (!empty($prod_id)) {
	
$_SESSION['latest_5_products_id_array'] =  $prod_id;
} else {
	$_SESSION['latest_5_products_id_array']= null;
}
?>


<div class="woman-products">
<?php
if (!empty($prod_id)) {
$in  = str_repeat('?,', count($prod_id) - 1) . '?';
$s = str_repeat('s', count($prod_id) - 1) . 's';
if ($prep_stmt = "SELECT p.id , p.product_name , p.price , p.quantity , p.product_color , p.size , p.gender ,p.category , i.product_id , i.images_path 
FROM products as p , images_tbl as i where p.id = i.product_id and (SUBSTRING_INDEX(SUBSTRING_INDEX(p.gender, ',', 1), ',', -1) = 'woman' or SUBSTRING_INDEX(SUBSTRING_INDEX(p.gender, ',', 2), ',', -1) = 'woman' or SUBSTRING_INDEX(SUBSTRING_INDEX(p.gender, ',', 3), ',', -1) = 'woman' or SUBSTRING_INDEX(SUBSTRING_INDEX(p.gender, ',', 4), ',', -1) = 'woman' OR SUBSTRING_INDEX(SUBSTRING_INDEX(p.gender, ',', 5), ',', -1) = 'woman' OR SUBSTRING_INDEX(SUBSTRING_INDEX(p.gender, ',', 6), ',', -1) = 'woman') and (p.id != ? and p.id != ? and p.id != ? and p.id != ? and p.id != ? and p.id != ? and p.id != ?) ORDER by id DESC ");
$stmt = $mysqli->prepare($prep_stmt);

$stmt->bind_param('sssssss', $prod_id[0] , $prod_id[1] , $prod_id[2], $prod_id[3], $prod_id[4], $prod_id[5], $prod_id[6]);
if ($stmt) {
$fig_id = 0;
$stmt->execute();    // Execute the prepared query.
$stmt->store_result();
$stmt->bind_result($id , $product_name, $price, $quantity, $color , $size , $gender, $category, $product_id, $images_path);
if($stmt->num_rows > 0){
$limit=0;
$nr = "";
while($row = $stmt->fetch()){
$fig_id = $fig_id + 1;
if($limit == 5){
		break;
	}

if($nr==$product_id) {
	
continue;	
}

?>

<div class="slide">
<figure class="fig-id<?php echo $fig_id ?>"><a href="<?php echo site_name ?>/show.php?p-id=<?php echo $id ?>"><img src="<?php echo $images_path ?>"  alt="" >
<div class="caption"><figcaption><a id="p-name"><?php echo $product_name ?></a><a id="category">Category: <?php echo $category ?></a>
<a id="price">Price: <?php echo $price ?>$</a></a></figcaption></div></figure>
</div>
<?php 
$nr=$product_id; ++$limit;
}
}
}
}
?>
</div>


</div>





