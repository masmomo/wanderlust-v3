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
?>

    <div class="container">
      <img class="img-responsive m_b_20" src="<?php echo $prefix_url;?>files/common/img_small-0.jpg" width="100%">
      <div class="content">
        <div class="row">
          
		  <?php 
		  if($count_career['rows'] > 0){
		     
			 foreach($data_career as $data_career){
          ?>

          <div class="col-xs-4">
            <a data-toggle="modal" href="#myModal">
              <div class="career-box">
                <h3 class="h5 m_b_15"><?php echo $data_career['career_name'];?></h3>
                <p><?php echo $data_career['description'];?></p>
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

    <div class="modal fade career-modal" id="myModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <h4 class="m_b_20">Job Title</h4>
            <p style="color: #999">In five years, Wanderlust has gone from an idea to a mature, growing organization. We’re looking for an exceptional person to join the senior team and oversee finance and business operations with us.
              <br><br>
              The VP of Operations and Finance will report directly to the CEO. They will oversee finances, human resources, office administration, and operational aspects of payments and international expansion. They will ensure that the organization runs smoothly and efficiently.
              <br><br>
              The operational duties are vital, and so is cultural fit. Kickstarter is a place dedicated to helping creative projects come to life. Want to work at a “hot start-up”? This is probably not the job for you. We're working hard to build something independent and longterm — not prepping for an IPO or sale. We are hungry, we are passionate, and our mission truly comes first.
              <br><br>
              Sound like an organization you’d like to be a part of? Reach out. We can’t wait to hear from you.</p>
          </div>
          <div class="p_20">
            <p><strong style="color: #000000">Interested?</strong>
              <br>
              Send a little something about yourself to <a href="mailto:hello@mywanderlustories.com">hello@mywanderlustories.com</a> with links to your work. This position is full-time, on-site at our awesome office in Greenpoint, Brooklyn. Your compensation will include equity and health care.</p>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->


<?php
if($_POST['btn_contact'] == ""){
   unset($_SESSION['alert']);
   unset($_SESSION['msg']);
}
?>
    
<script src="<?php echo $prefix_url.'script/contact.js'?>"></script>