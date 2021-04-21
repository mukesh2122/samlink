<?php
    $player = $viewer = User::getUser();
?>
<!-- News list start -->
<div class="list_container">
	<div class="list_header">
		<h1><?php echo $headerName;?></h1>
	</div>

	<?php if(isset($bloggersList) and !empty($bloggersList)) {
            echo '<div id="wall_container" class="item_list">';
                    foreach ($bloggersList as $item) {
                            echo $this->renderBlock('blog/blogger', array('player' => (object) $item, 'owner' => $player, 'viewer' => $viewer));
                    }
            echo '</div>';
            
            echo $this->renderBlock('players/common/show_more', array(
                    'order' => isset($order) ? $order : '',
                    'total' => isset($total) ? $total : 0,
            ));

            if (isset($pager) and $pager != '' and isset($pagerObj) and $pagerObj->totalPage > 1) {
                    echo $this->renderBlock('common/pagination', array('pager' => $pager));
            }
        }
        ?>
</div>
<!-- News list end -->
