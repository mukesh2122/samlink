<?php
$player = User::getUser();
echo $this->renderBlock('players/content/tabs_achievements', array(
	'player' => $player,
	'baseUrl' => 'players/my-achievements/',
    'activeTab' => ACHIEVEMENT_RANKINGS
));
echo $this->renderBlock('achievements/common/playerrank_list', array(
    'rankings' => $rankings,
));
echo $this->renderBlock('achievements/common/rankings_list', array(
    'rankings' => $rankings
));
if(isset($pager)) {
	echo $this->renderBlock('common/pagination', array('pager'=>$pager));
};
?>