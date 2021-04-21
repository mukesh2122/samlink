<?php

Doo::loadCore('db/DooSmartModel');

class SnFiletypes extends DooSmartModel {

    public $ID_FILETYPE;
    public $FiletypeName;
    public $FiletypeDesc;
    public $ID_OWNER;
    public $OwnerType;
    public $_table = 'sn_filetypes';
    public $_primarykey = 'ID_FILETYPE';
    public $_fields = array('ID_FILETYPE',
        'DownloadName',
        'FiletypeName',
        'FiletypeDesc',
        'ID_OWNER',
        'OwnerType',
    );

    public function getDownloads() {
        $params = array();
        $params['desc'] = 'CreationTime';
        $params['where'] = "ID_FILETYPE = ?";
        $params['param'] = array($this->ID_FILETYPE);
        $downloads = Doo::db()->find('SnDownloads', $params);
        return $downloads;
    }

}
?>