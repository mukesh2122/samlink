<?php
include(dirname(__FILE__) . '/layoutadmin/conn.php');
include(dirname(__FILE__) . '/layoutadmin/footer.php');
mysqli_close($dbc);
?>
/*  == Footer ============================================================================================================================================================

	====================================================================================================================================================================== */

#footer {
	position: relative;
	// margin-bottom: 88px; /* heigt + border + size of #bottomBar from chat.css (not #bottombar below) */
        clear: both;	
	height: <?php echo (isset($height)) ? $height : '61px'; ?>;
	width: 100%;
}

#bottombar {
	width: 1064px;
	margin: 0 auto 50px auto;	
	<?php echo ($borderactive == '1') ? "border-top: 1px solid $bordercolor;" : ''; ?>
	<?php echo ($bg_active == 'color') ? "background-color: $backgroundcolor;" : 'background-color: #eee;' ; ?>
        
        <?php if ($bg_active == 'image'): 
            echo strpos($bg_img,'/') ? "background-image: url('$bg_img');" : "background-image: url('../pub_img/layout/".substr($bg_img, 0, 1)."/".substr($bg_img, 1, 1)."/$bg_img');";
            echo 'background-repeat: repeat-x'; 
        endif;?>
        <?php echo ($bg_active == 'gradient') ? "background: -moz-linear-gradient(top, $gradient_top, $gradient_bottom);" : ''; ?>
        <?php echo ($bg_active == 'gradient') ? "background: $gradient_top;
	background: -moz-linear-gradient(top,  $gradient_top 0%, $gradient_bottom 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,$gradient_top), color-stop(100%,$gradient_bottom));
	background: -webkit-linear-gradient(top,  $gradient_top 0%,$gradient_bottom 100%);
	background: -o-linear-gradient(top,  $gradient_top 0%, $gradient_bottom 100%);
	background: -ms-linear-gradient(top,  $gradient_top 0%, $gradient_bottom 100%);
	background: linear-gradient(top,  $gradient_top 0%,$gradient_bottom 100%);" : ''; ?>
        
        height: <?php echo (isset($height)) ? $height : '61px'; ?>;
	padding: 0px 14px 15px 14px;
}

#footer .logo {
 float: left;
}

#footer .logo img {
	margin-top: <?php echo (isset($top)) ? $top : '23px'; ?>;
	margin-left: <?php echo (isset($left)) ? $left : '0'; ?>;
}

.footer_nav {
	float: left;
}

.footer_social_nav {
	float: right;
}

.footer_social_nav li {
	display: inline;
}

.footer_nav,
.footer_social_nav {
	list-style: none;
	margin-top: 23px;
	margin-left: 15px;
}

.footer_nav li {
	display: inline;
	border-right: 1px solid #999;
}

.footer_nav a,
.footer_social_nav a {
	color: #666;
	font-size: 13px;
	padding: 0 8px;
}

.footer_social_nav i {
	margin-bottom: 1px;
}