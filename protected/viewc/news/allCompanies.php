<?php include('common/top.php');?>

<!-- Top 5 companies start -->
<?php if(isset($companiesTop) and !empty($companiesTop)):?>
	<div class="content_hidden <?php echo !User::isBlockVisible(NEWS_COMPANIES) ? '' : 'dn'; ?>">
		<table class="table table_bordered table_striped" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th class="size_70">
						<?php echo $this->__('Top 5 Companies');?>
					</th>

					<th class="size_10 centered">
						<?php echo $this->__('News');?>
					</th>

					<th class="size_20 centered">
						<?php echo $this->__('User Rating');?>
					</th>
				</tr>
			</thead>
		</table>
		<div class="show_content">
			<a href="#" rel="<?php echo NEWS_COMPANIES; ?>"><?php echo $this->__('Show Top Companies');?></a>
		</div>
	</div>

	<div class="content_shown <?php echo User::isBlockVisible(NEWS_COMPANIES) ? '' : 'dn'; ?>">
		<table class="table table_bordered table_striped gradient_thead grey_link" cellpadding="0" cellspacing="0" border="1">
			<thead>
				<tr>
					<th class="size_70">
						<?php echo $this->__('Top 5 Companies'); ?>
					</th>

					<th class="size_10 centered">
						<?php echo $this->__('News'); ?>
					</th>

					<th class="size_20 centered">
						<?php echo $this->__('User Rating'); ?>
					</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($companiesTop as $key => $company): ?>
				<tr>
					<td class="multi_cell">
						<?php echo MainHelper::showImage($company, THUMB_LIST_40x40, false, array('no_img' => 'noimage/no_company_40x40.png')); ?>
						<a href="<?php echo $company->NEWS_URL;?>"><?php echo $company->CompanyName;?></a>
					</td>

					<td class="centered">
						<?php echo $company->NewsCount;?>
					</td>

					<td class="centered">
						<?php echo str_repeat("<i class='blue_star_icon'></i>&nbsp;", intval($company->SocialRating));?><?php echo str_repeat("<i class='grey_star_icon'></i>&nbsp;", (5 - intval($company->SocialRating)));?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<div class="hide_content">
			<a href="#" rel="<?php echo NEWS_COMPANIES;?>"><?php echo $this->__('Hide Top Companies'); ?></a>
		</div>
	</div>
<?php endif; ?>
<!-- Top 5 companies end -->

<!-- Company search start -->
<form method="GET" action="<?php echo MainHelper::site_url('news/companies/search');?>" id="inside_search" class="c_column_search clearfix mt45 mb15">
	<input type="hidden" id="form_url" value="<?php echo MainHelper::site_url('news/companies/search');?>" />
	<input type="text" id="inside_search_txt" class="c_column_search_input withLabel"
			title="<?php echo $this->__('Search for companies...'); ?>" 
			value="<?php echo (isset($searchText) and $searchText != '') ? urldecode(htmlspecialchars($searchText)) : $this->__('Search for companies...'); ?>" />
	<input type="submit" value="<?php echo $this->__('Search'); ?>" class="c_column_search_button light_blue" />
</form>

<?php if(isset($searchText) and $searchText != ''):?>
	<div class="list_header no_border">
		<h1><?php echo $this->__('Your search matched').' '.$searchTotal.' '.$this->__('companies'); ?></h1>
		<div class="list_header_meta"><?php echo $this->__('You searched for:'); ?> <span><?php echo urldecode(htmlspecialchars($searchText)); ?></span></div>
	</div>
<?php endif;?>
<!-- Company search end -->

<!-- Companies list start -->
<?php if(isset($companies) and !empty($companies)):?>
	<table class="table table_bordered table_striped gradient_thead grey_link mb15" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th class="size_70">
					<?php echo $this->__('All Companies'); ?>&nbsp;&nbsp;
					<span class="counter"><?php echo $pagerObj->totalItem; ?></span>
				</th>

				<th class="size_10 centered">
					<?php echo $this->__('News');?>
				</th>

				<th class="size_20 centered">
					<?php echo $this->__('User Rating');?>
				</th>
			</tr>
		</thead>

		<tbody>
			<?php foreach ($companies as $key => $company):?>
			<tr>
				<td class="multi_cell">
					<?php echo MainHelper::showImage($company, THUMB_LIST_40x40, false, array('no_img' => 'noimage/no_company_40x40.png')); ?>
					<a href="<?php echo $company->NEWS_URL;?>"><?php echo $company->CompanyName;?></a>
				</td>

				<td class="centered">
					<?php echo $company->NewsCount;?>
				</td>

				<td class="centered">
					<?php echo str_repeat("<i class='blue_star_icon'></i>&nbsp;", intval($company->SocialRating));?><?php echo str_repeat("<i class='grey_star_icon'></i>&nbsp;", (5 - intval($company->SocialRating)));?>
				</td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>

	<?php echo $this->renderBlock('common/pagination', array('pager'=>$pager)) ?>

<?php endif; ?>
<!-- Companies list end -->





<?php /*
<?php include('common/top.php');?>
<?php if(isset($companiesTop) and !empty($companiesTop)):?>
	<div class="gradient_header header_toggle <?php echo !User::isBlockVisible(NEWS_COMPANIES) ? '':'dn';?> clearfix mb20">
		<span class="header_name"><?php echo $this->__('Top 5 Companies');?></span>
		<span class="fr show_top_news"><a rel="<?php echo NEWS_COMPANIES?>" class="fft fs11 table" href="javascript:void(0)"><span>&nbsp;</span><?php echo $this->__('Show Top Companies');?></a></span>
	</div>

	<div class="platform_list top_companies_list tbl_slide" <?php echo User::isBlockVisible(NEWS_COMPANIES) ? '':'style="display: none;"';?>>
		<table cellpadding="0" cellspacing="0" border="1" width="100%" class="mt10 company_table">
			<tr>
				<th colspan="2"><span><?php echo $this->__('Top 5 Companies');?></span></th>
				<th class="tac pl10 pr10"><?php echo $this->__('News');?></th>
				<th class="tac pl10 pr10"><?php echo $this->__('User Rating');?></th>
			</tr>

			<?php foreach ($companiesTop as $key => $company):?>
			<tr>
				<td width="50">
					<?php echo MainHelper::showImage($company, THUMB_LIST_40x40, false, array('no_img' => 'noimage/no_company_40x40.png')); ?>
				</td>
				<td class="p0 pl10 <?php echo (($key - 1) % 2 == 0) ? 'odd' : 'even';?>" width="365">
					<div class="pr">
						<a class="db fs16" href="<?php echo $company->NEWS_URL;?>"><?php echo $company->CompanyName;?></a>
						<div class="company_top"><div class="star<?php echo $company->NewsCurrentTop;?>">&nbsp;</div></div> 
					</div>
				</td>
				<td class="pl10 pr10 tac tb <?php echo (($key - 1) % 2 == 0) ? 'odd' : 'even';?>" width="57"><?php echo $company->NewsCount;?></td>
				<td class="pl10 pr10 tac <?php echo (($key - 1) % 2 == 0) ? 'odd' : 'even';?>" width="123">
					<?php echo str_repeat("<span class='star_blue'></span>", intval($company->SocialRating));?><?php echo str_repeat("<span class='star_grey'></span>", (5 - intval($company->SocialRating)));?>
				</td>
			</tr>
			<?php endforeach;?>
		</table>
		<div class="hide_top_news">
			<a class="fft fs11 table" rel="<?php echo NEWS_COMPANIES;?>" href="javascript:void(0)"><span>&nbsp;</span><?php echo $this->__('Hide Top Companies');?></a>
		</div>
	</div>
<?php endif; ?>

<div class="inside_search_cont mt5">
	<div class="inside_search_left">
		<div class="inside_search_right clearfix">
			<form id="inside_search" action="<?php echo MainHelper::site_url('news/companies/search');?>" method="GET">
				<input type="hidden" id="form_url" value="<?php echo MainHelper::site_url('news/companies/search');?>" />
				<input type="text" id="inside_search_txt" onfocus="if (value == '<?php echo $this->__('Search Companies...');?>') {value =''}" onblur="if (value == '') {value = '<?php echo $this->__('Search Companies...');?>'}" value="<?php echo isset($searchText) ? htmlspecialchars($searchText) : $this->__('Search Companies...');?>" title="<?php echo $this->__('Search Companies...');?>" />
				<a href="javascript:void(0)"><span><?php echo $this->__('Search');?></span></a>
				<input type="submit" class="dn" />
			</form>
		</div>
	</div>
</div>
<?php if(isset($searchText)):?>
	<div class="fs16 fft mt5"><?php echo $this->__('Search Results');?>:</div>
	<div class="fs2 fft"><?php echo $this->__('Searched for: '). $searchText .'. Founded: '.$searchTotal;?></div>
<?php endif;?>

<?php if(isset($companies) and !empty($companies)):?>
	<table cellpadding="0" cellspacing="0" border="1" width="100%" class="mt10 company_table company_table_border">
		<tr>
			<th colspan="2">
				<span><?php echo $this->__('All Companies');?></span>
				<span class="header_current"><?php echo $this->__('Companies');?>: <?php echo $pagerObj->totalItem;?></span>
			</th>
			<th class="tac pl10 pr10"><?php echo $this->__('News');?></th>
			<th class="tac pl10 pr10"><?php echo $this->__('User Rating');?></th>
		</tr>

		<?php foreach ($companies as $key => $company):?>
			<tr class="<?php echo (!$key) ? 'first' : '';?>">
				<td width="50">
					<?php echo MainHelper::showImage($company, THUMB_LIST_40x40, false, array('no_img' => 'noimage/no_company_40x40.png')); ?>
				</td>
				<td class="pl10 <?php echo (($key - 1) % 2 == 0) ? 'odd' : 'even';?>" width="365">
					<div class="pr">
						<a class="db fs16" href="<?php echo $company->NEWS_URL;?>"><?php echo $company->CompanyName;?><?php echo ($company->NewsHistoryTop > 0 and $company->NewsCurrentTop == 0) ? '<span class="fr db star_pop">'.$company->NewsCurrentTop.'</span>' : '';?></a>
						<?php if($company->NewsHistoryTop > 0):?>
							<div class="company_top"><div class="star<?php echo $company->NewsHistoryTop;?>">&nbsp;</div></div> 
						<?php endif;?>
					</div>
				</td>
				<td class="pl10 pr10 tac tb <?php echo (($key - 1) % 2 == 0) ? 'odd' : 'even';?>" width="57"><?php echo $company->NewsCount;?></td>
				<td class="pl10 pr10 tac <?php echo (($key - 1) % 2 == 0) ? 'odd' : 'even';?>" width="123">
					<?php echo str_repeat("<span class='star_blue'></span>", intval($company->SocialRating));?><?php echo str_repeat("<span class='star_grey'></span>", (5 - intval($company->SocialRating)));?>
				</td>
			</tr>
			<?php endforeach;?>
	</table>
	<?php echo $this->renderBlock('common/pagination', array('pager'=>$pager)) ?>
<?php endif; ?>
*/ ?>