<?php
class Campaign{

    //find all campaigns
    //
    //@output -> AdCampaigns
    public function getAllCampaigns($limit = 30){
        
        $list = Doo::db()->find('AdCampaigns',array(
                            'limit' => $limit
        ));
        
        return $list;
    }

    //find all campaigns
    //
    //@output -> AdCampaigns
    public function getAllBanners($limit = 30){
        
        $list = Doo::db()->find('AdBanners',array(
                            'limit' => $limit
        ));
        
        return $list;
    }
    //get campaign by id
    //
    //@output -> AdCampaigns
    public function getCampaignByID($ID_CAMPAIGN){
        $list = Doo::db()->getOne('AdCampaigns',array('where' => "ID_CAMPAIGN = {$ID_CAMPAIGN}"));
        return $list;
    }
    
    //get banner by id
    //
    //@output -> AdBanners
    public function getBannerByID($ID_BANNER){
        $list = Doo::db()->getOne('AdBanners',array('where' => "ID_BANNER = {$ID_BANNER}"));
        return $list;
    }
    
     //get banner by campaign
    //
    //@output -> AdBanners
    public function getBannersByCampaign($ID_CAMPAIGN){
        $list = Doo::db()->find('AdBanners',array('where' => "FK_CAMPAIGN = {$ID_CAMPAIGN}"));
        return $list;
    }
    
     //get banners campaign name
    //
    //@output -> string
    public function getCampaignName($ID_CAMPAIGN){
        $list = Doo::db()->getOne('AdCampaigns',array(
                    'where' => "ID_CAMPAIGN = {$ID_CAMPAIGN}",
                            ));
        
        return $list->AdvertiserName;
    }
    
    //create campaign
    //
    //
    public function createCampaign($post){
        $campaign = new AdCampaigns();

        if (isset($post['advertiser_name'])) $campaign->AdvertiserName = ContentHelper::handleContentInput($post['advertiser_name']);
        if (isset($post['country'])) $campaign->Country = ContentHelper::handleContentInput($post['country']);
        if (isset($post['language'])) $campaign->Language = ContentHelper::handleContentInput($post['language']);

        if (isset($post['csday']) and isset($post['csmonth']) and isset($post['csyear'])) {
            $date=  strtotime("{$post['csday']}-{$post['csmonth']}-{$post['csyear']}");
            $campaign->StartDate = $date;
        }
        
        if(!isset($post['enddate'])){
            if (isset($post['ceday']) and isset($post['cemonth']) and isset($post['ceyear']) and $post['ceday'] != 0 and $post['cemonth'] != 0 and $post['ceyear'] != 0) {
                $date=  strtotime("{$post['ceday']}-{$post['cemonth']}-{$post['ceyear']}");
                $campaign->EndDate = $date;
            }
            else $campaign->EndDate = 0;
        }
        else $campaign->EndDate = 0;

        $campaign->insert();
    }
    //delete campaign
    //
    //
    public function deleteCampaign($ID_CAMPAIGN)
    {
        $campaign = new AdCampaigns();
        
        $campaign->ID_CAMPAIGN = $ID_CAMPAIGN;
        $campaign->delete();
    }
    
    //delete banner
    //
    //
    public function deleteBanner($ID_BANNER)
    {
        $banner = new AdBanners();
        
        $banner->ID_BANNER = $ID_BANNER;
        $banner->delete();
    }
    
    //update campaign
    //
    //
    public function updateCampaign(AdCampaigns $campaign, $post){
        
       if (isset($post['campaign_name'])) $campaign->AdvertiserName = ContentHelper::handleContentInput($post['campaign_name']);
       if (isset($post['country_id'])) $campaign->Country = ContentHelper::handleContentInput($post['country_id']);
       if (isset($post['language_id'])) $campaign->Language = ContentHelper::handleContentInput($post['language_id']);

       if (isset($post['startdate_day']) and isset($post['startdate_month']) and isset($post['startdate_year'])) {
           $date=  strtotime("{$post['startdate_day']}-{$post['startdate_month']}-{$post['startdate_year']}");
           $campaign->StartDate = $date;
       }
       
       if(!isset($post['enddate'])){
           if (isset($post['enddate_day']) and isset($post['enddate_month']) and isset($post['enddate_year']) and $post['enddate_day'] != 0 and $post['enddate_month'] != 0 and $post['enddate_year'] != 0) {
               $date=  strtotime("{$post['enddate_day']}-{$post['enddate_month']}-{$post['enddate_year']}");
               $campaign->EndDate = $date;
           }
           else $campaign->EndDate = 0;
       }
       else $campaign->EndDate = 0;

       $campaign->update();
    }
    //update banners
    //
    //
    public function updateBanner(AdBanners $banner, $post){
        
       if (isset($post['campaign_id'])) $banner->FK_CAMPAIGN = ContentHelper::handleContentInput($post['campaign_id']);
       if (isset($post['max_clicks'])) $banner->MaxClicks = ContentHelper::handleContentInput($post['max_clicks']);
       if (isset($post['max_displays'])) $banner->MaxDisplays = ContentHelper::handleContentInput($post['max_displays']);
       if (isset($post['destination_url'])) $banner->DestinationUrl = ContentHelper::handleContentInput($post['destination_url']);
       if (isset($post['displaysite'])) $banner->DisplaySiteUrl = ContentHelper::handleContentInput($post['displaysite']);
       
       if (isset($post['top'])){
                $banner->Placement = 'top';
        }
       else if (isset($post['side'])){
                $banner->Placement = 'side';
        }
        
       $banner->update();
    }
        //create campaign
    //
    //
    public function uploadBanner($post){
        $banner = new AdBanners();
        $imageUrl = "";
		if (!empty($_FILES['Filedata']) and $_FILES['Filedata']['size'] > 0) {
			$image = new Image();
			$result = $image->uploadImages(FOLDER_BANNERS, '', '', false);
			if ($result['filename'] != '') {
				$imageUrl = $result['filename'];
			}
		}
        if (isset($post['placements'])){
            foreach ($post['placements'] as $placement)
                $banner->Placement = ContentHelper::handleContentInput($placement);
        }
        $banner->Code = 0;
        if (isset($post['maxDisplays'])) $banner->MaxDisplays = ContentHelper::handleContentInput($post['maxDisplays']);
        if (isset($post['maxClicks'])) $banner->MaxClicks = ContentHelper::handleContentInput($post['maxClicks']);
        if (isset($post['campaign_id'])) $banner->FK_CAMPAIGN = ContentHelper::handleContentInput($post['campaign_id']);
        if (isset($post['destination'])) $banner->DestinationUrl = ContentHelper::handleContentInput($post['destination']);
        if (isset($post['displaysite'])) $banner->DisplaySiteUrl = ContentHelper::handleContentInput($post['displaysite']);
        
            $banner->PathToBanner = $imageUrl;
      

        $banner->insert();
    }
}
?>