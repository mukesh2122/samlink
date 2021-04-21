<!-- Topbar start -->
<div id="topbar_container">
  <div id="topbar">
    <div class="logo">
      <a href="<?php echo MainHelper::site_url(); ?>" title="PlayNation - social network">
        <img src="<?php echo Doo::conf()->APP_URL; ?>global/css/img/header_logo.png">
      </a>
    </div>

    <div id="global_search">
      <form action="<?php echo MainHelper::site_url('search'); ?>" id="top_search" method="get">
        <input id="search" type="text" title="<?php echo $this->__('Search here'); ?>" value="<?php echo $this->__('Search here'); ?>" />
      </form>
    </div>
  </div>
</div>
<!-- Topbar end -->

<!-- Global navigation start -->
<?php if (isset($data['header'])): ?>
	<?php
		$menu = $data['header'];
		$player = User::getUser();
	?>
	<div id="global_nav_container" class="default">
		<div id="global_nav_wrapper" class="clearfix">
			<nav id="global_nav">
				<ul class="clearfix">
					<?php foreach ($menu as $k1 => $v1): ?>
						<?php if (($v1->MenuName == 'Home') ||
									($player->canAccess('All') === TRUE) || /* = Super admin. Make sure it's an area none of the others use */
									($v1->MenuName == 'News' && $player->canAccess('Create news') === TRUE) ||
									($v1->MenuName == 'Games' && $player->canAccess('Edit game information') === TRUE) ||
									($v1->MenuName == 'Companies' && $player->canAccess('Edit company information') === TRUE) ||
									($v1->MenuName == 'Players' && ($player->canAccess('Edit user information') || $player->canAccess('Edit user info light') === TRUE)) ||
									($v1->MenuName == 'Shop' && $player->canAccess('Edit products') === TRUE) ||
									($v1->MenuName == 'Bug reports' && $player->canAccess('Bug Reporting') === TRUE) ||
									($v1->MenuName == 'Translate' && $player->canAccess('Translate') === TRUE) ||
									($v1->MenuName == 'Setup' && ($player->canAccess('Setup') === TRUE || $player->canAccess('Edit layout') === TRUE)) ||
									($v1->MenuName == 'Stats' && $player->canAccess('Stats') === TRUE) ||
									($v1->MenuName == 'Achievements' && $player->canAccess('Achievements') === TRUE)
								 ):
						?>
							<?php $active = ''; ?>
							<?php if (isset($data['selected_menu']) and 'admin/'.$data['selected_menu'] == $v1->URL) { $active = 'class="active"'; }; ?>
							<li <?php echo $active != '' ? $active : ''; ?>>
								<a href="<?php echo MainHelper::site_url($v1->URL); ?>">
									<?php echo $v1->MenuName; ?>
								</a>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</nav>
		</div>
	</div>
<?php endif; ?>
<!-- Global navigation end -->