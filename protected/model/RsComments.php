<?php
Doo::loadCore('db/DooSmartModel');

class RsComments extends DooSmartModel {

    public $ID_COMMENT;
    public $FK_OWNER;
    public $OwnerType;
    public $Comment;
    public $TimeStamp;

    public $_table = 'rs_comments';
    public $_primarykey = 'ID_COMMENT';
    public $_fields = array(
        'ID_COMMENT',
        'FK_OWNER',
        'OwnerType',
        'Comment',
        'TimeStamp',
        );
};
?>
