

            <div id="main-content">

                <div class="sub-header clearfix">
                    <h2>Add Product</h2>
                    <div class="btn-placeholder">
                        <input type="button" class="btn grey main" value="Cancel">
                        <input type="button" class="btn green main" value="Save Changes">
                        <input type="button" class="btn green main" value="Save Changes &amp; Exit">
                    </div>
                </div>

                <div class="box">
                    <div class="head"><h3>Basic Details</h3></div>
                    <div class="content">
                        <ul class="field-set">
                            <li class="field field-select">
                                <label for="brand">Brand <span>*</span></label>
                                <select class="input-select" id="brand" name="brand">
                                    <option selected value="xxxx"></option>
                                    <option value="xxxx">Monstore</option>
                                </select>
                                <p class="field-message error hidden">Content required</p>
                            </li>
                            <li class="field-divider"></li>
                            <li class="field field-select">
                                <label for="category">Product Category <span>*</span></label>
                                <select class="input-select" id="category" name="category">
                                    <option selected value="xxxx"></option>
                                    <option value="xxxx">Tops</option>
                                </select>
                            </li>
                            <li class="field field-select">
                                <label for="sizegroup">Size Group <span>*</span></label>
                                <select class="input-select" id="sizegroup" name="sizegroup">
                                    <option selected value="xxxx"></option>
                                    <option value="xxxx">General</option>
                                    <option value="xxxx">Bottoms</option>
                                </select>
                            </li>
                            <li class="field-divider"></li>
                            <li class="field field-select">
                                <label for="gender">Gender <span>*</span></label>
                                <select class="input-select" id="gender" name="gender">
                                    <option selected value="xxxx"></option>
                                    <option value="xxxx">Unisex</option>
                                    <option value="xxxx">Male</option>
                                    <option value="xxxx">Female</option>
                                    <option value="xxxx">Neither</option>
                                </select>
                            </li>
                            <li class="field-divider"></li>
                            <li class="field field-select">
                                <label for="collection">Collection <span>*</span></label>
                                <select class="input-select" id="collection" name="collection">
                                    <option selected value="xxxx"></option>
                                    <option value="xxxx">2012 Illusion</option>
                                </select>
                                <div class="btn row grey hidden">+</div>
                            </li>
                            <li class="field field-select">
                                <label for="series">Series <span>*</span></label>
                                <select class="input-select" id="series" name="series">
                                    <option selected value="xxxx"></option>
                                    <option value="xxxx">Series 1</option>
                                </select>
                            </li>
                            <li class="field field-select">
                                <label for="artist">Artist <span>*</span></label>
                                <select class="input-select" id="artist" name="artist">
                                    <option selected value="xxxx"></option>
                                    <option value="xxxx">Artist 1</option>
                                </select>
                            </li>
                            <li class="field-divider"></li>
                            <li class="field">
                                <label for="story">Story</label>
                                <textarea rows="5" id="story" name="story"></textarea>
                            </li>
                        </ul>
                    </div>
                </div><!--box-->

                <div class="box">
                    <div class="head"><h3>Variants</h3></div>
                    <div class="content">
                        <ul class="field-set">
                            <li class="field">
                                <label for="product-name">Product Name <span>*</span></label>
                                <input type="text" class="input-text" id="product-name" name="product-name">
                            </li>
                        </ul>
                        <ul class="field-set">
                            <li class="field-divider"></li>
                            <li class="field field-select">
                                <label for="color">Color <span>*</span></label>
                                <select class="input-select" id="color" name="color">
                                    <option selected value="xxxx"></option>
                                    <option value="xxxx">Black</option>
                                </select>
                                <div class="btn row grey hidden">+</div>
                            </li>
                            <li class="field">
                                <label for="sku">SKU</label>
                                <input type="text" class="input-text" id="sku" name="sku">
                            </li>
                            <li class="field">
                                <label for="price">Price <span>*</span></label>
                                <input type="text" class="input-text" id="price" name="price">
                                <p class="field-message">Excluding tax</p>
                            </li>
                            <li class="field">
                                <label for="product-desc">Product Description</label>
                                <textarea rows="5" id="product-desc" name="product-desc"></textarea>
                                <p class="field-message error hidden">Content required</p>
                            </li>
                            <script type="text/javascript">
                             function getFile(){
                               document.getElementById("upfile").click();
                             }
                             function sub(obj){
                                var file = obj.value;
                                var fileName = file.split("\\");
                                document.getElementById("file-text").innerHTML = fileName[fileName.length-1];
                                document.myForm.submit();
                                event.preventDefault();
                              }
                            </script>

                            <li class="field input-file clearfix">
                                <label for="xxxx">Main Image</label>
                                <div class="image"></div>
                                <div style="fl">
                                    <div class="btn grey row" onclick="getFile()" style="margin-right: 5px">Change Image</div>
                                    <div class="btn red row">Remove</div>
                                    <div style='height: 0px; width: 0px; overflow:hidden;'>
                                        <input type="file" id="upfile" name="xxxx" onchange="sub(this)">
                                    </div>
                                </div>
                                <p class="field-message" style="padding-top: 32px">Recommended dimensions of 500 x 500 px.</p>
                            </li>
                            <li class="field input-file clearfix">
                                <label for="xxxx">Image</label>
                                <div class="image"></div>
                                <div style="fl">
                                    <div class="btn grey row" onclick="getFile()" style="margin-right: 5px">Change Image</div>
                                    <div class="btn red row">Remove</div>
                                    <div style='height: 0px; width: 0px; overflow:hidden;'>
                                        <input type="file" id="upfile" name="xxxx" onchange="sub(this)">
                                    </div>
                                </div>
                                <p class="field-message" style="padding-top: 32px">Recommended dimensions of 500 x 500 px.</p>
                            </li>
                            <li class="field input-file clearfix">
                                <label for="xxxx">Image</label>
                                <div class="image"></div>
                                <div style="fl">
                                    <div class="btn grey row" onclick="getFile()" style="margin-right: 5px">Add Image</div>
                                    <div class="btn red row hidden">Remove</div>
                                    <div style='height: 0px; width: 0px; overflow:hidden;'>
                                        <input type="file" id="upfile" name="xxxx" onchange="sub(this)">
                                    </div>
                                </div>
                                <p class="field-message" style="padding-top: 32px">Recommended dimensions of 500 x 500 px.</p>
                            </li>
                            <li class="field">
                                <label for="sizes">Sizes</label>
                                <div>
                                    <p class="row-label">S</p>
                                    <input type="text" class="input-text" id="sizes" name="sizes" placeholder="0" style="width:50px; text-align:right">
                                </div>
                            </li>
                            <li class="field">
                                <label class="invisible" for="sizes">Sizes</label>
                                <div>
                                    <p class="row-label">M</p>
                                    <input type="text" class="input-text" id="sizes" name="sizes" placeholder="0" style="width:50px; text-align:right">
                                </div>
                            </li>
                            <li class="field">
                                <label class="invisible" for="sizes">Sizes</label>
                                <div>
                                    <p class="row-label">L</p>
                                    <input type="text" class="input-text" id="sizes" name="sizes" placeholder="0" style="width:50px; text-align:right">
                                </div>
                            </li>
                            <li class="field">
                                <label for="weight">Weight <span>*</span></label>
                                <input type="text" class="input-text" id="weight" name="weight" placeholder="0" style="width:90px; text-align:right">
                            </li>
                            <li class="clearfix"><div class="btn-placeholder"><input type="button" class="btn red main" value="Remove Variant"></div></li>
                        </ul>
                        <ul class="field-set">
                            <li class="field-divider"></li>
                            <li class="field field-select">
                                <label for="color">Color <span>*</span></label>
                                <select class="input-select" id="color" name="color">
                                    <option selected value="xxxx"></option>
                                    <option value="xxxx">Black</option>
                                </select>
                                <div class="btn row grey hidden">+</div>
                            </li>
                            <li class="field">
                                <label for="sku">SKU</label>
                                <input type="text" class="input-text" id="sku" name="sku">
                            </li>
                            <li class="field">
                                <label for="price">Price <span>*</span></label>
                                <input type="text" class="input-text" id="price" name="price">
                                <p class="field-message">Excluding tax</p>
                            </li>
                            <li class="field">
                                <label for="product-desc">Product Description</label>
                                <textarea rows="5" id="product-desc" name="product-desc"></textarea>
                                <p class="field-message error hidden">Content required</p>
                            </li>
                            <script type="text/javascript">
                             function getFile(){
                               document.getElementById("upfile").click();
                             }
                             function sub(obj){
                                var file = obj.value;
                                var fileName = file.split("\\");
                                document.getElementById("file-text").innerHTML = fileName[fileName.length-1];
                                document.myForm.submit();
                                event.preventDefault();
                              }
                            </script>

                            <li class="field input-file clearfix">
                                <label for="xxxx">Main Image</label>
                                <div class="image"></div>
                                <div style="fl">
                                    <div class="btn grey row" onclick="getFile()" style="margin-right: 5px">Change Image</div>
                                    <div class="btn red row">Remove</div>
                                    <div style='height: 0px; width: 0px; overflow:hidden;'>
                                        <input type="file" id="upfile" name="xxxx" onchange="sub(this)">
                                    </div>
                                </div>
                                <p class="field-message" style="padding-top: 32px">Recommended dimensions of 500 x 500 px.</p>
                            </li>
                            <li class="field input-file clearfix">
                                <label for="xxxx">Image</label>
                                <div class="image"></div>
                                <div style="fl">
                                    <div class="btn grey row" onclick="getFile()" style="margin-right: 5px">Change Image</div>
                                    <div class="btn red row">Remove</div>
                                    <div style='height: 0px; width: 0px; overflow:hidden;'>
                                        <input type="file" id="upfile" name="xxxx" onchange="sub(this)">
                                    </div>
                                </div>
                                <p class="field-message" style="padding-top: 32px">Recommended dimensions of 500 x 500 px.</p>
                            </li>
                            <li class="field input-file clearfix">
                                <label for="xxxx">Image</label>
                                <div class="image"></div>
                                <div style="fl">
                                    <div class="btn grey row" onclick="getFile()" style="margin-right: 5px">Add Image</div>
                                    <div class="btn red row hidden">Remove</div>
                                    <div style='height: 0px; width: 0px; overflow:hidden;'>
                                        <input type="file" id="upfile" name="xxxx" onchange="sub(this)">
                                    </div>
                                </div>
                                <p class="field-message" style="padding-top: 32px">Recommended dimensions of 500 x 500 px.</p>
                            </li>
                            <li class="field">
                                <label for="sizes">Sizes</label>
                                <div>
                                    <p class="row-label">S</p>
                                    <input type="text" class="input-text" id="sizes" name="sizes" placeholder="0" style="width:50px; text-align:right">
                                </div>
                            </li>
                            <li class="field">
                                <label class="invisible" for="sizes">Sizes</label>
                                <div>
                                    <p class="row-label">M</p>
                                    <input type="text" class="input-text" id="sizes" name="sizes" placeholder="0" style="width:50px; text-align:right">
                                </div>
                            </li>
                            <li class="field">
                                <label class="invisible" for="sizes">Sizes</label>
                                <div>
                                    <p class="row-label">L</p>
                                    <input type="text" class="input-text" id="sizes" name="sizes" placeholder="0" style="width:50px; text-align:right">
                                </div>
                            </li>
                            <li class="field">
                                <label for="weight">Weight <span>*</span></label>
                                <input type="text" class="input-text" id="weight" name="weight" placeholder="0" style="width:90px; text-align:right">
                            </li>
                            <li class="clearfix"><div class="btn-placeholder"><input type="button" class="btn red main" value="Remove Variant"></div></li>
                        </ul>
                        <ul class="field-set">
                            <li class="field-divider"></li>
                            <li class="clearfix"><div class="btn-placeholder"><input type="button" class="btn green main" value="Add Variant"></div></li>
                        </ul>
                    </div>
                </div><!--box-->

            </div><!--main-content-->

            
