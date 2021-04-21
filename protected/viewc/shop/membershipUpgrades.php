<?php include('common/top.php'); ?>

<!-- Membership upgrades start -->
<table class="membership_upgrades shop_items">
	<tr class="subtle_grey">
		<th>
			<?php echo $this->__('Memberships'); ?>
		</th>
		<th>
			<?php echo $this->__('Basic'); ?>
		</th>
		<th class="premium_memb">
			<?php echo $this->__('Silver'); ?>
		</th>
		<th class="premium_memb">
			<?php echo $this->__('Gold'); ?>
		</th>
		<th class="premium_memb">
			<?php echo $this->__('Platinum'); ?>
		</th>
	</tr>
	<tr>
		<th></th>
		<th></th>
		<th colspan="3"><?php echo $this->__('Premium memberships'); ?></th>
	</tr>
	<?php foreach($featuresTable as $key=>$feature):?>
	<?php $class = $key % 2 == 0 ? '' : ' even_rows_bg';?>
	<tr class="shop_item<?php echo $class;?>">
		<td>
			<?php echo $feature->NameTranslated; ?>
		</td>
		<td class="shop_item_meta">
			<?php
				if($feature->SpecialType == '') {
					echo isset($feature->FiPackages[PACKAGE_BASIC]) ? '<span class="iconr_check"></span>' : '';
				} else {
					echo isset($feature->FiPackages[PACKAGE_BASIC]) ? $feature->getQuantity($feature->FiPackages[PACKAGE_BASIC]) : '';
				}
			?>
		</td>
		<td class="shop_item_meta">
			<?php
				if($feature->SpecialType == '') {
					echo isset($feature->FiPackages[PACKAGE_SILVER]) ? '<span class="iconr_check"></span>' : '';
				} else {
					echo isset($feature->FiPackages[PACKAGE_SILVER]) ? $feature->getQuantity($feature->FiPackages[PACKAGE_SILVER]) : '';
				}
			?>
		</td>
		<td class="shop_item_meta">
			<?php
				if($feature->SpecialType == '') {
					echo isset($feature->FiPackages[PACKAGE_GOLD]) ? '<span class="iconr_check"></span>' : '';
				} else {
					echo isset($feature->FiPackages[PACKAGE_GOLD]) ? $feature->getQuantity($feature->FiPackages[PACKAGE_GOLD]) : '';
				}
			?>
		</td>
		<td class="shop_item_meta">
			<?php
				if($feature->SpecialType == '') {
					echo isset($feature->FiPackages[PACKAGE_PLATINUM]) ? '<span class="iconr_check"></span>' : '';
				} else {
					echo isset($feature->FiPackages[PACKAGE_PLATINUM]) ? $feature->getQuantity($feature->FiPackages[PACKAGE_PLATINUM]) : '';
				}
			?>
		</td>
	</tr>
	<?php endforeach;?>

	<?php $i = 0; $total = count($membershipPrices);?>
	<?php foreach($membershipPrices as $duration=>$membership):?>
		<?php
			$class = '';
			if(!$i) {
				$class = ' first_child';
			} else if($i + 1 == $total) {
				$class = ' last_child';
			}
			$i++;
		?>
		<tr class="upgrade_options<?php echo $class;?>">
			<td>
				<?php echo $duration . ' '. $this->__('Months');?>
				<?php if($membership[PACKAGE_SILVER]->Save > 0) {
					echo ' - ' . $this->__('Save [_1]%', array($membership[PACKAGE_SILVER]->Save));
				}?>
			</td>
			<td>
				<?php echo $this->__('Free');?>
			</td>
			<td>
				<a class="button button_fluid grey" rel="iframe" href="<?php echo MainHelper::site_url('shop/buy-membership-pack/'.$membership[PACKAGE_SILVER]->ID);?>"><?php echo MainHelper::creditsOutput($membership[PACKAGE_SILVER]->Price);?></a>
			</td>
			<td>
				<a class="button button_fluid light_orange" rel="iframe" href="<?php echo MainHelper::site_url('shop/buy-membership-pack/'.$membership[PACKAGE_GOLD]->ID);?>"><?php echo MainHelper::creditsOutput($membership[PACKAGE_GOLD]->Price);?></a>
			</td>
			<td>
				<a class="button button_fluid light_green" rel="iframe" href="<?php echo MainHelper::site_url('shop/buy-membership-pack/'.$membership[PACKAGE_PLATINUM]->ID);?>"><?php echo MainHelper::creditsOutput($membership[PACKAGE_PLATINUM]->Price);?></a>
			</td>
		</tr>
	<?php endforeach;?>
</table>
<!-- Membership upgrades end -->
