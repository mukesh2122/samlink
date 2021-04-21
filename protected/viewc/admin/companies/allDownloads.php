<?php if(isset($companyDownloads) and !empty($companyDownloads)):?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_10 centered">
                                    <?php echo 'ID';?>
				</th>
                                <th class="size_30 centered">
                                    <?php echo $this->__('Filetype');?>
				</th>
                                <th class="size_30 centered">
                                    <?php echo $this->__('Download Name');?>
				</th>
                                <th class="size_10 centered">
                                    <?php echo $this->__('Filesize (MB)');?>
				</th>
				<th colspan="2" class="size_20 centered"><?php echo $this->__('Action');?></th>
			</tr>
		</thead>
		<tbody>

			<?php foreach($companyDownloads as $key => $item):?>
				<tr>
					<td class="centered"><?php echo $item->ID_DOWNLOAD;?></td>
					<td>
                                            <?php echo $item->Filetype; ?>
                                        </td>
                                        <td>
                                            <?php echo $item->DownloadName; ?>
                                        </td>
                                        <td>
                                            <?php echo $item->FileSize; ?>
                                        </td>
					<td class="size_10 centered">
                                            <a href="<?php echo MainHelper::site_url('admin/companies/edit/'.$item->ID_OWNER.'/downloads/edit/'.$item->ID_DOWNLOAD);?>"><?php echo $this->__('Edit');?></a>
                                        </td>
					<td class="size_10 centered">
                                            <a href="<?php echo MainHelper::site_url('admin/companies/edit/'.$item->ID_OWNER.'/downloads/delete/'.$item->ID_DOWNLOAD);?>"><?php echo $this->__('Delete');?></a>
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