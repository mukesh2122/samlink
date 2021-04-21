<div class="visual_list gamelist ml10">
<?php foreach ($games as $game): ?>
    <div class="visual_item game pr"> 
        <a href="<?php echo $game->URL; ?>">
            <?php echo MainHelper::showImage($game, THUMB_LIST_95x95, false, array('width', 'no_img' => 'noimage/no_game_95x95.png'));?>
            <p><?php echo $game->GameName; ?></p>
        </a>
    </div>
<?php endforeach; ?>
</div>
