function selectCategoryInventory(){
   var current_category = document.getElementById("category_name_search").value;
  
   
   location.href=url+"/"+current_category;
}