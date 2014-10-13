<?php
include("update.php");
/* variable */
// Category



/* function database */
if(isset($_FILES['multi_files'])){
	insert_multiple_products();
}
?>