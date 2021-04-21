<?php include('common/top.php'); ?>
<div class="fclg fs11"><?php echo $this->__('Total Matches');?>: <?php echo $resultCount;?></div>

<?php if(isset($groupList) and !empty($groupList)):?>
<?php $num = 0; ?>
    <div class="mt10 clearfix">
        <?php foreach ($groupList as $item):?>
            <?php echo $this->renderBlock('common/group', array('item' => $item));?>
        <?php $num ++;  endforeach; ?>
        <?php echo $this->renderBlock('common/pagination', array('pager'=>$pager)) ?>
    </div>
<?php endif; ?>