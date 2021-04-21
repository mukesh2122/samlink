<?php
Doo::loadCore('db/DooSmartModel');

class SnGameTypes extends DooSmartModel{

    public $ID_GAMETYPE;
    public $GameTypeName;
    public $GameTypeDesc;

    public $_table = 'sn_gametypes';
    public $_primarykey = 'ID_GAMETYPE';
    public $_fields = array(
                            'ID_GAMETYPE',
                            'GameTypeName',
                            'GameTypeDesc',
                         );
	
	public function __get($attr) {
		switch ($attr) {
			case 'NameTranslated':
				$this->$attr = (isset($this->TypeNameTranslated) and strlen($this->TypeNameTranslated) > 0) ? $this->TypeNameTranslated : $this->GameTypeName;
				break;
			case 'DescTranslated':
				$this->$attr = (isset($this->TypeDescTranslated) and strlen($this->TypeDescTranslated) > 0) ? $this->TypeDescTranslated : $this->GameTypeDesc;
				break;
		}
		return $this->$attr;
	}
}
?>