<?php
$recipeCategory = getCategory();


// DEFINED VALUE
$post_category_recipes = $_POST['category'];;
$post_recipes_name     = $_POST['recipe_name'];
$post_recipes_date     = $_POST['recipe_date'];
$post_ingredients      = addslashes($_POST['recipe_ingredients']);
$post_sauce            = addslashes($_POST['recipe_sauce']);
$post_method           = addslashes($_POST['recipe_method']);

$getRecords            = getRecords($post_recipes_name);

if($_POST['btn-add-recipes'] == "Save Changes" || $_POST['btn-add-recipes'] == "Save Changes & Exit"){
   
   $checkName     = getName($post_recipes_name);
   
   if($checkName['rows'] > 0 ){
	  
	  for($i=0;$i<=$getRecords['rows'];$i++){
         $recipe_name = cleanurl($post_recipes_name.randomchr());
	  }
	  
   }else{
      $recipe_name = cleanurl($post_recipes_name);
   }

   $uploads_dir   = '../files/uploads/recipes_image/';
   $userfile_name = str_replace(array('(',')',' '),'_',$_FILES['upload_recipes_1']['name']);
   $userfile_tmp  = $_FILES['upload_recipes_1']['tmp_name'];
   $prefix        = 'recipes_image-';
   $prod_img      = $uploads_dir.$prefix.$userfile_name;
   
   move_uploaded_file($userfile_tmp, $prod_img);
   $slider_image  = $prefix.$userfile_name;
   
   $filename      = "files/uploads/recipes_image/".$slider_image;
   
   addNews($post_category_recipes, $post_recipes_name, $filename, $post_recipes_date, $post_ingredients, $post_sauce, $post_method, cleanurl($recipe_name), 'Visible', 'top');
   
   if ($_POST['btn-add-recipes'] == "Save Changes & Exit"){
   ?>
      <script>
      location.href = "http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/recipe-detail/".cleanurl($recipe_name);?>";
	  </script>
   <?php
   }

}
?>