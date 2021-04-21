<?php

Doo::loadCore('db/DooSmartModel');

class SnDownloads extends DooSmartModel {

    public $ID_DOWNLOAD;
    public $DownloadName;
    public $DownloadDesc;
    public $URL;
    public $ImageURL;
    public $CreationTime;
    public $FileSize;
    public $ID_FILETYPE;
    public $DownloadCount;
    public $_table = 'sn_downloads';
    public $_primarykey = 'ID_DOWNLOAD';
    public $_fields = array('ID_DOWNLOAD',
        'DownloadName',
        'DownloadDesc',
        'URL',
        'ImageURL',
        'CreationTime',
        'FileSize',
        'ID_FILETYPE',
        'DownloadCount',
    );

}
?> 