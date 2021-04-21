<div class="forumPagination">
	<ul class="clearfix">
		<?php
			for($i = 1; $i <= $pager->totalPage; $i++) { ?>
				<li><a href="<?php echo $pager->baseUrl . '/' . $i; ?>" class="<?php if (isset($withHighlight) AND $pager->currentPage == $i) echo 'current'; ?>" title="<?php echo $this->__('Go to page ' . $i); ?>"><?php echo $this->__($i); ?></a></li>
				<?php
			}
		?>
	</ul>
</div>