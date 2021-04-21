var Test = {
    errorObject : null, // Holds the last error, used to trace back the error stack.
    // Dumps the contents of one or more variables in the console.
    // @param {Mixed} The variables to dump
    Dump: function() { errLog('Dump: ' + JSON.stringify(arguments)); },
    Fail : function(Msg) { // Should not be called externally. Internal function to trace, show and throw an assert error.
        Test.errorObject = new Error(Msg);
        errLog('Assert fail on line: ' + parseInt(Test.errorObject.stack.split('\n')[3].split(':')[2], 10));
        throw Test.errorObject;
    },
//	 * Test if a variable is a given type.
//	 * @param {Mixed} The variable to test.
//	 * @param {String} Type The expected type of the variable (string, number, array, object).
//	 * @returns {Boolean} true on success, false on fail. 
    isType : function(variable, type) { if(type === 'array') { return $.isArray(variable); } else { return typeof variable === type; }; },
//	 * Function to test an expression in code.
//	 * @param {Boolean} expression the expression to test
//	 * @param {String} description The description to show if the test fail.
    Assert : function(expression, description) { if(!expression) { Test.Fail('ASSERT FAIL: ' + description); }; },
//	 * Function to test if a variable is of a specific type.
//	 * @param {Mixed} variable the variable to test.
//	 * @param {String} Type The expected type of the variable (string, number, array, object)
//	 * @param {String} The description to show if the test fails. 
    AssertType : function(variable, Type, description) { if(!Test.isType(variable, Type)) { Test.Fail('ASSERT TYPE FAIL (Expected: ' + Type + ' Got: ' + typeof (variable) + '): ' + description); }; },
//	 * Shows a warning in the console.
//	 * @param {String} Message The warning message. 
    Warning : function(Message) { errLog('WARNING: ' + Message); }
};

String.prototype.maxlen = function(len) { // TODO: Should not prototype. 
    if(this.length <= len) { return this; };
    return this.substring(0, len - 3) + '...';
};

var Chat = {
    windowSize : {
        width : null,
        height : null
    },
    data : {
        Timer : null,
        updateInterval : consts.chat_updateinterval,
        noActivity : 0,
        jspAPI : null
    },
    getParticipants : function(Conversation) {
        var result = [], tmpVar = Conversation.Participants || false, CurItem = '';
        if(tmpVar) {
            for(var i = 0, iEnd = tmpVar.length; i < iEnd; ++i) {
                CurItem = tmpVar[i];
                if(parseInt(Chat.data.Me.id, 10) !== parseInt(CurItem.user.id), 10) { result.push(CurItem.user.name); }; // lets not return ourself ;)
            };
        };
        return result;
    },
    flashHeader : function() {
        var convHeadID = elementById('toggleConv'), convCountID = elementById('converCount');
        if(0 === convCountID.innerHTML) { convCountID.classList.remove('newConvOnline'); }
        else { convCountID.classList.add('newConvOnline'); };
        convHeadID.classList.add('bgFlash');
        $(convHeadID).on('click', function() {
            convHeadID.classList.remove('bgFlash');
            convCountID.classList.remove("newConvOnline");
        });
    },
    getParticipantIds : function(Conversation) {
        var result = [], tmpConv = Conversation, tmpVar = tmpConv.Participants || false, CurItem = '';
        if(tmpVar) {
            for(var i = 0, iEnd = tmpVar.length; i < iEnd; ++i) {
                CurItem = parseInt(tmpVar[i].user.id, 10);
                if(parseInt(Chat.data.Me.id, 10) !== CurItem) { result.push(CurItem); }; // lets not return ourself ;)
            };
        };
        return result;
    },
    init : function() {
        Chat.data.jspAPI = $(elementById('chatMessageContainer')).jScrollPane({/* verticalDragMinHeight: 12, verticalDragMaxHeight: 12 */}).data('jsp');
        $.get(site_url + 'bottomchat', { action : 'firstUpdate' }, function(data) {
            if(checkData(data)) { Chat.start(data); };
        }, 'json');
    },
    addFriendToCurrent : function(friendId) {
        var Participants = Chat.getParticipantIds(Chat.getConversationFromId(Chat.data.currentConversation));
        Participants.push(parseInt(friendId, 10));
        Chat.CreateConversationWith(Participants);
    },
    ShowFriendMenu : function(friendId) {
        var offset = $(elementById('friendlistContainer')).offset(), menu = elementById('friendMenuContainer');
        menu.style.top = (parseInt(offset.top, 10) - 85) + 'px';
        menu.style.right = '5px';
        menu.style.display = 'block';
        elementById('newConversation').setAttribute('ref', friendId);
        elementById('addToConversation').setAttribute('ref', friendId);
        $(document).on('click.chatnamespace', function() {
            menu.style.display = 'none';
            $(document).off('click.chatnamespace');
        });
    },
    CreateConversationWith : function(participants) {
        var tmpPartic = (participants) ? participants.join(',') : '';
        $.get(site_url + 'bottomchat', { action : "CreateConversationWith", participants : tmpPartic }, function(data) {
            var tmpData = data || null;
            if(checkData(tmpData)) {
                Chat.update(tmpData);
                Chat.openConversation(parseInt(tmpData.conversationId, 10));
            };
        }, 'json');
    },
    updateChatTitle : function(data) {
        var tmpID = elementById('chatfriendname');
        emptyElement(tmpID);
        tmpID.insertAdjacentHTML('beforeend', data.NAME);
    },
    getConversationIdFromString : function(theString) {
        var temp = theString.split('_');
        return parseInt(temp[1], 10);
    },
    emptyMessages : function() { Chat.data.jspAPI.getContentPane().empty(); },
    sendState : function() {
        var isConvOpen = $(elementById('chatContainer')).is(':visible'), CurConv = Chat.data['currentConversation'], friendOpen = $(elementById('friendButtonContainer')).is(':visible'), convsOpen = $(elementById('cButtonContainer')).is(':visible');
        createCookie('chat.openConversation', isConvOpen);
        createCookie('chat.conversationId', CurConv);
        createCookie('chat.friendsOpen', friendOpen);
        createCookie('chat.conversationsOpen', convsOpen);
        $.get(site_url + 'bottomchat', { action : 'setState', state : { openConversation : isConvOpen, conversationId : CurConv, friendsOpen : friendOpen, conversationsOpen : convsOpen} }, function(data) {
            var tmpData = data || null;
            if(checkData(tmpData)) { Chat.update(tmpData); };
        }, 'json');
    },
    restoreState : function() {
        if(readCookie('chat.friendsOpen') === 'true') {
            $(elementById('friendButtonContainer')).slideToggle(400, function() {
                $(elementById('friendlistContainer')).toggleClass('chatShadow');
                Chat.sendState();
            });
        };
        if(readCookie("chat.conversationsOpen") === "true") {
            $(elementById('cButtonContainer')).slideToggle(400, function() {
                $(elementById('convlistContainer')).toggleClass('chatAndTwichShadow');
            });
        };
        if(readCookie('chat.openConversation') === 'true') { Chat.openConversation(parseInt(readCookie('chat.conversationId'), 10)); };
    },
    closeCurrentConversation : function() {
        var chatContainer = elementById('chatContainer');
        if(chatContainer.style.display !== 'none') {
            $(chatContainer).slideUp(function() { Chat.emptyMessages(); });
            $('.invgrad').removeClass('invgrad').addClass('grad');
        };
        Chat.data.currentConversation = null;
        createCookie('chat.openConversation', 'false');
    },
    openConversation : function(ConversationId) {
        var tmpVar = parseInt(ConversationId, 10), CurButName = '', preventLoop = checkData(preventLoop) ? preventLoop : 0;
        Test.AssertType(tmpVar, 'number', 'openConversation: ConversationId');
        if(Chat.data.currentConversation === tmpVar) {
            Chat.closeCurrentConversation();
            return;
        };
        Chat.updateChatTitle({ NAME : Chat.getParticipants(Chat.getConversationFromId(tmpVar)).join(', ') });
        var chatContainer = elementById('chatContainer'), jChatContainer = $(chatContainer);
        if((chatContainer.style.display === 'none') && preventLoop < 1) {
            jChatContainer.slideUp(200, function() {
                ++preventLoop;
                Chat.emptyMessages();
                Chat.openConversation(tmpVar); // recall when we are ready!
                return;
            });
        };
        Chat.data.currentConversation = tmpVar;
        Chat.updateChatContainerContents(tmpVar);
        CurButName = 'conversation_' + tmpVar;
        Chat.setActiveButton(CurButName);
        jChatContainer.slideDown(function() {
            Chat.sendState();
            Chat.data.jspAPI.reinitialise();
            Chat.data.jspAPI.scrollToBottom(true);
            $(elementById('chatMessage')).focus();
        });
        $(elementById(CurButName)).children('.newMessageCount').text('0').removeClass('unreadMessages');
        $(elementById('toggleConv')).removeClass('bgFlash');
    },
    OpenConversationWith : function(friendId) {
        var tmpID = parseInt(friendId, 10), convos = (Chat.data.Conversations) ? Chat.data.Conversations : false, iEnd = (convos !== false) ? convos.length : 0, curItem = [], curItemMsgs = [], curItemParts = [], result = [], newest = { time : 0, id : 0}, curItemNewest = 0;
        for(var i = 0; i < iEnd; ++i) {
            curItem = convos[i];
            curItemParts = Chat.getParticipantIds(curItem);
            if(0 <= curItemParts.indexOf(tmpID)) { result.push(curItem); };
        };
        if(result.length > 0) {
            for(var x = 0, xEnd = result.length; x < xEnd; ++x) {
                curItemMsgs = result[x].Messages;
                curItemNewest = (curItemMsgs) ? parseInt(curItemMsgs[curItemMsgs.length - 1].time, 10) : 0;
                if(curItemNewest > newest.time) {
                    newest.time = curItemNewest;
                    newest.id = result[x].id;
                };
            };
            if(parseInt(newest.id, 10) !== 0) { Chat.openConversation(newest.id); }
            else { Chat.ShowFriendMenu(friendId); };
        } else { Chat.ShowFriendMenu(friendId); };
    },
    setActiveButton : function(buttonId) {
        $('.invgrad').removeClass('invgrad').addClass('grad');
        if(!elementById(buttonId)) { // button is not created yet.... sooo hack it!
            Chat.activeButTimer = window.setTimeout('Chat.setActiveButton("' + buttonId + '");', 200);
            return null;
        }
        $(elementById(buttonId)).removeClass('grad').addClass('invgrad');
    },
    updateChatContainerContents : function(ConversationId, tmpcur) {
        var current = tmpcur || false, ConvID = ConversationId, Conversation = Chat.getConversationFromId(ConvID), lastTimestamp = 0, MsgID = '', MsgIDTxt = '', Class = '', FullTime = '', Name = '', HourTime = '', Msg = '', tmpTxt = [], Msgs = '', CurItem = [], thisTimestamp = 0, CurItemID = 0, CurItemOwnID = 0, CurItemTime = 0;
        if(Conversation.Messages) {
            for(var i = 0, iEnd = Conversation.Messages.length; i < iEnd; ++i) {
                CurItem = Conversation.Messages[i];
                thisTimestamp = Chat.GetRelativeDate(CurItem.time);
                CurItemID = CurItem.id;
                CurItemOwnID = CurItem.owner_id;
                CurItemTime = CurItem.time;
                MsgIDTxt = 'message_' + CurItemID;
                MsgID = elementById(MsgIDTxt);
                if(lastTimestamp !== thisTimestamp && !MsgID) { tmpTxt.push('<p>',thisTimestamp,'</p>'); };
                lastTimestamp = thisTimestamp;
                if(!MsgID) {
                    Class = (CurItemOwnID === Chat.data.Me.id) ? 'fromMe' : 'toMe';
                    FullTime = Chat.CreateFullTimeString(CurItemTime);
                    Name = Chat.data.usertable[CurItemOwnID];
                    HourTime = Chat.getChatMessageTimeStamp(CurItemTime);
                    Msg = CurItem.text;
                    tmpTxt.push('<div class="chatMessage" id="',MsgIDTxt,'"><div class="chatline ',Class,'"><header title="',FullTime,'">',Name,' - ',HourTime,'</header><p>',Msg,'</p></div></div>');
                };
            };
            Msgs = tmpTxt.join('');
            if(current) { Chat.data.jspAPI.getContentPane().append(Msgs); } else if(!current) { Chat.data.jspAPI.getContentPane().html(Msgs); };
        };
    },
    getConversationFromId : function(ConversationId) {
        var tmpVar = Chat.data.Conversations;
        if(tmpVar) {
            for(var i = 0, iEnd = tmpVar.length; i < iEnd; ++i) {
                var Conversation = tmpVar[i];
                if(parseInt(Conversation.id, 10) === parseInt(ConversationId, 10)) { return Conversation; };
            };
        };
        return false; // no output cuz we use this to check if a conversation exists now
    },
    getDST: function(timeStamp) {
        var dateObj = new Date(timeStamp), jan = new Date(dateObj.getFullYear(), 0, 1), jul = new Date(dateObj.getFullYear(), 6, 1), stdOffset = Math.max(jan.getTimezoneOffset(), jul.getTimezoneOffset()), DST = dateObj.getTimezoneOffset() < stdOffset ? 1 : 0;
        return DST * 3600000; // 60 * 60 * 1000
    },
    getTimezone : function() {
        if (Chat['timezoneCache']) { return Chat['timezoneCache']; };
        var dtDate = new Date('1/1/' + (new Date()).getUTCFullYear()), intOffset = 0, intMonth;
        for(intMonth = 0; intMonth < 12; ++intMonth) { //go through each month to find the lowest offset to account for DST
            dtDate.setUTCMonth(dtDate.getUTCMonth() + 1);
            if(!intOffset || intOffset > (dtDate.getTimezoneOffset() * (-1))) { intOffset = (dtDate.getTimezoneOffset() * (-1)); };
        }
        Chat['timezoneCache'] = intOffset * 60000;
        return Chat['timezoneCache'];
    },
    getDaysAgo : function(timeStamp) {
        var serverTime = parseInt(Chat.data.requestTime, 10) * 1000, oneDay = 86400000, dateObject = new Date(serverTime + oneDay); // milliseconds
        dateObject.setHours(0, 0, 0, Chat.getTimezone());
        var today = dateObject.getTime(); // reset time to local midnight
        dateObject.setTime(timeStamp * 1000);
        return Math.floor((today - dateObject.getTime()) / oneDay);
    },
    GetRelativeDate : function(timeStamp) {
        var daysAgo = Chat.getDaysAgo(timeStamp), result = "";
        if(daysAgo < 15) {// same month as now
            switch(daysAgo) {
                case 0: result = lang['today'];
                    break;
                case 1: result = lang['yesterday'];
                    break;
                case 2: result = lang['two_days_ago'];
                    break;
                case 7: result = lang['week_ago'];
                    break;
                case 14: result = lang['two_weeks_ago'];
                    break;
                default: result = daysAgo + " " + lang['days_ago'];
                    break;
            };
        } else { // returns a short version of the date
            var dateObject = new Date(timeStamp * 1000), day = dateObject.getDate(), month = dateObject.getMonth();
            result = ('0' + day).substring(-2) + '.' + ('0' + month).substring(-2);
        };
        return result;
    },
    CreateFullTimeString : function(timeStamp) { return Chat.CreateDateString(timeStamp) + ' ' + Chat.CreateTimeString(timeStamp); },
    CreateDateString : function(timeStamp) { // multiply php/sql time to match js time
        var dateObject = new Date(timeStamp * 1000), day = ('00' + dateObject.getDate()).substr(-2), month = ('00' + dateObject.getMonth()).substr(-2);
        return day.substr(-2) + '.' + month.substr(-2);
    },
    getChatMessageTimeStamp: function(timeStamp) {
        if(Chat.getDaysAgo(timeStamp) > 0) { return Chat.GetRelativeDate(timeStamp); }
        else { return Chat.CreateTimeString(timeStamp); };  
    },
    CreateTimeString : function(timeStamp) {
        var GMT = Chat.getTimezone(), DST = Chat.getDST(timeStamp * 1000), dateObject = new Date((timeStamp * 1000) + GMT + DST), hours = '00' + dateObject.getHours(), minutes = '00' + dateObject.getMinutes();
        return hours.substr(-2) + ':' + minutes.substr(-2);
    },
    onWindowResize : function() { elementById('listContainer').style.maxHeight = (Chat.windowSize.height - 150) + 'px'; }, // updates the maximum height of the user/conversation container.
    start : function(data) {
        Chat.periodicUpdate(data);
        Chat.restoreState();
    },
    getParticipant : function(conversationId, ParticipantId) {
        Test.AssertType(ParticipantId, 'number', 'getParticipant: ParticipantId');
        Test.AssertType(conversationId, 'number', 'getParticipant: conversationId');
        var Conversation = Chat.getConversationFromId(conversationId), tmpParticip = Conversation.Participants, CurItem = '';
        Test.Assert(Test.isType(Conversation, 'object'), 'Conversation(' + conversationId + ') not found!');
        for(var i = 0, iEnd = tmpParticip.length; i < iEnd; ++i) {
            CurItem = tmpParticip[i];
            if(parseInt(CurItem.user.id, 10) === parseInt(ParticipantId, 10)) { return CurItem; };
        };
        Test.Assert(false, 'Participant(' + ParticipantId + ') not found in array: ' + JSON.stringify(tmpParticip));
    },
    getFriendFromId : function(id) {
        var tmpVar = Chat.data.Friends;
        if(tmpVar && Test.isType(tmpVar, 'array')) {
            for(var i = 0, iEnd = tmpVar.length, CurItem = ''; i < iEnd; ++i) {
                CurItem = tmpVar[i];
                if(parseInt(CurItem.id, 10) === parseInt(id, 10)) { return CurItem; };
            };
        };
        return null; // if we got down here it means we are called before an update o
    },
    updateFriend : function(id, data) {
        var friend = Chat.getFriendFromId(id), tmpData = data;
        Test.Assert(Test.isType(friend, 'object'), 'updateFriend(' + id + '): friend is not an object!');
        if(!checkData(friend)) { return false; };
        if(tmpData.lastSeen) {
            var lastSeen = parseInt(tmpData.lastSeen, 10);
            Test.AssertType(lastSeen, 'number', 'updateFriend: data.lastSeen');
            friend.lastSeen = lastSeen;
        };
        if(tmpData.name) {
            Test.Assert(Test.isType(tmpData.name, 'string'), 'updateFriend: data.name exists but is not a string!');
            friend.name = tmpData.name;
        };
        return true;
    },
    updateChatData : function(data) {
        var hasChanged = false, tmpdata = data, ConversationsArray = tmpdata.Conversations || false, Conversation = false, CurItem = '', CurItemID = false;
        if(ConversationsArray) {
            hasChanged = true;
            for(var i = 0, iEnd = ConversationsArray.length; i < iEnd; ++i) {
                CurItem = ConversationsArray[i], CurItemID = (CurItem) ? CurItem.id : 0;
                Conversation = Chat.getConversationFromId(parseInt(CurItemID, 10));
                if(Conversation) {
                    if(CurItem.Messages) {
                        var Messages = CurItem.Messages;
                        if(!Conversation.Messages) { Conversation.Messages = []; }; // if there's no messages in this conversation lets make room for them
                        $.extend(true, Conversation.Messages, Messages);
                    };
                    if(CurItem.Participants) {
                        var changedParticipants = CurItem.Participants;
                        for(var pIndex = 0, iEnd = changedParticipants.length; pIndex < iEnd; ++pIndex) {
                            var changedParticipant = changedParticipants[pIndex].user, existingParticipant = Chat.getParticipant(parseInt(Conversation.id, 10), parseInt(changedParticipant.id, 10));
                                // TODO: should fix timestamp and id datatype from string to int (Long term solution should be a instance of a user class)
                            if(existingParticipant) { existingParticipant = changedParticipant; } // Added to the conversation!
                            else { if(Conversation.Participants.indexOf(changedParticipants[pIndex]) === -1) { Conversation.Participants.push(changedParticipants[pIndex]); }; };
                        };
                    };
                } else { // this is a new conversation so we can just add it
                    if(!Chat.data.Conversations) { Chat.data.Conversations = []; };
                    if(checkData(CurItem)) { Chat.data.Conversations.push(CurItem); };
                };
            };
        };
        if(tmpdata.OnlineCount || tmpdata.Friends) {
            hasChanged = true;
            var changedFriends = tmpdata.Friends, tmpItem = '', counter = tmpdata.OnlineCount, countID = elementById('onlineCount');
            for(var i = 0, iEnd = changedFriends.length; i < iEnd; ++i) {
                tmpItem = changedFriends[i];
                if(!Chat.updateFriend(tmpItem.id, tmpItem)) { // not found so add him
                    if(!Chat.data.Friends) { Chat.data.Friends = []; };
                    Chat.data.Friends.push(tmpItem);
                };
            };
            Chat.data.OnlineCount = counter;
            countID.innerHTML = counter;
            if(0 === counter) { countID.classList.remove('newConvOnline'); }
            else { countID.classList.add('newConvOnline'); };
        };
        if(tmpdata.usertable) { // this is really just a clientside table of id's and names so no need to report changes here
            if (!Chat.data.usertable) { Chat.data.usertable = {}; };
            $.extend(Chat.data.usertable, tmpdata.usertable);
        };
        if(tmpdata.Me) {
            if(!Chat.data.Me) { Chat.data.Me = {}; };
            $.extend(Chat.data.Me, tmpdata.Me);
        };
        Chat.data.requestTime = tmpdata.requestTime;
        if(tmpdata.State) { hasChanged = true; };
        return hasChanged;
    },
    update : function(data) { // Main update function
        var tmpdata = data, convCountID = elementById('converCount');
        if(Chat.updateChatData(tmpdata)) { //something changed since last call!
            convCountID.innerHTML = (Chat.data.Conversations) ? Chat.data.Conversations.length : 0;
            if(tmpdata.Friends) { Chat.drawFriends(tmpdata.Friends); }; // friends timestamp or list has changed
            if(tmpdata.Conversations) {
                var allConversationButtons = $('.cButton');
                if(allConversationButtons.length === 0) { Chat.drawAllConversationButtons(tmpdata.Conversations); }; // this is the first run so we have to draw all the buttons
                Chat.updateConversationButtons(tmpdata.Conversations);
                var CurrentConv = Chat.data.currentConversation;
                if(checkData(CurrentConv)) {//do we have a open conversation?
                    Chat.data.Conversations = tmpdata.Conversations; // nasty firefox fix!
                    Chat.updateChatContainerContents(CurrentConv, true); // update it
                    Chat.data.jspAPI.reinitialise(); // reinitialize the custom scrollbar
                    Chat.data.jspAPI.scrollToBottom(true);
                };
            };
            return true;
        };
        return false;
    },
    updateConversationButtons : function(conversations) {
        var tmpVar = conversations, CurItem = '', CurItemID = '', CurItemIDTxt = '', CurItemObj = '', tmpMake = false;
        for(var i = 0, iEnd = tmpVar.length; i < iEnd; ++i) {
            CurItem = tmpVar[i], CurItemID = tmpVar[i].id, CurItemIDTxt = 'conversation_' + CurItemID, CurItemObj = elementById(CurItemIDTxt);
            if(CurItemObj) { // if the button exists update the number
                if(parseInt(Chat.data.currentConversation, 10) !== parseInt(CurItemID, 10)) { // dont update the count on the current conversation
                    var messageCounter = $(CurItemObj).children('.newMessageCount'), unreadCount = Chat.getUnreadMessageCount(Chat.getConversationFromId(parseInt(CurItemID, 10)));
                    messageCounter.text(unreadCount);
                    if(parseInt(unreadCount, 10) > 0) {
                        Chat.flashHeader();
                        messageCounter.addClass('unreadMessages');
                    };
                };
            } else { // create the button and append it
                if(CurItem.Messages) {
                    if(CurItem.Messages.length > 0 || CurItemID == Chat.data.currentConversation) {
                        tmpMake = true;
                        var Title = Chat.getParticipants(Chat.getConversationFromId(parseInt(CurItemID, 10))).join(', '), unreadCount = Chat.getUnreadMessageCount(CurItemID), tmpText = '', tmpItems = [];
                        tmpItems.push('<li class="cButton grad" id="',CurItemIDTxt,'" title="',Title.replace(/\"/g, '&quot;'),'"><span>',Title.maxlen(31),'</span><span class="newMessageCount" title="Unread messages">',unreadCount,'</span></li>');
                    };
                };
            };
        };
        if(tmpMake) {
            var tmpID = elementById('cButtonContainer');
            tmpText = tmpItems.join('');
            emptyElement(tmpID);
            tmpID.insertAdjacentHTML('beforeend', tmpText);
            Chat.flashHeader();
        };
    },
    periodicUpdateFunc : function() {
        $.get(site_url + 'bottomchat', { action : 'periodicUpdate', since : Chat.data.requestTime, lastMessageId : Chat.getLastMessageId() }, function(data) {
            if(checkData(data)) { Chat.periodicUpdate(data); };
        }, 'json');
    },
    periodicUpdate : function(data) { //self calling method
        var tmpdata = data;
        if(checkData(tmpdata)) {
            if(Chat.update(tmpdata)) { Chat.data.noActivity = 0; } //something changed since last call!
            else {
                ++Chat.data.noActivity;
                var tmpActiv = Chat.data.noActivity;
                if(tmpActiv > 3) { Chat.data.updateInterval = 15000; } // 15 seconds
                else if(tmpActiv > 10) { Chat.data.updateInterval = 25000; } // 25 seconds
                else if(tmpActiv > 20) { Chat.data.updateInterval = 40000; } // 40 seconds
                else { Chat.data.updateInterval = 60000; };
            };
        };
        clearTimeout(Chat.Timer);
        Chat.Timer = window.setTimeout('Chat.periodicUpdateFunc()', Chat.data.updateInterval);
    },
    getHighest : function(a, b) { return (parseInt(a, 10) > parseInt(b, 10) ? a : b); },
    getLastMessageId : function(convo) {
        var result = 0, Conversations = (convo) ? convo : Chat.data.Conversations || false;
        if(Conversations) {
            for(var i = 0, iEnd = Conversations.length; i < iEnd; ++i) {
                var Messages = Conversations[i].Messages || false;
                if(Messages) { for(var c = 0, cEnd = Messages.length; c < cEnd; ++c) { result = Chat.getHighest(Messages[c].id, result); }; };
            };
        };
        return result;
    },
    getTimeoutTime : function() {
        var dateObj = new Date(parseInt(Chat.data.requestTime, 10) * 1000);
        return (dateObj.getTime() / 1000) - consts.chat_timeout;
    },
    drawFriends : function(friendArray) {
        if(!Test.isType(friendArray, 'array')) { return; }; // no friends to draw!
        var buttonID = elementById('friendButtonContainer'), tmpVar = friendArray, CurItem = '', tmpText = '', tmpItems = [];
        for(var i = 0, iEnd = tmpVar.length; i < iEnd; ++i) {
            var CurItem = tmpVar[i], UserId = CurItem.id, Username = Chat.data.usertable[UserId], Avatar = CurItem.avatar;
            tmpItems.push('<li class="friendButton friend grad ',(1 === parseInt(CurItem.online, 10)) ? 'User_Online' : 'User_Offline','" id="user_',UserId,'"><p>',Username,'</p><img src="',Avatar,'"></li>');
        };
        tmpText = tmpItems.join('');
        emptyElement(buttonID);
        buttonID.insertAdjacentHTML('beforeend', tmpText);
    },
    getLastUpdateTime : function(Conversation, Id) {
        var tmpVar = Conversation.Participants || false, CurItem = '';
        if(tmpVar) {
            Test.AssertType(tmpVar, 'array');
            for(var i = 0, iEnd = tmpVar.length; i < iEnd; ++i) {
                CurItem = tmpVar[i];
                if(CurItem.user.id === Id) { return CurItem.lastUpdate; }; };
            errLog('getLastUpdateTime: user(' + Id + ') is apparently not a participant in Conversation(' + Conversation.id + ')');
        } else { errLog('apparently I got here from a conversation without participants!'); };
        return null; // This should never!!! happen!
    },
    getUnreadMessageCount : function(Conversation) {
        var tmpConv = Conversation;
        if(!tmpConv.Messages) { return '0'; }; //No messages, then my guess is theres no unread
        var result = 0, MyID = Chat.data.Me.id, MyLastUpdateTime = Chat.getLastUpdateTime(tmpConv, MyID), tmpConvMsgs = tmpConv.Messages, CurItem = '';
        for(var i = 0, iEnd = tmpConvMsgs.length; i < iEnd; ++i) {
            CurItem = tmpConvMsgs[i];
            if((parseInt(CurItem.owner_id, 10) !== parseInt(MyID, 10)) && (CurItem.time > MyLastUpdateTime) && (CurItem.text.length > 0)) { ++result; };
        };
        return result;
    },
    drawAllConversationButtons : function(conversationsArray) {
        var tmpID = elementById('cButtonContainer'), CurItem = '', CurItemMsg = '', CurItemID = '', tmpText = '', tmpItems = [], make = false;
        emptyElement(tmpID); // lets only redraw everything if we need to!
        for(var i = 0, iEnd = conversationsArray.length; i < iEnd; ++i) {
            CurItem = conversationsArray[i], CurItemMsg = CurItem.Messages || false, CurItemID = CurItem.id;
            if(CurItemMsg) {
                if(CurItemMsg.length > 0 || CurItemID === Chat.data.currentConversation) {
                    make = true;
                    var Conversation = Chat.getConversationFromId(CurItemID), Title = Chat.getParticipants(Conversation).join(', '), unreadCount = Chat.getUnreadMessageCount(Conversation);
                    tmpItems.push('<li class="cButton grad" id="conversation_',CurItemID,'" title="',Title.replace(/\"/g, '&quot;'),'"><span>',Title.maxlen(31),'</span><span class="newMessageCount" title="Unread messages">',unreadCount,'</span></li>');
                };
            };
        };
        if(make) {
            tmpText = tmpItems.join('');
            tmpID.insertAdjacentHTML('beforeend', tmpText);
        };
    }
};

$(document).ready(function() {
    if(elementById('listContainer')) {
        Chat.init();

        $(window).on('resize', function() {// we have to update the size of the chat if it doesnt fit
            Chat.windowSize.width = $(this).width();
            Chat.windowSize.height = $(this).height();
            Chat.onWindowResize();
        });

        $(window).on('blur', function() {
            if(elementById('listContainer')) {
                $(window).on('focus', function() {
                    if(elementById('listContainer')) {
                        Chat.periodicUpdate(null);
                        $(window).off('focus');
                    };
                });
            };
        });

        $(elementById('convlistContainer')).on('click', function() {
            var denne = this;
            $(elementById('cButtonContainer')).slideToggle(400, function() {
                Chat.sendState();
                $(denne).toggleClass('chatShadow');
            });
        });

        $(elementById('chat_header')).on('click', function() {
            var chatFrame = $(elementById('chat_frame'));
            if(chatFrame.hasClass('closed')) {
                eraseCookie('chatFrame');
                createCookie('chatFrame', 'open');
                chatFrame.removeClass('closed');
                chatFrame.addClass('open');
            } else {
                eraseCookie('chatFrame');
                createCookie('chatFrame', 'closed');
                chatFrame.removeClass('open');
                chatFrame.addClass('closed');
            };
        });

        $(elementById('chatkryds')).on('click', function() { Chat.closeCurrentConversation(); });
        $(elementById('newConversation')).on('click', function() { Chat.CreateConversationWith([this.getAttribute('ref')]); });
        $(elementById('addToConversation')).on('click', function() { Chat.addFriendToCurrent([this.getAttribute('ref')]); });
        $(elementById('cButtonContainer')).on({
            click : function() {
                Chat.openConversation(Chat.getConversationIdFromString(this.getAttribute('id')));
            } 
        }, '.cButton');

        $(elementById('toggleFriends')).on('click', function(event) {
            var denne = this;
            event.preventDefault();
            $(elementById('friendButtonContainer')).slideToggle(400, function() {
                Chat.sendState();
                $(denne).toggleClass('chatShadow');
            });
        });

        $(elementById('friendButtonContainer')).on({
            click : function(event) {
                eatEvent(event);
                var friendId = parseInt(this.getAttribute('id').split('_')[1], 10);
                Test.AssertType(friendId, 'number', 'friendButtonClickEvent: not a valid id');
                if(checkData(Chat.data.currentConversation)) {
                    var currentParticipants = Chat.getParticipantIds(Chat.getConversationFromId(Chat.data.currentConversation));
                    if(currentParticipants.indexOf(friendId) > -1) { return; }
                    else { Chat.OpenConversationWith(friendId); }; // try to open an existing convo with friendID
                    // TODO: maybe add the possibility to open a conversation with only this friend, if there's more than one participant
                    // dont do anything if the participant is already in the current conversation
                    // Ask to add or create new conversation
                } else { Chat.OpenConversationWith(friendId); };
            }
        }, 'li.User_Online');

        $(elementById('chatMessageForm')).on('submit', function(event) {
            event.preventDefault();
            var chatMsg = elementById('chatMessage');
            $.get(site_url + 'bottomchat', { action : 'sendMessage', conversationId : Chat.data.currentConversation, text : chatMsg.value, since : Chat.data.requestTime - 10 }, function(data) {
                if(checkData(data)) { Chat.update(data); };
            }, 'json');
            chatMsg.value = '';
            chatMsg.focus();
            return false;
        });
    };
});