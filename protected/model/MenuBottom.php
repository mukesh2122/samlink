<?php
Doo::loadCore('db/DooSmartModel');

class MenuBottom extends DooSmartModel{

    /**
     * @var int Max length is 8.  unsigned.
     */
    public $menu_id;
    /**
     * @var int Max length is 8.  unsigned.
     */
    public $top;
        /**
     * @var int Max length is 8.  unsigned.
     */
    public $parent_id;
    /**
     * @var varchar Max length is 250.
     */
    public $menu_titel;

    /**
     * @var text
     */
    public $menu_text;


    public $_table = 'menu_bottom';
    public $_primarykey = 'menu_id';
    public $_fields = array('menu_id','menu_titel','menu_text');

    public function getVRules() {
        return array(
                'menu_id' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 8 ),
                        array( 'optional' ),
                ),
                         'parent_id' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 8 ),
                        array( 'optional' ),
                ),                
                		'top' => array(
                        array( 'integer' ),
                        array( 'min', 0 ),
                        array( 'maxlength', 8 ),
                        array( 'optional' ),
                ),

                'menu_titel' => array(
                        array( 'maxlength', 250 ),
                        array( 'notnull' ),
                ),

                'menu_text' => array(
                        array( 'text' ),

                )
            );
    }

}
?>