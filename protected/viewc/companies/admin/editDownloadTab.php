<div class="message_container clearfix">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Edit Tab'); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="addtab_company_form">
        <input type="hidden" name="company_id" value="<?php echo $company->ID_COMPANY; ?>">

        <div class="comments-cont mt10">
            <div class="comments-top">
                <div class="comments-bot clearfix pr jqtransform">
                    <span class="fl db fclg fs12 pr5 pb5"><?php echo $this->__('Select Tab'); ?>:</span>
                    <div class="fl noborder">
                        <select name="tab_id" class="tab_id jqselect">
                            <?php foreach($tabs as $tab): ?>
                                <option value ="<?php echo $tab->ID_FILETYPE; ?>"><?php echo $this->__($tab->FiletypeName); ?></option>
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
                    <span class="fl db"><input name="tab_name" class="tab_name" value="<?php echo $first_tabs->FiletypeName; ?>"></span>
                </div>
            </div>
        </div>

        <div class="clear mt10">&nbsp;</div>
        <a href="javascript:void(0);" class="link_green fr addtab_company"><span><span><?php echo $this->__('Save'); ?></span></span></a>
    </form>
</div>
<script type="text/javascript">loadDropdowns();</script>