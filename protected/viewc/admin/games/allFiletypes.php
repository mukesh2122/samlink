<?php if(isset($gameDownloadTabs) and !empty($gameDownloadTabs)):?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_10 centered">
                                    <?php echo 'ID';?>
				</th>
                                <th class="size_30 centered">
                                    <?php echo $this->__('Filetype Name');?>
				</th>
                                <th class="size_40 centered">
                                    <?php echo $this->__('Filetype Description');?>
				</th>
				<th colspan="2" class="size_20 centered"><?php echo $this->__('Action');?></th>
			</tr>
		</thead>
		<tbody>

			<?php foreach($gameDownloadTabs as $key => $item):?>
				<tr>
					<td class="centered"><?php echo $item->ID_FILETYPE;?></td>
					<td>
                                            <?php echo $item->FiletypeName; ?>
                                        </td>
                                        <td>
                                            <?php echo DooTextHelper::limitChar($item->FiletypeDesc, 30, '...'); ?>
                                        </td>
					<td class="size_10 centered">
                                            <a href="<?php echo MainHelper::site_url('admin/games/edit/'.$item->ID_OWNER.'/downloadtabs/edit/'.$item->ID_FILETYPE);?>"><?php echo $this->__('Edit');?></a>
                                        </td>
					<td class="size_10 centered">
                                            <a href="<?php echo MainHelper::site_url('admin/games/edit/'.$item->ID_OWNER.'/downloadtabs/delete/'.$item->ID_FILETYPE);?>"><?php echo $this->__('Delete');?></a>
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