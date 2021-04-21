<?php

class AdminLayoutController extends AdminController {

	public function css() {
		$player = User::getUser();
		if($player->canAccess('Edit layout') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		} else {
			$dynCss = new DynamicCSS;
			$action = isset($this->params['action']) ? $this->params['action'] : '';
			$id = isset($this->params['id']) ? $this->params['id'] : 0;
			$sortType = isset($this->params['sortType']) ? $this->params['sortType'] : 'description';
			$sortDir = isset($this->params['sortDir']) ? $this->params['sortDir'] : 'asc';
			if (!empty($action)){
				$dynCss->action($action, $id);
			}
			$list = array();
			$cssFNmodel = new CssFilename;
			$cssRows = $cssFNmodel->count();
			$pager = $this->appendPagination($list, $cssFNmodel, $cssRows, Mainhelper::site_url('admin/setup/layout/css/page'), Doo::conf()->csspagelimit);
			$cssFiles = $dynCss->getCssFiles($pager->limit, $sortType, $sortDir);

			$list['sortType'] = $sortType;
			$list['sortDir'] = $sortDir;
			$list['cssFiles'] = $cssFiles;
			$list['imgFiles'] = Doo::db()->find('CssImagename', array('asc' => 'ID_IMG'));
			$data['title'] ='Stylesheet';
			$data['body_class'] = 'layout_general';
			$data['selected_menu'] = 'setup';
			$data['left'] = $this->renderBlock('setup/common/leftColumn');
			$data['right'] = $this->renderBlock('setup/layout/css_rightColumn');
			$data['content'] = $this->renderBlock('setup/layout/css', $list);
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = $this->getMenu();
			$this->render3Cols($data);
		}
	}

	public function cssEdit() {
		$player = User::getUser();
		if($player->canAccess('Edit layout') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		} else {
			$dynCss = new DynamicCSS;
			$id = isset($this->params['id']) ? $this->params['id'] : 0;
			$error = '';
			$cssFile = new CssFilename;
			if ($id > 0) {
				$cssFile = $dynCss->getCssFileById($id);
			}
			if (!empty($_SESSION['cssedit'])) {   // Reload dataset if returned with error
				$cssFile->FilenameDesc = $_SESSION['cssedit']['description'];
				$cssFile->Filetype     = $_SESSION['cssedit']['type'];
				$error = $_SESSION['cssedit']['error'];
				unset($_SESSION['cssedit']);
			}
			$list = array();
			$list['id'] = $id;
			$list['error'] = $error;
			$list['cssFile'] = $cssFile;
			$list['fileTypes'] = $dynCss->getFileTypes();
			$data['title'] ='Stylesheet';
			$data['body_class'] = 'layout_general';
			$data['selected_menu'] = 'setup';
			$data['left'] = $this->renderBlock('setup/common/leftColumn');
			$data['right'] = $this->renderBlock('setup/layout/css_rightColumn');
			$data['content'] = $this->renderBlock('setup/layout/css_edit', $list);
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = $this->getMenu();
			$this->render3Cols($data);
		}
	}
	
	public function cssImageManager() {
		$_SESSION['fmFileRoot'] = Doo::conf()->SITE_PATH.'global/img/'.FOLDER_DYNCSS.'/';
		$url = MainHelper::site_url('global/js/ckeditor4.3.3/Filemanager/index.html');
		DooUriRouter::redirect($url);
    }

	//current layout page
	public function currentLayout() {
		$layout = new Layout();

		$list = array();
		$list['layout'] = $layout->getCurrentLayout();

		$data['title'] ='Current layout';
		$data['body_class'] = 'current_layout';
		$data['selected_menu'] = 'setup';
		$data['left'] = $this->renderBlock('setup/common/leftColumn');
		$data['right'] = '';
		$data['content'] = $this->renderBlock('setup/layout/current_layout', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	//default layout page
	public function defaultLayout() {
		$layout = new Layout();

		$list = array();
		$list['layout'] = $layout->getDefaultLayout();

		$data['title'] ='Default layout';
		$data['body_class'] = 'default_layout';
		$data['selected_menu'] = 'setup';
		$data['left'] = $this->renderBlock('setup/common/leftColumn');
		$data['right'] = '';
		$data['content'] = $this->renderBlock('setup/layout/default_layout', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	public function header(){
		$layout = new Layout();

		$list = array();

		if(isset($_POST) && !empty($_POST) && isset($_POST['save_button'])){
			$layout->saveHeaderLayout($_POST);
			DooUriRouter::redirect(MainHelper::site_url('admin/setup/layout/header'));
		}
		else if(isset($_POST['reset_button'])){
			$layout->resetLayout('header');
			DooUriRouter::redirect(MainHelper::site_url('admin/setup/layout/header'));
		}

		$data['title'] ='Header';
		$data['body_class'] = 'layout_header';
		$data['selected_menu'] = 'setup';
		$data['left'] = $this->renderBlock('setup/common/leftColumn');
		$data['content'] = $this->renderBlock('setup/layout/header', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	public function links(){
		$list = array();

		$data['title'] ='Links';
		$data['body_class'] = 'layout_links';
		$data['selected_menu'] = 'setup';
		$data['left'] = $this->renderBlock('setup/common/leftColumn');
		$data['content'] = $this->renderBlock('setup/layout/links', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	public function footer(){
		$player = User::getUser();
		if($player->canAccess('Edit layout') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		} else {
			$layout = new Layout();

			$list = array();

			if(isset($_POST) && !empty($_POST) && isset($_POST['save_button'])){
				$layout->saveFooterLayout($_POST);
				DooUriRouter::redirect(MainHelper::site_url('admin/setup/layout/footer'));
			}
			else if(isset($_POST['reset_button'])){
				$layout->resetLayout('footer');
				DooUriRouter::redirect(MainHelper::site_url('admin/setup/layout/footer'));
			}

			$data['title'] ='Footer';
			$data['body_class'] = 'layout_footer';
			$data['selected_menu'] = 'setup';
			$data['left'] = $this->renderBlock('setup/common/leftColumn');
			$data['content'] = $this->renderBlock('setup/layout/footer', $list);
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = $this->getMenu();
			$this->render3Cols($data);
		}
	}

	public function topmenu(){
		$player = User::getUser();
		if($player->canAccess('Edit layout') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		} else {
			$layout = new Layout();

			$list = array();

			if(isset($_POST) && !empty($_POST) && isset($_POST['save_button'])){
				$layout->saveTopmenuLayout($_POST);
				DooUriRouter::redirect(MainHelper::site_url('admin/setup/layout/topmenu'));
			}
			else if(isset($_POST['reset_button'])){
				$layout->resetLayout('topmenu');
				DooUriRouter::redirect(MainHelper::site_url('admin/setup/layout/topmenu'));
			}
			
			$data['title'] ='Topmenu';
			$data['body_class'] = 'layout_topmenu';
			$data['selected_menu'] = 'setup';
			$data['left'] = $this->renderBlock('setup/common/leftColumn');
			$data['content'] = $this->renderBlock('setup/layout/topmenu', $list);
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = $this->getMenu();
			$this->render3Cols($data);
		}
	}

	public function general(){
		$player = User::getUser();
		if($player->canAccess('Edit layout') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		} else {
			$layout = new Layout();

			$list = array();

			if(isset($_POST) && !empty($_POST) && isset($_POST['save_button'])){
				$layout->saveGeneralLayout($_POST);
				DooUriRouter::redirect(MainHelper::site_url('admin/setup/layout/general'));
			}
			else if(isset($_POST['reset_button'])){
				$layout->resetLayout('general');
				DooUriRouter::redirect(MainHelper::site_url('admin/setup/layout/general'));
			}

			$data['title'] ='General';
			$data['body_class'] = 'layout_general';
			$data['selected_menu'] = 'setup';
			$data['left'] = $this->renderBlock('setup/common/leftColumn');
			$data['content'] = $this->renderBlock('setup/layout/general', $list);
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = $this->getMenu();
			$this->render3Cols($data);
		}
	}

	public function ajaxUploadBackground() {
		$player = User::getUser();
		if($player->canAccess('Edit layout') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		} else {
			$layout = new SyLayout();
			$image = new Image();
			$id = "";
			$result = $image->uploadImage(FOLDER_LAYOUT,'','',false);

			switch ($this->params['type']){
				case 'logo':
					$id = 'imageName_logo';
				break;
				default:
					$id = false;
				break;
			}

			if ($result['filename'] != '') {
					$layout->Value = ContentHelper::handleContentInput($result['filename']);
					$file = MainHelper::showImage($layout, THUMB_LIST_100x100, true, array('width', 'no_img' => 'noimage/no_games_100x100.png'));
					echo $this->toJSON(array('success' => TRUE, 'img' => $file, 'fileName' => $result['filename'], 'customID' => $id));
			} else {
					echo $this->toJSON(array('error' => $result['error']));
			}
		}
	}

	public function rightColumn() {
		$player = User::getUser();
		if($player->canAccess('Edit layout') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$list['widgets'] = MainHelper::getWidgetListAdmin();

		$data['title'] ='Right column (Widgets)';
		$data['body_class'] = 'layout_right_column';
		$data['selected_menu'] = 'setup';
		$data['left'] = $this->renderBlock('setup/common/leftColumn');
		$data['content'] = $this->renderBlock('setup/layout/right_column', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	public function newRightColumnWidget() {
		$player = User::getUser();
		if ($player->canAccess('New widget') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$layout = new Layout();

		if (isset($_POST) && !empty($_POST)) {
			$layout->newRightColumnWidget($_POST);
			DooUriRouter::redirect(MainHelper::site_url('admin/setup/layout/right-column'));
		}

		$data['title'] ='New widget';
		$data['body_class'] = 'layout_new_widget';
		$data['selected_menu'] = 'setup';
		$data['left'] = $this->renderBlock('setup/common/leftColumn');
		$data['content'] = $this->renderBlock('setup/layout/new_widget');
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	public function rightColumnEdit() {
		$player = User::getUser();
		if ($player->canAccess('Edit widgets') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$layout = new Layout();
		$widgetId = isset($this->params['widget_id']) ? $this->params['widget_id'] : 0;

		if (isset($_POST) && !empty($_POST)) {
			if (isset($_POST['widget_delete'])) {
				$layout->deleteRightColumnWidget($widgetId);
				DooUriRouter::redirect(MainHelper::site_url('admin/setup/layout/right-column'));
			}
			$layout->saveRightColumnWidget($_POST);
			DooUriRouter::redirect(MainHelper::site_url('admin/setup/layout/right-column'));
		}

		if ($widgetId == 0) {
			DooUriRouter::redirect(MainHelper::site_url('admin/setup/layout/right-column'));
		} else {
			$list['widget'] = MainHelper::getWidgetByID($widgetId);

			$data['title'] ='Edit widget';
			$data['body_class'] = 'layout_right_column_edit';
			$data['selected_menu'] = 'setup';
			$data['left'] = $this->renderBlock('setup/common/leftColumn');
			$data['content'] = $this->renderBlock('setup/layout/edit_widget', $list);
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = $this->getMenu();
			$this->render3Cols($data);
		}
	}
}
