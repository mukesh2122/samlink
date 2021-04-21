<?php $contentchildFields = MainHelper::GetModuleFieldsByTag('contentchild'); ?>
<?php $isEnabledContentparent = MainHelper::IsModuleEnabledByTag('contentparent'); ?>
<?php $contentchildFunctions = MainHelper::GetModuleFunctionsByTag('contentchild'); ?>
<?php if (MainHelper::IsModuleNotAvailableByTag('contentparent')==1) $isEnabledContentparent = 0; ?>

<?php
    /**
    * @todo Move code to controller or create Form/editor class/new controller.
    * @todo Move html to templates.
    * @todo Move name and description to Elements section.
    */
    $EditorData = array(
        'ID'            => $game->ID_GAME,
        'Post'          => MainHelper::site_url('admin/games/edit/'.$game->ID_GAME),
        'MainOBJ'       => $game,
        'Title'         => 'Game',
        'ID_PRE'        => 'game',
        'NativeFields' 	=> $contentchildFields,
        'Elements'      => array(
            array(
                'type'      => 'title',
                'text'      => $this->__('Game Settings')
            ),
            array( // all the hidden values
                'type'      => 'hidden',
                'values'    => array (
                    array('game_id', $game->ID_GAME)
                )
            ),
            array(
                'id'        => 'game_name',
                'title'     => $this->__('Name'),
                'value'     => $game->GameName, // maybe translate for diff versions??
				'fieldName'	=> 'Name'

            ),
            array(
                'type'      => 'textfield',
                'text'      => $this->__('Description'),
                'id'        => 'game_description',
                'value'      => $game->GameDesc,
				'fieldName'	=> 'Description'
            ),
/*            array(
                'id'        => 'game_release',
                'value'     => $game->CreationDate,
                'title'     => $this->__('Creation Date'),
				'fieldName'	=> 'CreationDate'
            ),*/
			array(
                'type'      => 'date',
                'id'        => 'game_release',
                'prefix'    => 'game_release_',
                'title'     => $this->__('Creation Date'),
                'value'     => $game->CreationDate,

            ),
             array(
                'id'        => 'game_esrb',
                'value'     => $game->ESRB,
                'title'     => $this->__('ESRB rating'),
				'fieldName'	=> 'ESRBrating'
            ),
            array(
                'id'        => 'game_url',
                'value'     => $game->URL,
                'title'     => $this->__('URL'),
				'fieldName'	=> 'URL'
            ),
        )
    );

	//Distributor / developer
	if ($isEnabledContentparent)
	{
		$EditorData['Elements'] = array_merge($EditorData['Elements'],
			array
			(
				array(
					'id'        => 'developer_id',
					'type'      => 'select',
					'options'   => ContentHelper::ObjArrayToOptions($companies, 'ID_COMPANY', 'CompanyName', 'ID_COMPANY', $developers),
					'value'     => '0',
					'text'      => $this->__('Select game developer'),
					'title'     => $this->__('Game developer')
				),
				array(
					'id'        => 'distributor_id',
					'type'      => 'select',
					'options'   => ContentHelper::ObjArrayToOptions($companies, 'ID_COMPANY', 'CompanyName',  'ID_COMPANY', $distributors),
					'value'     => '0',
					'text'      => $this->__('Select game publisher'),
					'title'     => $this->__('Game publisher')
				)
			)
		);
	}

	$EditorData['Elements'] = array_merge($EditorData['Elements'],
		array
		(
            array(
                'id'        => 'game_type',
                'type'      => 'select',
                'options'   => ContentHelper::ObjArrayToOptions($gameTypes, 'ID_GAMETYPE', 'NameTranslated', 'ID_GAMETYPE', array($game->ID_GAMETYPE)),
                'value'     => '0',
                'text'      => $this->__('Select game type'),
                'title'     => $this->__('Game type'),
				'fieldName'	=> 'Type'
            ),
            array(
                'type'      => 'checkboxes',
                'id'        => 'platforms',
                'title'     => $this->__('Game platform'),
                'options'   => ContentHelper::ObjArrayToOptions($gameAllPlatforms, 'ID_PLATFORM', 'PlatformName', 'ID_PLATFORM', $gamePlatforms),
				'fieldName'	=> 'Platform'
            )
        )
    );

	//Add extrafields to EditorData
	if (isset($extrafields))
		$EditorData = ContentHelper::AddEditorDataExtrafields($extrafields,$EditorData,$this);

	//Add free play
	if ($contentchildFunctions['contentchildFreeToPlay'] == 1)
	{
		$EditorData['Elements'] = array_merge($EditorData['Elements'],
			array
			(
				array(
					'type'      => 'info',
					'value'     => $this->__('Free to play')
				),
				array(
					'type'      => 'checkbox',
					'id'        => 'isFreePlay',
					'title'     => $this->__('Enabled'),
					'label'     => $this->__('Yes'),
					'checked'   => $game->isFreePlay == 1
				),
				array(
					'id'        => 'FreePlayLink',
					'value'     => $game->FreePlayLink,
					'title'     => $this->__('Link')
				),
			)
		);
	}

	//Add free play
	if ($contentchildFunctions['contentchildBuyable'] == 1)
	{
		$EditorData['Elements'] = array_merge($EditorData['Elements'],
			array
			(
				array(
					'type'      => 'info',
					'value'     => $this->__('Buyable')
				),
				array(
					'type'      => 'checkbox',
					'id'        => 'isBuyable',
					'title'     => $this->__('Enabled'),
					'label'     => $this->__('Yes'),
					'checked'   => $game->isBuyable == 1
				),
				array(
					'id'        => 'ID_PRODUCT',
					'value'     => $game->ID_PRODUCT,
					'title'     => $this->__('Product ID')
				),
			)
		);
	}

	//Add picture nativefield
	$EditorData['Elements'] = array_merge($EditorData['Elements'],
		array
		(
			array(
                'type'      => 'picture'
            )
		)
	);


    ContentHelper::ParseEditorData($EditorData);
?>

