<?php 
    $hidden;
    $hidden[] = array('team_id', $team->ID_TEAM);
    
    foreach ($teammates as $player){
        $hidden[] = array('roster[]',$player->EMail);
    }
    ?>
<!-- Main container start -->
<div id="container" class="clearfix">
	<!-- Main content start -->
	<div id="esports_wrapper">
		<!-- E-Sports menu start -->
		<?php echo $this->renderBlock('esport/common/es_top_menu',array('esMenuSelected'=>$esMenuSelected)); ?>
		<!-- E-Sports menu end -->

		<!-- E-Sports content start -->
		<div class="esports_content">
			<?php echo $this->renderBlock('esport/common/leftcolumn', array('profile' => $profile, 'choosegameEnabled'=>true,'bettingladderEnabled'=>false)); ?>	
                    <!-- E-Sports right column start -->
                    <div class="esports_right_column">
                    <?php    
                                    $EditorData = array(
                            'ID'            => 0,
                            'Post'          => MainHelper::site_url('esport/myteam/saveinfo'),
                            'MainOBJ'       => array(),
                            'formid'        => 'editForm', // TODO: test if this actually is needed
                            'Title'         => 'User',
                            'ID_PRE'        => 'user',
                            'NativeFields' 	=> array(),
                            'PersonalInformation' => array(),
                            'Elements'      => array(
                                    array( // all the hidden values
						'type'      => 'hidden',
						'values'    => $hidden
						
					),
                                    array(
                                            'type'      => 'info',
                                            'value'     => $this->__('Update teaminfo'),
                                            'info'      => $this->__('Update your fanclub info and invite people to join your team')
                                    ),
                                    array(
                                            'type'     => 'text',
                                            'title'     => $this->__('Team name'),
                                            'id'        => 'team_name',
                                            'value'     => $team->DisplayName
                                    ),
                                    array(
                                            'type'     => 'text',
                                            'title'     => $this->__('Team initials'),
                                            'id'        => 'team_initials',
                                            'value'     => $team->TeamInitials
                                    ),
                                    array(
						'type'      => 'select',
						'title'     => $this->__('Based country'),
						'id'        => 'team_country',
						'fieldName'	=> 'Country',
						'options'   => ContentHelper::ObjArrayToOptions(MainHelper::getCountryList(), 'A2', 'Country', 'A2', array($team->Country)),
						'CbVisibile'=> '1'
					),
                                    array(
                                            'type'      => 'fileupload',
                                            'title'     => $this->__('Team logo').(' (200x200)'),
                                            'id'        => 'team_img',
                                            'model'     => $team
                                    ),
                                    array(
                                            'type'      => 'roster',
                                            'title'     => $this->__('Roster'),
                                            'roster'    => $teammates 
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
                    <!-- E-Sports right column end -->
		</div>
		<!-- E-Sports content end -->
	</div>
	<!-- Main content end -->
</div>
<!-- Main container end -->