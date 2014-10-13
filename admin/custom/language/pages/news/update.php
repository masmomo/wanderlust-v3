<?php 
function insert_news_lang($post_news_title, $post_id_param, $post_news_category, $post_news_date, $post_news_image, $post_news_content, $post_news_created_date, $post_news_visibility, $post_lang_code){
   $conn  = connDB();
   $sql   = "INSERT INTO tbl_news_lang (`id_param`, `news_category`, `news_title`, `news_date`, `news_image`, `news_content`, `news_created_date`, `news_visibility`, `language_code`)
                                 VALUES('$post_id_param', '$post_news_category', '$post_news_title', '$post_news_date', '$post_news_image', '$post_news_content', '$post_news_created_date', '$post_news_visibility', '$post_lang_code')
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}

function updateNews_lang($post_news_category, $post_news_title, $post_news_date, $post_news_image, $post_news_content, $post_news_created_date, $post_news_id, $post_lang_code, $post_news_visibility){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_news_lang SET `news_category` = '$post_news_category',
                                      `news_title` = '$post_news_title',
								 	  `news_date` = '$post_news_date',
								 	  `news_image` = '$post_news_image',
								 	  `news_content` = '$post_news_content',
								 	  `news_created_date` = '$post_news_created_date',
									  `news_visibility` = '$post_news_visibility'
								 
             WHERE `id_param` = '$post_news_id' AND `language_code` = '$post_lang_code'
			";
   $query = mysql_query($sql, $conn);
}



function deleteNews_lang($news_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_news WHERE `news_id` = '$news_id'";
   $query = mysql_query($sql, $conn);
}


?>