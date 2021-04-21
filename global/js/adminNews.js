function resetPlatforms(tmpPlatformID, platformText) {
    var platformID = document.getElementById(tmpPlatformID), opt = document.createElement("option");
    opt.value = 0;
    opt.innerHTML = platformText;
    platformID.innerHTML = '';
    platformID.appendChild(opt);
    $(platformID).dropkick("refresh");
}

function ajaxCall(gameID, tmpPlatformID, platformText) {
    $.ajax({                                      
        url: site_url + 'news/ajaxupdateplatforms/' + gameID, //the script to call to get data, you can insert url arguments here to pass to api.php, for example "id=5&parent=6"
        dataType: 'json',             //data format      
        success: function(data) {     //on recieve of reply
            if((data !== null) && (data !== "") && (data !== consts.undefined)) {
                var platformIDtxt = (tmpPlatformID !== consts.undefined) ? tmpPlatformID : null, platformID = document.getElementById(platformIDtxt), object = "", input = data.platforms, opt = document.createElement("option");
                opt.value = 0;
                opt.innerHTML = (platformText !== consts.undefined) ? platformText : "All platforms";
                platformID.innerHTML = '';
                platformID.appendChild(opt);
                for(var j = 0, jEnd = input.length; j < jEnd; ++j) {
                    object = input[j].SnPlatforms;
                    opt = document.createElement("option");
                    opt.value = object.ID_PLATFORM;
                    opt.innerHTML = object.PlatformName;
                    platformID.appendChild(opt);
                };
                $(platformID).dropkick("refresh");
            };
        },
        error: function(data) { alert("Error encountered! " + data); }
    });
};

function changeCategory(selectID, tmpChildID, itemlist, tmpPlatformID, tmpPlatformText) {
    var platformID = (tmpPlatformID !== consts.undefined) ? tmpPlatformID : null, childID = document.getElementById(tmpChildID), selIdVal = document.getElementById(selectID).value, owners = itemlist;

    childID.innerHTML = '';
    for(var j = 0, jEnd = owners.length; j < jEnd; ++j) {
        if(owners[j].TypeID == selIdVal) {
            var opt = document.createElement("option");
            opt.value = owners[j].OwnerID;
            opt.innerHTML = owners[j].Name;
            childID.appendChild(opt);
        };
    };
    if(platformID !== null) { resetPlatforms(platformID, (tmpPlatformText !== consts.undefined) ? tmpPlatformText : "All platforms"); };
    $(childID).dropkick("refresh");
};

function changeTypeCategory(tmpParentID, tmpChildID, tmpTypes, tmpItems, platformID, platformText) {
    var opt = "", types = tmpTypes, parentID = document.getElementById(tmpParentID), childID = document.getElementById(tmpChildID), items = tmpItems;

//     POPULATE TYPE LIST //
    parentID.innerHTML = '';
    for(var i = 0, iEnd = types.length; i < iEnd; ++i) {
        opt = document.createElement("option");
        opt.value = types[i].TypeID;
        opt.innerHTML = types[i].Name;
        parentID.appendChild(opt);
    };
    $(parentID).dropkick("refresh");

    // POPULATE OWNER LIST //
    childID.innerHTML = '';
    for(var j = 0, jEnd = items.length; j < jEnd; ++j) {
        opt = document.createElement("option");
        opt.value = items[j].OwnerID;
        opt.innerHTML = items[j].Name;
        childID.appendChild(opt);
    };
    if(platformID !== null) { resetPlatforms(platformID, platformText); };
    $(childID).dropkick("refresh");
};