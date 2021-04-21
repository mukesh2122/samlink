<?php
Doo::loadCore('db/DooSmartModel');

class GeCountries extends DooSmartModel{

    public $ID_COUNTRY;
    public $Country;
    public $A2;
    public $A3;
    public $Number;
    public $AreaCount;
    public $LastAreaNum;
    public $LanguageCount;
    public $NewsCount;
    
    //external
    private $URL;

    public $_table = 'ge_countries';
    public $_primarykey = 'ID_COUNTRY';
    public $_fields = array(
                            'ID_COUNTRY',
                            'Country',
                            'A2',
                            'A3',
                            'Number',
                            'AreaCount',
                            'LastAreaNum',
                            'LanguageCount',
                            'NewsCount',
                         );

    //used for translation    
    public function __get($attr) {
        
        switch ($attr) {
        	case 'URL':
        	        $this->$attr = MainHelper::site_url('news/country/'.$this->A2);
        		break;
        }
        return $this->$attr;
    }
    
}
?>