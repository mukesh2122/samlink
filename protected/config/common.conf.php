<?php
/*
 * Common configuration that can be used throughout the application
 * Please refer to DooConfig class in the API doc for a complete list of configurations
 * Access via Singleton, eg. Doo::conf()->BASE_PATH;
 */
error_reporting(E_ALL | E_STRICT); // TODO: this should be dependent of 'dev'/'prod' mode
//error_reporting(NULL);
ini_set('display_errors',1);
date_default_timezone_set('UTC');

/**
 * for benchmark purpose, call Doo::benchmark() for time used.
 */
//$config['START_TIME'] = microtime(true);

$config['PROTECTED_FOLDER'] = 'protected/';
$config['CLASS_PATH'] = $config['SITE_PATH'].$config['PROTECTED_FOLDER'].'class/';

//----------------- optional, if not defined, default settings are optimized for production mode ----------------
//if your root directory is /var/www/ and you place this in a subfolder eg. 'app', define SUBFOLDER = '/app/'

$config['SUBFOLDER'] = str_replace($_SERVER['DOCUMENT_ROOT'], '', str_replace('\\','/',$config['SITE_PATH']));
//$config['SUBFOLDER'] = '/beta/';
if(strpos($config['SUBFOLDER'], '/')!==0){
	$config['SUBFOLDER'] = '/'.$config['SUBFOLDER'];
}

$config['APP_URL'] = 'http://'.$_SERVER['HTTP_HOST'].$config['SUBFOLDER'];
//$config['AUTOROUTE'] = TRUE;

$config['DEBUG_ENABLED'] = ($config['APP_MODE'] == 'prod') ? FALSE : TRUE;
//in diagnostic/debug.php exists EXIT in setErrorHandler, remove that on not beta

//$config['TEMPLATE_COMPILE_ALWAYS'] = TRUE;

//register functions to be used with your template files
//$config['TEMPLATE_GLOBAL_TAGS'] = array('url', 'url2', 'time', 'isset', 'empty');

/**
 * Path to store logs/profiles when using with the logger tool. This is needed for writing log files and using the log viewer tool
 */
//$config['LOG_PATH'] = '/var/logs/';
/**
 * defined either Document or Route to be loaded/executed when requested page is not found
 * A 404 route must be one of the routes defined in routes.conf.php (if autoroute on, make sure the controller and method exist)
 * Error document must be more than 512 bytes as IE sees it as a normal 404 sent if < 512b
 */
//$config['ERROR_404_DOCUMENT'] = 'error.php';
$config['ERROR_404_ROUTE'] = '/error';

/**
 * Settings for memcache server connections, you don't have to set if using localhost only.
 * host, port, persistent, weight
 * $config['MEMCACHE'] = array(
 *                       array('192.168.1.31', '11211', true, 40),
 *                       array('192.168.1.23', '11211', true, 80)
 *                     );
 */
/**
 * Defines modules that are allowed to be accessed from an auto route URI.
 * Example, we have a module in SITE_PATH/PROTECTED_FOLDER/module/example
 * It can be accessed via http://localhost/example/controller/method/parameters
 *
 * $config['MODULES'] = array('example');
 *
 */
/**
 * Unique string ID of the application to be used with PHP 5.3 namespace and auto loading of namespaced classes
 * If you wish to use namespace with the framework, your classes must have a namespace starting with this ID.
 * Example below is located at /var/www/app/protected/controller/test and can be access via autoroute http://localhost/test/my/method
 * <?php
 * namespace myapp\controller\test;
 * class MyController extends \DooController {
 *     .....
 * } ?>
 *
 * You would need to enable autoload to use Namespace classes in index.php
 * spl_autoload_register('Doo::autoload');
 *
 * $config['APP_NAMESPACE_ID'] = 'myapp$config['forumTopicsLimit'] = 20;
$config['forumIndexLimit'] = 50;
$config['forumMessagesLimit'] = 20;
$config['forumSearchMinLength'] = 2;
';
 *
 */
/**
 * To enable autoloading, add directories which consist of the classes needed in your application.
 *
 * $config['AUTOLOAD'] = array(
                            //internal directories, live in the app
                            'class', 'model', 'module/example/controller',
                            //external directories, live outside the app
                            '/var/php/library/classes'
                        );
*/
$config['AUTOLOAD'] = array(
    'override/helper',
    'override/controller',
    'override/view',
    'class',
    'class/Zend',
    'class/Yahoo',
    'class/CKEditor',
    'model',
    'helper',
);

/**
 * you can include self defined config, retrieved via Doo::conf()->variable
 * Use lower case for you own settings for future Compability with DooPHP
 */
//$config['pagesize'] = 10;

$config['postnum'] = 20;
$config['repliestnum'] = 5;
$config['photonum'] = 21;
$config['videonum'] = 21;
$config['defaultShowRepliesLimit'] = 5;
$config['defaultPageLimit'] = 10;
$config['csspagelimit'] = 5;

$config['FTUsteps'] = 4; //number of steps in FTU form

$config['frontpageNewsLimit'] = 25;
$config['topNewsLimit'] = 5;
$config['newsLimit'] = 25;
$config['mostReadNewsLimit'] = 5;
$config['highlightsPerRow'] = 3;
$config['relatedPerRow'] = 3;
$config['newsCatsLimit'] = 20;
$config['topBlogLimit'] = 5;
$config['bloggersLimit'] = 25;

$config['messagesLimit'] = 10;
$config['conversationsLimit'] = 10;
$config['messagesConversationLimit'] = 10;
$config['notificationsLimit'] = 50;

$config['emailFrom'] = 'registration@playnation.eu';
//$config['emailFrom'] = 'mailer@gsn-hosting.com'; // Test before new one
//$config['emailFrom'] = 'noreply@playnation.eu'; // Old one
$config['notificationHistory'] = time() - 13600;

$config['friendsLimit'] = 100;
$config['subscriptionsLimit'] = 50;

$config['globalSearchLimit'] = 10;

$config['forumTopicsLimit'] = 20;
$config['forumIndexLimit'] = 50;
$config['forumMessagesLimit'] = 20;
$config['forumSearchMinLength'] = 2;
$config['eventsSearchMinLength'] = 2;
$config['eventsLimit'] = 20;
$config['eventsSearchPlayersMax'] = 50;
$config['eventPILimit'] = 30;

$config['companiesLimit'] = 20;
$config['gamesLimit'] = 20;
$config['groupsLimit'] = 20;
$config['noticesLimit'] = 6;//catia
$config['mynoticesLimit'] = 2;//catia
$config['transactionsLimit'] = 10;
$config['groupMemberLimit'] = 20;
$config['achievementsLimit'] = 20;
$config['gameMemberLimit'] = 20;
$config['playerGroupsLimit'] = 20;
$config['playerGamesLimit'] = 20;
$config['playerEventsLimit'] = 20;
$config['playersLimit'] = 10;
$config['adminPlayersLimit'] = 50;
$config['adminAchievementsLimit'] = 50;
$config['adminGamesLimit'] = 50;
$config['adminCompaniesLimit'] = 50;
$config['adminNewsLimit'] = 50;
$config['adminBugReportsLimit'] = 30;
$config['adminTranslateLimit'] = 30;
$config['adminSetupLimit'] = 30;
$config['adminProductsLimit'] = 30;
$config['productsLimit'] = 15;
$config['ordersLimit'] = 20;

$config['FTUlistLimit'] = 20;

// Infobox
$config['memberType'] = '[_memberType]';
$config['maxPhotos'] = '[_maxPhotos]';

// Registration validation
$config['minNicknameLenght'] = 5;
$config['maxNicknameLenght'] = 40;
$config['minPasswordLenght'] = 8;
$config['maxPasswordLenght'] = 80;

$config['lang'] = array(
                        1=>'en',
                        2=>'da',
                        3=>'de',
                        4=>'fr',
                        5=>'es',
                        6=>'ro',
                        7=>'lt',
                        8=>'bg',
                        9=>'nl',
                        10=>'el',
                        11=>'tr',
                        12=>'zh',
                        13=>'is',
                        14=>'br',
                        15=>'th',
                        16=>'pt',
                        17=>'ru',
                        18=>'pl',
                        19=>'fi',
                        20=>'fa',
                        21=>'dr',
                        22=>'no',
                        23=>'se',
                        24=>'hu',
                        25=>'ar',
                        26=>'et',
                       );
$config['langName'] = array(
                        1=>'English',
                        2=>'Danish',
                        3=>'German',
                        4=>'French',
                        5=>'Spanish',
                        6=>'Romanian',
                        7=>'Lithuanian',
                        8=>'Bulgarian',
                        9=>'Dutch',

                        10=>'Greek',
                        11=>'Turkish',
                        12=>'Chinese',
                        13=>'Icelandic',
                        14=>'Brazilian',
                        15=>'Thai',
                        16=>'Portuguese',
                        17=>'Russian',
                        18=>'Polish',
                        19=>'Finnish',
                        20=>'Farsi',
                        21=>'Dari',
                        22=>'Norwegian',
                        23=>'Swedish',
                        24=>'Hungarian',
                        25=>'Arabic',
                        26=>'Estonian',
                       );

$config['default_lang'] = $config['lang'][1];
$config['maxFutureYears'] = 5;

//paypal
//use false on production
$config['paypal_test'] = FALSE;
$config['paypal'] = array(
                        'account' => 'info@playnation.eu',
                        'username' => '',
                        'pass' => '',
                        'signature' => 'AiwyWYy3HqxRlxCfdUigLqqwlP9cAjUvZHooq3PUo.MATqkCm8N07MPD'
                        );

$config['xsolla'] = array(
                        'project' => '7321',
                        'secret' => 'P-.G{zuz@/KW%6AuqX1=9k5LDUJS.F'
                        );

/**
 * sandbox account: email: richard@gametek.dk, pass: PlaynationRichard
 * buyer info: email: richar_1325245110_per@gametek.dk, pass: 325244993
 * seller info: email: richar_1325245185_biz@gametek.dk, pass: 325245151
 */
$config['paypal_demo'] = array(
                        'account' => 'richar_1325245185_biz@gametek.dk',
                        'username' => 'richar_1325245185_biz_api1.gametek.dk',
                        'pass' => '325245151',
                        'signature' => 'AiwyWYy3HqxRlxCfdUigLqqwlP9cAjUvZHooq3PUo.MATqkCm8N07MPD'
                        );

//cache settings
$config['cache_enabled'] = ($config['APP_MODE'] == 'prod') ? true : false; //should be true on live server
// For sandboxes only !!
// $config['cache_enabled'] = false; //should also be false on live server
$config['URL_LIFETIME'] = 2592000; // 30 days
$config['MENU_LIFETIME'] = 2592000; // 30 days
$config['GROUP_LIFETIME'] = 2592000; // 30 days
$config['GROUP_ALLIANCE_LIFETIME'] = 2592000; // 30 days
$config['COMPANY_LIFETIME'] = 2592000; // 30 days
$config['FORUM_LIFETIME'] = 2592000; // 30 days
$config['EVENT_LIFETIME'] = 2592000; // 30 days
$config['BUGREPORT_LIFETIME'] = 2592000; // 30 days

$config['OAUTH_CONSUMER_KEY'] = 'dj0yJmk9eGtZTE1qdkdvTHhjJmQ9WVdrOVNFZHpaR1Y0TkdNbWNHbzlNemd6TnpFeE1qWXkmcz1jb25zdW1lcnNlY3JldCZ4PWFh';
$config['OAUTH_CONSUMER_SECRET'] = 'c7009a1d6342d87989cd2bdc280a80343fff2eab';

//Google developer key.
$config['google_developer_key'] = "AIzaSyBw3rm2s6MrWSZeTnuYVQiqtrfJOn4OWwU";

//all image constants must be here provided

$config['image_sizes'] = array(
	THUMB_LIST_40x40,
	THUMB_LIST_60x60,
	THUMB_LIST_80x80,
	THUMB_LIST_95x95,
	THUMB_LIST_98x81, //companies
	THUMB_LIST_100x100,
	THUMB_LIST_100x150,
	THUMB_LIST_100x75,
    THUMB_LIST_100x33, // banner format
	THUMB_LIST_110x110,
	THUMB_LIST_138x107,
	THUMB_LIST_140x110,
	THUMB_LIST_180x140,
	THUMB_LIST_188x188,
	THUMB_LIST_198x148,
	THUMB_LIST_200x140,
	THUMB_LIST_200x300,
    THUMB_LIST_240x180,
	THUMB_LIST_320x320,
	THUMB_LIST_330x260,
    THUMB_LIST_600x200, // full banner
	IMG_600x360,
	IMG_800x600
);

// facebook
$config['fb_appid'] = '418700074881313';
$config['fb_secret'] = 'bc3de7c76f5a4272146e5ee2bee63ade';

// twitter
$config['twitter_key'] = '9oZujSD4GuUjnFvek0smw';
$config['twitter_secret'] = '5saXyUvksRTNvKGUSTkw985t1n28P1ICs6N8OQ5kAXM';

// twitch  - http://localhost
$config['twitch_id_local'] = 'kojzv819s9eox5118z8i9kyz2ysc468';
$config['twitch_secret_local'] = 'bbpe1yhehzus051ol313j9fwq0d3p49';
$config['twitch_id_local_login'] = '2kzg41w45551ejywtrkoxipxws1fygs';
$config['twitch_secret_local_login'] = 'bna16ht38u88iabuf2i4n1cm76hevhw';
//$config['twitch_id_local'] = 'cuu7qvldf4ore4nlevbn67pft14u8qz';
//$config['twitch_secret_local'] = 'hndxij1otavadouiech201kjucmoed6';
//twitch  - http://www.playnation.eu
$config['twitch_id'] = 'h71e26t73icxg2pqssprvg60e6xu36u';
$config['twitch_secret'] = '88equxbtkxunu8do6cahmx12mhs6lsn';
$config['twitch_id_login'] = 'nwbhuf1uynhbl1bfd02msbxckpjpjwg';
$config['twitch_secret_login'] = 'fp9jufby2aq338kiwx7ierike9tv9j3';
//$config['twitch_id'] = 'tkp4omcfzt8vxtnz0k3833fw8a9hf2s';
//$config['twitch_secret'] = 'qpsk1xl06xa2q98985vy5e1b28igta5';
//twitch  - http://beta.playnation.eu
$config['twitch_id_test'] = 'egg10xckrdc2ra4spm5fuj57113wins';
$config['twitch_secret_test'] = 'lbek06o0yk59z0tyb9zkqbs69kgbs6e';
$config['twitch_id_test_login'] = 'pbsu3hmcixr35z5b3bcf0xpgqf8m74a';
$config['twitch_secret_test_login'] = 'p8tylq52uzor8kqywdqpsfdt19myctp';
//twitch  - http://www.playnation.eu/beta
$config['twitch_id_beta'] = 'eavloc2w1y26jyxemjejnrtbo8ywsd4';
$config['twitch_secret_beta'] = 'mykl2xb97ala2w1l3940z4ql86x9kpe';
$config['twitch_id_beta_login'] = '82ewkw8taskh2c7bzmlq8iqc2nxqtpa';
$config['twitch_secret_beta_login'] = '7ylafjdt7fq6pakp6f9omk0oiike0jw';

//memberships types to package ID relation
$config['package'] = array(
	'no_ads_or_banners' => 13,
	'membership_contests' => 15,
	'membership_esport_events' => 16,
	'membership_offers_on_games' => 17,
	'membership_giveaways' => 18,
	'membership_beta_key_giveaways' => 19,
);

//downloadable items max download time
$config['downloadLimit'] = 2;

//playcoins for signups to referrer
$config['signupBonusPlaiCoins'] = 100;

$config['userGroups'] = array(
	0 => array('label' => 'None', 'allowed' => array()),
	1 => array('label' => 'Super Admin', 'allowed' => array('*')),
	2 => array('label' => 'User Admin', 'allowed' => array('Partial Admin', 'Edit user information')),
	3 => array('label' => 'Editor', 'allowed' => array('Partial Admin', 'Create news', 'Edit news', 'Delete news', 'Approve news', 'Reject news', 'Translate news', 'Edit game information', 'Edit company information')),
	4 => array('label' => 'Journalist', 'allowed' => array('Partial Admin', 'Create news', 'Edit news', 'Translate news', 'Edit game information', 'Edit company information')),
	5 => array('label' => 'Super Editor', 'allowed' => array('Partial Admin', 'Create news', 'Edit news', 'Delete news', 'Approve news', 'Reject news', 'Translate news', 'Edit game information', 'Edit company information', 'Edit user info light')),
//	6 => 'Overall Area Admin',
	7 => array('label' => 'Company Admin', 'allowed' => array('Partial Admin', 'Edit company information')),
	8 => array('label' => 'Game Admin', 'allowed' => array('Partial Admin', 'Edit game information', 'Edit company information', 'Edit review', 'Delete review')),
//	9 => 'Group Admin',
//	10 => 'Forum Admin',
//	11 => 'Forum Moderator',
//	12 => 'E-sport Admin',
	13 => array('label' => 'Shop Admin', 'allowed' => array('Partial Admin', 'Edit product categories', 'Create Products', 'Edit products', 'View orders')),
//  14 => 'Specific Company Admin',
//  15 => 'Specific Games Admin',
//  16 => 'Specific Group Admin',
	17 => array('label' => 'Translator', 'allowed' => array('Partial Admin', 'Translate', 'Translate news', 'Edit news')),
	18 => array('label' => 'Site Admin', 'allowed' => array('Partial Admin', 'Stats', 'Setup', 'Translate', 'Edit game information', 'Edit company information', 'Site admin', 'module_reguser', 'module_contentparent', 'module_contentchild')),
	19 => array('label' => 'Stats Admin', 'allowed' => array('Partial Admin', 'Stats')),
	20 => array('label' => 'Achievement Admin', 'allowed' => array('Edit achievement information')),
	21 => array('label' => 'Layout Admin', 'allowed' => array('Partial Admin', 'Edit layout')),
);
/**
PERMISSIONS
 *
User Pages
- Edit user information
- Delete user
News Pages
- Create news
- Edit news
- Delete news
Game Pages
- Create games
- Edit games
- Delete games
- Add downloads
- Edit downloads
- Delete downloads
Company Pages
- Create company
- Edit company
- Delete company
Forum Pages
- Create forum
- Edit forum
- Delete forum
- Create categories
- Edit categories
- Delete categories
- Add boards
- Edit boards
- Delete boards
- Edit forum posts
- Delete forum posts
- Suspend users from forum
- Ban users from forum
Group Pages
- Create group
- Edit group
- Delete group
- Add affiliate group
- Invite members to group
- Accept applications
- Reject applications
- Remove members from group
Events Pages
- Create events
- Edit events
- Delete events
- Invite people
- Remove people
Media Pages
- Add media
- Edit media
- Delete media
Shop Pages
- Create product categories
- Edit product categories
- Delete product categories
- Add products
- Edit products
- Delete products
E-sport Pages
- Edit info
- Add games
- Create leagues
- Edit leagues
- Delete leagues
- Create cups
- Edit cups
- Delete cups
Super Admin Interface - will include all the on-site stuff - this is the extra stuff
User Control Pages
- Suspend users
- Delete users
- Assign user roles
News Pages
- Approve news
- Reject news
Shop Pages
- View orders
- Retract orders
E-sport Pages
- Choose winner in match in case of dispute
- Close match with no winner
Affiliate Program Pages
- Suspend affiliate programs
- Ban users from light version
 */

// VideoPlayer
$config['videoAutoplay'] = TRUE;
$config['videoWaitTime'] = 1000;
$config['videoFPS'] = 33;
?>