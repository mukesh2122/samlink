<?php

    $EditorData = array(
        'ID'            => $campaign->ID_CAMPAIGN,
        'Post'          => MainHelper::site_url('admin/campaigns/editcampaign/'.$campaign->ID_CAMPAIGN),
        'MainOBJ'       => $campaign,
        'Title'         => 'Campaign',
        'ID_PRE'        => 'campaign',
        'Elements'      => array(
            array(
                'type'      => 'title',
                'text'      => $this->__('Campaign Settings')
            ),
            array( // all the hidden values
                'type'      => 'hidden',
                'values'    => array (
                    array('campaign_id', $campaign->ID_CAMPAIGN)
                )
            ),
            array(
                'id'        => 'campaign_name',
                'title'     => $this->__('Name'),
                'value'     => $campaign->AdvertiserName, 
				'fieldName'	=> 'Name'

            ),
            array(
                'id'        => 'country_id',
                'type'      => 'select',
                'options'   => ContentHelper::ObjArrayToOptions($countryList, 'ID_COUNTRY', 'Country', 'ID_COUNTRY', array($campaign->Country)),
                'value'     => '0',
                'text'      => $this->__('Select language'),
                'title'     => $this->__('Country')
            ),
            array(
                'id'        => 'language_id',
                'type'      => 'select',
                'options'   => ContentHelper::ObjArrayToOptions($languageList, 'ID_LANGUAGE', 'EnglishName', 'ID_LANGUAGE', array($campaign->Language)),
                'value'     => '0',
                'text'      => $this->__('Select country'),
                'title'     => $this->__('Language')
            ),
            			array(
                'type'      => 'date',
                'id'        => 'startdate',
                'prefix'    => 'startdate_',
                'title'     => $this->__('Start Date'),
                'value'     => date('Y-m-d',$campaign->StartDate)
				
            ),
            array(
                'type'      => 'date',
                'id'        => 'enddate',
                'prefix'    => 'enddate_',
                'title'     => $this->__('End Date'),
                'value'     => $campaign->EndDate == 0 ? '' : date('Y-m-d',$campaign->EndDate)
				
            ),
            array(
                    'type'      => 'checkbox',
                    'id'        => 'enddate',
                    'value'     => '0',
                    'title'     => $this->__('No end date'),
                    'label'     => '',
                    'checked'   => $campaign->EndDate == 0
            ),
        )        
    );
			
    ContentHelper::ParseEditorData($EditorData);
?>
		
