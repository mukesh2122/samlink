<?php if(!isset($model) or (!($model instanceof SnGames) and !($model instanceof SnCompanies) and !($model instanceof SnGroups))): ?>
	<?php if(isset($event)):?>
		<input id="event_id" value="<?php echo $event->ID_EVENT;?>" type="hidden" />
	<?php endif; ?>

	<?php echo $this->renderBlock('common/header_ads', array());?>

	<?php if(isset($infoBox)):?>
	    <?php echo $infoBox;?>
	<?php endif; ?>

<?php elseif($type == WALL_OWNER_GAME):?>
	<?php echo $this->renderBlock('games/common/top', array('game' => $model, 'CategoryType' => GAME_EVENTS)); ?>
<?php elseif($type == WALL_OWNER_COMPANY):?>
	<?php echo $this->renderBlock('companies/common/top', array('company' => $model, 'CategoryType' => COMPANY_EVENTS)); ?>
<?php elseif($type == WALL_OWNER_GROUP):?>
	<?php echo $this->renderBlock('groups/common/top', array('group' => $model, 'CategoryType' => GROUP_EVENTS)); ?>
<?php endif; ?>