<?php
function get_about($post_fill){
   $conn   = connDB();
   
   $sql    = "SELECT * FROM tbl_about WHERE `type` = '$post_fill'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result['fill'];
}

$about = get_about('about');
?>

<style>
.img-responsive.m_b_20{
   height:260px;
}
</style>

    <div class="container">
      <img class="img-responsive m_b_20" src="<?php echo $prefix_url;?>files/common/img_small-0.jpg" width="100%">
      <div class="content">
        <p style="line-height: 1.8;"><?=$about;?>
        </p>
      </div><!--.content-->
    </div><!--.container.main-->


<?php
if($_POST['btn_contact'] == ""){
   unset($_SESSION['alert']);
   unset($_SESSION['msg']);
}
?>
    
<script src="<?php echo $prefix_url.'script/contact.js'?>"></script>