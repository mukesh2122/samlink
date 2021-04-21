<h3><?php echo 'Info tabs'; ?></h3>
<ul class="vertical_tabs">
	<?php if(isset($infoTabs) and !empty($infoTabs)):?>
		<?php foreach($infoTabs as $info):?>
			<li>
				<a href="<?php echo MainHelper::site_url('admin/shop/product/'.$product->ID_PRODUCT.'/info/'.urlencode($info->ID_PRODUCTINFO));?>"><?php echo $info->Headline;?></a>
			</li>
		<?php endforeach;?>
	<?php endif;?>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/shop/product/'.$product->ID_PRODUCT.'/new/info');?>"><?php echo 'New Info tab';?></a>
	</li>
</ul>
<h3><?php echo 'Images'; ?></h3>
<ul class="vertical_tabs">
	<?php if(isset($imageList) and !empty($imageList)):?>
		<?php foreach($imageList as $image):?>
			<li>
				<a href="<?php echo MainHelper::site_url('admin/shop/product/'.$product->ID_PRODUCT.'/image/'.urlencode($image->ID_PRODUCTINFO));?>"><?php echo $image->ID_PRODUCTINFO;?></a>
			</li>
		<?php endforeach;?>
	<?php endif;?>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/shop/product/'.$product->ID_PRODUCT.'/new/image');?>"><?php echo 'New Image';?></a>
	</li>
</ul>