<?php  if(isset($banners) and !empty($banners)): ?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
                            <th class="size_20 centered">
						<?php echo $this->__('Campaign');?>
				</th>
				<th class="size_30 centered">
						<?php echo $this->__('Banner Name');?>
				</th>                                
                                <th class="size_10 centered">
						<?php echo $this->__('Place');?>
				</th>
                                <th class="size_10 centered">
						<?php echo $this->__('Displays');?>
				</th>
                                <th class="size_10 centered">
						<?php echo $this->__('Clicks');?>
				</th>
				<th class="size_10 centered"><?php echo $this->__('Action');?></th>
			</tr>
			
		</thead>
		<tbody>

			 <?php foreach($banners as $banner):?>
				 <tr>
					<td class="centered"><?php echo $banner->getCampaignName();?></td>
					<td class="centered"><?php echo $banner->PathToBanner;?></td>
					<td class="centered"><?php echo $banner->Placement;?></td>
                                        <td class="centered"><?php echo "{$banner->CurrentDisplays}($banner->MaxDisplays)";?></td>
                                        <td class="centered"><?php echo "{$banner->CurrentClicks}({$banner->MaxClicks})";?></td>
					
					<td class="centered">
                                            <a href="<?php echo MainHelper::site_url('admin/campaigns/delbanner/'.$banner->ID_BANNER);?>"
                                               onclick="if (confirm('<?php echo $this->__('Are you sure?'); ?>')){action.value='delete';document.allnews_form.submit();}"/><?php echo $this->__('Delete');?></a>
                                            <a href="<?php echo MainHelper::site_url('admin/campaigns/editbanner/'.$banner->ID_BANNER);?>"><?php echo $this->__('Edit');?></a>
					</td>
				</tr>
				
			<?php endforeach;?>				
		</tbody>
	</table>
	<?php endif; ?>