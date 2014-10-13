<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
    	<?php $prefix="../";?>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Admin Demo</title>
        <meta name="description" content="Antikode Admin Demo">
        <meta name="format-detection" content="telephone=no">
		<!--[if lt IE 9]>
			<script src="<?php echo $prefix;?>js/html5shiv.js"></script>
		<![endif]-->
        <link rel="stylesheet" href="<?php echo $prefix;?>css/normalize.css">
        <link rel="stylesheet" href="<?php echo $prefix;?>css/main.css">
        <script src="<?php echo $prefix;?>script/vendor/modernizr-2.6.1.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an outdated browser. <a href="http://browsehappy.com/">Upgrade your browser today</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to better experience this site.</p>
        <![endif]-->

        <div id="container" class="reports">

            <?php include($prefix."static/header.php");?>

            <?php include($prefix."static/breadcrumbs.php");?>

            <div class="sub-header clearfix">
                <div class="content">
                    <h2>Sales Report by Items</h2>
                    <select class="input-select">
                        <option>Grouped by Categories</option>
                        <option>Grouped by Orders</option>
                    </select>
                    <div class="btn-placeholder hidden">
                        <input type="button" class="btn green main" value="Add Product">
                    </div>
                </div>
            </div>

            <div id="main-content">

                <div class="clearfix">
                    <div class="report-filter clearfix fl">
                        <input type="text" class="input-text fl" placeholder="Date from">
                        <p class="fl">to</p>
                        <input type="text" class="input-text fl" placeholder="Date to">
                    </div>

                    <div class="btn-placeholder">
                        <input type="button" class="btn grey main" value="Export">
                        <input type="button" class="btn green main" value="Refresh">
                    </div>
                </div>

                <div class="table-wrapper">
                    <table cellpadding="0" cellspacing="0">
                        <thead>
                            <tr class="headings">
                                <th class="sort" width="10%">SKU</th>
                                <th class="sort" width="37%">
                                    Item<span class="sort-arrow-up"></span>
                                </th>
                                <th class="sort" width="5%" style="text-align: right">Qty.</th>
                                <th class="sort" width="12%" style="text-align: right">Sales Price</th>
                                <th class="sort" width="12%" style="text-align: right">Subtotal</th>
                                <th class="sort" width="12%" style="text-align: right">Avg. Disc.</th>
                                <th class="sort" width="12%" style="text-align: right">Total</th>
                            </tr>
                        </thead>
                        <tbody onload="loading()">
                            <!--<div id="loading" style="position: absolute; z-index: 2; background: #000; width: 940px; height: 200px"></div>-->
                            <tr class="rowhead-0">
                                <td></td>
                                <td>All Categories</td>
                                <td class="tr">29</td>
                                <td class="tr"></td>
                                <td class="tr">3.150.000</td>
                                <td class="tr">-80.000</td>
                                <td class="tr">3.070.000</td>
                            </tr>
                            <tr class="rowhead-1">
                                <td></td>
                                <td>Tops</td>
                                <td class="tr">29</td>
                                <td class="tr"></td>
                                <td class="tr">3.150.000</td>
                                <td class="tr">-80.000</td>
                                <td class="tr">3.070.000</td>
                            </tr>
                            <tr class="rowhead-2">
                                <td></td>
                                <td>Tees</td>
                                <td class="tr">29</td>
                                <td class="tr"></td>
                                <td class="tr">3.150.000</td>
                                <td class="tr">-80.000</td>
                                <td class="tr">3.070.000</td>
                            </tr>
                            <tr class="odd">
                                <td>PRO0101BLK01</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">1</td>
                                <td class="tr">150.000</td>
                                <td class="tr">150.000</td>
                                <td class="tr">-</td>
                                <td class="tr">50.000</td>
                            </tr>
                            <tr class="even">
                                <td>PRO0101BLK02</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">2</td>
                                <td class="tr">150.000</td>
                                <td class="tr">300.000</td>
                                <td class="tr">-20.000</td>
                                <td class="tr">270.000</td>
                            </tr>
                            <tr class="odd">
                                <td>PRO0101BLK01</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">1</td>
                                <td class="tr">150.000</td>
                                <td class="tr">150.000</td>
                                <td class="tr">-</td>
                                <td class="tr">150.000</td>
                            </tr>
                            <tr class="even">
                                <td>PRO0101BLK02</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">2</td>
                                <td class="tr">150.000</td>
                                <td class="tr">300.000</td>
                                <td class="tr">-20.000</td>
                                <td class="tr">270.000</td>
                            </tr>
                            <tr class="odd">
                                <td>PRO0101BLK01</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">1</td>
                                <td class="tr">150.000</td>
                                <td class="tr">150.000</td>
                                <td class="tr">-</td>
                                <td class="tr">150.000</td>
                            </tr>
                            <tr class="even">
                                <td>PRO0101BLK02</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">2</td>
                                <td class="tr">150.000</td>
                                <td class="tr">300.000</td>
                                <td class="tr">-20.000</td>
                                <td class="tr">270.000</td>
                            </tr>
                            <tr class="odd">
                                <td>PRO0101BLK01</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">1</td>
                                <td class="tr">150.000</td>
                                <td class="tr">150.000</td>
                                <td class="tr">-</td>
                                <td class="tr">150.000</td>
                            </tr>
                            <tr class="even">
                                <td>PRO0101BLK02</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">2</td>
                                <td class="tr">150.000</td>
                                <td class="tr">300.000</td>
                                <td class="tr">-20.000</td>
                                <td class="tr">270.000</td>
                            </tr>
                            <tr class="rowhead-2">
                                <td></td>
                                <td>Tanks</td>
                                <td class="tr">29</td>
                                <td class="tr"></td>
                                <td class="tr">3.150.000</td>
                                <td class="tr">-80.000</td>
                                <td class="tr">3.070.000</td>
                            </tr>
                            <tr class="odd">
                                <td>PRO0101BLK01</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">1</td>
                                <td class="tr">150.000</td>
                                <td class="tr">150.000</td>
                                <td class="tr">-</td>
                                <td class="tr">50.000</td>
                            </tr>
                            <tr class="even">
                                <td>PRO0101BLK02</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">2</td>
                                <td class="tr">150.000</td>
                                <td class="tr">300.000</td>
                                <td class="tr">-20.000</td>
                                <td class="tr">270.000</td>
                            </tr>
                            <tr class="odd">
                                <td>PRO0101BLK01</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">1</td>
                                <td class="tr">150.000</td>
                                <td class="tr">150.000</td>
                                <td class="tr">-</td>
                                <td class="tr">150.000</td>
                            </tr>
                            <tr class="even">
                                <td>PRO0101BLK02</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">2</td>
                                <td class="tr">150.000</td>
                                <td class="tr">300.000</td>
                                <td class="tr">-20.000</td>
                                <td class="tr">270.000</td>
                            </tr>
                            <tr class="odd">
                                <td>PRO0101BLK01</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">1</td>
                                <td class="tr">150.000</td>
                                <td class="tr">150.000</td>
                                <td class="tr">-</td>
                                <td class="tr">150.000</td>
                            </tr>
                            <tr class="even">
                                <td>PRO0101BLK02</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">2</td>
                                <td class="tr">150.000</td>
                                <td class="tr">300.000</td>
                                <td class="tr">-20.000</td>
                                <td class="tr">270.000</td>
                            </tr>
                            <tr class="rowhead-2">
                                <td></td>
                                <td>Tanks</td>
                                <td class="tr">29</td>
                                <td class="tr"></td>
                                <td class="tr">3.150.000</td>
                                <td class="tr">-80.000</td>
                                <td class="tr">3.070.000</td>
                            </tr>
                            <tr class="odd">
                                <td>PRO0101BLK01</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">1</td>
                                <td class="tr">150.000</td>
                                <td class="tr">150.000</td>
                                <td class="tr">-</td>
                                <td class="tr">50.000</td>
                            </tr>
                            <tr class="even">
                                <td>PRO0101BLK02</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">2</td>
                                <td class="tr">150.000</td>
                                <td class="tr">300.000</td>
                                <td class="tr">-20.000</td>
                                <td class="tr">270.000</td>
                            </tr>
                            <tr class="odd">
                                <td>PRO0101BLK01</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">1</td>
                                <td class="tr">150.000</td>
                                <td class="tr">150.000</td>
                                <td class="tr">-</td>
                                <td class="tr">150.000</td>
                            </tr>
                            <tr class="even">
                                <td>PRO0101BLK02</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">2</td>
                                <td class="tr">150.000</td>
                                <td class="tr">300.000</td>
                                <td class="tr">-20.000</td>
                                <td class="tr">270.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div><!--table-wrapper-->

            </div><!--main-content-->

            <?php include($prefix."static/footer.php");?>

        </div> <!--container-->

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="script/vendor/jquery-1.8.0.min.js"><\/script>')</script>
        <script src="<?php echo $prefix;?>script/plugins.js"></script>
        <script src="<?php echo $prefix;?>script/main.js"></script>

    </body>
</html>
