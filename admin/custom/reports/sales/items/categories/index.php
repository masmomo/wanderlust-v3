<?php
include("control.php");

include("export.php");
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
                        <a target="_blank" href="<?php echo $prefix_url.'reports/exports/'.$date_title.' Sales By Items (Categories).xlsx'?>"><input type="button" class="btn grey main" value="Export"></a>
                        <a href=""><input type="button" class="btn green main" value="Refresh"></a>
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
                                <td class="tr"><?=$root_sales_detail['quantity'];?></td>
                                <td class="tr"></td>
                                <td class="tr"><?=price($root_sales_detail['subtotal']);?></td>
                                <td class="tr"><?php if($root_sales_detail['discount']!=0){ echo "-".price($root_sales_detail['discount']);}?></td>
                                <td class="tr"><?=price($root_sales_detail['subtotal']-$root_sales_detail['discount']);?></td>
                            </tr>

							<?php
							print_category($iteration,'top',0);
							function print_category($iteration,$parent,$i){
								$i++;
								foreach ($iteration[$parent] as $iteration_){



									$sales_detail = find_sales($iteration_['id']);
									//print_r($sales_detail);



									if ($sales_detail['quantity']>0){
										
									
										?>
										
										<tr class="rowhead-<?=$i;?>">
			                                <td></td>
			                                <td><?=ucfirst($iteration_['name']);?></td>
			                                <td class="tr"><?=$sales_detail['quantity'];?></td>
			                                <td class="tr"></td>
			                                <td class="tr"><?=price($sales_detail['subtotal']);?></td>
			                                <td class="tr"><?php if($sales_detail['discount']!=0){ echo "-".price($sales_detail['discount']);}?></td>
			                                <td class="tr"><?=price($sales_detail['subtotal']-$sales_detail['discount']);?></td>
			                            </tr>
			
										<?php
										if ($iteration[$iteration_['id']]==null){
											$sales_items = find_sales_items($iteration_['id']);
											$row = 1;
											foreach ($sales_items as $sales_item){
											?>
											<tr 
											<?php
											if($row%2==1){
												echo 'class="odd"';
											}
											else{
												echo 'class="even"';
											}
											?>
											>
				                                <td><?=$sales_item['type_code'];?></td>
				                                <td><a href=""><?=$sales_item['product_name'];?></a> / <?=$sales_item["type_name"];?> / <?=$sales_item["stock_name"];?></td>
				                                <td class="tr"><?=$sales_item['quantity'];?></td>
				                                <td class="tr"><?=price($sales_item['item_price']);?></td>
				                                <td class="tr"><?=price($sales_item['subtotal']);?></td>
				                                <td class="tr"><?php if($sales_item['discount']!=0){ echo "-".price($sales_item['discount']);}?></td>
				                                <td class="tr"><?=price($sales_item['subtotal']-$sales_item['discount']);?></td>
				                            </tr>
											
											<?php
												$row++;
											}
											
										}
									}



									print_category($iteration,$iteration_['id'],$i);
								}
							}
							?>
                     
                            
                        </tbody>
                    </table>
                </div><!--table-wrapper-->

            </div><!--main-content-->
			
			
<script>
$(document).ready($('body').addClass('reports'));
</script>