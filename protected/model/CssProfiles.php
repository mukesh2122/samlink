<?php
Doo::loadCore('db/DooSmartModel');

class CssProfiles extends DooSmartModel {
    public $ID_PROFILE;
    public $PackageType;
    public $ProfileType;
    public $CssTable;

	public $_table = 'css_profiles';
	public $_primarykey = 'ID_PROFILE';
	public $_fields = array(
        'ID_PROFILE',
        'PackageType',
        'ProfileType',
        'CssTable',
    );
}
?>