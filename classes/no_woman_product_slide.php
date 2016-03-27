<div class="top-slideshow-no">
<?php


if ($prep_stmt = "SELECT p.id , p.product_name , p.price , p.quantity , p.product_color , p.size , p.gender ,p.category , i.product_id , i.images_path 
FROM products as p , images_tbl as i where p.id = i.product_id and (SUBSTRING_INDEX(SUBSTRING_INDEX(p.gender, ',', 1), ',', -1) != 'woman' and SUBSTRING_INDEX(SUBSTRING_INDEX(p.gender, ',', 2), ',', -1) != 'woman' and SUBSTRING_INDEX(SUBSTRING_INDEX(p.gender, ',', 3), ',', -1) != 'woman' and SUBSTRING_INDEX(SUBSTRING_INDEX(p.gender, ',', 4), ',', -1) != 'woman' and SUBSTRING_INDEX(SUBSTRING_INDEX(p.gender, ',', 5), ',', -1) != 'woman' and SUBSTRING_INDEX(SUBSTRING_INDEX(p.gender, ',', 6), ',', -1) != 'woman') ORDER by id DESC LIMIT 5");
$stmt = $mysqli->prepare($prep_stmt);

if ($stmt) {
$fig_id = 0;
$stmt->execute();    // Execute the prepared query.
$stmt->store_result();
$stmt->bind_result($id , $product_name, $price, $quantity, $color , $size , $gender, $category, $product_id, $images_path);

$limit=0; // create a int variable start from 0 to count the fetch from db
$nr = ""; //create a blank variable for taking the product_id and check if this id is fetched before;

while($row = $stmt->fetch()){
if($limit == 12){
		break;
	}

if($nr==$product_id) { //if the previows id is the sam with the actual id we continue to the next fetch
	
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
?>
</div>
