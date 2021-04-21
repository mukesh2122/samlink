<?php

class Order {

	/**
	 * Creates new Order
	 * @uses DB triggers to update order QTY and statuses
	 * @param array $params
	 * @return FiOrders 
	 */
	public function createOrder($params = array()) {
		$cart = Cart::getCart();
		$player = User::getUser();

		if ($player and $cart and count($params) > 0) {
			Cart::validateCart();
			Cart::appendCartItems($cart);
			$productList = array();
			$finalPrice = 0;
			foreach ($cart->FiCartProductRel as $cartItem) {
					$product = new FiProducts();
					$product->ID_PRODUCT = $cartItem->ID_PRODUCT;
					$product = $product->getOne();
					
					if($product) {
						$finalPrice += $cartItem->Quantity * $product->Price;
						$product->Quantity = $cartItem->Quantity;
						$product->TotalPrice = $cartItem->TotalPrice;
						$product->Discount = $cartItem->Discount;
						$productList[] = $product;
					}
			}

			if ($finalPrice <= $player->Credits and $finalPrice > 0) {

				//check billing info
				$billingInfoCheck = array(
					'BillingFirstName' => 'billing_first_name',
					'BillingLastName' => 'billing_last_name',
					'BillingAddress' => 'billing_address',
					'BillingZip' => 'billing_post_code',
					'BillingCity' => 'billing_city',
					'BillingCountry' => 'billing_country'
				);

				$order = new FiOrders();
				$order->ID_PLAYER = $player->ID_PLAYER;
				$order->Status = ORDER_PENDING;
				$order->PlayerIP = $_SERVER['REMOTE_ADDR'];
				$order->TotalPrice = $cart->TotalPrice;
//				$order->ID_COUNTRY = ;
				$order->Quantity = $cart->Quantity;
				$order->GeoLocation = '';

				foreach ($billingInfoCheck as $key => $param) {
					if (isset($params[$param]) and trim($params[$param]) != "") {
						$order->{$key} = trim($params[$param]);
					} else {
						throw new Exception(ORDER_ERROR_VALIDATION);
						return;
					}
				}

				$orderID = $order->insert();
				$order->ID_ORDER = $orderID;

				$userParams = array(
					'firstname' => $order->BillingFirstName,
					'lastName' => $order->BillingLastName,
					'address' => $order->BillingAddress,
					'zip' => $order->BillingZip,
					'city' => $order->BillingCity
				);
				$player->updateProfile($userParams);

				$usedFreeGames = 0;
				foreach ($productList as $product) {
					$orderItem = new FiPurchases();
					$orderItem->ID_ORDER = $orderID;
					$orderItem->ID_PLAYER = $player->ID_PLAYER;
					$orderItem->ID_PRODUCT = $product->ID_PRODUCT;
					$orderItem->ProductName = $product->ProductName;
					$orderItem->ProductDesc = $product->ProductDesc;
					$orderItem->ProductType = PRODUCT;
					$orderItem->UnitPrice = $product->Price;
					$orderItem->Status = ORDER_PENDING;
					$orderItem->Quantity = $product->Quantity;
					$orderItem->Discount = $product->Discount;
					$orderItem->TotalPrice = $product->TotalPrice;
					if($product->isDownloadable) {
						$ext = explode(".",$product->DownloadURL);
						$orderItem->ProductType = DOWNLOADABLE;
						$orderItem->DownloadURL = md5(($orderID+$player->ID_PLAYER).''.$product->DownloadURL).'.'.end($ext);
					}
					$orderItem->insert();
					
					//free games management
					if($product->isFeatured == 1) {
						$usedFreeGames++;
					}
				}
				
				if($usedFreeGames > 0) {
					$player->updateProfile(array('freeGameLimit' => max(0, $player->FreeGameLimit - $usedFreeGames)));
				}

				Cart::flushCart($cart);

				return $order;
			} else {
				throw new Exception(ORDER_ERROR_CREDITS);
			}
		} else {
			throw new Exception(ORDER_ERROR_PERMISSION);
		}
	}

	/**
	 * @uses DB triggers to update order QTY and statuses
	 * @param FiPackages $package
	 * @param type $price
	 * @return FiOrders 
	 */
	public function createMembershipOrder(FiPackages &$package, $price) {
		$player = User::getUser();

		$order = new FiOrders();
		$order->ID_PLAYER = $player->ID_PLAYER;
		$order->Status = ORDER_PENDING;
		$order->PlayerIP = $_SERVER['REMOTE_ADDR'];
		$order->BillingFirstName = $player->FirstName;
		$order->BillingLastName = $player->LastName;
		$order->BillingAddress = $player->Address;
		$order->BillingZip = $player->Zip;
		$order->BillingCity = $player->City;
		$order->TotalPrice = $price->Price;
		$order->GeoLocation = '';
		$orderID = $order->insert();
		$order->ID_ORDER = $orderID;

		$orderItem = new FiPurchases();
		$orderItem->ID_ORDER = $orderID;
		$orderItem->ID_PLAYER = $player->ID_PLAYER;
		$orderItem->ID_PRODUCT = $package->ID_PACKAGE;
		$orderItem->ProductName = $package->NameTranslated;
		$orderItem->ProductDesc = $package->DescTranslated;
		$orderItem->ProductType = PACKAGE;
		$orderItem->UnitPrice = $package->Price;
		$orderItem->Status = ORDER_PENDING;
		$orderItem->Quantity = 1;
		$orderItem->Discount = $price->Discount;
		$orderItem->TotalPrice = $price->Price;
		$orderItem->insert();

		return $order;
	}

	/**
	 * @note triggers maintain times in order of specific status
	 * when changing status in purchases table
	 * @param type $status
	 * @param type $orderID
	 * @param type $params
	 * @return FiOrders 
	 */
	public function addOrderStatus($orderID, $status, $params = array()) {
		$originalOrderProducts = new FiPurchases();
		$originalOrderProducts->ID_ORDER = $orderID;
		$originalOrderProducts = $originalOrderProducts->find();
        
		if ($originalOrderProducts) {
			foreach ($originalOrderProducts as $item) {
                $player = User::getById($item->ID_PLAYER);

                $playerNickname = 'playnation'.$player->ID_PLAYER;
                $playerEmail = $player->EMail;
                $itemId = $item->ID_PRODUCT;

                if($itemId>='4'&&$itemId<='14'){
                    $reseller = new Reseller();     
                    $reseller->handleOrder($itemId , $playerNickname, $playerEmail);
                }
                    
				$item->Status = ContentHelper::handleContentInput($status);
				$item->update();
				if ($status == ORDER_PROCESSING and $item->ProductType == PACKAGE) {
					Referral::registerPayment($item);
					Membership::handlePurchasedFeature($item);
				}
			}
		}

		$order = new FiOrders();
		$order->ID_ORDER = $orderID;
		$order->purgeCache();
		$order = $order->getOne();

		if ($order) {
			if ($status == ORDER_PROCESSING) {
				$player = User::getById($order->ID_PLAYER);
				$player->updateProfile(array(
					'credits' => max(0, ($player->Credits - $order->TotalPrice))
				));
			}

			if ($status == ORDER_CLOSED) {
				$mail = new EmailNotifications();
				$mail->orderComplete($order);
			}
		}

		return $order;
	}

	/**
	 *
	 * @param int $orderID
	 * @param string $status
	 * @return FiOrders 
	 */
	public function getOrder($orderID = 0, $status = '') {
		$player = User::getUser();

		if ($player) {
			$order = new FiOrders();
			$order->ID_PLAYER = $player->ID_PLAYER;
			$order->ID_ORDER = $orderID;
			$order = $order->getOne();
			if ($order) {
				Order::appendOrderItems($order);
			}
			return $order;
		}
		return null;
	}
	
	/**
	 * Gets the product corresponding to specific users order
	 * @param type $orderID
	 * @param type $downloadURL
	 * @return FiProducts || null 
	 */
	public function getDownloadFile($orderID = 0, $downloadURL = "") {
		$player = User::getUser();

		if ($player) {
			$orderItem = new FiPurchases();
			$orderItem->ID_PLAYER = $player->ID_PLAYER;
			$orderItem->ID_ORDER = $orderID;
			$orderItem->DownloadURL = $downloadURL;
			$orderItem = $orderItem->getOne();
			if ($orderItem and (Doo::conf()->downloadLimit - $orderItem->DownloadAttempts) > 0) {
				$product = new FiProducts;
				$product->ID_PRODUCT = $orderItem->ID_PRODUCT;
				$product = $product->getOne();
				
				if($product) {
					$orderItem->DownloadAttempts = $orderItem->DownloadAttempts + 1;
					$orderItem->isDownloaded = 1;
					$orderItem->update();
					$orderItem->purgeCache();
					
					return $product;
				}
			}
			
		}
		return null;
	}

	public static function appendOrderItems(FiOrders &$order) {
		if ($order) {
			$orderItems = new FiPurchases();
			$orderItems->ID_ORDER = $order->ID_ORDER;
			$orderItems = $orderItems->find();
			$order->FiPurchases = $orderItems;
		}
	}

	public function getTotalOrders() {
		$player = User::getUser();

		if ($player) {
			$orders = new FiOrders();
			$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $orders->_table . '` 
											WHERE ID_PLAYER = ?
											LIMIT 1', array($player->ID_PLAYER));

			return $totalNum->cnt;
		}
		return 0;
	}

	public function getPlayerOrders($limit) {
		$player = User::getUser();

		if ($player) {
			$orders = Doo::db()->Find('FiOrders', array(
				'desc' => 'CreatedTime',
				'limit' => $limit,
				'where' => 'ID_PLAYER = ?',
				'param' => array($player->ID_PLAYER)
					));

			return $orders;
		}
		return null;
	}

}
