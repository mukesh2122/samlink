<?php

class LoginController extends SnController {

	public function moduleOff() {
		$notAvailable = MainHelper::TrySetModuleNotAvailableByTag('reguser');
		if($notAvailable) {
			$data['title'] = $this->__('All Players');
			$data['body_class'] = 'index_players';
			$data['selected_menu'] = 'players';
			$data['left'] = PlayerHelper::playerLeftSide();
			$data['right'] = PlayerHelper::playerRightSide();
			$data['content'] = $notAvailable;
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();
			$this->render3Cols($data);
			exit;
		};
	}

    public function loginFirst() {
		$this->moduleOff();
		if(Auth::isUserLogged()) { DooUriRouter::redirect(Doo::conf()->APP_URL); };

		$data['body_class'] = 'loginfirst_players';
		$data['title'] = $this->__('Login Required!');
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$data['content'] = $this->renderBlock('login/loginFirst');
		$this->render1Col($data);
	}

	public function ajaxRegister() {
        $tmpInput = filter_input_array(INPUT_GET);
        $playerExist = $maxGroup = $maxImg = $newID = $result = $refID = FALSE;
        if(empty($tmpInput)) {
            $return = $this->__("No data received");
        } else if(FALSE === $this->isAjax()) {
            $return = $this->__("Not an AJAX request");
        } else if($tmpInput['pass'] !== $tmpInput['confirm_pass']) {
            $return = $this->__("Passwords mismatch");
        } else if(FALSE === MainHelper::validateGetFields(array('nick', 'email', 'pass', 'confirm_pass', 'terms'))) {
            $return = $this->__("Not valid data in fields");
        } else if(FALSE === PlayerHelper::isValidEmail($tmpInput['email'])) {
            $return = $this->__("Email is not valid");
        } else if(FALSE === PlayerHelper::isValidNickName($tmpInput['nick'])) {
            $return = $this->__("Nickname is not valid");
        } else if(!empty($tmpInput['day']) && !empty($tmpInput['month']) && !empty($tmpInput['year']) && FALSE === PlayerHelper::isValidAge($tmpInput['day'], $tmpInput['month'], $tmpInput['year'])) {
			$ageLimit = Layout::getActiveLayout('siteinfo_age_limit');
            $return = $this->__("The age limit of this website is ".$ageLimit->Value.". Please return when you are old enough");
        } else if(!($tmpInput['terms'] == 1)) {
            $return = $this->__("You must accept the terms");
        } else {
            $player = new Players();
            $player->EMail = ContentHelper::handleContentInput($tmpInput['email']);
            $playerExist = $player->getOne();
            if(!empty($playerExist)) {
                $return = $this->__("Player already exists");
                $this->toJSON($return, TRUE);
                return FALSE;
            };
            if (!empty($tmpInput['day']) && !empty($tmpInput['month']) && !empty($tmpInput['year'])) {
                $player->DateOfBirth = $tmpInput['year'].'-'.$tmpInput['month'].'-'.$tmpInput['day'];
            }
            else {
                $player->DateOfBirth = date('Y-m-d');
            }
            $player->NickName = ContentHelper::handleContentInput($tmpInput['nick']);
            $player->Password = md5(md5($tmpInput['pass']));
            $player->VerificationCode = md5(md5(time() * microtime()) . md5($player->NickName . $player->Password));
            $player->OtherLanguages = 1;
            $maxGroup = $player->GroupLimit = MainHelper::GetSetting('GroupLimit','ValueInt');
            if(FALSE === $maxGroup) {
                $return = $this->__("Failed to retrieve max limit for groups");
                $this->toJSON($return, TRUE);
                return FALSE;
            };
            $maxImg = $player->ImageLimit = MainHelper::GetSetting('ImageLimit','ValueInt');
            if(FALSE === $maxImg) {
                $return = $this->__("Failed to retrieve max limit for images");
                $this->toJSON($return, TRUE);
                return FALSE;
            };

            $newID = $player->ID_PLAYER = $player->insert();
            if((FALSE === $newID) || !(is_numeric($newID))) {
                $return = $this->__("Failed to create player in database");
                $player->delete();
                $this->toJSON($return, TRUE);
                return FALSE;
            };

            $SnPrivacy = new SnPrivacy();
            if(FALSE === $SnPrivacy->CreateUserPrivacy($newID)) {
                $return = $this->__("Failed to create user privacy settings");
                $SnPrivacy->DeleteUserPrivacy($newID);
                $player->delete();
                $this->toJSON($return, TRUE);
                return FALSE;
            } else if(FALSE === MainHelper::CreatePersonalInformation($newID)) {
                $return = $this->__("Failed to create personal player information");
                MainHelper::DeletePersonalInformation($newID);
                $SnPrivacy->DeleteUserPrivacy($newID);
                $player->delete();
                $this->toJSON($return, TRUE);
                return FALSE;
            }else if(FALSE === MainHelper::CreateFriendCategoriesPlayer($newID)) {
                $return = $this->__("Failed to create player friends relations");
                MainHelper::DeleteFriendCategoriesPlayer($newID);
                MainHelper::DeletePersonalInformation($newID);
                $SnPrivacy->DeleteUserPrivacy($newID);
                $this->toJSON($return, TRUE);
                $player->delete();
                return FALSE;
            };

            $player->URL = md5($newID);
            if(0 === $player->update(array('field' => 'URL'))) {
                $return = $this->__("Failed to create player URL");
                MainHelper::DeleteFriendCategoriesPlayer($newID);
                MainHelper::DeletePersonalInformation($newID);
                $SnPrivacy->DeleteUserPrivacy($newID);
                $player->delete();
                $this->toJSON($return, TRUE);
                return FALSE;
            };

            $mail = new EmailNotifications();
			$approver = Layout::getActiveLayout('siteinfo_register_approver');
			if (!empty($approver)) {
				switch ($approver->Value) {
					case 'user':
						$return['result'] = $mail->registrationConfirmation($player);
						break;
					case 'admin':
						$return['result'] = $mail->registrationConfirmationAdmin($player);
						break;
					case 'none':
					default :
						$player->VerificationCode = '';   
						$player->update();
						$return['result'] = $mail->registrationSuccessful($player);
				}
			}
			else {
				$return['result'] = true;   // Force true if no approver
			}
            if(TRUE !== $return['result']) {
                $return = $this->__("ERROR : sending mail :\n") . $return['result'];
                MainHelper::DeleteFriendCategoriesPlayer($newID);
                MainHelper::DeletePersonalInformation($newID);
                $SnPrivacy->DeleteUserPrivacy($newID);
                $player->delete();
                $this->toJSON($return, TRUE);
                return FALSE;
            };

            $code = isset($tmpInput['referral_code']) ? $tmpInput['referral_code'] : 0;
            if($code > 9999) {
                $refID = Referral::registerAction($code, REFERRAL_SIGNUP, 0, $newID);
                if((FALSE === $refID) || (!is_numeric($refID))) {
                    // delete ref
                };
            };
        };
        $this->toJSON($return, TRUE);
    }

	public function registrationSuccessful() {
		$this->moduleOff();
		$creator = Layout::getActiveLayout('siteinfo_register_creator');
		$approver = Layout::getActiveLayout('siteinfo_register_approver');
		$data['title'] = $this->__('Registration successful');
		$data['body_class'] = 'index_registration_successful';
		$data['selected_menu'] = 'players';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		if (!empty($creator) && !empty($approver)) {
			switch (true) {
				case ($creator == 'user' && $approver == 'user'):
					$data['content'] = $this->renderBlock('login/regSuccUserCreatorUserApprover');
					break;
				case ($creator == 'user' && $approver == 'admin'):
					$data['content'] = $this->renderBlock('login/regSuccUserCreatorAdminApprover');
					break;
				case ($creator == 'user' && $approver == 'none'):
					$data['content'] = $this->renderBlock('login/regSuccUserCreatorNoApprover');
					break;
				case ($creator == 'admin' && $approver == 'user'):
					$data['content'] = $this->renderBlock('login/regSuccAdminCreatorUserApprover');
					break;
				case ($creator == 'admin' && $approver == 'admin'):
					$data['content'] = $this->renderBlock('login/regSuccAdminCreatorAdminApprover');
					break;
				case ($creator == 'admin' && $approver == 'none'):
					$data['content'] = $this->renderBlock('login/regSuccAdminCreatorNoApprover');
					break;
				default:
					$data['content'] = $this->renderBlock('login/regSuccUserCreatorUserApprover');
			}
		}
		else {
			$data['content'] = $this->renderBlock('login/regSuccUserCreatorUserApprover');
		}
		$data['content'] .= $this->renderBlock('login/fbCampaignScript');
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$this->render3Cols($data);
	}

	/**
	 * Activates user by given activation code
	 *
	 */
	public function activate() {
		$this->moduleOff();
		$code = isset($this->params['code']) ? $this->params['code'] : FALSE;
		if(FALSE === $code) { DooUriRouter::redirect(MainHelper::site_url()); };
		$auth = Auth::verifyByCode($code);
		if($auth === FALSE) { DooUriRouter::redirect(MainHelper::site_url()); };
		Referral::signUpBonus($auth->ID_PLAYER);

		$mail = new EmailNotifications();
		$mail->registrationSuccessful($auth);

		$data['selected_menu'] = 'players';
		$data['title'] = $this->__('Activation successful');
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('players/content/activate');
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$this->render3Cols($data);
	}

	/**
	 * Changes pass if code from email is correct
	 *
	 */
	public function resetPassword() {
		$this->moduleOff();

		$code = isset($this->params['code']) ? $this->params['code'] : FALSE;
        if(FALSE === $code) { DooUriRouter::redirect(MainHelper::site_url()); };
		$pass = Auth::changePassByCode($code);
		if($pass === FALSE) { DooUriRouter::redirect(MainHelper::site_url()); };

		$data['selected_menu'] = 'players';
		$data['title'] = $this->__('Password Reset');
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$result = array('pass' => $pass);
		$data['content'] = $this->renderBlock('login/resetPassword', $result);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$this->render3Cols($data);
	}

	public function twitterLogin() {
		$twitteroauth = new TwitterOAuth(
			Doo::conf()->twitter_key,
			Doo::conf()->twitter_secret
		);
		$request_token = $twitteroauth->getRequestToken('http://localhost/beta/index.php'); // why was it Beta and not beta ???
		$_SESSION['oauth_token'] = $request_token['oauth_token'];
		$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
		if($twitteroauth->http_code == 200) {
			$url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']);
			echo 'Location: ', $url;
			exit();
		};
		echo $this->__('TWITTER RESULT: ');
		exit();
	}

	public function verifyTwitter() {
        $input = filter_input(INPUT_GET, 'oauth_verifier');
		if(empty($input)){
			$tmhOAuth = new tmhOAuth(array(
				'consumer_key'    => Doo::conf()->twitter_key,
				'consumer_secret' => Doo::conf()->twitter_secret,
			));
			$tmhOAuth->config['user_token']  = $_SESSION['oauth']['oauth_token'];
			$tmhOAuth->config['user_secret'] = $_SESSION['oauth']['oauth_token_secret'];
			$code = $tmhOAuth->request('POST', $tmhOAuth->url('oauth/access_token', ''), array(
				'oauth_verifier' => $_REQUEST['oauth_verifier']
			));
			if($code == 200) {
				$_SESSION['access_token'] = $tmhOAuth->extract_params($tmhOAuth->response['response']);
				unset($_SESSION['oauth']);
				$usr = $this->getTwitterInfo();
				if($usr !== NULL){
                    if(Auth::logInTwitter($usr)) { DooUriRouter::redirect(MainHelper::site_url('players/wall')); };
				};
				DooUriRouter::redirect(MainHelper::site_url('registration'));
			};
		};
		DooUriRouter::redirect(MainHelper::site_url());
	}

    private function getTwitterInfo() {
		if(isset($_SESSION['access_token'])) {
			$tmhOAuth = new tmhOAuth(array(
				'consumer_key'	=> Doo::conf()->twitter_key,
				'consumer_secret' => Doo::conf()->twitter_secret,
			));
			$tmhOAuth->config['user_token']  = $_SESSION['access_token']['oauth_token'];
			$tmhOAuth->config['user_secret'] = $_SESSION['access_token']['oauth_token_secret'];
			$code = $tmhOAuth->request('GET', $tmhOAuth->url('1/account/verify_credentials'));
			if($code == 200) {
				return json_decode($tmhOAuth->response['response']);
			};
		};
		return NULL;
	}

	/**
	 * Returns login form
	 *
	 * @return JSON
	 */
	public function ajaxLoginBox() {
		if($this->isAjax()) {
			$tmhOAuth = new tmhOAuth(array(
				'consumer_key'    => Doo::conf()->twitter_key,
				'consumer_secret' => Doo::conf()->twitter_secret,
				));
			$here = MainHelper::site_url('twitter');
			$params = array('oauth_callback' => $here);
			$code = $tmhOAuth->request('POST', $tmhOAuth->url('oauth/request_token', ''), $params);
			if($code == 200) {
				$_SESSION['oauth'] = $tmhOAuth->extract_params($tmhOAuth->response['response']);
				$method = 'authenticate';
				$force  = '';
				$authurl = $tmhOAuth->url("oauth/{$method}", '') . "?oauth_token={$_SESSION['oauth']['oauth_token']}{$force}";
				$this->toJSON(array('content' => $this->renderBlock('players/ajaxLogin', array('twitter' => $authurl))), TRUE);
			} else { $this->toJSON(array('content' => $this->renderBlock('players/ajaxLogin', array())), TRUE); };
		};
	}

	/**
	 * Returns register form
	 *
	 * @return JSON
	 */
	public function ajaxRegisterBox() {
		if($this->isAjax()) { $this->toJSON(array('content' => $this->renderBlock('login/ajaxRegister')), TRUE); };
	}

	/**
	 * Returns forgot pass form
	 *
	 * @return JSON
	 */
	public function ajaxForgotPass() {
		if($this->isAjax()) { $this->toJSON(array('content' => $this->renderBlock('login/ajaxForgotPass')), TRUE); };
	}

	/**
	 * Manages password recovery
	 *
	 * @return JSON
	 */
	public function ajaxPassRecovery() {
		if($this->isAjax() && MainHelper::validateGetFields(array('mail'))) {
			$player = new Players();
			$player->EMail = filter_input(INPUT_GET, 'mail');
			$player = $player->getOne();
			$result['message'] = '';
			$result['result'] = FALSE;
			if($player) {
				$player->newPassRequest();
				$mail = new EmailNotifications();
				$mail->passwordReminder($player);
				$result['result'] = TRUE;
			} else { $result['message'] = $this->__('This e-mail does not exist in our system'); };
			$this->toJSON($result, TRUE);
		};
	}

	/**
	 * Validates users entered login information
	 *
	 * @return JSON
	 */
	public function ajaxLoginValidate() {
        $result = array();
        $result['message'] = $this->__('Not a valid AJAX request');
        $result['result'] = FALSE;
		if($this->isAjax()) {
			$result['result'] = Auth::logIn(filter_input_array(INPUT_GET));
			if($result['result'] === FALSE) { $result['message'] = $this->__('Incorrect e-mail or password'); }
			else {
				if(strpos($result['result'],'level3_') === 0) {
					$EndDate = str_replace('level3_','',$result['result']);
					$remainTime = MainHelper::GetRemainTime($EndDate);
					$result['message'] = $this->__('Your account has been suspended. [_1] day(s) and [_2] hour(s) remaining',array($remainTime->days,$remainTime->h));
					$result['result'] = FALSE;
				} else {
                    $result['message'] = '';
                    $result['result'] = TRUE;
                    $result['url'] = (empty($_SESSION['loginRedirect'])) ? MainHelper::site_url('players/wall') : $_SESSION['loginRedirect'];
                };
			};
        };
        header("Cache-Control: no-cache, must-revalidate");
        $this->toJSON($result, TRUE);
	}

	/**
	 * Logout action
	 *
	 */
	public function logout() {
		$_SESSION['loginRedirect'] = ''; // Make sure player is not redirected to previous URL when logged out properly
		Auth::logOut();
        header("Cache-Control: no-cache, must-revalidate");
		DooUriRouter::redirect(MainHelper::site_url());
	}

	/**
	 * Validates mails in registration if exists in system
	 *
	 * @return Bool
	 */
	public function validateMail() {
        $tmpInput = filter_input(INPUT_GET, 'email');
		if(!empty($tmpInput) && $this->isAjax()) {
            $rs = Doo::db()->find('Players', array('limit' => 1, 'param' => array($tmpInput), 'where' => 'EMail = ?'));
			$returnVal = (FALSE === $rs) ? TRUE : FALSE;
            $this->toJSON($returnVal, TRUE);
		};
	}

	public function registration() {
		$this->moduleOff();
		$player = User::getUser();
		if($player && !$player->canAccess('Site admin')) {
            header("Cache-Control: no-cache, must-revalidate");
			DooUriRouter::redirect(MainHelper::site_url('players/wall'));
			return FALSE;
		};

		$list = array();
		$ageLimit = Doo::db()->getOne('SyLayout', array('where' => 'Name = "siteinfo_age_limit" AND isActive = 1'));
		$list['age_limit'] = $ageLimit ? $ageLimit->Value : NULL;
		$list['email'] = isset($this->params['email']) ? urldecode($this->params['email']) : NULL;
        $list['code'] = isset($_SESSION['referringCode']) ? intval($_SESSION['referringCode']) : NULL;
        $list['twitter'] = $this->getTwitterInfo();

		$data['title'] = $this->__('Register on PlayNation');
		$data['body_class'] = 'index_register';
		$data['selected_menu'] = 'players';
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('login/registration', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

        header("Cache-Control: no-cache, must-revalidate");
		$this->render1Col($data);
	}

	public function signin() {
		$this->moduleOff();
		$player = User::getUser();
		if($player) {
			DooUriRouter::redirect(MainHelper::site_url('players/wall'));
			return FALSE;
		};
		$list = array();
		$data['title'] = $this->__('Sign in to PlayNation');
		$data['body_class'] = 'index_signin';
		$data['selected_menu'] = 'players';
		$data['content'] = $this->renderBlock('login/signin', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();

		$this->render1Col($data);
	}

//	public function twitchAuth() {
//		if(empty($_REQUEST['code'])) {
//			$loginURL = "https://api.twitch.tv/kraken/oauth2/authorize?response_type=code&client_id=".Doo::conf()->twitch_id."&redirect_uri=".MainHelper::site_url()."players/twitchlogin&scope=user_read+channel_read+user_follows_edit";
//			echo "<script>window.location='", $loginURL, "';</script>";
//		} else {
//			$params = "?client_id=".Doo::conf()->twitch_id."&client_secret=".Doo::conf()->twitch_secret."&grant_type=authorization_code&redirect_uri=".MainHelper::site_url()."players/twitchlogin&code=".$_REQUEST['code'];
//			$response = TwitchTV::get_access_token($params);
//			$_SESSION['twitch'] = array(
//				'isOnline'      => true,
//				'accessToken'   => $response['access_token']
//			);
//            header("Cache-Control: no-cache, must-revalidate");
//			DooUriRouter::redirect(MainHelper::site_url());
//		};
//	}
//
//	public function twitchLogin() {
//		if(!Auth::isUserLogged()) { $this->twitchRegister(); }
//        else { $this->twitchAuth(); };
//	}
//
//	public function twitchRegister() {
//		$this->twitchAuth();
//
//		$params = TwitchTV::get_auth_user($_SESSION['twitch']['access_token']);
//
//		$_GET['nickName'] = ContentHelper::handleContentInput($params['display_name']);
//		$_GET['email'] = ContentHelper::handleContentInput($params['email']);
//		$_GET['password'] = "playnationTest";
//		$_GET['confirmPassword'] = "playnationTest";
//		$_GET['terms'] = 1;
//
//		$this->register();
//	}

	public function fblogin() {
		$fb = new FacebookSDK(array(
			'appId' => Doo::conf()->fb_appid,
			'secret' => Doo::conf()->fb_secret
		));
		$user = $fb->getUser();
		if($user == 0) {
			$loginParams = array(
				'scope' => 'email, user_birthday, user_location',
				'display' => 'page'
			);
			$loginUrl = $fb->getLoginUrl($loginParams);
			//echo '<META HTTP-EQUIV="Refresh" Content="0; url='.urlencode($loginUrl).'">';
			//printf("<script>location.href='".$loginUrl."';</script>");
			//header("Location: ".urlencode($loginUrl), true);
			echo "<script>window.location='".$loginUrl."';</script>";
		} else {
			try {
				$profile = $fb->api('/me');
				if($profile) { $this->fbRegister($profile); }
                else{ return; };
			} catch(Exception $e) { echo($e->getMessage()); };
		};
	}

	public function twitterRegister() {
        if(MainHelper::validateGetFields(array('email', 'nickName', 'password', 'confirmPassword', 'terms'))
				&& PlayerHelper::isValidEmail($_GET['email'])
				&& PlayerHelper::isValidNickName($_GET['nickName'])
				&& $_GET['password'] == $_GET['confirmPassword']
				&& $_GET['terms'] == 1) {
			$player = new Players();
			$player->EMail = ContentHelper::handleContentInput($_GET['email']);
			$check = Doo::db()->find($player);
			if(!empty($check)) {
				DooUriRouter::redirect(MainHelper::site_url('registration'));
				return FALSE;
			};
			$twitter = $this->getTwitterInfo();
			if($twitter !== NULL) {
				$pl = new Players;
				$pl->TwitterID = $twitter->id;
				$pl = $pl->getOne();
				if(!empty($pl)) {
					DooUriRouter::redirect(MainHelper::site_url('registration'));
					return FALSE;
				};
				$player->TwitterID = $twitter->id;
				$player->FirstName = $twitter->name;
			};
			$player->NickName = ContentHelper::handleContentInput($_GET['nickName']);
			$player->Password = md5(md5($_GET['password']));
			$player->VerificationCode = md5(md5(time() * microtime()) . md5($player->NickName . $player->Password));
			$player->OtherLanguages = 1;
			$player->Address = '';
			$player->ID_PLAYER = $player->insert();
			$player->GroupLimit = MainHelper::GetSetting('GroupLimit', 'ValueInt', 1);
			$player->ImageLimit = MainHelper::GetSetting('ImageLimit', 'ValueInt', 100);
			$player->update(array('field' => 'GroupLimit'));
			$player->update(array('field' => 'ImageLimit'));
			$SnPrivacy = new SnPrivacy;
			$SnPrivacy->CreateUserPrivacy($player->ID_PLAYER);
			MainHelper::CreatePersonalInformation($player->ID_PLAYER);
			MainHelper::CreateFriendCategoriesPlayer($player->ID_PLAYER);
			$player->URL = md5($player->ID_PLAYER);
			$player->update(array('field' => 'URL'));
			$code = isset($_GET['referral_code']) ? $_GET['referral_code'] : 0;
            if($code == 0 && isset($_SESSION['referringCode'])) { $code = $_SESSION['referringCode']; };
			if($code > 9999) { Referral::registerAction($code, REFERRAL_SIGNUP, 0, $player->ID_PLAYER); };
			$mail = new EmailNotifications();
			$mail->registrationConfirmation($player);
			DooUriRouter::redirect(MainHelper::site_url('login/registration-successful'));
		} else {
			DooUriRouter::redirect(MainHelper::site_url('registration'));
			return FALSE;
		};
	}

	private function fbRegister($profile){
		$_GET['nickName'] = ContentHelper::handleContentInput($profile['first_name'].$profile['last_name']);
		$_GET['email'] = ContentHelper::handleContentInput($profile['email']);
		$_GET['password'] = "playnationTest";
		$_GET['confirmPassword'] = "playnationTest";
		$_GET['terms'] = 1;

		$this->register();
		/*
		$birthday = strtotime(ContentHelper::handleContentInput($profile['birthday']));   // user_birthday AT required
		$player = new Players();
		$player->EMail = ContentHelper::handleContentInput($profile['email']);            // email AT required
		//echo(PHP_EOL."MAIL: ".$player->EMail);
		//exit();
		$player->FirstName = ContentHelper::handleContentInput($profile['first_name']);   //No access_token required
		$player->LastName = ContentHelper::handleContentInput($profile['last_name']);     //No access_token required
		$player->NickName = ContentHelper::handleContentInput($profile['username']);      //No access_token required
		//$player->City = ContentHelper::handleContentInput($profile['location']['name']);  // user_location AT required
		$player->Gender = ucfirst(ContentHelper::handleContentInput($profile['gender'])); //No access_token required
		$player->DateOfBirth = date('Y-m-d', $birthday);
		$player->Password = md5(md5(microtime()-time()).$profile['first_name'].sha1($profile['last_name'].$profile['first_name']));
		//$player->VerificationCode = md5(md5(time() * microtime()) . md5($player->NickName . $player->Password));
		$player->ID_PLAYER = $player->insert();
		$player->GroupLimit = MainHelper::GetSetting('GroupLimit','ValueInt');
		$player->ImageLimit = MainHelper::GetSetting('ImageLimit','ValueInt');
		$player->update(array('field' => 'GroupLimit'));
		$player->update(array('field' => 'ImageLimit'));
		$SnPrivacy = new SnPrivacy;
		$SnPrivacy->CreateUserPrivacy($player->ID_PLAYER);
		MainHelper::CreatePersonalInformation($player->ID_PLAYER);
		MainHelper::CreateFriendCategoriesPlayer($player->ID_PLAYER);
		$player->URL = md5($player->ID_PLAYER);
		$player->update(array('field' => 'URL'));
		Auth::logInFb($profile);
		//$mail = new EmailNotifications();
		//$mail->registrationConfirmation($player);
		*/
	}
}
?>