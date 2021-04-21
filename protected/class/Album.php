<?php
	class Album {
	
		public function create($player, $data) {
			$albumName = isset($data['albumName']) ? $data['albumName'] : '';
			$albumDescription = isset($data['albumDescription']) ? $data['albumDescription'] : '';

			$albums = new SnAlbums;
			$albums->ID_OWNER  = $player->ID_PLAYER;
			$albums->OwnerType = 'player';
			$albums->AlbumName = isset($data['albumName']) ? $data['albumName'] : '';
			$albums->AlbumDescription = isset($data['albumDescription']) ? $data['albumDescription'] : '';
			$idAlbum = $albums->insert();
			
			$message['albumName'] = $albumName;
			$message['albumDescription'] = $albumDescription;
			$items = new SnWallitems;
			$items->ItemType = 'album';
			$items->ID_OWNER = $player->ID_PLAYER;
			$items->OwnerType = 'player';
			$items->ID_ALBUM = $idAlbum;
			$items->ID_WALLOWNER = $player->ID_PLAYER;
			$items->WallOwnerType = 'player';
			$items->PosterDisplayName = $player->DisplayName;
			$items->Message = serialize($message);
			$items->insert();
			
			return $idAlbum;
		}
		
		public function getAlbumsByUser(Players $user) {
			$albums = new SnAlbums;
			$wallItems = new SnWallitems;
			$params = array(
				'SnWallitems'  => array(
					'select'   => "{$albums->_table}.*, {$wallItems->_table}.*"
				,	'JoinType' => 'LEFT'
				,	'where'    => "{$albums->_table}.ID_OWNER = $user->ID_PLAYER AND "
					.             "{$albums->_table}.OwnerType = 'player' "
				,	'desc'     => "{$wallItems->_table}.PostingTime "
				)
			);
			return Doo::db()->relatemany('SnAlbums', array('SnWallitems'), $params);
		}
		
		public function getAlbumsByTag(Players $user) {
			//---- Find tagged wallitems in players albums ----
			$walltags = new SnWalltags;
			$myWallitems = new SnMyWallItems;
			$sql = "SELECT a.ID_ALBUM, b.ID_WALLITEM "
			.	"FROM {$walltags->_table} AS a LEFT JOIN {$myWallitems->_table} AS b "
			.	"ON a.ID_WALLITEM = b.ID_WALLITEM AND a.ID_TAGGED = b.ID_VIEWER "
			.	"WHERE a.ID_TAGGED = $user->ID_PLAYER AND a.Untagged = 0 "
			.	"AND NOT ISNULL(b.ID_VIEWER) ";
			$tagItems = Doo::db()->fetchAll($sql);
			//---- Find original wallitems ----
			$inArray = array();
			if (!empty($tagItems)){
				foreach($tagItems as $tagItem){
					$inArray[] = $tagItem['ID_WALLITEM'];
				}
				$inWallitems = implode(',', $inArray);
				//---- Find tagged wallitems in players albums ----
				$wallitems = new SnWallitems;
				$opt = array(
					'where'    => "{$wallitems->_table}.ID_OWNER != $user->ID_PLAYER AND "
					.             "{$wallitems->_table}.ID_WALLITEM IN ($inWallitems) "
				,	'desc'     => "{$wallitems->_table}.PostingTime "
				);
				$items = Doo::db()->find($wallitems, $opt);
				//---- Replace wallitems album with players album ----
				$item2album = array();
				foreach($tagItems as $tagItem){
					$item2album[$tagItem['ID_WALLITEM']] = $tagItem['ID_ALBUM'];
				}
				foreach($items as $key=>$item){
					$items[$key]->ID_ALBUM = $item2album[$item->ID_WALLITEM];
				}
				return $items;
			}
			return false;
		}
		
		public function getById($idAlbum) {
			$albums = new SnAlbums;
			$albums->ID_ALBUM = $idAlbum;
			return Doo::db()->find($albums, array('limit' => 1));
		}
		
		public static function imageCountDec($idAlbum){
			if ($idAlbum > 0){
				$albums = new SnAlbums;
				$albums->ID_ALBUM = $idAlbum;
				$album = Doo::db()->find($albums, array('limit' => 1));
				if ($album->ImageCount > 0){
					--$album->ImageCount;
					$album->update();
				}
			}
		}
		
		public static function imageCountInc($idAlbum){
			if ($idAlbum > 0){
				$albums = new SnAlbums;
				$albums->ID_ALBUM = $idAlbum;
				$album = Doo::db()->find($albums, array('limit' => 1));
				++$album->ImageCount;
				$album->update();
			}
		}
		
		public static function imageCountMove($oldAlbum, $newAlbum){
			if ($oldAlbum != $newAlbum){
				self::imageCountDec($oldAlbum);
				self::imageCountInc($newAlbum);
			}
		}

		public function remove($idPlayer, $idAlbum) {
			//---- Remove uploaded files in album ----
			$items = new SnWallitems;
			$items->ID_ALBUM  = $idAlbum;
			$items->ID_OWNER  = $idPlayer;
			$items->OwnerType = 'player';
			$removeItems = Doo::db()->find($items);
			foreach ($removeItems as $item) {
				if ($item->ItemType == WALL_PHOTO) {
					$message = unserialize($item->Message);
					$content = unserialize($message['content']);
					$fileName = $content['content'];
					$dir = sprintf('%sglobal/pub_img/%s/%s/%s/', Doo::conf()->SITE_PATH, FOLDER_WALL_PHOTOS, $fileName[0], $fileName[1]);
					$files = preg_replace('/\.\w+$/', '*\\0', $fileName);   // Alter filename.ext to filename*.ext
					foreach(glob($dir.$files) as $file) {
						@unlink($file);
					}
				}
			}
			
			//---- Remove wallitems in album ----
			$items = new SnWallitems;
			$items->ID_ALBUM  = $idAlbum;
			$items->ID_OWNER  = $idPlayer;
			$items->OwnerType = 'player';
			$items->delete();
			
			//---- Remove album ----
			$albums = new SnAlbums;
			$albums->ID_ALBUM  = $idAlbum;
			$albums->ID_OWNER  = $idPlayer;
			$albums->OwnerType = 'player';
			$albums->delete();
		}
		
		public function update($idAlbum, $data) {
			$albumName = isset($data['albumName']) ? $data['albumName'] : '';
			$albumDescription = isset($data['albumDescription']) ? $data['albumDescription'] : '';

			$albums = new SnAlbums;
			$albums->ID_ALBUM = $idAlbum;
			$albums->OwnerType = 'player';
			$albums->AlbumName = $albumName;
			$albums->AlbumDescription = $albumDescription;
			$albums->update();
			
			$items = new SnWallitems;
			$items->ItemType = 'album';
			$items->ID_ALBUM = $idAlbum;
			$item = Doo::db()->find($items, array('limit' => 1));
			$message = unserialize($item->Message);
			$message['albumName'] = $albumName;
			$message['albumDescription'] = $albumDescription;
			$item->Message = serialize($message);
			$item->update();
		}
		
	}
?>
