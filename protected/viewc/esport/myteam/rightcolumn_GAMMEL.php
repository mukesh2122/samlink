<?php $player = User::getUser(); 
    $team = $profile['team'];
    $teammates = $profile['teammates'];
    
?>

<div class="esports_right_column">
	<!-- Header start -->
	<div class="esport_widget myteam_info">
             <div class="esport_profile_boxheaders mb1 mt0"><p><?php echo $this->__('Team Information'); ?></p></div>
             <div class="team_info pa fcw" style="left:220px">
                 <h1 class="fcw"><?php echo $team->DisplayName; ?><img class="lang_flag_list ml5" src="<?php echo MainHelper::site_url('global/img/flags/'.strtolower($team->Country).'.gif');?>" /></h1>
                 <p><?php echo $team->TeamInitials; ?></p>
                 <p><?php echo $team->Credits.' Credits / '.$team->Coins.' Coins'; ?></p>
                 <p></p>
             </div>
             <div class="tournament_buttons">
                 <a class="button red" href="<?php echo MainHelper::site_url('esport/myteam/moneytransfer/'.$team->ID_TEAM); ?>"><?php echo $this->__('Transfer'); ?></a>
                 <?php if($player->esportCheckStatus('isCaptain',$team->ID_TEAM)): ?>
                     <a class="button red" href="<?php echo MainHelper::site_url('esport/myteam/editinfo/'.$team->ID_TEAM); ?>"><?php echo $this->__('Edit info'); ?></a>
                     <a class="button red" href="<?php echo MainHelper::site_url('esport/closeteam/'.$team->ID_TEAM); ?>"><?php echo $this->__('close team'); ?></a>
                 <?php endif; ?>
             </div>
             <div style="overflow:hidden;width:200px;height:200px; border-bottom-left-radius: 5px">
             <?php echo MainHelper::showImage($team, THUMB_LIST_200x200, false, array('width', 'no_img' => 'noimage/no_game_200x200.png'));?>
             </div>
	</div>
	<div class="esport_widget roster ">
             <div class="esport_profile_boxheaders mt0 mb1"><p><?php echo $this->__('Roster'); ?></p></div>
             <?php 
             ?>
             <div id="fanclubs_hub" class="ml40">
		<table>
                    <?php
                    foreach($teammates as $players):
                    ?>
                        <td>
                            <div id="fanclubs_img" href="<?php echo MainHelper::site_url('esport/fanclubinfo/');?>"><?php echo MainHelper::showImage($players, THUMB_LIST_150x225, false, array('both', 'no_img' => 'noimage/no_player_150x225.png'));?></a>
                            <span><p><?php echo $players->DisplayName; ?><img class="lang_flag_list ml5" src="<?php echo MainHelper::site_url('global/img/flags/'.strtolower($players->Country).'.gif');?>" /></p></div>
                            </span>
                            <span>
                              <?php 
                                echo $players->esportCheckStatus('isCaptain',$team->ID_TEAM) ? $this->__('Captain').'</br>' : '';
                                echo $players->esportCheckStatus('isPending',$team->ID_TEAM) ? $this->__('Player is pending').'...' : '';
                              ?>
                            </span>
                        </td>
                    <?php
                   endforeach;
                   if(count($teammates) == 1) echo '<td></td><td></td>';
                   if(count($teammates) == 2) echo '<td></td>';
                    ?>
		</table>
            </div>
	</div>
	<!-- Header end -->
	<!-- League ranking pictures start -->
	
</div>