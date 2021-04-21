<?php if($mediaItem->MediaType==MEDIA_VIDEO){
    $videoClass="";
    $photoClass="dn";
}
else {
    $videoClass="dn";
    $photoClass="";
}
?>
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
            <h1 class="pull_left"><?php echo $this->__('Edit Media'); ?></h1>
    </div>
    <input type="hidden" name="ID_MEDIA" value="<?php echo $mediaItem->ID_MEDIA; ?>" />
    <input type="hidden" name="OwnerType" value="company" />
    
    <div class="standard_form_elements clearfix">

            <div class="clearfix">
                <label for="game_media_tab"><?php echo $this->__('Select Tab');?></label>
                <select name="MediaType" id="game_media_tab" class="change dropkick_lightWide">
                        <?php foreach ($tabs as $key => $tab): ?>
                                <?php $key==$mediaItem->MediaType ? $selected='selected="selected"' : $selected='' ?>
                                <option value="<?php echo $key; ?>" <?php echo $selected; ?> ><?php echo $tab; ?></option>
                        <?php endforeach; ?>
                </select>
            </div>
        <div class="clear pt10">&nbsp;</div>
        <input class="button button_auto light_blue pull_right" type="submit" value="<?php echo $this->__('Save Settings');?>" />
    </div>
</form>