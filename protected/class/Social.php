<?php

class Social {

    /***
     * returns all sn_socials objects with playerdata 
     */
    public static function getAllSocialsWithUrls($ID_OWNER, $OwnerType){
        $social = new SnSocials();
        $rel = new SnSocialsRel();
        
        $query = "SELECT * FROM {$social->_table} 
                LEFT JOIN {$rel->_table} 
                ON {$social->_table}.ID_SOCIAL = {$rel->_table}.FK_SOCIAL AND {$rel->_table}.FK_OWNER = {$ID_OWNER} AND {$rel->_table}.OwnerType = '{$OwnerType}'";
                
        $socials = Doo::db()->query($query)->fetchAll(PDO::FETCH_CLASS, 'SnSocials');
        return $socials;
    }
    
    /***
     * returns SnSocials object
     */
    public static function getSocialsWithUrls($ID_OWNER, $OwnerType){
        $social = new SnSocials();
        $rel = new SnSocialsRel();
        
        $query = "SELECT * FROM {$social->_table} 
                LEFT JOIN {$rel->_table} 
                ON {$social->_table}.ID_SOCIAL = {$rel->_table}.FK_SOCIAL 
                WHERE {$rel->_table}.FK_OWNER = {$ID_OWNER} AND {$rel->_table}.OwnerType = '{$OwnerType}'";
       
        $socials = Doo::db()->query($query)->fetchAll(PDO::FETCH_CLASS, 'SnSocials');
        
        return $socials;
    }
    
    /***
     * returns SnSocialsRel object
     */
    public static function getSocialRels($ID_OWNER, $OwnerType){
        
        $socials = Doo::db()->find('SnSocialsRel', array(
                        'where' =>  "FK_OWNER = {$ID_OWNER} AND OwnerType = '{$OwnerType}'"
        ));
                        
        return $socials;
    }
    
    public static function getSocialByName($name){
        $social = Doo::db()->getOne('SnSocials', array(
                    'where' =>  "SocialName = {$name}"
            ));
                    
        return $social;
    }
}
?>