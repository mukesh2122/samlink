<div class="mt10 clearfix dot_top">&nbsp;</div>
<div class="clearfix dot_bot">
    <span class="fs14 db pb5"><?php echo $this->__('Frontpage item look'); ?>:</span>
    <?php echo $this->renderBlock('news/newsItemLineLong', array('item' => $article, 'num' => 1)); ?>
</div>
<div class="mt10">
    <span class="fs14 db pb5"><?php echo $this->__('List item look'); ?>:</span>
    <?php echo $this->renderBlock('news/newsItemLine', array('item' => $article)); ?>
</div>
<div class="mt10 dot_bot">
    <span class="fs14 db pb5"><?php echo $this->__('Inside look'); ?>:</span>
    <?php echo $this->renderBlock('news/newsItemFull', array('item' => $article)); ?>
</div>