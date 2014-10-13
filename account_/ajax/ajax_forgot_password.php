<?php
include("../../admin/custom/static/general.php");
include("../../admin/static/general.php");

$email = clean_email($_POST['email']);

function validate_email($post_user_email){
   $conn   = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_user WHERE `user_email` = '$post_user_email'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}

function reset_password($post_user_password, $post_user_email){
   $conn  = conndB();
   
   $sql   = "UPDATE tbl_user SET `user_password` = MD5('$post_user_password') WHERE `user_email` = '$post_user_email'";
   $query = mysql_query($sql, $conn);
}

// CALL FUNCTION
$validate = validate_email($email);

if($validate['rows'] > 0){
   // FEEDER NEW PASSWORD
   $randomize = randomchr($length = 10, $letters = '123456789abcdefghijklmnopqrstuvwxyz');
   
   // RESET PASSWORD
   reset_password($randomize, $email);
   
   // SEND EMAIL
   $name      = $general['website_title']; 
   $email     = $info['email']; 
   $recipient = $email; 
   $mail_body = "Your password has been reset. Your new password is: ".$randomize;
   $subject   = "[".$general['website_title']."] FORGOT PASSWORD: ";
   $headers   = "Content-Type: text/html; charset=ISO-8859-1\r\n".
   $headers  .= "From: ".$general['website_title']." <" .$info['email']. ">\r\n"; //optional headerfields
   
   mail($recipient, $subject, $mail_body, $headers);
   
   //ALERT
   echo "<div class=\"alert alert-success\">";
   echo "   <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>";
   echo "   <p>An email has been sent to: ".$email."</p>";
   echo "</div>";
    
}else{
   
   //ALERT
   echo "<div class=\"alert alert-danger\">";
   echo "   <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>";
   echo "   <p>E-mail address not valid</p>";
   echo "</div>";
}

?>