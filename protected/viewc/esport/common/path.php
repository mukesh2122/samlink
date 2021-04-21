<?php if(isset($item->Path) and !empty($item->Path)):?>
	<div class="list_item_path esport_newspath">
		<?php
		$num = 0;
		$totalNum = count($item->Path);
		?>
		<?php foreach ($item->Path as $path):?>
			<a href="<?php echo $path->Url;?>"><?php echo $path->Title;?></a>
			<?php echo ($num < $totalNum - 1) ? '<span></span>' : ''; ;?>
		<?php $num++; endforeach;?>
	</div>
                <?php if($item->Published==0): ?>
                    <div class="list_item_path_unpublished fr"><?php echo $this->__('Unpublished'); ?></div>
                <?php endif; ?>
<?php endif; ?>





<?php /*
<?php if(isset($item->Path) and !empty($item->Path)):?>
    <div class="clearfix fl news_path_cont">
    <?php 
        $num = 0;
        $totalNum = count($item->Path);
    ?>
    <?php foreach ($item->Path as $path):?>
        <a class="news_path" href="<?php echo $path->Url;?>"><?php echo $path->Title;?></a>
        <?php echo ($num < $totalNum - 1) ? '<span>></span>' : ''; ;?>
    <?php $num++; endforeach;?>
    </div>
<?php endif; ?>
<?php if($item->RatingTop > 0 or $item->RatingPop > 0):?>
    <div class="fr clearfix">
        <?php if($item->RatingTop > 0):?>
            <span class="fr db star_top"><?php echo $item->RatingTop;?></span>
        <?php endif; ?>
        <?php if($item->RatingPop > 0):?>
            <span class="fr db star_pop"><?php echo $item->RatingPop;?></span>
        <?php endif; ?>
    </div>
<?php endif; ?>
*/ ?>