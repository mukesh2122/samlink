<?php

class ReferralController extends SnController {

    public function index() {
		$list = array();
		$referral = new Referral();
		$player = User::getUser();
		if(!$player or $player->isReferrer != 1) {
			 DooUriRouter::redirect(MainHelper::site_url());
			 return false;
		}
		$list['infoBox'] = MainHelper::loadInfoBox('Referral', 'index', true);

		if(isset($this->params['fromDate']) and isset($this->params['toDate'])) {
			$timeFrom = strtotime(str_replace(" ", "-",urldecode($this->params['fromDate'])));
			$timeTo = strtotime(str_replace(" ", "-",urldecode($this->params['toDate'])));
		} else {
			$timeFrom = mktime(0,0,0,1,1,(date('Y',time())));
			$timeTo = time();
		}

		if($timeFrom <= 0 or $timeTo <= 0) {
			$timeFrom = mktime(0,0,0,1,1,(date('Y',time())));
			$timeTo = time();
		}

        $list['timeFrom'] = $timeFrom;
        $list['timeTo'] = $timeTo;
        $list['subReferals'] = $referral->getSubReferrals($player, $timeFrom, $timeTo);
		$list['assignedCodes'] = $referral->getAssignedCodes($player, $timeFrom, $timeTo);
		$data['title'] = $this->__('Referral');
        $data['body_class'] = 'index_referral';
        $data['selected_menu'] = 'players';
        $data['left'] = PlayerHelper::playerLeftSide('affiliate');
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('referral/index', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
	}

	public function registerReferral() {
		if(!isset($this->params['code']) or intval($this->params['code']) <= 9999) {
			DooUriRouter::redirect(MainHelper::site_url());
            return FALSE;
		}
		$code = intval($this->params['code']);
		$referral = new Referral();
		$referrer = $referral->getByCode($code);
		if(!$referrer) {
			DooUriRouter::redirect(MainHelper::site_url());
            return FALSE;
		}

		$referral->registerAction($code, REFERRAL_CLICK);
		$_SESSION['referringCode'] = $code;
        
        $url = $this->params['url'];
        foreach($this->params as $k => $v)
        {
            if(is_numeric($k))
            {
                $url .='/'.$v;
            }
        }

        if(isset($this->params['url'])&&!empty($this->params['url']))
        {
            $header = get_headers(MainHelper::site_url($url));
            if($header[0] == 'HTTP/1.1 404 Not Found')
            {
                $url = '';
            }
        }
		DooUriRouter::redirect(MainHelper::site_url($url));
		return FALSE;
	}

	public function createReferralCode() {
		$player = User::getUser();
		if(!$player or $player->isReferrer != 1) {
			 DooUriRouter::redirect(MainHelper::site_url());
			 return false;
		}

		if($player->canCreateReferrers != 1) {
			 DooUriRouter::redirect(MainHelper::site_url('referral'));
			 return false;
		}

		$list = array();
		$referral = new Referral();
		if(isset($_POST) and !empty($_POST) and MainHelper::validatePostFields(array('displayLabel'))) {
			$displayName = ContentHelper::handleContentInput($_POST['displayLabel']);
			$referer = $referral->createReferral($player, $displayName);
			DooUriRouter::redirect(MainHelper::site_url('referral'));
            return FALSE;
		}
		$list['infoBox'] = MainHelper::loadInfoBox('Referral', 'index', true);
		$data['title'] = $this->__('Referral');
        $data['body_class'] = 'index_referral';
        $data['selected_menu'] = 'players';
        $data['left'] = PlayerHelper::playerLeftSide('affiliate');
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('referral/manageReferralCode', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
	}

	public function editReferralCode() {
		if(!isset($this->params['code']) or intval($this->params['code']) <= 9999) {
			DooUriRouter::redirect(MainHelper::site_url('referral'));
            return FALSE;
		}

		$referral = new Referral();
		$code = intval($this->params['code']);
		$referrer = $referral->getByCode($code);
		$player = User::getUser();
		$list = array();

		if(!$player or $player->ID_PLAYER != $referrer->ID_REFERRER or $player->isReferrer != 1) {
			DooUriRouter::redirect(MainHelper::site_url('referral'));
            return FALSE;
		}

		if(isset($_POST) and !empty($_POST) and MainHelper::validatePostFields(array('displayLabel'))) {
			$displayName = ContentHelper::handleContentInput($_POST['displayLabel']);
			$referral->updateReferral($code, $displayName);
			DooUriRouter::redirect(MainHelper::site_url('referral'));
            return FALSE;
		}

		$list['referrer'] = $referrer;
		$list['infoBox'] = MainHelper::loadInfoBox('Referral', 'index', true);
		$data['title'] = $this->__('Referral');
        $data['body_class'] = 'index_referral';
        $data['selected_menu'] = 'players';
        $data['left'] = PlayerHelper::playerLeftSide('affiliate');
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('referral/manageReferralCode', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
	}

	public function codesBanners() {
		if(!isset($this->params['code']) or intval($this->params['code']) <= 9999) {
			DooUriRouter::redirect(MainHelper::site_url('referral'));
            return FALSE;
		}

		$referral = new Referral();
		$code = intval($this->params['code']);
		$referrer = $referral->getByCode($code);
		$player = User::getUser();
		$list = array();

		if(!$player or $player->ID_PLAYER != $referrer->ID_REFERRER or $player->isReferrer != 1) {
			DooUriRouter::redirect(MainHelper::site_url('referral'));
            return FALSE;
		}

		$list['referrer'] = $referrer;
		$list['infoBox'] = MainHelper::loadInfoBox('Referral', 'codesBanners', true);
		$data['title'] = $this->__('Referral');
        $data['body_class'] = 'index_referral';
        $data['selected_menu'] = 'players';
        $data['left'] = PlayerHelper::playerLeftSide('affiliate');
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('referral/codes', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
	}

	public function createSubReferralCode() {
		$list = array();
		$referral = new Referral();
		$player = User::getUser();
		if(!$player or $player->isReferrer != 1) {
			 DooUriRouter::redirect(MainHelper::site_url());
			 return false;
		}
		if($player->canCreateReferrers != 1) {
			 DooUriRouter::redirect(MainHelper::site_url('referral'));
			 return false;
		}

		if(isset($_POST) and !empty($_POST) and MainHelper::validatePostFields(array('displayLabel', 'user', 'commision'))) {
			$displayName = ContentHelper::handleContentInput($_POST['displayLabel']);
			$email = ContentHelper::handleContentInput($_POST['user']);
			$commision = intval($_POST['commision']);
			$referer = $referral->createSubReferral($player, $displayName, $email, $commision);
			if($referer instanceof SnReferrers) {
				DooUriRouter::redirect(MainHelper::site_url('referral'));
				return FALSE;
			}
			$referrer = new SnReferrers;
			$referrer->EMail = $email;
			$referrer->DisplayName = $displayName;
			$referrer->Commision = $commision;
			$list['referrer'] = $referrer;
			$list['error'] = $this->__('This user is already a referrer. Please assign this code to another user.');
		}
		$list['manager'] = $referral->getByReferrer($player->ID_PLAYER);
		$list['infoBox'] = MainHelper::loadInfoBox('Referral', 'createSubReferral', true);
		$data['title'] = $this->__('Referral');
        $data['body_class'] = 'index_referral';
        $data['selected_menu'] = 'players';
        $data['left'] = PlayerHelper::playerLeftSide('affiliate');
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('referral/manageSubReferrals', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
	}

	public function editSubReferralCode() {
		if(!isset($this->params['code']) or intval($this->params['code']) <= 9999) {
			DooUriRouter::redirect(MainHelper::site_url('referral'));
            return FALSE;
		}
		$referral = new Referral();

		$code = intval($this->params['code']);
		$referrer = $referral->getByCode($code);
		$player = User::getUser();
		$list = array();

		if(!$player or !$referrer or $player->ID_PLAYER != $referrer->ID_PARENT or $player->isReferrer != 1) {
			DooUriRouter::redirect(MainHelper::site_url('referral'));
            return FALSE;
		}
		if($player->canCreateReferrers != 1) {
			 DooUriRouter::redirect(MainHelper::site_url('referral'));
			 return false;
		}

		if(isset($_POST) and !empty($_POST) and MainHelper::validatePostFields(array('displayLabel', 'user', 'commision'))) {
			$displayName = ContentHelper::handleContentInput($_POST['displayLabel']);
			$email = ContentHelper::handleContentInput($_POST['user']);
			$commision = intval($_POST['commision']);
			$referer = $referral->updateSubReferral($code, $displayName, $email, $commision);
			if($referer != false) {
				DooUriRouter::redirect(MainHelper::site_url('referral'));
				return FALSE;
			}
			$referrer = new SnReferrers;
			$referrer->EMail = $email;
			$referrer->DisplayName = $displayName;
			$referrer->Commision = $commision;
			$list['referrer'] = $referrer;
			$list['error'] = true;
		}
		$list['manager'] = $referral->getByReferrer($player->ID_PLAYER);
		$list['referrer'] = $referrer;
		$list['infoBox'] = MainHelper::loadInfoBox('Referral', 'createSubReferral', true);
		$data['title'] = $this->__('Referral');
        $data['body_class'] = 'index_referral';
        $data['selected_menu'] = 'players';
        $data['left'] = PlayerHelper::playerLeftSide('affiliate');
        $data['right'] = PlayerHelper::playerRightSide();
        $data['content'] = $this->renderBlock('referral/manageSubReferrals', $list);
        $data['footer'] = MainHelper::bottomMenu();
        $data['header'] = MainHelper::topMenu();
        $this->render3Cols($data);
	}

	public function cancelReferral() {
		if(!isset($this->params['code']) or intval($this->params['code']) <= 9999 or !isset($this->params['email'])) {
			DooUriRouter::redirect(MainHelper::site_url());
            return FALSE;
		}

		$email = base64_decode($this->params['email']);
		$code = intval($this->params['code']);

		$referal = new Referral();
		$referal->cancelReferal($code, $email);
	}
}
