$(document).ready(function(){
    changeSizeType();
});

function changeColor(i){
	color_id = document.getElementById("color_id_"+i).value;
	document.getElementById("type_name_"+i).value = $("#color_id_"+i+" option[value='"+color_id+"']").text();
}

function getFile(){
   document.getElementById("upfile").click();
}



var browseflag=1;
function openBrowser(i){
   
   if(browseflag==1){
	   //alert(i);
      document.getElementById("product-"+i+'-image').click();
   }
}

function readURL(input,i) {
   
   if (input.files && input.files[0]) {
      var reader = new FileReader();
	  
	  reader.onload = function (e) {
		  $('#upload-image-'+i).removeClass('hidden');
		  $('#upload-image-'+i).attr('src', e.target.result);
	  }
	  
	  reader.readAsDataURL(input.files[0]);
	  document.getElementById("image-delete-"+i).value='0';
   }
}



function deleteOver(){  browseflag=0; }

function deleteOut(){   browseflag=1; }

function imageOver(i){   
   var img = $('#product-'+i+'-image').val();
   
   if(typeof(img) !== 'undefined' || img == ''){
      $('#image-'+i+'-delete').removeClass('hidden'); 
   }
}

function imageOut(i){    $('#image-'+i+'-delete').addClass('hidden'); }

function deleteImage(i,i_,j_){
	browseflag=0;
   $('#upload-image-'+i).addClass('hidden');
    
   document.getElementById('product-'+i+'-image-wrap').innerHTML = '<input type="file" name="product_image['+i_+']['+j_+']" id="product-'+i+'-image" onchange="readURL(this,\''+i+'\')" class="hidden"/>';
   document.getElementById("image-delete-"+i).value='1';
   //document.getElementById("product-1-1-image").value="";
   //$("#upload-image-"+i).attr("src","");
   //browseflag=1;
}

function getAlias(trial){

	trial = (trial === undefined) ? 0 : trial;
	
	$('#product_alias').css({"background-image":"url('../files/common/loader.gif')","background-repeat":"no-repeat","background-position":"right"});
	
	var product_name = document.getElementById("product_name").value;
	var product_id = document.getElementById("product_id").value;
	
	document.getElementById('page_title').value = product_name;
	
	product_name = product_name.replace(/[^a-zA-Z0-9\/_|+ -]/g,'');
	
	product_name = product_name.toLowerCase();
	product_name = product_name.replace(/[\/_|+ -]+/g,'-');
	
	if(trial!=0){
		product_name = product_name + '-' + trial;
	}
	
	var ajq = $.ajax({
		type: "POST",
		url: "products/add/ajax_check_alias.php",
		data: { product_alias: product_name,product_id: product_id },
		error: function(jqXHR, textStatus, errorThrown) {
			//alert('Error: ' + textStatus + ' ' + errorThrown);
			}
		}).done(function(msg) {
			
			if(msg=="existed"){
				trial++;
		
				getAlias(trial);
			}
			else{
				document.getElementById('product_alias').value=product_name;
				
				$('#product_alias').css({"background-image":"","background-repeat":"no-repeat","background-position":"right"});
			}
			
			//alert(msg);
		});								
	
}

function forceAlias(trial){

	trial = (trial === undefined) ? 0 : trial;
	
	$('#product_alias').css({"background-image":"url('../files/common/loader.gif')","background-repeat":"no-repeat","background-position":"right"});
	
	var product_name = document.getElementById("product_alias").value;
	
	//document.getElementById('page_title').value = product_name;
	
	product_name = product_name.replace(/[^a-zA-Z0-9\/_|+ -]/g,'');
	
	product_name = product_name.toLowerCase();
	product_name = product_name.replace(/[\/_|+ -]+/g,'-');
	
	if(trial!=0){
		product_name = product_name + '-' + trial;
	}
	
	var ajq = $.ajax({
		type: "POST",
		url: "products/add/ajax_check_alias.php",
		data: { product_alias: product_name },
		error: function(jqXHR, textStatus, errorThrown) {
			//alert('Error: ' + textStatus + ' ' + errorThrown);
			}
		}).done(function(msg) {
			
			if(msg=="existed"){
				trial++;
		
				forceAlias(trial);
			}
			else{
				document.getElementById('product_alias').value=product_name;
				
				$('#product_alias').css({"background-image":"","background-repeat":"no-repeat","background-position":"right"});
			}
			
			//alert(msg);
		});								
	
}

function changeSizeType(i){
	i = (i === undefined) ? 1 : i;
	if(document.getElementById("product_stock_list_"+i)!=null){
		
		var size_type_id = document.getElementById("size_type_id").value;
		var product_alias = document.getElementById("product_alias").value;
		
		var ajq = $.ajax({
		type: "POST",
		url: "products/details/ajax_size.php",
		data: { size_type_id: size_type_id, type_order : i, product_alias:product_alias},
		error: function(jqXHR, textStatus, errorThrown) {
			//alert('Error: ' + textStatus + ' ' + errorThrown);
			}
		}).done(function(msg) {
			
			document.getElementById('product_stock_list_'+i).innerHTML=msg;
			i++;
			changeSizeType(i);
			
			//alert(msg);
		});
	}
}

function deleteType(i){
	document.getElementById('type_delete_'+i).value=1;
	$("#type_group_"+i).css({"overflow":"hidden"});
	
	$("#type_group_"+i).animate({"height":0},$("#type_group_1").height());
}


function addVariant(){
	var data = new Array();
	var i = document.getElementById("next_type").innerHTML;
	
	var data = { 
		'price' : document.getElementById("type_price_1").value, 
		'desc' : document.getElementById("type_description_1").value,
		'weight' : document.getElementById("type_weight_1").value
		}
		
	

	
	var ajq = $.ajax({
		type: "POST",
		url: "products/add/ajax_type.php",
		data: { i:i,data:data},
		error: function(jqXHR, textStatus, errorThrown) {
			//alert('Error: ' + textStatus + ' ' + errorThrown);
			}
		}).done(function(msg) {
			
			document.getElementById('field_'+i).innerHTML=msg;
			
			
			//make visible
			$("#field_"+i).removeClass("hidden");
			
			var height = $("#type_group_1").height();
			$("#type_group_"+i).height(0);
			
			$("#type_group_"+i).animate({"height":height},$("#type_group_1").height());
													
			changeSizeType(i);
			
			//change the type
			document.getElementById('next_type').innerHTML = i*1+1;
			
			customTypeField(i);
			//alert(msg);
		});
	
}

function enableButton(){
	var product_name = $('#product_name').val();
	if(product_name!=''){
		$('.submit-button').removeAttr("disabled");
	}
	else{
		$('.submit-button').prop('disabled', true);
	}
	
	//$('.submit-button').removeAttr({"disabled"});
	//document.getElementById('x').disabled=false;
}


function validate_add(){
   
   /* --- DEFINE VARIABLE --- */
   var prod_name   = $('#product_name').val();
   var prod_cat    = $('#product_category option:selected').val();
   var prod_size   = $('#size_type_id option:selected').val();
   var nonum       = /^\d*[0-9](|.\d*[0-9]|,\d*[0-9])?$/
   
   // TYPE COLOR
   var counter   = $("select[id^=color_id_]").size();
   var arr_color = [];
   for(i=1;i<=counter;i++){
      var color_value = $('#color_id_'+i+' option:selected').val();
	  
	  if(color_value == 'No Color'){
		 var color_check = '0';
		 arr_color.push(color_check);
	  }else{
		 var color_check = '1';
		 arr_color.push(color_check);
	  }
	  
   }
   
   // TYPE PRICE
   var arr_price = [];
   for(i=1;i<=counter;i++){
      var price_value = $('#type_price_'+i).val();
	  
	  if(price_value == '' || !nonum.test(price_value)|| price_value == '0'){
		 var price_check = '0';
		 arr_price.push(price_check);
	  }else{
		 var price_check = '1';
		 arr_price.push(price_check);
	  }
	  
   }
   
   // TYPE WEIGHT
   var arr_weight = [];
   for(i=1;i<=counter;i++){
      var weight_value = $('#type_weight_'+i).val();
	  
	  if(weight_value == '' || weight_value == '0' || !nonum.test(weight_value)){
	     //$('#color_id_'+i).attr('style','border:1px solid #f00');
		 var weight_check = '0';
		 arr_weight.push(weight_check);
	  }else{
		 var weight_check = '1';
		 arr_weight.push(weight_check);
	  }
	  
   }
   
   $('#form_product_name').removeClass('has-error');
   $('#category_field').removeClass('has-error');
   $('#lbl_size_type_id').removeClass('has-error');
   $('#lbl_size_type_id').removeClass('has-error');
   $('#lbl_color_id_'+arr_color).removeClass('has-error');
   $('#lbl_color_price_'+arr_price).removeClass('has-error');
   $('#lbl_type_weight_'+arr_weight).removeClass('has-error');
   
   
   if(prod_name == ''){
      $('#form_product_name').addClass('has-error');
	  
	  alert('Product Name');
   }else if(prod_cat == ''){
      $('#category_field').addClass('has-error');
	  
	  alert('Product Category');
   }else if(prod_size == ''){
      $('#lbl_size_type_id').addClass('has-error');
	  alert('Product Size Type');
   }else if(jQuery.inArray('0', arr_color) != -1){
      
	  var temp_color = +jQuery.inArray('0', arr_color);
	  var add_color  = +1;
	  
	  $('#lbl_color_id_'+(temp_color+add_color)).addClass('has-error');
	  
	  alert('Product Color'+(+temp_color+add_color));
	  
   }else if(jQuery.inArray('0', arr_price) != -1){
      
	  var temp_price = +jQuery.inArray('0', arr_price);
	  var add_price  = +1;
	  
	  $('#lbl_color_price_'+(temp_price+add_price)).addClass('has-error');
	  
	  jQuery.each(arr_color, function(index, value){
	     $('#lbl_color_id_'+(+index + +1)).removeClass('has-error');
	  });
	  
	  alert('Product Price');
	  
   }else if(jQuery.inArray( "0", arr_weight ) != -1){
      
	  var temp_weight = +jQuery.inArray('0', arr_weight);
	  var add_weight  = +1;
	  
	  $('#lbl_type_weight_'+(temp_weight+add_weight)).addClass('has-error');
	  
	  jQuery.each(arr_price, function(index, value){
	     $('#lbl_color_price_'+(+index + +1)).removeClass('has-error');
	  });
	  
	  alert('Product Weight');
   }else{
	  
	  jQuery.each(arr_weight, function(index, value){
	     $('#lbl_type_weight_'+(+index + +1)).removeClass('has-error');
	  });
	  
	  $('#id_add_product').click();
   }
   
}