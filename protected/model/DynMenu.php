<?php
Doo::loadCore('db/DooSmartModel');

class DynMenu extends DooSmartModel{

    /**
     * @var int Max length is 11.
     */
    public $menu_id;

    /**
     * @var varchar Max length is 250.
     */
    public $menu_titel;

    /**
     * @var text
     */
    public $menu_text;

    /**
     * @var varchar Max length is 250.
     */
    public $menu_url;

    /**
     * @var int Max length is 11.
     */
    public $top_menu;

    /**
     * @var int Max length is 11.
     */
    public $external_content;

    /**
     * @var int Max length is 11.
     */
    public $Parent_ID;
    public $hasChild;

    public $_table = 'dyn_menu';
    public $_primarykey = 'menu_id';
    public $_fields = array('menu_id','menu_titel','menu_text','url','top_menu','external_content','Parent_ID','hasChild');

    public function getVRules() {
        return array(
                'menu_id' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'optional' ),
                ),

                'menu_titel' => array(
                        array( 'maxlength', 250 ),
                        array( 'notnull' ),
                ),

                'menu_text' => array(
                        array( 'notnull' ),
                ),

                'menu_url' => array(
                        array( 'maxlength', 250 ),
                        array( 'notnull' ),
                ),

                'top_menu' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'notnull' ),
                ),

                'external_content' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'notnull' ),
                ),

                'Parent_ID' => array(
                        array( 'integer' ),
                        array( 'maxlength', 11 ),
                        array( 'notnull' ),
                )
            );
    }
    
    /**
     * Returns childs by parent id
     *
     * @return DynMenu
     */
    public function getChildren() {
        return Doo::db()->find('DynMenu', 
                    array(
                    'where'=>'Parent_ID = ?',
                    'param'=> array($this->menu_id)
                    )
                );
    }


}
?>