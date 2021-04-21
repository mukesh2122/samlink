<?php
$isEnabledLayout = MainHelper::IsModuleEnabledByTag('layout');
$title = ($isEnabledLayout) ? Layout::getActiveLayoutValue('siteinfo_site_name') : 'PlayNation';
$appUrl = Doo::conf()->APP_URL;
$sitePath = Doo::conf()->SITE_PATH;
$isLoggedOn = Auth::isUserLogged();
$files = include($sitePath . 'protected/config/JsCss.conf.php');
$css = $files['css'];
$js = $files['js'];
$cEnd = count($css);
$jEnd = count($js);
if(!empty($_SERVER['SERVER_NAME'])) { $absUrl = $_SERVER['SERVER_NAME']; }
else if (!empty($_SERVER['HTTP_HOST'])) { $absUrl = $_SERVER['HTTP_HOST']; }
else if (!empty($_SERVER['HOST_NAME'])) { $absUrl = $_SERVER['HOST_NAME']; }
else if (!empty($_SERVER['SERVER_SITE'])) { $absUrl = $_SERVER['SERVER_SITE']; };
$absUrl .= (Doo::conf()->APP_MODE == 'dev') ? '/beta/' : '/';
?>

<meta charset="UTF-8">
<meta name="author" content="http://www.playnation.eu">
<meta name="application-name" content="Playnation">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="copyright" content="Playnation">
<meta name="description" content="PlayNation is a social networking service. The company aspires to give gamers around the world a one-stop online community that offers social activities, news and e-sport tournaments; an opportunity to compete, socialize and keep up with the latest news of the gaming world">
<meta name="distribution" content="global">
<meta name="expires" content="never">
<meta name="google-site-verification" content="mGaSH7adlwZzd0JKckReE3yULiEUWeLfB6B4B4u47ac">
<meta name="Googlebot" content="noarchive, noimageindex">
<meta name="Googlebot-News" content="noarchive, noimageindex">
<meta name="Googlebot-Image" content="noarchive, noimageindex">
<meta name="Googlebot-Video" content="noarchive, noimageindex">
<meta name="Googlebot-Mobile" content="noarchive, noimageindex">
<meta name="Mediapartners-Google" content="noarchive, noimageindex">
<meta name="AdsBot-Google" content="noarchive, noimageindex">
<meta name="Mediapartners" content="noarchive, noimageindex">
<meta name="keywords" content="playnation,gsn,games,social network,esport,raid,mmoprg,competition,fun,activities,news">
<meta name="rating" content="14 years">
<meta name="robots" content="noarchive">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">

<link rel="publisher" href="https://plus.google.com/[117458130912901209796]">
<link rel="author" href="https://plus.google.com/[101958285538803731306]">

<!--[if gte IE 9]><!-->
    <link rel="icon" href="//<?php echo $absUrl; ?>newfavicon.ico" sizes="16x16 24x24 32x32" type="image/vnd.microsoft.icon">
<!--<![endif]-->
<!--[if lt IE 9]>
    <link rel="shortcut icon" href="/favicon.ico"/>
<![endif]-->

<!--[if gte IE 9]><!-->
    <link rel="stylesheet" href="<?php echo $appUrl; ?>global/css/ui-lightness/jquery-ui-1.10.4.custom.css" type="text/css" media="all">
<!--<![endif]-->
<!--[if lt IE 9]>
    <link rel="stylesheet" href="<?php echo $appUrl; ?>global/css/ui-lightness/jquery-ui-1.9.2.custom.css" type="text/css" media="all">
<![endif]-->

<?php
	for ($i = 0; $i < $cEnd; ++$i) {
		echo '<link rel="stylesheet" href="'.$appUrl.$css[$i].'" type="text/css" media="all">';
	}
	if (!empty($data['dynamicCss'])) {
		echo '<link rel="stylesheet" href="'.$data['dynamicCss'].'" type="text/css" media="all">';
	}
	else {
		$dynCss = new DynamicCSS;
		$defaultCss = $dynCss->getDefaultCss();
		if (!empty($defaultCss)) {
			echo '<link rel="stylesheet" href="'.$defaultCss.'" type="text/css" media="all">';
		}
	}
?>

<!--[if gte IE 7]>
    <link rel="stylesheet" href="<?php echo $appUrl; ?>global/css/ie.css" type="text/css" media="all">
<![endif]-->
<!--[if lte IE 7]>
    <link rel="stylesheet" type="text/css" href="<?php echo $appUrl; ?>global/css/ie7_and_down.css">
<![endif]-->

<!--[if lt IE 9]>
    <script type="text/javascript" src="<?php echo $appUrl; ?>global/js/jquery-1.11.0.js"></script>
    <script type="text/javascript" src="<?php echo $appUrl; ?>global/js/jquery-ui-1.9.2.custom.js"></script>
<![endif]-->
<!--[if gte IE 9]><!-->
    <script type="text/javascript" src="<?php echo $appUrl; ?>global/js/jquery-2.1.0.js"></script>
    <script type="text/javascript" src="<?php echo $appUrl; ?>global/js/jquery-ui-1.10.4.custom.js"></script>
<!--<![endif]-->

<?php // translation snippets, constants and global variables for javascript usage
include($sitePath . 'global/js/head.js.php');

for($i = 0; $i < $jEnd; ++$i): ?>
    <script type="text/javascript" src="<?php echo $appUrl, $js[$i]; ?>"></script>
<?php endfor;
    if(isset($data['scripts'])) { echo $data['scripts']; }; // KiC - added during feedback implementation
?>

<title><?php echo $data['title'], ' | ', $title; ?></title>