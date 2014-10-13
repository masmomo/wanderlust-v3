//Installation guide

1. include("multiple_insert_product/control.php") on top of the file
2. add 
	<script src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']);?>/products/add/multiple_insert_product/multiple.js"></script>
   on the bottom of the file
   
3. add files/uploads/products and files/uploads/product/thumb_240x360