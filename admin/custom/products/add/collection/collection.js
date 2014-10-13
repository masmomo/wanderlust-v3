$(document).ready(function(){
	var a = $("#init_collection").val();
    var ajq = $.ajax({
		type: "POST",
		url: "custom/products/add/collection/ajax_collection.php",
		data: {a:a},
		error: function(jqXHR, textStatus, errorThrown) {
			//alert('Error: ' + textStatus + ' ' + errorThrown);
			}
		}).done(function(msg) {
			$('#category_field').before(msg);
		});
});
