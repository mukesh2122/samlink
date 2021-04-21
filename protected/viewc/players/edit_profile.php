<?php
$reguserFields = MainHelper::GetModuleFieldsByTag('reguser'); 
$extrafields = MainHelper::GetExtraFieldsByOwnertype('player',$user->ID_PLAYER);
$PersonalInformation = MainHelper::GetPersonalInformation($user->ID_PLAYER);
$suspendLevel = ($user) ? $user->getSuspendLevel() : 0;
$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
MainHelper::MakeValidation($reguserFields,'#editForm');
$isEnabledTranslate = MainHelper::IsModuleEnabledByTag('translations');
switch ($section)
	{
		default:
		case 'personalinfo':
			$EditorData = array(
				'ID'            => $user->ID_PLAYER,
				'Post'          => MainHelper::site_url('players/editprofileaction'.(isset($section) ? '/'.$section : '')),
				'MainOBJ'       => $user,
				'formid'        => 'editForm', // TODO: test if this actually is needed
				'Title'         => 'User',
				'ID_PRE'        => 'user',
				'NativeFields' 	=> $reguserFields,
				'PersonalInformation' => $PersonalInformation,
				'Elements'      => array(
					array( // all the hidden values
						'type'      => 'hidden',
						'values'    => array (
							array('user', $user->ID_PLAYER)
						)
					),
					array(
						'type'      => 'titleex',
						'text'      => $this->__('Account Settings'),
						'info'      => $this->__('Registered').': '.date(DATE_SHORT, $user->RegistrationTime).' -'
					),
					array(
						'type'      => 'info',
						'value'     => $this->__('Personal information'),
						'info'      => $this->__('Change your personal information.')
					),
					array(
						'title'     => $this->__('First name'),
						'id'        => 'firstName',
						'value'     => $user->FirstName,
						'fieldName'	=> 'FirstName',
						'CbVisibile'=> '1'
					),
					array(
						'title'     => $this->__('Last name'),
						'id'        => 'lastName',
						'value'     => $user->LastName,
						'fieldName'	=> 'LastName',
						'CbVisibile'=> '1'
					),
					array(
						'title'     => $this->__('Nickname'),
						'id'        => 'nickname',
						'value'     => $user->NickName,
						'fieldName'	=> 'NickName',
						'CbVisibile'=> '1'
					),
					array(
						'title'     => $this->__('Display name'),
						'tooltip'   => $this->__('Your display name is the name you choose to display on your profile. It can be your first name, full name, nickname or any combination. It can also be something completely different.').' '.$this->__('If you do not choose a display name, your nickname will be displayed by default.'),
						'id'        => 'displayName',
						'value'     => $user->DisplayName,
						'fieldName'	=> 'DisplayName'
					),
					array(
						'type'      => 'date',
						'id'        => 'dob',
						'prefix'    => '',
						'title'     => $this->__('Date of birth'),
						'value'     => $user->DateOfBirth,
						'fieldName'	=> 'DateOfBirth',
						'CbVisibile'=> '1'
					),
					array(
						'title'     => $this->__('City'),
						'id'        => 'city',
						'value'     => $user->City,
						'fieldName'	=> 'City',
						'CbVisibile'=> '1'
					),
					array(
						'type'      => 'select',
						'title'     => $this->__('Country'),
						'id'        => 'country',
						'fieldName'	=> 'Country',
						'options'   => ContentHelper::ObjArrayToOptions(MainHelper::getCountryList(), 'A2', 'Country', 'A2', array($user->Country)),
						'CbVisibile'=> '1'
					),
		/*
					array(
						'title'     => $this->__('Address'),
						'id'        => 'address',
						'value'     => $user->Address
					),
					array(
						'title'     => $this->__('Zip'),
						'id'        => 'zip',
						'value'     => $user->Zip
					),
					array(
						'title'     => $this->__('Phone'),
						'id'        => 'phone',
						'value'     => $user->Phone
					),
		*/  
				)
		   );

			//Add extrafields to EditorData
			if (isset($extrafields))
				$EditorData = ContentHelper::AddEditorDataExtrafields($extrafields,$EditorData,$this);

			$categories = MainHelper::GetPlayerCategories('player');
			if ($categories)
				$EditorData = ContentHelper::AddEditorDataCategories($categories,$EditorData,$this,$user->ID_PLAYER,false);

			ContentHelper::ParseEditorData($EditorData);
			break;
		case 'timezonelanguage':
			$TimeZoneOptions = array();
			$zones = MainHelper::getTimeZoneList();
			foreach ($zones as $zone) {
				$TimeZoneOptions[] = array(
					'value'     => $zone->ID_TIMEZONE,
					'selected'  => ($user->ID_TIMEZONE == $zone->ID_TIMEZONE),
					'text'      => $zone->TimeZoneText . ' ' . $zone->HelpText
				);
			}
			
			$LanguageOptions = array();
			$addLangs = explode(',', $user->OtherLanguages);
			foreach (Lang::getLanguages() as $lang) {
				$LanguageOptions[] = array(
					'class'     => 'updatePlayerLang',
					'id'        => 'alang_'.$lang->ID_LANGUAGE,
					'name'      => 'addLangs[]',
					'value'     => $lang->ID_LANGUAGE,
					'selected'   => in_array($lang->ID_LANGUAGE, $addLangs),
					'text'      => $lang->NativeName
				);
			}    

		   $EditorData = array(
				'ID'            => $user->ID_PLAYER,
				'Post'          => MainHelper::site_url('players/editprofileaction'.(isset($section) ? '/'.$section : '')),
				'MainOBJ'       => $user,
				'formid'        => 'editForm', // TODO: test if this actually is needed
				'Title'         => 'User',
				'ID_PRE'        => 'user',
				'NativeFields' 	=> $reguserFields,
				'PersonalInformation' => $PersonalInformation,
				'Elements'      => array(
					array( // all the hidden values
						'type'      => 'hidden',
						'values'    => array (
							array('user', $user->ID_PLAYER)
						)
					),
					array(
						'type'      => 'titleex',
						'text'      => $this->__('Account Settings'),
						'info'      => $this->__('Registered').': '.date(DATE_SHORT, $user->RegistrationTime).' -'
					),
				)
			);
			$EditorData['Elements'] = array_merge($EditorData['Elements'], 
				array
				(
					array(
						'type'      => 'info',
						'value'     => $this->__('Timezone settings'),
						'info'      => $this->__('Change timezone and daylight saving time settings.')
					),
					array(
						'type'      => 'select',
						'id'        => 'ID_TIMEZONE',
						'title'     => $this->__('Timezone'),
						'options'   => $TimeZoneOptions
					),
					array(
						'type'      => 'checkbox',
						'title'     => $this->__('Daylight saving time'),
						'label'     => $this->__('Yes'),
						'id'        => 'dst',
						'checked'   => ($user->DSTOffset) == 3600
					)
				)
			);

			if ($isEnabledTranslate==1)
			{
				$EditorData['Elements'] = array_merge($EditorData['Elements'], 
					array
					(
						array(
							'type'      => 'info',
							'value'     => $this->__('Language settings'),
							'info'      => $this->__('Change language settings.')
						),
						array(
							'type'      => 'select',
							'id'        => 'mainLanguage', // fixed bug
							'title'     => $this->__('Site language'),
							'tooltip'   => $this->__('Your site language is the language in which you want to view the site. The default is English. If any content has not been translated into your site language, the English version will be displayed.'),
							'options'   => ContentHelper::ObjArrayToOptions(Lang::getLanguages(), 'ID_LANGUAGE', 'NativeName', 'ID_LANGUAGE', array($user->ID_LANGUAGE))
						),
						array(
							'type'      => 'customboxes',
							'title'     => $this->__('Additional languages'),
							'tooltip'   => $this->__('You have the option to select a number of additional content languages. If our content has not been translated into your site language, it may be available in other languages that you prefer.').' '.$this->__('You will get the option to choose between the available languages that you have selected.'),
							'options'   => $LanguageOptions
						)
					)
				);
			}
			ContentHelper::ParseEditorData($EditorData);
			break;
		case 'userphoto':
		   $EditorData = array(
				'ID'            => $user->ID_PLAYER,
				'Post'          => MainHelper::site_url('players/editprofileaction'.(isset($section) ? '/'.$section : '')),
				'MainOBJ'       => $user,
				'formid'        => 'editForm', // TODO: test if this actually is needed
				'Title'         => 'User',
				'ID_PRE'        => 'user',
				'NativeFields' 	=> $reguserFields,
				'PersonalInformation' => $PersonalInformation,
				'Elements'      => array(
					array( // all the hidden values
						'type'      => 'hidden',
						'values'    => array (
							array('user', $user->ID_PLAYER)
						)
					),
					array(
						'type'      => 'titleex',
						'text'      => $this->__('Account Settings'),
						'info'      => $this->__('Registered').': '.date(DATE_SHORT, $user->RegistrationTime).' -'
					),
				)
			);

			$EditorData['Elements'] = array_merge($EditorData['Elements'], 
				array
				(
					array(
						'type'      => 'picture'
					)
				)
			);
			ContentHelper::ParseEditorData($EditorData);
			break;
		case 'privatesettings':
		   $EditorData = array(
				'ID'            => $user->ID_PLAYER,
				'Post'          => MainHelper::site_url('players/editprofileaction'.(isset($section) ? '/'.$section : '')),
				'MainOBJ'       => $user,
				'formid'        => 'editForm', // TODO: test if this actually is needed
				'Title'         => 'User',
				'ID_PRE'        => 'user',
				'NativeFields' 	=> $reguserFields,
				'PersonalInformation' => $PersonalInformation,
				'Elements'      => array(
					array( // all the hidden values
						'type'      => 'hidden',
						'values'    => array (
							array('user', $user->ID_PLAYER)
						)
					),
					array(
						'type'      => 'titleex',
						'text'      => $this->__('Account Settings'),
						'info'      => $this->__('Registered').': '.date(DATE_SHORT, $user->RegistrationTime).' -'
					),
				)
			);

			//Privacy settings
			$EditorData['Elements'] = array_merge($EditorData['Elements'], 
				array
				(
					array(
						'type'      => 'info',
						'value'     => $this->__('Privacy settings'),
						'info'      => $this->__('Who can see your settings.')
					)
				)
			);

			$privacyBoxes[] =
				array(
					'class'     => '',
					'id'        => 'privacyFriend_all',
					'name'      => 'privacyFriend_all',
					'value'     => 0,
					'selected'   => "",
					'text'      => $this->__('All'),
					'action'	=>	'onclick="$(' . "'.privacyFriend').checkBox('changeCheckStatus', this.checked);" . '"'
				);
			$privacyBoxes[] =
				array(
					'class'     => '',
					'id'        => 'privacyOthers_all',
					'name'      => 'privacyOthers_all',
					'value'     => 0,
					'selected'   => "",
					'text'      => $this->__('All'),
					'action'	=>	'onclick="$(' . "'.privacyOthers').checkBox('changeCheckStatus', this.checked);" . '"'
				);
			$privacyBoxes[] =
				array(
					'class'     => '',
					'id'        => 'privacyCategory_all',
					'name'      => 'privacyCategory_all',
					'value'     => 0,
					'selected'   => "",
					'text'      => $this->__('All'),
					'action'	=>	'onclick="$(' . "'.privacyCategory').checkBox('changeCheckStatus', this.checked);" . '"'
				);

			$EditorData['Elements'] = array_merge($EditorData['Elements'], 
				array
				(
					array(
						'type'      => 'customboxes',
						'title'     => '',
						'options'   => $privacyBoxes
					)
				)
			);

			$SnPrivacy = new SnPrivacy;

			$privacyrows = $SnPrivacy->GetAllPrivacies();
			foreach($privacyrows as $row)
			{
				//Privacy setting entry
				$ID_PRIVSET = $row['ID_PRIVSET'];
				$Title = $row['Title'];
				
				$privacyBoxes = array();

				$selectedF = "";
				$selectedO = "";

				$userTarget = $SnPrivacy->GetUserTargets($user->ID_PLAYER,$ID_PRIVSET);
				foreach($userTarget as $ut)
				{
					$TargetType = $ut['TargetType'];
					if ($TargetType=='friends')
						$selectedF = "selected";
					if ($TargetType=='others')
						$selectedO = "selected";
				}

				//Privacy against friends
				$privacyBoxes[] =
					array(
						'class'     => 'privacyFriend',
						'id'        => 'PRIVACY_FRIENDS_'.$ID_PRIVSET,
						'name'      => 'PRIVACY_FRIENDS_'.$ID_PRIVSET,
						'value'     => $ID_PRIVSET,
						'selected'   => $selectedF,
						'text'      => $this->__('Friends')
					);
				//Privacy against others
				$privacyBoxes[] =
					array(
						'class'     => 'privacyOthers',
						'id'        => 'PRIVACY_OTHERS_'.$ID_PRIVSET,
						'name'      => 'PRIVACY_OTHERS_'.$ID_PRIVSET,
						'value'     => $ID_PRIVSET,
						'selected'   => $selectedO,
						'text'      => $this->__('Other users')
					);

				//Privacy against categories
				$categories = $SnPrivacy->GetAllCategories();
				foreach($categories as $category)
				{
					$ID_CATEGORY = $category['ID_CATEGORY'];

					$selected = "";
					foreach($userTarget as $ut)
						if ($ut['TargetType']=='category')
							if ($ut['ID_TARGET']==$ID_CATEGORY)
								$selected = "selected";

					$privacyBoxes[] =
						array(
							'class'     => 'privacyCategory',
							'id'        => 'PRIVACYCATEGORY_' . $ID_PRIVSET,
							'name'      => 'PRIVACYCATEGORY_' . $ID_PRIVSET . '[]',
							'value'     => $ID_CATEGORY,
							'selected'   => $selected,
							'text'      => $category['CategoryName']
						);

				}
				$EditorData['Elements'] = array_merge($EditorData['Elements'], 
					array
					(
						array(
							'type'      => 'customboxes',
							'title'     => $Title,
							'options'   => $privacyBoxes
						)
					)
				);

				if (!empty($ca))
				{
					$EditorData['Elements'] = array_merge($EditorData['Elements'], 
						array
						(
							array(
								'type'      => 'customboxes',
								'title'     => '',
								'options'   => $ca
							)
						)
					);
				}
			}
			ContentHelper::ParseEditorData($EditorData);
			break;
		case 'membersettings':
			?>
				<!-- Membership settings start -->
				<form class="standard_form mt30" method="post" id="editForm" action="<?php echo MainHelper::site_url('players/editprofileaction'); ?>">

					<div class="standard_form_header">
						<h1><?php echo $this->__('Membership Settings'); ?></h1>
					</div>

					<div class="standard_form_elements clearfix">

						<?php if(isset($currentMembership) and $currentMembership): ?>
							<?php 
								$currentMembershipType = $this->__('Basic');
								if($currentMembership->PackageType == PACKAGE_SILVER) {
									$currentMembershipType = $this->__('Silver');
								} else if($currentMembership->PackageType == PACKAGE_GOLD) {
									$currentMembershipType = $this->__('Gold');
								} else if($currentMembership->PackageType == PACKAGE_PLATINUM) {
									$currentMembershipType = $this->__('Platinum');
								}
							?>

							<div class="standard_form_info_header">
								<h2><?php echo $this->__('Current membership') ?></h2>
								<p><?php echo $this->__('Change or upgrade your current membership.'); ?></p>
							</div>

							<div class="clearfix">
								<span class="act_as_label"><?php echo $this->__('Membership type'); ?></span>
								<div class="act_as_input">
									<?php echo $currentMembershipType;?> <a href="<?php echo MainHelper::site_url('shop/membership');?>">(<?php echo $this->__('Change');?>)</a>
								</div>
							</div>

							<div class="clearfix">
								<span class="act_as_label"><?php echo $this->__('Start date'); ?></span>
								<div class="act_as_input">
									<?php echo date(DATE_SHORT, $currentMembership->ActivationTime);?>
								</div>
							</div>

							<div class="clearfix">
								<span class="act_as_label"><?php echo $this->__('End date'); ?></span>
								<div class="act_as_input">
									<?php echo date(DATE_SHORT, $currentMembership->ExpirationTime);?>
								</div>
							</div>

								<?php if(isset($nextMembership) and $nextMembership):?>
									<?php 
										$nextMembershipType = $this->__('Basic');
										if($nextMembership->PackageType == PACKAGE_SILVER) {
											$nextMembershipType = $this->__('Silver');
										} else if($nextMembership->PackageType == PACKAGE_GOLD) {
											$nextMembershipType = $this->__('Gold');
										} else if($nextMembership->PackageType == PACKAGE_PLATINUM) {
											$nextMembershipType = $this->__('Platinum');
										}
									?>

									<div class="standard_form_info_header no_sep">
										<h2><?php echo $this->__('Next update') ?></h2>
										<p><?php echo $this->__("Your next membership update will happen [_1].", array('<em>' . date(DATE_SHORT, $nextMembership->ActivationTime) . '</em>')); ?></p>
									</div>

									<div class="clearfix">
										<span class="act_as_label"><?php echo $this->__('Update type'); ?></span>
										<div class="act_as_input">
											<?php echo $nextMembershipType;?>
										</div>
									</div>

									<div class="clearfix">
										<span class="act_as_label"><?php echo $this->__('Start date'); ?></span>
										<div class="act_as_input">
											<?php echo date(DATE_SHORT, $nextMembership->ActivationTime);?>
										</div>
									</div>

									<div class="standalone_elm">
										<a href="javascript:void(0)" class="button button_medium red F_cancelNextMembership"><?php echo $this->__('Cancel');?></a>
									</div>
								<?php endif;?>

						<?php else: ?>

							<div class="standard_form_info_header">
								<h2><?php echo $this->__('Current membership') ?></h2>
							</div>

							<p class="standalone_elm">
								<?php echo $this->__("You currently have a basic membership. For more features you can buy a silver, gold or platinum membership in our shop right [_1]here[_2].", array('<a href="' . MainHelper::site_url('shop/membership') . '">', '</a>')); ?>
							</p>

						<?php endif;?>

						<?php if(isset($currentFeatures) and $currentFeatures):?>

							<div class="standard_form_info_header">
								<h2><?php echo $this->__('Additional site features') ?></h2>
								<p><?php echo $this->__('This is an overview of the additional site features you have purchased.'); ?></p>
							</div>

							<?php $amount = count($currentFeatures); ?>
							<?php $x = 1; ?>
							<?php foreach($currentFeatures as $package):?>
								<div class="clearfix">
									<span class="act_as_label"><?php echo $this->__('Feature type'); ?></span>
									<div class="act_as_input">
										<?php echo $package->NameTranslated;?>
									</div>
								</div>
								<div class="clearfix">
									<span class="act_as_label"><?php echo $this->__('Start date'); ?></span>
									<div class="act_as_input">
										<?php echo date(DATE_SHORT, $package->FiPlayerFeatureRel[0]->ActivationTime);?>
									</div>
								</div>
								<div class="clearfix">
									<span class="act_as_label"><?php echo $this->__('End date'); ?></span>
									<div class="act_as_input">
										<?php echo date(DATE_SHORT, $package->FiPlayerFeatureRel[0]->ExpirationTime);?>
									</div>
								</div>
								<?php echo ($x != $amount) ? '<div class="standard_form_seperator"></div>' : ''; ?>
								<?php $x++; ?>
							<?php endforeach; ?>
							</div>
							<div class="standard_form_footer clearfix">
								<p class="stand_form_footer_link pull_left"><?php echo $this->__('You can buy more additional site features in our shop right [_1]here[_2].', array('<a href="' . MainHelper::site_url('shop/membership') . '">', '</a>')); ?></p>
							</div>
						<?php else: ?>
							<div class="standard_form_info_header">
								<h2><?php echo $this->__('Additional site features') ?></h2>
							</div>
							<p class="standalone_elm">
								<?php echo $this->__("You don't have any additional site features at the moment. You can buy them in our shop right [_1]here[_2]. Additional site features lets you create extra groups, upload extra photos and much more.", array('<a href="' . MainHelper::site_url('shop/membership') . '">', '</a>')); ?>
							</p>
							</div>
						<?php endif; ?>
				</form>
			<?php
			break;
		case 'widgets':
			$EditorData = array(
				'ID'            => $user->ID_PLAYER,
				'Post'          => MainHelper::site_url('players/editprofileaction'.(isset($section) ? '/'.$section : '')),
				'MainOBJ'       => $user,
				'formid'        => 'editForm', // TODO: test if this actually is needed
				'Title'         => 'Widgets',
				'class'         => 'widgets',
				'ID_PRE'        => 'user',
				'PersonalInformation' => $PersonalInformation,
				'Elements'      => array(
					array( // all the hidden values
						'type'      => 'hidden',
						'values'    => array(
							array('user', $user->ID_PLAYER)
						)
					),
					array(
						'type'      => 'titleex',
						'text'      => $this->__('Account Settings'),
						'info'      => $this->__('Registered').': '.date(DATE_SHORT, $user->RegistrationTime).' - '
					),
					array(
						'type'      => 'info',
						'value'     => $this->__('Widgets'),
						'info'      => $this->__('Organize your widgets.')
					)
				)
			);

			$howToOrder = isset($orderWidgetsBy) ? $orderWidgetsBy : '';

			$EditorData['Elements'] = array_merge($EditorData['Elements'],
				array(
					array(
						'type'      => 'columnlabel',
						'id'        => '',
						'title'     => '',
						'options'   => array(
							array(
								'text'  => 'Position',
								'tooltip' => 'Sort the widgets by position.',
								'link'  => 'position',
								'current' => ($howToOrder == 'position') ? true : false,
								'style' => 'float: left; width: 42%;'
							),
							array(
								'text'  => 'Visibility', 
								'tooltip' => 'Sort the widgets by visibility.',
								'link'  => 'visibility',
								'current' => ($howToOrder == 'visibility') ? true : false,
								'style' => 'float: left; width: 58%;'
							)
						)
					)
				)
			);

			$widgetsList = MainHelper::getWidgetsList($user->ID_PLAYER, $howToOrder);

			foreach ($widgetsList as $item) {
				$widget[] = array(
					'name'      => $item['Name'],
					'value'     => $item['ID_WIDGET'],
					'order'     => $item['WidgetOrder']
				);

				if($item['isVisible'] == 1) {
					$EditorData['PersonalInformation'] = array_merge($EditorData['PersonalInformation'],
						array(
							'vcb_' . $item['Name']
						)
					);
				}
			}

			foreach ($widget as $key => $value) {
				$select = array();
				for ($i = 1; $i <= count($widget); $i++) {
					$selected = ($i == $widget[$key]['order']) ? 'selected' : '';
					$select[] = array(
							'value' => $i, 
							'text' => $i, 
							'selected' => $selected
					);
				}

				$EditorData['Elements'] = array_merge($EditorData['Elements'], 
					array(
						array(
							'type'      => 'selectNarrow',
							'title'     => $widget[$key]['name'],
							'id'        => '',
							'name'      => $widget[$key]['name'],
							'class'     => 'widgets_layout select-' . $widget[$key]['name'],
							'options'   => $select,
							'CbVisibile'=> '1',
							'CbVisibileLeft' => '60%'
						)
					)
				);
			}
			ContentHelper::ParseEditorData($EditorData);
			break;
		case 'emailpassword':
			$EditorData = array(
				'ID'            => $user->ID_PLAYER,
				'Post'          => MainHelper::site_url('players/editprofileaction'.(isset($section) ? '/'.$section : '')),
				'MainOBJ'       => $user,
				'formid'        => 'editForm', // TODO: test if this actually is needed
				'Title'         => 'User',
				'ID_PRE'        => 'user',
				'NativeFields' 	=> $reguserFields,
				'PersonalInformation' => $PersonalInformation,
				'Elements'      => array(
					array( // all the hidden values
						'type'      => 'hidden',
						'values'    => array (
							array('user', $user->ID_PLAYER)
						)
					),
					array(
						'type'      => 'titleex',
						'text'      => $this->__('Account Settings'),
						'info'      => $this->__('Registered').': '.date(DATE_SHORT, $user->RegistrationTime).' -'
					),
					array(
						'type'      => 'info',
						'value'     => $this->__('Personal information'),
						'info'      => $this->__('Email and password.')
					),
					array(
						'type'      => 'linklabel',
						'title'		=> $this->__('Email address'),
						'class'		=> 'messageOpt mr2 fl db changeemail',
						'rel'		=> '',
						'link'		=> 'players/ajaxchangeemail',
						'value'		=> $user->EMail
					),
					array(
						'type'      => 'password',
						'title'     => $this->__('Password'),
						'id'        => 'password',
						'name'      => 'pass',
						'value'     => ''
					),
					array(
						'type'      => 'password',
						'title'     => $this->__('Confirm password'),
						'id'        => 'confirmpassword',
						'value'     => ''
					)
				)
		   );
			ContentHelper::ParseEditorData($EditorData);
			if (!$noProfileFunctionality)
			{
				$linkTitle = $this->__('Disable profile');
				$linkHref = MainHelper::site_url('players/edit/disableprofile');
				?>
				<div class="standard_form mt30">
					<div class="standard_form_header">
						<h2><?php echo $this->__('Disable your profile on the link below.') ?></h2>
					</div>
					<div class="standard_form_elements clearfix">
						<div class="clearfix">
							<a onclick="return confirm('<?php echo $this->__('Are you sure?'); ?>');" class="" href="<?php echo $linkHref; ?>"><?php echo $linkTitle ?></a>
						</div>
					</div>
				</div>
			<?php 
			}

			break;
	}
?>
	<?php /* NOT DONE */ ?>
	<?php /*
	<div class="usage_statistics_wrapper">
		<a href="#" class="usage_statistics_ribbon"></a>

		<div class="usage_statistics">
			<a href="#" class="usage_statistics_close">&times;</a>

			<ul class="statistics_list">
				<li>
					<span class="icon_span"><i class="stat_image_icon"></i><?php echo $user->WallPhotoCount . '/'. $user->ImageLimit; ?></span>
					<?php echo $this->__('Images'); ?>
				</li>
				<li>
					<span class="icon_span"><i class="stat_group_icon"></i><?php echo $user->GroupsOwnedCount .'/'. $user->GroupLimit; ?></span>
					<?php echo $this->__('Groups'); ?>
				</li>
				<li>
					<span class="icon_span"><i class="stat_film_icon"></i><?php echo $user->WallVideoCount; ?></span>
					<?php echo $this->__('Videos'); ?>
				</li>
				<li>
					<span class="icon_span"><i class="stat_link_icon"></i><?php echo $user->WallLinkCount; ?></span>
					<?php echo $this->__('Links'); ?>
				</li>
			</ul>

			<ul class="statistics_list">
				<li>
					<span class="icon_span"><i class="stat_post_icon"></i><?php echo $user->WallPostCount; ?></span>
					<?php echo $this->__('Posts'); ?>
				</li>
				<li>
					<span class="icon_span"><i class="stat_group_icon"></i><?php echo $user->FriendCount; ?></span>
					<?php echo $this->__('Friends'); ?>
				</li>
				<li>
					<span class="icon_span"><i class="stat_game_icon"></i><?php echo $user->GameCount; ?></span>
					<?php echo $this->__('Games'); ?>
				</li>
				<li>
					<span class="icon_span"><i class="stat_event_icon"></i><?php echo $user->EventCount; ?></span>
					<?php echo $this->__('Events'); ?>
				</li>
			</ul>
			
		</div>
	</div>
	*/ ?>
<!-- Profile settings end -->
<!-- Membership settings end -->
<script type="text/javascript">loadCheckboxes();</script>
