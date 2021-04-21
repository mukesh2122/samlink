<?php
Doo::loadCore('db/DooSmartModel');

class NwPrefixLocale extends DooSmartModel{

    public $ID_PREFIX;
    public $ID_LANGUAGE;
    public $PrefixName;
	
    public $_table = 'nw_prefixlocales';
    public $_primarykey = ''; 
    public $_fields = array(
		'ID_PREFIX',
		'ID_LANGUAGE',
		'PrefixName'
	);
	
	public function __get($attr) {
        switch ($attr) {
            case 'URL':
                $this->$attr = Url::getUrl($this, 'URL');
                break;
            case 'PLAIN_URL':
                $this->$attr = Url::getUrl($this, 'PLAIN_URL');
                break;
        }
        return $this->$attr;
    }

    public function __set($attr, $val) {
        return $this->{$attr} = $val;
    }
}
?>