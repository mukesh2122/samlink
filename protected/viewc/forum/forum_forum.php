<?php
$reguserFunctions = MainHelper::GetModuleFunctionsByTag('reguser');
$userPlayer = User::getUser();
$isApproved = ($userPlayer) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;

$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);

$forumBanned = MainHelper:: ifBannedForum($type, $model->UNID);
//echo 'forumbanned: ';
//var_dump($forumBanned);

if(isset($infoBox)) { echo $infoBox; };

include('common/tabs.php'); // includes the forum submenu

?>

<?php if($isForumAdmin OR $isForumMod && !$noProfileFunctionality):
	if(!$forumBanned){
		if($bans){?>
		<!-- banned members button -->
			<a class="button button_large light_grey fr" href="<?php echo MainHelper::site_url('forum/bannedmembers/'.$type.'/'.$url.''); ?>"><?php echo $this->__('Banned members'); ?></a> 
		<?php
		}
		?>
		<!-- the ADMIN FORUM button -->
		<a class="button button_large light_grey fr" href="<?php echo MainHelper::site_url('adminforum/'.$type.'/'.$url.'/jeps'); ?>"><?php echo $this->__('Admin Forum page'); ?></a> 
<?php }
endif; ?>

<?php
if(isset($crumb)): ?>
	<div class="clearfix">
		<?php echo $this->renderBlock('common/breadcrumb', array('crumb' => $crumb)); ?>
	</div>
<?php endif; ?>

<input type="hidden" id="type" value="<?php echo $type; ?>">
<input type="hidden" id="id" value="<?php echo $model->UNID; ?>">
<?php
echo $this->renderBlock('forum/common/search', array(
	'url' => MainHelper::site_url('forum/'.$type.'/'.$url.'/search'), 
	'resetUrl' => MainHelper::site_url('forum/'.$type.'/'.$url), 
	'searchText' => isset($searchText) ? $searchText : '',
	'label' => $label = $this->__('Search for Boards...'),
	'type' => $board = $this->__('boards')
));
echo '<div class="clearfix">&nbsp;</div>';

if(Auth::isUserLogged()): ?>
	<?php if($reguserFunctions['reguserSubscriptions']==1 && $isApproved==1 && !$noProfileFunctionality && !$forumBanned): ?>

	<div class="clearfix mb10">
		<?php if($model->isSubscribedForum()): ?>
			<a data-opt='{"id":"<?php echo $model->UNID; ?>", "type":"<?php echo SUBSCRIPTION_FORUM; ?>", "otype": "<?php echo $type; ?>", "oid": "<?php echo $model->UNID; ?>"}' class="buttonRRound buttonSubscribeRound dn subscribe mt5 subscribe_<?php echo $type; ?>_<?php echo $model->UNID; ?>" href="javascript:void(0);">
				<img src="<?php echo MainHelper::site_url('global/img/iconPlayers.png'); ?>">
				<?php // echo $this->__('Unfollow'); ?>
				<span class="iconForum_follow"></span>
				<?php echo $this->__('Follow this forum'); ?>
			</a>
			<a data-opt='{"id":"<?php echo $model->UNID; ?>", "type":"<?php echo SUBSCRIPTION_FORUM; ?>", "otype": "<?php echo $type; ?>", "oid": "<?php echo $model->UNID; ?>"}' class="buttonRRound buttonSubscribeRound unsubscribe mt5 unsubscribe_<?php echo $type; ?>_<?php echo $model->UNID; ?>" href="javascript:void(0);">
				<img src="<?php echo MainHelper::site_url('global/img/iconPlayers.png'); ?>">
				<?php // echo $this->__('Unfollow'); ?>
				<span class="iconForum_follow"></span>
				<?php echo $this->__('Unfollow this forum'); ?>
			</a>
		<?php else: ?>
			<a data-opt='{"id":"<?php echo $model->UNID; ?>", "type":"<?php echo SUBSCRIPTION_FORUM; ?>", "otype": "<?php echo $type; ?>", "oid": "<?php echo $model->UNID; ?>"}' class="buttonRRound buttonSubscribeRound subscribe mt5 subscribe_<?php echo $type; ?>_<?php echo $model->UNID; ?>" href="javascript:void(0);">
				<img src="<?php echo MainHelper::site_url('global/img/iconPlayers.png'); ?>">
				<?php // echo $this->__('Unfollow'); ?>
				<span class="iconForum_follow"></span>
				<?php echo $this->__('Follow this forum'); ?>
			</a>
			<a data-opt='{"id":"<?php echo $model->UNID; ?>", "type":"<?php echo SUBSCRIPTION_FORUM; ?>", "otype": "<?php echo $type; ?>", "oid": "<?php echo $model->UNID;?>"}' class="buttonRRound buttonSubscribeRound dn mt5 unsubscribe unsubscribe_<?php echo $type; ?>_<?php echo $model->UNID; ?>" href="javascript:void(0);">
				<img src="<?php echo MainHelper::site_url('global/img/iconPlayers.png'); ?>">
				<?php // echo $this->__('Unfollow'); ?>
				<span class="iconForum_follow"></span>
				<?php echo $this->__('Unfollow this forum'); ?>
			</a>
		<?php endif; ?>
	</div>	
	<?php endif;
endif;


if(isset($categories) && !empty($categories)){
	foreach($categories as $c):
		$cat_class = 'cat_'.$type.'_'.$c->ID_OWNER.'_'.$c->ID_CAT; ?>
		
			<div class="<?php echo $cat_class.'_wrap'; ?>   CATWRAP mb20">

			<?php echo $this->renderBlock('forum/common/category', array('category' => $c, 'isForumAdmin' => $isForumAdmin, 'url' => $url));?>
				<div class="forumBg <?php echo $cat_class; ?>">
					
					<?php
						
						if(!empty($c->boards)):
							$n = 0;
							foreach($c->boards as $b):
							?>
								<?php echo $this->renderBlock('forum/common/boardItem', array('model' => $model, 'board' => $b, 'n' => $n, 'ownerType' => $type, 'ownerID' => $ownerId, 'isForumAdmin' => $isForumAdmin, 'url' => $url)); ?>
							<?php
							$n++;
							endforeach;
						endif;?>
					
				</div>
			</div>
		
		<?php
	endforeach;
}


?>
<div class="clearfix"></div>
<?php
	echo $this->renderBlock('forum/common/onlineUsers',
							 array(
							 	'allOnlineUsers' => $allOnlineUsers,
							 	'OnlineUsers' => $OnlineUsers,
							 	'onlineGuests' => $onlineGuests,
							 	'onlineMembers' => $onlineMembers,
							 	'model' => $model

							  ) 
	     );
?>