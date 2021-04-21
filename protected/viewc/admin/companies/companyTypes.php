<?php if(isset($companyTypes) and !empty($companyTypes)):?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_10 centered">
                                    <?php echo 'ID';?>
				</th>
				<th class="size_60 centered">
                                    <?php echo $this->__('Company Type Name');?>
				</th>
				<th colspan="3" class="size_30 centered"><?php echo $this->__('Action');?></th>
			</tr>
		</thead>
		<tbody>

			<?php foreach($companyTypes as $type):?>
				<tr>
					<td class="centered"><?php echo $type->ID_COMPANYTYPE;?></td>
					<td>
                                            <?php
                                                if(!empty($type->TypeNameTranslated)) echo $type->TypeNameTranslated;
                                                else echo $type->CompanyTypeName;
                                            ?></td>
                                        <td class="size_10 centered">
                                            <a href="<?php echo MainHelper::site_url('admin/companies/types/merge/'.$type->ID_COMPANYTYPE);?>"><?php echo $this->__('Merge');?></a>
                                        </td>
					<td class="size_10 centered">
                                            <a href="<?php echo MainHelper::site_url('admin/companies/types/edit/'.$type->ID_COMPANYTYPE);?>"><?php echo $this->__('Edit');?></a>
                                        </td>
					<td class="size_10 centered">
                                            <a href="<?php echo MainHelper::site_url('admin/companies/types/delete/'.$type->ID_COMPANYTYPE);?>"><?php echo $this->__('Delete');?></a>
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