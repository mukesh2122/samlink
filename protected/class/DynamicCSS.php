<?php
	class DynamicCSS {
		private $files = false;
		private $post  = false;
		private $urlValue = '';
		private $folderCss = 'global/css/';
		private $headerHome = 'admin/setup/layout/css';

		function __construct() {
			$this->urlValue = filter_input(INPUT_SERVER, "REQUEST_URI");
		}
		
		public function action($action, $id){
			switch($action){
				case 'deleteCss':
					self::deleteCss($id);
					break;
				case 'downloadCssCompanies':
					self::downloadFile($this->folderCss.'defaultCssCompanies.css');
					break;
				case 'downloadCssGames':
					self::downloadFile($this->folderCss.'defaultCssGames.css');
					break;
				case 'downloadCustomCss':
					self::downloadCustomCss($id);
					break;
				case 'uploadCss':
					self::uploadCss();
					break;
			}
		}
		
		public function deleteCss($id){
			$file = self::getCssFileById($id);
			if (!empty($file->Path) && file_exists($this->folderCss.$file->Path)){
				unlink($this->folderCss.$file->Path);
			}
			$cssFNmodel = new CssFilename;
			$cssFNmodel->ID_FILENAME = $id;
			Doo::db()->delete($cssFNmodel);
			header('Location: '.Mainhelper::site_url($this->headerHome));
			exit;
		}
		
		public function downloadCustomCss($id){
			$file = Doo::db()->getone('CssFilename', array('where' => 'ID_FILENAME = '.$id));
			self::downloadFile($this->folderCss.$file->Path);
		}
		
		public function downloadFile($file){
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename($file));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: '.filesize($file));
			ob_clean();
			flush();
			readfile($file);
			exit;
		}

		private function filesError() {
			$error = false;
			switch(true) {
				case (empty($this->files['name'])):          // no file name entered
					$error = 'fileempty';
					break;
				case (self::isDuplicateFile()):              // file used in another entry
					$error = 'fileduplicate';
					break;
				case ($this->files['type'] != 'text/css'):   // wrong file type
					$error = 'filetype';
					break;
				case ($this->files['error'] != 0):           // other file error
					$error = 'fileerror';
					break;
			}
			if (!empty($error)) {
				$_SESSION['cssedit']['description'] = isset($this->post['description']) ? $this->post['description'] : '';
				$_SESSION['cssedit']['type']        = isset($this->post['type']) ? $this->post['type'] : '';
				$_SESSION['cssedit']['error']       = $error;
				header('Location: '.MainHelper::site_url($this->headerHome.'/edit/'.$this->post['id']));
				exit;
			}
			return false;
		}
		
		public function getCustomCss($fileType, $name){
			$dynamicCss = Doo::db()->getone('CssFilename', array('where' => 'Filetype = "'.$fileType.'" AND FilenameDesc = "'.$name.'"'));
			if (!empty($dynamicCss)){
				return Doo::conf()->APP_URL.$this->folderCss.$dynamicCss->Path;
			}
			return false;
		}
	
		public function getCssFileById($id) {
			return Doo::db()->getone('CssFilename', array('where' => 'ID_FILENAME = '.$id));
		}
		
		public function getCssFiles($limit = 5, $sortType = '', $sortDir = 'desc') {
			$orderBy = '';
			switch ($sortType) {
				case 'description':
					$orderBy = 'FilenameDesc';
					break;
				case 'filename':
					$orderBy = 'Path';
					break;
				case 'filetype':
					$orderBy = 'Filetype';
					break;
				default:
					$orderBy = 'ID_FILENAME';
			}
			$opt = array(
				'limit' => $limit
			,	"{$sortDir}" => "{$orderBy}"
			);
			return Doo::db()->find('CssFilename', $opt);
		}
		
		public function getDefaultCss() {
			switch(TRUE){
				case (self::urlMatch("/game/")):
				case (self::urlMatch("games")):
					$cssPath = "defaultCssGames";
					break;
				case (self::urlMatch("/company/")):
				case (self::urlmatch("companies")):
					$cssPath = "defaultCssCompanies";
					break;
				case (self::urlMatch("/group/")):
				case (self::urlMatch("/groups")):
					$cssPath = "css_groups";
					break;
				case (self::urlMatch("/news")):
					$cssPath = "css_news";
					break;
				case (self::urlMatch("/event/")):
				case (self::urlMatch("/events")):
					$cssPath = "css_events";
					break;
				case (self::urlMatch("/recruitment2")):
				case (self::urlMatch("/recruitment2/")):
					$cssPath = "css_recruitment";
					break;
				default: 
					$cssPath = "defaultNewCss";
			};
			$cssUrl = Doo::conf()->APP_URL.'global/css/'.$cssPath.'.css';
			$cssFile = Doo::conf()->SITE_PATH.'global/css/'.$cssPath.'.css';
			if (file_exists($cssFile)) {
				return $cssUrl;
			};
			return false;
		}
		
		public function getFileTypes() {
			$cssFNmodel = new CssFilename;
			$enum = Doo::db()->query('SHOW COLUMNS FROM '.$cssFNmodel->_table.' WHERE Field = "Filetype"')->fetchAll()[0]['Type'];
			preg_match_all('/\'(\w+)\'/', $enum, $matches);
			return $matches[1];
		}
	
		private function isDuplicateFile() {
			$cssFNmodel = new CssFilename;
			return $cssFNmodel->count(array('where' => 'Path = "'.$this->files['name'].'" AND ID_FILENAME != '.$this->post['id'])) > 0;
		}
		
		private function isDuplicateDescription() {
			$cssFNmodel = new CssFilename;
			return $cssFNmodel->count(array('where' => 'FilenameDesc = "'.$this->post['description'].'" AND ID_FILENAME != '.$this->post['id'])) > 0;
		}
		
		private function isValidFileType() {
			return in_array($this->post['type'], self::getFileTypes());
		}
		
		private function postError() {
			$error = false;
			switch(true) {
				case (!(isset($this->post['id']) && strlen($this->post['id']) > 0)):   // no id defined
					$error = 'noid';
					break;
				case (empty($this->post['description'])):   // description not defined
					$error = 'descempty';
					break;
				case (self::isDuplicateDescription()):      // description used in other entry
					$error = 'descduplicate';
					break;
				case (!self::isValidFileType()):             // not correct file type
					$error = 'posttype';
					break;
			}
			if (!empty($error)) {
				if ($error == 'noid') {   // return to main page
					header('Location: '.MainHelper::site_url($this->headerHome));
					exit;
				}
				else {                    // return to edit page
					$_SESSION['cssedit']['description'] = isset($this->post['description']) ? $this->post['description'] : '';
					$_SESSION['cssedit']['type']        = isset($this->post['type']) ? $this->post['type'] : '';
					$_SESSION['cssedit']['error']       = $error;
					header('Location: '.MainHelper::site_url($this->headerHome.'/edit/'.$this->post['id']));
					exit;
				}
			}
			return false;
		}
		
		public function uploadCss(){
			$filter = array(
				'id'          => FILTER_VALIDATE_INT
			,	'description' => array(
					'filter'  => FILTER_SANITIZE_STRING
				,	'flags'   => FILTER_FLAG_ENCODE_LOW | FILTER_FLAG_ENCODE_HIGH
				)
			,	'type'        => array(
					'filter'  => FILTER_SANITIZE_STRING
				,	'flags'   => FILTER_FLAG_ENCODE_LOW | FILTER_FLAG_ENCODE_HIGH
				)
			,	'uploadCss'   => array(
					'filter'  => FILTER_SANITIZE_STRING
				,	'flags'   => FILTER_FLAG_ENCODE_LOW | FILTER_FLAG_ENCODE_HIGH
				)
			);
			$this->post = filter_input_array(INPUT_POST, $filter);
			$this->files = !empty($_FILES['uploadFileCss']) ? $_FILES['uploadFileCss'] : false;
			$this->files['name'] = str_replace(array(' ', ','), array('-', ''), $this->files['name']);
			if (!self::postError()) {
				if (!file_exists($this->folderCss)) {   // prepare upload folder if not exist
					mkdir($this->folderCss, 0777, true);
				}
				if ($this->post['id'] == 0) {   // add new css
					if (!self::filesError()) {
						move_uploaded_file($this->files['tmp_name'], $this->folderCss.$this->files['name']);
						$cssFNmodel = new CssFilename;
						$cssFNmodel->Path = $this->files['name'];
						$cssFNmodel->FilenameDesc = $this->post['description'];
						$cssFNmodel->Filetype = $this->post['type'];
						$cssFNmodel->insert();
					}
				}
				else {                    // edit existing css
					if (!empty($this->files['name']) && !self::filesError()) {   // upload if new file is given
						$file = self::getCssFileById($this->post['id']);
						if (file_exists($this->folderCss.$file->Path)){          // delete old file if exist
							unlink($this->folderCss.$file->Path);
						}
						move_uploaded_file($this->files['tmp_name'], $this->folderCss.$this->files['name']);
					}
					$cssFNmodel = new CssFilename;
					$cssFNmodel->ID_FILENAME = $this->post['id'];
					if (!empty($this->files['name'])) {
						$cssFNmodel->Path = $this->files['name'];
					}
					$cssFNmodel->FilenameDesc = $this->post['description'];
					$cssFNmodel->Filetype = $this->post['type'];
					$cssFNmodel->update();
				}
			}
			header('Location: '.Mainhelper::site_url($this->headerHome));
			exit;
		}

		private function urlMatch($input) {
			return (FALSE !== stripos($this->urlValue, $input)) ? TRUE : FALSE;
		}
		
	}
?>
