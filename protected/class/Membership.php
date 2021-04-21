<?php

class Membership {

	/**
	 * Forms list of Features and related Packages
	 * @return type FiFeatures
	 */
	public function getMembershipTable() {
		$packRel = new FiPackageFeatureRel;
		$pack = new FiPackages;
		$feature = new FiFeatures;
		$params['FiPackages'] = array(
			'select' => "{$pack->_table}.*, {$feature->_table}.*, {$packRel->_table}.SpecialType as SpecialType",
			'where' => "isMembership = 1 AND Duration = 12",
			'joinType' => 'INNER',
			'match' => true,
			'asc' => "{$feature->_table}.Position"
		);
		$features = Doo::db()->relateMany('FiFeatures', array('FiPackages'), $params);
		foreach ($features as &$f) {
			$cnt = count($f->FiPackages);
			for ($i = 0; $i < $cnt; $i++) {
				$f->FiPackages[$f->FiPackages[$i]->PackageType] = $f->FiPackages[$i];
				unset($f->FiPackages[$i]);
			}
		}
		return $features;
	}

	public function getMembershipPrices() {
		$pack = new FiPackages;
		$memberships = $pack->find(array(
			'select' => 'ID_PACKAGE, PackageType, Price, Duration',
			'where' => 'isMembership = 1 AND PackageType != ""',
			'asc' => 'Duration, Price'
				));

		$result = array();
		foreach ($memberships as &$membership) {
			$save = 0;
			if (isset($result[3][$membership->PackageType])) {
				$first = $result[3][$membership->PackageType];
				$monthPrice = $first->Price / $first->Duration; //lowest
				$currentMonthPrice = $membership->Price / $membership->Duration;
				$save = 100 - ($currentMonthPrice * 100 / $monthPrice);
			}

			$result[$membership->Duration][$membership->PackageType] = (object) array(
						'Price' => $membership->Price,
						'Duration' => $membership->Duration,
						'Save' => $save,
						'ID' => $membership->ID_PACKAGE,
			);
		}
		return $result;
	}

	public function getIntividualUpgrades() {
		$pack = new FiPackages;
		$params['FiFeatures'] = array(
			'where' => "isMembership = 0",
			'joinType' => 'INNER',
			'match' => true,
			'asc' => "{$pack->_table}.Position"
		);
		$packages = Doo::db()->relateMany('FiPackages', array('FiFeatures'), $params);
		return $packages;
	}

	public function getCurrentPackage($playerID = NULL) {
        $player = ($playerID === NULL) ? User::getUser()->ID_PLAYER : $playerID;
        if(!$player) { $result = FALSE; };
		$result = Doo::db()->find('FiPlayerPackageRel', array(
			'param' => array($player, time(), time()),
			'where' => 'ID_PLAYER = ? AND ActivationTime < ? AND ExpirationTime > ? AND PackageType != ""',
			'limit' => 1
			));		
        if(!$result) { $result = FALSE; };
		return $result;
	}

	public function getCurrentFeature(FiPackages &$package) {
		$player = User::getUser();
		$result = false;
		
		if($player) {
			$result = Doo::db()->find('FiPlayerPackageRel', array(
				'where' => 'ID_PLAYER = ? AND ActivationTime < ? AND ExpirationTime > ? AND PackageType = "" AND ID_PACKAGE = ?',
				'param' => array($player->ID_PLAYER, time(), time(), $package->ID_PACKAGE),
				'limit' => 1
				));
		}
		
		if(!$result)
			$result = FALSE;
			
		return $result;
	}

	public static function getPackageById($id) {
		$package = new FiPackages;
		$package->ID_PACKAGE = $id;
		$package = $package->getOne();
		return $package;
	}

	public static function calculatePackagePrice(FiPackages &$neededPackage, &$playerPackageRel = null) {
		/*
		 * Before a membership package is purchased, 
		 * check if there is an active membership with a "lower" rank, 
		 * subtrackt the number of full month between now and the ExpirationTime of that membership, 
		 * convert the months to credits using the purchase price and duration of the "old" package. 
		 * Subtract that value in the "Discount" field of the new purchase (the value is always negative) 
		 */
		$price = 0;
		$discount = 0;

		if ($playerPackageRel == null or $neededPackage->PackageType == "") {
			$price = $neededPackage->Price;
		} else {
			$currentPackage = Membership::getPackageById($playerPackageRel->ID_PACKAGE);
			if ($currentPackage->ID_PACKAGE === $neededPackage->ID_PACKAGE and $currentPackage->Duration === $neededPackage->Duration) {
				$price = $neededPackage->Price;
			} else {
				$daysLeft = (int) (($playerPackageRel->ExpirationTime - time()) / (60 * 60 * 24));
				$totalDays = (int) (($playerPackageRel->ExpirationTime - $playerPackageRel->ActivationTime) / (60 * 60 * 24));

				$discount = (int) (($currentPackage->Price / $totalDays) * $daysLeft);
				$price = $neededPackage->Price - $discount;
			}
		}

		return (object) array('Price' => $price, 'Discount' => $discount);
	}

	/**
	 * @noteThis logic is asociated with success page in orders
	 * @param FiPackages $package
	 * @return boolean || FiPackages
	 */
	public function buyPackage(FiPackages &$package) {
		$player = User::getUser();
		$activationTime = time();
		$packageResult = false;

		if (!$player) {
			return false;
		}
		
		//if feature
		if ($package->PackageType == "") {
			if ($player->Credits < $package->Price) {
				return false;
			}
			$packageResult = $this->manageFeature($package, $player, $activationTime);
			
		} else {
			$playerPackageRel = $this->getCurrentPackage();
			$price = self::calculatePackagePrice($package, $playerPackageRel);
			
			//if no existing membership
			if (!$playerPackageRel) {
				if ($player->Credits < $price->Price) {
					return false;
				}
			
				$packageResult = $this->insertMembership($package, $player, $activationTime);
			} else {
				$upgrade = self::getUpgradesByType();

				//same type
				if ($playerPackageRel->PackageType === $package->PackageType) {
					$currentPackage = $this->getPackageById($playerPackageRel->ID_PACKAGE);
					//upgrade
					if ($currentPackage->Duration === $package->Duration) {
						if ($player->Credits < $price->Price) {
							return false;
						}
			
						$packageResult = $this->extendMembership($playerPackageRel, $package, $player);
					} else {
						//same membership downgrade / upgrade, cuz we change only queue element
						$this->downgradeMembership($playerPackageRel, $package, $player);
						$packageResult = true;
					}
				} else if (in_array($package->PackageType, $upgrade[$playerPackageRel->PackageType])) {
					//upgrade
					if ($player->Credits < $price->Price) {
						return false;
					}
			
					$packageResult = $this->upgradeMembership($playerPackageRel, $package, $player);
				} else {
					//downgrade
					$this->downgradeMembership($playerPackageRel, $package, $player);
					$packageResult = true;
				}
			}
		}
		
		return $packageResult;
	}

	/**
	 * extends current membership
	 * @param FiPlayerPackageRel $currentPackageRel
	 * @param FiPackages $package
	 * @param Players $player
	 * @return FiPackages 
	 */
	private function extendMembership(FiPlayerPackageRel $currentPackageRel, FiPackages $package, &$player) {
		$this->cancelQueue($player);

		$expirationTime = $currentPackageRel->ExpirationTime;

		//extend existing membership
		$currentPackageRel->ExpirationTime = mktime(1, 1, 1, (date("m", $expirationTime) + $package->Duration), date("d", $expirationTime), date("Y", $expirationTime));
		$currentPackageRel->update(array(
			'field' => 'ExpirationTime',
			'where' => 'ID_PLAYER = ? AND ID_PACKAGE = ? AND Activationtime = ?',
			'param' => array($currentPackageRel->ID_PLAYER, $currentPackageRel->ID_PACKAGE, $currentPackageRel->ActivationTime)
		));

		//end up items for current membership
		$playerFeatureRel = new FiPlayerFeatureRel;
		$featureRel = $playerFeatureRel->find(array(
			'where' => 'ID_PACKAGE = ? AND ID_PLAYER = ?',
			'param' => array($currentPackageRel->ID_PACKAGE, $player->ID_PLAYER)
				));

		if ($featureRel) {
			foreach ($featureRel as $frel) {
				$frel->ExpirationTime = $currentPackageRel->ExpirationTime;
				$frel->update(array(
					'field' => 'ExpirationTime',
					'where' => 'ID_PLAYER = ? AND ID_PACKAGE = ? AND ID_FEATURE = ?',
					'param' => array($frel->ID_PLAYER, $frel->ID_PACKAGE, $frel->ID_FEATURE)
				));
			}
		}

		$this->createQueue($package, $player, $currentPackageRel->ExpirationTime);

		return $package;
	}

	/**
	 * Upgrades current membership
	 * @param FiPlayerPackageRel $currentPackageRel
	 * @param FiPackages $package
	 * @param Players $player
	 * @return FiPackages 
	 */
	private function downgradeMembership(FiPlayerPackageRel $currentPackageRel, FiPackages $package, &$player) {
		$this->cancelQueue($player);
		$this->createQueue($package, $player, $currentPackageRel->ExpirationTime);

		return TRUE;
	}

	/**
	 * Upgrades current membership
	 * @param FiPlayerPackageRel $currentPackageRel
	 * @param FiPackages $package
	 * @param Players $player
	 * @return FiPackages 
	 */
	private function upgradeMembership(FiPlayerPackageRel $currentPackageRel, FiPackages $package, &$player) {
		$this->cancelQueue($player);

		//end up existing membership
		$currentPackageRel->ExpirationTime = time();
		$currentPackageRel->update(array(
			'field' => 'ExpirationTime',
			'where' => 'ID_PLAYER = ? AND ID_PACKAGE = ? AND Activationtime = ?',
			'param' => array($currentPackageRel->ID_PLAYER, $currentPackageRel->ID_PACKAGE, $currentPackageRel->ActivationTime)
		));

		//end up items for current membership
		$playerFeatureRel = new FiPlayerFeatureRel;
		$featureRel = $playerFeatureRel->find(array(
			'where' => 'ID_PACKAGE = ? AND ID_PLAYER = ?',
			'param' => array($currentPackageRel->ID_PACKAGE, $player->ID_PLAYER)
				));

		if ($featureRel) {
			foreach ($featureRel as $frel) {
				$frel->ExpirationTime = $currentPackageRel->ExpirationTime;
				$frel->update(array(
					'field' => 'ExpirationTime',
					'where' => 'ID_PLAYER = ? AND ID_PACKAGE = ? AND ID_FEATURE = ?',
					'param' => array($frel->ID_PLAYER, $frel->ID_PACKAGE, $frel->ID_FEATURE)
				));
			}
		}

		$package = $this->insertMembership($package, $player, time());

		return $package;
	}

	/**
	 * Inserts first membership
	 * @param FiPackages $package
	 * @param Players $player
	 * @param int $activationTime
	 * @return FiPackages 
	 */
	private function insertMembership(FiPackages $package, &$player, $activationTime) {
		$package = current($package->relate('FiPackageFeatureRel'));
		$packageFeatures = (isset($package->FiPackageFeatureRel)) ? $package->FiPackageFeatureRel : array();

		$newPlayerPackRel = new FiPlayerPackageRel;
		$newPlayerPackRel->ID_PACKAGE = $package->ID_PACKAGE;
		$newPlayerPackRel->PackageType = $package->PackageType;
		$newPlayerPackRel->ID_PLAYER = $player->ID_PLAYER;
		$newPlayerPackRel->ActivationTime = $activationTime;
		$newPlayerPackRel->ExpirationTime = mktime(1, 1, 1, (date("m", $activationTime) + $package->Duration), date("d", $activationTime), date("Y", $activationTime));
		$newPlayerPackRel->insert();

		//add new items for membership
		if (!empty($packageFeatures)) {
			foreach ($packageFeatures as $feature) {
				$featureRel = new FiPlayerFeatureRel;
				$featureRel->ActivationTime = $newPlayerPackRel->ActivationTime;
				$featureRel->ExpirationTime = $newPlayerPackRel->ExpirationTime;
				$featureRel->ID_FEATURE = $feature->ID_FEATURE;
				$featureRel->ID_PACKAGE = $package->ID_PACKAGE;
				$featureRel->PackageType = $package->PackageType;
				$featureRel->ID_PLAYER = $player->ID_PLAYER;
				$featureRel->Quantity = $feature->Quantity;
				$featureRel->SpecialType = $feature->SpecialType;
				$featureRel->insert();
			}
		}

		$this->createQueue($package, $player, $newPlayerPackRel->ExpirationTime);

		return $package;
	}
	
	/**
	 * Inserts membership feature, but still it's a package with 1 feature assigned
	 * @param FiPackages $package
	 * @param Players $player
	 * @param int $activationTime
	 * @return FiPackages 
	 */
	private function manageFeature(FiPackages $package, &$player, $activationTime) {
		$package = current($package->relate('FiPackageFeatureRel'));
		$packageFeatures = (isset($package->FiPackageFeatureRel)) ? $package->FiPackageFeatureRel : array();

		$currentPackageRel = $this->getCurrentFeature($package);
		//no extension, need to insert
		if($currentPackageRel === FALSE) {
			$newPlayerPackRel = new FiPlayerPackageRel;
			$newPlayerPackRel->ID_PACKAGE = $package->ID_PACKAGE;
			$newPlayerPackRel->PackageType = $package->PackageType;
			$newPlayerPackRel->ID_PLAYER = $player->ID_PLAYER;
			$newPlayerPackRel->ActivationTime = $activationTime;
			$newPlayerPackRel->ExpirationTime = $package->Duration == 0 ? 0 : mktime(1, 1, 1, (date("m", $activationTime) + $package->Duration), date("d", $activationTime), date("Y", $activationTime));
			$newPlayerPackRel->insert();

			//add new items for membership
			if (!empty($packageFeatures)) {
				foreach ($packageFeatures as $feature) {
					$featureRel = new FiPlayerFeatureRel;
					$featureRel->ActivationTime = $newPlayerPackRel->ActivationTime;
					$featureRel->ExpirationTime = $newPlayerPackRel->ExpirationTime;
					$featureRel->ID_FEATURE = $feature->ID_FEATURE;
					$featureRel->ID_PACKAGE = $package->ID_PACKAGE;
					$featureRel->PackageType = $package->PackageType;
					$featureRel->ID_PLAYER = $player->ID_PLAYER;
					$featureRel->Quantity = $feature->Quantity;
					$featureRel->SpecialType = $feature->SpecialType;
					$featureRel->insert();
				}
			}
		} else {
			//extend existing
			$expirationTime = $currentPackageRel->ExpirationTime;

			//extend existing membership
			$currentPackageRel->ExpirationTime = mktime(1, 1, 1, (date("m", $expirationTime) + $package->Duration), date("d", $expirationTime), date("Y", $expirationTime));
			$currentPackageRel->update(array(
				'field' => 'ExpirationTime',
				'where' => 'ID_PLAYER = ? AND ID_PACKAGE = ? AND Activationtime = ?',
				'param' => array($currentPackageRel->ID_PLAYER, $currentPackageRel->ID_PACKAGE, $currentPackageRel->ActivationTime)
			));

			//end up items for current membership
			$playerFeatureRel = new FiPlayerFeatureRel;
			$featureRel = $playerFeatureRel->find(array(
				'where' => 'ID_PACKAGE = ? AND ID_PLAYER = ?',
				'param' => array($currentPackageRel->ID_PACKAGE, $player->ID_PLAYER)
					));

			if ($featureRel) {
				foreach ($featureRel as $frel) {
					$frel->ExpirationTime = $currentPackageRel->ExpirationTime;
					$frel->update(array(
						'field' => 'ExpirationTime',
						'where' => 'ID_PLAYER = ? AND ID_PACKAGE = ? AND ID_FEATURE = ?',
						'param' => array($frel->ID_PLAYER, $frel->ID_PACKAGE, $frel->ID_FEATURE)
					));
				}
			}
		}

		return $package;
	}

	/**
	 * Cancels 2'nd queue element from players membership
	 * @param int $ExpirationTime
	 * @param Players $player 
	 */
	public function cancelQueue(&$player) {
		$currentPackageRel = $this->getCurrentPackage();

		if ($currentPackageRel) {
			$nextPlayerPackRel = new FiPlayerPackageRel;
			$nextPlayerPackRel->ActivationTime = $currentPackageRel->ExpirationTime;
			$nextPlayerPackRel->ID_PLAYER = $player->ID_PLAYER;
			$nextPlayerPackRel->purgeCache();
			$nextPlayerPackRel->delete();
			
			return true;
		}
		
		return false;
	}

	/**
	 * Creates Queue of 2 elements
	 * @param FiPackages $package
	 * @param type $player
	 * @param type $activationTime 
	 */
	private function createQueue(FiPackages $package, &$player, $activationTime) {
		$newPlayerPackRel2 = new FiPlayerPackageRel;
		$newPlayerPackRel2->ID_PACKAGE = $package->ID_PACKAGE;
		$newPlayerPackRel2->PackageType = $package->PackageType;
		$newPlayerPackRel2->ID_PLAYER = $player->ID_PLAYER;
		$newPlayerPackRel2->ActivationTime = $activationTime;
		$newPlayerPackRel2->ExpirationTime = mktime(1, 1, 1, (date("m", $activationTime) + $package->Duration), date("d", $activationTime), date("Y", $activationTime));
		$newPlayerPackRel2->insert();
	}

	/**
	 * gets 2'nd queue element
	 * @return boolean /  FiPlayerPackageRel
	 */
	public function getQueue() {
		$currentPackageRel = $this->getCurrentPackage();
		$player = User::getUser();

		if ($currentPackageRel and $player) {
			$nextPlayerPackRel = new FiPlayerPackageRel;
			$nextPlayerPackRel->ActivationTime = $currentPackageRel->ExpirationTime;
			$nextPlayerPackRel->ID_PLAYER = $player->ID_PLAYER;
			return $nextPlayerPackRel->getOne();
		}

		return false;
	}

	public static function getUpgradesByType() {
		$upgrade[PACKAGE_SILVER] = array(PACKAGE_GOLD, PACKAGE_PLATINUM);
		$upgrade[PACKAGE_GOLD] = array(PACKAGE_PLATINUM);
		$upgrade[PACKAGE_PLATINUM] = array();

		return $upgrade;
	}
	
	/**
	 * Handles logic for features users bought
	 * @param FiPurchases $item 
	 */
	public static function handlePurchasedFeature(FiPurchases $item) {
		$package = Membership::getPackageById($item->ID_PRODUCT);
		$package = current($package->relate('FiPackageFeatureRel'));
		$player = User::getById($item->ID_PLAYER);      
        
		$packConfig = Doo::conf()->package;
		if (isset($package->FiPackageFeatureRel)) {
			foreach ($package->FiPackageFeatureRel as $relation) {

				if ($relation->SpecialType == GAME) {
					$player->updateProfile(array(
						//'freeGameLimit' => $relation->Quantity
						'freeGameLimit' => ($player->FreeGameLimit + $relation->Quantity)
					));
				} else if ($relation->SpecialType == IMAGE) {
					$player->updateProfile(array(
						'imageLimit' => ($player->ImageLimit + $relation->Quantity)
					));
				} else if ($relation->SpecialType == GROUP) {
					$player->updateProfile(array(
						'groupLimit' => ($player->GroupLimit + $relation->Quantity)
					));
                //} else if ($relation->SpecialType == VOICE) {}                  
				} else if ($package->ID_PACKAGE == $packConfig['no_ads_or_banners']) {
					//add timestamp to player
					$membership = new Membership();
					$currentFeature = $membership->getCurrentFeature($package);
					
					$expirationTime = time();
					if($currentFeature !== FALSE) {
						$expirationTime = $currentFeature->ExpirationTime;
					}
		
					$player->updateProfile(array(
						'noAdsTime' => mktime(1, 1, 1, (date("m", $expirationTime) + $package->Duration), date("d", $expirationTime), date("Y", $expirationTime))
					));
				}
			}
		}
	}

	/**
	 * Updates the number of free games available for players with active premium memberships
	 * The function is not intended to ever be called from other sources,
	 * and thus the screen texts are okay to show
	 */
	public function updateFreeGameCount()
	{
//		$rel = new FiPlayerFeatureRel;
		$relations = Doo::db()->find('FiPlayerFeatureRel',
									  array('where' => "ActivationTime < ? AND ExpirationTime > ? AND SpecialType = 'game'",
											'param' => array(time(), time())
		));

		echo "Number of players to update: ";
		print_r(count($relations));
		echo "<br>";

		foreach ($relations as $relation)
		{
			$player = User::getById($relation->ID_PLAYER);
			$player->updateProfile(array(
				//'freeGameLimit' => $relation->Quantity
				'freeGameLimit' => ($player->FreeGameLimit + $relation->Quantity)
			));
		}
	}

	public static function isValidFeature($name) {
		static $return = array();
		if(Auth::isUserLogged()) {
			$player = User::getUser();

			if(isset($return["{$name}"])) {
				return $return["{$name}"];
			}

			if($name === 'createGroup') {
				$return["{$name}"] = $player->GroupLimit > $player->GroupsOwnedCount ? true : false;
			} else if($name === 'uploadImage') {
				$return["{$name}"] = $player->ImageLimit > $player->WallPhotoCount ? true : false;
			} else if($name === 'noAdsTime') {
				$return["{$name}"] = $player->NoAdsTime > time() ? true : false;
			}
		} else {
			$return["{$name}"] = false;
		}
		return $return["{$name}"];
	}
	
	public function getCurrentFeatures() {
		$player = User::getUser();
		$result = false;
		
		if($player) {
			$pack = new FiPackages;
			$rel = new FiPlayerFeatureRel;
			$params['FiPlayerFeatureRel'] = array(
				'select' => "{$pack->_table}.*, {$rel->_table}.ActivationTime, {$rel->_table}.ExpirationTime, {$rel->_table}.ID_FEATURE",
				'where' => "ID_PLAYER = ? AND ActivationTime < ? AND ExpirationTime > ? AND {$rel->_table}.PackageType = ''",
				'param' => array($player->ID_PLAYER, time(), time()),
				'joinType' => 'INNER',
				'match' => true,
				'asc' => "{$pack->_table}.Position"
			);
			$result = Doo::db()->relateMany('FiPackages', array('FiPlayerFeatureRel'), $params);
		}
		
		return $result;
	}
	
	/**
	 * Free items like games per month, there will be 10 featured items user can select from
	 */
	public function prepareFreeItems() {
		$product = new FiProducts;
		$product->isFeatured = 0;
		$product->update(array('where' => '1'));
		
		$products = Doo::db()->find('FiProducts', array(
			'where' => 'isDownloadable = 1 AND Available = 1',
			'limit' => 10,
			'asc' => 'LastFeaturedTime'
		));
		
		if($products) {
			foreach($products as $product) {
				$product->isFeatured = 1;
				$product->update();
			}
		}
	}

}