<div class="esports_right_column">
<?php

            $GameList = array();
            $progress = 0; 
            $model = new Esport();
            $games = $model->getAllGames();
            
            foreach($games as $game):
                /*    array_push($MapsList,array(
                            'value'     => $mapId,
                            'selected'  => 0,
                            'text'      => $mapName
                    ));*/
                $Game = array('value'     => $game->ID_GAME,
                            'selected'  => 0,
                            'text'      => $game->GameName);
            $GameList[] = $Game;
            $progress++;
            endforeach;

	$EditorData = array(
		'ID'            => 0,//$user->ID_PLAYER,
		'Post'          => MainHelper::site_url('esport/createteam'),
		'MainOBJ'       => array(),
		'formid'        => 'editForm', // TODO: test if this actually is needed
		'Title'         => 'User',
		'ID_PRE'        => 'user',
		'NativeFields' 	=> array(),
		'PersonalInformation' => array(),
                'Submitbutton' => 'Create Team',
		'Elements'      => array(
			array(
				'type'      => 'info',
				'value'     => $this->__("You don't currently have a team"),
				'info'      => $this->__('Select the games you want associated with the team. Select multiple with Ctrl.')
			),
                        array(
				'type'      => 'list',
				'title'     => $this->__('Gamelist'),
				'id'        => 'gameList[]',
                                'class'      => 'h300',
				'options'   => $GameList
			),
		)
		
   );
?>

<div class="esportform">
	<?php
		echo ContentHelper::ParseEditorData($EditorData);
	?>
</div>
</div>