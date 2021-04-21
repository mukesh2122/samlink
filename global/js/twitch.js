var Twitch = {
    init : function() {
        if(readCookie('twitchLoggedIn') === 'yes') {
            if(readCookie('twitchSelected') === 'followed') {
                Twitch.getFollowed();
                Twitch.selectFollowed();
            } else {
                Twitch.getFeatured();
                Twitch.selectFeatured();
            };
        } else { Twitch.getFeatured(); };
        createCookie('twitchFirstTime', 'yes');
        if(readCookie('twitchIsOpen') === 'yes') {
            if(readCookie('twitchIsMin') !== 'yes') {
                var tmpName = readCookie('twitchStream');
                Twitch.setupChat(tmpName);
                Twitch.setupStreamWindow(tmpName);
            };
        };
        if(readCookie('twitchList') === 'open') {
            $(elementById('twitchStreamList')).slideToggle(400, function() {
                $(elementById('twitchMenuContainer')).toggleClass('twichShadow');
            });
        };
    },
    drawListItem : function(data) {
        var tmpData = data, listID = elementById('twitchStreamList');
        emptyElement(listID);
        listID.insertAdjacentHTML('beforeend', tmpData);
    },
    drawStreams : function(streamList, ff, maxStreams) {
        ff = ff || 'featured';
        maxStreams = maxStreams || 6;
        if(streamList && (streamList.length < maxStreams)) { maxStreams = streamList.length; };
        var streamName = '', streamImg = '', streamDisplayName = '', streamGame = '', tmpVal = {}, tmpHtml = [], tmpText = '';
        for(var i = 0; i < maxStreams; ++i) {
            if(ff === 'followed') {
                tmpVal = streamList[i].channel;
                streamName = tmpVal.name;
                streamImg = tmpVal.logo;
                streamDisplayName = tmpVal.display_name;
                streamGame = tmpVal.game;
            } else if(ff === 'featured') {
                tmpVal = streamList[i].stream.channel || null;
                streamName = tmpVal.name || 'N/A';
                streamImg = tmpVal.logo || null;
                streamDisplayName = tmpVal.display_name || 'N/A';
                streamGame = tmpVal.game || 'N/A';
            };
            tmpHtml.push('<li class="twitchStreamItem grad" id="',streamName,'"><img class="twitchImage" src="',streamImg,'"><span class="twitchTitle">',streamDisplayName,'</span><span class="twitchSub">',streamGame,'</span></li>');
            };
        tmpText = tmpHtml.join('');
        Twitch.drawListItem(tmpText);
    },
    getFeatured : function() {
        $.get(site_url + 'twitchfeatured', null, function(data) {
            var tmpVal = (!data) ? null : data.featured || null;
            if(checkData(data)) { Twitch.drawStreams(tmpVal, 'featured', 6); }
        }, 'json');
    },
    getFollowed : function() {
        $.get(site_url + 'twitchfollowed', null, function(data) {
            var tmpVal = data.streams;
            if(!checkData(tmpVal)) { Twitch.noStreamsFound(); }
            else { Twitch.drawStreams(tmpVal, 'followed', 6); };
        }, 'json');
    },
    selectFeatured : function() {
        elementById('twitchFeatured').style.background = '#00FF00';
        elementById('twitchFollowed').style.background = '#888888';
        createCookie('twitchSelected', 'featured');
    },
    selectFollowed : function() {
        elementById('twitchFollowed').style.background = '#00FF00';
        elementById('twitchFeatured').style.background = '#888888';
        createCookie('twitchSelected', 'followed');
    },
    noStreamsFound : function() {
        Twitch.drawListItem('<li class="twitchEmptyList grad"><span class="twitchSub">No followed streams.</span><span class="twitchSub">Or none online.</span></li>');
    },
    refreshStream : function() {
        var winID = elementById('twitchStream'), playerID = elementById('twitch_live_embed_player_flash'), player = playerID.cloneNode(true), chat = elementById('twitch_chat_embed');
        winID.removeChild(playerID);
        winID.insertBefore(player, chat);
    },
    refreshChat : function() {
        var winID = elementById('twitchStream'), chatID = elementById('twitch_chat_embed'), chat = chatID.cloneNode(true);
        winID.removeChild(chatID);
        winID.appendChild(chat);
    },
    setupStreamWindow : function(streamName) {
        var playerID = elementById('twitch_live_embed_player_flash'), stream = elementById('twitchStream');
//        var stream = elementById('twitchStream');
        if((readCookie('twitchStream') !== streamName) || (readCookie('twitchFirstTime') === 'yes')) {
            playerID.setAttribute('flashvars', 'hostname=www.twitch.tv&channel=' + streamName + '&auto_play=true&start_volume=25')
//            elementById('playChannel').value = 'hostname=www.twitch.tv&channel=' + streamName + '&auto_play=true&start_volume=25';
            Twitch.refreshStream();
            createCookie('twitchIsOpen', 'yes');
            createCookie('twitchFirstTime', 'no');
        };
        if(stream.style.display !== 'block') { $(stream).slideToggle(); };
    },
    setupChat : function(streamName) {
        elementById('twitch_chat_embed').setAttribute('src', 'http://twitch.tv/chat/embed?channel=' + streamName + '&amp;popout_chat=true');
        Twitch.refreshChat();
    },
    closeStreamWindow : function() {
        $(elementById('twitchStream')).slideToggle();
        elementById('twitch_live_embed_player_flash').setAttribute('flashvars', '');
//        elementById('playChannel').value = '';
        Twitch.refreshStream();
        eraseCookie('twitchIsOpen');
    },
    closeChat : function() {
        var chatID = elementById('twitch_chat_embed');
        chatID.removeAttribute('src');
        emptyElement(chatID);
    }
};

$(document).ready(function() {
    if(elementById('twitchMenuContainer')) {
        Twitch.init();

        $(elementById('twitch_logout')).on('click', function(e) {
            eatEvent(e);
            eraseCookie('twitchLoggedIn');
            window.location.href = site_url + 'twitchlogout';
        });

        $(elementById('twitch_login')).on('click', function(e) {
            eatEvent(e);
            window.location.href = site_url + 'twitchlogin';
        });

        $(elementById('twitchStreamList')).on({
            click : function(e) {
                eatEvent(e);
                var streamName = this.id;
                Twitch.setupChat(streamName);
                Twitch.setupStreamWindow(streamName);
                createCookie('twitchStream', streamName);
            }
        }, 'li.twitchStreamItem');

        $(elementById('closeTwitchStream')).on('click', function(e) {
            eatEvent(e);
            Twitch.closeChat();
            Twitch.closeStreamWindow();
            eraseCookie('twitchIsOpen');
            eraseCookie('twitchStream');
            eraseCookie('twitchFirstTime');
        });

        $(elementById('toggleTwitch')).on('click', function(e) {
            eatEvent(e);
            var listen = elementById('twitchStreamList'), status = listen.style.display;
            if(status === 'none') {
                createCookie('twitchList', 'open');
                if(readCookie('twitchIsMin') === 'yes') {
                    var streamName = readCookie('twitchStream');
                    eraseCookie('twitchIsMin');
                    Twitch.setupChat(streamName);
                    Twitch.setupStreamWindow(streamName);
                };
            } else if(status === 'block') {
                createCookie('twitchList', 'closed');
                if((readCookie('twitchIsOpen') === 'yes') && (readCookie('twitchIsMin') !== 'yes')) {
                    createCookie('twitchIsMin', 'yes');
                    $(elementById('twitchStream')).slideToggle();
                };
            };
            $(listen).slideToggle(400, function() { this.parentNode.classList.toggle('twichShadow'); });
        });

        $(elementById('twitchMenuContainer')).on({
            click : function(e) {
                eatEvent(e);
                var ff = e.target.id, list = elementById('twitchStreamList');
                if(ff === 'twitchFollowed') {
                    Twitch.getFollowed();
                    Twitch.selectFollowed();
                } else if(ff === 'twitchFeatured') {
                    Twitch.getFeatured();
                    Twitch.selectFeatured();
                };
                if(list.style.display === 'none') { $(list).slideToggle(); };
            }
        }, 'header.fftoggler');
    };

    $(elementById('twitch_signin')).on('click', function(e) {
        eatEvent(e);
        window.location.href = site_url + 'twitchlogin'; // TODO : fix this login
    });
});