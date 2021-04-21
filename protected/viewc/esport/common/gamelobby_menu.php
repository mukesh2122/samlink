<?php
$player = User::getUser();

	$esMenu = array
	(
		array('title'=>'QUICKMATCH','tag'=>'quickmatch','link'=>'quickmatch'),
		array('title'=>'TOURNAMENTS','tag'=>'tournaments','link'=>'tournaments'),
	);
?>

<!-- E-Sports menu start -->
<div id="esports_menu" class="progressbar">
	<div class="esports_menu_bottom"></div>
	<ul class="esports_ul progressbar_text">
		<?php 
			foreach ($esMenu as $esm)
			{   
				$tag = $esm['tag'];
				$title = $esm['title'];
				$link = $esm['link'];
				$class = ($tag==$progress) ? ' active': '';
				echo '<li><a class="'.$tag.$class.'" href="#">'.$title.'</a></li>';
			}
		?>
	</ul>
</div>
<!-- E-Sports menu end -->
