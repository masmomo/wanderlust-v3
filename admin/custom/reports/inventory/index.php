<?php
include("control.php");

include("export.php");

//STORED VALUE
echo "<input type=\"hidden\" name=\"url\" id=\"url\" class=\"hidden\" value=\"http://".$_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF'])."/reporting/inventory\">\n";
?>


            <div class="sub-header clearfix">
                <div class="content">
                    <h2>Inventory Details</h2>
                    <select class="input-select" id="category_name_search" onchange="selectCategoryInventory()">
                        <option value="top">All Categories</option>
                        <?php listCategory(0,'top',$root);?>
                    </select>
                </div>
            </div>

            <div id="main-content">

                <div class="clearfix">
                    <div class="report-filter clearfix fl">
                        <input type="text" class="input-text fl invisible" placeholder="Date from" value="Current">
                    </div>

                    <div class="btn-placeholder">
                        <a target="_blank" href="<?php echo $prefix_url.'reports/exports/'.date('dm').' Inventory Details ('.$root_name.').xlsx'?>"><input type="button" class="btn grey main" value="Export"></a>
                        <a href=""><input type="button" class="btn green main" value="Refresh"></a>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table cellpadding="0" cellspacing="0">
                        <thead>
                            <tr class="headings">
                                <th width="10%">SKU</th>
                                <th width="55%">
                                    Item<span class="sort-arrow-up"></span>
                                </th>
                                <th width="5%" style="text-align: right">Qty.</th>
                                <th width="15%" style="text-align: right">Value</th>
                                <th width="15%" style="text-align: right">Total Value</th>
                            </tr>
                        </thead>
                        <tbody onload="loading()">
                            <!--<div id="loading" style="position: absolute; z-index: 2; background: #000; width: 940px; height: 200px"></div>-->
                            <tr class="rowhead-0">
                                <td></td>
                                <td><?=$root_name;?></td>
                                <td class="tr"><?=$root_sales_detail['quantity'];?></td>
                                <td class="tr"></td>
                                <td class="tr"><?=price($root_sales_detail['subtotal']);?></td>
                            </tr>
                            

							<?php
							
							print_category($iteration,$root,0);
							
							function print_category($iteration,$parent,$i){
								$i++;
								if ($iteration!=null){
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
				                                <td class="tr"><?=price($sales_item['type_price']);?></td>
				                                <td class="tr"><?=price($sales_item['subtotal']);?></td>
				                                
				                            </tr>
											
											<?php
												$row++;
											}
											
										}
									}



									print_category($iteration,$iteration_['id'],$i);
								}
								} //iteration null
								else{
					
									$sales_items = find_sales_items($parent);
									
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
		                                <td class="tr"><?=price($sales_item['type_price']);?></td>
		                                <td class="tr"><?=price($sales_item['subtotal']);?></td>
		                                
		                            </tr>
									
									<?php
										$row++;
									}
								}
							}
							?>
							
                        </tbody>
                    </table>
                </div><!--table-wrapper-->

            </div><!--main-content-->



<script src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']);?>/reports/script/inventory.js"></script>  

<script>
$(document).ready($('body').addClass('reports'));
</script>