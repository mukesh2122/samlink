<!-- Search results start -->
<div class="list_container no_top">

	<div class="list_header">
		<h1><?php echo $this->__('Your search matched').' '.$resultCount.' '.$this->__('items'); ?></h1>
		<div class="list_header_meta"><?php echo $this->__('You searched for:'); ?> <span><?php echo htmlspecialchars($searchText); ?></span></div>
	</div>

	<?php if (isset($list) and !empty($list)): ?>
	<div class="item_list">
		<?php foreach ($list as $item): ?>
			<?php
			$img = "";
			$type = "";
			$title = "";
			$typeResult = $item->getByType();
			switch ($item->FieldType) {
				case SEARCH_PLAYER:
					echo $this->renderBlock('common/player', array(
						'player' => $typeResult,
					));
					break;

				case SEARCH_COMPANY:
					echo $this->renderBlock('companies/companyItem', array(
						'item' => $typeResult,
					));
					break;

				case SEARCH_GAME:
					echo $this->renderBlock('common/game', array(
						'item' => $typeResult,
					));
					break;
				case SEARCH_GROUP:
					echo $this->renderBlock('common/group', array(
						'item' => $typeResult,
					));
					break;
				case SEARCH_NEWS:
					echo $this->renderBlock('news/newsItemLine', array(
						'item' => $typeResult,
					));
					break;
			}
			?>
		<?php endforeach; ?>
	</div>
	<?php echo $this->renderBlock('common/pagination', array('pager' => $pager)) ?>
	<?php endif; ?>
</div>
<!-- Search results end -->