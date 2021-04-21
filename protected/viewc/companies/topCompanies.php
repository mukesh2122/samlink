<div class="gradient_header clearfix">
	<span class="header_name header_name_green"><?php echo $headerName; ?></span>
	<span class="fr show_top_news <?php echo !User::isBlockVisible(COMPANY_TOP) ? '':'dn'; ?> "><a rel="<?php echo COMPANY_TOP?>" class="fft fs11" href="javascript:void(0)"><span>&nbsp;</span><?php echo $this->__('Show Top Companies'); ?></a></span>
</div>
<?php if(isset($companyList) and !empty($companyList)): ?>
    <div class="mt10 clearfix top_news top_companies_list top_companies" <?php echo User::isBlockVisible(COMPANY_TOP) ? '':'style="display: none;"'; ?>>
        <?php foreach ($companyList as $key=>$item): ?>
			<?php echo $this->renderBlock('companies/companyItem', array('item' => $item, 'topStars' => $item->CurrentTop, 'odd' => (($key-1) % 2 == 0)));?>
        <?php endforeach; ?>
		
		<div class="hide_top_news">
			<a class="fft fs11" rel="<?php echo COMPANY_TOP; ?>" href="javascript:void(0)"><span>&nbsp;</span><?php echo $this->__('Hide Top Companies'); ?></a>
		</div>
		
    </div>
<?php else: ?>
<div class="noItemsText"><?php echo $this->__('There are no companies here. Yet!'); ?></div>
<?php endif; ?>
