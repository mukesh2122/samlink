<?php
$fcp = $profile['teams'];
$esport = new Esport();
$fanclub = $profile['fanclub'];
$pf_rel = $profile['playerfanclub'];

$isLiked = !empty($pf_rel) ? $pf_rel->isLiked() : false;
$isSubscribed = !empty($pf_rel) ? $pf_rel->isSubscribed() : false;
?>

<div class="esports_right_column">
	<!-- Header start -->
	<div id="news_header">
		<img src="<?php echo MainHelper::site_url('global/img/icon.png');?>" alt=""/>
		<span><?php echo $this->__('Fanclubs'); ?></span>
	<div class="tournament_buttons mt5">
		<!-- To see the rankings of different games -->
                <?php if($profile['player']->ID_TEAM == $profile['fanclub']->FK_TEAM): ?>
                    <a class="button red" href="<?php echo Mainhelper::site_url('esport/fanclubs/updatefanclub/'.$profile['player']->ID_TEAM); ?>"><?php echo $this->__('Update fanclubinfo'); ?></a>
                <?php endif; ?>
	</div>
	</div>
	<!-- Header end -->

	<?php
	//foreach ($fanclubplayers as $fcp)
	//{
		$fcp_player = $esport->GetPlayerByTeam($fcp->ID_TEAM);
		$country = PlayerHelper::getCountry($fcp_player->Country);
                $model = $fanclub->isProfileUrl == 0 ? $fanclub : $fcp_player;
		?>
		<div id="fanclubs_header" class="esport_widget">
                   
			
			<div class="fanclub_img_container"><?php echo MainHelper::showImage($model, THUMB_LIST_150x200, false, array('width', 'no_img' => 'noimage/no_player_150x200.png'));?></div>
			<h1><?php echo "{$fcp->DisplayName}"; ?></h1>
			<h2>
			<?php
				$games = $profile['games'];
				$c = "";
				foreach ($games as $game)
				{
					echo $c.$game['GameName'];
					$c = ", ";
				}			
			?>
			</h2>
			<div class="fanclub_buttons">
                            <a data-opt="{&quot;id&quot;:&quot;<?php echo $fanclub->FK_TEAM; ?>&quot;, &quot;type&quot;:&quot;fanclub&quot;}" class="button button_178 button_icon button_no_shadow baby_blue clearfix <?php echo $isSubscribed ? 'dn' : ''; ?> subscribe subscribe_<?php echo $fanclub->FK_TEAM; ?>" href="javascript:void(0)">
                                    <span class="text mt3"><?php echo $this->__('Subscribe'); ?></span>
                                    <span class="icon iconr_subscribe">&nbsp;</span>
                            </a>
                            <a data-opt="{&quot;id&quot;:&quot;<?php echo $fanclub->FK_TEAM; ?>&quot;, &quot;type&quot;:&quot;fanclub&quot;}" class="button button_178 button_icon button_no_shadow baby_blue clearfix <?php echo $isSubscribed ? '' : 'dn'; ?> unsubscribe unsubscribe_<?php echo $fanclub->FK_TEAM; ?>" href="javascript:void(0)">
                                    <span class="text mt3"><?php echo $this->__('Unsubscribe'); ?></span>
                                    <span class="icon iconr_subscribe">&nbsp;</span>
                            </a>
                            <a class="button button_178 button_icon button_no_shadow light_grey clearfix <?php echo $isLiked ? 'dn' : ''; ?> fanclub_like like like_<?php echo $fanclub->FK_TEAM; ?>" href="javascript:void(0)" rel="<?php echo $fanclub->FK_TEAM; ?>">
                                    <span class="text mt3"><?php echo $this->__('Like'); ?></span>
                                    <span class="icon iconr_like mt3 mb2">&nbsp;</span>
                            </a>
                            <a class="button button_178 button_icon button_no_shadow light_grey clearfix <?php echo $isLiked ? '' : 'dn'; ?> fanclub_unlike unlike unlike_<?php echo $fanclub->FK_TEAM; ?>" href="javascript:void(0)" rel="<?php echo $fanclub->FK_TEAM; ?>">
                                    <span class="text mt3"><?php echo $this->__('Unlike'); ?></span>
                                    <span class="icon iconr_like mt3 mb2">&nbsp;</span>
                            </a>
				 <!--				</a>
<a class="button button_178 button_icon button_no_shadow light_grey clearfix send_message" href="javascript:void(0)" rel="70">
					<span class="text mt2">Message</span>
					<span class="icon iconr_send_message mt2 mb2">&nbsp;</span>
				</a>
				<a class="button button_178 button_icon button_no_shadow light_grey clearfix group_like like like_70" href="javascript:void(0)" rel="70">
					<span class="text mt2">Gallery</span>
					<span class="icon iconr_like mt2 mb2">&nbsp;</span>
				</a> -->
			</div>
			<div class="fanclub_description_background"></div>
			<div class="fanclub_description">
				<?php echo $fanclub->WelcomeMessage; ?>
			</div>
		</div>
            <div id="fanclub_content">
                
		<div id="fanclub_information" class="esport_widget">
			<ul>
				<li>
					<span><?php echo $this->__('Teams').':'; ?></span><br/>
					<span>
					<?php
						$teams = $profile['teams'];
						$c = "";
						//foreach ($teams as $team)
						//{
							echo $c.$teams->DisplayName;
							$c = "<br/>";
						//}			
					?>
					</span>
				</li>
				<li>
					<span><?php echo $this->__('Nationality').':'; ?></span><br/>
					<span><?php echo $country; ?></span>
				</li>
			</ul>
		</div>
                        
		
		<div id="fanclub_wall">

			<?php

			//Redirect if walls not enabled
			if (MainHelper::IsModuleEnabledByTag('walls') != 0)
			{
				$wall = new Wall();
				$list = array();
				
				$type = WALL_HOME;
				$friendUrl = '';

				$list['infoBox'] = MainHelper::loadInfoBox('Players', $type, true);

				$poster = $fcp_player;
				$idAlbum = 0;
				MainHelper::getWallPosts($list, $fcp_player, 0, $type, $friendUrl, $idAlbum);
				
				$list['poster']    = $poster;
				$list['friendUrl'] = $friendUrl;
				$list['wallType']  = $type;

				
				echo $this->renderBlock('common/universal_wall_input', array(
					'post_text' => $this->__('Leave a message...'),
					'wallType'  =>  WALL_OWNER_FRIEND.'_'.$list['wallType'],
					'button'    => 	$this->__('Post message'),
					'posts'     => $list['posts'],
					'global'     => true,
					'obj'       => $list['poster'],
					'postCount' => $list['postCount'],
					'id_album'  => $idAlbum
				));
				
			}
			
			
			?>
		</div>
                  <br class="clear" />     
            </div>
	<?php
	//}
	?>
	</div>
</div>