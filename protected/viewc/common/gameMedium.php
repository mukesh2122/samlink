<?php
$platformNames = MainHelper::getGamePlatforms($item);
$time = MainHelper::getGameRelease($item);
?>

<div class="gamesContent">
    <div class="gameTop">&nbsp;</div>
	<a class="gameImg" href="<?php echo $item->GAME_URL;?>"><?php echo MainHelper::showImage($item, THUMB_LIST_120x120, false, array('no_img' => 'noimage/no_game_120x120.png'));?></a>

	<div class="gameBody">
		                            
                                <h3><a class="gameHeader" href="<?php echo $item->GAME_URL;?>"><?php echo $item->GameName;?></a></h3>
                                
				<span class="gameText">
					<p><?php echo $this->__('Game Type');?>:
					<?php echo $item->GameType != '' ? $item->GameType : '-';?></p>
				
					<p><?php echo $this->__('Release Date');?>:
					<?php echo $item->CreationDate != '0000-00-00' ? $time : '-';?></p>
				
					<p><?php echo $this->__('Platforms');?>:
					<?php echo !empty($platformNames) ? implode(", ", $platformNames) : '-';?></p>
				
                                        <p><img src="../../global/img/iconPlayers.png"/>&nbsp;
					<?php echo $item->PlayersCount != '' ? $item->PlayersCount : '-';?></p>
				</span>
                                        
                                <span class="gameRating">
                                        <img src="../../global/img/gameRating.png"/>
				</span>
                                
				<br />

				<span class="game_item_vr">
				<?php if(Auth::isUserLogged()): ?>
					<?php $userPlayer = User::getUser();
                        $suspendLevel = $userPlayer->getSuspendLevel();
                        $noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
                        $noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
						if (!$noProfileFunctionality): ?>
						<?php if (!$item->isPlaying()): ?>
							<a href="javascript:void(0)" class="action_is_playing" rel="<?php echo $item->ID_GAME;?>"><?php echo $this->__('Add to my games');?></a>
                            <?php else: ?>
							<a href="javascript:void(0)" class="action_stop_playing" rel="<?php echo $item->ID_GAME;?>"><?php echo $this->__('Stop playing');?></a>
						<?php endif ?>
					<?php endif; ?>
				<?php endif; ?>
				</span>
			</div>
        
    <div class="gameBottom">&nbsp;</div>

		</div>
        <?php if(isset($showAdminFunc) && $showAdminFunc === TRUE && isset($funcList)): ?>
			<div class="list_item_dropdown item_dropdown">
				<a href="javascript:void(0);" class="list_item_dropdown_trigger item_dropdown_trigger"><?php echo $this->__('Options'); ?></a>
				<ul class="list_item_dropdown_options item_dropdown_options">
					<li><?php echo implode("</li><li>", $funcList); ?></li>
				</ul>
			</div>
        <?php endif; ?>




<?php /*
<?php
$platformNames = MainHelper::getGamePlatforms($item);
$time = MainHelper::getGameRelease($item);
?>
<div class="<?php echo !$num ? 'dot_top' : '';?>">
	<div class="pt10 pb10 clearfix dot_bot">
		<div class="grid_1 alpha"><a href="<?php echo $item->GAME_URL;?>"><?php echo MainHelper::showImage($item, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_game_60x60.png'));?></a> </div>
		<div class="clearfix grid_5 alpha omega">
			<a class="fs13" href="<?php echo $item->GAME_URL;?>"><?php echo $item->GameName;?></a>

			<span class="db fclg fft fs11 mt8"><strong><?php echo $this->__('Game Type');?></strong>: <?php echo $item->GameType != '' ? $item->GameType : '-';?></span>
			<span class="db fclg fft fs11"><strong><?php echo $this->__('Release Date');?></strong>: <?php echo $item->CreationDate != '0000-00-00' ? $time : '-';?></span>
			<span class="db fclg fft fs11"><strong><?php echo $this->__('Platforms');?></strong>: <?php echo !empty($platformNames) ? implode(", ", $platformNames) : '-';?></span>
		</div>
		<div class="clearfix grid_2 alpha omega fr">
			<span class="db fclg fft fs11"><strong><?php echo $this->__('Players');?></strong>: <?php echo $item->PlayersCount != '' ? $item->PlayersCount : '-';?></span>
			<span class="db fclg fft fs11"><strong><?php echo $this->__('ESRB Rating');?></strong>: <?php echo $item->ESRB != '' ? $item->ESRB : '-';?></span>
			<?php if(!$item->isPlaying() and Auth::isUserLogged()):?>
				<a href="javascript:void(0)" class="link_green db tac mt10 action_is_playing" rel="<?php echo $item->ID_GAME;?>"><span><span><?php echo $this->__('I play this');?></span></span></a>
			<?php endif; ?>
		</div>
	</div>
</div>
*/ ?>