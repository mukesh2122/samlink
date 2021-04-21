<?php
/* $acl[GROUP_ANONYMOUS]['deny'] = array('*');
$acl[GROUP_ANONYMOUS]['allow'] = array(
	'ExternalController' => '*',
	'MainController' => '*',
	'NewsController' => array(
		'index',
		'articleView',
	),
	'PlayersController' => array(
		'loginFirst',
		'ajaxLoginBox',
		'ajaxRegisterBox',
		'ajaxRegister',
		'ajaxForgotPass',
		'ajaxLoginValidate',
		'validateMail',
		'registrationSuccessful',
		'registration',
		'ajaxPassRecovery',
		'activate',
		'resetPassword',
		'playerProfile',
		'ajaxGetPosts',
		'iframeShowPhoto',
		'ajaxGetRepliesList',
		'fbLogin',
		'verifyTwitter',
		'twitterLogin',
		'twitchLogin',
		'register',
		'signin',
		'updateLang',
	),
	'ForumController' => array(
		'index',
		'forum',
		'board',
		'topic',
		'ajaxCollapseCategory',
		'ajaxExpandCategory'
	),
	'ReferralController' => array(
		'registerReferral',
		'cancelReferral',
	),
	'ShopController' => array(
		'acceptIpn',
		'acceptXsolla',
	),
	'CompaniesController' => '*',
	'GamesController' => '*',
);
$acl[GROUP_ANONYMOUS]['failRoute'] = array(
	'_default' => '/login/loginfirst',
$acl[GROUP_ANONYMOUS]['deny'] = array(
        'MainController' => array(
                'joinus',
                'joinusSuccessful',
                'join',
        ),
);
$acl[GROUP_ANONYMOUS]['failRoute'] = array(
	'_default' => '/players/loginfirst',
        'ShopController' => '/players/loginfirst/shop',
        'EsportController' => '/players/loginfirst/esport',
        'RecruitmentController' => '/players/loginfirst/recruitment',
        'MainController/joinus' => '/players/loginfirst/joinus',
        'FeedbackController' => '/players/loginfirst/feedback',
);
*/
$acl[GROUP_ANONYMOUS]['allow'] =
$acl[GROUP_PLAYER]['allow'] = array(
	'MainController' => '*',
	'BottommenuController' => '*',
	'LoginController' => '*',
	'NewsController' => '*',
	'PlayersController' => '*',
	'ForumController' => '*',
	'EventController' => '*',
	'ShopController' => '*',
	'ExternalController' => '*',
	'ReferralController' => '*',
	'CompaniesController' => '*',
	'GamesController' => '*',
	'GroupsController' => '*',
	'FeedbackController' => '*',
	'EsportController' => '*',
	'RecruitmentController' => '*',
	'BuySellTradeController' => '*',
	'AdminMainController' => '*',
	'AdminNewsController' => '*',
	'AdminUsersController' => '*',
	'AdminGamesController' => '*',
	'AdminCompaniesController' => '*',
	'AdminShopController' => '*',
	'AdminBugReportsController' => '*',
	'AdminTranslateController' => '*',
	'AdminEsportController' => '*',
	'AdminSetupController' => '*',
	'AdminStatsController' => '*',
	'AdminCampaignController' => '*',
	'AdminAchievementsController' => '*',
	'AdminLayoutController' => '*',
);

$acl[GROUP_ANONYMOUS]['deny'] = array(
	'ShopController'=>array('index'),
	'RecruitmentController'=>array('index'),
	'BuySellTradeController'=>array('index'),
	'PlayersController'=>array('index','wall'),
	'EsportController'=>array('profile'),
	'MainController'=>array('joinus','joinusSuccessful'),
	'FeedbackController'=>array('index'),
	);

$acl[GROUP_ANONYMOUS]['failRoute'] = array(
	'_default' => '/login/loginfirst',
	'ShopController' => '/login/loginfirst/shop',
	'EsportController' => '/login/loginfirst/esport',
	'RecruitmentController' => '/login/loginfirst/recruitment',
	'BuySellTradeController'=>'/login/loginfirst/buyselltrade',
	'MainController/joinus' => '/login/loginfirst/joinus',
	'FeedbackController' => '/login/loginfirst/feedback',
	'PlayersController' => '/login/loginfirst/players',
);

$acl[GROUP_PLAYER]['deny'] = array(
	'SnsController' => array('banUser', 'showVipHome'),
	'BlogController' => array('deleteComment', 'writePost')
);
$acl[GROUP_PLAYER]['failRoute'] = array(
	'_default' => '/login/loginfirst'
);


//$acl['admin']['allow'] = '*';
//$acl['admin']['deny'] = array(
//							'SnsController'=>array('showVipHome')
//						);
//
//$acl['admin']['failRoute'] = array(
//							'SnsController/showVipHome'=>'/error/admin/sns/vipOnly'
//						);
?>
