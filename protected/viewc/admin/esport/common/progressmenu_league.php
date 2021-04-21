<?php
$player = User::getUser();

	$esMenu = array
	(
		array('title'=>'NEWS','tag'=>'news','link'=>'news', 'isAdmin' => false),
		array('title'=>'COVERAGE','tag'=>'coverage','link'=>'coverage', 'isAdmin' => false),
		array('title'=>'TOURNAMENTS','tag'=>'tournaments','link'=>'tournaments', 'isAdmin' => false),
		array('title'=>'LADDER','tag'=>'ladder','link'=>'ladder', 'isAdmin' => false),
		array('title'=>'BETTING','tag'=>'betting','link'=>'betting', 'isAdmin' => false),
		array('title'=>'FANCLUBS','tag'=>'fanclubs','link'=>'fanclubs', 'isAdmin' => false),
		array('title'=>'PROFILE','tag'=>'profile','link'=>'profile', 'isAdmin' => false),
		array('title'=>'ADMIN','tag'=>'admin','link'=>'admin', 'isAdmin' => true)
	);
?>

<!-- E-Sports menu start -->
<div id="esports_menu">
	<div class="esports_menu_bottom"></div>
	<ul class="esports_ul">
		<?php 
			foreach ($esMenu as $esm)
			{   
                                $admin = $esm['isAdmin'] === true && !$player->canAccess('Esport') ? 'style="display:none"' : '';
				$tag = $esm['tag'];
				$title = $esm['title'];
				$link = $esm['link'];
				$class = ($tag==$esMenuSelected) ? ' class="active "': '';
				echo '<li><a '.$admin.$class.'href="'.MainHelper::site_url('esport/'.$link).'">'.$title.'</a></li>';
			}
		?>
	</ul>
</div>
<!-- E-Sports menu end -->
