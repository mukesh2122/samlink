<?php

class AdminCampaignController extends AdminController {
	
	//Main website function
    public function index() {
        
		$campaigns = new Campaign();
		
		
		$list = array();
		$list['campaigns'] = $campaigns->getAllCampaigns();
                
		$data['title'] ='All Campaigns';
		$data['body_class'] = 'index_campaign';
		$data['selected_menu'] = 'campaigns';
		$data['left'] = $this->renderBlock('campaigns/common/leftColumn');
		$data['content'] = $this->renderBlock('campaigns/index', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}
	
	//New Campaign
    public function newCampaign(){
        $campaigns = new Campaign();
        
        $list = array();
	
        $list['countries'] = MainHelper::getCountryList();
        $list['languages'] = Lang::getLanguages();
	
        if(isset($_POST) and !empty($_POST)) {
			$campaign = $campaigns->createCampaign($_POST);
                        DooUriRouter::redirect(MainHelper::site_url('admin/campaigns'));
		}
        
		$data['title'] ='New Campaign';
		$data['body_class'] = 'index_news';
		$data['selected_menu'] = 'campaigns';
		$data['left'] = $this->renderBlock('campaigns/common/leftColumn');
		$data['right'] = '';
		$data['content'] = $this->renderBlock('campaigns/newcampaign', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}
	
	// Edit Campaign
	public function editCampaign(){
                $campaigns = new Campaign();
            
                $campaign = $campaigns->getCampaignByID($this->params['ID_CAMPAIGN']);
                
                if(isset($_POST) and !empty($_POST)) {
                        $campaigns->updateCampaign($campaign, $_POST);
			DooUriRouter::redirect(MainHelper::site_url('admin/campaigns/editcampaign/'.$campaign->ID_CAMPAIGN));
		}
                $list = array();
                $list['campaign'] = $campaign;  
                $list['countryList'] = MainHelper::getCountryList();
                $list['languageList'] = Lang::getLanguages();
               
                $data['title'] ='Edit Campaign';
		$data['body_class'] = 'edit_campaign';
		$data['selected_menu'] = 'campaigns';
		$data['left'] = $this->renderBlock('campaigns/common/leftColumn');
		$data['right'] = $this->renderBlock('campaigns/common/rightColumn', array('campaign' => $campaign ));
		$data['content'] = $this->renderBlock('campaigns/editcampaign', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}
	public function delCampaign(){
		$campaigns = new Campaign();
                
                $campaigns->deleteCampaign($this->params['ID_CAMPAIGN']);
                DooUriRouter::redirect(MainHelper::site_url('admin/campaigns'));
	}
	public function adBanner(){
        $campaigns = new Campaign();
		
        if(isset($_POST) and !empty($_POST)) {
                        $campaigns->uploadBanner($_POST);
			DooUriRouter::redirect(MainHelper::site_url('admin/campaigns/'));
		}
	$list = array();
        $list['campaign'] = $campaigns->getCampaignByID($this->params['ID_CAMPAIGN']);
	
	$data['title'] ='Upload Banner';
	$data['body_class'] = 'upload_banner';
	$data['selected_menu'] = 'campaigns';
	$data['left'] = $this->renderBlock('campaigns/common/leftColumn');
	$data['right'] = $this->renderBlock('campaigns/common/rightColumn', $list);
	$data['content'] = $this->renderBlock('campaigns/uploadbanner', $list);
	$data['footer'] = MainHelper::bottomMenu();
	$data['header'] = $this->getMenu();
	$this->render3Cols($data);	
	}
 
        public function banners() {
        
		$campaigns = new Campaign();
		
		$list = array();
		$list['banners'] = $campaigns->getBannersByCampaign($this->params['ID_CAMPAIGN']);
                $list['campaign'] = $this->params['ID_CAMPAIGN'];
                
		$data['title'] ='Banners';
		$data['body_class'] = 'index_banners';
		$data['selected_menu'] = 'campaigns';
		$data['left'] = $this->renderBlock('campaigns/common/leftColumn');
		$data['right'] = $this->renderBlock('campaigns/common/rightColumn', array('campaign' => $campaigns->getCampaignByID($this->params['ID_CAMPAIGN'])));
		$data['content'] = $this->renderBlock('campaigns/banners', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}
        public function allBanners() {
        
		$campaigns = new Campaign();
		
		$list = array();
		$list['banners'] = $campaigns->getAllBanners();
                
		$data['title'] ='Banners';
		$data['body_class'] = 'index_banners';
		$data['selected_menu'] = 'campaigns';
		$data['left'] = $this->renderBlock('campaigns/common/leftColumn');
		$data['content'] = $this->renderBlock('campaigns/allbanners', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}
	
	public function editBanner(){
                $campaigns = new Campaign();
            
                $banner = $campaigns->getBannerByID($this->params['ID_BANNER']);
                $campaignList = $campaigns->getAllCampaigns();
                
                if(isset($_POST) and !empty($_POST)) {
                        $campaigns->updateBanner($banner, $_POST);
			DooUriRouter::redirect(MainHelper::site_url('admin/campaigns/editbanner/'.$banner->ID_BANNER));
		}
                $list = array();
                $list['banner'] = $banner;  
                $list['campaignList'] = $campaignList;
               
                $data['title'] ='Edit Banner';
		$data['body_class'] = 'edit_banner';
		$data['selected_menu'] = 'campaigns';
		$data['left'] = $this->renderBlock('campaigns/common/leftColumn');
		$data['right'] = $this->renderBlock('campaigns/common/rightColumn', array('campaign' => $campaigns->getCampaignByID($banner->FK_CAMPAIGN)));
		$data['content'] = $this->renderBlock('campaigns/editbanner', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}
	
	public function delBanner(){
            $ID_CAMPAIGN = isset($this->params['ID_CAMPAIGN']) ? $this->params['ID_CAMPAIGN'] : '';
            $campaign = new Campaign();
            $campaign->deleteBanner($this->params['ID_BANNER']);
            DooUriRouter::redirect(MainHelper::site_url('admin/campaigns/banners/'.$ID_CAMPAIGN));
	}
	
}