<?php
/*
* ----------------------------------------------------------------------
* SESSION
* ----------------------------------------------------------------------
*/

/* --- CONSTRUCT SESSION --- */
session_start();


/* --- CKEDITOR SESSION --- */
$_SESSION['KCFINDER']             = array();
$_SESSION['KCFINDER']['disabled'] = false;

 
/* --- SESSION DUAL LANGUAGE --- */
if(!isset($_SESSION['lang'])){
   $_SESSION['lang'] = "en";
}



/*
* ----------------------------------------------------------------------
* DATE & TIME
* ----------------------------------------------------------------------
*/

/* --- GET CURRENT DATE (Format : Mon, 1 Jan 2013) --- */
function current_date(){
   $date   = date('D, j M Y');  
   
   echo $date;
}


/* --- GET CURRENT DATE PHPMYADMIN FORMAT (Format : YYYY-MM-DD / 2013-01-01) --- */
function current_date_sql(){
   $date   = date('Y-m-d');  
   
   return $date;
}


/* --- FORMAT DATE --- */
function format_date($time){
   $date   = date('D, j M Y',strtotime($time));  
   
   return $date;
}


/* --- FORMAT DATE FOR DATEPICKER --- */
function format_date_min($time){
   $date   = date('Y/m/j',strtotime($time));  
   
   return $date;
}


/* --- FORMAT DATE FOR SQL --- */
function format_date_sql($time){
   $date   = date('Y-m-j',strtotime($time));  
   
   return $date;
}



/*
* ----------------------------------------------------------------------
* FORMAT
* ----------------------------------------------------------------------
*/

/* --- CLEAN ALPHABET --- */
function clean_alphabet($str) {
   $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
   $clean = preg_replace("/[^a-zA-Z]\s/", '', $str);
   $clean = preg_replace("/[^a-zA-Z]\s/", '', $clean);
   $clean = addslashes($clean);

   return $clean;
}


/* --- CLEAN EMAIL --- */
function clean_email($str) {
   $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
   $clean = preg_replace("/[^a-zA-Z0-9.@_]/", '', $str);
   $clean = preg_replace("/[^a-zA-Z0-9.@_]/", '', $clean);
   $clean = addslashes($clean);
   
   return $clean;
}


/* --- CLEAN ALPHANUMERIC --- */
function clean_alphanum($str) {
   $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
   $clean = preg_replace("/[^a-zA-Z0-9]\s/", '', $str);
   $clean = preg_replace("/[^a-zA-Z0-9]\s/", '', $clean);
   $clean = addslashes($clean);

   return $clean;
}


/* --- CLEAN NUMBER --- */
function clean_number($number){
   $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $number);
   $clean = preg_replace("/[^0-9]/", '', $number);
   $clean = trim($clean, '*');
   $clean = preg_replace("/[^0-9]/", '', $clean);

   return $clean;
}


/* --- CLEAN ALPHANUMERIC 2 --- */
function clean_alphanumeric($alphanum){
   $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $alphanum);
   $clean = preg_replace("/[^a-zA-Z0-9]\s/", '', $alphanum);
   $clean = trim($clean, '*');
   $clean = preg_replace("/[^a-zA-Z0-9]\s/", '', $clean);

   return $clean;
}


/* --- CLEAN URL --- */
function cleanurl($str) {
   $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
   $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '-', $str);
   $clean = strtolower(trim($clean, '-'));
   $clean = preg_replace("/[\/_|+ -]+/", '-', $clean);

   return $clean;
}


/* --- CLEAN IMAGE --- */
function clean_image($str) {
   $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
   $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $str);
   $clean = strtolower(trim($clean, '-'));
   $clean = preg_replace("/[\/_|+ -]+/", '-', $clean);

   return $clean;
}


/* --- GET DIR --- */
function get_dirname($path){
   $current_dir = dirname($path);
   
   if($current_dir == "/" || $current_dir == "\\"){
      $current_dir = '';
   }
   
   return $current_dir;
}


/* --- RANDOM CHAR --- */
function randomchr($length = 5, $letters = '123456789abcdefghijklmnopqrstuvwxyz') {
   $s = '';
   $lettersLength = strlen($letters)-1;
   
   for($i = 0 ; $i < $length ; $i++){
      $s .= $letters[rand(0,$lettersLength)];
   }
   
   return $s;
}



/* --- CLEAN POST FROM HTML ATTRIBUTE --- */
function removeHtmlAttributes($tagSource){
	$stripAttrib = "' (class&#166;javascript:&#166;onclick&#166;ondblclick&#166;onmousedown&#166;onmouseup&#166;onmouseover&#166;onmousemove&#166;onmouseout&#166;onkeypress&#166;onkeydown&#166;onkeyup&#166;oncontextmenu)=\"(.*?)\"'i";
	$tagSource = stripslashes($tagSource);
	$tagSource = preg_replace($stripAttrib, '', $tagSource);
	return $tagSource;
}


/* --- CLEAN POST FROM HTML TAGS --- */
function removeHtmlTags($source) {
   $allowedTags = '<h1><h2><h3><h4><h5><h6><br><b><p><u><i><a><ol><ul><li><pre><hr><blockquote><table><tr><td><th><span><div><strong><tbody><sup><font>';
   $source = strip_tags($source, $allowedTags);
   return preg_replace('/<(.*?)>/ie', "'<'.removeHtmlAttributes('\\1').'>'", $source);
}


/* --- DISPLAY PRICE --- */
function price($number){
   $format = number_format($number,0,',','.');
   return $format;
}


/* --- CLEAN PRICE --- */
function clean_price($number) {
   $clean = str_replace(".", "", $number);

   return $clean;
}


/* --- ESCAPE QUOTE --- */
function escape_quote($string){
   $string = str_replace('"', '&#34', $string);
   $string = str_replace("'", '&#39', $string);
   $string = $string;
   
   return $string;
}



/* --- DEFINED VARIABLE (GLOBAL) --- */
$prefix_url  = "http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/";
$prefix_img  = "http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/admin/static/thimthumb.php?src=../"; // APPLIED FRONT END ONLY
$act         = $_REQUEST['act'];
$current_url = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];



/*
* ----------------------------------------------------------------------
* ADMIN LOGIN
* ----------------------------------------------------------------------
*/

/* --- CHECKING DATABASE --- */
function admin_login($one, $two){
   $conn = connDB();
   
   $sql    = "SELECT count(*) as rows, `id` FROM tbl_admin where username = '$one' and password = MD5('$two')";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;

}

/* --- GET VALID FORGOT PASSWORD --- */
function admin_forgot_password($one){
   $conn = connDB();
   
   $sql    = "SELECT count(*) as rows, `id` FROM tbl_admin where username = '$one'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;

}

/*
* ----------------------------------------------------------------------
* END ADMIN LOGIN
* ----------------------------------------------------------------------
*/



/*
* ----------------------------------------------------------------------
* GENERAL FUNCTION
* ----------------------------------------------------------------------
*/


/* --- TABLE: tbl_info --- */
function get_info(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_infos";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


/* --- TABLE: tbl_general --- */
function get_general(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_general";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


/* --- TABLE: tbl_user --- */
function get_customer_global($get_user_id){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_user WHERE `user_id` = '$get_user_id'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


/* --- TABLE: tbl_notification --- */
function get_notification_global(){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_notification WHERE `notification_id` = '1'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


/* --- CALL FUNCTIONS --- */
$info        = get_info();
$general     = get_general();
$global_user = get_customer_global($_SESSION['user_id']);
$notif       = get_notification_global();





/*
* ----------------------------------------------------------------------
* CUSTOM FUNCTION
* ----------------------------------------------------------------------
*/

/* --- SHORTEN FUNCTIONS DATABASE --- */
function db($sql){
   $conn = connDB();
   
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


/* --- CONTROL HEADER --- */
// Get page, query_per_page, first_record, sort_by, search_parameter, search_value
function page_init($equal_search,$default_sort_by){
	$pgdata = array();
	// PAGE
	if ($_REQUEST["pg"] == ""){
	   $pgdata['page'] = 1;
	}else{
	   $pgdata['page'] = $_REQUEST["pg"];
	}
	
	// QUERY PER PAGE
	if ($_REQUEST["qpp"]==""){
	   $pgdata['query_per_page'] = 25;
	}else{
	   $pgdata['query_per_page'] = $_REQUEST['qpp'];
	}
	
	// FIRST VALUE IN LIMIT
	$pgdata['first_record'] = ($pgdata['page'] - 1) * $pgdata['query_per_page'];
	
	// SORT BY
	$pgdata['sort_by']    = $_REQUEST["srt"];
	
	if ($pgdata['sort_by'] ==""){
	   $pgdata['sort_by'] = $default_sort_by;
	}
	
	$pgdata['search_parameter'] = stripslashes($_REQUEST['src']);
	$pgdata['search_value']     = stripslashes($_REQUEST['srcval']);
	
	$search_parameter = stripslashes($_REQUEST['src']);
	$search_value     = stripslashes($_REQUEST['srcval']);
	   
	if ($search_parameter == ''){
	   $pgdata['search_query']='1';
	}else{
	   $pgdata['search'][$search_parameter] = $search_value;
	   
	   if (in_array($search_parameter, $equal_search)){
	      $pgdata['search_query'] = $search_parameter." = '".$search_value."'";
	   }else{
		  $pgdata['search_query'] = $search_parameter." LIKE '%".$search_value."%'";
	   }
	   
	}	
	
	return $pgdata;
}


// ORDER DISABLING SEARCH
function order_disabling_search($variabel, $post_src){
   
   if($variabel == "$post_src"){ 
      echo "value=\"".str_replace('\\', '/', $_REQUEST['srcval'])."\"";
   }else if(!empty($variabel)){ 
      echo "disabled";
   }

}



/*
* ----------------------------------------------------------------------
* PRODUCTS
* ----------------------------------------------------------------------
*/

/* --- PRODUCT ALIAS --- */
function alias_count_type(){
   $conn = connDB();
   
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_product_type WHERE `type_alias` = ''";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function alias_get_type(){
   $conn = connDB();
   
   $sql    = "SELECT * FROM tbl_product_type WHERE `type_alias` = ''";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
	   array_push($row, $result);
   }
   
   return $row;
}


function alias_update_type($post_type_id, $post_type_name){
   $conn  = connDB();
   
   $sql   = "UPDATE tbl_product_type SET `type_alias` = '$post_type_name' WHERE `type_id` = '$post_type_id'";
   $query = mysql_query($sql, $conn);
}

$alias_check = alias_count_type();
$alias_get   = alias_get_type();

if($alias_check['rows'] > 0){
   
   foreach($alias_get as $alias_get){
      alias_update_type($alias_get['type_id'], cleanurl($alias_get['type_name']));
   }
   
}

/* --- END PRODUCT ALIAS --- */


/* --- DISCOUNT --- */
function discount_price($post_disc_id, $post_disc_value, $post_normal_price, $post_start, $post_end){
   
   if($post_start <= date('Y-m-d') and $post_end >= date('Y-m-d')){
      
          if( $post_disc_id == "1" || $post_disc_id == 1){
          
             // PERCENTAGE
             $return['now_price']   = $post_normal_price - (($post_disc_value / 100) * $post_normal_price);
             $return['was_price']   = $post_normal_price;
			 
			 $return['promo_value'] = ($post_disc_value / 100) * $post_normal_price;
          
          }else if($post_disc_id == "2" || $post_disc_id == 2){
      
             // AMOUNT
             $return['now_price']   = $post_normal_price - $post_disc_value;
             $return['was_price']   = $post_normal_price;
			 
			 $return['promo_value'] = $post_disc_value;
          }
		  
          
   }else{
      $return['now_price']   = $post_normal_price;
	  $return['promo_value'] = 0;
   }
   
   return $return;
   
}


/* --- LABEL DISCOUNT --- */
function discount_label($post_disc_id, $post_start, $post_end, $prefix_url){
   
   if(!empty($post_disc_id) || $post_disc_id == ""){
   
      if($post_start <= date('Y-m-d') and $post_end >= date('Y-m-d')){
         echo '<div class="thumb-label sale"><img src="'.$prefix_url.'files/common/icon_sale.png"></div>'; 
      }
	  
   }
   
}



/* --- LABEL NEW ARRIVAL --- */ 
function new_label($post_disc_id, $post_start, $post_end, $prefix_url){
   
   if(!empty($post_disc_id) || $post_disc_id == ""){
   
      if($post_start <= date('Y-m-d') and $post_end >= date('Y-m-d')){
         //echo '<div class="thumb-label new"><img src="'.$prefix_url.'files/common/icon_new.png" style="width:50px; height:50px"></div>'; 
         echo "<div class=\"thumb-label sale\"><img src=\"".$prefix_url."files/common/icon_new.png\"></div>";
	  }
	  
   }
   
}


if($act != 'pages/home/home'){

/*
* ----------------------------------------------------------------------
* EXPIRED ORDER
* ----------------------------------------------------------------------
*/
 
if(!isset($_SESSION['global_day']) || $_SESSION['global_day'] == ''){
   $_SESSION['global_day'] = date('d');
   
}else{
   
   if($_SESSION['global_day'] != date('d') ){
      $_SESSION['global_day'] = date('d');
   }else{
	  
	  
	  
	  // DEFINED VARIABLE// CHECK ORDER EXPIRED
	  function header_count_order(){
	     $conn   = connDB();
		 $sql    = "SELECT COUNT(*) AS rows FROM tbl_order WHERE `order_date` = DATE_ADD( DATE( NOW( ) ) , INTERVAL -3 DAY )
                                                             AND `order_status` = 'Open' AND `payment_status` = 'Unpaid'
			       ";
	     $query  = mysql_query($sql, $conn);
		 $result = mysql_fetch_array($query);
		 
		 return $result;
	  }
	  
	  
	  // GET ORDER EXPIRED
	  function header_get_order(){
	     $conn   = connDB();
   
	     $sql    = "SELECT * FROM tbl_order WHERE `order_date` = DATE_ADD( DATE( NOW( ) ) , INTERVAL -3 DAY )
                                              AND `order_status` = 'Open' AND `payment_status` = 'Unpaid'
			       ";
	     $query  = mysql_query($sql, $conn);
	     $row    = array();
   
	     while($result = mysql_fetch_array($query)){
		    array_push($row, $result);
		 }
   
	     return $row;
	  }
	  
	  
	  // GET PRODUCT FROM ORDER EXPIRED
	  function header_get_order_item($order_id){
	     $conn   = connDB();
   
	     $sql    = "SELECT * FROM tbl_order AS ord_ LEFT JOIN tbl_order_item AS item_ ON ord_.order_id = item_.order_id WHERE ord_.order_id = '$order_id'";
	     $query  = mysql_query($sql, $conn);
	     $row    = array();
   
	     while($result = mysql_fetch_array($query)){
		    array_push($row, $result);
		 }
   
	     return $row;
	  }
	  
	  
	  // GET PRODUCT STOCK
      function header_get_item_stock($type_id, $stock_name){
	     $conn   = connDB();
   
	     $sql    = "SELECT * FROM tbl_product_stock WHERE `type_id` = '$type_id' AND `stock_name` = '$stock_name'";
	     $query  = mysql_query($sql, $conn);
	     $result = mysql_fetch_array($query);
   
	    return $result;
	  }
	  
	  
	  // GET BILLING EMAIL
      function header_get_billing($header_post_order_id){
	     $conn   = connDB();
   
	     $sql    = "SELECT * FROM tbl_user AS user_ INNER JOIN tbl_user_purchase AS pur_ ON user_.user_id = pur_.user_id WHERE `order_id` = '$header_post_order_id'";
	     $query  = mysql_query($sql, $conn);
	     $result = mysql_fetch_array($query);
   
	    return $result;
	  }
	  
	  
	  // UPDATE INTO EXPIRED
	  function header_update_expired_order($header_post_order_id){
	     $conn   = connDB();
   
	     $sql    = "UPDATE tbl_order SET `order_expired_date` = NOW(), `order_status` = 'Expired' WHERE `order_id` = '$header_post_order_id'";
	     $query  = mysql_query($sql, $conn) or die(mysql_error());
	  }
	  
	  
	  // UPDATE INTO EXPIRED
	  function header_update_expired_order_item($stock, $stock_id){
	     $conn   = connDB();
   
	     $sql    = "UPDATE tbl_product_stock SET `stock_quantity` = '$stock' WHERE `stock_id` = '$stock_id'";
	     $query  = mysql_query($sql, $conn) or die(mysql_error());
	  }
	  
	  
	  /* -- EXECUTION -- */
	  
	  // CALL FUNCTION
	  $header_check_expired = header_count_order();
	  $header_get_expired   = header_get_order();
	  
	  if($header_check_expired['rows'] > 0){
	     
		 foreach($header_get_expired as $key=>$header_get_expired){
	  
		    // UPDATE ORDER INTO EXPIRED
			header_update_expired_order($header_get_expired['order_id']);
			
			/* -- EMAIL -- */
			
			// GET CUSTOMER
			$header_expired_user = header_get_billing($header_get_expired['order_id']);
			header_update_expired_order($header_get_expired['order_id']);
			
			$header_expired_items = header_get_order_item($header_get_expired['order_id']);
			
			foreach($header_expired_items as $key=>$header_expired_items){
			   $header_expired_item = header_get_item_stock($header_expired_items['type_id'], $header_expired_items['stock_name']);
			   
			   $header_recover_stock = $header_expired_items['item_quantity'] + $header_expired_item['stock_quantity'];
			   header_update_expired_order_item($header_recover_stock, $header_expired_item['stock_id']);
			}
			
			
			// EMAIL
			$name      = $general['website_title']; 
			$email     = $notif['email_order']; 
			$recipient = $header_expired_user['user_email']; 
			$mail_body = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
	  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	  <title>['.$general['website_title'].' '.$header_expired_user['order_number'].' Expired</title>
	</head>
	
	<body style="font-family: Helvetica, Arial, sans-serif; color:#333333" topmargin="0" leftmargin="0">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="overflow: hidden; background: #fff">
	    <tbody>
		  <tr>
		    <td>
              <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="overflow: hidden; background: #fff">
                <tr>
                  <td style="padding-left: 15px; padding-top: 10px; padding-bottom: 10px">
                    <img src="'.$prefix_url.'files/common/logo.jpg'.'" height="50">
                  </td>
                </tr>
              </table>
            </td>
          </tr>
      </tbody>
    </table>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="overflow: hidden; background: #f0f0f0; border-bottom: 1px solid #e0e0e0">
      <tbody>
	    <tr>
		  <td>
            <table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
              <tr>
                <td>
                  <td style="font-size: 12px; color: #999; padding-left: 15px; text-align: left;">
                    <span style="font-weight: 100">Order no.</span> <i style="font-size: 14px; color: #333">'.$header_expired_user['order_number'].'</i>
                  </td>
                  <td style="font-size: 12px; color: #fff; padding: 10px 15px; text-align: right">
                    <span style="line-height: 18px; color: #999"><b style="color: #cc0000">ORDER EXPIRED</b> </span>
                  </td>
                </td>
              </tr>
            </table>
          </td>
        </tr>
    </tbody>
  </table>
  
  <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:12px; overflow: hidden; background: #fff; line-height: 20px">
    <tbody>
      <tr>
        <td width="600" bgcolor="#fff" style="padding: 25px">
          Dear Name,<br>
          <br>
          We\'re sorry to let you know that your order <b>'.$header_expired_user['order_number'].'</b> has been set to expired since we haven\'t received any payment confirmation within 2x24 hours.<br>
          <br> 
          If you believe this is an error or you have actually paid but haven\'t got time to confirm the payment, please contact us through email at <a style="color:#0383ae" href="mailto:'.$info['email'].'">'.$info['email'].'</a> to resolve the problem. Thank you!
          
        </td>
      </tr>
    </tbody>
  </table>
  
  <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" style="font-size:11px; color: #999; margin-top:15px">
    <tbody>
      <tr>
        <td style="padding-left:20px; padding-right:20px">
          © 2013 '.$genral['website_title'].'. Powered by <a style="color: #666; text-decoration: none" href="http://www.antikode.com">Antikode</a>. <br><br>
        </td>
      </tr>
    </tbody>
  </table>

</body>
</html>';

            $subject   = '['.$general['website_title'].'] '.$header_expired_user['order_number'].' Waiting for Payment';
            $headers   = "Content-Type: text/html; charset=ISO-8859-1\r\n".
            $headers  .= "From: ".$general['website_title']." <" .$notif['email_order']. ">\r\n"; //optional headerfields
			
			mail($recipient, $subject, $mail_body, $headers);

		 }// foreach($header_get_expired as $key=>$header_get_expired)
   
	  }// END if($header_check_expired['rows'] > 0)

   }// END if($_SESSION['global_day'] != date('d') )
   
}// END if(!isset($_SESSION['global_day']) || $_SESSION['global_day'] == '')

/*
 *---------------------------------------------------------------
 * END EXPIRED ORDER
 *---------------------------------------------------------------
 */
}


session_id();

function count_session_id($id, $count){
   $conn   = connDB();
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_session_id WHERE `session_id` = '$id' AND `count` = '$count'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function insert_session_id($id, $count){
   $conn   = connDB();
   $sql    = "INSERT INTO tbl_session_id(`session_id`, `count`) VALUES('$id', '$count')";
   $query  = mysql_query($sql, $conn);
}


function update_session_id($count){
   $conn   = connDB();
   $sql    = "UPDATE tbl_session_id SET `count` = '$count'";
   $query  = mysql_query($sql, $conn);
}


/* --- DEFINED VARIABLE --- */
$token_session_id = session_id();

/* --- CALL FUNCTION --- */
$count_session_id  = count_session_id($token_session_id, 0);
$count_session_ids = count_session_id($token_session_id, 1);
?>