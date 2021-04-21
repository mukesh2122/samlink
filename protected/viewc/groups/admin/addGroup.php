<div class="message_container">
	<?php if(Membership::isValidFeature('createGroup') === TRUE):?>
		<!-- header -->
		<div class="clearfix">
			<span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Create Group'); ?></span>
		</div>
		<!-- end header -->
		<form action="#" method="post" id="create_group_form">
			<div class="mt5">
				<label for="groupName" class="cp"><?php echo $this->__('Group Name');?></label>
				<div class="border mt2">
					<input name="group_name" class="w576 news_border group_name" id="groupName" />
				</div>
			</div>

			<div class="mt5">
				<label for="game_tags" class="cp"><?php echo $this->__('Search game');?></label>
				<div class="border mt2 rounded5 h16 pt5 pb5" id="game_tags_cont">
					<input name="group_game" class="w576 news_border dn" id="game_tags" value="" />
				</div>
			</div>

			<div class="mt5 pr zi100">
				<label for="groupType1" class="cp"><?php echo $this->__('Type 1');?></label>
				<div class="jqtransform pr border clearfix mt2">
					 <select id="groupType1" name="group_type1" class="w570 group_type1 jqselect">
						<?php foreach ($group_types as $type): ?>
							<?php if($type->Subtype == 1):?>
							<option value ="<?php echo $type->ID_GROUPTYPE; ?>"><?php echo $type->GroupTypeName; ?></option>
							<?php endif; ?>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="mt5 pr zi99">
				<label for="groupType2" class="cp"><?php echo $this->__('Type 2');?></label>
				<div class="jqtransform pr border clearfix mt2">
					 <select id="groupType2" name="group_type2" class="w570 group_type2 jqselect">
						<?php foreach ($group_types as $type): ?>
							<?php if($type->Subtype == 2):?>
							<option value ="<?php echo $type->ID_GROUPTYPE; ?>"><?php echo $type->GroupTypeName; ?></option>
							<?php endif; ?>
						<?php endforeach; ?>
					</select>
				</div>
			</div>

			<div class="mt5">
				<label for="groupDescription" class="cp"><?php echo $this->__('Group Description');?></label>
				<div class="border mt2">
					<textarea name="group_description" rows="5"  class="news_border w576" id="groupDescription"></textarea>
				</div>
			</div>

			<div class="clear mt10">&nbsp;</div>
			<a href="javascript:void(0)" class="link_green fr create_group_info"><span><span><?php echo $this->__('Create'); ?></span></span></a>
		</form>
		<script type="text/javascript">loadDropdowns();loadGroup();</script>
	<?php else:?>
		<?php echo $this->__('You have reached your groups limit. To create more groups, please buy additional groups.');?>
	<?php endif;?>
</div>
