<?php

Doo::loadCore('db/DooSmartModel');

class FiProductTypes extends DooSmartModel {

    public $ID_PRODUCTTYPE;
    public $ProductTypeName;
    public $ProductTypeDesc;
    public $ProductCount;
    
    public $_table = 'fi_producttypes';
    public $_primarykey = 'ID_PRODUCTTYPE';
    public $_fields = array(
        'ID_PRODUCTTYPE',
        'ProductTypeName',
        'ProductTypeDesc',
        'ProductCount',
    );
	
	public function __get($attr) {
		switch ($attr) {
			case 'NameTranslated':
				$this->$attr = (isset($this->TypeNameTranslated) and strlen($this->TypeNameTranslated) > 0) ? $this->TypeNameTranslated : $this->ProductTypeName;
				break;
			case 'DescTranslated':
				$this->$attr = (isset($this->TypeDescTranslated) and strlen($this->TypeDescTranslated) > 0) ? $this->TypeDescTranslated : $this->ProductTypeDesc;
				break;
		}
		return $this->$attr;
	}

}
?>