<?php

class AdminShopController extends AdminController {

	/**
	 * Main website
	 *
	 */
	public function index() {
		$player = User::getUser();
		if($player->canAccess('Create Products') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$shop = new Shop();
		$list = array();

		$list['genreList'] = $shop->getTypes();
		$genreID = 0;
		if (isset($this->params['ProductTypeName']))
			foreach($list['genreList'] as $genreItem)
			{
				if($genreItem->ProductTypeName == $this->params['ProductTypeName'])
				{
					$genreID = $genreItem->ID_PRODUCTTYPE;
					break;
				}
			}
		$pager = $this->appendPagination($list, new stdClass(), $shop->getTotalProducts($genreID), MainHelper::site_url('admin/shop'.(isset($this->params['ProductTypeName']) ? ('/'.$this->params['ProductTypeName']) : '').'/page'), Doo::conf()->adminProductsLimit);
		$list['products'] = $shop->getProducts($pager->limit, $genreID, 'ID_PRODUCT', 'asc');
		$data['title'] = 'Shop - products';
		$data['body_class'] = 'index_products';
		$data['selected_menu'] = 'shop';
		$data['left'] =  $this->renderBlock('shop/common/leftColumn', $list);
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('shop/index', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	public function search() {
		if (!isset($this->params['searchText'])) {
			DooUriRouter::redirect(MainHelper::site_url('admin/shop'));
			return FALSE;
		}

		$shop = new Shop();
		$list = array();
		$player = User::getUser();
		if($player->canAccess('Create Products') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$list['searchText'] = urldecode($this->params['searchText']);

		$productsTotal = $shop->getSearchTotal(urldecode($this->params['searchText']));
		$pager = $this->appendPagination($list, $shop, $productsTotal, MainHelper::site_url('shop/search/'.urlencode($list['searchText']).'/page'), Doo::conf()->adminProductsLimit);
		$list['products'] = $shop->getSearch(urldecode($this->params['searchText']), $pager->limit);
		$list['searchTotal'] = $productsTotal;

		$data['title'] = $this->__('Search results');
		$data['body_class'] = 'search_products';
		$data['selected_menu'] = 'shop';
		$data['left'] =  $this->renderBlock('shop/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('shop/index', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	public function newProduct() {
		$player = User::getUser();
		if($player->canAccess('Create Products') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$shop = new Shop();
		$list = array();
		if(isset($_POST) and !empty($_POST)) {
			$product = $shop->createProduct($_POST);
			DooUriRouter::redirect(MainHelper::site_url('admin/shop/product/'.$product->ID_PRODUCT));
		}

		$list['genreList'] = $shop->getTypes();

		$data['title'] = 'New Product';
		$data['body_class'] = 'index_products';
		$data['selected_menu'] = 'shop';
		$data['left'] =  $this->renderBlock('shop/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('shop/product/new', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	public function editProduct() {
		$player = User::getUser();
		if($player->canAccess('Edit Products') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$shop = new Shop();
		$list = array();
		$product = $shop->getProductByID($this->params['product_id']);
		if(!$product) {
			DooUriRouter::redirect(MainHelper::site_url('admin/shop'));
		}
		if(isset($_POST) and !empty($_POST)) {
			$shop->updateProduct($product, $_POST);
			DooUriRouter::redirect(MainHelper::site_url('admin/shop/product/'.$product->ID_PRODUCT));
		}

		$list['genreList'] = $shop->getTypes();
		$list['product'] = $product;
		$list['infoTabs'] = $shop->getProductInfo($product->ID_PRODUCT, 'text');
		$list['imageList'] = $shop->getProductInfo($product->ID_PRODUCT, 'image');

		$data['title'] = 'Edit Product';
		$data['body_class'] = 'index_products';
		$data['selected_menu'] = 'shop';
		$data['left'] =  $this->renderBlock('shop/common/leftColumn', $list);
		$data['right'] = $this->renderBlock('shop/product/rightColumn', $list);
		$data['content'] = $this->renderBlock('shop/product/edit', $list);
//		$data['content'] = 'Editing options for <b>'.$product->ProductName.'</b> Comming soon to an admin module near you';
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	/* This function has not been made yet, it's intended use is the right column items under "Edit Product" */
	public function newProductInfo() {
		$player = User::getUser();
		if($player->canAccess('Create Products') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$shop = new Shop();
		$list = array();
		if(isset($_POST) and !empty($_POST)) {
			$product = $shop->createProduct($_POST);
			DooUriRouter::redirect(MainHelper::site_url('admin/shop/product/'.$product->ID_PRODUCT));
		}

		$list['genreList'] = $shop->getTypes();

		$data['title'] = 'New Product';
		$data['body_class'] = 'index_products';
		$data['selected_menu'] = 'shop';
		$data['left'] =  $this->renderBlock('shop/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = "Creating new '".$this->params['info_type']."' for product with id:".$this->params['product_id'];
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	/* This function has not been made yet, it's intended use is the right column items under "Edit Product" */
	public function editProductInfo() {
		$player = User::getUser();
		if($player->canAccess('Edit Products') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$shop = new Shop();
		$list = array();
		$product = $shop->getProductByID($this->params['product_id']);
		if(!$product) {
			DooUriRouter::redirect(MainHelper::site_url('admin/shop'));
		}
		if(isset($_POST) and !empty($_POST)) {
			$shop->updateProductInfo($product, $_POST);
			DooUriRouter::redirect(MainHelper::site_url('admin/shop/product/'.$product->ID_PRODUCT));
		}

		$list['genreList'] = $shop->getTypes();
		$list['product'] = $product;
		$list['infoTabs'] = $shop->getProductInfo($product->ID_PRODUCT, 'text');
		$list['imageList'] = $shop->getProductInfo($product->ID_PRODUCT, 'image');

		$data['title'] = 'Edit Product';
		$data['body_class'] = 'index_products';
		$data['selected_menu'] = 'shop';
		$data['left'] =  $this->renderBlock('shop/common/leftColumn', $list);
		$data['right'] = $this->renderBlock('shop/product/rightColumn', $list);
		$data['content'] = "Editing Info with id: ".$this->params['info_id']." of type '".$this->params['info_type']."' for product with id:".$this->params['product_id'];
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	public function indexMembership() {
		$player = User::getUser();
		if($player->canAccess('Create Packages') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$shop = new Shop();
		$list = array();

		$pager = $this->appendPagination($list, new stdClass(), $shop->getTotalPackages(), MainHelper::site_url('admin/shop'.(isset($this->params['PackageTypeName']) ? ('/'.$this->params['PackageTypeName']) : '').'/page'), Doo::conf()->adminProductsLimit);
		$list['packages'] = $shop->getPackages($pager->limit, 'ID_PACKAGE', 'asc');
		$data['title'] = 'Shop - packages';
		$data['body_class'] = 'index_packages';
		$data['selected_menu'] = 'shop';
		$data['left'] =  $this->renderBlock('shop/common/leftColumn', $list);
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('shop/memberships/index', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	public function newMembership() {
		$player = User::getUser();
		if($player->canAccess('Create Membership') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$shop = new Shop();
		$list = array();
		if(isset($_POST) and !empty($_POST)) {
			$package = $shop->createMembership($_POST);
			DooUriRouter::redirect(MainHelper::site_url('admin/shop/memberships/'.$package->ID_PACKAGE));
		}

		$data['title'] = 'New Membership';
		$data['body_class'] = 'index_packages';
		$data['selected_menu'] = 'shop';
		$data['left'] =  $this->renderBlock('shop/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('shop/memberships/new', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	public function editMembership() {
		$player = User::getUser();
		if($player->canAccess('Edit Membership') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$shop = new Shop();
		$list = array();
		$package = $shop->getPackageByID($this->params['package_id']);
		if(!$package) {
			DooUriRouter::redirect(MainHelper::site_url('admin/shop'));
		}
		if(isset($_POST) and !empty($_POST)) {
			$shop->updatePackage($package, $_POST);
			DooUriRouter::redirect(MainHelper::site_url('admin/shop/memberships/'.$package->ID_PACKAGE));
		}

		$list['package'] = $package;

		$data['title'] = 'Edit Membership';
		$data['body_class'] = 'index_packages';
		$data['selected_menu'] = 'shop';
		$data['left'] =  $this->renderBlock('shop/common/leftColumn', $list);
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('shop/memberships/edit', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	public function indexFeatures() {
		$player = User::getUser();
		if($player->canAccess('Show Membership Features') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$shop = new Shop();
		$list = array();

		$pager = $this->appendPagination($list, new stdClass(), $shop->getTotalFeatures(), MainHelper::site_url('admin/shop'.(isset($this->params['FeatureName']) ? ('/'.$this->params['FeatureName']) : '').'/page'), Doo::conf()->adminProductsLimit);
		$list['features'] = $shop->getFeatures($pager->limit, 'ID_FEATURE', 'asc');
		$data['title'] = 'Shop - Membership Features';
		$data['body_class'] = 'index_features';
		$data['selected_menu'] = 'shop';
		$data['left'] =  $this->renderBlock('shop/common/leftColumn', $list);
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('shop/features/index', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	public function newFeatures() {
		$player = User::getUser();
		if($player->canAccess('Create Feature') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$shop = new Shop();
		$list = array();
		if(isset($_POST) and !empty($_POST)) {
			$feature = $shop->createFeature($_POST);
			DooUriRouter::redirect(MainHelper::site_url('admin/shop/features/'.$feature->ID_FEATURE));
		}

		$data['title'] = 'New Feature';
		$data['body_class'] = 'index_features';
		$data['selected_menu'] = 'shop';
		$data['left'] =  $this->renderBlock('shop/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('shop/features/new', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	public function editFeatures() {
		$player = User::getUser();
		if($player->canAccess('Edit Features') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$shop = new Shop();
		$list = array();
		$feature = $shop->getFeaturesByID($this->params['features_id']);
		if(!$feature) {
			DooUriRouter::redirect(MainHelper::site_url('admin/shop'));
		}
		if(isset($_POST) and !empty($_POST)) {
			$shop->updateFeature($feature, $_POST);
			DooUriRouter::redirect(MainHelper::site_url('admin/shop/features/'.$feature->ID_FEATURE));
		}

		$list['feature'] = $feature;

		$data['title'] = 'Edit Features';
		$data['body_class'] = 'index_packages';
		$data['selected_menu'] = 'shop';
		$data['left'] =  $this->renderBlock('shop/common/leftColumn', $list);
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('shop/features/edit', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	public function indexCredit() {
		$player = User::getUser();
		if($player->canAccess('Show Credits Packs') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$shop = new Shop();
		$list = array();

		$pager = $this->appendPagination($list, new stdClass(), $shop->getTotalCredits(), MainHelper::site_url('admin/shop'.(isset($this->params['credits']) ? ('/'.$this->params['credits']) : '').'/page'), Doo::conf()->adminProductsLimit);
		$list['credits'] = $shop->getCredit($pager->limit, 'ID_EXCHANGE', 'asc');
		$data['title'] = 'Shop - Credits Package';
		$data['body_class'] = 'index_credit';
		$data['selected_menu'] = 'shop';
		$data['left'] =  $this->renderBlock('shop/common/leftColumn', $list);
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('shop/credit/index', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	public function newCredit() {
		$player = User::getUser();
		if($player->canAccess('Create Credit') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$shop = new Shop();
		$list = array();
		if(isset($_POST) and !empty($_POST)) {
			$credit = $shop->createCredit($_POST);
			DooUriRouter::redirect(MainHelper::site_url('admin/shop/rates/'.$credit->ID_EXCHANGE));
		}

		$data['title'] = 'New Credit';
		$data['body_class'] = 'index_credits';
		$data['selected_menu'] = 'shop';
		$data['left'] =  $this->renderBlock('shop/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('shop/credit/new', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	public function editCredit() {
		$player = User::getUser();
		if($player->canAccess('Edit Credits') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$shop = new Shop();
		$list = array();
		$credit = $shop->getCreditByID($this->params['credit_id']);
		if(!$credit) {
			DooUriRouter::redirect(MainHelper::site_url('admin/shop'));
		}
		if(isset($_POST) and !empty($_POST)) {
			$shop->updateCredit($credit, $_POST);
			DooUriRouter::redirect(MainHelper::site_url('admin/shop/rates/'.$credit->ID_EXCHANGE));
		}

		$list['credit'] = $credit;

		$data['title'] = 'Edit Credits';
		$data['body_class'] = 'index_credits';
		$data['selected_menu'] = 'shop';
		$data['left'] =  $this->renderBlock('shop/common/leftColumn', $list);
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('shop/credit/edit', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	public function indexType() {
		$player = User::getUser();
		if($player->canAccess('Show Product Types') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$shop = new Shop();
		$list = array();

		$pager = $this->appendPagination($list, new stdClass(), $shop->getTotalTypes(), MainHelper::site_url('admin/shop'.(isset($this->params['TypeName']) ? ('/'.$this->params['TypeName']) : '').'/page'), Doo::conf()->adminProductsLimit);
		$list['types'] = $shop->getTypes($pager->limit, 'ID_PRODUCTTYPE', 'asc');
		$data['title'] = 'Shop - Product Types';
		$data['body_class'] = 'index_types';
		$data['selected_menu'] = 'shop';
		$data['left'] =  $this->renderBlock('shop/common/leftColumn', $list);
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('shop/type/index', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	public function newType() {
		$player = User::getUser();
		if($player->canAccess('Create New Product Type') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}
		$shop = new Shop();
		$list = array();
		if(isset($_POST) and !empty($_POST)) {
			$type = $shop->createType($_POST);
			DooUriRouter::redirect(MainHelper::site_url('admin/shop/types/'.$type->ID_PRODUCTTYPE));
		}

		$data['title'] = 'New Product Type';
		$data['body_class'] = 'index_types';
		$data['selected_menu'] = 'shop';
		$data['left'] =  $this->renderBlock('shop/common/leftColumn');
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('shop/type/new', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}

	public function editType() {
		$player = User::getUser();
		if($player->canAccess('Edit Product Types') === FALSE) {
			DooUriRouter::redirect(MainHelper::site_url('admin'));
		}

		$shop = new Shop();
		$list = array();
		$type = $shop->getTypeByID($this->params['type_id']);
		if(!$type) {
			DooUriRouter::redirect(MainHelper::site_url('admin/shop'));
		}
		if(isset($_POST) and !empty($_POST)) {
			$shop->updateType($type, $_POST);
			DooUriRouter::redirect(MainHelper::site_url('admin/shop/types/'.$type->ID_PRODUCTTYPE));
		}

		$list['type'] = $type;

		$data['title'] = 'Edit Product Types';
		$data['body_class'] = 'index_typeds';
		$data['selected_menu'] = 'shop';
		$data['left'] =  $this->renderBlock('shop/common/leftColumn', $list);
		$data['right'] = 'right';
		$data['content'] = $this->renderBlock('shop/type/edit', $list);
		$data['header'] = $this->getMenu();
		$this->render3Cols($data);
	}
}
