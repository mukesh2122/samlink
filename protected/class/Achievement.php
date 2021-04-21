<?php

class Achievement {

	/**
	 * Returns all achievements 
	 *
	 * @return AcAchievements
         * db->ac_achievements
	 */
	public function getAllAchievements($limit = 50, $isActive = true) {
            $achievement = new AcAchievements;
            $active = "";
            
            if($isActive)
                $active = " WHERE {$achievement->_table}.IsActive = 1";
            
            $query = "SELECT 
                        {$achievement->_table}.* 
                    FROM
                        {$achievement->_table}
                ".$active;
            
            $rs = Doo::db()->query($query);
            $list = $rs->fetchAll(PDO::FETCH_CLASS,'AcAchievements');
            
            return $list;
        }
        	/**
	 * Returns all levels of achievements 
	 *
	 * @return AcLevels
         * db->ac_levels
	 */
	public function getAllLevels($limit = 50) {
            
            $list = Doo::db()->find('AcLevels', array(
                                "limit" => $limit
            ));
            
            return $list;
        }
        /**
	 * Returns all branches
	 *
	 * @return AcBranches
         * db->ac_branches
	 */
        public function getAllBranches(){
            
            $list = Doo::db()->find('AcBranches');

            return $list;
        }
        /**
	 * Returns number of achievements
	 *
	 * @return int cnt
         * 
	 */
        public function getTotalAchievements(){
            $achievements = new AcAchievements();
            
            $query = "SELECT 
                        count(*) as cnt
                     FROM
                        {$achievements->_table}
                    ";
            $rs = Doo::db()->query($query);            
            $cnt = $rs->fetch();
            return $cnt['cnt'];
        }
        /**
	 * Returns number of levels
	 *
	 * @return int cnt
         * 
	 */
        public function getTotalLevels(){
            $levels = new AcLevels();
            
            $query = "SELECT 
                        count(*) as cnt
                     FROM
                        {$levels->_table}
                    ";
            $rs = Doo::db()->query($query);            
            $cnt = $rs->fetch();
            return $cnt['cnt'];
        }
        /**
	 * Returns number of ranked players
	 *
	 * @return int cnt
         * 
	 */
        public function getTotalRankings(){
            $rankings = new AcRankings();
            
            $query = "SELECT 
                        count(*) as cnt
                     FROM
                        {$rankings->_table}
                    ";
            $rs = Doo::db()->query($query);            
            $cnt = $rs->fetch();
            return $cnt['cnt'];
        }   
        /**
	 * Returns ranking list
	 *
	 * @return AcRankings
         * db->ac_rankings
	 */
        public function getRankings($limit){
            $rankings = new AcRankings();
            $player = new Players();

            $query = "SELECT
                        {$rankings->_table}.*, {$player->_table}.DisplayName as PlayerName
                    FROM
                        {$rankings->_table}
                    LEFT JOIN
                        {$player->_table}
                    ON 
                        {$rankings->_table}.FK_PLAYER = {$player->_table}.ID_PLAYER
                    ORDER BY {$rankings->_table}.Points DESC
                    LIMIT {$limit}    
                    ";
                        
            $rs = Doo::db()->query($query);
            $list = $rs->fetchAll(PDO::FETCH_CLASS, 'AcRankings');
            
            return $list;
        }
        public function getFriendRankings(Players $user, $limit){
            $player = new Players();
            $ranking = new AcRankings();
            $relation = new SnFriendsRel();
            
            $query = "SELECT {$ranking->_table}.*, {$player->_table}.DisplayName as PlayerName
                        FROM {$ranking->_table} 
                        LEFT JOIN {$player->_table} 
                        ON {$ranking->_table}.FK_PLAYER = {$player->_table}.ID_PLAYER 
                        LEFT JOIN {$relation->_table} 
                        ON {$ranking->_table}.FK_PLAYER = {$relation->_table}.ID_FRIEND 
                        WHERE {$relation->_table}.ID_PLAYER = {$user->ID_PLAYER}
                    UNION
                        SELECT {$ranking->_table}.*, {$player->_table}.DisplayName as PlayerName 
                        FROM {$ranking->_table} 
                        LEFT JOIN {$player->_table} 
                        ON {$ranking->_table}.FK_PLAYER = {$player->_table}.ID_PLAYER 
                        WHERE {$ranking->_table}.FK_PLAYER = {$user->ID_PLAYER}
                    ORDER BY Points DESC
                    LIMIT {$limit}
                    ";
                    
            $rs = Doo::db()->query($query);
            $list = $rs->fetchAll(PDO::FETCH_CLASS, 'AcRankings');
            
            return $list;
        }
        /**
	 * Returns all categories
	 *
	 * @return AcCategories
         * db->ac_categories
	 */
        public function getAllCategories(){
            
            $list = Doo::db()->find('AcCategories');
            
            return $list;
        }

        /**
         * Returns achievement by id
         *
         * @return AcAchievements object
         */
        public static function getAchievementByID($id) {
			$item = Doo::db()->find('AcAchievements', array(
				'where' => 'ID_ACHIEVEMENT = ?',
				'param' => array($id),
				'limit' => 1
					));
                        return $item;
        }
            /**
         * Returns branch by id
         *
         * @return AcBranches object
         */
        public static function getBranchByID($id) {
            $item = Doo::db()->find('AcBranches', array(
                    'where' => 'ID_BRANCH = ?',
                    'param' => array($id),
                    'limit' => 1
                            ));
            return $item;
        }
           /**
         * Returns category by id
         *
         * @return AcCategories object
         */
        public static function getCategoryById($id) {
            $item = Doo::db()->find('AcCategories', array(
                    'where' => 'CategoryName = ?',
                    'param' => array($id),
                    'limit' => 1
                            ));
            return $item;
        }
       /**
         * Returns category by id
         *
         * @return AcCategories object
         */
        public static function getBranchByLevelID($id) {
            $level = self::getLevelByID($id);
            $achievement = self::getAchievementByID($level->FK_ACHIEVEMENT);
            $branch = self::getBranchById($achievement->FK_BRANCH);
            
            return $branch;
        }
         /**
         * Returns a players latest achievements by id
         *
         *input: 
         *$ID_PLAYER - Players Id
         *$latest - The number of maximum achievements to return
         *   
         * @return AcAchievements 
         */
        public static function getLatestAchievementsByID($ID_PLAYER, $latest = 3, $isActive = true) {
            $myAchievements = new AcPlayerAchievementRel();
            $levels = new AcLevels();
            $active = "";
            
            if($isActive)
                $active = " AND {$levels->_table}.IsLevelActive = 1";
            
            $query = "SELECT 
                        {$myAchievements->_table}.* 
                    FROM 
                        {$myAchievements->_table}
                    LEFT JOIN
                        {$levels->_table}
                    ON
                        {$myAchievements->_table}.FK_LEVEL = {$levels->_table}.ID_LEVEL
                    WHERE 
                        {$myAchievements->_table}.FK_PLAYER = {$ID_PLAYER}
            ".$active;
           
           $rs = Doo::db()->query($query);
           $list = $rs->fetchAll(PDO::FETCH_CLASS,'AcPlayerAchievementRel');
                   
           return $list;
        }        
         /**
         * Returns a players achievements by id
         *
         * @return AcPlayerAchievementRel 
         */
        public static function getPlayerAchievementsByID($ID_PLAYER, $isActive = true) {
            $myAchievements = new AcPlayerAchievementRel();
            $levels = new AcLevels();
            $active = "";
            
            if($isActive)
                $active = " AND {$levels->_table}.IsLevelActive = 1 ";
            
            $query = "SELECT
                          {$myAchievements->_table}.FK_PLAYER,
                          {$myAchievements->_table}.FK_ACHIEVEMENT,
                          {$myAchievements->_table}.FK_LEVEL,
                          MAX({$myAchievements->_table}.Achievement) as Achievement,
                          {$myAchievements->_table}.AchievementTime,
                          {$levels->_table}.Level,
                          {$levels->_table}.LevelDesc as AchievementDesc, 
                          {$levels->_table}.ImageURL              
                      FROM
                          {$myAchievements->_table}
                      LEFT JOIN
                          {$levels->_table}
                      ON
                          {$myAchievements->_table}.FK_LEVEL = {$levels->_table}.ID_LEVEL
                      WHERE {$myAchievements->_table}.FK_PLAYER = {$ID_PLAYER}"
                      .$active.
                      "GROUP BY {$myAchievements->_table}.FK_ACHIEVEMENT
                      ORDER BY {$myAchievements->_table}.AchievementTime    
                ";

           $rs = Doo::db()->query($query);        
           $list = $rs->fetchAll(PDO::FETCH_CLASS, 'AcPlayerAchievementRel');
           
           return $list;
        }
         /**
         * Returns a level by id
         *
         * @return AcLevels 
         */
        public static function getLevelByID($id) {
            $levels = new AcLevels();
            
           $list = Doo::db()->find('AcLevels',array(
                                        "where"=>"{$levels->_table}.ID_LEVEL = ?",
                                        "param" => array($id),
                                        "limit" => 1        
           )); 
                       
           return $list;
        }
                 /**
         * Returns players rank by id
         *
         * @return AcRankings 
         */
        public static function getPlayerRankByID($ID_PLAYER) {
            $rankings = new AcRankings();
            $player = new Players();
            $query = "SELECT
                       {$rankings->_table}.*, {$player->_table}.DisplayName as PlayerName
                   FROM
                       {$rankings->_table}
                   LEFT JOIN
                       {$player->_table}
                   ON
                       {$rankings->_table}.FK_PLAYER = {$player->_table}.ID_PLAYER
                   WHERE 
                       {$rankings->_table}.FK_PLAYER = {$ID_PLAYER}
                   LIMIT 1
               ";
            $rank = Doo::db()->fetchAll($query,null, PDO::FETCH_CLASS,'AcRankings');
            if(empty($rank)) { return FALSE; };
            return $rank[0];
        }

         /**
         * Returns achievements in a branch
         *
         * @return AcAchievements
         */
        public static function getAchievementsByBranch(AcBranches $branch, $isActive = true) {
            $achievement = new AcAchievements;
            $active = "";
            
            if($isActive)
                $active = " AND {$achievement->_table}.IsActive = 1";
            
            $query = "SELECT 
                        {$achievement->_table}.* 
                    FROM
                        {$achievement->_table}
                    WHERE
                        {$achievement->_table}.FK_BRANCH = {$branch->ID_BRANCH}
                ".$active;
            
            $rs = Doo::db()->query($query);
            $list = $rs->fetchAll(PDO::FETCH_CLASS,'AcAchievements');
            
            return $list;
        }
            /**
	 * Returns all player achievements
	 *
	 * @return Player achievements list
         * db->ac_player_achievements
	 */
        public function getAllPlayerAchievements(){
            $playerAch = new AcPlayerAchievementRel();
            $player = new Players();
            
            $query = "SELECT
                        {$playerAch->_table}.* , {$player->_table}.DisplayName 
                    FROM
                        {$playerAch->_table}
                    LEFT JOIN 
                        {$player->_table}
                    ON 
                    {$playerAch->_table}.FK_PLAYER = {$player->_table}.ID_PLAYER
                    LIMIT 0, ".Doo::conf()->playersLimit;
                        
            $rs = Doo::db()->query($query);
            $list = $rs->fetchAll(PDO::FETCH_CLASS, 'AcPlayerAchievementRel');
            
            return $list;
        }
       /**
	 * Creates a new branch
	 *
	 * db->ac_branches
	 */
        public function createBranch($post){
            $branch = new AcBranches();
            
            if (isset($post['name'])) $branch->BranchName = ContentHelper::handleContentInput($post['name']);
            if (isset($post['desc'])) $branch->BranchDesc = ContentHelper::handleContentInput($post['desc']);
            
            $branch->insert();
            
        }
       /**
	 * Creates a new achievement
	 *
	 * db->ac_achievements
	 */
        public function createAchievement($post){
            $achievement = new AcAchievements();
            $imageUrl = "";
		if (!empty($_FILES['Filedata']) and $_FILES['Filedata']['size'] > 0) {
			$image = new Image();
			$result = $image->uploadImages(FOLDER_ACHIEVEMENTS);
			if ($result['filename'] != '') {
				$imageUrl = $result['filename'];
			}
		}
            if (isset($post['name'])) $achievement->AchievementName = ContentHelper::handleContentInput($post['name']);
            if (isset($post['desc'])) $achievement->AchievementDesc = ContentHelper::handleContentInput($post['desc']);
            if (isset($post['branch'])) $achievement->FK_BRANCH = ContentHelper::handleContentInput($post['branch']);
            $achievement->ImageUrl = $imageUrl;
            
            $achievement->insert();
            
        }
                     /**
	 * Creates a new level
	 *
	 * db->ac_levels
	 */
        public function createLevel($post){
            $level = new AcLevels();
            $imageUrl = "";
		if (!empty($_FILES['Filedata']) and $_FILES['Filedata']['size'] > 0) {
			$image = new Image();
			$result = $image->uploadImages(FOLDER_ACHIEVEMENTS);
			if ($result['filename'] != '') {
				$imageUrl = $result['filename'];
			}
		}
            if (isset($post['name'])) $level->LevelName = ContentHelper::handleContentInput($post['name']);
            if (isset($post['desc'])) $level->LevelDesc = ContentHelper::handleContentInput($post['desc']);
            if (isset($post['level'])) $level->Level = ContentHelper::handleContentInput($post['level']);
            if (isset($post['points'])) $level->Points = ContentHelper::handleContentInput($post['points']);
            if (isset($post['multiplier'])) $level->Multiplier = ContentHelper::handleContentInput($post['multiplier']);
            if (isset($post['achievement'])) $level->FK_ACHIEVEMENT = ContentHelper::handleContentInput($post['achievement']);
            $level->ImageURL = $imageUrl;
            
            $level->insert();
            
        }
       /**
	 * Creates a new category
	 *
	 * db->ac_categories
	 */
        public function createCategory($post){
            $category = new AcCategories();
            
            if (isset($post['name'])) $category->CategoryName = ContentHelper::handleContentInput($post['name']);
            
            $category->insert();
        }
         /**
	 * Updates a branch
	 *
	 * db->ac_branches
	 */
        public function updateBranch(AcBranches $branch, $post){
         
            if(!empty($post)){
                if (isset($post['branch_name'])) $branch->BranchName = ContentHelper::handleContentInput($post['branch_name']);
                if (isset($post['branch_desc'])) $branch->BranchDesc = ContentHelper::handleContentInput($post['branch_desc']);

                $branch->update();
                return true;
            }
            return false;
        }
         /**
	 * Updates a level
	 *
	 * db->ac_levels
	 */
        public function updateLevel(AcLevels $level, $post){
         
            if(!empty($post)){
                if (isset($post['level_name'])) $level->LevelName = ContentHelper::handleContentInput($post['level_name']);
                if (isset($post['level_desc'])) $level->LevelDesc = ContentHelper::handleContentInput($post['level_desc']);
                if (isset($post['level_ach_id'])) $level->FK_ACHIEVEMENT = ContentHelper::handleContentInput($post['level_ach_id']);
                if (isset($post['level_points'])) $level->Points = ContentHelper::handleContentInput($post['level_points']);
                if (isset($post['level_multiplier'])) $level->Multiplier = ContentHelper::handleContentInput($post['level_multiplier']);
                if(isset($post['image_url'])) {
				$level->ImageURL = $post['image_url'];
			};

                $level->update();
                return true;
            }
            return false;
        }
        /* Updates an achievement
	 *
	 * db->ac_achievement
	 */
        public function updateAchievement(AcAchievements $achievement, $post){
            if(!empty($post)){
                if (isset($post['ach_name'])) $achievement->AchievementName = ContentHelper::handleContentInput($post['ach_name']);
                if (isset($post['ach_desc'])) $achievement->AchievementDesc = ContentHelper::handleContentInput($post['ach_desc']);
                if (isset($post['ach_branch_id'])) $achievement->FK_BRANCH = ContentHelper::handleContentInput($post['ach_branch_id']);

                $achievement->update();
                return true;
            }
            return false;
        }
        
        public function uploadPhoto($id, $type = 'level') {
            $c = '';
            if($type == 'level')
                $c = $this->getLevelByID($id);
            else
                $c = $this->getAchievementByID($id);
            
            if($c != ''){
                $image = new Image();
                $result = $image->uploadImage(FOLDER_ACHIEVEMENTS, $c->ImageURL);
                if ($result['filename'] != '') {
                        $c->ImageURL = ContentHelper::handleContentInput($result['filename']);
                        $c->update(array('field' => 'ImageURL'));
                        $c->purgeCache();
                        $result['c'] = $c;
                }
                return $result;
            }
	}
        
        
        /****************************CHECK FOR UNLOCKED ACHIEVEMENTS**********/
        /*********************************************************************/
       
        /* Unlock an achievement
        * 
        * 
        * 
        */
        public function unlockAchievement($ID_PLAYER, $ID_ACHIEVEMENT){
            $achievement = new AcPlayerAchievementRel();
            
            $achievement->FK_PLAYER = $ID_PLAYER;
            $achievement->FK_LEVEL = $ID_ACHIEVEMENT;
            
            $achievement->insert();
        }
         /* Check for achievements
         *
         *$categoryName - The category name from the ac_category table
	 *set $rollback to true, to backtrack achievements and unlock them
          * 
          *@return AcAchievements 
	 */
        public function checkAchievement($ID_PLAYER, $categoryName,  $rollback = false){
           $achievementLvl = new AcLevels();
           $progress = 0;
           $achievement = new AcAchievements();
           $achievement->AchievementName = $categoryName;
           $playerAchievement = new AcPlayerAchievementRel();
            
           switch($achievement->AchievementName){
               case "Complete profile":
                   $progress = self::checkCompletedProfile($ID_PLAYER);
                   break;
               case "PAYTOPLAY":
                   break;
           }       
                      
           $queryLvl = "SELECT 
                        {$achievementLvl->_table}.*
                     FROM
                        {$achievementLvl->_table}
                     INNER JOIN
                        {$achievement->_table}
                     ON
                        {$achievementLvl->_table}.FK_ACHIEVEMENT = {$achievement->_table}.ID_ACHIEVEMENT
                     WHERE
                         {$achievement->_table}.AchievementName = '{$achievement->AchievementName}'
                     ORDER BY {$achievementLvl->_table}.Level ASC         
                     ";
            $lvl = Doo::db()->query($queryLvl);
            $levels = $lvl->fetchAll(PDO::FETCH_CLASS, 'AcLevels');

                                    
           foreach($levels as $level){
              $multiplier = $level->Multiplier;
              
             $unlocked = Doo::db()->find('AcPlayerAchievementRel',array(
                "where" => "{$playerAchievement->_table}.FK_PLAYER = ? AND {$playerAchievement->_table}.FK_LEVEL = ?",
                "param" => array($ID_PLAYER, $level->ID_LEVEL)                    
               ));
              
             if(!count($unlocked) > 0 ){  
                  if($progress == $multiplier)
                  {
                      self::unlockAchievement($ID_PLAYER, $level->ID_LEVEL);
                  }
                  else if($progress < $multiplier)
                      break;
              }
           }                       
        }
        
        public static function totalPayToPlayWins($ID_PLAYER){
            
        }
        public static function totalFreeToPlayWins($ID_PLAYER){
            
        }
        public static function totalDailyChallengesWins($ID_PLAYER){
            
        }
        public static function totalSendRequests($ID_PLAYER){
            $request = new Players();
            
            $query = "SELECT FriendRequestsSent as cnt 
                   FROM 
                       {$request->_table}
                   WHERE 
                       {$request->_table}.ID_PLAYER = {$ID_PLAYER}";
           
           $cnt = (object) Doo::db()->fetchRow($query);
           $progress = $cnt->cnt;
           return $progress; 
        }
        public static function totalAcceptedRequests($ID_PLAYER){
            $request = new SnFriendsRel();
            
            $query = "SELECT count(*) as cnt 
                   FROM 
                       {$request->_table}
                   WHERE 
                       {$request->_table}.ID_FRIEND = {$ID_PLAYER}
                   AND
                       {$request->_table}.Subscribed = 1
                   ";
           
           $cnt = (object) Doo::db()->fetchRow($query);
           $progress = $cnt->cnt;
           return $progress; 
        }
        public static function totalMembershipTime($ID_PLAYER){
            
        }
        public static function checkCompletedProfile($ID_PLAYER){
            return 1;
        }
        public static function checkMembershipBuys($ID_PLAYER){
            $playerpackage = new SnPlayerPackageRel();
            
            $query = "SELECT PackageType 
                   FROM 
                       {$playerpackage->_table}
                   WHERE 
                       {$playerpackage->_table}.ID_FRIEND = {$ID_PLAYER}
                   LIMIT 1
                   ";
           
           $package = (object) Doo::db()->fetchRow($query);
           $type = $package->PackageType;
           return $type; 
        }
}

?>