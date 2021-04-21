<?php 
    include('common/top.php');
?>
<?php echo $this->renderBlock('groups/common/showDescription', array('group' => $group));?>

<?php echo $this->renderBlock('news/newsItemFull', array('item' => $item));?>

<?php echo $this->renderBlock('news/common/comment_block', array('item' => $item, 'replies' => $replies, 'lang' => $lang));?>

