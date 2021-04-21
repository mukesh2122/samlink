<?php 
include('common/top.php');
$tabsUrl = 'players/conversations/';

$viewer = User::getUser();
$suspendLevel = ($viewer) ? $viewer->getSuspendLevel() : 0;
$nocommenting = ($suspendLevel==1 || $suspendLevel==2);

?>
<?php if(Auth::isUserLogged() and isset($mTab)):?>
	<ul id="news_tab" class="tab_navigation_big clearfix">
		<li><a class="<?php echo $mTab == MESSAGES_INBOX ? 'active':'';?>" href="<?php echo MainHelper::site_url($tabsUrl);?>"><span><span class="pl15"><span class="icon_tabs icon_inbox">&nbsp;</span><?php echo $this->__('Inbox');?></span></span></a></li>
		<?php if (!$nocommenting): ?>
			<li><a class="<?php echo $mTab == '' ? 'active':'';?> create_new_message" href="javascript:void(0)"><span><span class="pl20"><span class="icon_tabs icon_newmessage">&nbsp;</span><?php echo $this->__('New message');?></span></span></a></li>
		<?php endif;?>
	</ul>
<?php endif;?>

<?php if(isset($pager)): ?>
<div class="clearfix messagesPagerInfo mt5">
	<div class="fl fclg3 pl5 mt2">
		<?php echo $this->__('Page'); ?>: <?php echo $this->__('[_1] of [_2]', array($pagerObj->currentPage, $pagerObj->totalPage)); ?>
<?php /* To be re-enabled once a solution for the deletion of conversations have been found
		<span class="fcbl4"> | </span>
		<a id="select_all" href="javascript:void(0)"><?php echo $this->__('Select All'); ?></a>
		<a id="deselect_all" class="dn" href="javascript:void(0)"><?php echo $this->__('Deselect All'); ?></a>
		<span class="fcbl4"> | </span>
		<a class="delete_selected_messages" href="javascript:void(0)"><?php echo $this->__('Delete Selected'); ?></a>
		<span class="fcbl4"> | </span>
*/ ?>
	</div>
	
	<div class="fr">
		<div class="fl blueCorner"></div>
		<div class="fr blueBoxCorn"><?php echo $this->__('Conversations'); ?>: <?php echo $total; ?></div>
	</div>
</div>
<?php endif; ?>


<div id="wall_container"><?php echo isset($conversations) ? $conversations : '';?></div>

<?php if(!isset($conversations) or $conversations == ''): ?>
	<div class="noItemsText"><?php echo $this->__('There are no conversations at this moment'); ?></div>
<?php endif; ?>

<?php if(isset($pager) and $pager != '' and isset($pagerObj) and $pagerObj->totalPage > 1): ?>
	<?php echo $this->renderBlock('common/pagination', array('pager'=>$pager)) ?>
<?php endif; ?>
