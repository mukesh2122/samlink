<?php $reguserFunctions = MainHelper::GetModuleFunctionsByTag('reguser'); 
	$userPlayer = User::getUser();
	$isApproved = ($userPlayer) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;

	$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
	$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
	$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
?>

<?php
$nick = PlayerHelper::showName($player);
$location = PlayerHelper::getLocation($player);

$playerInfoString = "";
if(isset($player->ID_LEVEL2FRIEND)) {
	$playerInfo = array();
	if($player->MutualCount > 0) {
		$playerInfo[] = $this->__('[_1]', array($player->MutualCount));
	}
	if($player->CommonGamesPlayedCount > 0) {
		$playerInfo[] = $this->__('[_1] game(s)', array($player->CommonGamesPlayedCount));
	}
	if($player->CommonGroupsCount > 0) {
		$playerInfo[] = $this->__('[_1] group(s)', array($player->CommonGroupsCount));
	}

	if(count($playerInfo) <= 2) {
		$playerInfoString = implode(" ".$this->__('and')." ", $playerInfo);
	} else {
		$playerInfoString = $playerInfo[0].', ' . $playerInfo[1] .' '.$this->__('and').' '. $playerInfo[2];
	}
}

$showAdminFunc = false;
$funcList = array();
if(isset($adminActions['deleteFriend']) and $adminActions['deleteFriend'] === true && !$noProfileFunctionality) {
	$showAdminFunc = true;
	$funcList[] = '<a class="delete_friend" rel="'.$player->ID_PLAYER.'" href="javascript:void(0)">'.$this->__('Unfriend player').'</a>';
}

//Categorize friend
if(isset($adminActions['categorizeFriend']) and $adminActions['categorizeFriend'] === true && !$noProfileFunctionality) {
	//Show categories and even selected ones
	$showAdminFunc = true;

	$query="
		SELECT sn_playerfriendcat.* ,sn_playerfriendcat_rel.ID_FRIEND
		FROM sn_playerfriendcat
		LEFT JOIN sn_playerfriendcat_rel
		ON sn_playerfriendcat.ID_PLAYER = sn_playerfriendcat_rel.ID_PLAYER 
		AND sn_playerfriendcat.ID_CAT = sn_playerfriendcat_rel.ID_CAT
		AND sn_playerfriendcat_rel.ID_FRIEND={$player->ID_PLAYER}
		WHERE sn_playerfriendcat.ID_PLAYER={$userPlayer->ID_PLAYER}
		AND Native in (0,1)
		ORDER BY Native DESC,ID_CAT ASC";
	$friendCatRels = Doo::db()->query($query)->fetchall();

	if (!empty($friendCatRels))
	{
		$funcList[] = '<span class="categorize_friend_title">' . $this->__('Categorize friend').":</span>";
		$f = 0;
		foreach ($friendCatRels as $friendCat)
		{
			$ID_CAT = $friendCat['ID_CAT'];
			$CategoryName = $friendCat['CategoryName'];
			$checked = '';
			if (isset($friendCat['ID_FRIEND']))
				$checked = '+';
			//$funcList[] = '<a class="categorize_friend" rel="'.$ID_CAT.'" href="javascript:void(0)" id="_'.$player->ID_PLAYER.'_friendcat'.$ID_CAT .'"><span id="s_'.$player->ID_PLAYER.'_friendcat'.$ID_CAT.'">'.$checked.'</span>'.$CategoryName.'</a>';
			$funcList[] = '<a class="categorize_friend" name="'.$player->ID_PLAYER.'" rel="'.$ID_CAT.'" href="javascript:void(0)" id="_'.$player->ID_PLAYER.'_friendcat'.$ID_CAT .'"><span id="s_'.$player->ID_PLAYER.'_friendcat'.$ID_CAT.'">'.$checked.'</span>'.$CategoryName.'</a>';
			$f++;
		}
		//$funcList[] = '<a class="categorize_friend_submit" rel="'.$player->ID_PLAYER.'" href="javascript:void(0)">'.$this->__('Submit').'</a>';
	}
}


if(isset($adminActions['removeGroupMember']) and $adminActions['removeGroupMember'] === true and isset($player->SnPlayerGroupRel) and $player->SnPlayerGroupRel[0]->hasApplied == 1) {
	$showAdminFunc = true;	
	$funcList[] = '<a href="javascript:void(0)" class="add_membertogroup_from_notif aprove_application" rel="'.$group->ID_GROUP.'_'.$player->URL.'">'.$this->__('Add player to group').'</a>';
}
if(isset($adminActions['removeGroupMember']) and $adminActions['removeGroupMember'] === true){
	$showAdminFunc = true;
	$funcList[] = '<a class="delete_group_member" rel="'.$player->ID_PLAYER.'" href="javascript:void(0)">'.$this->__('Remove player from group').'</a>';
} 
if(isset($player->ID_LEVEL2FRIEND)) {
	$showAdminFunc = true;
	$funcList[] = '<a class="delete_player_suggestion" rel="'.$player->URL.'" href="javascript:void(0)">'.$this->__('Remove player suggestion').'</a>';
}
?>
<?php
	$listUserIsApproved = MainHelper::IsPlayerApproved($player->ID_PLAYER);

	//echo "viewer: {$userPlayer->ID_PLAYER}  friend: {$player->ID_PLAYER}";
	$blockStatus = ($userPlayer) ? Mainhelper::IsFriendBlocked($userPlayer->ID_PLAYER,$player->ID_PLAYER) : 0;
	$extBlockStatus = ($userPlayer) ? Mainhelper::IsFriendBlocked($player->ID_PLAYER,$userPlayer->ID_PLAYER) : 0;
?>

<!-- Player item start -->
<div class="list_item clearfix itemPost">
	<?php if ($listUserIsApproved==1 && $blockStatus==0 && $extBlockStatus==0): ?>
		<a href="<?php echo MainHelper::site_url('player/'.$player->URL); ?>" class="list_item_img"><?php echo MainHelper::showImage($player, THUMB_LIST_80x80, false, array('no_img' => 'noimage/no_player_80x80.png')); ?>
		<?php
/*			//Friendcategory banner on avatar
			if (isset($viewer))	if ($userPlayer->ID_PLAYER == $viewer->ID_PLAYER)
				{
					$friendCats = MainHelper::FriendInCategories($userPlayer->ID_PLAYER,$player->ID_PLAYER);
					foreach ($friendCats as $fc)
					{
						echo "<p>{$fc['CategoryName']}</p>";
					}
				}*/
		?>
		</a>
	<?php else: ?>
		<a href="#" class="list_item_img"><?php echo MainHelper::showImage($player, THUMB_LIST_80x80, false, array('no_img' => 'noimage/no_player_80x80.png')); ?></a>
	<?php endif; ?>

	<div class="list_item_meta">
		<?php
			//$playerSuspendLevel = $player->getSuspendLevel();
			//$noProfileFunctionality = ($suspendLevel==1 || $suspendLevel==2);
		?>
		
		<?php if ($listUserIsApproved==1 && $blockStatus==0 && $extBlockStatus==0): ?>
			<h3><a class="list_item_header" href="<?php echo MainHelper::site_url('player/'.$player->URL); ?>"><?php echo $nick;?></a></h3>
		<?php else: ?>
			<h3><a class="list_item_header" href="#"><?php echo $nick;?></a></h3>
		<?php endif; ?>

		<?php if(isset($adminActions['removeGroupMember']) and $adminActions['removeGroupMember'] === true and isset($player->SnPlayerGroupRel) and $player->SnPlayerGroupRel[0]->hasApplied == 1):?>
				<p class="list_item_description"><b><?php echo $this->__('Reason');?></b>: <?php echo $player->SnPlayerGroupRel[0]->Comments;?></p>
			<?php elseif(isset($groupRank)):?>
				<p class="list_item_description"><b><?php echo $this->__('Rank');?></b>: <span class="member_rank_<?php echo $player->URL;?>"><?php echo $groupRank;?></span> <?php if($groupRank != 'Leader' and isset($adminActions['removeGroupMember']) and $adminActions['removeGroupMember'] === true and $player->ID_PLAYER != $viewer->ID_PLAYER and $groupRank != '-'): ?><a href="javascript:void(0)" class="toggle_group_member_rank" rev="<?php echo $player->URL;?>" >toggle</a><?php endif;?></p>
		<?php endif;?>
				
		<span class="player_item_location">
			<?php if($location != '-' and trim($location) != ''):?>
				<?php echo $this->__('Lives in [_1]', array($location));?>
			<?php endif;?>
			&nbsp;
		</span>
		
			
		<?php if($playerInfoString != ""):?>
			<div class="player_item_info"><?php echo $this->__('Friends in common: [_1]', array($playerInfoString));?></div>
		<?php endif;?>
		
	
		<ul class="list_item_footer">
			<?php if(isset($viewer) and $viewer and $player->ID_PLAYER != $viewer->ID_PLAYER  && !$noProfileFunctionality): ?>
				<?php if($isApproved==1 && $blockStatus==0 && $extBlockStatus==0):?>
					<?php if($viewer->isPending($player->ID_PLAYER)):?>
						<li>
							<a class="icon_link" href="javascript:void(0)"><i class="add_friend_icon"></i><?php echo $this->__('Pending');?></a>
						</li>
					<?php elseif(!$viewer->isFriend($player->ID_PLAYER)):?>
						<li>
							<a class="icon_link add_member_profile" rel="<?php echo $player->ID_PLAYER;?>" href="javascript:void(0)"><i class="add_friend_icon"></i><?php echo $this->__('Add Friend');?></a>
						</li>
					<?php endif; ?>
				<?php endif; ?>
					
				<?php if($reguserFunctions['reguserMessages']==1 && $isApproved==1 && $blockStatus==0 && $extBlockStatus==0):?>
				<li>
					<a class="icon_link reply_message" rel="<?php echo $player->URL;?>" title="<?php echo $nick;?>" href="<?php echo MainHelper::site_url('players/ajaxgetsendmessage/'.$player->URL);?>"><i class="message_icon"></i><?php echo $this->__('Send Message');?></a>
				</li>
				<?php endif; ?>

				<?php if($reguserFunctions['reguserSubscriptions']==1 && $isApproved==1 && $blockStatus==0 && $extBlockStatus==0 && !$noProfileFunctionality):?>
					<?php if($viewer->isSubscribed($player->ID_PLAYER)):?>
						<li>
							<a data-opt='{"id":"<?php echo $player->ID_PLAYER;?>", "type":"<?php echo SUBSCRIPTION_PLAYER;?>"}' class="icon_link unsubscribe unsubscribe_<?php echo $player->ID_PLAYER;?>" href="javascript:void(0)"><i class="unsubscribe_icon"></i><?php echo $this->__('Unsubscribe');?></a>
							<a data-opt='{"id":"<?php echo $player->ID_PLAYER;?>", "type":"<?php echo SUBSCRIPTION_PLAYER;?>"}' class="icon_link dn subscribe subscribe_<?php echo $player->ID_PLAYER;?>" href="javascript:void(0)"><i class="subscribe_icon"></i><?php echo $this->__('Subscribe');?></a>
						</li>
					<?php else:?>
						<li>
							<a data-opt='{"id":"<?php echo $player->ID_PLAYER;?>", "type":"<?php echo SUBSCRIPTION_PLAYER;?>"}' class="icon_link subscribe subscribe_<?php echo $player->ID_PLAYER;?>" href="javascript:void(0)"><i class="subscribe_icon"></i><?php echo $this->__('Subscribe');?></a>
							<a data-opt='{"id":"<?php echo $player->ID_PLAYER;?>", "type":"<?php echo SUBSCRIPTION_PLAYER;?>"}' class="icon_link dn unsubscribe unsubscribe_<?php echo $player->ID_PLAYER;?>" href="javascript:void(0)"><i class="unsubscribe_icon"></i><?php echo $this->__('Unsubscribe');?></a>
						</li>
					<?php endif; ?>
				<?php endif; ?>
				

				<?php if ($extBlockStatus==0): ?>
					<?php if ($blockStatus==1): ?>
						<li>
							<a class="icon_link unblock_user" rel="<?php echo $player->ID_PLAYER;?>" title="<?php echo $nick;?>" href="javascript:void(0)"><i class="unblock_icon"></i><?php echo $this->__('Unblock user');?></a>
						</li>
					<?php else: ?>
						<li>
							<a class="icon_link block_user" rel="<?php echo $player->ID_PLAYER;?>" title="<?php echo $nick;?>" href="javascript:void(0)"><i class="block_icon"></i><?php echo $this->__('Block user');?></a>
						</li>
					<?php endif; ?>
				<?php endif; ?>
			<?php endif; ?>
		</ul>

		<?php if($showAdminFunc === true): ?>
			<div class="list_item_dropdown item_dropdown">
				<a href="javascript:void(0)" class="list_item_dropdown_trigger item_dropdown_trigger"><?php echo $this->__('Options');?></a>
				<ul class="list_item_dropdown_options item_dropdown_options">
					<li><?php echo implode("</li><li>", $funcList);?></li>
				</ul>
			</div>
		<?php endif;?>
	</div>
</div>
<!-- Player item end -->
