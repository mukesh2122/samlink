<?php echo $this->renderBlock('admin/esport/common/progressmenu_cup',array('progress' => 'maps')); ?>

<?php
        $esport = new Esport();
        
        if(isset($_SESSION['createcup']['mappoolnames']) && isset($_SESSION['createcup']['mappool'])){
            $mapNames = explode(',',$_SESSION['createcup']['mappoolnames']);
            $mapId = explode(',',$_SESSION['createcup']['mappool']);
            
            $MapsList = array();
            $progress = 0;        
            foreach($mapNames as $mapName):
                /*    array_push($MapsList,array(
                            'value'     => $mapId,
                            'selected'  => 0,
                            'text'      => $mapName
                    ));*/
                $Map = array('value'     => $mapId[$progress],
                            'selected'  => 0,
                            'text'      => $mapName);
            $MapsList[] = $Map;
            $progress++;
            endforeach;
        }
        
        if(isset($_SESSION['createcup']['game']))
            $maps = $esport->getMapsByGame($_SESSION['createcup']['game']);
        
        $SponsorList = $esport->getAllSponsors();
        $DefaultMapList = array
        (
                    array(
                            'value'     => '0',
                            'selected'  => 1,
                            'text'      => 'Currently no maps for this game')
        );
        $DefaultAddedList = array
        (
                    array(
                            'value'     => '0',
                            'selected'  => 0,
                            'text'      => 'No maps added')
        );
	$ESportGames = Doo::db()->query("CALL esp_GetAllESportGames();")->fetchall();
	$GameOptions = array();     
	foreach ($ESportGames as $game)
	{
                
		$GameOptions[] = array(
			'value'     => $game['ID_GAME'],
			'selected'  => isset($_SESSION['createcup']['game']) && $game['ID_GAME'] == $_SESSION['createcup']['game'] ? 1 : 0,
			'text'      => $game['GameName']
		);
	}
        ?>
        <input type="hidden" id="game" value="<?php echo isset($_SESSION['createcup']['game']) ? $_SESSION['createcup']['game'] : 0 ?>" />
        <?php
        $url = isset($_SESSION['createcup']['ID_GAME']) ? '/'.$_SESSION['createcup']['ID_GAME'] : '';
	$EditorData = array(
		'ID'            => 0,//$user->ID_PLAYER,
		'Post'          => MainHelper::site_url('esport/admin/createcup/4'.$url),
		'MainOBJ'       => array(),
		'formid'        => 'editForm', // TODO: test if this actually is needed
		'Title'         => 'User',
		'ID_PRE'        => 'mappool',
		'NativeFields' 	=> array(),
		'PersonalInformation' => array(),
                'Submitbutton'  => 'Next',
		'Elements'      => array(
                        array( // all the hidden values
                                'type'      => 'hidden',
                                'values'    => array (
                                    array('mappool', isset($_SESSION['createcup']['mappool']) ? $_SESSION['createcup']['mappool'] : ''),
                                    array('mappoolnames', isset($_SESSION['createcup']['mappoolnames']) ? $_SESSION['createcup']['mappoolnames'] : '')
                            )
                        ),
			array(
				'type'      => 'info',
				'value'     => $this->__('Mappool'),
                                'info'      => isset($_SESSION['createcup']['game']) ? $this->__('Choose your maps') : $this->__('No game selected yet! Select your game from first.'),
			),
			array(
				'type'      => 'fileupload',
                                'title'     => $this->__('Add map to list'),
                                'preview'   => false,
                                'id'        => 'mapUploader'
			),
                        array(
				'type'      => 'select',
				'title'     => $this->__('Select from database'),
				'text'      => $this->__('Add map'),
                                'value'     => '0',
				'id'        => 'dbMap',
				'options'   => isset($maps) && !empty($maps) ? ContentHelper::ObjArrayToOptions($maps, 'ID_MAP', 'MapName', 'ID_MAP', array(0)) : $DefaultMapList
			),
                        array(
				'type'      => 'list',
				'title'     => $this->__('Added maps'),
				'id'        => 'mapList',
                                'size'      => 10,
				'options'   => isset($MapsList) ? $MapsList : $DefaultAddedList
			),
                        array(
				'type'      => 'button',
                                'divstyle'  => 'float:right; margin: -25px 0 30px 0;',
				'value'     => 'Remove',
				'id'        => 'remove',
			),
		)
		
   );
?>

<div class="esportform">
	<?php
		echo ContentHelper::ParseEditorData($EditorData);
	?>
</div>
<script>
    
    $('#dbMap').change(function(){
       var name = $(this).find(':selected').html();
       var value = $(this).find(':selected').val();
       
       if(value !== '0'){
           if($('#mapList option:first').val() === '0'){
               $('#mapList option:first').remove();
           }
           $('#mapList').append("<option value='"+value+"'>"+name+"</option>");
           updateMappool();    
       }
    });
    $('#remove').click(function(){
       $('#mapList option:selected').remove();    
       updateMappool();
    });
    
    function updateMappool(){
           var listmap = '';
           var listmapnames = '';
           $('#mapList option').each(function(){
               listmap += $(this).val();
               listmapnames += $(this).html();
               if($(this).is(':not(#mapList option:last)')){
                    listmap += ',';
                    listmapnames += ',';
               }
           });
           $('#mappool').val(listmap);   
           $('#mappoolnames').val(listmapnames);   
    }
</script>