<?php
if(!isset($addHeader))
	$addHeader = '';
?>
<?php if(!isset($model) or (!($model instanceof SnGames) and !($model instanceof SnCompanies) and !($model instanceof SnGroups))): ?>
<?php include('top.php');?>
<?php
	$tabsUrl = 'forum/';
	if(!isset($type))
		$type = '';
?>

<!-- generates the tabs  on the index overview games/ companies -->
<input type="hidden" id="selectedTab" value="<?php echo $type; ?>" />
<ul  class="horizontal_tabs clearfix">
	<li class="<?php echo $type == URL_GAME ? 'active':'';?>">
		<a class="icon_link" href="<?php echo MainHelper::site_url($tabsUrl.URL_GAME);?>"><i class="games_tab_icon"></i><?php echo $this->__('Games');?></a>
	</li>
	<li class="<?php echo $type == URL_COMPANY ? 'active':'';?>">
		<a class="icon_link" href="<?php echo MainHelper::site_url($tabsUrl.URL_COMPANY);?>"><i class="company_tab_icon"></i><?php echo $this->__('Companies');?></a>
	</li>
</ul>

<?php elseif($type == WALL_OWNER_GAME):?>
	<?php echo $this->renderBlock('games/common/top', array('game' => $model, 'CategoryType' => GAME_FORUM, 'addHeader' => $addHeader)); ?>
<?php elseif($type == WALL_OWNER_COMPANY):?>
	<?php echo $this->renderBlock('companies/common/top', array('company' => $model, 'CategoryType' => COMPANY_FORUM, 'addHeader' => $addHeader)); ?>
<?php elseif($type == WALL_OWNER_GROUP):?>
	<?php echo $this->renderBlock('groups/common/top', array('group' => $model, 'CategoryType' => GROUP_FORUM, 'addHeader' => $addHeader)); ?>
<?php endif; ?>

