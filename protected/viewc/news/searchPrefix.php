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


