<input type="hidden" id="init_gender" value="<?=$custom_data['product_gender'];?>"/>
<input type="hidden" id="init_artist" value="<?=$custom_data['product_artist'];?>"/>
<input type="hidden" id="init_series" value="<?=$custom_data['product_series'];?>"/>
<input type="hidden" id="init_collection" value="<?=$custom_data['product_collection'];?>"/>
<input type="hidden" id="init_story" value="<?=$custom_data['product_story'];?>"/>

<input type="hidden" id="init_sizefit" value="<?=$custom_data['product_sizefit'];?>"/>
<input type="hidden" id="init_usd" value="<?=$custom_data['product_usd'];?>"/>


<script src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']);?>/custom/products/add/custom.js"></script>


<!--gender module-->
<script src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']);?>/custom/products/add/gender/gender.js"></script>

<!--artist module-->
<script src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']);?>/custom/products/add/artist/artist.js"></script>

<!--series module-->
<script src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']);?>/custom/products/add/series/series.js"></script>

<!--collection module-->
<script src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']);?>/custom/products/add/collection/collection.js"></script>



<!--story module-->
<script src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']);?>/custom/products/add/story/story.js"></script>


<!--image module-->
<script src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']);?>/custom/products/add/image/image.js"></script>

<!--sizefit module-->
<script src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']);?>/custom/products/add/sizefit/sizefit.js"></script>

<!--USD Module-->
<script src="http://<?php echo $_SERVER['HTTP_HOST'].get_dirname($_SERVER['PHP_SELF']);?>/custom/products/add/usd/ajax_usd.js"></script>