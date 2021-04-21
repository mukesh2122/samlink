<?php $reguserFunctions = MainHelper::GetModuleFunctionsByTag('reguser'); ?>
<?php include('common/top.php');?>
<?php
        $player = User::getUser();
	$tabsUrl = 'players/wall/';
	if(isset($friendUrl) and $friendUrl != ''){
		$tabsUrl = 'player/'.$friendUrl.'/wall/';
                $profile = $poster;
	}
        else {
                $profile = $player;
        }
	if(!isset($wallType))
		$wallType = '';
?>

<?php
$pvAllowImages = 1;
$pvAllowLinks = 1;
$pvAllowVideos = 1;
$pvAllowWall = 1;
if ($player->ID_PLAYER != $poster->ID_PLAYER)
{
	$SnPrivacy = new SnPrivacy;
	$pvTypes = $SnPrivacy->GetPrivacyTypesForPlayer($player,$poster);
	$pvAllowImages = $pvTypes['myimages']['allow'];
	$pvAllowLinks = $pvTypes['mylinks']['allow'];
	$pvAllowVideos = $pvTypes['myvideos']['allow'];
	$pvAllowWall = $pvTypes['mywall']['allow'];
}

?>


<?php if(Auth::isUserLogged()):?>
	<input type="hidden" id="selectedTab" value="<?php echo $wallType; ?>" />
	<ul class="horizontal_tabs clearfix">
		<li class="<?php echo $wallType == WALL_HOME ? 'active':'';?>">
			<a class="icon_link" href="<?php echo MainHelper::site_url($tabsUrl.WALL_HOME);?>"><i class="home_tab_icon"></i><?php echo $this->__('Home');?></a>
		</li>
		<?php if ($reguserFunctions['reguserImages']==1 && $pvAllowImages==1): ?>
		<li class="<?php echo $wallType == WALL_PHOTO ? 'active':'';?>">
			<a class="icon_link" href="<?php echo MainHelper::site_url($tabsUrl.WALL_PHOTO);?>"><i class="photo_tab_icon"></i><?php echo $this->__('Images');?></a>
		</li>
		<?php endif; ?>
                <?php if (MainHelper::IsModuleEnabledByTag('blogs')==1 && $profile->hasBlog==1): ?>
                <li class="<?php echo $wallType == WALL_BLOG ? 'active':'';?>">
			<a class="icon_link" href="<?php echo MainHelper::site_url($tabsUrl.WALL_BLOG);?>"><i class="linky_tab_icon"></i><?php echo $this->__('Blogs');?></a>
		</li>
                <?php endif; ?>
		<?php if ($reguserFunctions['reguserLinks']==1 && $pvAllowLinks==1): ?>
		<li class="<?php echo $wallType == WALL_LINK ? 'active':'';?>">
			<a class="icon_link" href="<?php echo MainHelper::site_url($tabsUrl.WALL_LINK);?>"><i class="linky_tab_icon"></i><?php echo $this->__('Links');?></a>
		</li>
		<?php endif; ?>
		<?php if ($reguserFunctions['reguserVideos']==1 && $pvAllowVideos==1): ?>
		<li class="<?php echo $wallType == WALL_VIDEO ? 'active':'';?>">
			<a class="icon_link" href="<?php echo MainHelper::site_url($tabsUrl.WALL_VIDEO);?>"><i class="video_tab_icon"></i><?php echo $this->__('Videos');?></a>
		</li>
		<?php endif; ?>
		<?php if((!isset($friendUrl) or $friendUrl == '') and $pvAllowWall==1): ?>
		<li class="<?php echo $wallType == WALL_MAIN ? 'active':'';?>">
			<a class="icon_link" href="<?php echo MainHelper::site_url($tabsUrl.WALL_MAIN);?>"><i class="wall_tab_icon"></i><?php echo $this->__('Wall');?></a>
		</li>
		<?php endif; ?>
		<li class="<?php echo $wallType == WALL_INFOPAGE ? 'active':'';?>">
			<a class="icon_link" href="<?php echo MainHelper::site_url($tabsUrl.WALL_INFOPAGE);?>"><i class="wall_tab_icon"></i><?php echo $this->__('Info');?></a>
		</li>
	</ul>
<?php endif;?>
