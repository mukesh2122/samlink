<!-- Event search start -->
<?php if(isset($url)):?>
	<form method="GET" id="inside_search" class="c_column_search clearfix">
		<input type="hidden" id="form_url" value="<?php echo $url;?>" />
		<input type="text" id="inside_search_txt" class="c_column_search_input withLabel"
				title="<?php echo $label ?>" 
				value="<?php echo (isset($searchText) and $searchText != '') ? htmlspecialchars($searchText) : $label; ?>" />
		<input type="submit" value="<?php echo $this->__('Search'); ?>" class="c_column_search_button mint" />
	</form>

	<?php if(isset($searchText) and $searchText != ''):?>
		<div class="list_header">
			<h1><?php echo $this->__('Your search matched [_1]', array($searchTotal)).' '.$type; ?></h1>
			<div class="list_header_meta"><?php echo $this->__('You searched for:'); ?> <span><?php echo htmlspecialchars($searchText); ?></span></div>
		</div>
	<?php endif;?>
<?php endif;?>

<!-- Event search end -->





<?php /*
<div class="mt5">
	<div class="searchGroupTop"></div>
	<div class="searchGrouptMid">
		<div class="searchGroupInputTop"></div>
		<div class="searchGroupInputMid">
			<form method="GET" id="<?php echo $searchId; ?>" class="common_new_search_form fl">
				<input type="text" id="searchText" class="w300 pl5 bareInput withLabel pt2"
						title="<?php echo $this->__('Search...'); ?>" 
						rel="<?php echo isset($rel) ? $rel : ''; ?>" 
						class="fl withLabel bareInput"
						value="<?php echo (isset($search) and $search != '') ? $search : $this->__('Search...'); ?>" />
			</form>

			<a id="" class="buttonRRound eventsSearchRound fr mr4 common_new_search" 
				href="javascript:void(0)">
				<span class="lrc"></span>
				<span class="mrc">
					<span class="fl fs11"><strong><?php echo $this->__('Search'); ?></strong></span>
					<span class="iconr_search fl mt3 ml2"></span>
				</span>
				<span class="rrc"></span>
			</a>
		</div>
		<div class="searchGroupInputBottom"></div>
		
	</div>
	<div class="searchGroupBottom"></div>
</div>

<?php if(isset($search) and $search != ''):?>
	<div class="fs16 fft mt5"><?php echo $this->__('Search Results');?>:</div>
	<div class="fs2 fft"><?php echo $this->__('Searched for: '). $search .'. '.$this->__('Found').': '.$total;?></div>
<?php endif;?>
 * */ ?>