<!-- Group list start -->
<div class="list_container">
	<?php
	if(isset($url)) {
		echo $this->renderBlock('groups/common/search', array(
			'url' => $url,
			'searchText' => $searchText,
			'searchTotal' => $searchTotal,
			'label' => $label = $this->__('Search for groups...'),
			'type' => $type = $this->__('groups')
		));
	}
	?>
	
	<?php if(!isset($searchText) && Auth::isUserLogged()): ?>
	<div class="list_header">
		<h1><?php echo $headerName; ?></h1>
		<a rel="iframe" href="<?php echo MainHelper::site_url('groups/creategroup');?>" class="list_header_button"><?php echo $this->__('Create New Group +');?></a>
	</div>
	<?php endif; ?>
			
	<?php 
	if(isset($groupList) and !empty($groupList)) {

		echo '<div class="item_list">';
			foreach ($groupList as $key=>$item) {
				echo $this->renderBlock('common/group', array('item' => $item));
			}
		echo '</div>';

		if(isset($pager)) {
			echo $this->renderBlock('common/pagination', array('pager'=>$pager));
		}
	}
	?>
</div>
<!-- Group list end -->
