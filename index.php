<?php
include("admin/custom/static/general.php");
include("admin/static/general.php");
include("static/redirect.php");
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=1000px">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $general['website_title'];?></title>
    <meta name="description" content="<?php echo $general['website_description'];?>">
    <meta name="keywords" content="<?php echo $general['website_keywords'];?>">
    <meta name="author" content="">
    <link href="<?php echo $prefix_url;?>css/bootstrap-nr.css" rel="stylesheet">
    <link href="<?php echo $prefix_url;?>css/main.css" rel="stylesheet">
    <link href="<?php echo $prefix_url;?>css/plugins/uisearch.css" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="<?php echo $prefix_url;?>script/html5shiv.js"></script>
      <script src="<?php echo $prefix_url;?>script/respond.min.js"></script>
    <![endif]-->
    <script src="<?php echo $prefix_url;?>script/modernizr-2.6.1.min.js"></script>
    <script src="<?php echo $prefix_url;?>script/jquery.js"></script>
    <?php include("static/analytics.php"); ?>
  </head>
  <?php
    if($_REQUEST['act']=="shop_/details") {
      $body_class='products';
    }
    else if($_REQUEST['act']=="blog_/index") {
      $body_class='blog';
    }
  ?>
  <body class="<?php echo $body_class;?>">
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
    <![endif]-->

    <?php include("static/navbar.php"); ?>

		<?php
		if(empty($_REQUEST['act'])){
		  include('pages_/home/index.php');
		}else{
		   include(str_replace ('http','',$_REQUEST['act']).".php");
		}
		?>

    <?php include("static/footer.php"); ?>

    <script src="<?php echo $prefix_url;?>script/bootstrap.js"></script>
    <script src="<?php echo $prefix_url;?>script/holder.js"></script>
    <script src="<?php echo $prefix_url;?>script/main.js"></script>
    <script src="<?php echo $prefix_url;?>script/plugins/classie.js"></script>
    <script src="<?php echo $prefix_url;?>script/plugins/uisearch.js"></script>
    
    
    <?php
    if($act == 'order_/bag' || $act =='order_/checkout'){
	?>
    <script src="<?php echo $prefix_url;?>script/accounting.js"></script>
	<?php
	}
	?>

  </body>
</html>