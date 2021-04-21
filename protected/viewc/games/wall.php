<?php
include('common/top.php');
$p = User::getUser();
echo $this->renderBlock('common/universal_wall_input', array(
	'post_text' => $this->__('Write on game wall...'),
	'wallType' => 'game',
	'posts' => $posts,
	'obj' => $game,
	'postCount' => $postCount,
	'admin' => $p ? $p->canAccess('Edit game information') : false
));
?>