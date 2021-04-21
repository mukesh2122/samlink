<?php

Doo::loadCore('db/DooSmartModel');

class FiFeatures extends DooSmartModel {

	public $ID_FEATURE;
	public $FeatureName;
	public $FeatureDesc;
	public $Position;
	public $_table = 'fi_features';
	public $_primarykey = 'ID_FEATURE';
	public $_fields = array(
		'ID_FEATURE',
		'FeatureName',
		'FeatureDesc',
		'Position',
	);

	public function getQuantity(FiPackages $package) {
		$qty = 0;
		if ($package != null) {
			$qty = new FiPackageFeatureRel;
			$qty->ID_FEATURE = $this->ID_FEATURE;
			$qty->ID_PACKAGE = $package->ID_PACKAGE;
			$qty = $qty->getOne();

			if ($qty) {
				$qty = $qty->Quantity;
			}
		}
		return $qty;
	}

	public function __get($attr) {
		switch ($attr) {
			case 'NameTranslated':
				if (!isset($this->NameTranslated)) {
					$langID = Lang::getCurrentLangID();
					$locale = new FiFeatureLocale;
					$locale->ID_LANGUAGE = $langID;
					$locale->ID_FEATURE = $this->ID_FEATURE;
					$locale = $locale->getOne();
					if ($locale) {
						$this->NameTranslated = $locale->FeatureName;
					}
				}
				$this->$attr = (isset($this->NameTranslated) and strlen($this->NameTranslated) > 0) ? $this->NameTranslated : $this->FeatureName;
				break;
			case 'DescTranslated':
				$this->$attr = $this->FeatureDesc;
				break;
		}
		return $this->$attr;
	}

}
?>