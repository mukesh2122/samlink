<?php echo $this->renderBlock('companies/common/search', array(
	'url' => MainHelper::site_url('admin/companies/search'),
	'searchText' => isset($searchText) ? $searchText : '',
	'searchTotal' => isset($searchTotal) ? $searchTotal : 0,
	'label' => $label = $this->__('Search for companies...'),
	'type' => $type = $this->__('companies')
));?>
<?php if(isset($companies) and !empty($companies)):?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_10 centered">
					<a href="<?php echo MainHelper::site_url('admin/companies/sort/11/'.(isset($sortType) && $sortType == '11' && $sortDir == 'asc' ? 'desc' : 'asc'));?>">
						<?php echo 'ID'.(isset($sortType) && $sortType == '11' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					</a>
				</th>
				<th class="size_50 centered">
					<a href="<?php echo MainHelper::site_url('admin/companies/sort/12/'.(isset($sortType) && $sortType == '12' && $sortDir == 'asc' ? 'desc' : 'asc'));?>">
						<?php echo $this->__('Company Name').(isset($sortType) && $sortType == '12' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					</a>
				</th>
				<th class="size_30 centered">
					<a href="<?php echo MainHelper::site_url('admin/companies/sort/13/'.(isset($sortType) && $sortType == '13' && $sortDir == 'asc' ? 'desc' : 'asc'));?>">
						<?php echo 'Type'.(isset($sortType) && $sortType == '13' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					</a>
				</th>
				<th class="size_20 centered"><?php echo $this->__('Action');?></th>
			</tr>
		</thead>
		<tbody>

			<?php foreach($companies as $company):?>
				<tr>
					<td class="centered"><?php echo $company->ID_COMPANY;?></td>
					<td><?php echo $company->CompanyName;?></td>
					<td><?php echo $company->CompanyType;?></td>
					<td class="centered">
						<a href="<?php echo MainHelper::site_url('admin/companies/edit/'.$company->ID_COMPANY);?>"><?php echo $this->__('Edit');?></a>
					</td>
				</tr>
			<?php endforeach;?>
		</tbody>
	</table>
	<?php
	if(isset($pager)){
		echo $this->renderBlock('common/pagination', array('pager'=>$pager));
	}
endif;
?>