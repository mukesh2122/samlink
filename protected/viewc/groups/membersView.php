<?php 
	$groupUrl = $group->GROUP_URL;
    include('common/top.php');
    $isLogged = Auth::isUserLogged();
    $player = User::getUser();
//    $memberCount = $group->MemberCount;

    if ($globalAdmin === true) {
    	if($activeSub == 1) {
    		$type = "Members";
    	} elseif ($activeSub == 2) {
    		$type = "Applications";
    	} elseif ($activeSub == 3) {
    		$type = "Invitations";
    	}
    } else {
    	$type = "Members";
    }


?>

<div class="list_header <?php echo ($globalAdmin === true) ? 'mb15' : '' ?>">
	<h1><?php echo $this->__($type) ?></h1>
	<?php if($globalAdmin === true): ?>
		<a class="list_header_button" rel="iframe" href="<?php echo $groupUrl; ?>/admin/addmember"><?php echo $this->__('Invite Members +'); ?></a>
	<?php endif;

     ?>
</div>

<?php if($globalAdmin === true): ?>
	<ul class="horizontal_tabs small clearfix">
        <li <?php echo ($activeSub == 1) ? 'class="active"' : '';?>>
        	<a href="<?php echo $groupUrl.'/members';?>"><?php echo $this->__('Members');?> (<?php echo $group->MemberCount;?>)</a>
    	</li>
        <li <?php echo ($activeSub == 2) ? 'class="active"' : '';?>>
        	<a href="<?php echo $groupUrl.'/members-applications';?>"><?php echo $this->__('Applications');?> (<?php echo $group->ApplicantCount;?>)</a>
    	</li>
        <li <?php echo ($activeSub == 3) ? 'class="active"' : '';?>>
        	<a href="<?php echo $groupUrl.'/members-invitations';?>"><?php echo $this->__('Invitations');?> (<?php echo $group->InviteCount;?>)</a>
    	</li>
    </ul>
<?php endif;?>

<?php   
    if(isset($player) AND $player == TRUE){
         $roles = $groups->getPlayerGroupRel($group, $player);
     }else{
        $roles = "";
     }

    if(!empty($memberList)): ?>

	<div class="item_list">
      
		<?php 
        // linien i array har jeg udkommenteret - den skal sådan set sendes med over i næste view, men ved ikke og det er nok med tjekker $globaladmin ==) true

         foreach($memberList as $item){
            $item = (object)$item;
            $playerroles = $groups->getPlayerGroupRel($group, $item); 

				echo $this->renderBlock('common/member', array(
                    'globalAdmin' => $globalAdmin,
					'player' => $item,
                    'playerroles' => $playerroles,
					'viewer' => $player,
                    'viewerRolls' => $roles,
					'group' => $group,
					'groupRank' => PlayerHelper::showRank($item),
                    'isAdmin' => $globalAdmin, 
                    'ownerID' => $group->ID_GROUP, 
                    'ownerType' => GROUP,
					'adminActions' => array('removeGroupMember' => $isLogged === TRUE 
                        and $player 
                        and $player->ID_PLAYER != $item->ID_PLAYER 
                        and $globalAdmin === TRUE
                        and ($memberStatus == 'current' 
                            or $memberStatus == 'applying'),
                      'promoteGroupMember' => $memberStatus == 'current',
                      'acceptApplication' => $memberStatus == 'applying')
				));
		} ?>
	</div>

	<?php echo $this->renderBlock('common/pagination', array('pager'=>$pager)); ?>
<?php else: ?>
	<p class="noItemsText"><?php echo $this->__('There are no '.strtolower($type).' here. Yet!'); ?></p>
<?php endif; ?>
