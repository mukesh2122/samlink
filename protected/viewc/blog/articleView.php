<?php include('common/top.php');?>
<?php if(!empty($item)) {
    echo $this->renderBlock('blog/newsItemFull', array('item' => $item));

    echo $this->renderBlock('blog/common/comment_block', array('item' => $item, 'replies' => $replies, 'lang' => $lang));
    }
?>
