function getFile(){
   document.getElementById("upfile").click();
 }
 
 function sub(obj){
    var file = obj.value;
    var fileName = file.split("\\");
    document.getElementById("file-text").innerHTML = fileName[fileName.length-1];
    document.myForm.submit();
    event.preventDefault();
  }

function loading(){
 	$("#loading").animate({"opacity":"0"},200,function(){
		$("#loading").css({"display":"none"});
	});
}

