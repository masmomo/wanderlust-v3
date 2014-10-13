<?php 
include_once("xeditor/ckeditor.php");

include("control.php");
include("custom/pages/about/control.php");
?>

<form method="post">

    <div class="subnav">
      <div class="container clearfix">
        <h1><span class="glyphicon glyphicon-font"></span> &nbsp; About</h1>
        <div class="btn-placeholder">
          <input type="submit" class="btn btn-success btn-sm" value="Save Changes" name="btn-about">
        </div>
      </div>
    </div>

    <?php
	if(!empty($_SESSION['alert'])){
	   echo '<div class="alert '.$_SESSION['alert'].'">';
	   echo '<div class="container">'.$_SESSION['msg'].'</div>';
	   echo '</div>';
	}
	
	if($_POST['btn-about'] == ''){
	   unset($_SESSION['alert']);
	   unset($_SESSION['msg']);
	}
	?>

    <div class="container main">

      <div class="box row">
        <div class="desc col-xs-3" id="custom_lang">
          <h3>Content</h3>
          <p>Descriptions about your company.</p>
          
        </div>
        <div class="content col-xs-9">
          <ul class="form-set">
            <li class="form-group row underlined">
              <label class="control-label col-xs-12">History</label><br /><br />
              <div class="col-xs-12">
                
				<?php
				$get_about = get_about('about');
				$path = get_dirname($_SERVER['PHP_SELF']);
				$CKEditor = new CKEditor();
				$CKEditor->basePath = $path.'/xeditor/';
				$initialValue = $get_about['fill'];
				$code = $CKEditor->editor("about", $initialValue);
				?>
                
              </div>
            </li>
                            
            <li class="form-group row underlined">
              <label class="control-label col-xs-12">Vision &amp; Mission</label><br /><br />
              <div class="col-xs-12">
                
				<?php
				$get_facilities = get_about('facilities');
				$path = get_dirname($_SERVER['PHP_SELF']);
				$CKEditor = new CKEditor();
				$CKEditor->basePath = $path.'/xeditor/';
				$initialValue = $get_facilities['fill'];
				$code = $CKEditor->editor("facilities", $initialValue);
				?>
                
              </div>
            </li>

            <li class="form-group row">
              <label class="control-label col-xs-12">Quality Policy</label><br /><br />
              <div class="col-xs-12">
              
                <?php
				$get_quality = get_about('quality');
				$path = get_dirname($_SERVER['PHP_SELF']);
				$CKEditor = new CKEditor();
				$CKEditor->basePath = $path.'/xeditor/';
				$initialValue = $get_quality['fill'];
				$code = $CKEditor->editor("quality", $initialValue);
				?>
                
              </div>
            </li>

            <li class="form-group row">
              <label class="control-label col-xs-12">Activities</label><br /><br />
              <div class="col-xs-12">
              
                <?php
				$get_quality = get_about('description');
				$path = get_dirname($_SERVER['PHP_SELF']);
				$CKEditor = new CKEditor();
				$CKEditor->basePath = $path.'/xeditor/';
				$initialValue = $get_quality['fill'];
				$code = $CKEditor->editor("description", $initialValue);
				?>
                
              </div>
            </li>

            <li class="form-group row">
              <label class="control-label col-xs-12">FAQ</label><br /><br />
              <div class="col-xs-12">
              
                <?php
				$get_quality = get_about('faq');
				$path = get_dirname($_SERVER['PHP_SELF']);
				$CKEditor = new CKEditor();
				$CKEditor->basePath = $path.'/xeditor/';
				$initialValue = $get_quality['fill'];
				$code = $CKEditor->editor("faq", $initialValue);
				?>
                
              </div>
            </li>
          </ul>
        </div>
      </div><!--box-->

    </div><!--container-main-->
            
</form>

<?php include("custom/pages/about/about.php");?>         