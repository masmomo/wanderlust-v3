

            <div class="sub-header clearfix">
                <div class="content">
                    <h2>Inspiration</h2>
                    <div class="btn-placeholder">
                        <input type="button" class="btn grey main" value="Cancel">
                        <input type="button" class="btn green main" value="Save Changes">
                        <input type="button" class="btn green main" value="Save Changes &amp; Exit">
                    </div>
                </div>
            </div>

            <div id="main-content">

                <div class="box clearfix">
                    <div class="desc">
                        <h3>Banner</h3>
                        <p>Add inspiration page banners.</p>
                    </div>
                    <div class="content">
                        <ul class="field-set">
                            <li class="field input-file clearfix">
                                <label>Banners</label>
                                <div class="clearfix" style="width: 550px; padding-bottom: 8px">
                                    
                                    <?php
									function nth($per_row, $post_interate){
									   
									   if($post_interate % $per_row == 0){
									      $return = "margin-right:0px;";
									   }
									   
									   echo $return;
									   
									}
									
									$total_banner = 6;
                                    for($i=1;$i<=$total_banner;$i++){
									?>
                                    
                                    <div class="fl image" style="width: 174px; height: 80px; margin-bottom:10px; <?php nth(3, $i);?>">
                                        <div class="hidden">
                                           <div class="image-delete"></div>
                                           <div class="image-overlay"></div>
                                        </div>
                                        <img class="hidden" src="<?php echo $prefix;?>files/common/sample_product.jpg">
                                    </div>
                                    
                                    <?php
									}
									?>
                                    
                                </div>
                                <!--<div style="fl">
                                    <div class="btn grey row" onclick="getFile()" style="margin-right: 5px">Change Image</div>
                                    <div class="btn red row">Remove</div>
                                    <div style='height: 0px; width: 0px; overflow:hidden;'>
                                        <input type="file" id="upfile" name="xxxx" onchange="sub(this)">
                                    </div>
                                </div>-->
                                <p class="field-message" style="padding-top: 10px">Recommended dimensions of 940 x 400 px.</p>
                            </li>
                            <li class="field-divider"></li>
                        </ul>
                    </div>
                </div><!--box-->

                <div class="box clearfix">
                    <div class="desc">
                        <h3>Featured Products</h3>
                        <p>Edit inspiration featured products.</p>
                    </div>
                    <div class="content">
                        <ul class="field-set">
                            <li class="field">
                                <label for="product-name">Product 1</label>
                                <select class="input-select">
                                   <option>Product Name</option>
                                </select>
                            </li>
                            <li class="field">
                                <label for="product-name">Product 2</label>
                                <select class="input-select">
                                   <option>Product Name</option>
                                </select>
                            </li>
                            <li class="field">
                                <label for="product-name">Product 3</label>
                                <select class="input-select">
                                   <option>Product Name</option>
                                </select>
                            </li>
                            <li class="field">
                                <label for="product-name">Product 4</label>
                                <select class="input-select">
                                   <option>Product Name</option>
                                </select>
                            </li>
                            <li class="field">
                                <label for="product-name">Product 5</label>
                                <select class="input-select">
                                   <option>Product Name</option>
                                </select>
                            </li>
                            <li class="field">
                                <label for="product-name">Product 6</label>
                                <select class="input-select">
                                   <option>Product Name</option>
                                </select>
                            </li>
                            <li class="field">
                                <label for="product-name">Product 7</label>
                                <select class="input-select">
                                   <option>Product Name</option>
                                </select>
                            </li>
                            <li class="field">
                                <label for="product-name">Product 8</label>
                                <select class="input-select">
                                   <option>Product Name</option>
                                </select>
                            </li>
                        </ul>
                    </div>
                </div><!--box-->

            </div><!--main-content-->

            
