<?php
Doo::loadCore('db/DooSmartModel');

class FriendsRelInsert extends DooSmartModel{

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $ID_PLAYER;

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $ID_FRIEND;
    public $Subscribed;
    public $Request;

    public $_table = 'sn_friends_rel_insert';
    public $_primarykey = 'ID_FRIEND';
    public $_fields = array('ID_PLAYER','ID_FRIEND','Subscribed','Request');

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