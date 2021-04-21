<?php
include(dirname(__FILE__) . '/layoutadmin/conn.php');
include(dirname(__FILE__) . '/layoutadmin/design_top.php');
mysqli_close($dbc);
if(isset($header_height)) { preg_match_all('/\d+/', $header_height, $matches); };
?>
/*  == Top height ========================================================================================================================================================

	All heights of the top bar and menu. 

	====================================================================================================================================================================== */
	
#topbar_container, #topbar {
	height: <?php echo (isset($header_height)) ? $header_height : '48px'; ?>;
}

#global_nav_container {
	top: <?php echo (isset($header_height)) ? $global_nav_top = $matches[0][0] + 2 .'px;' : '50px'; ?> /* must be height of topbar_container + size of borders (if any) */
	height: 36px;
}

#global_nav a, .global_nav_action {
	line-height: 36px; /* same as height of global_nav_container */
}

.global_nav_action {
	height: 37px; /* must be height of global_nav_container + size of border-bottom (if any) */
}

.global_nav_action_dropdown {
	top: 37px; /* must be height of global_nav_action */
}

.the_one_columns_child,
#center_column,
#center_column_wide,
#center_column_wide_left,
#center_column_wide_left_admin,
#left_column,
#right_column,
#right_column_wide {
	padding-top: <?php echo (isset($global_nav_top)) ? $global_nav_top + 37 + 15 .'px;' : '102px'; ?> /* global_nav_container top + global_nav_action height + padding of choice between top and content (15px) */
}

/*  == Top bar ===========================================================================================================================================================

	====================================================================================================================================================================== */
	
#topbar_container {
	position: fixed;
	z-index: 8999;
	left: 0;
	top: 0;
	right: 0;
	border-top: 1px solid #3f3f3f;
	border-bottom: 1px solid #000;
	width: 100%;

        background-color:<?php echo ($bg_active == 'color') ? "$backgroundcolor" : '#000' ; ?>;
        
        <?php if ($bg_active == 'image'): 
            echo strpos($header_bg,'/') ? "background-image: url('$header_bg');" : "background-image: url('../pub_img/layout/".substr($header_bg, 0, 1)."/".substr($header_bg, 1, 1)."/$header_bg');";
            echo 'background-repeat: repeat-x;';
        endif; ?>
        
        <?php echo ($bg_active == 'gradient') ? "background: $gradient_top;
	background: -moz-linear-gradient(top,  $gradient_top 0%, $gradient_bottom 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,$gradient_top), color-stop(100%,$gradient_bottom));
	background: -webkit-linear-gradient(top,  $gradient_top 0%,$gradient_bottom 100%);
	background: -o-linear-gradient(top,  $gradient_top 0%, $gradient_bottom 100%);
	background: -ms-linear-gradient(top,  $gradient_top 0%, $gradient_bottom 100%);
	background: linear-gradient(top,  $gradient_top 0%,$gradient_bottom 100%);" : ''; ?>
        
        <?php if(isset($nav_border)) { echo ($nav_border == '1') ? "border-bottom: 1px solid {$topborder};" : ''; }
        else { echo "border-bottom: 1px solid #000;"; }; ?>

        <?php if(isset($nav_shadow)): ?>
            <?php echo ($nav_shadow == '1') ?
            "-webkit-box-shadow:  0px 1px 1px 0px rgba(0, 0, 0, 0.3);
            -moz-box-shadow:  0px 1px 1px 0px rgba(0, 0, 0, 0.3);
            box-shadow:  0px 1px 1px 0px rgba(0, 0, 0, 0.3);" : ''; ?>
        <?php else:
            echo "-webkit-box-shadow:  0px 1px 1px 0px rgba(0, 0, 0, 0.3);
            -moz-box-shadow:  0px 1px 1px 0px rgba(0, 0, 0, 0.3);
            box-shadow:  0px 1px 1px 0px rgba(0, 0, 0, 0.3);";
            endif;?>
}

#topbar {
	position: relative;
	width: 1082px;
        height: <?php echo (isset($header_height)) ? $header_height : '48px'; ?>;
	margin: 0 auto;
}

#header .logo img {
	margin-top: <?php echo (isset($logo_top)) ? $logo_top : '4px';?>;
	margin-left: <?php echo (isset($logo_left)) ? $logo_left : '0';?>;
}

/*  == Top menu ==========================================================================================================================================================

	====================================================================================================================================================================== */

#global_nav_container {
	position: fixed;
	z-index: 8998;
	left: 0;
	right: 0;

	width: 100%;
        
        <?php if(isset($nav_border)) { echo ($nav_border == '1') ? "border-bottom: 1px solid {$bottomborder};" : ''; }
        else { echo "border-bottom: 1px solid #afafaf;"; };
	
        if(isset($nav_shadow)) {
            echo ($nav_shadow == '1') ?
            "-webkit-box-shadow:  0px 0px 3px 0px rgba(0, 0, 0, 0.2);
            -moz-box-shadow:  0px 0px 3px 0px rgba(0, 0, 0, 0.2);
            box-shadow:  0px 0px 3px 0px rgba(0, 0, 0, 0.2);"
            : ''; }
        else {
            echo "-webkit-box-shadow:  0px 0px 3px 0px rgba(0, 0, 0, 0.2);
            -moz-box-shadow:  0px 0px 3px 0px rgba(0, 0, 0, 0.2);
            box-shadow:  0px 0px 3px 0px rgba(0, 0, 0, 0.2);"; };
        ?>
        

}
#global_nav_wrapper {
	width: 1094px;
	margin: 0 auto;
}

#global_nav {}

#global_nav ul {
	float: left;
	list-style: none;
        
        <?php if(isset($nav_border)) { echo ($nav_border == '1') ? "border-left: 1px solid {$nav_splitter};" : ''; }
        else { echo "border-left: 1px solid #c2c2c2;"; }; ?>
}

#global_nav li {
	float: left;
	text-align: center;
}

#global_nav a {
	display: block;
	padding: 0 15px;
	font-size: <?php echo (isset($nav_fontsize)) ? $nav_fontsize : '13px'; ?>;
	font-weight: bold;
	color: <?php echo (isset($nav_fontcolor)) ? $nav_fontcolor : '#333'; ?>;
	text-decoration: none;

        <?php if(isset($nav_border)) { echo ($nav_border == '1') ? "border-right: 1px solid $nav_splitter;" : ''; }
        else { echo "border-right: 1px solid #c2c2c2;"; }; ?>
}

/* Hover state */
#global_nav a:hover {
	text-decoration: none;
	color: <?php echo (isset($hover_fontcolor)) ? $hover_fontcolor : '#333'; ?>;
        
        <?php $hover_topcolor = isset($hover_topcolor) ? $hover_topcolor : '#fbfbfb' ?>
        <?php $hover_bottomcolor = isset($hover_bottomcolor) ? $hover_bottomcolor : '#d7d7d7' ?>
        
        background: <?php echo $hover_topcolor; ?>;
        background: -moz-linear-gradient(top,  <?php echo $hover_topcolor; ?> 0%, <?php echo $hover_bottomcolor; ?> 100%);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,<?php echo $hover_topcolor; ?>), color-stop(100%,<?php echo $hover_bottomcolor; ?>));
        background: -webkit-linear-gradient(top,  <?php echo $hover_topcolor; ?> 0%,<?php echo $hover_bottomcolor; ?> 100%);
        background: -o-linear-gradient(top,  <?php echo $hover_topcolor; ?> 0%,<?php echo $hover_bottomcolor; ?> 100%);
        background: -ms-linear-gradient(top,  <?php echo $hover_topcolor; ?> 0%,<?php echo $hover_bottomcolor; ?> 100%);
        background: linear-gradient(top,  <?php echo $hover_topcolor; ?> 0%,<?php echo $hover_bottomcolor; ?> 100%);
}

/* Active state */
#global_nav .active a, 
#global_nav .active a:hover {
	color: <?php echo (isset($active_fontcolor)) ? $active_fontcolor : '#333'; ?>;
        background: <?php echo (isset($active_background)) ? $active_background : '#eee'; ?>;

	-moz-box-shadow: inset 0px 1px 3px 0px rgba(0, 0, 0, 0.2);
	-webkit-box-shadow: inset 0px 1px 3px 0px rgba(0, 0, 0, 0.2);
	box-shadow: inset 0px 1px 3px 0px rgba(0, 0, 0, 0.2);
}

/*  == Top menu actions ==================================================================================================================================================

	====================================================================================================================================================================== */
	
.global_nav_actions {
	list-style: none;
	float: right;
}

.global_nav_actions_li {
	position: relative;
	float: left;
}

.global_nav_actions_li_c {
	position: relative;
	float: right;
}
.global_nav_action {
	display: block;
	padding: 0 10px;
	color: #454545;
	font-weight: bold;
	text-rendering: optimizeLegibility;
	-webkit-font-smoothing: antialiased;
	border-left: 1px solid transparent;
	border-right: 1px solid transparent;
}

.global_nav_action span {
	font-weight: normal;
}

.global_nav_action i {
	margin-left: 3px;
}

/* hover state*/
.global_nav_action:hover {
	text-decoration: none;
	color: #333333;
}

/* active state */
.global_nav_action.open {
	color: #333333;
	background-color: #FFFFFF;
	border-left: 1px solid #B5B5B5;
	border-right: 1px solid #B5B5B5;
}

.global_nav_action_dropdown {
	display: none;
	position: absolute;
	right: 0;
	z-index: 1000;
	border: 1px solid #B5B5B5;
	border-top: 0;
	border-bottom-color: #AAAAAA;
	background-color: #FFFFFF;

	-webkit-box-shadow: 0 7px 8px rgba(0, 0, 0, 0.2);
	-moz-box-shadow: 0 7px 8px rgba(0, 0, 0, 0.2);
	box-shadow: 0 7px 8px rgba(0, 0, 0, 0.2);
}


.dropdown_form {
}

.dropdown_form_list {
	padding: 15px 15px 0px 15px;
}

.dropdown_form .login_error {
	color: #ff0000;
	margin-bottom: 10px;
}

.dropdown_form label.error {
	margin: -12px 0 2px 0;
	background: none;
	display: block;
	color: #ff0000;
	font-size: 12px;
	font-family: Arial, "Helvetica Neue", Helvetica, sans-serif;
}

.dropdown_form_terms label.error {
	margin: 4px 0 2px 0;
}

.dropdown_form_label {
	display: block;
	cursor: pointer;
	margin-bottom: 2px;
	color: #333333;
}

.dropdown_form_input {
	margin-bottom: 15px;
	font-size: 12px;
	line-height: 28px;
	border: 1px solid #CCCCCC;
	width: 218px;
	height: 28px;
	padding: 0 6px 0 6px;
	color: #333333;

	-webkit-box-shadow:
		inset 0px 1px 2px 0px rgba(116, 116, 116, 0.1);
	-moz-box-shadow: 
		inset 0px 1px 2px 0px rgba(116, 116, 116, 0.1);
	box-shadow: 
		inset 0px 1px 2px 0px rgba(116, 116, 116, 0.1);

	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
}

.dropdown_form_input:hover {
	border: 1px solid #B5B5B5;
}

.dropdown_form_input:focus {
	border: 1px solid #AAAAAA;

	-webkit-box-shadow:
		inset 0px 1px 2px 0px rgba(116, 116, 116, 0.2);
	-moz-box-shadow: 
		inset 0px 1px 2px 0px rgba(116, 116, 116, 0.2);
	box-shadow: 
		inset 0px 1px 2px 0px rgba(116, 116, 116, 0.2);
}

.dropdown_form_input.error {
	background-image: none;
	color: #ff0000;
	border-color: #FF0000;
}

.dropdown_form_footer {
	padding: 15px;
	background-color: #f4f4f4;
}

.dropdown_form_left_link {
	float: left;
	display: block;
	margin-top: 7px;
}

.dropdown_form_button {
	float: right;
	padding: 8px 14px;
	font-size: 12px;
	line-height: 12px;
	text-decoration: none;
	text-align: center;
	cursor: pointer;

	-webkit-box-shadow: 
		0px 1px 1px 0px rgba(0, 0, 0, 0.2),
		inset 0px 1px 0px 0px rgba(255, 255, 255, 0.2);
	-moz-box-shadow: 
		0px 1px 1px 0px rgba(0, 0, 0, 0.2),
		inset 0px 1px 0px 0px rgba(255, 255, 255, 0.2);
	box-shadow: 
		0px 1px 1px 0px rgba(0, 0, 0, 0.2),
		inset 0px 1px 0px 0px rgba(255, 255, 255, 0.2);

	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
}

.dropdown_form_button:hover {
	text-decoration: none;
}

.alt_signin {
	padding: 4px 15px 15px 15px;
}

.alt_signin a {
	display: block;
	font-size: 11px;
	color: #999999;
	margin-bottom: 4px;
}

.facebook_icon, .twitter_icon, .twitch_icon {
	margin: 0px 5px 0px 2px;
}

.dropdown_lang_select {
	min-width: 200px;
	padding: 6px 0 6px 0;
}


.dropdown_games_select li,
.dropdown_lang_select li {
	display: block;
}

.dropdown_lang_select a {
	display: block;
	font-size: 12px;
	line-height: 18px;
	padding: 6px 12px;
	color: #333;
	white-space: nowrap;
}

.dropdown_lang_select li > a:hover {
	color: #FFFFFF;
	text-decoration: none;
	background-color: #0084C7;
}

.dropdown_lang_select li.active a {
	color: #FFFFFF;
	text-decoration: none;
	background-color: #0084C7;
}

.lang_flag {
	margin-top: -1px;
}

.lang_flag_list {
	margin: -1px 5px 0 0;
}

/*  == Top menu search ==================================================================================================================================================

	====================================================================================================================================================================== */

#global_search {
	position: absolute;
	right: 0;
	top: 9px;
}

#global_search input {
	font: 12px/12px Helvetica, Arial, sans-serif;
	color: #999999;
	border: solid 1px #151515;
	width: 175px;
	height: 26px;
	padding-left: 25px;

	background-color: #FFFFFF;
    background-repeat: no-repeat;
    background-position: 8px -953px;
    background-image: url('img/n_icon_sprite.png');

	-moz-box-shadow: inset 2px 2px 3px 0px rgba(0, 0, 0, 0.4);
	-webkit-box-shadow: inset 2px 2px 3px 0px rgba(0, 0, 0, 0.4);
	box-shadow: inset 2px 2px 3px 0px rgba(0, 0, 0, 0.4);

	-webkit-border-radius: 14px;
	-moz-border-radius: 14px;
	border-radius: 14px;

	-moz-background-clip: padding;
	-webkit-background-clip: padding-box;
	background-clip: padding-box;
}

#global_search input:focus {
	color: #333333;
	background-position: 8px -993px;
}

/*  == Developerbar ==================================================================================================================================================

	====================================================================================================================================================================== */
#developerbar {
    position: absolute;
    left: 40%;
	top: 30%;
}
#developerbar label {
    display: inline-block;
    float: left;
}
#usergroup {
	width: 120px;
}
#dk_container_usergroup {
    display: inline-block;
    float: right;
    margin-left: 10px;
}
#dk_container_usergroup a.dk_toggle {
    padding-top: 1px;
    height: 12px;
}
/*  == Recruitment stuff =================================================================================================================================================

	====================================================================================================================================================================== */
    
.dropdown_games_select {
	min-width: 200px;
    height: 200px;
    overflow:auto;
	padding: 6px 0 6px 0;
}