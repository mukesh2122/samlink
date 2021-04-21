<?php

Doo::loadCore('db/DooSmartModel');

class AcBranches extends DooSmartModel {

    public $ID_BRANCH;
    public $BranchName;
    public $BranchDesc;
    
    public $_table = 'ac_branches';
    public $_primarykey = 'ID_BRANCH'; 
    public $_fields = array(
		'ID_BRANCH',
		'BranchName',
                'BranchDesc'
	);

}
?>