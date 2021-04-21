<?php
include(dirname(__FILE__) . '/layoutadmin/conn.php');
include(dirname(__FILE__) . '/layoutadmin/designcolors.php');
mysqli_close($dbc);
?>
/*  == Backgrounds =======================================================================================================================================================

	====================================================================================================================================================================== */

.horizontal_tabs li:hover, .wall_item_comment_container {
	background-color: #f7f7f7;
}

#container, .horizontal_tabs li.active, .horizontal_tabs li.active:hover, .wall_input textarea, .wall_item_comment_input textarea {
	background-color: #fff;
}

.global_info_meta_table, .play_ftp_now, .horizontal_tabs li, .wall_input {
	background-color: #f2f2f2;
}

.horizontal_tabs li:hover, .wall_item_comment_container {
	background-color: #f7f7f7;
}
body {
	<?php
        if($bg_active == 'color')
            echo "background: $bg_color;";
        else if($bg_active == 'image')
            echo strpos($background,'/') ? "background: url('$background');" : "background: url('../pub_img/layout/".substr($background, 0, 1)."/".substr($background, 1, 1)."/$background');";
        else if($bg_active == 'gradient'){
            echo "background: $bg_topgradient;
	background: -moz-linear-gradient(top,  $bg_topgradient 0%, $bg_bottomgradient 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,$bg_topgradient), color-stop(100%,$bg_bottomgradient));
	background: -webkit-linear-gradient(top,  $bg_topgradient 0%,$bg_bottomgradient 100%);
	background: -o-linear-gradient(top,  $bg_topgradient 0%, $bg_bottomgradient 100%);
	background: -ms-linear-gradient(top,  $bg_topgradient 0%, $bg_bottomgradient 100%);
	background: linear-gradient(top,  $bg_topgradient 0%,$bg_bottomgradient 100%);";
        }
        else
           echo "background: url('img/site_bg.gif');"; 
        ?>
	margin-bottom: 25px;
}

/*  == Borders ===========================================================================================================================================================

	====================================================================================================================================================================== */
	
#container {
	border-color: #b5b5b5;

	-webkit-box-shadow: 0 7px 8px rgba(0, 0, 0, 0.2);
	-moz-box-shadow: 0 7px 8px rgba(0, 0, 0, 0.2);
	box-shadow: 0 7px 8px rgba(0, 0, 0, 0.2);
}

.wall_input_button:hover, .wall_item_comment_input_button:hover, .thumbnail img:hover {
	border-color: #bbb;
}

#center_column, .global_info_page, .global_info_meta_table, .play_ftp_now, .table th, .table td, .table tbody + tbody, .table_bordered, .left_nav li,
.horizontal_tabs, .horizontal_tabs li, .wall_input, .wall_input_button, .wall_item_comment, .wall_item, .wall_item_link_meta, .wall_item_comment_input textarea,
.wall_item_comment_input_button, .thumbnail img {
	border-color: #ccc;
}

/*  == Text colors =======================================================================================================================================================

	====================================================================================================================================================================== */
	
.global_info_meta_table, .play_ftp_now, .left_nav ul li a:hover, .wall_item_link_title, .wall_item_link_title:hover, .wall_item_article_header,
.wall_item_article_header:hover {
	color: #333;
}

body, .left_nav ul li a, .horizontal_tabs a, .horizontal_tabs a:hover, .wall_input textarea:focus, .wall_input_button, .wall_input_button:hover,
.wall_item_comment_input textarea:focus, .wall_item_comment_input_button, .wall_item_comment_input_button:hover {
	color: #666;
}

.wall_input textarea, .wall_item_date, .wall_item_link_description, .wall_item_article_description, .wall_item_comment_input textarea, .comment_item_delete_trigger {
	color: #999;
}

/* blue */

a, a:hover, .left_nav ul li.active a {
	color: #0f7cb9;
}

/* red */

.comment_item_delete_trigger:hover {
	color: #ff6442;
}

/*  == Gradients =========================================================================================================================================================

	====================================================================================================================================================================== */
	
/* top menu and filter bar gradient */

#global_nav_container, .filter_bar {
	<?php
        if($menu_active == 'color')
            echo "background: $menu_color;";
        else if($menu_active == 'image')
            echo strpos($menu_image,'/') ? "background: url('$menu_image');" : "background: url('../pub_img/layout/".substr($menu_image, 0, 1)."/".substr($menu_image, 1, 1)."/$menu_image');";
        else if($menu_active == 'gradient'){
            echo "background: $topgradient;
	background: -moz-linear-gradient(top,  $topgradient 0%, $bottomgradient 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,$topgradient), color-stop(100%,$bottomgradient));
	background: -webkit-linear-gradient(top,  $topgradient 0%,$bottomgradient 100%);
	background: -o-linear-gradient(top,  $topgradient 0%, $bottomgradient 100%);
	background: -ms-linear-gradient(top,  $topgradient 0%, $bottomgradient 100%);
	background: linear-gradient(top,  $topgradient 0%,$bottomgradient 100%);";
        }
        else{
           echo "background: #f0f0f0;
	background: -moz-linear-gradient(top,  #f0f0f0 0%, #d3d3d3 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#f0f0f0), color-stop(100%,#d3d3d3));
	background: -webkit-linear-gradient(top,  #f0f0f0 0%,#d3d3d3 100%);
	background: -o-linear-gradient(top,  #f0f0f0 0%, #d3d3d3 100%);
	background: -ms-linear-gradient(top,  #f0f0f0 0%, #d3d3d3 100%);
	background: linear-gradient(top,  #f0f0f0 0%,#d3d3d3 100%);";
        }
        ?>
}

/* very light grey gradient */

.wall_input_button, .wall_item_comment_input_button {
	background: #fff;
	background: -moz-linear-gradient(top,  #fff 0%, #f2f2f2 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fff), color-stop(100%,#f2f2f2));
	background: -webkit-linear-gradient(top,  #fff 0%,#f2f2f2 100%);
	background: -o-linear-gradient(top,  #fff 0%,#f2f2f2 100%);
	background: -ms-linear-gradient(top,  #fff 0%,#f2f2f2 100%);
	background: linear-gradient(top,  #fff 0%,#f2f2f2 100%);
}