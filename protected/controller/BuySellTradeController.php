<?php

class BuySellTradeController extends SnController {

	public function moduleOff()
	{
		$notAvailable = MainHelper::TrySetModuleNotAvailableByTag('buy_sell_trade');
		if ($notAvailable)
		{
			$data['title'] = $this->__('Buy/sell/trade');
			$data['body_class'] = 'index_buy_sell_trade';
			$data['selected_menu'] = 'buy_sell_trade';
			$data['left'] = PlayerHelper::playerLeftSide();
			$data['right'] = PlayerHelper::playerRightSide();
			$data['content'] = $notAvailable;
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();
			$this->render3Cols($data);
			exit;
		}
	}//catia

	/**
	 * Main website
	 *
	 */
	public function index() {
		//$this->moduleOff();
		
		$buyselltrades = new Buyselltrade();
		$languages = new Lang();
		$list = array();
		//$cx = new CurrencyExchange($currency='', 'EUR');
	    
		$noticesTotal = $buyselltrades->getNoticesTotal();
		$pager = $this->appendPagination($list, $buyselltrades, $noticesTotal, MainHelper::site_url(BUYSELLTRADE_NOTICES.'/page'), Doo::conf()->noticesLimit);
		$limit = $pager->limit;
		$player = User::getUser();
        

		if (isset($this->params['ownertype'])) {
			$ownertype = $this->params['ownertype'];
			if ($ownertype != '') {
				$ok = $buyselltrades->setOwnerType($ownertype);
			}
		} else {
			$ownertype = $buyselltrades->getOwnerType();
			if ($ownertype == '') {
				$ownertype = 'player';
				$ok = $buyselltrades->setOwnerType($ownertype);
			}
		}
		
		//NOTICETYPE
		
		if (isset($this->params['noticetype'])) {
			$noticetype = $this->params['noticetype'];
			if ($noticetype != '') { 
				$ok = $buyselltrades->setNoticeType($noticetype);
			}
		} else {
			$noticetype = $buyselltrades->getNoticeType();
			if ($noticetype == '') {
				$noticetype = 'sell';
				$ok = $buyselltrades->setNoticeType($noticetype);
			}
		}
		
		//SaleType
		
		if (isset($this->params['saletype'])) {
			$saletype = $this->params['saletype'];
			if ($saletype != '') { 
				$ok = $buyselltrades->setSaleType($saletype);
			}
		} else {
			$saletype = $buyselltrades->getSaleType();
			if ($saletype == '') {
				//changed
				$saletype = '';
				$ok = $buyselltrades->setSaleType($saletype);
			}
		}
		
		if (isset($this->params['category'])) {
			$category = $this->params['category'];
			if ($category != '') {
				$ok = $buyselltrades->setCategory($category);
			}
		} else {
			$category = $buyselltrades->getCategory();
		}
		if (isset($this->params['lang'])) {
			$lang = $this->params['lang'];
			if ($lang != '') {
				$ok = $buyselltrades->setLang($lang);
			}
		} else {
			$lang = $buyselltrades->getSetLang();
		}
		if (isset($this->params['country'])) {
			$country_id = $this->params['country'];
			if ($country_id!='') {
				$ok = $buyselltrades->setCountry($country_id);
			}
		} else {
			$country_id = $buyselltrades->getCountry();
		}

		
		$list['categoryList'] = $buyselltrades->getCategories();
		$list['countryList'] = $buyselltrades->getCountries();
		$list['langList'] = $languages->getLanguages();
		$list['noticesList'] = $buyselltrades->getNotices($ownertype,$category,$country_id,$lang,$noticetype,$saletype,$limit);
		
		//$list['credits'] = $cx->toCredit($price='');
        $list['noticetype'] = $noticetype;
		
		$nid='';
		$list['responsestotal'] = $buyselltrades->getResponsesTotal($nid);
		$list['payment'] = $buyselltrades->PaymentExists($nid);
		//saletype
		$list['saletype'] = $saletype;
		$list['category'] = $category;
		$list['ownertype'] = $ownertype;
		$list['player'] = $player;
		$list['country'] = $country_id;
		$list['lang'] = $lang;		
		$list['ownerid'] = ($player ? $player->ID_PLAYER : '');
		$list['headerName'] = $this->__('List Notices');

		$data['title'] = $this->__('buyselltrade');
		$data['body_class'] = 'index_groups';
		$data['selected_menu'] = 'buyselltrade';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('buyselltrade/listNotices', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}
	public function my_notices() {
		//$this->moduleOff();
		
		$buyselltrades = new Buyselltrade();
		$lang = new Lang();
		$list = array();
		$player = User::getUser();
		
		
		if (isset($this->params['noticetype'])) {
			$noticetype = $this->params['noticetype'];
			if ($noticetype != '') {
				$ok = $buyselltrades->setNoticeType($noticetype);
			}
		} else {
			$noticetype = $buyselltrades->getNoticeType();
			if ($noticetype == '') {
				$noticetype = 'sell';
				$ok = $buyselltrades->setNoticeType($noticetype);
			}
		}
		
		if (isset($this->params['ownertype'])) {
			$ownertype = $this->params['ownertype'];
			if ($ownertype != '') {
				$ok = $buyselltrades->setOwnerType($ownertype);
			}
		} else {
			$ownertype = $buyselltrades->getOwnerType();
			if ($ownertype == '') {
				$ownertype = 'player';
				$ok = $buyselltrades->setOwnerType($ownertype);
			}
		}
		//SaleType
		if (isset($this->params['saletype'])) {
			$saletype = $this->params['saletype'];
			if ($saletype != '') {
				$ok = $buyselltrades->setSaleType($saletype);
			}
		} else {
			$saletype = $buyselltrades->getSaleType();
			if ($saletype == '') {
				$saletype = 'buynow';
				$ok = $buyselltrades->setSaleType($saletype);
			}
		}
		if (isset($this->params['category'])) {
			$category = $this->params['category'];
			if ($category != '') {
				$ok = $buyselltrades->setCategory($category);
			}
		} else {
			$category = $buyselltrades->getCategory();
		}
		if (isset($this->params['country'])) {
			$country = $this->params['country'];
			if ($country != '') {
				$ok = $buyselltrades->setCountry($country);
			}
		} else {
			$country = $buyselltrades->getCountry();
		}
		if (isset($this->params['type'])) {
			$type = $this->params['type'];
			if ($type!='') {
				$ok = $buyselltrades->setType($type);
			}
		} else {
			$type = $buyselltrades->getSetType();
			if ($type == '') {
				$type = 'notices';
				$ok = $buyselltrades->setType($type);
			}
		}
		
		$list['categoryList'] = $buyselltrades->getCategories();
		$list['countryList'] = $buyselltrades->getCountries();
		$list['langList'] = $lang->getLanguages();
		$list['type'] = $type;
		$list['category'] = $category;
		$list['ownertype'] = $ownertype;
		//saletype
		$list['saletype'] = $saletype;
		$list['country'] = $country;
		$list['ownerid'] = ($player ? $player->ID_PLAYER : '');
		$list['noticetype'] = $noticetype;
		//responsesTotal
		//$myResponsesTotal = $buyselltrades->getMyResponsesTotal($ownertype,($player ? $player->ID_PLAYER : ''));
		
		//$noticesTotal = $recruitments->getMyNoticesTotal($ownertype,($player ? $player->ID_PLAYER : ''));
//		$pager = $this->appendPagination($list, $recruitments, $noticesTotal, MainHelper::site_url(RECRUITMENT_NOTICES.'/'.RECRUITMENT_MY_NOTICES.'/page'), Doo::conf()->mynoticesLimit);
//		$limit = $pager->limit;
		$limit = '';
		$list['noticesList'] = $buyselltrades->getMyNotices($ownertype,($player ? $player->ID_PLAYER : ''),$type,$limit,$category,$country,$noticetype,$saletype);


		$list['headerName'] = $this->__('List Notices');

		$data['title'] = $this->__('buyselltrade');
		$data['body_class'] = 'index_groups';
		$data['selected_menu'] = 'buyselltrade';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('buyselltrade/myNoticesResponses', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);

	}

	 public function create_notices() {
	 	//$this->moduleOff();
		
		$buyselltrades = new Buyselltrade();
		$languages = new Lang();
		$list = array();
		$player = User::getUser();

		if (isset($this->params['ownertype'])) {
			$ownertype = $this->params['ownertype'];
			if ($ownertype != '') {
				$ok = $buyselltrades->setOwnerType($ownertype);
			}
		} else {
			$ownertype = $buyselltrades->getOwnerType();
			if ($ownertype == '') {
				$ownertype = 'player';
				$ok = $buyselltrades->setOwnerType($ownertype);
			}
		}
		if (isset($this->params['category'])) {
			$category = $this->params['category'];
			if ($category != '') {
				$ok = $buyselltrades->setCategory($category);
			}
		} else {
			$category = $buyselltrades->getCategory();
		}
		if (isset($this->params['country'])) {
			$country = $this->params['country'];
			if ($country != '') {
				$ok = $buyselltrades->setCountry($country);
			}
		} else {
			$country = $buyselltrades->getCountry();
		}
		if (isset($this->params['lang'])) {
			$lang = $this->params['lang'];
			if ($lang != '') {
				$ok = $buyselltrades->setLang($lang);
			}
		} else {
			$lang = $buyselltrades->getSetLang();
		}
		if (isset($this->params['noticetype'])) {
			$noticetype = $this->params['noticetype'];
			if ($noticetype != '') {
				$ok = $buyselltrades->setNoticeType($noticetype);
			}
		} else {
			$noticetype = $buyselltrades->getNoticeType();
			//if ($noticetype=='') { 
//				$noticetype = 'sell';
//				$ok = $buyselltrades->setNoticeType($noticetype);
//				setcookie('noticetype', 'sell', (time() + (3600 * 24 * 365)), "/");
//				$noticetype = $buyselltrades->getNoticeType();
//				die('adfva'.$noticetype);
//			}
		}
		
		//saletype
		
		if (isset($this->params['saletype'])) {
			$saletype = $this->params['saletype'];
			if ($saletype != '') {
				$ok = $buyselltrades->setSaleType($saletype);
			}
		} else {
			$saletype = $buyselltrades->getSaleType();
			
		}
			
		// CurrentPrice
		if (isset($this->params['currentprice'])) {
			$currentprice = $this->params['currentprice'];
			if ($currentprice != '') {
				$ok = $buyselltrades->setCurrentPrice($currentprice);
			}
		} else {
			$currentprice = $buyselltrades->getCurrentPrice();
		}
		
		// minPrice
		if (isset($this->params['minprice'])) {
			$minprice = $this->params['minprice'];
			if ($minprice != '') {
				$ok = $buyselltrades->setMinPrice($minprice);
			}
		} else {
			$minprice = $buyselltrades->getMinPrice();
		}
		
		// startPrice
		
		if (isset($this->params['startprice'])) {
			$startprice = $this->params['startprice'];
			if ($startprice != '') {
				$ok = $buyselltrades->setStartPrice($startprice);
			}
		} else {
			$startprice = $buyselltrades->getStartPrice();
		}
		
		// Currency
			
		if (isset($this->params['currency'])) {
			$currency = $this->params['currency'];
			if ($currency != '') {
				$ok = $currency->setCurrency($currency);
			}
		} else {
			$currency = $buyselltrades->getCurrency();
		}
		// TimeCreated
		if (isset($this->params['createdtime'])) {
			$createdtime = $this->params['createdtime'];
			if ($createdtime != '') {
				$ok = $createdtime->setCreatedTime($createdtime);
			}
		} else {
			$createdtime = $buyselltrades->getCreatedTime();
		}
		
		
		// PaymentType
			
		if (isset($this->params['paymenttype'])) {
			$paymenttype = $this->params['paymenttype'];
			if ($paymenttype != '') {
				$ok = $buyselltrades->setPaymentType($paymenttype);
			}
		} else {
			$paymenttype = $buyselltrades->getPaymentType();
		}
		
		//details
		
			if (isset($this->params['details'])) {
			$details = $this->params['details'];
			if ($details != '') {
				$ok = $buyselltrades->setDetails($details);
			}
		} else {
			$details = $buyselltrades->getDetails();
		}
		//headline
		if (isset($this->params['headline'])) {
			$headline = $this->params['headline'];
			if ($headline != '') {
				$ok = $buyselltrades->setHeadline($headline);
			}
		} else {
			$headline = $buyselltrades->getHeadline();
		}
		$list['categoryList'] = $buyselltrades->getCategories();
		$list['countryList'] = $buyselltrades->getCountries();
		$list['langList'] = $languages->getLanguages();
		$list['ownerid'] = ($player ? $player->ID_PLAYER : '');
		$list['category'] = $category;
		$list['ownertype'] = $ownertype;
		$list['country'] = $country;
		$list['lang'] = $lang;
		$list['noticetype'] = $noticetype;
		$list['details'] = $details;
		$list['headline'] = $headline;
		$list['headerName'] = $this->__('Create Notices');
        //added phase 2
		$list['currentprice'] = $currentprice;
		$list['currency'] = $currency;
		$list['minprice'] = $minprice;
		$list['startprice'] = $startprice;
		$list['createdtime'] = $createdtime;
		$list['paymenttype'] = $paymenttype;
		$list['saletype'] = $saletype;
		
		$data['title'] = $this->__('buyselltrade');
		$data['body_class'] = 'index_groups';
		$data['selected_menu'] = 'buyselltrade';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('buyselltrade/createNotices', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);

	}

	public function save_notices() {
		//$this->moduleOff();
		
		$buyselltrades = new Buyselltrade();
		
		$button = $_POST['button_category'];
		if ($button!='') {
			//die($button);
			$noticeID = $buyselltrades->saveCategory($_POST);
		} else {
			$noticeID = $buyselltrades->saveNotice($_POST);
		}
		
		
		if($noticeID > 0){
			$result['result'] = true;
			$result['newUrl'] =  MainHelper::site_url(BUYSELLTRADE_NOTICES);

			setcookie('category', '', (time() + (3600 * 24 * 365)), "/");
			setcookie('country', '', (time() + (3600 * 24 * 365)), "/");
			$link=MainHelper::site_url(BUYSELLTRADE_NOTICES);
			DooUriRouter::redirect($link);
		}
		else{
			$result['result'] = false;
		}
	}
	
	public function save_categories() {
		//$this->moduleOff();
		
		$buyselltrades = new Buyselltrade();
		
		$noticeID = $buyselltrades->saveCategory($_POST);
		if($noticeID > 0){
			$result['result'] = true;
			$result['newUrl'] =  MainHelper::site_url(BUYSELLTRADE_NOTICES);

			setcookie('category', '', (time() + (3600 * 24 * 365)), "/");
			setcookie('country', '', (time() + (3600 * 24 * 365)), "/");
			$link=MainHelper::site_url(BUYSELLTRADE_NOTICES);
			DooUriRouter::redirect($link);
		}
		else{
			$result['result'] = false;
		}
	}
	
	public function save_category() {
		//$this->moduleOff();
		
		$buyselltrades = new Buyselltrade();
		
		$noticeID = $buyselltrades->saveCategory($_POST);
		die('sdfga'.$noticeID);
		if($noticeID > 0){
			$result['result'] = true;
			$result['newUrl'] =  MainHelper::site_url(BUYSELLTRADE_NOTICES);

			setcookie('category', '', (time() + (3600 * 24 * 365)), "/");
			setcookie('country', '', (time() + (3600 * 24 * 365)), "/");
			$link=MainHelper::site_url(BUYSELLTRADE_NOTICES);
			DooUriRouter::redirect($link);
		}
		else{
			$result['result'] = false;
		}
	}

	public function save_response() {
		//$this->moduleOff();
		
		$buyselltrades = new Buyselltrade();

		$responseID = $buyselltrades->saveResponse($_POST);
		if($responseID > 0){
			$result['result'] = true;
			$result['newUrl'] =  MainHelper::site_url(BUYSELLTRADE_NOTICES);

			setcookie('category', '', (time() + (3600 * 24 * 365)), "/");
			setcookie('country', '', (time() + (3600 * 24 * 365)), "/");
			
			$link=MainHelper::site_url(BUYSELLTRADE_NOTICES);

			DooUriRouter::redirect($link);

		}
		else{
			$result['result'] = false;
		}
	}

	public function update_response() {
		$this->moduleOff();
		
		$buyselltrades = new Buyselltrade();
		if (isset($this->params['rid'])) {
			$responseid = $this->params['rid'];
		}
		if (isset($this->params['status'])) {
			$statusid = $this->params['status'];
		}
		if (isset($this->params['owner'])) {
			$owner = $this->params['owner'];
		}
		if (isset($this->params['notice'])) {
			$notice = $this->params['notice'];
		}
		$responseID = $buyselltrades->updateResponse($responseid,$statusid,$owner,$notice);

		if($responseID > 0){

			$result['result'] = true;
			$result['newUrl'] =  MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_MY_NOTICES);

			setcookie('category', '', (time() + (3600 * 24 * 365)), "/");
			setcookie('country', '', (time() + (3600 * 24 * 365)), "/");
			
			$this->index();
		}
		else{
			$result['result'] = false;
		}
	}


	public function update_notice_status() {
		$this->moduleOff();
		
		$buyselltrades = new Buyselltrade();
		
		if (isset($this->params['status'])) {
			$statusid = $this->params['status'];
		}
		if (isset($this->params['owner'])) {
			$owner = $this->params['owner'];
		}
		if (isset($this->params['notice'])) {
			$notice = $this->params['notice'];
		}
		$responseID = $buyselltrades->updateNoticeStatus($statusid,$owner,$notice);

		if($responseID > 0){

			$result['result'] = true;
			$result['newUrl'] =  MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_MY_NOTICES);

			setcookie('category', '', (time() + (3600 * 24 * 365)), "/");
			setcookie('country', '', (time() + (3600 * 24 * 365)), "/");
			
			$this->index();
		}
		else{
			$result['result'] = false;
		}
	}

	public function respond_notices() {
		//$this->moduleOff();
		
		$buyselltrades = new Buyselltrade();
		$languages = new Lang();
		$list = array();
		$player = User::getUser();

		if (isset($this->params['ownertype'])) {
			$ownertype = $this->params['ownertype'];

		} else {
			$ownertype = '';
		}
		if (isset($this->params['nid'])) {
			$nid = $this->params['nid'];
		} else {
			$nid = '';
		}
		if (isset($this->params['noticetype'])) {
			$noticetype = $this->params['noticetype'];
		} else {
			$noticetype = '';
		}
		$list['noticeList'] = $buyselltrades->getNoticeById($nid,$ownertype);
		$list['ownertype'] = $ownertype;
		$list['noticetype'] = $noticetype;
		$list['nid'] = $nid;
		$list['ownerid'] = ($player ? $player->ID_PLAYER : '');
		$oid=($player ? $player->ID_PLAYER : '');
		$list['committer'] = $buyselltrades->getownerinfo($oid,$ownertype);

		$list['headerName'] = $this->__('Create Response');

		$data['title'] = $this->__('buyselltrade');
		$data['body_class'] = 'index_groups';
		$data['selected_menu'] = 'buyselltrade';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('buyselltrade/createResponse', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function update_notices() {
		//$this->moduleOff();
		
		$buyselltrades = new Buyselltrade();
		$languages = new Lang();
		              
		$list = array();
		$player = User::getUser();
		//catia start
		$users = new User();
		$friendUrl = '';
		$poster = $friendUrl == '' ? $player : User::getFriend($friendUrl);
		//catia end
		
		if (isset($this->params['noticetype'])) {
			$noticetype = $this->params['noticetype'];

		} else {
			$noticetype = '';
		}
		
		if (isset($this->params['saletype'])) {
			$saletype = $this->params['saletype'];

		} else {
			$saletype = '';
		}
		if (isset($this->params['ownertype'])) {
			$ownertype = $this->params['ownertype'];

		} else {
			$ownertype = '';
		}
		if (isset($this->params['nid'])) {
			$nid = $this->params['nid'];
		} else {
			$nid = '';
		}
		//die($nid.'afgag');
		//*********************catia*****************
		$type = WALL_PHOTO;
		
		$list['infoBox'] = MainHelper::loadInfoBox('Players', $type, true);
		$album_id = $buyselltrades->getAlbumByNotices($nid);
		if ($album_id!='') {
			MainHelper::getWallPosts($list, $player, 0, $type, $friendUrl, $album_id);		
		} else {
		    $list['posts'] = '';
		}		
		$list['wallType']  = $type;
		$album = new Album;
		$albums = $album->getAlbumsByUser($poster);       // Get own wallitem in albums
		$taggedItems = $album->getAlbumsByTag($poster);   // Get wallitems in albums on which the player is tagged
		if (!empty($taggedItems) && !empty($albums)){
			foreach($taggedItems as $item){
				foreach($albums as $key=>$alb){
					if ($item->ID_ALBUM == $alb->ID_ALBUM){
						$albums[$key]->SnWallitems[] = $item;   // Merge tagged items with own items
						break;
					}
					
				}
			}
			//---- Resort albums by descending postingtime----
			foreach($albums as $key=>$alb){
				uasort($albums[$key]->SnWallitems, function($a, $b){
					return $b->PostingTime - $a->PostingTime;
				});
			}
		}
		
		$list['albums'] = $albums;
		
		$album->ID_ALBUM = $album_id;
		$album->AlbumName = '';
		$album->AlbumDescription = '';
		$list['album'] = $album;
		//die($album_id.' ggggg');
		if ($album_id!='') {
			$list['currentAlbum'] = $album->getById($album_id);
		} else {
			$list['currentAlbum'] = '';
		}
		//*****************catia end***********************
		$list['noticesList'] = $buyselltrades->getNoticeById($nid,$ownertype);
		
		$list['categoryList'] = $buyselltrades->getCategories();
		$list['countryList'] = $buyselltrades->getCountries();
		$list['langList'] = $languages->getLanguages();
		$list['noticetype'] = $noticetype;
		$list['saletype'] = $saletype;
		$list['ownertype'] = $ownertype;
		$list['nid'] = $nid;
		$list['ownerid'] = ($player ? $player->ID_PLAYER : '');
		$oid=($player ? $player->ID_PLAYER : '');
		$list['committer'] = $buyselltrades->getownerinfo($oid,$ownertype);

		$list['headerName'] = $this->__('Update Notice');

		$data['title'] = $this->__('buyselltrade');
		$data['body_class'] = 'index_groups';
		$data['selected_menu'] = 'buyselltrade';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('buyselltrade/updateNotices', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}
	
	
	public function update_change_notice() {
	//	$this->moduleOff();
		$player = User::getUser();//catia
		$buyselltrades = new Buyselltrade();
		if (isset($this->params['nid'])) {
			$noticeid = $this->params['nid'];
		}
		if (isset($this->params['status'])) {
			$statusid = $this->params['status'];
		}
		if (isset($this->params['owner'])) {
			$owner = $this->params['owner'];
		}
		if (isset($this->params['notice'])) {
			$notice = $this->params['notice'];
		}
		//*******catia*********
		
		$notice = $_POST['nid'];
		$ownertype = $_POST['owntype']; 
		$button = $_POST['button_category'];
		if ($_POST['button_images']=='1') {
			$idAlbum = $_POST['id'];
			$noticeid = $_POST['nid'];
			$album = new Album;
			if ($idAlbum == 0) {
				$idAlbum = $buyselltrades->create($player, $_POST);
				//$idAlbum = '37';
				//die($idAlbum.'sdfgthsh');
				//$responseID = $buyselltrades->updateNotice_album($album_id,$noticeid);
				//die($idAlbum);
				header('Location: '.MainHelper::site_url(BUYSELLTRADE_NOTICES.'/update_notices/'.$noticeid.'/player'));
				
				exit;
			}
			else {
				$album->update($idAlbum, $_POST);
			}
			header('Location: '.MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_MY_NOTICES));
			exit;
		} else {
		
			if ($button!='') {
				$responseID = $buyselltrades->saveCategory($_POST);
			} else {
				$responseID = $buyselltrades->updateNotice($_POST);
			}
		}
		//*******catia*********
		//$responseID = $buyselltrades->updateNotice($_POST);
		
	
		if($responseID > 0){

			$result['result'] = true;
			if ($button!='') {
				$link=MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_UPDATE_NOTICES.'/'.$notice.'/'.$ownertype);
				DooUriRouter::redirect($link);
			} else {
				$result['newUrl'] =  MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_MY_NOTICES);
			}
			setcookie('category', '', (time() + (3600 * 24 * 365)), "/");
			setcookie('country', '', (time() + (3600 * 24 * 365)), "/");
			
			$this->index();
		}
		else{
			$result['result'] = false;
		}
	}
	
	public function view_notices_responses() {
		//$this->moduleOff();
		
		$buyselltrades = new Buyselltrade();
		$list = array();
		$player = User::getUser();

		if (isset($this->params['ownertype'])) {
			$ownertype = $this->params['ownertype'];

		} else {
			$ownertype = '';
		}
		if (isset($this->params['nid'])) {
			$nid = $this->params['nid'];
		} else {
			$nid = '';
		}
			if (isset($this->params['noticetype'])) {
			$noticetype = $this->params['noticetype'];

		} else {  
			$noticetype = '';
		}
		if (isset($this->params['saletype'])) {
			$saletype = $this->params['saletype'];
		} else {
			$saletype = '';
		}
		$list['noticeList'] = $buyselltrades->getNoticeById($nid,$ownertype);
		$list['ownertype'] = $ownertype;
		$list['noticetype'] = $noticetype;
		$list['saletype'] = $saletype;
		$list['nid'] = $nid;
		$list['ownerid'] = ($player ? $player->ID_PLAYER : '');
		$oid=($player ? $player->ID_PLAYER : '');
		$list['committer'] = $buyselltrades->getownerinfo($oid,$ownertype);

		$list['headerName'] = $this->__('OverView');

		$data['title'] = $this->__('buyselltrade');
		$data['body_class'] = 'index_groups';
		$data['selected_menu'] = 'buyselltrade';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('buyselltrade/viewNoticesResponses', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}
	
	//buy with credits
	
	//buycredits tab
	
	public function buyCredits() {
		//$this->moduleOff();

		$list['headerName'] = $this->__('Buy Credits');

		$data['title'] = $this->__('Buy Credits');
		$data['body_class'] = 'index_groups';
		$data['selected_menu'] = 'buyselltrade';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('buyselltrade/buyCredits', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}
	
     //Transactions transactions history tab

	public function transactions() {
		//$this->moduleOff();
		$buyselltrades = new Buyselltrade();
		$list = array();
		$player = User::getUser();

		
		$list['infoBox'] = MainHelper::loadInfoBox('Buyselltrade', 'transactions', true);
         $limit = '';
		$transactionsTotal = $buyselltrades->getMyTransactionsTotal(($player ? $player->ID_PLAYER : ''));
		$list['transactionsList'] = $buyselltrades->getMyTransactions(($player ? $player->ID_PLAYER : ''),$limit);
		// $pager = $this->appendPagination($list, $buyselltrades, $transactionsTotal, MainHelper::site_url('buyselltrade/transactions/page'), 
		//Doo::conf()->transactionsLimit);
		
		
		//$list['transactionsList'] = $buyselltrades->getMyTransactions($pager->limit);
		$list['type'] = BUYSELLTRADE_TRANSACTIONS;
		$data['title'] = $this->__('Transactions');
		$data['body_class'] = 'index_groups';
		$data['selected_menu'] = 'buyselltrade';
		$list['ownertype'] = 'player';
		$oid=($player ? $player->ID_PLAYER : '');
		$list['committer'] = $buyselltrades->getownerinfo($oid='',$ownertype='');
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('buyselltrade/transactions', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}
	
	
	
	
	public function save_transaction() {
		//$this->moduleOff();
		
		$buyselltrades = new Buyselltrade();	
		$button = $_POST['save_transaction'];
		if ($button!='') {
			
			$transactionID = $buyselltrades->saveTransaction($_POST);

		 $buyerID = $buyselltrades->updateBuyerCredits($_POST);
		 $sellerID = $buyselltrades->updateSellerCredits($_POST);

		}
		
		
		if($transactionID > 0){
			$result['result'] = true;
			$result['newUrl'] =  MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_SUCCESS.'/'.$transactionID);
       
			setcookie('tid', '', (time() + (3600 * 24 * 365)), "/");
			
			$link=MainHelper::site_url(BUYSELLTRADE_NOTICES.'/'.BUYSELLTRADE_SUCCESS.'/'.$transactionID);
			DooUriRouter::redirect($link);
		}
		else{
			$result['result'] = false;
		}
	}
	

public function success() {
		//$this->moduleOff();
		
		$buyselltrades = new Buyselltrade();
		$languages = new Lang();
		$list = array();
		$player = User::getUser();
        
			if (isset($this->params['ownertype'])) {
			$ownertype = $this->params['ownertype'];

		} else {
			$ownertype = '';
			
		}
		
		
			if (isset($this->params['noticetype'])) {
			$noticetype = $this->params['noticetype'];

		} else {
			$noticetype = '';
			
		}
		
		
			if (isset($this->params['buyerid'])) {
			$buyerid = $this->params['buyerid'];

		} else {
			$buyerid = '';
			
		}
		
		
		if (isset($this->params['tid'])) {
			$tid = $this->params['tid'];
		} else {
			$tid = '';
		}
		
	
		$list['transactList'] = $buyselltrades->getTransactionById($tid);
		$list['tid'] = $tid;
		$list['buyerid'] = ($player ? $player->ID_PLAYER : '');
		$list['ownertype'] = $ownertype;
		$list['noticetype'] = $noticetype;
		$oid=($player ? $player->ID_PLAYER : '');
		$list['committer'] = $buyselltrades->getownerinfo($oid,$ownertype);
		$list['headerName'] = $this->__('Transaction Details');
		$data['title'] = $this->__('buyselltrade');
		$data['body_class'] = 'index_groups';
		$data['selected_menu'] = 'buyselltrade';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('buyselltrade/success', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
		
	}
	
	
	//payment page
	
	public function payments() {
		//$this->moduleOff();
		$buyerid=$_POST['buyerid'];
		$buyselltrades = new Buyselltrade();
		$languages = new Lang();
		
			if (isset($this->params['sellerid'])) {
			$sellerid = $this->params['sellerid'];

		} else {
			$sellerid = '';
			
		}
				
		$list = array();
		$player = User::getUser();
		$list['buyercredit'] = $buyselltrades->getBuyerCreditById($buyerid);
		$list['sellercredit'] = $buyselltrades->getSellerCreditById($sellerid);
		$list['credits'] =  $_POST['credits'];
		$list['headline'] = $_POST['headline'];
		$list['nid'] = $_POST['nid'];
		$list['rid'] = $_POST['rid'];
		$list['ownertype'] = $_POST['ownertype'];
		$list['noticetype'] = $_POST['noticetype'];
		$list['saletype'] = $_POST['saletype'];
		$list['buyerid'] = $buyerid;
		$list['sellerid'] = $sellerid;			
		$list['headerName'] = $this->__('Pay With Credits');
		$data['title'] = $this->__('buyselltrade');
		$data['body_class'] = 'index_groups';
		$data['selected_menu'] = 'buyselltrade';
		$data['left'] = PlayerHelper::playerLeftSide();
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('buyselltrade/payments', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
		
	}
	
	
	
}

?>
