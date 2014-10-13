<?php
function count_career(){
   $conn   = conndB();
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_career WHERE `visibility` = '1'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_career(){
   $conn   = conndB();
   $sql    = "SELECT * FROM tbl_career WHERE `visibility` = '1'";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


/* --- CALL FUNCTION --- */
$count_career = count_career();
$data_career  = get_career();
$modal_career = get_career();
?>

    <div class="container">
      <img class="img-responsive m_b_20" src="<?php echo $prefix_url;?>files/common/img_small-0.jpg" width="100%">
      <div class="content">
        <div class="row">
          
		  <?php 
		  if($count_career['rows'] > 0){
		     
			 foreach($data_career as $key=>$data_career){
          ?>

          <div class="col-xs-4">
            <a data-toggle="modal" href="#myModal-<?php echo $key;?>">
              <div class="career-box">
                <h3 class="h5 m_b_15"><?php echo $data_career['career_name'];?></h3>
                <p><?php echo substr($data_career['description'], 0, 150).'..';?></p>
              </div>
            </a>
          </div>
          
          <?php 
			 }
          } 
          ?>
          
        </div>
      </div><!--.content-->
    </div><!--.container.main-->
    
    <?php
    foreach($modal_career as $key_modal=>$data_career){
	?>
    
    <div class="modal fade career-modal" id="myModal-<?php echo $key_modal;?>">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <h4 class="m_b_20"><?php echo $data_career['career_name'];?></h4>
            <p style="color: #999"><?php echo preg_replace("/\n/","\n<br>",$data_career['description']);?></div>
          <div class="p_20">
            <p><strong style="color: #000000">Interested?</strong>
              <br>
              Send a little something about yourself to <a href="mailto:<?php echo $info['email'];?>"><?php echo $info['email'];?></a> with links to your work. This position is full-time, on-site at our awesome office in Greenpoint, Brooklyn. Your compensation will include equity and health care.</p>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
    <?php
	}
	?>


<?php
if($_POST['btn_contact'] == ""){
   unset($_SESSION['alert']);
   unset($_SESSION['msg']);
}
?>
    
<script src="<?php echo $prefix_url.'script/contact.js'?>"></script>