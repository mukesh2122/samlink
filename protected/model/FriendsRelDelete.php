<?php
Doo::loadCore('db/DooSmartModel');

class FriendsRelDelete extends DooSmartModel{

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $ID_PLAYER;

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $ID_FRIEND;
    public $Mutual;
    public $Subscribed;
    public $MyRequest;
    public $OtherRequest;

    public $_table = 'sn_friends_rel_delete';
    public $_primarykey = 'ID_FRIEND';
    public $_fields = array('ID_PLAYER','ID_FRIEND','Mutual','Subscribed','MyRequest','OtherRequest');

    public function getVRules() {
        return array(
                'ID_PLAYER' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 8 ),
                        array( 'notnull' ),
                ),

                'ID_FRIEND' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 8 ),
                        array( 'notnull' ),
                )
            );
    }

}
?>