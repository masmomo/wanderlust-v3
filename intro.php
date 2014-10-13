<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Mywanderlustories</title>
</head>

<body>

<?php
/* --- GET DIR --- */
function get_dirname($path){
   $current_dir = dirname($path);
   
   if($current_dir == "/" || $current_dir == "\\"){
      $current_dir = '';
   }
   
   return $current_dir;
}

$prefix_url  = "http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/";
?>

   <img src="<?php echo $prefix_url;?>files/common/bg_intro.png" width="700" style="margin: 150px auto 0; display: block;">

</body>
</html>