<?php

class Prefix {

    public static function getPrefixes() {
        $prefix = new NwPrefixes();
        return $prefix->find(array('asc' => 'PrefixName', 'where' => 'isLocked = 0'));
    }

    public static function getPrefixesAll() {
        $prefix = new NwPrefixes();
        return $prefix->find(array('asc' => 'PrefixName'));
    }

    public static function getPrefixById($ID_PREFIX = NULL) {
        if(NULL === $ID_PREFIX) { return FALSE; };
        $prefix = new NwPrefixes();
        $prefix->ID_PREFIX = $ID_PREFIX;
        $result = $prefix->getOne();
        if(!$result) { return FALSE; };
        $result->applyUserLangs(TRUE);
        return $result;
    }
}
?>