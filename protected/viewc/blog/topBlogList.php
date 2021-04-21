<?php if(isset($topBlog) and !empty($topBlog)):
?>

	<!-- Top blog start -->
	<div class="list_container">

		<div class="list_header">
			<h1><?php echo $head;?></h1>
		</div>

		<div class="show_content content_hidden <?php echo !User::isBlockVisible($blockType) ? '':'dn';?>">
			<a rel="<?php echo $blockType?>" href="javascript:void(0)"><?php echo $this->__('Show ').' '.$hideText;?></a>
		</div>

		<?php $total = count($topBlog); ?>

		<div class="item_list content_shown <?php echo User::isBlockVisible($blockType) ? '':'dn';?>">
			<?php foreach ($topBlog as $key=>$item){
				$style = '';
				if(!$key) {
					$style = 'first';
				} else if($key + 1 == $total) {
					$style = 'last';
				}
				echo $this->renderBlock('blog/blogItemLine', array('item' => $item, 'stars' => (5-$key)));
			}?>
		
			<div class="hide_content border">
				<a class="" rel="<?php echo $blockType?>" href="javascript:void(0)"><?php echo $this->__('Hide ').' '.$hideText;?></a>
			</div>
		</div>
	</div>
	<!-- Top news end -->
<?php endif; ?>
