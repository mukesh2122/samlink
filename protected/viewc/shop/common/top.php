<?php $isEnabledShop = MainHelper::IsModuleEnabledByTag('shop'); ?>
<?php $isEnabledMemberships = MainHelper::IsModuleEnabledByTag('memberships'); ?>
<?php if (MainHelper::IsModuleNotAvailableByTag('shop')==1) $isEnabledShop = 0; ?>

<?php echo $this->renderBlock('common/header_ads', array());?>

<?php if(isset($infoBox)):?>
    <?php echo $infoBox;?>
<?php endif; ?>

<?php
	$tabsUrl = 'shop/';
	if(!isset($type))
		$type = '';
?>

<ul class="horizontal_tabs clearfix">
	<?php if ($isEnabledShop==1): ?>
	<li class="<?php echo $type == SHOP_ALL ? 'active':'';?>">
		<a class="icon_link" href="<?php echo MainHelper::site_url($tabsUrl);?>"><i class="games_tab_icon"></i><?php echo $this->__('Products');?></a>
	</li>
	<?php endif; ?>
	<?php if ($isEnabledMemberships==1): ?>
	<li class="<?php echo $type == SHOP_MEMBERSHIP ? 'active':'';?>">
		<a class="icon_link" href="<?php echo MainHelper::site_url($tabsUrl.SHOP_MEMBERSHIP);?>"><i class="games_tab_icon"></i><?php echo $this->__('Memberships');?></a>
	</li>
	<?php endif; ?>
	<li class="<?php echo $type == SHOP_BUYCREDITS ? 'active':'';?>">
		<a class="icon_link" href="<?php echo MainHelper::site_url('shop/buy-credits');?>"><i class="games_tab_icon"></i><?php echo $this->__('Credits');?></a>
	</li>
	<?php if ($isEnabledShop==1): ?>
	<li class="<?php echo $type == SHOP_HISTORY ? 'active':'';?>">
		<a class="icon_link" href="<?php echo MainHelper::site_url('shop/history');?>"><i class="games_tab_icon"></i><?php echo $this->__('Order History');?></a>
	</li>
	<?php endif; ?>
</ul>