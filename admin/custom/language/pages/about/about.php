<?php 
include_once("xeditor/ckeditor.php");

include("get.php");
include("update.php");
include("control.php");
?>

<form method="post">

    <div class="subnav">
      <div class="container clearfix">
        <h1><span class="glyphicon glyphicon-font"></span> &nbsp; About</h1>
        <div class="btn-placeholder">
          <input type="submit" class="btn btn-success btn-sm" value="Simpan" name="btn_about_lang">
        </div>
      </div>
    </div>

    <?php
	if(!empty($_SESSION['alert'])){
	   echo '<div class="alert '.$_SESSION['alert'].'">';
	   echo '<div class="container">'.$_SESSION['msg'].'</div>';
	   echo '</div>';
	}
	
	if($_POST['btn_about_lang'] == ''){
	   unset($_SESSION['alert']);
	   unset($_SESSION['msg']);
	}
	?>
    
    <div class="container main">
    
      <div class="box row">
        <div class="desc col-xs-3">
        <h3>Konten</h3>
        <p>Deskripsi seputar perusahaan</p>
        
        <?php
        include("select.php");
		?>
        
      </div>
      
      <div class="content col-xs-9">
        <ul class="form-set">
          <li class="form-group row underlined">
            <label style="width:200px;">Sejarah</label>
            <br /><br />
            
            <?php
			$get_about          = get_about('about', $get_lang);
			$path               = get_dirname($_SERVER['PHP_SELF']);
			$CKEditor           = new CKEditor();
			$CKEditor->basePath = $path.'/xeditor/';
			$initialValue       = $get_about['fill'];
			$code               = $CKEditor->editor("about", $initialValue);
			?>
            
            <br />
            <input type="checkbox" id="id_custom_page_about_about" name="custom_page_about_about" value="yes"
            <?php if($get_about['fill'] == 'default'){ echo 'checked="checked"';}?>> Use default value
          </li>
          
          <li class="form-group row underlined">
            <label style="width:250px;">Visi & misi</label>
            <br /><br />
          
		    <?php
		    $get_about          = get_about('facilities', $get_lang);
		    $path               = get_dirname($_SERVER['PHP_SELF']);
		    $CKEditor           = new CKEditor();
		    $CKEditor->basePath = $path.'/xeditor/';
		    $initialValue       = $get_about['fill'];
		    $code               = $CKEditor->editor("facilities", $initialValue);
		    ?>
          
            <br />
            <input type="checkbox" name="custom_page_about_facilities" value="yes" 
            <?php if($get_about['fill'] == 'default'){ echo 'checked="checked"';}?>> Use default
          </li>
        
          <li class="form-group row underlined">
            <label style="width:250px;">Kebijakan Mutu</label>
            <br /><br />
          
		    <?php
		    $get_about          = get_about('quality', $get_lang);
		    $path               = get_dirname($_SERVER['PHP_SELF']);
		    $CKEditor           = new CKEditor();
		    $CKEditor->basePath = $path.'/xeditor/';
		    $initialValue       = $get_about['fill'];
		    $code               = $CKEditor->editor("quality", $initialValue);
		    ?>
          
            <br />
            <input type="checkbox" name="custom_page_about_quality" value="yes" 
            <?php if($get_about['fill'] == 'default'){ echo 'checked="checked"';}?>> Use default value
          </li>
        
          <li class="form-group row underlined">
            <label style="width:250px;">Kegiatan</label>
            <br /><br />
          
		    <?php
		    $get_about          = get_about('description', $get_lang);
		    $path               = get_dirname($_SERVER['PHP_SELF']);
		    $CKEditor           = new CKEditor();
		    $CKEditor->basePath = $path.'/xeditor/';
		    $initialValue       = $get_about['fill'];
		    $code               = $CKEditor->editor("description", $initialValue);
		    ?>
          
            <br />
            <input type="checkbox" name="custom_page_about_description" value="yes"  
			<?php if($get_about['fill'] == 'default'){ echo 'checked="checked"';}?>> Use default value
          </li>
        
          <li class="form-group row">
            <label style="width:250px;">Tanya Jawab</label>
            <br /><br />
          
		    <?php
		    $get_about          = get_about('faq', $get_lang);
		    $path               = get_dirname($_SERVER['PHP_SELF']);
		    $CKEditor           = new CKEditor();
		    $CKEditor->basePath = $path.'/xeditor/';
		    $initialValue       = $get_about['fill'];
		    $code               = $CKEditor->editor("faq", $initialValue);
		    ?>
          
            <br />
            <input type="checkbox" name="custom_page_about_faq" value="yes"  
			<?php if($get_about['fill'] == 'default'){ echo 'checked="checked"';}?>> Use default value
          </li>
        
        </ul>
      </div>
    </div><!--main-content-->
    
    <?php
	// HIDDEN VALUE
    echo '<input type="hidden" name="hidden_lang_code" value="'.$_SESSION['lang_admin'].'">';
	?>
    
  </form>
  
  <!--custom-->
  <?php
  include("custom/language/pages/about/index.php");
  ?>

           