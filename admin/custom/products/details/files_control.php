<?php
function get_product_id_file($post_product_alias){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_product WHERE `product_alias` = '$post_product_alias'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
   $result = mysql_fetch_array($query);
   
   return $result;
}


function custom_filter_update($post_files, $post_product_id){
   $conn  = connDB();
   $sql   = "UPDATE tbl_product_files SET `files` = '$post_files' WHERE `product_id` = '$post_product_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function custom_get_files($post_product_id){
   $conn   = connDB();
   $sql    = "SELECT * FROM tbl_product_files WHERE `product_id` = '$post_product_id'";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
   $result = mysql_fetch_array($query);
   
   return $result;
   
}


if(isset($_POST['btn-product-detail'])){
   
   if(!empty($_FILES['product_files']['name'])){
   
      // REQUEST VARIABLE
      $req_prod_filter = $_REQUEST['product_alias'];
   
   
      // CALL FUNCTION
      $files_product_id = get_product_id_file($req_prod_filter);
	  $old_file         = custom_get_files($files_product_id['id']);
	  
	  
	  // REMOVE OLD FILE
	  unlink('../'.$old_file['files']);
   
   
      // DEFINED VARIABLE
      $image_name    = substr($_FILES['product_files']['name'],0,- 4);
      $image_type    = substr($_FILES['product_files']['name'],-4);
   
      $uploads_dir   = '../files/uploads/media/';
      $userfile_name = cleanurl(str_replace(array('(',')',' '),'_',$image_name)).$image_type;
      $userfile_tmp  = $_FILES['product_files']['tmp_name'];
      $prefix        = 'spesification-';
      $prod_img      = $uploads_dir.$prefix.$userfile_name;
   
      move_uploaded_file($userfile_tmp, $prod_img);
      $file_name  = 'files/uploads/media/'.$prefix.$userfile_name;
   
	  custom_filter_update($file_name, $files_product_id['id']);
   
   }
   
}
?>