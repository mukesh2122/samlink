<?php
Doo::loadCore('db/DooSmartModel');

class NwSlides extends DooSmartModel{

	public $ID_SLIDE;
	public $Image;
	public $Headline;
	public $URL;
	public $Priority;
	public $isActive;
	public $InactiveReason;
        public $Teaser;

	public $_table = 'nw_slides';
	public $_primarykey = 'ID_SLIDE';
	public $_fields = array(
		'ID_SLIDE'
	,	'Image'
	,	'Headline'
	,	'URL'
	,	'Priority'
	,	'isActive'
	,	'InactiveReason'
	,	'Teaser'
	);

        public function getEsportURL(){
            
            $url = $this->URL;
            
            if(strstr($this->URL,'playnation.eu')){
                $url = str_replace('http://playnation.eu/news/view', Doo::conf()->APP_URL.'esport/news', $url);
            }
            
            return $url;
        }    
}
?>
