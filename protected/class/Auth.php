<?php
class Auth {
    
    /**
     * Checks if user is logged in
     *
     * @return boolean
     */
    public static function isUserLogged() {
        if(!isset($_SESSION['user']['id']) or $_SESSION['user']['id'] <= 0 or !isset($_COOKIE['u'])) {
            return FALSE;
        }
		
		if(User::getUser() === false) {
			return FALSE;
		}
        
        return TRUE;
    }
    
    public static function isUserOnTwitch() {
        if(!isset($_SESSION['twitch'])){
            return FALSE;
        }
        return TRUE;
    }
    
    /**
     * Generates secure string
     *
     * @param Players $p
     * @return Array
     * @todo additional check with IP and PLAYER_ID
     */
    public static function generateSecure(Players $p) {
		
        static $check = array();
        if(isset($check['secure'])) {
            return $check;
        }
        
        $chars = "abcdefghijkmnopqrstuvwxyz023456789";
        srand((double)microtime()*1000000);
        $i = 0;
        $extra = '' ;
    
        while ($i <= 8) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $extra = $extra . $tmp;
            $i++;
        }
        $secure = sha1( microtime(true) + 
                        $p->ID_PLAYER + 
                        $_SERVER['REMOTE_ADDR'] + 
                        $extra + 
                        $_SERVER['HTTP_USER_AGENT']
                    );
        
        if($p->ID_USERGROUP != 0)
            setcookie('u', $secure, (time() + 3600 * 20), "/"); //timeout set to 20 hours for employees
        else
            setcookie('u', $secure, (time() + 3600), "/");
		
		$_COOKIE['u'] = $secure;
        $_SESSION['user']['group'] = GROUP_PLAYER;
        
        $p->Hash = $secure;
        $p->LastActivity = time();
        $p->isOnline = true;
        
        if(!isset($_SESSION['user']['id']) or $_SESSION['user']['id'] <= 0) {
            $_SESSION['user']['id'] = $p->ID_PLAYER;
			$_SESSION['user']['isSuperUser'] = $p->isSuperUser;
        }
		
        
        $p->update(array('field' => 'Hash,LastActivity,isOnline'));
        $p->purgeCache();
        return $check = array('secure' => $secure, 'player' => $p);
    }

    /**
     * Test if user suspend status must be rejected
     *
     * @return boolean
     */
	public static function TestSuspend($user)
	{
		//Return false if suspended level 3
		$sus = $user->getSuspendStatus();
		if ($sus!=null)
			if ($sus['Level']==3)
				return false;

		return true;
	}
    
    /**
     * Takes care of user login processes
     *
     * @param Array $params
     * @return boolean
     */
    public static function logIn($params) {
        if(!isset($params['email']) || !isset($params['pass'])) { return FALSE; };

        $player = new Players();
        $player->EMail = urldecode($params['email']);
        $player->Password = md5(md5($params['pass']));
        $player->purgeCache();
        $player = $player->getOne();
        if(!empty($player) && $player->VerificationCode == '') {
			$sus = $player->getSuspendStatus();
			if($sus !== NULL) {
				//Banned
                if($sus['Level'] == 5) { return FALSE; };
			};
			if(!self::TestSuspend($player) && $sus !== NULL) {
				//If no-access suspension
				$StartDate = $sus['StartDate'];
				//$durDays = MainHelper::GetDurdays($StartDate);
				//return "level3_".$durDays;
				$EndDate = $sus['EndDate'];
				return "level3_".$EndDate;
			} else {
				$_SESSION['user']['id'] = $player->ID_PLAYER;
				$_SESSION['user']['isSuperUser'] = $player->isSuperUser;
				session_regenerate_id(TRUE);
				self::generateSecure($player);
				//validates cart for free games or other changes
				Cart::validateCart($player);	
				return TRUE;
			};
        };
        return FALSE;
    }
	
    /**
     * Takes care of user facebook login processes
     *
     * @param Array $params
     * @return boolean
     */
    public static function logInFb($params) {
        if(!isset($params['email']))
            return FALSE;
         
        $player = new Players();
        $player->EMail = $params['email'];
//        $player->Password = md5(md5($params['pass']));
        $player->purgeCache();
        $player = $player->getOne();
        if(!empty($player) and $player->VerificationCode == '' && self::TestSuspend($player)) {
            $_SESSION['user']['id'] = $player->ID_PLAYER;
			$_SESSION['user']['isSuperUser'] = $player->isSuperUser;
			session_regenerate_id(true);
            self::generateSecure($player);
            return TRUE;
        }
        
        return FALSE;
    }
    
    public static function logInTwitter($user) {
        if(!isset($user->id))
            return FALSE;
         
        $player = new Players();
        $player->TwitterID = $user->id;
        $player->purgeCache();
        $player = $player->getOne();
        if(!empty($player) and $player->VerificationCode == '' && self::TestSuspend($player)) {
            $_SESSION['user']['id'] = $player->ID_PLAYER;
			$_SESSION['user']['isSuperUser'] = $player->isSuperUser;
			session_regenerate_id(true);
            self::generateSecure($player);
            return TRUE;
        }
        
        return FALSE;
    }
    
    /**
     * Takes care of user logout processes
     */
    public static function logOut($redirect = TRUE) {
        $player = new Players();
        if(isset($_SESSION['user']['id']) and $_SESSION['user']['id'] > 0) {
            $player->ID_PLAYER = $_SESSION['user']['id'];
        } else {
            $player->Hash = $_COOKIE['u'];
        }
        $p = Doo::db()->getOne($player);
        if(!empty($p)) {
            $p->Hash = null;
            $p->isOnline = 0;
            Doo::db()->update($p, array('setnulls' => true));
        }
        setcookie('u', null, time()-90000, '/');
        $_SESSION['user']['group'] = GROUP_ANONYMOUS;
        $_SESSION['user']['id'] = 0;
        $_SESSION['user']['isSuperUser'] = 0;
        unset($_SESSION['user']['id']);
		session_regenerate_id(TRUE);
    }
    
    /**
     * handles user activation by verify code
     * 
     * @param String $code
     * @return bool|Players
     */
    public static function verifyByCode($code) {
        $player = new Players();
        $player->VerificationCode = $code;
        $player = $player->getOne();
        
        if(empty($player))
            return FALSE;
        
        $player->VerificationCode = '';   
        $player->update(array('field' => 'VerificationCode'));
        
        return $player;
    }
    
    /**
     * handles user activation by verify code
     * 
     * @param String $code
     * @return bool|Players
     */
    public static function changePassByCode($code) {
        $player = new Players();
        $player->PassRequest = $code;
        $player = $player->getOne();
        
        if(empty($player))
            return FALSE;
            
        $chars = "abcdefghijkmnopqrstuvwxyz023456789";
        srand((double)microtime()*1000000);
        $i = 0;
        $pass = '' ;
    
        while ($i <= 8) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
        
        $player->PassRequest = '';   
        $player->Password = md5(md5($pass));   
        $player->update();
        
        return $pass;
    }
    
    public static function isUserDeveloper(){
        if(self::isUserLogged()){
            $player = User::getUser();
            return $player->isDeveloper();
        }   
        else return false;
    }
    
}
?>