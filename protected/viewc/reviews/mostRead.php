<div id="most_read_column">
	<h3><?php echo $this->__('Most read this week');?></h3>
	<?php
		$player = User::getUser();
		if ($player)
			$langID = $player->ID_LANGUAGE.','.$player->OtherLanguages;
		else
			$langID = Lang::getCurrentLangID().',1';

		$news = new News;
		$list = $news->getMostReadNews(5, 1);

		$output = '';
		if (isset($list) && !empty($list)) {
			foreach ($list as $mostRead) {
				$newsUrl = '';
				$headline = '';
				foreach ($mostRead->NwItemLocale as $locale) {
					$headline = $locale->Headline;
				}
				foreach ($mostRead->NwItems as $items) {
					$newsUrl = $items->URL;
				}
				$output .= '<div class="most_read">'
				.	'<a href="'.$newsUrl.'">'.$headline.'</a>'
				.	'</div>';
			}
		}
		echo $output;
	?>
</div>
