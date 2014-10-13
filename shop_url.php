<?php
/* --- FUNCTIONS --- */
function get_dirname($path){
   $current_dir = dirname($path);
   
   if($current_dir == "/" || $current_dir == "\\"){
      $current_dir = '';
   }
   
   return $current_dir;
}


/* --- DEFINED VARIABLE --- */
$param = $_REQUEST['param'];

if($param == 'wanderlust'){
   $param_url = 'shop/22';
}else if($param == 'wanderboy'){
   $param_url = 'shop/15';
}else if($param == 'wanderer'){
   $param_url = 'shop/29';
}else if($param == 'wandering'){
   $param_url = 'shop/30';
}


header("HTTP/1.1 301 Moved Permanently");
header("location:http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']).'/'.$param_url);
?>