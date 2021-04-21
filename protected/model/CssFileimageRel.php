<?php
Doo::loadCore('db/DooSmartModel');

class CssFileimageRel extends DooSmartModel {
    public $FK_FILENAME;
    public $FK_IMG;
    public $UsedTag;

	public $_table = 'css_fileimage_rel';
	public $_primarykey = '';
	public $_fields = array(
        'FK_FILENAME',
        'FK_IMG',
        'UsedTag',
    );
}
?>