<?php

class Shop {

	public function getExchangeRates() {
		$rates = new FiExchangeRates();
		return $rates->find(array('asc' => 'Credits'));
	}

	/**
	 * Returns history of credits purchased by player
	 */
	public function getCreditsHistory() {
		$player = User::getUser();

		$payment = new FiPayments();
		$payment->ID_PLAYER = $player->ID_PLAYER;
		$payment->PaymentType = 'in';
		$payments = $payment->find(array('desc' => 'PaymentTime', 'where' => 'ID_TXN != ""'));

		return $payments;
	}

	/**
	 * Returns products
	 */
	public function getProducts($limit, $productTypeID = 0, $sortField = 'PurchaseCount', $order = 'desc')
	{
		$productTypeID = intval($productTypeID);
		$products = new FiProducts();
		$params['limit'] = $limit;
		if ($order == 'asc')
			$params['asc'] = $sortField;
		else
			$params['desc'] = $sortField;
		if($productTypeID > 0)
			$params['where'] = "{$products->_table}.ID_PRODUCTTYPE = $productTypeID ";
		elseif ($productTypeID == -1)
			$params['where'] = "{$products->_table}.isFeatured = 1 ";
		elseif ($productTypeID == -2)
			$params['where'] = "{$products->_table}.isSpecialOffer = 1 ";
		elseif ($productTypeID == -3)
			$params['where'] = "{$products->_table}.isSpecialPremOffer = 1 ";
		elseif ($productTypeID == -4)
			$params['where'] = "{$products->_table}.isFeatured = 0 AND {$products->_table}.isSpecialOffer = 0 AND {$products->_table}.isSpecialPremOffer = 0 ";
		$products = $products->find($params);

		return $products;
	}

	public function getPackages($limit, $sortField = 'PurchaseCount', $order = 'desc')
	{
		$packages = new FiPackages();
		$params['limit'] = $limit;
		if ($order == 'asc')
			$params['asc'] = $sortField;
		else
			$params['desc'] = $sortField;

		$packages = $packages->find($params);

		return $packages;
	}


	public function getFeatures($limit, $sortField = 'PurchaseCount', $order = 'desc')
	{
		$features = new FiFeatures();
		$params['limit'] = $limit;
		if ($order == 'asc')
			$params['asc'] = $sortField;
		else
			$params['desc'] = $sortField;

		$features = $features->find($params);

		return $features;
	}

	public function getCredit($limit, $sortField = 'PurchaseCount', $order = 'desc')
	{
		$credits = new FiExchangeRates();
		$params['limit'] = $limit;
		if ($order == 'asc')
			$params['asc'] = $sortField;
		else
			$params['desc'] = $sortField;

		$credits = $credits->find($params);

		return $credits;
	}

	public function getTotalProducts($productTypeID = 0)
	{
		$productTypeID = intval($productTypeID);
		$products = new FiProducts();
		$where = "";
		if($productTypeID > 0)
			$where = "WHERE {$products->_table}.ID_PRODUCTTYPE = $productTypeID ";
		elseif ($productTypeID == -1)
			$where = "WHERE {$products->_table}.isFeatured = 1 ";
		elseif ($productTypeID == -2)
			$where = "WHERE {$products->_table}.isSpecialOffer = 1 ";
		elseif ($productTypeID == -3)
			$where = "WHERE {$products->_table}.isSpecialPremOffer = 1 ";
		elseif ($productTypeID == -4)
			$where = "WHERE {$products->_table}.isFeatured = 0 AND {$products->_table}.isSpecialOffer = 0 AND {$products->_table}.isSpecialPremOffer = 0 ";
		$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $products->_table . '` '.$where.' LIMIT 1');
		return $totalNum->cnt;
	}

	public function getTotalCredits() {
		$credits = new FiExchangeRates();
		$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $credits->_table . '` LIMIT 1');
		return $totalNum->cnt;
	}

    /**
     * Returns product item
     *
     * @return fiProducts object
     */
    public static function getProductByID($id) {

        $item = Doo::db()->getOne('FiProducts', array(
            'limit' => 1,
            'where' => 'ID_PRODUCT = ?',
            'param' => array($id)
                ));
        return $item;
    }

    public function getProductInfo($id, $infotype) {
        if (intval($id) > 0) {
            $params = array();
            $params['asc'] = 'Priority';
            $params['where'] = "ID_PRODUCT = ? AND InfoType = ?";
            $params['param'] = array($id, $infotype);
            $tabs = Doo::db()->find('FiProductInfo', $params);
            return $tabs;
        }

        return array();
    }

    public static function getProductInfoByID($id) {

        $item = Doo::db()->getOne('FiProductInfo', array(
            'limit' => 1,
            'where' => 'ID_PRODUCTINFO = ?',
            'param' => array($id)
                ));
        return $item;
    }

    public function getSearchTotal($phrase) {
        if ($phrase and mb_strlen($phrase) >= 3) {
            $params = array();
            $params['limit'] = 1;
            $params['select'] = "COUNT(1) as cnt";
            $params['where'] = "ProductName Like ?";
            $params['param'] = array('%'.$phrase.'%');
            $search = Doo::db()->find('FiProducts', $params);
            return $search->cnt;
        }
        return 0;
    }

	public function getTotalPackages() {
		$packages = new FiPackages();
		$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $packages->_table . '` LIMIT 1');
		return $totalNum->cnt;
	}

	public function getTotalFeatures() {
		$features = new FiFeatures();
		$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $features->_table . '` LIMIT 1');
		return $totalNum->cnt;
	}

	public function getTotalTypes() {
		$types = new FiProductTypes();
		$totalNum = (object) Doo::db()->fetchRow('SELECT COUNT(1) as cnt FROM `' . $types->_table . '` LIMIT 1');
		return $totalNum->cnt;
	}

    /**
     * Returs search results
     *
     * @param String $phrase
     * @return collection of FiProducts
     */
    public function getSearch($phrase, $limit)
    {
        if ($phrase and mb_strlen($phrase) >= 3)
        {
            $products = new FiProducts();
            $query = "SELECT * FROM {$products->_table} WHERE ProductName LIKE ? ORDER BY ProductName ASC LIMIT $limit";
            $q = Doo::db()->query($query, array('%'.$phrase.'%'));
            $result = $q->fetchAll(PDO::FETCH_CLASS, 'FiProducts');

            return $result;
        }
        return array();
    }

	public function getPackageByID($id) {

        $item = Doo::db()->getOne('FiPackages', array(
            'limit' => 1,
            'where' => 'ID_PACKAGE = ?',
            'param' => array($id)
                ));
        return $item;

	}

	public function getCreditByID($id) {

        $item = Doo::db()->getOne('FiExchangeRates', array(
            'limit' => 1,
            'where' => 'ID_EXCHANGE = ?',
            'param' => array($id)
                ));
        return $item;

	}

	public function getFeaturesByID($id) {

        $item = Doo::db()->getOne('FiFeatures', array(
            'limit' => 1,
            'where' => 'ID_FEATURE = ?',
            'param' => array($id)
                ));
        return $item;

	}

	public function getTypeByID($id) {

        $item = Doo::db()->getOne('FiProductTypes', array(
            'limit' => 1,
            'where' => 'ID_PRODUCTTYPE = ?',
            'param' => array($id)
                ));
        return $item;

	}

	public function createProduct($post) {
		if (!empty($post)) {
			$product = new FiProducts();
			$product->ProductName = ContentHelper::handleContentInput($post['product_name']);
			$product->ID_PRODUCTTYPE = ContentHelper::handleContentInput($post['product_type']);
			$product->ProductType = '';
			$product->Price = ContentHelper::handleContentInput($post['price']);
			$product->isDownloadable = isset($post['is_downloadable']) ? 1 : 0;
			$product->DownloadURL = ContentHelper::handleContentInput($post['download_url']);
			$product->isSpecialOffer = isset($post['is_special_offer']) ? 1 : 0;
			if(isset($post['special_price']) && $post['special_price'] != '')
				$product->SpecialPrice = ContentHelper::handleContentInput($post['special_price']);
			$product->ProductDesc = $post['product_desc'];
			$product->ID_PRODUCT = $product->insert();

			return $product;
		}
		return false;
	}


	public function createMembership($post) {
		if (!empty($post)) {
			$package = new FiPackages();
			$package->PackageName = ContentHelper::handleContentInput($post['package_name']);
			$package->PackageType = ContentHelper::handleContentInput($post['PackageType']);
			$package->Duration = ContentHelper::handleContentInput($post['Duration']);
			$package->Price = ContentHelper::handleContentInput($post['Price']);
			$package->isMonthly = isset($post['isMonthly'])?1:0;
			$package->isMembership = isset($post['isMembership'])?1:0;
			$package->Position = ContentHelper::handleContentInput($post['Position']);
			$package->PackageDesc = $post['PackageDesc'];
			$package->ID_PACKAGE = $package->insert();

			return $package;
		}
		return false;
	}


	public function createFeature($post) {
		if (!empty($post)) {
			$feature = new FiFeatures();
			$feature->FeatureName = ContentHelper::handleContentInput($post['FeatureName']);
			$feature->FeatureDesc = $post['FeatureDesc'];
			$feature->Position = ContentHelper::handleContentInput($post['Position']);

			$feature->ID_FEATURE = $feature->insert();

			return $feature;
		}
		return false;
	}

	public function createCredit($post) {
		if (!empty($post)) {
			$credit = new FiExchangeRates();
			$credit->Credits = ContentHelper::handleContentInput($post['Credits']);
			$credit->Money = ContentHelper::handleContentInput($post['Money']);
			$credit->Currency = ContentHelper::handleContentInput($post['currency']);

			$credit->ID_EXCHANGE = $credit->insert();

			return $credit;
		}
		return false;
	}

	public function createType($post) {
		if (!empty($post)) {
			$type = new FiProductTypes();
			$type->ProductTypeName = ContentHelper::handleContentInput($post['ProductTypeName']);
			$type->ProductTypeDesc = '' /*ContentHelper::handleContentInput($post['ProductTypeDesc'])*/;

			$type->ID_PRODUCTTYPE = $type->insert();
			return $type;
		}
		return false;
	}

	public function updateProduct(FiProducts $product, $post) {
		if (!empty($post)) {
			$product->ProductName = ContentHelper::handleContentInput($post['product_name']);
			$product->ID_PRODUCTTYPE = ContentHelper::handleContentInput($post['product_type']);
			$product->Price = ContentHelper::handleContentInput($post['price']);
			$product->isDownloadable = isset($post['is_downloadable'])?1:0;
			$product->DownloadURL = ContentHelper::handleContentInput($post['download_url']);
			$product->isSpecialOffer = isset($post['is_special_offer'])?1:0;
			$product->SpecialPrice = ContentHelper::handleContentInput($post['special_price']);
			$product->ProductDesc = $post['product_desc'];
			if(isset($post['image_url']))
				$product->ImageURL = $post['image_url'];

			$product->update();
//			$this->updateCache($product);

			return true;
		}
		return false;
	}

	public function updatePackage(FiPackages $package, $post) {
		if (!empty($post)) {
			$package->PackageName = ContentHelper::handleContentInput($post['package_name']);
			$package->PackageDesc = $post['PackageDesc'];
			$package->PackageType = ContentHelper::handleContentInput($post['PackageType']);
			$package->Duration = ContentHelper::handleContentInput($post['Duration']);
			$package->Price = ContentHelper::handleContentInput($post['Price']);
			$package->FeatureCount = ContentHelper::handleContentInput($post['FeatureCount']);
			$package->isMonthly = isset($post['isMonthly'])?1:0;
			$package->isMembership = isset($post['isMembership'])?1:0;

			$package->update();
//			$this->updateCache($package);

			return true;
		}
		return false;
	}

	public function updateFeature(FiFeatures $feature, $post) {
		if (!empty($post)) {
			$feature->FeatureName = ContentHelper::handleContentInput($post['FeatureName']);
			$feature->FeatureDesc = $post['FeatureDesc'];
			$feature->Position = ContentHelper::handleContentInput($post['Position']);

			$feature->update();
//			$this->updateCache($package);

			return true;
		}
		return false;
	}

	public function updateCredit(FiExchangeRates $credit, $post) {
		if (!empty($post)) {
			$credit->Credits = ContentHelper::handleContentInput($post['Credits']);
			$credit->Money = ContentHelper::handleContentInput($post['Money']);
			$credit->Currency = ContentHelper::handleContentInput($post['currency']);

			$credit->update();

			return true;
		}
		return false;
	}

	public function updateType(FiProductTypes $type, $post) {
		if (!empty($post)) {
			$type->ProductTypeName = $post['ProductTypeName'];

			$type->update();
//			$this->updateCache($type);

			return true;
		}
		return false;
	}

	/**
	 * Upload handler
	 *
	 * @return array
	 */
	public function uploadPhoto($id) {
		$c = $this->getProductByID($id);

		if (User::canAccess("Edit product")) {
			$image = new Image();
			$result = $image->uploadImage(FOLDER_SHOP, $c->ImageURL);
			if ($result['filename'] != '') {
				$c->ImageURL = ContentHelper::handleContentInput($result['filename']);
				$c->update(array('field' => 'ImageURL'));
				$c->purgeCache();
				$result['c'] = $c;
			}
			return $result;
		}

	}

	/**
     * Returns product types
     *
     * @return unknown
     */
    public function getTypes() {
		$langID = Lang::getCurrentLangID();
		$type = new FiProductTypes;
		$typeLocale = new FiProductTypeLocale;

		$param = array($langID);
		$query = "SELECT {$type->_table}.*, {$typeLocale->_table}.ProductTypeName as TypeNameTranslated, {$typeLocale->_table}.ProductTypeDesc as TypeDescTranslated
					FROM {$type->_table}
					LEFT JOIN {$typeLocale->_table} ON {$type->_table}.ID_PRODUCTTYPE = {$typeLocale->_table}.ID_PRODUCTTYPE AND {$typeLocale->_table}.ID_LANGUAGE = ?
					ORDER BY TypeNameTranslated ASC";
//					ORDER BY {$type->_table}.ProductTypeName ASC";

		$q = Doo::db()->query($query, $param);
		$types = $q->fetchAll(PDO::FETCH_CLASS, 'FiProductTypes');

        return $types;
    }

    public static function getProductTypeByID($id) {
		$langID = Lang::getCurrentLangID();
		$type = new FiProductTypes;
		$typeLocale = new FiProductTypeLocale;

		$param = array($langID,$id);
		$query = "SELECT {$type->_table}.*, {$typeLocale->_table}.ProductTypeName as TypeNameTranslated, {$typeLocale->_table}.ProductTypeDesc as TypeDescTranslated
					FROM {$type->_table}
					LEFT JOIN {$typeLocale->_table} ON {$type->_table}.ID_PRODUCTTYPE = {$typeLocale->_table}.ID_PRODUCTTYPE AND {$typeLocale->_table}.ID_LANGUAGE = ?
					WHERE {$type->_table}.ID_PRODUCTTYPE = ?";
//					ORDER BY {$type->_table}.ProductTypeName ASC";

		$q = Doo::db()->query($query, $param);
		$item = $q->fetchAll(PDO::FETCH_CLASS, 'FiProductTypes');

/*        $item = Doo::db()->getOne('FiProductTypes', array(
            'limit' => 1,
            'where' => 'ID_PRODUCTTYPE = ?',
            'param' => array($id)
                ));
*/
        return $item[0];
    }

}

?>
