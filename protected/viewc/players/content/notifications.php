<?php include(realpath(dirname(__FILE__) . '/../common/top.php'));?>

<?php

echo $this->renderBlock('players/common/search', array(
    'url' => MainHelper::site_url('players/notifications/search'),
    'searchText' => isset($searchText) ? $searchText : '',
    'searchTotal' => isset($searchTotal) ? $searchTotal : 0,
    'default' => $this->__('Search for notifications...')
    ));

if($searchText == '') {
    echo $this->renderBlock('players/common/title_bar', array(
    	'title'		=> $this->__('My notifications'),
    	'total'		=> $pagerObj->totalItem
	));
}
?>

<div class="clear mt10"></div>
<?php
$num = 0;
if (!empty($notifications)) :
    foreach ($notifications as $item): ?>
        <?php
            $typeResult = $item->getByType();
            $item->markAsRead();
            $img = "";
            $notif_msg = "";
            $additional_text = "";

            switch ($item->NotificationType) {
				//working
                case NOTIFICATION_REPLY_MY_WALL:
                    $players = array();
                    if(!empty($typeResult->rel)) {
                        foreach ($typeResult->rel as $rel) {
                            $p = $rel->Players;
                            $players[] = '<a href="'.MainHelper::site_url('player/'.$p->URL).'">'.PlayerHelper::showName($p).'</a>';
                        }
                    }

                    if(!empty($players)) {
                        $notif_msg = $this->__('Player(s) [_1] commented on your wall [_2]post[_3].', array(
                                                                                                    implode(", ", $players),
                                                                                                    '<a href="'.MainHelper::site_url('post/'.$typeResult->post_id).'">',
                                                                                                    '</a>'
                                                                                                    ));
                        $img = '<a href="'. MainHelper::site_url('player/'.$p->URL).'">'.MainHelper::showImage($p, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png')).'</a>';
                    }
                    break;
                //working
                case NOTIFICATION_POST_ON_MY_WALL:
					$img = '<a href="'. MainHelper::site_url('player/'.$typeResult->player->URL).'">'.MainHelper::showImage($typeResult->player, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png')).'</a>';
                    $notif_msg = $this->__('Player [_1] posted on your wall [_2]post[_3].', array(
																					'<a href="'.MainHelper::site_url('player/'.$typeResult->player->URL).'">'.PlayerHelper::showName($typeResult->player).'</a>',
																					'<a href="'.MainHelper::site_url('post/'.$typeResult->post_id).'">',
																					'</a>'
																					));
                    break;
				//working
                case NOTIFICATION_REPLY_POST_MY_WALL:
					$players = array();
                    if(!empty($typeResult->rel)) {
                        foreach ($typeResult->rel as $rel) {
                            $p = $rel->Players;
                            $players[] = '<a href="'.MainHelper::site_url('player/'.$p->URL).'">'.PlayerHelper::showName($p).'</a>';
                        }
                    }

                    if(!empty($players)) {
						$img = '<a href="'. MainHelper::site_url('player/'.$p->URL).'">'.MainHelper::showImage($p, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png')).'</a>';
						$notif_msg = $this->__('Player(s) [_1] commented the [_2]post[_3] by [_4] on your wall.', array(
																						implode(", ", $players),
																						'<a href="'.MainHelper::site_url('post/'.$typeResult->post_id).'">',
																						'</a>',
																						'<a href="'.MainHelper::site_url('player/'.$typeResult->playerPostOwner->URL).'">'.PlayerHelper::showName($typeResult->playerPostOwner).'</a>'
																						));
						//Player <ID_FROM> commented the post by <ID_TERTIARY> on your wall.
                    }
					break;
                //working
                case NOTIFICATION_REPLY_POST_OTHER_WALL:
					$players = array();
                    if(!empty($typeResult->rel)) {
                        foreach ($typeResult->rel as $rel) {
                            $p = $rel->Players;
                            $players[] = '<a href="'.MainHelper::site_url('player/'.$p->URL).'">'.PlayerHelper::showName($p).'</a>';
                        }
                    }

                    if(!empty($players)) {
						$img = '<a href="'. MainHelper::site_url('player/'.$p->URL).'">'.MainHelper::showImage($p, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png')).'</a>';
						$notif_msg = $this->__('Player(s) [_1] commented your [_2]post[_3] on [_4] wall.', array(
																						implode(", ", $players),
																						'<a href="'.MainHelper::site_url('post/'.$typeResult->post_id).'">',
																						'</a>',
																						'<a href="'.MainHelper::site_url('player/'.$typeResult->playerPostOwner->URL).'">'.PlayerHelper::showName($typeResult->playerPostOwner).'</a>'
																						));

						//Player <ID_FROM> commented your post on <ID_TERTIARY>'s wall.
					}
                    break;
                //working
                case NOTIFICATION_REPLY_MY_REPLY:
                    $players = array();
                    if(!empty($typeResult->rel)) {
                        foreach ($typeResult->rel as $rel) {
                            $p = $rel->Players;
                            $players[] = '<a href="'.MainHelper::site_url('player/'.$p->URL).'">'.PlayerHelper::showName($p).'</a>';
                        }
                    }

                    if(!empty($players)) {
                        $posterLink = '<a href="'.MainHelper::site_url('player/'.$typeResult->player->URL).'">'.PlayerHelper::showName($typeResult->player).'</a>';

                        $notif_msg = $this->__('Player(s) [_1] also commented the [_2]post[_3] by [_4].', array(
                                                                                                        implode(", ", $players),
                                                                                                        '<a href="'.MainHelper::site_url('post/'.$typeResult->post_id).'">',
                                                                                                        '</a>',
                                                                                                        $posterLink
                                                                                                        ));
                        $img = '<a href="'. MainHelper::site_url('player/'.$p->URL).'">'.MainHelper::showImage($p, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png')).'</a>';
                    }
                    break;

				//working
                case NOTIFICATION_PUBLIC_BY_SUBSCRIBE:
					$ownerPrefix = "";
					if(isset($typeResult->type)) {
						if($typeResult->type->TypeName == PLAYER) {
							$ownerPrefix = $this->__('Player');
						} else if($typeResult->type->TypeName == GROUP) {
							$ownerPrefix = $this->__('Group');
						} else if($typeResult->type->TypeName == COMPANY) {
							$ownerPrefix = $this->__('Company');
						} else if($typeResult->type->TypeName == GAME) {
							$ownerPrefix = $this->__('Game');
						} else if($typeResult->type->TypeName == EVENTS) {
							$ownerPrefix = $this->__('Event');
						}

						$img = '<a href="'. $typeResult->type->URL.'">'.MainHelper::showImage($typeResult->type->Type, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_'.$typeResult->type->TypeName .'_60x60.png')).'</a>';

						$notif_msg = $ownerPrefix.' '.$this->__('[_1][_2][_3], whom you subscribe to, has posted a new public [_4]post[_5].', array(
																										'<a href="'. $typeResult->type->URL.'">',
                                                                                                        $typeResult->type->Name,
																										'</a>',
                                                                                                        '<a href="'.MainHelper::site_url('post/'.$typeResult->post_id).'">',
                                                                                                        '</a>'
                                                                                                        ));

					}

                    //Player <ID_FROM>, whom you subscribe to, has posted a new public post.
                    break;
                //working
                case NOTIFICATION_LIKE:
                    $players = array();
                    if(!empty($typeResult->rel)) {
                        foreach ($typeResult->rel as $rel) {
                            $p = $rel->Players;
                            $players[] = '<a href="'.MainHelper::site_url('player/'.$p->URL).'">'.PlayerHelper::showName($p).'</a>';
                        }
                    }

                    if(!empty($players)) {
                        $notif_msg = $this->__('Player(s) [_1] liked your [_2]post[_3].', array(
                                                                                        implode(", ", $players),
                                                                                        '<a href="'.MainHelper::site_url('post/'.$typeResult->post_id).'">',
                                                                                        '</a>'
                                                                                        ));
                        $img = '<a href="'. MainHelper::site_url('player/'.$p->URL).'">'.MainHelper::showImage($p, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png')).'</a>';
                    }
                    break;
                //working
                case NOTIFICATION_DISLIKE:
                    $players = array();
                    if(!empty($typeResult->rel)) {
                        foreach ($typeResult->rel as $rel) {
                            $p = $rel->Players;
                            $players[] = '<a href="'.MainHelper::site_url('player/'.$p->URL).'">'.PlayerHelper::showName($p).'</a>';
                        }
                    }
                    if(count($players)) {
                        $notif_msg = $this->__('Player(s) [_1] disliked your [_2]post[_3].', array(
                                                                                        implode(", ", $players),
                                                                                        '<a href="'.MainHelper::site_url('post/'.$typeResult->post_id).'">',
                                                                                        '</a>'
                                                                                        ));
                        $img = '<a href="'. MainHelper::site_url('player/'.$p->URL).'">'.MainHelper::showImage($p, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png')).'</a>';
                    }
                    break;
                //working
                case NOTIFICATION_SUBSCRIBE_PLAYER:
                    $img = '<a href="'. MainHelper::site_url('player/'.$typeResult->URL).'">'.MainHelper::showImage($typeResult, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png')).'</a>';
                    $notif_msg = $this->__('Player [_1] is now subscribed to you.', array('<a href="'.MainHelper::site_url('player/'.$typeResult->URL).'">'.PlayerHelper::showName($typeResult).'</a>'));
                    break;

				//trigger error
                case NOTIFICATION_FRIEND_REQUEST:
                    $img = '<a href="'. MainHelper::site_url('player/'.$typeResult->URL).'">'.MainHelper::showImage($typeResult, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png')).'</a>';
                    $notif_msg = $this->__('Player [_1] has sent you a friend request.', array('<a href="'.MainHelper::site_url('player/'.$typeResult->URL).'">'.PlayerHelper::showName($typeResult).'</a>'));
                    $p = User::getUser();

                    if($p and !$p->isFriend($typeResult->ID_PLAYER)) {
                        $additional_text = '<div class="tac fl clearfix mt5 mb5 pr5">
                                <a href="javascript:void(0)" class="buttonRRound groupSearchRound add_friend_from_notif fl" rel="'.$typeResult->ID_PLAYER.'">
                                    <span class="lrc"></span>
									<span class="mrc">
										<span class="fl fs11"><strong>'.$this->__('Accept').'</strong></span>
									</span>
									<span class="rrc"></span>
                                </a>
                                <a href="javascript:void(0)" class="buttonRRound groupSearchRound fl reject_friend_from_notif fl ml5" rel="'.$typeResult->ID_PLAYER.'">
                                    <span class="lrc"></span>
									<span class="mrc">
										<span class="fl fs11"><strong>'.$this->__('Reject').'</strong></span>
									</span>
									<span class="rrc"></span>
                                </a>
                            </div>';
                    }
                    break;
                //trigger error
                case NOTIFICATION_FRIEND_REPLY:
                    $img = '<a href="'. MainHelper::site_url('player/'.$typeResult->URL).'">'.MainHelper::showImage($typeResult, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png')).'</a>';
                    $notif_msg = $this->__('Player [_1] has accepted your friend request.', array('<a href="'.MainHelper::site_url('player/'.$typeResult->URL).'">'.PlayerHelper::showName($typeResult).'</a>'));
                    break;

				//working badly
				//wrong board
				//wrong topic
                case NOTIFICATION_NEW_FORUM_POST:
                    $players = array();
                    if(!empty($typeResult->rel)) {
                        foreach ($typeResult->rel as $rel) {
                            $p = $rel->Players;
                            $players[] = '<a href="'.MainHelper::site_url('player/'.$p->URL).'">'.PlayerHelper::showName($p).'</a>';
                        }
                    }
                    if(count($players)) {
                        $img = '<a href="'. MainHelper::site_url('player/'.$p->URL).'">'.MainHelper::showImage($p, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png')).'</a>';
                        $notif_msg = $this->__('Player(s) [_1]  has posted in a topic: [_2] in forum: [_3] - [_4].', array(
                                                                                                    implode(", ", $players),
                                                                                                    '<a href="'.$typeResult->topic->URL.'">'.$typeResult->topic->TopicName.'</a>',
                                                                                                    '<a href="'.$typeResult->type->URL.'">'.$typeResult->type->Name.'</a>',
                                                                                                    '<a href="'.$typeResult->board->URL.'">'.$typeResult->board->BoardName.'</a>',
                                                                                                    ));
                    }
                    //Player <ID_FROM> has posted in a topic in <ID_SECONDARY>
                    break;

				//working badly
				//wrong board
				//wrong topic
                case NOTIFICATION_NEW_FORUM_TOPIC:
                    $img = '<a href="'. MainHelper::site_url('player/'.$typeResult->player->URL).'">'.MainHelper::showImage($typeResult->player, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png')).'</a>';
                    $notif_msg = $this->__('Player [_1] has posted a new topic: [_2] in forum [_3] - [_4].', array(
                                                                                                    '<a href="'.MainHelper::site_url('player/'.$typeResult->player->URL).'">'.PlayerHelper::showName($typeResult->player).'</a>',
                                                                                                    '<a href="'.$typeResult->topic->URL.'">'.$typeResult->topic->TopicName.'</a>',
                                                                                                    '<a href="'.$typeResult->type->URL.'">'.$typeResult->type->Name.'</a>',
                                                                                                    '<a href="'.$typeResult->board->URL.'">'.$typeResult->board->BoardName.'</a>',
                                                                                                    ));

                    break;
                //working
                case NOTIFICATION_COMPANY_NEWS:
                    $img = '<a href="'. $typeResult->newsitem->URL.'">'.MainHelper::showImage($typeResult->newsitem, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_news_60x60.png')).'</a>';
                    $notif_msg = $this->__('News from company [_1].', array('<a href="'.$typeResult->company->COMPANY_URL.'">'.$typeResult->company->CompanyName.'</a>'));

                    //News from company <ID_FROM>
                    break;
                //working
                case NOTIFICATION_GAME_NEWS:
                    $img = '<a href="'. $typeResult->newsitem->URL.'">'.MainHelper::showImage($typeResult->newsitem, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_news_60x60.png')).'</a>';
                    $notif_msg = $this->__('News from game [_1].', array('<a href="'.$typeResult->game->GAME_URL.'">'.$typeResult->game->GameName.'</a>'));

                    //News from game <ID_FROM>.
                    break;
                //working
                case NOTIFICATION_GROUP_NEWS:
                    $img = '<a href="'. $typeResult->group->GROUP_URL.'">'.MainHelper::showImage($typeResult->group, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_news_60x60.png')).'</a>';
                    $notif_msg = $this->__('News from group [_1].', array('<a href="'.$typeResult->group->GROUP_URL.'">'.$typeResult->group->GroupName.'</a>'));

                    break;

				//working
                case NOTIFICATION_NEWS_REPLY:
                    $players = array();
                    if(!empty($typeResult->rel)) {
                        foreach ($typeResult->rel as $rel) {
                            $p = $rel->Players;
                            $players[] = '<a href="'.MainHelper::site_url('player/'.$p->URL).'">'.PlayerHelper::showName($p).'</a>';
                        }
                    }

                    $notif_msg = $this->__('Player(s) [_1] commented on a [_2]news item[_3], you subscribe to.', array(implode(", ", $players), '<a href="'. $typeResult->newsitem->URL.'">', '</a>'));
                    $img = '<a href="'. $typeResult->newsitem->URL.'">'.MainHelper::showImage($typeResult->newsitem, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_news_60x60.png')).'</a>';

                    break;

                //working
                case NOTIFICATION_GROUP_INVITE:
                    $notif_msg = $this->__('Player [_1] has invited you to join the group [_2].', array(
                                                                                                        '<a href="'.MainHelper::site_url('player/'.$typeResult->player->URL).'">'.PlayerHelper::showName($typeResult->player).'</a>',
                                                                                                        '<a href="'.$typeResult->group->GROUP_URL.'">'.$typeResult->group->GroupName.'</a>'
                                                                                                    ));
                    $img = '<a href="'. $typeResult->group->GROUP_URL.'">'. MainHelper::showImage($typeResult->group, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_group_60x60.png')).'</a>';
                    if($typeResult->group->isPending()) {
                        $additional_text = '<div class="tac fl clearfix mt5 mb5 pr5">
								<a href="javascript:void(0)" class="buttonRRound groupSearchRound add_membertogroup_from_notif fl" rel="'.$typeResult->group->ID_GROUP.'">
                                    <span class="lrc"></span>
									<span class="mrc">
										<span class="fl fs11"><strong>'.$this->__('Accept').'</strong></span>
									</span>
									<span class="rrc"></span>
                                </a>
                                <a href="javascript:void(0)" class="buttonRRound groupSearchRound fl reject_membertogroup_from_notif fl ml5" rel="'.$typeResult->group->ID_GROUP.'">
                                    <span class="lrc"></span>
									<span class="mrc">
										<span class="fl fs11"><strong>'.$this->__('Reject').'</strong></span>
									</span>
									<span class="rrc"></span>
                                </a>
                            </div>';
                    }
                    break;
                //working
                case NOTIFICATION_GROUP_APPLICATION:
                    $notif_msg = $this->__('Player [_1] has applied to join the group [_2].', array(
                                                                                                        '<a href="'.MainHelper::site_url('player/'.$typeResult->player->URL).'">'.PlayerHelper::showName($typeResult->player).'</a>',
                                                                                                        '<a href="'.$typeResult->group->GROUP_URL.'">'.$typeResult->group->GroupName.'</a>'
                                                                                                    ));
                    $img = '<a href="'. $typeResult->group->GROUP_URL.'">'. MainHelper::showImage($typeResult->group, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_group_60x60.png')).'</a>';
                    if($typeResult->group->hasApplied($typeResult->player)) {
                        $additional_text = '<div class="tac fl clearfix mt5 mb5 pr5">
								<a href="javascript:void(0)" class="buttonRRound groupSearchRound add_membertogroup_from_notif aprove_application fl" rel="'.$typeResult->group->ID_GROUP.'_'.$typeResult->player->URL.'">
                                    <span class="lrc"></span>
									<span class="mrc">
										<span class="fl fs11"><strong>'.$this->__('Accept').'</strong></span>
									</span>
									<span class="rrc"></span>
                                </a>
                                <a href="javascript:void(0)" class="buttonRRound groupSearchRound fl reject_membertogroup_from_notif aprove_application ml5" rel="'.$typeResult->group->ID_GROUP.'_'.$typeResult->player->URL.'">
                                    <span class="lrc"></span>
									<span class="mrc">
										<span class="fl fs11"><strong>'.$this->__('Reject').'</strong></span>
									</span>
									<span class="rrc"></span>
                                </a>
                            </div>';
                    }
                    break;
                case NOTIFICATION_ACHIEVEMENT:
                    $noimage = AchievementHelper::GetBranchNoImageName($typeResult->branch->BranchName);
                    
                    $notif_msg = $this->__('You have unlocked the [_1] achievement!', array('<strong>'.$typeResult->achievement->LevelName.'</strong>'));
                    $img = '<a href="#">'.MainHelper::showImage($typeResult->achievement, THUMB_LIST_60x60, false, array('no_img' => 'noimage/'.$noimage.'no_game_60x60.jpg')).'</a>';
                    $additional_text = '<div class="tac fl clearfix mt5 mb5 pr5">
								<a href="'.MainHelper::site_url('players/my-achievements').'" class="buttonRRound groupSearchRound fl" rel="'.$typeResult->achievement->ID_LEVEL.'">
                                    <span class="lrc"></span>
									<span class="mrc">
										<span class="fl fs11"><strong>'.$this->__('Go to trophyroom').'</strong></span>
									</span>
									<span class="rrc"></span>
                                </a>
                            </div>';
                    break;
                case NOTIFICATION_ESPORT:
                    
                    $notif_msg = $this->__('You have been invited by [_1] to join [_2]', array('<strong>'.PlayerHelper::showName($typeResult->player).'</strong>','<strong>'.$typeResult->team->DisplayName.'</strong>'));
                    $img = '<a href="#">'.MainHelper::showImage($typeResult->player, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.jpg')).'</a>';
                    $additional_text = '<div class="tac fl clearfix mt5 mb5 pr5">
								<a href="'.MainHelper::site_url('players/teamrequestrespond/accept/'.$typeResult->team->ID_TEAM).'" class="buttonRRound groupSearchRound fl" rel="'.$typeResult->team->ID_TEAM.'">
                                    <span class="lrc"></span>
									<span class="mrc">
										<span class="fl fs11"><strong>'.$this->__('Accept').'</strong></span>
									</span>
									<span class="rrc"></span>
                                </a>
								<a href="'.MainHelper::site_url('players/teamrequestrespond/reject/'.$typeResult->team->ID_TEAM).'" class="buttonRRound groupSearchRound fl" rel="'.$typeResult->team->ID_TEAM.'">
                                    <span class="lrc"></span>
									<span class="mrc">
										<span class="fl fs11"><strong>'.$this->__('Reject').'</strong></span>
									</span>
									<span class="rrc"></span>
                                </a>
                            </div>';
                    break;
                case NOTIFICATION_RAID_INVITE:
                    $tmpType = $typeResult->type;
                    if($tmpType === "group") {
                        $notif_msg = $this->__('Group [_1] has invited you to join their raid.', array('<a href="'.$typeResult->group->GROUP_URL.'">'.$typeResult->group->GroupName.'</a>'));
                        $img = '<a href="#">'.MainHelper::showImage($typeResult->group, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_group_60x60.png')).'</a>';
                    } else if($tmpType === "player") {
                        $notif_msg = $this->__('Player [_1] has invited you to join their raid.', array('<a href="'.MainHelper::site_url('player/'.$typeResult->player->URL).'">'.PlayerHelper::showName($typeResult->player).'</a>'));
                        $img = '<a href="#">'.MainHelper::showImage($typeResult->player, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png')).'</a>';
                    };
                    $raidID = $typeResult->raid;
                    $additional_text = '<div class="tac fl clearfix mt5 mb5 pr5">
                                            <a href="' . MainHelper::site_url('raidscheduler/signup/' . $raidID) . '" class="buttonRRound groupSearchRound fl" rel="prefetch noreferrer">
                                                <span class="lrc"></span>
                                                <span class="mrc"><span class="fl fs11"><strong>' . $this->__('Sign up') . '</strong></span></span>
                                                <span class="rrc"></span>
                                            </a>
                                            <a href="javascript:void(0);" class="buttonRRound groupSearchRound fl ml5 decline_raidsignup" data-idnum="' . $raidID . '">
                                                <span class="lrc"></span>
                                                <span class="mrc"><span class="fl fs11"><strong>' . $this->__('Decline') . '</strong></span></span>
                                                <span class="rrc"></span>
                                            </a>
                                        </div>';
                    break;
            }
        ?>
        <div class="post_wall mt5 clearfix">
            <div class="post_head clearfix">
                <div class="fl w60 pr10"><?php echo $img?></div>
                <div class="fl w530 pt5 dot_top pr mh60">
                    <div class="fs15"><?php echo $this->__('Notification_'.$item->NotificationType);?></div>
                    <div class="fs11 fft"><?php echo $notif_msg;?></div>
                    <?php if($additional_text != ''):?>
                         <div class="mt5 fl"><?php echo $additional_text;?></div>
                    <?php endif; ?>
					 <div class="fs11 fft fclg notif_date pa"><?php echo date(DATE_FULL, $item->NotificationTime);?></div>
                </div>
            </div>
        </div>
    <?php endforeach;?>
	<?php if(isset($pager) and $pager != ''): ?>
		<?php echo $this->renderBlock('common/pagination', array('pager'=>$pager)) ?>
	<?php endif; ?>
<?php else: ?>
	<div class="noItemsText"><?php echo $this->__('There are no notifications at this moment'); ?></div>
<?php endif;?>