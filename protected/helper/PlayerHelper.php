<?php
class PlayerHelper {

	/**
	 * Renders players left side
	 *
	 * @param String $selectedMenuItem
	 * @return String
	 */
	public static function playerLeftSide($selectedMenuItem = '', $friendURL = '', $siteArea="")
	{
		$profile = '';
		if(Auth::isUserLogged() === TRUE)
		{
			$profile = self::playerLogged($selectedMenuItem, $friendURL, false, $siteArea);
		} else {
			$profile = self::playerNotLogged($friendURL, $siteArea);
		}

		return $profile;
	}

	/**
	 * Renders players right side
	 *
	 * @param String $selectedMenuItem
	 * @return String
	 */
	public static function playerRightSide($list = array())
	{
		Doo::loadController('SnController');
		$snController = new SnController();
		$sitePath = Doo::conf()->SITE_PATH;
		$return = '';

		if(Auth::isUserLogged() === TRUE)
		{
			$player = User::getUser();

			$return .= $snController->renderBlock('sidebar/logout', array('player' => $player));
			$reguserFunctions = MainHelper::GetModuleFunctionsByTag('reguser');

			$widgetsList = MainHelper::getWidgetsList($player->ID_PLAYER);

			foreach ($widgetsList as $widget) {
				if ($player && $widget['isVisible'] == 1) {
					$wName = str_replace(" ", "_", strtolower($widget['Name']));

					$return .= $snController->renderBlock('sidebar/widgets/' . $wName, array(
						'player' => $player,
						'widgetName' => $widget['Name'],
						'widgetId' => $widget['ID_WIDGET'],
						'isOpen' => $widget['isOpen']
						)
					);
				}
			}
		} else {
			$tmhOAuth = new tmhOAuth(array(
				'consumer_key'    => Doo::conf()->twitter_key,
				'consumer_secret' => Doo::conf()->twitter_secret,
				));

			$here = MainHelper::site_url('twitter');

			$params = array('oauth_callback' => $here);

			$code = $tmhOAuth->request('POST', $tmhOAuth->url('oauth/request_token', ''), $params);

			if ($code == 200)
			{
				$_SESSION['oauth'] = $tmhOAuth->extract_params($tmhOAuth->response['response']);
				$method = 'authenticate';
				$force  = '';
				$authurl = $tmhOAuth->url("oauth/{$method}", '') . "?oauth_token={$_SESSION['oauth']['oauth_token']}{$force}";

				// $return .= $snController->renderBlock('sidebar/register', array('twitter' => $authurl));
			}

			$return .= $snController->renderBlock('sidebar/widgets/rss', array());
		}

		$isEnabledNews = MainHelper::IsModuleEnabledByID(1);
		if ($isEnabledNews == 1)
		{
			$news = new News();
//			$return .= $snController->renderBlock('sidebar/topNews', array('topNews' => $news->getTopNews()));
		}

		if (isset($list['showEvents']) && $list['showEvents']) //&& $widget['isVisible'] == 1
		{
			// $return .= $snController->renderBlock('sidebar/upcommingEvent', array('event' => Event::getClosest()));
		}

		// $return .= $snController->renderBlock('sidebar/promotion', array());
		$return .= $snController->renderBlock('sidebar/advertisement', array());

		return $return;
	}

	/**
	 * Shows not logged user info (mainly registration)
	 *
	 * @return String
	 */
	public static function playerNotLogged($friendURL, $siteArea = "")
	{
		Doo::loadController('SnController');
		$snController = new SnController();

		$returnString = '';
		if($friendURL != '')
		{
			$p = User::getUser();
			$profile['player'] = $p;

			$f = User::getFriend($friendURL);
			$profile['friend'] = $f;
			if($siteArea == "blog") {
				$blog = new Blog();
				$blogDesc = $blog->getBlogDescriptionByUser($f->ID_PLAYER);
				$profile['blogDesc'] = $blogDesc;
			}
			$returnString .= $snController->renderBlock('players/friendProfile', $profile);
		}
		return $returnString;
	}

	/**
	 * Makes actions for logged user left side
	 *
	 * @param String $selectedMenuItem
	 * @return String
	 */
	public static function playerLogged($selectedMenuItem, $friendURL, $hideMenu = false, $siteArea = "")
	{
		Doo::loadController('SnController');
		$return = '';
		$snController = new SnController();
		$p = User::getUser();
		$profile['selected'] = $selectedMenuItem;
		$profile['player'] = $p;

		if($friendURL != '')
		{
			$f = User::getFriend($friendURL);
			$profile['friend'] = $f;
			if($siteArea == "blog" && $f->ID_PLAYER!=$p->ID_PLAYER)
			{
				$blog = new Blog();
				$blogDesc = $blog->getBlogDescriptionByUser($f->ID_PLAYER);
				$profile['blogDesc'] = $blogDesc;
			}
			$return = $snController->renderBlock('players/friendProfile', $profile);
		} else {
			if($hideMenu == TRUE)
			{
				$profile['hideMenu'] = true;
			}
			$return = $snController->renderBlock('players/personalProfile', $profile);
		}
		return $return;
	}

	/**
	 * Calculates age by given date
	 *
	 * @param String $date
	 * @return int|String
	 */
	public static function calculateAge($date)
	{
		if($date == '0000-00-00')
		{
			return "-";
		}

		list($BirthYear,$BirthMonth,$BirthDay) = explode("-", $date);
		$YearDiff = date("Y") - $BirthYear;
		$MonthDiff = date("m") - $BirthMonth;
		$DayDiff = date("d") - $BirthDay;

		// If the birthday has not occured this year
		if ($MonthDiff < 0 || ($MonthDiff < 0 && $DayDiff < 0))
		  $YearDiff--;

		return $YearDiff > 0 ? $YearDiff : '-';
	}

	/**
	 * Shows country name by ISO
	 *
	 * @param String $c
	 * @return String
	 */
	public static function getCountry($c)
	{
		$country = '-';
		if($c)
		{
			$list = new GeCountries();
			$list->A2 = $c;
			$country = $list->getOne();

			if($country)
			{
				$country = $country->Country;
			}
		}
		return ucfirst(strtolower($country));
	}

	/**
	 * Returns player location in more readable format
	 * @param type $player
	 * @return String
	 */
	public static function getLocation($player)
	{
		if($player->City != '' and $player->Country != '')
		{
			return $player->City.', '.PlayerHelper::getCountry($player->Country);
		} else if($player->Country != '') {
			return PlayerHelper::getCountry($player->Country);
		}

		return false;
	}


	/**
	 * Returns name of player
	 * @param Player $p
	 * @return String
	 */
	public static function showName($p) {
		$string = '';
		if(!empty($p->DisplayName)) {
			$string = $p->DisplayName;
		} else {
            if(!empty($p->FirstName)) {
                $string = $p->FirstName;
                if(!empty($p->LastName)) {
                    $string .= ' ' . $p->LastName;
                };
                if(!empty($p->NickName)) {
                    $string .= ' <small>('.trim($p->NickName).')</small>';
                };
            } else if(!empty($p->NickName)) {
                $string = $p->NickName;
            };
		};
		return htmlspecialchars($string);
//            if($p->FirstName && $p->LastName && $p->NickName) {
//				$string = $p->FirstName .' ' . $p->LastName .' <small>('.trim($p->NickName).')</small>';
//			} else if($p->FirstName && !$p->LastName && $p->NickName) {
//				$string = $p->FirstName .' <small>('.trim($p->NickName).')</small>';
//			} else if(!$p->FirstName && $p->NickName) {
//				$string = $p->NickName;
//			};
	}

	public static function showVoiceServiceUsername($p)
	{
		$string = 'playnation';
		$string .= $p->ID_PLAYER;

		return htmlspecialchars($string);
	}

	public static function DisplayRating($p)
	{
		$string = 'Rating: ';
		$string .= $p->SocialRating;

		return htmlspecialchars($string);
	}

    public static function DisplayVisits($p)
	{
		$string = 'Visits: ';
		$string .= $p->VisitCount;

		return htmlspecialchars($string);
	}


    public static function updateVisitCountPlayer($id)
	{
        $player = User::getUser(); // User who is visiting
        $user = User::getById($id); // User who is being visited

        $ID_LASTVISITOR = 0;
        $LastVisitorInfo = '';

        if (!$player) {
            if (!isset($_COOKIE['rv'])) {
                $LastVisitorInfo = session_id();
            } else {
                $LastVisitorInfo = $_COOKIE['rv'];
            }
        } else {
            $ID_LASTVISITOR = $player->ID_PLAYER;
            $LastVisitorInfo = $player->FirstName;
            }

        $user->ID_LASTVISITOR = $ID_LASTVISITOR;
        $user->LastVisitorInfo = $LastVisitorInfo;

        $user->update(array('field' => 'ID_LASTVISITOR,LastVisitorInfo'));

    }

	//returns rank of player in group
	public static function showRank($p)
	{
		$return = '-';

		if(isset($p->SnPlayerGroupRel) and isset($p->SnPlayerGroupRel[0]))
		{
			if($p->SnPlayerGroupRel[0]->isLeader == 1)
			{
				$return = 'Leader';
			} elseif($p->SnPlayerGroupRel[0]->isOfficer == 1)
			{
				$return = 'Officer';
			} elseif($p->SnPlayerGroupRel[0]->isMember == 1)
			{
				$return = 'Member';
			}
		} else if($p instanceof SnPlayerGroupRel)
		{
			if($p->isLeader == 1)
			{
				$return = 'Leader';
			} elseif($p->isOfficer == 1)
			{
				$return = 'Officer';
			} elseif($p->isMember == 1)
			{
				$return = 'Member';
			}
		}

		return $return;
	}

	public static function showRating($p, $enable = true)
	{
		Doo::loadController('SnController');
		$snController = new SnController();
		return $snController->renderBlock('players/common/rating', array('player' => $p, 'enabled' => $enable));
	}

	public static function emailExists($email)
	{
		$query = "SELECT COUNT(*) as cnt FROM sn_players WHERE EMail='$email'";
		$o = (object) Doo::db()->fetchRow($query);
		return $o->cnt;
	}

	public static function isValidAge($day, $month, $year) {
		$ageLimit = Layout::getActiveLayout('siteinfo_age_limit');
		if ($ageLimit->Value) {
			$birth = date_create($year.'-'.$month.'-'.$day);
			$now   = date_create('now');
			$age   = date_diff($birth, $now);
			if ($age->y < $ageLimit->Value) {
				return false;
			}
		}
		return true;
	}
	
	public static function isValidEmail($email)
	{
		// First, we check that there's one @ symbol,
		// and that the lengths are right.
		if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email))
		{
			// Email invalid because wrong number of characters
			// in one section or wrong number of @ symbols.
			return false;
		}
		// Split it into sections to make life easier
		$email_array = explode("@", $email);
		$local_array = explode(".", $email_array[0]);
		for ($i = 0; $i < sizeof($local_array); $i++)
		{
			if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&↪'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i]))
			{
				return false;
			}
		}
		// Check if domain is IP. If not,
		// it should be valid domain name
		if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1]))
		{
			$domain_array = explode(".", $email_array[1]);
			if (sizeof($domain_array) < 2)
			{
				return false; // Not enough parts to domain
			}
			for ($i = 0; $i < sizeof($domain_array); $i++)
			{
				if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|↪([A-Za-z0-9]+))$/", $domain_array[$i]))
				{
					return false;
				}
			}
		}

		return true;
	}

	public static function isValidNickName($nick)
	{
		$nick = trim($nick);
		if(strlen($nick) >= Doo::conf()->minNicknameLenght and strlen($nick) <= Doo::conf()->maxNicknameLenght)
		{
			return true;
		}
		return false;
	}

	public static function isValidPassword($pass)
	{
		if(strlen($pass) >= Doo::conf()->minPasswordLenght and strlen($pass) <= Doo::conf()->maxPasswordLenght)
		{
			return true;
		}
		return false;
	}

	public static function isDigits($element)
	{
		return !preg_match ("/[^0-9]/", $element);
	}


	/*
	* get the players signatur from the relation tables
	*/

	public static function getSignature($ownerType, $ID_OWNER, $ID_PLAYER){
		if($ownerType == 'company'){
			$query = "SELECT `Signature` FROM  sn_playercompany_rel WHERE  ID_COMPANY = $ID_OWNER  AND ID_PLAYER = $ID_PLAYER";
		}elseif ($ownerType == 'game') {
			$query = "SELECT `Signature` FROM  sn_playergame_rel WHERE  ID_GAME = $ID_OWNER  AND ID_PLAYER = $ID_PLAYER";
		}else{
			$query = "SELECT `Signature` FROM  sn_playergroup_rel WHERE  ID_GROUP = $ID_OWNER  AND ID_PLAYER = $ID_PLAYER";
		}

		Doo::db()->query($query);
		$signature = (object) Doo::db()->fetchRow($query);

		if(isset($signature->Signature) && !empty($signature->Signature))
			return $signature->Signature;
		
			return "";		
	}

	/*
	* gets the ForumSignatur from the sn_players table
	*/
	public static function getForumSignature($ownerType, $ID_OWNER, $ID_PLAYER){
		$player_signature = PlayerHelper::getSignature($ownerType, $ID_OWNER, $ID_PLAYER);
		
		if(empty($player_signature)){
			$query = "SELECT `ForumSignature` FROM  sn_players  WHERE ID_PLAYER = $ID_PLAYER";
			Doo::db()->query($query);
			$forum_signature = (object) Doo::db()->fetchRow($query);
			return $forum_signature->ForumSignature;
		}else{
			return $player_signature;
		}
	}



}
?>
