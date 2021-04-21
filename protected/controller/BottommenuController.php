<?php
class BottommenuController extends SnController {
    private function showPhp() {
        ob_start();
        phpinfo();
        $info = ob_get_clean();
        echo "<pre>", print_r($info, TRUE), "</pre>";
        return TRUE;
    }

    private function showSession() {
//        echo "<pre>", highlight_string(print_r($_SESSION, TRUE), TRUE), "</pre>";
        $_SESSION['servername'] = array(
            'SERVER_NAME' => (empty($_SERVER['SERVER_NAME'])) ? '' : $_SERVER['SERVER_NAME'],
            'HTTP_HOST' => (empty($_SERVER['HTTP_HOST'])) ? '' : $_SERVER['HTTP_HOST'],
            'HOST_NAME' => (empty($_SERVER['HOST_NAME'])) ? '' : $_SERVER['HOST_NAME'],
            'SERVER_SITE' => (empty($_SERVER['SERVER_SITE'])) ? '' : $_SERVER['SERVER_SITE'],
        );
        $_SESSION['twitch_loginurl'] = MainHelper::site_url('twitchlogin');
        echo "<pre>", print_r($_SESSION, TRUE), "</pre>";
        return TRUE;
    }

    public function index() {
        if(Auth::isUserLogged() && Auth::isUserDeveloper() && isset($this->params['action'])) {
            $input = $this->params["action"];
            switch($input) {
                case "showphpinfo":
                    $this->showPhp();
                    break;
                case "showsession":
                    $this->showSession();
                    break;
                default:
                    echo "Wrong request type!";
            };
        } else { echo "Request not valid!"; };
        return TRUE;
    }

	public function menupop() {
	    if($this->isAjax()) {
    		$data["bottommenupop"] = Doo::db()->find("DynMenu",
        		array("select" => "menu_url,menu_titel,menu_text",
        		"where" => "menu_url = ?",
        		"param" => array($this->params["menu_url"])
    		));
    		echo $this->renderBlock("menu/menupop", $data);
	    };
	}
}
?>