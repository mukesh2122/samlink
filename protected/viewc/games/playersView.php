<?php include('common/top.php'); ?>
<div class="list_header">
	<h1><?php echo $this->__('Players'); ?></h1>
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
		echo $this->renderBlock('common/player', array( 'player' => $item ));
    }; ?>
	</div>
	<?php echo $this->renderBlock('common/pagination', array('pager'=>$pager));
else: ?>
	<p class="noItemsText"><?php echo $this->__('There are no players here. Yet!'); ?></p>
<?php endif; ?>