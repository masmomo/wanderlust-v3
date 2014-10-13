<?php
unset($_SESSION['lang_admin']);

echo '<input type="hidden" id="custom_news_detail_nid" value="'.$_REQUEST['cid'].'">';
echo '<input type="hidden" id="custom_news_detail_nn" value="'.cleanurl($detail_category['category_name']).'">';
?>