<?php if(isset($group) and $group): ?>
	<tr class="small_list_tr F_group_<?php echo $group->ID_GROUP; ?>">
		<td>
			<div class="no-margin clearfix">
				<?php echo $group->GroupName; ?>
			</div>
		</td>
		<td>
			<div class="no-margin clearfix">
				<a class="db fclg" href="<?php echo $group->GROUP_URL . '/request-to-join'; ?>" rel="iframe">
					<?php echo $this->__('Request to join group'); ?>
				</a>
			</div>
		</td>
	</tr>
<?php endif; ?>