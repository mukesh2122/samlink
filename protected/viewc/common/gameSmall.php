<?php if(isset($game) and $game): ?>
	<tr class="small_list_tr F_game_<?php echo $game->ID_GAME; ?>">
		<td>
			<div class="no-margin clearfix">
				<input id="game_<?php echo $game->ID_GAME; ?>" class="<?php echo isset($id) ? $id : ''; ?>" value="<?php echo $game->ID_GAME; ?>" name="games[]" type="checkbox">
				<label for="game_<?php echo $game->ID_GAME; ?>"><?php echo $game->GameName; ?></label>
			</div>
		</td>
	</tr>
<?php endif; ?>