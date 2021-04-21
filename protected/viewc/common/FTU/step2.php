<?php
$friends = $user->getFriendsSuggestions();
?>
<div class="ftu_form yellow_box rounded_5">
	<div class="box_header clearfix">
		<h3><?php echo $this->__('Find your friends on PlayNation (Optional)'); ?></h3>
		<div class="ftu_form_steps">
			<a href="javascript:void(0)" class="ftu_form_step F_loadFTUStep" rel="0">1</a>
			<a href="javascript:void(0)" class="current_step" rel="1">2</a>
			<a href="javascript:void(0)" class="ftu_form_step F_loadFTUStep" rel="2">3</a>
			<a href="javascript:void(0)" class="ftu_form_step F_loadFTUStep" rel="3">4</a>
		</div>
	</div>


	<p>
		<?php echo $this->__('Here you can search the users who already have a user profile on PlayNation.'); ?><br />
		<?php echo $this->__('You can search by first name, last name, display name, city and e-mail.'); ?><br />
		<?php echo $this->__('So if you know the nick name your friends usually use, just type it in the box and hit “Search”'); ?>
	</p>
	<div class="wide_search_box">
		<input type="text" class="wide_search_box_input withLabel F_searchPlayersInput" title="<?php echo $this->__('Search for players...'); ?>" value="<?php echo $this->__('Search for players...'); ?>" />
		<a href="javascript:void(0)" class="wide_search_box_button mint F_searchPlayers"><?php echo $this->__('Search'); ?></a>
	</div>

	<?php if (!empty($friends)): ?>
		<div class="small_list_container">
			<table class="small_list_table F_searchPlayersList">
				<tbody>
					<?php foreach ($friends as $f): ?>
						<?php echo $this->renderBlock('common/playerSmall', array('player' => $f, 'id' => 'F_addFriend')); ?>
					<?php endforeach; ?>
				</tbody>
				<tfoot>
					<tr class="small_list F_zeroPlayersFound dn">
						<td>
							<div class="no-margin clearfix tac">
								<?php echo $this->__('No players found'); ?>
							</div>
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	<?php endif; ?>

	<div class="add_button clearfix">
		<a href="javascript:void(0)" class="button button_medium mint F_addToFriends"><?php echo $this->__('Add Friends'); ?></a>
	</div>

	<div class="box_header box_header_plus clearfix">
		<h3><?php echo $this->__('Invite your friends to PlayNation'); ?></h3>
	</div>

	<p>
		<?php echo $this->__('The e-mail inviter can search through your contacts in your email. You just fill out the boxes to gain access to your contacts and then select which you want to invite.'); ?><br />
		<?php echo $this->__('We do not store any information you type into these boxes.'); ?>
	</p>

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
<div class="ftu_form_footer clearfix">
	<a href="javascript:void(0)" class="button button_medium light_blue F_loadFTUStep fl" rel="0"><?php echo $this->__('Previous'); ?></a>
	<a href="javascript:void(0)" class="button button_medium light_blue F_loadFTUStep fr" rel="2"><?php echo $this->__('Next'); ?></a>
</div>
<script type="text/javascript">loadCheckboxes();</script>
