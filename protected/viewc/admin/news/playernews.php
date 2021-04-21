<ul class="horizontal_tabs clearfix">
<li><a href="<?php echo MainHelper::site_url('admin/news/player-news/all/page/1') ?>" > 
<i class="readmore_icon"></i> <?php echo $this->__('All') ?> </a></li>
<li><a href="<?php echo MainHelper::site_url('admin/news/player-news/unpub/page/1') ?>" >
<i class="recent_tab_icon"></i> <?php echo $this->__('Unpublished') ?> </a></li>
<li><a href="<?php echo Mainhelper::site_url('admin/news/player-news/pub/page/1') ?>" > 
<i class="players_tab_icon"></i> <?php echo $this->__('Published') ?> </a></li>

</ul>
<?php if($filter=='all')$th='All News';elseif($filter=='unpub')$th='All Unpublished News';else $th='All Published News';  ?>
<?php if(isset($newsList) && !empty($newsList)){ ?>
	<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
		<thead>		
		<tr>
			<th class="size_10 centered"><?php echo $this->__('ID')?></th>
			<th class="size_40 centered"><?php echo $this->__($th);?></th>
			<th class="size_40 centered"><?php echo $this->__('Last Editor Note')?></th>
			<th class="size_10 centered"><?php echo $this->__('Ready')?></th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach($newsList as $key => $item){ 
			foreach($item->NwItemLocale as $itemlocale){?>
				<tr>
					<td><?php echo $itemlocale->ID_NEWS ?></td>
					<td ><?php echo date('d/m-Y G:i',$itemlocale->PostingTime),'<br/>'; 
					echo ucfirst($item->OwnerType),': <a href="',$item->getOwner()->url,'">',$item->getOwner()->name,'</a><br/>';
					echo '<a href="',$item->EDIT_URL,'/',$itemlocale->ID_LANGUAGE,'">',$itemlocale->Headline,'</a>';	?>
					</td>
					<td>
					<?php	if($itemlocale->EditorNote != ''){
								//explode -1 parameter to insure it doesn't return last extra/added element that is empty 
								$editornotes=explode('|semicolon|',$itemlocale->EditorNote,-1);
								$lastnote=explode('|comma|',end($editornotes));
								 echo $this->__('Changed'),' <span style="color:blue">', date('d/m-Y G:i',$lastnote[0]),
								 '</span><br/> ',$this->__('by'),' <span style="color:blue">',$lastnote[1],
								 '</span><br/><br/><strong style="color:darkslategray">',$this->__('Note'),':</strong> ',
								 $lastnote[2];
								 
								 if(count($editornotes) > 1)								 
								 	echo '<br/><a class="pull_right" href="',MainHelper::site_url('admin/news/player-news/'),
								 	$itemlocale->ID_NEWS,'/',$itemlocale->ID_LANGUAGE,'">',$this->__('View More Notes'),'</a>';
							}else 
								echo $this->__('No notes');
					?>
					</td>
					<td><?php $isready= ($itemlocale->isReady == 0) ? $this->__('No') : $this->__('Yes');echo $isready;?></td>
				</tr>
		<?php }} ?>
		</tbody>
	</table>
<?php  
		echo $this->renderBlock('common/pagination',array('pager' => $pager)); 
	}
	else{
		echo '<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">';
		echo '<thead><tr><th class="size_50 centered">',$this->__('No News'),'</th></tr></thead><tr><td>';
		echo '<a href="',MainHelper::site_url('admin/news/add-news'),'">',$this->__('Add'),'</a>';
		echo '</td></tr></table>';
	}
			
	
?>

