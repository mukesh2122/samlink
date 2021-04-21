<?php

class Payment{

	//paypal
	public function generatePaymentParams($post) {
		$params = array();
		if(!empty($post)) {
			$rate = null;
			$player = User::getUser();
			if($player) {
				if(isset($post['rate']) and $post['rate'] > 0) {
					$rate = new FiExchangeRates();
					$rate->ID_EXCHANGE = intval($post['rate']);
					$rate = $rate->getOne();
				}
				$hash = md5($player->ID_PLAYER.time().$rate->Money.  rand(1, 999999));
				if(isset($post['payment']) and $post['payment'] == PAYMENT_PAYPAL and $rate) {
					$paypal = Doo::conf()->paypal;
					$business = $paypal['account'];
					if (Doo::conf()->paypal_test == TRUE) {
						$paypal = Doo::conf()->paypal_demo;
						$business = $paypal['account'];
					}

					$params['business'] = $business;
					$params['cmd'] = '_xclick';
					$params['no_shipping'] = '1';
					$params['item_name'] = $rate->Credits . ' Credits';
					$params['amount'] = $rate->Money;
					$params['currency_code'] = $rate->Currency;
					$params['image_url'] = MainHelper::site_url('global/img/signature.gif');
					$params['custom'] = $hash;
					$params['return'] = MainHelper::site_url('shop/thank-you/'.$player->URL.'/'.$hash);
					$params['cancel_return'] = MainHelper::site_url('shop/cancel/'.$player->URL.'/'.$hash);
				} else if(isset($post['payment']) and $post['payment'] == PAYMENT_XSOLLA and $rate) {
					$xsolla = Doo::conf()->xsolla;
					$params['project'] = $xsolla['project'];
					$params['v1'] = $hash;
					$params['email'] = $player->EMail;
					$params['out'] = number_format($rate->Money, 2, '.', '');
					$params['signature'] = md5("fix_project={$params['project']}fix_v1={$params['v1']}fix_email={$params['email']}fix_out={$params['out']}{$xsolla['secret']}");
				}
			}
		}

		return $params;
	}

	public function generatePaymentUrl($params, $provider) {
		$url = '';

		if($provider == PAYMENT_PAYPAL) {
			$env = '';
			if (Doo::conf()->paypal_test == TRUE) {
				$env = 'sandbox.';
			}
			$url = urldecode('https://www.'.$env.'paypal.com/cgi-bin/webscr');
		} else if($provider == PAYMENT_XSOLLA) {
			$urlSuffix = array();
			if(!empty($params)) {
				foreach($params as $key => $val) {
					$urlSuffix[] = $key.'='.$val;
				}
			}
			$url = urldecode('https://secure.xsolla.com/paystation/index.php?id_theme=12&'.implode('&', $urlSuffix));
		}

		return $url;
	}

	/**
	 * Inserts post data when user presses buy credits
	 * @param array $params
	 * @return void
	 */
	public function recordPaypalRequest($params, $provider) {
		$player = User::getUser();
		$payment = new FiPayments();
		$payment->ID_PLAYER = $player->ID_PLAYER;
		$payment->PaymentText = serialize($params);
		$payment->PaymentType = 'out';
		$payment->PaymentProvider = $provider;
		$payment->PaymentTime = time();
		$payment->PlayerIP = $_SERVER['REMOTE_ADDR'];
		$payment->Hash = isset($params['v1']) ? $params['v1'] : $params['custom'];
		$payment->insert();
	}

	/**
	 * Inserts cancel note when user presses cancel from paypal
	 * @param array $post
	 * @return void
	 */
	public function recordPaypalCancel($hash) {
		$player = User::getUser();
		$payment = new FiPayments();
		$payment->ID_PLAYER = $player->ID_PLAYER;
		$payment->PaymentText = serialize(array('status' => 'Canceled by Player'));
		$payment->PaymentType = 'in';
		$payment->PaymentProvider = PAYMENT_PAYPAL;
		$payment->PaymentTime = time();
		$payment->PlayerIP = $_SERVER['REMOTE_ADDR'];
		$payment->Hash = $hash;
		$payment->insert();
	}

	/**
	 * Inserts payed note when user pays from paypal
	 * @param array $post
	 * @return void
	 */
	public function recordPaypalPayment($hash) {
		$player = User::getUser();
		$payment = new FiPayments();
		$payment->ID_PLAYER = $player->ID_PLAYER;
		$payment->PaymentText = serialize(array('status' => 'Payed by Player'));
		$payment->PaymentType = 'in';
		$payment->PaymentProvider = PAYMENT_PAYPAL;
		$payment->PaymentTime = time();
		$payment->PlayerIP = $_SERVER['REMOTE_ADDR'];
		$payment->Hash = $hash;
		$payment->insert();
	}

	/**
	 * Validates Paypal
	 * @param array $post
	 */
	public function validateIPN($post) {

		$env = '';
		$paypal = Doo::conf()->paypal;
		if (Doo::conf()->paypal_test == TRUE) {
			$env = 'sandbox.';
			$paypal = Doo::conf()->paypal_demo;
		}

		$url = 'https://www.' . $env . 'paypal.com/cgi-bin/webscr';

		$postdata = '';
		foreach ($post as $i => $v) {
			$postdata .= $i . '=' . urlencode($v) . '&';
		}
		$postdata .= 'cmd=_notify-validate';

		$web = parse_url($url);
		if ($web['scheme'] == 'https') {
			$web['port'] = 443;
			$ssl = 'ssl://';
		} else {
			$web['port'] = 80;
			$ssl = '';
		}

		$fp = @fsockopen($ssl . $web['host'], $web['port'], $errnum, $errstr, 30);

		if (!$fp) {
			echo $errnum . ': ' . $errstr;
		} else {
			fputs($fp, "POST " . $web['path'] . " HTTP/1.1\r\n");
			fputs($fp, "Host: " . $web['host'] . "\r\n");
			fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
			fputs($fp, "Content-length: " . strlen($postdata) . "\r\n");
			fputs($fp, "Connection: close\r\n\r\n");
			fputs($fp, $postdata . "\r\n\r\n");

			while (!feof($fp)) {
				$info[] = @fgets($fp, 1024);
			}
			fclose($fp);
			$info = implode(',', $info);
			if (preg_match('/VERIFIED/', $info)) {

				if (!$this->isHash($post['custom'], serialize($post)) and $post['payment_status'] == 'Completed'
						and $paypal['account'] == $post['business'] and $post['mc_currency'] == 'EUR') {

					$payment = new FiPayments();
					$payment->Hash = $post['custom'];
					$payment->PaymentType = 'out';
					$payment->purgeCache();
					$payment = $payment->getOne();

					if ($payment) {
						$paymentBack = new FiPayments();
						$paymentBack->ID_PLAYER = $payment->ID_PLAYER;
						$paymentBack->PaymentText = serialize($post);
						$paymentBack->PaymentType = 'in';
						$paymentBack->PaymentProvider = PAYMENT_PAYPAL;
						$paymentBack->PaymentTime = time();
						$paymentBack->ID_TXN = $post['txn_id'];
						$paymentBack->Hash = $post['custom'];
						$paymentBack->insert();

						$player = User::getById($payment->ID_PLAYER);
						if ($player) {
							$amount = $player->Credits + intval($post['item_name']);
							$player->updateProfile(array('credits' => $amount));
						}
					}
				}
			} else {
				$payment = new FiPayments();
				$post['status'] = 'INVALID';
				$payment->PaymentText = serialize($post);
				$payment->PaymentType = 'in';
				$payment->PaymentProvider = PAYMENT_PAYPAL;
				$payment->PaymentTime = time();
				$payment->insert();
			}
		}
	}

	/**
	 * Validates Xsolla
	 * @param array $params
	 */
	public function validateXsolla($params) {
		ob_clean();

		header('Content-type: text/xml');

		//check if all params are in place
		if(!isset($params['id']) or !isset($params['v1']) or !isset($params['amount']) or !isset($params['currency']) or !isset($params['datetime']) or !isset($params['sign'])) {
			echo '<?xml version="1.0" encoding="UTF-8"?>
			<response>
				<result>30</result>
				<description>Temporary error</description>
			</response>';
			exit;
		}

		$payment = new FiPayments();
		$payment->ID_TXN = $params['id'];
		$payment->purgeCache();
		$payment = $payment->getOne();

		//check if there is no same ID in system
		if($payment) {
			echo '<?xml version="1.0" encoding="UTF-8"?>
			<response>
				<result>0</result>
				<description>Success</description>
				<fields>
					<id>'.$params['id'].'</id>
					<order>'.$params['v1'].'</order>
					<amount>'.$params['amount'].'</amount>
					<currency>'.$params['currency'].'</currency>
					<datetime>'.$params['datetime'].'</datetime>
					<sign>'.$params['sign'].'</sign>
				</fields>
			</response>';
			exit;
		}

		$xsolla = Doo::conf()->xsolla;
		$sign = md5("{$params['v1']}{$params['amount']}{$params['currency']}{$params['id']}{$xsolla['secret']}");

		//check if signatures match
		if($sign != $params['sign']) {
			echo '<?xml version="1.0" encoding="UTF-8"?>
			<response>
				<result>30</result>
				<description>Temporary error</description>
			</response>';
			exit;
		}

		//check if item exists in system
		$payment = new FiPayments();
		$payment->Hash = $params['v1'];
		$payment->PaymentType = 'out';
		$payment->purgeCache();
		$payment = $payment->getOne();

		if(!$payment) {
			echo '<?xml version="1.0" encoding="UTF-8"?>
			<response>
				<result>20</result>
				<description>Incorrect order ID</description>
			</response>';
			exit;
		}

		if ($params['command'] == 'pay' and $params['currency'] == 'EUR') {

			$player = User::getById($payment->ID_PLAYER);
			if ($player) {
				$rate = new FiExchangeRates();
				$rate->Money = intval($params['amount']);
				$rate = $rate->getOne();
				if($rate) {
					$amount = $player->Credits + $rate->Credits;
					$player->updateProfile(array('credits' => $amount));

					$paymentBack = new FiPayments();
					$paymentBack->ID_PLAYER = $payment->ID_PLAYER;
					$paymentBack->PaymentText = serialize($params);
					$paymentBack->PaymentType = 'in';
					$paymentBack->PaymentProvider = PAYMENT_XSOLLA;
					$paymentBack->PaymentTime = time();
					$paymentBack->ID_TXN = $params['id'];
					$paymentBack->Hash = $params['v1'];
					$paymentBack->insert();

					echo '<?xml version="1.0" encoding="UTF-8"?>
						<response>
							<result>0</result>
							<description>Success</description>
							<fields>
								<id>'.$params['id'].'</id>
								<order>'.$params['v1'].'</order>
								<amount>'.$params['amount'].'</amount>
								<currency>'.$params['currency'].'</currency>
								<datetime>'.$params['datetime'].'</datetime>
								<sign>'.$sign.'</sign>
							</fields>
						</response>';
					exit;
				}
			}
		}

		echo '<?xml version="1.0" encoding="UTF-8"?>
			<response>
				<result>30</result>
				<description>Temporary error</description>
			</response>';
		exit;
	}

	/**
	 * Checks for dublicates
	 * @param String $hash
	 * @param String $text
	 * @return boolean
	 */
	public function isHash($hash, $text = '') {
		$payment = new FiPayments();
		$payment->Hash = $hash;
		$payment->PaymentText = $text;
		$payment->purgeCache();
		$payment = $payment->getOne();
		if ($payment) {
			return true;
		}
		return false;
	}
}
?>
