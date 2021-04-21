<?php
$functions = MainHelper::GetModuleFunctionsByTag('news');
$userPlayer = User::getUser();
$isApproved = (($userPlayer) && !($userPlayer === FALSE)) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;
$newsUrl = isset($objUrl) ? $objUrl.$item->PLAIN_URL : $item->URL;
$descLimit = 170;
$headerLimit = 45;
if($item->LANG_ID==12) { $headerLimit = 30; }; // If Chinese
$player = User::getUser();
$funcList = array();
$showAdminFunc = FALSE;
if(Auth::isUserLogged() === TRUE) {
	if((isset($isAdmin) && $isAdmin === TRUE) || $player->canAccess('Edit news') === TRUE) {
		if(isset($item->NwItemLocale) && !empty($item->NwItemLocale)) {
			$showAdminFunc = TRUE;
			$editUrl = isset($editURL) ? $editURL : $item->EDIT_URL;
			$funcList[] = '<a rel="iframe" href="'.$editUrl.'">'.$this->__('Edit'). '...</a>';
		}
	}
    if($userPlayer->canAccess('Translate news') === TRUE) {
        $showAdminFunc = true;
        $ownerUrl = Url::getUrlById($item->ID_OWNER, $item->OwnerType);
        $translateUrl = isset($translateURL) ? $translateURL : MainHelper::site_url($item->OwnerType.'/'.$ownerUrl->URL.'/admin/translate-news/'.$item->ID_NEWS);
        $funcList[] = '<a href="'.$translateUrl.'">' . $this->__('Translate') . '...</a>';
    };
	if($player->canAccess('Delete news') === TRUE || ($item->OwnerType == POSTRERTYPE_GROUP && Groups::getGroupByID($item->ID_OWNER)->isAdmin())) {
		$funcList[] = '<a href="javascript:void(0);" rel="'.$item->ID_NEWS.'" class="delete_news">'.$this->__('Remove').'</a>';
	}
}
?>

<div class="new_list_item newsContent">
    <div class="newsHeader">
        <span class="newsTitle">
            <h2><?php echo DooTextHelper::limitChar($item->Headline, $headerLimit, '...', 'utf8'); ?></h2>
        </span>
    </div>
    <div class="newsBody">
        <div class="newsImg">
            <a class="newsImg" href="<?php echo $newsUrl; ?>">
                <?php echo MainHelper::showImage($item, THUMB_LIST_246x167, false, array('no_img' => 'noimage/no_news_246x167.png')); ?>
            </a>
        </div>
        <span class="newsDate"><?php echo MainHelper::calculateTime($item->PostingTime); ?></span>
        <p class="newsDescription"><?php echo strip_tags(DooTextHelper::limitChar($item->IntroText, $descLimit, '...', 'utf8')); ?>
            <a href="<?php echo $newsUrl; ?>"><?php echo $this->__('Read more'); ?></a>
        </p>
		<?php /* <h2><a class="list_item_header" href="<?php echo $newsUrl; ?>"><?php echo DooTextHelper::limitChar($item->Headline, $headerLimit); ?></a></h2>*/?>
        <?php /* if ($functions['comments']==1 && $isApproved==1):?>
        <div class="newsComments">
                <a class="icon_link" href="<?php echo $newsUrl; ?>"><i class="comment_icon"></i><?php echo $item->Replies; ?> <?php echo $item->Replies != 1 ? $this->__('Comments') : $this->__('Comment'); ?></a>
        </div>
        <?php endif; */ ?>
        <div class="newsSocial">
            <?php
                $urlEncoded = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                $titleEncoded = urlencode($item->Headline);
            ?>
            <a href="https://twitter.com/share?text=<?php echo $titleEncoded, '&url=', $newsUrl, '&via=', urlencode('PlayNationdoteu'); ?>" target="_blank">
                <img src="../../global/img/iconTwitter.gif">
            </a>
            <a href="https://www.facebook.com/sharer.php?u=<?php echo $newsUrl, '&t=', $titleEncoded; ?>" target="_blank">
                <img src="../../global/img/iconFacebook.gif">
            </a>
        </div>
		<?php /*<ul class="list_item_footer">
			<?php if(isset($item->NwItemLocale) and !empty($item->NwItemLocale)):?>
				<?php $num = 0; foreach($item->NwItemLocale as $locale):
					if($num > 2) break;
					$num++;?>
					<?php if($item->LANG_ID != $locale->ID_LANGUAGE):?>
					<?php $localeUrl = isset($objUrl) ? $objUrl.$locale->PLAIN_URL : $locale->URL;?>
						<li>
							<a class="list_item_flag" href="<?php echo $localeUrl;?>"><img src="<?php echo MainHelper::site_url('global/img/flags/'.Doo::conf()->lang[$locale->ID_LANGUAGE].'.gif');?>" alt=""/></a>
						</li>
					<?php endif;?>
				<?php endforeach;?>
			<?php endif;?>
			<?php if ($functions['comments']==1 && $isApproved==1):?>
			<li>
				<a class="icon_link" href="<?php echo $newsUrl; ?>"><i class="comment_icon"></i><?php echo $item->Replies; ?> <?php echo $item->Replies != 1 ? $this->__('Comments') : $this->__('Comment'); ?></a>
			</li>
			<?php endif;?>
		</ul>
		<?php /*<span class="list_item_date"><?php echo MainHelper::calculateTime($item->PostingTime); ?></span> */ ?>
		<?php if($showAdminFunc === TRUE): ?>
			<div class="list_item_dropdown item_dropdown">
				<a href="javascript:void(0);" class="list_item_dropdown_trigger item_dropdown_trigger"><?php echo $this->__('Options'); ?></a>
				<ul class="list_item_dropdown_options item_dropdown_options">
					<li><?php echo implode("</li><li>", $funcList); ?></li>
				</ul>
			</div>
		<?php endif; ?>
    </div>
</div>
