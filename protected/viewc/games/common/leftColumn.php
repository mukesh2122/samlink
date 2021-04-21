<?php $reguserFunctions = MainHelper::GetModuleFunctionsByTag('reguser');
$isRegUsers = MainHelper::IsModuleEnabledByTag('reguser');
$isEnabledRegUser = MainHelper::IsModuleEnabledByTag('reguser');
$isEnabledNews = MainHelper::IsModuleEnabledByTag('news');
$isEnabledContentparent = MainHelper::IsModuleEnabledByTag('contentparent');
$isEnabledForum = MainHelper::IsModuleEnabledByTag('forum');
$contentchildFields = MainHelper::GetModuleFieldsByTag('contentchild');
if (MainHelper::IsModuleNotAvailableByTag('contentparent')==1) $isEnabledContentparent = 0;
if (MainHelper::IsModuleNotAvailableByTag('news')==1) $isEnabledNews = 0;
if (MainHelper::IsModuleNotAvailableByTag('forum')==1) $isEnabledForum = 0;
if (MainHelper::IsModuleNotAvailableByTag('reguser')==1) $isRegUsers = 0;
$contentchildFunctions = MainHelper::GetModuleFunctionsByTag('contentchild'); 
$anyMedia = $contentchildFunctions['contentchildMediaVideos'] + $contentchildFunctions['contentchildMediaScreenshots']
		+ $contentchildFunctions['contentchildMediaConceptArt']+ $contentchildFunctions['contentchildMediaWallpapers']
		+ $contentchildFunctions['contentchildMediaDownloads'];

if(isset($game)): ?>
    <input id="game_id" value="<?php echo $game->ID_GAME; ?>" type="hidden">
<?php endif;

$isEnabledRegUser = MainHelper::IsModuleEnabledByTag('reguser');
$reguserFunctions = MainHelper::GetModuleFunctionsByTag('reguser');
$isEnabledContentparent = MainHelper::IsModuleEnabledByTag('contentparent');
$contentchildFields = MainHelper::GetModuleFieldsByTag('contentchild');
if(MainHelper::IsModuleNotAvailableByTag('contentparent')==1) { $isEnabledContentparent = 0; };
$userPlayer = User::getUser();
$isApproved = ($userPlayer) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;
$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
$p = User::getUser();
$isAdmin = $p and $p->canAccess('Edit game information');
$isEditor = $p and $p->canAccess('Create news');
$platformNames = MainHelper::getGamePlatforms($game);
$relations = $game->getCompanyRel();
$developers = '';//count($relations->developers) == 0 ? '-' : '';
if(isset($relations) && !empty($relations->developers) && is_array($relations->developers)) {
    $developers = array();
    foreach($relations->developers as $d) { $developers[] = '<a href="'.$d->SnCompanies->COMPANY_URL.'">'.$d->SnCompanies->CompanyName.'</a>'; };
    $developers = implode(", ", $developers);
};
$distributors = '';//count($relations->distributors) == 0 ? '-' : '';
if(isset($relations) && !empty($relations->distributors) && is_array($relations->distributors)) {
    $distributors = array();
    foreach($relations->distributors as $d) { $distributors[] = '<a href="'.$d->SnCompanies->COMPANY_URL.'">'.$d->SnCompanies->CompanyName.'</a>'; };
    $distributors = implode(", ", $distributors);
};
?>
<input type="hidden" id="game_id" value="<?php echo $game->ID_GAME; ?>">
<!-- Game photo start -->
<div class="profile_foto">
	<a href="<?php echo $game->GAME_URL; ?>" class="personal_profile_link">
		<?php echo MainHelper::showImage($game, THUMB_LIST_200x300, false, array('width', 'no_img' => 'noimage/no_game_200x300.png')); ?>
	</a>
	<ul id="img_load" class="dn"></ul>
</div>
<!-- Game photo end -->

<!-- Admin change picture start -->
<?php if(Auth::isUserLogged() && $isAdmin): ?>
	<div class="actions rounded_5_btm clearfix">
		<?php if($game->ImageURL != ''): ?>
			<a rel="<?php echo $game->ID_GAME; ?>" id="change_game_picture" href="javascript:void(0);"><?php echo $this->__('change picture'); ?></a>
		<?php else: ?>
			<a rel="<?php echo $game->ID_GAME; ?>" id="add_game_picture" href="javascript:void(0);"><?php echo $this->__('upload picture'); ?></a>
		<?php endif; ?>
	</div>
<?php endif; ?>
<!-- Admin change picture end -->

<!-- Game name start -->
<div class="profile_gamename">
	<span><?php echo $game->GameName; ?></span>
</div>
<!-- Game name end -->

<!-- Game rating start -->
<?php echo $this->renderBlock('games/common/rating', array('game' => $game)); ?>
<!-- Game rating end -->

<!-- SUBSCRIBE AND LIKE -->
<!--<ul id="subLikeUl">
    <a href="#" class="subLikeLink"><li class="subLikeList">Subscribe <div id="iconSubscribe">&nbsp;</div></li></a>
    <a href="#" class="subLikeLink"><li class="subLikeList">Like <div id="iconLike">&nbsp;</div></li></a>
</ul>-->

<?php $extrafields = MainHelper::GetExtraFieldsByOwnertype('game',$game->ID_GAME);
foreach($extrafields as $extrafield):
    $v = $extrafield['ValueText'];
    if(!empty($v)): ?>
        <div class="user_info_item_long clearfix">
            <span class="user_info_vr_long"><?php echo $extrafield['FieldName']; ?>:</span>
            <span class="user_info_vl_long"><?php echo $v; ?></span>
        </div>
    <?php endif;
endforeach; ?>

<!-- SUBSCRIBE AND LIKE -->
<ul id="subLikeUl">
<?php if(Auth::isUserLogged()):
    $idgame = $game->ID_GAME;
	if($game->isSubscribed($game->ID_GAME)): ?>    	
        <a data-opt='{"id":"<?php echo $idgame; ?>", "type":"<?php echo SUBSCRIPTION_GAME;?>"}' class="subLikeLink unsubscribe unsubscribe_<?php echo $game->ID_GAME;?>" href="javascript:void(0);"><li class="subLikeList"><?php echo $this->__('Unsubscribe');?> <div id="iconSubscribe">&nbsp;</div></li></a>
        <a data-opt='{"id":"<?php echo $idgame; ?>", "type":"<?php echo SUBSCRIPTION_GAME;?>"}' class="subLikeLink dn subscribe subscribe_<?php echo $game->ID_GAME;?>" href="javascript:void(0);"><li class="subLikeList"><?php echo $this->__('Subscribe');?> <div id="iconSubscribe">&nbsp;</div></li></a>
    <?php else: ?>
        <a data-opt='{"id":"<?php echo $idgame; ?>", "type":"<?php echo SUBSCRIPTION_GAME;?>"}' class="subLikeLink subscribe subscribe_<?php echo $game->ID_GAME;?>" href="javascript:void(0);"><li class="subLikeList"><?php echo $this->__('Subscribe');?> <div id="iconSubscribe">&nbsp;</div></li></a>
        <a data-opt='{"id":"<?php echo $idgame; ?>", "type":"<?php echo SUBSCRIPTION_GAME;?>"}' class="subLikeLink dn unsubscribe unsubscribe_<?php echo $game->ID_GAME;?>" href="javascript:void(0);"><li class="subLikeList"><?php echo $this->__('Unsubscribe');?> <div id="iconSubscribe">&nbsp;</div></li></a>
    <?php endif;
    if($game->isLiked()): ?>
        <a class="subLikeLink dn game_like like like_<?php echo $idgame;?>" href="javascript:void(0);" rel="<?php echo $idgame;?>"><li class="subLikeList"><?php echo $this->__('Like'); ?> <div id="iconLike">&nbsp;</div></li></a>
        <a class="subLikeLink game_unlike unlike_<?php echo $idgame;?>" href="javascript:void(0);" rel="<?php echo $idgame;?>"><li class="subLikeList"><?php echo $this->__('Unlike'); ?> <div id="iconLike">&nbsp;</div></li></a>
    <?php else: ?>
        <a class="subLikeLink game_like like like_<?php echo $idgame;?>" href="javascript:void(0);" rel="<?php echo $idgame;?>"><li class="subLikeList"><?php echo $this->__('Like'); ?> <div id="iconLike">&nbsp;</div></li></a>
        <a class="subLikeLink dn game_unlike unlike_<?php echo $idgame;?>" href="javascript:void(0);" rel="<?php echo $idgame;?>"><li class="subLikeList"><?php echo $this->__('Unlike'); ?> <div id="iconLike">&nbsp;</div></li></a>
    <?php endif;
endif; ?>
</ul>

<br/>

<ul id="leftMenuUl">
    <?php $gameUrl = $game->GAME_URL; ?>
    <a href="<?php echo $gameUrl;?>" class="leftMenuLink"><li class="leftMenuList"><?php echo ucfirst($this->__('Info'));?></li></a>
    <?php if ($isEnabledNews == 1): ?>
        <a href="<?php echo $gameUrl.'/news';?>" class="leftMenuLink"> <li class="leftMenuList"><?php echo ucfirst($this->__('News'));?></li></a>
    <?php endif;
    if($contentchildFunctions['contentchildWall'] == 1): ?>
        <a href="<?php echo $gameUrl.'/wall';?>" class="leftMenuLink"><li class="leftMenuList"><?php echo ucfirst($this->__('Wall'));?></li></a>
    <?php endif;
    if($contentchildFunctions['contentchildUgf'] == 1): ?>
        <a href="<?php echo $gameUrl.'/reviews';?>" class="leftMenuLink"><li class="leftMenuList"><?php echo ucfirst($this->__('Reviews'));?></li></a>
    <?php endif;
    if($isRegUsers==1):?>
        <a href="<?php echo $gameUrl.'/players';?>" class="leftMenuLink"><li class="leftMenuList"><?php echo ucfirst($this->__('Players'));?></li></a>
    <?php endif;
    if($isEnabledForum == 1): ?>
        <a href="<?php echo $game->FORUM_URL;?>" class="leftMenuLink"><li class="leftMenuList"><?php echo ucfirst($this->__('Forum'));?></li></a>
    <?php endif; ?>
    <a href="<?php echo $game->EVENTS_URL;?>" class="leftMenuLink"><li class="leftMenuList"><?php echo ucfirst($this->__('Events'));?></li></a>
    <?php if($anyMedia != 0): ?>
        <a href="<?php echo $gameUrl.'/media';?>" class="leftMenuLink"><li class="leftMenuList"><?php echo ucfirst($this->__('Media'));?></li></a>
    <?php endif;
    if($isEditor): ?>
        <a href="<?php echo $gameUrl.'/admin/add-news';?>" class="leftMenuLink"><li class="leftMenuList"><?php echo ucfirst($this->__('Create news'));?></li></a>
    <?php endif; ?>
</ul>