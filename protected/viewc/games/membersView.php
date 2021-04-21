<?php 
    include('common/top.php');
    $player = User::getUser();
    if($player) { $roles = $games->getPlayerGameRel($game, $player); }
    else { $roles = ""; };
?>

<div class="list_header">
	<h1><?php echo $this->__('Members'); ?></h1>
</div>
<ul class="horizontal_tabs clearfix mt10">
    <?php if($isRegUsers==1 && ($CategoryType == GAME_PLAYERS || $CategoryType == GAME_MEMBERS)): ?>
        <li class="<?php echo $CategoryType == GAME_PLAYERS ? 'active':''; ?>">
            <a class="icon_link" href="<?php echo $gameUrl.'/players'; ?>"><i class="players_tab_icon"></i><?php echo $this->__('Players'); ?></a>
        </li>
        <li class="<?php echo $CategoryType == GAME_MEMBERS ? 'active':''; ?>">
            <a class="icon_link" href="<?php echo $gameUrl.'/members'; ?>"><i class="players_tab_icon"></i><?php echo $this->__('Members'); ?></a>
        </li>
    <?php endif; ?>
</ul>

<?php if(!empty($memberList)): ?>
	<div class="item_list">
        <?php foreach($memberList as $item) {
            $item = (object)$item;
            $playerroles = $games->getPlayerGameRel($game, $item);
            echo $this->renderBlock('common/member', array(
                'isAdmin' => $globalAdmin, // isAdmin: boolean
                'player' => $item,
                'playerroles' => $playerroles,
                'viewer' => $player,
                'viewerRoles' => $roles,
                'ownerID' => $game->ID_GAME,
                'ownerType' => GAME
            ));
        }; ?>
	</div>
	<?php echo $this->renderBlock('common/pagination', array('pager'=>$pager));
else: ?>
	<p class="noItemsText"><?php echo $this->__('There are no members here. Yet!'); ?></p>
<?php endif; ?>