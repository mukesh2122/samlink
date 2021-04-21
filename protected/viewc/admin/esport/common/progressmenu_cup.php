<?php
$player = User::getUser();
$isUpdate = isset($_SESSION['createcup']['Update']) ? 'UPDATE' : 'SUBMIT'; 

	$esMenu = array
	(
		array('title'=>'BASICINFO','tag'=>'basic','link'=>'1'),
		array('title'=>'PARTICIPANTS','tag'=>'participants','link'=>'2'),
		array('title'=>'MAP POOL','tag'=>'maps','link'=>'3'),
		array('title'=>'ROUNDS','tag'=>'rounds','link'=>'4'),
		array('title'=>'REPLAYS','tag'=>'replays','link'=>'5'),
		array('title'=>'DESCRIPTION','tag'=>'description','link'=>'6'),
		array('title'=>'GRAPHICS','tag'=>'graphics','link'=>'8'),
                array('title'=>$isUpdate,'tag'=>'submit','link'=>'7')
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
				$class = ($tag==$progress) ? ' class="active "': '';
				echo '<li><a '.$class.'href="'.MainHelper::site_url('esport/admin/createcup/'.$link).'">'.$title.'</a></li>';
			}
		?>
	</ul>
</div>
<!-- E-Sports menu end -->
