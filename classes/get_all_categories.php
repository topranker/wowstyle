<?php

if ($prep_stmt = "SELECT t1.name AS lev1, t2.name as lev2, t3.name as lev3, t4.name as lev4
FROM category AS t1
LEFT JOIN category AS t2 ON t2.parent = t1.category_id
LEFT JOIN category AS t3 ON t3.parent = t2.category_id
LEFT JOIN category AS t4 ON t4.parent = t3.category_id
WHERE t1.name = 'ELECTRONICS';");
$stmt = $mysqli->prepare($prep_stmt);
if ($stmt) {

$stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
$stmt->bind_result($lev1 , $lev2, $lev3, $lev4);
		if ($stmt->num_rows > 0) {
			while($row = $stmt->fetch()) {
        echo "Category: " . $lev2 ." | Subcategory: ".$lev3."<br>";
			}
		}
}
?>