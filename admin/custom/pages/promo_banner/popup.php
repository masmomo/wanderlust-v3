
<?php /* -- POP UP LINK PROMO BANNER -- */?>

<form method="post" enctype="multipart/form-data">
        <div class="" id="link-pop-banner">
            <div class="overlay over-link">
                <div class="header">
                    <h2>Image Link</h2> 
                    <div class="btn-placeholder">
                        <input type="hidden" name="banner_id" id="link-id-banner">
                        <input type="button" class="btn grey main" value="Cancel" onclick="closeLinkBanner()">
                        <input type="submit" class="btn red main" value="Delete" name="btn-link-promo">
                        <input type="submit" class="btn green main" value="Save Changes" name="btn-link-promo">
                    </div>
                </div>
                <div class="content">
                    <ul class="field-set">
                        <li class="field clearfix">
                            <label>Link</label>
                            <input type="text" class="input-text" id="name-link-banner" name="banner_link">
                            <p class="field-message">Paste your link here.</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="overlay_bg70" onclick="closeLinkBanner()"></div>
        </div>
</form>