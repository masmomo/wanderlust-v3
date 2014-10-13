<script>
$(document).ready(function(e) {
   // LOAD SELECT
   $('#custom_lang_select').load('custom/language/pages/about/select.php');
   
   function selectOptionLanguage(x){
   
      if(x != ''){
         $('#id_custom_select_lang option[value="'+x+'"]').attr('selected', true);
      }else{
         $('#id_custom_select_lang option[value="default"]').attr('selected', true);
      }

   }

   selectOptionLanguage('<?php echo $_SESSION['lang_admin'];?>');
   

   function changeLanguage(){
      var lang = $('#id_custom_select_lang option:selected').val();
   
      if(lang != "default"){
         location.href = "<?php echo $prefix_url;?>../../../../"+lang+"-about";
      }else{
         location.href = "<?php echo $prefix_url;?>../../../../about";
      }
   
   }

});
</script>

