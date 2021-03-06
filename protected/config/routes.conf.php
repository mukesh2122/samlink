<?php
/**
 * Define your URI routes here.
 *
 * $route[Request Method][Uri] = array( Controller class, action method, other options, etc. )
 *
 * RESTful api support, *=any request method, GET PUT POST DELETE
 * POST 	Create
 * GET      Read
 * PUT      Update, Create
 * DELETE 	Delete
 *
 * Use lowercase for Request Method
 *
 * If you have your controller file name different from its class name, eg. home.php HomeController
 * $route['*']['/'] = array('home', 'index', 'className'=>'HomeController');
 *
 * If you need to reverse generate URL based on route ID with DooUrlBuilder in template view, please defined the id along with the routes
 * $route['*']['/'] = array('HomeController', 'index', 'id'=>'home');
 *
 * If you need dynamic routes on root domain, such as http://facebook.com/username
 * Use the key 'root':  $route['*']['root']['/:username'] = array('UserController', 'showProfile');
 *
 * If you need to catch unlimited parameters at the end of the url, eg. http://localhost/paramA/paramB/param1/param2/param.../.../..
 * Use the key 'catchall': $route['*']['catchall']['/:first'] = array('TestController', 'showAllParams');
 *
 * If you have placed your controllers in a sub folder, eg. /protected/admin/EditStuffController.php
 * $route['*']['/'] = array('admin/EditStuffController', 'action');
 *
 * If you want a module to be publicly accessed (without using Doo::app()->getModule() ) , use [module name] ,   eg. /protected/module/forum/PostController.php
 * $route['*']['/'] = array('[forum]PostController', 'action');
 *
 * If you create subfolders in a module,  eg. /protected/module/forum/post/ListController.php, the module here is forum, subfolder is post
 * $route['*']['/'] = array('[forum]post/PostController', 'action');
 *
 * Aliasing give you an option to access the action method/controller through a different URL. This is useful when you need a different url than the controller class name.
 * For instance, you have a ClientController::new() . By default, you can access via http://localhost/client/new
 *
 * $route['autoroute_alias']['/customer'] = 'ClientController';
 * $route['autoroute_alias']['/company/client'] = 'ClientController';
 *
 * With the definition above, it allows user to access the same controller::method with the following URLs:
 * http://localhost/company/client/new
 *
 * To define alias for a Controller inside a module, you may use an array:
 * $route['autoroute_alias']['/customer'] = array('controller'=>'ClientController', 'module'=>'example');
 * $route['autoroute_alias']['/company/client'] = array('controller'=>'ClientController', 'module'=>'example');
 *
 * Auto routes can be accessed via URL pattern: http://domain.com/controller/method
 * If you have a camel case method listAllUser(), it can be accessed via http://domain.com/controller/listAllUser or http://domain.com/controller/list-all-user
 * In any case you want to control auto route to be accessed ONLY via dashed URL (list-all-user)
 *
 * $route['autoroute_force_dash'] = true;	//setting this to false or not defining it will keep auto routes accessible with the 2 URLs.
 *
 */

$route['*']['/'] = array('MainController', 'index');
//$route['*']['catchall']['/:first'] = array('NewsController', 'showUrlContent');

$route['*']['/right-col'] = array('MainController', 'rightCol');
$route['*']['/error'] = array('ErrorController', 'error404');
$route['*']['/enable-js'] = array('ErrorController', 'enableJs');
$route['*']['/enable-cookie'] = array('ErrorController', 'enableCookie');
$route['*']['/lang/:langID'] = array('PlayersController', 'updateLang');
$route['*']['/joinus'] = array('MainController', 'joinus');
$route['*']['/info/joinus'] = array('MainController', 'joinus');
$route['*']['/joinus-successful'] = array('MainController', 'joinusSuccessful');
$route['*']['/join'] = array('MainController', 'join');

$route['*']['/livesearch'] = array('MainController', 'liveSearch');
$route['*']['/subPageSearch/:type'] = array('MainController', 'subPageSearch');
$route['*']['/search/:searchText'] = array('MainController', 'topSearch');
$route['*']['/search/:searchText/:page'] = array('MainController', 'topSearch');
$route['*']['/closeinfobox'] = array('MainController', 'closeInfoBox');
$route['*']['/popup/:id'] = array('MainController', 'popup');
$route['*']['/info/:id'] = array('MainController', 'info');
$route['*']['/block-visibility/:block_name/:block_val'] = array('MainController', 'updateBlockVisibility');
$route['*']['/ajaxsetpost'] = array('MainController', 'ajaxSetPost');
$route['*']['/ajaxgetposts'] = array('MainController', 'ajaxGetPosts');
$route['*']['/ajaxdeletepost'] = array('MainController', 'ajaxDeletePost');
$route['*']['/ajaxlike'] = array('MainController', 'ajaxToggleLike');
$route['*']['/ajaxsetreply'] = array('MainController', 'ajaxSetReply');
$route['*']['/ajaxgetreplieslist'] = array('MainController', 'ajaxGetRepliesList');
$route['*']['/ajaxdeletereply'] = array('MainController', 'ajaxDeleteReply');
$route['*']['/post'] = array('MainController', 'showPost');
$route['*']['/post/:post_id'] = array('MainController', 'showPost');
$route['*']['/ajaxtogglesubscription'] = array('MainController', 'ajaxToggleSubscription');
$route['*']['/ajaxshareonwall'] = array('MainController', 'ajaxShareOnWall');
$route['*']['/ajaxshareongroupwall'] = array('MainController', 'ajaxShareOnGroupWall');
$route['*']['/ajaxshowsharemessage'] = array('MainController', 'ajaxShowShareMessage');
$route['*']['/ajaxsharemessage'] = array('MainController', 'ajaxShareMessage');
$route['*']['/ajaxsetrole'] = array('MainController', 'ajaxSetRole');
$route['*']['/ajaxaddmemberrole'] = array('MainController', 'ajaxAddMemberRole');
$route['*']['/ajaxremovememberrole'] = array('MainController', 'ajaxRemoveMemberRole');

// login and registration
$route['*']['/signin'] = array('LoginController', 'signin'); // login page
$route['*']['/twitter'] = array('LoginController', 'twitterLogin');
$route['*']['/registration'] = array('LoginController', 'registration'); // register page
$route['*']['/login/ajaxregister'] = array('LoginController', 'ajaxRegister'); // register validation
$route['*']['/registration/:email'] = array('LoginController', 'registration');
$route['*']['/login/fblogin'] = array('LoginController', 'fblogin'); // facebook
$route['*']['/login/register'] = array('LoginController', 'twitterRegister'); // twitter
$route['*']['/login/logout'] = array('LoginController', 'Logout');
$route['*']['/players/logout'] = array('LoginController', 'Logout');
$route['*']['/login/registration-successful'] = array('LoginController', 'registrationSuccessful');
$route['*']['/login/activate/:code'] = array('LoginController', 'activate');
$route['*']['/login/reset-password/:code'] = array('LoginController', 'resetPassword');
$route['*']['/login/ajaxloginbox'] = array('LoginController', 'ajaxLoginBox'); // not used ??
$route['*']['/login/ajaxregisterbox'] = array('LoginController', 'ajaxRegisterBox'); // not used ??
$route['*']['/login/ajaxforgotpass'] = array('LoginController', 'ajaxForgotPass');
$route['*']['/login/ajaxloginvalidate'] = array('LoginController', 'ajaxLoginValidate');
$route['*']['/players/ajaxloginvalidate'] = array('LoginController', 'ajaxLoginValidate');
$route['*']['/login/validatemail'] = array('LoginController', 'validateMail');
$route['*']['/players/ajaxpassrecovery'] = array('LoginController', 'ajaxPassRecovery');
//failroutes *acl.conf.php*
$route['*']['/login/loginfirst'] = array('LoginController', 'loginFirst'); // login redirect after trying to access member areas
$route['*']['/login/loginfirst/:item'] = array('LoginController', 'loginFirst'); // not used ??

// bottombar developer menu
$route['*']['/admin/devmenu/:action'] = array('BottommenuController', 'index');

// twitch
$route['*']['/twitchlogin'] = array('TwitchController', 'twitchLogin');
$route['*']['/twitchlogout'] = array('TwitchController', 'twitchLogout');
$route['*']['/twitchfeatured'] = array('TwitchController', 'twitchGetFeatured');
$route['*']['/twitchfollowed'] = array('TwitchController', 'twitchGetFollowed');

// chat
$route['*']['/bottomchat'] = array('ChatController', 'index');

// translate
$route['*']['/translate/:type/:id'] = array('TranslateController', 'index');
$route['*']['/translate/save'] = array('TranslateController', 'save');

//players section
$route['*']['/players'] = array('PlayersController', 'index');
$route['*']['/players/tab'] = array('PlayersController', 'index');
$route['*']['/players/tab/:tab'] = array('PlayersController', 'index');
$route['*']['/players/tab/:tab/:order'] = array('PlayersController', 'index');
$route['*']['/players/get-players'] = array('PlayersController', 'getPlayersAjax');

$route['*']['/players/top-list'] = array('PlayersController', 'topList');
$route['*']['/players/top-list/tab'] = array('PlayersController', 'topList');
$route['*']['/players/top-list/tab/:tab'] = array('PlayersController', 'topList');
$route['*']['/players/top-list/tab/:tab/:order'] = array('PlayersController', 'topList');

$route['*']['/players/edit'] = array('PlayersController', 'editProfile');
$route['*']['/players/edit/:section'] = array('PlayersController', 'editProfile');
$route['*']['/players/edit/:section/sort-by/:order'] = array('PlayersController', 'editProfile');
$route['*']['/players/invite'] = array('PlayersController', 'invite');
$route['*']['/players/ajaxgetcontactlist'] = array('PlayersController', 'ajaxGetContactList');
$route['*']['/players/search/:searchText'] = array('PlayersController', 'search');
$route['*']['/players/search/:searchText/:page'] = array('PlayersController', 'search');
$route['*']['/players/editprofileaction'] = array('PlayersController', 'editProfileAction');
$route['*']['/players/editprofileaction/:section'] = array('PlayersController', 'editProfileAction');
$route['*']['/players/edit/enableprofile'] = array('PlayersController', 'enableProfile');
$route['*']['/players/edit/disableprofile'] = array('PlayersController', 'disableProfile');

$route['*']['/players/wall'] = array('PlayersController', 'wall');
$route['*']['/players/wall/:type'] = array('PlayersController', 'wall');
$route['*']['/players/wall/:type/:id_album'] = array('PlayersController', 'wall');

$route['*']['/players/edit_post/:type/:id'] = array('PlayersController', 'editPost');
$route['*']['/players/edit_album/:type/:id'] = array('PlayersController', 'editAlbum');
$route['*']['/players/remove_album/:type/:id'] = array('PlayersController', 'removeAlbum');

$route['*']['/players/my-subscriptions'] = array('PlayersController', 'mySubscriptions');
$route['*']['/players/my-subscriptions/page/:page'] = array('PlayersController', 'mySubscriptions');
$route['*']['/players/my-subscriptions/:type'] = array('PlayersController', 'mySubscriptions');
$route['*']['/players/my-subscriptions/:type/page/:page'] = array('PlayersController', 'mySubscriptions');
$route['*']['/players/my-subscriptions/search/:search'] = array('PlayersController', 'mySubscriptions');
$route['*']['/players/my-subscriptions/search/:search/page/:page'] = array('PlayersController', 'mySubscriptions');
$route['*']['/players/my-friends'] = array('PlayersController', 'myFriends');
$route['*']['/players/my-friends/page/:page'] = array('PlayersController', 'myFriends');
$route['*']['/players/my-friends/search/:search'] = array('PlayersController', 'myFriends');
$route['*']['/players/my-friends/search/:search/page/:page'] = array('PlayersController', 'myFriends');
$route['*']['/players/my-friends/cat/:cat'] = array('PlayersController', 'myFriends');
$route['*']['/players/my-friends/cat/:cat/page/:page'] = array('PlayersController', 'myFriends');
$route['*']['/players/my-friends/cat/:cat/search/:search'] = array('PlayersController', 'myFriends');
$route['*']['/players/my-friends/cat/:cat/search/:search/page/:page'] = array('PlayersController', 'myFriends');
$route['*']['/players/my-blocks'] = array('PlayersController', 'myBlocks');
$route['*']['/players/my-events'] = array('PlayersController', 'myEvents');
$route['*']['/players/my-events/page/:page'] = array('PlayersController', 'myEvents');
$route['*']['/players/my-events/search/:search'] = array('PlayersController', 'myEvents');
$route['*']['/players/my-events/search/:search/page/:page'] = array('PlayersController', 'myEvents');
$route['*']['/players/my-groups'] = array('PlayersController', 'myGroups');
$route['*']['/players/my-groups/page/:page'] = array('PlayersController', 'myGroups');
$route['*']['/players/my-groups/search/:search'] = array('PlayersController', 'myGroups');
$route['*']['/players/my-groups/search/:search/page/:page'] = array('PlayersController', 'myGroups');
$route['*']['/players/my-games'] = array('PlayersController', 'myGames');
$route['*']['/players/my-games/page/:page'] = array('PlayersController', 'myGames');
$route['*']['/players/my-games/search/:search'] = array('PlayersController', 'myGames');
$route['*']['/players/my-games/search/:search/page/:page'] = array('PlayersController', 'myGames');
$route['*']['/players/my-achievements'] = array('PlayersController', 'myAchievements');
$route['*']['/players/my-achievements/:ach_id'] = array('PlayersController', 'myAchievements');
$route['*']['/players/my-achievements/rankings'] = array('PlayersController', 'achievementsRanking');
$route['*']['/players/my-achievements/rankings/page'] = array('PlayersController', 'achievementsRanking');
$route['*']['/players/my-achievements/rankings/page/:page'] = array('PlayersController', 'achievementsRanking');
$route['*']['/players/my-achievements/friends-ranking'] = array('PlayersController', 'achievementsFriendsRanking');
$route['*']['/players/my-achievements/friends-ranking/page'] = array('PlayersController', 'achievementsFriendsRanking');
$route['*']['/players/my-achievements/friends-ranking/page/:page'] = array('PlayersController', 'achievementsFriendsRanking');

$route['*']['/players/my-game-description/:game'] = array('PlayersController', 'addGameDescription');
$route['*']['/players/save-game-description'] = array('PlayersController', 'saveGameDescription');
$route['*']['/players/invite-friends'] = array('PlayersController', 'inviteFriends');

$route['*']['/player/:player_url'] = array('PlayersController', 'wall');
$route['*']['/player/:player_url/friends'] = array('PlayersController', 'playerFriends');
$route['*']['/player/:player_url/friends/page/:page'] = array('PlayersController', 'playerFriends');
$route['*']['/player/:player_url/friends/search/:search'] = array('PlayersController', 'playerFriends');
$route['*']['/player/:player_url/friends/search/:search/page/:page'] = array('PlayersController', 'playerFriends');
$route['*']['/player/:player_url/friends/cat/:cat'] = array('PlayersController', 'playerFriends');
$route['*']['/player/:player_url/friends/cat/:cat/page/:page'] = array('PlayersController', 'playerFriends');
$route['*']['/player/:player_url/friends/cat/:cat/search/:search'] = array('PlayersController', 'playerFriends');
$route['*']['/player/:player_url/friends/cat/:cat/search/:search/page/:page'] = array('PlayersController', 'playerFriends');

$route['*']['/player/:player_url/blog/:blog'] = array('BlogController', 'articleView');

$route['*']['/player/:player_url/wall'] = array('PlayersController', 'wall');
$route['*']['/player/:player_url/wall/:type'] = array('PlayersController', 'wall');
$route['*']['/player/:player_url/wall/:type/page/:page'] = array('PlayersController', 'wall');
$route['*']['/player/:player_url/wall/:type/:id_album'] = array('PlayersController', 'wall');
$route['*']['/player/:player_url/groups'] = array('PlayersController', 'playerGroups');
$route['*']['/player/:player_url/groups/page/:page'] = array('PlayersController', 'playerGroups');
$route['*']['/player/:player_url/groups/search/:search'] = array('PlayersController', 'playerGroups');
$route['*']['/player/:player_url/groups/search/:search/page/:page'] = array('PlayersController', 'playerGroups');
$route['*']['/player/:player_url/achievements'] = array('PlayersController', 'playerAchievements');
$route['*']['/player/:player_url/games'] = array('PlayersController', 'playerGames');
$route['*']['/player/:player_url/games/page/:page'] = array('PlayersController', 'playerGames');
$route['*']['/player/:player_url/games/search/:search'] = array('PlayersController', 'playerGames');
$route['*']['/player/:player_url/games/search/:search/page/:page'] = array('PlayersController', 'playerGames');
$route['*']['/player/:player_url/events'] = array('PlayersController', 'playerEvents');
$route['*']['/player/:player_url/events/page/:page'] = array('PlayersController', 'playerEvents');
$route['*']['/player/:player_url/events/search/:search'] = array('PlayersController', 'playerEvents');
$route['*']['/player/:player_url/events/search/:search/page/:page'] = array('PlayersController', 'playerEvents');
$route['*']['/players/notifications'] = array('PlayersController', 'notifications');
$route['*']['/players/notifications/page/:page'] = array('PlayersController', 'notifications');
$route['*']['/players/notifications/search/:search'] = array('PlayersController', 'notifications');
$route['*']['/players/notifications/search/:search/page/:page'] = array('PlayersController', 'notifications');
$route['*']['/players/messages'] = array('PlayersController', 'messages');
$route['*']['/players/messages/read'] = array('PlayersController', 'messageRead');
$route['*']['/players/messages/read/:url'] = array('PlayersController', 'messageRead');
$route['*']['/players/messages/read/:url/page/:page'] = array('PlayersController', 'messageRead');
$route['*']['/players/messages/page/:page'] = array('PlayersController', 'messages');
$route['*']['/players/messages/sent'] = array('PlayersController', 'messagesSent');
$route['*']['/players/messages/sent/page/:page'] = array('PlayersController', 'messagesSent');
$route['*']['/players/conversations'] = array('PlayersController', 'conversations');
$route['*']['/players/conversations/page/:page'] = array('PlayersController', 'conversations');
$route['*']['/players/conversations/read/:id'] = array('PlayersController', 'conversationRead');
$route['*']['/players/conversations/read/:id/page/:page'] = array('PlayersController', 'conversationRead');
$route['post']['/players/updateprofile'] = array('PlayersController', 'updateProfile');
$route['*']['/players/finishstep'] = array('PlayersController', 'finishStep');
$route['*']['/player/disabled'] = array('PlayersController', 'disabled');

// KiC - Begin
$route['*']['/players/feedback'] = array('FeedbackController', 'index');
$route['*']['/players/feedback/page/:page'] = array('FeedbackController', 'index');
$route['*']['/players/feedback/new'] = array('FeedbackController', 'newFeedbackReport');
$route['*']['/players/feedback/edit/:error_id'] = array('FeedbackController', 'edit');
$route['*']['/players/feedback/edit/:error_id/image'] = array('FeedbackController', 'ajaxScreenshotView');
$route['*']['/players/feedback/ajaxuploadscreenshot/:error_id'] = array('FeedbackController', 'ajaxUploadScreenshot');
$route['*']['/players/feedback/sort/:sortType/:sortDir'] = array('FeedbackController', 'index');
$route['*']['/players/feedback/sort/:sortType/:sortDir/page/:page'] = array('FeedbackController', 'index');
$route['*']['/players/feedback/:type_id'] = array('FeedbackController', 'index');
$route['*']['/players/feedback/:type_id/page/:page'] = array('FeedbackController', 'index');
$route['*']['/players/feedback/:type_id/sort/:sortType/:sortDir'] = array('FeedbackController', 'index');
$route['*']['/players/feedback/:type_id/sort/:sortType/:sortDir/page/:page'] = array('FeedbackController', 'index');
$route['*']['/players/ajaxuploadscreenshot/:error_id'] = array('FeedbackController', 'ajaxUploadScreenshot');
// KiC - End

//ajax methods for players
$route['*']['/players/iframeshowphoto/:id_wallitem/:item_type'] = array('PlayersController', 'iframeShowPhoto');
$route['*']['/players/iframeshowphotopopup/:id_wallitem/:item_type'] = array('PlayersController', 'iframeShowPhotoPopup');
$route['*']['/players/iframeshowphototag/:id_wallitem/:item_type'] = array('PlayersController', 'iframeShowPhotoTag');
$route['*']['/players/ajaxphototag'] = array('PlayersController', 'ajaxPhotoTag');
$route['*']['/players/ajaxphotountag'] = array('PlayersController', 'ajaxPhotoUntag');
$route['*']['/players/ajaxtogglepublic'] = array('PlayersController', 'ajaxTogglePublic');
$route['*']['/players/ajaxuploadphoto'] = array('PlayersController', 'ajaxUploadPhoto');
$route['*']['/players/ajaxuploadphoto/:user_id'] = array('PlayersController', 'ajaxUploadPhoto');
$route['*']['/players/ajaxwalluploadphoto'] = array('PlayersController', 'ajaxWallUploadPhoto');
$route['*']['/players/ajaxwalluploadphoto/:empty'] = array('PlayersController', 'ajaxWallUploadPhoto');
$route['*']['/players/ajaxupdateprofile'] = array('PlayersController', 'ajaxUpdateProfile');
$route['*']['/players/ajaxgetfriends'] = array('PlayersController', 'ajaxGetFriends');
$route['*']['/players/ajaxdeletefriend'] = array('PlayersController', 'ajaxDeleteFriend');
$route['*']['/players/ajaxhideplayersuggestion'] = array('PlayersController', 'ajaxHidePlayerSuggestion');
$route['*']['/players/ajaxinsertfriend'] = array('PlayersController', 'ajaxInsertFriend');
$route['*']['/players/ajaxrejectfriend'] = array('PlayersController', 'ajaxRejectFriend');
$route['*']['/players/ajaxgetnotifications'] = array('PlayersController', 'ajaxGetNotifications');
$route['*']['/players/ajaxgetsendmessage'] = array('PlayersController', 'ajaxGetSendMessage'); // To be removed
$route['*']['/players/ajaxreplymessage'] = array('PlayersController', 'ajaxReplyMessage'); // To be removed
$route['*']['/players/ajaxgetsendmessage/:friend_url'] = array('PlayersController', 'ajaxGetSendMessage'); // To be removed
$route['*']['/players/ajaxgetsendmessage/:friend_url/:message_id'] = array('PlayersController', 'ajaxGetSendMessage'); // To be removed
$route['*']['/players/ajaxsendmessage'] = array('PlayersController', 'ajaxSendMessage');
$route['*']['/players/ajaxblockuser'] = array('PlayersController', 'ajaxBlockUser');
$route['*']['/players/ajaxreplyconvmessage'] = array('PlayersController', 'ajaxReplyConvMessage');
$route['*']['/players/ajaxsendconvmessage/:conversation_id'] = array('PlayersController', 'ajaxSendConvMessage');
$route['*']['/players/ajaxsendoutsideconvmessage'] = array('PlayersController', 'ajaxSendOutsideConvMessage');
$route['*']['/players/ajaxfindfriend'] = array('PlayersController', 'ajaxFindFriend');
$route['*']['/players/ajaxdeletemessageitem'] = array('PlayersController', 'ajaxDeleteMessageItem');
$route['*']['/players/ajaxdeleteallmessages'] = array('PlayersController', 'ajaxDeleteAllMessages');
$route['*']['/players/ajaxtoggleisplayinggame'] = array('PlayersController', 'ajaxToggleIsPlayingGame');
$route['*']['/players/ajaxrate'] = array('PlayersController', 'ajaxRate');
$route['*']['/players/ajaxgetratinginfo'] = array('PlayersController', 'ajaxGetRating');
$route['*']['/players/ajaxsearchplayers'] = array('PlayersController', 'ajaxSearchPlayers');
$route['*']['/players/ajaxaddfriends'] = array('PlayersController', 'ajaxAddFriends');
$route['*']['/players/ajaxopeninviter'] = array('PlayersController', 'ajaxOpenInviter');
$route['*']['/players/ajaxsiteinvite'] = array('PlayersController', 'ajaxSiteInvite');
$route['*']['/players/ajaxaddgroups'] = array('PlayersController', 'ajaxAddGroups');
$route['*']['/players/ajaxaddgames'] = array('PlayersController', 'ajaxAddGames');
$route['*']['/players/ajaxgetftustep'] = array('PlayersController', 'ajaxGetFTUStep');
$route['*']['/players/ajaxsimpleinvite'] = array('PlayersController', 'ajaxSimpleInvite');
$route['*']['/player/ajaxfindplayergroups'] = array('PlayersController', 'ajaxFindPlayerGroups');

$route['*']['/players/ajaxchangeemail'] = array('PlayersController', 'ajaxChangeEmail');
$route['*']['/players/ajaxchangeemailsubmit'] = array('PlayersController', 'ajaxChangeemailSubmit');
$route['*']['/players/ajaxchangeemaildone'] = array('PlayersController', 'ajaxChangeemailDone');
$route['*']['/players/ajaxwidgetstatus'] = array('PlayersController', 'ajaxChangeWidgetStatus');
$route['*']['/players/ajaxwidgetvisibility'] = array('PlayersController', 'ajaxChangeWidgetVisibility');


$route['*']['/players/category/:ID_CATEGORY'] = array('PlayersController', 'index');
$route['*']['/players/category/:ID_CATEGORY/tab'] = array('PlayersController', 'index');
$route['*']['/players/category/:ID_CATEGORY/tab/:tab'] = array('PlayersController', 'index');
$route['*']['/players/category/:ID_CATEGORY/tab/:tab/:order'] = array('PlayersController', 'index');

$route['*']['/players/top-list/category/:ID_CATEGORY'] = array('PlayersController', 'topList');
$route['*']['/players/top-list/category/:ID_CATEGORY/tab'] = array('PlayersController', 'topList');
$route['*']['/players/top-list/category/:ID_CATEGORY/tab/:tab'] = array('PlayersController', 'topList');
$route['*']['/players/top-list/category/:ID_CATEGORY/tab/:tab/:order'] = array('PlayersController', 'topList');

//bottommenu
 $route['*']['/menu_bottom/popup/:menu_url'] = array('BottommenuController', 'menupop');

//News related
$route['*']['/news'] = array('NewsController', 'index');
$route['*']['/news/page/:page'] = array('NewsController', 'index');

$route['*']['/news/recent'] = array('NewsController', 'recentNews');
$route['*']['/news/recent/page/:page'] = array('NewsController', 'recentNews');

$route['*']['/news/popular'] = array('NewsController', 'popularNews');
$route['*']['/news/popular/page/:page'] = array('NewsController', 'popularNews');

$route['*']['/news/platforms'] = array('NewsController', 'platformNews');
$route['*']['/news/platforms/page/:page'] = array('NewsController', 'platformNews');
$route['*']['/news/platforms/:platform/:close'] = array('NewsController', 'specificPlatformNews');
$route['*']['/news/platforms/:platform/page/:page/:close'] = array('NewsController', 'specificPlatformNews');

$route['*']['/news/companies'] = array('NewsController', 'allCompanies');
$route['*']['/news/companies/page/:page'] = array('NewsController', 'allCompanies');
$route['*']['/news/companies/:company'] = array('NewsController', 'companyNews');
$route['*']['/news/companies/:company/page/:page'] = array('NewsController', 'companyNews');
$route['*']['/news/companies/search/:searchText'] = array('NewsController', 'searchCompanies');
$route['*']['/news/companies/search/:searchText/page/:page'] = array('NewsController', 'searchCompanies');

$route['*']['/news/games'] = array('NewsController', 'allGames');
$route['*']['/news/games/page/:page'] = array('NewsController', 'allGames');
$route['*']['/news/game/:game'] = array('NewsController', 'gameNews');
$route['*']['/news/game/:game/page/:page'] = array('NewsController', 'gameNews');
$route['*']['/news/games/search/:searchText'] = array('NewsController', 'searchGames');
$route['*']['/news/games/search/:searchText/page/:page'] = array('NewsController', 'searchGames');

$route['*']['/news/countries/all'] = array('NewsController', 'allCountries');
$route['*']['/news/countries/all/:letter'] = array('NewsController', 'allCountries');
$route['*']['/news/country/:country'] = array('NewsController', 'allCountries');
$route['*']['/news/country/:country/:page'] = array('NewsController', 'allCountries');
$route['*']['/news/search/:searchText'] = array('NewsController', 'search');
$route['*']['/news/search/:searchText/:page'] = array('NewsController', 'search');
$route['*']['/news/view/:lang/:article'] = array('NewsController', 'articleView');
$route['*']['/news/:article'] = array('NewsController', 'articleView');
$route['*']['/news/delete/:news_id'] = array('NewsController', 'deleteNews');
$route['*']['/news/unpublish/:news_id/:lang_id'] = array('NewsController', 'unpublishReview');

$route['*']['/news/searchAdv'] = array('NewsController', 'searchAdvIndex'); 
$route['*']['/news/searchAdvResult'] = array('NewsController', 'searchAdv');

$route['*']['/news/tab'] = array('NewsController', 'index');
$route['*']['/news/tab/:tab'] = array('NewsController', 'index');
$route['*']['/news/tab/:tab/:order'] = array('NewsController', 'index');
$route['*']['/news/tab/:tab/:order/page/:page'] = array('NewsController', 'index');

$route['*']['/news/prefixes/:searchText'] = array('NewsController', 'searchPrefix'); //test

//Reviews
$route['*']['/reviews'] = array('NewsController', 'reviews');
$route['*']['/reviews/page/:page'] = array('NewsController', 'reviews');

//Blog related
$route['*']['/blog'] = array('BlogController', 'index');
$route['*']['/blog/page/:page'] = array('BlogController', 'index');
$route['*']['/blog/all-news'] = array('BlogController', 'index');

$route['*']['/blog/recent'] = array('BlogController', 'recentBlog');
$route['*']['/blog/recent/page/:page'] = array('BlogController', 'recentBlog');

$route['*']['/blog/popular'] = array('BlogController', 'popularBlog');
$route['*']['/blog/popular/page/:page'] = array('BlogController', 'popularBlog');

$route['*']['/blog/bloggers'] = array('BlogController', 'bloggersBlog');
$route['*']['/blog/bloggers/page/:page'] = array('BlogController', 'bloggersBlog');

$route['*']['/blog/countries/all'] = array('BlogController', 'allCountries');
$route['*']['/blog/countries/all/:letter'] = array('BlogController', 'allCountries');
$route['*']['/blog/country/:country'] = array('BlogController', 'allCountries');
$route['*']['/blog/country/:country/:page'] = array('BlogController', 'allCountries');
$route['*']['/blog/search/:searchText'] = array('BlogController', 'search');
$route['*']['/blog/search/:searchText/:page'] = array('BlogController', 'search');
$route['*']['/blog/view/:lang/:article'] = array('BlogController', 'articleView');
$route['*']['/blog/delete/:news_id'] = array('BlogController', 'deleteBlog');

$route['*']['/blog/addblog'] = array('BlogController', 'addBlog');
$route['*']['/blog/editblog/:news_id'] = array('BlogController', 'editBlog');

$route['*']['/blog/ajaxcropphoto/:id/:orientation/:ownertype'] = array('GamesController', 'ajaxCropPhoto');
$route['*']['/blog/ajaxuploadphoto/:news_id'] = array('BlogController', 'ajaxUploadPhoto');

//news ajax actions
$route['*']['/news/ajaxuploadphoto/:news_id'] = array('NewsController', 'ajaxUploadPhoto');
$route['*']['/news/ajaxcropphoto/:id/:orientation/:ownertype'] = array('GamesController', 'ajaxCropPhoto');
$route['*']['/news/ajaxupdateplatforms/:game_id'] = array('NewsController', 'ajaxUpdatePlatforms');

$route['*']['/news/ajaxliketoggle'] = array('NewsController', 'ajaxLikeToggle');
$route['*']['/news/ajaxsetreply'] = array('NewsController', 'ajaxSetReply');
$route['*']['/news/ajaxdeletereply'] = array('NewsController', 'ajaxDeleteReply');
$route['*']['/news/ajaxgetreplieslist'] = array('NewsController', 'ajaxGetRepliesList');

//companies
$route['*']['/companies'] = array('CompaniesController', 'index');
$route['*']['/companies/tab'] = array('CompaniesController', 'index');
$route['*']['/companies/tab/:tab'] = array('CompaniesController', 'index');
$route['*']['/companies/tab/:tab/:order'] = array('CompaniesController', 'index');
$route['*']['/companies/tab/:tab/:order/page/:page'] = array('CompaniesController', 'index');

//$route['*']['/companies/publisher'] = array('CompaniesController', 'publisherCompanies');
//$route['*']['/companies/publisher/page/:page'] = array('CompaniesController', 'publisherCompanies');

/*
$route['*']['/companies/downloads'] = array('CompaniesController', 'allDownloads');
$route['*']['/companies/downloads/page/:page'] = array('CompaniesController', 'allDownloads');
$route['*']['/company/:company/downloads'] = array('CompaniesController', 'downloadsView');
$route['*']['/company/:company/downloads/:tab_id'] = array('CompaniesController', 'downloadsView');
$route['*']['/company/savedownloadtab'] = array('CompaniesController', 'saveDownloadTab');
$route['*']['/company/savedownload'] = array('CompaniesController', 'saveDownload');
$route['*']['/company/deletedownload'] = array('CompaniesController', 'deleteDownload');
*/

$route['*']['/companies/ajaxgetratinginfo'] = array('CompaniesController', 'ajaxGetRating');
$route['*']['/companies/ajaxrate'] = array('CompaniesController', 'ajaxRate');

$route['*']['/company/:company'] = array('CompaniesController', 'companyView');
$route['*']['/company/:company/news'] = array('CompaniesController', 'newsView');
$route['*']['/company/:company/news/page/:page'] = array('CompaniesController', 'newsView');
$route['*']['/company/:company/news/search/:searchText'] = array('CompaniesController', 'searchNews');
$route['*']['/company/:company/news/search/:searchText/page/:page'] = array('CompaniesController', 'searchNews');
$route['*']['/company/:company/news/:lang/:article'] = array('CompaniesController', 'newsItemView');

$route['*']['/companies/ajaxtogglelike'] = array('CompaniesController', 'ajaxToggleLike');

$route['*']['/companies/search'] = array('CompaniesController', 'search');
$route['*']['/companies/search/:searchText'] = array('CompaniesController', 'search');
$route['*']['/companies/search/:searchText/page/:page'] = array('CompaniesController', 'search');

$route['*']['/companies/ajaxfindcompany'] = array('CompaniesController', 'ajaxFindCompany');

$route['*']['/company/:company/games'] = array('CompaniesController', 'gamesView');
$route['*']['/company/:company/media'] = array('CompaniesController', 'mediaView');
$route['*']['/company/:company/media/:tab'] = array('CompaniesController', 'mediaView');
$route['*']['/company/:company/media/:tab/:media_id'] = array('CompaniesController', 'ajaxMediaView');

//companies ajax
$route['*']['/company/ajaxcropphoto/:id/:orientation/:ownertype'] = array('GamesController', 'ajaxCropPhoto');

$route['*']['/company/ajaxuploadphoto/:company_id'] = array('CompaniesController', 'ajaxUploadPhoto');
$route['*']['/company/ajaxcountdownload'] = array('CompaniesController', 'ajaxCountDownload');
$route['*']['/company/ajaxuploadmultiphoto/:company_id'] = array('CompaniesController', 'ajaxUploadMultiPhoto');
$route['*']['/company/ajaxuploadmultivideo/:company_id'] = array('CompaniesController', 'ajaxUploadMultiVideo');

//companies admin
$route['*']['/company/:company/admin/add-news'] = array('CompaniesController', 'addNews');
$route['*']['/company/:company/admin/edit-news/:news_id'] = array('CompaniesController', 'chooseLang');
$route['*']['/company/:company/admin/edit-news/:news_id/:lang_id'] = array('CompaniesController', 'editNews');
$route['*']['/company/:company/admin/translate-news/:news_id'] = array('CompaniesController', 'translateNews');

$route['*']['/company/:company/admin/editcompanyinfo'] = array('CompaniesController', 'editCompanyInfo');
$route['*']['/company/:company/admin/adddownloadtab'] = array('CompaniesController', 'addDownloadTab');
$route['*']['/company/:company/admin/editdownloadtab'] = array('CompaniesController', 'editDownloadTab');
$route['*']['/company/:company/admin/deletedownloadtab'] = array('CompaniesController', 'deleteDownloadTab');
$route['*']['/company/:company/admin/adddownload'] = array('CompaniesController', 'addDownload');
$route['*']['/company/:company/admin/editdownload/:download_id'] = array('CompaniesController', 'editDownload');
$route['*']['/company/:company/admin/addmedia'] = array('CompaniesController', 'addMedia');
$route['*']['/company/:company/admin/addgame'] = array('CompaniesController', 'addGame');
$route['*']['/company/updatecompanyinfo'] = array('CompaniesController', 'updateCompanyInfo');
$route['*']['/company/savegame'] = array('CompaniesController', 'saveGame');
$route['*']['/company/:company/admin/deletemedia'] = array('CompaniesController', 'deleteMedia');
$route['*']['/company/:company/admin/editmedia/:media_id'] = array('CompaniesController', 'editMedia');
$route['*']['/company/:company/admin/savemedia'] = array('CompaniesController', 'saveMedia');

//games
$route['*']['/games/search'] = array('GamesController', 'search');
$route['*']['/games/search/:searchText'] = array('GamesController', 'search');
$route['*']['/games/search/:searchText/page/:page'] = array('GamesController', 'search');

$route['*']['/games/ajaxgetratinginfo'] = array('GamesController', 'ajaxGetRating');
$route['*']['/games/ajaxrate'] = array('GamesController', 'ajaxRate');
$route['*']['/games/ajaxrate/:ourl/:rating'] = array('GamesController', 'ajaxRate');

$route['*']['/games/ajaxfindgame'] = array('GamesController', 'ajaxFindGame');
$route['*']['/games/ajaxtogglelike'] = array('GamesController', 'ajaxToggleLike');
$route['*']['/games/ajaxsearchgames'] = array('GamesController', 'ajaxSearchGames');

$route['*']['/games'] = array('GamesController', 'index');
$route['*']['/games/:category'] = array('GamesController', 'index');
$route['*']['/games/:category/:genre'] = array('GamesController', 'index');
$route['*']['/games/:category/:genre/tab'] = array('GamesController', 'index');
$route['*']['/games/:category/:genre/tab/:tab'] = array('GamesController', 'index');
$route['*']['/games/:category/:genre/tab/:tab/:order'] = array('GamesController', 'index');
$route['*']['/games/:category/:genre/tab/:tab/:order/page'] = array('GamesController', 'index');
$route['*']['/games/:category/:genre/tab/:tab/:order/page/:page'] = array('GamesController', 'index');

// Temporary hacky route fix (games filtering doesn't work)
$route['*']['/games/:genre/tab/:tab/:order'] = array('GamesController', 'index');

$route['*']['/game/:game'] = array('GamesController', 'gameView');
$route['*']['/game/:game/page/:page'] = array('GamesController', 'gameView');
$route['*']['/game/:game/search/:search'] = array('GamesController', 'gameView');
$route['*']['/game/:game/search/:search/page/:page'] = array('GamesController', 'gameView');

$route['*']['/game/:game/play'] = array('GamesController', 'gamePlayView');

$route['*']['/game/:game/news'] = array('GamesController', 'newsView');
$route['*']['/game/:game/reviews'] = array('GamesController', 'reviews');
$route['*']['/game/:game/unpublished-reviews'] = array('GamesController', 'unpublishedReviews');
$route['*']['/game/:game/unpublished-reviews/page/:page'] = array('GamesController', 'unpublishedReviews');
$route['*']['/game/:game/reviews/page/:page'] = array('GamesController', 'reviews');
$route['*']['/game/:game/review/:lang/:article'] = array('GamesController', 'reviewItemView');
$route['*']['/game/:game/add-review'] = array('GamesController', 'addReview');
$route['*']['/game/:game/news/page/:page'] = array('GamesController', 'newsView');
$route['*']['/game/:game/news/search/:searchText'] = array('GamesController', 'searchNews');
$route['*']['/game/:game/news/search/:searchText/page/:page'] = array('GamesController', 'searchNews');
$route['*']['/game/:game/news/:lang/:article'] = array('GamesController', 'newsItemView');
$route['*']['/game/:game/players'] = array('GamesController', 'playersView');
$route['*']['/game/:game/players/page/:page'] = array('GamesController', 'playersView');
$route['*']['/game/:game/members'] = array('GamesController', 'membersView');
$route['*']['/game/:game/members/page/:page'] = array('GamesController', 'membersView');
$route['*']['/game/:game/media'] = array('GamesController', 'mediaView');
$route['*']['/game/:game/media/:tab'] = array('GamesController', 'mediaView');
$route['*']['/game/:game/downloads'] = array('GamesController', 'downloadsView');
$route['*']['/game/:game/downloads/:tab_id'] = array('GamesController', 'downloadsView');
$route['*']['/game/:game/wall'] = array('GamesController', 'wall');

//games ajax
$route['*']['/game/ajaxuploadphoto/:game_id'] = array('GamesController', 'ajaxUploadPhoto');
$route['*']['/game/ajaxcropphoto/:id/:orientation/:ownertype'] = array('GamesController', 'ajaxCropPhoto');
$route['*']['/game/ajaxuploadmultiphoto/:game_id'] = array('GamesController', 'ajaxUploadMultiPhoto');
$route['*']['/game/ajaxuploadmultivideo/:game_id'] = array('GamesController', 'ajaxUploadMultiVideo');
$route['*']['/game/ajaxcountdownload'] = array('GamesController', 'ajaxCountDownload');
$route['*']['/game/:game/media/:tab/:media_id'] = array('GamesController', 'ajaxMediaView');

//games admin
$route['*']['/game/:game/admin/editgameinfo'] = array('GamesController', 'editGameInfo');
$route['*']['/game/:game/admin/adddownloadtab'] = array('GamesController', 'addDownloadTab');
$route['*']['/game/:game/admin/editdownloadtab'] = array('GamesController', 'editDownloadTab');
$route['*']['/game/:game/admin/deletedownloadtab'] = array('GamesController', 'deleteDownloadTab');
$route['*']['/game/:game/admin/adddownload'] = array('GamesController', 'addDownload');
$route['*']['/game/:game/admin/editdownload/:download_id'] = array('GamesController', 'editDownload');
$route['*']['/game/:game/admin/addmedia'] = array('GamesController', 'addMedia');
$route['*']['/game/:game/admin/deletemedia'] = array('GamesController', 'deleteMedia');
$route['*']['/game/:game/admin/editmedia/:media_id'] = array('GamesController', 'editMedia');
$route['*']['/game/:game/admin/savemedia'] = array('GamesController', 'saveMedia');
$route['*']['/game/:game/admin/add-news'] = array('GamesController', 'addNews');
$route['*']['/game/:game/admin/edit-news/:news_id'] = array('GamesController', 'chooseLang');
$route['*']['/game/:game/admin/edit-news/:news_id/:lang_id'] = array('GamesController', 'editNews');
$route['*']['/game/:game/admin/translate-news/:news_id'] = array('GamesController', 'translateNews');
$route['*']['/game/:game/edit-review/:news_id/:lang_id'] = array('GamesController', 'editReview');

$route['*']['/game/updategameinfo'] = array('GamesController', 'updateGameInfo');
$route['*']['/game/savedownloadtab'] = array('GamesController', 'saveDownloadTab');
$route['*']['/game/savedownload'] = array('GamesController', 'saveDownload');
$route['*']['/game/deletedownload'] = array('GamesController', 'deleteDownload');

//recruitment2 catia
$route['*']['/recruitment2'] = array('RecruitmentController', 'index');
$route['*']['/recruitment2/page/:page'] = array('RecruitmentController', 'index');
$route['*']['/recruitment2/game/:game'] = array('RecruitmentController', 'index');
$route['*']['/recruitment2/faction/:faction'] = array('RecruitmentController', 'index');
$route['*']['/recruitment2/role/:role'] = array('RecruitmentController', 'index');
$route['*']['/recruitment2/level/:level'] = array('RecruitmentController', 'index');
$route['*']['/recruitment2/mode/:mode'] = array('RecruitmentController', 'index');
$route['*']['/recruitment2/ownertype/:ownertype'] = array('RecruitmentController', 'index');
$route['*']['/recruitment2/server/:server'] = array('RecruitmentController', 'index');
$route['*']['/recruitment2/lang/:lang'] = array('RecruitmentController', 'index');
$route['*']['/recruitment2/filter'] = array('RecruitmentController', 'index');
$route['*']['/recruitment2/region/:region'] = array('RecruitmentController', 'index');
$route['*']['/recruitment2/my_notices'] = array('RecruitmentController', 'my_notices');
$route['*']['/recruitment2/my_notices/page/:page'] = array('RecruitmentController', 'my_notices');
$route['*']['/recruitment2/my_notices/ownertype/:ownertype'] = array('RecruitmentController', 'my_notices');
$route['*']['/recruitment2/my_notices/ownerid'] = array('RecruitmentController', 'my_notices');
$route['*']['/recruitment2/my_notices/type/:type'] = array('RecruitmentController', 'my_notices');
$route['*']['/recruitment2/my_notices/rid/:rid/owner/:owner/notice/:notice/status/:status'] = array('RecruitmentController', 'update_response');

$route['*']['/recruitment2/respond_notices/:nid/:ownertype'] = array('RecruitmentController', 'respond_notices');
$route['*']['/recruitment2/respond_notices/save_response'] = array('RecruitmentController', 'save_response');

$route['*']['/recruitment2/create_notices'] = array('RecruitmentController', 'create_notices');
$route['*']['/recruitment2/create_notices/page/:page'] = array('RecruitmentController', 'PresCnotices');
$route['*']['/recruitment2/create_notices/notices/:create'] = array('RecruitmentController', 'save_notices');

$route['*']['/recruitment2/create_notices/game/:game'] = array('RecruitmentController', 'create_notices');
$route['*']['/recruitment2/create_notices/faction/:faction'] = array('RecruitmentController', 'create_notices');
$route['*']['/recruitment2/create_notices/role/:role'] = array('RecruitmentController', 'create_notices');
$route['*']['/recruitment2/create_notices/level/:level'] = array('RecruitmentController', 'create_notices');
$route['*']['/recruitment2/create_notices/mode/:mode'] = array('RecruitmentController', 'create_notices');
$route['*']['/recruitment2/create_notices/ownertype/:ownertype'] = array('RecruitmentController', 'create_notices');
$route['*']['/recruitment2/create_notices/lang/:lang'] = array('RecruitmentController', 'create_notices');
$route['*']['/recruitment2/create_notices/region/:region'] = array('RecruitmentController', 'create_notices');
$route['*']['/recruitment2/create_notices/server/:server'] = array('RecruitmentController', 'create_notices');




//BUYSELLTRADE

$route['*']['/buyselltrade'] = array('BuySellTradeController', 'index');
$route['*']['/buyselltrade/page/:page'] = array('BuySellTradeController', 'index');
$route['*']['/buyselltrade/category/:category'] = array('BuySellTradeController', 'index');
$route['*']['/buyselltrade/country/:country'] = array('BuySellTradeController', 'index');
$route['*']['/buyselltrade/ownertype/:ownertype'] = array('BuySellTradeController', 'index');
//added 
$route['*']['/buyselltrade/saletype/:saletype'] = array('BuySellTradeController', 'index');
$route['*']['/buyselltrade/noticetype/:noticetype'] = array('BuySellTradeController', 'index');

$route['*']['/buyselltrade/lang/:lang'] = array('BuySellTradeController', 'index');
$route['*']['/buyselltrade/filter'] = array('BuySellTradeController', 'index');

$route['*']['/buyselltrade/my_notices'] = array('BuySellTradeController', 'my_notices');
$route['*']['/buyselltrade/my_notices/page/:page'] = array('BuySellTradeController', 'my_notices');
$route['*']['/buyselltrade/my_notices/ownertype/:ownertype'] = array('BuySellTradeController', 'my_notices');
$route['*']['/buyselltrade/my_notices/ownerid'] = array('BuySellTradeController', 'my_notices');
$route['*']['/buyselltrade/my_notices/type/:type'] = array('BuySellTradeController', 'my_notices');
$route['*']['/buyselltrade/my_notices/noticetype/:noticetype'] = array('BuySellTradeController', 'my_notices');
//added 
$route['*']['/buyselltrade/my_notices/saletype/:saletype'] = array('BuySellTradeController', 'my_notices');
$route['*']['/buyselltrade/my_notices/responses/rid/:rid/owner/:owner/notice/:notice/status/:status'] = array('BuySellTradeController', 'update_response');
$route['*']['/buyselltrade/my_notices/notices/owner/:owner/notice/:notice/status/:status'] = array('BuySellTradeController', 'update_notice_status');

$route['*']['/buyselltrade/view_notices_responses/:nid/:ownertype/:noticetype/:saletype'] = array('BuySellTradeController', 'view_notices_responses');
//added
$route['*']['/buyselltrade/respond_notices/noticetype/:noticetype'] = array('BuySellTradeController', 'respond_notices');
$route['*']['/buyselltrade/respond_notices/:nid/:ownertype/:noticetype'] = array('BuySellTradeController', 'respond_notices');
$route['*']['/buyselltrade/respond_notices/save_response'] = array('BuySellTradeController', 'save_response');
//added
$route['*']['/buyselltrade/update_notices/noticetype/:noticetype'] = array('BuySellTradeController', 'update_notices');
$route['*']['/buyselltrade/update_notices/:nid/:ownertype'] = array('BuySellTradeController', 'update_notices');
$route['*']['/buyselltrade/update_notices/update_change_notice'] = array('BuySellTradeController', 'update_change_notice');

$route['*']['/buyselltrade/create_notices'] = array('BuySellTradeController', 'create_notices');
$route['*']['/buyselltrade/create_notices/page/:page'] = array('BuySellTradeController', 'PresCnotices');
$route['*']['/buyselltrade/create_notices/notices/:create'] = array('BuySellTradeController', 'save_notices');
$route['*']['/buyselltrade/create_notices/save_categories'] = array('BuySellTradeController', 'save_category');
$route['*']['/buyselltrade/create_notices/notices/savecategory'] = array('BuySellTradeController', 'save_category');

$route['*']['/buyselltrade/create_notices/category/:category'] = array('BuySellTradeController', 'create_notices');
$route['*']['/buyselltrade/create_notices/country/:country'] = array('BuySellTradeController', 'create_notices');
$route['*']['/buyselltrade/create_notices/ownertype/:ownertype'] = array('BuySellTradeController', 'create_notices');
//added
$route['*']['/buyselltrade/create_notices/saletype/:saletype'] = array('BuySellTradeController', 'create_notices');
$route['*']['/buyselltrade/create_notices/lang/:lang'] = array('BuySellTradeController', 'create_notices');

//pay with credits

$route['*']['/buyselltrade/payments/:sellerid'] = array('BuySellTradeController', 'payments');
$route['*']['/buyselltrade/payments/notices/:save'] = array('BuySellTradeController', 'save_transaction');
$route['*']['/buyselltrade/success/:tid'] = array('BuySellTradeController', 'success');
$route['*']['/buyselltrade/buy_credits'] = array('BuySellTradeController', 'buyCredits');
$route['*']['/buyselltrade/transactions'] = array('BuySellTradeController', 'transactions');
$route['*']['/buyselltrade/history/page/:page'] = array('BuySellTradeController', 'history');




//groups
$route['*']['/groups'] = array('GroupsController', 'index');
$route['*']['/groups/page/:page'] = array('GroupsController', 'index');

$route['*']['/groups/recent'] = array('GroupsController', 'recent');
$route['*']['/groups/recent/page/:page'] = array('GroupsController', 'recent');

$route['*']['/groups/search/:type/:searchText'] = array('GroupsController', 'search');
$route['*']['/groups/search/:type/:searchText/page/:page'] = array('GroupsController', 'search');

$route['*']['/group/:group'] = array('GroupsController', 'groupView');
$route['*']['/group/:group/news'] = array('GroupsController', 'newsView');
$route['*']['/group/:group/news/page/:page'] = array('GroupsController', 'newsView');
$route['*']['/group/:group/news/search/:searchText'] = array('GroupsController', 'searchNews');
$route['*']['/group/:group/news/search/:searchText/page/:page'] = array('GroupsController', 'searchNews');
$route['*']['/group/:group/news/:lang/:article'] = array('GroupsController', 'newsItemView');

$route['*']['/group/:group/members'] = array('GroupsController', 'membersView');
$route['*']['/group/:group/members/page/:page'] = array('GroupsController', 'membersView');
$route['*']['/group/:group/members-applications'] = array('GroupsController', 'membersApplicationsView');
$route['*']['/group/:group/members-applications/page/:page'] = array('GroupsController', 'membersApplicationsView');
$route['*']['/group/:group/members-invitations'] = array('GroupsController', 'membersInvitationsView');
$route['*']['/group/:group/members-invitations/page/:page'] = array('GroupsController', 'membersInvitationsView');

$route['*']['/group/savedownload'] = array('GroupsController', 'saveDownload');
$route['*']['/group/deletedownload'] = array('GroupsController', 'deleteDownload');
$route['*']['/group/savedownloadtab'] = array('GroupsController', 'saveDownloadTab');

//groups ajax
$route['*']['/groups/ajaxtogglelike'] = array('GroupsController', 'ajaxToggleLike');
$route['*']['/groups/ajaxsearchgroups'] = array('GroupsController', 'ajaxSearchGroups');
$route['*']['/group/ajaxuploadphoto/:group_id'] = array('GroupsController', 'ajaxUploadPhoto');
$route['*']['/group/ajaxuploadmultiphoto/:group_id'] = array('GroupsController', 'ajaxUploadMultiPhoto');
$route['*']['/group/ajaxuploadmultivideo/:group_id'] = array('GroupsController', 'ajaxUploadMultiVideo');
$route['*']['/group/ajaxfindgroup/:group'] = array('GroupsController', 'ajaxFindGroup');
$route['*']['/group/ajaxdeleteaplication'] = array('GroupsController', 'ajaxDeleteApplication');

$route['*']['/group/:group/request-to-join'] = array('GroupsController', 'requestToJoin');
$route['*']['/group/:group/delete'] = array('GroupsController', 'deleteGroup');
$route['*']['/group/:group/leave'] = array('GroupsController', 'leaveGroup');
$route['*']['/group/send-request-to-join'] = array('GroupsController', 'sendRequestToJoin');

//groups admin
$route['*']['/groups/creategroup'] = array('GroupsController', 'createGroup');
$route['*']['/groups/savegroup'] = array('GroupsController', 'saveGroup');
$route['*']['/group/:group/admin/editgroupinfo'] = array('GroupsController', 'editGroupInfo');
$route['*']['/group/:group/admin/addalliance'] = array('GroupsController', 'addAlliance');
$route['*']['/group/:group/admin/savealliance'] = array('GroupsController', 'saveAlliance');
$route['*']['/group/:group/admin/removealliance'] = array('GroupsController', 'removeAlliance');
$route['*']['/group/:group/admin/editalliance/:alliance_id'] = array('GroupsController', 'editAlliance');
$route['*']['/group/:group/admin/addmedia'] = array('GroupsController', 'addMedia');
$route['*']['/group/:group/admin/deletemedia'] = array('GroupsController', 'deleteMedia');
$route['*']['/group/:group/admin/editmedia/:media_id'] = array('GroupsController', 'editMedia');
$route['*']['/group/:group/admin/savemedia'] = array('GroupsController', 'saveMedia');
$route['*']['/group/:group/admin/addmember'] = array('GroupsController', 'addMember');
$route['*']['/group/:group/admin/invitemembers'] = array('GroupsController', 'inviteMembers');
$route['*']['/group/:group/admin/add-news'] = array('GroupsController', 'addNews');
$route['*']['/group/:group/admin/edit-news/:news_id'] = array('GroupsController', 'chooseLang');
$route['*']['/group/:group/admin/edit-news/:news_id/:lang_id'] = array('GroupsController', 'editNews');
$route['*']['/group/updategroupinfo'] = array('GroupsController', 'updateGroupInfo');
$route['*']['/group/savedownloadtab'] = array('GroupsController', 'saveDownloadTab');
$route['*']['/group/togglememberrank'] = array('GroupsController', 'toggleMemberRank');

$route['*']['/group/ajaxdeletemember'] = array('GroupsController', 'ajaxDeleteMember');
$route['*']['/group/ajaxacceptinvitation'] = array('GroupsController', 'ajaxAcceptInvitation');
$route['*']['/group/ajaxrejectinvitation'] = array('GroupsController', 'ajaxRejectInvitation');

$route['*']['/group/:group/admin/adddownload'] = array('GroupsController', 'addDownload');
$route['*']['/group/:group/admin/adddownloadtab'] = array('GroupsController', 'addDownloadTab');
$route['*']['/group/:group/admin/editdownloadtab'] = array('GroupsController', 'editDownloadTab');
$route['*']['/group/:group/admin/deletedownloadtab'] = array('GroupsController', 'deleteDownloadTab');

//forum - overview that lists all
$route['*']['/forum-search/:type/:id'] = array('ForumController', 'search');
$route['*']['/forum-search/:type'] = array('ForumController', 'search');

$route['*']['/forum'] = array('ForumController', 'index');
$route['*']['/forum/:type'] = array('ForumController', 'index'); // this might mess up with below since :type is an unknown variable and the others could be variables and not pathnames
$route['*']['/forum/vote'] = array('ForumController', 'ajaxCastVote');
$route['*']['/forum/addboardmod'] = array('ForumController', 'ajaxAddBoardMod');
$route['*']['/forum/banuser'] = array('ForumController','ajaxBanUser'); 
$route['*']['/forum/editmessage'] = array('ForumController', 'ajaxeditmessage');
$route['*']['/forum/ajaxdeletemessage'] = array('ForumController', 'ajaxdeletemessage');
$route['*']['/forum/ajaxdeletethread'] = array('ForumController', 'ajaxdeletethread');
$route['*']['/forum/ajaxdeletePoll'] = array('ForumController', 'ajaxdeletepoll');
$route['*']['/forum/ajaxcollapsecat'] = array('ForumController', 'ajaxCollapseCategory');
$route['*']['/forum/ajaxexpandcat'] = array('ForumController', 'ajaxExpandCategory');
$route['*']['/forum/savecategory'] = array('ForumController', 'saveCategory');

$route['*']['/forum/:type/page/:page'] = array('ForumController', 'index');
$route['*']['/forum/:type/search/:search'] = array('ForumController', 'index');
$route['*']['/forum/:type/search/:search/page/:page'] = array('ForumController', 'index');

// single forum
$route['*']['/forum/:type/:id'] = array('ForumController', 'forum'); // ok
$route['*']['/forum/:type/:id/search/:search'] = array('ForumController', 'forum');

$route['get']['/forum/:type/:id/:board'] = array('ForumController', 'board'); // ok boards overview of topics
$route['*']['/forum/:type/:id/:board/page/:page'] = array('ForumController', 'board');
$route['*']['/forum/:type/:id/:board/search/:search'] = array('ForumController', 'board');
$route['*']['/forum/:type/:id/:board/search/:search/page/:page'] = array('ForumController', 'board');
$route['*']['/forum/:type/:id/:board/sort/:sortType'] = array('ForumController', 'board'); // what about, when multipages ? 
$route['*']['/forum/:type/:id/:board/:topic/pl-type/:action'] = array('ForumController', 'pinLockThread'); // pin/unpin and lock/unlock a topic on a board
$route['get']['/forum/:type/:id/:board/mark-as-read'] = array('ForumController', 'markBoardAsRead');

$route['*']['/forum/:type/:id/:board/select-create-form'] = array('ForumController', 'selectCreateForm'); //
$route['*']['/forum/:type/:id/:board/create-form'] = array('ForumController', 'CreateForm'); // ok

$route['get']['/forum-create/topic/:type/:id/:boardId'] = array('ForumController', 'createTopic'); // create new thread in a board
$route['post']['/forum-create/topic/:type/:id/:boardId'] = array('ForumController', 'createTopicAction');
$route['get']['/forum-create/poll/:type/:id/:boardId'] = array('ForumController', 'createPoll'); // create new poll in a board
$route['post']['/forum-create/poll/:type/:id/:boardId'] = array('ForumController', 'createPollAction');

$route['get']['/forum/:type/:id/:board/:topic'] = array('ForumController', 'topic');// view singele thread 
$route['get']['/forum/:type/:id/:board/:topic/page/:page'] = array('ForumController', 'topic'); 
$route['get']['/forum/:type/:id/:board/:topic/:poll'] = array('ForumController', 'topic');// view singele  Poll
$route['get']['/forum/:type/:id/:board/:topic/:poll/page/:page'] = array('ForumController', 'topic'); 

$route['post']['/forum/:type/:id/:board/:topic'] = array('ForumController', 'reply');
$route['post']['/forum/:type/:id/:board/:topic/page/:page'] = array('ForumController', 'reply');
$route['post']['/forum/:type/:id/:board/:topic/:poll'] = array('ForumController', 'reply');
$route['post']['/forum/:type/:id/:board/:topic/:poll/page/:page'] = array('ForumController', 'reply');



$route['*']['/forum/:type/:id/:board/:topic/:msgid/banuser'] = array('ForumController', 'setBanUser');  // calls the form to set the ban

$route['*']['/forum/:type/:id/:board/:topic/:poll/changevote'] = array('ForumController', 'deleteOldVote'); // change vote

$route['get']['/forum/:type/:id/:board/:topic/:poll/editpoll'] = array('ForumController','editPoll');
$route['post']['/forum/:type/:id/:board/:topic/:poll/editpoll'] = array('ForumController','editPollAction');
$route['*']['/forum/:type/:id/:board/:topic/:poll/deletepollchoice/:choice'] =array('ForumController', 'deletePollChoice'); // in edit poll

$route['*']['/forum/:type/:id/:board/:topic/:poll/deletepoll'] =array('ForumController','deletePoll');

$route['*']['/forum/:type/:id/:board/:topic/:msgid/edit'] = array('ForumController', 'editMessage');

$route['*']['/forum/:type/:id/:board/:topic/:msgid/deletethread'] = array('ForumController', 'deleteThread');
$route['*']['/forum/:type/:id/:board/:topic/:msgid/deletereply'] = array('ForumController', 'deleteReply');

// bannedmembers page
$route['*']['/forum/bannedmembers/:type/:id'] = array('ForumController','bannedmembers');
$route['*']['/forum/bannedmembers/:type/:id/deactivateban'] = array('ForumController','ajaxDeactivateBan');
$route['*']['/forum/bannedmembers/:type/:id/movetohistory'] = array('ForumController','ajaxMoveToHistory');

// admin forum page
$route['*']['/adminforum/:type/:id/:admin'] = array('ForumController', 'adminForum');

$route['*']['/adminforum/:type/:id/create/category'] = array('ForumController', 'createCategory');
$route['*']['/adminforum/:type/:id/edit/category/:cat_id'] = array('ForumController', 'editCategory');
$route['post']['/forum/ajaxdeletecategory'] = array('ForumController', 'ajaxdeletecategory'); // dont reload page

$route['*']['/adminforum/:type/:id/editorder/:cat_id'] = array('ForumController', 'editOrder');
$route['*']['/forum/ajaxmovecat'] = array('ForumController', 'ajaxMoveCategory');

$route['*']['/adminforum/:type/:id/create/board/:cat_id'] = array('ForumController', 'createBoard');
$route['*']['/forum/saveboard'] = array('ForumController', 'saveBoard');


$route['*']['/adminforum/:type/:id/editboardorder/:cat_id/:board_id'] = array('ForumController', 'editBoardOrder');
$route['*']['/adminforum/:type/:id/edit/board/:cat_id/:board_id'] = array('ForumController', 'editBoard');
$route['post']['/forum/ajaxmoveboard'] = array('ForumController' , 'ajaxMoveBoard' );

$route['*']['/adminforum/:type/:id/deleteboard/:cat_id/:board_id'] = array('ForumController', 'deleteBoard');
$route['post']['/forum/ajaxdeleteboard'] = array('ForumController', 'ajaxdeleteboard');

$route['get']['/forum-create/:type/:id'] = array('ForumController', 'createForum');
$route['post']['/forum-create/:type/:id'] = array('ForumController', 'createForumAction');

//Temporary e-sports
//$route['*']['/esport'] = array('EsportController', 'index');
$route['*']['/esport'] = array('EsportController', 'news');
$route['*']['/fanclub/ajaxtogglelike'] = array('EsportController', 'ajaxToggleLike');
$route['*']['/esport/ajaxsearchplayer'] = array('EsportController', 'ajaxSearchPlayer');
$route['*']['/esport/ajaxsearchteams'] = array('EsportController', 'ajaxSearchTeams');
$route['*']['/esport/ajaxaddgame'] = array('EsportController', 'ajaxAddGame');
$route['*']['/esport/ajaxremovegame'] = array('EsportController', 'ajaxRemoveGame');
$route['*']['/esport/addnews'] = array('EsportController', 'addNews');
$route['*']['/esport/wallpost/newcomment'] = array('EsportController', 'ajaxNewWallComment');
$route['*']['/esport/wallpost/like'] = array('EsportController', 'ajaxWallLike');
$route['*']['/esport/ajaxuploadphoto'] = array('EsportController', 'ajaxUploadPhoto');
$route['*']['/esport/ajaxuploadavatar'] = array('EsportController', 'ajaxUploadAvatar');
$route['*']['/esport/ajaxuploadscreenshot'] = array('EsportController', 'ajaxUploadScreenshot');
$route['*']['/esport/ajaxuploadteamphoto'] = array('EsportController', 'ajaxUploadTeamPhoto');
$route['*']['/esport/ajaxuploadmap/:id'] = array('EsportController', 'ajaxUploadMap');
$route['*']['/esport/ajaxcheckstatus'] = array('EsportController', 'ajaxCheckStatus');
$route['*']['/esport/ajaxchecknotes'] = array('EsportController', 'ajaxCheckNotes');
$route['*']['/esport/acceptchallenge/:match'] = array('EsportController', 'acceptchallenge');
$route['*']['/esport/ajaxacceptchallenge/:match'] = array('EsportController', 'AjaxAcceptChallenge');
$route['*']['/esport/ajaxsetfavorite'] = array('EsportController', 'ajaxSetFavorite');
$route['*']['/esport/ajaxrejectchallenge/:match'] = array('EsportController', 'AjaxRejectChallenge');
$route['*']['/players/teamrequestrespond/:status/:id'] = array('EsportController', 'teamRequestRespond');
$route['*']['/esport/teamrequestrespond/:status/:id'] = array('EsportController', 'teamRequestRespond');
$route['*']['/esport/moneytransfer/:id'] = array('EsportController', 'moneytransfer');
$route['*']['/esport/browseteams'] = array('EsportController', 'browseteams');
$route['*']['/esport/browseteams/:letter'] = array('EsportController', 'browseteams');
$route['*']['/esport/browseteams/:game/:letter'] = array('EsportController', 'browseteams');
$route['*']['/esport/browseteams/search/:game/:searchstring'] = array('EsportController', 'browseteams');
$route['*']['/esport/browseplayers'] = array('EsportController', 'browseplayers');
$route['*']['/esport/browseplayers/:letter'] = array('EsportController', 'browseplayers');
$route['*']['/esport/browseplayers/:game/:letter'] = array('EsportController', 'browseplayers');
$route['*']['/esport/browseplayers/search/:game/:searchstring'] = array('EsportController', 'browseplayers');
$route['*']['/esport/challenges/:category'] = array('EsportController', 'allchallenges');
$route['*']['/esport/challenge/submitscores'] = array('EsportController', 'submitscores');
$route['*']['/esport/challenge/submitscores/submit'] = array('EsportController', 'SubmitMatchresult');
$route['*']['/esport/createchallenge/create'] = array('EsportController', 'CreateMatch');
$route['*']['/esport/createchallenge/:type'] = array('EsportController', 'createchallenge');
$route['*']['/esport/createchallenge/:type/verify'] = array('EsportController', 'verifychallenge');
$route['*']['/esport/createchallenge/:type/:name'] = array('EsportController', 'createchallenge');
$route['*']['/esport/forum'] = array('EsportController', 'forum');
$route['*']['/esport/profile'] = array('EsportController', 'profile');
$route['*']['/esport/profile/:participant'] = array('EsportController', 'profile');
$route['*']['/esport/ladder'] = array('EsportController', 'ladder');
$route['*']['/esport/ladder/:id'] = array('EsportController', 'ladder');
$route['*']['/esport/ladder/:id/league/:league'] = array('EsportController', 'ladder');
$route['*']['/esport/ladder/:id/league/:league/:tier'] = array('EsportController', 'ladder');
$route['*']['/esport/gamelobby/chat'] = array('EsportController', 'AjaxSendChat');
$route['*']['/esport/gamelobby/chatupdate'] = array('EsportController', 'AjaxUpdateChat');
$route['*']['/esport/gamelobby'] = array('EsportController', 'gamelobby');
$route['*']['/esport/gamelobby/tournaments'] = array('EsportController', 'gamelobby_tournaments');
$route['*']['/esport/tournaments'] = array('EsportController', 'tournaments');
$route['*']['/esport/tournamentinfo/:id'] = array('EsportController', 'tournamentinfo');
$route['*']['/esport/tournamentinfo/:id/:error'] = array('EsportController', 'tournamentinfo');
$route['*']['/esport/leavetournament/:league/:team'] = array('EsportController', 'leavetournament');
$route['*']['/esport/tournamentinfo/cuptree/:id'] = array('EsportController', 'cuptree');
$route['*']['/esport/myspotlight'] = array('EsportController', 'spotlight');
$route['*']['/esport/spotlight'] = array('EsportController', 'spotlight');
$route['*']['/esport/spotlight/:topmenu/:botmenu'] = array('EsportController', 'spotlight');
$route['*']['/esport/spotlight/createfanclub'] = array('EsportController', 'createfanclub');
$route['*']['/esport/spotlight/savefanclub'] = array('EsportController', 'savefanclub');
$route['*']['/esport/spotlight/update'] = array('EsportController', 'UpdateSpotlight');
$route['*']['/esport/spotlight/:id'] = array('EsportController', 'spotlight');
$route['*']['/esport/spotlight/updatefanclub/:id'] = array('EsportController', 'createfanclub');
$route['*']['/esport/spotlight/edit'] = array('EsportController', 'editspotlight');
$route['*']['/esport/betting'] = array('EsportController', 'betting');
$route['*']['/esport/createteam'] = array('EsportController', 'createteam');
$route['*']['/esport/register'] = array('EsportController', 'register');
$route['*']['/esport/registerplayer'] = array('EsportController', 'RegisterPlayer');
$route['*']['/esport/registerteam'] = array('EsportController', 'RegisterTeam');
$route['*']['/esport/closeteam/:id'] = array('EsportController', 'CloseTeam');
$route['*']['/esport/myteam'] = array('EsportController', 'myteam');
$route['*']['/esport/myteam/challenges'] = array('EsportController', 'challenges');
$route['*']['/esport/myteam/:id'] = array('EsportController', 'myteam');
$route['*']['/esport/team/:id'] = array('EsportController', 'myteam');
$route['*']['/esport/myteam/moneytransfer/:id'] = array('EsportController', 'moneytransfer');
$route['*']['/esport/myteam/edit/:id'] = array('EsportController', 'editteam');
$route['*']['/esport/myteam/update'] = array('EsportController', 'UpdateTeam');
$route['*']['/esport/coverage'] = array('EsportController', 'coverage');
$route['*']['/esport/coverage/:name'] = array('EsportController', 'coverage');
$route['*']['/esport/news'] = array('EsportController', 'news');
$route['*']['/esport/news/page/:page'] = array('EsportController', 'news');
$route['*']['/esport/:lang/:article'] = array('EsportController', 'articleview');
$route['*']['/esport/playquickmatch'] = array('EsportController', 'playquickmatch');
$route['*']['/esport/playquickmatch/:id'] = array('EsportController', 'playquickmatch');
$route['*']['/esport/instantchallenge/:id'] = array('EsportController', 'instantchallenge');
$route['*']['/esport/quickmatchsignup/:id/:playmode/:betsize'] = array('EsportController', 'quickmatchsignup');
$route['*']['/esport/createquickmatch'] = array('EsportController', 'CreateQuickmatch');
$route['*']['/esport/deletequickmatch'] = array('EsportController', 'DeleteQuickmatch');
$route['*']['/esport/ajaxjoinquickmatch'] = array('EsportController', 'JoinQuickmatch');
$route['*']['/esport/reportmatchresult'] = array('EsportController', 'reportmatchresult');
$route['*']['/esport/reportmatchresult/:matchid/:reporterid'] = array('EsportController', 'reportmatchresult');
$route['*']['/esport/addgamescollection'] = array('EsportController', 'addgamescollection');
$route['*']['/esport/addgametocollection/:id'] = array('EsportController', 'addgametocollection');
$route['*']['/esport/ajaxjoincup'] = array('EsportController', 'ajaxjoincup');
$route['*']['/esport/signupcup/:id/:type'] = array('EsportController', 'signupcup');
$route['*']['/esport/teamcenter'] = array('EsportController', 'teamcenter');
$route['*']['/esport/reportcupmatch/:id/:r1/:r2'] = array('EsportController', 'reportcupmatch');

$route['*']['/esport/tempadmin'] = array('EsportController', 'tempadmin');
$route['*']['/esport/admin'] = array('admin/AdminEsportController', 'admin');
$route['*']['/esport/admin/showleagues'] = array('admin/AdminEsportController', 'showleagues');
$route['*']['/esport/admin/deletetournament/:id'] = array('admin/AdminEsportController', 'deletetournament');
$route['*']['/esport/admin/createcup'] = array('admin/AdminEsportController', 'createcup');
$route['*']['/esport/admin/createcup/:step'] = array('admin/AdminEsportController', 'createcup');
$route['*']['/esport/admin/createcup/:step/:id'] = array('admin/AdminEsportController', 'createcup');
$route['*']['/esport/admin/createleague'] = array('admin/AdminEsportController', 'createleague');
$route['*']['/esport/admin/createleague/:id'] = array('admin/AdminEsportController', 'createleague');
$route['*']['/esport/admin/editladder'] = array('admin/AdminEsportController', 'editladder');
$route['*']['/esport/admin/achievements'] = array('admin/AdminEsportController', 'achievements');
$route['*']['/esport/admin/editachievement/:teamid'] = array('admin/AdminEsportController', 'editachievement');
$route['*']['/esport/admin/editachievement/:teamid/:id'] = array('admin/AdminEsportController', 'editachievement');
$route['*']['/esport/admin/deleteachievement/:id'] = array('admin/AdminEsportController', 'deleteachievement');

//Event related
$route['*']['/events/ajax/getplayersday'] = array('EventController', 'ajaxGetPlayersDay');
$route['*']['/events/ajax/setcalendardate'] = array('EventController', 'ajaxSetCalendarDate');
$route['*']['/events/ajax/addcalendarnote'] = array('EventController', 'ajaxAddCalendarNote');
$route['*']['/events/ajax/deletecalendarnote'] = array('EventController', 'ajaxDeleteCalendarNote');
$route['*']['/events/ajax/editcalendarnote'] = array('EventController', 'ajaxEditCalendarNote');
$route['*']['/events/ajax/editnote'] = array('EventController', 'ajaxEditNote');
$route['*']['/event/ajaxjoinevent'] = array('EventController', 'ajaxJoinEvent');
$route['*']['/event/ajaxunparticipate'] = array('EventController', 'ajaxUnparticipate');
$route['*']['/event/ajaxdeleteevent'] = array('EventController', 'ajaxDeleteEvent');

$route['*']['/event/:event'] = array('EventController', 'eventViewInformation');
$route['get']['/event/:event/edit'] = array('EventController', 'editEvent'); // view: event_edit
$route['post']['/event/:event/edit'] = array('EventController', 'editEventAction');
$route['*']['/event/:event/join'] = array('EventController', 'eventJoin');
$route['*']['/event/:event/information'] = array('EventController', 'eventViewInformation');
$route['*']['/event/:event/news'] = array('EventController', 'eventViewNews');
$route['*']['/event/:event/wall'] = array('EventController', 'eventViewWall');
$route['*']['/event/:event/participants'] = array('EventController', 'eventViewParticipants');
$route['*']['/event/:event/participants/page/:page'] = array('EventController', 'eventViewParticipants');
$route['*']['/event/:event/participants/search/:search'] = array('EventController', 'eventViewParticipants');
$route['*']['/event/:event/invited'] = array('EventController', 'eventViewInvited');
$route['*']['/event/:event/invited/page/:page'] = array('EventController', 'eventViewInvited');
$route['*']['/event/:event/invited/search/:search'] = array('EventController', 'eventViewInvited');
$route['*']['/event/:event/new'] = array('EventController', 'addEventNews');
$route['*']['/event/:event/edit/:news_id/:lang_id'] = array('EventController', 'editEventNews');
$route['*']['/event/:event/delete/:news_id'] = array('EventController', 'deleteEventNews');

$route['*']['/events'] = array('EventController', 'eventsUpcoming');
$route['*']['/events/upcoming'] = array('EventController', 'eventsUpcoming');
$route['*']['/events/upcoming/page/:page'] = array('EventController', 'eventsUpcoming');
$route['*']['/events/upcoming/search/:search'] = array('EventController', 'eventsUpcoming');
$route['*']['/events/current'] = array('EventController', 'eventsCurrent');
$route['*']['/events/current/page/:page'] = array('EventController', 'eventsCurrent');
$route['*']['/events/current/search/:search'] = array('EventController', 'eventsCurrent');
$route['*']['/events/all/page/:page'] = array('EventController', 'eventsAll');
$route['*']['/events/all/search/:search'] = array('EventController', 'eventsAll');
$route['*']['/events/all/search/:search/page/:page'] = array('EventController', 'eventsAll');

$route['*']['/events/upcoming'] = array('EventController', 'eventsUpcoming');
$route['*']['/events/upcoming/tab'] = array('EventController', 'eventsUpcoming');
$route['*']['/events/upcoming/tab/:tab'] = array('EventController', 'eventsUpcoming');
$route['*']['/events/upcoming/tab/:tab/:order'] = array('EventController', 'eventsUpcoming');
$route['*']['/events/upcoming/tab/:tab/:order/page/:page'] = array('EventController', 'eventsUpcoming');

$route['*']['/events/current'] = array('EventController', 'eventsCurrent');
$route['*']['/events/current/tab'] = array('EventController', 'eventsCurrent');
$route['*']['/events/current/tab/:tab'] = array('EventController', 'eventsCurrent');
$route['*']['/events/current/tab/:tab/:order'] = array('EventController', 'eventsCurrent');
$route['*']['/events/current/tab/:tab/:order/page/:page'] = array('EventController', 'eventsCurrent');

$route['*']['/events/all'] = array('EventController', 'eventsAll');
$route['*']['/events/all/tab'] = array('EventController', 'eventsAll');
$route['*']['/events/all/tab/:tab'] = array('EventController', 'eventsAll');
$route['*']['/events/all/tab/:tab/:order'] = array('EventController', 'eventsAll');
$route['*']['/events/all/tab/:tab/:order/page/:page'] = array('EventController', 'eventsAll');

//$route['*']['/events/:type'] = array('EventController', 'eventIndex');
//$route['*']['/events/:type/page/:page'] = array('EventController', 'eventIndex');
//$route['*']['/events/:type/search/:search'] = array('EventController', 'eventIndex');

$route['*']['/events/:type'] = array('EventController', 'events');
$route['*']['/events/:type/:id'] = array('EventController', 'events');
$route['*']['/events/:type/:id/search/:search'] = array('EventController', 'events');
$route['*']['/events/:type/:id/listtype/:listtype/calendar/:calendar/page/:page'] = array('EventController', 'events');
$route['*']['/event-search/:type/:id'] = array('EventController', 'eventSearch');
$route['*']['/event-search/:type'] = array('EventController', 'eventSearch');
$route['get']['/events/create/:type/:id'] = array('EventController', 'createEvent');
$route['post']['/events/create/:type/:id'] = array('EventController', 'createEventAction');

$route['*']['/event/ajaxuploadphoto/:id'] = array('EventController', 'ajaxUploadPhoto');
$route['post']['/event/ajaxcropphoto/:id/:orientation/:ownertype'] = array('EventController', 'ajaxCropPhoto');

$route['*']['/event/ajaxinvitepeopleshow/:event'] = array('EventController', 'ajaxInvitePeopleShow');
$route['*']['/event/ajaxinvitepeople'] = array('EventController', 'ajaxInvitePeople');

//RaidScheduler
// event is all, player is player only, group is group only
$route['*']['/raidscheduler/signup/:raid'] = array('RaidSchedulerController', 'index_signup');
$route['post']['/raidscheduler/signup/create'] = array('RaidSchedulerController', 'raidSignup');
$route['post']['/players/raidscheduler/decline'] = array('RaidSchedulerController', 'raidDecline');
$route['*']['/events/raidscheduler'] = array('RaidSchedulerController', 'index_events');
$route['get']['/events/raidscheduler/getdata'] = array('RaidSchedulerController', 'getAllStartData');
$route['get']['/events/raidscheduler/newraid'] = array('RaidSchedulerController', 'getAllRaids');
$route['get']['/events/raidscheduler/newcomment'] = array('RaidSchedulerController', 'getAllComments');
$route['post']['/events/raidscheduler/newraid'] = array('RaidSchedulerController', 'createPlayerRaid');
$route['post']['/events/raidscheduler/newcomment'] = array('RaidSchedulerController', 'createComment');
$route['post']['/events/raidscheduler/deleteraid'] = array('RaidSchedulerController', 'deleteRaid');
$route['*']['/players/raidscheduler'] = array('RaidSchedulerController', 'index_players');
$route['get']['/players/raidscheduler/getdata'] = array('RaidSchedulerController', 'getPlayerStartData');
$route['get']['/players/raidscheduler/newraid'] = array('RaidSchedulerController', 'getPlayerRaids');
$route['get']['/players/raidscheduler/newcomment'] = array('RaidSchedulerController', 'getPlayerComments');
$route['post']['/players/raidscheduler/newraid'] = array('RaidSchedulerController', 'createPlayerRaid');
$route['post']['/players/raidscheduler/newcomment'] = array('RaidSchedulerController', 'createComment');
$route['post']['/players/raidscheduler/deleteraid'] = array('RaidSchedulerController', 'deleteRaid');
$route['*']['/groups/raidscheduler/:group'] = array('RaidSchedulerController', 'index_groups');
$route['get']['/groups/raidscheduler/getdata'] = array('RaidSchedulerController', 'getGroupStartData');
$route['get']['/groups/raidscheduler/newraid'] = array('RaidSchedulerController', 'getGroupRaids');
$route['get']['/groups/raidscheduler/newcomment'] = array('RaidSchedulerController', 'getGroupComments');
$route['post']['/groups/raidscheduler/newraid'] = array('RaidSchedulerController', 'createGroupRaid');
$route['post']['/groups/raidscheduler/newcomment'] = array('RaidSchedulerController', 'createComment');
$route['post']['/groups/raidscheduler/deleteraid'] = array('RaidSchedulerController', 'deleteRaid');

//external help
$route['*']['/external/clearcache'] = array('ExternalController', 'clearCache');
$route['*']['/external/generateurl'] = array('ExternalController', 'generateUrl');
$route['*']['/external/generatefreegames'] = array('ExternalController', 'generateFreeGames');
$route['*']['/external/updateplayerfreegames'] = array('ExternalController', 'updatePlayerFreeGames');
$route['*']['/external/generatenewspriorities'] = array('ExternalController', 'generateNewsPriorities');
$route['*']['/external/generateratings'] = array('ExternalController', 'generateRatings');
$route['*']['/external/importgames'] = array('ExternalController', 'importGames');
$route['*']['/external/importcompanies'] = array('ExternalController', 'importCompanies');
$route['*']['/external/convertmessages'] = array('ExternalController', 'convertMessages');
$route['*']['/external/translations'] = array('ExternalController', 'synchTranslations');
$route['*']['/external/translations/:lang'] = array('ExternalController', 'synchTranslations');
$route['*']['/external/newscrawler'] = array('ExternalController', 'NewsCrawler');
$route['*']['/external/cleanupmostread'] = array('ExternalController', 'cleanUpMostRead');

//shop
$route['*']['/shop'] = array('ShopController', 'index');
$route['*']['/shop/page'] = array('ShopController', 'index');
$route['*']['/shop/page/:page'] = array('ShopController', 'index');
$route['*']['/shop/:genre'] = array('ShopController', 'index');
$route['*']['/shop/:genre/page/:page'] = array('ShopController', 'index');
$route['*']['/shop/sort/:sortType'] = array('ShopController', 'index');
$route['*']['/shop/:genre/sort/:sortType'] = array('ShopController', 'index');
$route['*']['/shop/:genre/sort/:sortType/page'] = array('ShopController', 'index');
$route['*']['/shop/:genre/sort/:sortType/page/:page'] = array('ShopController', 'index');

$route['*']['/shop/search'] = array('ShopController', 'search');
$route['*']['/shop/search/:searchText'] = array('ShopController', 'search');
$route['*']['/shop/search/:searchText/page/:page'] = array('ShopController', 'search');

$route['*']['/shop/product/:product_id'] = array('ShopController', 'productView');
$route['*']['/shop/product/:product_id/info/:infotab_id'] = array('ShopController', 'productView');
$route['*']['/shop/product/:product_id/image/:activeImage'] = array('ShopController', 'ajaxProductView');
$route['*']['/shop/ajaxuploadphoto/:product_id'] = array('ShopController', 'ajaxUploadPhoto');

$route['*']['/shop/buy-credits'] = array('ShopController', 'buyCredits');
$route['*']['/shop/history'] = array('ShopController', 'history');
$route['*']['/shop/history/page/:page'] = array('ShopController', 'history');
$route['*']['/shop/history/:order_id'] = array('ShopController', 'orderView');
$route['*']['/shop/cart'] = array('ShopController', 'cart');
$route['*']['/shop/membership'] = array('ShopController', 'membership');
$route['*']['/shop/Playnation+memberships'] = array('ShopController', 'membership');
$route['*']['/shop/Playnation+features'] = array('ShopController', 'features');
$route['*']['/shop/features'] = array('ShopController', 'features');
$route['*']['/shop/buy-membership-pack'] = array('ShopController', 'buyMembershipPackage');
$route['*']['/shop/buy-membership-pack/:pack_id'] = array('ShopController', 'buyMembershipPackage');
$route['*']['/shop/buy-membership-feature'] = array('ShopController', 'buyMembershipFeature');
$route['*']['/shop/buy-membership-feature/:pack_id'] = array('ShopController', 'buyMembershipFeature');
$route['*']['/shop/confirm-membership'] = array('ShopController', 'ajaxConfirmMembershipPackage');
$route['*']['/shop/accept-ipn'] = array('ShopController', 'acceptIpn');
$route['*']['/shop/accept-xsolla'] = array('ShopController', 'acceptXsolla');
$route['*']['/shop/thank-you/:player_url/:hash'] = array('ShopController', 'thankYou');
$route['*']['/shop/cancel/:player_url/:hash'] = array('ShopController', 'cancel');
$route['*']['/shop/ajaxmakerequest'] = array('ShopController', 'ajaxMakeRequest');
$route['*']['/shop/addtocart'] = array('ShopController', 'ajaxAddToCart');
$route['*']['/shop/removefromcart'] = array('ShopController', 'ajaxRemoveFromCart');
$route['*']['/shop/confirmcart'] = array('ShopController', 'ajaxConfirmCart');
$route['*']['/shop/order-complete'] = array('ShopController', 'orderComplete');
$route['*']['/shop/ajaxconvertpd'] = array('ShopController', 'ajaxConvertPD');
$route['*']['/shop/membership-feature-expiration/:type'] = array('ShopController', 'ajaxMembershipFeatureExpiration');
$route['*']['/shop/download/:order_id/:file'] = array('ShopController', 'downloadFile');
$route['*']['/shop/membership/cancel-queue'] = array('ShopController', 'ajaxCancelQueue');

//referrals
$route['*']['/referral'] = array('ReferralController', 'index');
$route['*']['/referral/c'] = array('ReferralController', 'registerReferral');
$route['*']['/referral/c/:code'] = array('ReferralController', 'registerReferral');
$route['*']['/referral/c/:code/url'] = array('ReferralController', 'registerReferral');
//$route['*']['/referral/c/:code/url/:url'] = array('ReferralController', 'registerReferral');
$route['*']['catchall']['/referral/c/:code/url/:url'] = array('ReferralController', 'registerReferral');
$route['*']['/referral/create-referral-code'] = array('ReferralController', 'createReferralCode');
$route['*']['/referral/codes'] = array('ReferralController', 'codesBanners');
$route['*']['/referral/codes/:code'] = array('ReferralController', 'codesBanners');
$route['*']['/referral/edit'] = array('ReferralController', 'editReferralCode');
$route['*']['/referral/edit/:code'] = array('ReferralController', 'editReferralCode');
$route['*']['/referral/create-subreferral-code'] = array('ReferralController', 'createSubReferralCode');
$route['*']['/referral/edit-subreferral'] = array('ReferralController', 'editSubReferralCode');
$route['*']['/referral/edit-subreferral/:code'] = array('ReferralController', 'editSubReferralCode');
$route['*']['/referral/cancel/:email/:code'] = array('ReferralController', 'cancelReferral');
$route['*']['/referral/:fromDate/:toDate'] = array('ReferralController', 'index');

//ADMIN PART
$admin = array('admin'=>'1dfsg234');
$route['*']['/admin'] = array('admin/AdminMainController', 'index');

$route['*']['/admin/news'] = array('admin/AdminNewsController', 'index');
$route['*']['/admin/news/sort/:sortType/:sortDir'] = array('admin/AdminNewsController', 'index');
$route['*']['/admin/news/page'] = array('admin/AdminNewsController', 'index');
$route['*']['/admin/news/page/:page'] = array('admin/AdminNewsController', 'index');
$route['*']['/admin/news/unpublished'] = array('admin/AdminNewsController', 'unpublished');
$route['*']['/admin/news/unpublished/page'] = array('admin/AdminNewsController', 'unpublished');
$route['*']['/admin/news/unpublished/sort/:sortType/:sortDir'] = array('admin/AdminNewsController', 'unpublished');
$route['*']['/admin/news/unpublished/page/:page'] = array('admin/AdminNewsController', 'unpublished');
$route['*']['/admin/news/unpublished/publish/:publishid'] = array('admin/AdminNewsController', 'unpublished');
$route['*']['/admin/news/unpublished/publish/:publishid/page/:page'] = array('admin/AdminNewsController', 'unpublished');
$route['*']['/admin/news/local'] = array('admin/AdminNewsController', 'local');
$route['*']['/admin/news/local/page'] = array('admin/AdminNewsController', 'local');
$route['*']['/admin/news/local/page/:page'] = array('admin/AdminNewsController', 'local');
$route['*']['/admin/news/local/:filter'] = array('admin/AdminNewsController', 'local');
$route['*']['/admin/news/local/page/:filter'] = array('admin/AdminNewsController', 'local');
$route['*']['/admin/news/local/page/:page/:filter'] = array('admin/AdminNewsController', 'local');
$route['*']['/admin/news/local/publish/:news_id/:filter'] = array('admin/AdminNewsController', 'publishLocal');
$route['*']['/admin/news/local/status/:seen/:news_id/:filter'] = array('admin/AdminNewsController', 'seenLocal');
$route['*']['/admin/news/unpublished-reviews'] = array('admin/AdminNewsController', 'unpublishedReviews');
$route['*']['/admin/news/unpublished-reviews/page'] = array('admin/AdminNewsController', 'unpublishedReviews');
$route['*']['/admin/news/unpublished-reviews/page/:page'] = array('admin/AdminNewsController', 'unpublishedReviews');
$route['*']['/admin/news/unpublished-reviews/publish/:news_id'] = array('admin/AdminNewsController', 'publishReview');
$route['*']['/admin/news/unpublished-reviews/delete/:news_id'] = array('admin/AdminNewsController', 'deleteReview');
$route['*']['/admin/news/frontpage'] = array('admin/AdminNewsController', 'frontpage');
$route['*']['/admin/news/frontpage/highlights'] = array('admin/AdminNewsController', 'highlights');
$route['*']['/admin/news/frontpage/highlights/edit/:id'] = array('admin/AdminNewsController', 'edithighlight');
$route['*']['/admin/news/frontpage/highlights/delete/:id'] = array('admin/AdminNewsController', 'deletehighlight');
$route['*']['/admin/news/frontpage/slider'] = array('admin/AdminNewsController', 'slider');
$route['*']['/admin/news/frontpage/slider/edit/:id'] = array('admin/AdminNewsController', 'editslider');
$route['*']['/admin/news/frontpage/slider/delete/:id'] = array('admin/AdminNewsController', 'deleteslider');
$route['*']['/admin/news/crawlersubscriptions'] = array('admin/AdminNewsController', 'crawlerSubscriptions');
$route['*']['/admin/news/crawlersites'] = array('admin/AdminNewsController', 'crawlerSites');
$route['*']['/admin/news/crawlersites/edit/:id'] = array('admin/AdminNewsController', 'editCrawlerSite');
$route['*']['/admin/news/crawlersites/delete/:id'] = array('admin/AdminNewsController', 'deleteCrawlerSite');
$route['*']['/admin/news/crawlerglobals'] = array('admin/AdminNewsController', 'crawlerGlobals');
$route['*']['/admin/news/crawlerlogs'] = array('admin/AdminNewsController', 'crawlerLogs');
$route['*']['/admin/news/ajaxdeletecrawlerlog'] = array('admin/AdminNewsController', 'ajaxDeleteCrawlerLog');
$route['*']['/admin/news/ajaxgetnewslocale'] = array('admin/AdminNewsController', 'ajaxGetNewsLocale');
$route['*']['/admin/news/add-news'] = array('admin/AdminNewsController', 'addNews');
$route['*']['/admin/news/player-news/:filter/page/:page'] = array('admin/AdminNewsController','playerNews');
$route['*']['/admin/news/player-news/:news_id/:language_id'] = array('admin/AdminNewsController','playerNewsNotes');
$route['*']['/admin/news/edit-prefixes'] = array('admin/AdminNewsController', 'editNewsPrefixes'); 
$route['*']['/admin/news/save-Prefixes'] = array('admin/AdminNewsController', 'editNewsPrefix'); 
$route['*']['/admin/news/add-Prefixes'] = array('admin/AdminNewsController', 'addNewsPrefixes'); 
$route['*']['/admin/news/filemanager'] = array('admin/AdminNewsController', 'filemanager'); 



$route['*']['/admin/users'] = array('admin/AdminUsersController', 'index');
$route['*']['/admin/users/page'] = array('admin/AdminUsersController', 'index');
$route['*']['/admin/users/page/:page'] = array('admin/AdminUsersController', 'index');
$route['*']['/admin/users/search/:searchText'] = array('admin/AdminUsersController', 'search');
$route['*']['/admin/users/search/:searchText/:page'] = array('admin/AdminUsersController', 'search');
$route['*']['/admin/users/sort/:sortType/:sortDir'] = array('admin/AdminUsersController', 'index');
$route['*']['/admin/users/edit/:user_id'] = array('admin/AdminUsersController', 'edit');
$route['*']['/admin/users/newuser'] = array('admin/AdminUsersController', 'newuser');
$route['*']['/admin/users/selfdeactivated'] = array('admin/AdminUsersController', 'selfdeactivated');
$route['*']['/admin/users/banned'] = array('admin/AdminUsersController', 'banned');
$route['*']['/admin/users/notapproved'] = array('admin/AdminUsersController', 'notapproved');
$route['*']['/admin/users/specialtools'] = array('admin/AdminUsersController', 'specialtools');
$route['*']['/admin/users/friendcat'] = array('admin/AdminUsersController', 'friendcat');
$route['*']['/admin/users/neweditsuspend/:user_id'] = array('admin/AdminUsersController', 'neweditsuspend');
$route['*']['/admin/users/cancelsuspend/:user_id'] = array('admin/AdminUsersController', 'cancelsuspend');
$route['*']['/admin/users/activate/:user_id'] = array('admin/AdminUsersController', 'activate');

$route['*']['/admin/games'] = array('admin/AdminGamesController', 'index');
$route['*']['/admin/games/:type_id'] = array('admin/AdminGamesController', 'index');
$route['*']['/admin/games/page'] = array('admin/AdminGamesController', 'index');
$route['*']['/admin/games/page/:page'] = array('admin/AdminGamesController', 'index');
$route['*']['/admin/games/type/:type_id/page/:page'] = array('admin/AdminGamesController', 'index');
$route['*']['/admin/games/search/:searchText'] = array('admin/AdminGamesController', 'search');
$route['*']['/admin/games/search/:searchText/page'] = array('admin/AdminGamesController', 'search');
$route['*']['/admin/games/search/:searchText/page/:page'] = array('admin/AdminGamesController', 'search');
$route['*']['/admin/games/sort/:sortType/:sortDir'] = array('admin/AdminGamesController', 'index');
$route['*']['/admin/games/sort/:sortType/:sortDir/page/:page'] = array('admin/AdminGamesController', 'index');
$route['*']['/admin/games/sort/:sortType/:sortDir/type/:type_id/page/:page'] = array('admin/AdminGamesController', 'index');
$route['*']['/admin/games/edit/:game_id'] = array('admin/AdminGamesController', 'edit');
$route['*']['/admin/games/edit/:game_id/media'] = array('admin/AdminGamesController', 'allMedia');
$route['*']['/admin/games/edit/:game_id/media/page/:page'] = array('admin/AdminGamesController', 'allMedia');
$route['*']['/admin/games/edit/:game_id/media/new'] = array('admin/AdminGamesController', 'addMedia');
$route['*']['/admin/games/edit/:game_id/media/edit/:media_id'] = array('admin/AdminGamesController', 'editMedia');
$route['*']['/admin/games/edit/:game_id/media/delete/:media_id'] = array('admin/AdminGamesController', 'deleteMedia');
$route['*']['/admin/games/edit/:game_id/downloads'] = array('admin/AdminGamesController', 'allDownloads');
$route['*']['/admin/games/edit/:game_id/downloads/page/:page'] = array('admin/AdminGamesController', 'allDownloads');
$route['*']['/admin/games/edit/:game_id/downloads/new'] = array('admin/AdminGamesController', 'addDownload');
$route['*']['/admin/games/edit/:game_id/downloads/edit/:download_id'] = array('admin/AdminGamesController', 'editDownload');
$route['*']['/admin/games/edit/:game_id/downloads/delete/:download_id'] = array('admin/AdminGamesController', 'deleteDownload');
$route['*']['/admin/games/edit/:game_id/downloadtabs'] = array('admin/AdminGamesController', 'allFiletypes');
$route['*']['/admin/games/edit/:game_id/downloadtabs/page/:page'] = array('admin/AdminGamesController', 'allFiletypes');
$route['*']['/admin/games/edit/:game_id/downloadtabs/new'] = array('admin/AdminGamesController', 'addFiletype');
$route['*']['/admin/games/edit/:game_id/downloadtabs/edit/:tab_id'] = array('admin/AdminGamesController', 'editFiletype');
$route['*']['/admin/games/edit/:game_id/downloadtabs/delete/:tab_id'] = array('admin/AdminGamesController', 'deleteFiletype');
$route['*']['/admin/games/new'] = array('admin/AdminGamesController', 'newGame');
$route['*']['/admin/games/types'] = array('admin/AdminGamesController', 'allGameTypes');
$route['*']['/admin/games/types/page/:page'] = array('admin/AdminGamesController', 'allGameTypes');
$route['*']['/admin/games/types/new'] = array('admin/AdminGamesController', 'newGameType');
$route['*']['/admin/games/types/edit/:type_id'] = array('admin/AdminGamesController', 'editGameType');
$route['*']['/admin/games/types/delete/:type_id'] = array('admin/AdminGamesController', 'deleteGameType');
$route['*']['/admin/games/types/merge/:type_id'] = array('admin/AdminGamesController', 'mergeGameTypes');

$route['*']['/admin/companies'] = array('admin/AdminCompaniesController', 'index');
$route['*']['/admin/companies/:type_id'] = array('admin/AdminCompaniesController', 'index');
$route['*']['/admin/companies/page'] = array('admin/AdminCompaniesController', 'index');
$route['*']['/admin/companies/page/:page'] = array('admin/AdminCompaniesController', 'index');
$route['*']['/admin/companies/type/:type_id/page/:page'] = array('admin/AdminCompaniesController', 'index');
$route['*']['/admin/companies/search/:searchText'] = array('admin/AdminCompaniesController', 'search');
$route['*']['/admin/companies/search/:searchText/page'] = array('admin/AdminCompaniesController', 'search');
$route['*']['/admin/companies/search/:searchText/page/:page'] = array('admin/AdminCompaniesController', 'search');
$route['*']['/admin/companies/sort/:sortType/:sortDir'] = array('admin/AdminCompaniesController', 'index');
$route['*']['/admin/companies/sort/:sortType/:sortDir/page/:page'] = array('admin/AdminCompaniesController', 'index');
$route['*']['/admin/companies/edit/:company_id'] = array('admin/AdminCompaniesController', 'edit');
$route['*']['/admin/companies/edit/:company_id/media'] = array('admin/AdminCompaniesController', 'allMedia');
$route['*']['/admin/companies/edit/:company_id/media/page/:page'] = array('admin/AdminCompaniesController', 'allMedia');
$route['*']['/admin/companies/edit/:company_id/media/new'] = array('admin/AdminCompaniesController', 'addMedia');
$route['*']['/admin/companies/edit/:company_id/media/edit/:media_id'] = array('admin/AdminCompaniesController', 'editMedia');
$route['*']['/admin/companies/edit/:company_id/media/delete/:media_id'] = array('admin/AdminCompaniesController', 'deleteMedia');
$route['*']['/admin/companies/edit/:company_id/downloads'] = array('admin/AdminCompaniesController', 'allDownloads');
$route['*']['/admin/companies/edit/:company_id/downloads/page/:page'] = array('admin/AdminCompaniesController', 'allDownloads');
$route['*']['/admin/companies/edit/:company_id/downloads/new'] = array('admin/AdminCompaniesController', 'addDownload');
$route['*']['/admin/companies/edit/:company_id/downloads/edit/:download_id'] = array('admin/AdminCompaniesController', 'editDownload');
$route['*']['/admin/companies/edit/:company_id/downloads/delete/:download_id'] = array('admin/AdminCompaniesController', 'deleteDownload');
$route['*']['/admin/companies/edit/:company_id/downloadtabs'] = array('admin/AdminCompaniesController', 'allFiletypes');
$route['*']['/admin/companies/edit/:company_id/downloadtabs/page/:page'] = array('admin/AdminCompaniesController', 'allFiletypes');
$route['*']['/admin/companies/edit/:company_id/downloadtabs/new'] = array('admin/AdminCompaniesController', 'addFiletype');
$route['*']['/admin/companies/edit/:company_id/downloadtabs/edit/:tab_id'] = array('admin/AdminCompaniesController', 'editFiletype');
$route['*']['/admin/companies/edit/:company_id/downloadtabs/delete/:tab_id'] = array('admin/AdminCompaniesController', 'deleteFiletype');
$route['*']['/admin/companies/new'] = array('admin/AdminCompaniesController', 'newCompany');
$route['*']['/admin/companies/types'] = array('admin/AdminCompaniesController', 'allCompanyTypes');
$route['*']['/admin/companies/types/page/:page'] = array('admin/AdminCompaniesController', 'allCompanyTypes');
$route['*']['/admin/companies/types/new'] = array('admin/AdminCompaniesController', 'newCompanyType');
$route['*']['/admin/companies/types/edit/:type_id'] = array('admin/AdminCompaniesController', 'editCompanyType');
$route['*']['/admin/companies/types/delete/:type_id'] = array('admin/AdminCompaniesController', 'deleteCompanyType');
$route['*']['/admin/companies/types/merge/:type_id'] = array('admin/AdminCompaniesController', 'mergeCompanyTypes');

//Bug reports section BEGIN
$route['*']['/admin/bugreports'] = array('admin/AdminBugReportsController', 'index');
$route['*']['/admin/bugreports/page/:page'] = array('admin/AdminBugReportsController', 'index');
$route['*']['/admin/bugreports/new'] = array('admin/AdminBugReportsController', 'newBugReport');
$route['*']['/admin/bugreports/edit/:error_id'] = array('admin/AdminBugReportsController', 'edit');
$route['*']['/admin/bugreports/edit/:error_id/image'] = array('admin/AdminBugReportsController', 'ajaxScreenshotView');
//with type_id
$route['*']['/admin/bugreports/:type_id'] = array('admin/AdminBugReportsController', 'index');
$route['*']['/admin/bugreports/:type_id/page/:page'] = array('admin/AdminBugReportsController', 'index');
$route['*']['/admin/bugreports/:type_id/sort/:sortType/:sortDir'] = array('admin/AdminBugReportsController', 'index');
$route['*']['/admin/bugreports/:type_id/sort/:sortType/:sortDir/page/:page'] = array('admin/AdminBugReportsController', 'index');
$route['*']['/admin/bugreports/:type_id/search/:searchText'] = array('admin/AdminBugReportsController', 'search');
$route['*']['/admin/bugreports/:type_id/search/:searchText/page/:page'] = array('admin/AdminBugReportsController', 'search');
//with type_id, category_id
$route['*']['/admin/bugreports/:type_id/:category_id'] = array('admin/AdminBugReportsController', 'index');
$route['*']['/admin/bugreports/:type_id/:category_id/page/:page'] = array('admin/AdminBugReportsController', 'index');
$route['*']['/admin/bugreports/:type_id/:category_id/sort/:sortType/:sortDir'] = array('admin/AdminBugReportsController', 'index');
$route['*']['/admin/bugreports/:type_id/:category_id/sort/:sortType/:sortDir/page/:page'] = array('admin/AdminBugReportsController', 'index');
$route['*']['/admin/bugreports/:type_id/:category_id/search/:searchText'] = array('admin/AdminBugReportsController', 'search');
$route['*']['/admin/bugreports/:type_id/:category_id/search/:searchText/page/:page'] = array('admin/AdminBugReportsController', 'search');
//with type_id, category_id, subcategory_id
$route['*']['/admin/bugreports/:type_id/:category_id/:subcategory_id'] = array('admin/AdminBugReportsController', 'index');
$route['*']['/admin/bugreports/:type_id/:category_id/:subcategory_id/page/:page'] = array('admin/AdminBugReportsController', 'index');
$route['*']['/admin/bugreports/:type_id/:category_id/:subcategory_id/sort/:sortType/:sortDir'] = array('admin/AdminBugReportsController', 'index');
$route['*']['/admin/bugreports/:type_id/:category_id/:subcategory_id/sort/:sortType/:sortDir/page/:page'] = array('admin/AdminBugReportsController', 'index');
$route['*']['/admin/bugreports/:type_id/:category_id/:subcategory_id/search/:searchText'] = array('admin/AdminBugReportsController', 'search');
$route['*']['/admin/bugreports/:type_id/:category_id/:subcategory_id/search/:searchText/page'] = array('admin/AdminBugReportsController', 'search');
$route['*']['/admin/bugreports/:type_id/:category_id/:subcategory_id/search/:searchText/page/:page'] = array('admin/AdminBugReportsController', 'search');
$route['*']['/bugreport/ajaxuploadscreenshot/:error_id'] = array('admin/AdminBugReportsController', 'ajaxUploadScreenshot');
//Bug reports section END

//Translate section BEGIN
$route['*']['/admin/translate'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/page/:page'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/:A2'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/:A2/page/:page'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/sort/:sortType/:sortDir'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/sort/:sortType/:sortDir/page/:page'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/:A2/sort/:sortType/:sortDir'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/:A2/sort/:sortType/:sortDir/page/:page'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/:transfilter'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/:transfilter/page/:page'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/:A2/:transfilter'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/:A2/:transfilter/page/:page'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/:transfilter/sort/:sortType/:sortDir'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/:transfilter/sort/:sortType/:sortDir/page/:page'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/:A2/:transfilter/sort/:sortType/:sortDir'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/:A2/:transfilter/sort/:sortType/:sortDir/page/:page'] = array('admin/AdminTranslateController', 'index');

$route['*']['/admin/translate/search/:search'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/search/:search/page/:page'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/search/:search/:A2'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/search/:search/:A2/page/:page'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/search/:search/sort/:sortType/:sortDir'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/search/:search/sort/:sortType/:sortDir/page/:page'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/search/:search/:A2/sort/:sortType/:sortDir'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/search/:search/:A2/sort/:sortType/:sortDir/page/:page'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/search/:search/:transfilter'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/search/:search/:transfilter/page/:page'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/search/:search/:A2/:transfilter'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/search/:search/:A2/:transfilter/page/:page'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/search/:search/:transfilter/sort/:sortType/:sortDir'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/search/:search/:transfilter/sort/:sortType/:sortDir/page/:page'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/search/:search/:A2/:transfilter/sort/:sortType/:sortDir'] = array('admin/AdminTranslateController', 'index');
$route['*']['/admin/translate/search/:search/:A2/:transfilter/sort/:sortType/:sortDir/page/:page'] = array('admin/AdminTranslateController', 'index');

$route['*']['/admin/translate/edit/:ID_TEXT'] = array('admin/AdminTranslateController', 'edit');
$route['*']['/admin/translate/edit/:ID_TEXT/:A2'] = array('admin/AdminTranslateController', 'edit');
$route['*']['/admin/translate/edit/:ID_TEXT/sort/:sortType/:sortDir'] = array('admin/AdminTranslateController', 'edit');
$route['*']['/admin/translate/edit/:ID_TEXT/:A2/sort/:sortType/:sortDir/page/:page'] = array('admin/AdminTranslateController', 'edit');
$route['*']['/admin/translate/edit/:ID_TEXT/:A2/sort/:sortType/:sortDir'] = array('admin/AdminTranslateController', 'edit');

$route['*']['/admin/translate/edit/:ID_TEXT/:transfilter'] = array('admin/AdminTranslateController', 'edit');
$route['*']['/admin/translate/edit/:ID_TEXT/:A2/:transfilter'] = array('admin/AdminTranslateController', 'edit');
$route['*']['/admin/translate/edit/:ID_TEXT/:transfilter/sort/:sortType/:sortDir'] = array('admin/AdminTranslateController', 'edit');
$route['*']['/admin/translate/edit/:ID_TEXT/:A2/:transfilter/sort/:sortType/:sortDir/page/:page'] = array('admin/AdminTranslateController', 'edit');
$route['*']['/admin/translate/edit/:ID_TEXT/:A2/:transfilter/sort/:sortType/:sortDir'] = array('admin/AdminTranslateController', 'edit');

$route['*']['/admin/translate/keycontent'] = array('admin/AdminTranslateController', 'keycontent');
$route['*']['/admin/translate/keycontent/:A2'] = array('admin/AdminTranslateController', 'keycontent');
$route['*']['/admin/translate/keycontent/:A1/:A2'] = array('admin/AdminTranslateController', 'keycontent');
$route['*']['/admin/translate/dllang/:A1/:A2'] = array('admin/AdminTranslateController', 'dllang');

$route['*']['/admin/translate/lnggroup/:grouptype/:A1/:A2'] = array('admin/AdminTranslateController', 'lnggroup');

$route['*']['/admin/translate/languages'] = array('admin/AdminTranslateController', 'languages');
$route['*']['/admin/translate/editlanguage'] = array('admin/AdminTranslateController', 'editlanguage');
$route['*']['/admin/translate/editlanguage/:i/:ID'] = array('admin/AdminTranslateController', 'editlanguage');

//$route['*']['/admin/translate/:status_id/:module_id'] = array('admin/AdminTranslateController', 'index');
//$route['*']['/admin/translate/:status_id/:module_id/page/:page'] = array('admin/AdminTranslateController', 'index');
//$route['*']['/admin/translate/:A2/:module_id/sort/:sortType/:sortDir'] = array('admin/AdminTranslateController', 'index');
//$route['*']['/admin/translate/:A2/:module_id/sort/:sortType/:sortDir/page/:page'] = array('admin/AdminTranslateController', 'index');
//$route['*']['/translate/ajaxuploadscreenshot/:textID'] = array('admin/AdminTranslateController', 'ajaxUploadScreenshot');
//$route['*']['/admin/translate/new'] = array('admin/AdminTranslateController', 'newTranslate');
//$route['*']['/admin/translate/deletelanguage'] = array('admin/AdminTranslateController', 'deletelanguage');
//Translate section END

//Setup section BEGIN
$route['*']['/layout/ajaxuploadbackground'] = array('admin/AdminLayoutController', 'ajaxUploadBackground');
$route['*']['/layout/ajaxuploadbackground/:type'] = array('admin/AdminLayoutController', 'ajaxUploadBackground');
$route['*']['/admin/setup'] = array('admin/AdminSetupController', 'index');
$route['*']['/admin/setup/editmodule'] = array('admin/AdminSetupController', 'editmodule');
$route['*']['/admin/setup/editmodule/id/:ID_MODULE'] = array('admin/AdminSetupController', 'editmodule');
$route['*']['/admin/setup/editextrafield/moduleid/:ID_MODULE/fieldid/:ID_FIELD'] = array('admin/AdminSetupController', 'editextrafield');
$route['*']['/admin/setup/editcategory/moduleid/:ID_MODULE/categoryid/:ID_CATEGORY'] = array('admin/AdminSetupController', 'editcategory');
$route['*']['/admin/setup/siteinfo'] = array('admin/AdminSetupController', 'siteinfo');
$route['*']['/admin/setup/layout/general'] = array('admin/AdminLayoutController', 'general');
$route['*']['/admin/setup/layout/topmenu'] = array('admin/AdminLayoutController', 'topmenu');
$route['*']['/admin/setup/layout/right-column'] = array('admin/AdminLayoutController', 'rightColumn');
$route['*']['/admin/setup/layout/right-column/new-widget'] = array('admin/AdminLayoutController', 'newRightColumnWidget');
$route['*']['/admin/setup/layout/right-column/edit-widget/:widget_id'] = array('admin/AdminLayoutController', 'rightColumnEdit');
$route['*']['/admin/setup/layout/header'] = array('admin/AdminLayoutController', 'header');
$route['*']['/admin/setup/layout/footer'] = array('admin/AdminLayoutController', 'footer');
$route['*']['/admin/setup/layout/css'] = array('admin/AdminLayoutController', 'css');
$route['*']['/admin/setup/layout/css/imagemanager'] = array('admin/AdminLayoutController', 'cssImageManager');
$route['*']['/admin/setup/layout/css/page/:page'] = array('admin/AdminLayoutController', 'css');
$route['*']['/admin/setup/layout/css/sort/:sortType/:sortDir'] = array('admin/AdminLayoutController', 'css');
$route['*']['/admin/setup/layout/css/edit/:id'] = array('admin/AdminLayoutController', 'cssEdit');
$route['*']['/admin/setup/layout/css/:action'] = array('admin/AdminLayoutController', 'css');
$route['*']['/admin/setup/layout/css/:action/:id'] = array('admin/AdminLayoutController', 'css');
//Setup section END

//Campaign section BEGIN
$route['*']['/admin/campaigns'] = array('admin/AdminCampaignController', 'index');
$route['*']['/admin/campaigns/page'] = array('admin/AdminCampaignController', 'index');
$route['*']['/admin/campaigns/page/:page'] = array('admin/AdminCampaignController', 'index');
$route['*']['/admin/campaigns/delete/:ID_CAMPAIGN'] = array('admin/AdminCampaignController', 'delCampaign');
$route['*']['/admin/campaigns/newcampaign'] = array('admin/AdminCampaignController', 'newCampaign');
$route['*']['/admin/campaigns/newcampaign/page'] = array('admin/AdminCampaignController', 'newCampaign');
$route['*']['/admin/campaigns/newcampaign/page/:page'] = array('admin/AdminCampaignController', 'newCampaign');
$route['*']['/admin/campaigns/banners'] = array('admin/AdminCampaignController', 'allBanners');
$route['*']['/admin/campaigns/banners/:ID_CAMPAIGN'] = array('admin/AdminCampaignController', 'banners');
$route['*']['/admin/campaigns/editbanner/:ID_BANNER'] = array('admin/AdminCampaignController', 'editBanner');
$route['*']['/admin/campaigns/delbanner/:ID_BANNER'] = array('admin/AdminCampaignController', 'delBanner');
$route['*']['/admin/campaigns/delbanner/:ID_BANNER/:ID_CAMPAIGN'] = array('admin/AdminCampaignController', 'delBanner');
$route['*']['/admin/campaigns/editcampaign/:ID_CAMPAIGN'] = array('admin/AdminCampaignController', 'editCampaign');
$route['*']['/admin/campaigns/editcampaign/page'] = array('admin/AdminCampaignController', 'editCampaign');
$route['*']['/admin/campaigns/editcampaign/page/:page'] = array('admin/AdminCampaignController', 'editCampaign');
$route['*']['/admin/campaigns/adbanner/:ID_CAMPAIGN'] = array('admin/AdminCampaignController', 'adBanner');
//Campaign section END

//Achievements section BEGIN
$route['*']['/admin/achievements'] = array('admin/AdminAchievementsController', 'index');
$route['*']['/admin/achievements/page'] = array('admin/AdminAchievementsController', 'index');
$route['*']['/admin/achievements/page/:page'] = array('admin/AdminAchievementsController', 'index');
$route['*']['/admin/achievements/edit/:achieve_id'] = array('admin/AdminAchievementsController', 'edit');
$route['*']['/admin/achievements/levels'] = array('admin/AdminAchievementsController', 'levels');
$route['*']['/admin/achievements/newlevel'] = array('admin/AdminAchievementsController', 'newLevel');
$route['*']['/admin/achievements/editlevel/:level_id'] = array('admin/AdminAchievementsController', 'editLevel');
$route['*']['/admin/achievements/branches'] = array('admin/AdminAchievementsController', 'branches');
$route['*']['/admin/achievements/editbranch/:branch_id'] = array('admin/AdminAchievementsController', 'editbranch');
$route['*']['/admin/achievements/playerachievements'] = array('admin/AdminAchievementsController', 'playerAchievements');
$route['*']['/admin/achievements/search/:searchText'] = array('admin/AdminAchievementsController', 'search');
$route['*']['/admin/achievements/newachievement'] = array('admin/AdminAchievementsController', 'newAchievement');
$route['*']['/admin/achievements/newbranch'] = array('admin/AdminAchievementsController', 'newBranch');
$route['*']['/admin/achievements/categories'] = array('admin/AdminAchievementsController', 'categories');
$route['*']['/admin/achievements/newcategory'] = array('admin/AdminAchievementsController', 'newCategory');
$route['*']['/admin/achievements/rankings'] = array('admin/AdminAchievementsController', 'rankings');
//Achievements section END

$route['*']['/admin/shop'] = array('admin/AdminShopController', 'index');
$route['*']['/admin/shop/page'] = array('admin/AdminShopController', 'index');
$route['*']['/admin/shop/page/:page'] = array('admin/AdminShopController', 'index');
$route['*']['/admin/shop/:ProductTypeName'] = array('admin/AdminShopController', 'index');
$route['*']['/admin/shop/:ProductTypeName/page'] = array('admin/AdminShopController', 'index');
$route['*']['/admin/shop/:ProductTypeName/page/:page'] = array('admin/AdminShopController', 'index');
$route['*']['/admin/shop/search/:searchText'] = array('admin/AdminShopController', 'search');
$route['*']['/admin/shop/search/:searchText/page'] = array('admin/AdminShopController', 'search');
$route['*']['/admin/shop/search/:searchText/page/:page'] = array('admin/AdminShopController', 'search');
$route['*']['/admin/shop/product/:product_id'] = array('admin/AdminShopController', 'editProduct');
$route['*']['/admin/shop/product/:product_id/new/:info_type'] = array('admin/AdminShopController', 'newProductInfo');
$route['*']['/admin/shop/product/:product_id/:info_type/:info_id'] = array('admin/AdminShopController', 'editProductInfo');
$route['*']['/admin/shop/product/new'] = array('admin/AdminShopController', 'newProduct');
$route['*']['/admin/shop/updateproduct'] = array('ShopController', 'updateProduct');
$route['*']['/shop/updateproduct'] = array('ShopController', 'updateProduct');

$route['*']['/admin/shop/memberships'] = array('admin/AdminShopController', 'indexMembership');
$route['*']['/admin/shop/memberships/:package_id'] = array('admin/AdminShopController', 'editMembership');
$route['*']['/admin/shop/memberships/new'] = array('admin/AdminShopController', 'newMembership');

$route['*']['/admin/shop/features'] = array('admin/AdminShopController', 'indexFeatures');
$route['*']['/admin/shop/features/:features_id'] = array('admin/AdminShopController', 'editFeatures');
$route['*']['/admin/shop/features/new'] = array('admin/AdminShopController', 'newFeatures');

$route['*']['/admin/shop/rates'] = array('admin/AdminShopController', 'indexCredit');
$route['*']['/admin/shop/rates/:credit_id'] = array('admin/AdminShopController', 'editCredit');
$route['*']['/admin/shop/rates/new'] = array('admin/AdminShopController', 'newCredit');

$route['*']['/admin/shop/types'] = array('admin/AdminShopController', 'indexType');
$route['*']['/admin/shop/types/:type_id'] = array('admin/AdminShopController', 'editType');
$route['*']['/admin/shop/types/new'] = array('admin/AdminShopController', 'newType');

$route['*']['/admin/stats'] = array('admin/AdminStatsController', 'index');
$route['*']['/admin/stats/users'] = array('admin/AdminStatsController', 'users');
$route['*']['/admin/stats/referrers'] = array('admin/AdminStatsController', 'referrers');
$route['*']['/admin/stats/referrers/page/:page'] = array('admin/AdminStatsController', 'referrers');
$route['*']['/admin/stats/referrers/search'] = array('admin/AdminStatsController', 'search');
$route['*']['/admin/stats/referrers/search/:searchText'] = array('admin/AdminStatsController', 'search');
$route['*']['/admin/stats/credits'] = array('admin/AdminStatsController', 'credits');

//---------- Delete if not needed ------------

/*
//view the logs and profiles XML, filename = db.profile, log, trace.log, profile
$route['*']['/debug/:filename'] = array('MainController', 'debug', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');

//show all urls in app
$route['*']['/allurl'] = array('MainController', 'allurl', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');

//generate routes file. This replace the current routes.conf.php. Use with the sitemap tool.
$route['post']['/gen_sitemap'] = array('MainController', 'gen_sitemap', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');

//generate routes & controllers. Use with the sitemap tool.
$route['post']['/gen_sitemap_controller'] = array('MainController', 'gen_sitemap_controller', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');

//generate Controllers automatically
$route['*']['/gen_site'] = array('MainController', 'gen_site', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');

//generate Models automatically
$route['*']['/gen_model'] = array('MainController', 'gen_model', 'authName'=>'DooPHP Admin', 'auth'=>$admin, 'authFail'=>'Unauthorized!');
*/
?>
