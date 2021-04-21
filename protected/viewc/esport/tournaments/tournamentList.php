<!-- Playnation tournaments start -->
<div id="pn_tournaments_list" class="accordion esport_widget">
        <div class="esport_profile_boxheaders cursor_pointer"><p><?php echo $title; ?></p></div>
        <ul class="tournament_list" style='display:none'>
                <?php 
                $player = User::getUser();
                foreach ($tournamentsList as $tournament): 
                        $esport = new Esport();
                        $LeagueName = $tournament['LeagueName'];
                        $countSponsors = $esport->getTotalSponsors($tournament['ID_LEAGUE']);
                        if($countSponsors == 3)
                            $LeagueNameShort = strlen($LeagueName) > 35 ? substr($LeagueName,0,35).'...' : $LeagueName ;
                        else if($countSponsors == 2)
                            $LeagueNameShort = strlen($LeagueName) > 50 ? substr($LeagueName,0,50).'...' : $LeagueName ;
                        else    
                            $LeagueNameShort = strlen($LeagueName) > 55 ? substr($LeagueName,0,55).'...' : $LeagueName ;
                        
                        $sponsors = $esport->GetSponsorsByLeague($tournament['ID_LEAGUE']);
                        $StartTime = $tournament['StartTime'];
                        $host = $esport->GetHost($tournament['Host']);
                        $isSignedUp = $esport->isTeamSignedUp($player->ID_TEAM,$tournament['ID_LEAGUE']);
                        $game = Games::getGameByID($tournament['ID_GAME']);
                        $background_url = $esport->PickTournamentBackground($game->GameName);
                ?>
                        <li class="<?php echo $background_url; ?>">
                               
                                <?php echo MainHelper::showImage($game, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_game_60x60.png')); ?>
                                <h1 title="<?php echo $LeagueName; ?>"><?php echo $LeagueNameShort; ?></h1>
                                <h2><?php echo isset($host[0]) ? $this->__('Hosted by').': '.$host[0]['DisplayName'] : ''; ?></h2>
                                <h3><?php echo date("d-m-Y", $StartTime); ?>
                                <br/><?php echo $this->__('Start-time').': '.date("H:i", $StartTime); ?></h3>
                                <div class="tournament_sponsors">
                                    <ul class="sponsor_list">
                                        <?php foreach($sponsors as $sponsor):
                                            echo "<li><a target='_blank' title='".$sponsor->SponsorName."' href='".$sponsor->Link."'><img src='".MainHelper::site_url('global/pub_img/esport/sponsors/'.$sponsor->ImageURL)."'/></a></li>";
                                        endforeach;?>
                                    </ul>
                                </div>
                                <div id="<?php echo $isSignedUp; ?>" class="tournament_buttons">
                                    <?php if($isSignedUp): ?>
                                        <span><strong> <?php echo $this->__('Signed up'); ?></strong></span>
                                    <?php else: ?>
                                        <span><?php echo $tournament['TournamentType'] == 'Cup' ? $this->__('Join this cup').':' : $this->__('Join this league').':'; ?></span>
                                    <?php endif; ?>
                                        <a class="button red" target="_blank" href="<?php echo MainHelper::site_url('esport/tournamentinfo/'.$tournament['ID_LEAGUE']); ?>"><?php echo $this->__('Information'); ?></a>
                                </div>
                        </li>
                <?php endforeach; ?>
        </ul>
</div>
<!-- Playnation tournaments end -->

