<?php
	$url = "";
	$nick = "";
	$img = "";
	if($poster instanceof Players) {
		$url = MainHelper::site_url('player/'.$poster->URL);
		$nick = PlayerHelper::showName($poster);
		$img = MainHelper::showImage($poster, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_player_60x60.png'));
	} elseif($poster instanceof SnGroups) {
		$url = $poster->GROUP_URL;
		$nick = $poster->GroupName;
		$img = MainHelper::showImage($poster, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_group_60x60.png'));
	} elseif($poster instanceof EvEvents) {
		$url = $poster->EVENT_URL;
		$nick = $poster->EventHeadline;
		$img = MainHelper::showImage($poster, THUMB_LIST_60x60, false, array('no_img' => 'noimage/no_events_60x60.png'));
	};
?>