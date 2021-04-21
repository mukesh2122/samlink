<?php
	class NewsHighlights {
		
		private function urlExists($url) {
			$headers = get_headers($url);
			return ($headers[0] != 'HTTP/1.1 404 Not Found');
		}
		
		public function deleteHighlight($id) {
			$highlights = new NwHighlights;
			return $highlights->delete(array(
				'where' => 'ID_HIGHLIGHT = '.$id
			));
		}

		public function getActiveHighlights() {
			$highlights = new NwHighlights;
			$highlights->purgeCache();
			return $highlights->find(array(
				'select' => '*'
			,	'where'  => 'isActive = 1'
			,	'asc'    => 'Priority'
			));
		}

		public function getAllFiles($dir = '') {
			$fileList = array();
			if ($dir == '') {
				$dir = sprintf('%sglobal/pub_img/%s/', Doo::conf()->SITE_PATH, FOLDER_NEWS_HIGHLIGHTS);
			}
			if (substr($dir, -1 , 1) != '/') {
				$dir .= '/';
			}
			if (!file_exists($dir)) {
				mkdir($dir, 0777, TRUE);
			}
			$dh = opendir($dir);
			while (($entry = readdir($dh)) !== FALSE) {
				$dirEntry = $dir.$entry;
				if (is_dir($dirEntry)) {
					if (!in_array($entry,  array('.', '..'))) {
						$fileList = array_merge($fileList, self::getAllFiles($dirEntry));
					}
				}
				else {
					$fileParts = explode('.', $entry);
					$fileExt = end($fileParts);
					if (in_array($fileExt, array('gif', 'jpeg', 'jpg', 'png'))) {
						$fileList[] = $entry;
					}
				}
			}
			closedir($dh);
			return $fileList;
		}
		
		public function getAllHighlights() {
			$highlights = new NwHighlights;
			return $highlights->find(array(
				'select' => '*'
			,	'asc'    => 'Priority'
			));
		}

		public function getImgFullPath(NwHighlights $highlight) {
			$pathFormat = '%sglobal/pub_img/%s/%s/%s/%s';
			$image = utf8_decode($highlight->Image);
			return utf8_encode(sprintf($pathFormat, Doo::conf()->APP_URL, FOLDER_NEWS_HIGHLIGHTS, $image[0], $image[1], $image));
		}

		public function getHighlight($id) {
			$highlights = new NwHighlights;
			return $highlights->find(array(
				'select' => '*'
			,	'where'  => 'ID_HIGHLIGHT = '.$id
			));
		}

		public function getHighlightsTableRows() {
			$highlights = self::getActiveHighlights();
			$output = '';
			$highlightsPerRow = Doo::conf()->highlightsPerRow;
			$tdFormat     = '<td><a href="%4$s"><img src="%1$s"></a><span><h3>%2$s</h3><p>%3$s <a href="%4$s">Read&nbsp;More</a></p></span></td>';
			$tdLastFormat = '<td class="small_news_last"><a href="%4$s"><img src="%1$s"></a><span><h3>%2$s</h3><p>%3$s <a href="%4$s">Read&nbsp;More</a></p></span></td>';
			foreach ($highlights as $key=>$highlight) {
				$firstInRow = ($key % $highlightsPerRow == 0);
				$lastInRow  = (($key + 1) % $highlightsPerRow == 0);
				$lastInSet  = ($key == count($highlights) -1);
				if ($firstInRow) {
					$output .= '<table class="small_news"><tr>';
				}
				$src = self::getImgFullPath($highlight);
				if (self::urlExists($src)) {
					if ($lastInRow || $lastInSet) {
						$output .= sprintf($tdLastFormat, $src, $highlight->Headline, $highlight->IntroText, $highlight->URL);
					}
					else {
						$output .= sprintf($tdFormat, $src, $highlight->Headline, $highlight->IntroText, $highlight->URL);
					}
				}
				if ($lastInRow || $lastInSet) {
					$output .= '</tr></table>';
				}
			}
			return $output;
		}

		public function shiftPriority() {
			$highlights = new NwHighlights;
			$toShift = new NwHighlights;
			$dublicatePriority = $highlights->count(array(
				'where' => 'Priority = '.$this->Priority.' '
				.          'AND ID_HIGHLIGHT != '.$this->ID_HIGHLIGHT
			));
			if ($dublicatePriority > 0) {
				$toShift = $highlights->find(array(
					'select' => '*'
				,	'where' => 'Priority >= '.$this->Priority.' '
					.          'AND ID_HIGHLIGHT != '.$this->ID_HIGHLIGHT
				));
				foreach ($toShift as $highlight) {
					++$highlight->Priority;
					$highlight->update(array(
						'field' => 'Priority'
					));
				}
			}
		}
		
		public function updateHighlight() {
			self::shiftPriority();
			$highlights = new NwHighlights;
			foreach ($this as $key => $value) {
				$highlights->$key = $value;
			}
			if ($highlights->ID_HIGHLIGHT == 0) {
				$highlights->insert();
			}
			else {
				$highlights->update();
			}
		}

	}
?>
