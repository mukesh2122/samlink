<?php

class ShopController extends SnController {

	public function moduleOff()
	{
		$notAvailable = MainHelper::TrySetModuleNotAvailableByTag('shop');
		if ($notAvailable)
		{
			$data['title'] = $this->__('Shop');
			$data['body_class'] = 'index_shop';
			$data['selected_menu'] = 'shop';
			$data['right'] = PlayerHelper::playerRightSide();
			$data['content'] = $notAvailable;
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();
			$this->render3Cols($data);
			exit;
		}
	}

	private function applyLeftSide(&$list, $selectedGenre = '') {
		$this->moduleOff();

		$shop = new Shop();
		$genre = isset($this->params['genre']) ? $this->params['genre'] : 'all-products';
		$genre = (isset($selectedGenre) and $selectedGenre != '') ? $selectedGenre : $genre;
		$genre = ContentHelper::handleContentInput(urldecode(htmlspecialchars($genre)));

		$list['genreList'] = $shop->getTypes();
		$genreID = 0;
		$genreTranslated = "";
		if($genre != 'all-products' and $genre != 'Free for premium members' and $genre != 'Special offers' and $genre != 'Special premium offers' and $genre != 'Regular' and count($list['genreList']) > 0)
		{
			foreach($list['genreList'] as $genreItem)
			{
				if($genreItem->ProductTypeName == $genre)
				{
					$genreID = $genreItem->ID_PRODUCTTYPE;
					$genreTranslated = $genreItem->NameTranslated;
					break;
				}
			}
		}
		elseif ($genre == 'Free for premium members')
		{
			$genreID = -1;
			$genreTranslated = $this->__('Free for premium members');
		}
		elseif ($genre == 'Special offers')
		{
			$genreID = -2;
			$genreTranslated = $this->__('Special offers');
		}
		elseif ($genre == 'Special premium offers')
		{
			$genreID = -3;
			$genreTranslated = $this->__('Special premium offers');
		}
		elseif ($genre == 'Regular')
		{
			$genreID = -4;
			$genreTranslated = $this->__('Regular');
		}
		$list['shop'] = $shop;
		$list['selectedGenre'] = $genre;
		$list['selectedGenreTranslated'] = $genreTranslated;
		$list['selectedGenreID'] = $genreID;
	}
	/**
	 * Main website
	 *
	 */
	public function index() {
		$this->moduleOff();

		$list = array();
		$shop = new Shop();
		$list['infoBox'] = MainHelper::loadInfoBox('Shop', 'index', true);
		$this->applyLeftSide($list);

		$productsTotal = $shop->getTotalProducts($list['selectedGenreID']);
		if (isset($this->params['sortType']))
		{
			$list['selectedSort'] = urldecode($this->params['sortType']);
			switch (urldecode($this->params['sortType']))
			{
				case 'Popularity':
					$sortBy = 'PurchaseCount';
					$order = 'desc';
					$list['selectedSortTranslated'] = $this->__('Popularity');
					break;
				case 'Date added':
					$sortBy = 'ID_PRODUCT';
					$order = 'asc';
					$list['selectedSortTranslated'] = $this->__('Date added');
					break;
				case 'Alphabetically':
					$sortBy = 'ProductName';
					$order = 'asc';
					$list['selectedSortTranslated'] = $this->__('Alphabetically');
					break;
				case 'Price low to high':
					$sortBy = 'Price';
					$order = 'asc';
					$list['selectedSortTranslated'] = $this->__('Price low to high');
					break;
				case 'Price high to low':
					$sortBy = 'Price';
					$order = 'desc';
					$list['selectedSortTranslated'] = $this->__('Price high to low');
					break;
				case 'New products':
					$sortBy = 'ID_PRODUCT';
					$order = 'desc';
					$list['selectedSortTranslated'] = $this->__('New products');
					break;

				default:
					$sortBy = 'PurchaseCount';
					$order = 'desc';
					$list['selectedSortTranslated'] = $this->__('Popularity');
					break;
			}
			$pager = $this->appendPagination($list, $shop, $productsTotal, MainHelper::site_url('shop/'.urlencode($list['selectedGenre']).'/sort/'.urlencode($list['selectedSort']).'/page'), Doo::conf()->productsLimit);
			$list['listProducts'] = $shop->getProducts($pager->limit, $list['selectedGenreID'], $sortBy, $order);
		}
		else
		{
			$pager = $this->appendPagination($list, $shop, $productsTotal, MainHelper::site_url('shop/'.urlencode($list['selectedGenre']).'/page'), Doo::conf()->productsLimit);
			$list['listProducts'] = $shop->getProducts($pager->limit, $list['selectedGenreID']);
		}
		$list['type'] = SHOP_ALL;

		$data['title'] = $this->__('Shop');
		$data['body_class'] = 'index_shop';
		$data['selected_menu'] = 'shop';
		$data['left'] = $this->renderBlock('shop/common/leftColumn', $list);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('shop/index', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

    /**
     * Product view section
     *
     */
    public function ProductView()
    {
		$this->moduleOff();

		$shop = new Shop();
		$list = array();
		$product = $shop->getProductByID($this->params['product_id']);
		if(!$product)
		{
			DooUriRouter::redirect(MainHelper::site_url('shop/'));
		}

		$list['productHeader'] = $product->ProductName;
		$list['product'] = $product;
		$list['infotabs'] = $shop->getProductInfo($product->ID_PRODUCT, 'text');
		$list['activeTabInfo'] = !isset($this->params['infotab_id']) ? ($list['infotabs'] == NULL ? 0 : $list['infotabs'][0]->ID_PRODUCTINFO) : $this->params['infotab_id'];
		$mainImage = new FiProductInfo;
		$mainImage->ID_PRODUCTINFO = 0;
		$mainImage->ID_PRODUCT = $product->ID_PRODUCT;
		$mainImage->InfoType = 'image';
		$mainImage->ImageURL = $product->ImageURL;
		$list['imagetabs'] = $shop->getProductInfo($product->ID_PRODUCT, 'image');
		/* Add main image to list of images - disabled for now, might be reintroduced if we decide to create a fancy image viewer */
//		$list['imagetabs'][] = $mainImage;
//		sort($list['imagetabs']);
/*
		if (!isset($this->params['activeImage']) || $this->params['activeImage'] == 0)
		{
			$list['activeTabImage'] = 0;
			$list['mainImage'] = $product;
		}
		else
		{
			$list['activeTabImage'] = $this->params['activeImage'];
			$list['mainImage'] = $shop->getProductInfoByID($this->params['activeImage']);
		}
*/
		$list['mainImage'] = $product;
		$list['productType'] = $shop->getProductTypeByID($product->ID_PRODUCTTYPE);
		$membership = new Membership();
		$list['currentMembership'] = $membership->getCurrentPackage();

		$data['title'] = $product->ProductName;
		$data['body_class'] = 'product_view';
		$data['selected_menu'] = 'shop';
		$data['left'] = 'left';
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('shop/productView', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render2ColsRight($data);
    }

	/**
	 * searches products
	 *
	 */
	public function search() {
		$this->moduleOff();

		if (!isset($this->params['searchText'])) {
			DooUriRouter::redirect(Doo::conf()->APP_URL);
			return FALSE;
		}

		$shop = new Shop();
		$search = new Search();
		$list = array();
		$list['type'] = SHOP_ALL;
		$list['infoBox'] = MainHelper::loadInfoBox('Shop', 'index', true);
		$this->applyLeftSide($list);

		$productsTotal = $search->getSearchTotal(urldecode($this->params['searchText']), SEARCH_PRODUCT);
		$list['searchText'] = urldecode($this->params['searchText']);
		$pager = $this->appendPagination($list, $shop, $productsTotal, MainHelper::site_url('shop/search/' . urlencode($list['searchText']) . '/page'), Doo::conf()->productsLimit);
		$list['listProducts'] = $search->getSearch(urldecode($this->params['searchText']), SEARCH_PRODUCT, $pager->limit);

		$list['searchTotal'] = $productsTotal;

		$data['title'] = $this->__('Search results');
		$data['body_class'] = 'search_groups';
		$data['selected_menu'] = 'shop';
		$data['left'] = $this->renderBlock('shop/common/leftColumn', $list);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('shop/index', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function specialOffers() {
		$this->moduleOff();

		$list = array();
		$shop = new Shop();
		$list['infoBox'] = MainHelper::loadInfoBox('Shop', 'index', true);
		$list['listProducts'] = $shop->getProducts();
		$list['type'] = SHOP_SPECIAL;
		$this->applyLeftSide($list);

		$data['title'] = $this->__('Shop');
		$data['body_class'] = 'index_shop';
		$data['selected_menu'] = 'shop';
		$data['left'] = $this->renderBlock('shop/common/leftColumn', $list);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('shop/index', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function buyCredits() {
		$this->moduleOff();

		$list = array();
		$shop = new Shop();
		$list['infoBox'] = MainHelper::loadInfoBox('Shop', 'buyCredits', true);
		$list['rates'] = $shop->getExchangeRates();
		$list['type'] = SHOP_BUYCREDITS;
		$this->applyLeftSide($list);

		$data['title'] = $this->__('Buy Credits');
		$data['body_class'] = 'index_shop';
		$data['selected_menu'] = 'shop';

		$isEnabledShop = MainHelper::IsModuleEnabledByTag('shop');
		$isEnabledMemberships = MainHelper::IsModuleEnabledByTag('memberships');
		if ($isEnabledShop==0 && $isEnabledMemberships==1)
			$data['left'] = PlayerHelper::playerLeftSide();
		else
			$data['left'] = $this->renderBlock('shop/common/leftColumn', $list);

		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('shop/buyCredits', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function history() {
		$this->moduleOff();

		$list = array();
		$order = new Order();
		$list['infoBox'] = MainHelper::loadInfoBox('Shop', 'history', true);

		$ordersTotal = $order->getTotalOrders();
		$pager = $this->appendPagination($list, $order, $ordersTotal, MainHelper::site_url('shop/history/page'), Doo::conf()->ordersLimit);
		$list['listOrders'] = $order->getPlayerOrders($pager->limit);
		$list['type'] = SHOP_HISTORY;
		$this->applyLeftSide($list);

		$data['title'] = $this->__('Orders History');
		$data['body_class'] = 'index_shop';
		$data['selected_menu'] = 'shop';
		$data['left'] = $this->renderBlock('shop/common/leftColumn', $list);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('shop/history', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function downloadFile() {
		$list = array();
		$order = new Order();
		$item = $order->getDownloadFile($this->params['order_id'], $this->params['file']);
		if(!$item) {
			DooUriRouter::redirect(MainHelper::site_url('shop/history/'.$this->params['order_id']));
			return FALSE;
		}

		$file = Doo::conf()->SITE_PATH.'global/downloads/'.$item->DownloadURL;
		if (file_exists($file)) {
			header('Content-Description: File Transfer');
			header('Content-Type: '.mime_content_type($file));
			header('Content-Disposition: attachment; filename= "'.$item->DownloadURL.'"');
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			ob_clean();
			flush();
			readfile($file);
		}
		exit;
	}

	public function orderView() {
		$this->moduleOff();

		$list = array();
		$order = new Order();
		$item = $order->getOrder($this->params['order_id']);
		if(!$item) {
			DooUriRouter::redirect(MainHelper::site_url('shop'));
			return FALSE;
		}
		$list['infoBox'] = MainHelper::loadInfoBox('Shop', 'history', true);
		$list['order'] = $item;
		$this->applyLeftSide($list);

		$data['title'] = $this->__('Order View');
		$data['body_class'] = 'index_shop';
		$data['selected_menu'] = 'shop';
		$data['left'] = $this->renderBlock('shop/common/leftColumn', $list);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('shop/orderView', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function membership() {
		$this->moduleOff();

		$list = array();
		$membership = new Membership();
		$list['type'] = SHOP_MEMBERSHIP;
		$list['infoBox'] = MainHelper::loadInfoBox('Shop', 'membership', true);
		$list['featuresTable'] = $membership->getMembershipTable();
		$list['membershipPrices'] = $membership->getMembershipPrices();
		$this->applyLeftSide($list, 'Playnation memberships');

		$data['title'] = $this->__('Memberships');
		$data['body_class'] = 'index_shop';
		$data['selected_menu'] = 'shop';

		$isEnabledShop = MainHelper::IsModuleEnabledByTag('shop');
		$isEnabledMemberships = MainHelper::IsModuleEnabledByTag('memberships');
		if ($isEnabledShop==0 && $isEnabledMemberships==1)
			$data['left'] = PlayerHelper::playerLeftSide();
		else
			$data['left'] = $this->renderBlock('shop/common/leftColumn', $list);

		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('shop/membershipUpgrades', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function features() {
		$this->moduleOff();

		$list = array();
		$membership = new Membership();
		$list['individualUpgrades'] = $membership->getIntividualUpgrades();
		$this->applyLeftSide($list, 'Playnation features');

		$data['title'] = $this->__('Playnation features');
		$data['body_class'] = 'index_shop';
		$data['selected_menu'] = 'shop';
		$data['left'] = $this->renderBlock('shop/common/leftColumn', $list);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('shop/individualFeatures', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	/**
	 * Updates product info
	 */
	public function updateProduct() {
		$p = User::getUser();
		if ($this->isAjax() and $p) {
			$shop = new Shop();
			$product = $shop->getProductByID($_POST['product_id']);
			if (isset($product) and $p->canAccess('Edit Product')) {
				$result['result'] = $product->updateProduct($product, $_POST);
				$this->toJSON($result, true);
			}
		}
	}

	public function buyMembershipPackage() {
		$this->moduleOff();

		if(!isset($this->params['pack_id']) and intval($this->params['pack_id']) > 0) {
			return;
		}

		$list = array();
		$membership = new Membership();
		$neededPackage = $membership->getPackageById(intval($this->params['pack_id']));
		if(!$neededPackage) {
			return;
		}
		$currentPackageRel = $membership->getCurrentPackage();
		$currentQueueRel = $membership->getQueue();
		$packagePrice = $membership->calculatePackagePrice($neededPackage, $currentPackageRel);
		$list['currentPackage'] = $currentPackageRel !== FALSE ? $membership->getPackageById($currentPackageRel->ID_PACKAGE) : FALSE;
		$list['currentPackageRel'] = $currentPackageRel;
		$list['currentQueueRel'] = $currentQueueRel;
		$list['currentQueue'] = $currentQueueRel !== FALSE ? $membership->getPackageById($currentQueueRel->ID_PACKAGE) : FALSE;
		$list['neededPackage'] = $neededPackage;
		$list['neededPackagePrice'] = $packagePrice;
		echo $this->renderBlock('shop/buyMembership', $list);
	}

	public function buyMembershipFeature() {
		$this->moduleOff();

		if(!isset($this->params['pack_id']) and intval($this->params['pack_id']) > 0) {
			return;
		}

		$list = array();
		$membership = new Membership();
		$neededPackage = $membership->getPackageById(intval($this->params['pack_id']));
		if(!$neededPackage) {
			return;
		}
		$neededPackage = current($neededPackage->relate('FiPackageFeatureRel'));
		$neededPackageRel = null;

		if(isset($neededPackage->FiPackageFeatureRel)) {
			$neededPackageRel = current($neededPackage->FiPackageFeatureRel);
		}
		$currentPackageRel = $membership->getCurrentFeature($neededPackage);
		$list['neededPackage'] = $neededPackage;
		$list['neededPackageRel'] = $neededPackageRel;
		$list['isCurrentPackage'] = $currentPackageRel !== FALSE;
		$list['currentPackageRel'] = $currentPackageRel;
		echo $this->renderBlock('shop/buyFeature', $list);
	}

	public function ajaxConfirmMembershipPackage() {
		if($this->isAjax() and MainHelper::validatePostFields(array('id'))) {
			$id = intval($_POST['id']);
			$membership = new Membership();
			$neededPackage = $membership->getPackageById($id);
			if(!$neededPackage) {
				return;
			}
			$result['result'] = false;

			$playerPackageRel = $membership->getCurrentPackage();
			$price = $membership->calculatePackagePrice($neededPackage, $playerPackageRel);
			$buyPackage = $membership->buyPackage($neededPackage);

			if($buyPackage instanceof FiPackages) {
				$neededPackage = current($neededPackage->relate('FiPackageFeatureRel'));

				$order = new Order();
				$orderResult = $order->createMembershipOrder($buyPackage, $price);
				$_SESSION['order'] = $orderResult->ID_ORDER;
				$_SESSION['orderType'] = PACKAGE;
				$_SESSION['package'] = serialize($neededPackage);
				$_SESSION['playerPackageRel'] = serialize($playerPackageRel);
				$_SESSION['boughtPackage'] = serialize($buyPackage);
				$processingOrder = $order->addOrderStatus($orderResult->ID_ORDER, ORDER_PROCESSING);
				$closedOrder = $order->addOrderStatus($orderResult->ID_ORDER, ORDER_CLOSED);

				$result['result'] = true;
			} else if($buyPackage === TRUE) {
				//was downgrade
				$_SESSION['order'] = 0;
				$_SESSION['orderType'] = PACKAGE;
				$_SESSION['package'] = serialize($neededPackage);
				$_SESSION['playerPackageRel'] = serialize($playerPackageRel);
				$_SESSION['boughtPackage'] = serialize($buyPackage);

				$result['result'] = true;
			} else {
				//something bad happened
				$result['result'] = false;
			}

			$this->toJSON($result, true);
		}
	}

	public function cart() {
		$this->moduleOff();

		$list = array();
		$cart = new Cart();
		$list['infoBox'] = MainHelper::loadInfoBox('Shop', 'cart', true);
		$list['cart'] = $cart->getFullCart();
		$list['player'] = User::getUser();
		$this->applyLeftSide($list);

		$data['title'] = $this->__('Shopping Cart');
		$data['body_class'] = 'index_shop';
		$data['selected_menu'] = 'shop';
		$data['left'] = $this->renderBlock('shop/common/leftColumn', $list);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('shop/cart', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function cancel() {
		$this->moduleOff();

		$list = array();
		$payment = new Payment();

		$player = User::getUser();
		$playerCheck = User::getFriend($this->params['player_url']);

		if ($player and $playerCheck and $player->ID_PLAYER == $playerCheck->ID_PLAYER and !$payment->isHash($this->params['hash'], 'Canceled by Player')) {
			$payment->recordPaypalCancel($this->params['hash']);
			$this->applyLeftSide($list);
			$data['title'] = $this->__('Cancel Payment');
			$data['body_class'] = 'index_shop';
			$data['selected_menu'] = 'shop';
			$data['left'] = $this->renderBlock('shop/common/leftColumn', $list);
			$data['right'] = PlayerHelper::playerRightSide();
			$data['content'] = $this->renderBlock('shop/cancel', $list);
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();
			$this->render3Cols($data);
		} else {
			DooUriRouter::redirect(MainHelper::site_url('shop'));
			return FALSE;
		}
	}

	public function thankYou() {
		$this->moduleOff();

		$list = array();
		$payment = new Payment();

		$player = User::getUser();
		$playerCheck = User::getFriend($this->params['player_url']);

		if ($player and $playerCheck and $player->ID_PLAYER == $playerCheck->ID_PLAYER and !$payment->isHash($this->params['hash'])) {
			$payment->recordPaypalPayment($this->params['hash']);
			$this->applyLeftSide($list);

			$list['paymentComplete'] = 1;
			$data['title'] = $this->__('Successful Payment');
			$data['body_class'] = 'index_shop';
			$data['selected_menu'] = 'shop';
			$data['left'] = $this->renderBlock('shop/common/leftColumn', $list);
			$data['right'] = PlayerHelper::playerRightSide();
			$data['content'] = $this->renderBlock('shop/success', $list);
			$data['footer'] = MainHelper::bottomMenu();
			$data['header'] = MainHelper::topMenu();
			$this->render3Cols($data);
		} else {
			DooUriRouter::redirect(MainHelper::site_url('shop'));
			return FALSE;
		}
	}

	public function orderComplete() {
		$this->moduleOff();

		$list = array();
		$order = new Order();
		if (!isset($_SESSION['orderType'])) {
			DooUriRouter::redirect(MainHelper::site_url('shop/history'));
			return FALSE;
		}
		$orderID = intval($_SESSION['order']);
//		unset($_SESSION['order']);

		$list['membership'] = null;
		$list['orderType'] = $_SESSION['orderType'];
		$list['order'] = $order->getOrder($orderID);

		if($_SESSION['orderType'] == PACKAGE) {
			$list['package'] = unserialize($_SESSION['package']);
			$list['playerPackageRel'] = unserialize($_SESSION['playerPackageRel']);
			$list['boughtPackage'] = unserialize($_SESSION['boughtPackage']);
			$list['currentPackage'] = null;
			if($list['playerPackageRel']) {
				$list['currentPackage'] = Membership::getPackageById($list['playerPackageRel']->ID_PACKAGE);
			}

			unset($_SESSION['orderType']);
			unset($_SESSION['package']);
			unset($_SESSION['playerPackageRel']);
			unset($_SESSION['boughtPackage']);
		}
		$this->applyLeftSide($list);

		$data['title'] = $this->__('Order Complete');
		$data['body_class'] = 'index_shop';
		$data['selected_menu'] = 'shop';

		$data['left'] = $this->renderBlock('shop/common/leftColumn', $list);
		$data['right'] = PlayerHelper::playerRightSide();
		$data['content'] = $this->renderBlock('shop/success', $list);
		$data['footer'] = MainHelper::bottomMenu();
		$data['header'] = MainHelper::topMenu();
		$this->render3Cols($data);
	}

	public function acceptIpn() {
		if (!empty($_POST)) {
			$payment = new Payment();
			$payment->validateIPN($_POST);
		}
	}

	public function acceptXsolla() {
		if (!empty($_GET)) {
			$payment = new Payment();
			$payment->validateXsolla($_GET);
		}
	}

	public function ajaxProductView() {
		$id = $this->params['product_id'];
		$infoId = $this->params['activeImage'];
		$shop = new Shop();
		if (intval($infoId) > 0)
			$product = $shop->getProductInfoByID($infoId);
		else
			$product = $shop->getProductByID($id);
		$list['image'] = $this->renderBlock('shop/viewImage', array('product' => $product));
		echo $list['image'];
	}

	public function ajaxMakeRequest() {
		if ($this->isAjax()) {
			$payment = new Payment();
			$result['result'] = false;
			$result['url'] = '';
			$result['params'] = '';

			$paymentMethods = array(PAYMENT_XSOLLA, PAYMENT_PAYPAL);
			if(isset($_POST['payment']) and in_array($_POST['payment'], $paymentMethods)) {
				$params = $payment->generatePaymentParams($_POST);
				if(!empty($params)) {
					$payment->recordPaypalRequest($params, $_POST['payment']);

					$result['result'] = true;
					$result['url'] = $payment->generatePaymentUrl($params, $_POST['payment']);
					$result['params'] = $params;
				}
			}
			$this->toJSON($result, true);
		}
	}

	public function ajaxAddToCart() {
		if ($this->isAjax() and MainHelper::validatePostFields(array('qty', 'id'))) {
			$player = User::getUser();
			if($player) {
				$cart = new Cart();
				$result['result'] = false;
				$result['content'] = '';
				$cartResult = $cart->addToCart($_POST);
				if ($cartResult) {
					$result['result'] = true;
					$result['content'] = $this->renderBlock('common/briefCart', array());
				}

				$this->toJSON($result, true);
			}
		}
	}

	public function ajaxRemoveFromCart() {
		if ($this->isAjax()) {
			$cart = new Cart();
			$result['result'] = false;
			$result['totalPrice'] = 0;
			$result['content'] = '';
			$cartResult = $cart->removeFromCart($_POST);

			if ($cartResult) {
				$fullCart = $cart->getFullCart();
				$result['result'] = true;
				if(!$fullCart) {
					$result['result'] = false;
				}

				$result['contentBrief'] = $this->renderBlock('common/briefCart', array());
				$result['contentFull'] = $this->renderBlock('shop/cartTable', array('cart' => $fullCart));
			}
			$this->toJSON($result, true);
		}
	}

	public function ajaxConfirmCart() {
		if ($this->isAjax()) {
			$order = new Order();
			$result['result'] = false;
			$result['error'] = '';
			$orderResult = null;
			try {
				$orderResult = $order->createOrder($_POST);
				$_SESSION['order'] = $orderResult->ID_ORDER;
				$_SESSION['orderType'] = PRODUCT;
				$processingOrder = $order->addOrderStatus($orderResult->ID_ORDER, ORDER_PROCESSING);
				$processingOrder = $order->addOrderStatus($orderResult->ID_ORDER, ORDER_CLOSED);
			} catch (Exception $e) {
				$result['error'] = $e->getMessage();
			}
			if ($orderResult) {
				$result['result'] = true;
			}
			$this->toJSON($result, true);
		}
	}

	public function ajaxMembershipFeatureExpiration() {
		if ($this->isAjax()) {
			echo $this->renderBlock('shop/membersipFeatureExpiration', array('type' => $this->params['type']));
		}
	}

	public function ajaxConvertPD() {
		$user = User::getUser();
		if ($this->isAjax() and $user and MainHelper::validatePostFields(array('pd')) and PlayerHelper::isDigits($_POST['pd'])) {
			$pd = intval($_POST['pd']);

			if($pd > 0 and $pd <= $user->Credits){
				$addPlay = $pd * 10;
				$removeCredits = $pd;

				$user->Credits = $user->Credits - $removeCredits;
				$user->PlayCredits = $user->PlayCredits + $addPlay;

				$user->update();

				$result['result'] = true;
			}
			else{
				$result['result'] = false;
			}

			$this->toJSON($result, true);
		}
	}

	public function ajaxCancelQueue() {
		if($this->isAjax()) {
			$player = User::getUser();
			if($player) {
				$membership = new Membership();
				$result['result'] = $membership->cancelQueue($player);

				$this->toJSON($result, true);
			}
		}
	}

	/**
	 * Upload image
	 *
	 * @return JSON
	 */
	public function ajaxUploadPhoto() {
		$c = new Shop();
		if (!isset($this->params['product_id']))
			return false;

		$upload = $c->uploadPhoto(intval($this->params['product_id']));

		if ($upload['filename'] != '') {
			$file = MainHelper::showImage($upload['c'], THUMB_LIST_100x100, true, array('width', 'no_img' => 'noimage/no_shop_100x100.png'));
			echo $this->toJSON(array('success' => TRUE, 'img' => $file));
		} else {
			echo $this->toJSON(array('error' => $upload['error']));
		}
	}
}

?>
