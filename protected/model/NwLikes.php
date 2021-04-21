<?php
Doo::loadCore('db/DooSmartModel');

class NwLikes extends DooSmartModel{

    public $ID_LIKE;
    public $ID_NEWS;
    public $ID_PLAYER;
    public $ReplyNumber;
    public $Likes;

    public $_table = 'nw_likes';
    public $_primarykey = 'ID_LIKE';
    public $_fields = array('ID_LIKE',
                            'ID_NEWS',
                            'ID_PLAYER',
                            'ReplyNumber',
                            'Likes',
                            );

}
?>