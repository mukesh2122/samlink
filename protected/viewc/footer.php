<?php
$isLayoutEnabled = MainHelper::isModuleEnabledByTag('layout');
if($isLayoutEnabled) {
    $img_src = Layout::getActiveLayoutValue('footer_logo_img');
    $logopath = strpos($img_src,'/') ? $img_src : "global/pub_img/layout/".substr($img_src, 0, 1)."/".substr($img_src, 1, 1)."/$img_src";
    $facebook = Layout::getActiveLayoutValue('siteinfo_social_facebook');
    $twitter = Layout::getActiveLayoutValue('siteinfo_social_twitter');
};
?>
<div id="bottombar" class="clearfix">
    <div class="logo">
        <img src="<?php echo $isLayoutEnabled && isset($logopath) ? Doo::conf()->APP_URL.$logopath : Doo::conf()->APP_URL.'global/css/img/footer_logo.png'; ?>">
    </div>
    <?php if(isset($data['footer'])):
    $menu = $data['footer'];
        if(!empty($menu->bottommenu)): ?>
            <ul class="footer_nav">
                <?php foreach($menu->bottommenu as $k1=>$v1): ?>
                    <li>
						<?php /* // KiC Original line below ...
						<a href='<?php echo ($v1->URL != 'about') ? MainHelper::site_url('info/'.$v1->URL) : MainHelper::site_url('company/playnation'); ?>' title='<?php echo htmlspecialchars($v1->NameTranslated); ?>' ><?php echo $v1->NameTranslated; ?></a>
						// replaced with this: */ ?>
                        <a href='<?php echo ($v1->URL != 'about') ? (($v1->URL == 'players/feedback') ? MainHelper::site_url($v1->URL) : MainHelper::site_url('info/'.$v1->URL)) : MainHelper::site_url('company/playnation'); ?>' title='<?php echo htmlspecialchars($v1->NameTranslated); ?>'><?php echo $v1->NameTranslated; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif;
    endif; ?>

    <ul class="footer_social_nav">
        <li>
            <a class="icon_link" target="_blank" href="<?php echo isset($google) ? $google : 'https://plus.google.com/117458130912901209796'; ?>" rel="publisher"><i class="google_icon"></i>Google+</a>
        </li>
		<li>
			<a class="icon_link" target="_blank" href="<?php echo isset($facebook) ? $facebook : 'https://facebook.com/playnation.eu'; ?>"><i class="facebook_icon"></i>Facebook</a>
		</li>
        <li>
            <a class="icon_link" target="_blank" href="<?php echo isset($twitter) ? $twitter : 'https://twitter.com/PlayNationdoteu'; ?>"><i class="twitter_icon"></i>Twitter</a>
        </li>
    </ul>
</div>
<?php
// Can we please find another way of achieving this functionality ???
//After login redirect back to page before login
$loginfirst = FALSE;
$redirect = '';
$REQUEST_URI = str_replace('beta/','',substr($_SERVER['REQUEST_URI'], 1));
if(strpos($_SERVER['REQUEST_URI'], 'login/loginfirst') !== FALSE) {
    $loginfirst = TRUE;
    $redirect = str_replace('login/loginfirst/','',substr($REQUEST_URI, 0));
};
if(!empty($REQUEST_URI) && $REQUEST_URI !== 'signin' && $REQUEST_URI !== 'registration' && $loginfirst === FALSE) {
    $_SESSION['loginRedirect'] = MainHelper::site_url($REQUEST_URI);
} elseif(!empty($redirect)) /*if sent by acl.conf.php FAILROUTE*/ {
    $_SESSION['loginRedirect'] = MainHelper::site_url($redirect);
} elseif(!empty($_SERVER['HTTP_REFERER'])) /*if sent by AJAX*/ {
    $_SESSION['loginRedirect'] = $_SERVER['HTTP_REFERER'];
};
?>