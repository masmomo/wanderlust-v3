<?php
include('../../../xeditor/ckeditor_php5.php');
?>

      <div class="box row">
        <div class="desc col-xs-3">
          <h3>Content</h3>
          <p>Descriptions about your information.</p>
        </div>
        <div class="content col-xs-9">
          <ul class="form-set">
          
            <li class="form-group row underlined">
              <label class="control-label col-xs-12">How To Use</label><br /><br />
              <div class="col-xs-12">
                <?php
				$path = get_dirname($_SERVER['PHP_SELF']);
				$CKEditor = new CKEditor();
				$initialValue = 'How to use';
				$code = $CKEditor->editor("how", $initialValue);
				?>
              </div>
            </li>
            
            <li class="form-group row">
              <label class="control-label col-xs-12">Technical Data</label><br /><br />
              <div class="col-xs-12">
                <?php
				$path = get_dirname($_SERVER['PHP_SELF']);
				$CKEditor = new CKEditor();
				$initialValue = 'Technical Data';
				$code = $CKEditor->editor("technical", $initialValue);
				?>
              </div>
            </li>
            
          </ul>
        </div>
      </div><!--box-->