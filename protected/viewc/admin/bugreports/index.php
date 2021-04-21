<?php echo $this->renderBlock('bugreports/common/search', array(
	'url' => MainHelper::site_url('admin/bugreports/'.$typeFilter.(isset($categoryFilter) ? ('/'.$categoryFilter.(isset($subcategoryFilter) ? ('/'.$subcategoryFilter) : '')) : '').'/search'),
	'searchText' => isset($searchText) ? $searchText : '',
	'searchTotal' => isset($searchTotal) ? $searchTotal : 0,
	'label' => $label = 'Search for support tickets...',
	'type' => $type = 'tickets'
)); ?>
<?php if(isset($bugreports) and !empty($bugreports)):?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_10 centered">
					<a href="<?php echo MainHelper::site_url('admin/bugreports/'.$typeFilter.(isset($categoryFilter) ? ('/'.$categoryFilter.(isset($subcategoryFilter) ? ('/'.$subcategoryFilter) : '')) : '').'/sort/ID_ERROR/'.(isset($sortType) && $sortType == 'ID_ERROR' && $sortDir == 'asc' ? 'desc' : 'asc'));?>">
						<?php echo 'Ticket #'.($sortType == 'ID_ERROR' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					</a>
				</th>
<?php if ($typeFilter == 'All') { ?>
				<th class="size_10 centered">
					<a href="<?php echo MainHelper::site_url('admin/bugreports/'.$typeFilter.'/sort/Type/'.(isset($sortType) && $sortType == 'Type' && $sortDir == 'asc' ? 'desc' : 'asc'));?>">
						<?php echo 'Type'.($sortType == 'Type' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					</a>
				</th>
<?php } else if ($typeFilter == 'Bug') { ?>
				<th class="size_10 centered">
					<a href="<?php echo MainHelper::site_url('admin/bugreports/'.$typeFilter.'/sort/Module/'.(isset($sortType) && $sortType == 'Module' && $sortDir == 'asc' ? 'desc' : 'asc'));?>">
						<?php echo 'Module'.($sortType == 'Module' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					</a>
				</th>
<?php } else if ($typeFilter != 'None' && empty($categoryFilter) && empty($subcategoryFilter)) { ?>
				<th class="size_10 centered">
					<a href="<?php echo MainHelper::site_url('admin/bugreports/'.$typeFilter.'/sort/Cat/'.(isset($sortType) && $sortType == 'Cat' && $sortDir == 'asc' ? 'desc' : 'asc'));?>">
						<?php echo 'Category'.($sortType == 'Cat' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					</a>
				</th>
<?php } else if (isset($categoryFilter) && $categoryFilter != 'None' && empty($subcategoryFilter)) { ?>
				<th class="size_10 centered">
					<a href="<?php echo MainHelper::site_url('admin/bugreports/'.$typeFilter.'/'.$categoryFilter.'/sort/SubCat/'.(isset($sortType) && $sortType == 'SubCat' && $sortDir == 'asc' ? 'desc' : 'asc'));?>">
						<?php echo 'Subcategory'.($sortType == 'SubCat' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					</a>
				</th>
<?php } ?>
				<th class="size_10 centered">
					<a href="<?php echo MainHelper::site_url('admin/bugreports/'.$typeFilter.(isset($categoryFilter) ? ('/'.$categoryFilter.(isset($subcategoryFilter) ? ('/'.$subcategoryFilter) : '')) : '').'/sort/Status/'.(isset($sortType) && $sortType == 'Status' && $sortDir == 'asc' ? 'desc' : 'asc'));?>">
						<?php echo 'Status'.($sortType == 'Status' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					</a>
				</th>
				<th class="size_40 centered">
					<a href="<?php echo MainHelper::site_url('admin/bugreports/'.$typeFilter.(isset($categoryFilter) ? ('/'.$categoryFilter.(isset($subcategoryFilter) ? ('/'.$subcategoryFilter) : '')) : '').'/sort/ErrorName/'.(isset($sortType) && $sortType == 'ErrorName' && $sortDir == 'asc' ? 'desc' : 'asc'));?>">
						<?php echo 'Subject'.($sortType == 'ErrorName' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					</a>
				</th>
<?php if ($typeFilter == 'Bug') { ?>
                <th class="size_10 centered">
                    <a href="<?php echo MainHelper::site_url('admin/bugreports/'.$typeFilter.(isset($categoryFilter) ? ('/'.$categoryFilter.(isset($subcategoryFilter) ? ('/'.$subcategoryFilter) : '')) : '').'/sort/Approver/'.(isset($sortType) && $sortType == 'Approver' && $sortDir == 'asc' ? 'desc' : 'asc'));?>">
                        <?php echo 'Developer'.($sortType == 'Approver' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
                    </a>
                </th>
<?php } else { ?>
                <th class="size_10 centered">
                    <a href="<?php echo MainHelper::site_url('admin/bugreports/'.$typeFilter.(isset($categoryFilter) ? ('/'.$categoryFilter.(isset($subcategoryFilter) ? ('/'.$subcategoryFilter) : '')) : '').'/sort/Approver/'.(isset($sortType) && $sortType == 'Approver' && $sortDir == 'asc' ? 'desc' : 'asc'));?>">
                        <?php echo 'Supporter'.($sortType == 'Approver' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
                    </a>
                </th>
<?php } ?>
				<th class="size_10 centered">
					<a href="<?php echo MainHelper::site_url('admin/bugreports/'.$typeFilter.(isset($categoryFilter) ? ('/'.$categoryFilter.(isset($subcategoryFilter) ? ('/'.$subcategoryFilter) : '')) : '').'/sort/Created/'.(isset($sortType) && $sortType == 'Created' && $sortDir == 'asc' ? 'desc' : 'asc'));?>">
						<?php echo 'Created'.($sortType == 'Created' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					</a>
				</th>
				<th class="size_10 centered">
					<a href="<?php echo MainHelper::site_url('admin/bugreports/'.$typeFilter.(isset($categoryFilter) ? ('/'.$categoryFilter.(isset($subcategoryFilter) ? ('/'.$subcategoryFilter) : '')) : '').(isset($statusFilter) ? ('/'.$statusFilter.(isset($moduleFilter) ? ('/'.$moduleFilter) : '')) : '').'/sort/LastUpdatedTime/'.(isset($sortType) && $sortType == 'LastUpdatedTime' && $sortDir == 'asc' ? 'desc' : 'asc'));?>">
						<?php echo 'Updated'.($sortType == 'LastUpdatedTime' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					</a>
				</th>
				<th class="size_10 centered">
					<a href="<?php echo MainHelper::site_url('admin/bugreports/'.$typeFilter.(isset($categoryFilter) ? ('/'.$categoryFilter.(isset($subcategoryFilter) ? ('/'.$subcategoryFilter) : '')) : '').'/sort/LastUpdatedBy/'.(isset($sortType) && $sortType == 'LastUpdatedBy' && $sortDir == 'asc' ? 'desc' : 'asc'));?>">
						<?php echo 'Last updated by'.($sortType == 'LastUpdatedBy' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					</a>
				</th>
				<th class="size_10 centered"><?php echo 'Action';?></th>
			</tr>
		</thead>

		<tbody>
			<?php foreach($bugreports as $bugreport):?>
				<tr>
					<td class="centered"><?php echo $bugreport->ID_ERROR;?></td>
<?php if ($typeFilter == 'All') { ?>
					<td class="centered"><?php echo $types[$bugreport->ReportType]; ?></td>
<?php } else if ($typeFilter == 'Bug') { ?>
					<td class="centered"><?php echo $modules[$bugreport->Module]; ?></td>
<?php } else if ($typeFilter != 'None' && empty($categoryFilter) && empty($subcategoryFilter)) { ?>
					<td class="centered"><?php echo $categories[$typeFilter][$bugreport->Category]; ?></td>
<?php } else if (isset($categoryFilter) && $categoryFilter != 'None' && empty($subcategoryFilter)) { ?>
					<td class="centered"><?php echo $subcategories[$categoryFilter][$bugreport->SubCategory]; ?></td>
<?php } ?>
					<td class="centered"><?php if ($typeFilter == 'Bug') { echo $statuses[$bugreport->Status]; } else { echo $errorstatuses[$bugreport->ErrorStatus]; }?></td>
					<td class="centered"><?php echo $bugreport->ErrorName;?></td>
					<td class="centered"><?php echo $bugreport->Developer; ?></td>
					<td class="centered"><?php echo MainHelper::calculateTime($bugreport->CreatedTime, 'd/m-y G:i');?></td>
					<td class="centered"><?php echo MainHelper::calculateTime($bugreport->LastUpdatedTime, 'd/m-y G:i'); ?></td>
					<td class="centered"><?php if ($bugreport->LastUpdatedBy != "") { if ($bugreport->LastUpdatedByType == '2') { echo 'Supporter: '; } else { echo 'User: '; } echo $bugreport->LastUpdatedBy; } ?></td>
					<td class="centered">
						<a href="<?php echo MainHelper::site_url('admin/bugreports/edit/'.$bugreport->ID_ERROR);?>"><?php echo 'Edit';?></a>
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