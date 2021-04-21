<?php foreach($wallitems as $item): ?>
<?php 
    $player = new Players();
    $player->Avatar = $item->Avatar;
    $isLiked = $item->isLiked();
?>
<ul>
    <li class="self">
        <div class="profile_picture">
            <?php echo MainHelper::showImage($player, THUMB_LIST_60x60, false, array('width', 'no_img' => 'noimage/no_player_60x60.png'));?>
        </div>
        <div class="achieved">
            <p><?php echo $item->Message; ?></p>
            <img src="#" />
        </div>
        <hr />
        <div class="feed_footer">
            <a class="button button_small grey btn_red_gradient_bg showhide" href="javascript:void(0);"><?php echo $this->__('Toggle'); ?></a>
            <a class="button button_small grey btn_red_gradient_bg newcomment" href="javascript:void(0);"><?php echo $this->__('Comment'); ?></a>
            <a class="button button_small grey btn_red_gradient_bg <?php echo $isLiked ? 'dn' : ''; ?> like" rel="<?php echo $item->ID_WALLITEM.'_0'; ?>" href="javascript:void(0);"><?php echo $this->__('Like'); ?></a>
            <a class="button button_small grey btn_red_gradient_bg <?php echo $isLiked ? '' : 'dn'; ?> unlike" rel="<?php echo $item->ID_WALLITEM.'_0'; ?>" href="javascript:void(0);"><?php echo $this->__('Unlike'); ?></a>
            <div class="info"><p><?php echo $this->__('Likes').': '; ?><span><?php echo $item->LikeCount; ?></span></p></div>
            <div class="date"><p>19/11/2013 10:35 AM</p></div>
        </div>
    </li>
    <?php if(Auth::isUserLogged()): ?>
    <?php $user = User::getUser(); ?>
    <li class="new_comment" style="display:none">
        <div class="profile_picture">
            <?php echo MainHelper::showImage($user, THUMB_LIST_60x60, false, array('width', 'no_img' => 'noimage/no_player_60x60.png'));?>
        </div>
        <div class="profile_name">
            <p><?php echo $user->DisplayName; ?></p>
        </div>
        <div class="comment">
            <textarea class="commentbox" rel="<?php echo $item->ID_WALLITEM; ?>" cols="70" rows="5" name="commentbox"></textarea>
        </div>
        <hr />
        <div class="feed_footer">
            <a class="button button_small grey btn_red_gradient_bg post" rel="<?php echo $item->ID_WALLITEM; ?>" href="javascript:void(0);"><?php echo $this->__('Post'); ?></a>
            <div class="date"></div>
        </div>
        <div><!-- Der skal komme en kommentar box og send knap, hvis man klikker på "Comment" knappen. Kan ses i PSD filen. Hvis du bare får den frem når man klikker og sende når man trykker send, skal jeg nok få den til at se rigtig ud, bagefter :-) --></div>
    </li>
    <?php endif; ?>
    <?php if($item->Replies > 0):?>
    <?php $replies = $item->getReplies(); ?>
    <?php foreach($replies as $reply): ?>
    <?php 
        $player = new Players();
        $player->Avatar = $reply->Avatar;
        $replyLiked = $reply->isLiked();
    ?>
    <li>
        <div class="profile_picture">
            <?php echo MainHelper::showImage($player, THUMB_LIST_60x60, false, array('width', 'no_img' => 'noimage/no_player_60x60.png'));?>
        </div>
        <div class="profile_name">
            <p><?php echo $reply->PosterDisplayName; ?></p>
        </div>
        <div class="comment">
            <p><?php echo $reply->Message; ?></p>
        </div>
        <hr />
        <div class="feed_footer">
            <a class="button button_small grey btn_red_gradient_bg like <?php echo $replyLiked ? 'dn' : ''; ?> reply" rel="<?php echo $reply->ID_WALLITEM.'_'.$reply->ReplyNumber; ?>" href="javascript:void(0)"><?php echo $this->__('Like'); ?></a>
            <a class="button button_small grey btn_red_gradient_bg <?php echo $replyLiked ? '' : 'dn'; ?> unlike reply" rel="<?php echo $reply->ID_WALLITEM.'_'.$reply->ReplyNumber; ?>" href="javascript:void(0)"><?php echo $this->__('Unlike'); ?></a>
            <div class="info"><p><?php echo $this->__('Likes').': '; ?><span><?php echo $reply->LikeCount; ?></span></p></div>
            <div class="date"><p><?php echo date("d-m-Y H:i", $reply->PostingTime); ?></p></div>
        </div>
        <!--<div> Der skal komme en kommentar box og send knap, hvis man klikker på "Comment" knappen. Kan ses i PSD filen. Hvis du bare får den frem når man klikker og sende når man trykker send, skal jeg nok få den til at se rigtig ud, bagefter :-) </div>-->
    </li>
    <?php endforeach;?>
    <?php endif;?>
</ul>
<?php endforeach; ?>

