<?php include('common/top.php'); ?>
<div class="fclg fs11"><?php echo $this->__('Total Matches'); ?>: <?php echo $resultCount; ?></div>
<?php if(isset($gameList) and !empty($gameList)):
    $num = 0; ?>
    <div class="mt10 clearfix">
        <?php foreach($gameList as $item):
            echo $this->renderBlock('games/gameItem', array('item' => $item, 'num' => $num));
            $num ++;
        endforeach;
        echo $this->renderBlock('common/pagination', array('pager'=>$pager)); ?>
    </div>
<?php endif; ?>