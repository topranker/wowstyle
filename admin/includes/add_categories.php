
<form method="post" name="post_site_name" action="?new-category">
<input type="hidden" id="txtName" name="txtName" readonly="readonly" />
      </form>
<?php
if(is_category_null($mysqli) === false){
if(add_this_category($mysqli,"your store name"));

} else {
if(isset($_POST['txtName'])){
if(update_this_category($mysqli,$_POST['txtName'],"parent is null"));
}
?>
<div style='color:green; background-color:grey; float:left; width:100%; text-align:center;'><a href="#" onclick="SelectName('../Popup.htm');" style="float:left;"><img src="../img/product_edit.png" width="20px" ></a><h2 id="txtName" style='text-align:center; color:green; float:right; margin-right:40%;'><?php echo is_category_null($mysqli) ?></h2></div>
<?php            
	}


$error="";

if(isset($_POST['submit_new_category'])){
	
	if($_POST["category_name"] == ""){
		$error = "your category is empty!";
		
	}

$category_name = $_POST["category_name"];
$replace_category = preg_replace("/[^A-Za-z0-9]/", "-", $category_name);

if( $replace_category !== $category_name){
    $error_flag = true;
    $error= "Wrong Character Found, space is not allowed! ( ".$category_name." )";
}

if ($prep_stmt = "SELECT category_id FROM category WHERE name = ? LIMIT 1;");
$stmt = $mysqli->prepare($prep_stmt);
if ($stmt) {

        $stmt->bind_param('s', $category_name);
        $stmt->execute();
        $stmt->store_result();
		if ($stmt->num_rows == 1) {
            // this category name already exist
            $error = '<a class="error">This category name already exists.</a>';
			
                        $stmt->close();
        }
                
	}



if($error == ""){
$mysqli->query("INSERT INTO category (name, parent) values ('$category_name','1')");

echo "<h3 style='color:green'>Your category is now added to our database</h3>";

}

}


?>


<div class="register_category_form">
<div class="reg_cat">
<form method="post" class="category_form" action="?new-category" >
Category:<input type="text" name="category_name"> 
<input name="submit_new_category" class="add_new_category_button" type="submit" value="Add Category" ></br>
<a style="padding-left:10px; color:#FFE6CC"><?php echo $error; ?></a>
</form>
</div>
<?php
$error_subcategory = "";
if(isset($_POST['select_category_and_submit_new_subcategory'])){
	$selected_category = $_POST['select_category'];
	$subcategory_name = $_POST['subcategory_name'];
	if ($_POST['select_category'] == ""){
		$error_subcategory = "<a style='color:red'>your category is not selected </a>";
		
	}
	
	if ($_POST['subcategory_name'] == ""){
		$error_subcategory = "<a style='color:red'>your subcategory name is empty</a>";
		
	}
	

	$replace_sub = preg_replace("/[^a-z0-9\s]/i", "", $subcategory_name); 
	$replace_sub = preg_replace("/\s\s+/", " ", $replace_sub);
	
	if($replace_sub !== $subcategory_name){
    $error_subcategory = "Wrong Character Found, space is not allowed! ( ".$subcategory_name." )";
}
	
	
if ($prep_stmt = "SELECT category_id FROM category WHERE name = ? LIMIT 1;");
$stmt = $mysqli->prepare($prep_stmt);
if ($stmt) {

        $stmt->bind_param('s', $subcategory_name);
        $stmt->execute();
        $stmt->store_result();
		if ($stmt->num_rows == 1) {
            // A user with this email address already exists
            $error_subcategory = '<a class="error">This subcategory name already exists.</a>';
			
                        $stmt->close();
        }
                
	}
	
	
	
	if ($error_subcategory == ""){
	$mysqli->query("INSERT INTO category (name, parent) select '$subcategory_name', category_id from category
where category_id = (select category_id from category where name = '$selected_category')");
	$error_subcategory = "<a style='color:green'>Success, Subcategory is added!</a>";
	}
}

?>

<div  class="set-subcategory">
<form method="post" class="category_form" action="?new-category" >
<?php echo $error_subcategory."</br>"; ?>
<select name="select_category" id="select_category" value="<?php echo $_POST['select_category'];?>">
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
        echo "<option "; if ($_POST['select_category'] == $name) { echo " selected='true'"; }; echo "value='". $name ."'>" . $name ."</option>";
			}	
			$stmt -> close();
		}
}
?>
</select>:Select Category 
<input type="text" name="subcategory_name">:Subcategory 
<input name="select_category_and_submit_new_subcategory" type="submit" value="Add Subcategory" >
</form>

</div>


<div class="change-cat-sub">
<a style="padding:2px; margin-bottom:10px; float:left; width:100%; background-color: #FFDABD">Click the <img src="<?php echo site_name ?>/img/DeleteRed.png" width="12px"> to delete a category/subcategory or Click +... to display subcategories</a>
<div class="change-cat">

<ul><div style="margin:5px;">Change Categories:</div>
<?php 
if (!isset($_SESSION['deleted'])){
	$_SESSION['deleted'] = "";
}

if (!isset($_SESSION['deleted_category'])){
	$_SESSION['deleted_category'] = "";
}
if ((isset($_SESSION['deleted']) && !empty($_SESSION['deleted'])) || (isset($_SESSION['deleted_category']) && !empty($_SESSION['deleted_category']))){


if ($_SERVER['QUERY_STRING'] == $_SESSION['deleted']){


echo "nuk fshihet";

			if(preg_match_all("/(?<=-)(.*?)(?=-)/s", $_SESSION['deleted'], $result)){
				if (delete_subcategory($mysqli, $result[0][0]));
			}

} else if ($_SERVER['QUERY_STRING'] == $_SESSION['deleted_category']){

			
			if(preg_match_all("/(?<=-)(.*?)(?=-)/s", $_SESSION['deleted_category'], $result)){
				if (delete_category($mysqli, $result[0][0])){
					
					 
				}
			}


		}
}

echo "<form method='post' action='?new-category'>";
$get = "";
$get_cat_id = "";
$category_id_all = array();
if ($prep_stmt = "SELECT category_id , name FROM category WHERE parent = 1 order by category_id");
$stmt = $mysqli->prepare($prep_stmt);
if ($stmt) {
$stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
$stmt->bind_result($category_id,$name);
if ($stmt->num_rows > 0) {	
$a=0;
		while($row = $stmt->fetch()) {
		$category_id_all[$a] = $category_id;
		$a= $a+1;	
			}	
		
		if (update_categories($mysqli ,'update_categories' , $category_id_all)){
		echo "<script>setTimeout(function() { alert('Category updated'); }, 1); </script>";
		}
		$get_categories = array();
$get_categories = get_all_categories_from_db($mysqli);
$i=0;
		while(count($get_categories) > $i) {
?>
        <li><a href='#' onclick="return confirm_it('?deleted-<?php echo $category_id_all[$i] ?>-<?php echo $get_categories[$i] ?>','Do you want to delete this category?');"><img src='<?php echo site_name ?>/img/DeleteRed.png' width='12px'> </a>
<?php
echo "<input type='text' name='n".$i."' value='".$get_categories[$i]."'><a href='?change-".$get_categories[$i]."'>+...</a></li>";
		if(isset($_GET['change-'.$get_categories[$i]])){
				$get = $get_categories[$i];
			}
			$i+=1;
			}	
			
		}
}



echo "<li><input type='submit'  name='update_categories' value=' Save/Update Categories ' ></li>"; // print a submit button
echo "</form>"; //close the form

 ?>

</ul>
</div>

<div class="change-cat">
<?php if ($_SERVER['QUERY_STRING'] == "change-".$get){ ?>
<ul><?php echo "<div style='margin-top:5px; text-align:center;'>Selected Category:</br>'".$get."'</div>"; ?></br>
<?php
echo "<form method='post' action='?change-".$get."'>";
$subcategory_parent_all = array();	//create a array for taking all the subcategory parent id from db
$subcategory_names = array();
if ($prep_stmt = "SELECT category_id ,name FROM category WHERE parent = (select category_id from category where name = '$get') "); //we take all subcategory id and name from db 
$stmt = $mysqli->prepare($prep_stmt);
if ($stmt) {
$stmt->execute();    // Execute the prepared query.
$stmt->store_result();
$stmt->bind_result($subcategory_id,$name);
$i=0;
if ($stmt->num_rows > 0) {	
		while($row = $stmt->fetch()) {
		$subcategory_id_all[$i] = $subcategory_id;
		$subcategory_names[$i] = $name;
		$i= $i+1;
			}		
	
if (update_subcategories($mysqli, 'update_subcategories' , $subcategory_id_all)){
	echo "<script>setTimeout(function() { alert('Subcategory updated'); }, 1); </script>";
}
$get_subcategories = get_all_subcategories_from_category_db($mysqli,$get); //we take all subcategories form database
$i=0;
		while(count($get_subcategories) > $i) {
?>
        <li><a href='#' onclick="return confirm_it('?deleted/subcategory-<?php echo $subcategory_id_all[$i] ?>-<?php echo $get_subcategories[$i] ?>','Do you want to delete this subcategory?');"><img src='<?php echo site_name ?>/img/DeleteRed.png' width='12px'> </a><input type='text' name='sub<?php echo $i ?>' value='<?php echo $get_subcategories[$i] ?>'></li>
<?php		
		$i= $i+1;
			}	
			
		}
		
}

echo "<li><input type='submit' name='update_subcategories' value=' Save/Update Subcategories ' ></li>";
echo "</form>";
 ?>
</ul>
<?php } else { echo "Click +... to change subcategories";}?>

</div>
</div>
<div class="delete-categories">

</div>
</div>
