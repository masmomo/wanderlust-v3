<?php
   /* -- DASHBOARD -- */
if(empty($act)){
   $header_dashboard  = "class=\"active\"";
   $header_order      = "";
   $header_customer   = "";
   $header_products   = "";
   $header_promotions = "";
   $header_report     = "";
   $header_pages      = "";
   
   
   /* -- ORDER -- */
}else if($act == "orders/index" || $act == "orders/details/index" || $act == "orders/details/edit"){
   $header_dashboard  = "";
   $header_order      = "class=\"active\"";
   $header_customer   = "";
   $header_products   = "";
   $header_promotions = "";
   $header_report     = "";
   $header_pages      = "";
   
   
   /* -- CUSTOMER -- */
}else if($act == "customers/index" || $act == "customers/add/index" || $act == "customers/details/edit" || $act == "customers/details/index"){
   $header_dashboard  = "";
   $header_order      = "";
   $header_customer   = "class=\"active\"";
   $header_products   = "";
   $header_promotions = "";
   $header_report     = "";
   $header_pages      = "";
   
   
   /* -- PRODUCTS -- */
}else if($act == "products/index" || $act == "products/add/index" || $act == "products/details/edit" || $act == "products/category/index" || $act == "products/color/index" || $act == "products/stock/sizemanager" || $act == "products/size/index" || $act == "products/designer/index"){
   $header_dashboard  = "";
   $header_order      = "";
   $header_customer   = "";
   $header_products   = "class=\"active\"";
   $header_promotions = "";
   $header_report     = "";
   $header_pages      = "";


   /* -- PROMOTION -- */
}else if($act == "promotions/sale/index"){
   $header_dashboard  = "";
   $header_order      = "";
   $header_customer   = "";
   $header_products   = "";
   $header_promotions = "class=\"active\"";
   $header_report     = "";
   $header_pages      = "";

   /* -- REPORTS -- */
}else if($act == "reports/index"){
   $header_dashboard  = "";
   $header_order      = "";
   $header_customer   = "";
   $header_products   = "";
   $header_promotions = "";
   $header_report     = "class=\"active\"";
   $header_pages      = "";


   /* -- PAGES -- */
}else if($act == "reports/index" || $act == "pages/home/home" || $act == "pages/about" || $act == "pages/contact" || $act == "pages/gallery" || $act == "pages/news/category/index" || $act == "pages/news/index" || $act == "pages/news/details/index" || $act == "pages/news/details/edit" || $act == "pages/news/add/index" || $act == "pages/recipes/category/index" || $act == "pages/recipes/category/index" || $act == "pages/recipes/index" || $act == "pages/recipes/details/index" || $act == "pages/recipes/add/index" || $act == "pages/recipes/details/edit" || $act == "pages/recipes/index"){
   $header_dashboard  = "";
   $header_order      = "";
   $header_customer   = "";
   $header_products   = "";
   $header_promotions = "";
   $header_report     = "";
   $header_pages      = "class=\"active\"";


// VOUCHER
}else if($act == "voucher/index"){
   $header_dashboard  = "";
   $header_order      = "";
   $header_customer   = "";
   $header_products   = "";
   $header_promotions = "";
   $header_pages      = "";
   $header_report     = "";
   $header_voucher    = "class=\"active\"";
   

// REPORT
}else if($act == "reports/index" || $act == "reports/sales/items/categories/index" || $act == "reports/sales/items/orders/index" || $act == "reports/inventory/index"){
   $header_dashboard  = "";
   $header_order      = "";
   $header_customer   = "";
   $header_products   = "";
   $header_promotions = "";
   $header_pages      = "";
   $header_report     = "class=\"active\"";
}
?>

<header>

  <div class="navbar navbar-inverse navbar-static-top" role="navigation">
    <div class="container">

      <div class="navbar-brand"><img src="<?php echo $prefix_url.'static/thimthumb.php?src='.$general['logo'].'&h=40&q=80';?>" alt="logo"></div>

      <ul class="nav navbar-nav" role="navigation">
        <li <?php echo $header_dashboard;?> class="hidden"><a href="#">Dashboard</a></li>
        <li <?php echo $header_order;?>><a href="<?php echo $prefix_url;?>order">Orders</a></li>
        <li <?php echo $header_customer;?>><a href="<?php echo $prefix_url;?>customer">Customers</a></li>
        <li <?php echo $header_products;?>><a data-toggle="dropdown" href="#">Products</a>
          <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
            <li><a href="<?php echo $prefix_url;?>product">Products</a></li>
            <li><a href="<?php echo $prefix_url;?>collection">Collection</a></li>
            <li><a href="<?php echo $prefix_url;?>stock-manager">Stock Control</a></li>
            <li class="disabled"><a>Attributes</a></li>
            <li><a href="<?php echo $prefix_url;?>category">Categories</a></li>
            <li><a href="<?php echo $prefix_url;?>size">Size Groups</a></li> 
            <li><a href="<?php echo $prefix_url;?>color">Color Manager</a></li>         
            <li class="disabled hidden"><a>Color Groups</a></li>
            <li class="hidden"><a href="<?php echo $prefix_url;?>tag">Solid Color</a></li>
            <li class="hidden"><a href="<?php echo $prefix_url;?>tagging">Wood Colors</a></li>
          </ul>
        </li>
        
        
        <li <?php echo $header_promotions;?>><a data-toggle="dropdown" href="#">Promotions</a>
          <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
            <li><a href="<?php echo $prefix_url;?>new-arrivals">New Arrivals</a></li>
            <li><a href="<?php echo $prefix_url;?>sale">Sale</a></li>
          </ul>
        </li>
        <li class="hidden"><a href="<?php echo $prefix_url;?>reporting">Reports</a></li>
        
        <li class="hidden"><a data-toggle="dropdown" href="#">Projects</a>
          <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
            <li><a href="<?php echo $prefix_url.'project-category';?>">Categories</a></li>
            <li><a href="<?php echo $prefix_url.'project';?>">Projects</a></li>
          </ul>
        </li>

        <li <?php echo $header_pages;?>><a data-toggle="dropdown" href="#">Pages</a>
          <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
            <li><a href="<?php echo $prefix_url;?>home">Home</a></li>
            <li><a href="<?php echo $prefix_url;?>about">About</a></li>
            <li><a href="<?php echo $prefix_url;?>contact">Contact</a></li>
            <li class="hidden"><a href="<?php echo $prefix_url;?>faq">FAQ</a></li>
            <li class="disabled"><a>News &amp; Events</a></li>
            <li><a href="<?php echo $prefix_url.'news-category';?>">Category</a></li>
            <li><a href="<?php echo $prefix_url.'news';?>">News</a></li>
          </ul>
        </li>

        <li <?php echo $header_pages;?>><a data-toggle="dropdown" href="#">Partner</a>
          <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
            <li><a href="<?php echo $prefix_url;?>store-city">City</a></li>
            <li><a href="<?php echo $prefix_url;?>store">Partner</a></li>
          </ul>
        </li>

        <li <?php echo $header_pages;?>><a data-toggle="dropdown" href="#">Career</a>
          <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
            <li><a href="<?php echo $prefix_url;?>career-department">Department</a></li>
            <li><a href="<?php echo $prefix_url;?>career">Jobs</a></li>
          </ul>
        </li>
        
      </ul>
      
      

      <ul class="nav navbar-nav navbar-right" role="navigation">
        <li class=""><a data-toggle="dropdown" href="#" style="font-size: 18px; padding: 14px 6px 14px 10px"><span class="glyphicon glyphicon-cog"></span></a>
          <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
            <li><a href="<?php echo $prefix_url;?>general">General</a></li>
            <li><a href="<?php echo $prefix_url;?>accounts">Account</a></li>
            <li><a href="<?php echo $prefix_url;?>notifications">Notifications</a></li>
            <li><a href="<?php echo $prefix_url;?>payment">Payment</a></li>
            <li><a href="<?php echo $prefix_url;?>shipping">Shipping Methods</a></li>
            <li><a href="<?php echo $prefix_url;?>logout">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</header>