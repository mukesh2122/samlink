<?php
Doo::loadCore('db/DooSmartModel');

class RsRaidCommentRel extends DooSmartModel {

    public $FK_RAID;
    public $FK_COMMENT;

    public $_table = 'rs_raidcomment_rel';
    public $_primarykey = '';
    public $_fields = array(
        'FK_RAID',
        'FK_COMMENT',
        );
};
?>
