<?php 
if(!empty($fanclub) && $fanclub->isProfileUrl == 1){
    $model = new Players();
    $model->Avatar = $fanclub->ImageURL;
}
else if(!empty($fanclub) && $fanclub->isProfileUrl == 0){
    $model = new EsFanclubs();
    $model->ImageURL = $fanclub->ImageURL;
}

$post_url = !empty($fanclub) ? MainHelper::site_url('esport/fanclubs/updatefanclub') : MainHelper::site_url('esport/fanclubs/savefanclub');
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
                            'Post'          => $post_url,
                            'MainOBJ'       => array(),
                            'formid'        => 'editForm', // TODO: test if this actually is needed
                            'Title'         => 'User',
                            'ID_PRE'        => 'user',
                            'NativeFields' 	=> array(),
                            'PersonalInformation' => array(),
                            'Elements'      => array(
                                    array( // all the hidden values
						'type'      => 'hidden',
						'values'    => array (
							array('id_team', $team->ID_TEAM)
						)
					),
                                    array(
                                            'type'      => 'info',
                                            'value'     => isset($fanclub) && !empty($fanclub) ? $this->__('Update fanclub') : $this->__('Create fanclub'),
                                            'info'      => isset($fanclub) && !empty($fanclub) ? $this->__('Update your fanclub info') : $this->__('Create your very own fanclub')
                                    ),
                                    array(
                                            'type'     => 'text',
                                            'title'     => $this->__('Fanclub name'),
                                            'id'        => 'fanclub_name',
                                            'value'     => $team->DisplayName
                                    ),
                                    array(
                                            'type'      =>  'textfield',
                                            'title'     => $this->__('Info'),
                                            'id'        => 'fanclub_desc',
                                            'value'     => isset($fanclub) && !empty($fanclub) ? $fanclub->WelcomeMessage : $this->__('Write a short welcome message...'),
                                            'text'      => ''
                                    ),
                                    array(
                                            'type'      => 'checkbox',
                                            'title'     => $this->__('Use profile photo'),
                                            'id'        => 'fanclub_useProfile',
                                            'checked'   => isset($fanclub) && !empty($fanclub) ? $fanclub->isProfileUrl : 0 
                                    ),
                                    array(
                                            'type'      => 'fileupload',
                                            'title'     => $this->__('Banner').(' (200x250)'),
                                            'id'        => 'fanclub_img',
                                            'model'     => isset($model) ? $model : ''
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