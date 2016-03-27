<?php

 
echo "Show Products";
$prod_id = get_all_products_id_db($mysqli);
$x=25;
$y=1;
$p=0;
$k=1;
while(count($prod_id) > $x){
	
	$x+=25;
	$y+=1;
}
if ((count($prod_id) - $x) != 0) {
	
}


?>
<div class="show-products">
<div class="show-top">

<ul class="top">
<li class="name"><input type="button"  value="Products Name"></li>
<li class="category"><input type="button"  value="Category"></li>
<li class="Quantity"><input type="button"  value="Quantity"></li>
<li class="price"><input type="button"  value="Price"></li>
<li class="clicks"><input type="button"  value="Clicks"></li></ul></br></br>
<?php
if(isset($_POST['hidden'])){
	$hidden_id = $_POST['hidden'];
if(delete_product($mysqli, $hidden_id)){
}
}

if(isset($_POST['edit'])){
	if(!$_POST['edit'] == ""){
$_SESSION['get_product_id'] = $_POST['edit'];
header("Location: ?edit product-".$_POST['edit']."-admin");
	}
}

$products = get_all_products_from_db($mysqli, 0,25);
while (count($prod_id) > $p){
 if ($_SERVER['QUERY_STRING'] == "show-products-".$p){
       $k=$p;   
	   $products = get_all_products_from_db($mysqli, 2,$k*2);
	   break;   
    }
	$p+=1;
}

echo "<form method='post' name='del_edit_form' action='?show-products'>";
echo"<input type='hidden' name='hidden' value=''>";
echo"<input type='hidden' name='edit' value=''>";
$i=0;
while (count($products[0]) > $i){
	?>
    <a href='#' id="a" onclick='return getProductId(<?php echo $products[5][$i] ?>);'><img src='../img/DeleteRed.png' width='20px'></a>
    <a id="a" onclick='return post_hidden_value(<?php echo $products[5][$i] ?>);' href='#' ><img src='../img/product_edit.png' width='20px'></a>
    <li class='p-name'><?php echo $products[0][$i]?>
    <li class='p-category'><?php echo $products[1][$i] ?></li>
	<li><?php echo $products[2][$i] ?></li>
	<li><?php echo $products[3][$i] ?>$</li>
	<li><?php echo $products[4][$i] ?></li></ul>
	</br></br>
	<?php $i+=1; } ?>
</form>
	


</div>
<div class="change">
<?php
 $u=$k;
while ($y-1 >= $k){
	echo "<a href='?show-products-".$k."'><input type='button' value='".$k."'></a>";
	$k+=1;
	if ($k == $u+20){
		echo "...";
		break;
	}
	
}


?>
</div>
</div>