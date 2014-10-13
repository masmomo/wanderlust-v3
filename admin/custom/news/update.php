<?php
function delete($post_news_id){
   $conn  = connDB();
   $sql   = "DELETE FROM tbl_news WHERE `news_id` = '$post_news_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}


function update($post_visibility, $post_news_id){
   $conn  = connDB();
   $sql   = "UPDATE tbl_news SET `news_visibility` = '$post_visibility' WHERE `news_id` = '$post_news_id'";
   $query = mysql_query($sql, $conn) or die(mysql_error());
}
?>