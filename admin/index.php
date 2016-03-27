
<!-- main header --!>
<?php 



$dir = preg_replace('/\b\w*admin\w*\b/i', '', trim( __DIR__));

?>

<?php  include_once $dir.'/head.php' ;  ?>
<?php  include $dir.'/menu.php' ; ?>

<?php
if(admin_login_check($mysqli) == false){
	header("location: admin_login.php");
	exit();
}

?>

<h1>Store Admin Arena</h1>
<!-- body -->

<!-- latest clothes -->



<!-- container -->
<div class="left" > 
<div class="leftProducts">
<p style="background-color:#E9E9E9">Welcome to your store <?php echo htmlentities($_SESSION['first_name']); ?>!</p></br>
<?php

$get = "";
$string = $_SERVER['QUERY_STRING'];

if ($prep_stmt = "SELECT name FROM category WHERE parent = 1 order by category_id");
$stmt = $mysqli->prepare($prep_stmt);
if ($stmt) {
$stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
$stmt->bind_result($name);

if ($stmt->num_rows > 0) {	
		while($row = $stmt->fetch()) {
			$i=0;
		if(preg_match_all("/(?<=-)(.*?)(?=-)/s", $string, $result)){
			if ($_SERVER['QUERY_STRING'] == "deleted-".$result[0][0]."-".$name){
				$_SESSION['deleted_category'] = "deleted-".$result[0][0]."-".$name;
				include_once $_SERVER["DOCUMENT_ROOT"] . site_name.'/admin/includes/add_categories.php';
		   break;
			}
}
	   $subcategory_names = get_all_subcategories_from_category_db($mysqli,$name);
       if ($_SERVER['QUERY_STRING'] == "new-category" || $_SERVER['QUERY_STRING'] == "change-".$name  ){
		   include_once $_SERVER["DOCUMENT_ROOT"] . site_name.'/admin/includes/add_categories.php';
		   break;
	   }
             if(preg_match_all("/(?<=-)(.*?)(?=-)/s", $string, $result)){
			 while (count($subcategory_names) > $i){
				 
			 if (preg_match("/(\r|\n|\t|\s)/", $subcategory_names[$i])){
				 
				 $subcategory_names[$i] = str_replace(" ","%20",$subcategory_names[$i]);
			 }
			 
				 if ($_SERVER['QUERY_STRING'] == "deleted/subcategory-".$result[0][0]."-".$subcategory_names[$i]) {
					 $_SESSION['deleted'] = "deleted/subcategory-".$result[0][0]."-".$subcategory_names[$i];
             include_once $_SERVER["DOCUMENT_ROOT"] . site_name.'/admin/includes/add_categories.php';
			 
			 break;
				 }
				 $i =$i+1;
			 }
			 }
			 
	   }
			}	
			
		}
$prod_id = get_all_products_id_db($mysqli);
$a=0;
while(count($prod_id) >$a){
	if ($_SERVER['QUERY_STRING'] == "show-products-".$a){
             
             include_once $_SERVER["DOCUMENT_ROOT"] . site_name.'/admin/includes/show_products.php';
		break;
	}
	if ($_SERVER['QUERY_STRING'] == "edit%20product-".$prod_id[$a]."-admin"){
             
             include_once $_SERVER["DOCUMENT_ROOT"] . site_name.'/admin/includes/edit.php';
		break;
	}
	$a+=1;
}

 if ($_SERVER['QUERY_STRING'] == "new-product"){
             
             include_once $_SERVER["DOCUMENT_ROOT"] . site_name.'/admin/includes/register_products.php';
    } else if ($_SERVER['QUERY_STRING'] == "new-category"){
             
             include_once $_SERVER["DOCUMENT_ROOT"] . site_name.'/admin/includes/add_categories.php';
    } else if ($_SERVER['QUERY_STRING'] == "show-products"){
             
             include_once $_SERVER["DOCUMENT_ROOT"] . site_name.'/admin/includes/show_products.php';
		
	}else if ($_SERVER['QUERY_STRING'] == "show-users"){
             
             include_once $_SERVER["DOCUMENT_ROOT"] . site_name.'/admin/includes/show_users.php';
		
	}


?>
</div>


</div>


<!-- sidebar -->
<div class="right" > 
<div class="admin-menu-category">

<input type="button" name="admin-add-products" onClick="window.location.href = '?new-product';" value="New Product" class="admin-add-products" />
<input type="button" name="admin-add-category" value="New Category" onClick="window.location.href = '?new-category';" class="admin-add-category" />
<input type="button" name="admin-show-products" value="Show Products" onClick="window.location.href = '?show-products';" class="admin-show-products" />
<input type="button" name="admin-show-users" value="Show Users" onClick="window.location.href = '?show-users';" class="admin-show-users" />

</div>



</div>



<!-- footer -->
<?php include $_SERVER["DOCUMENT_ROOT"] . site_name.'/footer.php' ; ?>