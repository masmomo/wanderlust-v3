$(document).load(function() {
    //$('#children-1').hide();
	//$('#grandchild-2').hide();
    //$('#children-2').hide();
	//$('#grandchild-3').hide();
	//$('#grandchild-4').hide();
	//$('#children-5').hide();
});

$(document).ready(function() {
    //$('#children-1').hide();
	//$('#grandchild-2').hide();
    //$('#children-2').hide();
	//$('#grandchild-3').hide();
	//$('#grandchild-4').hide();
	//$('#children-5').hide();
});

function showMenu(i){
   
   $('#parent-'+i).mouseover(function(){
      //$('#children-'+i).fadeIn("fast");
	  $('#children-'+i).removeClass("hidden");
	  
	  if(i == 3){
		 //$('#granchild-4').addClass("hidden");
	  }else if(i == 4){
		 //$('#grandchild-3').addClass("hidden");
	  }else if(i == 1){
	     //$('#grandchild-2').addClass("hidden");
	  }else if(i == 2){
		 //$('#grandchild-3').addClass("hidden");
		 //$('#grandchild-4').addClass("hidden");
	  }
	  
   });
   
   $('#parent-'+i).mouseleave(function(){
	  $('#children-'+i).addClass("hidden");
	  $('#grandchild-2').addClass("hidden");
	  $('#grandchild-3').addClass("hidden");
	  $('#grandchild-4').addClass("hidden");
   });
   
   $('#child-'+i).mouseover(function(){
	  $('#grandchild-'+i).removeClass("hidden");
	  
	  if(i == 1 || i == 7){
		 $('#grandchild-2').addClass("hidden");
	  }else if(i == 3){
		 $('#grandchild-4').addClass("hidden");
		 $('#grandchild-3').removeClass("hidden");
	  }else if(i == 4){
		 $('#grandchild-3').addClass("hidden");
	  }else if(i > 6){
         //$('#grandchild-3').fadeOut("fast");
	     //$('#grandchild-4').fadeOut("fast");
	  }
	  
   });
   
   $('#children-5').mouseleave(function(){
      $('#children-5').fadeOut("fast");
   });
   
}

function clickSetting(){
   //$('#children-5').fadeIn("fast");
   $('#children-5').removeClass("hidden");
}

$('#utility').mouseleave(function(){
   //$('#children-5').fadeOut("fast");
   $('#children-5').addClass("hidden");
});