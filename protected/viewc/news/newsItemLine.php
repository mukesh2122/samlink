<?php
$functions = MainHelper::GetModuleFunctionsByTag('news');
$userPlayer = User::getUser();
$isApproved = ($userPlayer) && !($userPlayer === FALSE) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;
$newsUrl = isset($objUrl) ? $objUrl . $item->PLAIN_URL : $item->URL;
if ($item->NwItemLocale) {
    $locales = $item->NwItemLocale;
    $userLang = $userPlayer ? $userPlayer->ID_LANGUAGE : 1;
    if (array_key_exists($userLang, $locales)) {
        $newsUrl = isset($objUrl) ? $objUrl . $locales[$userLang]->PLAIN_URL : MainHelper::site_url('news/view/' . $locales[$userLang]->PLAIN_URL);
    };
};
$descLimit = 170;
$headerLimit = 50;
if ($item->LANG_ID == 12) {
    $headerLimit = 30;
}; // If Chinese
$funcList = array();
$showAdminFunc = FALSE;
if (Auth::isUserLogged() === TRUE) {
    if ((isset($isAdmin) and $isAdmin === TRUE) || $userPlayer->canAccess('Edit news') === TRUE) {
        if (isset($item->NwItemLocale) && !empty($item->NwItemLocale)) {
            $showAdminFunc = TRUE;
            $editUrl = isset($editURL) ? $editURL : $item->EDIT_URL;
            $funcList[] = '<a rel="iframe" href="' . $editUrl . '">' . $this->__('Edit') . '...</a>';
        };
    };
    if ($userPlayer->canAccess('Translate news') === TRUE) {
        $showAdminFunc = TRUE;
        $ownerUrl = Url::getUrlById($item->ID_OWNER, $item->OwnerType);
        $translateUrl = isset($translateURL) ? $translateURL : MainHelper::site_url($item->OwnerType . '/' . $ownerUrl->URL . '/admin/translate-news/' . $item->ID_NEWS);
        $funcList[] = '<a href="' . $translateUrl . '">' . $this->__('Translate') . '...</a>';
    };
    if ($userPlayer->canAccess('Delete news') === TRUE or ($item->OwnerType == POSTRERTYPE_GROUP and Groups::getGroupByID($item->ID_OWNER)->isAdmin())) {
        $funcList[] = '<a href="javascript:void(0);" rel="' . $item->ID_NEWS . '" class="delete_news">' . $this->__('Remove') . '</a>';
    };
};
?>

<div class="list_item big clearfix itemPost">
    <a class="list_item_img" href="<?php echo $newsUrl; ?>"><?php echo MainHelper::showImage($item, THUMB_LIST_100x100, FALSE, array('no_img' => 'noimage/no_news_100x100.png')); ?></a>
    <div class="list_item_meta">
        <div class="clearfix">
            <?php echo $this->renderBlock('news/common/prefix', array('item' => $item));  ?>
            <?php echo $this->renderBlock('news/common/path', array('item' => $item)); ?>
            <?php echo $this->renderBlock('news/common/ratingTop', array('item' => $item)); // this is an empty file ???  ?>
        </div>
        <h2><a class="list_item_header" href="<?php echo $newsUrl; ?>"><?php echo DooTextHelper::limitChar($item->Headline, $headerLimit, '...', 'utf8'); ?></a></h2>
        <p class="list_item_description"><?php echo DooTextHelper::limitChar(strip_tags($item->IntroText), $descLimit, '...', 'utf8'); ?></p>
        <ul class="list_item_footer">
            <?php
            if (isset($item->NwItemLocale) && !empty($item->NwItemLocale)):
                $num = 0;
                foreach ($item->NwItemLocale as $locale):
                    if ($num > 10) {
                        break;
                    };
                    ++$num;
                    if ($item->LANG_ID !== $locale->ID_LANGUAGE):
                        $localeUrl = isset($objUrl) ? $objUrl . $locale->PLAIN_URL : MainHelper::site_url('news/view/' . $locale->PLAIN_URL);
                        ?>
                        <li><a class="list_item_flag" href="<?php echo $localeUrl; ?>"><img src="<?php echo MainHelper::site_url('global/img/flags/' . Doo::conf()->lang[$locale->ID_LANGUAGE] . '.gif'); ?>" alt=""></a></li>
                        <?php
                    endif;
                endforeach;
            endif;
            if ($functions['comments'] == 1 && $isApproved == 1):
                ?>
                <li><a class="icon_link" href="<?php echo $newsUrl; ?>"><i class="comment_icon"></i><?php echo $item->Replies; ?> <?php echo $item->Replies != 1 ? $this->__('Comments') : $this->__('Comment'); ?></a></li>
            <?php endif; ?>
        </ul>
        <span class="list_item_date"><?php echo MainHelper::calculateTime($item->PostingTime); ?></span>
        <?php if ($showAdminFunc === TRUE): ?>
            <div class="list_item_dropdown item_dropdown">
                <a href="javascript:void(0);" class="list_item_dropdown_trigger item_dropdown_trigger"><?php echo $this->__('Options'); ?></a>
                <ul class="list_item_dropdown_options item_dropdown_options">
                    <li><?php echo implode("</li><li>", $funcList); ?></li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>