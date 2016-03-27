

<div >
 

<?php
$product_name = "";
if ($prep_stmt = "SELECT p.id , p.product_name , p.price , p.quantity , p.product_color , p.size ,p.category , i.product_id , i.images_path 
FROM products as p , images_tbl as i where p.id = i.product_id ORDER by id DESC LIMIT 12");
$stmt = $mysqli->prepare($prep_stmt);
if ($stmt) {

$stmt->execute();    // Execute the prepared query.
$stmt->store_result();
$stmt->bind_result($id , $product_name, $price, $quantity, $color , $size , $category, $product_id, $images_path);
		
$limit=0; // create a int variable start from 0 to count the fetch from db
$nr = ""; //create a blank variable for taking the product_id and check if this id is fetched before;


while($row = $stmt->fetch()){
if($limit == 5){
		break;
	}

if($nr==$product_id) { //if the previows id is the sam with the actual id we continue to the next fetch
	
continue;	
}
?>
<div class="products10" style="">
<div class="border"><a href="<?php echo site_name;?>/show.php?p-id=<?php echo $id; ?>">
<h3><?php echo $product_name ?></h3>

<img src="<?php echo $images_path ?>" alt="" ></br>
<a  style="float:left">Category: <?php echo $category ?></a>
<a class="price">Price: <?php echo $price ?>$</a></a></br>
</div>
</div>

<?php 
$nr=$product_id; ++$limit;
}

}

?>



</div></br>

