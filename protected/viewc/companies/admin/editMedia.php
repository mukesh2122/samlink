<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Edit Media'); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="addmedia_company_form">
        <input type="hidden" name="company_id" value="<?php echo $company->ID_COMPANY; ?>">
        <input type="hidden" name="media_id" value="<?php echo $media->ID_MEDIA; ?>">

        <div class="comments-cont mt10">
            <div class="comments-top">
                <div class="comments-bot clearfix pr jqtransform">
                    <span class="fl db fclg fs12 pr5 pb5"><?php echo $this->__('Select Tab'); ?>:</span>
                    <div class="fl noborder">
                        <select name="tab" class="media_tab_type">
                            <?php foreach ($tabs as $url => $tab): ?>
                                <option <?php echo $media->MediaType == $tabs1[$url] ? 'selected="selected"' : ''; ?> value="<?php echo $url; ?>"><?php echo $tab; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="comments-cont mt10">
            <div class="comments-top">
                  <div class="comments-bot clearfix pr">
                    <span class="fl db fclg fs12 pr5 pb5"><?php echo $this->__('Name'); ?>:</span>
                    <span class="fl db"><input name="media_name" class="media_name" value="<?php echo $this->__($media->MediaName); ?>"></span>
                  </div>
            </div>
        </div>

        <div class="clear mt10">&nbsp;</div>
        <a href="javascript:void(0);" class="link_green fr editmedia_company"><span><span><?php echo $this->__('Save'); ?></span></span></a>
    </form>
</div>
<script type="text/javascript">loadDropdowns();</script>