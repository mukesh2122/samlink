<?php
Doo::loadCore('db/DooSmartModel');

class GlItemLocale extends DooSmartModel{

    public $ID_NEWS;
    public $ID_LANGUAGE;
	public $ID_PLAYER;
    public $Headline;
    public $IntroText;
    public $NewsText;
    public $Image;
	public $URL;
    public $Published;
    public $EditorNote;
    public $Replies;
    public $PostingTime;
    public $LastActivityTime;
    public $LastUpdatedTime;
    public $isBlog;
    public $isReview;

    private $PLAIN_URL;

    public $_table = 'gl_itemlocales';
    public $_primarykey = ''; 
    public $_fields = array(
		'ID_NEWS',
		'ID_LANGUAGE',
		'ID_PLAYER',
		'Headline',
		'IntroText',
		'NewsText',
		'Image',
		'URL',
		'Published',
		'EditorNote',
		'Replies',
		'PostingTime',
		'LastActivityTime',
		'LastUpdatedTime',
                'isBlog',
                'isReview'
	);
	
	public function __get($attr) {
        switch ($attr) {
            case 'URL':
                $this->$attr = Url::getUrl($this, 'URL');
                break;
            case 'PLAIN_URL':
                $this->$attr = Url::getUrl($this, 'PLAIN_URL');
                break;
        }
        return $this->$attr;
    }

    public function __set($attr, $val) {
        return $this->{$attr} = $val;
    }
}
?>