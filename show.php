

<!-- main header --!>
<?php 

?>
<?php  include 'head.php' ; ?>
<?php  include 'menu.php' ; ?>

<?php 




?>

<!-- body -->

<!-- latest clothes -->



<div class="left" > 


<style>
/* show product images slideshow css start
*/
section {
	
	
}
.container {
  max-width: 300px;
  
  margin: 0 auto;
  text-align: center;
  position:absolute;
}
.container div {
 
  width: 100%;
  display: inline-block;
  display: none;
}
.container img {
  width: 100%;
  height: auto;
}

.show-product .body button {
	position:relative;
	margin-right:50px;
	background-color:#FFFFFF;
	width:80px;
}

.next {
  right: 5px;
}

.prev {
  left: 5px;
}
/* show product images slideshow css end
*/
</style>


 

<?php

$id_findet = 0;
$ids = getProductsID($mysqli);
$i = count($ids);

while ($i > -1) {
	if ($_SERVER['QUERY_STRING'] == "p-id=".$ids[$i]){
            $id_findet = $ids[$i];             
}
$i = $i-1;
}

 if ( $query = ("UPDATE products SET clicks = clicks + 1 WHERE id = ? "));
    $stmt = $mysqli->prepare($query);
$stmt->bind_param('s', $id_findet);
if ($stmt) {
$stmt->execute();    // Execute the prepared query.
$stmt->fetch();
}


$product_name = "";
if ($prep_stmt = "SELECT p.id , p.product_name , p.price , p.quantity, p.details , p.product_color , p.size , p.gender ,p.category , p.clicks, i.product_id , i.images_path 
FROM products as p , images_tbl as i where p.id = i.product_id and p.id = ?");
$stmt = $mysqli->prepare($prep_stmt);
$stmt->bind_param('s', $id_findet);
if ($stmt) {

$stmt->execute();    // Execute the prepared query.
$stmt->store_result();
$stmt->bind_result($id , $product_name, $price, $quantity, $details, $color , $size , $gender, $category, $clicks, $product_id, $images_path);

$nr = "";
?>
<div class="show-product" style="">
<div class="body">
<section class="product_images_slide">

  
<?php
$imgpath= array();
$c=0;
while($row = $stmt->fetch()){
$imgpath[$c]= $images_path;

?>
<div class="thumbnail">
<div class="image"><a>
<div class="container">
    <div style="display: inline-block;">
      <img src="<?php echo $images_path; ?>"  alt="" >
      <button class="prev">Previous</button>
<button class="next">Next</button>
    </div>
    
  </div>
  </a></div></div>
<?php
}
}
?>

</section>
<a class="category" style="float:left"><strong>Category: </strong><?php echo $category; ?></a>
<a class="clicks"><strong>Clicks: </strong><?php echo $clicks; ?></a></br>

<div class="details">
<h3><?php echo $product_name ?></h3>

<a class="price"><strong>Price: </strong><?php echo $price ?>$</a></br>
<a class="quantity"><strong>Quantity: </strong><?php echo $quantity ?></a></br>
<a class="size"><strong>Size: </strong><?php echo $size ?></a></br>
<a class="gender"><strong>Gender: </strong><?php echo $gender ?></a></br>
<a class="details"><strong>Details: </strong><?php echo $details ?></a></br>

</div>
</div>
</div>

<?php 






?>

</div></br>
<script>
// slideshow finctions start from here :

var currentIndex = 0,
  items = $('.container div'),
  itemAmt = items.length;

function cycleItems() {
  var item = $('.container div').eq(currentIndex);
  items.hide();
  item.css('display','inline-block');
}

var autoSlide = setInterval(function() {
  currentIndex += 1;
  if (currentIndex > itemAmt - 1) {
    currentIndex = 0;
  }
  cycleItems();
}, 3000);

$('.next').click(function() {
  clearInterval(autoSlide);
  currentIndex += 1;
  if (currentIndex > itemAmt - 1) {
    currentIndex = 0;
  }
  cycleItems();
});

$('.prev').click(function() {
  clearInterval(autoSlide);
  currentIndex -= 1;
  if (currentIndex < 0) {
    currentIndex = itemAmt - 1;
  }
  cycleItems();
});

// slideshow functions end here
</script>
</div>

<!-- sidebar -->
<div class="right" > 

<?php  include 'sidebarheader.php' ; ?>


</div>




<!-- footer -->
<?php include 'footer.php' ; ?>
