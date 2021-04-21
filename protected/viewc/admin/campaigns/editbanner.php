<?php

    $EditorData = array(
        'ID'            => $banner->ID_BANNER,
        'Post'          => MainHelper::site_url('admin/campaigns/editbanner/'.$banner->ID_BANNER),
        'MainOBJ'       => $banner,
        'Title'         => 'Banner',
        'ID_PRE'        => 'banner',
        'Elements'      => array(
            array(
                'type'      => 'title',
                'text'      => $this->__('Banner Settings')
            ),
            array( // all the hidden values
                'type'      => 'hidden',
                'values'    => array (
                    array('banner_id', $banner->ID_BANNER)
                )
            ),
            array(
                    'type'      => 'checkbox',
                    'id'        => 'top',
                    'value'     => 'top',
                    'title'     => $this->__('Placement'),
                    'label'     => $this->__('Top'),
                    'checked'   => $banner->Placement == 'top'
            ),
            array(
                    'type'      => 'checkbox',
                    'id'        => 'side',
                    'value'     => 'side',
                    'title'     => '',
                    'label'     => $this->__('Side'),
                    'checked'   => $banner->Placement == 'side'
            ),
            array(
                'id'        => 'campaign_id',
                'type'      => 'select',
                'options'   => ContentHelper::ObjArrayToOptions($campaignList, 'ID_CAMPAIGN', 'AdvertiserName', 'ID_CAMPAIGN', array($banner->FK_CAMPAIGN)),
                'value'     => '0',
                'text'      => $this->__('Select campaign'),
                'title'     => $this->__('Campaign')
            ),
            array(
                'id'        => 'max_clicks',
                'title'     => $this->__('Max clicks'),
                'value'     => $banner->MaxClicks, 
				'fieldName'	=> 'Max clicks'

            ),
            array(
                'id'        => 'max_displays',
                'title'     => $this->__('Max displays'),
                'value'     => $banner->MaxDisplays, 
				'fieldName'	=> 'Max displays'

            ),
            array(
                'id'        => 'destination_url',
                'title'     => $this->__('Destination URL'),
                'value'     => $banner->DestinationUrl, 
				'fieldName'	=> 'Destination URL'

            ),
            array(
                'id'        => 'displaysite',
                'title'     => $this->__('Display site URL'),
                'value'     => $banner->DisplaySiteUrl, 
				'fieldName'	=> 'Display site URL'

            ),
        )        
    );
		
    ContentHelper::ParseEditorData($EditorData);
    
?>	
