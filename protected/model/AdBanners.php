<?php

Doo::loadCore('db/DooSmartModel');

class AdBanners extends DooSmartModel {

    public $ID_BANNER;
    public $FK_CAMPAIGN;
    public $Placement;
    public $isCode;
    public $Code;
    public $PathToBanner;
    public $DestinationUrl;
    public $MaxDisplays;
    public $CurrentDisplays;
    public $MaxClicks;
    public $CurrentClicks;
    public $DisplaySiteUrl;

    public $_table = 'ad_banners';
    public $_primarykey = 'ID_BANNER';
    public $_fields = array(
		'ID_BANNER',
		'FK_CAMPAIGN',
                'Placement',
                'isCode',
                'Code',
                'PathToBanner',
                'DestinationUrl',
                'MaxDisplays',
                'CurrentDisplays',
                'MaxClicks',
                'CurrentClicks',
                'DisplaySiteUrl'
	);

    public function getCampaignName(){
        $campaign = new AdCampaigns();

        $campaign->ID_CAMPAIGN = $this->FK_CAMPAIGN;
        $campaign = $campaign->getOne();

        return $campaign->AdvertiserName;
    }
}
?>