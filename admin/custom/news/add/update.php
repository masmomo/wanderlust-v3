<?php
function insertNews($news_id, $news_category, $news_title, $news_date, $news_image, $news_content, $news_created_date, $post_news_visibility){
   $conn  = connDB();
   
   $sql   = "INSERT INTO tbl_news 
                   (`news_id`, `news_category`, `news_title`, `news_date`, `news_image`, `news_content`, `news_created_date`, `news_visibility`) 
			VALUES ('$news_id', '$news_category', '$news_title', '$news_date', '$news_image', '$news_content', '$news_created_date', '$post_news_visibility')";
   $query = mysql_query($sql, $conn);
}

function updateNews(){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_news SET (`news_category`, `news_title`, `news_date`, `news_image`, `news_content`, `news_created_date`) 
			VALUES ('$news_category', '$news_title', '$news_date', '$news_image', '$news_content', '$news_created_date')";
   $query = mysql_query($sql, $conn);
}
?>