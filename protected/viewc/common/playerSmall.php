<?php if(isset($player) and $player): ?>
	<tr class="small_list_tr F_player_<?php echo $player->ID_PLAYER; ?>">
		<td>
			<div class="no-margin clearfix">
				<input id="player_<?php echo $player->ID_PLAYER; ?>" class="<?php echo isset($id) ? $id : ''; ?>" value="<?php echo $player->ID_PLAYER; ?>" name="invitation[]" type="checkbox"/>
				<label class="db" for="player_<?php echo $player->ID_PLAYER; ?>"><?php echo PlayerHelper::showName($player); ?></label>
			</div>
		</td>
	</tr>
<?php endif; ?>
