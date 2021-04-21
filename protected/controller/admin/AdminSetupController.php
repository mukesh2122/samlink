<?php

class AdminSetupController extends AdminController {
    public function links(){
                $list = array();
        
                $data['title'] ='Links';
		$data['body_class'] = 'index_layout_links';
		$data['selected_menu'] = 'setup';
		$data['left'] = $this->renderBlock('setup/common/leftColumn');
		$data['content'] = $this->renderBlock('setup/layout/links', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
    }	
    /**
     * Main website
     *
     */
    public function index() {
		$player = User::getUser();
		if($player->canAccess('Setup') === FALSE && $player->canAccess('Edit layout') === TRUE) { DooUriRouter::redirect(MainHelper::site_url('admin/setup/layout/general')); };
		if($player->canAccess('Setup') === FALSE) { DooUriRouter::redirect(MainHelper::site_url('admin')); };

		$superadmin = $player->canAccess('*');
				
		$setup = new Setup();
		$modules = $setup->GetModules();

		//Update checkboxes
		if (!empty($_POST)) {
			$opt = array(
				'modules' => array(
					'filter'  => FILTER_VALIDATE_INT
				,	'flags'   => FILTER_REQUIRE_ARRAY
				)
			,	'functions' => array(
					'filter'  => FILTER_VALIDATE_INT
				,	'flags'   => FILTER_REQUIRE_ARRAY
				)
			);
			$post = filter_input_array(INPUT_POST, $opt);
			$modules = implode(',', $post['modules']);
			$functions = implode(',', $post['functions']);
			$syModules = new SyModules;
			$syModules->isEnabled = 0;
			$syModules->update(array('where' => 'ID_MODULE NOT IN ('.$modules.') AND isEnabled = 1'));
			$syModules->isEnabled = 1;
			$syModules->update(array('where' => 'ID_MODULE IN ('.$modules.') AND isEnabled = 0'));
			$syModules->purgeCache();
			$syModuleFunctions = new SyModuleFunctions;
			$syModuleFunctions->isEnabled = 0;
			$syModuleFunctions->update(array('where' => 'ID_MODFUNC NOT IN ('.$functions.') AND isEnabled = 1'));
			$syModuleFunctions->isEnabled = 1;
			$syModuleFunctions->update(array('where' => 'ID_MODFUNC IN ('.$functions.') AND isEnabled = 0'));
			$syModuleFunctions->purgeCache();
			$setup->UpdateModuleDependencies();
			//No double submit
			DooUriRouter::redirect(MainHelper::site_url('admin/setup'));
		}

//		if(isset($_POST) and !empty($_POST)) {
//			foreach($modules as $module) {
//				$ID_MODULE = $module['ID_MODULE'];
//				$isEnabled = 0;
//                foreach($_POST as $k => $v) { if($k == $ID_MODULE) { $isEnabled = $v; }; };
//
//				$query = "UPDATE sy_modules SET isEnabled=$isEnabled WHERE ID_MODULE=$ID_MODULE";
//				$rs = Doo::db()->query($query);
//
//				$setup->SetPublish($ID_MODULE, $isEnabled);
//
//				//$setup->UpdateFunctions($ID_MODULE);
//			};
//
//			$setup->UpdateModuleDependencies();
//
//			//No double submit
//			DooUriRouter::redirect(MainHelper::site_url('admin/setup'));
//		}

		$list = array();
		$list['mainpage'] = "setup";
		$list['modules'] = $modules;
		$list['superadmin'] = $superadmin;
        $list['player'] = $player;

		$data['title'] = 'Setup';
		$data['body_class'] = 'index_setup';
        $data['left'] = $this->renderBlock('setup/common/leftColumn');
		$data['selected_menu'] = 'setup';
		$data['content'] = $this->renderBlock('setup/index', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	public function editmodule() {
		$player = User::getUser();
		if($player->canAccess('Setup') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$superadmin = $player->canAccess('*');

		$setup = new Setup();

		if (!isset($this->params['ID_MODULE']) )
		{
			DooUriRouter::redirect(MainHelper::site_url('admin/setup'));
		}
		$ID_MODULE = $this->params['ID_MODULE'];
		$selected_module = $setup->GetModule($ID_MODULE);


		//Update editmodule page
		if(isset($_POST) and !empty($_POST)) 
		{
			//Normal submit action
			if (isset($_POST['ID_MODULE']) && $_POST['actionType'] == "submitform")
			{
				$ID_MODULE = $_POST['ID_MODULE'];
				$selected_module = $setup->GetModule($ID_MODULE);

				$ModuleName = $_POST['ModuleName'];
				$ModuleTitle = $_POST['ModuleTitle'];
				$ModuleDesc = $_POST['ModuleDesc'];

				$isEnabled = isset($_POST['isEnabled']) ? 1 : 0;
				$query = "UPDATE sy_modules SET 
					ModuleName='$ModuleName',
					ModuleTitle='$ModuleTitle',
					ModuleDesc='$ModuleDesc', 
					isEnabled=$isEnabled 
					WHERE ID_MODULE=$ID_MODULE";

				$rs = Doo::db()->query($query);

				$setup->SetPublish($ID_MODULE, $isEnabled);

				$setup->UpdateFunctions($ID_MODULE);
				$setup->UpdateFields($ID_MODULE);
				
				$setup->UpdateModuleDependencies();

				$setup->UpdateSettings($ID_MODULE);
				
				$setup->UpdateAvailability($ID_MODULE);
				
				//No double submit
				DooUriRouter::redirect(MainHelper::site_url('admin/setup'));
			}

			//Add extrafield action
			if (isset($_POST['ID_MODULE']) && $_POST['actionType'] == "addextrafield")
			{
				$setup->AddExtraField($selected_module['OwnerType'],$_POST['extrafieldname'],$_POST['extrafieldtype'],$_POST['extrafieldpriority']);
				DooUriRouter::redirect(MainHelper::site_url('admin/setup/editmodule/id/'.$selected_module['ID_MODULE']));
			}

			//Delete extrafield action
			if (isset($_POST['ID_MODULE']) && $_POST['actionType'] == "deleteextrafield")
			{
				$setup->DeleteExtraField($_POST['actionValue']);
				DooUriRouter::redirect(MainHelper::site_url('admin/setup/editmodule/id/'.$selected_module['ID_MODULE']));
			}
			
			//Add category action
			if (isset($_POST['ID_MODULE']) && $_POST['actionType'] == "addcategory")
			{
				$MBAenabled = isset($_POST['mbaenabled']) ? '1' : '0';
				$setup->AddCategory($selected_module['OwnerType'],$_POST['categoryname'],$MBAenabled);
				DooUriRouter::redirect(MainHelper::site_url('admin/setup/editmodule/id/'.$selected_module['ID_MODULE']));
			}

			//Delete category action
			if (isset($_POST['ID_MODULE']) && $_POST['actionType'] == "deletecategory")
			{
				$setup->DeleteCategory($_POST['actionValue']);
				DooUriRouter::redirect(MainHelper::site_url('admin/setup/editmodule/id/'.$selected_module['ID_MODULE']));
			}
		}
		
	
		$list['setup'] = $setup;
		$list['selected_module'] = $selected_module;
		$list['mainpage'] = "editmodule";
		$list['superadmin'] = $superadmin;

		$data['title'] = 'Edit module';
		$data['body_class'] = 'index_editmodule';
		$data['selected_menu'] = 'setup';
		$data['content'] = $this->renderBlock('setup/editmodule', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}


	public function editextrafield() {
		$player = User::getUser();
		if($player->canAccess('Setup') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$superadmin = $player->canAccess('*');

		$setup = new Setup();

		if (!isset($this->params['ID_MODULE']) || !isset($this->params['ID_FIELD']))
		{
			DooUriRouter::redirect(MainHelper::site_url('admin/setup'));
		}
		$ID_MODULE = $this->params['ID_MODULE'];
		if (!isset($this->params['ID_FIELD']))
		{
			DooUriRouter::redirect(MainHelper::site_url('admin/setup/editmodule/id/'.$ID_MODULE));
		}
		$ID_FIELD = $this->params['ID_FIELD'];

		$selected_module = $setup->GetModule($ID_MODULE);
		$selected_extrafield = $setup->GetExtraField($ID_FIELD);

		//Normal submit action
		if (isset($_POST['ID_FIELD']) && isset($_POST['FieldName']) && isset($_POST['FieldType']) && isset($_POST['Priority']))
		{
			$setup->UpdateExtraField($ID_FIELD,$_POST['FieldName'],$_POST['FieldType'],$_POST['Priority']);
				
			//Return to editmodule page
			DooUriRouter::redirect(MainHelper::site_url('admin/setup/editmodule/id/'.$ID_MODULE));
		}		
		
		

		
		$list['setup'] = $setup;
		$list['selected_module'] = $selected_module;
		$list['selected_extrafield'] = $selected_extrafield;
		$list['mainpage'] = "editextrafield";
		$list['superadmin'] = $superadmin;

		$data['title'] = 'Edit extrafield';
		$data['body_class'] = 'index_editextrafield';
		$data['selected_menu'] = 'setup';
		$data['content'] = $this->renderBlock('setup/editextrafield', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	public function editcategory() {
		$player = User::getUser();
		if($player->canAccess('Setup') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$superadmin = $player->canAccess('*');

		$setup = new Setup();

		if (!isset($this->params['ID_MODULE']) || !isset($this->params['ID_CATEGORY']))
		{
			DooUriRouter::redirect(MainHelper::site_url('admin/setup'));
		}
		$ID_MODULE = $this->params['ID_MODULE'];
		if (!isset($this->params['ID_CATEGORY']))
		{
			DooUriRouter::redirect(MainHelper::site_url('admin/setup/editmodule/id/'.$ID_MODULE));
		}
		$ID_CATEGORY = $this->params['ID_CATEGORY'];

		$selected_module = $setup->GetModule($ID_MODULE);
		$selected_category = $setup->GetCategory($ID_CATEGORY);

		//Normal submit action
		if (isset($_POST['ID_CATEGORY']) && isset($_POST['CategoryName']))
		{
			$MBAenabled = isset($_POST['MBA_enabled']) ? '1' : '0';
			$setup->UpdateCategory($ID_CATEGORY,$_POST['CategoryName'],$MBAenabled);
				
			//Return to editmodule page
			DooUriRouter::redirect(MainHelper::site_url('admin/setup/editmodule/id/'.$ID_MODULE));
		}		
		
		

		
		$list['setup'] = $setup;
		$list['selected_module'] = $selected_module;
		$list['selected_category'] = $selected_category;
		$list['mainpage'] = "editcategory";
		$list['superadmin'] = $superadmin;

		$data['title'] = 'Edit category';
		$data['body_class'] = 'index_editcategory';
		$data['selected_menu'] = 'setup';
		$data['content'] = $this->renderBlock('setup/editcategory', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}
        
        public function siteinfo(){
            $layout = new Layout();

            $list = array();

            if(isset($_POST) && !empty($_POST) && isset($_POST['save_button'])){
                $layout->saveSiteInfo($_POST);
                DooUriRouter::redirect(MainHelper::site_url('admin/setup/siteinfo'));
            }
            else if(isset($_POST['reset_button'])){
                $layout->resetLayout('siteinfo');
                DooUriRouter::redirect(MainHelper::site_url('admin/setup/siteinfo'));
            }

            $data['title'] ='Site info';
            $data['body_class'] = 'layout_siteinfo';
            $data['selected_menu'] = 'setup';
            $data['left'] = $this->renderBlock('setup/common/leftColumn');
            $data['content'] = $this->renderBlock('setup/layout/siteinfo', $list);
            $data['footer'] = MainHelper::bottomMenu();
            $data['header'] = $this->getMenu();
            $this->render3Cols($data);
        }
}
