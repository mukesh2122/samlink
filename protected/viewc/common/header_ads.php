<?php
if(Membership::isValidFeature('noAdsTime') === FALSE): // && $_SERVER['REMOTE_ADDR'] != '127.0.0.1'
    $isLogged = Auth::isUserLogged();
    $topbanner = ($isLogged) ? MainHelper::pickBanner("top",MainHelper::getPageName()) : MainHelper::pickBannernotloggedin("top",MainHelper::getPageName());

    if(!empty($topbanner->ID_BANNER)):
        $id = $topbanner->ID_BANNER;
        $Displays = $topbanner->CurrentDisplays;
        $tmpurl = $topbanner->DestinationUrl;
        $url = (parse_url($tmpurl, PHP_URL_SCHEME) === NULL) ? 'http://' . $tmpurl : $tmpurl; ?>
        <div onmousedown="<?php MainHelper::countUpClick($id); ?>" class="header_ad">
        <!-- ?? Calling a static php function which queries the database, how will this work inline html ?? -->
            <?php if($topbanner->isCode==0): ?>
                <a href="<?php echo $url; ?>" target="_blank">
                    <img src="<?php echo MainHelper::site_url('global/pub_img/banners/'), $topbanner->PathToBanner; ?>"  border="0" alt="top banner" width="600">
                </a>
            <?php endif;
            echo ($topbanner->isCode == 1) ? $topbanner->Code : '';
            $newDisplay = $Displays + 1;
            MainHelper::countUpDisplays($id, $newDisplay); ?>
        </div>
    <?php endif;
endif; ?>