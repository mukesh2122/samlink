<?php  if(isset($layout) and !empty($layout)):?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_10 centered"><?php echo 'ID'; ?></th>
				<th class="size_30 centered"><?php echo $this->__('Style');?></th>
				<th class="size_20 centered"><?php echo $this->__('Value');?></th>
				<th class="size_10 centered"><?php echo $this->__('Default');?></th>
				<th class="size_20 centered"><?php echo $this->__('Action');?></th>
			</tr>
			
		</thead>
		<tbody>

			 <?php foreach($layout as $style):?>
				 <tr>
					<td class="centered"><?php echo $style->ID_LAYOUT;?></td>
					<td class="centered"><?php echo $style->Name;?></td>
					<td class="centered"><?php echo $style->Value;?></td>
					<td class="centered"><?php echo $style->isDefault;?></td>
					
					<td class="centered">
                                            <a href="<?php echo MainHelper::site_url('admin/setup/layout/editstyle/'.$style->ID_LAYOUT);?>"><?php echo $this->__('Edit');?></a>
					</td>
				</tr>
				
			<?php endforeach;?>			
		</tbody>
	</table>
	<?php endif; ?>