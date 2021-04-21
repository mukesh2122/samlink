<?php
Doo::loadCore('db/DooSmartModel');

class GeAreas extends DooSmartModel{

    public $ID_COUNTRY;
    public $AreaNumber;
    public $AreaName;
    public $Abbrevation;
    public $NewsCount;
    
    //external
    private $URL;

    public $_table = 'ge_areas';
    public $_primarykey = 'ID_COUNTRY';
    public $_fields = array(
                            'ID_COUNTRY',
                            'AreaNumber',
                            'AreaName',
                            'Abbrevation',
                            'NewsCount',
                         );

    //used for translation    
    public function __get($attr) {
        
        switch ($attr) {
        	case 'URL':
        	    $country = new GeCountries();
        	    $country->ID_COUNTRY = $this->ID_COUNTRY;
        	    $country = $country->getOne();
        	    $this->$attr = $country->URL.'/'.$this->AreaNumber;
        	    break;
        }
        return $this->$attr;
    }
    
}
?>