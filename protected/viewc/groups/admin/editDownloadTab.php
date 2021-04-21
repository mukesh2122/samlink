<div class="message_container clearfix">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Edit Tab'); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="addtab_group_form">
        <input type="hidden" name="group_id" value="<?php echo $group->ID_GROUP; ?>">

		<div class="mt5 pr zi100">
			<label for="tabID" class="cp"><?php echo $this->__('Select Tab'); ?></label>
			<div class="jqtransform pr border clearfix mt2">
				<select id="tabID" name="tab_id" class="w570 tab_id jqselect">
					<?php foreach ($tabs as $tab): ?>
						<option value ="<?php echo $tab->ID_FILETYPE;?>"><?php echo $tab->FiletypeName; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

        <div class="mt5">
			<label for="tabName" class="cp"><?php echo $this->__('Name'); ?></label>
			<div class="border mt2">
				<input name="tab_name" class="w576 news_border tab_name" id="tabName" value="<?php echo $first_tabs->FiletypeName; ?>">
			</div>
		</div>

        <div class="clear mt10">&nbsp;</div>
        <a href="javascript:void(0);" class="link_green fr addtab_group"><span><span><?php echo $this->__('Save'); ?></span></span></a>
    </form>
</div>
<script type="text/javascript">loadDropdowns();</script>