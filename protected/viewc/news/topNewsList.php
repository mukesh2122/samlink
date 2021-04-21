<?php if(isset($topNews) && !empty($topNews)): ?>
	<!-- Top news start -->
	<div class="list_container">
		<div class="list_header">
			<h1><?php echo $head; ?></h1>
		</div>
		<div class="show_content content_hidden <?php echo !User::isBlockVisible($blockType) ? '':'dn'; ?>">
			<a rel="<?php echo $blockType; ?>" href="javascript:void(0);"><?php echo $this->__('Show'), '  ', $hideText; ?></a>
		</div>
		<?php $total = count($topNews); ?>
		<div class="item_list content_shown <?php echo User::isBlockVisible($blockType) ? '':'dn'; ?>">
			<?php foreach($topNews as $key=>$item) {
				$style = '';
				if(!$key) {
					$style = 'first';
				} else if($key + 1 == $total) {
					$style = 'last';
				};
				echo $this->renderBlock('news/newsItemLine', array('item' => $item, 'stars' => (5-$key)));
			}; ?>
			<div class="hide_content border">
				<a class="" rel="<?php echo $blockType?>" href="javascript:void(0);"><?php echo $this->__('Hide'), '  ', $hideText; ?></a>
			</div>
		</div>
	</div>
	<!-- Top news end -->
<?php endif; ?>