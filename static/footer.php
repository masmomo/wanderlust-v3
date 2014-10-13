<div class="">
	<div class="footer" style="margin-top: 30px">
		<div class="container">
			<img class="m_b_20" src="<?php echo $prefix_url;?>files/common/img_line-dotted.png" width="100%" height="2">
			<div class="row">
				<div class="col-xs-3">
					<div class="heading">Contact</div>
					<a href="mailto:<?php echo $general['company_email'];?>" style="display:block; margin-bottom: 3px"><?php echo $general['company_email'];?></a>
					<p><?php echo $general['company_phone'];?></p>
				</div>
				<div class="col-xs-3">
					<div class="heading">Content</div>
					<ul>
						<li><a href="<?php echo $prefix_url;?>about">About</a></li>
						<li><a href="<?php echo $prefix_url;?>contact">Contact</a></li>
						<li><a href="<?php echo $prefix_url;?>partners">Partners</a></li>
						<li><a href="<?php echo $prefix_url;?>career">Career</a></li>
					</ul>
				</div>
				<div class="col-xs-3">
                
                  <?php
                  function social($url){
				     
					 $raw_url = $url;
					 $check_url = substr($url, 0, 6);
					 
					 if($check_url === $url){
					    $url = $url;
					 }else{
					    $url = 'http://'.$url;
					 }
					 
					 return $url;
					 
				  }
				  
				  $social_facebook  = social($general['company_facebook']);
				  $social_twitter   = social($general['company_twitter']);
				  $social_instagram = social($general['company_instagram']);
				  ?>
                
                  <div class="heading">Social</div>
                  <ul>
                    <li><a target="_blank" href="<?php echo $social_facebook;?>">Facebook</a></li>
                    <li><a target="_blank" href="<?php echo $social_twitter;?>">Twitter</a></li>
                    <li><a target="_blank" href="<?php echo $social_instagram;?>">Instagram</a></li>
                  </ul>
                </div>
				<div class="col-xs-3">
					<div class="heading">Newsletter</div>
					<form id="newsletter_form" action="javascript:submitNewsletter()" method="get" class="form-inline" role="form">
				  
					  <div class="clearfix">
						  <div class="form-group">
						    <label class="hidden sr-only" for="exampleInputEmail2">Email</label>
						    <input type="email" name="newsletter_email" id="newsletter_email_1" class="form-control custom" placeholder="Type your email" style="width: 185px; padding: 6px 8px;">
						  </div>
						  <button type="submit" name="newsletter_submit" id="newsletter_submit_1" class="btn btn-primary btn-sm" style="height: 34px; margin-left: -4px">Go</button>
					  </div>
					</form>
					<p id="newsletter_label" style="margin-top: 10px; font-size: 10px">Subscribe to Wanderlust newsletter for to stay in the know!</p>
				</div>
			</div>
	  </div>
	</div>

	<div class="footer text-center" style="background: #fff; font-size: 11px">
		<div class="container">
			<img class="m_b_15" src="<?php echo $prefix_url;?>files/common/img_line-dotted.png" width="100%" height="2">
			<p>&copy; 2014 Wanderlust. All rights reserved.</p>
		</div>
	</div>

</div>

<input type="hidden" id="prefix_url" value="<?=$prefix_url;?>" />

