<script>
function readURL(input,i) {
      
   if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function (e) {
	     $("#upload-slider-"+i).removeClass("hidden");
		 $('#btn-slider-'+i).removeClass('hidden');
		 //$('#btn-link-'+i).removeClass('hidden');
		 $("#upload-slider-"+i).attr('src', e.target.result);
	     $("#slideshow-flag-"+i).val('notempty');
	     $('#id_slideshow_'+i).attr('checked','checked');
		 
		 //$('#row_slide').html($('#row_slide').html()+$('#new_image').html());
	  }
	  
	  reader.readAsDataURL(input.files[0]);
   }
	  
}


function openBrowser(i){
   document.getElementById("slider-"+i).click();
}


function removeButton(i){
	  
   var test = $('#upload-slider-'+i).attr('src');
	  
   if(test != ""){
      $("#remove-slider-"+i).removeClass("hidden");
	  $("#remove-slider-"+i).fadeIn("fast");
	  $("#btn-slider-"+i).attr('style','z-index:12; position:absolute');
	  $("#btn-link-"+i).attr('style','z-index:13; position:absolute');
	  
	  $("#slide-"+i).mouseleave(function(){
	     $("#remove-slider-"+i).fadeOut("fast");
	  });
	  
   }

}
   
   
function ajaxDeleteBanner(i){
   var bid = i;
	  
   var ajx   = $.ajax({
	              type : "POST",
				  url  : "../admin/pages/home/ajax/delete_banner.php",
				  data : {bid:bid},
				  error: function(jqXHR, textStatus, errorThrown) {
					   
					     }
						 
			      }).done(function(data) {	
				  //alert(data);
				  });
}


function clearImage(i){
   $('#tester-'+i).html('<input type="file" name="upload_slider_'+i+'" id="slider-'+i+'" onchange="readURL(this,'+i+')" class="hidden"/>');
   
   //<input type="file" name="upload_slider_<?php echo $slider['id'];?>" id="slider-<?php echo $slider['id'];?>" onchange="readURL(this,'<?php echo $slider['id'];?>')" class="hidden"/>
   $("#upload-slider-"+i).attr('src', '');
   //$("#upload-slider-"+i).fadeOut("slow");
   $("#upload-slider-"+i).addClass('hidden');
   $("#slideshow-flag-"+i).val('');
	   
   ajaxDeleteBanner(i);
}
   
   $('#link-pop').hide();
   
   function showLink(i){
	  /*
      $('#link-pop').attr('style', 'position:relative; z-index:1000;').fadeIn("fast");
      */
	  
      $('#link-id').val(i);   
	  $('#name-link').val($('#link-'+i).val());
	  
	  $('#btn_pop_save').attr('name','btn-link-banner');
	  $('#btn_pop_delete').attr('name','btn-link-banner');
   }
   
   function closeLink(){
      $('#link-pop').attr('style', '').fadeOut("fast"); 
      $('#name-link').removeAttr('name');   
   }
   
   $('#link-pop-banner').hide();

function showLinkBanner(i){
   $('#link-pop-banner').attr('style', 'position:relative; z-index:1000;').fadeIn("fast");
   $('#link-id-banner').val(i);   
   $('#name-link-banner').val($('#promo-url-'+i).val());
}

function closeLinkBanner(){
   $('#link-pop-banner').attr('style', '').fadeOut("fast"); 
   $('#name-link-banner').removeAttr('name');   
}
</script>