<?php if($offset == 0):?>
    <!-- header -->
    <?php
        $friendsCount = isset($friend) ? $friend->FriendCount : $player->FriendCount;
    ?>
    <div class="mt10 mb20 clearfix">
        <span class="fs22 fft fclg2 fl mr10">Friends</span>
        <div class="blue_block fl mr10"><div><div><span class="friend_count_header"><?php echo $friendsCount;?></span></div></div></div>
        <?php if($player->FriendRequestsReceived > 0 and !isset($friend)):?>
            <span class="fl fs22 fft fcbl received_requests"><?php echo $player->FriendRequestsReceived;?> <?php echo $this->__('New');?>!</span>
        <?php endif; ?>
    </div>
    <!-- end header -->
<?php endif;?>
<?php
$num = $offset;
$isLogged = Auth::isUserLogged();
foreach ($friends as $item):
    include('friend.php');
    $num++;
endforeach;
?>