<?php
Doo::loadCore('db/DooSmartModel');

class EsTeamComputerSpecRel extends DooSmartModel{

	public $FK_TEAM;
	public $FK_COMPUTERSPEC;
	public $SpecDesc;
        
        //non db-related. From es_constants
	public $SpecName;

	public $_table = 'es_teamcomputerspec_rel';
	public $_primarykey = ''; //multiple
	public $_fields = array(
							'FK_TEAM',
							'FK_COMPUTERSPEC',
							'SpecDesc',
						 );

}
?>
