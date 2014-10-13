<?php
include('control.php');
?>
<script>
$(function() {
   $("#sortable_promo").sortable();
   $("#sortable_promo").disableSelection();
});
</script>

<style>
#sortable_promo { list-style-type: none;}
#sortable_promo li { float: left;}
</style>

<li class="form-group row image-placeholder">
  <label class="control-label col-xs-3">Promo Banners</label>
    <div class="col-xs-9" id="promo_banner">
      <div class="row">
        <ul class="field-set" id="sortable_promo">
        
		  <?php
		  $promo_banner = get_promos();
		  $promo_row    = 1;
		  
		  foreach($promo_banner as $promo_banner){
		  ?>
          
          <li class="col-xs-4 image">
            <div onmouseover="removeButtonPromo(<?php echo $promo_banner['id'];?>)" id="promo-<?php echo $promo_banner['id'];?>" style="width: 100%">
              <div class="content img-about-size">
                <div class="hidden" id="remove-promo-<?php echo $promo_banner['id'];?>">
                  <div class="image-delete" id="btn-promo-1" onClick="clearImagePromo(<?php echo $promo_banner['id'];?>)">
                    <span class="glyphicon glyphicon-remove"></span>
                  </div>
                  
                  <div class="image-link <?php if(!empty($promo_banner['link'])){ echo "linked";}?>" onclick="showLinkPromo(<?php echo $promo_banner['id'];?>)" id="btn-link-<?php echo $last;?>"  href="#link-pops" data-toggle="modal"></div>
                  <div class="image-overlay" onClick="openBrowserPromo(<?php echo $promo_banner['id'];?>)"></div>
                </div>
                
                <img class="" id="upload-promo-<?php echo $promo_banner['id'];?>" src="<?php echo $prefix_url."../../../../static/thimthumb.php?src=../".$promo_banner['filename']."&h=80&w=174&q=100";?>">
                
                <div id="tester_<?php echo $promo_banner['id'];?>">
                  <input type="file" name="upload_promo_<?php echo $promo_banner['id'];?>" id="promos-<?php echo $promo_banner['id'];?>" onchange="readURLPromo(this,<?php echo $promo_banner['id'];?>)" class="hidden"/>
                </div><!--tester-->
                
                <input type="checkbox" class="hidden" name="promo_id[]" value="<?php echo $promo_banner['id'];?>" id="chk_promo_banner_<?php echo $promo_banner['id'];?>">
                <input type="hidden" name="promo_link_<?php echo $promo_banner['id'];?>" id="promo_link_<?php echo $promo_banner['id'];?>" value="<?php echo $promo_banner['link'];?>">
                <input type="hidden" name="promo_order[]" value="<?php echo $promo_banner['id'];?>">
                <input type="checkbox" class="hidden" name="promo_delete_<?php echo $promo_banner['id'];?>" value="<?php echo $promo_banner['id']?>" id="id_promo_delete_<?php echo $promo_banner['id']?>">
                <input type="hidden" name="hidden_image_<?php echo $promo_banner['id'];?>" value="<?php echo $promo_banner['filename'];?>">
                <input type="hidden" id="hidden_name_<?php echo $promo_banner['id'];?>" value="<?php echo $promo_banner['name'];?>">
              </div>
            </div> 
          </li>
          
		  <?php
		  }
		  ?>
          
        </ul><!--sortable-->
          
		  
		  
		  <?php
		  // EMPTY SPACE
		  $total_promo_banner = 4;
		  $promo_loop         = $total_promo_banner - $count_promo_banner['rows'];
		  for($i=($max_id_promo['max_id'] + 1); $i<=($promo_loop + $max_id_promo['max_id']); $i++){
		  ?>
          
          <div class="col-xs-4 image" id="promo-<?php echo $i;?>">
            <div class="content img-about-size">
              <div class="hidden" id="remove-promo-<?php echo $i;?>">
                <div class="image-delete" id="btn-promo-<?php echo $i;?>" onClick="clearImagePromo(<?php echo $i;?>)">
                  <span class="glyphicon glyphicon-remove"></span>
                </div>
              </div>
              
              <div class="image-overlay" onClick="openBrowserPromo(<?php echo $i;?>)"></div>
              <img class="hidden" id="upload-promo-<?php echo $i;?>">
              
              <div id="tester_<?php echo $i?>">
                <input type="file" name="upload_promo_<?php echo $i;?>" id="promos-<?php echo $i;?>" onchange="readURLPromo(this,<?php echo $i;?>)" class="hidden"/>
              </div>
              
              <input type="checkbox" class="hidden" name="promo_id[]" value="<?php echo $i;?>" id="chk_promo_banner_<?php echo $i;?>">
            </div>
          </div>
          
		  <?php
		  }
		  ?>
          
      </div><!--.row-->
      <p class="help-block">For first image recommended dimensions of 980 x 220 px for others recommended dimensions of 320 x 220 px.</p>
      
    </li>



<script>
function readURLPromo(input,i) {

   if (input.files && input.files[0]) {
      var reader = new FileReader();
   
      reader.onload = function (e) {
         //$("#upload-promo-"+i).fadeIn("slow");
         $("#upload-promo-"+i).attr('src', e.target.result);
		 $('#chk_promo_banner_'+i).attr('checked', true);
		 $('#upload-promo-'+i).removeClass("hidden");
		 
		 $('#promo-'+i).attr('onMouseOver','removeButtonPromo('+i+')');
		 $('#id_promo_delete_'+i).attr('checked', false);
      }
	  
	  reader.readAsDataURL(input.files[0]);
   }

}

function openBrowserPromo(i){
   $("#promos-"+i).click();
}

function showLinkPromo(i){
	/*
   $('#link-pop').attr('style', 'position:relative; z-index:1000;').fadeIn("fast");
   $('#link-id').val(i);  
   $('#name-link').val($('#promo_link_'+i).val());
   $('#pop_home_save').attr('name','btn_promo_link');
   $('#pop_home_delete').attr('name','btn_promo_link');
   */
   $('#name-link').val($('#promo_link_'+i).val());
   $('#link-id').val(i);
   $('#btn_pop_save').attr('name','btn_promo_link');
   $('#btn_pop_delete').attr('name','btn_promo_link');
   
   $( "#lbl_name_link" ).after('<span class="custom_promo_name"><li class="form-group row"> <label class="col-xs-3 control-label">Name</label> <div class="col-xs-9"> <input type="text" class="form-control" id="id_name_promo_link" name="name_promo_link"> <p class="help-block">Input name</p></div></li></div>');
   
   var name = $('#hidden_name_'+i).val();
   $('#id_name_promo_link').val(name);
   
}

function removeButtonPromo(i){
   $("#remove-promo-"+i).removeClass("hidden");
   $("#remove-promo-"+i).fadeIn("fast");
   $("#btn-promo-"+i).attr('style','z-index:1000; position:absolute');

   $("#promo-"+i).mouseleave(function(){
      $("#remove-promo-"+i).fadeOut("fast");
   });
}

function clearImagePromo(i){
   $('#upload-promo-'+i).addClass("hidden");
   $('#tester_'+i).html('<input type="file" name="upload_promo_'+i+'" id="promos-'+i+'" onchange="readURLPromo(this,'+i+')" class="hidden"/>');
   
   //$('#promo-'+i).removeAttr('onMouseOver');
   $('#id_promo_delete_'+i).attr('checked', true);
   
   ajaxDeletePromoBanner(i);
}


function ajaxDeletePromoBanner(i){
   var pid = i;
	  
   var ajx   = $.ajax({
	              type : "POST",
				  url  : "../admin/custom/pages/home/promo/ajax/ajax_delete.php",
				  data : {pid:pid},
				  error: function(jqXHR, textStatus, errorThrown) {
					   
					     }
						 
			      }).done(function(data) {	
				  });
}


function removeName(){
   $('.custom_promo_name').each(function(index, element) {
      $(this).html(' ') 
   });
}



$(document).ready(function(e) {
   $('#btn_cancel').click(function(){
      removeName();
   });
});
</script>