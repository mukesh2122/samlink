<?php

class Referral {
	
	public static function getByCode($code) {
		$referrer = new SnReferrers();
		$referrer->VoucherCode = $code;
		return $referrer->getOne();
	}
	
	public static function getByReferrer($id, $parent = null) {
		$referrer = new SnReferrers();
		$referrer->ID_REFERRER = $id;
		if($parent !== NULL) {
			$referrer->ID_PARENT = $parent;
		}
		return $referrer->getOne();
	}
	
	public static function getFirstReferrerEntry($id) {
		$referrer = new SnReferrers();
		$referrer->ID_REFERRER = $id;
		$referrer->ID_PARENT = 0;
		$check = $referrer->getOne();
		
		if($check) {
			return $check;
		} else {
			$referrer = new SnReferrers();
			$referrer->ID_REFERRER = $id;
			return $referrer->getOne();
		}
		
	}
	
	/**
	 * Generates random voucher code
	 * @return int
	 */
	public function generateVoucherCode() {
		$referrers = new SnReferrers();
		$referrers->purgeCache();
		$referrers = $referrers->find();
		
		$results = array();
		if($referrers and !empty($referrers)) {
			foreach($referrers as $r) {
				$results[] = $r->VoucherCode;
			}
		}
		
		if(count($results) > 3000) {
			for($i = 10000; $i < 99999; $i++) {
				if(!in_array($i, $results)) {
					return $i;
				}
			}
		} else {
			while(true) {
				$rand = rand(10000, 99999);
				if(!in_array($rand, $results)) {
					return $rand;
				}
			}
		}
	}
	
	public function createReferral(Players &$player, $displayName = "", $comission = 0) {
		//check if it's first player's referral then parent = 0, else parent = referral id
		$referrer = new SnReferrers();
		$referrer->ID_REFERRER = $player->ID_PLAYER;
		$voucherCode = $this->generateVoucherCode();
		$check = $referrer->getOne();
		
		if($check) {
			$referrer->ID_PARENT = $player->ID_PLAYER;
			$referrer->VoucherCode = $voucherCode;
			$referrer->Commision = $check->Commision;
		} else {
			$referrer->VoucherCode = $voucherCode;
			$referrer->Commision = (int) abs($comission);
		}
		
		$referrer->DisplayName = $displayName;
		$referrer->insert();
		
		return $referrer;
	}
	
	public function updateReferral($code, $displayName = "", $comission = 0) {
		$referrer = new SnReferrers();
		$referrer->VoucherCode = $code;
		$check = $this->getByCode($code);
		
		if($check) {
			if($comission > 0) {
				$check->Commision = $comission;
			}
			
			$check->DisplayName = $displayName;
			$check->update();
			return true;
		} 
		return false;
	}
	
	public function createSubReferral(Players &$player, $displayName = "", $email = "", $comission = 0) {
		//check if it's first player's referral then parent = 0, else parent = referral id
		$user = User::getByEmail($email);
		
		//validate commision
		$manager= new SnReferrers();
		$manager->ID_REFERRER = $player->ID_PLAYER;
		$manager->ID_PARENT = 0;
		$manager = $manager->getOne();
		
		if(!$manager) {
			return false;
		}
		
		if($manager->Commision < $comission) {
			return false;
		}
		$voucherCode = $this->generateVoucherCode();
		$referrer = new SnReferrers();
		$referrer->ID_REFERRER = 0;
		if($user) {
			$referrer->ID_REFERRER = $user->ID_PLAYER;
			$check = Doo::db()->find('SnReferrers', array(
				'where' => "ID_REFERRER = ? OR EMail = ?",
				'param' => array($user->ID_PLAYER, $email),
				'limit' => 1
			));
			if($check) {
				return false;
			}
			
			//make player referrer
			$user->updateProfile(array(
				'isReferrer' => 1
			));
		} 
		
		$referrer->ID_PARENT = $player->ID_PLAYER;
		$referrer->EMail = $email;
		$referrer->VoucherCode = $voucherCode;
		$referrer->Commision = (int) abs($comission);
		$referrer->DisplayName = $displayName;
		$referrer->insert();
		
		return $referrer;
	}
	
	public function updateSubReferral($code, $displayName = "", $email = "", $comission = 0) {
		$referrer = $this->getByCode($code);
		
		if(!$referrer) {
			return false;
		}
		
		$user = User::getByEmail($email);
		
		if($referrer->EMail != $email) {
			if($user) {
				$referrer->ID_REFERRER = $user->ID_PLAYER;
				
				$check = Doo::db()->find('SnReferrers', array(
					'where' => "ID_REFERRER = ? OR EMail = ?",
					'param' => array($user->ID_PLAYER, $email),
					'limit' => 1
				));
				if($check) {
					return false;
				}
			
			} else {
				$referrer->ID_REFERRER = 0;
			}
		} 
		
		$referrer->EMail = $email;
		$referrer->Commision = (int) abs($comission);
		$referrer->DisplayName = $displayName;
		$referrer->update();
		
		return $referrer;
	}
	
	public static function registerAction($code, $action, $credits = 0, $referee = 0, $referrer = 0) {
		$referral = new SnReferrals();
		$referral->VoucherCode = $code;
		$referral->RecordType = $action;
		$referral->Credits = $credits;
		$referral->ID_REFERREE = $referee;
		$referral->ID_REFERRER = $referrer;
		$rs = $referral->insert();
        return $rs;
	}
	
	public static function signUpBonus($id){
		//need to add bonus to referrer after other user signs up
		$referral = new SnReferrals();
		$referral->ID_REFERREE = $id;
		$code = $referral->getOne();
		
		if($code) {
			$referrerObj = Referral::getByCode($code->VoucherCode);
			if(!$referrerObj) {
				return false;
			}
			
			//if new player update referrer table
			if($referrerObj->ID_REFERRER == 0) {
				$referrerObj->ID_REFERRER = $id;
				$referrerObj->update(array(
					'field' => 'ID_REFERRER',
					'where' => 'VoucherCode = ?',
					'param' => array($code->VoucherCode)
					));
			}

			//make player referrer
			$player = User::getById($id);
			if($player and $referrerObj->EMail == $player->EMail) {
				$player->updateProfile(array(
					'isReferrer' => 1
				));
			}
		
			//give bonus for parent referree
			if($referrerObj->ID_PARENT > 0) {
				$player = User::getById($referrerObj->ID_PARENT);
				if($player) {
					$player->updateProfile(array(
						'playCredits' => ($player->PlayCredits + Doo::conf()->signupBonusPlaiCoins)
					));
				}
			}
		}
	}
	
	public static function registerPayment($item) {
		if($item->TotalPrice > 0 and $item->ID_PLAYER > 0) {
			$referrers = new SnReferrers;
			$referrals = new SnReferrals;

			$query = "SELECT 
				{$referrers->_table}.*
			FROM
				`{$referrers->_table}`
			INNER JOIN {$referrals->_table} ON {$referrals->_table}.VoucherCode = {$referrers->_table}.VoucherCode
			WHERE
				{$referrals->_table}.ID_REFERREE = ?
			LIMIT 1";

			$rs = Doo::db()->query($query, array($item->ID_PLAYER));
			$referrer = $rs->fetchObject('SnReferrers');
			
			if(isset($referrer) and !empty($referrer)) {
				if($referrer->ID_PARENT == 0 or $referrer->ID_PARENT == $referrer->ID_REFERRER) {
					$managerPlayer = User::getById($referrer->ID_REFERRER);
					if($managerPlayer) {
						$amount = $item->TotalPrice * ($referrer->Commision / 100);
						Referral::registerAction($referrer->VoucherCode, REFERRAL_PAYMENT, $amount, $item->ID_PLAYER, $managerPlayer->ID_PLAYER);
						$managerPlayer->updateProfile(array(
							'credits' => ($managerPlayer->Credits + $amount)
						));
					}
				} else {
					$managerPlayer = User::getById($referrer->ID_PARENT);
					$subReferrerPlayer = User::getById($referrer->ID_REFERRER);

					$manager = new SnReferrers;
					$manager->ID_REFERRER = $referrer->ID_PARENT;
					$manager->ID_PARENT = 0;
					$manager = $manager->getOne();

					if($managerPlayer and $subReferrerPlayer and $manager) {

						//register subreferral money
						$amount = (int) ($item->TotalPrice * ($referrer->Commision / 100));
						Referral::registerAction($referrer->VoucherCode, REFERRAL_PAYMENT, $amount, $item->ID_PLAYER, $subReferrerPlayer->ID_PLAYER);

						$subReferrerPlayer->updateProfile(array(
							'credits' => ($subReferrerPlayer->Credits + $amount)
						));

						//register manager money
						$amount = (int) ($item->TotalPrice * (($manager->Commision - $referrer->Commision) / 100));
						Referral::registerAction($manager->VoucherCode, REFERRAL_PAYMENT, $amount, $referrer->ID_REFERRER, $managerPlayer->ID_PLAYER);
						$managerPlayer->updateProfile(array(
							'credits' => ($managerPlayer->Credits + $amount)
						));
					}
				}
			}
			$player = User::getById($item->ID_PLAYER);
			$translator = new SyTranslators();
			$translator->ID_LANGUAGE = $player->ID_LANGUAGE;
			$translator->Country = $player->Country;
			$translator->isEditor = 1;

//            $translator = $translator->getOne();
//            $areaEditor = User::getById($translator->ID_PLAYER);
//            $amount = (int) ($item->TotalPrice * ($translator->Commission / 100));
            /* CHANGED TO */
            $playerID = $translator->ID_PLAYER;
			$areaEditor = User::getById($playerID);
            $price = $item->TotalPrice;
            $commision = $translator->Commission;
			$amount = (int) ($price * ($commision / 100));


			Referral::registerAction(0, REFERRAL_PAYMENT, $amount, $item->ID_PLAYER, $areaEditor->ID_PLAYER);
			$areaEditor->updateProfile(array(
				'credits' => ($areaEditor->Credits + $amount)
			));
		}
	}
	
	/**
	 * Returns managers sub referrals
	 * @param Players $player
	 * @return type 
	 */
	public function getSubReferrals(Players &$player, $from, $to) {
		$referrers = new SnReferrers;
		$referrals = new SnReferrals;
				
		$query = "SELECT 
			{$referrers->_table}.*,
			SUM(RecordType = 'click') as ClickCount,
			SUM(RecordType = 'signup') as SignupCount,
			SUM(RecordType = 'payment') as PaymentCount,
			SUM(Credits) as PaymentTotal
		FROM
			`{$referrers->_table}`
		LEFT JOIN {$referrals->_table} ON {$referrals->_table}.VoucherCode = {$referrers->_table}.VoucherCode AND ActionTime >= ? AND ActionTime <= ?
		WHERE
			{$referrers->_table}.ID_PARENT = ? AND {$referrers->_table}.ID_REFERRER <> ?
		GROUP BY {$referrers->_table}.ID_REFERRER, {$referrers->_table}.ID_PARENT
		ORDER BY DisplayName ASC";

		$rs = Doo::db()->query($query, array($from, $to, $player->ID_PLAYER, $player->ID_PLAYER));
		$list = $rs->fetchAll(PDO::FETCH_CLASS, 'SnReferrers');
		return $list;
	}
	
	/**
	 * Returns referrers codes
	 * @param Players $player
	 * @return type 
	 */
	public function getAssignedCodes(Players &$player, $from, $to) {
		$referrers = new SnReferrers;
		$referrals = new SnReferrals;
				
		$query = "SELECT 
			{$referrers->_table}.*,
			SUM(RecordType = 'click') as ClickCount,
			SUM(RecordType = 'signup') as SignupCount,
			SUM(RecordType = 'payment') as PaymentCount,
			SUM(Credits) as PaymentTotal
		FROM
			`{$referrers->_table}`
		LEFT JOIN {$referrals->_table} ON {$referrals->_table}.VoucherCode = {$referrers->_table}.VoucherCode AND ActionTime >= ? AND ActionTime <= ?
		WHERE
			{$referrers->_table}.ID_REFERRER = ? 
		GROUP BY {$referrers->_table}.ID_REFERRER, {$referrers->_table}.VoucherCode
		ORDER BY DisplayName ASC";

		$rs = Doo::db()->query($query, array($from, $to, $player->ID_PLAYER));
		$list = $rs->fetchAll(PDO::FETCH_CLASS, 'SnReferrers');
		
		return $list;
	}
	
	public function cancelReferal($code, $email) {
		Doo::db()->delete('SnReferrers', array(
			'where' => "VoucherCode = ? AND EMail = ?",
			'param' => array($code, $email)
		));
	}
	
}