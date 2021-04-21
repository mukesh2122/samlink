<div class="forumUserOnline">
    <p><?php echo $OnlineUsers, $this->__(" users are online"); ?></p>
    <p> <?php echo $onlineMembers,$this->__(" members"), ", ", $onlineGuests,$this->__(" guests"); ?> </p>	
    
    <?php
    $members = 0;
    foreach ($allOnlineUsers as $user) { 
    	if($model->isMember($user->ID_PLAYER) === TRUE){ 
			$members ++;
			if($members != $onlineMembers){ ?>
				<a href="<?php echo MainHelper::site_url('player/'.$user->URL); ?>" > <?php echo $user->DisplayName; ?> </a>,
			<?php
			}else{?>
                <a href="<?php echo MainHelper::site_url('player/'.$user->URL); ?>" > <?php echo $user->DisplayName; ?> </a>
            <?php
            }
		}
    }  ?>
</div>