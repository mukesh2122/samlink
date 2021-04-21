<?php
$item = (object)$item;
$nick = PlayerHelper::showName($item);
$img = MainHelper::showImage($item, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png'));
$age = PlayerHelper::calculateAge($item->DateOfBirth);
$country = PlayerHelper::getCountry($item->Country);
$userPlayer = User::getUser();
$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
?>
<div class="post_friend post_friend_<?php echo $item->ID_PLAYER;?> <?php echo !$num ? ' dot_top ':'';?>clearfix">
    <div class="pb15 dot_bot mt15 clearfix">
        <div class="grid_1 alpha"><a title="<?php echo $nick;?>" href="<?php echo MainHelper::site_url('player/'.$item->URL);?>"><?php echo $img?></a></div>
        <div class="grid_5 alpha omega">
            <span class="fs10 mt13 fclg db"><?php echo $this->__('Friend');?>:</span>
            <span class="db mt0"><a href="<?php echo MainHelper::site_url('player/'.$item->URL);?>"><?php echo $nick;?></a></span>
        </div>
        <?php if($isLogged === TRUE):?>
            <?php if(isset($friend)): //checks if it is friends list preview from other person?>
                <?php if($player->ID_PLAYER == $item->ID_PLAYER): //if same user do not show anything?>

                <?php else:?>
                    <?php if(isset($item->viewerRelation)): //checks for relations between player and viewer?>
                        <?php if(isset($item->viewerRelation) and $item->viewerRelation->Mutual == 1): //if mutual friendship then show info?>
                            <div class="grid_2 fr alpha omega clearfix">
                                <div class="fl clearfix pl20">
                                    <span class="db fwb fclg fft fs11 mb5"><?php echo $this->__('User Info');?>:</span>
                                    <span class="db fclg fft fs11"><?php echo $this->__('Age');?>: <?php echo $age;?></span>
                                    <span class="db fclg fft fs11"><?php echo $this->__('Country');?>: <?php echo $country;?></span>
                                    <!--<span class="db fclg fft fs11"><?php echo $this->__('Rating');?>: 4.8</span>-->
                                </div>
                            </div>
                        <?php endif; ?>
                   <?php else: ?><!-- else show add friend button-->
						<?php if(!$noProfileFunctionality): ?>
							<div class="grid_2 fr alpha omega clearfix">
								<div class="tac fr clearfix mt25 pr5">
									<a href="javascript:void(0)" class="info_green add_friend_friend add_friend_<?php echo $item->ID_PLAYER;?>" rel="<?php echo $item->ID_PLAYER;?>">
										<span><span><?php echo $this->__('Add Friend');?></span></span>
									</a>
								</div>
							</div>
						<?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
                <div class="clear">&nbsp;</div>
                <?php if($player->ID_PLAYER != $item->ID_PLAYER && !$noProfileFunctionality): //if players are different then you can write message and subscribe/unsubscribe?>
                    <div class="mt5 clearfix">
                        <a class="link_icon icon_writeonwall reply_message" rel="<?php echo $item->URL;?>" title="<?php echo $nick;?>" href="<?php echo MainHelper::site_url('players/ajaxgetsendmessage/'.$item->URL);?>"><?php echo $this->__('Send Message');?></a>
                        <?php if(isset($item->viewerRelation) and $item->viewerRelation->Subscribed == 1):?>
                            <a class="link_icon icon_unsubscribe unsubscribe_from_friend unsubscribe_<?php echo $item->ID_PLAYER;?>" rel="<?php echo $item->ID_PLAYER;?>" href="javascript:void(0)"><?php echo $this->__('Unsubscribe');?></a>
                            <a class="link_icon icon_subscribe subscribe_to_friend dn subscribe_<?php echo $item->ID_PLAYER;?>" rel="<?php echo $item->ID_PLAYER;?>" href="javascript:void(0)"><?php echo $this->__('Subscribe');?></a>
                        <?php else:?>
                            <a class="link_icon icon_subscribe subscribe_to_friend subscribe_<?php echo $item->ID_PLAYER;?>" rel="<?php echo $item->ID_PLAYER;?>" href="javascript:void(0)"><?php echo $this->__('Subscribe');?></a>
                            <a class="link_icon icon_unsubscribe unsubscribe_from_friend dn unsubscribe_<?php echo $item->ID_PLAYER;?>" rel="<?php echo $item->ID_PLAYER;?>" href="javascript:void(0)"><?php echo $this->__('Unsubscribe');?></a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <?php if(isset($item->Mutual) and $item->Mutual == 0): //if not mutual then show accept button?>
                    <div class="grid_2 fr alpha omega clearfix">
                        <div class="tac fr clearfix mt25 pr5">
                            <a href="javascript:void(0)" class="info_green add_friend" rel="<?php echo $item->ID_PLAYER;?>">
                                <span><span><?php echo $this->__('Accept');?></span></span>
                            </a>
                            <div class="clear">&nbsp;</div>
                            <span class="db mt10 tac">
                                <a class="fs10 green_link reject_friend" rel="<?php echo $item->ID_PLAYER;?>" href="javascript:void(0)"><?php echo $this->__('Reject');?></a>
                            </span>
                        </div>
                    </div>
                <?php else: ?><!--show friends info-->
                    <div class="grid_2 fr alpha omega clearfix">
                        <div class="fl clearfix pl20">
                            <span class="db fwb fclg fft fs11 mb5"><?php echo $this->__('User Info');?>:</span>
                            <span class="db fclg fft fs11"><?php echo $this->__('Age');?>: <?php echo $age;?></span>
                            <span class="db fclg fft fs11"><?php echo $this->__('Country');?>: <?php echo $country;?></span>
                            <!--<span class="db fclg fft fs11"><?php echo $this->__('Rating');?>: 4.8</span>-->
                        </div>
                    </div>
                <?php endif; ?>
                <div class="clear">&nbsp;</div>
                <div class="mt5 clearfix">
                    <a class="link_icon icon_writeonwall reply_message" rel="<?php echo $item->URL;?>" title="<?php echo $nick;?>" href="<?php echo MainHelper::site_url('players/ajaxgetsendmessage/'.$item->URL);?>"><?php echo $this->__('Send Message');?></a>
                    <?php if(isset($item->Mutual) and $item->Mutual == 1):?>
                        <a class="link_icon icon_deletefriend delete_friend" rel="<?php echo $item->ID_PLAYER;?>" href="javascript:void(0)"><?php echo $this->__('Delete Friend');?></a>
                    <?php endif; ?>
                    <?php if(isset($item->Subscribed) and $item->Subscribed == 1):?>
                        <a class="link_icon icon_unsubscribe unsubscribe_from_friend unsubscribe_<?php echo $item->ID_PLAYER;?>" rel="<?php echo $item->ID_PLAYER;?>" href="javascript:void(0)"><?php echo $this->__('Unsubscribe');?></a>
                        <a class="link_icon icon_subscribe subscribe_to_friend dn subscribe_<?php echo $item->ID_PLAYER;?>" rel="<?php echo $item->ID_PLAYER;?>" href="javascript:void(0)"><?php echo $this->__('Subscribe');?></a>
                    <?php else:?>
                        <a class="link_icon icon_subscribe subscribe_to_friend subscribe_<?php echo $item->ID_PLAYER;?>" rel="<?php echo $item->ID_PLAYER;?>" href="javascript:void(0)"><?php echo $this->__('Subscribe');?></a>
                        <a class="link_icon icon_unsubscribe unsubscribe_from_friend dn unsubscribe_<?php echo $item->ID_PLAYER;?>" rel="<?php echo $item->ID_PLAYER;?>" href="javascript:void(0)"><?php echo $this->__('Unsubscribe');?></a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>