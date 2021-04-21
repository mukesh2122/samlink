<div class="ftu_form yellow_box rounded_5">
	<div class="box_header clearfix">
		<h3><?php echo $this->__('Welcome to PlayNation'); ?></h3>
		<div class="ftu_form_steps">
			<a href="javascript:void(0)" class="ftu_form_step F_loadFTUStep" rel="0">1</a>
			<a href="javascript:void(0)" class="ftu_form_step F_loadFTUStep" rel="1">2</a>
			<a href="javascript:void(0)" class="ftu_form_step F_loadFTUStep" rel="2">3</a>
			<a href="javascript:void(0)" class="current_step" rel="3">4</a>
		</div>
	</div>
	<strong><?php echo $this->__('Congratulations'); ?></strong>
	<p><?php echo $this->__('You are now a member of PlayNation. The next move is yours.'); ?></p>

		<?php echo $this->__('You can go to the [_1]player list[_2] and connect to other users and share stuff on your [_3]wall[_4], browse through the [_5]games database[_6] and check out our [_7]free-to-play games[_8].',
				array('<a href="'.MainHelper::site_url('players').'">', '</a>', '<a href="'.MainHelper::site_url('players/wall').'">', '</a>', '<a href="'.MainHelper::site_url('games').'">', '</a>', '<a href="'.MainHelper::site_url('games/free').'">', '</a>')); ?><br />
		<?php echo $this->__('In the [_1]news[_2] section you can get up to date on the gaming scene and share it with the world.', array('<a href="'.MainHelper::site_url('news').'">', '</a>')); ?><br />
		<?php echo $this->__('If your guild or clan need to get connected you can create a [_1]group[_2] or join existing groups.', array('<a href="'.MainHelper::site_url('groups').'">', '</a>')); ?><br />
		<?php echo $this->__('The [_1]event[_2] section is perfect if you need to create awareness about your upcoming LAN party.', array('<a href="'.MainHelper::site_url('events').'">', '</a>')); ?><br />
		<?php echo $this->__('You can also go straight to the [_1]e-sports[_2] and get your game on or upgrade your account,', array('<a href="'.MainHelper::site_url('esports').'">', '</a>')); ?><br />
		<?php echo $this->__('buy games servers or other features in the [_1]shop[_2].', array('<a href="'.MainHelper::site_url('shop').'">', '</a>')); ?></p>
	<p><?php echo $this->__('Have fun!'); ?></p>
	<p>--<br />
	PlayNation Team</p>
</div>

<div class="ftu_form_footer clearfix">
	<form method="POST" action="<?php echo MainHelper::site_url('players/finishstep'); ?>">
		<input type="hidden" name="step" value="4" />
		<input class="button button_medium light_blue fr" type="submit" value="<?php echo $this->__('Finish'); ?>" />
		<a href="javascript:void(0)" class="button button_medium light_blue F_loadFTUStep fl" rel="2"><?php echo $this->__('Previous'); ?></a>
	</form>
</div>