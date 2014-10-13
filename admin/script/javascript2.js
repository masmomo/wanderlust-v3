var select_counter=0,select_flag=1,select_all_flag=0,url;

function initialization(){
	url=document.getElementById("url").value;
	
}

function adminPanelFix(){
	$(window).scroll(function(){ 
		
		if ($(window).scrollTop()>=170){
			var width_fix;
			var window_width = $(window).width();
			if (window_width<=1024){
				width_fix = 960;
			}
			else{
				width_fix = window_width-64;
			}
			$(".admin_panel").css({"position":"fixed","top":"0px","left":"32px","width":width_fix,"-webkit-box-shadow":"0 6px 6px -3px #ececec","-moz-box-shadow":"0 6px 6px -3px #ececec","box-shadow":"0 6px 6px -3px #ececec"});
			//$(".admin_panel_slideshow").css({"position":"fixed","top":"0px","left":"32px","width":width_fix,"-webkit-box-shadow":"0 6px 6px -3px #ececec","-moz-box-shadow":"0 6px 6px -3px #ececec","box-shadow":"0 6px 6px -3px #ececec"})
		   }
		else{
			$(".admin_panel").css({"position":"relative","left":"0px","top":"1px","width":"100%","-webkit-box-shadow":"0 0 #ececec","-moz-box-shadow":"0 0 #ececec","box-shadow":"0 0 #ececec"});
			//$(".admin_panel_slideshow").css({"position":"relative","left":"0px","width":"100%","-webkit-box-shadow":"0 0 #ececec","-moz-box-shadow":"0 0 #ececec","box-shadow":"0 0 #ececec"});
		}
		
	});
}

function initializationSidebarTable(){
	url=document.getElementById("url").value;
	$(window).scroll(function(){ 
		
		if ($(window).scrollTop()>=220){
			var width_fix;
			var window_width = $(window).width();
			if (window_width<=1024){
				width_fix = 960;
			}
			else{
				width_fix = window_width-64;
			}
			$(".admin_panel").css({"position":"fixed","top":"0px","left":"32px","width":width_fix,"-webkit-box-shadow":"0 6px 6px -3px #ececec","-moz-box-shadow":"0 6px 6px -3px #ececec","box-shadow":"0 6px 6px -3px #ececec"});
			//$(".admin_panel_slideshow").css({"position":"fixed","top":"0px","left":"32px","width":width_fix,"-webkit-box-shadow":"0 6px 6px -3px #ececec","-moz-box-shadow":"0 6px 6px -3px #ececec","box-shadow":"0 6px 6px -3px #ececec"})
		   }
		else{
			$(".admin_panel").css({"position":"relative","left":"0px","top":"1px","width":"100%","-webkit-box-shadow":"0 0 #ececec","-moz-box-shadow":"0 0 #ececec","box-shadow":"0 0 #ececec"});
			//$(".admin_panel_slideshow").css({"position":"relative","left":"0px","width":"100%","-webkit-box-shadow":"0 0 #ececec","-moz-box-shadow":"0 0 #ececec","box-shadow":"0 0 #ececec"});
		}
		
	});
}

function initializationSidebarTables(){
	url=document.getElementById("url").value;
	
	var admin_panel_count = document.getElementById("admin_panel_count").innerHTML;
	var i_top = new Array();
	for (count=1;count<=admin_panel_count;count++){
		if (count!=1){
			i_top[count] = $("#admin_panel_"+count).offset().top-41;
		}
		else{
			i_top[count] = $("#admin_panel_"+count).offset().top;
		}
	}
	
	$(window).scroll(function(){ 
		for (count=1;count<=admin_panel_count;count++){
			var next = count*1+1;
			
			if (count==admin_panel_count){
				//var i_top = $("#admin_panel_"+count).offset().top;
				
				if ($(window).scrollTop()>=i_top[count]){
					var width_fix;
					var window_width = $(window).width();
					if (window_width<=1024){
						width_fix = 960;
					}
					else{
						width_fix = window_width-64;
					}
					$("#admin_panel_"+count).css({"position":"fixed","top":"0px","left":"32px","width":width_fix,"-webkit-box-shadow":"0 6px 6px -3px #ececec","-moz-box-shadow":"0 6px 6px -3px #ececec","box-shadow":"0 6px 6px -3px #ececec"});
					//$(".admin_panel_slideshow").css({"position":"fixed","top":"0px","left":"32px","width":width_fix,"-webkit-box-shadow":"0 6px 6px -3px #ececec","-moz-box-shadow":"0 6px 6px -3px #ececec","box-shadow":"0 6px 6px -3px #ececec"})
				   }
				else{
					$("#admin_panel_"+count).css({"position":"relative","left":"0px","top":"1px","width":"100%","-webkit-box-shadow":"0 0 #ececec","-moz-box-shadow":"0 0 #ececec","box-shadow":"0 0 #ececec"});
				}
			}
			else{
				if ($(window).scrollTop()>=i_top[count] && $(window).scrollTop()<i_top[next]){
					var width_fix;
					var window_width = $(window).width();
					if (window_width<=1024){
						width_fix = 960;
					}
					else{
						width_fix = window_width-64;
					}
					$("#admin_panel_"+count).css({"position":"fixed","top":"0px","left":"32px","width":width_fix,"-webkit-box-shadow":"0 6px 6px -3px #ececec","-moz-box-shadow":"0 6px 6px -3px #ececec","box-shadow":"0 6px 6px -3px #ececec"});
					//$(".admin_panel_slideshow").css({"position":"fixed","top":"0px","left":"32px","width":width_fix,"-webkit-box-shadow":"0 6px 6px -3px #ececec","-moz-box-shadow":"0 6px 6px -3px #ececec","box-shadow":"0 6px 6px -3px #ececec"})
				   }
				else{
					$("#admin_panel_"+count).css({"position":"relative","left":"0px","top":"1px","width":"100%","-webkit-box-shadow":"0 0 #ececec","-moz-box-shadow":"0 0 #ececec","box-shadow":"0 0 #ececec"});
				}
			}
		
		}
		
	});
}

function tableSidebar(){
	$(".fill_container_sidebar").width($("#admin_header").width()-215-64);
	$(window).resize(function(){
		$(".fill_container_sidebar").width($("#admin_header").width()-215-64);
	});
}

function adjustSidebar(){
	
	
}

function initializationSidebar(){
	//url=document.getElementById("url").value;
	$(window).scroll(function(){ 
		
		if ($(window).scrollTop()>=125){
			var width_fix;
			var window_width = $(window).width();
			if (window_width<=1024){
				width_fix = 1024;
			}
			else{
				width_fix = window_width;
			}
			$("#page_title_bar").css({"position":"fixed","top":"0px","width":width_fix,"-webkit-box-shadow":"0 6px 6px -3px #ececec","-moz-box-shadow":"0 6px 6px -3px #ececec","box-shadow":"0 6px 6px -3px #ececec"});
			//$(".admin_panel_slideshow").css({"position":"fixed","top":"0px","left":"32px","width":width_fix,"-webkit-box-shadow":"0 6px 6px -3px #ececec","-moz-box-shadow":"0 6px 6px -3px #ececec","box-shadow":"0 6px 6px -3px #ececec"})
		   }
		else{
			$("#page_title_bar").css({"position":"relative","width":"100%","-webkit-box-shadow":"0 0 #ececec","-moz-box-shadow":"0 0 #ececec","box-shadow":"0 0 #ececec"});
			//$(".admin_panel_slideshow").css({"position":"relative","left":"0px","width":"100%","-webkit-box-shadow":"0 0 #ececec","-moz-box-shadow":"0 0 #ececec","box-shadow":"0 0 #ececec"});
		}
		
	});
}

function showSubmenu(submenu){
	$("#"+submenu).css({"display":"block"});
}
function hideSubmenu(submenu){
	$("#"+submenu).css({"display":"none"});
}

function selectFile(file_input){
	document.getElementById(file_input).click();
}

function confirmLogout(){
	var question = confirm ("Are you sure you want to log out?");
	var prefix=document.getElementById("prefix").innerHTML;
	if (question) {
		location.href = prefix+"logout.php";
	}
	
}

function deleteFile(counter){
	
	
	var question = confirm ("Are you sure you want to delete?");
	
	if (question) {
	location.href = "delete.php?order="+counter;
}
}

function selectRow(row){
	
	if (select_flag==1){
	var checkbox_status = document.getElementById("check_"+row).checked;
	if (checkbox_status==true){
		select_counter=select_counter-1;
		document.getElementById("check_"+row).checked=false;
		if (row%2=="1"){
			$("#row_"+row).css({"background-color":"#f6f6f6"});
		}
		else{
			$("#row_"+row).css({"background-color":"#ffffff"});
			
		}
		changeCounter();
	}
	else{
		select_counter=select_counter*1+1;
		document.getElementById("check_"+row).checked=true;
		$("#row_"+row).css({"background-color":"#e2f0cf"});
		changeCounter();
	}
	}
}

function selectRowCheck(row){
	//if (select_flag==1){
	var checkbox_status = document.getElementById("check_"+row).checked;
	if (checkbox_status==false){
		select_counter=select_counter-1;
		//document.getElementById("check_"+row).checked=false;
		if (row%2=="1"){
			$("#row_"+row).css({"background-color":"#f6f6f6"});
		}
		else{
			$("#row_"+row).css({"background-color":"#ffffff"});
			
		}
		changeCounter();
	}
	else{
		select_counter=select_counter*1+1;
		//document.getElementById("check_"+row).checked=true;
		$("#row_"+row).css({"background-color":"#e2f0cf"});
		changeCounter();
	}
	//}
}

function forceSelect(row){
	
	var checkbox_status = document.getElementById("check_"+row).checked;
	document.getElementById("check_"+row).checked=true;
	$("#row_"+row).css({"background-color":"#e2f0cf"});
	
	if (checkbox_status==false){
		select_counter=select_counter*1+1;
		
		changeCounter();
	}
	
}

function downCheck(){
	select_flag=0;
}

function upCheck(){
	select_flag=1;
}

function selectAllToggle(){
	if (select_all_flag==0){
		selectAll();
		
	}
	else{
		unselectAll();
	}
}

function selectAll(){
	for (row=1;document.getElementById("row_"+row)!=null;row++){
		document.getElementById("check_"+row).checked=true;
		
		$("#row_"+row).css({"background-color":"#e2f0cf"});
	}
	select_counter = row-1;
	changeCounter();
	document.getElementById("select_all").checked=true;
	select_all_flag=1;
}

function unselectAll(){
	for (row=1;document.getElementById("row_"+row)!=null;row++){
		
		document.getElementById("check_"+row).checked=false;
		if (row%2=="1"){
			$("#row_"+row).css({"background-color":"#f6f6f6"});
		}
		else{
			$("#row_"+row).css({"background-color":"#ffffff"});
			
		}
	}
	select_counter = 0;
	changeCounter();
	document.getElementById("select_all").checked=false;
	select_all_flag=0;
}

function changeCounter(){
	//document.getElementById("selected_counter").innerHTML=select_counter;
}

function sortBy(sort_by){
	
	var current_sort = document.getElementById("sort_by").value;
	if (sort_by==current_sort){
		sort_by=sort_by+" DESC";
	}
	
	var query_per_page = document.getElementById("query_per_page").value;
	
	
	var search = document.getElementById("search").value;
	/*if (document.getElementById("category_id")!=null){
		var category_id = document.getElementById("category_id").value;
		
		location.href = url+"?page=1&query_per_page="+query_per_page+"&sort_by="+sort_by+"&search="+search+"&category_id="+category_id;
	}else if (document.getElementById("user_id")!=null){
		
		if (document.getElementById("user_id").value!=""){
		var user_id = document.getElementById("user_id").value;
		location.href = url+"?page=1&query_per_page="+query_per_page+"&sort_by="+sort_by+"&search="+search+"&user_id="+user_id;
		}	
		else{
			location.href = url+"?page=1&query_per_page="+query_per_page+"&sort_by="+sort_by+"&search="+search;
		}
	
	}
	else{*/
		
		location.href = url+"/page-1/list-"+query_per_page+"/sort-"+sort_by+"/"+search;
		
	//}
}

//page
function goToPage(page){
	var total_page = document.getElementById("total_page").value;
	if (page>0&&page<=total_page){
	   var sort_by = document.getElementById("sort_by").value;
	   var query_per_page = document.getElementById("query_per_page").value;
	   var search = document.getElementById("search").value;
	   
	   location.href = url+"/page-"+page+"/list-"+query_per_page+"/sort-"+sort_by+"/"+search;
	}
}

function pageOption(){
   var e = document.getElementById("page-option");
   var strUser = e.options[e.selectedIndex].value;
   
   var sort_by = document.getElementById("sort_by").value;
   var query_per_page = document.getElementById("query_per_page").value;
   var search = document.getElementById("search").value;
   
   location.href = url+"/page-"+strUser+"/list-"+query_per_page+"/sort-"+sort_by+"/"+search;
}



function pageInput(){
	if(event.keyCode == 13){
        var page = document.getElementById("page_text_box").value;
		goToPage(page);
    }
	
}

function changeQueryPerPage(){
	var page = document.getElementById("page").value;
	var sort_by = document.getElementById("sort_by").value;
	var query_per_page = document.getElementById("query_per_page_input").value;
	var search = document.getElementById("search").value;
	
	location.href = url+"/page-1/list-"+query_per_page+"/sort-"+sort_by+"/"+search;
	
	//location.href = url+"?page=1&query_per_page="+query_per_page+"&sort_by="+sort_by+"&search="+search;
	
}

function disableEnterKey(e)
{
     var key;
     if(window.event)
          key = window.event.keyCode;     //IE
     else
          key = e.which;     //firefox
     if(key == 13)
          
			
			return false;
			
     else
          return true;
}

function searchQuery(s){
	if(event.keyCode == 13){
        
		var sort_by = document.getElementById("sort_by").value;
		var query_per_page = document.getElementById("query_per_page_input").value;
		
		var value = document.getElementById(s+"_search").value;
		var search = s+" LIKE '%25"+value+"%25'";
		location.href=url+"/page-1/list-"+query_per_page+"/sort-"+sort_by+"/"+search;
    }
}

function searchQueryExact(s){
	if(event.keyCode == 13){
        
		var sort_by = document.getElementById("sort_by").value;
		var query_per_page = document.getElementById("query_per_page_input").value;
		
		var value = document.getElementById(s+"_search").value;
		var search = s+" = '"+value+"'";
		
		if(s != 0){
		   location.href=url+"/page-1/list-"+query_per_page+"/sort-"+sort_by+"/"+search;
		}
	}
}

function searchQueryOption(s){
   var sort_by = document.getElementById("sort_by").value;
   var query_per_page = document.getElementById("query_per_page_input").value;
   var value = document.getElementById(s+"_search").value;
   
   var search = s+"= '"+value+"'";
   
   if(value == "reset"){
      var url_reset = document.getElementById("url-reset").value;
      location.href=url_reset;
   }else{
      location.href=url+"/page-1/list-"+query_per_page+"/sort-"+sort_by+"/"+search;
   }
}

function searchStatus(value){
	var sort_by = document.getElementById("sort_by").value;
	var query_per_page = document.getElementById("query_per_page_input").value;
	//var value = document.getElementById("status_search").value;
	var search = "order_status='"+value+"'";
	location.href=url+"/page-1/list-"+query_per_page+"/sort-"+sort_by+"/"+search+"/order_status="+value;
}

function toggleChild(parent){
	var status = document.getElementById("status_"+parent).innerHTML;
	var selected_ = document.getElementById("selected_"+parent).innerHTML;
	if (status=="close"){
		$(".under_"+parent).css({"display":"block"});
		document.getElementById("status_"+parent).innerHTML="open";
		if (selected_==1){
			var arrow_url = 'url("../../files/web_images/minus_light.png")';
		}
		else{
			var arrow_url = 'url("../../files/web_images/minus_dark.png")';
		}
		
		$("#arrow_sidebar_"+parent).css({"background-image":arrow_url});
	}
	else{
		$(".under_"+parent).css({"display":"none"});
		document.getElementById("status_"+parent).innerHTML="close";
		if (selected_==1){
			var arrow_url = 'url("../../files/web_images/plus_light.png")';
		}
		else{
			var arrow_url = 'url("../../files/web_images/plus_dark.png")';
		}
		
		$("#arrow_sidebar_"+parent).css({"background-image":arrow_url});
	}
}




