<?php 
    include('common/top.php'); 
?>
<?php echo $this->renderBlock('games/common/showDescription', array('game' => $game));?>
<?php echo $this->renderBlock('news/newsList', array('newsList' => $gameNews, 'pager' => $pager, 'pagerObj' => $pagerObj, 'back' => $this->__('Back to All Games'), 'back_link' => MainHelper::site_url('news/games'), 'headerName' => $this->__('Game News')));?>