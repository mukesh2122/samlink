<?php
Doo::loadCore('db/DooSmartModel');

class GeLanguages extends DooSmartModel{

    public $ID_LANGUAGE;
    public $A2;
    public $NativeName;
    public $EnglishName;
    public $CountryCount;
    public $isEnabled;
    
    //external
    private $URL;

    public $_table = 'ge_languages';
    public $_primarykey = 'ID_LANGUAGE';
    public $_fields = array(
                            'ID_LANGUAGE',
                            'A2',
                            'NativeName',
                            'EnglishName',
                            'CountryCount',
                            'isEnabled',
                         );

}
?>