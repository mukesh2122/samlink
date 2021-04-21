<?php
Doo::loadCore('db/DooSmartModel');

class CssFilename extends DooSmartModel {
    public $ID_FILENAME;
    public $CssTitle;
    public $FilenameDesc;
    public $Path;
    public $Filetype;
    public $FK_PLAYER;
    public $Price;

	public $_table = 'css_filename';
	public $_primarykey = 'ID_FILENAME';
	public $_fields = array(
        'ID_FILENAME',
        'CssTitle',
        'FilenameDesc',
        'Path',
        'Filetype',
        'FK_PLAYER',
        'Price',
    );
}
?>
