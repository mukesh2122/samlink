<?php include('common/top.php');?>

<?php echo $this->renderBlock('news/reviewItemFull', array('item' => $item));?>

<?php echo $this->renderBlock('news/common/comment_block', array('item' => $item, 'replies' => $replies, 'lang' => $lang));?>

