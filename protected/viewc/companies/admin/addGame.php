<div class="message_container">
    <!-- header -->
    <div class="clearfix">
        <span class="fs22 fft fclg2 fl mr10"><?php echo $this->__('Add Game'); ?></span>
    </div>
    <!-- end header -->
    <form action="#" method="post" id="addgame_company_form">
        <input type="hidden" name="company_id" value="<?php echo $company->ID_COMPANY; ?>">

		<div class="mt5">
			<label for="gameName" class="cp"><?php echo $this->__('Name'); ?></label>
			<div class="border mt2">
				<input name="game_name" class="w576 news_border game_name" id="gameName">
			</div>
		</div>

		<div class="mt5 pr zi100">
			<label for="gameType" class="cp"><?php echo $this->__('Genre'); ?></label>
			<div class="jqtransform pr border clearfix mt2">
				 <select id="gameType" name="game_type" class="w570 game_type jqselect">
					<select name="game_type" class="game_type jqselect">
						<?php foreach ($types as $type): ?>
							<option value ="<?php echo $type->ID_GAMETYPE; ?>"><?php echo $this->__($type->GameTypeName); ?></option>
						<?php endforeach; ?>
					</select>
				</select>
			</div>
		</div>

		<div class="mt10 pr zi99">
			<label class="cp"><?php echo $this->__('Platform'); ?></label>
			 <div class="w580 clearfix">
				<?php foreach ($platforms as $platform): ?>
					<div class="grid_2 alpha omega mt10">
						<input name="platforms[]" type="checkbox" class="fl" id="c_<?php echo $platform->ID_PLATFORM; ?>" value ="<?php echo $platform->ID_PLATFORM; ?>">
						<label class="fl cp" for="c_<?php echo $platform->ID_PLATFORM; ?>"><?php echo $this->__($platform->PlatformName); ?></label>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
 
		<div class="mt5">
			<label for="gameRelease" class="cp"><?php echo $this->__('Release Date'); ?></label>
			<div class="border mt2">
				<input name="game_release" class="w576 news_border" id="gameRelease">
			</div>
		</div>

		<div class="mt5">
			<label for="gameEsrb" class="cp"><?php echo $this->__('ESRB Rating'); ?></label>
			<div class="border mt2">
				<input name="game_esrb" class="w576 news_border" id="gameEsrb">
			</div>
		</div>

		<div class="mt5">
			<label for="gameURL" class="cp"><?php echo $this->__('URL'); ?></label>
			<div class="border mt2">
				<input name="game_url" class="w576 news_border" id="gameURL" value="http://">
			</div>
		</div>

		<div class="mt5">
			<label for="gameDescription" class="cp"><?php echo $this->__('Game Description'); ?></label>
			<div class="border mt2">
				<textarea name="game_description" rows="5"  class="news_border w576" id="gameDescription"></textarea>
			</div>
		</div>

        <div class="clear mt10">&nbsp;</div>
        <a href="javascript:void(0);" class="link_green fr addgame_company"><span><span><?php echo $this->__('Add'); ?></span></span></a>
    </form>
</div>
<script type="text/javascript">loadDropdowns(); loadCheckboxes();</script>