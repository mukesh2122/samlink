<?php

class Lang {

	//do using cookies
	public static function getLang() {

		static $check;

		//Translate off, then use firstchoice
		if(MainHelper::IsModuleEnabledByTag('translations') == 0) {
			$lang = MainHelper::GetFirstChoiceLanguage();
			if(!$check) {
				Lang::setLang($lang);
				$check = 1;
			};
			return $lang;
		};

		$browserLang = null;

		if(isset($_COOKIE['locale']) and !empty($_COOKIE['locale'])) {
			if(in_array($_COOKIE['locale'], Doo::conf()->lang)) { return $_COOKIE['locale']; };
		};

		if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) and strlen($_SERVER['HTTP_ACCEPT_LANGUAGE']) > 0) {
			$browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
			if(!in_array($browserLang, Doo::conf()->lang)) { $browserLang = null; };
		};

		if($browserLang === NULL) { $lang = Doo::conf()->default_lang; }
        else { $lang = $browserLang; };

		if(!$check) {
			Lang::setLang($lang);
			$check = 1;
		};
		return $lang;
	}

	public static function setLang($lang) {
		setcookie('locale', $lang, (time() + (3600 * 24 * 365)), "/");
	}

	public static function getCurrentLangID() {
		static $id = NULL;
		if($id !== NULL) { return $id; };
		$lang = strtolower(Lang::getLang());
		$id = array_search($lang, Doo::conf()->lang);
		return $id;
	}

	public static function getLanguages() {
		$lang = new GeLanguages();
		return $lang->find(array('asc' => 'NativeName', 'where' => 'isEnabled = 1'));
	}

	public static function getLangById($id) {
		$lang = new GeLanguages();
		return $lang->getOne(array('where' => 'ID_LANGUAGE = ? AND isEnabled = 1', 'param' => array($id)));
	}

	public static function getCountryByTag($tag) {
		$lang = new GeCountries();
		$country = $lang->getOne(array('where' => 'A2 = ?', 'param' => array($tag)));

                return !empty($country) ? $country->Country : '';
	}

	public static function getCountryIDByTag($tag) {
		$lang = new GeCountries();
		$country = $lang->getOne(array('where' => 'A2 = ?', 'param' => array($tag)));
		return !empty($country) ? $country->ID_COUNTRY : 0;
	}

}
?>