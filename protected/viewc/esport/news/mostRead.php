<div id="esport_most_read_column" class="esport_widget">
	<h3 class="fcw ml10 mt7"><?php echo $this->__('Most read this week');?></h3>
	<?php
		$player = User::getUser();
		if ($player)
			$langID = $player->ID_LANGUAGE.','.$player->OtherLanguages;
		else
			$langID = Lang::getCurrentLangID().',1';

		$news = new News;
		$list = $news->getMostReadNews();

		$output = '';
		if (isset($list) && !empty($list)) {
			foreach ($list as $mostRead) {
				$newsUrl = '';
				$headline = '';
				foreach ($mostRead->NwItemLocale as $locale) {
					$headline = $locale->Headline;
				}
				foreach ($mostRead->NwItems as $items) {
					$newsUrl = 'news/'.$items->PLAIN_URL;
				}
				$output .= '<div class="most_read">'
				.	'<a class="fcw" href="'.$newsUrl.'">'.$headline.'</a>'
				.	'</div>';
			}
		}
		echo $output;
	?>
</div>
