<?php
Doo::loadCore('db/DooSmartModel');

class GlSettings extends DooSmartModel{

    public $ID_SETTING;
	public $ValueBool;
    public $ValueInt;
    public $ValueDec;
    public $ValueText;
    public $ValueBin;
    public $LastUpdatedTime;

    public $_table = 'gl_settings';
    public $_primarykey = 'ID_SETTING';
    public $_fields = array(
                            'ID_SETTING',
							'ValueBool',
                            'ValueInt',
                            'ValueDec',
                            'ValueText',
                            'ValueBin',
                            'LastUpdatedTime',
                         );

    // Checks if player is super admin
    public function isAdmin()
    {
        $p = User::getUser();
        if($p)
        {
            if($p->canAccess('Super Admin Interface') === TRUE)
            {
                return TRUE;
            }
        }
        return FALSE;
    }

}
?>