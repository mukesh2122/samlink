<?php
include('common/top.php');
echo $this->renderBlock('games/common/showDescription', array('game' => $game));
echo $this->renderBlock('news/reviewItemFull', array('item' => $item));
echo $this->renderBlock('news/common/comment_block', array('item' => $item, 'replies' => $replies, 'lang' => $lang));
?>