<?php
    $esport = new Esport();
    $onlineChannels = $channels['onlineChannels'];
    $featureChannels = $channels['featureChannels'];
    $offlineChannels =$channels['offlineChannels'];
    $favoriteChannels =$channels['favoriteChannels'];
    $onlineCount = $channels['onlineCount'];
    $offlineCount = $channels['offlineCount'];
?>

<!-- Main container start -->
<div id="container" class="clearfix">
	<!-- Main content start -->
	<div id="esports_wrapper">
            
        <?php echo $this->renderBlock('esport/common/topbar', array()); ?>
            
		<!-- E-Sports content start -->
		<div class="esports_content">
        <div class="esport_profile_boxheaders top_header"><p><?php echo $this->__('<span>Stream</span> coverage') ?></p></div>
        <div id="coverage_stream_large">
                    <div class="red_gradient_bg"><p><?php echo $this->__('Currently Viewing').': '.$activeChannel->ChannelName; ?></p></div>
                    <div id="esport_channelviewer" class="mt4">
                        <div class="chat_loader"></div>
                        <div class="stream_loader"></div>
                        <span id="esport_video_wrapper" style="display:none">
			<object type="application/x-shockwave-flash"
				height="370"
				width="657"
				id="esport_feature_flash_player"
                                data="http://da.twitch.tv/widgets/live_embed_player.swf?channel=<?php echo $activeChannel->TwitchName; ?>" bgcolor="#000000">
				<param name="allowFullScreen" value="true" />
				<param name="allowScriptAccess" value="always" />
				<param name="allowNetworking" value="all" />
				<param name="movie" value="http://da.twitch.tv/widgets/live_embed_player.swf" />
				<param name="flashvars" value="hostname=da.twitch.tv&channel=<?php echo $activeChannel->TwitchName; ?>&auto_play=false&start_volume=25" />
			</object>
                        </span>
                        <div id="esport_channelviewer_splitter">
                            <i class="esport_splitter"></i>
                        </div>
			<div id="coverage_chat"> 
				<iframe id="chat embed" width="380" scrolling="no" height="370" frameborder="0" style="display:none" 
                                        src="http://twitch.tv/chat/embed?channel=<?php echo $activeChannel->TwitchName; ?>&popout_chat=true">
                                </iframe>
                        </div>
                    </div>
                    <div class="red_gradient_bg"><p></p></div>
		</div>
        
        
			<div id="esports_coverage_left_column">
            	<div class="esport_profile_boxheaders header"><p><span>Channels</span></p></div>
                            <div class="channel_list">
                                <div id="channel_features" class="channel_accordion_header featured_channels red_gradient_bg">
                                    <h3><?php echo $this->__('Featured channels'); ?></h3>
                                </div>
                                <div class="channel_accordion_content">
                                    <ul class="esport_link_red">
                                    <?php foreach($featureChannels as $channel){

                                        echo '<li>';
                                        echo '<a class="icon_link" style="display:inline-block;width:230px" href="'.MainHelper::site_url('esport/coverage/'.$channel->TwitchName).'">';
                                        echo '<img src="'.$channel->ImageURL.'" />';
                                        echo '<span>'.$channel->ChannelName.'</span>';
                                        echo '</a>';
                                        echo '</li>';
                                    }
                                    ?>
                                    </ul>
                                    
                                </div>
                                <div id="channel_features" class="channel_accordion_header red_gradient_bg">
                                    <h3><?php echo $this->__('Favorite channels'); ?></h3>
                                </div>
                                <div class="channel_accordion_content red_gradient_bg">
                                    <ul class="esport_link_red">
                                    <?php foreach($favoriteChannels as $channel){

                                        echo '<li>';
                                        echo '<a class="icon_link" style="display:inline-block;width:230px" href="'.MainHelper::site_url('esport/coverage/'.$channel->TwitchName).'">';
                                        echo '<img src="'.$channel->ImageURL.'" />';
                                        echo '<span>'.$channel->ChannelName.'</span>';
                                        echo '</a>';
                                        echo '</li>';
                                    }
                                    ?>
                                    </ul>
                                    
                                </div>
                                <div id="channel_features" class="channel_accordion_header red_gradient_bg">
                                    <h3><?php echo $this->__('Online').' ('.$onlineCount.')'; ?></h3>
                                </div>
                                <div class="channel_accordion_content" style="display:none;">
                                    <ul class="esport_link_red">
                                    <?php foreach($onlineChannels as $channel){
                                        $filled = $channel->isFavorite ? 'icon_star_filled active' : 'icon_star_empty favorite';
                                        echo '<li>';
                                        echo '<a class="icon_link" style="display:inline-block;width:230px" href="'.MainHelper::site_url('esport/coverage/'.$channel->TwitchName).'">';
                                        echo '<img src="'.$channel->ImageURL.'" />';
                                        echo '<span>'.$channel->ChannelName.'</span>';
                                        echo '</a>';
                                        echo '<span style="display:none" id="'.$channel->TwitchName.'" class="star pull_right mr5 '.$filled.'"></span>';
                                        echo '</li>';
                                    }
                                    ?>
                                    </ul>
                                    
                                </div>
                                <div id="channel_features" class="channel_accordion_header red_gradient_bg">
                                    <h3><?php echo $this->__('Offline').' ('.$offlineCount.')'; ?></h3>
                                </div>
                                <div class="channel_accordion_content" style="display:none;">
                                    <ul class="esport_link_red">
                                    <?php foreach($offlineChannels as $channel){
                                        $filled = $channel->isFavorite ? 'icon_star_filled active' : 'icon_star_empty favorite';
                                        echo '<li>';
                                        echo '<a class="icon_link" style="display:inline-block;width:230px" href="'.MainHelper::site_url('esport/coverage/'.$channel->TwitchName).'">';
                                        echo '<img src="'.$channel->ImageURL.'" />';
                                        echo '<span>'.$channel->ChannelName.'</span>';
                                        echo '</a>';
                                        echo '<span style="display:none" id="'.$channel->TwitchName.'" class="star pull_right mr5 '.$filled.'"></span>';
                                        echo '</li>';
                                    }
                                    ?>
                                    </ul>
                                    
                                </div>
                            </div>
                                <div id="channel_list_bottom"></div>
                            
                            
	<!--			<span>Bet on this stream's winner:</span>
				<div class="betting_buttons">
					<a class="button red" href="#">Team 1</a>
					<a class="button blue" href="#">Team 2</a>
-->				<!--</div>
				<!-- <div id="stream_information">
					<!-- Information skal hentes med php 
					<div id="team_1_info">
						<span>Team 1</span>
						<div class="team_score">
							10/12/25
						</div>
						<div class="team_composition">
							<img src="<?php //echo MainHelper::site_url('global/img/esport/test/coverage_minis/jayce.png');?>"/><a href="#">Playername 1</a>
							<br/><img src="<?php //echo MainHelper::site_url('global/img/esport/test/coverage_minis/anivia.png');?>"/><a href="#">Playername 2</a>
							<br/><img src="<?php //echo MainHelper::site_url('global/img/esport/test/coverage_minis/xinzhao.png');?>"/><a href="#">Playername 3</a>
							<br/><img src="<?php //echo MainHelper::site_url('global/img/esport/test/coverage_minis/draven.png');?>"/><a href="#">Playername 4</a>
							<br/><img src="<?php //echo MainHelper::site_url('global/img/esport/test/coverage_minis/sona.png');?>"/><a href="#">Playername 5</a>
						</div>
					</div>
					<div id="team_2_info">
						<span>Team 2</span>
						<div class="team_score">
							12/10/23
						</div>
						<div class="team_composition">
							<img src="<?php //echo MainHelper::site_url('global/img/esport/test/coverage_minis/jayce.png');?>"/><a href="#">Playername 6</a>
							<br/><img src="<?php //echo MainHelper::site_url('global/img/esport/test/coverage_minis/anivia.png');?>"/><a href="#">Playername 7</a>
							<br/><img src="<?php //echo MainHelper::site_url('global/img/esport/test/coverage_minis/xinzhao.png');?>"/><a href="#">Playername 8</a>
							<br/><img src="<?php //echo MainHelper::site_url('global/img/esport/test/coverage_minis/draven.png');?>"/><a href="#">Playername 9</a>
							<br/><img src="<?php //echo MainHelper::site_url('global/img/esport/test/coverage_minis/sona.png');?>"/><a href="#">Playername 10</a>
						</div>
					</div> -->
				
			</div>
            <div class="left_border_grey_gradient">
            </div>
			<div id="esports_coverage_right_column">
				<div id="betting_matches_streams" style="display:table">
                	<div class="esport_profile_boxheaders header"><p><?php echo $this->__('Live <span>streams</span>') ?></p></div>
                                    <?php foreach($onlineChannels as $channel): ?>
                                    <?php try{ ?>
					<div class="betting_stream_small">
                        <a href="<?php echo MainHelper::site_url('esport/coverage/'.$channel->TwitchName); ?>"><img src="<?php echo $channel->Screenshot;?>"/></a>
						<div class="stream_info">
							<img class="stream_game" src="<?php echo $channel->ImageURL;?>" title="<?php echo $channel->ChannelName; ?>" alt="<?php echo $channel->TwitchName; ?>"/>
							<ul>
								<li><span><?php echo $channel->Title; ?></span></li>
								<li><?php echo $channel->GameName; ?> - <?php echo $channel->Viewers.' '.$this->__('viewers'); ?></li>
							</ul>
						</div>
					</div>
                                    <?php }catch(Exception $e){}; ?>
                                    <?php endforeach; ?>
				</div>
			</div>
		</div>
		<!-- E-Sports content end -->
	</div>
	<!-- Main content end -->
</div>
<!-- Main container end -->	
<script>
    $(".favorite").mouseenter(function(){
        $(this).removeClass('icon_star_empty');
        $(this).addClass('icon_star_filled');
    });
    $(".favorite").mouseleave(function(){
        
        if($(this).hasClass("active") === false){
            $(this).removeClass('icon_star_filled');
            $(this).addClass('icon_star_empty');
        }
    });
    $(".channel_accordion_content li").mouseenter(function(){
        $(this).children('.star').show();
    });
    $(".channel_accordion_content li").mouseleave(function(){
        $(this).children('.star').hide();
    });
    $(document.body).on('click','.favorite',function(){
            $(this).removeClass('favorite');
            $(this).addClass('active');
        
         $.post(site_url+"esport/ajaxsetfavorite",{
                 channel: $(this).attr('id'),
                 remove: false
            }, function(data){
         });  
    });
    $(document.body).on('click','.active',function(event){
        $(this).removeClass('active');
        $(this).addClass('favorite');
        $(this).removeClass('icon_star_filled');
        $(this).addClass('icon_star_empty');
        
         $.post(site_url+"esport/ajaxsetfavorite",{
                 channel: $(this).attr('id'),
                 remove: true
            }, function(data){
         });  
    });
    
</script>