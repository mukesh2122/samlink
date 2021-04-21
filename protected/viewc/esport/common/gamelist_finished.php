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
        <h4><?php echo $this->__('Wins'); ?></h4>
    </div>
</div>
<div class="browsed_list">
    <?php if(!empty($challenges)): ?>
    <?php foreach($challenges as $finished): ?>
    <?php $game = Games::getGameById($finished->FK_GAME); ?>
    <?php $playerresult = $finished->getPlayersResult(); ?>
    <?php $opponent = $finished->getOpponent(); ?>
        <div class="challenge">
            <div class="browse_content game">
                <a href="#go_to_game_page"><?php echo MainHelper::showImage($game, THUMB_LIST_18x18, false, array('no_img' => 'noimage/no_game_18x18.png')); ?></a>
                <h2><a href="#go_to_game_page"><?php echo $game->GameName; ?></a></h2>
            </div>
            <div class="browse_content versus">
                <?php if(!empty($opponent)): ?>
                <a href="<?php echo MainHelper::site_url('esport/spotlight/'.$opponent->ID_TEAM); ?>"><?php echo MainHelper::showImage($opponent, THUMB_LIST_30x30, false, array('no_img' => 'noimage/no_player_40x40.png')); ?></a>
                <h2><a href="<?php echo MainHelper::site_url('esport/spotlight/'.$opponent->ID_TEAM); ?>"><?php echo $opponent->DisplayName; ?></a></h2>
                <?php else: ?>
                <a href="#go_to_team_page"></a>
                <h2><a href="#go_to_team_page"></a></h2>
                <?php endif; ?>
            </div>
            <div class="browse_content type">
                <p><?php echo strtoupper(Esport::getPlayMode($finished->PlayMode)); ?></p><p><?php echo ucfirst($finished->RankedStatus); ?></p>
            </div>
            <div class="browse_content status">
                <p class="<?php echo $playerresult; ?>"><?php echo ucfirst($playerresult); ?></p>
            </div>
        </div>
    <?php endforeach; ?>
    <?php else: ?>
        <div class="error_message">
            <h1 class="m20"><?php echo $this->__('No currently finished challenges'); ?></h1>
        </div>
    <?php endif; ?>