<?php
$reguserFunctions = MainHelper::GetModuleFunctionsByTag('reguser');
$contentparentFields = MainHelper::GetModuleFieldsByTag('contentparent');
$userPlayer = User::getUser();
$isApproved = ($userPlayer) ? MainHelper::IsPlayerApproved($userPlayer->ID_PLAYER) : 1;
$suspendLevel = ($userPlayer) ? $userPlayer->getSuspendLevel() : 0;
$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
$isAdmin = User::canAccess("Edit company");
$isEditor = User::canAccess("Create news");
$anyMedia = MainHelper::countCompanyMedias($company);
$isEnabledForum = MainHelper::IsModuleEnabledByTag('forum');
if(MainHelper::IsModuleNotAvailableByTag('forum') == 1) { $isEnabledForum = 0; };
$isEnabledNews = MainHelper::IsModuleEnabledByTag('news');
if(MainHelper::IsModuleNotAvailableByTag('news') == 1) { $isEnabledNews = 0; };

if(isset($company)): ?>
    <input id="company_id" value="<?php echo $company->ID_COMPANY;?>" type="hidden" />
<?php endif; ?>  

<!-- Company photo start -->
<div class="profile_foto">
	<a href="<?php echo $company->COMPANY_URL; ?>" class="personal_profile_link">
		<?php echo MainHelper::showImage($company, THUMB_LIST_200x300, false, array('width', 'no_img' => 'noimage/no_company_200x300.png')); ?>
	</a>
	<ul id="img_load" class="dn"></ul>
</div>
<!-- Company photo end -->

<!-- Admin change picture start -->
<?php if(Auth::isUserLogged() && $isAdmin): ?>
	<div class="actions rounded_5_btm clearfix">
		<?php if($company->ImageURL != ''): ?>
			<a rel="<?php echo $company->ID_COMPANY; ?>" id="change_company_picture" href="javascript:void(0);"><?php echo $this->__('change picture'); ?></a>
		<?php else: ?>
			<a rel="<?php echo $company->ID_COMPANY; ?>" id="add_company_picture" href="javascript:void(0);"><?php echo $this->__('upload picture'); ?></a>
		<?php endif; ?>
	</div>
<?php endif; ?>
<!-- Admin change picture end -->

<!-- Company name start -->
<div class="profile_gamename">
	<span><?php echo $company->CompanyName;?></span>
</div>
<!-- Company name end -->

<!-- Company rating start -->
<?php echo $this->renderBlock('companies/common/rating', array('company' => $company)) ?>
<!-- Company rating end -->


<!-- SUBSCRIBE AND LIKE -->
<ul id="subLikeUl">
<?php if(Auth::isUserLogged()): ?>
	<?php if($company->isSubscribed($company->ID_COMPANY)):?>    	
        <a data-opt='{"id":"<?php echo $company->ID_COMPANY;?>", "type":"<?php echo SUBSCRIPTION_COMPANY;?>"}' class="subLikeLink unsubscribe unsubscribe_<?php echo $company->ID_COMPANY;?>" href="javascript:void(0)"><li class="subLikeList"><?php echo $this->__('Unsubscribe');?> <div id="iconSubscribe">&nbsp;</div></li></a>
        <a data-opt='{"id":"<?php echo $company->ID_COMPANY;?>", "type":"<?php echo SUBSCRIPTION_COMPANY;?>"}' class="subLikeLink dn subscribe subscribe_<?php echo $company->ID_COMPANY;?>" href="javascript:void(0)"><li class="subLikeList"><?php echo $this->__('Subscribe');?> <div id="iconSubscribe">&nbsp;</div></li></a>
    <?php else:?>
        <a data-opt='{"id":"<?php echo $company->ID_COMPANY;?>", "type":"<?php echo SUBSCRIPTION_COMPANY;?>"}' class="subLikeLink subscribe subscribe_<?php echo $company->ID_COMPANY;?>" href="javascript:void(0)"><li class="subLikeList"><?php echo $this->__('Subscribe');?> <div id="iconSubscribe">&nbsp;</div></li></a>
        <a data-opt='{"id":"<?php echo $company->ID_COMPANY;?>", "type":"<?php echo SUBSCRIPTION_COMPANY;?>"}' class="subLikeLink dn unsubscribe unsubscribe_<?php echo $company->ID_COMPANY;?>" href="javascript:void(0)"><li class="subLikeList"><?php echo $this->__('Unsubscribe');?> <div id="iconSubscribe">&nbsp;</div></li></a>
    <?php endif; ?>
    <?php if($company->isLiked()):?>
        <a class="subLikeLink dn company_like like like_<?php echo $company->ID_COMPANY;?>" href="javascript:void(0)" rel="<?php echo $company->ID_COMPANY;?>"><li class="subLikeList"><?php echo $this->__('Like'); ?> <div id="iconLike">&nbsp;</div></li></a>
        <a class="subLikeLink company_unlike unlike_<?php echo $company->ID_COMPANY;?>" href="javascript:void(0)" rel="<?php echo $company->ID_COMPANY;?>"><li class="subLikeList"><?php echo $this->__('Unlike'); ?> <div id="iconLike">&nbsp;</div></li></a>
    <?php else:?>
        <a class="subLikeLink company_like like like_<?php echo $company->ID_COMPANY;?>" href="javascript:void(0)" rel="<?php echo $company->ID_COMPANY;?>"><li class="subLikeList"><?php echo $this->__('Like'); ?> <div id="iconLike">&nbsp;</div></li></a>
        <a class="subLikeLink dn company_unlike unlike_<?php echo $company->ID_COMPANY;?>" href="javascript:void(0)" rel="<?php echo $company->ID_COMPANY;?>"><li class="subLikeList"><?php echo $this->__('Unlike'); ?> <div id="iconLike">&nbsp;</div></li></a>
    <?php endif;?>
<?php endif; ?>
</ul>

<?php /*
<div class="profile_buttons">
		<?php if(Auth::isUserLogged() and $isApproved==1 && !$noProfileFunctionality):?>

			<?php if($reguserFunctions['reguserSubscriptions']==1 && $isApproved==1):?>
				<?php if($game->isSubscribed()):?>

					<a data-opt='{"id":"<?php echo $game->ID_GAME;?>", "type":"<?php echo SUBSCRIPTION_GAME;?>"}' class="button button_178 button_icon button_no_shadow baby_blue clearfix dn subscribe subscribe_<?php echo $game->ID_GAME?>" href="javascript:void(0)" rel="<?php echo $game->ID_GAME;?>">
						<span class="text mt3"><?php echo $this->__('Subscribe'); ?></span>
						<span class="icon iconr_subscribe">&nbsp;</span>
					</a>

					<a data-opt='{"id":"<?php echo $game->ID_GAME;?>", "type":"<?php echo SUBSCRIPTION_GAME;?>"}' class="button button_178 button_icon button_no_shadow baby_blue clearfix unsubscribe unsubscribe_<?php echo $game->ID_GAME;?>" href="javascript:void(0)">
						<span class="text mt3"><?php echo $this->__('Unsubscribe'); ?></span>
						<span class="icon iconr_subscribe">&nbsp;</span>
					</a>
				<?php else: ?>

					<a data-opt='{"id":"<?php echo $game->ID_GAME;?>", "type":"<?php echo SUBSCRIPTION_GAME;?>"}' class="button button_178 button_icon button_no_shadow baby_blue clearfix subscribe subscribe_<?php echo $game->ID_GAME?>" href="javascript:void(0)" rel="<?php echo $game->ID_GAME;?>">
						<span class="text mt3"><?php echo $this->__('Subscribe'); ?></span>
						<span class="icon iconr_subscribe">&nbsp;</span>
					</a>

					<a data-opt='{"id":"<?php echo $game->ID_GAME;?>", "type":"<?php echo SUBSCRIPTION_GAME;?>"}' class="button button_178 button_icon button_no_shadow baby_blue clearfix dn unsubscribe unsubscribe_<?php echo $game->ID_GAME;?>" href="javascript:void(0)">
						<span class="text mt3"><?php echo $this->__('Unsubscribe'); ?></span>
						<span class="icon iconr_subscribe">&nbsp;</span>
					</a>

				<?php endif; ?>
			<?php endif; ?>

			<?php if(!$game->isLiked()):?>

				<a class="button button_178 button_icon button_no_shadow light_grey clearfix game_like like like_<?php echo $game->ID_GAME;?>" href="javascript:void(0)" rel="<?php echo $game->ID_GAME;?>">
					<span class="text mt2"><?php echo $this->__('Like'); ?></span>
					<span class="icon iconr_like mt2 mb2">&nbsp;</span>
				</a>

				<a class="button button_178 button_icon button_no_shadow light_grey clearfix dn game_unlike unlike_<?php echo $game->ID_GAME;?>" href="javascript:void(0)" rel="<?php echo $game->ID_GAME;?>">
					<span class="text mt2"><?php echo $this->__('Unlike'); ?></span>
					<span class="icon iconr_like mt2 mb2">&nbsp;</span>
				</a>

			<?php else:?>

				<a class="button button_178 button_icon button_no_shadow light_grey clearfix dn game_like like like_<?php echo $game->ID_GAME;?>" href="javascript:void(0)" rel="<?php echo $game->ID_GAME;?>">
					<span class="text mt2"><?php echo $this->__('Like'); ?></span>
					<span class="icon iconr_like mt2 mb2">&nbsp;</span>
				</a>

				<a class="button button_178 button_icon button_no_shadow light_grey clearfix game_unlike unlike_<?php echo $game->ID_GAME;?>" href="javascript:void(0)" rel="<?php echo $game->ID_GAME;?>">
					<span class="text mt2"><?php echo $this->__('Unlike'); ?></span>
					<span class="icon iconr_like mt2 mb2">&nbsp;</span>
				</a>

			<?php endif;?>

		<?php endif; ?>
	</div> */ ?>

<!-- MENU -->
<!--<head>
<link href='http://fonts.googleapis.com/css?family=Ubuntu:700italic' rel='stylesheet' type='text/css'>
</head>-->

<ul id="leftMenuUl">
    <?php $companyUrl = $company->COMPANY_URL; ?>
    <a href="<?php echo $companyUrl;?>" class="leftMenuLink"><li class="leftMenuList"><?php echo ucfirst($this->__('Info'));?></li></a>
    <?php if ($isEnabledNews == 1): ?>
        <a href="<?php echo $companyUrl.'/news';?>" class="leftMenuLink"> <li class="leftMenuList"><?php echo ucfirst($this->__('News'));?></li></a>
    <?php endif; ?>
    <a href="<?php echo $companyUrl.'/games';?>" class="leftMenuLink"><li class="leftMenuList"><?php echo ucfirst($this->__('Games'));?></li></a>
    <?php if($isEnabledForum == 1): ?>
        <a href="<?php echo $company->FORUM_URL;?>" class="leftMenuLink"><li class="leftMenuList"><?php echo ucfirst($this->__('Forum'));?></li></a>
    <?php endif; ?>
    <a href="<?php echo $company->EVENTS_URL;?>" class="leftMenuLink"><li class="leftMenuList"><?php echo ucfirst($this->__('Events'));?></li></a>
    <?php if($anyMedia != 0): ?>
        <a href="<?php echo $companyUrl.'/media';?>" class="leftMenuLink"><li class="leftMenuList"><?php echo ucfirst($this->__('Media'));?></li></a>
    <?php endif;
    if($isEditor): ?>
        <a href="<?php echo $companyUrl.'/admin/add-news';?>" class="leftMenuLink"><li class="leftMenuList"><?php echo ucfirst($this->__('Create news'));?></li></a>
    <?php endif; ?>
</ul>

