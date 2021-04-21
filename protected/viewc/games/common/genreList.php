<h3><?php echo $this->__('Select a genre'); ?></h3>
<?php $CategoryType = isset($CategoryType) ? $CategoryType : GAME_INDEX; ?>
<ul class="vertical_tabs">
	<li>
		<a href="<?php echo MainHelper::site_url('games/'.$CategoryType); ?>" <?php echo $selectedGenreID == 0 ? 'class="selected"' : ''; ?>><?php echo $this->__('All games'); ?></a>
	</li>
	<?php if(isset($genreList) and !empty($genreList)):
		foreach($genreList as $genre): ?>
			<li>
				<a href="<?php echo MainHelper::site_url('games/'. urlencode($CategoryType) .'/'. urlencode($genre->GameTypeName)); ?>" <?php echo $selectedGenreID == $genre->ID_GAMETYPE ? 'class="selected"' : ''; ?>><?php echo $this->__($genre->NameTranslated); ?></a>
			</li>
		<?php endforeach;
	endif;?>
</ul>