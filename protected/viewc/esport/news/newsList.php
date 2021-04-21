<!-- News list start -->
<div class="list_container">
	<div class="list_header esport_newsheader">
		<h1><?php echo $headerName;?></h1>
	</div>

	<?php if(isset($newsList) and !empty($newsList)):?>

		<div class="item_list">
		<?php foreach ($newsList as $key=>$item):?>
			<?php echo $this->renderBlock('esport/news/newsItemLine', array('item' => $item));?>
		<?php endforeach; ?>
		</div>

		<?php echo $this->renderBlock('esport/common/pagination', array('pager'=>$pager)) ?>

	<?php endif; ?>
</div>
<!-- News list end -->