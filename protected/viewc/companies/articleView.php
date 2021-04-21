<?php
include('common/top.php');
echo $this->renderBlock('companies/common/showDescription', array('company' => $company));
echo $this->renderBlock('news/newsItemFull', array('item' => $item));
echo $this->renderBlock('news/common/comment_block', array('item' => $item, 'replies' => $replies, 'lang' => $lang));
?>