<script>
<?php 
//for($i=1;$i<3;$i++){
//$get_promo = get_promo($i);

//if(empty($get_promo['filename'])){
?>
$("#upload-promo-<?php echo $i;?>").hide();
<?php
//} 
//}//foreach
?>

function readURLPromo(input,i) {

if (input.files && input.files[0]) {
var reader = new FileReader();
reader.onload = function (e) {
$("#upload-promo-"+i).fadeIn("slow");
$("#upload-promo-"+i).attr('src', e.target.result);
$("#promo-flag-"+i).val('notempty');
}

reader.readAsDataURL(input.files[0]);
}

}

function openBrowserPromo(i){
   $("promos-"+i).click();
}

function removeButtonPromo(i){
$("#remove-promo-"+i).removeClass("hidden");
$("#remove-promo-"+i).fadeIn("slow");
$("#btn-promo-"+i).attr('style','z-index:1000; position:absolute');

$("#promo-"+i).mouseleave(function(){
$("#remove-promo-"+i).fadeOut("slow");
});
}

function clearImagePromo(i){
$("#upload-promo-"+i).attr('src', '');
$("#upload-promo-"+i).fadeOut("slow");
$("#promo-flag-"+i).val('');
}

</script>