
<?php

$error="";

if(isset($_POST['product_name'],$_POST['price']) ){
	
	if($_POST["product_name"] == "" || $_POST["price"] == "" || $_POST["size"] == "" || $_POST["details"] == "" || $_POST["categories"] == "" || $_POST["subcategories"] == "" || $_POST["quantity"] == "" ) {
		$error .= "All field are required! ";
		echo $error;
	}

$product_name = $_POST["product_name"];
$price = $_POST["price"];
$size = $_POST["size"];
$details = $_POST["details"];
$categories = $_POST["categories"];
$subcategories = $_POST["subcategories"];
$product_color = $_POST["product_color"];
$quantity = $_POST["quantity"];


$gender = "";
if (empty($_POST['product_gender']) && !isset($_POST['product_gender'])) {
	$error = "please select gender of product!";
} else {
foreach($_POST['product_gender'] as $item){
  $gender .= $item . ",";
}

}
$date = date("Y-m-d H:i:s");
if (empty($_FILES["uploadedimage"]["name"])) {
	$error = "No image selected!";
}


if($error == ""){
	

	

if ($insert_stmt = $mysqli->prepare("INSERT INTO products (product_name, price, quantity, product_color, size, gender ,  details, category, subcategory, date_added) VALUES (?, ?, ?, ?,?,?,?,?,?,?)")){
$insert_stmt->bind_param('ssssssssss', $product_name, $price, $quantity, $product_color, $size, $gender, $details, $categories, $subcategories, $date);

if (! $insert_stmt->execute()) {
                header('Location:' .site_name.'/admin/error.php?err=products insert failure: INSERT');
            }

}
if ($stmt = $mysqli->prepare("SELECT id FROM products WHERE date_added = ?")) {

$stmt->bind_param('s', $date);
$stmt->execute();    // Execute the prepared query.
  $stmt->store_result();
if ($stmt) {
$stmt->bind_result($id);
$stmt->fetch();
}
}

$myFiles=$_FILES["uploadedimage"];
	$temp_name=$_FILES["uploadedimage"];
	$fileCount = count($myFiles["name"]);
	
	
	
	for($i=0; $i<$fileCount; $i++){
		$imgtype=$myFiles["type"][$i];
		
	$ext= GetImageExtension($imgtype);
		$imagename=$i."id".date("d-m-Y")."-".time().$ext;
		$target_path = "../product_images/".$imagename;
	$getTargetPath = site_name."/product_images/".$imagename;
if(move_uploaded_file($myFiles["tmp_name"][$i], $target_path)) {
	if ($insert_stmt = $mysqli->prepare("INSERT into images_tbl (product_id, images_path, submission_date) VALUES (?, ?, ?)")){
$insert_stmt->bind_param('sss', $id , $getTargetPath, date("Y-m-d"));

if (! $insert_stmt->execute()) {
                header('Location:' .site_name.'/admin/error.php?err=products insert failure: INSERT');
            }

}
}
}


	 
	 
	 



//upload image finish

echo "<h1 style='color:green'>Your product is now added to our database</h1>";
}
}


?>


<div class="register_products_form">
<div style=" background-color:#FFC38E" class="left_half" >

<form method="post" class="products_form" action="?new-product" enctype="multipart/form-data">
<input id="productName" type="text" value="<?php if(isset($_POST['product_name'])){ echo $_POST['product_name']; }?>" name="product_name">:Product Name</br>
<input type="number" value="<?php echo $_POST['price'] ?>" name="price">:Price</br>
<input type="number" value="<?php echo $_POST['quantity'] ?>" name="quantity">:quantity</br>
<input type="color" value="<?php echo $_POST['product_color'] ?>" class="product_color" name="product_color">:Product color</br>
<select name="size" >
<option></option>
<option <?php if (isset($_POST['size'])) { if($_POST['size'] == 'xs'){ ?>selected="true" <?php }}; ?>value="xs">XS</option>
<option <?php if (isset($_POST['size'])) { if($_POST['size'] == 's'){ ?>selected="true" <?php }}; ?>value="s">S</option>
<option <?php if (isset($_POST['size'])) { if($_POST['size'] == 'm'){ ?>selected="true" <?php }}; ?>value="m">M</option>
<option <?php if (isset($_POST['size'])) { if($_POST['size'] == 'l'){ ?>selected="true" <?php }}; ?>value="l">L</option>
<option <?php if (isset($_POST['size'])) { if($_POST['size'] == 'xl'){ ?>selected="true" <?php }}; ?>value="xl">XL</option>
</select>:size </br>
<div class="product_gender">
<p>

  <div class="gender_1">
    <input  type="checkbox" name="product_gender[]" value="man" id="product_gender_0">Man</div>
  
  <div class="gender_2">
    <input type="checkbox" name="product_gender[]" value="woman" id="product_gender_1">
    Woman</div>
  
  <div class="gender_3">
    <input type="checkbox" name="product_gender[]" value="girls" id="product_gender_2">
    Girls</div>
    
    <div class="gender_3">
    <input type="checkbox" name="product_gender[]" value="boys" id="product_gender_2">
    Boys</div>
    
    <div class="gender_3">
    <input type="checkbox" name="product_gender[]" value="baby" id="product_gender_2">
    Baby</div>
    
    <div class="gender_3">
    <input type="checkbox" name="product_gender[]" value="other" id="product_gender_2">
    Other</div>
  
</p></div><br>
<input type="file" name="uploadedimage[]" multiple >:Select product images</br>

<textarea rows="10" cols="45" name="details" placeholder="write your product details here..."><?php if (isset($_POST['details'])) { echo $_POST['details'];} ?></textarea><label>:Details</label></br>
<select name="categories" value="<?php echo $_POST['categories'] ?>" onChange="this.form.submit()">
<option></option>
<?php
if ($prep_stmt = "SELECT name FROM category WHERE parent = 1");
$stmt = $mysqli->prepare($prep_stmt);
if ($stmt) {
$stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
$stmt->bind_result($name);
if ($stmt->num_rows > 0) {	

		while($row = $stmt->fetch()) {
			?>
            <option <?php if (isset($_POST['categories'])) { if($_POST['categories'] == $name){ ?>selected="true" <?php }}; ?>value= <?php echo $name ?>><?php echo $name ?></option>
            <?php
        
			}	
			$stmt -> close();
		}
}
?>
</select>:category </br>
<select name="subcategories" >
<option></option>
<?php

if(isset($_POST['categories'])){
	$error_subcategory = "";
	$selected_category = $_POST['categories'];
	
	
	if ($_POST['categories'] == ""){
		$error_subcategory = "<a style='color:red'>your category is not selected </a>";	
	}
	if ($error_subcategory == ""){
	if ($stmt = $mysqli->prepare("SELECT name FROM category WHERE parent = (select category_id from category where name = ?)"));

$stmt->bind_param('s', $selected_category);
$stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
		 $stmt->bind_result($getsubcategory);
		while($row = $stmt->fetch()) {
        echo "<option>" . $getsubcategory ."</option>";
			}	
			$stmt -> close();
	}
}

?>
</select>:subcategory</br>

<input type="submit" value="Add Product" class="add_this_product" name="add_this_product">
</form>
</div>




</div>