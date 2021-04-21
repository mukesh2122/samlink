<ul class="horizontal_tabs clearfix">
<li><a href="<?php echo MainHelper::site_url('admin/news/player-news/all/page/1') ?>" > 
<i class="readmore_icon"></i> <?php echo $this->__('All') ?> </a></li>
<li><a href="<?php echo MainHelper::site_url('admin/news/player-news/unpub/page/1') ?>" > 
<i class="recent_tab_icon"></i> <?php echo $this->__('Unpublished') ?> </a></li>
<li><a href="<?php echo MainHelper::site_url('admin/news/player-news/pub/page/1') ?>" > 
<i class="players_tab_icon"></i> <?php echo $this->__('Published') ?> </a></li>
</ul>

<?php
	echo '<table cellspacing="0" cellpadding="0" class="table table_bordered table_striped gradient_thead mt10">
	<thead><tr><th class="size_50"><h2>', $this->__('Editor Notes') ,'</h2></th></tr></thead><tbody>';
	if(isset($newsList) && !empty($newsList)){
		$itemlocales = $newsList[0]->NwItemLocale;
		foreach($itemlocales as $locale){
			$editornotes = explode("|semicolon|",$locale->EditorNote, -1);// -1 parameter to remove last empty element that is automaticly added 
			foreach($editornotes as $editornoteString){
				$editornote = explode("|comma|",$editornoteString);
				echo '<tr><td>',$this->__('Changed'),' <span style="color:blue">',date('d/m-Y G:i',$editornote[0]),
						'</span> ',$this->__('by'),' <span style="color:blue">',$editornote[1],'</span>';
				echo '<br/><span class="pull_right"><strong style="color:darkslategray">',
						$this->__('Note'),': </strong>',$editornote[2],'</span><br/></td></tr>'; 
			}	
		}echo '<tr><td><a href="',$newsList[0]->EDIT_URL,'/',$locale->ID_LANGUAGE,'">',$locale->Headline,'</a></td></tr>';
	}
?>
<tbody></table>