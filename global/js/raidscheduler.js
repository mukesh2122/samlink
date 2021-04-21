$(document)["ready"](function() {
if($("#RaidScheduler").length) {
//console.log(window.opener); // track if there is linked here from another site/program
    (function(window, document, jQuery) {
        var data = (function(window) {
            var MyConstructor = function() {
                var PlayerListData = {
                    Game    : {},
                    Role    : {},
                    Server  : {},
                    Raid    : {},
                    Comment : {},
                    Friends : {},
                    Members : {},
                    Groups  : {}
                };
                    this["getPlayerListData"]        = function() { return PlayerListData; };
                    this["getPlayerGameListData"]    = function() { return PlayerListData["Game"]; };
                    this["getPlayerRoleListData"]    = function() { return PlayerListData["Role"]; };
                    this["getPlayerServerListData"]  = function() { return PlayerListData["Server"]; };
                    this["getPlayerRaidListData"]    = function() { return PlayerListData["Raid"]; };
                    this["getPlayerCommentListData"] = function() { return PlayerListData["Comment"]; };
                    this["getPlayerFriendListData"]  = function() { return PlayerListData["Friends"]; };
                    this["getPlayerMemberListData"]  = function() { return PlayerListData["Members"]; };
                    this["getPlayerGroupListData"]   = function() { return PlayerListData["Groups"]; };
                    this["setPlayerListData"]        = function(data) { PlayerListData = data; };
                    this["setPlayerGameListData"]    = function(data) { PlayerListData["Game"] = data; };
                    this["setPlayerRoleListData"]    = function(data) { PlayerListData["Role"] = data; };
                    this["setPlayerServerListData"]  = function(data) { PlayerListData["Server"] = data; };
                    this["setPlayerRaidListData"]    = function(data) { PlayerListData["Raid"] = data; };
                    this["setPlayerCommentListData"] = function(data) { PlayerListData["Comment"] = data; };
                    this["setPlayerFriendListData"]  = function(data) { PlayerListData["Friends"] = data; };
                    this["setPlayerMemberListData"]  = function(data) { PlayerListData["Members"] = data; };
                    this["setPlayerGroupListData"]   = function(data) { PlayerListData["Groups"] = data; };

                var GroupListData = {
                    Game    : {},
                    Role    : {},
                    Server  : {},
                    Raid    : {},
                    Comment : {},
                    Members : {},
                    Groups  : {}
                };
                    this["getGroupListData"]        = function() { return GroupListData; };
                    this["getGroupGameListData"]    = function() { return GroupListData["Game"]; };
                    this["getGroupRoleListData"]    = function() { return GroupListData["Role"]; };
                    this["getGroupServerListData"]  = function() { return GroupListData["Server"]; };
                    this["getGroupRaidListData"]    = function() { return GroupListData["Raid"]; };
                    this["getGroupCommentListData"] = function() { return GroupListData["Comment"]; };
                    this["getGroupMemberListData"]  = function() { return GroupListData["Members"]; };
                    this["getGroupGroupListData"]   = function() { return GroupListData["Groups"]; };
                    this["setGroupListData"]        = function(data) { GroupListData = data; };
                    this["setGroupGameListData"]    = function(data) { GroupListData["Game"] = data; };
                    this["setGroupRoleListData"]    = function(data) { GroupListData["Role"] = data; };
                    this["setGroupServerListData"]  = function(data) { GroupListData["Server"] = data; };
                    this["setGroupRaidListData"]    = function(data) { GroupListData["Raid"] = data; };
                    this["setGroupCommentListData"] = function(data) { GroupListData["Comment"] = data; };
                    this["setGroupMemberListData"]  = function(data) { GroupListData["Members"] = data; };
                    this["setGroupGroupListData"]   = function(data) { GroupListData["Groups"] = data; };

                var FormData = {};
                    this["getFormData"] = function() { return FormData; };
                    this["setFormData"] = function(data) { FormData = data; };

                var IDs = {
                    ChangeCalViewBut    : "RSweekmonbut",
                    ViewMonBut          : "RSviewbutmon",
                    ViewWeekBut         : "RSviewbutweek",

                    MonthCalendar       : "RSmoncalendar",
                    PrevMonBut          : "RSprevMonth",
                    NextMonBut          : "RSnextMonth",
                    MonCal              : "RSmonCal",
                    MonNameTxt          : "RScurMonth",

                    WeekCalendar        : "RSweekCalDays",
                    PrevWeekBut         : "RSprevWeek",
                    NextWeekBut         : "RSnextWeek",
                    WeekCal             : "RSweekCal",
                    WeekNumberTxt       : "RSweekNum",

                    HoverPopup          : "RShoverPopup",
                    HoverPopupWin       : "RShoverPopupWin",
                    HoverPlayer         : "RShoverPlayer",
                    HoverPlayerWin      : "RShoverPlayerWin",

                    NewRaidWindow       : "RSnewRaidPopup",
                    NewRaidWeekBut      : "RSweekNewRaidBut",
                    NewRaidMonBut       : "RSmonNewRaidBut",
                    NewRaidWinCloseBut  : "RSnewRaidWinClose",
                    StartDate           : "RSnewRaidStartDate",
                    Recurring           : "RSnewRaidRecurring",
                    LoadPreset          : "RSnewRaidLoadPreset",
                    GameSelect          : "RSnewRaidGame",
                    Location            : "RSnewRaidLocation",
                    ServerSelect        : "RSnewRaidServer",
                    GameRole1           : "RSnewRaidRole1",
                    GameRole2           : "RSnewRaidRole2",
                    GameRole3           : "RSnewRaidRole3",
                    GameRole4           : "RSnewRaidRole4",
                    GameRole5           : "RSnewRaidRole5",
                    RaidSize            : "RSnewRaidRoleSum",
                    StartTime           : "RSnewRaidStartTime",
                    EndTime             : "RSnewRaidEndTime",
                    Finalize            : "RSnewRaidFinalize",
                    Remind              : "RSnewRaidRemind",
                    Description         : "RSnewRaidDescription",
                    InviteButtons       : "RSnewRaidInviteButtons",
                    InviteOpenBut       : "RSnewRaidInviteOpenBut",
                    InviteMemberBut     : "RSnewRaidInviteMemberBut",
                    InviteGroupBut      : "RSnewRaidInviteGroupBut",
                    InviteFriendBut     : "RSnewRaidInviteFriendBut",
                    InviteMixBut        : "RSnewRaidInviteMixBut",
                    SavePresetBut       : "RSnewRaidSavePresetBut",
                    CreateRaidBut       : "RSnewRaidCreateRaidBut",

                    InviteWindow        : "RSnewRaidInvitePopup",
                    InviteCloseBut      : "RSnewRaidInviteListWinClose",
                    InviteList          : "RSnewRaidInviteList",
                    InviteDoneBut       : "RSnewRaidInviteListWinDoneBut",

                    RaidInfoWindow      : "RSinfoRaidPopup",
                    RaidInfoWinCloseBut : "RSinfoRaidWinClose",
                    RaidInfoHeadDescr   : "RSinfoRaidHeaderDescription",
                    RaidInfoSignupTab   : "RSinfoRaidTabSignupBut",
                    RaidInfoSignupWin   : "RSinfoRaidTabSignupContent",
                    RaidInfoStatusTab   : "RSinfoRaidTabStatusBut",
                    RaidInfoStatusWin   : "RSinfoRaidTabStatusContent",
                    RaidInfoFinalizeTab : "RSinfoRaidTabFinalizeBut",
                    RaidInfoFinalizeWin : "RSinfoRaidTabFinalizeContent",
                    RaidInfoCommentTab  : "RSinfoRaidTabCommentsBut",
                    RaidInfoCommentsWin : "RSinfoRaidTabCommentsContent",
                    RaidInfoCommentList : "RSinfoRaidTabCommentsList",
                    RaidInfoCommentText : "RSinfoRaidTabCommentsInput",
                    RaidInfoCommentSend : "RSinfoRaidTabCommentsSendBut",
                    RaidInfoUpdateBut   : "RSinfoRaidUpdateBut",
                    RaidInfoUpdateSave  : "RSinfoRaidUpdateButSave",
                    RaidInfoUpdateDscrd : "RSinfoRaidUpdateButDiscard",
                    RaidInfoUpdateChng  : "RSinfoRaidUpdateButChange",
                    RaidInfoDeleteBut   : "RSinfoRaidDeleteBut",
                    RaidInfoSignupBut   : "RSinfoRaidSignupBut",
                    RaidInfoFinalizeBut : "RSinfoRaidFinalBut",

                    RaidSignUpCharacter : "RSsignupCharacter",
                    RaidSignUpRole      : "RSsignupRole",
                    RaidSignUpStatusBox : "RSsignupStatusBox",
                    RaidSignUpComment   : "RSsignupComment",
                    RaidSignUpDoneBut   : "RSsignupDoneBut"
                };
                    this["getIDof"] = function(IDval) { return document["getElementById"](IDval); };
                    this["getID"]   = function(IDval) { return document["getElementById"](IDs[IDval]); };
                    this["setID"]   = function(ID, IDval) { IDs[ID] = IDval; };

                var vars = {
                    Debug           : false,
                    HomePath        : site_url,
                    InvitationSet   : null,
                    InvitationList  : {},
                    ScrollIDup      : null,
                    ScrollIDdown    : null,
                    Scroll          : {},
                    TimerID         : null,
                    GroupID         : "0",
                    GroupName       : null,
                    PlayerName      : null,
                    PlayerID        : null,
                    IsOnSignUpPage  : false,
                    IsOnGroupPage   : false,
                    IsGroupMember   : false,
                    IsGroupOfficer  : false,
                    IsGroupCreator  : false,
                    IsGroupAdmin    : false,
                    TodayDate       : null,
                    TodayDay        : null,
                    prevClickMon    : null,
                    prevSelMon      : null,
                    prevClickWeek   : null,
                    prevSelWeek     : null,
                    CurYear         : 0,
                    WeekNow         : 0,
                    MonNow          : 0,
                    MonNum          : 0,
                    CurDay          : 0,
                    datepad         : "00",
                    DaysInMon       : [ 0, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ],
                    Months          : [ "NONE", lang["january"], lang["february"], lang["march"], lang["may"], lang["april"], lang["june"], lang["july"], lang["august"], lang["september"], lang["october"], lang["november"], lang["december"] ]
                };
                    this["pad"] = function(val) { return vars["datepad"]["substring"](0, 2 - val["length"]) + val; };
                    this["getVar"] = function(varKey) { return vars[varKey]; };
                    this["setVar"] = function(varKey, varVal) { vars[varKey] = varVal; };
                    this["showDebug"] = function(data) { if(vars["Debug"] === true) { console.log(data); var x = window["open"](); x["document"]["open"](); x["document"]["write"](data); }; };
            };
            return new MyConstructor();
        }(window));

        function getNewPlayerComments(Raid) {
            var tmpRaid = Raid;
            $["ajax"]({
                async : true,
                cache : false,
                crossDomain : true,
                type : "GET",
                data : { RaidID : tmpRaid },
                url : "raidscheduler/newcomment/"
            })["done"](function(result) {
                data["showDebug"](result);
                if((result !== null) && (result !== consts["undefined"]) && (result !== "")) {
                    data["setPlayerCommentListData"](JSON["parse"](result));
                    showRaidInfoComments();
                };
            })["fail"](function(data) { alertFancy(lang['ERROR'] + " : " + data); });
            return true;
        };
        function getNewGroupComments(Raid) {
            $["ajax"]({
                async : true,
                cache : false,
                crossDomain : true,
                type : "GET",
                data : { GroupID : data["getVar"]("GroupID"), RaidID : Raid },
                url : "newcomment/"
            })["done"](function(result) {
                data["showDebug"](result);
                if((result !== null) && (result !== consts["undefined"]) && (result !== "")) {
                    data["setGroupCommentListData"](JSON["parse"](result));
                    showRaidInfoComments();
                };
            })["fail"](function(data) { alertFancy(lang['ERROR'] + " : " + data); });
            return true;
        };

        function getNewPlayerRaids() {
            $["ajax"]({
                async : true,
                cache : false,
                crossDomain : true,
                type : "GET",
                url : "raidscheduler/newraid/"
            })["done"](function(result) {
                data["showDebug"](result);
                if((result !== null) && (result !== consts["undefined"]) && (result !== "")) {
                    data["setPlayerRaidListData"](JSON["parse"](result));
                    setRaids();
                };
            })["fail"](function(data) { alertFancy(lang['ERROR'] + " : " + data); });
            return true;
        };

        function getNewGroupRaids() {
            $["ajax"]({
                async : true,
                cache : false,
                crossDomain : true,
                type : "GET",
                data : { GroupID : data["getVar"]("GroupID") },
                url : "newraid/"
            })["done"](function(result) {
                data["showDebug"](result);
                if((result !== null) && (result !== consts["undefined"]) && (result !== "")) {
                    data["setGroupRaidListData"](JSON["parse"](result));
                    setRaids();
                };
            })["fail"](function(data) { alertFancy(lang['ERROR'] + " : " + data); });
            return true;
        };

        function getPlayerData() {
            $["ajax"]({
                async : true,
                cache : false,
                crossDomain : true,
                type : "GET",
                url : "raidscheduler/getdata/"
            })["done"](function(result) {
                data["showDebug"](result);
                if((result !== null) && (result !== consts["undefined"]) && (result !== "")) {
                    data["setPlayerListData"](JSON["parse"](result));
                    initData();
                };
            })["fail"](function(data) { alertFancy(lang['ERROR'] + " : " + data); });
            return true;
        };

        function getGroupData() {
            $["ajax"]({
                async : true,
                cache : false,
                crossDomain : true,
                type : "GET",
                data : { GroupID : data["getVar"]("GroupID") },
                url : "getdata/"
            })["done"](function(result) {
                data["showDebug"](result);
                if((result !== null) && (result !== consts["undefined"]) && (result !== "")) {
                    data["setGroupListData"](JSON["parse"](result));
                    initData();
                };
            })["fail"](function(data) { alertFancy(lang['ERROR'] + " : " + data); });
            return true;
        };

        function initData() {
            var gameselect = data["getID"]("GameSelect"), insdata = (data["getVar"]("IsOnGroupPage")) ? data["getGroupGameListData"]() : data["getPlayerGameListData"]();
            emptyElement(gameselect);
            gameselect["insertAdjacentHTML"]("beforeend", (insdata) ? insdata["Html"] : "");
            gameselect["selectedIndex"] = 0;
            gameselect["onchange"]();
            $(gameselect)["dropkick"]("refresh");
            setRaids();
            return true;
        };

        function showCalendar(sel) {
            var Wcal = data["getID"]("WeekCal")["style"], Mcal = data["getID"]("MonCal")["style"], WcalTxt = $(data["getIDof"]("RSviewbutweek")), McalTxt = $(data["getIDof"]("RSviewbutmon"));
            switch(parseInt(sel, 10)) {
                case 1:
                    Mcal["display"] = "none";
                    McalTxt["css"]("text-decoration", "none");
                    Wcal["display"] = "block";
                    WcalTxt["css"]("text-decoration", "underline");
                    break;
                case 2:
                    Wcal["display"] = "none";
                    WcalTxt["css"]("text-decoration", "none");
                    Mcal["display"] = "block";
                    McalTxt["css"]("text-decoration", "underline");
                    break;
                default:
            };
            return true;
        };

        function changeWeek(sel) {
            var tmpWeekID = data["getID"]("WeekNumberTxt"), tmpWeekNum = parseInt(tmpWeekID["innerHTML"], 10), prevclicked = data["getVar"]("prevClickWeek");
            if(sel) { tmpWeekNum += 1; } else { tmpWeekNum -= 1; };
            tmpWeekID["innerHTML"] = tmpWeekNum;
            $(data["getIDof"]("RSweekCalDays"))["find"]("section")["removeClass"]();
            if(parseInt(data["getVar"]("prevSelWeek"), 10) === tmpWeekNum) { if(prevclicked) { data["getIDof"](prevclicked)["classList"]["toggle"]("SelectWeek"); }; };
            setToday();
            setRaids();
            return true;
        };
        function changeMonth(sel) {
            var monthTxtID = data["getID"]("MonNameTxt"), monthList = data["getVar"]("Months"), tmpMonNum = monthList["indexOf"](monthTxtID["innerHTML"]), tmpyear = data["getVar"]("CurYear");
            if(sel) {
                tmpMonNum += 1;
                if(tmpMonNum === 13) {
                    tmpMonNum = 1;
                    tmpyear += 1;
                };
            } else {
                tmpMonNum -= 1;
                if(tmpMonNum === 0) {
                    tmpMonNum = 12;
                    tmpyear -= 1;
                };
            };
            monthTxtID["innerHTML"] = monthList[tmpMonNum];
            generateMonCal(tmpyear, tmpMonNum);
            setToday();
            setRaids();
            return true;
        };
        function setToday() {
            $("section", $(data["getIDof"]("RSweekCalDays")))["find"]("h3")["css"]({"text-decoration" : "none", "font-style" : "normal"});
            var WeekSet = parseInt(data["getID"]("WeekNumberTxt")["innerHTML"], 10), WeekNow = parseInt(data["getVar"]("WeekNow"), 10), MonSet = data["getID"]("MonNameTxt")["innerHTML"], MonNow = data["getVar"]("MonNow"), dato = new Date(), today = dato["getFullYear"]() + "-" + data["pad"]("" + (dato["getMonth"]() + 1)) + "-" + data["pad"]("" + dato["getDate"]());
            if(WeekSet === WeekNow) {
                var weekday = dato["getDay"](), weekdayTxtID = $(data["getIDof"]("RSweekCalDay" + weekday + "Txt"));
                data["setVar"]("TodayDay", weekday);
                data["setVar"]("TodayDate", today);
                weekdayTxtID["css"]({"text-decoration" : "underline", "font-style" : "italic"});
            };
            if(MonSet === MonNow) { data["getIDof"](today)["classList"]["toggle"]("TodayMon"); };
            return true;
        };

        function setRaids() {
            $(data["getIDof"]("RSmoncalendar"))["find"]("div")["remove"](".RSmonEvent");
            $(data["getIDof"]("RSweekCalDays"))["find"]("div")["remove"](".RSweekEvent");
            $("section", $(data["getIDof"]("RSweekCalDays")))["find"]("span")["removeClass"]();
            var raidlist = (data["getVar"]("IsOnGroupPage") === true) ? data["getGroupRaidListData"]() : data["getPlayerRaidListData"](), iEnd = raidlist["TotalCount"], WeekDayNum = 0, WeekDay = "", WeekDayID = "", ScrollDown = "", ScrollUp = "", WeekDayArr = new Array(0,0,0,0,0,0,0), ScrollArr = new Array(), ScrollDownID = "", ScrollUpID = "", tmpHtmlWeekID = "", CurNum = "", WeekNow = parseInt(data["getID"]("WeekNumberTxt")["innerHTML"], 10), CurNumMonID = "", monthList = data["getVar"]("Months"), CurMonth = data["getVar"]("MonNow");
            for(var i = 0; i < iEnd; ++i) {
                CurNum = raidlist[i];
                CurNumMonID = CurNum["HtmlMonID"];
                tmpHtmlWeekID = CurNum["HtmlWeekID"];
                if(parseInt(tmpHtmlWeekID["slice"](2), 10) === WeekNow) {
                    WeekDayNum = parseInt(tmpHtmlWeekID["charAt"](0), 10);
                    WeekDay = "RSweekCalDay" + WeekDayNum;
                    WeekDayID = data["getIDof"](WeekDay);
                    WeekDayID["insertAdjacentHTML"]("beforeend", CurNum["HtmlWeekCal"]);
                    ++WeekDayArr[WeekDayNum];
                    if(WeekDayArr[WeekDayNum] === 4) {
                        ScrollDown = WeekDay + "ScrollDown";
                        ScrollDownID = data["getIDof"](ScrollDown);
                        ScrollUp = WeekDay + "ScrollUp";
                        ScrollUpID = data["getIDof"](ScrollUp);
                        ScrollDownID["classList"]["toggle"]("scrolldownraids");
                        ScrollUpID["classList"]["toggle"]("scrollupraids");
                        ScrollArr[ScrollDown] = $(ScrollDownID)["offset"]();
                        ScrollArr[ScrollUp] = $(ScrollUpID)["offset"]();
                        data["setVar"]("Scroll", ScrollArr);
                    };
                };
                if((monthList[(CurNumMonID[5] === "1" ? CurNumMonID[5] : "") + CurNumMonID[6]]) === data["getID"]("MonNameTxt")["innerHTML"]) { data["getIDof"](CurNumMonID)["insertAdjacentHTML"]("beforeend", CurNum["HtmlMonCal"]); };
            };
            return true;
        };

        function setSelectedMon(target) {
            var clicked = target;
            if(data["getVar"]("TodayDate") <= clicked) {
                var prevclicked = data["getVar"]("prevClickMon");
                if(prevclicked) { data["getIDof"](prevclicked)["classList"]["toggle"]("SelectMon"); };
                data["getIDof"](clicked)["classList"]["toggle"]("SelectMon");
                data["setVar"]("prevClickMon", clicked);
            };
            return true;
        };

        function setSelectedWeek(target) {
            var clicked = target, tmp = parseInt(clicked["charAt"](12), 10), clicknum = (tmp === 0) ? 7 : tmp, prevclicked = data["getVar"]("prevClickWeek"), WeekNow = parseInt(data["getVar"]("WeekNow"), 10), WeekSet = parseInt(data["getID"]("WeekNumberTxt")["innerHTML"], 10), tmpID = "";
            if(WeekNow === WeekSet) {
                var tmpToday = data["getVar"]("TodayDay"), today = (tmpToday === 0) ? 7 : tmpToday;
                if(today <= clicknum) {
                    if(prevclicked) {
                        tmpID = data["getIDof"](prevclicked);
                        if(tmpID["classList"]["contains"]("SelectWeek")) { tmpID["classList"]["toggle"]("SelectWeek"); };
                    };
                    data["getIDof"](clicked)["classList"]["toggle"]("SelectWeek");
                    data["setVar"]("prevClickWeek", clicked);
                    data["setVar"]("prevSelWeek", WeekSet);
                };
            } else if(WeekNow < WeekSet) {
                if(prevclicked) {
                    tmpID = data["getIDof"](prevclicked);
                    if(tmpID["classList"]["contains"]("SelectWeek")) { tmpID["classList"]["toggle"]("SelectWeek"); };
                };
                data["getIDof"](clicked)["classList"]["toggle"]("SelectWeek");
                data["setVar"]("prevClickWeek", clicked);
                data["setVar"]("prevSelWeek", WeekSet);
            };
            return true;
        };

        function followCursor(event, winID) {
//            var PopupID = winID, newevent = $["event"]["fix"](event), PosX = newevent["pageX"] - 350, PosY = 31 + newevent["pageY"];
            var PopupID = winID, PosX = event["pageX"] - 350 + "px", PosY = 31 + event["pageY"] + "px";
            $(PopupID)["css"]({"left" : PosX, "top" : PosY});
//            PopupID["style"]["left"] =  PosX + "px";
//            PopupID["style"]["top"] = PosY + "px";
            return true;
        };
        function showHoverRaids(targetval) {
            var ListNum = parseInt(targetval["getAttribute"]("data-listnum"), 10), Raidlist = (data["getVar"]("IsOnGroupPage")) ? data["getGroupRaidListData"]() : data["getPlayerRaidListData"](), PopupID = data["getID"]("HoverPopup"), tmpCur = Raidlist[ListNum];
            $(data["getIDof"]("RShoverPopupWin"))["find"]("span")["empty"]();
            data["getIDof"]("RShoverGame")["insertAdjacentHTML"]("beforeend", tmpCur["GameName"]);
            data["getIDof"]("RShoverServer")["insertAdjacentHTML"]("beforeend", tmpCur["Server"]);
            data["getIDof"]("RShoverLocation")["insertAdjacentHTML"]("beforeend", tmpCur["Location"]);
            data["getIDof"]("RShoverStartTime")["insertAdjacentHTML"]("beforeend", tmpCur["StartTime"]);
            data["getIDof"]("RShoverEndTime")["insertAdjacentHTML"]("beforeend", tmpCur["EndTime"]);
            data["getIDof"]("RShoverSize")["insertAdjacentHTML"]("beforeend", tmpCur["Size"]);
            data["getIDof"]("RShoverDescription")["insertAdjacentHTML"]("beforeend", tmpCur["Description"]);
            PopupID["style"]["position"] = "absolute";
            PopupID["style"]["display"] = "block";
            $(window)["on"]("mousemove", $(PopupID), function(event) { followCursor(event, PopupID); event["stopPropagation"](); });
//            window["onmousemove"] = function(event) { followCursor(event, PopupID); event["stopPropagation"](); };
            return true;
        };
        function showInviteeInfo(targetval, sel) {
            var PageSel = sel, GroupListNum = 0, ListNum = parseInt(targetval["getAttribute"]("data-listnum"), 10), PopupID = data["getID"]("HoverPlayer"), PopupWinID = data["getID"]("HoverPlayerWin"), List = "", tmpText = "", ListItemName = "";
            emptyElement(PopupWinID);
            if(PageSel === true) {
                ListItemName = targetval["parentNode"]["getAttribute"]("name");
                if(data["getVar"]("IsOnGroupPage")) {
                    List = data["getGroupMemberListData"]();
                    tmpText = List[ListNum]["Picture"];
                } else {
                    if(ListItemName === "RSgroupList") {
                        GroupListNum = parseInt(targetval["parentNode"]["previousElementSibling"]["getAttribute"]("data-listnum"), 10);
                        List = data["getPlayerGroupListData"]();
                        tmpText = List[GroupListNum]["Members"][ListNum]["Picture"];
                    } else if(ListItemName === "RSfriendList") {
                        List = data["getPlayerFriendListData"]();
                        tmpText = List[ListNum]["Picture"];
                    };
                };
            } else if(PageSel === false) {
                if((ListNum === null) || (ListNum === consts["undefined"]) || (isNaN(ListNum))) { return true; }
                else {
                    List = data["getPlayerGroupListData"]();
                    tmpText = List[ListNum]["Picture"];
                };
            };
            PopupWinID["insertAdjacentHTML"]("beforeend", tmpText);
            PopupID["style"]["position"] = "absolute";
            PopupID["style"]["display"] = "block";
            $(window)["on"]("mousemove", $(PopupID), function(event) { followCursor(event, PopupID); event["stopPropagation"](); });
            return true;
        };

        function StopTimer() { clearInterval(data["getVar"]("TimerID")); return true; };
        function StartScrollDown() {
            var tmpdown = data["getVar"]("ScrollIDdown"), tmpdownID = tmpdown["id"], tmpup = data["getVar"]("ScrollIDup"), tmpupID = tmpup["id"], tmpscroll = data["getVar"]("Scroll");
            ++tmpdown["parentNode"]["scrollTop"];
            $(tmpdown)["offset"]({ top : tmpscroll[tmpdownID]["top"], left : tmpscroll[tmpdownID]["left"] });
            $(tmpup)["offset"]({ top : tmpscroll[tmpupID]["top"], left : tmpscroll[tmpupID]["left"] });
            return true;
        };
        function StartScrollUp() {
            --data["getVar"]("ScrollIDup")["parentNode"]["scrollTop"];
            $(data["getVar"]("ScrollIDdown"))["offset"]({ top : data["getVar"]("Scroll")[data["getVar"]("ScrollIDdown")["id"]]["top"], left : data["getVar"]("Scroll")[data["getVar"]("ScrollIDdown")["id"]]["left"] - data["getVar"]("LeftOffsetFix") });
            $(data["getVar"]("ScrollIDup"))["offset"]({ top : data["getVar"]("Scroll")[data["getVar"]("ScrollIDup")["id"]]["top"], left : data["getVar"]("Scroll")[data["getVar"]("ScrollIDup")["id"]]["left"] - data["getVar"]("LeftOffsetFix") });
            return true;
        };
        function scrollDownRaids(target) {
            var downarrow = target, uparrow = data["getIDof"](downarrow["parentNode"]["id"] + "ScrollUp");
            data["setVar"]("ScrollIDdown", downarrow);
            data["setVar"]("ScrollIDup", uparrow);
            data["setVar"]("TimerID", setInterval(StartScrollDown, 10));
            return true;
        };
        function scrollUpRaids(target) {
            var uparrow = target, downarrow = data["getIDof"](uparrow["parentNode"]["id"] + "ScrollDown");
            data["setVar"]("ScrollIDdown", downarrow);
            data["setVar"]("ScrollIDup", uparrow);
            data["setVar"]("TimerID", setInterval(StartScrollUp, 10));
            return true;
        };

        function infoFancy(tmpMsg, top, closespd) {
            var Msg = ['<h4>',tmpMsg,'</h4>']["join"]("");
            $["fancybox"]({
                "closeBtn"      : false,
                "closeClick"    : false,
                "openEffect"    : "fade",
                "closeEffect"   : "fade",
                "openSpeed"     : 250,
                "closeSpeed"    : closespd,
                "loop"          : true,
                "arrows"        : false,
                "type"          : "inline",
                "content"       : Msg,
                "autoSize"      : true,
                "autoWidth"     : true,
                "autoHeight"    : true,
                "fitToView"     : false,
                "minHeight"     : 20,
//                "maxHeight"     : 80,
                "topRatio"      : top,
//                "index"         : 9090,
                "helpers"       : {
                    "title"     : null,
                    "overlay"   : null
                },
                afterShow       : function() { $["fancybox"]["close"](); return true; }
            });
            return true;
        };
        function week2date(year, weeknum, daynum) {
            var week = parseInt(weeknum, 10), day = parseInt( (daynum === "0") ? 7 : daynum, 10 ) - 1, tmp = new Date(year, 0, day + ((week - 1) * 7)), Text = "";
            Text = [tmp["getFullYear"](), "-" + data["pad"](("" + (tmp["getMonth"]() + 1))), "-", data["pad"](("" + tmp["getDate"]()))]["join"]("");
            return Text;
        };
        function makeNewRaid(sel) {
            var prevclick = "", selected = sel;
            if(selected === true) { prevclick = (data["getVar"]("prevClickWeek")) ? week2date(data["getVar"]("CurYear"), data["getVar"]("prevSelWeek"), data["getVar"]("prevClickWeek")["charAt"](12)) : null; }
            else if(selected === false) { prevclick = data["getVar"]("prevClickMon"); };
            var today = data["getVar"]("TodayDate"), startdateID = data["getID"]("StartDate");
            startdateID["setAttribute"]("min", today);
            startdateID["setAttribute"]("value", (prevclick === null) ? today : prevclick);
            data["getID"]("NewRaidWindow")["style"]["display"] = "block";
            infoFancy(lang['RS_allrequired'], 0.14, 3500);
            return true;
        };

        function showRaidInfo(targetval) {
            var ListNum = parseInt(targetval["getAttribute"]("data-listnum"), 10), Gamelist = (data["getVar"]("IsOnGroupPage")) ? data["getGroupGameListData"]() : data["getPlayerGameListData"](), Raidlist = (data["getVar"]("IsOnGroupPage")) ? data["getGroupRaidListData"]() : data["getPlayerRaidListData"](), PlayerID = data["getVar"]("PlayerID"), FinalizeBut = data["getID"]("RaidInfoFinalizeBut"), UpdateBut = data["getID"]("RaidInfoUpdateBut"), DeleteBut = data["getID"]("RaidInfoDeleteBut"), tmpCur = Raidlist[ListNum], tmpText = [], RaidWindow = data["getID"]("RaidInfoWindow"), Image = data["getIDof"]("RSinfoHeadImg"), Game = data["getIDof"]("RSinfoHeadGame"), Desc = data["getIDof"]("RSinfoRaidHeaderDescription"), Text = "";
            FinalizeBut["style"]["display"] = "none";
            UpdateBut["style"]["display"] = "none";
            DeleteBut["style"]["display"] = "none";
            emptyElement(Image);
            emptyElement(Game);
            emptyElement(Desc);
            $("h2", $(data["getIDof"]("RSinfoHeaderTitleBox")))["find"]("span")["empty"]();
            $(data["getIDof"]("RSinfoRaidHeaderTimeBox"))["find"]("span.RSinfoHeaderText")["empty"]();
            Image["insertAdjacentHTML"]("beforeend", Gamelist["Image"][0]);
            Game["insertAdjacentHTML"]("beforeend", tmpCur["GameName"]);
            data["getIDof"]("RSinfoHeadLocation")["insertAdjacentHTML"]("beforeend", tmpCur["Location"]);
            data["getIDof"]("RSinfoHeadSize")["insertAdjacentHTML"]("beforeend", tmpCur["Size"]);
            data["getIDof"]("RSinfoHeadDate")["setAttribute"]("value", tmpCur["HtmlMonID"]);
            data["getIDof"]("RSinfoHeadStart")["setAttribute"]("value", tmpCur["StartTime"]);
            data["getIDof"]("RSinfoHeadEnd")["setAttribute"]("value", tmpCur["EndTime"]);
            tmpText = ['<a href="',tmpCur["OwnerUrl"],'">',tmpCur["Owner"],'</a>'];
            Text = tmpText["join"]("");
            data["getIDof"]("RSinfoHeadOwner")["insertAdjacentHTML"]("beforeend", Text);
            Desc["insertAdjacentHTML"]("beforeend", tmpCur["Description"]);
            RaidWindow["setAttribute"]("data-idnum", tmpCur["RaidID"]);
            RaidWindow["setAttribute"]("data-listnum", ListNum);
            if((parseInt(tmpCur["OwnerID"], 10) === PlayerID) || (data["getVar"]("IsGroupOfficer") || data["getVar"]("IsGroupCreator") || data["getVar"]("IsGroupAdmin"))) {
                FinalizeBut["style"]["display"] = "inline-block";
                UpdateBut["style"]["display"] = "inline-block";
                DeleteBut["style"]["display"] = "inline-block";
            };
            data["getID"]("RaidInfoSignupTab")["checked"] = true;
            RaidWindow["style"]["display"] = "block";
            showRaidInfoSignups();
            return true;
        };
        function showRaidInfoComments() {
            var TargetID = data["getID"]("RaidInfoWindow")["getAttribute"]("data-idnum"), Commentlist = (data["getVar"]("IsOnGroupPage")) ? data["getGroupCommentListData"]() : data["getPlayerCommentListData"](), iEnd = Commentlist["length"], tmpNum = "", tmpText = [], Text = "", ListID = data["getID"]("RaidInfoCommentList");
            emptyElement(ListID);
            for(var i = 0; i < iEnd; ++i) {
                tmpNum = Commentlist[i];
                if(TargetID === tmpNum["RaidID"]) { tmpText["push"]('<li><a href="',tmpNum["SenderUrl"],'">',tmpNum["Sender"],'</a> :: ',tmpNum["Comment"],'</li>'); };
            };
            Text = tmpText["join"]("");
            ListID["insertAdjacentHTML"]("beforeend", Text);
            return true;
        };
        function sendRaidComment() {
            var TextField = data["getID"]("RaidInfoCommentText"), GPage = data["getVar"]("IsOnGroupPage"), url = (GPage)? "newcomment/" : "raidscheduler/newcomment/", Raid = parseInt(data["getID"]("RaidInfoWindow")["getAttribute"]("data-idnum")["substring"](6), 10), package = {
                RaidID      : Raid,
                Comment     : TextField["value"]["toString"](),
                GroupID     : (GPage) ? parseInt(data["getVar"]("GroupID"), 10) : null
            };
            $["post"](url, package)
            ["done"]( function(result) {
                if((result !== null) && (result !== consts["undefined"]) && (result !== "")) { alertFancy(result); };
                if(GPage === true) { getNewGroupComments(Raid); }
                else if(GPage === false) { getNewPlayerComments(Raid); };
                TextField["value"] = "";
            })["fail"]( function(data) { alertFancy(lang['ERROR'] + " : " + data); });
            return true;
        };

        function showRaidInfoSignups() {
            var SignupContent = data["getID"]("RaidInfoSignupWin"), RaidWindow = data["getID"]("RaidInfoWindow"), ListNum = RaidWindow["getAttribute"]("data-listnum"), GroupPage = data["getVar"]("IsOnGroupPage"), RaidList = (GroupPage === true) ? data["getGroupRaidListData"]() : data["getPlayerRaidListData"](), CurRaid = RaidList[ListNum], Text = "", tmpText = ["<ul>"], Invited = CurRaid["Invited"], iEnd = Invited["length"], CurItem = {}, RoleList = (GroupPage === true) ? data["getGroupRoleListData"]() : data["getPlayerRoleListData"](), cEnd = RoleList["length"], CurRole = "", x = 0;
            emptyElement(SignupContent);
            for(var i = 0; i < iEnd; ++i) {
                CurItem = Invited[i];
                if(CurItem["Status"] === "accepted") {
                    for(var c = 0; c < cEnd; ++c) { if(CurItem["Role"] === RoleList[c]["ID_ROLE"]) { CurRole = RoleList[c]["RoleName"]; c = 1 + cEnd; }; };
                    tmpText["push"]('<li><a href="',CurItem["Url"],'">',CurItem["NickName"],'.</a> ',lang['RS_signupas'],' : ',CurRole,'.  ',lang['RS_signupwith'],' : ',CurItem["CharName"],'.</li>');
                    ++x;
                };
            };
            if(x === 0) { Text = lang['RS_nosignup']; }
            else {
                tmpText["push"]("</ul>");
                Text = tmpText["join"]("");
            };
            SignupContent["insertAdjacentHTML"]("beforeend", Text);
        };

        function showRaidInfoStatus() {
            var StatusContent = data["getID"]("RaidInfoStatusWin"), RaidWindow = data["getID"]("RaidInfoWindow"), ListNum = RaidWindow["getAttribute"]("data-listnum"), GroupPage = data["getVar"]("IsOnGroupPage"), RaidList = (GroupPage === true) ? data["getGroupRaidListData"]() : data["getPlayerRaidListData"](), CurRaid = RaidList[ListNum], InviteType = CurRaid["InviteType"], Text = "", tmpText = [], tmpTextR = [], Invited = [], iEnd = 0, CurItem = {}, RoleList = (GroupPage === true) ? data["getGroupRoleListData"]() : data["getPlayerRoleListData"](), cEnd = RoleList["length"], CurRole = "";
            emptyElement(StatusContent);
            if(InviteType === "open") { tmpText["push"]("<h3>",lang["RS_openforall"],".</h3><br><h5>",lang['RS_whoenlisted'],".</h5>"); }
            else {
                Invited = CurRaid["Invited"];
                iEnd = Invited["length"];
                tmpText["push"]('<div id="RSinfoRaidTabStatusLeft"><h3>',lang['RS_waiting'],'.</h3><ul>');
                tmpTextR["push"]('<div id="RSinfoRaidTabStatusRight"><h3>',lang['RS_declined'],'.</h3><ul>');
                for(var i = 0; i < iEnd; ++i) {
                    CurItem = Invited[i];
                    switch(CurItem["Status"]) {
                        case "waiting":
                            for(var c = 0; c < cEnd; ++c) { if(CurItem["Role"] === RoleList[c]["ID_ROLE"]) { CurRole = RoleList[c]["RoleName"]; c = 1 + cEnd; }; };
                            tmpText["push"]('<li><a href="',CurItem["Url"],'">',CurItem["NickName"],'.</a></li>');
                            break;
                        case "rejected":
                            tmpTextR["push"]('<li><a href="',CurItem["Url"],'">',CurItem["NickName"],'</a></li>');
                            break;
                        default:
                            break;
                    };
                };
                tmpText["push"]("</ul></div>");
                tmpTextR["push"]("</ul></div>");
                tmpText["push"]["apply"](tmpText, tmpTextR);
            };
            Text = tmpText["join"]("");
            StatusContent["insertAdjacentHTML"]("beforeend", Text);
        };

        function setRoles(sel) {
            var selval = sel, rolelist = (data["getVar"]("IsOnGroupPage")) ? data["getGroupRoleListData"]() : data["getPlayerRoleListData"](), iEnd = rolelist["length"], c = 1, roleID = "", tmpID = "", tmpnum = "";
            $(data["getIDof"]("RSnewRaidRoles"))["find"]("label")["css"]("display", "none");
            $(data["getIDof"]("RSnewRaidRoles"))["find"]("input")["val"](0);
            for(var i = 0; i < iEnd; ++i) {
                tmpnum = rolelist[i];
                if(selval === tmpnum["FK_GAME"]) {
                    tmpID = data["getID"]("GameRole" + c), roleID = tmpID["parentNode"];
                    roleID["firstChild"]["data"] = tmpnum["RoleName"];
                    tmpID["setAttribute"]("data-idnum", tmpnum["ID_ROLE"]);
//                    tmpID["dataset"]["idnum"] = tmpnum["ID_ROLE"]; // HTML 5 only!
                    switch(parseInt(tmpnum["ID_ROLE"], 10)) {
                        case 1:
                            roleID["classList"]["toggle"]("Tank");
                            break;
                        case 2:
                            roleID["classList"]["toggle"]("Healer");
                            break;
                        case 3:
                            roleID["classList"]["toggle"]("DPS");
                            break;
                        default:
                            roleID["className"] = "";
                    };
                    tmpID["value"] = 10;
                    roleID["style"]["display"] = "inline";
                    ++c;
                };
            };
            if(c === 1) {
                tmpID = data["getID"]("GameRole1");
                roleID = tmpID["parentNode"];
                roleID["firstChild"]["data"] = lang['RS_noroles'];
                roleID["className"] = "";
                roleID["style"]["display"] = "inline";
            };
            data["getID"]("GameRole1")["onkeyup"]();
            return true;
        };

        function setServers(sel) {
            var selval = sel, serverlist = (data["getVar"]("IsOnGroupPage")) ? data["getGroupServerListData"]() : data["getPlayerServerListData"](), iEnd = serverlist["length"], tmplist = [], list = "", CurSer = "", Servers = data["getID"]("ServerSelect");
            emptyElement(Servers);
            for(var i = 0; i < iEnd; ++i) {
                CurSer = serverlist[i];
                if(selval === CurSer["GameID"]) { tmplist["push"](CurSer["HtmlCode"]); };
            };
            if(tmplist.length === 0) { tmplist["push"]("<option>",lang['Default'],"</option>"); }
            list = tmplist["join"]("");
            Servers["insertAdjacentHTML"]("beforeend", list);
            $(Servers)["dropkick"]("refresh");
            return true;
        };

        function roleAmountInputCheck(target, key) {
            var pressed = parseInt(key, 10), realval = parseInt(pressed, 10) - 48, tmpID = target, max = parseInt(tmpID["max"], 10), curval = tmpID["value"], sum = "" + curval + realval;
            if(pressed > 31 && (pressed < 48 || pressed > 57)) { return false; };
            if(max < sum) { return false; };
            return true;
        };
        function roleAmountSum() {
            var Sum = 0, tmp = 0;
            for(var i = 1; i < 6; ++i) {
                tmp =  parseInt(data["getID"]("GameRole" + i)["value"], 10);
                Sum += (isNaN(tmp)) ? 0 : tmp;
            };
            data["getID"]("RaidSize")["value"] = Sum;
            return true;
        };

        function savePreset() {
            // save in local storage
            return true;
        };

        function alertFancy(tmpMsg) {
            var Msg = ["<h2>",tmpMsg,"</h2>"]["join"]("");
            $["fancybox"]({
                "closeBtn"      : false,
                "closeClick"    : true,
                "openEffect"    : "elastic",
                "closeEffect"   : "elastic",
                "openSpeed"     : 300,
                "closeSpeed"    : 200,
                "loop"          : true,
                "arrows"        : false,
                "type"          : "inline",
                "content"       : Msg,
                "autoSize"      : true,
                "autoWidth"     : true,
                "autoHeight"    : true,
                "fitToView"     : false,
                "minHeight"     : 20,
//                "maxHeight"     : 100,
                "helpers"       : {
                    "title"     : null,
                    "overlay"   : {
                        "closeClick"    : true,
                        "css"   : {
                            "background"    : "rgba(0, 0, 0, 0.3)"
                        }
                    }
                }
            });
            return true;
        };
        function checkRaidInput() {
            var myGroupID = parseInt(data["getVar"]("GroupID"), 10), TimeStart = data["getID"]("StartDate")["value"] + " " + data["getID"]("StartTime")["value"], StartingTime = parseInt(Date["parse"](TimeStart["replace"](/-/g, "/")), 10)/1000, TimeEnd = data["getID"]("StartDate")["value"] + " " + data["getID"]("EndTime")["value"], EndingTime = parseInt(Date["parse"](TimeEnd["replace"](/-/g, "/")), 10)/1000, Recur = parseInt(data["getID"]("Recurring")["value"], 10), SelGame = parseInt(data["getID"]("GameSelect")["value"], 10), SelServer = parseInt(data["getID"]("ServerSelect")["value"], 10), LocationTxt = data["getID"]("Location")["value"]["toString"](), TotalSize = parseInt(data["getID"]("RaidSize")["value"], 10), Description = data["getID"]("Description")["value"]["toString"](), InvitationType = parseInt(data["getVar"]("InvitationSet"), 10), InviteList = new Array(data["getVar"]("InvitationList")), Invites = (InvitationType === 1) ? "" : InviteList["filter"](function(elem, pos) { return InviteList["indexOf"](elem) === pos; }), Final = parseInt(data["getID"]("Finalize")["value"], 10), Remind = parseInt(data["getID"]("Remind")["value"], 10), formdata = {};
            if((data["getVar"]("IsOnGroupPage") === true) && (myGroupID <= 0)) { alertFancy(lang['RS_msg_nogroup'] + " ???"); return false; };
            if(StartingTime <= 0) { alertFancy(lang['RS_msg_nostart'] + "."); return false; };
            if(EndingTime <= 0) { alertFancy(lang['RS_msg_noend'] + "."); return false; };
            if(Recur <= 0) { alertFancy(lang['RS_msg_norecur'] + "."); return false; };
            if(SelGame <= 0) { alertFancy(lang['RS_msg_nogame'] + "."); return false; };
            if(SelServer <= 0) { alertFancy(lang['RS_msg_noserver'] + "."); return false; };
            if(LocationTxt["length"] < 2) { alertFancy(lang['RS_msg_nolocat'] + "."); return false; };
            if(TotalSize <= 0) { alertFancy(lang['RS_msg_noppl'] + "."); return false; };
            if(Description["length"] < 2) { alertFancy(lang['RS_msg_nodesc'] + "."); return false; };
            if(isNaN(InvitationType) || (InvitationType <= 0)) { alertFancy(lang['RS_msg_noinvtype'] + "."); return false; };
            if((InvitationType !== 1) && (Invites[0]["length"] <= 0)) { alertFancy(lang['RS_msg_noinvite'] + "."); return false; };
            if(Final <= 0) { alertFancy(lang['RS_msg_nofinal'] + "."); return false; };
            if(Remind <= 0) { alertFancy(lang['RS_msg_noremind'] + "."); return false; };

            var Roles = [], roleID = "", parent = "";
            for(var i = 1, val = 0; i < 5; ++i) {
                roleID = data["getID"]("GameRole" + i);
                parent = roleID["parentNode"];
                if(parent["style"]["display"] === "inline" ) {
                    val = parseInt(roleID["value"], 10);
                    Roles["push"]({"Name" : parent["firstChild"]["data"]["toString"](), "RoleID": parseInt(roleID["getAttribute"]("data-idnum"), 10), "Amount" : val}); // HTML 5 ONLY!  ->  roleID["dataset"]["idnum"]
                };
            };
//            if(!inputnum["match"](check)) { console.log("Invalid input"); return false; };
//            var check = new RegExp("^[1-9]{1}[0-9]{0,2}$");
            formdata = {
                GroupID         : myGroupID,
                StartTime       : StartingTime,
                EndTime         : EndingTime,
                Recurring       : Recur,
                Game            : SelGame,
                Server          : SelServer,
                Location        : LocationTxt,
                Size            : TotalSize,
                RoleList        : Roles,
                RaidDesc        : Description,
                InviteType      : InvitationType,
                Invitees        : Invites[0],
                Finalized       : Final,
                RemindInterval  : Remind
            };
            data["setFormData"](formdata);
            return true;
        };
        function createRaid() {
            var checked = checkRaidInput(), formdata = {};
            if(checked === false) { return false; };
            formdata = data["getFormData"]();
            if(formdata === null) { alertFancy(lang['RS_err_form'] + "..."); return false; };
            var GPage = data["getVar"]("IsOnGroupPage"), url = (GPage) ? "newraid/" : "raidscheduler/newraid/", popupwin = data["getID"]("NewRaidWindow");
            $["post"](url, formdata)
            ["done"]( function(result) {
                if((result !== null) && (result !== consts["undefined"]) && (result !== "")) { alertFancy(result); };
                data["showDebug"](result);
                if(GPage) { getNewGroupRaids(); }
                else { getNewPlayerRaids(); };
                popupwin["style"]["display"] = "none";
                data["setFormData"](null);
            })["fail"]( function(data) { alertFancy(lang['ERROR'] + " : " + data); });
            return true;
        };

        function deleteRaid() {
            var GPage = data["getVar"]("IsOnGroupPage"), url = (GPage) ? "deleteraid/" : "raidscheduler/deleteraid/", tmpRaidID = data["getID"]("RaidInfoWindow")["getAttribute"]("data-idnum")["substring"](6);
            $["post"](url, { RaidID : parseInt(tmpRaidID, 10), GroupID : (GPage) ? parseInt(data["getVar"]("GroupID"), 10) : null })
            ["done"]( function(result) {
                if((result !== null) && (result !== consts["undefined"]) && (result !== "")) { alertFancy(result); };
                data["showDebug"](result);
                if(GPage) { getNewGroupRaids(); }
                else { getNewPlayerRaids(); };
                data["getID"]("RaidInfoWindow")["style"]["display"] = "none";
            })["fail"]( function(data) { alertFancy(lang['ERROR'] + " : " + data); });
            return true;
        };

        function openInviteWindow(sel) {
            var Selected = sel, tmpText = [], Text = "", InsList = "", iEnd = 0, CurItem = "", cEnd = 0, CurMemb = "", GroupName = "", InviteList = data["getID"]("InviteList");
            emptyElement(InviteList);
            switch(parseInt(Selected, 10)) {
                case 2:
                    InsList = data["getGroupMemberListData"]();
                    if((InsList === null) || (InsList === consts["undefined"]) || (InsList === null)) { break; };
                    iEnd = InsList["length"];
                    tmpText["push"]('<li class="RSinviteListTitle"><label><input type="checkbox">',lang['RS_allmembers'],'</label></li><ul name="RSmemberList">');
                    for(var i = 0; i < iEnd; ++i) {
                        CurItem = InsList[i];
                        tmpText["push"]('<li class="RSinviteListItem" data-listnum=', i, '><label><input type="checkbox" data-idnum=', CurItem["IDnum"], ' name="RSmember">', CurItem["NickName"], '</label>  (<a href="', CurItem["Url"] + '">', CurItem["Name"] ,'</a>)</li>');
                    };
                    tmpText["push"]('</ul>');
                    break;
                case 3:
                    InsList = data["getPlayerGroupListData"]();
                    if((InsList === null) || (InsList === consts["undefined"]) || (InsList === null)) { break; };
                    iEnd = InsList["length"];
                    for(var i = 0; i < iEnd; ++i) {
                        CurItem = InsList[i];
                        GroupName = CurItem["Name"];
                        tmpText["push"]('<li class="RSinviteListTitle" data-listnum=', i, '><label><input type="checkbox" data-idnum=', CurItem["IDnum"] + '>', GroupName, '</label></li><ul name="RSgroupList">');
                        cEnd = parseInt(CurItem["MemberCount"], 10);
                        for(var c = 0; c < cEnd; ++c) {
                            CurMemb = CurItem["Members"][c];
                            tmpText["push"]('<li class="RSinviteListItem" data-listnum=', c, '><label><input type="checkbox" data-idnum=', CurMemb["IDnum"], ' name="RSmember">', CurMemb["NickName"], '</label>  (<a href="', CurMemb["Url"], '">', CurMemb["Name"], '</a>)</li>');
                        };
                        tmpText["push"]('</ul>');
                    };
                    break;
                case 4:
                    InsList = data["getPlayerFriendListData"]();
                    if((InsList === null) || (InsList === consts["undefined"]) || (InsList === null)) { break; };
                    iEnd = InsList["length"];
                    tmpText["push"]('<li class="RSinviteListTitle"><label><input type="checkbox">',lang['RS_allfriends'],'</label></li><ul name="RSfriendList">');
                    for(var i = 0; i < iEnd; ++i) {
                        CurItem = InsList[i];
                        tmpText["push"]('<li class="RSinviteListItem" data-listnum=', i, '><label><input type="checkbox" data-idnum=', CurItem["IDnum"], ' name="RSfriend">', CurItem["NickName"], '</label>  (<a href="', CurItem["Url"], '">', CurItem["Name"], '</a>)</li>');
                    };
                    tmpText["push"]('</ul>');
                    break;
                case 5:
                    InsList = data["getPlayerFriendListData"]();
                    if((InsList !== null) && (InsList !== consts["undefined"]) && (InsList !== null)) { 
                        iEnd = InsList["length"];
                        tmpText["push"]('<li class="RSinviteListTitle"><label><input type="checkbox">',lang['RS_allfriends'],'</label></li><ul name="RSfriendList">');
                        for(var i = 0; i < iEnd; ++i) {
                            CurItem = InsList[i];
                            tmpText["push"]('<li class="RSinviteListItem" data-listnum=', i, '><label><input type="checkbox" data-idnum=', CurItem["IDnum"], ' name="RSfriend">', CurItem["NickName"], '</label>  (<a href="', CurItem["Url"], '">', CurItem["Name"], '</a>)</li>');
                        };
                        tmpText["push"]('</ul>');
                    };
                    InsList = data["getPlayerGroupListData"]();
                    if((InsList !== null) && (InsList !== consts["undefined"]) && (InsList !== null)) { 
                        iEnd = InsList["length"];
                        for(var i = 0; i < iEnd; ++i) {
                            CurItem = InsList[i];
                            GroupName = CurItem["Name"];
                            tmpText["push"]('<li class="RSinviteListTitle" data-listnum=', i, '><label><input type="checkbox" data-idnum=', CurItem["IDnum"], '>', GroupName, '</label></li><ul name="RSgroupList">');
                            cEnd = parseInt(CurItem["MemberCount"], 10);
                            for(var c = 0; c < cEnd; ++c) {
                                CurMemb = CurItem["Members"][c];
                                tmpText["push"]('<li class="RSinviteListItem" data-listnum=', c, '><label><input type="checkbox" data-idnum=', CurMemb["IDnum"], ' name="RSmember">', CurMemb["NickName"], '</label>  (<a href="', CurMemb["Url"], '">', CurMemb["Name"], '</a>)</li>');
                            };
                            tmpText["push"]('</ul>');
                        };
                    };
                    break;
                default:
            };
            Text = tmpText["join"]("");
            InviteList["insertAdjacentHTML"]("beforeend", Text);
            data["getID"]("InviteWindow")["style"]["display"] = "block";
            return true;
        };
        function inviteListSelectAll(targetval) {
            var Target = targetval, NewButState = Target["firstChild"]["firstChild"]["checked"], List =  Target["nextSibling"]["getElementsByTagName"]("input"), iEnd = List["length"];
            for(var i = 0; i < iEnd; ++i) { List[i]["checked"] = NewButState; };
            return true;
        };
        function closeInviteWindow() {
            var PrevSet = data["getVar"]("InvitationSet"), tmpBut = "";
            if(PrevSet !== null) {
                switch(parseInt(PrevSet, 10)) {
                    case 1:
                        tmpBut = data["getID"]("InviteOpenBut");
                        break;
                    case 2:
                        tmpBut = data["getID"]("InviteMemberBut");
                        break;
                    case 3:
                        tmpBut = data["getID"]("InviteGroupBut");
                        break;
                    case 4:
                        tmpBut = data["getID"]("InviteFriendBut");
                        break;
                    case 5:
                        tmpBut = data["getID"]("InviteMixBut");
                        break;
                    default:
                };
                tmpBut["checked"] = true;
            };
            data["getID"]("InviteWindow")["style"]["display"] = "none";
            return true;
        };
        function storeSelectedInvites() {
            var Buttons = data["getID"]("InviteButtons")["getElementsByTagName"]("input"), CheckboxList = data["getID"]("InviteList")["getElementsByTagName"]("input"), CBListEnd = CheckboxList["length"], SelectedList = new Array(0), ButVal = 0, tmpList = "", CurBut = "";
            for(var i = 0; i < 4; ++i) {
                CurBut = Buttons[i];
                if(CurBut["checked"] === true) {
                    ButVal = CurBut["value"];
                    i = 5;
                };
            };
            switch(parseInt(ButVal, 10)) {
                case 2:
                    data["setVar"]("InvitationSet", 2);
                    for(var i = 0, c = 0; i < CBListEnd; ++i) {
                        tmpList = CheckboxList[i];
                        if((tmpList["checked"] === true) && (tmpList["name"] === "RSmember")) {
                            SelectedList[c] = parseInt(tmpList["getAttribute"]("data-idnum"), 10);
                            ++c;
                        };
                    };
                    break;
                case 3:
                    data["setVar"]("InvitationSet", 3);
                    for(var i = 0, c = 0; i < CBListEnd; ++i) {
                        tmpList = CheckboxList[i];
                        if((tmpList["checked"] === true) && (tmpList["name"] === "RSmember")) {
                            SelectedList[c] = parseInt(tmpList["getAttribute"]("data-idnum"), 10);
                            ++c;
                        };
                    };
                    break;
                case 4:
                    data["setVar"]("InvitationSet", 4);
                    for(var i = 0, c = 0; i < CBListEnd; ++i) {
                        tmpList = CheckboxList[i];
                        if((tmpList["checked"] === true) && (tmpList["name"] === "RSfriend")) {
                            SelectedList[c] = parseInt(tmpList["getAttribute"]("data-idnum"), 10);
                            ++c;
                        };
                    };
                    break;
                case 5:
                    data["setVar"]("InvitationSet", 5);
                    for(var i = 0, c = 0; i < CBListEnd; ++i) {
                        tmpList = CheckboxList[i];
                        if((tmpList["checked"] === true) && ((tmpList["name"] === "RSfriend") || (tmpList["name"] === "RSmember"))) {
                            SelectedList[c] = parseInt(tmpList["getAttribute"]("data-idnum"), 10);
                            ++c;
                        };
                    };
                    break;
                default:
            };
            data["setVar"]("InvitationList", SelectedList);
            data["getID"]("InviteWindow")["style"]["display"] = "none";
            return true;
        };

        function signUpRaid() {
            var Character = data["getID"]("RaidSignUpCharacter")["value"]["toString"](), Role = data["getID"]("RaidSignUpRole")["value"], StatusButs = data["getID"]("RaidSignUpStatusBox")["getElementsByTagName"]("input"), Comment = data["getID"]("RaidSignUpComment")["value"]["toString"](), CurBut = "", ButVal = 0, FormData = {}, Locat = window["location"], PathName = Locat["pathname"], raidID = PathName["slice"](parseInt(PathName["indexOf"]("raidscheduler/signup/"), 10) + 21);
            for(var i = 0; i < 3; ++i) {
                CurBut = StatusButs[i];
                if(CurBut["checked"] === true) {
                    ButVal = CurBut["value"];
                    i = 4;
                };
            };
            if(ButVal === 3) {
                $["post"]("raidscheduler/decline/", { RaidID : raidID })
                ["done"]( function(result) {
                    data["showDebug"](result);
                    if((result !== null) && (result !== consts["undefined"]) && (result !== "")) { alertFancy(result); }
                    else { Locat["href"] = data["getVar"]("HomePath") + "events/raidscheduler"; };
                    return true;
                })["fail"]( function(data) { alertFancy(lang["ERROR"] + " : " + data); return false; });
            } else {
                if(Character["length"] <= 2) { alertFancy(lang['RS_msg_nochar'] + "."); return false; };
                if(Role <= 0) { alertFancy(lang['RS_msg_norole'] + "."); return false; };
                if(ButVal <= 0) { alertFancy(lang['RS_msg_nostatus'] + "."); return false; };
    //            if(Comment["length"] <= 0) { alertFancy("Please comment."); return false; };
                FormData = {
                    Char    : Character,
                    Role    : Role,
                    Status  : ButVal,
                    Comment : Comment,
                    RaidID  : raidID
                };
                $["post"]("create/", FormData)
                ["done"]( function(result) {
                    data["showDebug"](result);
                    if((result !== null) && (result !== consts["undefined"]) && (result !== "")) { alertFancy(result); }
                    else { Locat["href"] = data["getVar"]("HomePath") + "events/raidscheduler"; };
                    return true;
                })["fail"]( function(data) { alertFancy(lang["ERROR"] + " : " + data); return false; });
            };
            return true;
        };

        function changeRaid(targetval) {
            var ButState = targetval, ChangeBut = data["getID"]("RaidInfoUpdateChng"), SaveBut = data["getID"]("RaidInfoUpdateSave"), DiscardBut = data["getID"]("RaidInfoUpdateDscrd"), Desc = data["getID"]("RaidInfoHeadDescr"), Date = data["getIDof"]("RSinfoHeadDate"), StartTime = data["getIDof"]("RSinfoHeadStart"), EndTime = data["getIDof"]("RSinfoHeadEnd");
            if(ButState === true) {
                ChangeBut["style"]["display"] = "none";
                SaveBut["style"]["display"] = "inline-block";
                DiscardBut["style"]["display"] = "inline-block";
                // save old values in backup buffer
                // make every element editable(remove readonly)
                Desc["readOnly"] = false;
                Date["readOnly"] = false;
                StartTime["readOnly"] = false;
                EndTime["readOnly"] = false;
                $(data["getIDof"]("RSinfoHeadStart"))["timepicker"]({ timeOnly: true });
                $(data["getIDof"]("RSinfoHeadEnd"))["timepicker"]({ timeOnly: true });
            } else if(ButState === false) {
                SaveBut["style"]["display"] = "none";
                DiscardBut["style"]["display"] = "none";
                ChangeBut["style"]["display"] = "inline-block";
                // make every element readonly
                Desc["readOnly"] = true;
                Date["readOnly"] = true;
                StartTime["readOnly"] = true;
                EndTime["readOnly"] = true;
                $(data["getIDof"]("RSinfoHeadStart"))["timepicker"]("destroy");
                $(data["getIDof"]("RSinfoHeadEnd"))["timepicker"]("destroy");
            };
            return true;
        };
        function discardRaidChanges() {
            // revert visible contents back from backup buffer
            // clear backup buffer
            var ChangeBut = data["getID"]("RaidInfoUpdateChng");
            ChangeBut["click"]();
            return true;
        };
        function saveRaidChanges() {
            // apply changes and clear backup buffer
            return true;
        };

        function isLeapYear(year) { return ((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0); };
        function generateMonCal(year, month) {
            var MonCalID = data["getID"]("MonthCalendar"), CurItem = "", CurChild = "", FullList = document["createDocumentFragment"](), CurYear = year, PrevYear = CurYear - 1, NextYear = CurYear, CurMon = month, PrevMon = CurMon - 1, NextMon = CurMon + 1, DaysInList = data["getVar"]("DaysInMon"), DaysInCur = DaysInList[CurMon], DaysInPrev = DaysInList[PrevMon], c = 0, tmpDaysLast = new Date(CurYear, CurMon - 1, 1, 12, 12, 12), FirstOf = (tmpDaysLast["getDay"]() === 0) ? 7 : tmpDaysLast["getDay"]();
            emptyElement(MonCalID);
            if(CurMon === 1) {
                PrevMon = 12;
                DaysInPrev = DaysInList[12];
            } else if(CurMon === 12) {
                NextMon = 1;
                NextYear = CurYear + 1;
            };
            if(isLeapYear(CurYear)) { if(CurMon === 2) { DaysInCur += 1; } else if(CurMon === 3) { DaysInPrev += 1; }; };
            for(var i = DaysInPrev - FirstOf + 2; i <= DaysInPrev; ++i, ++c) {
                CurItem = document["createElement"]("li");
                CurItem["id"] = "" + PrevYear + "-" + data["pad"]("" + PrevMon) + "-" + data["pad"]("" + i);
                CurItem["className"] = "inactive";
                CurItem["innerHTML"] = i;
                FullList["appendChild"](CurItem);
            };
            for(var i = 1; i <= DaysInCur; ++i, ++c) {
                CurChild = document["createElement"]("span");
                CurChild["innerHTML"] = i;
                CurItem = document["createElement"]("li");
                CurItem["id"] = "" + CurYear + "-" + data["pad"]("" + CurMon) + "-" + data["pad"]("" + i);
                CurItem["appendChild"](CurChild);
                FullList["appendChild"](CurItem);
            };
            for(var i = 1; c < 35; ++i, ++c) {
                CurItem = document["createElement"]("li");
                CurItem["id"] = "" + NextYear + "-" + data["pad"]("" + NextMon) + "-" + data["pad"]("" + i);
                CurItem["className"] = "inactive";
                CurItem["innerHTML"] = i;
                FullList["appendChild"](CurItem);
            };
            MonCalID["appendChild"](FullList);
        };

        window["oncontextmenu"] = function() { console.log("Right Clicking/Context Menu - Detected"); };
//        $(document)["ready"](function() {
            if(consts["isLoggedIn"] === "yes") {
                data["setVar"]("PlayerID", consts["PlayerID"]);
                data["setVar"]("IsOnSignUpPage", consts["SignUpPage"]);
                if((consts["SignUpPage"] === consts["undefined"]) || (consts["SignUpPage"] === null) || (consts["SignUpPage"] === "false")) {
                    var tmpdate = new Date(), tmpweek = $["datepicker"]["iso8601Week"](tmpdate), tmpObj = consts["getGlobal"]("MyConnectTimeObj"), tmpList = data["getVar"]("Months");
                    data["setVar"]("WeekNow", tmpweek);
                    data["setVar"]("CurYear", tmpdate["getFullYear"]());
                    data["setVar"]("CurDay", tmpdate["getDate"]());
                    data["setVar"]("MonNum", 1 + tmpdate["getMonth"]());
                    data["setVar"]("MonNow", tmpList[tmpObj["mon"]]);
                    data["getID"]("MonNameTxt")["innerHTML"] = tmpList[tmpObj["mon"]];
                    data["getID"]("WeekNumberTxt")["innerHTML"] = tmpweek;
                    generateMonCal(data["getVar"]("CurYear"), parseInt(data["getVar"]("MonNum"), 10));
                    if((GroupPage !== consts["undefined"]) && (GroupPage !== null) && (GroupPage === true)) {
                        data["setVar"]("IsOnGroupPage", GroupPage);
                        data["setVar"]("GroupID", GroupID);
                        if((GroupMember !== consts["undefined"]) && (GroupMember !== null)) { data["setVar"]("IsGroupMember", GroupMember); };
                        if((GroupOfficer !== consts["undefined"]) && (GroupOfficer !== null)) { data["setVar"]("IsGroupOfficer", GroupOfficer); };
                        if((GroupCreator !== consts["undefined"]) && (GroupCreator !== null)){ data["setVar"]("IsGroupCreator", GroupCreator); };
                        if((GroupAdmin !== consts["undefined"]) && (GroupAdmin !== null)){ data["setVar"]("IsGroupAdmin", GroupAdmin); };
                        getGroupData();
                    } else { getPlayerData(); };
                    data["getID"]("ChangeCalViewBut")["onchange"]   = function(event) { showCalendar(this["value"]); event["stopPropagation"](); };
                    data["getID"]("ViewMonBut")["onclick"]          = function(event) { $("#RSweekmonbut")["prop"]("value", 2)["change"](); event["stopPropagation"](); };
                    data["getID"]("ViewWeekBut")["onclick"]         = function(event) { $("#RSweekmonbut")["prop"]("value", 1)["change"](); event["stopPropagation"](); };
                    data["getID"]("PrevMonBut")["onclick"]          = function(event) { changeMonth(false); event["stopPropagation"](); };
                    data["getID"]("NextMonBut")["onclick"]          = function(event) { changeMonth(true); event["stopPropagation"](); };
                    data["getID"]("PrevWeekBut")["onclick"]         = function(event) { changeWeek(false); event["stopPropagation"](); };
                    data["getID"]("NextWeekBut")["onclick"]         = function(event) { changeWeek(true); event["stopPropagation"](); };
                    if(data["getVar"]("IsOnGroupPage")) {
                        if(data["getVar"]("IsGroupMember")) {
                            data["getID"]("RaidInfoUpdateBut")["onclick"]   = function(event) { changeRaid(this["checked"]); event["stopPropagation"](); };
                            data["getID"]("RaidInfoUpdateSave")["onclick"]  = function(event) { saveRaidChanges(); event["stopPropagation"](); };
                            data["getID"]("RaidInfoUpdateDscrd")["onclick"] = function(event) { discardRaidChanges(); event["stopPropagation"](); };
                            data["getID"]("RaidInfoDeleteBut")["onclick"]   = function(event) { deleteRaid(); event["stopPropagation"](); };
                            data["getID"]("RaidInfoSignupBut")["onclick"]   = function(event) { event["stopPropagation"](); };
                            data["getID"]("RaidInfoFinalizeBut")["onclick"] = function(event) { event["stopPropagation"](); };
                            data["getID"]("RaidInfoCommentSend")["onclick"] = function(event) { sendRaidComment(); event["stopPropagation"](); };
                            if(data["getVar"]("IsGroupOfficer") || data["getVar"]("IsGroupCreator") || data["getVar"]("IsGroupAdmin")) {
                                data["getID"]("NewRaidMonBut")["onclick"]   = function(event) { makeNewRaid(false); event["stopPropagation"](); };
                                data["getID"]("NewRaidWeekBut")["onclick"]  = function(event) { makeNewRaid(true); event["stopPropagation"](); };
                                data["getID"]("InviteMemberBut")["onclick"] = function(event) { openInviteWindow(2); event["stopPropagation"](); };
                            };
                        };
                    } else {
                        data["getID"]("NewRaidMonBut")["onclick"]       = function(event) { makeNewRaid(false); event["stopPropagation"](); };
                        data["getID"]("NewRaidWeekBut")["onclick"]      = function(event) { makeNewRaid(true); event["stopPropagation"](); };
                        data["getID"]("InviteGroupBut")["onclick"]      = function(event) { openInviteWindow(3); event["stopPropagation"](); };
                        data["getID"]("InviteFriendBut")["onclick"]     = function(event) { openInviteWindow(4); event["stopPropagation"](); };
                        data["getID"]("InviteMixBut")["onclick"]        = function(event) { openInviteWindow(5); event["stopPropagation"](); };
                        data["getID"]("RaidInfoUpdateBut")["onclick"]   = function(event) { changeRaid(this["checked"]); event["stopPropagation"](); };
                        data["getID"]("RaidInfoUpdateSave")["onclick"]  = function(event) { saveRaidChanges(); event["stopPropagation"](); };
                        data["getID"]("RaidInfoUpdateDscrd")["onclick"] = function(event) { discardRaidChanges(); event["stopPropagation"](); };
                        data["getID"]("RaidInfoDeleteBut")["onclick"]   = function(event) { deleteRaid(); event["stopPropagation"](); };
                        data["getID"]("RaidInfoSignupBut")["onclick"]   = function(event) { event["stopPropagation"](); };
                        data["getID"]("RaidInfoFinalizeBut")["onclick"] = function(event) { event["stopPropagation"](); };
                        data["getID"]("RaidInfoCommentSend")["onclick"] = function(event) { sendRaidComment(); event["stopPropagation"](); };
                    };
                    data["getID"]("NewRaidWinCloseBut")["onclick"]  = function(event) { data["getID"]("NewRaidWindow")["style"]["display"] = "none"; event["stopPropagation"](); };
                    data["getID"]("LoadPreset")["onchange"]         = function(event) { event["stopPropagation"](); };
                    data["getID"]("GameSelect")["onchange"]         = function() { setRoles(this["value"]); setServers(this["value"]); };
                    data["getID"]("GameRole1")["onkeypress"]        = function(event) { if(!roleAmountInputCheck(this, event["which"])) { return false; }; event["stopPropagation"](); };
                    data["getID"]("GameRole1")["onkeyup"]           = function() { roleAmountSum(); };
                    data["getID"]("GameRole2")["onkeypress"]        = function(event) { if(!roleAmountInputCheck(this, event["which"])) { return false; }; event["stopPropagation"](); };
                    data["getID"]("GameRole2")["onkeyup"]           = function() { roleAmountSum(); };
                    data["getID"]("GameRole3")["onkeypress"]        = function(event) { if(!roleAmountInputCheck(this, event["which"])) { return false; }; event["stopPropagation"](); };
                    data["getID"]("GameRole3")["onkeyup"]           = function() { roleAmountSum(); };
                    data["getID"]("GameRole4")["onkeypress"]        = function(event) { if(!roleAmountInputCheck(this, event["which"])) { return false; }; event["stopPropagation"](); };
                    data["getID"]("GameRole4")["onkeyup"]           = function() { roleAmountSum(); };
                    data["getID"]("GameRole5")["onkeypress"]        = function(event) { if(!roleAmountInputCheck(this, event["which"])) { return false; }; event["stopPropagation"](); };
                    data["getID"]("GameRole5")["onkeyup"]           = function() { roleAmountSum(); };
                    data["getID"]("InviteOpenBut")["onclick"]       = function(event) { data["setVar"]("InvitationSet", 1); event["stopPropagation"](); };
                    data["getID"]("InviteCloseBut")["onclick"]      = function(event) { closeInviteWindow(); event["stopPropagation"](); };
                    data["getID"]("InviteDoneBut")["onclick"]       = function(event) { storeSelectedInvites(); event["stopPropagation"](); };
                    data["getID"]("SavePresetBut")["onclick"]       = function(event) { savePreset(); event["stopPropagation"](); };
                    data["getID"]("CreateRaidBut")["onclick"]       = function(event) { createRaid(); event["stopPropagation"](); };
                    data["getID"]("RaidInfoWinCloseBut")["onclick"] = function(event) { data["getID"]("RaidInfoWindow")["style"]["display"] = "none"; event["stopPropagation"](); };
                    data["getID"]("RaidInfoSignupTab")["onclick"]   = function(event) { showRaidInfoSignups(); event["stopPropagation"](); };
                    data["getID"]("RaidInfoStatusTab")["onclick"]   = function(event) { showRaidInfoStatus(); event["stopPropagation"](); };
                    data["getID"]("RaidInfoCommentTab")["onclick"]  = function(event) { showRaidInfoComments(); event["stopPropagation"](); };

                    $(data["getIDof"]("RSweekmonbut"))["switchy"]();
                    if(0 < window["navigator"]["userAgent"]["toLowerCase"]()["indexOf"]("firefox")) { $("#RSnewRaidStartDate")["datepicker"]({ dateFormat: "yy-mm-dd", minDate: 0 }); };
                    $(data["getIDof"]("RSnewRaidStartTime"))["timepicker"]({ timeOnly: true });
                    $(data["getIDof"]("RSnewRaidEndTime"))["timepicker"]({ timeOnly: true });

                    setToday();
                    $("*", data["getIDof"]("RaidScheduler"))["find"](":not(input):not(textarea)")["attr"]("unselectable", "on"); // Disable ability to select text on page in Internet Explorer
                    // Dropkick styling all select elements
                    $(data["getID"]("LoadPreset"))["dropkick"]({theme : "Raidscheduler"});
                    $(data["getID"]("Recurring"))["dropkick"]({theme : "Raidscheduler"});
                    $(data["getID"]("GameSelect"))["dropkick"]({theme : "Raidscheduler"});
                    $(data["getID"]("ServerSelect"))["dropkick"]({theme : "Raidscheduler"});
                    $(data["getID"]("Finalize"))["dropkick"]({theme : "Raidscheduler"});
                    $(data["getID"]("Remind"))["dropkick"]({theme : "Raidscheduler"});
                } else if(consts["SignUpPage"] === "true") {
                    data["getID"]("RaidSignUpDoneBut")["onclick"]   = function(event) { signUpRaid(); event["stopPropagation"](); };
                    $(data["getID"]("RaidSignUpRole"))["dropkick"]({theme : "Raidscheduler"});
                };
            };
//        });

        $(document)
        ["on"]("click", "#RSmoncalendar li", function(event) { setSelectedMon(this["id"]); event["stopPropagation"](); } )
        ["on"]("click", "#RSmoncalendar div.RSmonEvent", function(event) { showRaidInfo(this); event["stopPropagation"](); } )
        ["on"]("mouseenter", "#RSmoncalendar div.RSmonEvent", function(event) { showHoverRaids(this); event["stopPropagation"](); } )
        ["on"]("mouseleave", "#RSmoncalendar div.RSmonEvent", function(event) { document["onmousemove"] = null; data["getID"]("HoverPopup")["style"]["display"] = "none"; event["stopPropagation"](); } )

        ["on"]("click", "#RSweekCalDays section", function(event) { setSelectedWeek(this["id"]); event["stopPropagation"](); } )
        ["on"]("click", "#RSweekCalDays div.RSweekEvent", function(event) { showRaidInfo(this); event["stopPropagation"](); } )
        ["on"]("mouseenter", "#RSweekCalDays div.RSweekEvent", function(event) { showHoverRaids(this); event["stopPropagation"](); } )
        ["on"]("mouseleave", "#RSweekCalDays div.RSweekEvent", function(event) { document["onmousemove"] = null; data["getID"]("HoverPopup")["style"]["display"] = "none"; event["stopPropagation"](); } )
        ["on"]("mouseenter", "#RSweekCalDays span.scrolldownraids", function(event) { scrollDownRaids(this); event["stopPropagation"](); } )
        ["on"]("mouseleave", "#RSweekCalDays span.scrolldownraids", function(event) { StopTimer(); event["stopPropagation"](); } )
        ["on"]("mouseenter", "#RSweekCalDays span.scrollupraids", function(event) { scrollUpRaids(this); event["stopPropagation"](); } )
        ["on"]("mouseleave", "#RSweekCalDays span.scrollupraids", function(event) { StopTimer(); event["stopPropagation"](); } )

        ["on"]("mouseenter", "#RSnewRaidInviteList li.RSinviteListItem", function(event) { showInviteeInfo(this, true); event["stopPropagation"](); } )
        ["on"]("mouseleave", "#RSnewRaidInviteList li.RSinviteListItem", function(event) { document["onmousemove"] = null; data["getID"]("HoverPlayer")["style"]["display"] = "none"; event["stopPropagation"](); } )
        ["on"]("click", "#RSnewRaidInviteList li.RSinviteListTitle", function(event) { inviteListSelectAll(this); event["stopPropagation"](); } )
        ["on"]("mouseenter", "#RSnewRaidInviteList li.RSinviteListTitle", function(event) { showInviteeInfo(this, false); event["stopPropagation"](); } )
        ["on"]("mouseleave", "#RSnewRaidInviteList li.RSinviteListTitle", function(event) { document["onmousemove"] = null; data["getID"]("HoverPlayer")["style"]["display"] = "none"; event["stopPropagation"](); } );

    }(window, document, $));
};

if($("#RSsignupPage")["length"]) {
    $(document)["on"]("click", "a.decline_raidsignup", function(event) {
        event["stopPropagation"]();
        var raidID = parseInt(this["getAttribute"]("data-idnum"), 10), Locat = window["location"];
        $["post"]("raidscheduler/decline/", { RaidID : raidID })
        ["done"](function(result) {
            if((result !== null) && (result !== consts["undefined"]) && (result !== "")) { alert(result); }
            else { Locat["href"] = site_url + "events/raidscheduler"; };
            return true;
        })["fail"]( function(data) { alert("ERROR : " + data); });
        return true;
    });
};
});