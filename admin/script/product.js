$(document).ready(function(){
	   changeAction();
});
                            
function changeAction(){
	  var action_ = document.getElementById('product-index-action').value;
		 	
	  if (action_=='delete'){
		 $("#product-index-option").addClass('hidden');
		 $("#product-index-conj").addClass('hidden');
	  }
	  else{
		 $("#product-index-option").removeClass('hidden');
		 $("#product-index-conj").removeClass('hidden');
	  }
}