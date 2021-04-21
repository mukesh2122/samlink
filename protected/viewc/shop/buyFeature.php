<p class="popup_width_mdl_content">
<?php
$hideButtons = false;
$packName = $this->__($neededPackage->PackageType);
$player = User::getUser();

if($player->Credits < $neededPackage->Price) {
	echo $this->__('You do not have enough Credits on your account. Please buy Credits now.');
	$hideButtons = true;
} else {
	if($neededPackageRel->SpecialType === GAME) {
		if($isCurrentPackage === TRUE) {
			echo $this->__('You have already activated this feature. It will renew on [_1]. If you wish to extend it now, [_2] will get deducted from your account.', array(
				date(DATE_SHORT, $currentPackageRel->ExpirationTime),
				MainHelper::creditsOutput($neededPackage->Price)
			));
		} else {
			echo $this->__('This will grant you access to [_1] Free Game per Month. [_2] will get deducted from your account.', array(
				$neededPackageRel->Quantity,
				MainHelper::creditsOutput($neededPackage->Price)
			));
		}
	} else if($neededPackageRel->SpecialType === GROUP) {
		echo $this->__('This will allow you to create additional [_1] group(s). [_2] will get deducted from your account.', array(
			$neededPackageRel->Quantity,
			MainHelper::creditsOutput($neededPackage->Price)
		));
	} else if($neededPackageRel->SpecialType === IMAGE) {
		echo $this->__('This will increase your image limit by [_1]. [_2] will be deducted from your account.', array(
			$neededPackageRel->Quantity,
			MainHelper::creditsOutput($neededPackage->Price)
		));
	} else {
		$packConfig = Doo::conf()->package;
		
		if($isCurrentPackage === TRUE) {
			echo $this->__('You have already activated this feature. It will renew on [_1]. If you wish to extend it now, [_2] will get deducted from your account.', array(
				date(DATE_SHORT, $currentPackageRel->ExpirationTime),
				MainHelper::creditsOutput($neededPackage->Price)
			));
		} else {
			if($neededPackage->ID_PACKAGE == $packConfig['no_ads_or_banners']) {
				echo $this->__('This will remove all ads and banners on the site. [_1] will be deducted from your account.', array(
					MainHelper::creditsOutput($neededPackage->Price)
				));
			}
		}
	}
}
?>
</p>
<div class="clear">&nbsp;</div>
<div class="clearfix mt20">
<?php if(!$hideButtons):?>
		<div class="fl mr10"><a data-opt='{"id":"<?php echo $neededPackage->ID_PACKAGE;?>"}' href="javascript:void(0)" class="button button_medium green F_packageBuy"><?php echo $this->__('Confirm');?></a></div>
		<div class="fl"><a href="javascript:void(0)" class="button button_medium grey F_closeFancybox"><?php echo $this->__('Cancel');?></a></div>
<?php else:?>
		<div class="fl"><a href="javascript:void(0)" class="button button_medium grey F_closeFancybox"><?php echo $this->__('Close');?></a></div>
<?php endif;?>
</div>