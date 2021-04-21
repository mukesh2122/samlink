<?php
$player = User::getUser();
$loggedIn = Auth::isUserLogged();

	$esMenu = array
	(
		array('title'=>'NEWS','tag'=>'news','link'=>'news', 'isLogged' => false, 'isAdmin' => false, 'isActive' => true),
		array('title'=>'COVERAGE','tag'=>'coverage','link'=>'coverage', 'isLogged' => false, 'isAdmin' => false, 'isActive' => true),
		array('title'=>'TOURNAMENTS','tag'=>'tournaments','link'=>'tournaments', 'isLogged' => true, 'isAdmin' => false, 'isActive' => false),
		array('title'=>'GAME LOBBY','tag'=>'gamelobby','link'=>'gamelobby', 'isLogged' => true, 'isAdmin' => false, 'isActive' => true),
		array('title'=>'LADDER','tag'=>'ladder','link'=>'ladder', 'isLogged' => true, 'isAdmin' => false, 'isActive' => true),
		array('title'=>'BETTING','tag'=>'betting','link'=>'betting', 'isLogged' => false, 'isAdmin' => false, 'isActive' => false),
		array('title'=>'FANCLUBS','tag'=>'fanclubs','link'=>'fanclubs', 'isLogged' => true, 'isAdmin' => false, 'isActive' => true),
		array('title'=>'PROFILE','tag'=>'profile','link'=>'profile', 'isLogged' => true, 'isAdmin' => false, 'isActive' => true),
		array('title'=>'MY TEAM','tag'=>'myteam','link'=>'myteam', 'isLogged' => true, 'isAdmin' => false,'isActive' => true),
		array('title'=>'ADMIN','tag'=>'admin','link'=>'admin', 'isLogged' => true, 'isAdmin' => true,'isActive' => true)
	);
?>

<!-- E-Sports menu start -->
<div id="esports_menu">
	<div class="esports_menu_bottom"></div>
	<ul class="esports_ul">
		<?php 
			foreach ($esMenu as $esm)
			{   
                            if($esm['isActive'] == true && (($esm['isAdmin'] == true && !$player->canAccess('Esport')) OR ($esm['isLogged'] == false) OR ($esm['isLogged'] == true && $loggedIn))){
                                $admin = $esm['isAdmin'] === true && !$player->canAccess('Esport') ? 'style="display:none"' : '';
                                $pull = $esm['tag'] == 'admin' ? 'style="float:right"' : '';
				$tag = $esm['tag'];
				$title = $esm['title'];
				$link = $esm['link'];
				$class = ($tag==$esMenuSelected) ? 'active ': '';
				echo '<li '.$pull.'><a '.$admin.' class="'.$class.'" href="'.MainHelper::site_url('esport/'.$link).'">'.$title.'</a></li>';
                            }
			}
		?>
	</ul>
</div>
<!-- E-Sports menu end -->
