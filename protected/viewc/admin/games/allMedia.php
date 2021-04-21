<?php if(isset($gameMedia) and !empty($gameMedia)):?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_10 centered">
                                    <?php echo 'ID';?>
				</th>
                                <th class="size_20 centered">
                                    <?php echo $this->__('Media Type');?>
				</th>
				<th class="size_50 centered">
                                    <?php echo $this->__('Media Name');?>
				</th>
				<th colspan="2" class="size_20 centered"><?php echo $this->__('Action');?></th>
			</tr>
		</thead>
		<tbody>

			<?php foreach($gameMedia as $key => $item):?>
				<tr>
					<td class="centered"><?php echo $item->ID_MEDIA;?></td>
					<td>
                                            <?php echo $this->__($item->MediaType); ?>
                                        </td>
                                        <td>
                                            <?php 
                                                if(!empty($item->MediaName)) echo $item->MediaName;
                                                else echo $this->__('Video Item ' . $key);
                                            ?>
                                        </td>
					<td class="size_10 centered">
                                            <?php if($item->MediaType!=MEDIA_VIDEO): ?>
                                            <a href="<?php echo MainHelper::site_url('admin/games/edit/'.$item->ID_OWNER.'/media/edit/'.$item->ID_MEDIA);?>"><?php echo $this->__('Edit');?></a>
                                            <?php endif; ?>
                                        </td>
					<td class="size_10 centered">
                                            <a href="<?php echo MainHelper::site_url('admin/games/edit/'.$item->ID_OWNER.'/media/delete/'.$item->ID_MEDIA);?>"><?php echo $this->__('Delete');?></a>
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