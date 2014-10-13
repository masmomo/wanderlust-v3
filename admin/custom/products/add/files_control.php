<?php
function get_product_id_files(){
   $conn  = connDB();
   
   $sql    = "SELECT MAX(id) as product_id FROM tbl_product";
   $query  = mysql_query($sql, $conn) or die(mysql_error());
   $result = mysql_fetch_array($query);
   
   return $result;
}


function custom_files_insert($post_files, $post_product_id){
   $conn  = connDB();
   $sql   = "INSERT INTO tbl_product_files (`files`, `product_id`)
                                     VALUES('$post_files', '$post_product_id')
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
   
}


if(isset($_POST['add-product'])){
   // CALL FUNCTION
   $files_product_id = get_product_id_files();
   
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
   
   custom_files_insert($file_name, $files_product_id['product_id']);
   
}
?>