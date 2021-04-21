<h2><?php echo 'Shop'; ?></h2>
<h2><?php echo '-------'; ?></h2>
<h3><?php echo 'Products'; ?></h3>
<ul class="vertical_tabs">
	<li>
		<a href="<?php echo MainHelper::site_url('admin/shop');?>"><?php echo 'All Products';?></a>
	</li>
	<?php if(isset($genreList) and !empty($genreList)):?>
		<?php foreach($genreList as $genre):?>
			<li>
				<a href="<?php echo MainHelper::site_url('admin/shop/'.urlencode($genre->ProductTypeName));?>"><?php echo $genre->ProductTypeName;?></a>
			</li>
		<?php endforeach;?>
	<?php endif;?>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/shop/product/new');?>"><?php echo 'New Product';?></a>
	</li>
</ul>
<h3><?php echo 'Packages (Memberships)'; ?></h3>
<ul class="vertical_tabs">
	<li>
		<a href="<?php echo MainHelper::site_url('admin/shop/memberships');?>"><?php echo 'All Packages';?></a>
	</li>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/shop/memberships/new');?>"><?php echo 'New Package';?></a>
	</li>
</ul>
<h3><?php echo 'Membership features'; ?></h3>
<ul class="vertical_tabs">
	<li>
		<a href="<?php echo MainHelper::site_url('admin/shop/features');?>"><?php echo 'All Features';?></a>
	</li>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/shop/features/new');?>"><?php echo 'New Feature';?></a>
	</li>
</ul>
<h3><?php echo 'Credit packs'; ?></h3>
<!-- Exchange rates -->
<ul class="vertical_tabs">
	<li>
		<a href="<?php echo MainHelper::site_url('admin/shop/rates');?>"><?php echo 'All Credit packs';?></a>
	</li>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/shop/rates/new');?>"><?php echo 'New Credit pack';?></a>
	</li>
</ul>
<h3><?php echo 'Product types'; ?></h3>
<ul class="vertical_tabs">
	<li>
		<a href="<?php echo MainHelper::site_url('admin/shop/types');?>"><?php echo 'All Product types';?></a>
	</li>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/shop/types/new');?>"><?php echo 'New Product type';?></a>
	</li>
</ul>
