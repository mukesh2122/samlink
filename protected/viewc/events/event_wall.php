<?php include('common/event_tabs.php');
echo $this->renderBlock('common/universal_wall_input', array(
	'post_text' => $this->__('Write on Group Wall...'),
	'wallType' => 'event',
	'posts' => $posts,
	'obj' => $event,
	'postCount' => $postCount,
	'admin' => $isAdmin
)); ?>