<div class="headers">
    <div class="grey_gradient_bg overview_header game">
        <h4><?php echo $this->__('Game'); ?></h4>
    </div>
    <div class="grey_gradient_bg overview_header versus">
        <h4><?php echo $this->__('Versus'); ?></h4>
    </div>
    <div class="grey_gradient_bg overview_header type">
        <h4><?php echo $this->__('Type'); ?></h4>
    </div>
    <div class="grey_gradient_bg overview_header status">
        <h4><?php echo $this->__('Action'); ?></h4>
    </div>
</div>
<div class="browsed_list">
<?php if(!empty($challenges)): ?>
    <?php foreach($challenges as $pending): ?>
    <?php $game = Games::getGameById($pending->FK_GAME); ?>
    <?php $playerresult = $pending->getPlayersResult(); ?>
    <?php $opponent = $pending->getOpponent(); ?>
    <div class="challenge">
        <div class="browse_content game">
            <a target="_blank" href="<?php echo $game->URL; ?>"><?php echo MainHelper::showImage($game, THUMB_LIST_18x18, false, array('no_img' => 'noimage/no_game_18x18.png')); ?></a>
            <h2><a target="_blank" href="<?php echo $game->URL; ?>"><?php echo $game->GameName; ?></a></h2>
        </div>
        <div class="browse_content versus">
        <?php if(!empty($opponent)): ?>
            <a href="<?php echo MainHelper::site_url('esport/spotlight/'.$opponent->ID_TEAM); ?>"><?php echo MainHelper::showImage($opponent, THUMB_LIST_30x30, false, array('no_img' => 'noimage/no_player_40x40.png')); ?></a>
            <h2><a href="<?php echo MainHelper::site_url('esport/spotlight/'.$opponent->ID_TEAM); ?>"><?php echo $opponent->DisplayName; ?></a></h2>
        <?php else: ?>
            <img src="<?php echo MainHelper::site_url('global/img/random_30x30.png'); ?>" />
            <h2><?php echo $this->__('Random'); ?></h2>
        <?php endif; ?>
        </div>
        <div class="browse_content type">
            <p><?php echo strtoupper(Esport::getPlayMode($pending->PlayMode)); ?></p>
            <p><?php echo ucfirst($pending->RankedStatus); ?></p>
        </div>
    <div class="browse_content status">
        <?php if($pending->Host != $player->ID_TEAM): ?>
            <a class="button button_small grey pull_left btn_red_gradient_bg accept" rel="<?php echo $pending->ID_MATCH; ?>" href="<?php echo MainHelper::site_url('esport/acceptchallenge/'.$pending->ID_MATCH); ?>"><?php echo $this->__('Info'); ?></a>
            <a class="button button_small grey pull_left btn_grey_gradient_bg reject" rel="<?php echo $pending->ID_MATCH; ?>" href="javascript:void(0)"><?php echo $this->__('Decline'); ?></a>
        <?php else: ?>
            <p class="draw mt17"><?php echo $this->__('Waiting for opponent'); ?></p>
        <?php endif; ?>
    </div>
    </div>
<?php endforeach; ?>
            <?php else: ?>
    <div class="error_message">
        <h1 class="m20"><?php echo $this->__('No currently pending challenges'); ?></h1>
    </div>
<?php endif; ?>