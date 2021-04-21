<?php $contentchildFields = MainHelper::GetModuleFieldsByTag('contentchild'); ?> 
<?php $isEnabledContentparent = MainHelper::IsModuleEnabledByTag('contentparent'); ?> 
<?php $contentchildFunctions = MainHelper::GetModuleFunctionsByTag('contentchild'); ?>
<?php if (MainHelper::IsModuleNotAvailableByTag('contentparent')==1) $isEnabledContentparent = 0; ?>

<form class="standard_form" method="post" action="<?php echo MainHelper::site_url('admin/games/new'); ?>">

	<div class="standard_form_header clearfix">
		<h1 class="pull_left"><?php echo $this->__('Game Settings'); ?></h1>
	</div>

	<div class="standard_form_elements clearfix">
		<div class="clearfix">
			<label for="game_name"><?php echo $this->__('Name'); ?></label>
			<span>
				<input tabindex="1" id="game_name" name="game_name" type="text" value="" class="text_input" />
			</span>
		</div>
		<div class="clearfix">
			<label for="game_description"><?php echo $this->__('Description'); ?></label>
			<span>
				<div class="standard_form_checks_wrapper no-margin clearfix">
					<textarea rows="7" cols="43" tabindex="2" id="game_description" name="game_description"></textarea>
				</div>
			</span>
		</div>
		
		<?php if ($contentchildFields['CreationDate']['isEnabled']==1): ?> 
		<div class="clearfix">
			<label for="game_release"><?php echo $this->__('Creation Date'); ?></label>
			<span>
				<input tabindex="1" id="game_release" name="game_release" type="text" value="" class="text_input" />
			</span>
		</div>
		<?php endif; ?>

		<?php if ($contentchildFields['ESRBrating']['isEnabled']==1): ?> 
		<div class="clearfix">
			<label for="game_esrb"><?php echo $this->__('ESRB rating'); ?></label>
			<span>
				<input tabindex="1" id="game_esrb" name="game_esrb" type="text" value="" class="text_input" />
			</span>
		</div>
		<?php endif; ?>
		
		<?php if ($contentchildFields['URL']['isEnabled']==1): ?> 
		<div class="clearfix">
			<label for="game_url"><?php echo $this->__('URL'); ?></label>
			<span>
				<input tabindex="1" id="game_url" name="game_url" type="text" value="" class="text_input" />
			</span>
		</div>
		<?php endif; ?>

		<?php if ($isEnabledContentparent==1): ?> 		<div class="clearfix">
			<label for="developer_id"><?php echo $this->__('Game developer'); ?></label>
			<span>
				<select id="developer_id" class="dropkick_lightWide" name="developer_id" tabindex="10">
					<option value="0">
						<?php echo $this->__('Select game developer');?>
					</option>
					<?php foreach ($companies as $developer): ?>
						<option value="<?php echo $developer->ID_COMPANY; ?>" <?php echo in_array($developer->ID_COMPANY, $developers) ? 'selected="selected"' : ''; ?>>
							<?php echo $developer->CompanyName; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>
		</div>
		<div class="clearfix">
			<label for="distributor_id"><?php echo $this->__('Game publisher'); ?></label>
			<span>
				<select id="distributor_id" class="dropkick_lightWide" name="distributor_id" tabindex="10">
					<option value="0">
						<?php echo $this->__('Select game publisher');?>
					</option>
					<?php foreach ($companies as $distributor): ?>
						<option value="<?php echo $distributor->ID_COMPANY; ?>" <?php echo in_array($distributor->ID_COMPANY, $distributors) ? 'selected="selected"' : ''; ?>>
							<?php echo $distributor->CompanyName; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>
		</div>
		<?php endif; ?>

		<?php if ($contentchildFields['Type']['isEnabled']==1): ?>
 		<div class="clearfix">
			<label for="game_type"><?php echo $this->__('Game type'); ?></label>
			<span>
				<select id="game_type" class="dropkick_lightWide" name="game_type" tabindex="10">
					<option value="0">
						<?php echo $this->__('Select game type');?>
					</option>
					<?php foreach ($gameTypes as $type): ?>
						<option value="<?php echo $type->ID_GAMETYPE; ?>">
							<?php echo $type->NameTranslated; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>
		</div>
		<?php endif; ?>

		<?php if ($contentchildFields['Platform']['isEnabled']==1): ?> 
		<div class="standard_form_checks clearfix">
			<label for="platforms"><?php echo $this->__('Game platform'); ?></label>
			<span>
				<div class="standard_form_checks_wrapper no-margin clearfix">
					<?php foreach ($gameAllPlatforms as $platform): ?>
						<input class="dst" type="checkbox" id="dst<?php echo $platform->ID_PLATFORM;?>" name="platforms[]" value="<?php echo $platform->ID_PLATFORM;?>" <?php echo in_array($platform->ID_PLATFORM, $gamePlatforms) ? 'checked="checked"' : ''; ?> />
						<label for="dst<?php echo $platform->ID_PLATFORM;?>"><?php echo $platform->PlatformName; ?></label>
					<?php endforeach; ?>
				</div>
			</span>
		</div>
		<?php endif; ?>

		<?php MainHelper::RenderExtrafields($extrafields,$this,''); ?>

		<?php if ($contentchildFunctions['contentchildFreeToPlay']==1): ?> 
		<div class="standard_form_info_header">
			<h2><?php echo $this->__('Free to play') ?></h2>
		</div>

		<div class="standard_form_checks clearfix">
			<label for="isFreePlay"><?php echo $this->__('Enabled'); ?></label>
			<span>
				<div class="standard_form_checks_wrapper no-margin clearfix">
					<input class="dst" type="checkbox" id="isFreePlay" name="isFreePlay" value="1" />
					<label for="isFreePlay"><?php echo $this->__('Yes'); ?></label>
				</div>
			</span>
		</div>

		<div class="clearfix">
			<label for="FreePlayLink"><?php echo $this->__('Link'); ?></label>
			<span>
				<input tabindex="1" id="FreePlayLink" name="FreePlayLink" type="text" value="" class="text_input" />
			</span>
		</div>
		<?php endif; ?>
	</div>

	<div class="standard_form_footer clearfix">
		<input class="button button_auto light_blue pull_right" type="submit" value="<?php echo $this->__('Save Settings'); ?>" />
	</div>

</form>
<script type="text/javascript">loadCheckboxes();</script>