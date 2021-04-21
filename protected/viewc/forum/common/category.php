<?php $isCollapsed = $category->isCollapsed; ?>
<div class="clearfix itemPost pr">
	<div class="forumCategoryBar">
		<div class="forumCategoryNameLeft">
			<div class="forumCategoryName">
				<?php echo $category->CategoryName; ?>
			</div>
		</div>
		<div class="forumCategoryRight">
			<div style="padding: 8px; font-size: 12px; color: white; text-align: right; vertical-align: middle; ">
				<?php echo $this->__('Total'); ?>: <?php echo $isCollapsed ? $category->getBoardCount() : count($category->boards); ?>
				<?php if($isCollapsed): ?>
					<a href="javascript:void(0);" title="Click to expand." style="font-size:14px;font-weight: 800;" class="expandCategory" rel="<?php echo $category->ID_CAT; ?>"><strong>+</strong></a>
				<?php else:	?>
					<a href="javascript:void(0);" title="Click to collapse." style="font-size:14px;font-weight: 800;" class="collapseCategory" rel="<?php echo $category->ID_CAT; ?>"><strong>-</strong></a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>