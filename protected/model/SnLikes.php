<?php
Doo::loadCore('db/DooSmartModel');

class SnLikes extends DooSmartModel{
    public $ID_LIKE;
    public $ID_WALLITEM;
    public $ID_PLAYER;
    public $ReplyNumber;
    public $Likes;

    public $_table = 'sn_likes';
    public $_primarykey = 'ID_LIKE';
    public $_fields = array('ID_LIKE','ID_WALLITEM','ID_PLAYER','ReplyNumber', 'Likes');

}
?>