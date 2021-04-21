<?php
Doo::loadCore('db/DooSmartModel');

class SnSearch extends DooSmartModel{

    public $ID_ITEM;
    public $FieldType;
    public $ID_LANGUAGE;
    public $Data;
    public $ID_OWNER;
    public $OwnerType;
    public $URL;
    public $ImageURL;

    public $_table = 'sn_search';
    public $_primarykey = 'ID_ITEM';
    public $_fields = array('ID_ITEM',
                            'FieldType',
                            'ID_LANGUAGE',
                            'Data',
                            'ID_OWNER',
                            'OwnerType',
                            'URL',
                            'ImageURL',
                            );

    /**
     * Returns object for defined type for processing in view
     *
     * @return object by type
     */
    public function getByType() {
        switch ($this->FieldType) {
        	case SEARCH_PLAYER:
        		return User::getById($this->ID_ITEM);
        		break;
    		case SEARCH_COMPANY:
        		return Companies::getCompanyByID($this->ID_ITEM);
        		break;
    		case SEARCH_GAME:
        		return Games::getGameByID($this->ID_ITEM);
        		break;
    		case SEARCH_GROUP:
        		return Groups::getGroupByID($this->ID_ITEM);;
        		break;
    		case SEARCH_NEWS:
        		return News::getArticleByID($this->ID_ITEM, $this->ID_LANGUAGE);
        		break;
        }
    }

}
?>