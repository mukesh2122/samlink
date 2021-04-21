<?php
Doo::loadClass(array("YoutubeSearch"));

$videosFound = false;
if(!empty($medias)):
	foreach($medias as $item){
		if(isset($item->MediaName) && !empty($item->MediaName)){
			//Perform a Youtube search for the channel name.
			$params = new YoutubeSearchParameters();
			$params->setResultQuality(YoutubeSearch::QUALITY_HIGH);
			$params->setResultEmbeddable();
			
			//Check if any playlists are defined.
			$playlists = null;
			if(isset($item->MediaDesc) && !empty($item->MediaDesc)){
				$playlists = explode(',', $item->MediaDesc);
			}
			
			$videos = array();
			if($playlists){
				foreach($playlists as $playlist){
					$result = YoutubeSearch::SearchChannel($item->MediaName, $params, $playlist);
					
					if($result){
						for($i = 0, $len = $result->getVideoAmount();$i < $len;$i++){
							$video = "<span class=\"video_title oh\"><a rel=\"iframe\" title=\"\" href=\"".$company->COMPANY_URL."/media/".MEDIA_CHANNEL_URL."/".$result->getVideoId($i)."\">".DooTextHelper::limitChar(htmlspecialchars($result->getVideoTitle($i)), 75)."</a></span>";
							$video .= "<a class=\"thickbox\" rel=\"iframe\" href=\"".$company->COMPANY_URL."/media/".MEDIA_CHANNEL_URL."/".$result->getVideoId($i)."\" title=\"".htmlspecialchars($result->getVideoTitle($i))."\">";
							$video .= "<img src=\"".$result->getVideoThumbnailLink($i, YoutubeSearch::THUMBNAIL_LOW)."\" onload=\"imageLoad(event);\">";
							$video .= "</a>";
							
							$videos[] = $video;
						}
						$videosFound = true;
					}
				}
			}
			else {
				$result = YoutubeSearch::SearchChannel($item->MediaName, $params);
				
				if($result){
					for($i = 0, $len = $result->getVideoAmount();$i < $len;$i++){
						$video = "<span class=\"video_title oh\"><a rel=\"iframe\" title=\"\" href=\"".$company->COMPANY_URL."/media/".MEDIA_CHANNEL_URL."/".$result->getVideoId($i)."\">".DooTextHelper::limitChar(htmlspecialchars($result->getVideoTitle($i)), 75)."</a></span>";
						$video .= "<a class=\"thickbox\" rel=\"iframe\" href=\"".$company->COMPANY_URL."/media/".MEDIA_CHANNEL_URL."/".$result->getVideoId($i)."\" title=\"".htmlspecialchars($result->getVideoTitle($i))."\">";
						$video .= "<img src=\"".$result->getVideoThumbnailLink($i, YoutubeSearch::THUMBNAIL_LOW)."\" onload=\"imageLoad(event);\">";
						$video .= "</a>";
						
						$videos[] = $video;
					}
					$videosFound = true;
				}
			}
			
			//Display the videos.
			$inc = 1; $offset = 0;
			if($offset > 0)
				$inc += $offset % 2;
			
			foreach($videos as $video){
				echo ($inc < 3) ? "<div class=\"mr3 media_post video_img pr\">" : "<div class=\"media_post video_img pr\">";
				echo $video;
				echo "</div>";
				
				if($inc == 3){
					echo "<div class=\"clear mb8\">&nbsp;</div>";
					$inc = 0;
				}
				
				$inc++;
			}
		}
	}
endif; ?>
<?php
    if(!$videosFound){
    	echo "<div class=\"noItemsText\">" . $this->__('No Youtube videos found.') . "</div>";
    }
?>