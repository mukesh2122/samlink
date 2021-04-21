<!-- News list start -->
<div class="list_container">
	<div class="list_header">
		<h1><?php echo $headerName; ?></h1>
	</div>
	<?php if(isset($reviewsList) and !empty($reviewsList)): ?>
		<div class="item_list">
            <?php foreach($reviewsList as $key=>$item) {
                echo $this->renderBlock('reviews/reviewItemLine', array('item' => $item));
            }; ?>
		</div>
		<?php echo $this->renderBlock('common/pagination', array('pager'=>$pager));
	endif; ?>
</div>
<!-- News list end -->