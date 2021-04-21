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
if(Auth::isUserLogged() && $player->ID_PLAYER==$userPlayer->ID_PLAYER) $playerURL="s";
else $playerURL="/".$player->URL;

$showAdminFunc = false;
$funcList = array();
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
			<h3><a class="list_item_header" href="<?php echo MainHelper::site_url('player'.$playerURL.'/wall/blog'); ?>"><?php echo $nick;?></a></h3>
		<?php else: ?>
			<h3><a class="list_item_header" href="#"><?php echo $nick;?></a></h3>
		<?php endif; ?>
				
		<div class="player_item_info"><?php echo $player->BlogDescription ;?></div>
		
	
		<ul class="list_item_footer">
                    <li>
                        <span><?php echo $player->BlogCount . " " . $this->__('Blogs');?></span>
                    </li>
			

                        <?php if($reguserFunctions['reguserSubscriptions']==1 && $isApproved==1 && $blockStatus==0 && $extBlockStatus==0 && !$noProfileFunctionality):?>
                            <?php if(Auth::isUserLogged()): ?>
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