<?php 
    include('common/top.php'); 
?>
<?php /* <div class="fcr1 mt20 fs19"><?php echo $this->__('Searched for');?> "<?php echo htmlspecialchars($searchText);?>"</div> */ ?>
<div class="fclg fs11">
    <?php echo $this->__('Total Matches');?>: <?php echo $resultCount;?>
    
</div>

<?php if(isset($newsList) and !empty($newsList)):?>
    <div class="mt10 clearfix">
        <?php foreach ($newsList as $item):?>
            <?php echo $this->renderBlock('news/newsItemLine', array('item' => $item));?>
        <?php endforeach;
        if(isset($pager)) {
            echo $this->renderBlock('common/pagination', array('pager'=>$pager));
        }; ?>
        
    </div>
<?php endif; ?>