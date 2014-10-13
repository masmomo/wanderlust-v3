var sf=1;
var a = $("#init_sizefit").val();

if(typeof a === 'undefined'){
   a = '';
}else{
   a = a;
}

while(document.getElementById('type_description_field_'+sf)!=null){
   if (document.getElementById('type_sizefit_'+sf)==null){
	  var a = $("#init_sizefit_"+sf).val();
      $('#type_description_field_'+sf).after('<li class="form-group row" id="type_sizefit_field_'+sf+'"><label class="col-xs-3 control-label" for="product-desc">Product Size & Fittings</label><div class="col-xs-9"><textarea class="form-control" rows="5" id="type_sizefit_'+sf+'" name="type_sizefit['+sf+']">'+a+'</textarea></div></li>');
   }
   sf++;
}

function addSizefitField(sf){
   if (document.getElementById('type_sizefit_'+sf)==null){
      var current_sizefit = $('#type_sizefit_1').val();
      $('#type_description_field_'+sf).after('<li class="form-group row" id="type_sizefit_field_'+sf+'"><label class="col-xs-3 control-label" for="product-desc">Product Size & Fittings</label><div class="col-xs-9"><textarea class="form-control" rows="5" id="type_sizefit_'+sf+'" name="type_sizefit['+sf+']">'+current_sizefit+'</textarea><p class="field-message error hidden">'+a+'</p></div></li>');
   }
}