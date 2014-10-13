<?php
// CALL FUNCTION
$recipe_category = getCategory();

// DEFINE VARIABLE
$recipe_id          = $_POST['recipe_id'];
$category_recipe    = $_POST['category'];
$post_recipe_name   = $_POST['recipe_name'];
$recipe_date        = $_POST['recipe_date'];
$recipe_ingredients = addslashes($_POST['recipe_ingredients']);
$recipe_sauce       = addslashes($_POST['recipe_sauce']);
$recipe_method      = addslashes($_POST['recipe_method']);
//$recipe_alias       = $_POST['recipe_alias'];
//$visibility_status  = $_POST['recipe_visibility'];
$recipe_additional  = 'top'; 

if(isset($_POST['btn-edit-recipes'])){
   
   if($_POST['btn-edit-recipes'] == "Save Changes" || $_POST['btn-edit-recipes'] == "Save Changes & Exit"){
	  
	  // CHECK IMAGE
	  if(empty($_POST['recipes_images'])){
	     $recipe_image = $_POST['recipes_unlink'];
	  }else{
	     $uploads_dir   = '../files/uploads/recipes_image/';
   	     $userfile_name = str_replace(array('(',')',' '),'_',$_FILES['upload_recipes_1']['name']);
   		 $userfile_tmp  = $_FILES['upload_recipes_1']['tmp_name'];
   		 $prefix        = 'recipes_image-';
   		 $prod_img      = $uploads_dir.$prefix.$userfile_name;
   
   		 move_uploaded_file($userfile_tmp, $prod_img);
   		 $slider_image  = $prefix.$userfile_name;
   
   		 $recipe_image  = "files/uploads/recipes_image/".$slider_image;
	  }
	  
	  // CREATE ALIAS
	  $checkName        = getName($post_recipe_name);
   
      if($checkName['rows'] > 0 ){
		  
         $getRecords = getRecords($post_recipe_name);
	  
	     //for($i=0;$i<=$getRecords['rows'];$i++){
            $recipe_name  = $post_recipe_name;
		    $recipe_alias = cleanurl($post_recipe_name.randomchr());
	     //}
	  
      }else{
         $recipe_name  = $post_recipe_name;
	 	 $recipe_alias = cleanurl($post_recipe_name);
      }

	  updateRecipes($category_recipe, $recipe_name, $recipe_image, $recipe_date, $recipe_ingredients, $recipe_sauce, $recipe_method, $recipe_alias, 'Visible', 'top', $recipe_id);
	  
	  if($_POST['btn-edit-recipes'] == "Save Changes"){
	  ?>
      <script>
	  location.href = "http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/recipe-detail/".cleanurl($recipe_alias);?>";
	  </script>
      <?php
	  }else{
	  ?>
      <script>
	  location.href = "http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/recipe"?>";
	  </script>
      <?php
	  }
	  
   }else if($_POST['btn-edit-recipes'] == "Delete"){
      deleteRecipes($recipe_id);
	  ?>
      <script>
	  location.href = "http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/recipe"?>";
	  </script>
      <?php
   }

}
?>