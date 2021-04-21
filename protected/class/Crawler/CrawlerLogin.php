<?php
	/*****************
	  Crawler Login
	  login on site
	*****************/
	class CrawlerLogin {
		private static $encryptKey = 'catonahottinroof';
		
		public static function decryptPassword($encryptPassword){
			return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5(self::$encryptKey), base64_decode($encryptPassword), MCRYPT_MODE_CBC, md5(md5(self::$encryptKey))), "\0");
		}

		public static function encryptPassword($decryptPassword){
			return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5(self::$encryptKey), $decryptPassword, MCRYPT_MODE_CBC, md5(md5(self::$encryptKey))));
		}

		public static function hostUrl($url){
			$urlParts = parse_url($url);
			return $urlParts['scheme'].'://'.$urlParts['host'];
		}

		public static function login($seDriver, $site){
			//---- Retrieve login page ----
			$seDriver->get($site['LoginURL']);

			//---- Fill in username and password, then submit ----
			$userElement = $seDriver->findElement(WebDriverBy::xpath($site['LoginUserXpath']));
			$userElement->sendKeys($site['LoginUsername']);
			
			$pswElement = $seDriver->findElement(WebDriverBy::xpath($site['LoginPasswordXpath']));
			$pswElement->sendKeys(self::decryptPassword($site['LoginPassword']));
			
			$buttonElement = $seDriver->findElement(WebDriverBy::xpath($site['LoginSubmitXpath']));
			$buttonElement->click();
			
			return $seDriver;
		}
	}
?>