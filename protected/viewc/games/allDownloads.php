<?php
include('common/top.php');
if(!empty($downloads)):
    $searchDLtxt = $this->__('Search Downloads...'); ?>
	<div class="gradient_header clearfix">
		<span class="header_name header_name_green"><?php echo $this->__('All Downloads'); ?></span>
		<?php if($pagerObj->totalItem > 0): ?>
			<span class="header_total header_total1"><?php echo $this->__('Total').': [_1]', array($pagerObj->totalItem); ?></span>
		<?php endif; ?>
	</div>
	<div class="inside_search_cont mt5">
		<div class="inside_search_left">
			<div class="inside_search_right clearfix">
				<input type="text" name="search" onfocus="if(this.value === '<?php echo $searchDLtxt; ?>') { this.value = ''; };" onblur="if(this.value === '') { this.value = '<?php echo $searchDLtxt; ?>'; };" value="<?php echo $searchDLtxt; ?>">
				<a href="javascript:void(0);"><span><?php echo $this->__('Search'); ?></span></a>
			</div>
		</div>
	</div>
    <?php foreach($downloads as $download) { echo $this->renderBlock('games/downloadItem', array('download' => $download)); };
endif; ?>