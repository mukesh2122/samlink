<?php
header("X-Robots-Tag: noarchive, noimageindex");
header("X-Robots-Tag: otherbot: noarchive, noimageindex");
header("X-Robots-Tag: Mediapartners: noarchive, noimageindex");
header("X-Robots-Tag: Googlebot: noarchive, noimageindex");
header("X-Robots-Tag: Googlebot-News: noarchive, noimageindex");
header("X-Robots-Tag: Googlebot-Image: noarchive, noimageindex");
header("X-Robots-Tag: Googlebot-Video: noarchive, noimageindex");
header("X-Robots-Tag: Googlebot-Mobile: noarchive, noimageindex");
header("X-Robots-Tag: Mediapartners-Google: noarchive, noimageindex");
header("X-Robots-Tag: AdsBot-Google: noarchive, noimageindex");

// Check for cookie accept
$acceptCookies = filter_input(INPUT_COOKIE, 'EUCookieLaw');
if($acceptCookies === "declined") { header("Location: http://www.theeucookielaw.com"); };

// Check for cache folder
if(!file_exists('./protected/cache')) { mkdir('./protected/cache', 0777, 1); };
// Check for configuration file
if(!file_exists('./protected/config/master.conf.php')) { copy(realpath('.').'/protected/config/master.conf.template',realpath('.').'/protected/config/master.conf.php'); }

// Start new session
session_start();

// Detect clients mobile platform
//include './protected/class/MobileDetect.php';
//$MobileDetect = new MobileDetect();
//$_SESSION['isMobile'] = ($MobileDetect->isMobile()) ? "TRUE" : "FALSE";
//$_SESSION['isTablet'] = ($MobileDetect->isTablet()) ? "TRUE" : "FALSE";
//if($_SESSION['isMobile'] || $_SESSION['isTablet']) { header('http://mobilesite.playnation.eu', true, 301); };

include './protected/class/CookieCheck.php';
include './protected/config/constants.php';
include './protected/config/master.conf.php';
include './protected/config/common.conf.php';
include './protected/config/routes.conf.php';
include './protected/config/db.conf.php';
include './protected/config/acl.conf.php';
include './protected/class/FirePHP/FirePHP.class.php';
include './protected/class/FirePHP/Fb.php';
include './protected/class/Twitter/OAuth.php';
include './protected/class/Twitter/twitteroauth.php';
include './protected/class/Facebook/facebook.php';
include './protected/class/twitch/twitch.php';
include './protected/class/MissingTypes.php';

// Check for news article image upload folder
if(!file_exists('./global/pub_img/'.FOLDER_CUSTOMVIEW)) { mkdir('./global/pub_img/'.FOLDER_CUSTOMVIEW, 0777, TRUE); };

if(!isset($_SESSION['user'])) {
	$_SESSION['user']['group'] = GROUP_ANONYMOUS;
	$_SESSION['user']['id'] = 0;
	$_SESSION['user']['isSuperUser'] = 0;
};

include $config['BASE_PATH'].'Doo.php';
include $config['BASE_PATH'].'app/DooConfig.php';
#Just include this for production mode
//include $config['BASE_PATH'].'deployment/deploy.php';

ini_set("open_basedir", FALSE);
# Uncomment for auto loading the framework classes.
spl_autoload_register('Doo::autoload');

# remove this if you wish to see the normal PHP error view.
if($config['APP_MODE'] == 'dev') {
	include $config['BASE_PATH'].'diagnostic/debug.php';
	$config['ERROR_HANDLER'] = 'setErrorHandler';
};

Doo::conf()->set($config);
Doo::conf()->add("EUCookieLaw", $acceptCookies);
Doo::acl()->rules = $acl;
Doo::acl()->defaultFailedRoute = '/error';

# database usage
//Doo::useDbReplicate();	#for db replication master-slave usage
Doo::db()->setMap($dbmap);
Doo::db()->setDb($dbconfig, $config['APP_MODE']);
//Doo::db()->sql_tracking = true;	#for debugging/profiling purpose
Doo::app()->route = $route;
# Uncomment for DB profiling
//Doo::logger()->beginDbProfile('doowebsite');
Doo::app()->run();
//Doo::logger()->endDbProfile('doowebsite');
//Doo::logger()->rotateFile(20);
//Doo::logger()->writeDbProfiles();
//echo Doo::benchmark();
?>