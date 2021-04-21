<div class="header_ad">
	<?php echo !isset($hideAdd) ? $this->renderBlock('common/header_ads', array()) : '';?>
</div>

<?php if(isset($infoBox)):?>
    <?php echo $infoBox;?>
<?php endif; ?>

<?php if(Auth::isUserLogged() and isset($wallType)):?>
	<ul id="news_tab" class="tab_navigation_big clearfix">
		<li><a class="<?php echo $wallType == WALL_HOME ? 'active':'';?>" href="<?php echo MainHelper::site_url('players/wall/home');?>"><span><span><span class="icon_tabs icon_recent">&nbsp;</span><?php echo $this->__('Home');?></span></span></a></li>
		<li><a class="<?php echo $wallType == WALL_PHOTO ? 'active':'';?>" href="<?php echo MainHelper::site_url('players/wall/photo');?>"><span><span><span class="icon_tabs icon_popular">&nbsp;</span><?php echo $this->__('Image');?></span></span></a></li>
		<li><a class="<?php echo $wallType == WALL_LINK ? 'active':'';?>" href="<?php echo MainHelper::site_url('players/wall/link');?>"><span><span><span class="icon_tabs icon_platforms">&nbsp;</span><?php echo $this->__('Link');?></span></span></a></li>
		<li><a class="<?php echo $wallType == WALL_VIDEO ? 'active':'';?>" href="<?php echo MainHelper::site_url('players/wall/video');?>"><span><span><span class="icon_tabs icon_games">&nbsp;</span><?php echo $this->__('Video');?></span></span></a></li>
		<li><a class="<?php echo $wallType == WALL_MAIN ? 'active':'';?>" href="<?php echo MainHelper::site_url('players/wall/main');?>"><span><span><span class="icon_tabs icon_companies">&nbsp;</span><?php echo $this->__('Wall');?></span></span></a></li>
	</ul>
<?php endif;?>