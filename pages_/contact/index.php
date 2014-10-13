<?php
if(isset($_POST['btn_contact'])){
   
   if($_POST['btn_contact'] == "Submit"){
   
      //send mail
      $_POST['message'] = removeHtmlTags($_POST['message']);

      $name      = $_POST['contact_name']; 
      $email     = $_POST['email']; 
      $recipient = $info['email']; 
      $mail_body = preg_replace("/\n/","\n<br>",$_POST['message']);;
      $subject   = "[".$general['website_title']."] ".$_POST['subject']; 
      $headers   = "Content-Type: text/html; charset=ISO-8859-1\r\n".
      $headers  .= "From: ". $name . " <" . $email . ">\r\n";

      mail($recipient, $subject, $mail_body, $headers);
	  
	  $_SESSION['alert'] = "success";
	  $_SESSION['msg']   = "Thank you! We will review your email as soon as possible.";
   }
   
}
?>

<style>
.has-error { border:2px solid #cc0000;}
</style>

    <div class="container main">
      <img src="<?php echo $prefix_url;?>files/common/img_line-dotted.png" width="100%" height="2">
      <div class="content">
        
        

        <div class="row">
          <div class="col-xs-4">
            <img src="<?php echo $prefix_url?>script/holder.js/100%x400">
          </div>
          <div class="col-xs-8">
                    <?php 
                if(!empty($_SESSION['alert'])){
                ?>
                    <div class="alert alert-<?php echo $_SESSION['alert'];?>"><?php echo $_SESSION['msg'];?></div>
                    <?php
                }
                ?>
            <h1 class="heading">CONTACT</h1>
              <p class="m_b_20">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
            <form role="form" method="post" class="form-horizontal">
              <div class="form-group">
                <label class="control-label col-xs-3">Name</label>
                <div class="col-xs-9">
                  <input type="text" class="form-control" name="contact_name" id="id_contact_name">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-xs-3">Email</label>
                <div class="col-xs-9">
                  <input type="email" class="form-control" name="contact_email" id="id_contact_email">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-xs-3">Subject</label>
                <div class="col-xs-9">
                  <input type="text" class="form-control" name="contact_subject" id="id_contact_subject">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-xs-3">Message</label>
                <div class="col-xs-9">
                  <textarea class="form-control" rows="5" name="contact_msg" id="id_contact_msg"></textarea>
                </div>
              </div>
              <input type="button" class="btn btn-primary pull-right " value="Submit" onclick="validation()" id="btn_alias">
              <input type="submit" class="hidden" value="Submit" name="btn_contact" id="id_btn_contact">
            </form>
          </div>
        </div><!--.row-->

      </div><!--.content-->
    </div><!--.container.main-->


<?php
if($_POST['btn_contact'] == ""){
   unset($_SESSION['alert']);
   unset($_SESSION['msg']);
}
?>
    
<script src="<?php echo $prefix_url.'script/contact.js'?>"></script>