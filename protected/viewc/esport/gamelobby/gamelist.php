<?php $esport = new Esport(); ?>
<div id="quickmatch_gameslist" class="ml15 mt15">
<?php
    foreach ($games as $game){
        $game = Games::getGameByID($game['ID_GAME']);
        
        echo '<a id="'.$game->GameName.'" class="lobby_gamelist mb1" href="javascript:void(0)">';
        echo MainHelper::showImage($game, THUMB_LIST_40x40, false, array('no_img' => 'noimage/no_game_40x40.png'));
        echo '<span>'.$game->GameName.'</span>';
        echo '</a>';
    }
?>  
</div>
<div id="pn_tournaments_list" class="quickmatch_list esport_widget">
        <div class="esport_profile_boxheaders mt0"><p><?php echo $this->__('My game'); ?></p></div>
        <?php if(empty($myQuickmatches)){ ?>
                <div id="error_note" class="esport_widget">
                    <div id="loader" class="loader_red_small pull_left mr5" style="display:none"></div>
                    <p><?php echo $this->__('Create a quickmatch'); ?></p>
                </div>
        	<div class="clearfix mt10 ml5">
			<span>
				<select id="create_qm_game" class="dropkick_lightWide" name="game" tabindex="">
                                        <option value="0">
                                            <?php echo $this->__("Choose game") ?>
                                        </option>
                                        <?php foreach ($games as $game): ?>
                                        <?php $game = Games::getGameByID($game['ID_GAME']); ?>
						<option value="<?php echo $game->ID_GAME; ?>" >
							<?php echo $game->GameName; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>
		</div>
        	<div class="clearfix mt10 ml5">
			<span>
				<select id="create_qm_type" class="dropkick_lightWide" name="gametype" tabindex="">
                                        <option value="0">
                                            <?php echo $this->__("Choose gametype") ?>
                                        </option>
                                        <?php $gametypes = $esport->GetPlaymodes()?>
                                        <?php foreach ($gametypes as $gametype => $v): ?>
						<option value="<?php echo $v; ?>" >
							<?php echo $gametype; ?>
						</option>
					<?php endforeach; ?>
				</select>
			</span>
		</div>
                <div class="clearfix mt10 ml5 w140 pull_left" >
                    <span>
                            <input tabindex="1" style="display:none" id="create_qm_bet" name="betsize" type="text" value="Betsize" class="text_input w140" />
                    </span>
		</div> 
                <div class="clearfix mt20 w150 ml130 pull_left fcw" >
                <span><?php echo $profile['team']->Credits; ?> Credits / <?php echo $profile['team']->Coins; ?> Coins</span>
		</div> 
        <?php
        echo '<div class="tournament_buttons mt15 mb20">';
        echo '<a href="javascript:void(0)" class="button red" id="create_qm_button">'.$this->__('Create game').'</a>';
        echo '</div>';
        } ?>
        <ul class="tournament_list">
            <?php if(!empty($myQuickmatches)){ ?>
            <?php
                        $game = Games::getGameByID($myQuickmatches->FK_GAME);
                        $background_url = $esport->PickTournamentBackground($game->GameName);
                        $state = $myQuickmatches->MatchState;
                        $statemsg = '';
                        
                        switch($state){
                            case $esport->GetMatchState('Active'):
                                    $statemsg = 'Match in progress';
                                    break;
                            case $esport->GetMatchState('Open'):
                                    $statemsg = 'Waiting for opponent';
                                    break;
                        }
            ?>
                        <li class="<?php echo $background_url; ?>">
                                <?php echo MainHelper::showImage($game, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_game_60x60.png')); ?>
                                <h1 title="<?php echo $game->GameName; ?>"><?php echo $game->GameName.' 1v1'; ?></h1>
                                <h2 id="myMatchstate"><?php echo $this->__('State').': '.$this->__($statemsg); ?></h2>
                                <div id="" class="tournament_buttons">
                                        <span><?php echo $this->__('Actions').':'; ?></span>
                                        <a class="button red delete" id="<?php echo $myQuickmatches->ID_LEAGUE; ?>" href="javascript:void(0)"><?php echo $this->__('Delete'); ?></a>
                                </div>
                        </li>
           <?php } ?>
            
        </ul>
</div>
    <!-- Playnation tournaments start -->
<div id="pn_tournaments_list" class="quickmatch_list qm_all esport_widget">
        <div class="esport_profile_boxheaders mt0"><p><?php echo $title; ?></p></div>
                <?php if(empty($tournamentsList)){
                echo '<div class="ml15 mt10 mb10">'.$this->__('No matches available').'</div>';
        } ?>
        <ul class="tournament_list">
                <?php 
                foreach ($tournamentsList as $tournament): 

                        $game = Games::getGameByID($tournament->FK_GAME);
                        $background_url = $esport->PickTournamentBackground($game->GameName);
                        $host = $esport->getPlayerByTeam($tournament->Challenger);
                ?>
                        <li class="<?php echo $background_url; ?> <?php echo $game->GameName; ?>">
                               
                                <?php echo MainHelper::showImage($game, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_game_60x60.png')); ?>
                                <h1 title="<?php echo $game->GameName; ?>"><?php echo $game->GameName.' 1v1'; ?></h1>
                                <h2 style="top:30px;left:80px;"><?php echo $this->__('Challenger').': '; ?><span><?php echo $host->DisplayName; ?></span></h2>
                                <h3 style="top:50px;left:80px;"><?php echo $this->__('Playmode').': '; ?><span><?php echo $esport->GetPlayMode($tournament->PlayMode); ?></span></h3>
                                <h3 style="top:50px;left:300px;"><?php echo $this->__('Fee').': '; ?><span><?php echo $tournament->BetSize; ?></span></h3>
                                <h3 style="top:50px;left:400px;"><?php echo $this->__('Prize').': '; ?><span><?php echo $tournament->Account * 2; ?></span></h3>
                                <div class="tournament_buttons">
                                <?php if($tournament->MatchState == $esport->GetMatchState('Active')): ?>
                                        <span><strong><?php echo $this->__('Match in progress'); ?></strong></span>
                                <?php else: ?>
                                        <span><?php echo $this->__('Actions').': '; ?></span>
                                        <a class="button red join" id="<?php echo $tournament->ID_QUICKMATCH; ?>" href="javascript:void(0)"><?php echo $this->__('Join'); ?></a>
                                <?php endif; ?>
                                </div>
                        </li>
                <?php endforeach; ?>
        </ul>
</div>
<!-- Playnation tournaments end -->
<script>
    $(document.body).on('click','#quickmatch_gameslist .lobby_gamelist', function(event){
                
        //$(this).siblings().removeClass('active');
        
        if($(this).hasClass('active')){
            $(this).removeClass('active');
            
            var game = $(this).attr('id');
            var showAll = true;
            
            if($(this).siblings().hasClass('active')){
                showAll = false;
            }
            
            if(showAll === true){
                $(".qm_all ul li").show();
                $(".qm_all ul li").removeClass('active');
            }
            else{
                $(".qm_all ul li").each(function(){
                    var str = $(this).attr('class');

                    if (str.indexOf(game) >= 1){
                        $(this).removeClass('active');
                        $(this).hide();
                    }
                });
            }    
        }
        else{
            $(this).addClass('active');
            
            var game = $(this).attr('id');
            
            $(".qm_all ul li").each(function(){
                var str = $(this).attr('class');
                
                if (str.indexOf(game) === -1 && $(this).hasClass('active') === false){
                    $(this).hide();
                }
                else if (str.indexOf(game) >= 1){
                    $(this).addClass('active');
                    $(this).show();
                }
            });
        }    
    });
</script>