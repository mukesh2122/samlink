<?php
Doo::loadCore('db/DooSmartModel');

class RsRoles extends DooSmartModel {

    public $ID_ROLE;
    public $RoleName;

    public $_table = 'rs_roles';
    public $_primarykey = 'ID_ROLE';
    public $_fields = array(
        'ID_ROLE',
        'RoleName',
        );
};
?>
