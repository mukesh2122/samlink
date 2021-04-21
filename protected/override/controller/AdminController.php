<?php

class AdminController extends SnController {

    public function beforeRun($resource, $action) {

		//if not login, group = anonymous
        $role = (isset($_SESSION['user']['group'])) ? $_SESSION['user']['group'] : GROUP_ANONYMOUS;

        $user = User::getUser();
		
		if(!$user or $user->canAccess(array('Super Admin Interface', 'Partial Admin')) !== TRUE) {
			
			$pageURL1 = $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
			$pageURL2 = MainHelper::site_url('admin');
			$s1 = explode('/',$pageURL1);
			$s2 = explode('/',$pageURL2);
			$page1 = $s1[count($s1)-1];
			$page2 = $s2[count($s2)-1];

			//Go back to adminpage, if you aren't there already..
			if ($page1 != $page2)
				DooUriRouter::redirect(MainHelper::site_url('admin'));

			return FALSE;
		}
		if (Auth::isUserLogged() === FALSE) {
            $role = GROUP_ANONYMOUS;
        }
        //sets lang if nessecary
        Lang::getLang();
		
        if ($rs = $this->acl()->process($role, $resource, $action)) {
            return $rs;
        }
    }
	
	public function getMenu($parentID = 0) {
		$menu = Doo::db()->find('SyMenu', array(
				'asc' => 'Position',
				'where' => 'ID_PARENT = ? AND isAdmin = 1 AND isPublished = 1',
				'param' => array($parentID)
			));
		return $menu;;
	}

    //langs
//    public static function __($msg, $params=array()) {
//        $lang = Lang::getLang();
//        $translator = Doo::translator('Csv', Doo::conf()->SITE_PATH . 'protected/lang/admin/' . $lang . '/' . $lang . '.csv' /* ,array('cache' => 'apc', 'delimiter' => ';') */);
//        return $translator->translate($msg, $params);
//    }
	
	public function renderBlock($file, $data=NULL, $controller = NULL, $includeTagClass = FALSE) {
        return (string) $this->view()->renderBlock('admin/'.$file, $data, $controller, $includeTagClass);
    }
	
    public function render2ColsLeft($data = array()) {
        $this->view()->render('admin/template_2cols_left', $data);
    }
    
	public function render3Cols($data = array()) {
        $this->view()->render('admin/template', $data);
    }

}
