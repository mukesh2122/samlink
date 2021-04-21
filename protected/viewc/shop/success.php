<?php include('common/top.php'); ?>
<?php $text = array(); ?>
<div class="grey_box rounded_5">
	<div class="box_header">
		<h3><?php echo $this->__('Success!') ?></h3>
	</div>

	<?php
	if ($orderType == PRODUCT) {
		$text[] = $this->__('[_1] has been deducted from your account and your order has been completed. You will receive an e-mail with your receipt.[_2] If you have purchased any downloadable items, you can find your [_3]download link(s)[_4] in your order history.', array(
			MainHelper::creditsOutput($order->TotalPrice), '<br /><br />', '<a href="'.MainHelper::site_url('shop/history/'.$order->ID_ORDER).'">', '</a>'
		));
	} else if ($orderType == PACKAGE) {
		if ($package->PackageType != "") {
			if (!$playerPackageRel) {
				$text[] = $this->__('[_1] has been deducted from your account and your order has been completed. You will receive an e-mail with your receipt.', array(
					MainHelper::creditsOutput($order->TotalPrice)
				));
				$text[] = $this->__('You are now a [_1] member. Your membership will automatically renew every [_2] months unless you cancel or don`t have enough Credits on your account. The first renewal date is [_3].', array(
					$package->PackageType,
					$package->Duration,
					date(DATE_SHORT, mktime(1, 1, 1, (date("m", time()) + $package->Duration), date("d", time()), date("Y", time()))),
				));
				$text[] = $this->__('You can always check the status of your membership, upgrade, downgrade and cancel in your user settings.');
				$text[] = $this->__('Thank you for your order. We hope you enjoy your new membership.');
			} else {
				$upgrade = Membership::getUpgradesByType();
				if ($playerPackageRel->PackageType === $package->PackageType) {
					if ($currentPackage->Duration === $package->Duration) {
						$text[] = $this->__('[_1] has been deducted from your account and your order has been completed. You will receive an e-mail with your receipt.', array(
							MainHelper::creditsOutput($order->TotalPrice)
						));
						$text[] = $this->__('You will receive an e-mail with your receipt. You have succesfully extended your [_1] membership. The next renewal date is [_2].', array(
							$package->PackageType,
							date(DATE_SHORT, mktime(1, 1, 1, (date("m", $playerPackageRel->ExpirationTime) + $package->Duration), date("d", $playerPackageRel->ExpirationTime), date("Y", $playerPackageRel->ExpirationTime))),
						));
						$text[] = $this->__('Thank you for your order.');
					} else {
						$text[] = $this->__('You have scheduled a change to a [_1] ([_2] months) membership. It will happen when your membership renews on [_3]. [_4] will be deducted from your account when your order completes and you will receive an e-mail with your receipt.', array(
							$package->PackageType,
							$package->Duration,
							date(DATE_SHORT, mktime(1, 1, 1, (date("m", $playerPackageRel->ExpirationTime)), date("d", $playerPackageRel->ExpirationTime), date("Y", $playerPackageRel->ExpirationTime))),
							MainHelper::creditsOutput($package->Price)
						));
						$text[] = $this->__('Thank you for your order.');
					}
				} else if (in_array($package->PackageType, $upgrade[$playerPackageRel->PackageType])) {
					//upgrade
					$text[] = $this->__('[_1] has been deducted from your account and your order has been completed. You will receive an e-mail with your receipt.', array(
						MainHelper::creditsOutput($order->TotalPrice)
					));
					$text[] = $this->__('You are now a [_1] member. Your membership will automatically renew every [_2] months unless you cancel or don`t have enough Credits on your account. The first renewal date is [_3].', array(
						$package->PackageType,
						$package->Duration,
						date(DATE_SHORT, mktime(1, 1, 1, (date("m", time()) + $package->Duration), date("d", time()), date("Y", time()))),
					));
					$text[] = $this->__('You can always check the status of your membership, upgrade, downgrade and cancel in your user settings.');
					$text[] = $this->__('Thank you for your order. We hope you enjoy your new membership.');
				} else {
					//downgrade
					$text[] = $this->__('You have scheduled a downgrade to a [_1] membership. It will happen when your membership renews on [_2]. [_3] will be deducted from your account when your order completes and you will receive an e-mail with your receipt.', array(
						$package->PackageType,
						date(DATE_SHORT, mktime(1, 1, 1, (date("m", $playerPackageRel->ExpirationTime)), date("d", $playerPackageRel->ExpirationTime), date("Y", $playerPackageRel->ExpirationTime))),
						MainHelper::creditsOutput($package->Price)
					));
					$text[] = $this->__('Thank you for your order.');
				}
			}
		} else {
			//feature
			$packConfig = Doo::conf()->package;
			if(isset($package->FiPackageFeatureRel)) {
				$relation = current($package->FiPackageFeatureRel);
				$player = User::getUser();
				if ($relation->SpecialType == IMAGE) {
					$text[] = $this->__('[_1] has been deducted from your account and your order has been completed. You will receive an e-mail with your receipt.', array(
						MainHelper::creditsOutput($order->TotalPrice)
					));
					$text[] = $this->__('You have now increased your photo limit with [_1]. Your new limit is [_2].', array(
						$relation->Quantity,
						$player->ImageLimit
					));
					$text[] = $this->__('Thank you for your order.');
				} else if ($relation->SpecialType == GROUP) {
					$text[] = $this->__('[_1] has been deducted from your account and your order has been completed. You will receive an e-mail with your receipt.', array(
						MainHelper::creditsOutput($order->TotalPrice)
					));
					$text[] = $this->__('You have now increased your group limit with [_1]. Your new limit is [_2].', array(
						$relation->Quantity,
						$player->GroupLimit
					));
					$text[] = $this->__('Thank you for your order.');
				} else if ($package->ID_PACKAGE == $packConfig['no_ads_or_banners']) {
					$text[] = $this->__('[_1] has been deducted from your account and your order has been completed. You will receive an e-mail with your receipt.', array(
						MainHelper::creditsOutput($order->TotalPrice)
					));
					$text[] = $this->__('You have now activated No Ads or Banners. The feature will automatically renew every [_1] months unless you cancel or don`t have enough Credits on your account. The first renewal date is [_2].', array(
						$package->Duration,
						date(DATE_SHORT, mktime(1, 1, 1, (date("m", time()) + $package->Duration), date("d", time()), date("Y", time()))),
					));
					$text[] = $this->__('Thank you for your order.');
				}
			}
		}
	}
	?>

	<p><?php echo implode('</p><p>', $text); ?></p> 
	<p>&nbsp;</p>
	<p><?php echo $this->__('Best Regards,'); ?></p>
	<p><?php echo $this->__('Customer Services'); ?></p>
	<p><?php echo $this->__('PlayNation.eu'); ?></p>
</div>





