<?php
	class NewsSlider {
		
		private function urlExists($url) {
			$headers = get_headers($url);
			return ($headers[0] != 'HTTP/1.1 404 Not Found');
		}
		
		public function deleteSlide($id) {
			$slides = new NwSlides;
			return $slides->delete(array(
				'where' => 'ID_SLIDE = '.$id
			));
		}

		public function getActiveSlides($limit = 5) {
			$slides = new NwSlides;
			$slides->purgeCache();
			return $slides->find(array(
				'select' => '*'
			,	'where'  => 'isActive = 1'
			,	'asc'    => 'Priority'
			,	'limit'  => $limit
			));
		}

		public function getAllFiles($dir = '') {
			$fileList = array();
			if ($dir == '') {
				$dir = sprintf('%sglobal/pub_img/%s/', Doo::conf()->SITE_PATH, FOLDER_NEWS_SLIDES);
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
		
		public function getAllSlides() {
			$slides = new NwSlides;
			return $slides->find(array(
				'select' => '*'
			,	'asc'    => 'Priority'
			));
		}


		public function getImgFullpath(NwSlides $slide) {
			$pathFormat = '%sglobal/pub_img/%s/%s/%s/%s';
			$image = utf8_decode($slide->Image);
			return utf8_encode(sprintf($pathFormat, Doo::conf()->APP_URL, FOLDER_NEWS_SLIDES, $image[0], $image[1], $image));
		}

		public function getSlide($id) {
			$slides = new NwSlides;
			return $slides->find(array(
				'select' => '*'
			,	'where'  => 'ID_SLIDE = '.$id
			));
		}

		public function getSliderImages($limit = 5) {
			$slides = self::getActiveSlides($limit);
			$output = '';
			$tagFormat = '<a href="%s"><img src="%s" alt ="" title ="%s" /></a>';
			foreach ($slides as $slide) {
				$src = self::getImgFullPath($slide);
				if (self::urlExists($src)) {
					$output .= sprintf($tagFormat, $slide->URL, $src, $slide->Headline);
				}
			}
			return $output;
		}

		public function shiftPriority() {
			$slides = new NwSlides;
			$toShift = new NwSlides;
			$dublicatePriority = $slides->count(array(
				'where' => 'Priority = '.$this->Priority.' '
				.          'AND ID_SLIDE != '.$this->ID_SLIDE
			));
			if ($dublicatePriority > 0) {
				$toShift = $slides->find(array(
					'select' => '*'
				,	'where' => 'Priority >= '.$this->Priority.' '
					.          'AND ID_SLIDE != '.$this->ID_SLIDE
				));
				foreach ($toShift as $slide) {
					++$slide->Priority;
					$slide->update(array(
						'field' => 'Priority'
					));
				}
			}
		}
		
		public function updateSlide() {
			self::shiftPriority();
			$slides = new NwSlides;
			foreach ($this as $key => $value) {
				$slides->$key = $value;
			}
			if ($slides->ID_SLIDE == 0) {
				$slides->insert();
			}
			else {
				$slides->update();
			}
		}

	}
?>
