<?php
function deleteMultiple($post_recipe_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_recipes WHERE `recipe_id` = '$post_recipe_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}
?>