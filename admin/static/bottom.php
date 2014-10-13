<?php
if($act == 'products/details/edit'){
   $_SESSION['custom_product_detail'] = $_REQUEST['product_alias'];
}else{
   unset($_SESSION['custom_product_detail']);
}
?>