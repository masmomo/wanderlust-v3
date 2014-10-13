<?php
unset($_SESSION['lang_admin']);

echo '<input type="hidden" name="hidden_cid" id="id_hidden_cid" value="'.$_REQUEST['cid'].'">';
echo '<input type="hidden" name="hidden_cname" id="id_hidden_cname" value="'.$_REQUEST['cname'].'">';
?>