<?php 
    include('common/top.php'); 
?>
<?php echo $this->renderBlock('games/common/showDescription', array('game' => $game));?>
<?php echo $this->renderBlock('blog/blogList', array('blogList' => $gameBlog, 'pager' => $pager, 'pagerObj' => $pagerObj, 'back' => $this->__('Back to All Games'), 'back_link' => MainHelper::site_url('blog/games'), 'headerName' => $this->__('Game Blogs')));?>
