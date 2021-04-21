<?php
Doo::loadCore('db/DooSmartModel');

class SnPlatforms extends DooSmartModel{

    public $ID_PLATFORM;
    public $PlatformName;
    public $PlatformDesc;
    public $RatingCur;
    public $RatingTop;
    public $RatingPop;
    
    //not related
    public $NewsCount = 0;
    
    private $NEWS_URL;
    private $PLAIN_URL;

    public $_table = 'sn_platforms';
    public $_primarykey = 'ID_PLATFORM';
    public $_fields = array(
                            'ID_PLATFORM',
                            'PlatformName',
                            'PlatformDesc',
                            'RatingCur',
                            'RatingTop',
                            'RatingPop',
                         );
                         
    public function __get($attr) {
       switch ($attr) {
		   case 'NEWS_URL':
                $this->$attr = Url::getUrl($this, "NEWS_URL");
                break;
        }
        return $this->$attr;
    }


}
?>