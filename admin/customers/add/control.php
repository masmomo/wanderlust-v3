<?php
include("get.php");
include("update.php");

// DEFINED VARIABLE
$first_name  = clean_alphabet($_POST['user_first_name']);
$last_name   = clean_alphabet($_POST['user_last_name']);
$phone       = clean_number($_POST['user_phone']);
$email       = $_POST['user_email'];
$password    = clean_alphanum($_POST['password']);
$address     = $_POST['user_address'];
$city        = $_POST['user_city'];
$province    = $_POST['user_province'];
$country     = $_POST['user_country'];
$postal_code = clean_number($_POST['user_postal_code']);
$ten         = cleanurl($first_name." ".$last_name);
$post_user_created_date = date("Y-m-d");

$set_user_fullname = $first_name." ".$last_name;


// CALL FUNCTION
$count       = countUser($set_user_fullname);
$getCountry  = getCountry();
$getCities   = getCities();
$getProvince = getProvince(); 
$get_email   = validate_email($email);

if($_POST['btn-add-customer'] == "Save Changes"){
	
   if($get_email['rows'] > 0){
	  $_SESSION['alert'] = "error";
      $_SESSION['msg']   = $email." has been taken, please register with other valid email address";
	  
   }else{
	  
	  if($count['rows'] > 0){
         $post_user_alias = cleanurl($set_user_fullname.$count['rows']);
      }else{
         $post_user_alias = cleanurl($set_user_fullname);
      }
   
      update_all($first_name, $last_name, $phone, $email, $password, $address, $city, $province, $country, $postal_code, $set_user_fullname, $post_user_created_date, $post_user_alias);
   
      $_SESSION['alert'] = "success";
      $_SESSION['msg']   = "A customer has been successfully added.";
   }
   
}
?>