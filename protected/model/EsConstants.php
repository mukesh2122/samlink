<?php

Doo::loadCore('db/DooSmartModel');

class EsConstants extends DooSmartModel {
    
    public $ID_CONSTANT;
    public $ConstantType;
    public $ConstantName;
    public $ConstantDesc;
    public $Value;
    
    public $_table = 'es_constants';
    public $_primarykey = 'ID_CONSTANT'; 
    public $_fields = array(
		'ID_CONSTANT',
                'ConstantType',
                'ConstantName',
                'ConstantDesc',
                'Value'
	);

}
?>