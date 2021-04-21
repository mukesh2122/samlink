<?php if(Membership::isValidFeature('noAdsTime') === FALSE):   // && $_SERVER['REMOTE_ADDR'] != '127.0.0.1'
    $sidebanner = (Auth::isUserLogged()) ? MainHelper::pickBanner("side",MainHelper::getPageName()) : MainHelper::pickBannernotloggedin("side",MainHelper::getPageName());
	if(!empty($sidebanner->ID_BANNER)):
		$id = $sidebanner->ID_BANNER;
        $tmpurl = $sidebanner->DestinationUrl;
        $url = (parse_url($tmpurl, PHP_URL_SCHEME) === NULL) ? 'http://' . $tmpurl : $tmpurl;
		$Displays = $sidebanner->CurrentDisplays; ?>
		<div onmousedown="<?php MainHelper::countUpClick($id); ?>" class="right_column_item ad mt10">
            <?php if($sidebanner->isCode==0): ?>
                <a href="<?php echo $url; ?>" target="_blank">
                    <img src="<?php echo MainHelper::site_url('global/pub_img/banners/'), $sidebanner->PathToBanner; ?>" border="0" alt="side banner" width="200">
                </a>
            <?php endif;
            if($sidebanner->isCode==1) { echo $sidebanner->Code; };
            $newDisplay = $Displays+1;
            MainHelper::countUpDisplays($id, $newDisplay); ?>
		</div>
    <?php endif;
endif; ?>