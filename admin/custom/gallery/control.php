<?php
/*--------------------*/
/*      GALLERY       */
/*--------------------*/

$count_gallery = count_gallery();
$latest_gallery_order = get_order_gallery();
$gallery_id    = $_POST['gallery_id'];

if(isset($_POST['btn-index-gallery'])){
   
   if($_POST['btn-index-gallery'] == "Save Changes"){
      
	  /* -- GALLERY -- */
	  foreach($gallery_id as $gallery_id){
         $get_gallery   = get_gallery($gallery_id);
	     $gallery_order = $get_gallery['order'];
	     $gallery_flag  = $_POST['gallery_flag_'.$gallery_id];
	  
	     if(!empty($_FILES['upload_gallery_'.$gallery_id]['name'])){ 
	     
		    $uploads_dir_gallery   = 'files/uploads/gallery/';
            $userfile_name_gallery = str_replace(array('(',')',' '),'_',$_FILES['upload_gallery_'.$gallery_id]['name']);
            $userfile_tmp_gallery  = $_FILES['upload_gallery_'.$gallery_id]['tmp_name'];
            $prefix_gallery        = 'gallery-'.$gallery_id."-";
            $prod_img_gallery      = $uploads_dir_gallery.$prefix_gallery.$userfile_name_gallery;
			
			move_uploaded_file($userfile_tmp_gallery, $prod_img_gallery);
            $gallery_image = $prefix_gallery.$userfile_name_gallery;
			
			$filename_gallery = $uploads_dir_gallery.$gallery_image;
		 
		    if(!empty($get_gallery['flag'])){ 
		       $unlink_gallery = $get_gallery['flag'];
		    }else{
	           $unlink_gallery = $filename_gallery;
		    }
			
			if(!empty($get_gallery['filename']) and $get_gallery['filename'] != $get_gallery['flag'] and file_exists($get_gallery['flag'])){ 
		       unlink($get_gallery['flag']);
	        }
		 
	     }else{
	        
			if(!empty($get_gallery['flag'])){ 
		    
			   if(empty($get_gallery['filename'])){ 
			      $unlink_gallery = $get_gallery['flag'];
			   }else{ 
			      $unlink_gallery = $get_gallery['flag'];
			   }
			   
		    }else{
			   $unlink_gallery = $get_gallery['filename'];
	        }		
		 
		    $filename_gallery = $gallery_flag;
		 
		 }
		 
		 if(!empty($get_gallery['filename']) and $get_gallery['filename'] != $get_gallery['flag'] and file_exists($get_gallery['flag'])){ 
		    unlink($get_gallery['flag']);
	     }
		 
		 if($count_gallery['rows'] > 0){
		    $gallery_order = 1;
	        update_gallery($filename_gallery, $link, $order, $unlink_gallery, $gallery_id);
			
		 }else{
			 
			$gallery_order = $latest_gallery_order['order']+1;
		    if($count_gallery['rows'] < 10){ insert_gallery($filename_gallery, 'NOT DEFINED YET', $gallery_order, $unlink_gallery);}
			//insert_gallery($gallery_id, $filename, $link, $order, $flag)
		 }
		 
	  }// END FOR
   
   
   /* -- END gallery -- */

   
   }
}
?>