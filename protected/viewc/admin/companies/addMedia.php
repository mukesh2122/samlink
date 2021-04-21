<script type="text/javascript">
function dropkickChange() {
    var tab = document.getElementById('game_media_tab').value;
    if(tab == 'Video') {
        if ( $('.game_tab_video').hasClass('dn') ) {
            $('.game_tab_video').toggleClass('dn');
            $('.game_tab_images').toggleClass('dn');
        }
        else {
            return;
        }
    }
    else {
        if ( $('.game_tab_images').hasClass('dn') ) {
            $('.game_tab_video').toggleClass('dn');
            $('.game_tab_images').toggleClass('dn');
        }
        else {
            return;
        }
    }
};
</script>
<form action="" class="standard_form" method="post" id="addmedia_game_form" enctype="multipart/form-data">
    <div class="standard_form_header clearfix">
            <h1 class="pull_left"><?php echo $this->__('Add Media'); ?></h1>
    </div>
    <input type="hidden" name="ID_OWNER" value="<?php echo $company->ID_COMPANY; ?>" />
    <input type="hidden" name="OwnerType" value="company" />
    
    <div class="standard_form_elements clearfix">

            <div class="clearfix">
                <label for="game_media_tab"><?php echo $this->__('Select Tab');?></label>
                <select name="MediaType" id="game_media_tab" class="change dropkick_lightWide">
                        <?php foreach ($tabs as $key => $tab): ?>
                                <option value="<?php echo $key; ?>"><?php echo $tab; ?></option>
                        <?php endforeach; ?>
                </select>
            </div>

            <div class="mt5">
                    <label for="game_media_video" class="cp"><?php echo $this->__('Youtube link/upload files');?></label>
                    <div class="border mt2">
                            <div class="game_tab_video">
                                    <input id="game_media_video" name="media_videos" class="text_input fr" value="" />
                            </div>
                            <div class="game_tab_images dn">
                                    <div id="custom-queue"></div>
                                    <input id="game_media_images" name="Filedata" type="file" class="fr" />
                            </div>
                    </div>
            </div>
        <div class="clear pt10">&nbsp;</div>
        <input class="button button_auto light_blue pull_right" type="submit" value="<?php echo $this->__('Save Settings');?>" />
    </div>
</form>