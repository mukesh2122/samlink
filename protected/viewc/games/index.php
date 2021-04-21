<?php
include('common/top.php');
echo $this->renderBlock('games/gameList', 
array('gameList' => $gameList, 
    'url' => MainHelper::site_url('games/search'), 
    'searchText' => isset($searchText) ? $searchText : null, 
    'searchTotal' => isset($searchTotal) ? $searchTotal : 0, 
    'pager' => $pager, 
    'tab' => isset($tab) ? $tab : 1,
    'order' => isset($order) ? $order : 'asc',
    'genre' => isset($selectedGenre) ? $selectedGenre : 'all-games',
    'pagerObj' => $pagerObj, 
    'headerName' => (!isset($selectedGenreID) or $selectedGenreID == 0) ? $this->__('All Games') : $selectedGenreTranslated)
);
?>