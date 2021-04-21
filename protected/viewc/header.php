<?php
$isEnabledTranslate = MainHelper::IsModuleEnabledByTag('translations');
$isEnabledShop = MainHelper::IsModuleEnabledByTag('shop');
$isEnabledLayout = MainHelper::IsModuleEnabledByTag('layout');
$acceptCookies = Doo::conf()->EUCookieLaw;
if(MainHelper::IsModuleNotAvailableByTag('shop')==1) { $isEnabledShop = 0; };
if(Auth::isUserLogged()) { $ref = MainHelper::site_url('players/wall'); }
else { $ref = MainHelper::site_url(''); };
if($isEnabledLayout) {
    $logo = Layout::getActiveLayoutValue('header_logo_img');
    $logopath = strpos($logo,'/') ? $logo : "global/css/img/".substr($logo, 0, 1)."/".substr($logo, 1, 1)."/$logo";
    $searchbar = Layout::getActiveLayoutValue('header_searchbar_active');
    $title = Layout::getActiveLayoutValue('header_logo_title');
};
$creator = Layout::getActiveLayout('siteinfo_register_creator');
?>

<div id="fb-root"></div>
<!-- Topbar start -->
<div id="topbar_container">
	<div id="topbar">
		<a class="logo" href="<?php echo $ref; ?>" title="<?php echo ($isEnabledLayout && isset($title)) ? $title : 'PlayNation - social network'; ?>">
            <img src="<?php echo ($isEnabledLayout && isset($logopath)) ? Doo::conf()->APP_URL.$logopath : Doo::conf()->APP_URL.'global/css/img/header_logo_beta.png'; ?>">
		</a>
		<!-- Login bar -->
		<?php if (!Auth::isUserLogged() && MainHelper::IsModuleEnabledByTag('reguser') == 1 && MainHelper::IsModuleNotAvailableByTag('reguser') == 0): ?>
			<form class="loginbar" id="login_form" method="GET">
				<div class="pull_left">
					<div class="pull_left">
						<span>
							<input id="login-email" name="email" type="text" placeholder="<?php echo $this->__('E-mail'); ?>">
						</span>
					</div>
					<div class="pull_left">
						<span>
							<input id="login-pass" name="pass" type="password" placeholder="<?php echo $this->__('Password'); ?>">
						</span>
					</div>
					<div class="login_error dn"></div>
				</div>
				<a class="button button_small light_blue pull_left" id="action_login" href="javascript:void(0);"><?php echo $this->__('Sign In'); ?></a>
				
				<!--FACEBOOK & TWITTER BEGIN-->
				<a id="facebook_login" href="javascript:void(0);"><i class="facebook_icon pull_left"></i></a>
				<a id="twitter_login" href="javascript:void(0);"><i class="twitter_icon pull_left"></i></a>
				<a id="twitch_signin" href="javascript:void(0);"><i class="twitch_icon pull_left"></i></a>
				<!--FACEBOOK & TWITTER END-->
				
				<div class="pull_left">
					<ul>
						<li>
							<a id="link_forgot" href="javascript:void(0);"><?php echo $this->__('Forgot your password?'); ?></a>
						</li>
						<?php if (!empty($creator) && $creator->Value == 'user'): ?>
							<li>
								<a href="<?php echo MainHelper::site_url('registration'); ?>"><?php echo $this->__('Register')?></a>
							</li>
						<?php endif; ?>
					</ul>
				</div>
			</form>
		<?php endif; ?>
        <?php if(Auth::isUserDeveloper()): ?>
            <div id="developerbar">
                <?php $userGroups = Doo::conf()->userGroups;
                $role = User::getUser()->ID_USERGROUP; ?>
                <label class="pull_left mr5 mt2" for="dk_container_usergroup"><?php echo $this->__('Role'); ?></label>
                <select class="mt-5" id="usergroup">
                    <?php foreach ($userGroups as $k => $v): ?>
                        <option <?php echo $role == $k ? "selected='selected'" : ''; ?> value="<?php echo $k; ?>"><?php echo $this->__($v['label']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif;
        $player = User::getUser();
        if ($player && $player->canAccess('Site admin')): ?>
			<div id="siteadmin_register">
				<a href="<?php echo MainHelper::site_url('registration'); ?>"><?php echo $this->__('Register new user')?></a>
			</div>
        <?php endif;
        if((isset($searchbar)) && ($searchbar == '1')): ?>
            <div id="global_search">
                <form action="<?php echo MainHelper::site_url('search'); ?>" id="top_search" method="get" autocomplete="off">
                    <input id="search" class="search_global" type="text" title="<?php echo $this->__('Search'); ?>" value="<?php echo $this->__('Search'); ?>">
                </form>
            </div>
        <?php endif; ?>
	</div>
</div>
<!-- Topbar end -->

<!-- Global navigation start -->
<?php if(isset($data['header'])):
    $menu = $data['header']; ?>
	<div id="global_nav_container" class="default">
		<div id="global_nav_wrapper" class="clearfix">
			<nav id="global_nav">
				<ul class="clearfix">
					<?php foreach ($menu->topmenu as $k1 => $v1):
						$active = '';
						if(/* Messes up menu MainHelper::activeMenu($v1->URL) or*/ (isset($data['selected_menu']) && $data['selected_menu'] == $v1->URL)) { $active = 'class="active"'; }; ?>
						<li <?php echo $active != '' ? $active : ''; ?>>
							<a href="<?php echo MainHelper::site_url($v1->URL); ?>">
								<?php echo $v1->NameTranslated; ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>

			<?php $langs = Lang::getLanguages();
            $currentLang = Lang::getCurrentLangID();
            $tmpGetLang = Lang::getLangById($currentLang);
            $selectedLang = (empty($tmpGetLang)) ? "EN" : $tmpGetLang->A2; ?>
            <div id="loaderDim"><img id="loaderPic" src="<?php echo MainHelper::site_url('global/css/img/ajax-loader.gif'); ?>"></div>
            <ul class="clearfix global_nav_actions">
				<?php if(Auth::isUserLogged() && $isEnabledShop == 1): ?>
                    <li class="global_nav_actions_li">
                        <div class="F_cartBrief <?php echo (Auth::isUserLogged() and Cart::getBriefCart()) ? '' : 'dn'; ?>">
                            <?php echo $this->renderBlock('common/briefCart', array()); ?>
                        </div>
                    </li>
				<?php endif;
				if($isEnabledTranslate == 1): ?>
                    <li class="global_nav_actions_li">
                        <a class="global_nav_action global_nav_action_trigger" href="#"><img class="lang_flag" src="<?php echo MainHelper::site_url('global/img/flags/'.strtolower($selectedLang).'.gif'); ?>"> <?php // echo $selectedLang->NativeName;?><i class="down_arrow_light_icon"></i></a>
                        <div class="global_nav_action_dropdown">
                            <ul class="dropdown_lang_select">
                                <?php foreach($langs as $lang): ?>
                                <li <?php echo $lang->ID_LANGUAGE == $currentLang ? 'class="active"' : ''; ?>>
                                    <a href="<?php echo MainHelper::site_url('lang/'.$lang->ID_LANGUAGE); ?>"><img class="lang_flag_list" src="<?php echo MainHelper::site_url('global/img/flags/'.strtolower($lang->A2).'.gif'); ?>"><?php echo $lang->NativeName; ?></a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
				<?php endif; /*
				if(!Auth::isUserLogged() && MainHelper::IsModuleEnabledByTag('reguser')==1 && MainHelper::IsModuleNotAvailableByTag('reguser')==0): ?>
                    <li class="global_nav_actions_li">
                        <a class="global_nav_action global_nav_action_trigger" href="javascript:void(0);"><?php echo $this->__('Register'); ?><i class="down_arrow_light_icon"></i></a>
                        <div class="global_nav_action_dropdown">
                            <form id="register_form" method="GET" class="dropdown_form">
                                <div class="dropdown_form_list">
                                    <div class="login_error dn"></div>
                                    <div>
                                        <label class="dropdown_form_label" for="register-email"><?php echo $this->__('E-mail'); ?></label>
                                        <span>
                                            <input class="first_child_input dropdown_form_input" id="register-email" name="email" type="text" value="" title="<?php echo $this->__('E-mail'); ?>">
                                        </span>
                                    </div>
                                    <div>
                                        <label class="dropdown_form_label" for="register-user"><?php echo $this->__('Nickname'); ?></label>
                                        <span>
                                            <input class="dropdown_form_input" id="register-user" name="nick" type="text" value="" title="<?php echo $this->__('Nickname'); ?>">
                                        </span>
                                    </div>
                                    <div>
                                        <label class="dropdown_form_label" for="register-pass"><?php echo $this->__('Password'); ?></label>
                                        <span>
                                            <input class="dropdown_form_input" id="register-pass" name="pass" type="password" value="" title="<?php echo $this->__('Password'); ?>">
                                        </span>
                                    </div>
                                    <div>
                                        <label class="dropdown_form_label" for="register-confirm-pass"><?php echo $this->__('Confirm Password'); ?></label>
                                        <span>
                                            <input class="dropdown_form_input" id="register-confirm-pass" name="confirm_pass" type="password" value="" title="<?php echo $this->__('Confirm Password'); ?>">
                                        </span>
                                    </div>
                                    <?php if(!isset($_SESSION['referringCode'])): ?>
                                        <div>
                                            <label class="dropdown_form_label" for="referral-code"><?php echo $this->__('Referral Code [_1](optional)[_2]', array('<em>', '</em>')); ?></label>
                                            <span>
                                                <input id="referral_code" class="dropdown_form_input" name="referral_code" type="text" value="<?php echo (isset($_SESSION['referringCode'])) ? intval ($_SESSION['referringCode']):''; ?>" title="<?php echo $this->__('Referral Code'); ?>">
                                            </span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="dropdown_form_terms no-margin clearfix">
                                        <div>
                                            <input id="accept-terms" name="terms" type="checkbox" value="1" title="<?php echo $this->__('I accept the Terms of Service'); ?>">
                                            <a class="" target="_blank" href="<?php echo MainHelper::site_url('info/terms'); ?>"><?php echo $this->__('I accept the Terms of Service'); ?></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="dropdown_form_footer">
                                    <div class="clearfix">
                                        <a class="dropdown_form_button light_blue" id="action_register" href="javascript:void(0);"><?php echo $this->__('Register'); ?></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>
                    <li class="global_nav_actions_li">
                        <a class="global_nav_action global_nav_action_trigger" href="javascript:void(0);"><?php echo $this->__('Sign In'); ?><i class="down_arrow_light_icon"></i></a>
                        <div class="global_nav_action_dropdown">
                            <form id="login_form" method="GET" class="dropdown_form">
                                <div class="dropdown_form_list">
                                    <div class="login_error dn"></div>
                                    <div>
                                        <label class="dropdown_form_label" for="login-email"><?php echo $this->__('E-mail'); ?></label>
                                        <span>
                                            <input class="first_child_input dropdown_form_input" id="login-email" name="email" type="text">
                                        </span>
                                    </div>
                                    <div>
                                        <label class="dropdown_form_label" for="login-pass"><?php echo $this->__('Password'); ?></label>
                                        <span>
                                            <input class="dropdown_form_input" id="login-pass" name="pass" type="password">
                                        </span>
                                    </div>
                                </div>

                                <!--FACEBOOK & TWITTER BEGIN-->
                                <div class="alt_signin clearfix">
                                    <a id="facebook_login" href="javascript:void(0);"><i class="facebook_icon"></i><?php echo $this->__("Connect with Facebook"); ?></a>
                                    <a id="twitter_login" href="javascript:void(0);"><i class="twitter_icon"></i><?php echo $this->__("Sign in with Twitter"); ?></a>
                                    <a id="twitch_signin" href="javascript:void(0);"><i class="twitch_icon"></i><?php echo $this->__("Log in with Twitch"); ?></a>
                                </div>
                                <!--FACEBOOK & TWITTER END-->
                                <div class="dropdown_form_footer">
                                    <div class="clearfix">
                                        <a class="dropdown_form_left_link" id="link_forgot" href="javascript:void(0);"><?php echo $this->__('Forgot your password?'); ?></a>
                                        <a class="dropdown_form_button light_blue" id="action_login" href="javascript:void(0);"><?php echo $this->__('Sign In'); ?></a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>
				<?php endif;*/ ?>
			</ul>
		</div>
	</div>
    <?php if($acceptCookies === NULL || $acceptCookies === FALSE): ?>
        <div id="accept-cookie-bar">
            <span id="accept-cookie-txt">
                <?php echo $this->__('By using this website, you agree to the use of'); ?>
                <a href="javascript:void(0);">
                    <?php echo $this->__('cookies'); ?>
                </a>
                .
                <a id="accept-cookie-but" href="#accept-cookie-bar">
                    <?php echo $this->__('Accept'); ?>
                </a>
            </span>
        </div>;
    <?php endif;
endif; ?>
<script type="text/javascript">loadCheckboxes();</script>
<!-- Global navigation end -->