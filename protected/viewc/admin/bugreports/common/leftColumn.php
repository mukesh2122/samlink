<h3><?php echo 'Support System'; ?></h3>
<ul class="vertical_tabs">
	<?php if (isset($types)): ?>
		<?php foreach ($types as $keyType => $valueType): ?>
			<li>
				<a href="<?php echo MainHelper::site_url('admin/bugreports/'.($keyType == '' ? 'None' : $keyType));?>"<?php echo ((isset($typeFilter) && $typeFilter == $keyType) || ($typeFilter == 'None' && $keyType == '')) ? 'class="selected"' : '';?>><?php echo $valueType;?></a>
				<?php if (isset($categories) && isset($typeFilter) && $typeFilter == $keyType && $typeFilter != 'All' && array_key_exists($typeFilter, $categories)) { ?>
					<ul class="vertical_tabs_indent">
						<?php foreach ($categories[$typeFilter] as $keyCat => $valueCat): ?>
							<li>
								<a href="<?php echo MainHelper::site_url('admin/bugreports/'.$keyType.'/'.($keyCat == '' ? 'None' : $keyCat));?>"<?php echo ((isset($categoryFilter) && $categoryFilter == $keyCat) || ($categoryFilter == 'None' && $keyCat == '')) ? 'class="selected"' : '';?>><?php echo $valueCat;?></a>
							</li>
							<?php if (isset($subcategories) && isset($categoryFilter) && $categoryFilter == $keyCat && array_key_exists($categoryFilter, $subcategories)): ?>
                                <ul class="vertical_tabs_indent">
                                    <?php foreach ($subcategories[$categoryFilter] as $keySubCat => $valueSubCat): ?>
                                        <li>
                                            <a href="<?php echo MainHelper::site_url('admin/bugreports/'.$keyType.'/'.$keyCat.'/'.($keySubCat == '' ? 'None' : $keySubCat));?>"<?php echo ((isset($subcategoryFilter) && $subcategoryFilter == $keySubCat) || ($subcategoryFilter == 'None' && $keySubCat == '')) ? 'class="selected"' : '';?>><?php echo $valueSubCat;?></a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
						<?php endforeach; ?>
					</ul>
				<?php } ?>
			</li>
		<?php endforeach; ?>
	<?php endif; ?>
	<li>
		<a href="<?php echo MainHelper::site_url('admin/bugreports/new');?>"<?php echo ((isset($typeFilter) && $typeFilter == "new")) ? 'class="selected"' : '';?>><?php echo 'Create new ticket';?></a>
	</li>
</ul>