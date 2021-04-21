<div class="visual_list gamelist ml10">
<?php foreach ($fans as $fan): ?>
    <div class="visual_item game pr"> 
        <a href="<?php echo MainHelper::site_url('esport/spotlight/'.$fan->ID_TEAM); ?>">
            <?php echo MainHelper::showImage($fan, THUMB_LIST_95x95, false, array('width', 'no_img' => 'noimage/no_player_95x95.png'));?>
            <p><?php echo $fan->DisplayName; ?></p>
        </a>
    </div>
<?php endforeach; ?>
</div>
