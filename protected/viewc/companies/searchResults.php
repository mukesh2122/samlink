<?php include('common/top.php'); ?>
<div class="fclg fs11"><?php echo $this->__('Total Matches');?>: <?php echo $resultCount; ?></div>

<?php if(isset($companyList) and !empty($companyList)): ?>
<?php $num = 0; ?>
    <div class="mt10 clearfix">
        <?php foreach ($companyList as $item): ?>
            <?php echo $this->renderBlock('companies/companyItem', array('item' => $item, 'num' => $num)); ?>
        <?php $num ++;  endforeach; ?>
        <?php echo $this->renderBlock('common/pagination', array('pager'=>$pager)); ?>
    </div>
<?php endif; ?>