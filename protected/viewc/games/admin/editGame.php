<div class="clearfix">
	<span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Edit Game Info'); ?></span>
</div>
<!-- end header -->
<form action="#" method="post" id="edit_game_form">
	<input type="hidden" name="game_id" value="<?php echo $game->ID_GAME; ?>">

	<div class="mt5">
		<label for="gameName" class="cp"><?php echo $this->__('Name'); ?></label>
		<div class="border mt2">
			<input name="game_name" class="w576 news_border" id="gameName" value="<?php echo $game->GameName; ?>">
		</div>
	</div>

	<div class="mt5 pr zi100">
		<label for="gameType" class="cp"><?php echo $this->__('Genre'); ?></label>
		<div class="jqtransform pr border clearfix mt2">
			<select id="gameType" name="game_type" class="w570 game_type jqselect">
				<?php foreach ($types as $type): ?>
					<option <?php echo $type->ID_GAMETYPE == $game->ID_GAMETYPE ? 'selected="selected"' : ''; ?> value="<?php echo $type->ID_GAMETYPE; ?>"><?php echo $this->__($type->GameTypeName); ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>

	<div class="mt10 pr zi99">
		<label class="cp"><?php echo $this->__('Platform'); ?></label>
		<div class="w580 clearfix">
			<?php foreach ($platforms as $platform): ?>
				<div class="grid_2 alpha omega mt10">
					<input name="platforms[]" type="checkbox" <?php echo in_array($platform->ID_PLATFORM, $assigned_platforms) ? 'checked="checked"' : ''; ?> class="fl" id="c_<?php echo $platform->ID_PLATFORM; ?>" value ="<?php echo $platform->ID_PLATFORM; ?>">
					<label class="fl cp" for="c_<?php echo $platform->ID_PLATFORM; ?>"><?php echo $this->__($platform->PlatformName); ?></label>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="mt5">
		<label for="gameRelease" class="cp"><?php echo $this->__('Release Date'); ?></label>
		<div class="border mt2">
			<input name="game_release" class="w576 news_border" id="gameRelease" value="<?php echo $game->CreationDate; ?>">
		</div>
	</div>

	<div class="mt5">
		<label for="gameEsrb" class="cp"><?php echo $this->__('ESRB Rating'); ?></label>
		<div class="border mt2">
			<input name="game_esrb" class="w576 news_border" id="gameEsrb" value="<?php echo $game->ESRB; ?>">
		</div>
	</div>

	<div class="mt5">
		<label for="gameURL" class="cp"><?php echo $this->__('URL'); ?></label>
		<div class="border mt2">
			<input name="game_url" class="w576 news_border" id="gameURL" value="<?php echo $game->URL; ?>">
		</div>
	</div>

	<div class="mt5">
		<label for="gameDescription" class="cp"><?php echo $this->__('Game Description'); ?></label>
		<div class="border mt2">
			<?php MainHelper::loadCKE("game_description", $this->__($game->GameDesc)); ?>
		</div>
	</div>

	<?php
		$extrafields = MainHelper::GetExtraFieldsByOwnertype('game',$game->ID_GAME);
		MainHelper::RenderExtrafields($extrafields,$this,'popupedit'); 
	?>

	<div class="clear mt10">&nbsp;</div>
	<a href="javascript:void(0);" class="link_green fl update_game_info"><span><span><?php echo $this->__('Save'); ?></span></span></a>
	<a href="javascript:void(0);" rel="<?php echo $game->GAME_URL; ?>" class="link_green fr update_game_info_close"><span><span><?php echo $this->__('Save and close'); ?></span></span></a>
</form>
<script type="text/javascript">loadDropdowns(); loadCheckboxes();</script>