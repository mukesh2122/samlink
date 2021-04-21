<?php if(isset($gameTypes) and !empty($gameTypes)):?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_10 centered">
                                    <?php echo 'ID';?>
				</th>
				<th class="size_70 centered">
                                    <?php echo $this->__('Game Type Name');?>
				</th>
				<th colspan="3" class="size_30 centered"><?php echo $this->__('Action');?></th>
			</tr>
		</thead>
		<tbody>

			<?php foreach($gameTypes as $type):?>
				<tr>
					<td class="centered"><?php echo $type->ID_GAMETYPE;?></td>
					<td>
                                            <?php
                                                if(!empty($type->TypeNameTranslated)) echo $type->TypeNameTranslated;
                                                else echo $type->GameTypeName;
                                            ?></td>
                                        <td class="size_10 centered">
                                            <a href="<?php echo MainHelper::site_url('admin/games/types/merge/'.$type->ID_GAMETYPE);?>"><?php echo $this->__('Merge');?></a>
                                        </td>
					<td class="size_10 centered">
                                            <a href="<?php echo MainHelper::site_url('admin/games/types/edit/'.$type->ID_GAMETYPE);?>"><?php echo $this->__('Edit');?></a>
                                        </td>
					<td class="size_10 centered">
                                            <a href="<?php echo MainHelper::site_url('admin/games/types/delete/'.$type->ID_GAMETYPE);?>"><?php echo $this->__('Delete');?></a>
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