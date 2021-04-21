<?php $reguserFields = MainHelper::GetModuleFieldsByTag('reguser'); ?>  

<?php
    $UserGroupArray = array();
    $groups = Doo::conf()->userGroups;
    foreach ($groups as $key => $group) {
        $UserGroupArray[] = array(
            'value'     => $key,
            'selected'  => $user->ID_USERGROUP == $key,
            'text'  => $group['label']
        );
    }
    
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
        'Post'          => MainHelper::site_url('admin/users/edit/'.$user->ID_PLAYER),
        'MainOBJ'       => $user,
        'Title'         => 'User',
        'ID_PRE'        => 'user',
        'NativeFields' 	=> $reguserFields,
        'Elements'      => array(
            array( // all the hidden values
                'type'      => 'hidden',
                'values'    => array (
                    array('daylight', '1'),
                    array('blogger', '1'),
                    array('user', $user->ID_PLAYER)
                )
            ),
            array(
                'type'      => 'titleex',
                'text'      => $this->__('Account Settings'),
                'info'      => '- ' . $this->__('Registered') . ': ' . date(DATE_SHORT, $user->RegistrationTime) . ' - ' . $user->Credits . ' / ' . $user->PlayCredits
            ),
            array(
                'title'     =>  $this->__('E-Mail') .' <b>'. ($user->VerificationCode == "" ? 'Verified' : 'Not Verified') . '</b>',
                'value'     => $user->EMail,
                'id'        => 'email'
            ),
            array(
                'title'     => $this->__('First name'),
                'id'        => 'firstName',
                'value'     => $user->FirstName,
				'fieldName'	=> 'FirstName'
            ),
            array(
                'title'     => $this->__('Last name'),
                'id'        => 'lastName',
                'value'     => $user->LastName,
				'fieldName'	=> 'LastName'
            ),
            array(
                'title'     => $this->__('Nickname'),
                'id'        => 'nickname',
                'value'     => $user->NickName
            ),
            array(
                'title'     => $this->__('Display name'),
                'id'        => 'displayName',
                'value'     => $user->DisplayName
            ),
            array(
                'type'      => 'date',
                'id'        => 'dob',
                'prefix'    => '',
                'title'     => $this->__('Date of birth'),
                'value'     => $user->DateOfBirth,
				'fieldName'	=> 'DateOfBirth'
            ),
            array(
                'title'     => $this->__('City'),
                'id'        => 'city',
                'value'     => $user->City,
				'fieldName'	=> 'City'
            ),
            array(
                'type'      => 'select',
                'title'     => $this->__('Country'),
                'id'        => 'country',
                'options'   => ContentHelper::ObjArrayToOptions(MainHelper::getCountryList(), 'A2', 'Country', 'A2', array($user->Country)),
				'fieldName'	=> 'Country'
            ),
            array(
                'title'     => $this->__('Address'),
                'id'        => 'address',
                'value'     => $user->Address,
				'fieldName'	=> 'Address'

            ),
            array(
                'title'     => $this->__('Zip'),
                'id'        => 'zip',
                'value'     => $user->Zip,
				'fieldName'	=> 'Zip'
            ),
            array(
                'title'     => $this->__('Phone'),
                'id'        => 'phone',
                'value'     => $user->Phone,
				'fieldName'	=> 'Phone'
            )
        )
    );

	//Add extrafields to EditorData
	if (isset($extrafields))
		$EditorData = ContentHelper::AddEditorDataExtrafields($extrafields,$EditorData,$this);

	$categories = MainHelper::GetPlayerCategories('player');
	if (isset($categories))
		$EditorData = ContentHelper::AddEditorDataCategories($categories,$EditorData,$this,$user->ID_PLAYER,true);
		
	$EditorData['Elements'] = array_merge($EditorData['Elements'], 
		array
		(
            array(
                'type'      => 'info',
                'value'     => $this->__('Password settings'),
                'info'      => $this->__('Leave empty if no changed needed.')
            ),
            array(
                'title'     => $this->__('Password'),
                'id'        => 'pass',
                'name'      => 'password',
            ),
            array(
                'type'      => 'info',
                'value'     => $this->__('Permission settings')
            ),
            array(
                'type'      => 'select',
                'id'        => 'usergroup',
                'title'     => $this->__('Permission Group'),
                'options'   => $UserGroupArray
            ),
            array(
                'type'      => 'checkbox',
                'id'        => 'hasBlog',
                'title'     => $this->__('Is Blogger'),
                'label'     => $this->__('Yes'),
                'checked'   => $user->hasBlog == 1
            ),
            array(
                'title'     => $this->__('Image limit'),
                'id'        => 'imageLimit',
                'value'     => $user->ImageLimit,
            ),
            array(
                'title'     => $this->__('Group limit'),
                'id'        => 'groupLimit',
                'value'     => $user->GroupLimit
            ),
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
            ),
            array(
                'type'      => 'info',
                'value'     => $this->__('Language settings'),
                'info'      => $this->__('Change language settings.')
            ),
            array(
                'type'      => 'select',
                'id'        => 'language',
                'title'     => $this->__('Site language'),
                'options'   => ContentHelper::ObjArrayToOptions(Lang::getLanguages(), 'ID_LANGUAGE', 'NativeName', 'ID_LANGUAGE', array($user->ID_LANGUAGE))
            ),
            array(
                'type'      => 'customboxes',
                'title'     => $this->__('Additional languages'),
                'options'   => $LanguageOptions
            ),
            array(
                'type'      => 'picture'
            ),
            array(
                'type'      => 'info',
                'value'     => $this->__('Referrer settings'),
                'info'      => $this->__('Use integer values for percentage')
            ),
            array(
                'type'      => 'checkbox',
                'title'     => $this->__('Enabled'),
                'id'        => 'isReferrer',
                'checked'   => $user->isReferrer == 1,
                'label'     => $this->__('Yes')
            ),
            array(
                'type'      => 'checkbox',
                'title'     => $this->__('Can Create SubReferrers'),
                'id'        => 'canCreateReferrers',
                'checked'   => $user->canCreateReferrers == 1,
                'label'     => $this->__('Yes')
            ),
            array(
                'title'     => $this->__('Display Name'),
                'id'        => 'referrerName',
                'value'     => (isset($referrer) and !empty($referrer)) ? $referrer->DisplayName : ''
            ),
            array(
                'title'     => $this->__('Commission'),
                'id'        => 'comission',
                'value'     => (isset($referrer) and !empty($referrer)) ? $referrer->Commision : 0
            )
			
			
		)
	);

	
	
    ContentHelper::ParseEditorData($EditorData);
 ?>
