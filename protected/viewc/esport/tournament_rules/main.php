<?php
    $esport = new Esport();
    $onlineChannels = $channels['onlineChannels'];
    $featureChannels = $channels['featureChannels'];
    $offlineChannels =$channels['offlineChannels'];
    $favoriteChannels =$channels['favoriteChannels'];
    $onlineCount = $channels['onlineCount'];
    $offlineCount = $channels['offlineCount'];
?>

<!-- Main container start -->
<div id="container" class="clearfix">
	<!-- Main content start -->
	<div id="esports_wrapper">
        <?php echo $this->renderBlock('esport/common/topbar', array()); ?>
		<!-- E-Sports content start -->
		<div class="esports_content">
        <div class="esport_profile_boxheaders top_header"><p><?php echo $this->__('<span>Stream</span> coverage') ?></p></div>
        	<div id="esports_menu" class="progressbar red_gradient_bg">
            	<div class="esports_menu_bottom"></div>
                <ul class="esports_ul full_width progressbar_text">
                <li><a class="rules active" href="#"><?php echo $this->__('Rules') ?></a></li><li><a class="tournament" href="#"><?php echo $this->__('Tournament') ?></a></li>	</ul>
            </div>
        <!-- Menu end -->
        <div class="tournament_poster">
        	<img src="../global/css/img/dota2_tournament_poster.jpg" />
        </div>
        <div class="tournament_rule">
            <div class="td_heading tournament_rules">
                <h1><?php echo $this->__('Rules') ?></h1>
            </div>
            <div class="tournament_rule_content">
                <p>1. General<br/>1.1 Administration<br/>1.1.1 Everybody who is authorized by Playnation Network to administrate the competition based on its rules and regulations will be called an "admin" or “referee" in the following, the collectivity of all admins will be called the "administration". A list of the current referees can be found here and - if existing - on the website of the competition.<br/>1.1.2 A referee is allowed to ignore or overrule any of the following rules in order to make the competition as fair as possible.
                </p>
            </div>
		</div>
        <div class="tournament_rule">
            <div class="td_heading tournament_rules active"><!-- class="active" gives red inner glow effect on the div -->
                <h1>1. <?php echo $this->__('General') ?><div class="dropdown_arrows"><a href="#Show/hide the tournament_rule_content div"><img src="../global/css/img/rules_dropdownarrow_down.png" /></a></h1><!-- img src="rules_dropdownarrow_down.png", if the box is dropped down. and img src="rules_dropdownarrow_straight.png" if the box isnt dropped down. -->
            </div>
            <div class="tournament_rule_content"> <!-- Should only be visible if the menu point is dropped down. -->
                <p>1. General<br/>1.1 Administration<br/>1.1.1 Everybody who is authorized by Playnation Network to administrate the competition based on its rules and regulations will be called an "admin" or “referee" in the following, the collectivity of all admins will be called the "administration". A list of the current referees can be found here and - if existing - on the website of the competition.<br/>1.1.2 A referee is allowed to ignore or overrule any of the following rules in order to make the competition as fair as possible.
                </p>
            </div>
		</div>
        <div class="tournament_rule">
            <div class="td_heading tournament_rules"><!-- class="active" gives red inner glow effect on the div -->
                <h1>2. <?php echo $this->__('Teams & players') ?><div class="dropdown_arrows"><a href="#Show/hide the tournament_rule_content div"><img src="../global/css/img/rules_dropdownarrow_down.png" /></a></h1>
            </div>
		</div>
        <div class="tournament_rule">
            <div class="td_heading tournament_rules"><!-- class="active" gives red inner glow effect on the div -->
                <h1>3. <?php echo $this->__('Schedule') ?><div class="dropdown_arrows"><a href="#Show/hide the tournament_rule_content div"><img src="../global/css/img/rules_dropdownarrow_straight.png" /></a></h1>
            </div>
		</div>
        <div class="tournament_rule">
            <div class="td_heading tournament_rules"><!-- class="active" gives red inner glow effect on the div -->
                <h1>4. <?php echo $this->__('Hosting & settings') ?><div class="dropdown_arrows"><a href="#Show/hide the tournament_rule_content div"><img src="../global/css/img/rules_dropdownarrow_straight.png" /></a></h1>
            </div>
		</div>
        <div class="tournament_rule">
            <div class="td_heading tournament_rules"><!-- class="active" gives red inner glow effect on the div -->
                <h1>5. <?php echo $this->__('During the match') ?><div class="dropdown_arrows"><a href="#Show/hide the tournament_rule_content div"><img src="../global/css/img/rules_dropdownarrow_straight.png" /></a></h1>
            </div>
		</div>
        <div class="tournament_rule">
            <div class="td_heading tournament_rules"><!-- class="active" gives red inner glow effect on the div -->
                <h1>6. <?php echo $this->__('Rule violation & punishment') ?><div class="dropdown_arrows"><a href="#Show/hide the tournament_rule_content div"><img src="../global/css/img/rules_dropdownarrow_straight.png" /></a></h1>
            </div>
		</div>
        <div class="tournament_rule">
            <div class="td_heading tournament_rules"><!-- class="active" gives red inner glow effect on the div -->
                <h1>7. <?php echo $this->__('Prize money distribution') ?><div class="dropdown_arrows"><a href="#Show/hide the tournament_rule_content div"><img src="../global/css/img/rules_dropdownarrow_down.png" /></a></h1>
            </div>
		</div>
        <div class="td_heading small">
        </div>
        <div class="tournament_rule">
        	<div class="tournament_rule_content">
                <p>1. General<br/>1.1 Administration<br/>1.1.1 Everybody who is authorized by Playnation Network to administrate the competition based on its rules and regulations will be called an "admin" or “referee" in the following, the collectivity of all admins will be called the "administration". A list of the current referees can be found here and - if existing - on the website of the competition.<br/>1.1.2 A referee is allowed to ignore or overrule any of the following rules in order to make the competition as fair as possible.
                </p>
            </div>
        </div>
        <div class="tournament_accept_reject">
        	<a href="#accept_only_captain_can_accept" class="tournament_accept"><p><?php echo $this->__('Accept') ?></p></a>
            <a href="#decline_only_captain_can_decline" class="tournament_decline"><p><?php echo $this->__('Decline') ?></p></a>
        </div>
		<!-- E-Sports content end -->
	</div>
	<!-- Main content end -->
</div>
<!-- Main container end -->	