<?php

Doo::loadCore('db/DooSmartModel');

class FiPackages extends DooSmartModel {

	public $ID_PACKAGE;
	public $PackageName;
	public $PackageDesc;
	public $PackageType;
	public $Duration;
	public $Price;
	public $FeatureCount;
	public $isMonthly;
	public $isMembership;
	public $Position;
	public $_table = 'fi_packages';
	public $_primarykey = 'ID_PACKAGE';
	public $_fields = array(
		'ID_PACKAGE',
		'PackageName',
		'PackageDesc',
		'PackageType',
		'Duration',
		'Price',
		'FeatureCount',
		'isMonthly',
		'isMembership',
		'Position',
	);

	public function __get($attr) {
		switch ($attr) {
			case 'NameTranslated':
				if (!isset($this->NameTranslated)) {
					$langID = Lang::getCurrentLangID();
					$locale = new FiPackageLocale;
					$locale->ID_LANGUAGE = $langID;
					$locale->ID_PACKAGE = $this->ID_PACKAGE;
					$locale = $locale->getOne();
					if ($locale) {
						$this->NameTranslated = $locale->PackageName;
					}
				}
				$this->$attr = (isset($this->NameTranslated) and strlen($this->NameTranslated) > 0) ? $this->NameTranslated : $this->PackageName;
				break;
			case 'DescTranslated':
				$this->$attr = $this->PackageDesc;
				break;
		}
		return $this->$attr;
	}

}
?>