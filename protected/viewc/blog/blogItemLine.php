<?php 
	$functions = MainHelper::GetModuleFunctionsByTag('news');
	$userPlayer = User::getUser();
	$isApproved = ($userPlayer) && !($userPlayer === FALSE) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;
?>
<?php
$newsUrl = isset($objUrl) ? $objUrl.$item->PLAIN_URL : $item->URL;
$descLimit = 170;
$headerLimit = 50;
$player = User::getUser();

$funcList = array();
$showAdminFunc = false;
if(isset($featuredBlog) && !empty($featuredBlog)) $urlBlog = '/wall/blog';
else $urlBlog = '';

if(Auth::isUserLogged() === TRUE) {
	if((isset($isAdmin) and $isAdmin === TRUE) or $player->canAccess('Edit news') === TRUE){
		if(isset($item->NwItemLocale) and !empty($item->NwItemLocale)){
			$showAdminFunc = true;
			foreach($item->NwItemLocale as $locale){
				$funcList[] = '<a href="'.MainHelper::site_url('blog/editblog/'.$locale->ID_NEWS).'">'.$this->__('Edit').'</a>';
			}
		}
	}
	if($player->canAccess('Delete news') === TRUE or ($item->OwnerType == POSTRERTYPE_GROUP and Groups::getGroupByID($item->ID_OWNER)->isAdmin())){
		$funcList[] = '<a href="javascript:void(0)" rel="'.$item->ID_NEWS.'" class="delete_news">'.$this->__('Remove').'</a>';
	}
}
?>

<div class="list_item big clearfix itemPost">

	<a class="list_item_img" href="<?php echo $newsUrl; ?>"><?php echo MainHelper::showImage($item, THUMB_LIST_100x100, false, array('no_img' => 'noimage/no_news_100x100.png')); ?></a>

    <div class="list_item_meta">

		<div class="clearfix">
			<?php echo $this->renderBlock('blog/common/path', array('item' => $item, 'urlBlog' => $urlBlog)); ?>
			<?php echo $this->renderBlock('blog/common/ratingTop', array('item' => $item)); ?>
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
			<?php if ($functions['comments']==1 && $isApproved==1):?>
			<li>
				<a class="icon_link" href="<?php echo $newsUrl; ?>"><i class="comment_icon"></i><?php echo $item->Replies; ?> <?php echo $item->Replies != 1 ? $this->__('Comments') : $this->__('Comment'); ?></a>
			</li>
			<?php endif;?>
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