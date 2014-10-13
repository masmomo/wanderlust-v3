<script type="text/javascript">

$(document).ready(function(){
	
	$.ajax({
		type: "POST",
		url: "custom/pages/home/promo/index.php",
		error: function(jqXHR, textStatus, errorThrown) {
		          //alert('Error: ' + textStatus + ' ' + errorThrown);
			   }
		}).done(function(msg) {
			
		   $("ul.field-set").html($("ul.field-set").html()+msg);
			
		});
		
		
	$.ajax({
		type: "POST",
		url: "custom/pages/home/banner/index.php",
		error: function(jqXHR, textStatus, errorThrown) {
		          //alert('Error: ' + textStatus + ' ' + errorThrown);
			   }
		}).done(function(msg) {
			
		   $("ul.field-set").html($("ul.field-set").html()+msg);
		   
		});

	
});	

</script>