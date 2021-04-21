<?php if (isset($invite) and !empty($invite)): ?>
	<div class="inviter_step_2">
		<div class="JscrollPane">
			<table class="small_list_table">
			<?php $count = 0; ?>
			<?php foreach ($invite as $email => $name): ?>
				<tr class="small_list">
					<td>
						<div class="no-margin clearfix">
							<input id="check_<?php echo $count; ?>" name='check_<?php echo $count; ?>' value='<?php echo $count; ?>' type='checkbox' class='F_inviteeEmail' checked />
							<label for="check_<?php echo $count; ?>"><strong><?php echo $email; ?></strong> <?php echo $name; ?></label>
							<input id="F_email_<?php echo $count; ?>" type='hidden' name='email_<?php echo $count; ?>' value='<?php echo $email; ?>'>
							<input type='hidden' name='name_<?php echo $count; ?>' value='<?php echo $name; ?>' />
						</div>
					</td>
				</tr>
			<?php $count++; ?>
			<?php endforeach; ?>
			</table>
		</div>
		<div class="tar">
			<a href="javascript:void(0);" class="F_inviterSelectAll"><?php echo $this->__('Select all'); ?></a> | <a href="javascript:void(0);" class="F_inviterSelectNone"><?php echo $this->__('Select none'); ?></a>
		</div>
	</div>
	<div class="add_button clearfix">
		<a href="javascript:void(0)" class="button button_medium mint F_sendSiteInvitations"><?php echo $this->__('Send invitations'); ?></a>
	</div>
<?php endif; ?>
<script type="text/javascript">loadCheckboxes();</script>
