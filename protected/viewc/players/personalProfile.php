<?php
$reguserFields = MainHelper::GetModuleFieldsByTag('reguser');
if(!isset($selected)) { $selected = 'wall'; };
$name = $player->FirstName ? $player->FirstName : '-';
$nickname = $player->NickName ? $player->NickName : '-';
$age = PlayerHelper::calculateAge($player->DateOfBirth);
$country = PlayerHelper::getCountry($player->Country);
$visitorID = (Auth::isUserLogged()) ? User::getUser()->ID_PLAYER : NULL;
?>
<input type="hidden" value="<?php echo $player->URL; ?>" name="player_url" id="player_url">

<!-- Profile photo start -->
<div class="profile_foto">
    <a href="<?php echo MainHelper::site_url('players/wall'); ?>" class="personal_profile_link">
		<?php echo MainHelper::showImage($player, THUMB_LIST_200x300, FALSE, array('width', 'no_img' => 'noimage/no_player_200x300.png')); ?>
    </a>
</div>
<!-- Profile photo end -->

<!-- Profile nickname start -->
<div class="profile_nickname">
	<span><?php echo $nickname; ?></span>
</div>
<!-- Profile nickname end -->

<!-- Profile rating start -->
<?php echo PlayerHelper::showRating($player, FALSE); ?>
<!-- Profile rating end -->

<!-- Profile credits start -->
<?php if(MainHelper::IsModuleEnabledByTag('memberships')==1): ?>
    <div class="profile_credits subtle_grey clearfix">
        <a href="<?php echo MainHelper::site_url('shop/buy-credits'); ?>">
            <span class="curr_span_pd"><?php echo MainHelper::creditsOutput($player->Credits); ?></span>
            &nbsp;/&nbsp;
            <span class="curr_span_pc"><?php echo MainHelper::centsOutput($player->PlayCredits); ?></span>
        </a>
    </div>
<?php endif; ?>
<!-- Profile credits end -->

<!-- Profile info start -->
<?php
$pInfo = MainHelper::GetPersonalInformation($player->ID_PLAYER);
$showNickName = in_array('vcb_nickname',$pInfo);
$showDob = in_array('vcb_dob',$pInfo);
$showCountry = in_array('vcb_country',$pInfo);
$anyPinfo = $showNickName + $showDob + $showCountry;
$suspendLevel = $player->getSuspendLevel();
$noProfileFunctionality = MainHelper::GetNoProfileFunctionality($suspendLevel);
$noSiteFunctionality = MainHelper::GetNoSiteFunctionality($suspendLevel);
if($anyPinfo): ?>
    <div class="personal_profile rounded_5_btm">
        <span class="user_info_header"><?php echo $this->__('User Info'); ?>:</span>
        <?php if((!$noProfileFunctionality) && ($visitorID === $player->ID_PLAYER)): ?>
            <a href="<?php echo MainHelper::site_url('players/edit'); ?>" class="user_info_edit icon_profile_edit">
                <?php echo $this->__('Edit'); ?>
            </a>
        <?php endif;
        if($showNickName): ?>
            <div class="user_info_item clearfix">
                <span class="user_info_vr"><?php echo $this->__('Nick'); ?>:</span>
                <span class="user_info_vl"><?php echo $nickname; ?></span>
            </div>
        <?php endif;
        if($reguserFields['DateOfBirth']['isEnabled'] == 1 && $showDob): ?>
            <div class="user_info_item clearfix">
                <span class="user_info_vr"><?php echo $this->__('Age'); ?>:</span>
                <span class="user_info_vl"><?php echo $age; ?></span>
            </div>
        <?php endif;
        if($reguserFields['Country']['isEnabled'] == 1 && $showCountry): ?>
            <div class="user_info_item clearfix">
                <span class="user_info_vr"><?php echo $this->__('Country'); ?>:</span>
                <span class="user_info_vl"><?php echo $country; ?></span>
            </div>
        <?php endif; ?>
    </div>
<?php else:
	if((!$noProfileFunctionality) && ($visitorID === $player->ID_PLAYER)): ?>
		<div class="personal_profile rounded_5_btm">
		&nbsp;	<a href="<?php echo MainHelper::site_url('players/edit'); ?>" class="user_info_edit icon_profile_edit"><?php echo $this->__('Edit'); ?></a>
		</div>
	<?php endif;
endif; ?>
<!-- Profile info end -->

<?php /*
<div class="F_cartBrief <?php echo (Auth::isUserLogged() and Cart::getBriefCart()) ? '' : 'dn';?>">
	<?php echo $this->renderBlock('common/briefCart', array());?>
</div>
*/
if(!isset($hideMenu)) { include('personalMenu.php'); }; ?>