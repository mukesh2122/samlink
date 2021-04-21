<p class="popup_width_mdl_content">
<?php
$hideButtons = false;
$packName = $this->__($neededPackage->PackageType);
$upgrade = Membership::getUpgradesByType();
$player = User::getUser();

if($player->Credits < $neededPackage->Price) {
	echo $this->__('You do not have enough Credits on your account. Please buy Credits now.');
	$hideButtons = true;
} else {
	if (!$currentPackage) {
		echo $this->__('This will upgrade your Basic membership to a [_1] membership. [_2] will be deducted from your account.', array(
			$packName,
			MainHelper::creditsOutput($neededPackage->Price)
		));
	} else {
		$currentPackName = $this->__($currentPackage->PackageType);
		if($currentPackage->PackageType === $neededPackage->PackageType) {
			if($currentPackage->Duration === $neededPackage->Duration) {
				echo $this->__('This will extend your membership. [_1] will be deducted from your account.', array(
					MainHelper::creditsOutput($neededPackage->Price),
				));
			} else {
				echo $this->__('This will change your [_1] ([_2] months) membership to a [_3] ([_4] months) membership. The change will happen when your membership renews on [_5].', array(
					$currentPackName,
					$currentPackage->Duration,
					$packName,
					$neededPackage->Duration,
					date(DATE_SHORT, $currentPackageRel->ExpirationTime)
				));
			}
		} else if (in_array($neededPackage->PackageType, $upgrade[$currentPackage->PackageType])) {
			$expire = new DateTime(date('Y-m-d', $currentPackageRel->ExpirationTime));
			$now = new DateTime("now");
			$interval = $now->diff($expire);

			if($interval->m > $neededPackage->Duration) {
				echo $this->__('Memberships are non-refundable. You have [_1] month(s) and [_2] day(s) left of your membership and cannot upgrade to a [_3] ([_4] months) membership. You must choose another upgrade.', array(
					$interval->m,
					$interval->d,
					$packName,
					$neededPackage->Duration,
				));
				$hideButtons = true;
			} else {
				echo $this->__('This will upgrade your [_1] ([_2] months) membership to a [_3] ([_4] months) membership. You have [_5] days left of your [_6] membership and this will reduce the price of your upgrade with [_7]. [_8] will be deducted from your account.', array(
					$currentPackName,
					$currentPackage->Duration,
					$packName,
					$neededPackage->Duration,
					(int)(($currentPackageRel->ExpirationTime - time()) / (60 * 60 * 24)),
					$currentPackName,
					MainHelper::creditsOutput($neededPackagePrice->Discount),
					MainHelper::creditsOutput($neededPackagePrice->Price),
				));
			}

		} else {

			if($currentQueue !== FALSE and $currentQueue->ID_PACKAGE === $neededPackage->ID_PACKAGE) {
				echo $this->__('You already have a downgrade to a [_1] ([_2] months) membership pending. It will happen automatically when your membership renews on [_3].', array(
					$packName,
					$neededPackage->Duration,
					date(DATE_SHORT, $currentPackageRel->ExpirationTime)
				));
				$hideButtons = true;
			} else if($currentQueue !== FALSE and $currentQueue->PackageType === $neededPackage->PackageType) {
				echo $this->__('You already have a downgrade to a [_1] ([_2] months) membership pending. If you continue, you will replace that downgrade with a downgrade to a [_3] ([_4] months) membership. It will happen automatically when your membership renews on [_5].', array(
					$packName,
					$currentQueue->Duration,
					$packName,
					$neededPackage->Duration,
					date(DATE_SHORT, $currentPackageRel->ExpirationTime)
				));
			} else {
				echo $this->__('This will downgrade your [_1] ([_2] months) membership to a [_3] ([_4] months) membership. Memberships are non-refundable and your downgrade will happen when your membership renews on [_5].', array(
					$currentPackName,
					$currentPackage->Duration,
					$packName,
					$neededPackage->Duration,
					date(DATE_SHORT, $currentPackageRel->ExpirationTime)
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