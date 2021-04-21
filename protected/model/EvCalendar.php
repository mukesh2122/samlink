<?php
Doo::loadCore('db/DooSmartModel');

class EvCalendar extends DooSmartModel{

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $ID_PLAYER;

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $ID_FROM;

    /**
     * @var mediumint Max length is 8.  unsigned.
     */
    public $ID_EVENT;

    /**
     * @var enum 'birthday','esport','personal','live').
     */
    public $EventType;

    /**
     * @var int Max length is 10.  unsigned.
     */
    public $EventTime;

    /**
     * @var int Max length is 10.  unsigned.
     */
    public $EventDuration;

    /**
     * @var varchar Max length is 144.
     */
    public $EventText;

    public $_table = 'ev_calendar';
    public $_primarykey = 'EventTime';
    public $_fields = array('ID_PLAYER','ID_FROM','ID_EVENT','EventType','EventTime','EventDuration','EventText');

    public function getVRules() {
        return array(
                'ID_PLAYER' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 8 ),
                        array( 'notnull' ),
                ),

                'ID_FROM' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 8 ),
                        array( 'notnull' ),
                ),

                'ID_EVENT' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 8 ),
                        array( 'notnull' ),
                ),

                'EventType' => array(
                        array( 'notnull' ),
                ),

                'EventTime' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 10 ),
                        array( 'notnull' ),
                ),

                'EventDuration' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 10 ),
                        array( 'notnull' ),
                ),

                'EventText' => array(
                        array( 'maxlength', 144 ),
                        array( 'notnull' ),
                )
            );
    }

}
?>