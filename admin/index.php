<?php 
include("custom/static/general.php");
include("static/general.php");


/* REQUIRED FOR REDIRECT PAGE */
include ("static/redirect.php");
include ("custom/static/redirect.php");
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
 	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $general['website_title'];?> Admin</title>
    <meta name="description" content="<?php echo $general['website_title'];?> Admin">
    <meta name="format-detection" content="telephone=no">
    <!--<link rel="stylesheet" href="<?php echo $prefix_url;?>css/normalize.css"> obsolete-->
    <link rel="stylesheet" href="<?php echo $prefix_url;?>css/bootstrap.css"> <!--old-->
    <link rel="stylesheet" href="<?php echo $prefix_url;?>css/main.css">
    <link rel="stylesheet" href="<?php echo $prefix_url;?>script/jQuery-ui.css">
    <!--[if lt IE 9]>
      <link href="<?php echo $prefix;?>css/ie.css" rel="stylesheet">
      <script src="<?php echo $prefix;?>script/html5shiv.js"></script>
      <script src="<?php echo $prefix;?>script/respond.min.js"></script>
    <![endif]-->
    <script src="<?php echo $prefix_url;?>script/modernizr-2.6.1.min.js"></script>
    <script src="<?php echo $prefix_url;?>script/jquery-1.8.3.js"></script>
    <script src="<?php echo $prefix_url;?>script/javascript.js"></script>
    <script src="<?php echo $prefix_url;?>script/jQuery-UI.js"></script>
    <script src="<?php echo $prefix_url;?>script/bootstrap.js"></script>
    
	<script src="<?php echo $prefix_url;?>script/plugins.js"></script> <!--old-->
    <!--<script src="<?php echo $prefix_url;?>script/header.js"></script> obsolete -->
    <script src="<?php echo $prefix_url;?>script/holder.js"></script>
    <script src="<?php echo $prefix_url;?>script/main.js"></script>
    <script src="<?php echo $prefix_url;?>script/dragtable.js"></script>
    </head>
    <body onLoad="initialization()" <?php if(empty($_SESSION['admin'])){ echo "class=\"signin\" ";}?>>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->

        <!--<div id="container">-->
        
           <?php 
		   // SESSION
		   if(!empty($_SESSION['admin'])){
		      include("custom/static/header.php");
		   }
		   
		   if(!empty($_SESSION['admin'])){
			  
			  if(empty($_REQUEST['act'])) {
			     echo '<script>location.href="'.$prefix_url.'product"</script>';
			  }else{
				 include(str_replace ('http','',$_REQUEST['act']).".php");
			  }
				
		   }else{
			  
			  if(empty($act)){
			     include("account/signin.php");
			  }else if($act == "account/forgot"){
			     include("account/forgot.php");
			  }else if($act == "account/recover"){
			     include("account/recover.php");
			  }else{
			     include("account/signin.php");
			  }
			  
		   }
		   
		   // SESSION
		   if(!empty($_SESSION['admin'])){
			  include("static/footer.php");
		   }
		   ?>
             

      <!--</div>-->

  </body>
</html>


<?php 
disconnect();
include('static/bottom.php');
?>