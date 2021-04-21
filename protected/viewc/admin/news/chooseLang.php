<?php $editUrl = isset($editURL) ? $editURL : $item->EDIT_URL; ?>
<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Choose Locale'); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="edit_news_lang_form">
        <input type="hidden" name="editUrl" id="editUrl" value="<?php echo $editUrl; ?>">
        <div class="mt5 pr zi100">
            <label for="languages" class="cp"><?php echo $this->__('Available locales');?></label>
            <div class="pr clearfix mt2">
                <select id="languages" name="languages" class="w530 languages">
                    <?php foreach($lang as $key => $l): ?>
                        <option value="<?php echo $key; ?>"><?php echo $l; ?></option>
                    <?php endforeach; ?>
               </select>
            </div>
        </div>
        <div class="clear mt10"></div>
        <a href="javascript:void(0);" class="link_green fr choose_news_lang"><span><span><?php echo $this->__('Edit locale'); ?></span></span></a>
        <div class="clear"></div>
    </form>
</div>
<script type="text/javascript">
    loadFancybox();
    $("#languages").dropkick({theme : "dropkick_lightwide"});
</script>