<?php

Doo::loadCore('db/DooSmartModel');

class SyMenu extends DooSmartModel {

	public $ID_MENU;
	public $ID_PARENT;
	public $isAdmin;
	public $MenuName;
	public $MenuDesc;
	public $isPublished;
	public $Position;
	public $loginRequired;
	public $URL;
	public $Location;

    public $_table = 'sy_menu';
	public $_primarykey = 'ID_MENU';
	public $_fields = array(
		'ID_MENU',
		'ID_PARENT',
		'isAdmin',
		'MenuName',
		'MenuDesc',
		'isPublished',
		'Position',
		'loginRequired',
		'URL',
		'Location',
	);

	public function __get($attr) {
		switch ($attr) {
			case 'NameTranslated':
				$this->$attr = (isset($this->MenuNameTranslated) and strlen($this->MenuNameTranslated) > 0) ? $this->MenuNameTranslated : $this->MenuName;
				break;
			case 'DescTranslated':
				$this->$attr = (isset($this->MenuDescTranslated) and strlen($this->MenuDescTranslated) > 0) ? $this->MenuDescTranslated : $this->MenuDesc;
				break;
		}
		return $this->$attr;
	}

	public function getMenu($location = TOP, $isLogged = 1) {
		$data = array();
		$langID = Lang::getCurrentLangID();
		if (Doo::conf()->cache_enabled == TRUE) {
			$currentDBconf = Doo::db()->getDefaultDbConfig();
			$cacheKey = md5(CACHE_MENU . '_' . $location . '_' . $langID . '_' . $isLogged . '_' . $currentDBconf[0] . '_' . $currentDBconf[1]);
			if (Doo::cache('apc')->get($cacheKey)) {
				return Doo::cache('apc')->get($cacheKey);
			}
		}

		$menuLocale = new SyMenuLocale;
/*		$query = "SELECT {$this->_table}.*, {$menuLocale->_table}.MenuName as MenuNameTranslated, {$menuLocale->_table}.MenuDesc as MenuDescTranslated,
					sy_modules.*

					FROM {$this->_table}
					LEFT JOIN {$menuLocale->_table} ON {$this->_table}.ID_MENU = {$menuLocale->_table}.ID_MENU AND {$menuLocale->_table}.ID_LANGUAGE = ?

					LEFT JOIN sy_menu_modules ON sy_menu_modules.ID_MENU = {$this->_table}.ID_MENU
					LEFT JOIN sy_modules ON sy_modules.ID_MODULE = sy_menu_modules.ID_MODULE

					WHERE Location = ? AND ID_PARENT = 0 AND isPublished = 1 AND isAdmin = 0

					AND (isEnabled IS NULL OR isEnabled = 1)

					ORDER BY Position ASC";
*/
		$query = "SELECT {$this->_table}.*, {$menuLocale->_table}.MenuName as MenuNameTranslated, {$menuLocale->_table}.MenuDesc as MenuDescTranslated
					FROM {$this->_table}
					LEFT JOIN {$menuLocale->_table} ON {$this->_table}.ID_MENU = {$menuLocale->_table}.ID_MENU AND {$menuLocale->_table}.ID_LANGUAGE = ?
					WHERE Location = ? AND ID_PARENT = 0 AND isPublished = 1 AND isAdmin = 0 AND loginRequired <= ?
					ORDER BY Position ASC";

		$q = Doo::db()->query($query, array($langID, $location, $isLogged));
		$data = $q->fetchAll(PDO::FETCH_CLASS, 'SyMenu');

		if (Doo::conf()->cache_enabled == TRUE) {
			Doo::cache('apc')->set($cacheKey, $data, Doo::conf()->MENU_LIFETIME);
		}
		return $data;
	}

	public function appendLang() {
		$langID = Lang::getCurrentLangID();
		$menuLocale = new SyMenuLocale;
		$menuLocale->ID_MENU = $this->ID_MENU;
		$menuLocale->ID_LANGUAGE = $langID;

		$menuLocale = $menuLocale->getOne();
		if ($menuLocale) {
			$this->MenuNameTranslated = $menuLocale->MenuName;
			$this->MenuDescTranslated = $menuLocale->MenuDesc;
		}
	}

}
?>