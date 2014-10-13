<?php
include("control.php");
?>

            <div class="sub-header clearfix">
                <div class="content">
                    <h2>Sales by Items</h2>
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
                                <th width="10%">SKU</th>
                                <th width="37%">
                                    Item<span class="sort-arrow-up"></span>
                                </th>
                                <th width="5%" style="text-align: right">Qty.</th>
                                <th width="12%" style="text-align: right">Sales Price</th>
                                <th width="12%" style="text-align: right">Subtotal</th>
                                <th width="12%" style="text-align: right">Disc.</th>
                                <th width="12%" style="text-align: right">Total</th>
                            </tr>
                        </thead>
                        <tbody onload="loading()">
                            <!--<div id="loading" style="position: absolute; z-index: 2; background: #000; width: 940px; height: 200px"></div>-->
                            <tr class="rowhead-0">
                                <td></td>
                                <td>All Categories</td>
                                <td class="tr">129</td>
                                <td class="tr"></td>
                                <td class="tr">20.100.000</td>
                                <td class="tr">-500.000</td>
                                <td class="tr">19.600.000</td>
                            </tr>
                            <tr class="rowhead-1">
                                <td></td>
                                <td>Tops</td>
                                <td class="tr">28</td>
                                <td class="tr"></td>
                                <td class="tr">2.800.000</td>
                                <td class="tr">-260.000</td>
                                <td class="tr">2.740.000</td>
                            </tr>
                            <tr class="rowhead-2">
                                <td></td>
                                <td>Tees</td>
                                <td class="tr">14</td>
                                <td class="tr"></td>
                                <td class="tr">1.400.000</td>
                                <td class="tr">-130.000</td>
                                <td class="tr">1.370.000</td>
                            </tr>
                            <tr class="odd">
                                <td>PRO0101BLK01</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">1</td>
                                <td class="tr">100.000</td>
                                <td class="tr">100.000</td>
                                <td class="tr">-</td>
                                <td class="tr">100.000</td>
                            </tr>
                            <tr class="even">
                                <td>PRO0101BLK02</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">2</td>
                                <td class="tr">100.000</td>
                                <td class="tr">200.000</td>
                                <td class="tr">-20.000</td>
                                <td class="tr">280.000</td>
                            </tr>
                            <tr class="odd">
                                <td>PRO0101BLK01</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">3</td>
                                <td class="tr">100.000</td>
                                <td class="tr">300.000</td>
                                <td class="tr">-</td>
                                <td class="tr">300.000</td>
                            </tr>
                            <tr class="even">
                                <td>PRO0101BLK02</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">2</td>
                                <td class="tr">100.000</td>
                                <td class="tr">200.000</td>
                                <td class="tr">-50.000</td>
                                <td class="tr">150.000</td>
                            </tr>
                            <tr class="odd">
                                <td>PRO0101BLK01</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">1</td>
                                <td class="tr">100.000</td>
                                <td class="tr">100.000</td>
                                <td class="tr">-</td>
                                <td class="tr">100.000</td>
                            </tr>
                            <tr class="even">
                                <td>PRO0101BLK02</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">2</td>
                                <td class="tr">100.000</td>
                                <td class="tr">200.000</td>
                                <td class="tr">-60.000</td>
                                <td class="tr">140.000</td>
                            </tr>
                            <tr class="odd">
                                <td>PRO0101BLK01</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">1</td>
                                <td class="tr">100.000</td>
                                <td class="tr">100.000</td>
                                <td class="tr">-</td>
                                <td class="tr">100.000</td>
                            </tr>
                            <tr class="even">
                                <td>PRO0101BLK02</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">2</td>
                                <td class="tr">100.000</td>
                                <td class="tr">200.000</td>
                                <td class="tr">-</td>
                                <td class="tr">200.000</td>
                            </tr>
                            <tr class="rowhead-2">
                                <td></td>
                                <td>Tees</td>
                                <td class="tr">14</td>
                                <td class="tr"></td>
                                <td class="tr">1.400.000</td>
                                <td class="tr">-130.000</td>
                                <td class="tr">1.370.000</td>
                            </tr>
                            <tr class="odd">
                                <td>PRO0101BLK01</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">1</td>
                                <td class="tr">100.000</td>
                                <td class="tr">100.000</td>
                                <td class="tr">-</td>
                                <td class="tr">100.000</td>
                            </tr>
                            <tr class="even">
                                <td>PRO0101BLK02</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">2</td>
                                <td class="tr">100.000</td>
                                <td class="tr">200.000</td>
                                <td class="tr">-20.000</td>
                                <td class="tr">280.000</td>
                            </tr>
                            <tr class="odd">
                                <td>PRO0101BLK01</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">3</td>
                                <td class="tr">100.000</td>
                                <td class="tr">300.000</td>
                                <td class="tr">-</td>
                                <td class="tr">300.000</td>
                            </tr>
                            <tr class="even">
                                <td>PRO0101BLK02</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">2</td>
                                <td class="tr">100.000</td>
                                <td class="tr">200.000</td>
                                <td class="tr">-50.000</td>
                                <td class="tr">150.000</td>
                            </tr>
                            <tr class="odd">
                                <td>PRO0101BLK01</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">1</td>
                                <td class="tr">100.000</td>
                                <td class="tr">100.000</td>
                                <td class="tr">-</td>
                                <td class="tr">100.000</td>
                            </tr>
                            <tr class="even">
                                <td>PRO0101BLK02</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">2</td>
                                <td class="tr">100.000</td>
                                <td class="tr">200.000</td>
                                <td class="tr">-60.000</td>
                                <td class="tr">140.000</td>
                            </tr>
                            <tr class="odd">
                                <td>PRO0101BLK01</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">1</td>
                                <td class="tr">100.000</td>
                                <td class="tr">100.000</td>
                                <td class="tr">-</td>
                                <td class="tr">100.000</td>
                            </tr>
                            <tr class="even">
                                <td>PRO0101BLK02</td>
                                <td><a href="">Product Name</a> / Color / Size</td>
                                <td class="tr">2</td>
                                <td class="tr">100.000</td>
                                <td class="tr">200.000</td>
                                <td class="tr">-</td>
                                <td class="tr">200.000</td>
                            </tr>
                        </tbody>
                    </table>
                </div><!--table-wrapper-->

            </div><!--main-content-->

           