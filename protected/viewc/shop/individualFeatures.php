<?php include('common/top.php'); ?>

<!-- Membership individual features start -->
<?php if(isset($individualUpgrades) and count($individualUpgrades) > 0):?>
	<table class="ind_feat shop_items">
		<tr class="subtle_grey">
			<th colspan="2">
				<?php echo $this->__('Individual Features'); ?>
			</th>
		</tr>

		<?php foreach($individualUpgrades as $key=>$upgrade):?>
		<?php
			$class = $key % 2 == 0 ? '' : ' even_rows_bg';
			$item = current($upgrade->FiFeatures);
		?>
		<tr class="shop_item<?php echo $class;?>">
			<td class="clearfix">
				<span><?php echo $upgrade->NameTranslated;?></span>
			</td>
			<td>
				<a class="button button_medium light_blue" rel="iframe" href="<?php echo MainHelper::site_url('shop/buy-membership-feature/'.$upgrade->ID_PACKAGE);?>">
				<?php if($upgrade->Duration === '0'):?>
					<?php echo $this->__('[_1]', array(MainHelper::creditsOutput($upgrade->Price)));?>
				<?php else:?>
					<?php echo $this->__('[_1]/[_2] months', array(
																MainHelper::creditsOutput($upgrade->Price),
																$upgrade->Duration
																));
					?>
				<?php endif;?>
				</a>
			</td>
		</tr>
		<?php endforeach;?>
	</table>
<?php endif;?>
<!-- Membership individual features start -->