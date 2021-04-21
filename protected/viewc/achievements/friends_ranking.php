<?php
$player = User::getUser();
echo $this->renderBlock('players/content/tabs_achievements', array(
	'player' => $player,
	'baseUrl' => 'players/my-achievements/',
    'activeTab' => ACHIEVEMENT_FRIENDSRANKING
));
echo $this->renderBlock('achievements/common/playerrank_list', array(
    'rankings' => $rankings,
));
$player = User::getUser();
echo $this->renderBlock('achievements/common/rankings_list', array(
    'rankings' => $rankings,
    'friendsList' => true
));
if(isset($pager)){
	echo $this->renderBlock('common/pagination', array('pager'=>$pager));
};
?>