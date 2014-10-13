<?php
include("control.php");

?>
<form method="post" enctype="multipart/form-data">


            <div class="sub-header clearfix">
                <div class="content">
                
                    <h2><?php echo $news_detail['news_title'];?></h2>
                    <div class="btn-placeholder">
                        <a href="<?php echo $prefix_url;?>news">
                        <input type="button" class="btn grey main" value="Cancel">
                        </a>
                        <a href="<?php echo $prefix_url.$_REQUEST['lang']."-news-edit/".$news_id."/".cleanurl($default_title);?>">
                        <input type="button" class="btn orange main" value="Edit">
                        </a>
                        <input type="submit" class="btn red main hidden" value="Delete" name="btn-edit-news">
                    </div>
                </div>
            </div>

            <div id="main-content">

                <div class="box clearfix">
                    <div class="desc">
                       
                       <!--custom-->
                       <?php
					   include("select.php");
					   ?>
                       
                        <h3>News Details</h3>
                        <p>Manage your news details from title, category, date, and content.</p>
                    </div>
                    <div class="content">
                        <ul class="field-set">
                            <li class="field field-select">
                                <label for="category">Category <span>*</span></label>
                                <p><?php echo ucwords(strtolower($news_detail['category_name']));?></p>
                                <select class="hidden input-select" id="category" name="category">
                                    <option value=""></option>
                                    <?php
                                    foreach($all_news_category as $category){
									   echo "<option value=\"".$category['category_id']."\">".$category['category_name']."</option>";
									}
									?>
                                </select>
                            </li>
                            <li class="field-divider"></li>
                            <li class="field">
                                <label>Title <span>*</span></label>
                                <p><?php echo $default_title;?></p>
                                <input type="text" class="hidden input-text" value="<?php echo $news_detail['news_title'];?>">
                            </li>
                            <li class="field">
                                <label>Date <span>*</span></label>
                                <p><?php echo $news_detail['news_created_date'];?></p>
                                <input type="text" class="hidden input-text" style="width: 300px">
                            </li>
                            <li class="field input-file clearfix">
                                <label>Cover Image</label>
                                <div class="clearfix" style="width: 550px; padding-bottom: 8px">
                                    <div class="fl image" style="width: 174px; height: 116px">
                                        <div class="hidden"><div class="image-delete"></div><div class="image-overlay"></div></div>
                                        <img class="" src="<?php echo $prefix_url."static/thimthumb.php?src=../".$news_detail['news_image']."&h=116&w=174&q=100";?>">
                                    </div>
                                </div>
                                <p class="field-message hidden" style="padding-top: 10px">Recommended dimensions of 228 x 152 px.</p>
                            </li>
                            <li class="field-divider"></li>
                            <li class="field">
                                <label>Content <span>*</span></label>
                                <p><?php echo preg_replace("/\n/","\n<br>",$default_content);?></p>
                                <textarea class="hidden" rows="8"></textarea>
                            </li>
                        </ul>
                    </div>
                </div><!--box-->

            </div><!--main-content-->
            
</form>
            
<script>
$('#category option[value=<?php echo $news_detail['news_category']?>]').attr('selected', 'selected');
</script>

            