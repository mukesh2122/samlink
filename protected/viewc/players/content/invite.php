<?php include(realpath(dirname(__FILE__) . '/../common/top.php')); ?>

<?php
echo $this->renderBlock('players/common/title_bar', array(
	'title' => $this->__('Invite friends'),
));
?>

<div class="ftu_form mt10">

<div class="F_openInviterBox clearfix">
	<?php MainHelper::showInviter(); ?>
</div>
<div class="F_inviteByEmail dn">
	<form id="F_simpleInviter">
		<div class="F_simpleInviterOutput p5 mb10 dn"></div>
		<input type="hidden" name="fieldsCount" id="F_fieldsCount" value="1"/>
		<div class="clearfix">
			<div class="fl">
				<input class="text_input thTextbox inviteByEmail_1 mb0" type="text" name="inviteByEmail_1" value=""/>
				<label for="inviteByEmail_1" class="errInviteByEmail_1" class="dn db"></label>
			</div>

			<a href="javascript:void(0)" class="F_addInviteByEmail db fl mt5 ml5"><?php echo $this->__('Add more fields'); ?></a>
		</div>
		<div class="add_button clearfix">
			<a href="javascript:void(0)" class="button button_medium mint mrg_fix F_sendInvitationsByEmail"><?php echo $this->__('Invite friends'); ?></a>
		</div>
		<div class="mt10">
			<a href="javascript:void(0)" class="F_showInviter"><?php echo $this->__('Import contacts from your e-mail account'); ?></a>
		</div>
	</form>
</div>

<div class="mt10">
	<?php echo $this->__('For each friend that registers on PlayNation, we will reward you with 100 Coins'); ?>
	<a href="javascript:void(0)" class="F_helpBubble" rel="<?php echo $this->__('Coins is one of PlayNations virtual currencies and can be used to buy certain products and services on the site.'); ?>">?</a>
</div>
</div>