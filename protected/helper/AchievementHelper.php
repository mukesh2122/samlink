<?php
class AchievementHelper {
   
    public static function GetAchievement($ID_ACHIEVEMENT){
       $query = "SELECT * 
                FROM ac_achievements 
                WHERE ID_ACHIEVEMENT = $ID_ACHIEVEMENT
                LIMIT 1";
       
       $ac = Doo::db()->query($query)->fetchAll();
       
    if(isset($ac[0]))
           return $ac[0];
       
           return null;
   }
   
   public static function GetPlayerAchievements($ID_PLAYER){
       $query = "SELECT *
                FROM ac_player_achievements
                WHERE FK_PLAYER = $ID_PLAYER";
       
       $ac = Doo::db()->query($query)->fetchAll();
       
       if($ac)
           return $ac;

   }
   
   public static function GetBranches($instruc = "Choose Branch"){
       	$list = new AcBranches();
        $list->ID_BRANCH = 0;
        $list->Name = $instruc;
        $array = array($list);
        $list = new AcBranches();
        $list = array_merge($array, $list->find(array('asc' => 'Name')));
        return $list;
   }
   
    public static function GetCategories($instruc = "Choose Category"){
       	$list = new AcCategories();
        $list->ID_CATEGORY = 0;
        $list->Name = $instruc;
        $array = array($list);
        $list = new AcCategories();
        $list = array_merge($array, $list->find(array('asc' => 'Name')));
        return $list;
   }
   
   public static function GetBranchNoImageName($branchName){
           $noimage = "";
    
    switch ($branchName){
        case BRANCH_ESPORT:
            $noimage = 'no_esport';
            break;
        case BRANCH_SOCIAL:
            $noimage = 'no_social';
            break;
        case BRANCH_SHOP:
            $noimage = 'no_shop';
            break;
        default :
            $noimage = 'no_achievement';
    }   
        return $noimage;
   }
}
?>