<?php

class Cart {

	protected static $cart;

	/**
	 * @return singleton FiCarts 
	 */
	public static function getCart($create = false, &$player = null) {
		if ($player !== null or Auth::isUserLogged()) {
			if (self::$cart !== NULL)
				return self::$cart;

			if ($player === null) {
				$player = User::getUser();
			}

			$cart = new FiCarts();
			$cart->ID_PLAYER = $player->ID_PLAYER;
			$cart->purgeCache();
			$isCart = $cart->getOne();
			if ($isCart) {
				self::$cart = $isCart;
			} else {
				if ($create == true) {
					$cart->ID_CART = $cart->insert();
					self::$cart = $cart;
				} else {
					self::$cart = NULL;
				}
			}
		}
		return self::$cart;
	}

	/**
	 * Returns the number of free products inside the cart
	 * @param FiCarts $cart
	 * @return type 
	 */
	public static function getFreeProductsInCart() {
		$player = User::getUser();
		if ($player and $player->FreeGameLimit > 0) {
			$items = new FiCartProductRel;
			$cart = new FiCarts;
			$product = new FiProducts;

			$query = "SELECT 
					COUNT(1) as total
				FROM
					{$product->_table}
				INNER JOIN {$items->_table} ON {$items->_table}.ID_PRODUCT = {$product->_table}.ID_PRODUCT
				INNER JOIN {$cart->_table} ON {$cart->_table}.ID_CART = {$items->_table}.ID_CART
				WHERE {$cart->_table}.ID_PLAYER = ? AND {$product->_table}.isFeatured = 1";

			$rs = (object) Doo::db()->fetchRow($query, array($player->ID_PLAYER));
			return $rs->total;
		}

		return 0;
	}

	/**
	 * used to validate product prices after user logins and after product is removed so other
	 * product gets discount for free products if there is space and before showing full cart
	 */
	public static function validateCart(&$player = NULL) {
		if($player === NULL) {
			$player = User::getUser();
		};
		if($player && $player->FreeGameLimit > 0) {
			$cartObject = Cart::getCart(FALSE, $player);

			if($cartObject && $cartObject->Quantity > 0) {
				$freeProductsInsideCart = Cart::getFreeProductsInCart();

				$items = new FiCartProductRel();
				$cart = new FiCarts();
				$product = new FiProducts();
                $productTable = $product->_table;
                $cartTable = $cart->_table;
                $itemsTable = $items->_table;

				$query = "SELECT 
						{$itemsTable}.*,
						{$productTable}.isFeatured, {$productTable}.Price as ProductPrice,
						{$productTable}.isSpecialOffer, {$productTable}.SpecialPrice,
						{$productTable}.isSpecialPremOffer, {$productTable}.SpecialPremPrice
					FROM
						{$productTable}
					INNER JOIN {$itemsTable} ON {$itemsTable}.ID_PRODUCT = {$productTable}.ID_PRODUCT
					INNER JOIN {$cartTable} ON {$cartTable}.ID_CART = {$itemsTable}.ID_CART
					WHERE {$cartTable}.ID_PLAYER = {$player->ID_PLAYER}";

				$rs = Doo::db()->query($query);
				$list = $rs->fetchAll(PDO::FETCH_CLASS, 'FiCartProductRel');

				$totalFreeProducts = 0;
				$totalCartPrice = 0;
				$membership = new Membership();
				$currentMembership = $membership->getCurrentPackage($player->ID_PLAYER);

				if($list && count($list) > 0) {
					foreach($list as $item) {
						if($item->isFeatured == 1 && $totalFreeProducts < $player->FreeGameLimit) {
							$totalFreeProducts++;
							$item->TotalPrice = 0;
							$item->Discount = $item->ProductPrice;
						} else if($item->isSpecialPremOffer == 1 && $currentMembership !== FALSE) {
							$item->Discount = ($item->ProductPrice - $item->SpecialPremPrice) * $item->Quantity;
							$item->TotalPrice = $item->SpecialPremPrice * $item->Quantity;
						} else if($item->isSpecialOffer == 1) {
							$item->Discount = ($item->ProductPrice - $item->SpecialPrice) * $item->Quantity;
							$item->TotalPrice = $item->SpecialPrice * $item->Quantity;
						} else {
							$totalCartPrice += $item->ProductPrice;
							$item->TotalPrice = $item->ProductPrice;
							$item->Discount = 0;
						}
						$item->update(array(
							'fields' => 'Discount,TotalPrice',
							'param' => array($item->ID_CART, $item->ID_PRODUCT),
							'where' => 'ID_CART = ? AND ID_PRODUCT = ?',
						));
					}
					$cartObject->TotalPrice = $totalCartPrice;
					$cartObject->update();
				}
			}
		}
	}

	public function addToCart($params = array()) {
		extract($params);
		$cart = Cart::getCart(true);
		$qty = intval($qty);
		$productID = intval($id);
		if ($cart and $qty > 0 and $productID > 0) {
			$product = new FiProducts();
			$product->ID_PRODUCT = $productID;
			$product = $product->getOne();

			$cartItem = new FiCartProductRel();
			$cartItem->ID_CART = $cart->ID_CART;
			$cartItem->ID_PRODUCT = $productID;
			$cartItem->purgeCache();
			$item = $cartItem->getOne();

			if (!$item) {

				$freeProductsInsideCart = Cart::getFreeProductsInCart();

				$player = User::getUser();
				$freeGamesLimit = $player->FreeGameLimit;
				$membership = new Membership();
				$currentMembership = $membership->getCurrentPackage();

				$cartItem->ProductName = $product->ProductName;
				$cartItem->Quantity = $qty;
				$cartItem->UnitPrice = $product->Price;
				$cartItem->Discount = 0;
				$cartItem->TotalPrice = $product->Price * $qty;

				if ($freeProductsInsideCart < $freeGamesLimit and $product->isFeatured == 1) {
					$cartItem->Discount = $product->Price;
					$cartItem->TotalPrice = 0;
				} else if ($product->isSpecialPremOffer == 1 and $currentMembership !== FALSE) {
					$cartItem->Discount = ($product->Price - $product->SpecialPremPrice) * $qty;
					$cartItem->TotalPrice = $product->SpecialPremPrice * $qty;
				} else if ($product->isSpecialOffer == 1) {
					$cartItem->Discount = ($product->Price - $product->SpecialPrice) * $qty;
					$cartItem->TotalPrice = $product->SpecialPrice * $qty;
				}
				$cartItem->insert();

				$cart->Quantity = $cart->Quantity + $qty;
				$cart->TotalPrice = $cart->TotalPrice + $cartItem->TotalPrice;
				$cart->LastUpdatedTime = time();
				$cart->update();
			} else {
//				$cartItem->Quantity = $item->Quantity + $qty;
//				$cartItem->TotalPrice = $cartItem->Quantity * $product->Price;
//				$cartItem->update(array(
//					'fields' => 'Quantity,TotalPrice',
//					'where' => 'ID_CART = ? AND ID_PRODUCT = ?',
//					'param' => array($cart->ID_CART, $productID)
//				));
			}

			return $cart;
		}
		return false;
	}

	public function removeFromCart($params = array()) {
		extract($params);
		$cart = Cart::getCart();
		$productID = intval($id);

		if ($cart and $productID > 0) {
			$cartItem = new FiCartProductRel();
			$cartItem->ID_CART = $cart->ID_CART;
			$cartItem->ID_PRODUCT = $productID;
			$cartItem->purgeCache();
			$item = $cartItem->getOne();

			$cart->Quantity = max(0, $cart->Quantity - $item->Quantity);
			$cart->TotalPrice = max(0, $cart->TotalPrice - $item->TotalPrice);
			$cart->LastUpdatedTime = time();
			$cart->update();

			if ($item) {
				$item->delete();
			}

			Cart::validateCart();

			return $cart;
		}
		return false;
	}

	public function getFullCart() {
		$items = new FiCartProductRel;
		$cart = new FiCarts;
		$product = new FiProducts;
		$player = User::getUser();
		Cart::validateCart();
		$params['FiCartProductRel'] = array(
			'where' => "{$cart->_table}.ID_PLAYER = ?",
			'param' => array($player->ID_PLAYER),
			'joinType' => 'INNER',
			'match' => true,
			'asc' => "{$items->_table}.LastUpdatedTime"
		);

		$cart = Doo::db()->relateMany('FiCarts', array('FiCartProductRel'), $params);
		return $cart ? $cart[0] : null;
	}

	public static function getBriefCart() {
		$cart = Cart::getCart();
		if ($cart and $cart->Quantity > 0) {
			Cart::appendCartItems($cart);
			return $cart;
		} else {
			return false;
		}
	}

	public static function appendCartItems(FiCarts &$cart) {
		if ($cart) {
			$cartItems = Doo::db()->find('FiCartProductRel', array(
				'where' => 'ID_CART = ?',
				'param' => array($cart->ID_CART),
				'asc' => 'LastUpdatedTime'
					));
			$cart->FiCartProductRel = $cartItems;
		}
	}

	public static function creditToEur($credit = 0) {
		return $credit / 10;
	}

	public static function flushCart(FiCarts $cart) {
		Doo::db()->delete('FiCartProductRel', array(
			'where' => 'ID_CART = ?',
			'param' => array($cart->ID_CART)
		));
		$cart->delete();
	}

}