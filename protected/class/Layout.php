<?php

class Layout {

    public static function getDefaultLayout(){
        $list = Doo::db()->find('SyLayout', array(
                        'where' => 'isDefault = 1'
        ));
        
        return $list;
    }
    public static function getCurrentLayout(){
        $list = Doo::db()->find('SyLayout', array(
                        'where' => 'isActive = 1'
        ));
        
        return $list;
    }
    public static function getActiveLayout($style){
        $list = Doo::db()->getOne('SyLayout', array(
                        'where' => "Name = '{$style}'  AND isActive = 1"
        ));
        
        return $list;
    }
    public static function getActiveLayoutValue($style){
        $list = Doo::db()->getOne('SyLayout', array(
                        'where' => "Name = '{$style}'  AND isActive = 1"
        ));
        
        if($list) { return $list->Value; };
    }
    public function resetLayout($category){
        $query = "UPDATE sy_layout SET isActive = 0 WHERE isDefault = 0 AND Menu = '{$category}';
                    UPDATE sy_layout SET isActive = 1 WHERE isDefault = 1 AND Menu = '{$category}';";
        
        Doo::db()->query($query);
    }
    public function saveGeneralLayout($post){
        $general = 'general';
        extract($post);
        
        if (isset($bg_active)){
            self::saveLayoutStyle($bg_active,'general_bg_active',$general);
        }
        if (isset($bg_color)){
            self::saveLayoutStyle($bg_color,'general_bg_color',$general);
        }
        if (isset($bg_gradient_start)){
            self::saveLayoutStyle($bg_gradient_start,'general_bg_startgradient',$general);
        }
        if (isset($bg_gradient_stop)){
            self::saveLayoutStyle($bg_gradient_stop,'general_bg_stopgradient',$general);
        }
        if (isset($layout_background_uploader)){
            self::saveLayoutStyle($layout_background_uploader,'general_bg_img',$general);
        }
    }
    
    public function saveSiteInfo($post){
        $siteinfo = 'siteinfo';
        extract($post);

        if (isset($facebook)){
            $value = filter_var($facebook, FILTER_SANITIZE_STRING);
            self::saveLayoutStyle($value, 'siteinfo_social_facebook', $siteinfo);
        }
        if (isset($twitter)){
            $value = filter_var($twitter, FILTER_SANITIZE_STRING);
            self::saveLayoutStyle($value, 'siteinfo_social_twitter', $siteinfo);
        }
        if (isset($linkedin)){
            $value = filter_var($linkedin, FILTER_SANITIZE_STRING);
            self::saveLayoutStyle($value, 'siteinfo_social_linkedin', $siteinfo);
        }
        if (isset($name)){
            $value = filter_var($name, FILTER_SANITIZE_STRING);
            self::saveLayoutStyle($value, 'siteinfo_site_name', $siteinfo);
        }
        if (isset($creator)){
            $value = filter_var($creator, FILTER_SANITIZE_STRING);
            self::saveLayoutStyle($value, 'siteinfo_register_creator', $siteinfo);
        }
        if (isset($approver)){
            $value = filter_var($approver, FILTER_SANITIZE_STRING);
            self::saveLayoutStyle($value, 'siteinfo_register_approver', $siteinfo);
        }
        if (isset($agelimit)) {
            $value = filter_var($agelimit, FILTER_VALIDATE_INT, array('options' => array('default' => '')));
            self::saveLayoutStyle($value, 'siteinfo_age_limit', $siteinfo);
        }
    }
    
    public function saveHeaderLayout($post){
        $header = 'header';
        extract($post);
        
        if (isset($bg_active)){
            self::saveLayoutStyle($bg_active,'header_bg_active',$header);
        }
        if (isset($searchbar)){
            self::saveLayoutStyle($searchbar,'header_searchbar_active',$header);
        }
        else self::saveLayoutStyle(0,'header_searchbar_active',$header);
        if (isset($layout_background_uploader)){
            self::saveLayoutStyle($layout_background_uploader,'header_bg_img',$header);
        }
        if (isset($header_color)){
            self::saveLayoutStyle($header_color,'header_bg_color',$header);
        }
        if (isset($header_gradient_start)){
            self::saveLayoutStyle($header_gradient_start,'header_bg_startgradient',$header);
        }
        if (isset($header_gradient_stop)){
            self::saveLayoutStyle($header_gradient_stop,'header_bg_stopgradient',$header);
        }
        if (isset($layout_logo_uploader)){
            self::saveLayoutStyle($layout_logo_uploader,'header_logo_img',$header);
        }
        if (isset($logo_top)){
            self::saveLayoutStyle($logo_top,'header_logo_top',$header);
        }
        if (isset($logo_left)){
            self::saveLayoutStyle($logo_left,'header_logo_left',$header);
        }
        if (isset($header_height)){
            self::saveLayoutStyle($header_height,'header_height',$header);
        }
        if (isset($logo_title)){
            self::saveLayoutStyle($logo_title,'header_logo_title',$header);
        }           
    }
    public function saveTopmenuLayout($post){
        $topmenu = 'topmenu';
        extract($post);
        
        if (isset($font_shadow)){
            self::saveLayoutStyle($font_shadow,'top_font_shadow',$topmenu);
        }
        else self::saveLayoutStyle(0,'top_font_shadow',$topmenu);
        if (isset($border_active)){
            self::saveLayoutStyle($border_active,'top_border_active',$topmenu);
        }
        else self::saveLayoutStyle(0,'top_border_active',$topmenu);
        if (isset($bg_active)){
            self::saveLayoutStyle($bg_active,'top_bg_active',$topmenu);
        }
        else self::saveLayoutStyle(0,'footer_border_active',$topmenu);
        if (isset($font_color)){
            self::saveLayoutStyle($font_color,'top_font_color',$topmenu);
        }
        if (isset($font_size)){
            self::saveLayoutStyle($font_size,'top_font_size',$topmenu);
        }
        if (isset($layout_background_uploader)){
            self::saveLayoutStyle($layout_background_uploader,'top_bg_img',$topmenu);
        }  
        if (isset($bg_color)){
            self::saveLayoutStyle($bg_color,'top_bg_color',$topmenu);
        }
        if (isset($gradient_top)){
            self::saveLayoutStyle($gradient_top,'top_bg_startgradient',$topmenu);
        }
        if (isset($gradient_bottom)){
            self::saveLayoutStyle($gradient_bottom,'top_bg_stopgradient',$topmenu);
        }
        if (isset($border_top)){
            self::saveLayoutStyle($border_top,'top_border_top',$topmenu);
        }
        if (isset($border_bottom)){
            self::saveLayoutStyle($border_bottom,'top_border_bottom',$topmenu);
        }
        if (isset($border_splitter)){
            self::saveLayoutStyle($border_splitter,'top_border_splitter',$topmenu);
        }            
        if (isset($hover_fontcolor)){
            self::saveLayoutStyle($hover_fontcolor,'top_hover_fontcolor',$topmenu);
        }
        if (isset($hover_start)){
            self::saveLayoutStyle($hover_start,'top_hover_startgradient',$topmenu);
        }
        if (isset($hover_stop)){
            self::saveLayoutStyle($hover_stop,'top_hover_stopgradient',$topmenu);
        }
        if (isset($active_fontcolor)){
            self::saveLayoutStyle($active_fontcolor,'top_active_fontcolor',$topmenu);
        }
        if (isset($active_color)){
            self::saveLayoutStyle($active_color,'top_active_color',$topmenu);
        }
    }
    public function saveFooterLayout($post){
        $footer = 'footer';
        extract($post);
        
        if (isset($border_active)){
            self::saveLayoutStyle($border_active,'footer_border_active',$footer);
        }
        else self::saveLayoutStyle(0,'footer_border_active',$footer);
        if (isset($bg_active)){
            self::saveLayoutStyle($bg_active,'footer_bg_active',$footer);
        }
        else self::saveLayoutStyle(0,'footer_border_active',$footer);
        if (isset($footer_height)){
            self::saveLayoutStyle($footer_height,'footer_height',$footer);
        }
        if (isset($border_color)){
            self::saveLayoutStyle($border_color,'footer_border_color',$footer);
        }
        if (isset($layout_logo_uploader)){
            self::saveLayoutStyle($layout_logo_uploader,'footer_logo_img',$footer);
        }
        if (isset($logo_top)){
            self::saveLayoutStyle($logo_top,'footer_logo_top',$footer);
        }
        if (isset($logo_left)){
            self::saveLayoutStyle($logo_left,'footer_logo_left',$footer);
        }
        if (isset($layout_background_uploader)){
            self::saveLayoutStyle($layout_background_uploader,'footer_bg_img',$footer);
        }
        if (isset($bg_color)){
            self::saveLayoutStyle($bg_color,'footer_bg_color',$footer);
        }
        if (isset($bg_gradient_start)){
            self::saveLayoutStyle($bg_gradient_start,'footer_bg_startgradient',$footer);
        }
        if (isset($bg_gradient_stop)){
            self::saveLayoutStyle($bg_gradient_stop,'footer_bg_stopgradient',$footer);
        }
            
    }
    public function saveLayoutStyle($value, $name, $category = 'general', $active = 1, $default = 0){
        $layout = new SyLayout();
        
        $query = "INSERT INTO {$layout->_table} (Value,Name,Menu,isActive, isDefault) VALUES ('{$value}','{$name}','{$category}',{$active},{$default})
                    ON DUPLICATE KEY UPDATE {$layout->_table}.Value = Values(Value), {$layout->_table}.isActive = {$active} ";
          
        Doo::db()->query($query);
        
              
        if($active == 1){
            $swap = $default == 0 ? 1 : 0;
            $query = "UPDATE {$layout->_table} SET isActive = 0 WHERE Name = '{$name}' AND isActive = 1 AND isDefault = {$swap}";
            Doo::db()->query($query);
        }
    }

    public function saveRightColumnWidget($post) {
        extract($post);

        $wID = isset($widget_ID) ? $widget_ID : 0;
        $wName = isset($widget_Name) ? $widget_Name : '';
        $wModule = isset($widget_Module) ? $widget_Module : 'all';
        $wIsDefault = isset($widget_isDefault) ? $widget_isDefault : 1;
        $wIsHidden = isset($widget_isHidden) ? $widget_isHidden : 0;

        $query = "UPDATE sn_widgets 
            SET Name = '{$wName}', Module = '{$wModule}', isDefault = $wIsDefault, isHidden = $wIsHidden 
            WHERE ID_WIDGET = $wID";

        Doo::db()->query($query);
    }

    public function newRightColumnWidget($post) {
        extract($post);

        $wName = isset($widget_Name) ? $widget_Name : '';
        $wModule = isset($widget_Module) ? $widget_Module : 'all';
        $wIsDefault = isset($widget_isDefault) ? $widget_isDefault : 1;
        $wIsHidden = isset($widget_isHidden) ? $widget_isHidden : 0;

        $query = "INSERT INTO sn_widgets (Name, Module, isDefault, isHidden) 
            VALUES ('{$wName}', '{$wModule}', $wIsDefault, $wIsHidden)";

        Doo::db()->query($query);
    }

    public function deleteRightColumnWidget($id) {
        $query = "DELETE FROM sn_widgets WHERE ID_WIDGET = $id";
        Doo::db()->query($query);
    }
}

?>