<?php
session_start();

// get dir
function get_dirname($path){
$current_dir = dirname($path);

if($current_dir == "/" || $current_dir == "\\"){
$current_dir = '';
}

return $current_dir;
}
	
unset($_SESSION['admin']);

header("Location: http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']));
?>