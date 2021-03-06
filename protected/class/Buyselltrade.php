<?php

class Buyselltrade {

	
	
	public static function setType($type) {
		setcookie('type', $type, (time() + (3600 * 24 * 365)), "/");
		
		//setcookie('noticetype', '', (time() + (3600 * 24 * 365)), "/");
//		setcookie('category', '', (time() + (3600 * 24 * 365)), "/");
//		setcookie('country', '', (time() + (3600 * 24 * 365)), "/");
//		setcookie('lang', '', (time() + (3600 * 24 * 365)), "/");
//		
	}
	 public function getSetType() {
		if (isset($_COOKIE['type']) and !empty($_COOKIE['type'])) {
			return $_COOKIE['type'];
		} else {
			return '';
		}
    }
	public static function setNoticeType($NoticeType) {
		setcookie('noticetype', $NoticeType, (time() + (3600 * 24 * 365)), "/");
		
		//setcookie('type', '', (time() + (3600 * 24 * 365)), "/");
//		setcookie('category', '', (time() + (3600 * 24 * 365)), "/");
//		setcookie('country', '', (time() + (3600 * 24 * 365)), "/");
//		setcookie('lang', '', (time() + (3600 * 24 * 365)), "/");
		
	}
	 public function getNoticeType() {
		if (isset($_COOKIE['noticetype']) and !empty($_COOKIE['noticetype'])) {
			return $_COOKIE['noticetype'];
		} else {
			return '';
		}
    }
	 //SaleType
	
	 	public static function setSaleType($SaleType) {
		setcookie('saletype', $SaleType, (time() + (3600 * 24 * 365)), "/");
		
	}
	 public function getSaleType() {
		if (isset($_COOKIE['saletype']) and !empty($_COOKIE['saletype'])) {
			return $_COOKIE['saletype'];
		} else {
			return '';
		}
    }
	


	//MinPrice
	
	 	public static function setMinPrice($MinPrice) {
		setcookie('minprice', $MinPrice, (time() + (3600 * 24 * 365)), "/");
		
	}
	 public function getMinPrice() {
		if (isset($_COOKIE['minprice']) and !empty($_COOKIE['minprice'])) {
			return $_COOKIE['minprice'];
		} else {
			return '';
		}
    }
	
	
	//Startprice
	
	
	 	public static function setStartPrice($StartPrice) {
		setcookie('startprice', $StartPrice, (time() + (3600 * 24 * 365)), "/");
		
	}
	 public function getStartPrice() {
		if (isset($_COOKIE['startprice']) and !empty($_COOKIE['startprice'])) {
			return $_COOKIE['startprice'];
		} else {
			return '';
		}
    }
	
	//Currentprice
	
	
	 	public static function setCurrentPrice($CurrentPrice) {
		setcookie('currentprice', $CurrentPrice, (time() + (3600 * 24 * 365)), "/");
		
	}
	 public function getCurrentPrice() {
		if (isset($_COOKIE['currentprice']) and !empty($_COOKIE['currentprice'])) {
			return $_COOKIE['currentprice'];
		} else {
			return '';
		}
    }
	
		//createdtime
	
	 	public static function setCreatedTime($CreatedTime) {
		setcookie('createdtime', $CreatedTime, (time() + (3600 * 24 * 365)), "/");
		
	}
	 public function getCreatedTime() {
		if (isset($_COOKIE['createdtime']) and !empty($_COOKIE['createdtime'])) {
			return $_COOKIE['createdtime'];
		} else {
			return '';
		}
    }
	
	//PaymentType
	
	 	public static function setPaymentType($PaymentType) {
		setcookie('paymenttype', $PaymentType, (time() + (3600 * 24 * 365)), "/");
		
	}
	 public function getPaymentType() {
		if (isset($_COOKIE['paymenttype']) and !empty($_COOKIE['paymenttype'])) {
			return $_COOKIE['paymenttype'];
		} else {
			return '';
		}
    }
	
	//Currency
	
		public static function setCurrency($Currency) {
		setcookie('currency', $Currency, (time() + (3600 * 24 * 365)), "/");
		
	}
	 public function getCurrency() {
		if (isset($_COOKIE['currency']) and !empty($_COOKIE['currency'])) {
			return $_COOKIE['currency'];
		} else {
			return '';
		}
    }
	
	public static function setHeadline($Headline) {
		setcookie('headline', $Headline, (time() + (3600 * 24 * 365)), "/");
		
		//setcookie('noticetype', '', (time() + (3600 * 24 * 365)), "/");
//		setcookie('type', '', (time() + (3600 * 24 * 365)), "/");
//		setcookie('category', '', (time() + (3600 * 24 * 365)), "/");
//		setcookie('country', '', (time() + (3600 * 24 * 365)), "/");
//		setcookie('lang', '', (time() + (3600 * 24 * 365)), "/");
		
	}
	 public function getHeadline() {
		if (isset($_COOKIE['headline']) and !empty($_COOKIE['headline'])) {
			return $_COOKIE['headline'];
		} else {
			return '';
		}
    }
	public static function setDetails($Details) {
		setcookie('details', $Details, (time() + (3600 * 24 * 365)), "/");
		
//		setcookie('noticetype', '', (time() + (3600 * 24 * 365)), "/");
//		setcookie('type', '', (time() + (3600 * 24 * 365)), "/");
//		setcookie('category', '', (time() + (3600 * 24 * 365)), "/");
//		setcookie('country', '', (time() + (3600 * 24 * 365)), "/");
//		setcookie('lang', '', (time() + (3600 * 24 * 365)), "/");
		
	}
	 public function getDetails() {
		if (isset($_COOKIE['details']) and !empty($_COOKIE['details'])) {
			return $_COOKIE['details'];
		} else {
			return '';
		}
    } 
	public static function setRegion($region) {
		setcookie('region', $region, (time() + (3600 * 24 * 365)), "/");
	}
	 public function getSetRegion() {
		if (isset($_COOKIE['region']) and !empty($_COOKIE['region'])) {
			return $_COOKIE['region'];
		} else {
			return '';
		}
    }
	public static function getRegionByID($id) {
        $item = Doo::db()->getOne('EsRegions', array(
            'limit' => 1,
            'where' => 'ID_REGION = ?',
            'param' => array($id)
                ));
        return $item;
    }
	public static function setOwnerType($ownertype) {
		setcookie('ownertype', $ownertype, (time() + (3600 * 24 * 365)), "/");
	}
	 public function getOwnerType() {
		if (isset($_COOKIE['ownertype']) and !empty($_COOKIE['ownertype'])) {
			return $_COOKIE['ownertype'];
		} else {
			return '';
		}
    }	
	
	public static function setCategory($category) {
		setcookie('category', $category, (time() + (3600 * 24 * 365)), "/");
	}
	 public function getCategory() {
		if (isset($_COOKIE['category']) and !empty($_COOKIE['category'])) {
			return $_COOKIE['category'];
		} else {
			return '';
		}
    }	
	public function getCategories() {
		$list = Doo::db()->find('SnCategories', array(
		    'select' => 'ID_CATEGORY, CategoryName',
		    'desc' => 'ID_CATEGORY'
		));
        
        return $list;
    }
	public function getCountries() {
		$list = Doo::db()->find('GeCountries', array(
		    'select' => 'ID_COUNTRY, Country',
		    'asc' => 'ID_COUNTRY'
		));
        
        return $list;
    }
	public static function getCountryByID($id) {
        $item = Doo::db()->getOne('GeCountries', array(
            'limit' => 1,
            'where' => 'ID_COUNTRY = ?',
            'param' => array($id)
                ));
        return $item;
    }
	public static function getCategoryByID($id) {
        $item = Doo::db()->getOne('SnCategories', array(
            'limit' => 1,
            'where' => 'ID_CATEGORY = ?',
            'param' => array($id)
                ));
        return $item;
    }
	public static function setCountry($country) {
		setcookie('country', $country, (time() + (3600 * 24 * 365)), "/");
	}
	 public function getCountry() {
		if (isset($_COOKIE['country']) and !empty($_COOKIE['country'])) {
			return $_COOKIE['country'];
		} else {
			return '';
		}
    }	
	//public function getServer($game_id = '') {
//		$gameserver = new RsGameServerRel;
//		$server = new RsServers;
//		
//		if ($game_id != '') {
// 			$list = Doo::db()->find('RsServers', array(
//		    	'select' => 'ID_SERVER, ServerName',
//				'where' => " EXISTS (SELECT {$gameserver->_table}.FK_SERVER FROM {$gameserver->_table} WHERE {$server->_table}.ID_SERVER = {$gameserver->_table}.FK_SERVER AND {$gameserver->_table}.FK_GAME = ?)",
//				'param' => array($game_id),
//		    	'asc' => 'ServerName'
//			));
//		} else {
//			$list = Doo::db()->find('RsServers', array(
//				'select' => 'ID_SERVER, ServerName',
//				'asc' => 'ServerName'
//			));
//		}        
//        return $list;
//    }	
//	public static function setServer($server) {
//		setcookie('server', $server, (time() + (3600 * 24 * 365)), "/");
//	}
//	 public function getSetServer() {
//		if (isset($_COOKIE['server']) and !empty($_COOKIE['server'])) {
//			return $_COOKIE['server'];
//		} else {
//			return '';
//		}
//    }
	public static function setLang($lang) {
		setcookie('lang', $lang, (time() + (3600 * 24 * 365)), "/");
	}
	 public function getSetLang() {
		if (isset($_COOKIE['lang']) and !empty($_COOKIE['lang'])) {
			return $_COOKIE['lang'];
		} else {
			return '';
		}
    }
	//public static function getServerByID($id) {
//        $item = Doo::db()->getOne('RsServers', array(
//            'limit' => 1,
//            'where' => 'ID_SERVER = ?',
//            'param' => array($id)
//                ));
//        return $item;
//    }
//			
//	public function getFaction($game_id = '') {
//		$faction = new RsFactions;
//		$gamefaction = new RsGameFactionRel;
//		
//		if ($game_id != '') {
// 			$list = Doo::db()->find('RsFactions', array(
//		    	'select' => 'ID_FACTION, FactionName',
//				'where' => " EXISTS (SELECT {$gamefaction->_table}.FK_FACTION FROM {$gamefaction->_table} WHERE {$faction->_table}.ID_FACTION = {$gamefaction->_table}.FK_FACTION AND {$gamefaction->_table}.FK_GAME = ?)",
//				'param' => array($game_id),
//		    	'asc' => 'FactionName'
//			));
//		} else {
//			$list = Doo::db()->find('RsFactions', array(
//		    	'select' => 'ID_FACTION, FactionName',
//		    	'asc' => 'FactionName'
//			));
//		}
//		
//        return $list;
//    }
//	 public static function setFaction($faction) {
//		setcookie('faction', $faction, (time() + (3600 * 24 * 365)), "/");
//	}
//	public function getSetFaction() {
//		if (isset($_COOKIE['faction']) and !empty($_COOKIE['faction'])) {
//			return $_COOKIE['faction'];
//		} else {
//			return '';
//		}
//    }
//	public static function getFactionByID($id) {
//        $item = Doo::db()->getOne('RsFactions', array(
//            'limit' => 1,
//            'where' => 'ID_FACTION = ?',
//            'param' => array($id)
//                ));
//        return $item;
//    }
//	
//	public function getRoles($game_id = '') {
//		$rolerel = new RsGameRoleRel;
//		$roles = new RsRoles;
//		
//		if ($game_id != '') {
//			$list = Doo::db()->find('RsRoles', array(
//		    	'select' => 'ID_ROLE, RoleName',
//				'where' => " EXISTS (SELECT {$rolerel->_table}.FK_ROLE FROM {$rolerel->_table} WHERE {$roles->_table}.ID_ROLE = {$rolerel->_table}.FK_ROLE AND {$rolerel->_table}.FK_GAME = ?)",
//				'param' => array($game_id),
//		    	'asc' => 'RoleName'
//			));
//			
//		} else {
//			$list = Doo::db()->find('RsRoles', array(
//		    	'select' => 'ID_ROLE, RoleName',
//		    	'asc' => 'RoleName'
//			));
//        }
//		
//        return $list;
//    }		
//	 public static function setRole($role) {
//		setcookie('role', $role, (time() + (3600 * 24 * 365)), "/");
//	}
//	public function getSetRole() {
//		if (isset($_COOKIE['role']) and !empty($_COOKIE['role'])) {
//			return $_COOKIE['role'];
//		} else {
//			return '';
//		}
//    }
//	public static function getRoleByID($id) {
//        $item = Doo::db()->getOne('RsRoles', array(
//            'limit' => 1,
//            'where' => 'ID_ROLE = ?',
//            'param' => array($id)
//                ));
//        return $item;
//    }
//	
			
//	public function getLevel($game_id = '') {
//		$gamelevel = new RsGameLevelRel;
//		$levelgroup = new SnGroupTypes;
//		
//		if ($game_id != '') {
//			$list = Doo::db()->find('SnGroupTypes', array(
//		    	'select' => 'ID_GROUPTYPE, GroupTypeName',
//				'where' => " EXISTS (SELECT {$gamelevel->_table}.FK_GROUPTYPE FROM {$gamelevel->_table} WHERE {$levelgroup->_table}.ID_GROUPTYPE = {$gamelevel->_table}.FK_GROUPTYPE AND {$gamelevel->_table}.FK_GAME = ?)",
//				'param' => array($game_id),
//		    	'asc' => 'GroupTypeName'
//			));
//			
//		} else {
//			$list = Doo::db()->find('SnGroupTypes', array(
//				'select' => 'ID_GROUPTYPE, GroupTypeName',
//				'asc' => 'GroupTypeName'
//			));
//        }
//        return $list;
//    }
//	public static function setLevel($level) {
//		setcookie('level', $level, (time() + (3600 * 24 * 365)), "/");
//	}
//	public function getSetLevel() {
//		if (isset($_COOKIE['level']) and !empty($_COOKIE['level'])) {
//			return $_COOKIE['level'];
//		} else {
//			return '';
//		}
//    }
//	public static function getLevelByID($id) {
//        $item = Doo::db()->getOne('SnGroupTypes', array(
//            'limit' => 1,
//            'where' => 'ID_GROUPTYPE = ?',
//            'param' => array($id)
//                ));
//        return $item;
//    }
//	
//	
//	public function getMode($game_id = '') {
//		$gamemode = new RsGameModeRel;
//		$modegroup = new SnGroupTypes;
//		
//		if ($game_id != '') {
//			$list = Doo::db()->find('SnGroupTypes', array(
//		    	'select' => 'ID_GROUPTYPE, GroupTypeName',
//				'where' => " EXISTS (SELECT {$gamemode->_table}.FK_GROUPTYPE FROM {$gamemode->_table} WHERE {$modegroup->_table}.ID_GROUPTYPE = {$gamemode->_table}.FK_GROUPTYPE AND {$gamemode->_table}.FK_GAME = ?)",
//				'param' => array($game_id),
//		    	'asc' => 'GroupTypeName'
//			));
//			
//		} else {
//			$list = Doo::db()->find('SnGroupTypes', array(
//				'select' => 'ID_GROUPTYPE, GroupTypeName',
//				'asc' => 'GroupTypeName'
//			));
//		}	        
//        return $list;
//    }	
//	public static function setMode($mode) {
//		setcookie('mode', $mode, (time() + (3600 * 24 * 365)), "/");
//	}
//	public function getSetMode() {
//		if (isset($_COOKIE['mode']) and !empty($_COOKIE['mode'])) {
//			return $_COOKIE['mode'];
//		} else {
//			return '';
//		}
//    }
//	public static function getModeByID($id) {
//        $item = Doo::db()->getOne('SnGroupTypes', array(
//            'limit' => 1,
//            'where' => 'ID_GROUPTYPE = ?',
//            'param' => array($id)
//                ));
//        return $item;
//    }
	
	public function getNotices($ownertype='',$category_id='',$country='',$lang='',$noticetype='',$saletype='',$limit='') {
		
		if (($ownertype=='') or ($ownertype=='player')) {
			$ownertype_name = 'NickName';
			$ownertype_table= "sn_players";	
			$ownertype_ID= "ID_PLAYER";	
		} else {
			$ownertype_name = "GroupName";
			$ownertype_table= "sn_groups";
			$ownertype_ID= "ID_GROUP";	
		}
		$filter = '';
		if (($category_id!='') && ($category_id!='4')) {
			$filter =  ' AND sn_notices.FK_CATEGORY = '.$category_id;
		}
		if ($country!='') {
			$filter .= ' AND sn_notices.FK_COUNTRY = '.$country;
		}
		if ($noticetype!='') {
			$filter .= " AND sn_notices.NoticeType = '".$noticetype."'";
		}
		if ($lang!='') {
			$filter .= ' AND sn_notices.FK_LANGUAGE = '.$lang;
		}
		
		//saletype
		if ($saletype!='') {
		$filter .=  " AND sn_notices.SaleType = '".$saletype."'";
	}
		
		
		$sqllimit = '';
		if ($limit!='') {
			$sqllimit = ' ORDER BY ID_NOTICE ASC LIMIT '.$limit;
		}
		$query ="SELECT sn_notices.* , 
				ge_countries.Country as CountryName, 
				".$ownertype_table.".".$ownertype_name." as OwnerName,
				ge_languages.EnglishName as LanguageName,
				sn_notices.NoticeType as NoticetypeName,
				sn_notices.SaleType as SaleTypeName,
				sn_categories.CategoryName as CategoryName		
				FROM sn_notices INNER JOIN sn_categories ON sn_categories.ID_CATEGORY = sn_notices.FK_CATEGORY 
								LEFT JOIN ge_countries ON ge_countries.ID_COUNTRY = sn_notices.FK_COUNTRY 
								LEFT JOIN ".$ownertype_table." ON ".$ownertype_table.".".$ownertype_ID." = sn_notices.FK_OWNER
								LEFT JOIN ge_languages ON ge_languages.ID_LANGUAGE = sn_notices.FK_LANGUAGE 
				WHERE sn_notices.NoticesStatus = 'open' And sn_notices.OwnerType = '".$ownertype."'".$filter.$sqllimit."";

		$rs = Doo::db()->query($query);
		$item = $rs->fetchAll(PDO::FETCH_CLASS);
		
        return $item;
	}
	
	public function getNoticeById($nid, $ownertype='') {
		
		if (($ownertype=='player')) {
			$ownertype_name = 'NickName';
			$ownertype_table= "sn_players";	
			$ownertype_ID= "ID_PLAYER";	
		} else {
			$ownertype_name = "GroupName";
			$ownertype_table= "sn_groups";
			$ownertype_ID= "ID_GROUP";	
		}
		
		$query ="SELECT sn_notices.* , 
				".$ownertype_table.".".$ownertype_name." as OwnerName,
				ge_languages.EnglishName as LanguageName,
				ge_countries.Country as CountryName,
				sn_notices.NoticeType as NoticeTypeName,
				sn_notices.SaleType as SaleTypeName,
				sn_categories.CategoryName as CategoryName			
				FROM sn_notices INNER JOIN sn_categories ON sn_categories.ID_CATEGORY = sn_notices.FK_CATEGORY 
								LEFT JOIN ge_countries ON ge_countries.ID_COUNTRY = sn_notices.FK_COUNTRY
								LEFT JOIN ".$ownertype_table." ON ".$ownertype_table.".".$ownertype_ID." = sn_notices.FK_OWNER
								LEFT JOIN ge_languages ON ge_languages.ID_LANGUAGE = sn_notices.FK_LANGUAGE 
				WHERE sn_notices.OwnerType = '".$ownertype."'
				AND   sn_notices.ID_NOTICE = '".$nid."'";
				
		$rs = Doo::db()->query($query);
		$item = $rs->fetchAll(PDO::FETCH_CLASS);
		
        return $item;
	}
	
	public function saveNotice($post) {
		$noticesID = '';
		if (!empty($post)) {
			
			$notices = new SnNotices;
			
			
			$notices->OwnerType = ContentHelper::handleContentInput($post['owntype']);
			$notices->isActive = '1';
			$notices->FK_OWNER = ContentHelper::handleContentInput($post['owner']);
			
			$notices->FK_COUNTRY = ContentHelper::handleContentInput($post['country']);
			$notices->FK_LANGUAGE = ContentHelper::handleContentInput($post['language']);
			$notices->FK_CATEGORY = ContentHelper::handleContentInput($post['category']);
			$notices->Details = ContentHelper::handleContentInput($post['details']);
			$notices->Headline = ContentHelper::handleContentInput($post['headline']);
			$notices->NoticeType = ContentHelper::handleContentInput($post['noticetype']);
			//added phase 2
			$notices->SaleType = ContentHelper::handleContentInput($post['saletype']);
			$notices->CurrentPrice = ContentHelper::handleContentInput($post['currentprice']);
			$notices->CreatedTime = ContentHelper::handleContentInput($post['createdtime']);
			$notices->MinPrice = ContentHelper::handleContentInput($post['minprice']);
			$notices->StartPrice = ContentHelper::handleContentInput($post['startprice']);
			$notices->PaymentType = ContentHelper::handleContentInput($post['paymenttype']);
			$notices->Currency = ContentHelper::handleContentInput($post['currency']);
			$notices->NoticesStatus = 'open';
			
			$noticesID = $notices->insert();		

		}
        return $noticesID;	
			
	}
	
	public function saveCategory($post) {
		$noticesID = '';
		
		if (!empty($post)) {
			//die('test');	
			$categories = new SnCategories();
			
			//$notices->OwnerType = ContentHelper::handleContentInput($post['owntype']);
			//$notices->isActive = '1';
			//$notices->FK_OWNER = ContentHelper::handleContentInput($post['owner']);
			
			//$notices->FK_COUNTRY = ContentHelper::handleContentInput($post['country']);//
//			$notices->FK_LANGUAGE = ContentHelper::handleContentInput($post['language']);
//			$notices->FK_CATEGORY = ContentHelper::handleContentInput($post['category']);   
			$categories->CategoryName = ContentHelper::handleContentInput($post['new_category']);
			//$notices->NoticesStatus = 'open';
			
			$noticesID = $categories->insert();		

		}
        return $noticesID;	
			
	}
	
	public static function getownerinfo($oid='',$ownertype='') {
		$item = '';
		if (($ownertype == 'player') && ($oid!='')){
			$item = Doo::db()->getOne('Players', array(
            'limit' => 1,
            'where' => 'ID_PLAYER = ?',
            'param' => array($oid)
                ));   		
		}
			
       return $item;
	}
	
	
	
	
	public function saveResponse($post) {
		$responseID = '';
		if (!empty($post)) {
			$responses = new SnResponses;
				
			$responses->OwnerType = ContentHelper::handleContentInput($post['ownertype']);
			//$responses->isActive = '1';
			$responses->FK_OWNER = ContentHelper::handleContentInput($post['ownerid']);
			
			$responses->FK_NOTICE = ContentHelper::handleContentInput($post['nid']);
			//added phase 2
			$responses->CreatedTime = ContentHelper::handleContentInput($post['createdtime']);
			$responses->Price = ContentHelper::handleContentInput($post['price']);
			$responses->PaymentType = ContentHelper::handleContentInput($post['paymenttype']);
			$responses->ResponseDetailsLog = ContentHelper::handleContentInput($post['ResponseDetailsLog']);
			$responses->ResponseStatus = 'waiting';
			
			$responsesID = $responses->insert();		
		
		}
        return $responsesID;	
			
	}
	
	
	public function updateResponse($responseid,$statusid,$owner,$notice,$createdtime,$price,$paymenttype) {
		$ID = '';
		if (($responseid!='') && ($statusid!='')) {
		
			
			$responses = new SnResponses;
			$responses->ResponseStatus = $statusid;
			$responses->ID_RESPONSE = $responseid;
			$responses->FK_OWNER = $owner;
			$responses->FK_NOTICE = $notice;
			//added
			$responses->CreatedTime = $createdtime;
			$responses->PaymentType = $paymenttype;
			$responses->Price = $price;
			$responses->update(array(
							'field' => 'ResponseStatus',
							'where' => 'ID_RESPONSE = ? AND FK_NOTICE = ? AND CreatedTime = ? AND Price = ? AND PaymentType = ? AND FK_OWNER = ?',
							'param' => array($responseid,$notice,$owner,$createdtime,$price,$paymenttype)
			));	
//			
		}
        return true;	
			
	}
	
	
	public function updateNoticeStatus($statusid,$owner,$notice) {
		$ID = '';
		if (($notice!='') && ($statusid!='')) {
	//	die('"'.$notice.'"');
			
			$notices = new SnNotices;
			$notices->NoticesStatus = $statusid;
			$notices->FK_OWNER = $owner;
			$notices->ID_NOTICE = $notice;
			$notices->update(array(
							'field' => 'NoticesStatus',
							'where' => 'ID_NOTICE = ? ',
							'param' => $notice
			));	
//			
		}
        return true;	
			
	}
	
	public function updateNotice($post) {
		$ID = '';
		if ($post!='') {
		
			$notices = new SnNotices;

			$notices->NoticeStatus = 'open';
			$notice = ContentHelper::handleContentInput($post['nid']);

			$notices->ID_NOTICE = ContentHelper::handleContentInput($post['nid']);
			$notices->FK_CATEGORY = ContentHelper::handleContentInput($post['category']);
			$notices->FK_OWNER = ContentHelper::handleContentInput($post['owner']);
			$notices->OwnerType = ContentHelper::handleContentInput($post['owntype']);
			$notices->FK_LANGUAGE = ContentHelper::handleContentInput($post['language']);
			$notices->FK_COUNTRY = ContentHelper::handleContentInput($post['country']);
			$notices->Details = ContentHelper::handleContentInput($post['details']);
			$notices->Headline = ContentHelper::handleContentInput($post['headline']);
			$notices->NoticeType = ContentHelper::handleContentInput($post['noticetype']);
			//added 
			$notices->Saletype = ContentHelper::handleContentInput($post['saletype']);
			$notices->CurrentPrice = ContentHelper::handleContentInput($post['currentprice']);
			$notices->MinPrice = ContentHelper::handleContentInput($post['minprice']);
			$notices->StartPrice = ContentHelper::handleContentInput($post['startprice']);
			$notices->PaymentType = ContentHelper::handleContentInput($post['paymenttype']);
			$notices->Currency = ContentHelper::handleContentInput($post['currency']);
			$notices->update(array(
							'field' => 'NoticeStatus,FK_CATEGORY,FK_OWNER,OwnerType,FK_LANGUAGE,FK_COUNTRY,Details,Headline,NoticeType,SaleType,
							CurrentPrice,MinPrice,StartPrice,PaymentType,Currency',
							'where' => 'ID_NOTICE = ? ',
							'param' => $notice
			));	
//			
		}
        return true;	
			
	}
	
	public function getMyNotices($ownertype='', $ownerid='', $type = '',$noticetype='',$limit='',$category='',$country='',$saletype='') {
		$item = '';
		setcookie('category', '', (time() + (3600 * 24 * 365)), "/");
		setcookie('country', '', (time() + (3600 * 24 * 365)), "/");
		setcookie('lang', '', (time() + (3600 * 24 * 365)), "/");
		setcookie('noticetype', '', (time() + (3600 * 24 * 365)), "/");
		setcookie('saletype', '', (time() + (3600 * 24 * 365)), "/");
		
		if ($ownerid!='') {
			if (($ownertype=='') or ($ownertype=='player')) {
				$ownertype_name = 'NickName';
				$ownertype_table= "sn_players";	
				$ownertype_ID= "ID_PLAYER";	
			} else {
				$ownertype_name = "GroupName";
				$ownertype_table= "sn_groups";
				$ownertype_ID= "ID_GROUP";	
			}
			
			if (($type!='') && ($type=='responses')) {
				$responses = " AND EXISTS (SELECT ID_RESPONSE FROM sn_responses WHERE sn_responses.FK_NOTICE = sn_notices.ID_NOTICE 
				                           AND sn_responses.FK_OWNER = ".$ownerid.") "; 
			} else {
				$responses = " AND sn_notices.FK_OWNER = ".$ownerid;
			}
			$sqllimit = '';
			if ($limit!='') {
				$sqllimit = ' LIMIT '.$limit;
			}
			//$query =
			$query="SELECT sn_notices.* , 
				".$ownertype_table.".".$ownertype_name." as OwnerName,
				ge_countries.Country as CountryName,
				sn_categories.CategoryName as CategoryName,
				sn_notices.NoticeType as NoticeTypeName,
				sn_notices.SaleType as SaleTypeName,
				ge_languages.EnglishName as LanguageName
				FROM sn_notices INNER JOIN sn_categories ON sn_categories.ID_CATEGORY = sn_notices.FK_CATEGORY 
								LEFT JOIN ge_countries ON ge_countries.ID_COUNTRY = sn_notices.FK_COUNTRY
								LEFT JOIN ".$ownertype_table." ON ".$ownertype_table.".".$ownertype_ID." = sn_notices.FK_OWNER
								LEFT JOIN ge_languages ON ge_languages.ID_LANGUAGE = sn_notices.FK_LANGUAGE 
				WHERE sn_notices.OwnerType = '".$ownertype."'".$responses.$sqllimit."";
			
			$rs = Doo::db()->query($query);
			$item = $rs->fetchAll(PDO::FETCH_CLASS);
		}
        return $item;
	}
	public static function getResponsesByNotices($noticesid,$ownertype) {
        $item = '';
		if ($noticesid!='') {
			if (($ownertype=='') or ($ownertype=='player')) {
				$ownertype_name = 'NickName';
				$ownertype_table= "sn_players";	
				$ownertype_ID= "ID_PLAYER";	
			} else {
				$ownertype_name = "GroupName";
				$ownertype_table= "sn_groups";
				$ownertype_ID= "ID_GROUP";	
			}
			
			$query ="SELECT ID_RESPONSE, FK_NOTICE, FK_OWNER, OwnerType, ResponseDetailsLog, ResponseStatus,Price,CreatedTime, PaymentType,
			".$ownertype_table.".".$ownertype_name." as OwnerName
			FROM sn_responses, ".$ownertype_table."
			WHERE (FK_NOTICE = '".$noticesid."') 
			AND ".$ownertype_table.".".$ownertype_ID." = FK_OWNER
			AND sn_responses.OwnerType = '".$ownertype."'";

			$rs = Doo::db()->query($query);
			$item = $rs->fetchAll(PDO::FETCH_CLASS);
		}
        return $item;
    }
	
	 public function getNoticesTotal() {
        $rc = new SnNotices();
		$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $rc->_table . '` LIMIT 1');
        return $totalNum->cnt;
    }
	 public function getMyNoticesTotal($ownertype='',$player='') {
        $rc = new SnNotices();
		$totalNum = (object) Doo::db()->fetchRow("SELECT COUNT(1) as cnt FROM ".$rc->_table."
		WHERE FK_OWNER = '".$player."'
		AND   OwnerType = '".$ownertype."'
		 LIMIT 1");
        return $totalNum->cnt;
    }

   

	
	//PAY WITH CREDITS
	
		
	
	  public static function getResponsesTotal($nid) {
        $rc = new SnResponses();
		$totalResponses = (object) Doo::db()->fetchRow("SELECT COUNT(1) as cnt FROM ".$rc->_table."
		WHERE FK_NOTICE = '".$nid."'
		 LIMIT 1");
		  return $totalResponses->cnt;
    }
	
	
	 //public static function ShowDateFormat($createdTime) {
//$date = DateTime::createFromFormat('dmyHi', $createdTime);
// $mydate= $date->format('d/m/y H:i');
//   
//   return  $mydate;
//}
	
	
	
	
	
	
	public function getBuyerCreditById($buyerid='') {
		$item='';
		
		$query ="SELECT 
		        NickName, 
				Credits as CreditAmount		
				FROM sn_players 
				WHERE ID_PLAYER = '".$buyerid."'";
				
		$rs = Doo::db()->query($query);
		$item = $rs->fetchAll(PDO::FETCH_CLASS);
		
        return $item;
	}

	
	public function getSellerCreditById($sellerid='') {
		$item='';
		
		$query ="SELECT 
		        NickName, 
				Credits as CreditAmount		
				FROM sn_players 
				WHERE ID_PLAYER = '".$sellerid."'";
				
		$rs = Doo::db()->query($query);
		$item = $rs->fetchAll(PDO::FETCH_CLASS);
		
        return $item;
	}
	
	 
	
	public function saveTransaction($post) {
		$transactionID = '';
		if (!empty($post)) {
			$transactions = new BstTransactions;
			$transactions->ID_SELLER = ContentHelper::handleContentInput($post['sellerid']);
			$transactions->ID_BUYER = ContentHelper::handleContentInput($post['buyerid']);
			$transactions->FK_RESPONSE = ContentHelper::handleContentInput($post['rid']);
			$transactions->FK_NOTICE = ContentHelper::handleContentInput($post['nid']);
		    $transactions->SaleType = ContentHelper::handleContentInput($post['saletype']);
			$transactions->TransactionTime = ContentHelper::handleContentInput($post['trans_time']);
			$transactions->Credits = ContentHelper::handleContentInput($post['credits']);	
			$transactionID = $transactions->insert();		
		
		}
        return $transactionID;	
			
	}
	
	
	public function updateSellerCredits($post) {
		$sellerid = '';
		
		if ($post!='') {
			
			$transactions = new Players;
	        $transactions->ID_PLAYER = ContentHelper::handleContentInput($post['sellerid']);
			$transactions->Credits = ContentHelper::handleContentInput($post['sellercredits']);
			$transactions->update(array(
							'field' => 'Credits',
							'where' => 'ID_PLAYER = ?',
							'param' => array($sellerid)
			));	
		
		}
        return true;	
			
	}
	
	public function updateBuyerCredits($post) {
		$buyerid = '';
		if ($post!='') {
		
			$transactions = new Players;
			$transactions->ID_PLAYER = ContentHelper::handleContentInput($post['buyerid']);
			$transactions->Credits = ContentHelper::handleContentInput($post['buyercredits']);
			$transactions->update(array(
							'field' => 'Credits',
							'where' => 'ID_Player = ? ',
							'param' => $buyerid
			));	
			
		}
        return true;	
			
	}
	
	 public function getMyTransactionsTotal($ownerid='') {
        $rc = new BstTransactions();
		$totalNum = (object) Doo::db()->fetchRow("SELECT COUNT(1) as cnt FROM ".$rc->_table."
		WHERE ID_SELLER = '".$ownerid."'
		OR ID_BUYER = '".$ownerid."'
		 LIMIT 1");
        return $totalNum->cnt;
    }


	public function getMyTransactions($ownerid='',$limit='') {
		$item = '';
		
			$sqllimit = '';
			if ($limit!='') {
				$sqllimit = ' LIMIT '.$limit;
			}
			//$query =
			$query="SELECT * from bst_transactions  
				WHERE ID_BUYER = '".$ownerid."' OR ID_SELLER = '".$ownerid."'".$sqllimit."";
			
			$rs = Doo::db()->query($query);
			$item = $rs->fetchAll(PDO::FETCH_CLASS);
		
        return $item;
	}
	
	public function getTransactionById($tid) {
	
		$item = '';
		
			
			//$query =
			$query="SELECT * from bst_transactions  
				WHERE ID_TRANSACTION = '".$tid."'
				";
			
			$rs = Doo::db()->query($query);
			$item = $rs->fetchAll(PDO::FETCH_CLASS);
		
        return $item;
	}
	
	public static function PaymentExists($nid) {
	
		    $rc = new BstTransactions();
		$totalPayments = (object) Doo::db()->fetchRow("SELECT COUNT(1) as cnt FROM ".$rc->_table."
		WHERE FK_NOTICE = '".$nid."'
		 LIMIT 1");
		  return $totalPayments->cnt;
	}
		
	//*****************catia ***********************
		public static function getAlbumsByAlbumID($user,$albumid) {
			$albums = new SnAlbums;
			$wallItems = new SnWallitems;
			$params = array(
				'SnWallitems'  => array(
					'select'   => "{$albums->_table}.*, {$wallItems->_table}.*"
				,	'JoinType' => 'LEFT'
				,	'where'    => "{$albums->_table}.ID_OWNER = $user AND "
					.             "{$albums->_table}.OwnerType = 'player' AND "
					.             "{$albums->_table}.ID_ALBUM = $albumid  "
				,	'desc'     => "{$wallItems->_table}.PostingTime "
				)
			);
			return Doo::db()->relatemany('SnAlbums', array('SnWallitems'), $params);
		}
	 public function getAlbumByNotices($nid) {
			 $rc = new SnNotices();
			$totalNum = (object) Doo::db()->fetchRow("SELECT FK_ALBUM FROM ".$rc->_table."
			WHERE ID_NOTICE = '".$nid."'
			 LIMIT 1");
			return $totalNum->FK_ALBUM;
	   }
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
			
			$query="update  sn_notices set  FK_ALBUM = '".$idAlbum."' 
				WHERE ID_NOTICE = '".$data['nid']."'";
			
			$rs = Doo::db()->query($query);
			
			return $idAlbum;
		}
	
		public static function getImageByAlbum($owner,$ownertype,$albumid) {
			
			$wallItems = new SnWallitems;	
			if ($albumid!='0') {	
				$totalNum = (object) Doo::db()->fetchRow("SELECT ID_WALLITEM from ".$wallItems->_table." 
					WHERE ID_OWNER = '".$owner."' AND OwnerType = '".$ownertype."' AND ID_ALBUM = '".$albumid."'
					AND ItemType = 'photo' ORDER BY PostingTime LIMIT 1 ");
			
				return $totalNum->ID_WALLITEM;
			} else {
				return '';
			}    		
			
		}
		
		public static function getTotalImages($owner,$ownertype,$albumid) {
			
			$wallItems = new SnWallitems;	
			if ($albumid!='0') {	
				$totalNum = (object) Doo::db()->fetchRow("SELECT COUNT(*) AS TOTAL from ".$wallItems->_table." 
					WHERE ID_OWNER = '".$owner."' AND OwnerType = '".$ownertype."' AND ID_ALBUM = '".$albumid."'
					AND ItemType = 'photo'  LIMIT 1 ");
			
				return $totalNum->TOTAL;
			} else {
				return '0';
			}    		
			
		}
		
		public static function getAllImageByAlbum($owner,$ownertype,$albumid) {
			$totalNum = '';
			$wallItems = new SnWallitems;	
			if ($albumid!='0') {	
				
					
				$query = "SELECT * from ".$wallItems->_table." 
					WHERE ID_OWNER = '".$owner."' AND OwnerType = '".$ownertype."' AND ID_ALBUM = '".$albumid."'
					AND ItemType = 'photo' ORDER BY PostingTime  ";
				
				$rs = Doo::db()->query($query);
				$totalNum = $rs->fetchAll(PDO::FETCH_CLASS);
				return $totalNum;
			} else {
				return '';
			}    		
			
		}
	//*****************catia end***********************	
	
	
	
	
	
}