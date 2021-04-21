<?php
$newsUrl = isset($objUrl) ? $objUrl.$item->PLAIN_URL : $item->URL;
$descLimit = 170;
$headerLimit = 50;
$player = User::getUser();

$funcList = array();
$showAdminFunc = false;
$isEditor = false;
$author = User::getById($item->ID_AUTHOR);

$ratings = new Ratings();
$reviewRating = $ratings->getUsersRating($item->OwnerType,$item->ID_OWNER,$item->ID_AUTHOR);

if($item->OwnerType==POSTRERTYPE_GAME) {
    $games = (isset($game)) ? $game : new SnGames();
    $isEditor = $games->isEditor();
}

if(Auth::isUserLogged() === TRUE) {
        if($isEditor === TRUE || $player->ID_PLAYER == $item->ID_AUTHOR) {
            $funcList[] = '<a href="javascript:void(0)" rel="'.$item->ID_NEWS.'" lang="'.$item->LANG_ID.'" class="unpublish_news">'.$this->__('Unpublish').'</a>';
        }
	if($player->canAccess('Edit review') === TRUE or $item->isAuthor()){
		if(isset($item->NwItemLocale) and !empty($item->NwItemLocale)){
			$showAdminFunc = true;
			$editUrl = $item->EDIT_URL;
			foreach($item->NwItemLocale as $locale){
				$funcList[] = '<a href="'.$game->GAME_URL.'/edit-review/'.$item->ID_NEWS.'/'.$locale->ID_LANGUAGE.'">'.$this->__('Edit in').' '.Doo::conf()->langName[$locale->ID_LANGUAGE].'</a>';
			}
		}
	}
	if($player->canAccess('Delete review') === TRUE or $player->ID_PLAYER == $item->ID_AUTHOR){
		$funcList[] = '<a href="javascript:void(0)" rel="'.$item->ID_NEWS.'" class="delete_news">'.$this->__('Remove').'</a>';
	}
}
?>

<div class="reviewArticleSmall">
	<div class="reviewFoundUseful"><?php echo $item->LikeCount . " out of " . ($item->LikeCount + $item->DislikeCount) . " found this review useful"; ?></div>
    
    <div class="reviewContent">
        <div class="reviewUserImg">
            <?php echo MainHelper::showImage($item, THUMB_LIST_100x100, false, array('no_img' => 'noimage/no_news_100x100.png')); ?>
            <p><a href="<?php echo MainHelper::site_url('player/'.$author->URL); ?>"><?php echo PlayerHelper::showName($author); ?></a></p>
        </div>
        
        <div class="reviewTop">
            <div class="reviewTitle"><a href="<?php echo $newsUrl; ?>"><?php echo $item->Headline; ?>
                <?php //echo MainHelper::showImage($item, THUMB_LIST_100x100, false, array('no_img' => 'noimage/no_news_100x100.png')); ?></a>
            </div>
            
            <div class="reviewUserRating"><?php echo PlayerHelper::showName($author); ?>'s rating: <?php echo !empty($reviewRating) ? $reviewRating->Rating : $reviewRating; ?></div>
            
            <div class="reviewIntroText"><?php echo strip_tags(DooTextHelper::limitChar($item->IntroText, $descLimit)); ?></div>
            
            <div class="reviewText1"><a href="<?php echo $newsUrl; ?>">Read more</a></div>
        </div>
            
        <div class="reviewCenterSmall">
            <?php /*<div class="reviewText2"> <?php echo $item->NewsText; ?><br/>
                <a href="?read=more&id=1">Read more</a>
            </div>*/?>
            
            <div class="reviewComments"><?php echo $item->Replies . " "; echo ($item->Replies != 1) ? $this->__("Comments") : $this->__("Comment"); ?></div>
            <div class="reviewFindUsefull">How do you find this review?
            	<a class="icon_link action_newslike" rel="<?php echo $item->ID_NEWS;?>_0" href="javascript:void(0)"><span class="reviewUseful">Useful</span></a>
                <a class="icon_link action_newsdislike" rel="<?php echo $item->ID_NEWS;?>_0" href="javascript:void(0)"><span class="reviewNotUseful">Not useful</span></a>
            </div>
        </div>
        
        <div class="reviewBottomSmall">&nbsp;</div>
    </div>
</div>

<div class="reviewLine">&nbsp;</div>

<?php /*
<div class="list_item big clearfix itemPost">

	<?php //if(isset($stars) and $stars > 0 and $stars < 6):?>
		<div class="list_item_img_stars">
			<div class="list_item_stars list_item_stars_<?php //echo $stars; ?>"></div>
			<a class="list_item_img" href="<?php echo $newsUrl; ?>"><?php echo MainHelper::showImage($item, THUMB_LIST_100x100, false, array('no_img' => 'noimage/no_news_100x100.png')); ?></a>
		</div>
	<?php //else: ?>
		<a class="list_item_img" href="<?php echo $newsUrl; ?>"><?php echo MainHelper::showImage($item, THUMB_LIST_100x100, false, array('no_img' => 'noimage/no_news_100x100.png')); ?></a>
	<?php //endif; ?>
                <div class="pull_right mr25"><h1><?php echo !empty($reviewRating) ? $reviewRating->Rating : '-'; ?></h1></div>

    <div class="list_item_meta">

		<div class="clearfix">
			<div class="list_item_path">
				<a href="<?php echo MainHelper::site_url('player/'.$author->URL); ?>"><?php echo $this->__('by'); ?> <?php echo PlayerHelper::showName($author); ?></a>
			</div>
			<?php echo $this->renderBlock('news/common/ratingTop', array('item' => $item)); ?>
		</div>

		<h2><a class="list_item_header" href="<?php echo $newsUrl; ?>"><?php echo DooTextHelper::limitChar($item->Headline, $headerLimit); ?></a></h2>

		<p class="list_item_description"><?php echo strip_tags(DooTextHelper::limitChar($item->IntroText, $descLimit)); ?></p>

		<ul class="list_item_footer">
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
			<li>
				<a class="icon_link" href="<?php echo $newsUrl; ?>"><i class="comment_icon"></i><?php echo $item->Replies; ?> <?php echo $item->Replies != 1 ? $this->__('Comments') : $this->__('Comment'); ?></a>
			</li>
			<li>
				<a class="icon_link action_newslike" rel="<?php echo $item->ID_NEWS;?>_0" href="javascript:void(0)"><i class="like_icon"></i><?php echo $this->__('Like');?> (<span class="like_comment_num"><?php echo $item->LikeCount;?></span>)</a>
			</li>
			<li>
				<a class="icon_link action_newsdislike" rel="<?php echo $item->ID_NEWS;?>_0" href="javascript:void(0)"><i class="dislike_icon"></i><?php echo $this->__('Dislike');?> (<span class="dislike_comment_num"><?php echo $item->DislikeCount;?></span>)</a>
			</li>
		</ul>

		<span class="list_item_date"><?php echo MainHelper::calculateTime($item->PostingTime); ?></span>

		<?php if($showAdminFunc === true): ?>
			<div class="list_item_dropdown item_dropdown">
				<a href="javascript:void(0)" class="list_item_dropdown_trigger item_dropdown_trigger"><?php echo $this->__('Options');?></a>
				<ul class="list_item_dropdown_options item_dropdown_options">
					<li><?php echo implode("</li><li>", $funcList);?></li>
				</ul>
			</div>
		<?php endif;?>

    </div>
</div>

 */?>