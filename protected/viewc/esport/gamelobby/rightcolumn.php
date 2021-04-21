<?php 
    $player = User::getUser(); 
    $games = $profile['games'];    
?>
    
<input type="hidden" id="username" value="<?php echo $player->DisplayName; ?>"/>
<input type="hidden" id="userid" value="<?php echo $player->ID_PLAYER; ?>"/>

<div class="esports_right_column">
    <div class="online_count"><img class="mr5" src="<?php echo Doo::conf()->APP_URL.'global/img/onlineindicator.png'; ?>" /><span><?php echo $profile['onlinecount'].' '.$this->__('online'); ?></span></div>
    <!-- Set default menu page -->
    <?php echo $this->renderBlock('esport/common/gamelobby_menu',array('progress' => 'quickmatch')); ?>
    <div id="gamelobby_topbar">
    <!-- <marquee style="color:rgb(186,57,51)" id="infobox" behavior="scroll" direction="left"></marquee> -->
    <div class="esport_widget lobby_notebox">
        <div class="esport_profile_boxheaders mt0 mb1"><p><?php echo $this->__('Notifications'); ?></p></div>
        <?php echo $this->renderBlock('esport/gamelobby/common/notebox',array('notifications' => $profile['myNotifications'])); ?>
 
    </div>
    <div class="esport_widget lobby_chatbox">
    	<div class="esport_profile_boxheaders mt0 mb1"><p><?php echo $this->__('<span>Lobby</span> Chat'); ?></p></div>
        <?php echo $this->renderBlock('esport/gamelobby/common/chatbox',array('player' => $player, 'state' => $profile['chatbox_state'])); ?>
    </div>
    </div>
    
    <!-- Games and challenges -->
    <div class="lobby_games esport_widget">
    	<div class="esport_profile_boxheaders mt0 mb1"><p><?php echo $this->__('<span>Games and</span> Challenges'); ?></p></div>
    	<div class="games_button back">
        	<a href='javascript:slide("left");'><img src="../global/css/img/esport_lobby_arrow_back.png" /></a>
        </div>
    	<div class="games_button forward">
        	<a href='javascript:slide("right");'><img src="../global/css/img/esport_lobby_arrow_forward.png" /></a>
        </div>
        <div class="games_and_challenges_gamelist esport_widget_content">
            <div class="games_and_challenges_inner">
                <ul class="games_and_challenges ">
                    <?php $count = 1; ?>
                    <?php $mid = count($games) > 4 ? count($games) / 2 : 4; ?>
                    <?php foreach($games as $game): ?>
                    <?php $ogame = new SnGames(); ?>
                    <?php $ogame->ImageURL = $game['ImageURL']; ?>
                    <li <?php echo $count == $mid ? 'class="focus"' : ''; ?>>
                        
                            <?php echo MainHelper::showImage($ogame, THUMB_LIST_121x150, false, array('no_img' => 'noimage/no_game_121x150.png' )); ?>
                                               <a href="<?php echo $game['URL']; ?>"><p><?php echo $game['GameName']; ?></p></a>
                    </li>
                    <?php $count++; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="lobby_challenges esport_widget_content">
    	<ul>
        <li>
        	<img src="../global/css/img/free2play.png" />
        </li>
        <li>
        	<img src="../global/css/img/pay2play_coins.png" />
        </li>
        <li>
        	<img src="../global/css/img/pay2play_credits.png" />
        </li>
        </ul>
    </div>
    <div class="esport_widget lobby_games">
    	<div class="esport_profile_boxheaders"><p><?php echo $this->__('<span>Active</span> Challenges'); ?></p></div>
        <div class="esport_widget_content active_challenges">
        	<ul>
            	<li style="background-image: url('../global/css/img/gamecover_wide_csgo.png')">
                	<a href="#Game_profile_page_or_something"><img class="challenge_gamecover" src="../global/css/img/gamecover_csgo.png" /></a>
                    <div class="challenge_content">
                    	<a href="#SKAL DET VÆRE ET LINK?"><p class="game_name">Counter Strike - Global Offensive (5vs5)</p></a>
                        <a href="#Users_profile"><p class="challenger_name">Challenger: n0thing</p></a>
                    </div>
                    <div class="challenge_response">
                    	<a class="button button_small grey btn_red_gradient_bg" href="#">Join</a>
                    </div>
                </li>
                <li style="background-image: url('../global/css/img/gamecover_wide_csgo.png')">
                	<a href="#Game_profile_page_or_something"><img class="challenge_gamecover" src="../global/css/img/gamecover_csgo.png" /></a>
                    <div class="challenge_content">
                    	<a href="#SKAL DET VÆRE ET LINK?"><p class="game_name">Counter Strike - Global Offensive (5vs5) Meeega langt game navn der ikke kan være på en linje</p></a>
                        <a href="#Users_profile"><p class="challenger_name">Challenger: en-newbie-med-verdens-længste-nickname-der-ikke-kan-være-på-en-linje-umuuuuuuuuuuuuliiiiiiiigt</p></a>
                    </div>
                    <div class="challenge_response">
                    	<a class="button button_small grey btn_red_gradient_bg" href="#">Join</a>
                    </div>
                </li>
                <li style="background-image: url('../global/css/img/gamecover_wide_csgo.png')">
                	<a href="#Game_profile_page_or_something"><img class="challenge_gamecover" src="../global/css/img/gamecover_csgo.png" /></a>
                    <div class="challenge_content">
                    	<a href="#SKAL DET VÆRE ET LINK?"><p class="game_name">Counter Strike - Global Offensive (5vs5)</p></a>
                        <a href="#Users_profile"><p class="challenger_name">Challenger: n0thing</p></a>
                    </div>
                    <div class="challenge_response">
                    	<a class="button button_small grey btn_red_gradient_bg" href="#">Join</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!-- Games and challenges END -->
    
    
    
    <!-- Sections showed according to selected menu. Changes automatically when added. Remember display:none for all other than startpage -->
    <!-- default page - quickmatch // set in top -->
    <!-- **************** READ ME ******************* More php i dont know if youll need. Else delete it
    <div class="section" id="gl_tournaments" style="display:none">
        <?php // $tournamentsFree = $profile['tournamentsFree']; ?>
        <?php // echo $this->renderBlock('esport/tournaments/tournamentList', array('title'=>$this->__('Free2Play tournaments'),'tournamentsList' => $tournamentsFree)); ?>
        <?php // echo $this->renderBlock('esport/tournaments/tournamentList', array('title'=>$this->__('Pay2Play tournaments (credits) '),'tournamentsList' => $profile['tournamentsCredits'])); ?>
        <?php // echo $this->renderBlock('esport/tournaments/tournamentList', array('title'=>$this->__('Pay2Play tournaments (coins)'),'tournamentsList' => $profile['tournamentsCoins'])); ?>
    </div>
    <!-- quickmatch page -->
    <!--<div  class="section" id="gl_quickmatch">
        <?php // $myTournaments = array(); ?>
        <?php // echo $this->renderBlock('esport/gamelobby/gamelist', array('title'=>$this->__('Current challenges'),'myQuickmatches' => $profile['myQuickmatches'],'games' => $profile['games'], 'tournamentsList' => $profile['Quickmatches'], 'profile' => $profile)); ?>       
    </div>-->
    <!-- End of sections -->
</div>
<script>
    function slide(where){  
            //get the item width 
            //make the sliding effect using jQuery's animate function... '  
             var item_width = 90;  
 
            /* using a if statement and the where variable check 
            we will check where the user wants to slide (left or right)*/  
            if(where == 'left'){  
                //...calculating the new left indent of the unordered list (ul) for left sliding  
                var left_indent = parseInt($('.games_and_challenges').css('left')) + item_width;  
            }else{  
                //...calculating the new left indent of the unordered list (ul) for right sliding  
                var left_indent = parseInt($('.games_and_challenges').css('left')) - item_width;  
  
            }           
            $('.games_and_challenges li').each(function(){
                if($(this).hasClass('focus') && ((where == 'left' && $(this).is(":first-child") !== true)||(where == 'right' && $(this).is(":last-child") !== true))){
                    if(where == 'left'){
                        $(this).prev().addClass('focus');
                    }
                    else{
                        $(this).next().addClass('focus');
                    }
                    
                    $(this).removeClass('focus');
                    $(".games_and_challenges").animate({left: left_indent});
                    return false;
                }
            });
            
  
    }
    
    $('.lobby_challenges li').click(function(){
        $('.lobby_challenges li').removeClass('active');
        $(this).addClass('active');
    })
</script>