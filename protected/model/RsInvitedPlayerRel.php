<?php
Doo::loadCore('db/DooSmartModel');

class RsInvitedPlayerRel extends DooSmartModel {

    public $FK_RAID;
    public $FK_PLAYER;
    public $InviteStatus;

    public $_table = 'rs_invitedplayer_rel';
    public $_primarykey = '';
    public $_fields = array(
        'FK_RAID',
        'FK_PLAYER',
        'InviteStatus',
        );
};
?>
