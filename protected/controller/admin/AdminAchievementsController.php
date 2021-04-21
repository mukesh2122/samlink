<?php

class AdminAchievementsController extends AdminController {

    /**
     * Main website
     *
     */
    public function index() {
                $achievements = new Achievement();
                $list = array();
		$player = User::getUser();
		if($player->canAccess('Edit achievements information') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}
		
                $pager = $this->appendPagination($list, new stdClass(), $achievements->getTotalAchievements(), MainHelper::site_url('admin/achievements/page'), Doo::conf()->adminAchievementsLimit);

		$list['achievements'] = $achievements->getAllAchievements($pager->limit, false);
		$list['player'] = $player;
		
		$data['title'] = $this->__('Achievements');
		$data['body_class'] = 'index_achievements';
		$data['selected_menu'] = 'achievements';
		$data['left'] =  $this->renderBlock('achievements/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('achievements/index', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data); 
	}
    /**
     * search achievements
     *
     */
    public function search() {
        if (!isset($this->params['searchText'])) {
            DooUriRouter::redirect(MainHelper::site_url('admin/achievements'));
            return FALSE;
        }

		$achievement = new Achievement();
		$search = new Search();
        $list = array();
		$player = User::getUser();
		if($player->canAccess('Edit achievement information') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$list['searchText'] = urldecode($this->params['searchText']);

		$achievementTotal = $search->getSearchTotal(urldecode($this->params['searchText']), SEARCH_ACHIEVEMENT);
		$pager = $this->appendPagination($list, $achievement, $achievementTotal, MainHelper::site_url('admin/achievements/search/'.  urlencode($list['searchText']).'/page'), Doo::conf()->adminAchievementsLimit);
		$list['achievements'] = $search->getSearch(urldecode($this->params['searchText']), SEARCH_ACHIEVEMENT, $pager->limit);
        $list['searchTotal'] = $achievementTotal;

		$data['title'] = $this->__('Search results');
        $data['body_class'] = 'search_achievements';
		$data['selected_menu'] = 'achievements';
		$data['left'] =  $this->renderBlock('achievements/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('achievements/index', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
    }
     /**
     * Shows branches admin page
     *
     */
    public function branches() {
                $achievements = new Achievement();
                $list = array();
		$player = User::getUser();
                        
		if($player->canAccess('Edit achievement information') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}
		
                $list['branches'] = $achievements->getAllBranches();
		
		$data['title'] = $this->__('Branches');
		$data['body_class'] = 'index_branches';
		$data['selected_menu'] = 'achievements';
		$data['left'] =  $this->renderBlock('achievements/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('achievements/branches', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data); 
	}
     /**
     * Show achieved achievements admin page
     *
     */
    public function playerAchievements() {
                $achievements = new Achievement();
                $list = array();
		$player = User::getUser();
                
		if($player->canAccess('Edit achievement information') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}
		
		//$pager = $this->appendPagination($list, new stdClass(), $users->getTotalPlayers($player), MainHelper::site_url('admin/users/page'), Doo::conf()->adminPlayersLimit);
		$list['achievements'] = $achievements->getAllPlayerAchievements();
		
		$data['title'] = $this->__('Achievements');
		$data['body_class'] = 'index_player_achievements';
		$data['selected_menu'] = 'achievements';
		$data['left'] =  $this->renderBlock('achievements/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('achievements/player_achievements', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data); 
	}
            /**
     * Shows parent categories for achievements
     *
     */
    public function levels() {
                $achievements = new Achievement();
                $list = array();
		$player = User::getUser();
                
		if($player->canAccess('Edit achievement information') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}
		
		$pager = $this->appendPagination($list, new stdClass(), $achievements->getTotalLevels(), MainHelper::site_url('admin/achievements/levels/page'), Doo::conf()->adminAchievementsLimit);
		$list['levels'] = $achievements->getAllLevels($pager->limit);
		
		$data['title'] = $this->__('Levels');
		$data['body_class'] = 'index_levels';
		$data['selected_menu'] = 'achievements';
		$data['left'] =  $this->renderBlock('achievements/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('achievements/levels', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data); 
	}  
            /**
     * Shows parent categories for achievements
     *
     */
    public function categories() {
                $achievements = new Achievement();
                $list = array();
		$player = User::getUser();
                
		if($player->canAccess('Edit achievement information') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}
		
		//$pager = $this->appendPagination($list, new stdClass(), $users->getTotalPlayers($player), MainHelper::site_url('admin/users/page'), Doo::conf()->adminPlayersLimit);
		$list['categories'] = $achievements->getAllCategories();
		
		$data['title'] = $this->__('Categories');
		$data['body_class'] = 'index_categories';
		$data['selected_menu'] = 'achievements';
		$data['left'] =  $this->renderBlock('achievements/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('achievements/categories', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data); 
	}    
            /**
     * Shows parent categories for achievements
     *
     */
    public function rankings() {
                $achievements = new Achievement();
                $list = array();
		$player = User::getUser();
                
		if($player->canAccess('Edit achievement information') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}
		
                $pager = $this->appendPagination($list, new stdClass(), $achievements->getTotalRankings(), MainHelper::site_url('admin/achievements/rankings/page'), Doo::conf()->adminAchievementsLimit);
		$list['rankings'] = $achievements->getRankings($pager->limit);
		
		$data['title'] = $this->__('Rankings');
		$data['body_class'] = 'index_rankings';
		$data['selected_menu'] = 'achievements';
		$data['left'] =  $this->renderBlock('achievements/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('achievements/rankings', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data); 
	} 
    /**
     * Shows newAchivement form
     *
     */
    public function newAchievement() {
                $achievements = new Achievement();
                $list = array();
		$player = User::getUser();
                
		if($player->canAccess('Edit achievement information') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}
		
                $branches = $achievements->getAllBranches();
		
                if(isset($_POST) and !empty($_POST)) {
			$achievement = $achievements->createAchievement($_POST);
                        DooUriRouter::redirect(MainHelper::site_url('admin/achievements'));
		}
                
                $list['branches'] = $branches;
                
		$data['title'] = $this->__('New Achievement');
		$data['body_class'] = 'index_achievements';
		$data['selected_menu'] = 'achievements';
		$data['left'] =  $this->renderBlock('achievements/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('achievements/newachievement', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data); 
	}
    /**
     * Shows newLevels form
     *
     */
    public function newLevel() {
                $achievements = new Achievement();
                $list = array();
		$player = User::getUser();
                
		if($player->canAccess('Edit achievement information') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}
		
                $achievementList = $achievements->getAllAchievements(50, false);
		
                if(isset($_POST) and !empty($_POST)) {
			$achievement = $achievements->createLevel($_POST);
                        DooUriRouter::redirect(MainHelper::site_url('admin/achievements/levels'));
		}
                
                $list['achievementList'] = $achievementList;
                
		$data['title'] = $this->__('New Achievement');
		$data['body_class'] = 'index_achievements';
		$data['selected_menu'] = 'achievements';
		$data['left'] =  $this->renderBlock('achievements/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('achievements/newlevel', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data); 
	}
   /**
     * Shows newBranch form
     *
     */
    public function newBranch() {
                $achievements = new Achievement();
                $list = array();
		$player = User::getUser();
		if($player->canAccess('Edit achievement information') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}
		
		//$pager = $this->appendPagination($list, new stdClass(), $users->getTotalPlayers($player), MainHelper::site_url('admin/users/page'), Doo::conf()->adminPlayersLimit);
		$list['player'] = $player;
                
                if(isset($_POST) and !empty($_POST)) {
			$branch = $achievements->createBranch($_POST);
                        DooUriRouter::redirect(MainHelper::site_url('admin/achievements/branches'));
		}
		
		$data['title'] = $this->__('New Branch');
		$data['body_class'] = 'index_achievements';
		$data['selected_menu'] = 'achievements';
		$data['left'] =  $this->renderBlock('achievements/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('achievements/newbranch', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data); 
	}
   /**
     * Shows newBranch form
     *
     */
    public function newCategory() {
                $achievements = new Achievement();
                $list = array();
		$player = User::getUser();
                        
		if($player->canAccess('Edit achievement information') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}
		
		$list['player'] = $player;
                
                if(isset($_POST) and !empty($_POST)) {
			$category = $achievements->createCategory($_POST);
                        DooUriRouter::redirect(MainHelper::site_url('admin/achievements/categories'));
		}
		
		$data['title'] = $this->__('New Category');
		$data['body_class'] = 'index_categories';
		$data['selected_menu'] = 'achievements';
		$data['left'] =  $this->renderBlock('achievements/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('achievements/newcategory', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data); 
	}        
            /**
     * edits existing branch
     *
     */
    public function edit() {
                $achievements = new Achievement();
                $list = array();
		$player = User::getUser();
		if($player->canAccess('Edit achievement information') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}
                
                $achievement = $achievements->getAchievementById($this->params['achieve_id']);
                $branches = $achievements->getAllBranches();
                
                if(isset($_POST) and !empty($_POST)) {
                        $achievements->updateAchievement($achievement, $_POST);
			DooUriRouter::redirect(MainHelper::site_url('admin/achievements/edit/'.$achievement->ID_ACHIEVEMENT));
		}
                $list['achievement'] = $achievement;
                $list['branches'] = $branches;
		
		$data['title'] = $this->__('Edit Achievement');
		$data['body_class'] = 'edit_branches';
		$data['selected_menu'] = 'achievements';
		$data['left'] =  $this->renderBlock('achievements/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('achievements/edit', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data); 
	}
    public function editLevel() {
                $achievements = new Achievement();
                $list = array();
		$player = User::getUser();
		if($player->canAccess('Edit achievement information') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}
                
                $level = $achievements->getLevelByID($this->params['level_id']);
                $achievementList = $achievements->getAllAchievements(50, false);
                
                if(isset($_POST) and !empty($_POST)) {
                        $achievements->updateLevel($level, $_POST);
			DooUriRouter::redirect(MainHelper::site_url('admin/achievements/editlevel/'.$level->ID_LEVEL));
		}
                $list['achievementList'] = $achievementList;
                $list['level'] = $level;
		
		$data['title'] = $this->__('Edit Achievement');
		$data['body_class'] = 'edit_branches';
		$data['selected_menu'] = 'achievements';
		$data['left'] =  $this->renderBlock('achievements/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('achievements/editlevel', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data); 
	}
    /**
     * edits existing branch
     *
     */
    public function editbranch() {
                $achievements = new Achievement();
                $list = array();
		$player = User::getUser();
                
		if($player->canAccess('Edit achievement information') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}
                
                $branch = $achievements->getBranchById($this->params['branch_id']);
                
                if(isset($_POST) and !empty($_POST)) {
                        $achievements->updateBranch($branch, $_POST);
			DooUriRouter::redirect(MainHelper::site_url('admin/achievements/editbranch/'.$branch->ID_BRANCH));
		}

                $list['branch'] = $branch;
		
		$data['title'] = $this->__('Edit Branch');
		$data['body_class'] = 'edit_branches';
		$data['selected_menu'] = 'achievements';
		$data['left'] =  $this->renderBlock('achievements/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('achievements/editbranch', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data); 
	}
        
        public function ajaxUploadPhoto() {
		$c = new Achievement();
		if (!isset($this->params['ach_id']))
			return false;

		$upload = $c->uploadPhoto(intval($this->params['ach_id']),$this->params['type']);

		if ($upload['filename'] != '') {
			$file = MainHelper::showImage($upload['c'], THUMB_LIST_100x100, true, array('width', 'no_img' => 'noimage/no_shop_100x100.png'));
			echo $this->toJSON(array('success' => TRUE, 'img' => $file));
		} else {
			echo $this->toJSON(array('error' => $upload['error']));
		}
 

	}
}