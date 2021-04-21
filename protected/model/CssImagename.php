<?php
Doo::loadCore('db/DooSmartModel');

class CssImagename extends DooSmartModel {
    public $ID_IMG;
    public $ImageTitle;
    public $ImageName;
    public $FK_PLAYER;

	public $_table = 'css_imagename';
	public $_primarykey = 'ID_IMG';
	public $_fields = array(
        'ID_IMG',
        'ImageTitle',
        'ImageName',
        'FK_PLAYER',
    );
}
?>