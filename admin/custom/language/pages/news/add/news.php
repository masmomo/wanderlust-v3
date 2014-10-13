<?php include_once("xeditor/ckeditor.php");?>

<?php
include("get.php");
include("update.php");
include("control.php");
//include("ajax.php");
?>

<form method="post">
            <div class="sub-header clearfix">
                <div class="content">
                    <h2>Tentang Perusahaan</h2>
                    <div class="btn-placeholder">
                        <!--<input type="button" class="btn grey main" value="Cancel">-->
                        <input type="submit" class="btn green main" value="Simpan" name="btn_about_lang">
                        <!--<input type="submit" class="btn green main" value="Save Changes &amp; Exit" name="btn-about">-->
                    </div>
                </div>
            </div>

            <div id="main-content">

                <div class="box clearfix">
                    <div class="desc">
                       
                       <div id="custom_lang_select"></div>
                       
                        <h3>Konten</h3>
                        <p>Deskripsi seputar perusahaan</p>
                    </div>
                    <div class="content">
                        <ul class="field-set">
                            <li class="field input-file clearfix">
                                <label>Visi &amp; Misi</label><br /><br />
                                <span style="width:550px">
                                <?php
								$get_about          = get_about('about', $get_lang);
								$path               = get_dirname($_SERVER['PHP_SELF']);
								$CKEditor           = new CKEditor();
								$CKEditor->basePath = $path.'/xeditor/';
								$initialValue       = $get_about['fill'];
								$code               = $CKEditor->editor("about", $initialValue);
								?>
                                </span>
                            </li>
                            <li class="field-divider"></li>
                            <li class="field input-file clearfix">
                                <label>Fasilitas Produksi</label><br /><br />
                                <span style="width:550px">
                                <?php
								$get_about          = get_about('facilities', $get_lang);
								$path               = get_dirname($_SERVER['PHP_SELF']);
								$CKEditor           = new CKEditor();
								$CKEditor->basePath = $path.'/xeditor/';
								$initialValue       = $get_about['fill'];
								$code               = $CKEditor->editor("facilities", $initialValue);
								?>
                                </span>
                            </li>
                            <li class="field-divider"></li>
                            <li class="field input-file clearfix">
                                <label>Manajemen Mutu</label><br /><br />
                                <span style="width:550px">
                                <?php
								$get_about          = get_about('quality', $get_lang);
								$path               = get_dirname($_SERVER['PHP_SELF']);
								$CKEditor           = new CKEditor();
								$CKEditor->basePath = $path.'/xeditor/';
								$initialValue       = $get_about['fill'];
								$code               = $CKEditor->editor("quality", $initialValue);
								?>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div><!--box-->

            </div><!--main-content-->
            
</form>

    <!--custom-->
    <?php
    include("sources/language/pages/about/index.php");
	?>

           