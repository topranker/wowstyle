
<!-- main header --!>
<?php 
$bo = "active";
?>
<?php  include 'head.php' ; ?>
<?php  include $_SERVER["DOCUMENT_ROOT"] . site_name.'/menu.php' ; ?>

<?php 




?>

<!-- body -->

<!-- latest clothes -->
<?php  include $_SERVER["DOCUMENT_ROOT"] . site_name.'/lastclothes.php' ; ?>


<div class="left" > 

<h1>Clothes for Boys</h1>



<div >
 

<?php
$product_name = "";
if ($prep_stmt = "SELECT p.id , p.product_name , p.price , p.quantity , p.product_color , p.size , p.gender ,p.category , i.product_id , i.images_path 
FROM products as p , images_tbl as i where p.id = i.product_id and (SUBSTRING_INDEX(SUBSTRING_INDEX(p.gender, ',', 1), ',', -1) = 'boys' or SUBSTRING_INDEX(SUBSTRING_INDEX(p.gender, ',', 2), ',', -1) = 'boys' or SUBSTRING_INDEX(SUBSTRING_INDEX(p.gender, ',', 3), ',', -1) = 'boys' or SUBSTRING_INDEX(SUBSTRING_INDEX(p.gender, ',', 4), ',', -1) = 'boys' OR SUBSTRING_INDEX(SUBSTRING_INDEX(p.gender, ',', 5), ',', -1) = 'boys' OR SUBSTRING_INDEX(SUBSTRING_INDEX(p.gender, ',', 6), ',', -1) = 'boys') ORDER by id DESC LIMIT 12");
$stmt = $mysqli->prepare($prep_stmt);
if ($stmt) {

$stmt->execute();    // Execute the prepared query.
$stmt->store_result();
$stmt->bind_result($id , $product_name, $price, $quantity, $color , $size , $gender, $category, $product_id, $images_path);
		

while($row = $stmt->fetch()){

?>
<div class="products10" style="">
<div class="border"><a href="<?php echo site_name ?>/show.php?p-id=<?php echo $id ?>">
<h3><?php echo $product_name ?></h3>

<img src="<?php echo $images_path ?>"  alt="" ></br>
<a style="float:left">Category: <?php echo $category ?></a>
<a class="price">Price: <?php echo $price ?>$</a></a></br>
</div>
</div>

<?php 
}
}

?>
</div></br>


</div>

<!-- sidebar -->
<div class="right" > 

<?php  include $_SERVER["DOCUMENT_ROOT"] . site_name.'/sidebarheader.php' ; ?>


</div>




<!-- footer -->
<?php include $_SERVER["DOCUMENT_ROOT"] . site_name.'/footer.php' ; ?>