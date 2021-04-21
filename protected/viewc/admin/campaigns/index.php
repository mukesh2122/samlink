<?php  if(isset($campaigns) and !empty($campaigns)):?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>
			<tr>
				<th class="size_10 centered">
					
						<?php echo 'ID'.(isset($sortType) && $sortType == '11' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					
				</th>
				<th class="size_40 centered">
					<a href="<?php echo MainHelper::site_url('admin/games/sort/12/'.(isset($sortType) && $sortType == '12' && $sortDir == 'asc' ? 'desc' : 'asc'));?>">
						<?php echo $this->__('Advertiser').(isset($sortType) && $sortType == '12' ? ($sortDir == 'asc' ?' ˄' : ' ˅') : '');?>
					</a>
				</th>
				<th class="size_20 centered"><?php echo $this->__('Banners');?></th>
				<th class="size_20 centered"><?php echo $this->__('Action');?></th>
			</tr>
			
		</thead>
		<tbody>

			 <?php foreach($campaigns as $campaign):?>
				 <tr>
					<td class="centered"><?php echo $campaign->ID_CAMPAIGN;?></td>
					
					<td>
					<?php echo $campaign->AdvertiserName;?>
					</td>
					<td class="centered">
                                            <a href="<?php echo MainHelper::site_url('admin/campaigns/banners/'.$campaign->ID_CAMPAIGN);?>"/><?php echo $this->__('View');?></a>
                                            <a href="<?php echo MainHelper::site_url('admin/campaigns/adbanner/'.$campaign->ID_CAMPAIGN);?>"><?php echo $this->__('Upload');?></a>
					</td>
					<td class="centered">
                                            <a href="<?php echo MainHelper::site_url('admin/campaigns/delete/'.$campaign->ID_CAMPAIGN);?>"
                                               onclick="if (confirm('<?php echo $this->__('Are you sure?'); ?>')){action.value='delete';document.allnews_form.submit();}"/><?php echo $this->__('Delete');?></a>
                                            <a href="<?php echo MainHelper::site_url('admin/campaigns/editcampaign/'.$campaign->ID_CAMPAIGN);?>"><?php echo $this->__('Edit');?></a>
					</td>                                        
				</tr>
				
			<?php endforeach;?>
<pre>

</pre>



				
		</tbody>
	</table>
	<?php endif; ?>
