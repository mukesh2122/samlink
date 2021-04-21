<form method="post" class="submitscore_form" action="<?php echo MainHelper::site_url('esport/challenge/submitscores'); ?>">
    <input type="hidden" id="id" name="id" />
</form>
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
<?php foreach ($challenges as $active): ?>
<?php $game = Games::getGameById($active->FK_GAME); ?>
<?php $playerresult = $active->getPlayersResult(); ?>
<?php $opponent = $active->getOpponent(); ?>
    <div class="challenge">
        <div class="browse_content game">
            <a href="#go_to_game_page"><?php echo MainHelper::showImage($game, THUMB_LIST_18x18, false, array('no_img' => 'noimage/no_game_18x18.png')); ?></a>
            <h2><a href="#go_to_game_page"><?php echo $game->GameName; ?></a></h2>
        </div>
        <div class="browse_content versus">
            <a href="<?php echo MainHelper::site_url('esport/spotlight/'.$opponent->ID_TEAM); ?>"><?php echo MainHelper::showImage($opponent, THUMB_LIST_30x30, false, array('no_img' => 'noimage/no_player_40x40.png')); ?></a>
            <h2><a href="<?php echo MainHelper::site_url('esport/spotlight/'.$opponent->ID_TEAM); ?>"><?php echo $opponent->DisplayName; ?></a></h2>
        </div>
        <div class="browse_content type">
               <p><?php echo strtoupper(Esport::getPlayMode($active->PlayMode)); ?></p><p><?php echo ucfirst($active->RankedStatus); ?></p>
        </div>
        <div class="browse_content status">
            <?php if($active->hasReported() == false): ?>
                <a class="button button_small grey pull_left btn_red_gradient_bg submitscores" rel="<?php echo $active->ID_MATCH ?>" href="javascript:void(0);"><?php echo $this->__('Verify results'); ?></a>
            <?php else: ?>
                <p class="draw mt17"><?php echo $this->__('Waiting for opponent'); ?></p>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>
<?php else: ?>
    <div class="error_message">
        <h1 class="m20"><?php echo $this->__('No currently active challenges'); ?></h1>
    </div>
<?php endif; ?>
<script>
    $('.submitscores').click(function(){
        $('.submitscore_form #id').val($(this).attr('rel'));
        $('.submitscore_form').submit();
    });
</script>