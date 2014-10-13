$(document).ready(function(){
		$(".btn-placeholder.top-button").html(
		$(".btn-placeholder.top-button").html()+
		'<input type="button" id="multi_button" class="btn green main" value="Add Multiple Products" onclick="clickUploadMultiple()"/>'+
		'<input type="file" class="hidden" id="multi_files" name="multi_files[]" onchange="uploadMultiple()" multiple />');
	});
	
	function clickUploadMultiple(){
		document.getElementById("multi_files").click();
	}

	function uploadMultiple(){
		$('form[name="index-order"]').submit();
	}