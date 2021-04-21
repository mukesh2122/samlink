<?php

/**
 * Example Database connection settings and DB relationship mapping
 * $dbmap[Table A]['has_one'][Table B] = array('foreign_key'=> Table B's column that links to Table A );
 * $dbmap[Table B]['belongs_to'][Table A] = array('foreign_key'=> Table A's column where Table B links to );

//Food relationship
$dbmap['Food']['belongs_to']['FoodType'] = array('foreign_key'=>'id');
$dbmap['Food']['has_many']['Article'] = array('foreign_key'=>'food_id');
$dbmap['Food']['has_one']['Recipe'] = array('foreign_key'=>'food_id');
$dbmap['Food']['has_many']['Ingredient'] = array('foreign_key'=>'food_id', 'through'=>'food_has_ingredient');

//Food Type
$dbmap['FoodType']['has_many']['Food'] = array('foreign_key'=>'food_type_id');

//Article
$dbmap['Article']['belongs_to']['Food'] = array('foreign_key'=>'id');

//Recipe
$dbmap['Recipe']['belongs_to']['Food'] = array('foreign_key'=>'id');

//Ingredient
$dbmap['Ingredient']['has_many']['Food'] = array('foreign_key'=>'ingredient_id', 'through'=>'food_has_ingredient');


//$dbconfig[ Environment or connection name] = array(Host, Database, User, Password, DB Driver, Make Persistent Connection?);
*/

//players relation
$dbmap['Players']['has_many']['SnPlayerCategoryRel'] = array('foreign_key'=>'ID_OWNER');
$dbmap['SnPlayerCategoryRel']['belongs_to']['Players'] = array('foreign_key'=>'ID_PLAYER');
$dbmap['SyCategories']['has_many']['SnPlayerCategoryRel'] = array('foreign_key'=>'ID_CATEGORY');
$dbmap['SnPlayerCategoryRel']['belongs_to']['SyCategories'] = array('foreign_key'=>'ID_CATEGORY');
$dbmap['Players']['has_many']['FriendsRel'] = array('foreign_key'=>'ID_PLAYER');
$dbmap['Players']['has_many']['SnWallitems'] = array('foreign_key'=>'ID_OWNER');
$dbmap['Players']['has_many']['SnWallreplies'] = array('foreign_key'=>'ID_OWNER');
$dbmap['Players']['has_many']['NwReplies'] = array('foreign_key'=>'ID_OWNER');
$dbmap['Players']['has_many']['SnMyWallItems'] = array('foreign_key'=>'ID_WALLITEM');
//$dbmap['Players']['belongs_to']['FmPersonalMessages'] = array('foreign_key'=>'ID_PLAYER_FROM'); // Duplicate
$dbmap['Players']['belongs_to']['FmPersonalMessages'] = array('foreign_key'=>'ID_PLAYER_FROM');
$dbmap['Players']['has_many']['SnNotificationsSub'] = array('foreign_key'=>'ID_OWNER');
$dbmap['Players']['has_many']['SnPlayerGameRel'] = array('foreign_key'=>'ID_PLAYER');
$dbmap['Players']['has_many']['SnPlayerCompanyRel'] = array('foreign_key'=>'ID_PLAYER');
$dbmap['Players']['has_many']['SnPlayerGroupRel'] = array('foreign_key'=>'ID_PLAYER');

$dbmap['Players']['has_many']['SnPlayerGroupRel'] = array('foreign_key'=>'ID_PLAYER');
$dbmap['SnPlayerGroupRel']['belongs_to']['Players'] = array('foreign_key'=>'ID_PLAYER');

$dbmap['Players']['has_many']['SnPlayerGameRel'] = array('foreign_key'=>'ID_PLAYER');
$dbmap['SnPlayerGameRel']['belongs_to']['Players'] = array('foreign_key'=>'ID_PLAYER');

//infobox relation with player
$dbmap['SnInfo']['has_many']['SnPlayerInfoRel'] = array('foreign_key'=>'ID_INFO');
$dbmap['SnPlayerInfoRel']['belongs_to']['SnInfo'] = array('foreign_key'=>'ID_INFO');

//players relation to players
$dbmap['FriendsRel']['belongs_to']['Players'] = array('foreign_key'=>'ID_PLAYER');
$dbmap['FriendsRel']['belongs_to']['SnWallitems'] = array('foreign_key'=>'ID_OWNER');

//wall relation
$dbmap['SnWallitems']['belongs_to']['Players'] = array('foreign_key'=>'ID_PLAYER');
$dbmap['SnWallitems']['has_many']['SnWallreplies'] = array('foreign_key'=>'ID_WALLITEM');
$dbmap['SnWallitems']['has_many']['SnMyWallItems'] = array('foreign_key'=>'ID_WALLITEM');
$dbmap['SnWallitems']['has_many']['FriendsRel'] = array('foreign_key'=>'ID_FRIEND');
$dbmap['SnAlbums']['has_many']['SnWallitems'] = array('foreign_key'=>'ID_ALBUM');
$dbmap['SnWallitems']['belongs_to']['SnAlbums'] = array('foreign_key'=>'ID_ALBUM');

//wall items replies
$dbmap['SnWallreplies']['belongs_to']['SnWallitems'] = array('foreign_key'=>'ID_WALLITEM');
$dbmap['SnWallreplies']['belongs_to']['Players'] = array('foreign_key'=>'ID_PLAYER');

//SnMyWallItems
$dbmap['SnMyWallItems']['belongs_to']['SnWallitems'] = array('foreign_key'=>'ID_WALLITEM');
$dbmap['SnMyWallItems']['belongs_to']['Players'] = array('foreign_key'=>'ID_VIEWER');

//messages
$dbmap['FmPersonalMessages']['has_many']['FmPersonalMessagesRecipients'] = array('foreign_key'=>'ID_PM');
$dbmap['FmPersonalMessages']['has_many']['Players'] = array('foreign_key'=>'ID_PLAYER');
$dbmap['FmPersonalMessagesRecipients']['belongs_to']['FmPersonalMessages'] = array('foreign_key'=>'ID_PM');

//news
$dbmap['NwItems']['has_many']['NwReplies'] = array('foreign_key'=>'ID_NEWS');
$dbmap['NwReplies']['belongs_to']['NwItems'] = array('foreign_key'=>'ID_NEWS');

$dbmap['NwItemLocale']['has_many']['NwReplies'] = array('foreign_key'=>'ID_NEWS');
$dbmap['NwReplies']['belongs_to']['NwItemLocale'] = array('foreign_key'=>'ID_NEWS');

$dbmap['SnPlatforms']['has_many']['SnGames'] = array('foreign_key'=>'ID_PLATFORM', 'through'=>'sn_gameplatform_rel');
$dbmap['SnGames']['has_many']['SnPlatforms'] = array('foreign_key'=>'ID_GAME', 'through'=>'sn_gameplatform_rel');
$dbmap['NwReplies']['belongs_to']['Players'] = array('foreign_key'=>'ID_PLAYER');

$dbmap['SnGames']['has_many']['SnGamesPlatformsRel'] = array('foreign_key'=>'ID_GAME');
$dbmap['SnGamesPlatformsRel']['belongs_to']['SnGames'] = array('foreign_key'=>'ID_GAME');

$dbmap['SnPlatforms']['has_many']['SnGamesPlatformsRel'] = array('foreign_key'=>'ID_PLATFORM');
$dbmap['SnGamesPlatformsRel']['belongs_to']['SnPlatforms'] = array('foreign_key'=>'ID_PLATFORM');

$dbmap['SnGames']['has_many']['SnCompanyGameRel'] = array('foreign_key'=>'ID_GAME');
$dbmap['SnCompanyGameRel']['belongs_to']['SnGames'] = array('foreign_key'=>'ID_GAME');

//subscribtions
$dbmap['SnCompanies']['has_many']['SnPlayerCompanyRel'] = array('foreign_key'=>'ID_COMPANY');
$dbmap['SnPlayerCompanyRel']['belongs_to']['SnCompanies'] = array('foreign_key'=>'ID_COMPANY');

$dbmap['SnGames']['has_many']['SnPlayerGameRel'] = array('foreign_key'=>'ID_GAME');
$dbmap['SnPlayerGameRel']['belongs_to']['SnGames'] = array('foreign_key'=>'ID_GAME');

$dbmap['SnGroups']['has_many']['SnGroupAlliances'] = array('foreign_key'=>'ID_GROUP');
$dbmap['SnGroupAlliances']['belongs_to']['SnGroups'] = array('foreign_key'=>'ID_GROUP');


$dbmap['SnGroups']['has_many']['SnPlayerGroupRel'] = array('foreign_key'=>'ID_GROUP');
$dbmap['SnPlayerGroupRel']['belongs_to']['SnGroups'] = array('foreign_key'=>'ID_GROUP');

$dbmap['NwItems']['has_many']['NwPlayerNewsRel'] = array('foreign_key'=>'ID_NEWS');
$dbmap['NwPlayerNewsRel']['belongs_to']['NwItems'] = array('foreign_key'=>'ID_NEWS');
$dbmap['NwItems']['has_many']['NwItemLocale'] = array('foreign_key'=>'ID_NEWS');
$dbmap['NwItemLocale']['belongs_to']['NwItems'] = array('foreign_key'=>'ID_NEWS');
$dbmap['NwItems']['has_one']['Players'] = array('foreign_key'=>'ID_PLAYER');
$dbmap['Players']['belongs_to']['NwItems'] = array('foreign_key'=>'ID_AUTHOR');
$dbmap['NwItemLocale']['has_one']['Players'] = array('foreign_key'=>'ID_PLAYER');
$dbmap['Players']['belongs_to']['NwItemLocale'] = array('foreign_key'=>'ID_PLAYER');

$dbmap['NwItems']['has_one']['NwPrefixes'] = array('foreign_key'=>'ID_PREFIX'); 
$dbmap['NwPrefixes']['has_many']['NwItems'] = array('foreign_key'=>'ID_PREFIX');

$dbmap['NwPrefixes']['has_many']['NwPrefixLocale'] = array('foreign_key'=>'ID_PREFIX'); //test
$dbmap['NwPrefixlocale']['belongs_to']['NwPrefixes'] = array('foreign_key'=>'ID_PREFIX');

$dbmap['SnGames']['has_many']['NwItems'] = array('foreign_key'=>'ID_OWNER');
$dbmap['NwItems']['belongs_to']['SnGames'] = array('foreign_key'=>'ID_GAME');
$dbmap['SnCompanies']['has_many']['NwItems'] = array('foreign_key'=>'ID_OWNER');
$dbmap['NwItems']['belongs_to']['SnCompanies'] = array('foreign_key'=>'ID_COMPANY');
$dbmap['SnGroups']['has_many']['NwItems'] = array('foreign_key'=>'ID_OWNER');
$dbmap['NwItems']['belongs_to']['SnGroups'] = array('foreign_key'=>'ID_GROUP');

$dbmap['NwItemLocale']['has_many']['NwMostRead'] = array('foreign_key'=>'ID_NEWS');
$dbmap['NwMostRead']['belongs_to']['NwItemLocale'] = array('foreign_key'=>'ID_NEWS');
$dbmap['NwItems']['has_many']['NwMostRead'] = array('foreign_key'=>'ID_NEWS');
$dbmap['NwMostRead']['belongs_to']['NwItems'] = array('foreign_key'=>'ID_NEWS');

//notifications
$dbmap['SnNotifications']['has_many']['SnNotificationsSub'] = array('foreign_key'=>'ID_MAIN');
$dbmap['SnNotificationsSub']['belongs_to']['SnNotifications'] = array('foreign_key'=>'ID_FROM');
$dbmap['SnNotificationsSub']['belongs_to']['Players'] = array('foreign_key'=>'ID_PLAYER');

//forum
$dbmap['SnGames']['has_one']['FmCounters'] = array('foreign_key'=> 'ID_OWNER');
$dbmap['FmCounters']['has_one']['SnGames'] = array('foreign_key'=> 'ID_GAME');

$dbmap['SnCompanies']['has_one']['FmCounters'] = array('foreign_key'=> 'ID_OWNER');
$dbmap['FmCounters']['has_one']['SnCompanies'] = array('foreign_key'=> 'ID_COMPANY');

$dbmap['SnGroups']['has_one']['FmCounters'] = array('foreign_key'=> 'ID_OWNER');
$dbmap['FmCounters']['has_one']['SnGroups'] = array('foreign_key'=> 'ID_GROUP');

$dbmap['FmCategories']['has_one']['SnGames'] = array('foreign_key'=> 'ID_OWNER');
$dbmap['SnGames']['has_many']['FmCategories'] = array('foreign_key'=> 'ID_GAME');

$dbmap['FmBoards']['has_many']['FmMessages'] = array('foreign_key'=> 'ID_BOARD');
$dbmap['FmMessages']['belongs_to']['FmBoards'] = array('foreign_key'=> 'ID_BOARD');

$dbmap['FmTopics']['has_many']['FmMessages'] = array('foreign_key'=> 'ID_TOPIC');
$dbmap['FmMessages']['belongs_to']['FmTopics'] = array('foreign_key'=> 'ID_TOPIC');


$dbmap['FmMessages']['belongs_to']['Players'] = array('foreign_key' => 'ID_PLAYER');
$dbmap['Players']['has_many']['FmMessages'] = array('foreign_key' => 'ID_PLAYER');

//Events
$dbmap['EvCalendar']['belongs_to']['Players'] = array('foreign_key'=>'ID_PLAYER');
$dbmap['EvCalendar']['belongs_to']['EvEvents'] = array('foreign_key'=>'ID_EVENT');

$dbmap['EvEvents']['has_many']['EvCalendar'] = array('foreign_key'=>'ID_EVENT');
$dbmap['EvEvents']['belongs_to']['Players'] = array('foreign_key'=>'ID_PLAYER');
$dbmap['EvEvents']['has_many']['EvParticipants'] = array('foreign_key'=>'ID_EVENT');

$dbmap['EvParticipants']['belongs_to']['Players'] = array('foreign_key'=>'ID_PLAYER');
$dbmap['Players']['has_many']['EvParticipants'] = array('foreign_key'=>'ID_PLAYER');
$dbmap['EvParticipants']['belongs_to']['EvEvents'] = array('foreign_key'=>'ID_EVENT');

$dbmap['Players']['has_many']['EvCalendar'] = array('foreign_key'=>'ID_PLAYER');
$dbmap['Players']['has_many']['EvEvents'] = array('foreign_key'=>'ID_PLAYER');

$dbmap['SnGames']['has_many']['SnCompanyGameRel'] = array('foreign_key' => 'ID_GAME');
$dbmap['SnCompanies']['has_many']['SnCompanyGameRel'] = array('foreign_key' => 'ID_COMPANY');
$dbmap['SnCompanyGameRel']['belongs_to']['SnGames'] = array('foreign_key' => 'ID_GAME');
$dbmap['SnCompanyGameRel']['belongs_to']['SnCompanies'] = array('foreign_key' => 'ID_COMPANY');

$dbmap['FiCarts']['has_many']['FiCartProductRel'] = array('foreign_key' => 'ID_CART');
$dbmap['FiCartProductRel']['belongs_to']['FiCarts'] = array('foreign_key' => 'ID_CART');

$dbmap['FiCartProductRel']['belongs_to']['FiProducts'] = array('foreign_key' => 'ID_PRODUCT');
$dbmap['FiProducts']['has_many']['FiCartProductRel'] = array('foreign_key' => 'ID_PRODUCT');

$dbmap['FiProductInfo']['belongs_to']['FiProducts'] = array('foreign_key' => 'ID_PRODUCT');
$dbmap['FiProducts']['has_many']['FiProductInfo'] = array('foreign_key' => 'ID_PRODUCT');

$dbmap['FiPackages']['has_many']['FiFeatures'] = array('foreign_key' => 'ID_PACKAGE', 'through'=>'fi_packagefeature_rel');
$dbmap['FiFeatures']['has_many']['FiPackages'] = array('foreign_key' => 'ID_FEATURE', 'through'=>'fi_packagefeature_rel');

$dbmap['FiPackages']['has_many']['FiPlayerFeatureRel'] = array('foreign_key' => 'ID_PACKAGE');
$dbmap['FiPlayerFeatureRel']['belongs_to']['FiPackages'] = array('foreign_key' => 'ID_PACKAGE');

$dbmap['FiPackages']['has_many']['FiPackageFeatureRel'] = array('foreign_key' => 'ID_PACKAGE');
$dbmap['FiPackageFeatureRel']['belongs_to']['FiPackages'] = array('foreign_key' => 'ID_PACKAGE');

$dbmap['MeConversations']['has_many']['MeParticipants'] = array('foreign_key' => 'ID_CONVERSATION');
$dbmap['MeParticipants']['belongs_to']['MeConversations'] = array('foreign_key' => 'ID_CONVERSATION');

$dbmap['Players']['has_many']['MeParticipants'] = array('foreign_key'=>'ID_PLAYER');
$dbmap['MeParticipants']['belongs_to']['Players'] = array('foreign_key' => 'ID_PLAYER');

$dbmap['Players']['has_many']['MeMessages'] = array('foreign_key'=>'ID_PLAYER');
$dbmap['MeMessages']['belongs_to']['Players'] = array('foreign_key' => 'ID_PLAYER');

// RaidScheduler
//$dbmap['SnGames']['has_many']['SnGroups'] = array('foreign_key' => 'ID_GAME');
//$dbmap['SnGroups']['belongs_to']['SnGames'] = array('foreign_key' => 'ID_GAME');
//
//$dbmap['RsRoles']['has_many']['SnPlayerGameRel'] = array('foreign_key' => 'ID_GAME', 'through' => 'rs_gamerole_rel');
//$dbmap['SnPlayerGameRel']['belongs_to']['RsRoles'] = array('foreign_key' => 'ID_ROLE', 'through' => 'rs_gamerole_rel');
//
//$dbmap['RsRoles']['has_many']['RsGameRoleRel'] = array('foreign_key' => 'ID_ROLE');
//$dbmap['RsGameRoleRel']['belongs_to']['RsRoles'] = array('foreign_key' => 'ID_ROLE');
//
//$dbmap['SnPlayerGameRel']['has_many']['RsGameRoleRel'] = array('foreign_key' => 'ID_GAME');
//$dbmap['RsGameRoleRel']['has_many']['SnPlayerGameRel'] = array('foreign_key' => 'ID_GAME');

// Campaigns
$dbmap['SyCampaigns']['has_many']['SyCampaignBannerRel'] = array('foreign_key'=>'ID_CAMPAIGN');
$dbmap['SyCampaignBannerRel']['belongs_to']['SyCampaigns'] = array('foreign_key'=>'ID_CAMPAIGN');
$dbmap['SyCampaigns']['has_many']['SyBanners'] = array('foreign_key'=>'ID_CAMPAIGN', 'through'=>'sy_campaignbanner_rel');
$dbmap['SyBanners']['belongs_to']['SyCampaigns'] = array('foreign_key'=>'ID_BANNER', 'through'=>'sy_campaignbanner_rel');
// end Campaigns 

//Achievements
$dbmap['AcAchievements']['has_one']['AcBranches'] = array('foreign_key'=>'FK_BRANCH');
$dbmap['AcBranches']['belongs_to']['AcAchievements'] = array('foreign_key'=>'ID_BRANCH');

$dbmap['AcLevels']['has_one']['AcAchievements'] = array('foreign_key'=>'FK_ACHIEVEMENT');
$dbmap['AcAchievements']['belongs_to']['AcLevels'] = array('foreign_key'=>'ID_ACHIEVEMENT');

$dbmap['AcPlayerAchievementRel']['has_one']['AcAchievements'] = array('foreign_key'=>'FK_ACHIEVEMENT');
$dbmap['AcAchievements']['belongs_to']['AcPlayerAchievementRel'] = array('foreign_key'=>'ID_ACHIEVEMENT');

$dbmap['AcPlayerAchievementRel']['has_one']['Players'] = array('foreign_key'=>'FK_PLAYER');
$dbmap['Players']['belongs_to']['AcPlayerAchievementRel'] = array('foreign_key'=>'ID_PLAYER');

$dbmap['AcPlayerAchievementRel']['has_one']['AcLevels'] = array('foreign_key'=>'FK_LEVEL');
$dbmap['AcLevels']['belongs_to']['AcPlayerAchievementRel'] = array('foreign_key'=>'ID_LEVEL');

$dbmap['AcRankings']['has_one']['Players'] = array('foreign_key'=>'FK_PLAYER');
$dbmap['Players']['belongs_to']['AcRankings'] = array('foreign_key'=>'ID_PLAYER');

?>
