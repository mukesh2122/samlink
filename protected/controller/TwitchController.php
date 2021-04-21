<?php
class TwitchController extends SnController {

    public function beforeRun($resource, $action) {
		parent::beforeRun($resource, $action);
	}

    public function twitchLogin() {
        if(!Auth::isUserLogged()) { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };
        if(!isset($_SESSION['twitch_state'])) { $_SESSION['twitch_state'] = md5(rand()); };
        if(!empty($_SERVER['SERVER_NAME'])) { $server = $_SERVER['SERVER_NAME']; }
        else if (!empty($_SERVER['HTTP_HOST'])) { $server = $_SERVER['HTTP_HOST']; }
        else if (!empty($_SERVER['HOST_NAME'])) { $server = $_SERVER['HOST_NAME']; }
        else if (!empty($_SERVER['SERVER_SITE'])) { $server = $_SERVER['SERVER_SITE']; };
        switch($server) {
            case 'playnation.eu':
                $twitchID = Doo::conf()->twitch_id_login;
                $twitchSec = Doo::conf()->twitch_secret_login;
//                $url = 'http://' . $server . ;
                break;
            case 'playnation.eu/beta':
                $twitchID = Doo::conf()->twitch_id_beta_login;
                $twitchSec = Doo::conf()->twitch_secret_beta_login;
//                $url = ;
                break;
            case 'beta.playnation.eu':
                $twitchID = Doo::conf()->twitch_id_test_login;
                $twitchSec = Doo::conf()->twitch_secret_test_login;
//                $url = ;
                break;
            case 'localhost':
                $twitchID = Doo::conf()->twitch_id_local_login;
                $twitchSec = Doo::conf()->twitch_secret_local_login;
//                $url = ;
                break;
            default:
                $twitchID = NULL;
                $twitchSec = NULL;
//                $url = NULL;
        };
//        $devMode = (Doo::conf()->APP_MODE === 'dev') ? TRUE : FALSE;
//        $twitchID = ($devMode) ? Doo::conf()->twitch_id_local : Doo::conf()->twitch_id;
        if(empty($_REQUEST['code'])) {
            $loginURL = "https://api.twitch.tv/kraken/oauth2/authorize?response_type=code&state=" . $_SESSION['twitch_state'] . "&client_id=" . $twitchID . "&scope=user_read+channel_read+chat_login&redirect_uri=" . MainHelper::site_url('twitchlogin');
        } else {
            if($_SESSION['twitch_state'] !== $_REQUEST['state']) { return FALSE; };
//            $twitchSec = ($devMode) ? Doo::conf()->twitch_secret_local : Doo::conf()->twitch_secret;
            $params = "?client_id=" . $twitchID . "&client_secret=" . $twitchSec . "&grant_type=authorization_code&code=".$_REQUEST['code']."&redirect_uri=".MainHelper::site_url('twitchlogin');
            $response = TwitchTV::get_access_token($params);
            $_SESSION['twitch'] = array(
                'isOnline'      => TRUE,
                'accessToken'   => $response['access_token'],
                'user'          => TwitchTV::get_auth_user($response['access_token']),
            );
            $loginURL = MainHelper::site_url();
        };
        DooUriRouter::redirect($loginURL);
	}

	public function twitchLogout() {
        unset($_SESSION['twitch']);
        $ch = curl_init("http://www.twitch.tv/user/logout");
        curl_exec($ch);
        curl_close($ch);
        DooUriRouter::redirect(MainHelper::site_url($_SERVER['PHP_SELF']));
	}

	public function twitchRegister() {
        if(!Auth::isUserLogged()) { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };
        $user = User::getUser();
		$_POST['nickName'] = (isset($params['display_name'])) ? ContentHelper::handleContentInput($params['display_name']) : $user->DisplayName;
		$_POST['email'] = (isset($params['email'])) ? ContentHelper::handleContentInput($params['email']) : $user->EMail;
		$_POST['password'] = "playnationTest";
		$_POST['confirmPassword'] = "playnationTest";
		$_POST['terms'] = 1;
        $RegFunc = new PlayersController();
		$RegFunc->register();
	}

	public function twitchGetFeatured() {
        if(!Auth::isUserLogged()) { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };
		$result = TwitchTV::get_featured_streams();
		if($this->isAjax()) { $this->toJSON($result, TRUE); };
	}

	public function twitchGetFollowed() {
        if(!Auth::isUserLogged()) { DooUriRouter::redirect(MainHelper::site_url('login/loginfirst')); };
        if(!Auth::isUserOnTwitch()) { $this->twitchRegister(); };
        $result = TwitchTV::get_followed_streams($_SESSION['twitch']['accessToken']);
        if($this->isAjax()) { $this->toJSON($result, TRUE); };
	}
}
?>