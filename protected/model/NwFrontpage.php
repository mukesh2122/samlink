<?php
Doo::loadCore('db/DooSmartModel');

class NwFrontpage extends DooSmartModel{

	public $ID_FRONTPAGE;
	public $Name;
	public $Frontpage;
	public $News;
	public $FTU;

	public $_table = 'nw_frontpage';
	public $_primarykey = 'ID_FRONTPAGE';
	public $_fields = array(
		'ID_FONTPAGE'
	,	'Name'
	,	'Frontpage'
	,	'News'
	,	'FTU'
	);

	public function getAllmodules() {
		return $this->find(array(
			'select' => '*'
		,	'asc'    => 'Name'
		));
	}
	
	public function getModuleStates() {
		$modules = self::getAllModules();
		$state = array();
		foreach ($modules as $module) {
			$state[$module->Name]['Frontpage'] = $module->Frontpage;
			$state[$module->Name]['News'] = $module->News;
			$state[$module->Name]['FTU'] = $module->FTU;
		}
		return $state;
	}

}
?>