

    <div class="container">
      <img class="img-responsive m_b_20" src="<?php echo $prefix_url;?>files/common/img_small-0.jpg" width="100%">
      <div class="content">
        <div class="row">
          <?php 
          for($i=0;$i<7;$i++){
          ?>
          <div class="col-xs-4">
            <a data-toggle="modal" href="#myModal">
              <div class="career-box">
                <h3 class="h5 m_b_15">Job Title</h3>
                <p>Lead research accross the company and help to make sure research findings are synthesized and translated into actionable objectives.</p>
              </div>
            </a>
          </div>
          <?php 
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