<?php 
function updateNews($post_news_category, $post_news_title, $post_news_date, $post_news_image, $post_news_content, $post_news_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_news SET `news_category` = '$post_news_category',
                                 `news_title` = '$post_news_title',
								 `news_date` = '$post_news_date',
								 `news_image` = '$post_news_image',
								 `news_content` = '$post_news_content'
								 
								 WHERE `news_id` = '$post_news_id'
			";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function delete_image($post_news_image, $post_news_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_news SET `news_image` = '$post_news_image' WHERE `news_id` = '$post_news_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}



function deleteNews($news_id){
   $conn  = connDB();
   
   $sql   = "DELETE FROM tbl_news WHERE `news_id` = '$news_id'";
   $query = mysql_query($sql, $conn);
}


?>