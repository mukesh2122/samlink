<script type="text/javascript">
    var consts = (function(window) { // variables in here can not be overwritten
        var MyReadonlyConstruct = function() {
            var UndefinedVar; // use this instead of testing against typeof "undefined" |->  somevar !== consts.undefined
            this.undefined = (function() { return UndefinedVar; }());

            var RSsignUp = "<?php echo (isset($SignUpPage)) ? "true" : "false"; ?>";
            var isLogged = "<?php echo ($isLoggedOn === TRUE) ? "yes" : "no"; ?>";
            var userID = "<?php echo ($isLoggedOn === TRUE) ? User::getUser()->ID_PLAYER : NULL; ?>";
            this.SignUpPage = (function() { return RSsignUp; }());
            this.isLoggedIn = (function() { return isLogged; }());
            this.PlayerID = (function() { return userID; }());

            var limit_search = "<?php echo Doo::conf()->globalSearchLimit; ?>";
            var limit_notif = "<?php echo Doo::conf()->notificationsLimit; ?>";
            var limit_players = "<?php echo Doo::conf()->playersLimit; ?>";
            var limit_msgs = "<?php echo Doo::conf()->messagesLimit; ?>";
            var limit_video = "<?php echo Doo::conf()->videonum; ?>";
            var limit_photo = "<?php echo Doo::conf()->photonum; ?>";
            var limit_reply = "<?php echo Doo::conf()->repliestnum; ?>";
            var limit_post = "<?php echo Doo::conf()->postnum; ?>";
            var limit_timechat = 300; // 5 minutes (uses seconds)
            var interval_chatupdate = 10000; // 2.5 seconds (uses milliseconds)
            this.search_limit = (function() { return limit_search; }());
            this.notification_limit = (function() { return limit_notif; }());
            this.messages_limit = (function() { return limit_msgs; }());
            this.video_limit = (function() { return limit_video; }());
            this.photo_limit = (function() { return limit_photo; }());
            this.reply_limit = (function() { return limit_reply; }());
            this.post_limit = (function() { return limit_post; }());
            this.players_limit = (function() { return limit_players; }());
            this.chat_timeout = (function() { return limit_timechat; }());
            this.chat_updateinterval = (function() { return interval_chatupdate; }());

            var video_autoplay = <?php echo Doo::conf()->videoAutoplay; ?>;
            var video_waittime = <?php echo Doo::conf()->videoWaitTime; ?>;
            var video_fps = <?php echo Doo::conf()->videoFPS; ?>;
            this.videoPlayAuto = (function() { return video_autoplay; }());
            this.videoPlayWait = (function() { return video_waittime; }());
            this.videoPlayFPS = (function() { return video_fps; }());

            var Globals = {
                MyConnectTimeObj    : <?php echo json_encode(getdate(MainHelper::calculateTime(time(), "U"))); ?>,
            };
            this.getGlobal = function(varname) { return Globals[varname]; };
            this.setGlobal = function(varname, value) { Globals[varname] = value; };

            this.adminDir = (function() { return "<?php echo ($isLoggedOn === TRUE) ? $appUrl . "admin" : "Not logged on"; ?>"; }());
            };

        return new MyReadonlyConstruct();
    }(window));

    var site_url = "<?php echo $appUrl; ?>";
    var site_path = "<?php
        $url = explode('/', rtrim(filter_input(INPUT_SERVER, "REQUEST_URI"), '/'));
        echo end($url); ?>";
    var lang = {
        enter_email         : '<?php echo $this->__("Please enter an email address"); ?>',
        enter_your_email    : '<?php echo $this->__("Please enter your e-mail address"); ?>',
        valid_email         : '<?php echo $this->__("Please enter a valid email address"); ?>',
        exists_email        : '<?php echo $this->__("This e-mail already exists in our system"); ?>',
        enter_pass          : '<?php echo $this->__("Please enter a password"); ?>',
        enter_your_pass     : '<?php echo $this->__("Please enter your password"); ?>',
        confirm_pass        : '<?php echo $this->__("Please confirm your password"); ?>',
        pass_nomatch        : '<?php echo $this->__("The passwords do not match"); ?>',
        enter_nick          : '<?php echo $this->__("Please enter a nickname"); ?>',
        accept_terms        : '<?php echo $this->__("You need to accept the Terms of Service"); ?>',
        min_five_char       : '<?php echo $this->__("At least 5 characters"); ?>',
        min_eight_char      : '<?php echo $this->__("At least 8 characters"); ?>',
        min_two_char        : '<?php echo $this->__("At least 2 characters"); ?>',
        max_forty_char      : '<?php echo $this->__("Maximum 40 characters"); ?>',
        max_eighty_char     : '<?php echo $this->__("Maximum 80 characters"); ?>',
        enter_first_name    : '<?php echo $this->__("Please enter your first name"); ?>',
        enter_last_name     : '<?php echo $this->__("Please enter your last name"); ?>',
        enter_city          : '<?php echo $this->__("Please enter your city"); ?>',
        select_country      : '<?php echo $this->__("Please select your country"); ?>',
        select_timezone     : '<?php echo $this->__("Please select your timezone"); ?>',
        select_birth_day    : '<?php echo $this->__("Please select your day of birth"); ?>',
        select_birth_mon    : '<?php echo $this->__("Please select your month of birth"); ?>',
        select_birth_year   : '<?php echo $this->__("Please select your year of birth"); ?>',

        delete_friend       : '<?php echo $this->__("Are you sure you want to delete the friend"); ?>?',
        delete_post         : '<?php echo $this->__("Are you sure you want to delete the post"); ?>?',
        delete_reply        : '<?php echo $this->__("Are you sure you want to delete the reply"); ?>?',
        delete_board        : '<?php echo $this->__("Are you sure you want to delete the board"); ?>?',
        button_yes          : '<?php echo $this->__("Yes"); ?>',
        button_no           : '<?php echo $this->__("No"); ?>',
        players_new         : '<?php echo $this->__("New"); ?>',
        delete_message      : '<?php echo $this->__("Are you sure you want to delete the message"); ?>?',
        delete_all_message  : '<?php echo $this->__("Are you sure you want to delete all messages"); ?>?',
        delete_member       : '<?php echo $this->__("Are you sure you want to delete the member from the group"); ?>?',
        delete_tab          : '<?php echo $this->__("Are you sure you want to delete the tab"); ?>?',
        delete_media        : '<?php echo $this->__("Are you sure you want to delete the media"); ?>?',
        delete_alliance     : '<?php echo $this->__("Are you sure you want to delete the affiliate"); ?>?',
        delete_group        : '<?php echo $this->__("Are you sure you want to delete the group"); ?>?',
        delete_category     : '<?php echo $this->__("Are you sure you want to delete the category"); ?>?',
        leave_group         : '<?php echo $this->__("Are you sure you want to leave the group"); ?>?',
        delete_news         : '<?php echo $this->__("Are you sure you want to delete the news item?"); ?>',
        edit                : '<?php echo $this->__("Edit"); ?>',
        loading_paypal      : '<?php echo $this->__("Loading Paypal, please wait"); ?>.',
        number_of_events    : '<?php echo $this->__("Number of events"); ?>',
        delete_cart_item    : '<?php echo $this->__("Are you sure you want to delete the cart item"); ?>?',
        add_member_role     : '<?php echo $this->__("Are you sure you want to add this role"); ?>?',
        remove_member_role  : '<?php echo $this->__("Are you sure you want to remove this role"); ?>?',
        unpublish_review    : '<?php echo $this->__("Are you sure you want to unpublish this review"); ?>?',
        input_reason        : '<?php echo $this->__("State your reason here"); ?>',

        show_more_posts     : '<?php echo $this->__("Show more posts"); ?>',
        show_more_friends   : '<?php echo $this->__("Show more friends"); ?>',
        show_more_subscribtions: '<?php echo $this->__("Show more subscribtions"); ?>',
        show_more_notifications: '<?php echo $this->__("Show more notifications"); ?>',
        show_more_messages  : '<?php echo $this->__("Show more messages"); ?>',
        change_picture      : '<?php echo $this->__("Change picture"); ?>',
        add_picture         : '<?php echo $this->__("Add picture"); ?>',
        show_more_companies : '<?php echo $this->__("Show more companies"); ?>',
        delete_download     : '<?php echo $this->__("Are you sure want to delete download"); ?>?',
        show_more_games     : '<?php echo $this->__("Show more games"); ?>',
        pasteVideo          : '<?php echo $this->__("Paste your video link here"); ?>...',
        upload_photo        : '<?php echo $this->__("Upload Photo"); ?>',
        upload_image        : '<?php echo $this->__("Upload image"); ?>',
        upload_map          : '<?php echo $this->__("Upload Map"); ?>',
        invitation_sent     : '<?php echo $this->__("Invitation has been sent to"); ?>',
        invitation_notsent  : '<?php echo $this->__("is already registered or invited"); ?>',

        symbols_left        : '<?php echo $this->__("Symbols left"); ?>:',
        january             : '<?php echo $this->__("January"); ?>',
        february            : '<?php echo $this->__("February"); ?>',
        march               : '<?php echo $this->__("March"); ?>',
        may                 : '<?php echo $this->__("May"); ?>',
        april               : '<?php echo $this->__("April"); ?>',
        june                : '<?php echo $this->__("June"); ?>',
        july                : '<?php echo $this->__("July"); ?>',
        august              : '<?php echo $this->__("August"); ?>',
        september           : '<?php echo $this->__("September"); ?>',
        october             : '<?php echo $this->__("October"); ?>',
        november            : '<?php echo $this->__("November"); ?>',
        december            : '<?php echo $this->__("December"); ?>',
        mon                 : '<?php echo $this->__("Mon"); ?>',
        tue                 : '<?php echo $this->__("Tue"); ?>',
        wed                 : '<?php echo $this->__("Wed"); ?>',
        thu                 : '<?php echo $this->__("Thu"); ?>',
        fri                 : '<?php echo $this->__("Fri"); ?>',
        sat                 : '<?php echo $this->__("Sat"); ?>',
        sun                 : '<?php echo $this->__("Sun"); ?>',

        today               : '<?php echo $this->__("Today"); ?>',
        yesterday           : '<?php echo $this->__("Yesterday"); ?>',
        two_days_ago        : '<?php echo $this->__("Two days ago"); ?>',
        week_ago            : '<?php echo $this->__("A week ago"); ?>',
        two_weeks_ago       : '<?php echo $this->__("Two weeks ago"); ?>',
        days_ago            : '<?php echo $this->__("days ago"); ?>',

        search_placeholder  : '<?php echo $this->__("Search"); ?>',
        search_hint         : '<?php echo $this->__("Type in a search term"); ?>',
        search_noresults    : '<?php echo $this->__("No results"); ?>',
        search_searching    : '<?php echo $this->__("Searching"); ?>...',

        error               : '<?php echo $this->__("ERROR"); ?>',
        no_data             : '<?php echo $this->__("No data received from server"); ?>',
        default             : '<?php echo $this->__("Default"); ?>',
        RS_allrequired      : '<?php echo $this->__("All fields required"); ?>...',
        RS_nosignup         : '<?php echo $this->__("No one signed up yet"); ?>...',
        RS_signupas         : '<?php echo $this->__("Signed up as"); ?>',
        RS_signupwith       : '<?php echo $this->__("With the character"); ?>',
        RS_openforall       : '<?php echo $this->__("This event is open for everyone"); ?>',
        RS_whoenlisted      : '<?php echo $this->__("Check the signups tab to see who has enlisted"); ?>',
        RS_waiting          : '<?php echo $this->__("Waiting for answer"); ?>',
        RS_declined         : '<?php echo $this->__("Declined invitation"); ?>',
        RS_char             : '<?php echo $this->__("Character"); ?>',
        RS_role             : '<?php echo $this->__("Role"); ?>',
        RS_allmembers       : '<?php echo $this->__("All Members"); ?>',
        RS_allfriends       : '<?php echo $this->__("All Friends"); ?>',
        RS_noroles          : '<?php echo $this->__("No role data, enter total size"); ?>',
        RS_msg_nogroup      : '<?php echo $this->__("Which group is this"); ?>',
        RS_msg_nostart      : '<?php echo $this->__("Please set when the raid starts"); ?>',
        RS_msg_noend        : '<?php echo $this->__("Please set when the raid ends"); ?>',
        RS_msg_norecur      : '<?php echo $this->__("Please set how often this raid occurs"); ?>',
        RS_msg_nogame       : '<?php echo $this->__("Please select a game for this raid"); ?>',
        RS_msg_noserver     : '<?php echo $this->__("Please select a server for this raid"); ?>',
        RS_msg_nolocat      : '<?php echo $this->__("Please enter a location for this raid"); ?>',
        RS_msg_noppl        : '<?php echo $this->__("Not enough player roles, please add more"); ?>',
        RS_msg_nodesc       : '<?php echo $this->__("Please enter a description"); ?>',
        RS_msg_noinvtype    : '<?php echo $this->__("Please select invitation type"); ?>',
        RS_msg_noinvite     : '<?php echo $this->__("Please select which players to invite"); ?>',
        RS_msg_nofinal      : '<?php echo $this->__("Please set when to finalize the raid"); ?>',
        RS_msg_noremind     : '<?php echo $this->__("Please set when to remind participants of this raid"); ?>',
        RS_msg_nochar       : '<?php echo $this->__("Please type your character name"); ?>',
        RS_msg_norole       : '<?php echo $this->__("Please select a role"); ?>',
        RS_msg_nostatus     : '<?php echo $this->__("Please choose whether to attend or not"); ?>',
        RS_err_form         : '<?php echo $this->__("Something was wrong with the form"); ?>'
    };

    function checkData(data) {
        var tmpData = data || null;
        return ((tmpData === null) || (tmpData === '') || (tmpData === consts.undefined)) ? false : true;
    };

    function elementById(id) {
        var tmpId = id || null;
        return document.getElementById(tmpId) || false;
    };

    function elementsByTag(tag) {
        var tmpTag = tag || null;
        return document.getElementsByTagName(tmpTag) || false;
    };

    function elementsByName(name) {
        var tmpName = name || null;
        return document.getElementsByName(tmpName) || false;
    };

    function emptyElement(elem) {
        if(checkData(elem)) {
            var tmpObj = '', Target = elem;
            while(tmpObj = Target.lastChild) { Target.removeChild(tmpObj); };
        };
        return;
    };

    function errLog() {
        var tmpArg = arguments || '';
        if(window.console) { console.log(tmpArg); }
        else if(window.opera) { opera.postError(tmpArg); }
        else { alert(tmpArg); };
        return;
    };

    function errWin(data) {
        var tmpData = data || '', x = window.open('', 'DebugWindow', 'location=0, menubar=0, resizable=1, scrollbars=1, status=0, titlebar=0, toolbar=0', true);
        if(checkData(x)) {
            x.document.open();
            x.document.write(tmpData);
        };
    };

    function eatEvent(event) {
        var e = event || null;
        e.preventDefault();
        e.stopPropagation();
        return;
    };
</script>