<?php
include("../../custom/static/general.php");
include("../../static/general.php");

$province = $_POST['province'];
$user_id  = $_POST['userID'];

function updateProvince($post_province, $post_user_id){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_user SET `user_province` = '$post_province' WHERE `user_id` = '$post_user_id'";
   $query = mysql_query($sql, $conn);
}


function get_user_ajax($post_user_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_user WHERE `user_id` = '$post_user_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_city($post_province){
   $conn  = connDB();
   
   $sql   = "SELECT * FROM cities WHERE `province` = '$post_province' ORDER BY city_name ASC";
   $query = mysql_query($sql, $conn);
   $row   = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}

updateProvince($province, $user_id);

// CALL FUNCTION
$get_city      = get_city($province);
$temp_ajx_user = get_user_ajax($user_id);
?>


   <?php
   foreach($get_city as $city){
      echo "<option value=\"".$city['city_name']."\"";
	  if($city['city_name'] == $temp_ajx_user['user_city']){
	    echo "selected=\"selected\"";
	  }
	  echo">".$city['city_name']."</option>";
   }
   ?>
