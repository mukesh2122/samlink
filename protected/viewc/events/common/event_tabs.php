<?php include('top.php');?>
<?php
    $user = User::getUser();
    $tabsUrl = 'event/'.$event->ID_EVENT.'/';
	
	if(!isset($type))
		$type = '';
?>

<input type="hidden" id="selectedTab" value="<?php echo $type; ?>" />
<ul class="horizontal_tabs clearfix">
	<li class="<?php echo $type == EVENT_INFO ? 'active':'';?>">
		<a class="icon_link" href="<?php echo MainHelper::site_url($tabsUrl.EVENT_INFO);?>"><i class="games_tab_icon"></i><?php echo $this->__('Info');?></a>
	</li>
        <li class="<?php echo $type == EVENT_NEWS ? 'active':'';?>">
		<a class="icon_link" href="<?php echo MainHelper::site_url($tabsUrl.EVENT_NEWS);?>"><i class="games_tab_icon"></i><?php echo $this->__('News');?></a>
	</li>
	<li class="<?php echo $type == EVENT_PARTICIPANTS ? 'active':'';?>">
		<a class="icon_link" href="<?php echo MainHelper::site_url($tabsUrl.EVENT_PARTICIPANTS);?>"><i class="games_tab_icon"></i><?php echo $this->__('Participants');?></a>
	</li>
	<li class="<?php echo $type == EVENT_INVITED ? 'active':'';?>">
		<a class="icon_link" href="<?php echo MainHelper::site_url($tabsUrl.EVENT_INVITED);?>"><i class="games_tab_icon"></i><?php echo $this->__('Invited');?></a>
	</li>
        <?php if(Auth::isUserLogged() && ((isset($isAdmin) && $isAdmin===true) || $user->canAccess('Create news'))): ?>
            <a class="list_header_button" href="<?php echo MainHelper::site_url($tabsUrl.'new'); ?>"><?php echo $this->__('Create Event News +') ?></a>
        <?php endif; ?>
<?php /*<li><a class="<?php echo $type == EVENT_WALL ? 'active':'';?>" href="<?php echo MainHelper::site_url($tabsUrl.EVENT_WALL);?>"><span><span class="pl20"><span class="icon_tabs icon_games">&nbsp;</span><?php echo $this->__('Wall');?></span></span></a></li> */?>
</ul>
