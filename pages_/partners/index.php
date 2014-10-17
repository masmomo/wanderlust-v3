<?php
function count_partner(){
   $conn   = conndB();
   $sql    = "SELECT COUNT(*) AS rows FROM tbl_store WHERE `visibility` = '1'";
   $query  = mysql_query($sql, $conn);
   $result = mysql_fetch_array($query);
   
   return $result;
}


function get_partner(){
   $conn   = conndB();
   $sql    = "SELECT * FROM tbl_store WHERE `visibility` = '1' ORDER BY `career_name`";
   $query  = mysql_query($sql, $conn);
   $row    = array();
   
   while($result = mysql_fetch_array($query)){
      array_push($row, $result);
   }
   
   return $row;
}


/* --- CALL FUNCTION --- */
$count_partner = count_partner();
$data_partner  = get_partner();
?>

    <div class="container">
      <img class="img-responsive m_b_20" src="<?php echo $prefix_url;?>files/common/img_small-0.jpg" width="100%">
      <div class="content">
        <div class="row">
        
          <?php
          if($count_partner['rows'] > 0){
		     
			 foreach($data_partner as $data_partner){
		  ?>
          
          <div class="col-xs-6">
            <div class="partner-box">
              <div class="row">
                <div class="col-xs-5">
                  <img src="<?php echo $prefix_url.'admin/static/thimthumb.php?src=../'.$data_partner['category_maps'].'&h=120&w=174&q=100';?>">
                </div>
                <div class="col-xs-7">
                  <p class="title"><strong><?php echo $data_partner['career_name'];?></strong></p>
                  <p>
                    <?php echo preg_replace("/\n/","\n<br>",$data_partner['description']).'<br>'?>
                    <a href="<?php echo 'http://www.'.$data_partner['website']?>"><?php echo 'www.'.$data_partner['website']?></a><br>
                    <a href="mailto:<?php echo $data_partner['email'];?>"><?php echo $data_partner['email'];?></a>
                  </p>
                </div>
              </div>
            </div>
          </div><!--.col-xs-6-->
          
		  <?php
			 }
			 
		  }else{
		  ?>
			 
          <div class="col-xs-12">
            <div class="partner-box">
              <div class="row">
                <p style="text-align:center;">Currently no partners</p>
              </div>
            </div>
          </div><!--.col-xs-6-->
             
		  <?php 
		  }
		  ?>
          
        </div>
      </div><!--.content-->
    </div><!--.container.main-->
