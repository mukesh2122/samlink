<?php if(Auth::isUserLogged()):
    $userOnTwitch = Auth::isUserOnTwitch(); ?>
    <div id="bottomBar">
        <section id="twitchMenuContainer" class="bottomBarLeft">
            <?php if($userOnTwitch): ?>
                <button class="alt_signout_twitch di notification notification_red buttonRRound mt2 fl" id="twitch_logout"><?php echo $this->__("Logout"); ?></button>
            <?php else: ?>
                <button class="alt_signin_twitch di notification notification_red buttonRRound mt2 fl" id="twitch_login"><?php echo $this->__("Login"); ?></button>
            <?php endif; ?>
            <header id="toggleTwitch" class="twitchToggler"><?php echo "Twitch"; ?></header>
            <?php if($userOnTwitch): ?>
                <header id="twitchFeatured" class="fftoggler"><?php echo $this->__("FEATURED"); ?></header>
                <header id="twitchFollowed" class="fftoggler"><?php echo $this->__("FOLLOWED"); ?></header>
                <script type="text/javascript">createCookie("twitchLoggedIn", "yes");</script>
            <?php endif; ?>
            <ul id="twitchStreamList"></ul>
        </section>
        <section class="bottomBarMid">
            <?php if(Auth::isUserDeveloper()) : ?>
                <span id="bottomDevBut"><?php echo $this->__("DevMenu"); ?></span>
                <div id="bottomDevMenu">
                    <ul>
                        <li id="showPhpInfo"><a href="<?php echo MainHelper::site_url('admin/devmenu/showphpinfo'); ?>"><?php echo $this->__("Phpinfo"); ?></a></li>
                        <li id="showSessVars"><a href="<?php echo MainHelper::site_url('admin/devmenu/showsession'); ?>"><?php echo $this->__("Session Variables"); ?></a></li>
                    </ul>
                </div>
            <?php endif; ?>
            <div id="twitchStream" class="twichShadow">
                <button id="closeTwitchStream"></button>
                <!--<iframe id="twitch_live_embed_player_flash" type="text/html" width="657" height="400" frameborder="0"></iframe>-->
                <!--<object data="http://www.twitch.tv/widgets/live_embed_player.swf"></object>-->
                <!--<object data="http://www.twitch.tv/widgets/archive_embed_player.swf"></object>-->
                <embed type="application/x-shockwave-flash" id="twitch_live_embed_player_flash" bgcolor="#EEEEEE" scale="noborder" embed="1" height="400" width="657" allowScriptAccess="always" allowNetworking="all" allowFullScreen="true" wmode="transparent" autoStart="true" quality="low" src="http://www-cdn.jtvnw.net/swflibs/TwitchPlayer.swf">
                <!--<embed src="http://www.twitch.tv/widgets/live_embed_player.swf">-->
                <!--<embed src="http://www.twitch.tv/widgets/archive_embed_player.swf">-->
                <!--<object type="application/x-shockwave-flash" id="twitch_live_embed_player_flash" height="400" width="657" data="http://www-cdn.jtvnw.net/swflibs/TwitchPlayer.swf">-->
                    <!--<param name="allowScriptAccess" value="always">-->
                    <!--<param name="allowFullScreen" value="true">-->
                    <!--<param name="allowNetworking" value="all">-->
                    <!--<param name="wmode" value="transparent">-->
                    <!--<param name="scale" value="noborder">-->
                    <!--<param name="bgcolor" value="#EEEEEE">-->
                    <!--<param name="embed" value="1">-->
                    <!--<param name="autoStart" value="true">-->
                    <!--<param id="playChannel" name="flashvars" value="">-->
                <!--</object>-->
                <iframe id="twitch_chat_embed" type="text/html" height="400" width="300" scrolling="no" frameborder="0" seamless="seamless"></iframe>
            </div>
        </section>
        <section class="bottomBarRight">
            <div id="listContainer">
                <div id="friendlistContainer" class="chatShadow">
                    <header id="toggleFriends" class="chatToggler"><?php echo $this->__("Friends"); ?><span id="onlineCount">0</span></header>
                    <ul id="friendButtonContainer"></ul>
                </div>
                <div id="convlistContainer">
                    <header id="toggleConv" class="chatToggler"><?php echo $this->__("Conversations"); ?><span id="converCount">0</span></header>
                    <ul id="cButtonContainer"></ul>
                </div>
            </div>
            <div id="chatContainer" class="chatAndTwichShadow">
                <div id="chatHeader"><span id="chatkryds"></span><span id="chatfriendname"></span></div>
                <div id="chatMessageContainer"></div>
                <form id="chatMessageForm" name="chatMessageForm" autocomplete="off">
                    <input type="text" id="chatMessage" autocomplete="off" name="chatMessage">
                    <input type="submit" value="<?php echo $this->__("Ok"); ?>" autocomplete="off">
                </form>
            </div>
            <div id="friendMenuContainer">
                <ul>
                    <li id="newConversation" ref="" class="chatAndTwichShadow"><a href="javascript:void(0);"><?php echo $this->__("New conversation"); ?></a></li>
                    <li id="addToConversation" ref="" class="chatAndTwichShadow"><a href="javascript:void(0);"><?php echo $this->__("Add to conversation"); ?></a></li>
                </ul>
            </div>
        </section>
    </div>
<?php endif; ?>