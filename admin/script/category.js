$(document).ready(function(){
   
   changeAction();
   
   $("#add-category-popup").hide();
   $("#btn-delete").hide();
   
   $("#btn-add-category").click(function(){
      $("#add-category-popup").fadeIn("slow");
	  $("#category_id").val("");
	  $("#category_active_status_active").val("");
	  $("#category_visibility_status_active").val("");
	  
   });
   
   $("#btn-add-category-cancel").click(function(){
      $("#add-category-popup").fadeOut("slow");
   });
   
   $(".overlay_bg70").click(function(){
      $("#add-category-popup").fadeOut("slow");
   });
   
   $("#btn-add-category-cancel").click(function(){
   
      $('#checkbox').find(':checked').each(function() {
      $(this).removeAttr('checked');
   
   });
   
});
   
});

function changeAction(){
	  var action_ = document.getElementById('category-action').value;
		 	
	  if (action_=='delete'){
		 $("#category-option").addClass('hidden');
		 $("#category-conj").addClass('hidden');
	  }
	  else{
		 $("#category-option").removeClass('hidden');
		 $("#category-conj").removeClass('hidden');
	  }
}

