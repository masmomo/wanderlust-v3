<?php
/*
--------------------
|     CUSTOMS      |
--------------------
*/

           /* -- CATEGORY NEWS -- */
		   if($_REQUEST['act'] == "pages/news/category/index"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/news-category\">Pages</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">News Category</a></li>";
		   
		   /* -- NEWS -- */
		   }else if($_REQUEST['act'] == "pages/news/index"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/news\">Pages</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">News</li>";
			  
			  }else if($_REQUEST['act'] == "pages/news/add/index"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/news\">Pages</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/news\">News</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">Add News</li>";
			  
			  }else if($_REQUEST['act'] == "pages/news/details/index"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/news\">Pages</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/news\">News</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">".$news_title."</li>";
			  
			  }else if($_REQUEST['act'] == "pages/news/details/edit"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/news\">Pages</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/news\">News</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/news-detail/".$_REQUEST['nid']."/".$news_title."\">".$news_title."</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\"> Edit : ".$news_title."</li>";
		   
		   /* RECIPE */
		   }else if($act == "pages/recipes/category/index"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/recipe-category\">Pages</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">Recipe Category</a></li>";
		   
		   }else if($act == "pages/recipes/index"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/recipe\">Pages</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">Recipe</li>";
		   
		   }else if($act == "pages/recipes/add/index"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/recipe\">Pages</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/recipe\">Recipe</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">Add Recipe</li>";
		   
		   }else if($act == "pages/recipes/details/index"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/recipe\">Pages</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/recipe\">Recipe</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">".ucwords(strtolower($recipe_title))."</li>";
		   
		   }else if($act == "pages/recipes/details/edit"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/recipe\">Pages</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/news\">Recipe</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/recipe-detail/".$recipe_title."\">".$recipe_title."</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\"> Edit : ".$recipe_title."</li>";
		   
		   
		   /* GALLERY */
		   }else if($act == "pages/gallery"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/gallery\">Pages</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">Gallery</li>";
		   
		   
		   /* PROMOTIONS */
		   }else if($act == "promotions/sale/index"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/sale\">Promotions</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">Sale</a></li>";
		   
		   
		   /* VOUCHER */
		   }else if($act == "voucher/index"){
		      echo "<li><a href=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/\">Home</a></li>";
			  echo "<li class=\"bread-arrow\"></li>";
			  echo "<li class=\"selected\">Voucher</li>";
		   }
?>