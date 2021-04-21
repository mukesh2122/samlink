<?php 
	include('common/top.php'); 
	$url = MainHelper::site_url('referral/c/'.$referrer->VoucherCode);
?>

<div class="standard_form_header">
	<h1><?php echo $this->__('Codes and Banners') ?></h1>
</div>

<div class="">
	URL: <?php echo $url;?>
</div>

<div class="">
	<img src="<?php echo MainHelper::site_url('global/img/banners/160x600-1.jpg');?>" alt=""/>
	<div>
		<?php echo $this->__('Banner');?>: 160 x 600px
		<?php echo $this->__('Code');?>: <?php echo htmlspecialchars('<a href="'.$url.'"><img src="'.MainHelper::site_url('global/img/banners/160x600-1.jpg').'" alt="PlayNation"/></a>');?>
	</div>
</div>
<div class="">
	<img src="<?php echo MainHelper::site_url('global/img/banners/160x600-2.jpg');?>" alt=""/>
	<div>
		<?php echo $this->__('Banner');?>: 160 x 600px
		<?php echo $this->__('Code');?>: <?php echo htmlspecialchars('<a href="'.$url.'"><img src="'.MainHelper::site_url('global/img/banners/160x600-2.jpg').'" alt="PlayNation"/></a>');?>
	</div>
</div>
<div class="">
	<img src="<?php echo MainHelper::site_url('global/img/banners/300x250-1.jpg');?>" alt=""/>
	<div>
		<?php echo $this->__('Banner');?>: 300 x 250px
		<?php echo $this->__('Code');?>: <?php echo htmlspecialchars('<a href="'.$url.'"><img src="'.MainHelper::site_url('global/img/banners/300x250-1.jpg').'" alt="PlayNation"/></a>');?>
	</div>
</div>
<div class="">
	<img src="<?php echo MainHelper::site_url('global/img/banners/300x250-2.jpg');?>" alt=""/>
	<div>
		<?php echo $this->__('Banner');?>: 300 x 250px
		<?php echo $this->__('Code');?>: <?php echo htmlspecialchars('<a href="'.$url.'"><img src="'.MainHelper::site_url('global/img/banners/300x250-2.jpg').'" alt="PlayNation"/></a>');?>
	</div>
</div>
<div class="">
	<img src="<?php echo MainHelper::site_url('global/img/banners/468x60-1.jpg');?>" alt=""/>
	<div>
		<?php echo $this->__('Banner');?>: 468 x 60px
		<?php echo $this->__('Code');?>: <?php echo htmlspecialchars('<a href="'.$url.'"><img src="'.MainHelper::site_url('global/img/banners/468x60-1.jpg').'" alt="PlayNation"/></a>');?>
	</div>
</div>
<div class="">
	<img src="<?php echo MainHelper::site_url('global/img/banners/468x60-2.jpg');?>" alt=""/>
	<div>
		<?php echo $this->__('Banner');?>: 468 x 60px
		<?php echo $this->__('Code');?>: <?php echo htmlspecialchars('<a href="'.$url.'"><img src="'.MainHelper::site_url('global/img/banners/468x60-2.jpg').'" alt="PlayNation"/></a>');?>
	</div>
</div>