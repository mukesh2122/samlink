var selectedTab = '', deleteElement = null, post_type = '', selectedTabUrl = '';

function urlencode(str) {
    str = (str + '').toString().replace(/\//g, ' ');
    return encodeURIComponent(str).
            replace(/!/g, '%21').
            //                                replace(/'/g, '%27').
            replace(/\(/g, '%28').
            replace(/\)/g, '%29').
            replace(/\*/g, '%2A').
            replace(/%20/g, '+');
}
;


function scaleImage(srcwidth, srcheight, targetwidth, targetheight, fLetterBox) {
    var result = {
        width: 0,
        height: 0,
        fScaleToTargetWidth: true
    };
    if ((srcwidth <= 0) || (srcheight <= 0) || (targetwidth <= 0) || (targetheight <= 0)) {
        return result;
    }
    ;
    // scale to the target width
    var scaleX1 = targetwidth, scaleY1 = (srcheight * targetwidth) / srcwidth;
    // scale to the target height
    var scaleX2 = (srcwidth * targetheight) / srcheight, scaleY2 = targetheight;
    // now figure out which one we should use
    var fScaleOnWidth = (scaleX2 > targetwidth);
    if (fScaleOnWidth) {
        fScaleOnWidth = fLetterBox;
    }
    else {
        fScaleOnWidth = !fLetterBox;
    }
    ;
    if (fScaleOnWidth) {
        result.width = Math.floor(scaleX1);
        result.height = Math.floor(scaleY1);
        result.fScaleToTargetWidth = true;
    } else {
        result.width = Math.floor(scaleX2);
        result.height = Math.floor(scaleY2);
        result.fScaleToTargetWidth = false;
    }
    ;
    result.targetleft = Math.floor((targetwidth - result.width) / 2);
    result.targettop = Math.floor((targetheight - result.height) / 2);
    return result;
}
;

function loadHelpBubbles() {
    if ($('.F_helpBubble').length) {
        $('.F_helpBubble').each(function() {
            var $this = $(this);
            $this.CreateBubblePopup({
                width: 200,
                innerHtml: $this.attr('rel'),
                themeName: 'grey',
                themePath: site_url + 'global/js/images/jquerybubblepopup-theme'
            });
        });
    }
    ;
}
;

function imageLoad(evt) {
    var img = evt.currentTarget;
    // what's the size of this image and it's parent
    var w = $(img).width(), h = $(img).height(), tw = $(img).parent().width(), th = $(img).parent().height();
    // compute the new size and offsets
    var result = scaleImage(w, h, tw, th, false);
    // adjust the image coordinates and size
    img.width = result.width;
    img.height = result.height;
    $(img).css("left", result.targetleft);
    $(img).css("top", result.targettop);
}
;

function imageLoad1(evt) {
    var img = evt.currentTarget;
    // what's the size of this image and it's parent
    var w = $(img).width(), h = $(img).height(), tw = $(img).parent().width(), th = $(img).parent().height();
    // compute the new size and offsets
    var result = scaleImage(w, h, tw, th, true);
    // adjust the image coordinates and size
    img.width = result.width;
    img.height = result.height;
    $(img).css("left", result.targetleft);
    if (img.height < th) {
        $(img).css("top", 0);
        $(img).parent().css("height", img.height + 'px');
    } else {
        $(img).css("top", result.targettop);
    }
    ;
}
;

function messageInit(ids, names) {
    $('.ta').elastic().trigger('update');
    if (ids === '' && names === '') {
        $("#nogetandet").tokenInput(site_url + 'players/ajaxfindfriend', {
            //searchDelay: 2000,
            minChars: 2,
            tokenDelimiter: "|",
            theme: "gametek",
            deleteText: "",
            resultsFormatter: function(item) {
                return "<li class='clearfix'>" + "<div class='fl w30'><img src='" + item.img + "' height='25px' width='25px' /></div>" + "<div class='fl pt3'><div class='full_name'>" + item.name + "</div></div></li>";
            }
        });
    } else {
        $("#tags").tokenInput(site_url + 'players/ajaxfindfriend', {
            //searchDelay: 2000,
            minChars: 2,
            tokenDelimiter: "|",
            theme: "gametek",
            deleteText: "",
            resultsFormatter: function(item) {
                return "<li class='clearfix'>" + "<div class='fl w30'><img src='" + item.img + "' height='25px' width='25px' /></div>" + "<div class='fl pt3'><div class='full_name'>" + item.name + "</div></div></li>";
            },
            prePopulate: [{
                    id: ids,
                    name: names
                }]
        });
    }
    ;
}
;

function messageInitForvard() {

    $('.ta').elastic().trigger('update');
    $("#tags").tokenInput(site_url + 'players/ajaxfindfriend', {
        minChars: 2,
        tokenDelimiter: "|",
        theme: "gametek",
        deleteText: "",
        resultsFormatter: function(item) {
            return "<li class='clearfix'>" + "<div class='fl w30'><img src='" + item.img + "' height='25px' width='25px' /></div>" + "<div class='fl pt3'><div class='full_name'>" + item.name + "</div></div></li>";
        }
    });
}
;

function loadIframe() {
    $('a[rel=iframe]').fancybox({
        'closeClick': false,
        'openEffect': 'elastic',
        'closeEffect': 'elastic',
        'openSpeed': 600,
        'closeSpeed': 200,
        'loop': true,
        'arrows': false,
        'type': 'ajax',
        'helpers': {
            'title': null,
            'overlay': {
                'showEarly': true,
                'closeClick': false,
                'css': {
                    'background': 'rgba(0, 0, 0, 0.58)'
                }
            }
        }
    });
    $('a.video_type[rel=iframe]').fancybox({
        'closeClick': false,
        'openEffect': 'elastic',
        'closeEffect': 'elastic',
        'openSpeed': 600,
        'closeSpeed': 200,
        'loop': true,
        'arrows': false,
        'type': 'ajax',
        'helpers': {
            'title': null,
            'overlay': {
                'showEarly': true,
                'closeClick': false,
                'css': {
                    'background': 'rgba(0, 0, 0, 0.58)'
                }
            }
        }
    });
    $('a.img_type[rel=iframe]').fancybox({
        'closeClick': false,
        'openEffect': 'elastic',
        'closeEffect': 'elastic',
        'openSpeed': 600,
        'closeSpeed': 200,
        'loop': true,
        'arrows': false,
        'type': 'image',
        'helpers': {
            'title': null,
            'overlay': {
                'showEarly': true,
                'closeClick': false,
                'css': {
                    'background': 'rgba(0, 0, 0, 0.58)'
                }
            }
        }
    });
}
;


function loadFancybox() {
    loadIframe();

    $('a[rel=photo_tag]').fancybox({
        'closeClick': false,
        'openEffect': 'elastic',
        'closeEffect': 'elastic',
        'openSpeed': 600,
        'closeSpeed': 200,
        'loop': true,
        'arrows': false,
        'scrolling': 'no',
        'keys': null,
        'type': 'ajax',
        'helpers': {
            'title': null,
            'overlay': {
                'showEarly': true,
                'closeClick': false,
                'css': {
                    'background': 'rgba(0, 0, 0, 0.58)'
                }
            }
        }
    });

    $('a[rel=fancy_img], a.article_gallery').fancybox({
        'closeClick': false,
        'openEffect': 'elastic',
        'closeEffect': 'elastic',
        'openSpeed': 600,
        'closeSpeed': 200,
        'loop': true,
        'arrows': false,
//           'type'          : 'ajax',
        'helpers': {
            'title': null,
            'overlay': {
                'showEarly': true,
                'closeClick': false,
                'css': {
                    'background': 'rgba(0, 0, 0, 0.58)'
                }
            }
        }
    });

    $('.ta').elastic().trigger('update');

    $('a.changeemail').fancybox({
        'closeClick': false,
        'openEffect': 'elastic',
        'closeEffect': 'elastic',
        'openSpeed': 600,
        'closeSpeed': 200,
        'arrows': false,
        'type': 'ajax',
        'helpers': {
            'title': null,
            'overlay': {
                'showEarly': true,
                'closeClick': false,
                'css': {
                    'background': 'rgba(0, 0, 0, 0.58)'
                }
            }
        },
        'afterLoad': function() {
            //messageInit($(this).attr('orig').attr('rel'), $(this).attr('title'));
        }
    });

    $('a.reply_message').fancybox({
        'closeClick': false,
        'openEffect': 'elastic',
        'closeEffect': 'elastic',
        'openSpeed': 600,
        'closeSpeed': 200,
        'arrows': false,
        'type': 'ajax',
        'helpers': {
            'title': null,
            'overlay': {
                'showEarly': true,
                'closeClick': false,
                'css': {
                    'background': 'rgba(0, 0, 0, 0.58)'
                }
            }
        },
        'afterShow': function() {
            messageInit(this.element.context.rel, $(this).attr('title'));
        }
    });

    $('a.forward_message').fancybox({
        'closeClick': false,
        'openEffect': 'elastic',
        'closeEffect': 'elastic',
        'openSpeed': 600,
        'closeSpeed': 200,
        'arrows': false,
        'type': 'ajax',
        'helpers': {
            'title': null,
            'overlay': {
                'showEarly': true,
                'closeClick': false,
                'css': {
                    'background': 'rgba(0, 0, 0, 0.58)'
                }
            }
        },
        'afterLoad': function() {
            messageInitForvard();
        }
    });


    $('a.create_new_message').fancybox({
        'closeClick': false,
        'openEffect': 'elastic',
        'closeEffect': 'elastic',
        'openSpeed': 600,
        'closeSpeed': 200,
        'arrows': false,
        'type': 'ajax',
        'href': site_url + 'players/ajaxgetsendmessage',
        'helpers': {
            'title': null,
            'overlay': {
                'showEarly': true,
                'closeClick': false,
                'css': {
                    'background': 'rgba(0, 0, 0, 0.58)'
                }
            }
        },
        'afterLoad': function() {
            messageInit('', '');
        }
    });
}
;

function createMapUploader(ids, text, url) {
    $(document).ready(function() {
        var uploader = new qq.FileUploader({
            debug: true,
            minSizeLimit: 0,
            sizeLimit: 0,
            element: document.getElementById(ids),
            action: site_url + url,
            multiple: false,
            allowedExtensions: [],
            onSubmit: function(id, fileName) {
                //            $('.personal_profile_short').addClass('dn');
                //            $("#img_load").removeClass('dn').html('');
            },
            onComplete: function(id, fileName, responseJSON) {
                if (responseJSON.error) {
                    return false;
                }
                ;
                if (responseJSON.mapid) {
                    $('#dbMap').append("<option value='" + responseJSON.mapid + "'>" + responseJSON.mapname + "</option>");
                    $('#mapList').append("<option value='" + responseJSON.mapid + "'>" + responseJSON.mapname + "</option>");
                    updateMappool();
                }
                ;
            }
        });
    });
}
;

function createUploader(ids, text, url, crop) {
    var uploader = new qq.FileUploader({
        debug: false,
        sizeLimit: 2097152,
        textUpload: text,
        element: document.getElementById(ids),
        listElement: document.getElementById('img_load'),
        action: site_url + url,
        multiple: false,
        allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
        acceptTypes: 'image/*',
        onSubmit: function(id, fileName) {

//            $('.personal_profile_short').addClass('dn');
//            $("#img_load").removeClass('dn').html('');
        },
        onComplete: function(id, fileName, responseJSON) {
            if (responseJSON.error) {
                return false;
            }
            ;
            if (crop) {
                if (responseJSON.img) {
                    if ($('#picture_crop_' + crop).length) {
                        $('#picture_crop_' + crop + ' img').attr('src', responseJSON.img);
                    }
                    ;
                }
                ;
            }
            else {
                if (responseJSON.img) {
                    if (!responseJSON.changeProfilePic == 0) {
                        $('.personal_profile_link img').attr('src', responseJSON.img);
                    }
                    ;
                    if ($('.profile_foto_edit').length) {
                        $('.profile_foto_edit img').attr('src', responseJSON.img);
                    }
                    ;
                }
                ;
                if (responseJSON.img100x100) {
                    if ($('.F_profileImage100x100').length) {
                        $('.F_profileImage100x100 img').attr('src', responseJSON.img100x100);
                    }
                    ;
                }
                ;
                if (responseJSON.fileName) {
                    if (!responseJSON.customID == 0) {
                        $('#' + responseJSON.customID).val(responseJSON.fileName);
                    }
                    else {
                        $('#imageName').val(responseJSON.fileName);
                    }
                }
                ;
            }
            ;
//            $('.personal_profile_short').removeClass('dn');
//            $("#img_load").addClass('dn');
            if (crop) {
                var aspectRatio = 1 / 1;
                switch (crop) {
                    case'portrait':
                        aspectRatio = 2 / 3;
                        break;
                    case'landscape':
                        aspectRatio = 4 / 3;
                        break;
                    case'square':
                        aspectRatio = 1 / 1;
                        break;
                    case'banner':
                        aspectRatio = 3 / 1;
                        break;
                }
                ;
                var cropLength = Array;
                $("body").addClass('index_events_create');
                $("body").append('<div id="openWindow_' + ids + '"></div>');
                $('#openWindow_' + ids).html('<img id="' + ids + '_load" />');
                $('#' + ids + '_load').attr('src', responseJSON.img800x600).load(function() {
                    $('#openWindow_' + ids).dialog({
                        title: 'Select part of image',
                        resizable: false,
                        modal: true,
                        width: 825,
                        autoOpen: true,
                        close: function() {
                            $(this).dialog('destroy');
                            $(this).remove();
                            location.reload();
                        },
                        buttons: {
                            Crop: function() {
                                $.ajax({
                                    url: site_url + url,
                                    type: 'POST',
                                    dataType: 'json',
                                    data: cropLength
                                }).done(function(responseJSON) {
                                    if (responseJSON.img) {
                                        if ($('#picture_crop_' + crop).length) {
                                            var now = new Date();
                                            $('#picture_crop_' + crop + ' img').attr('src', responseJSON.img + '?' + now.getTime());
                                            location.reload();
                                        }
                                        ;
                                    }
                                    ;
                                });
                                $(this).dialog('destroy');
                                $(this).remove();
                            }
                        }
                    }).ready(function() {
                        var minX = 300;
                        var minY = 300;
                        if (responseJSON.minSize) {
                            minX = responseJSON.minSize[0];
                            minY = responseJSON.minSize[1];
                        }
                        cropLength = {x: 0, y: 0, x2: minX, y2: minY, w: minX, h: minY};   // Preset if never selected
                        $('#' + ids + '_load').Jcrop({
                            aspectRatio: aspectRatio,
                            bgColor: 'black',
                            bgOpacity: .6,
                            minSize: [minX, minY],
                            setSelect: [0, 0, minX, minY],
                            onSelect: function updateCoords(c) {
                                cropLength = c;
                            }
                        });
                    });
                });
            }
            ;
        }
    });
}
;

function createMultiUploader(ids, url) {
    $(document).ready(function() {
        $('#' + ids).uploadify({
            'swf': site_url + 'global/js/uploadify3.2.1/uploadify.swf',
            'uploader': url,
            'cancelImg': site_url + 'global/js/uploadify3.2.1/cancel.png',
            'auto': false,
            'multi': true,
            'fileExt': '*.jpg;*.gif;*.png',
            'fileDesc': 'Image Files (.JPG, .GIF, .PNG)',
            'queueID': 'custom-queue',
            'queueSizeLimit': 30,
            'simUploadLimit': 1,
            'sizeLimit': 2097152,
            'removeCompleted': false,
            'formData': {'tab': 'video'},
            'onSelect': function(event, data) {
                //                alert(data.filesSelected + ' files have been added to the queue.');
            },
            'onUploadComplete': function(event, data, fileObj, errorObj) {
                //                console.log(data);
            },
            'onQueueComplete': function(event, data, fileObj, errorObj) {
                $.fancybox.close();
                location.reload();
            },
            'onUploadError': function(event, ID, fileObj, errorObj) {
                //                alert(errorObj.type + ' Error: ' + errorObj.info);
            }
        });
    });
}
;


function loadGroup() {
    $("#tags").tokenInput(site_url + 'group/ajaxfindgroup/' + $('#group_id').val(), {
        searchDelay: 1000,
        minChars: 2,
        tokenDelimiter: "|",
        theme: "gametek",
        deleteText: "",
        resultsFormatter: function(item) {
            return "<li>" + "<img src='" + item.img + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + "</div></div></li>";
        },
        beforeAdd: function(item) {
            $("#tags").tokenInput("clear");
        }
    });

    $("#player_tags").tokenInput(site_url + 'players/ajaxfindfriend', {
        searchDelay: 1000,
        minChars: 2,
        tokenDelimiter: "|",
        theme: "gametek",
        deleteText: "",
        resultsFormatter: function(item) {
            return "<li>" + "<img src='" + item.img + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + "</div></div></li>";
        }
    });

    $("#game_tags").tokenInput(site_url + 'games/ajaxfindgame', {
        searchDelay: 1000,
        minChars: 2,
        tokenDelimiter: "|",
        theme: "gametek",
        deleteText: "",
        resultsFormatter: function(item) {
            return "<li>" + "<img src='" + item.img + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + "</div></div></li>";
        },
        beforeAdd: function(item) {
            $("#game_tags").tokenInput("clear");
            $('#token-input-game_tags').removeClass('error');
        }
    });

    $("#company_tags").tokenInput(site_url + 'companies/ajaxfindcompany', {
        searchDelay: 1000,
        minChars: 2,
        tokenDelimiter: "|",
        theme: "gametek",
        deleteText: "",
        resultsFormatter: function(item) {
            return "<li>" + "<img src='" + item.img + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + "</div></div></li>";
        },
        beforeAdd: function(item) {
            $("#company_tags").tokenInput("clear");
            $('#token-input-company_tags').removeClass('error');
        }
    });
}
;

function showOverlay() {
    var ovr = $('<div class="blockOverlay" style="background-color: #000;cursor:pointer;z-index:50;display:none;border:none;margin:0;padding:0;width:100%;height:100%;top:0;left:0;position:fixed;"></div>');
    ovr.appendTo($('body'));
    ovr.show();
}
;


function hideOverlay() {
    var ovr = $('.blockOverlay');
    ovr.hide().remove();
    $('#link_forgot').HideAllBubblePopups();
    $('#link_forgot_page').HideAllBubblePopups();
    if (deleteElement !== null) {
        deleteElement.HideAllBubblePopups();
    }
    ;
}
;

function promptDelete(method, message, action) {
    if (action === 1) {
        hideOverlay();
        return false;
    } else if (action === 2) {
        hideOverlay();
        return false;
    }
    ;
    deleteElement.CreateBubblePopup({
        manageMouseEvents: false,
        position: 'bottom',
        align: 'center',
        themeName: 'grey',
        themePath: site_url + 'global/js/images/jquerybubblepopup-theme'
    });
    showOverlay();
    if (message === consts.undefined || message === "" || message === null) {
        message = lang.delete_category;
    }
    ;
    var actionHTML = "<div class='db mt10'>" +
            "<a href='javascript:void(0);' class='link_light_grey prompt_yes_no fl mr10' onclick='promptDelete(" + method + ",\"" + message + "\", 1);'><span><span>" + lang.button_yes + "</span></span></a>" +
            "<a href='javascript:void(0);' class='link_light_grey prompt_yes_no fl' onclick='promptDelete(\"\",\"" + message + "\", 2);'><span><span>" + lang.button_no + "</span></span></a></div>";
    deleteElement.SetBubblePopupInnerHtml(message + actionHTML, true);
    deleteElement.ShowBubblePopup();
}
;

function promptDeleteNote(method, message, action) {
    if (action === 1) {
        hideOverlay();
        return false;
    } else if (action === 2) {
        hideOverlay();
        return false;
    }
    ;
    deleteElement.CreateBubblePopup({
        manageMouseEvents: false,
        position: 'bottom',
        align: 'center',
        themeName: 'grey',
        themePath: site_url + 'global/js/images/jquerybubblepopup-theme'
    });
    showOverlay();
    if (message === consts.undefined || message === "" || message === null) {
        message = lang.delete_category;
    }
    ;
    var actionHTML = "<div class='db mt10'>" +
            "<div class='clearfix mb10'><input id='prompt_text' type='text' value='' placeholder='" + lang.input_reason + "...' class='fl w260' autofocus></div>" +
            "<a href='javascript:void(0);' class='link_light_grey prompt_yes_no fl mr10' onclick='promptDeleteNote(" + method + ",\"" + message + "\", 1);'><span><span>" + lang.button_yes + "</span></span></a>" +
            "<a href='javascript:void(0);' class='link_light_grey prompt_yes_no fl' onclick='promptDeleteNote(\"\",\"" + message + "\", 2);'><span><span>" + lang.button_no + "</span></span></a></div>";
    deleteElement.SetBubblePopupInnerHtml(message + actionHTML, true);
    deleteElement.ShowBubblePopup();
}
;

function unpublishNewsItem(id, lang, note) {
    $.post(site_url + 'news/unpublish/' + id + '/' + lang, {
        text: note
    }, function(data) {
        if (data.result === true) {
            location.reload();
        }
        ;
    });
}
;
function addMemberRole(id, role) {
    var owner = $('#ownerType').val(), owner_id = $('#ownerID').val();
    $.post(site_url + 'ajaxaddmemberrole', {
        'player_id': id,
        'role': role,
        'owner_id': owner_id,
        'ownerType': owner
    }, function(data) {
        if ((data !== consts.undefined) && (data !== "") && (data !== null)) {
            if (data.result === true) {
                location.reload();
            }
            ;
        }
        ;
    });
}
;

function removeMemberRole(id, role) {
    var owner = $('#ownerType').val(), owner_id = $('#ownerID').val();
    $.post(site_url + 'ajaxremovememberrole', {
        'player_id': id,
        'role': role,
        'owner_id': owner_id,
        'ownerType': owner
    }, function(data) {
        if (data.result === true) {
            location.reload();
        }
        ;
    });
}
;

function deleteFriend(fid) {
    $.post(site_url + 'players/ajaxdeletefriend', {'fid': fid}, function(data) {
        if (data.result === true) {
            $(deleteElement).closest('.itemPost').fadeOut('slow', function() {
                $(this).remove();
            });
            var friends_num = parseInt($('.friend_count_header').html(), 10);
            friends_num -= 1;
            $('.friend_count_header').html(friends_num);
        }
        ;
    });
}
;

function deletePost(pid, refresh) {
    $.post(site_url + 'ajaxdeletepost', {'pid': pid}, function(data) {
        if (data.result === true) {
            $('.post_wall_' + pid).fadeOut('slow', function() {
                $('.post_wall_' + pid).remove();
                $.fancybox.close();
            });
            if (selectedTab === 'video' || selectedTab === 'photo') {
                $.post(site_url + 'players/ajaxgetposts', {
                    'type': selectedTab,
                    'offset': 0
                }, function(data) {
                    $("#wall_container").html(data.content);
                    loadFancybox();
                    manageShowMorePosts(data.total);
                });
            }
            ;
            if (refresh === 1) {
                window.location.href = window.location.href;
            }
            ;
        }
        ;
    });
}
;

function deleteCompanyDownload(id) {
    $.post(site_url + 'company/deletedownload', {
        'download_id': id,
        'company_id': $('#company_id').val()
    }, function(data) {
        if (data.result === true) {
            $obj.closest('.download_cont').fadeOut('fast');
        }
        ;
    });
}
;

function deleteCartItem(id) {
    $.post(site_url + 'shop/removefromcart', {'id': id}, function(data) {
        if (data.result === true) {
            if ($('.shop_cart').length) {
                $('table.shop_items').remove();
                $('.shop_cart').prepend(data.contentFull).fadeIn();
            }
            ;
        } else {
            $('.shop_cart').remove();
        }
        ;
        $('.F_cartBrief').hide().html(data.contentBrief).fadeIn();
    });
}
;

function deleteGameDownload(id) {
    $.post(site_url + 'game/deletedownload', {
        'download_id': id,
        'game_id': $('#game_id').val()
    }, function(data) {
        if (data.result === true) {
            $obj.closest('.download_cont').fadeOut('fast');
        }
        ;
    });
}
;

function leaveGroup(id) {
    $.post(site_url + 'group/' + id + '/leave', {}, function(data) {
        if (data.result === true) {
            $obj.closest('.itemPost').fadeOut('fast');
        }
        ;
    });
}
;

function deleteGroup(id) {
    $.post(site_url + 'group/' + id + '/delete', {}, function(data) {
        if (data.result === true) {
            $obj.closest('.itemPost').fadeOut('fast');
        }
        ;
    });
}
;

function deleteGroupAlliance(id) {
    $.post(site_url + 'group/' + $('#group_id').val() + '/admin/removealliance', {'alliance_id': id}, function(data) {
        if (data.result === true) {
            $obj.closest('.itemPost').fadeOut('fast');
        }
        ;
    });
}
;

function deleteGroupMember(id) {
    $.post(site_url + 'group/ajaxdeletemember', {
        'member_id': id,
        'group_id': $('#group_id').val()
    }, function(data) {
        if (data.result === true) {
            $obj.closest('.itemPost').fadeOut('fast');
        }
        ;
    });
}
;

function deleteGroupApplication(id) {
    $.post(site_url + 'group/ajaxdeleteaplication', {
        'group_id': id
    }, function(data) {
        if (data.result === true) {
            //$obj.closest('.itemPost').fadeOut('fast');
        }
        ;
    });
}
;

function deleteGroupDownload(id) {
    $.post(site_url + 'group/deletedownload', {
        'download_id': id,
        'group_id': $('#group_id').val()
    }, function(data) {
        if (data.result === true) {
            $obj.closest('.download_cont').fadeOut('fast');
        }
        ;
    });
}
;

function deleteCompanyDownloadTab(id) {
    $.post(site_url + 'company/' + $('#company_id').val() + '/admin/deletedownloadtab', {'tab_id': id}, function(data) {
        if (data.result === true) {
            location.reload();
        }
        ;
    });
}
;

function deleteGameDownloadTab(id) {
    $.post(site_url + 'game/' + $('#game_id').val() + '/admin/deletedownloadtab', {'tab_id': id}, function(data) {
        if (data.result === true) {
            location.reload();
        }
        ;
    });
}
;

function deleteGroupMedia(id) {
    $.post(site_url + 'group/' + $('#group_id').val() + '/admin/deletemedia', {'media_id': id}, function(data) {
        if (data.result === true) {
            location.reload();
        }
        ;
    });
}
;

function deleteGameMedia(id) {
    $.post(site_url + 'game/' + $('#game_id').val() + '/admin/deletemedia', {'media_id': id}, function(data) {
        if (data.result === true) {
            location.reload();
        }
        ;
    });
}
;

function deleteCompanyMedia(id) {
    $.post(site_url + 'company/' + $('#company_id').val() + '/admin/deletemedia', {'media_id': id}, function(data) {
        if (data.result === true) {
            location.reload();
        }
        ;
    });
}
;

function deleteNewsItem(id) {
    $.post(site_url + 'news/delete/' + id, {}, function(data) {
        if (data.result === true) {
            location.reload();
        }
        ;
    });
}
;

function deleteReply(pid, rid) {
    $.post(site_url + 'ajaxdeletereply', {
        'pid': pid,
        'rid': rid
    }, function(data) {
        if (data.result === true) {
            $('.reply_' + pid + '_' + rid).fadeOut('slow', function() {
                $('.reply_' + pid + '_' + rid).remove();
            });
            $('.comments_num_' + pid).html(data.total);
            if (data.total === 0) {
                $('.comments_block_' + pid).html('').parent().removeClass('comments_block_active').addClass('dn');
                toggleReplyShow('show', pid);
            }
            ;
        }
        ;
    });
}
;

function deleteNewsReply(pid, rid) {
    $.post(site_url + 'news/ajaxdeletereply', {
        'pid': pid,
        'rid': rid
    }, function(data) {
        if (data.result === true) {
            $('.reply_' + pid + '_' + rid).fadeOut('slow', function() {
                $('.reply_' + pid + '_' + rid).remove();
            });
            $('.comments_num_' + pid).html(data.total);
            if (data.total === 0) {
                $('.comments_block_' + pid).html('').parent().removeClass('comments_block_active').addClass('dn');
                toggleReplyShow('show', pid);
            }
            ;
        }
        ;
    });
}
;

function deleteMessageItem(pid, type) {
    $.post(site_url + 'players/ajaxdeletemessageitem', {
        'pid': pid,
        'type': type
    }, function(data) {
        if (data.result === true) {
            $('.post_message_' + pid).fadeOut('fast');
        }
        ;
    });
}
;

function deleteMessageSelectedItems(type) {
    var ids = {};
    $.each($('.cp:checked'), function(i, data) {
        ids[i] = $(this).val();
    });
    $.post(site_url + 'players/ajaxdeletemessageitem', {
        'pid': ids,
        'type': type
    }, function(data) {
        if (data.result === true) {
            $.each(ids, function(i, data) {
                $('.post_message_' + data).fadeOut('fast');
            });
        }
        ;
    });
}
;

function deleteAllMessages(type) {
    $.post(site_url + 'players/ajaxdeleteallmessages', {'type': type}, function(data) {
        if (data.result === true) {
            $("#wall_container").html(data.content);
        }
        ;
    });
}
;

function toggleReplyShow(type, pid) {
    if (type === 'show') {
        $('.vc_' + pid).removeClass('dn');
        $('.hc_' + pid).addClass('dn');
    } else {
        $('.vc_' + pid).addClass('dn');
        $('.hc_' + pid).removeClass('dn');
    }
    ;
}
;

function loadCheckboxes() {

    $('input').checkBox();
    //select/deselect checkboxes
    $('#select_all').click(function() {
        $('.post_message input[type=checkbox]').checkBox('changeCheckStatus', true);
        $(this).addClass('dn');
        $('#deselect_all').removeClass('dn');
        return false;
    });
    $('#deselect_all').click(function() {
        $('.post_message input[type=checkbox]').checkBox('changeCheckStatus', false);
        $(this).addClass('dn');
        $('#select_all').removeClass('dn');
        return false;
    });
}
;

function resetShowMorePosts() {
    $('a.show_more_posts').attr('rel', 0);
}
;


function manageShowMorePosts(totalNum) {
    var $post = $('a.show_more_posts, a.show_more_friends'), offset = parseInt(consts.post_limit, 10), sum = parseInt($post.attr('rel'), 10);
    if (selectedTab === 'photo') {
        offset = parseInt(consts.photo_limit, 10);
    }
    else if (selectedTab === 'video') {
        offset = parseInt(consts.video_limit, 10);
    }
    else if (selectedTab === 'ajaxgetmessages') {
        offset = parseInt(consts.messages_limit, 10);
    }
    else if (selectedTab === 'ajaxgetmessagessent') {
        offset = parseInt(consts.messages_limit, 10);
    }
    else if (selectedTab === 'ajaxgetnotifications') {
        offset = parseInt(consts.notification_limit, 10);
    }
    else if ($post.hasClass('show_more_friends')) {
        offset = parseInt(consts.players_limit, 10);
    }
    ;
    sum += offset;
    if (sum >= totalNum) {
        $post.addClass('dn');
    }
    else if (totalNum > consts.post_limit) {
        $post.removeClass('dn');
    }
    ;
    $post.attr('rel', sum);
}
;

function translateShowMore(str) {
    $('.show_more_posts .translation').html(str);
}
;


//loads jqTransform dropdowns
function loadDropdowns() {
    $(document).ready(function() {
        $('.jqtransform').jqTransform();
        $('.jqTransformSelectWrapper ul li:last a').css('background-image', 'none');
        $('.jqTransformSelectWrapper').bind('jqTransformDropdown', function(e) {
        });
        $('.jqselect').bind('change', function(e) { /*console.log('pokytis'); */
        });
        $('.jqselectEventCat').bind('change', function(e) {
            window.location.href = site_url + 'events/' + $(this).val();
        });
        $('.jqselectForumCat').bind('change', function(e) {
            window.location.href = site_url + 'forum/' + $(this).val();
        });
        $('#group_media_tab').bind('change', function(e) {
            if ($(this).val() === 'video') {
                $('.group_tab_video').removeClass('dn');
                $('.group_tab_images').addClass('dn');
            } else {
                $('.group_tab_video').addClass('dn');
                $('.group_tab_images').removeClass('dn');
            }
            ;
        });
        $('#company_media_tab').bind('change', function(e) {
            if ($(this).val() === 'video') {
                $('.company_tab_video').removeClass('dn');
                $('.company_tab_images').addClass('dn');
            } else {
                $('.company_tab_video').addClass('dn');
                $('.company_tab_images').removeClass('dn');
            }
            ;
        });
        $('#game_media_tab').bind('change', function(e) {
            if ($(this).val() === 'video') {
                $('.game_tab_video').removeClass('dn');
                $('.game_tab_images').addClass('dn');
            } else {
                $('.game_tab_video').addClass('dn');
                $('.game_tab_images').removeClass('dn');
            }
            ;
        });
        $('.tab_id').bind('change', function(e) {
            $('.tab_name').val($('.tab_id :selected').text());
        });
    });
}
;

function validateNews() {
    var $news_form = $(".news_validate"), id = $('input[name=newsID]').val();
    $news_form.validate({
        rules: {name: {required: true}
//			,
//			language: {
//				required:true,
//				remote: {
//					url: site_url+'players/validatemail',
//					data: {
//						email: function () {
//							return id;
//						}
//					}
//				}
//			}
        }
    });
//    var err = false;
//    if($('input[name=newsID]').val() != 0) {
//        if($('.newsType:checked').val() === 1) {
//            if($('.token-input-list-gametek').children('li').length <= 2) {
//                $('#token-input-game_tags').addClass('error');
//                err = true;
//            }
//        } else {
//            if($('.token-input-list-gametek').children('li').length <= 2) {
//                $('#token-input-company_tags').addClass('error');
//                err = true;
//            }
//        }
//    }
    if ($news_form.valid()) {
        return true;
    } else {
        return false;
    }
    ;
}
;

function submitValues(url, params) {
    var form = ['<form method="POST" action="', url, '">'];
    for (var key in params) {
        form.push('<input type="hidden" name="', key, '" value="', params[key], '"/>');
    }
    ;
    form.push('</form>');
    jQuery(form.join('')).appendTo('body')[0].submit();
}
;

//function startNewsRotator() {
//	if($( "#top_news_carousel" ).length) {
//		$('#top_news_carousel').cycle({
//			fx:     'scrollHorz',
//			timeout: 4000,
//			pager:   '#news_pager'
//		});
//		$("#top_news_carousel").mouseenter(function() { $('#top_news_carousel').cycle('pause'); })
//        .mouseleave(function() { $('#top_news_carousel').cycle('resume'); });
//	};
//};

$(document).ready(function() {
    if ($('.datepicker-new').length > 0) {
        $('.datepicker-new').datepicker({dateFormat: 'dd/mm/yy'});
    }
    ;
//	startNewsRotator();
    //loads fancybox'es with rel=iframe
    loadFancybox();
    loadDropdowns();
    if ($('.form_validate').length > 0) {
        $('.form_validate').validate();
    }
    ;
    jQuery.validator.setDefaults({
        errorPlacement: function(error, element) {
            error.appendTo(element.parent().parent());
        }
        //        errorLabelContainer: $("div.errorContainer")
    });
    jQuery.validator.addMethod("valEqTitle", function(value, element, param) {
        if (param === true) {
            if ($(element).attr('title') === value) {
                return false;
            } else {
                return true;
            }
            ;
        }
        ;
    });
    jQuery.validator.addMethod("validatePass", function(value, element, param) {
        if ($(element).attr('title') === value && $(param.el).val() === '') {
            return false;
        } else {
            return true;
        }
        ;
    });
    jQuery.validator.addMethod("validateFutureDate", function(value, element, param) {
        var spl = value.toString().split('-'), date = new Date(spl[2], spl[1] - 1, spl[0]), today = new Date();
        if (Math.floor(date.getTime() / 86400000) + 1 < Math.floor(today.getTime() / 86400000)) {
            return false;
        }
        else {
            return true;
        }
        ;
    });
    jQuery.validator.addMethod("validateEndDate", function(value, element, param) {
        var spl = value.toString().split('-'), date = new Date(spl[2], spl[1] - 1, spl[0]);
        spl = $(element).attr('rel').toString().split('-');
        var start = new Date(spl[2], spl[1] - 1, spl[0]);
        if (date.getTime() < start.getTime()) {
            return false;
        } else {
            return true;
        }
        ;
    });
    //searchbox interaction
    $("#search").focus(function() {
        if ($(this).attr('title') === $(this).val()) {
            $(this).val('');
        }
        ;
        $("#src_cont").addClass('search_input_active');
    }).blur(function() {
        if ($(this).val() === '') {
            $(this).val($(this).attr('title'));
        }
        ;
        $("#src_cont").removeClass('search_input_active');
    });
    $('body').on('focus', ".withLabel", function() {
        if ($(this).attr('title') === $(this).val()) {
            $(this).val('');
        }
        ;
    });
    $('body').on('blur', ".withLabel", function() {
        if ($(this).val() === '') {
            $(this).val($(this).attr('title'));
        }
        ;
    });
    //searchbox interaction
    $("a#src_but").mouseover(function() {
        if (!$("#src_cont").hasClass('search_input_active')) {
            $("#src_cont").addClass('search_input_active');
        }
        ;
    })
            .mouseout(function() {
                if (!$("#search").is(':focus')) {
                    $("#src_cont").removeClass('search_input_active');
                }
                ;
            });
    $('body').on('click', "a#src_but", function(e) {
        $('#top_search').submit();
    });
    $('#top_search').on('keypress', function(e) {
        e.stopPropagation();
        if (e.which === 13) {
            $('#top_search').submit();
        }
        ;
    });
    $('#top_search').on('submit', function() {
        if ($('#search').val() !== $('#search').attr('title') && $('#search').val().length >= 3) {
            $(this).attr('action', site_url + 'search/' + urlencode($('#search').val()));
            return true;
        } else {
            return false;
        }
        ;
    });
    $('#filterReferral').on('submit', function() {
        $(this).attr('action', site_url + 'referral/' + urlencode($('#affiliateFrom').val()) + '/' + urlencode($('#affiliateTo').val()));
        return true;
    });
    $('#inside_search').on('click', "a", function(e) {
        e.preventDefault();
        $('#inside_search').submit();
    });
    $('#inside_search').on('submit', function() {
        if ($('#inside_search_txt').val() !== $('#inside_search_txt').attr('title') && $('#inside_search_txt').val().length >= 3) {
            $(this).attr('action', $('#form_url').val() + '/' + urlencode($('#inside_search_txt').val()));
            return true;
        } else {
            return false;
        }
        ;
    });

//    $("#searchAdv_But").on('click', function(e) {
//        e.preventDefault();
//        var headline = document.getElementById("searchAdv_headline").value || "",
//        description = document.getElementById("searchAdv_description").value || "",
//        author = document.getElementById("searchAdv_author").value || "";
//        var searchData = {
//            'headline' : headline,
//            'description' : description,
//            'author' : author
//        };
//        console.log("her");
//        console.log(document.getElementById("searchAdv_Form").getAttributeNode("action"));
//        $.get(document.getElementById("searchAdv_Form").getAttribute("action"), searchData, function() { console.log("svar"); });
//    });
    $("#search_inputField").tokenInput(site_url + 'subPageSearch/' + site_path, {
        searchDelay: 100,
        minChars: 3,
        tokenDelimiter: "|",
        theme: "gametek",
        deleteText: "",
        placeholder: $("#search_inputField").attr('placeholder'),
        hintText: lang['search_hint'],
        noResultsText: lang['search_noresults'],
        searchingText: lang['search_searching'],
        resultsLimit: 10,
        resultsFormatter: function(item) {
            return '<li class="result"><h3>' + item.name + '</h3><h4>' + item.type + '</h4></li>';
        },
        onAdd: function(item) {
            $("#search_inputField").tokenInput("clear");
            window.location.href = item.url;
        }
    });
    $("#inside_searchForm").on("keyup", function(e) {
        e.preventDefault();
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code === 13) {
            document.getElementById("search_button_REAL").click();
        }
        ;
    });
    $('#search_button_REAL').on('click', function() {
        var searchTxt = document.getElementById('token-input-search_inputField').value;
        if (searchTxt.length > 3) {
            console.log("found txt");
            var formID = document.getElementById('inside_searchForm'), url = document.getElementById('form_url').value;
            formID.setAttribute("action", url + '/' + urlencode(searchTxt));
            formID.submit();
            return true;
        } else {
            return false;
        }
        ;
    });
    //input title to val and reverse
    $('body').on('focus', ".input_dynamic, .reg_pass, .doo-captcha-text, .input_login", function() {
        if ($(this).attr('title') === $(this).val()) {
            $(this).val('');
        }
        ;
        if ($(this).parent().parent().hasClass('errors')) {
            $(this).parent().parent().removeClass('errors');
        }
        ;
    }).on('blur', ".input_dynamic, .reg_pass, .doo-captcha-text, .input_login", function() {
        if ($(this).val() === '') {
            $(this).val($(this).attr('title'));
        }
        ;
    });
    if ($('.ta').length > 0) {
        $('.ta').elastic().trigger('update');
    }
    ;
    $('.content_middle').on('click', '#wall_post_player_wall,' +
            '#wall_post_player_main,' +
            '#wall_post_player_home,' +
            '#wall_post_player_link,' +
            '#wall_post_player_video,' +
            '#wall_post_friend_wall,' +
            '#wall_post_friend_home,' +
            '#wall_post_friend_link,' +
            '#wall_post_friend_video,' +
            '#wall_post_group,' +
            '#wall_post_group_admin,' +
            '#wall_post_event,' +
            '#wall_post_game,' +
            '#wall_post_event_admin', function(e) {
                e.preventDefault();
                var obj = $(this);
                $(obj).startLoading();
                var $post = $("#wall"), url = site_url + 'ajaxsetpost', id = '', obj_id = $(obj).attr('id');
                if (obj_id === 'wall_post_player_main' || obj_id === 'wall_post_player_wall' || obj_id === 'wall_post_player_video' || obj_id === 'wall_post_player_link') {
                    id = $('#player_url').val();
                }
                else if (obj_id === 'wall_post_friend_wall' || obj_id === 'wall_post_friend_video' || obj_id === 'wall_post_friend_link') {
                    id = $('#friend_url').val();
                }
                else if (obj_id === 'wall_post_group' || obj_id === 'wall_post_group_admin') {
                    id = $('#group_id').val();
                }
                else if (obj_id === 'wall_post_game' || obj_id === 'wall_post_game_admin') {
                    id = $('#game_id').val();
                }
                else if (obj_id === 'wall_post_event' || obj_id === 'wall_post_event_admin') {
                    id = $('#event_id').val();
                }
                ;
                if ($post.attr('title') !== $post.val() && $post.val() !== '') {
                    $.post(url, {
                        'post': $post.val(),
                        'type': obj.attr('rel'),
                        'id': id
                    }, function(data) {
                        if (data.content) {
                            if ($('#wall_container').hasClass('dn')) {
                                $('#wall_container').removeClass('dn');
                            }
                            ;
                            if (obj_id === 'wall_post_player_video' || obj_id === 'wall_post_friend_video') {
                                $("#wall_container").html($(data.content).hide().fadeIn('slow', function() {
                                    loadFancybox();
                                }));
                                resetShowMorePosts();
                                manageShowMorePosts(data.total);
                            } else {
                                $("#wall_container").prepend($(data.content).hide().fadeIn('slow'));
                            }
                            ;
                        }
                        ;
                        $post.val($post.attr('title')).removeClass('wall_active');
                        $('.ta').trigger('update');
                        $('.autoSize').trigger('autosize');
                        $(obj).stopLoading();
                    });
                }
                ;
            });
    //enabled fancy checkboxes
    $(".register_form select, .personal_profile select").selectBox();
    //resizable textarea focus and blur actions
    $('body').on('focus', ".ta", function() {
        if ($(this).attr('title') === $(this).val()) {
            $(this).val('');
        }
        ;
        $(this).trigger('update');
        if ($(this).hasClass('message_block')) {
        }
        else if ($(this).hasClass('comment_block')) {
            $(this).addClass('comment_active');
        }
        else {
            $(this).addClass('wall_active');
        }
        ;
    }).on('blur', ".ta", function() {
        if ($(this).val() === '') {
            $(this).val($(this).attr('title'));
            if ($(this).hasClass('message_block')) {
            }
            else if ($(this).hasClass('comment_block')) {
                $(this).removeClass('comment_active');
            }
            else {
                $(this).removeClass('wall_active');
            }
            ;
        }
        ;
        $(this).trigger('update');
    });
    //resizable textarea focus and blur actions
    $('body').on('focus', ".titleAttr", function() {
        if ($(this).attr('title') === $(this).val()) {
            $(this).val('');
        }
        ;
        if ($(this).hasClass('message_block')) {
        }
        else if ($(this).hasClass('comment_block')) {
            $(this).addClass('comment_active');
        }
        else {
            $(this).addClass('wall_active');
        }
        ;
    }).on('blur', ".titleAttr", function() {
        if ($(this).val() === '') {
            $(this).val($(this).attr('title'));
            if ($(this).hasClass('message_block')) {
            }
            else if ($(this).hasClass('comment_block')) {
                $(this).removeClass('comment_active');
            }
            else {
                $(this).removeClass('wall_active');
            }
            ;
        }
        ;
    });

    $("div.friend_profile_block").mouseover(function() {
        $('.friend_profile').removeClass('dn');
    }).mouseout(function() {
        $('.friend_profile').addClass('dn');
    });

    $('body').on('click', '.blockOverlay', function() {
        hideOverlay();
    });

    $('body').on('click', '.showEmbededVideo', function(e) {
        e.preventDefault();
        var vidId = $(this).attr('rel');
        var embed = '<iframe width="520" height="294" src="http://www.youtube.com/embed/' + vidId + '?wmode=transparent" frameborder="0" allowfullscreen></iframe>';
        $('.F_showVideo_' + vidId).replaceWith(embed);
    });

    //replies posting
    $('body').on('click', '.comment_post', function(e) {
        e.preventDefault();
        var obj = $(this);
        $(obj).startLoading();
        var pid = $(obj).attr('rel'), pidArr = pid.split('_'), postID = pidArr[1], $comment = $('#' + pid);
        if ($comment.attr('title') !== $comment.val() && $comment.val() !== '') {
            $.post(site_url + 'ajaxsetreply', {
                'pid': postID,
                'comment': $comment.val()
            }, function(data) {
                if (data.content) {
                    $(".comments_block_" + postID).append($(data.content).hide().fadeIn('slow')).addClass('auto_added').parent().addClass('comments_block_active').removeClass('dn');
                    $('.comments_num_' + postID).html(data.total);
                    if (selectedTab === 'video') {
                        $('.video_comments_' + postID).html(data.total);
                    }
                    ;
                    if (selectedTab === 'photo') {
                        $('.img_comments_' + postID).html(data.total);
                    }
                    ;
                    $comment.val($comment.attr('title')).removeClass('comment_active');
                    $('.ta').trigger('update');
                    $('.autoSize').trigger('autosize');
                    toggleReplyShow('hide', postID);
                }
                ;
            });
        }
        ;
        $(obj).stopLoading();
    });

    //replies retrieving
    $('body').on('click', 'a.action_viewcomments', function(e) {
        e.preventDefault();
        var obj = $(this);
        $(obj).startLoading();
        var pid = $(obj).attr('rel');
        $.post(site_url + 'ajaxgetreplieslist', {'pid': pid}, function(data) {
            if (data.content) {
                $('.comments_block_' + pid).html($(data.content).hide().fadeIn('fast')).parent().addClass('comments_block_active').removeClass('dn');
                $('.comments_block_' + pid + ' .comment_body:last').addClass('comment_last');
                //view comments toggle text change
                toggleReplyShow('hide', pid);
                $(obj).stopLoading();
            }
            ;
        });
    });

    $('body').on('click', 'a.action_hidecomments', function(e) {
        e.preventDefault();
        $(this).startLoading();
        var pid = $(this).attr('rel');
        $('.comments_block_' + pid).html('').parent().removeClass('comments_block_active').addClass('dn');
        //view comments toggle text change
        toggleReplyShow('show', pid);
        $(this).stopLoading();
    });

    $('.content_middle').on('click', '.show_more_posts, .show_more_friends', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var sum = parseInt($(this).attr('rel'), 10), postUrl = site_url + 'ajaxgetposts', postType = $('#wallType').val(), postID = $('#wallID').val();
        if ($(this).hasClass('show_more_friends')) {
            postUrl = site_url + 'players/get-players';
        }
        ;
        $.post(postUrl, {
            'offset': sum,
            'type': postType,
            'id': postID
        }, function(data) {
            if (data.content) {
                $("#wall_container").append($(data.content).hide().fadeIn('slow'));
                loadFancybox();
            }
            ;
            manageShowMorePosts(data.total);
            obj.stopLoading();
        });
    });

    $('body').on('click', '.show_more_replies', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var relArr = $(this).attr('rel').split('_'), sum = parseInt(relArr[0], 10), pid = parseInt(relArr[1], 10);
        $.post(site_url + 'ajaxgetreplieslist', {
            'pid': pid,
            'offset': sum
        }, function(data) {
            if (data.content) {
                $('.comments_block_' + pid).append($(data.content).hide().fadeIn('slow'));
                toggleReplyShow('hide', pid);
            }
            ;
            obj.stopLoading();
        });
    });

    $('body').on('click', '.icon_close, .delete_post', function(e) {
        e.preventDefault();
        var pid = $(this).attr('rel');
        deleteElement = $(this);
        var refresh = 0;
        if ($(this).hasClass('refresh')) {
            refresh = 1;
        }
        ;
        promptDelete('deletePost(' + pid + ', ' + refresh + ')', lang['delete_post']);
    });

    $('.content_middle').on('click', '.toggle_group_member_rank', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var url = $(this).attr('rev');
        $.post(site_url + 'group/togglememberrank', {
            'group_id': $('#group_id').val(),
            'member': url
        }, function(data) {
            if (data.result === true) {
                $('.member_rank_' + url).html(data.rank);
                obj.stopLoading();
            }
            ;
        });
    });

    $('.content_middle').on('click', '.icon_close_reply, .delete_reply', function(e) {
        e.preventDefault();
        var pidArr = $(this).attr('rel').split('_'), pid = pidArr[0], rid = pidArr[1];
        deleteElement = $(this);
        promptDelete('deleteReply(' + pid + ',' + rid + ')', lang['delete_reply']);
    });

    $('body').on('click', '.action_like, .action_unlike, .action_dislike, .action_undislike', function(e) {
        e.preventDefault();
        var obj = $(this), data = $(obj).data('opt'), pid = data.id, type = data.type, rn = data.reply, l = data.like;
        $(obj).startLoading();
        if (type == 'news' || type == 'newsreply') {
            var ajax_function_path = 'news/ajaxliketoggle';
        } else {
            var ajax_function_path = 'ajaxlike';
        }
        $.post(site_url + ajax_function_path, {
            'pid': pid,
            'type': type,
            'replyNumber': rn,
            'like': l
        }, function(data) {
            if (data.result === true) {
                $(obj).addClass('dn');
                if ($(obj).hasClass('action_like')) {
                    $('.unlike_' + pid + '_' + rn).removeClass('dn').find('.like_comment_num').html(data.totalLikes);
                    if ($('.undislike_' + pid + '_' + rn).hasClass('action_undislike') == true) {
                        $('.undislike_' + pid + '_' + rn).addClass('dn').find('.dislike_comment_num').html(data.totalDislikes);
                        $('.dislike_' + pid + '_' + rn).removeClass('dn').find('.dislike_comment_num').html(data.totalDislikes);
                    }
                } else if ($(obj).hasClass('action_dislike')) {
                    $('.undislike_' + pid + '_' + rn).removeClass('dn').find('.dislike_comment_num').html(data.totalDislikes);
                    if ($('.unlike_' + pid + '_' + rn).hasClass('action_unlike') == true) {
                        $('.unlike_' + pid + '_' + rn).addClass('dn').find('.like_comment_num').html(data.totalLikes);
                        $('.like_' + pid + '_' + rn).removeClass('dn').find('.like_comment_num').html(data.totalLikes);
                    }
                } else if ($(obj).hasClass('action_unlike')) {
                    $('.like_' + pid + '_' + rn).removeClass('dn').find('.like_comment_num').html(data.totalLikes);
                } else if ($(obj).hasClass('action_undislike')) {
                    $('.dislike_' + pid + '_' + rn).removeClass('dn').find('.dislike_comment_num').html(data.totalDislikes);
                }
                ;
            }
            ;
            $(obj).stopLoading();
        });
    });

    $('.content_middle').on('click', '.action_makepublic, .action_makeprivate', function(e) {
        e.preventDefault();
        var $obj = $(this), pid = $obj.attr('rel');
        $obj.startLoading();
        $.post(site_url + 'players/ajaxtogglepublic', {
            'pid': pid
        }, function(data) {
            if (data.result === 1) {
                $obj.parent().find('.action_makeprivate').removeClass('dn');
                $obj.parent().find('.action_makepublic').addClass('dn');
            }
            ;
            if (data.result === 0) {
                $obj.parent().find('.action_makeprivate').addClass('dn');
                $obj.parent().find('.action_makepublic').removeClass('dn');
            }
            ;
            $obj.stopLoading();
        });
    });

    //img uploader
    if ($('#team_img').length) {
        createUploader('team_img', lang['upload_photo'], 'esport/ajaxuploadteamphoto');
    }
    ;
    if ($('#layout_background_uploader').length) {
        createUploader('layout_background_uploader', lang['upload_image'], 'layout/ajaxuploadbackground');
    }
    ;
    if ($('#layout_logo_uploader').length) {
        createUploader('layout_logo_uploader', lang['upload_image'], 'layout/ajaxuploadbackground/logo');
    }
    ;
    if ($('#add_picture').length) {
        createUploader('add_picture', lang['add_picture'], 'players/ajaxuploadphoto');
    }
    ;
    if ($('#uploadProfilePhoto').length) {
        createUploader('uploadProfilePhoto', lang['upload_photo'], 'players/ajaxuploadphoto');
    }
    ;
    if ($('#fanclub_img').length) {
        createUploader('fanclub_img', lang['upload_photo'], 'esport/ajaxuploadavatar');
    }
    ;
    if ($('#uploadProfilePhotoAdm').length) {
        createUploader('uploadProfilePhotoAdm', lang['upload_photo'], 'players/ajaxuploadphoto/' + $('#user').val());
    }
    ;
    if ($('#change_user_picture').length) { // Changed id (From:uploadProfilePhotoAdm) to fix compatility with new edit pages!
        createUploader('change_user_picture', lang['upload_photo'], 'players/ajaxuploadphoto/' + $('#user').val());
    }
    ;
    if ($('#change_league_picture').length) {
        createUploader('change_league_picture', lang['upload_photo'], 'esport/ajaxuploadphoto');
    }
    ;
    if ($('#mapUploader').length) {
        createMapUploader('mapUploader', lang['upload_map'], 'esport/ajaxuploadmap/' + $('#game').val());
    }
    ;
    if ($('#uploadEventPhoto').length) {
        createUploader('uploadEventPhoto', '<span class="lrc"></span><span class="mrc tac"><span class="iconr_photoshare fl mt1 mr2"></span>' + lang['upload_image'] + '</span><span class="rrc"></span>', 'event/ajaxuploadphoto/' + $('#event_id').val());
    }
    ;
    if ($('#add_company_picture').length) {
        createUploader('add_company_picture', lang['add_picture'], 'company/ajaxuploadphoto/' + $('#add_company_picture').attr('rel'));
    }
    ;
    if ($('#change_company_picture').length) {
        createUploader('change_company_picture', lang['change_picture'], 'company/ajaxuploadphoto/' + $('#change_company_picture').attr('rel'));
    }
    ;
    if ($('#add_game_picture').length) {
        createUploader('add_game_picture', lang['add_picture'], 'game/ajaxuploadphoto/' + $('#add_game_picture').attr('rel'));
    }
    ;
    if ($('#change_game_picture').length) {
        createUploader('change_game_picture', lang['change_picture'], 'game/ajaxuploadphoto/' + $('#change_game_picture').attr('rel'));
    }
    ;
    if ($('#change_news_picture').length) {
        createUploader('change_news_picture', lang['change_picture'], 'news/ajaxuploadphoto/' + $('#change_news_picture').attr('rel'));
    }
    ;
    if ($('#change_blog_picture').length) {
        createUploader('change_blog_picture', lang['change_picture'], 'blog/ajaxuploadphoto/' + $('#change_blog_picture').attr('rel'));
    }
    ;
    //find all crops
    if ($('.change_picture_crop').length) {
        $('.change_picture_crop').each(function() {
            createUploader('change_picture_crop_' + $(this).attr('orientation'), lang['change_picture'], $(this).attr('ownertype') + '/ajaxcropphoto/' + $(this).attr('rel') + '/' + $(this).attr('orientation') + '/' + $(this).attr('ownertype'), $(this).attr('orientation'));
        });
    }
    ;

    if ($('#add_group_picture').length) {
        createUploader('add_group_picture', lang['add_picture'], 'group/ajaxuploadphoto/' + $('#add_group_picture').attr('rel'));
    }
    ;
    if ($('#change_group_picture').length) {
        createUploader('change_group_picture', lang['change_picture'], 'group/ajaxuploadphoto/' + $('#change_group_picture').attr('rel'));
    }
    ;
    if ($('#add_shop_picture').length) {
        createUploader('add_shop_picture', lang['add_picture'], 'shop/ajaxuploadphoto/' + $('#add_shop_picture').attr('rel'));
    }
    ;
    if ($('#change_shop_picture').length) {
        createUploader('change_shop_picture', lang['change_picture'], 'shop/ajaxuploadphoto/' + $('#change_shop_picture').attr('rel'));
    }
    ;
    if ($('#change_achievement_picture').length) {
        createUploader('change_achievement_picture', lang['add_picture'], 'achievement/ajaxuploadphoto/' + $('#change_achievement_picture').attr('rel') + '/achievement');
    }
    ;
    if ($('#change_achievement_picture').length) {
        createUploader('change_achievement_picture', lang['change_picture'], 'achievement/ajaxuploadphoto/' + $('#change_achievement_picture').attr('rel') + '/achievement');
    }
    ;
    if ($('#change_level_picture').length) {
        createUploader('change_level_picture', lang['add_picture'], 'achievement/ajaxuploadphoto/' + $('#change_level_picture').attr('rel') + '/level');
    }
    ;
    if ($('#change_level_picture').length) {
        createUploader('change_level_picture', lang['change_picture'], 'achievement/ajaxuploadphoto/' + $('#change_level_picture').attr('rel') + '/level');
    }
    ;
    if ($('#add_bugreport_screenshot').length) {
        createUploader('add_bugreport_screenshot', lang['add_picture'], 'bugreport/ajaxuploadscreenshot/' + $('#add_bugreport_screenshot').attr('rel'));
    }
    ;
    if ($('#change_bugreport_screenshot').length) {
        createUploader('change_bugreport_screenshot', lang['change_picture'], 'bugreport/ajaxuploadscreenshot/' + $('#change_bugreport_screenshot').attr('rel'));
    }
    ;

    // KiC Begin
    if ($('#add_feedbackreport_screenshot').length) {
        createUploader('add_feedbackreport_screenshot', lang['add_picture'], 'players/feedback/ajaxuploadscreenshot/' + $('#add_feedbackreport_screenshot').attr('rel'));
    }
    ;
    if ($('#change_feedbackreport_screenshot').length) {
        createUploader('change_feedbackreport_screenshot', lang['change_picture'], 'players/feedback/ajaxuploadscreenshot/' + $('#change_feedbackreport_screenshot').attr('rel'));
    }
    ;
    // KiC End

    if ($('#wall_post_player_photo, #wall_post_friend_photo').length) {
        var el = '';
        if ($('#wall_post_player_photo').length > 0) {
            el = 'wall_post_player_photo';
        }
        else {
            el = 'wall_post_friend_photo';
        }
        ;
        var getStr = '';
        if ($('#wall_post_player_photo').attr('id_album')) {
            getStr = '?id_album=' + $('#wall_post_player_photo').attr('id_album');
        }
        ;
        new qq.FileUploader({
            debug: false,
            textUpload: '<span class="lrc"></span><span class="mrc"><span class="iconr_photoshare fl mt1 mr2"></span><span class="fl">' + lang['upload_image'] + '</span></span><span class="rrc"></span>',
            element: document.getElementById(el),
            action: site_url + 'players/ajaxwalluploadphoto' + getStr,
            multiple: false,
            allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
            acceptTypes: 'image/*',
            params: {friend: $('#friend_url').length > 0 ? $('#friend_url').val() : ''},
            onComplete: function(id, fileName, responseJSON) {
                window.location.href = window.location.href;
            }
        });
    }
    ;
    if ($('#wall_post_player_photo_disabled, #wall_post_friend_photo_disabled').length) {
        $('#wall_post_player_photo_disabled, #wall_post_friend_photo_disabled').fancybox({
            'closeClick': false,
            'openEffect': 'elastic',
            'closeEffect': 'elastic',
            'openSpeed': 600,
            'closeSpeed': 200,
            'loop': true,
            'arrows': false,
            'type': 'ajax',
            'href': site_url + 'shop/membership-feature-expiration/photo',
            'helpers': {
                'title': null,
                'overlay': {
                    'showEarly': true,
                    'closeClick': false,
                    'css': {
                        'background': 'rgba(0, 0, 0, 0.58)'
                    }
                }
            }
        });
    }
    ;

    if ($('#photoUplMain').length) {
        var wallpUploader = new qq.FileUploader({
            debug: false,
            sizeLimit: 50,
            textUpload: lang['upload_photo'],
            element: document.getElementById('photoUplMain'),
            //listElement: document.getElementById('img_load'),
            action: site_url + 'players/ajaxwalluploadphoto',
            multiple: false,
            allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
            acceptTypes: 'image/*',
            params: {friend: $('#friend_url').length > 0 ? $('#friend_url').val() : ''},
            onComplete: function(id, fileName, responseJSON) {
                window.location.href = window.location.href;
            }
        });
        //createUploader('wall_post_photo', '', 'players/ajaxwalluploadphoto/');
    }
    ;

    $('.content_middle').on('click', '.delete_friend', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var fid = $(this).attr('rel');
        deleteElement = $(this);
        promptDelete('deleteFriend(' + fid + ')', lang['delete_friend']);
    });

    $('.content_middle').on('click', '.categorize_friend_title', function(e) {
        return false;
    });
    $('.content_middle').on('click', '.categorize_friend', function(e) {
        var obj = $(this), friendcat = obj.attr('id'), c = document.getElementById('s' + friendcat);
        c.innerHTML = (c.innerHTML === '') ? '+' : '';
        var ID_FRIEND = obj.attr('name'), form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", window.location.href);
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "ID_FRIEND");
        hiddenField.setAttribute("value", ID_FRIEND);
        form.appendChild(hiddenField);
        hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "UpdateFriendCategories");
        hiddenField.setAttribute("value", "1");
        form.appendChild(hiddenField);
        var all = document.getElementsByTagName("span");
        for (var i = 0, max = all.length; i < max; i++) {
            // Do something with the element here
            var e = all[i];
            if (e.id) {
                if (e.id.search('s_' + ID_FRIEND + '_friendcat') !== -1) {
                    if (e.innerHTML !== '') {
                        var peID = e.id.replace('s_', '_'), pe = document.getElementById(peID), hiddenField1 = document.createElement("input");
                        hiddenField1.setAttribute("type", "hidden");
                        hiddenField1.setAttribute("name", "ID_CAT[]");
                        hiddenField1.setAttribute("value", pe.rel);
                        form.appendChild(hiddenField1);
                    }
                    ;
                }
                ;
            }
            ;
        }
        ;
        document.body.appendChild(form);
        form.submit();
        return true;
        //return false;
    });
    $('.content_middle').on('click', '.categorize_friend_submit', function(e) {
        var obj = $(this), ID_FRIEND = obj.attr('rel'), form = document.createElement("form");
        form.setAttribute("method", "post");
        form.setAttribute("action", window.location.href);
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "ID_FRIEND");
        hiddenField.setAttribute("value", ID_FRIEND);
        form.appendChild(hiddenField);
        hiddenField = document.createElement("input");
        hiddenField.setAttribute("type", "hidden");
        hiddenField.setAttribute("name", "UpdateFriendCategories");
        hiddenField.setAttribute("value", "1");
        form.appendChild(hiddenField);
        var all = document.getElementsByTagName("span");
        for (var i = 0, max = all.length; i < max; i++) {
            // Do something with the element here
            var e = all[i];
            if (e.id) {
                if (e.id.search('s_' + ID_FRIEND + '_friendcat') !== -1) {
                    if (e.innerHTML !== '') {
                        var peID = e.id.replace('s_', '_'), pe = document.getElementById(peID), hiddenField1 = document.createElement("input");
                        hiddenField1.setAttribute("type", "hidden");
                        hiddenField1.setAttribute("name", "ID_CAT[]");
                        hiddenField1.setAttribute("value", pe.rel);
                        form.appendChild(hiddenField1);
                    }
                    ;
                }
                ;
            }
            ;
        }
        ;
        document.body.appendChild(form);
        form.submit();
        return true;
    });

    $('.content_middle').on('click', '.delete_player_suggestion', function(e) {
        e.preventDefault();
        var obj = $(this);
        $(obj).startLoading();
        var pUrl = $(this).attr('rel');
        $.post(site_url + 'players/ajaxhideplayersuggestion', {'url': pUrl}, function(data) {
            if (data.result === true) {
                $(obj).closest('.itemPost').fadeOut('slow', function() {
                    $(this).remove();
                });
            }
            ;
            $(obj).stopLoading();
        });
    });


    //confirm friendship request from notification
    $('.content_middle').on('click', '.add_friend_from_notif', function(e) {
        e.preventDefault();
        var fid = $(this).attr('rel');
        $obj = $(this);
        $obj.startLoading();
        $.post(site_url + 'players/ajaxinsertfriend', {'fid': fid}, function(data) {
            if (data.result === true) {
                $obj.closest('div').fadeOut('fast').remove();
            }
            ;
            $obj.stopLoading();
        });
    });

    //confirm friendship request
    $('.content_middle').on('click', '.add_friend', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var fid = $(this).attr('rel');
        $.post(site_url + 'players/ajaxinsertfriend', {'fid': fid}, function(data) {
            if (data.result === true) {
                var style = 'mt20 dot_top';
                if (!$('.post_friend_' + fid).hasClass('dot_top')) {
                    style = '';
                }
                ;
                $('.post_friend_' + fid).hide(function() {
                    $('.post_friend_' + fid).after($(data.content).addClass(style));
                });
            }
            ;
            obj.stopLoading();
        });
    });

    //confirm friendship request from notification
    $('.content_middle').on('click', '.add_friend_from_notif', function(e) {
        e.preventDefault();
        var fid = $(this).attr('rel');
        $obj = $(this);
        $obj.startLoading();
        $.post(site_url + 'players/ajaxinsertfriend', {'fid': fid}, function(data) {
            if (data.result === true) {
                $obj.closest('div').fadeOut('fast').remove();
            }
            ;
            $obj.stopLoading();
        });
    });


    $('.content_middle').on('click', '.action_makepublic, .action_makeprivate', function(e) {
        e.preventDefault();
        var $obj = $(this), pid = $obj.attr('rel');
        $obj.startLoading();
        $.post(site_url + 'players/ajaxtogglepublic', {
            'pid': pid
        }, function(data) {
            if (data.result === 1) {
                $obj.parent().find('.action_makeprivate').removeClass('dn');
                $obj.parent().find('.action_makepublic').addClass('dn');
            }
            ;
            if (data.result === 0) {
                $obj.parent().find('.action_makeprivate').addClass('dn');
                $obj.parent().find('.action_makepublic').removeClass('dn');
            }
            ;
            $obj.stopLoading();
        });
    });

    //img uploader
    if ($('#team_img').length) {
        createUploader('team_img', lang['upload_photo'], 'esport/ajaxuploadteamphoto');
    }
    ;
    if ($('#layout_background_uploader').length) {
        createUploader('layout_background_uploader', lang['upload_image'], 'layout/ajaxuploadbackground');
    }
    ;
    if ($('#layout_logo_uploader').length) {
        createUploader('layout_logo_uploader', lang['upload_image'], 'layout/ajaxuploadbackground/logo');
    }
    ;
    if ($('#challenge_img_upload').length) {
        createUploader('challenge_img_upload', lang['upload_image'], 'esport/ajaxuploadscreenshot');
    }
    ;
    if ($('#add_picture').length) {
        createUploader('add_picture', lang['add_picture'], 'players/ajaxuploadphoto');
    }
    ;
    if ($('#uploadProfilePhoto').length) {
        createUploader('uploadProfilePhoto', lang['upload_photo'], 'players/ajaxuploadphoto');
    }
    ;
    if ($('#fanclub_img').length) {
        createUploader('fanclub_img', lang['upload_photo'], 'esport/ajaxuploadavatar');
    }
    ;
    if ($('#uploadProfilePhotoAdm').length) {
        createUploader('uploadProfilePhotoAdm', lang['upload_photo'], 'players/ajaxuploadphoto/' + $('#user').val());
    }
    ;
    if ($('#change_user_picture').length) { // Changed id (From:uploadProfilePhotoAdm) to fix compatility with new edit pages!
        createUploader('change_user_picture', lang['upload_photo'], 'players/ajaxuploadphoto/' + $('#user').val());
    }
    ;
    if ($('#change_league_picture').length) {
        createUploader('change_league_picture', lang['upload_photo'], 'esport/ajaxuploadphoto');
    }
    ;
    if ($('#mapUploader').length) {
        createMapUploader('mapUploader', lang['upload_map'], 'esport/ajaxuploadmap/' + $('#game').val());
    }
    ;
    if ($('#uploadEventPhoto').length) {
        createUploader('uploadEventPhoto', '<span class="lrc"></span><span class="mrc tac"><span class="iconr_photoshare fl mt1 mr2"></span>' + lang['upload_image'] + '</span><span class="rrc"></span>', 'event/ajaxuploadphoto/' + $('#event_id').val());
    }
    ;
    if ($('#add_company_picture').length) {
        createUploader('add_company_picture', lang['add_picture'], 'company/ajaxuploadphoto/' + $('#add_company_picture').attr('rel'));
    }
    ;
    if ($('#change_company_picture').length) {
        createUploader('change_company_picture', lang['change_picture'], 'company/ajaxuploadphoto/' + $('#change_company_picture').attr('rel'));
    }
    ;
    if ($('#add_game_picture').length) {
        createUploader('add_game_picture', lang['add_picture'], 'game/ajaxuploadphoto/' + $('#add_game_picture').attr('rel'));
    }
    ;
    if ($('#change_game_picture').length) {
        createUploader('change_game_picture', lang['change_picture'], 'game/ajaxuploadphoto/' + $('#change_game_picture').attr('rel'));
    }
    ;
    if ($('#change_news_picture').length) {
        createUploader('change_news_picture', lang['change_picture'], 'news/ajaxuploadphoto/' + $('#change_news_picture').attr('rel'));
    }
    ;
    if ($('#change_blog_picture').length) {
        createUploader('change_blog_picture', lang['change_picture'], 'blog/ajaxuploadphoto/' + $('#change_blog_picture').attr('rel'));
    }
    ;
    //find all crops
    if ($('.change_picture_crop').length) {
        $('.change_picture_crop').each(function() {
            createUploader('change_picture_crop_' + $(this).attr('orientation'), lang['change_picture'], $(this).attr('ownertype') + '/ajaxcropphoto/' + $(this).attr('rel') + '/' + $(this).attr('orientation') + '/' + $(this).attr('ownertype'), $(this).attr('orientation'));
        });
    }
    ;

    if ($('#add_group_picture').length) {
        createUploader('add_group_picture', lang['add_picture'], 'group/ajaxuploadphoto/' + $('#add_group_picture').attr('rel'));
    }
    ;
    if ($('#change_group_picture').length) {
        createUploader('change_group_picture', lang['change_picture'], 'group/ajaxuploadphoto/' + $('#change_group_picture').attr('rel'));
    }
    ;
    if ($('#add_shop_picture').length) {
        createUploader('add_shop_picture', lang['add_picture'], 'shop/ajaxuploadphoto/' + $('#add_shop_picture').attr('rel'));
    }
    ;
    if ($('#change_shop_picture').length) {
        createUploader('change_shop_picture', lang['change_picture'], 'shop/ajaxuploadphoto/' + $('#change_shop_picture').attr('rel'));
    }
    ;
    if ($('#change_achievement_picture').length) {
        createUploader('change_achievement_picture', lang['add_picture'], 'achievement/ajaxuploadphoto/' + $('#change_achievement_picture').attr('rel') + '/achievement');
    }
    ;
    if ($('#change_achievement_picture').length) {
        createUploader('change_achievement_picture', lang['change_picture'], 'achievement/ajaxuploadphoto/' + $('#change_achievement_picture').attr('rel') + '/achievement');
    }
    ;
    if ($('#change_level_picture').length) {
        createUploader('change_level_picture', lang['add_picture'], 'achievement/ajaxuploadphoto/' + $('#change_level_picture').attr('rel') + '/level');
    }
    ;
    if ($('#change_level_picture').length) {
        createUploader('change_level_picture', lang['change_picture'], 'achievement/ajaxuploadphoto/' + $('#change_level_picture').attr('rel') + '/level');
    }
    ;
    if ($('#add_bugreport_screenshot').length) {
        createUploader('add_bugreport_screenshot', lang['add_picture'], 'bugreport/ajaxuploadscreenshot/' + $('#add_bugreport_screenshot').attr('rel'));
    }
    ;
    if ($('#change_bugreport_screenshot').length) {
        createUploader('change_bugreport_screenshot', lang['change_picture'], 'bugreport/ajaxuploadscreenshot/' + $('#change_bugreport_screenshot').attr('rel'));
    }
    ;

    if ($('#wall_post_player_photo, #wall_post_friend_photo').length) {
        var el = '';
        if ($('#wall_post_player_photo').length > 0) {
            el = 'wall_post_player_photo';
        }
        else {
            el = 'wall_post_friend_photo';
        }
        ;
        var getStr = '';
        if ($('#wall_post_player_photo').attr('id_album')) {
            getStr = '?id_album=' + $('#wall_post_player_photo').attr('id_album');
        }
        ;
        new qq.FileUploader({
            debug: false,
            textUpload: '<span class="lrc"></span><span class="mrc"><span class="iconr_photoshare fl mt1 mr2"></span><span class="fl">' + lang['upload_image'] + '</span></span><span class="rrc"></span>',
            element: document.getElementById(el),
            action: site_url + 'players/ajaxwalluploadphoto' + getStr,
            multiple: false,
            allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
            acceptTypes: 'image/*',
            params: {friend: $('#friend_url').length > 0 ? $('#friend_url').val() : ''},
            onComplete: function(id, fileName, responseJSON) {
                window.location.href = window.location.href;
            }
        });
    }
    ;
    if ($('#wall_post_player_photo_disabled, #wall_post_friend_photo_disabled').length) {
        $('#wall_post_player_photo_disabled, #wall_post_friend_photo_disabled').fancybox({
            'closeClick': false,
            'openEffect': 'elastic',
            'closeEffect': 'elastic',
            'openSpeed': 600,
            'closeSpeed': 200,
            'loop': true,
            'arrows': false,
            'type': 'ajax',
            'href': site_url + 'shop/membership-feature-expiration/photo',
            'helpers': {
                'title': null,
                'overlay': {
                    'showEarly': true,
                    'closeClick': false,
                    'css': {
                        'background': 'rgba(0, 0, 0, 0.58)'
                    }
                }
            }
        });
    }
    ;

    if ($('#photoUplMain').length) {
        var wallpUploader = new qq.FileUploader({
            debug: false,
            sizeLimit: 50,
            textUpload: lang['upload_photo'],
            element: document.getElementById('photoUplMain'),
            //listElement: document.getElementById('img_load'),
            action: site_url + 'players/ajaxwalluploadphoto',
            multiple: false,
            allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
            acceptTypes: 'image/*',
            params: {friend: $('#friend_url').length > 0 ? $('#friend_url').val() : ''},
            onComplete: function(id, fileName, responseJSON) {
                window.location.href = window.location.href;
            }
        });
        //createUploader('wall_post_photo', '', 'players/ajaxwalluploadphoto/');
    }
    ;

    $('.content_middle').on('click', '.delete_friend', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var fid = $(this).attr('rel');
        deleteElement = $(this);
        promptDelete('deleteFriend(' + fid + ')', lang['delete_friend']);
    });

    $('body').on('click', '.update_game_info, .update_game_info_close', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var $form = $("#edit_game_form");
        $form.validate({
            rules: {
                game_name: {
                    required: true,
                    maxlength: 80
                },
                game_release: {
                    required: true,
                    date: true
                },
                game_url: {
                    required: true,
                    url: true
                }
            }
        });

        if ($form.valid()) {
            $('textarea[name=game_description]').val(CKEDITOR.instances['game_description'].getData());
            $.post(site_url + 'game/updategameinfo', $('#edit_game_form').serialize(), function(data) {
                if (data.result === true) {
//                    location.reload();
                    if (obj.hasClass('update_game_info_close')) {
                        window.location.href = obj.attr('rel');
                    }
                    ;
                }
                ;
                obj.stopLoading();
            });
        } else {
            obj.stopLoading();
        }
        ;
    });

    $('.content_middle').on('click', '.icon_close_game_media', function(e) {
        e.preventDefault();
        var pid = $(this).attr('rel');
        $obj = $(this);
        deleteElement = $(this);
        promptDelete('deleteGameMedia(' + pid + ')', lang['delete_media']);
    });

    $('body').on('click', '.addtab_game', function(e) {
        e.preventDefault();
        var obj = $(this);
        $(obj).startLoading();
        var $form = $("#addtab_game_form");
        $form.validate({
            rules: {
                tab_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 15
                }
            }
        });

        if ($form.valid()) {
            $.post(site_url + 'game/savedownloadtab', $('#addtab_game_form').serialize(), function(data) {
                if (data.result === true) {
                    $.fancybox.close();
                    location.reload();
                }
                ;
                $(obj).stopLoading();
            });
        } else {
            $(obj).stopLoading();
        }
        ;
    });

    $('body').on('click', '.adddownload_game', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var $form = $("#adddownload_game_form");
        $form.validate({
            rules: {
                download_filename: {
                    required: true,
                    minlength: 3,
                    maxlength: 40
                },
                download_filesize: {
                    required: true,
                    digits: true,
                    min: 1
                },
                download_fileurl: {
                    required: true,
                    url: true
                }
            }
        });

        if ($form.valid()) {
            $.post(site_url + 'game/savedownload', $('#adddownload_game_form').serialize(), function(data) {
                if (data.result === true) {
                    $.fancybox.close();
                    location.reload();
                }
                ;
                obj.stopLoading();
            });
        } else {
            obj.stopLoading();
        }
        ;
    });

    $('body').on('click', '.delete_game_download', function(e) {
        e.preventDefault();
        $obj = $(this);
        var id = $(this).attr('rel');
        deleteElement = $(this);
        promptDelete('deleteGameDownload(' + id + ')', lang['delete_download']);
    });

    $('body').on('click', '.icon_close_game_tab', function(e) {
        e.preventDefault();
        var pid = $(this).attr('rel');
        $obj = $(this);
        deleteElement = $(this);
        promptDelete('deleteGameDownloadTab(' + pid + ')', lang['delete_tab']);
    });

    $('body').on('click', '.update_group_info', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        $.post(site_url + 'group/updategroupinfo', $('#edit_group_form').serialize(), function(data) {
            if (data.result === true) {
                $.fancybox.close();
                location.reload();
            }
            ;
            obj.stopLoading();
        });
    });

    $('body').on('click', '.addtab_group', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var $form = $("#addtab_group_form");
        $form.validate({
            rules: {
                tab_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 15
                }
            }
        });

        if ($form.valid()) {
            $.post(site_url + 'group/savedownloadtab', $('#addtab_group_form').serialize(), function(data) {
                if (data.result === true) {
                    $.fancybox.close();
                    location.reload();
                }
                ;
                obj.stopLoading();
            });
        } else {
            obj.stopLoading();
        }
        ;
    });

    $('body').on('click', '.addmedia_group', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        if ($("#group_media_tab").val() === 'video') {
            $.post(site_url + 'group/ajaxuploadmultivideo/' + $('#group_id').val(), $('#addmedia_group_form').serialize(), function(data) {
                if (data.result === true) {
                    $.fancybox.close();
                    location.reload();
                }
                ;
                obj.stopLoading();
            });
        } else {
            $('#group_media_images').uploadify('settings', 'formData', {'selected-tab': $('#group_media_tab').val()});
            $('#group_media_images').uploadify('upload', '*');
            obj.stopLoading();
        }
        ;
    });


    //reject friend request reject from notification
    $('.content_middle').on('click', '.reject_friend_from_notif', function(e) {
        e.preventDefault();
        var fid = $(this).attr('rel');
        $obj = $(this);
        $obj.startLoading();
        $.post(site_url + 'players/ajaxrejectfriend', {'fid': fid}, function(data) {
            if (data.result === true) {
                $obj.closest('.post_wall').fadeOut('fast').remove();
            }
            ;
            $obj.stopLoading();
        });
    });


    //send friend request
    $('body').on('click', '.add_friend_profile, .add_friend_friend, .add_member_profile', function(e) {
        e.preventDefault();
        var fid = $(this).attr('rel'), $obj = $(this);
        $obj.startLoading();
        $.post(site_url + 'players/ajaxinsertfriend', {'fid': fid}, function(data) {
            if (data.result === true) {
                $('.add_friend_profile').addClass('dn').remove();
                $('.add_friend_' + fid).addClass('dn').remove();
                if ($obj.hasClass('add_member_profile')) {
                    if ($obj.parent().hasClass('add-btn')) {
                        $obj.closest('li').fadeOut(function() {
                            // 'this' now refers to the <li> element
                            this.remove();
                        });
                    } else {
                        $obj.addClass('dn').remove();
                    }
                }
                ;
            }
            ;
            $obj.stopLoading();
        });
    });

    //reject friend request
    $('body').on('click', '.reject_friend', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var fid = $(this).attr('rel');
        $.post(site_url + 'players/ajaxrejectfriend', {'fid': fid}, function(data) {
            if (data.result === true) {
                $('.post_friend_' + fid).fadeOut('fast');
                var new_friend = 0, friends_num = parseInt($('.friend_count_header').html(), 10);
                if ($('.received_requests').length) {
                    new_friend = parseInt($('.received_requests').html(), 10);
                }
                ;
                if (new_friend <= 1) {
                    $('.received_requests').remove();
                    $('.friend_count_side').html(friends_num);
                } else {
                    new_friend--;
                    $('.received_requests').html(new_friend + ' ' + lang['players_new']);
                }
                ;
            }
            ;
            obj.stopLoading();
        });
    });




    //send message
    $('a.send_message').fancybox({
        'closeClick': false,
        'openEffect': 'elastic',
        'closeEffect': 'elastic',
        'openSpeed': 600,
        'closeSpeed': 200,
        'loop': true,
        'arrows': false,
        'type': 'ajax',
        'href': site_url + 'players/ajaxgetsendmessage/' + $('#friend_url').val(),
        'helpers': {
            'title': null,
            'overlay': {
                'showEarly': true,
                'closeClick': false,
                'css': {
                    'background': 'rgba(0, 0, 0, 0.58)'
                }
            }
        },
        'afterShow': function() {
            messageInit($('#friend_url').val(), $(this).attr('title'));
        }
    });


    $('body').on('click', '.block_user', function(data) {
        var obj = $(this), ID_PLAYER = obj.attr('rel'), url = site_url + 'players/ajaxblockuser';
        var params = {
            'ID_PLAYER': ID_PLAYER,
            'blockmode': 'block'
        };
        //Do the external SQL action
        $.post(url, params, function(data) {
            //alert(data.result + document.URL);
            window.location.href = document.URL;
        });
    });

    $('body').on('click', '.unblock_user', function(data) {
        var obj = $(this), ID_PLAYER = obj.attr('rel'), url = site_url + 'players/ajaxblockuser';
        var params = {
            'ID_PLAYER': ID_PLAYER,
            'blockmode': 'unblock'
        };
        //Do the external SQL action
        $.post(url, params, function(data) {
            //alert(data.result + document.URL);
            window.location.href = document.URL;
        });
    });

    $('a.invite_event_friends').fancybox({
        'closeClick': false,
        'openEffect': 'elastic',
        'closeEffect': 'elastic',
        'openSpeed': 600,
        'closeSpeed': 200,
        'loop': true,
        'arrows': false,
        'type': 'ajax',
        'href': site_url + 'event/ajaxinvitepeopleshow/' + $('#event_id').val(),
        'helpers': {
            'title': null,
            'overlay': {
                'showEarly': true,
                'closeClick': false,
                'css': {
                    'background': 'rgba(0, 0, 0, 0.58)'
                }
            }
        },
        'afterShow': function() {
            $('.JscrollPane').jScrollPane({showArrows: true});
            loadCheckboxes();
            //messageInit($('#friend_url').val(), $(this).attr('title'));
        }
    });

    $('body').on('click', '.changeemail_post', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var $message = $('#newemail'), $ID_PLAYER = $('#ID_PLAYER');
        var params = {
            'ID_PLAYER': $ID_PLAYER.val(),
            'newemail': $message.val()
        };
        $.post(site_url + 'players/ajaxchangeemailsubmit', params, function(data) {
            if (data.emailExists !== 0) {
                alert("Email adress is already in the system!");
            }
            ;
            if (data.validEmail !== 1) {
                alert("Invalid email adress!");
            }
            ;
            if (data.emailExists === 0 && data.validEmail === 1) {
                alert("Your have updated your email adress. You will recieve a verification email on your new adress.");
                window.location.href = site_url + 'players/ajaxchangeemaildone';
            }
            ;
            $.fancybox.close();
        });
        return;
    });

    $('body').on('click', '.inviteFriendsSend', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var ids = '', event = obj.attr('rel'), url = site_url + 'event/ajaxinvitepeople';
        $('#playerInvite:checked').each(function(index) {
            if (index !== 0) {
                ids += ',' + $(this).val();
            } else {
                ids += $(this).val();
            }
            ;
        });
        //console.log(ids);
        $.post(url, {'ids': ids, 'event': event}, function(data) {
            if (data.result === true) {
                $.fancybox.close();
            }
            ;
            obj.stopLoading();
        });
    });

    $('body').on('click', '#sendMessage', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var friend = obj.attr('rel'), message = $('.messageInput'), url = site_url + 'players/ajaxreplymessage';
        if (message.val().length > 0 && message.val() !== message.attr('title')) {
            message = message.val();
            var params = {
                'friendUrl': friend,
                'message': message
            };
            $.post(url, params, function(data) {
                if (data.result === true) {
                    window.location.href = site_url + 'players/messages/read/' + friend;
                }
                ;
            });
        }
        ;
        obj.stopLoading();
    });

    $('body').on('click', '.message_post', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var $selector = $("#tags").tokenInput("get"), $message = $('#message_text');
        if ($selector.length > 0 && $message.val() !== $message.attr('title')) {
            var recipients = {};
            $.each($selector, function(i, v) {
                recipients[i] = v.id;
            });
            var params = {
                'message': $message.val(),
                'recipients': recipients
            };
            $.post(site_url + 'players/ajaxsendmessage', params, function(data) {
                if (data.result === true) {
                    $.fancybox.close();
                }
                ;
            });
        }
        ;
        return;
    });

    $('.content_middle').on('click', '.delete_inbox_message, .delete_sent_message', function(e) {
        e.preventDefault();
        var pid = $(this).attr('rel');
        deleteElement = $(this);
        if ($(this).hasClass('delete_sent_message')) {
            promptDelete('deleteMessageItem("' + pid + '", 0)', lang['delete_message']);
        }
        else {
            promptDelete('deleteMessageItem("' + pid + '", 1)', lang['delete_message']);
        }
        ;
    });

    $('.content_middle').on('click', '.delete_selected_messages, .delete_selected_sent_messages', function(e) {
        e.preventDefault();
        if ($('.cp:checked').length) {
            deleteElement = $(this);
            if ($(this).hasClass('delete_selected_sent_messages')) {
                promptDelete('deleteMessageSelectedItems(0)', lang['delete_message']);
            }
            else {
                promptDelete('deleteMessageSelectedItems(1)', lang['delete_message']);
            }
            ;
        }
        ;
    });

    $('.content_middle').on('click', '.delete_all_messages, .delete_all_sent_messages', function(e) {
        e.preventDefault();
        deleteElement = $(this);
        if ($(this).hasClass('delete_all_sent_messages')) {
            promptDelete('deleteAllMessages(0)', lang['delete_all_message']);
        }
        else {
            promptDelete('deleteAllMessages(1)', lang['delete_all_message']);
        }
        ;
    });

    // Conversation based message system functions (the following 2)
    $('body').on('click', '#sendConvMessage', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var conversation = obj.attr('rel'), message = $('.messageInput'), url = site_url + 'players/ajaxreplyconvmessage';
        if (message.val().length > 0 && message.val() !== message.attr('title')) {
            message = message.val();
            var params = {
                'conversation': conversation,
                'message': message
            };
            $.post(url, params, function(data) {
                if (data.result === true) {
                    window.location.href = site_url + 'players/conversations/read/' + conversation;
                }
                ;
            });
        }
        ;
        obj.stopLoading();
    });

    $('body').on('click', '.conv_message_post', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var $conversation = $('#conversation'), $message = $('#message_text');
        var params = {
            'message': $message.val(),
            'conversation': $conversation.val()
        };
        $.post(site_url + 'players/ajaxsendoutsideconvmessage', params, function(data) {
            if (data.result === true) {
                $.fancybox.close();
            }
            ;
        });
        return;
    });

    //news replies posting
    $('.content_middle').on('click', '.comment_newspost', function(e) {
        e.preventDefault();
        var obj = $(this);
        $(obj).startLoading();
        var data = $(obj).data('opt'), pid = data.ID, lang = data.langID, $comment = $('#comment_' + pid);
        if ($comment.attr('title') !== $comment.val() && $comment.val() !== '') {
            $.post(site_url + 'news/ajaxsetreply', {
                'pid': pid,
                'langID': lang,
                'comment': $comment.val()
            }, function(data) {
                if (data.content) {
                    if ($('.comments_block').hasClass('dn')) {
                        $('.comments_block').removeClass('dn');
                    }
                    ;
                    $(".comments_block_" + pid).append($(data.content).hide().fadeIn('slow'));
                    $('.comments_num_' + pid).html(data.total);
                    $comment.val($comment.attr('title')).removeClass('comment_active');
                    $('.ta').trigger('update');
                }
                ;
                $(obj).stopLoading();
            });
        } else {
            $(obj).stopLoading();
        }
        ;
    });

    //news replies retrieving
    $('.content_middle').on('click', '.action_viewnewscomments', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var data = $(obj).data('opt'), pid = data.ID, lang = data.langID;
        $.post(site_url + 'news/ajaxgetreplieslist', {
            'pid': pid,
            'langID': lang
        }, function(data) {
            if (data.content) {
                $('.comments_block_' + pid).html($(data.content).hide().fadeIn('fast')).parent().addClass('comments_block_active').removeClass('dn');
                $('.comments_block_' + pid + ' .comment_body:last').addClass('comment_last');
                //view comments toggle text change
                toggleReplyShow('hide', pid);
            }
            ;
            obj.stopLoading();
        });
    });

    $('.content_middle').on('click', '.delete_news', function(e) {
        e.preventDefault();
        $obj = $(this)
        var id = $(this).attr('rel');
        deleteElement = $(this);
        promptDelete('deleteNewsItem(' + id + ')', lang['delete_news']);
    });

    $('.content_middle').on('click', '.unpublish_news', function(e) {
        e.preventDefault();
        $obj = $(this);
        var id = $(this).attr('rel'), lang = $(this).attr('lang');
        deleteElement = $(this);
        promptDeleteNote('unpublishNewsItem(' + id + ',' + lang + ',$("#prompt_text").val())', lang['unpublish_review'], 0);
    });

    $('.content_middle').on('click', '.action_hidenewscomments', function(e) {
        e.preventDefault();
        var data = $(this).data('opt'), pid = data.ID;
        $('.comments_block_' + pid).html('').parent().removeClass('comments_block_active').addClass('dn');
        toggleReplyShow('show', pid);
    });

    $('.hide_top_news').on('click', 'a', function(e) {
        e.preventDefault();
        var val = $(this).attr('rel');
        $.post(site_url + 'block-visibility/' + val + '/0');
        if ($(this).hasClass('table')) {
            $('.tbl_slide').slideUp('fast', function() {
                $('.header_toggle').removeClass('dn');
            });
        }
        else {
            $('.top_news').slideUp('fast', function() {
                $('.show_top_news').removeClass('dn');
            });
        }
        ;
    });

    $('.show_top_news').on('click', 'a', function(e) {
        e.preventDefault();
        var val = $(this).attr('rel');
        $.post(site_url + 'block-visibility/' + val + '/1');
        if ($(this).hasClass('table')) {
            $('.header_toggle').addClass('dn');
            $('.tbl_slide').slideDown('fast');
        } else {
            $('.top_news').slideDown('fast', function() {
                $('.show_top_news').addClass('dn');
            });
        }
        ;
    });

    $('.content_middle').on('click', '.action_is_playing, .action_stop_playing', function(e) {
        e.preventDefault();
        var gid = $(this).attr('rel'), $obj = $(this);
        $obj.startLoading();
        $.post(site_url + 'players/ajaxtoggleisplayinggame', {'gid': gid}, function(data) {
            if (data.result === true) {
                if ($obj.hasClass('action_stop_playing')) {
                    if ($('#player_url').length) {
                        $obj.closest('.itemPost').fadeOut('fast', function() {
                            $(this).remove();
                        });
                    }
                    else {
                        $obj.closest('ul').find('.action_is_playing').removeClass('dn');
                        $obj.addClass('dn');
                    }
                    ;
                } else {
                    $obj.closest('ul').find('.action_stop_playing').removeClass('dn');
                    $obj.addClass('dn');
                }
                ;
            }
            ;
            $obj.stopLoading();
        });
    });

    $('.content_middle').on('click', '.action_remove_event', function(e) {
        e.preventDefault();
        var eid = $(this).attr('rel'), $obj = $(this);
        $obj.startLoading();
        $.post(site_url + 'event/ajaxdeleteevent', {'eid': eid}, function(data) {
            if (data.result === true) {
                $obj.closest('.itemPost').fadeOut('fast', function() {
                    $(this).remove();
                });
            }
            ;
            $obj.stopLoading();
        });
    });

    $('.content_middle').on('click', '.action_unparticipate_event', function(e) {
        e.preventDefault();
        var eid = $(this).attr('rel'), $obj = $(this);
        $obj.startLoading();
        $.post(site_url + 'event/ajaxunparticipate', {'eid': eid}, function(data) {
            if (data.result === true) {
                $obj.closest('.itemPost').fadeOut('fast', function() {
                    $(this).remove();
                });
            }
            ;
            $obj.stopLoading();
        });
    });

    $('body').on('click', '.F_unparticipate', function(e) {
        e.preventDefault();
        var eid = $(this).attr('rel'), $obj = $(this);
        $obj.startLoading();
        $.post(site_url + 'event/ajaxunparticipate', {'eid': eid}, function(data) {
            if (data.result === true) {
                $obj.fadeOut();
            }
            ;
            $obj.stopLoading();
        });
    });

    //delete news reply
    $('.content_middle').on('click', '.icon_close_newsreply', function(e) {
        e.preventDefault();
        var pidArr = $(this).attr('rel').split('_'), pid = pidArr[0], rid = pidArr[1];
        deleteElement = $(this);
        promptDelete('deleteNewsReply(' + pid + ',' + rid + ')', lang['delete_reply']);
    });

    //news searchbox interaction
    $(".search_common_text").focus(function() {
        if ($(this).attr('title') === $(this).val()) {
            $(this).val('');
        }
        ;
        $(".searchcommon_input").addClass('searchcommon_input_active');
    }).blur(function() {
        if ($(this).val() === '') {
            $(this).val($(this).attr('title'));
        }
        ;
        $(".searchcommon_input").removeClass('searchcommon_input_active');
    });

    //searchbox interaction
    $("a.srccommon_but").mouseover(function() {
        if (!$(".searchcommon_input").hasClass('searchcommon_input_active')) {
            $(".searchcommon_input").addClass('searchcommon_input_active');
        }
        ;
    }).mouseout(function() {
        if (!$(".search_common_text").is(':focus')) {
            $(".searchcommon_input").removeClass('searchcommon_input_active');
        }
        ;
    });
    $('body').on('click', "a.srccommon_but", function(e) {
        $('.common_search_form').submit();
    });
    $('body').on('click', "a.common_new_search", function(e) {
        $('.common_new_search_form').submit();
    });
    $('body').on('click', '.readmore', function(e) {
        e.preventDefault();
        var id = $(this).attr('rel');
        if ($('.short_desc_' + id).hasClass('dn')) {
            $('.short_desc_' + id).removeClass('dn');
            $('.long_desc_' + id).addClass('dn');
            $(this).html($(this).attr('name'));
        } else {
            $('.short_desc_' + id).addClass('dn');
            $('.long_desc_' + id).removeClass('dn');
            $(this).html($(this).attr('rev'));
        }
        ;
    });

    $('.show_more_desc').on('click', '.show_desc, .hide_desc', function(e) {
        e.preventDefault();
        $(this).addClass('dn');
        if ($(this).hasClass('show_desc')) {
            $('.description').removeClass('dn');
            $('.hide_desc').removeClass('dn');
        } else {
            $('.description').addClass('dn');
            $('.show_desc').removeClass('dn');
        }
    });

    $('.show_more_desc').on('click', '.show_oh, .hide_oh', function(e) {
        e.preventDefault();
        $(this).addClass('dn');
        var className = '';
        if ($('#company_id').length > 0) {
            className = 'company_desc';
        }
        else if ($('#group_id').length > 0) {
            className = 'group_desc';
        }
        else if ($('#game_id').length > 0) {
            className = 'game_desc';
        }
        ;
        if ($(this).hasClass('show_oh')) {
            $('.description').removeClass(className);
            $('.hide_oh').removeClass('dn');
        } else {
            $('.description').addClass(className);
            $('.show_oh').removeClass('dn');
        }
        ;
    });


    // once used on forum - dont think they are been used any more - hide/show show_more_desc_poll
    $('.show_more_desc_poll').on('click', '.show_desc_poll, .hide_desc_poll', function(e) {
        e.preventDefault();
        $(this).addClass('dn');
        if ($(this).hasClass('show_desc_poll')) {
            $('.polldescription').removeClass('dn');
            $('.hide_desc_poll').removeClass('dn');
        } else {
            $('.polldescription').addClass('dn');
            $('.show_desc_poll').removeClass('dn');
        }
    });




    $('.show_more_desc_poll').on('click', '.show_oh, .hide_oh', function(e) {
        e.preventDefault();
        $(this).addClass('dn');
        var className = '';
        if ($('#company_id').length > 0) {
            className = 'company_desc';
        }
        else if ($('#group_id').length > 0) {
            className = 'group_desc';
        }
        else if ($('#game_id').length > 0) {
            className = 'game_desc';
        }
        ;
        if ($(this).hasClass('show_oh')) {
            $('.polldescription').removeClass(className);
            $('.hide_oh').removeClass('dn');
        } else {
            $('.polldescription').addClass(className);
            $('.show_oh').removeClass('dn');
        }
        ;
    });

    $('body').on('click', '.count_download', function(e) {
        var id = $(this).attr('rel');
        $.post(site_url + 'company/ajaxcountdownload', {'id': id});
        return true;
    });


    $('body').on('submit', '.news_validate', function() {
        return validateNews();
    });

    $('body').on('change', '.news_action', function() {
        if ($(this).val() === 1) {
            $('.news_edit_container').load(site_url + 'news/ajaxedit/' + $('#news_id').val(), {}, function(data) {
                $('.news_edit_container').removeClass('dn');
                $('.news_preview_container').addClass('dn');
                loadCheckboxes();
            });
        } else {
            if (validateNews() === true) {
                $('textarea[name=messageIntro]').val(CKEDITOR.instances['messageIntro'].getData());
                $('textarea[name=messageText]').val(CKEDITOR.instances['messageText'].getData());
                var $form = $("#addnew_form"), urls = site_url;
                if ($('#news_id').length > 0) {
                    urls += 'news/ajaxupdate/' + $('#news_id').val();
                    $form = $("#editnew_form");
                } else {
                    urls += 'news/ajaxsave';
                }
                ;
                var options = {
                    success: function(data) {
                        if (data.content) {
                            $('.news_preview_container').html(data.content);
                            $('.news_edit_container').addClass('dn');
                            $('.news_preview_container').removeClass('dn');
                        }
                        ;
                    },
                    url: urls,
                    type: 'post',
                    dataType: 'json'
                };
                $form.ajaxSubmit(options);
                if (CKEDITOR.instances['messageIntro']) {
                    delete CKEDITOR.instances['messageIntro'];
                }
                ;
                if (CKEDITOR.instances['messageIntro']) {
                    CKEDITOR.instances['messageIntro'].destroy();
                }
                ;
                if (CKEDITOR.instances['messageText']) {
                    delete CKEDITOR.instances['messageText'];
                }
                ;
                if (CKEDITOR.instances['messageText']) {
                    CKEDITOR.instances['messageText'].destroy();
                }
                ;
                $('.news_edit_container').html('');
            }
            ;
        }
        ;
    });

    $('body').on('click', '.addnews, .editnews', function(e) {
        e.preventDefault();
        var $form = $("#addnew_form");
        if ($('#news_id').length > 0) {
            $form = $("#editnew_form");
        }
        ;
        if (validateNews() === true) {
            if ($(this).hasClass('save_close')) {
                $('#save_close').val('1');
            }
            ;
            $form.submit();
        }
        ;
    });

    $('body').on('change', '.newsType', function() {
        if ($(this).val() === 1) {
            $('#newsCompany').addClass('dn');
            $('#newsGame').removeClass('dn');
        } else {
            $('#newsCompany').removeClass('dn');
            $('#newsGame').addClass('dn');
        }
        ;
    });


    $('body').on('click', '.update_company_info', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var $form = $("#update_company_info_form");
        $form.validate({
            rules: {
                company_headquoters: {
                    required: true,
                    minlength: 3,
                    maxlength: 80
                },
                company_founded: {
                    required: true,
                    date: true
                },
                company_ownership: {
                    required: true
                },
                company_employees: {
                    required: true,
                    digits: true,
                    min: 1
                },
                company_url: {
                    required: true,
                    url: true
                }
            }
        });

        if ($form.valid()) {
            $.post(site_url + 'company/updatecompanyinfo', $('#update_company_info_form').serialize(), function(data) {
                if (data.result === true) {
                    $.fancybox.close();
                    location.reload();
                }
                ;
                obj.stopLoading();
            });
        } else {
            obj.stopLoading();
        }
        ;
    });

    $('.content_middle').on('click', '.icon_close_company_media', function(e) {
        e.preventDefault();
        var pid = $(this).attr('rel');
        $obj = $(this);
        deleteElement = $(this);
        promptDelete('deleteCompanyMedia(' + pid + ')', lang['delete_media']);
    });

    $('body').on('click', '.addtab_company', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var $form = $("#addtab_company_form");
        $form.validate({
            rules: {
                tab_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 15
                }
            }
        });

        if ($form.valid()) {
            $.post(site_url + 'company/savedownloadtab', $('#addtab_company_form').serialize(), function(data) {
                if (data.result === true) {
                    $.fancybox.close();
                    location.reload();
                }
                ;
                obj.stopLoading();
            });
        } else {
            obj.stopLoading();
        }
        ;
    });

    $('body').on('click', '.adddownload_company', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var $form = $("#adddownload_company_form");
        $form.validate({
            rules: {
                download_filename: {
                    required: true,
                    minlength: 3,
                    maxlength: 40
                },
                download_filesize: {
                    required: true,
                    digits: true,
                    min: 1
                },
                download_fileurl: {
                    required: true,
                    url: true
                }
            }
        });

        if ($form.valid()) {
            $.post(site_url + 'company/savedownload', $('#adddownload_company_form').serialize(), function(data) {
                if (data.result === true) {
                    $.fancybox.close();
                    location.reload();
                }
                ;
                obj.stopLoading();
            });
        } else {
            obj.stopLoading();
        }
        ;
    });

    $('body').on('click', '.delete_company_download', function(e) {
        e.preventDefault();
        $obj = $(this);
        var id = $(this).attr('rel');
        deleteElement = $(this);
        promptDelete('deleteCompanyDownload(' + id + ')', lang['delete_download']);
    });

    $('body').on('click', '.addgame_company', function(e) {
        e.preventDefault();
        var $obj = $(this);
        $obj.startLoading();
        var $form = $("#addgame_company_form");
        $form.validate({
            rules: {
                game_name: {
                    required: true,
                    maxlength: 80
                },
                game_release: {
                    required: true,
                    date: true
                },
                game_url: {
                    required: true,
                    url: true
                }
            }
        });

        if ($form.valid()) {
            $.post(site_url + 'company/savegame', $('#addgame_company_form').serialize(), function(data) {
                if (data.result === true) {
                    $.fancybox.close();
                    location.reload();
                }
                ;
                $obj.stopLoading();
            });
        } else {
            $obj.stopLoading();
        }
        ;
    });




    $('body').on('click', '.update_game_info, .update_game_info_close', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var $form = $("#edit_game_form");
        $form.validate({
            rules: {
                game_name: {
                    required: true,
                    maxlength: 80
                },
                game_release: {
                    required: true,
                    date: true
                },
                game_url: {
                    required: true,
                    url: true
                }
            }
        });

        if ($form.valid()) {
            $('textarea[name=game_description]').val(CKEDITOR.instances['game_description'].getData());
            $.post(site_url + 'game/updategameinfo', $('#edit_game_form').serialize(), function(data) {
                if (data.result === true) {
//                    location.reload();
                    if (obj.hasClass('update_game_info_close')) {
                        window.location.href = obj.attr('rel');
                    }
                    ;
                }
                ;
                obj.stopLoading();
            });
        } else {
            obj.stopLoading();
        }
        ;
    });

    $('.content_middle').on('click', '.icon_close_game_media', function(e) {
        e.preventDefault();
        var pid = $(this).attr('rel');
        $obj = $(this);
        deleteElement = $(this);
        promptDelete('deleteGameMedia(' + pid + ')', lang['delete_media']);
    });

    $('body').on('click', '.addtab_game', function(e) {
        e.preventDefault();
        var obj = $(this);
        $(obj).startLoading();
        var $form = $("#addtab_game_form");
        $form.validate({
            rules: {
                tab_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 15
                }
            }
        });

        if ($form.valid()) {
            $.post(site_url + 'game/savedownloadtab', $('#addtab_game_form').serialize(), function(data) {
                if (data.result === true) {
                    $.fancybox.close();
                    location.reload();
                }
                ;
                $(obj).stopLoading();
            });
        } else {
            $(obj).stopLoading();
        }
        ;
    });

    $('body').on('click', '.adddownload_game', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var $form = $("#adddownload_game_form");
        $form.validate({
            rules: {
                download_filename: {
                    required: true,
                    minlength: 3,
                    maxlength: 40
                },
                download_filesize: {
                    required: true,
                    digits: true,
                    min: 1
                },
                download_fileurl: {
                    required: true,
                    url: true
                }
            }
        });

        if ($form.valid()) {
            $.post(site_url + 'game/savedownload', $('#adddownload_game_form').serialize(), function(data) {
                if (data.result === true) {
                    $.fancybox.close();
                    location.reload();
                }
                ;
                obj.stopLoading();
            });
        } else {
            obj.stopLoading();
        }
        ;
    });

    $('body').on('click', '.delete_game_download', function(e) {
        e.preventDefault();
        $obj = $(this);
        var id = $(this).attr('rel');
        deleteElement = $(this);
        promptDelete('deleteGameDownload(' + id + ')', lang['delete_download']);
    });

    $('body').on('click', '.icon_close_game_tab', function(e) {
        e.preventDefault();
        var pid = $(this).attr('rel');
        $obj = $(this);
        deleteElement = $(this);
        promptDelete('deleteGameDownloadTab(' + pid + ')', lang['delete_tab']);
    });

    $('body').on('click', '.update_group_info', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        $.post(site_url + 'group/updategroupinfo', $('#edit_group_form').serialize(), function(data) {
            if (data.result === true) {
                $.fancybox.close();
                location.reload();
            }
            ;
            obj.stopLoading();
        });
    });

    $('body').on('click', '.addtab_group', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var $form = $("#addtab_group_form");
        $form.validate({
            rules: {
                tab_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 15
                }
            }
        });

        if ($form.valid()) {
            $.post(site_url + 'group/savedownloadtab', $('#addtab_group_form').serialize(), function(data) {
                if (data.result === true) {
                    $.fancybox.close();
                    location.reload();
                }
                ;
                obj.stopLoading();
            });
        } else {
            obj.stopLoading();
        }
        ;
    });

    $('body').on('click', '.addmedia_group', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        if ($("#group_media_tab").val() === 'video') {
            $.post(site_url + 'group/ajaxuploadmultivideo/' + $('#group_id').val(), $('#addmedia_group_form').serialize(), function(data) {
                if (data.result === true) {
                    $.fancybox.close();
                    location.reload();
                }
                ;
                obj.stopLoading();
            });
        } else {
            $('#group_media_images').uploadify('settings', 'formData', {'selected-tab': $('#group_media_tab').val()});
            $('#group_media_images').uploadify('upload', '*');
            obj.stopLoading();
        }
        ;
    });

//	$('#photo_upload').uploadify({
//            'uploader'  : site_url+'global/js/uploadify/uploadify.swf',
//            'script'    : site_url+'global/js/uploadify/uploadify.php',
//            'cancelImg' : site_url+'global/js/uploadify/cancel.png',
//            'auto'      : true,
//            'multi'          : true,
//            'fileExt'        : '*.jpg;*.gif;*.png',
//            'fileDesc'       : 'Image Files (.JPG, .GIF, .PNG)',
//            'queueID'        : 'custom-queue',
//            'queueSizeLimit' : 30,
//            'simUploadLimit' : 1,
//            'sizeLimit'   : 102400,
//            'removeCompleted': false,
//            'scriptData' : {
//            'tab': 'photo'
//            },
//            'onSelectOnce'   : function(event,data) {
//				console.log('sel')
//            //                alert(data.filesSelected + ' files have been added to the queue.');
//            },
//            'onComplete'   : function(event,data,fileObj,errorObj) {
//            //                console.log(data);
//            },
//            'onAllComplete'  : function(event,data,fileObj,errorObj) {
//                //$.fancybox.close();
//               // location.reload();
//            },
//            'onError'     : function (event,ID,fileObj,errorObj) {
//            //                alert(errorObj.type + ' Error: ' + errorObj.info);
//            }
//        });
//	$('body').on('click', '#wall_post_photo', function(e){
//		console.log('click');
//		e.preventDefault();
//        var obj = $(this);
//        obj.startLoading();
//		$('#photo_upload').uploadifySettings('scriptData', {
//			'selected-tab': obj.attr('rel')
//		});
//		$('#photo_upload').uploadifyUpload();
//		obj.stopLoading();
//	});

    $('body').on('click', '.addmedia_company', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        if ($("#company_media_tab").val() === 'video') {
            $.post(site_url + 'company/ajaxuploadmultivideo/' + $('#company_id').val(), $('#addmedia_company_form').serialize(), function(data) {
                if (data.result === true) {
                    $.fancybox.close();
                    location.reload();
                }
                ;
                obj.stopLoading();
            });
        } else {
            $('#company_media_images').uploadify('settings', 'formData', {'selected-tab': $('#company_media_tab').val()});
            $('#company_media_images').uploadify('upload', '*');
            obj.stopLoading();
        }
        ;
    });

    $('body').on('click', '.addmedia_game', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        if ($("#game_media_tab").val() === 'video') {
            $.post(site_url + 'game/ajaxuploadmultivideo/' + $('#game_id').val(), $('#addmedia_game_form').serialize(), function(data) {
                if (data.result === true) {
                    $.fancybox.close();
                    location.reload();
                }
                ;
                obj.stopLoading();
            });
        } else {
            $('#game_media_images').uploadify('settings', 'formData', {'selected-tab': $('#game_media_tab').val()});
            $('#game_media_images').uploadify('upload', '*');
            obj.stopLoading();
        }
        ;
    });

    $('body').on('click', '.editmedia_game', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var $form = $("#addmedia_game_form");
        $form.validate({
            rules: {
                media_name: {
                    required: true,
                    minlength: 1,
                    maxlength: 80
                }
            }
        });

        if ($form.valid()) {
            $.post(site_url + 'game/' + $('#game_id').val() + '/admin/savemedia', $('#addmedia_game_form').serialize(), function(data) {
                if (data.result === true) {
                    $.fancybox.close();
                    location.reload();
                }
                ;
                obj.stopLoading();
            });
        } else {
            obj.stopLoading();
        }
        ;
    });

    $('body').on('click', '.write_game_desc', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        $.post(site_url + 'players/save-game-description', $('#write_game_desc_form').serialize(), function(data) {
            if (data.result === true) {
                $.fancybox.close();
                location.reload();
            }
            ;
            obj.stopLoading();
        });
    });

    $('body').on('click', '.editmedia_company', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var $form = $("#addmedia_company_form");
        $form.validate({
            rules: {
                media_name: {
                    required: true,
                    minlength: 1,
                    maxlength: 80
                }
            }
        });

        if ($form.valid()) {
            $.post(site_url + 'company/' + $('#company_id').val() + '/admin/savemedia', $('#addmedia_company_form').serialize(), function(data) {
                if (data.result === true) {
                    $.fancybox.close();
                    location.reload();
                }
                ;
                obj.stopLoading();
            });
        } else {
            obj.stopLoading();
        }
        ;
    });

    $('body').on('click', '.icon_close_company_tab', function(e) {
        e.preventDefault();
        var pid = $(this).attr('rel');
        $obj = $(this);
        deleteElement = $(this);
        promptDelete('deleteCompanyDownloadTab(' + pid + ')', lang['delete_tab']);
    });

    $('body').on('click', '.editmedia_group', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var $form = $("#addmedia_group_form");
        $form.validate({
            rules: {
                media_name: {
                    required: true,
                    minlength: 1,
                    maxlength: 80
                }
            }
        });

        if ($form.valid()) {
            console.log($('#addmedia_group_form').serialize());
            $.post(site_url + 'group/' + $('#group_id').val() + '/admin/savemedia', $('#addmedia_group_form').serialize(), function(data) {
                if (data.result === true) {
                    $.fancybox.close();
                    location.reload();
                }
                ;
                obj.stopLoading();
            });
        } else {
            obj.stopLoading();
        }
        ;
    });

    $('body').on('click', '.add_group_alliances', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        $.post(site_url + 'group/' + $('#group_id').val() + '/admin/savealliance', $('#alliances_group_form').serialize(), function(data) {
            if (data.result === true) {
                $.fancybox.close();
                location.reload();
            }
            ;
            obj.stopLoading();
        });
    });

    $('body').on('click', '.invite_group_member', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        $.post(site_url + 'group/' + $('#group_id').val() + '/admin/invitemembers', $('#invite_group_member_form').serialize(), function(data) {
            if (data.result === true) {
                $.fancybox.close();
            }
            ;
            obj.stopLoading();
        });
    });

    $('body').on('click', '.add_membertogroup_from_notif', function(e) {
        e.preventDefault();
        var $obj = $(this);
        $obj.startLoading();
        var param = {'group_id': $obj.attr('rel')};
        if ($obj.hasClass('aprove_application')) {
            var split = $obj.attr('rel').split('_');
            param = {
                'group_id': split[0],
                'player': split[1]
            };
        }
        ;
        $.post(site_url + 'group/ajaxacceptinvitation', param, function(data) {
            if (data.result === true) {
                $obj.closest('.itemPost').fadeOut('fast');
                $obj.closest('.post_wall').fadeOut('fast');
            }
            ;
            $obj.stopLoading();
        });
    });

    $('body').on('click', '.reject_membertogroup_from_notif', function(e) {
        e.preventDefault();
        var $obj = $(this);
        $obj.startLoading();
        var param = {'group_id': $obj.attr('rel')};
        if ($(this).hasClass('aprove_application')) {
            var split = $obj.attr('rel').split('_');
            param = {
                'group_id': split[0],
                'player': split[1]
            };
        }
        ;
        $.post(site_url + 'group/ajaxrejectinvitation', param, function(data) {
            if (data.result === true) {
                $obj.closest('.post_wall').fadeOut('fast');
            }
            ;
            $obj.stopLoading();
        });
    });

    $('body').on('click', '.adddownload_group', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var $form = $("#adddownload_group_form");
        $form.validate({
            rules: {
                download_filename: {
                    required: true,
                    minlength: 3,
                    maxlength: 40
                },
                download_filesize: {
                    required: true,
                    digits: true,
                    min: 1
                },
                download_fileurl: {
                    required: true,
                    url: true
                }
            }
        });

        if ($form.valid()) {
            $.post(site_url + 'group/savedownload', $('#adddownload_group_form').serialize(), function(data) {
                if (data.result === true) {
                    $.fancybox.close();
                    location.reload();
                }
                ;
                obj.stopLoading();
            });
        } else {
            obj.stopLoading();
        }
        ;
    });

    $('body').on('click', '.create_group_info', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var $form = $("#create_group_form");
        $form.validate({
            rules: {
                group_name: {
                    required: true,
                    minlength: 1,
                    maxlength: 80
                }
            }
        });

        if ($form.valid() && $("#game_tags").val().length > 0) {
            $.post(site_url + 'groups/savegroup', $('#create_group_form').serialize(), function(data) {
                if (data.result === true) {
                    $.fancybox.close();
                    location = data.newUrl;
                    //location.reload();
                }
                ;
                obj.stopLoading();
            });
        } else {
            obj.stopLoading();
        }
        ;
    });

    $('body').on('click', '.remove_affiliate', function(e) {
        e.preventDefault();
        $obj = $(this);
        var id = $(this).attr('rel');
        deleteElement = $(this);
        promptDelete('deleteGroupAlliance(' + id + ')', lang['delete_alliance']);
    });

    $('body').on('keyup', '#group_apply_description', function(e) {
        var left = 250 - parseInt($(this).val().length, 10);
        if (left <= 0) {
            left = 0;
            $('#group_apply_description').val($('#group_apply_description').val().substring(0, 250));
        }
        ;
        $('#symbol_count').html(left);
    });

    $('body').on('click', '.add_group_application', function(e) {
        e.preventDefault();
        $obj = $(this);
        $obj.startLoading();
        $.post(site_url + 'group/send-request-to-join', $('#add_group_application_form').serialize(), function(data) {
            if (data.result === true) {
                $.fancybox.close();
                var groupID = data.id;
                $('.ga_' + groupID).fadeOut('fast');
                if ($('.F_group_' + $('.F_group_apply_id').val()).length) {
                    $('.F_group_' + $('.F_group_apply_id').val()).remove();
                }
                ;
            }
            ;
            $obj.stopLoading();
        });
    });

    $('body').on('click', '.leave_group', function(e) {
        e.preventDefault();
        $obj = $(this);
        var id = $(this).attr('rel');
        deleteElement = $(this);
        promptDelete('leaveGroup(' + id + ')', lang['leave_group']);
    });

    $('body').on('click', '.delete_group', function(e) {
        e.preventDefault();
        $obj = $(this);
        var id = $(this).attr('rel');
        deleteElement = $(this);
        promptDelete('deleteGroup(' + id + ')', lang['delete_group']);
    });

    $(document).on('click', '.delete_group_member', function(e) {
        e.preventDefault();
        $obj = $(this);
        var id = $(this).attr('rel');
        deleteElement = $(this);
        promptDelete('deleteGroupMember(' + id + ')', lang['delete_member']);
    });

    $('body').on('click', '.remove_group_application', function(e) {
        e.preventDefault();
        var group = $(this).attr('rel');
        deleteElement = $(this);
        promptDelete('deleteGroupApplication(' + group + ')', lang['delete_member']);
    });

    $('body').on('click', '.icon_close_group_media', function(e) {
        e.preventDefault();
        var pid = $(this).attr('rel');
        $obj = $(this);
        deleteElement = $(this);
        promptDelete('deleteGroupMedia(' + pid + ')', lang['delete_media']);
    });

    $('body').on('click', '.remove_member_role', function(e) {
        e.preventDefault();
        $obj = $(this);
        var rel = $(this).attr('rel'), rel_array = rel.split(","), id = rel_array[0], role = rel_array[1];
        deleteElement = $(this);
        promptDelete('removeMemberRole(' + id + ',\"' + role + '\")', lang['remove_member_role']);
    });

    $('body').on('click', '.add_member_role', function(e) {
        e.preventDefault();
        $obj = $(this);
        var rel = $(this).attr('rel'), rel_array = rel.split(","), id = rel_array[0], role = rel_array[1];
        deleteElement = $(this);
        promptDelete('addMemberRole(' + id + ',\"' + role + '\")', lang['add_member_role']);
    });

    $('.welcome_box').on('click', 'a.show', function(e) {
        e.preventDefault();
        if ($('.long').hasClass('dn')) {
            $('.welcome_box').addClass('welcome_box_extended');
            $('.long').removeClass('dn');
            $('.short').addClass('dn');
            $('a.show').addClass('hide');
        } else {
            $('.long').addClass('dn');
            $('.short').removeClass('dn');
            $('.welcome_box').removeClass('welcome_box_extended');
            $('a.show').removeClass('hide');
        }
        ;
    });

    //MAIN SUBSCRIPTIONS HANDLING
    $('body').on('click', '.subscribe, .unsubscribe', function(e) {
        e.preventDefault();
        var obj = $(this);
        $(obj).startLoading();
        var data = $(obj).data('opt'), type = data.otype, id = data.id;
        $.post(site_url + 'ajaxtogglesubscription', {
            id: data.id,
            type: data.type,
            ownerType: data.otype,
            ownerID: data.oid,
            ownerID1: data.oid1
        }, function(data) {
            if (data.result === true) {
                var pointer = id; // On forum pages there are different subscribe buttons, with same id. some glitches appear
                if (type !== consts.undefined) {
                    pointer = type + '_' + id;
                }
                ;
                if ($(obj).hasClass('subscribe')) {
                    $('.subscribe_' + pointer).addClass('dn');
                    $('.unsubscribe_' + pointer).removeClass('dn');
                } else {
                    if ($(obj).hasClass('unsubscribe_subscription')) {
                        $(obj).closest('tr').fadeOut();
                    }
                    else {
                        $('.subscribe_' + pointer).removeClass('dn');
                        $('.unsubscribe_' + pointer).addClass('dn');
                    }
                    ;
                }
                ;
            }
            ;
            $(obj).stopLoading();
        });
    });

    //like/unlike to group
    $('body').on('click', '.group_like, .group_unlike, .company_like, .company_unlike, .game_like, .game_unlike, .spotlight_like, .spotlight_unlike', function(e) {
        e.preventDefault();
        var id = $(this).attr('rel'), $obj = $(this), url;
        $obj.startLoading();
        if ($obj.hasClass('group_like') || $obj.hasClass('group_unlike')) {
            url = 'groups/ajaxtogglelike';
        }
        else if ($obj.hasClass('company_like') || $obj.hasClass('company_unlike')) {
            url = 'companies/ajaxtogglelike';
        }
        else if ($obj.hasClass('game_like') || $obj.hasClass('game_unlike')) {
            url = 'games/ajaxtogglelike';
        }
        else if ($obj.hasClass('spotlight_like') || $obj.hasClass('spotlight_unlike')) {
            url = 'fanclub/ajaxtogglelike';
        }
        ;
        $.post(site_url + url, {'id': id}, function(data) {
            if (data.result === true) {
                if ($obj.hasClass('like')) {
                    $('.like_' + id).addClass('dn');
                    $('.unlike_' + id).removeClass('dn');
                } else {
                    $('.like_' + id).removeClass('dn');
                    $('.unlike_' + id).addClass('dn');
                }
                ;
            }
            ;
            $obj.stopLoading();
        });
    });

    //shop
    $('body').on('click', '.F_buyCredits', function(e) {
        e.preventDefault();
        var obj = $(this);
        $(obj).startLoading();
        var prevVal = $(obj).html();
        $(obj).html('Processing...');
        $.post(site_url + 'shop/ajaxmakerequest', $('#F_creditsForm').serialize(), function(data) {
            if (data.result === true) {
                $(obj).html('Loading Payment...');
                submitValues(data.url, data.params);
            } else {
                $(obj).html(prevVal);
                $(obj).stopLoading();
            }
            ;
        });
    });

    $('body').on('click', '.update_product_info, .update_product_info_close', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var $form = $("#edit_product_form");
        $form.validate({
            rules: {
                product_name: {
                    required: true,
                    maxlength: 80
                },
                product_type: {
                    required: true
                }
            }
        });

        if ($form.valid()) {
            $('textarea[name=product_desc]').val(CKEDITOR.instances['product_desc'].getData());
            $.post(site_url + 'shop/updateproduct', $('#edit_product_form').serialize(), function(data) {
                if (data.result === true) {
                    if (obj.hasClass('update_product_info_close')) {
                        window.location.href = obj.attr('rel');
                    }
                    ;
                }
                ;
                obj.stopLoading();
            });
        } else {
            obj.stopLoading();
        }
        ;
    });

    $('#get_contacts_cont').on('click', 'a.get_mail_contacts', function(e) {
        e.preventDefault();
        var obj = $(this);
        $(obj).startLoading();
        var params = {
            'mail_system': $('input[name=mail_system]:checked').val(),
            'user': $('#mail_username').val(),
            'pass': $('#mail_password').val()
        };
        $.post(site_url + 'players/ajaxgetcontactlist', params, function(data) {
            $('#contact_list').html(data.content);
            $(obj).stopLoading();
        });
    });

    if ($(".scroll-content").length) {
        //scrollpane parts
        var scrollPane = $(".scroll-pane"), scrollContent = $(".scroll-content");
        //build slider
        var scrollbar = $(".scroll-bar").slider({
            slide: function(event, ui) {
                if (scrollContent.width() > scrollPane.width()) {
                    scrollContent.css("margin-left", Math.round(ui.value / 100 * (scrollPane.width() - scrollContent.width())) + "px");
                }
                else {
                    scrollContent.css("margin-left", 0);
                }
                ;
            }
        });

        //append icon to handle
        var handleHelper = scrollbar.find(".ui-slider-handle").mousedown(function() {
            scrollbar.width(handleHelper.width());
        })
                .mouseup(function() {
                    scrollbar.width("100%");
                }).append("<span class='slider_left'></span><span class='slider_right'></span>")
                .wrap("<div class='ui-handle-helper-parent'></div>").parent();

        //change overflow to hidden now that slider handles the scrolling
        scrollPane.css("overflow", "hidden");

        //size scrollbar and handle proportionally to scroll distance
        function sizeScrollbar() {
            var remainder = scrollContent.width() - scrollPane.width(), proportion = remainder / scrollContent.width(), handleSize = scrollPane.width() - (proportion * scrollPane.width());
            scrollbar.find(".ui-slider-handle").css({
                width: handleSize,
                "margin-left": -handleSize / 2
            });
            handleHelper.width("").width(scrollbar.width() - handleSize);
        }
        ;

        //reset slider value based on scroll content position
        function resetValue() {
            var remainder = scrollPane.width() - scrollContent.width(), leftVal = scrollContent.css("margin-left") === "auto" ? 0 :
                    parseInt(scrollContent.css("margin-left"), 10);
            var percentage = Math.round(leftVal / remainder * 100);
            scrollbar.slider("value", percentage);
        }
        ;

        //if the slider is 100% and window gets larger, reveal content
        function reflowContent() {
            var showing = scrollContent.width() + parseInt(scrollContent.css("margin-left"), 10), gap = scrollPane.width() - showing;
            if (gap > 0) {
                scrollContent.css("margin-left", parseInt(scrollContent.css("margin-left"), 10) + gap);
            }
            ;
        }
        ;

        //change handle position on window resize
        $(window).resize(function() {
            resetValue();
            sizeScrollbar();
            reflowContent();
        });
        //init scrollbar size
        setTimeout(sizeScrollbar, 10);//safari wants a timeout
    }
    ;

    $('body').on('click', "a.closeInfoBox", function(e) {
        e.preventDefault();
        var obj = $(this);
        $(obj).startLoading();
        $.post(site_url + 'closeinfobox', {'id': $(obj).attr('rel')}, function(data) {
            if (data.result === true) {
                $('.info_box').fadeOut();
                $(obj).stopLoading();
            }
            ;
        });
    });

    $('body').on('mouseover', '.profile_rating.enabled .ratingStar', function() {
        var obj = $(this), selected = -1, i = 0;
        for (i = 1; i <= 5; i++) {
            if (obj.hasClass("star" + i)) {
                selected = i;
                break;
            }
            ;
        }
        ;
        if (selected >= 0) {
            for (i = 1; i <= 5; i++) {
                if (i <= selected) {
                    $('.profile_rating .ratingStar.star' + i).removeClass('icon_star_empty').removeClass('icon_star_filled').addClass('icon_star_filled_vote');
                }
                else {
                    $('.profile_rating .ratingStar.star' + i).addClass('icon_star_empty').removeClass('icon_star_filled').removeClass('icon_star_filled_vote');
                }
                ;
            }
            ;
        }
        ;
    });

    $('body').on('mouseout', '.profile_rating.enabled .stars_rating', function() {
        var obj = $('.profile_rating .ratingStar.starCurrentSelected'), current = -1, i = 0;
        for (i = 1; i <= 5; i++) {
            if (obj.hasClass("star" + i)) {
                current = i;
                break;
            }
            ;
        }
        ;
        if (current >= 0) {
            for (i = 1; i <= 5; i++) {
                if (i <= current) {
                    $('.profile_rating .ratingStar.star' + i).removeClass('icon_star_empty').addClass('icon_star_filled').removeClass('icon_star_filled_vote');
                }
                else {
                    $('.profile_rating .ratingStar.star' + i).addClass('icon_star_empty').removeClass('icon_star_filled').removeClass('icon_star_filled_vote');
                }
                ;
            }
            ;
        }
        ;
    });

    $('.profile_rating.enabled .ratingStar').CreateBubblePopup({
        //manageMouseEvents: false,
        openingDelay: 1600,
        position: 'top',
        align: 'center',
        themeName: 'grey',
        themePath: site_url + 'global/js/images/jquerybubblepopup-theme',
        themeMargins: {total: '13px', difference: '0px'},
        innerHtml: '<img src="' + site_url + 'global/img/ajax-loader-small.gif" />'});

    $('.profile_rating.enabled .ratingStar').mouseenter(function() {
        var obj = $(this);
        if (obj.GetBubblePopupLastDisplayDateTime() === null) {
            var url = site_url + 'players/ajaxgetratinginfo', ourl = '', options = {};
            if ($('#friend_url').length > 0) {
                var selected = -1;
                for (var i = 1; i <= 5; i++) {
                    if (obj.hasClass("star" + i)) {
                        selected = i;
                        break;
                    }
                    ;
                }
                ;
                ourl = $('#friend_url').val();
                options = {'ourl': ourl, 'vote': selected};
            } else if ($("#company_id").length > 0) {
                url = site_url + 'companies/ajaxgetratinginfo';
                ourl = $("#company_id").val();
                options = {'ourl': ourl, 'vote': selected};
            } else if ($("#game_id").length > 0) {
                url = site_url + 'games/ajaxgetratinginfo';
                ourl = $("#game_id").val();
                options = {'ourl': ourl, 'vote': selected};
            }
            ;
            $.post(url, options, function(data) {
                if (data.result === true) {
                    obj.SetBubblePopupInnerHtml(data.content, true);
                }
                ;
            });
        }
        ;
    });

    $('.profile_rating.disabled').CreateBubblePopup({
//		openingDelay : 600,
        position: 'top',
        align: 'center',
        themeName: 'grey',
        themePath: site_url + 'global/js/images/jquerybubblepopup-theme',
        themeMargins: {total: '13px', difference: '0px'},
        innerHtml: '<img src="' + site_url + 'global/img/ajax-loader-small.gif" />'
    });

    $('.profile_rating.disabled').mouseenter(function() {
        if ($('.profile_rating.disabled').GetBubblePopupLastDisplayDateTime() === null) {
            var url = site_url + 'players/ajaxgetratinginfo', options = {};
            if ($('#friend_url').length > 0) {
                var ourl = $('#friend_url').val();
                options = {'ourl': ourl};
            }
            ;
            $.post(url, options, function(data) {
                if (data.result === true) {
                    $('.profile_rating.disabled').SetBubblePopupInnerHtml(data.content, true);
                }
                ;
            });
        }
        ;
    });

    $("#ratingDropdown").change(function() {
        var obj = $(this), selected = -1, url = site_url, ourl = '';
        if ($('#friend_url').length > 0) {
            url += 'players/ajaxrate';
            ourl = $('#friend_url').val();
        } else if ($("#company_id").length > 0) {
            url += 'companies/ajaxrate';
            ourl = $("#company_id").val();
            selected = $("#ratingDropdown").val();
        } else if ($("#game_id").length > 0) {
            url += "games/ajaxrate/";
            ourl = $("#game_id").val();
            selected = $("#ratingDropdown").val();
        }
        ;
        $.post(url, {'ourl': ourl, 'rating': selected}, function(data) {
            if (data.redirect !== consts.undefined && data.redirect === true) {
                window.location.href = site_url + 'login/loginfirst';
            }
            ;
        });
    });

    $('body').on('click', '.profile_rating.enabled .ratingStar', function() {
        console.log("cliekced");
        var obj = $(this), selected = -1, url = site_url, ourl = '';
        if ($('#friend_url').length > 0) {
            url += 'players/ajaxrate';
            ourl = $('#friend_url').val();
            selected = $('input[type="hidden"]', this).val();
        } else if ($("#company_id").length > 0) {
            url += 'companies/ajaxrate';
            ourl = $("#company_id").val();
        } else if ($("#game_id").length > 0) {
            url += 'games/ajaxrate';
            ourl = $("#game_id").val();
        }
        ;
        for (var i = 1; i <= 5; i++) {
            if (obj.hasClass("star" + i)) {
                selected = i;
                break;
            }
            ;
        }
        ;
        if (selected >= 1 || selected <= 5) {
            $.post(url, {'ourl': ourl, 'rating': selected}, function(data) {
                if (data.redirect !== consts.undefined && data.redirect === true) {
                    window.location.href = site_url + 'login/loginfirst';
                }
                ;
                if (data.result !== consts.undefined && data.result === true) {
                    var rating = parseFloat(data.rating).toFixed(1), iEnd = Math.round(rating);
                    $('.profile_rating span.actualRating').text(parseFloat(data.rating).toFixed(1));
                    for (var i = 1; i <= iEnd; i++) {
                        if (i <= iEnd) {
                            $('.profile_rating .ratingStar.star' + i).removeClass('icon_star_empty').addClass('icon_star_filled');
                        }
                        else {
                            $('.profile_rating .ratingStar.star' + i).addClass('icon_star_empty').removeClass('icon_star_filled');
                        }
                        ;
                        if (i === iEnd) {
                            $('.profile_rating .ratingStar.star' + i).addClass('starCurrentSelected');
                        }
                        else {
                            $('.profile_rating .ratingStar.star' + i).removeClass('starCurrentSelected');
                        }
                        ;
                    }
                    ;
                    for (var i = (iEnd + 1); i <= 5; i++) {
                        $('.profile_rating .ratingStar.star' + i).addClass('icon_star_empty').removeClass('icon_star_filled');
                    }
                    ;
                }
                ;
            });
        }
        ;
    });

    $('body').on('click', '.postVideoSwitch', function(e) {
        e.preventDefault();
        var obj = $(this);
        $(obj).startLoading();
        $('.wallInput').attr('title', lang['pasteVideo']);
        $('.wallInput').text(lang['pasteVideo']);
        $('.wallInput').focus();
        $(obj).stopLoading();
    });

    $('body').on('click', '#editNickname', function() {
        $(this).addClass('dn');
        $('#editNicknameFinish').removeClass('dn');
        //$('#nickname').val('');
        $('#nickname').focus();
    });

    $('body').on('click', '#editNicknameFinish', function() {
        var obj = $(this);
        obj.startLoading();
        var val = $('#nickname').val();
        if (val !== '' && val.length >= 5 && val.length <= 40) {
            var url = site_url + 'players/ajaxupdateprofile';
            $.post(url, {'nickname': val}, function(data) {
                obj.addClass('dn');
                $('#editNickname').removeClass('dn');
            });
        }
        ;
        obj.stopLoading();
    });
    $('body').on('click', '#editFirstName', function() {
        $(this).addClass('dn');
        $('#editFirstNameFinish').removeClass('dn');
        //$('#nickname').val('');
        $('#firstname').focus();
    });

    $('body').on('click', '#editFirstNameFinish', function() {
        var obj = $(this);
        obj.startLoading();
        var val = $('#firstname').val();
        if (val !== '' && val.length >= 5 && val.length <= 40) {
            var url = site_url + 'players/ajaxupdateprofile';
            $.post(url, {'firstName': val}, function(data) {
                obj.addClass('dn');
                $('#editFirstName').removeClass('dn');
            });
        }
        ;
        obj.stopLoading();
    });
    $('body').on('click', '#editLastName', function() {
        $(this).addClass('dn');
        $('#editLastNameFinish').removeClass('dn');
        //$('#nickname').val('');
        $('#lastname').focus();
    });

    $('body').on('click', '#editLastNameFinish', function() {
        var obj = $(this);
        obj.startLoading();
        var val = $('#lastname').val();
        if (val !== '' && val.length >= 5 && val.length <= 40) {
            var url = site_url + 'players/ajaxupdateprofile';
            $.post(url, {'lastName': val}, function(data) {
                obj.addClass('dn');
                $('#editLastName').removeClass('dn');
            });
        }
        ;
        obj.stopLoading();
    });

    $('body').on('click', '#editDisplayName', function() {
        $(this).addClass('dn');
        $('#editDisplayNameFinish').removeClass('dn');
        //$('#nickname').val('');
        $('#displayName').focus();
    });

    $('body').on('click', '#editDisplayNameFinish', function() {
        var obj = $(this);
        obj.startLoading();
        var val = $('#displayName').val();
        if (val !== '' && val.length >= 5 && val.length <= 40) {
            var url = site_url + 'players/ajaxupdateprofile';
            $.post(url, {'displayName': val}, function(data) {
                obj.addClass('dn');
                $('#editDisplayName').removeClass('dn');
            });
        }
        ;
        obj.stopLoading();
    });

    $('body').on('click', '#editPassword', function() {
        $(this).addClass('dn');
        $('#editPasswordFinish').removeClass('dn');
        $('#repeatPasswordBlock').removeClass('dn');
        $('#password').val('');
        $('#password').focus();
    });

    $('body').on('click', '#editPasswordFinish', function() {
        var obj = $(this);
        obj.startLoading();
        var val = $('#password').val();
        if (val !== '' && val.length >= 8 && val.length <= 40 && val === $('#repeatpassword').val()) {
            var url = site_url + 'players/ajaxupdateprofile';
            $.post(url, {'pass': val}, function(data) {
                obj.addClass('dn');
                $('#password').val('Password');
                $('#repeatpassword').val('');
                $('#editPassword').removeClass('dn');
                $('#repeatPasswordBlock').addClass('dn');
            });
        }
        ;
        obj.stopLoading();
    });

    $('body').on('click', '#editCountry', function() {
        $(this).addClass('dn');
        $('#editCountryFinish').removeClass('dn');
        $('#countrySelect').removeClass('dn');
        $('#country').addClass('dn');
    });

    $('body').on('click', '#editCountryFinish', function() {
        var obj = $(this);
        obj.startLoading();
        var val = $('#countrySelect').val();
        if (val !== '' && val !== 0) {
            var url = site_url + 'players/ajaxupdateprofile';
            $.post(url, {'country': val}, function(data) {
                obj.addClass('dn');
                $('#editCountry').removeClass('dn');
                $('#countrySelect').addClass('dn');
                $('#country').val(data.country);
                $('#country').removeClass('dn');
            });
        }
        ;
        obj.stopLoading();
    });

    $('body').on('click', '#editDOB', function() {
        $(this).addClass('dn');
        $('#editDOBFinish').removeClass('dn');
        $('.dobBlock').removeClass('dn');
        $('#dob').addClass('dn');
    });

    $('body').on('click', '#editDOBFinish', function() {
        var obj = $(this);
        obj.startLoading();
        var day = $('#dobDay').val(), month = $('#dobMonth').val(), year = $('#dobYear').val(), url = site_url + 'players/ajaxupdateprofile';
        if (day !== 0 && month !== 0 && year !== 0) {
            $.post(url, {'day': day, 'month': month, 'year': year}, function(data) {
                obj.addClass('dn');
                $('#editDOB').removeClass('dn');
                $('.dobBlock').addClass('dn');
                $('#dob').val(data.dob);
                $('#dob').removeClass('dn');
            });
        }
        ;
        obj.stopLoading();
    });

    if ($('#F_editTimezone').length) {
        $('#F_editTimezone').dropkick({
            theme: 'lightWide',
            change: function(value, label) {
                $.post(site_url + 'players/ajaxupdateprofile', {timezone: value}, function(data) {
                });
            }
        });
    }
    ;

    $('body').on('change', '#F_editDst', function() {
        dst = 0;
        if ($('#F_editDst').is(':checked')) {
            dst = 1;
        }
        ;
        $.post(site_url + 'players/ajaxupdateprofile', {
            'daylight': 1,
            'dst': dst
        }, function(data) {
        });
    });

    $('body').on('mouseover', '.itemPost', function() {
        $(this).find('.itemMoreActions').removeClass('dn');
    });

    $('body').on('mouseout', '.itemPost', function() {
        $(this).find('.itemMoreActions').addClass('dn');
    });

    $('body').on('click', '.itemMoreActions', function() {
        $(this).siblings('.itemMoreActionsBlock').toggleClass('dn');
    });

    $('body').on('mouseleave', '.itemMoreActionsBlock', function() {
        $(this).addClass('dn');
    });

    $('body').on('click', '.showMoreMutual', function(e) {
        e.preventDefault();
        var p = $(this).attr('rel');
        $('.mutualFriendsShort.p_' + p).addClass('dn');
        $('.mutualFriendsLong.p_' + p).removeClass('dn');
    });
    $('body').on('click', '.showLessMutual', function(e) {
        e.preventDefault();
        var p = $(this).attr('rel');
        $('.mutualFriendsLong.p_' + p).addClass('dn');
        $('.mutualFriendsShort.p_' + p).removeClass('dn');
    });

    $('body').on('click', '.F_saveReview', function(e) {
        e.preventDefault();
        $(this).closest('form').submit();
    });
    $('body').on('click', '.F_savePublishReview', function(e) {
        e.preventDefault();
        $('#published').val('1');
        $(this).closest('form').submit();
    });

    $('body').on('click', '.addEndTime', function(e) {
        e.preventDefault();
        $('.endTime').removeClass('dn');
        $(this).remove();
    });

    $('body').on('click', '.addRecurring', function(e) {
        e.preventDefault();
        $('.recurring').removeClass('dn');
        $(this).remove();
    });

    $('body').on('click', '.showInviteFriends', function(e) {
        e.preventDefault();
        $('.inviteFriends').removeClass('dnn');
        $('.JscrollPane').jScrollPane({showArrows: true});
    });

    $('body').on('change', 'select#eventRecurringType', function(e) {
        var max = $('#eventRecurringType option:selected').attr('rel'), str = '<option value="0">' + lang['number_of_events'] + '</option>';
        if (max.length > 0) {
            $('#eventRecurringTimes').html('');
            for (var i = 1; i <= max; i++) {
                str += '<option value="' + i + '">' + i + '</option>';
            }
            ;
            $('#eventRecurringTimes').html(str);
            $('#eventRecurringTimes').jqReloadSelect();
        }
        ;
    });

    $('.jqTransSelect').jqTransSelect();

    $('body').on('change', '#difShipping', function() {
        if ($(this).is(':checked')) {
            $('.differentShippingAddress').removeClass('dn');
        }
        else {
            $('.differentShippingAddress').addClass('dn');
        }
        ;
    });

    $('body').on('click', '.F_addToCart', function(e) {
        e.preventDefault();
        var obj = $(this);
        $(obj).startLoading();
        var data = $(obj).data('opt'), id = data.ID, qty = data.qty, img = $('.F_product_' + id).clone().prependTo($('.F_product_' + id)), objTo = $('.F_cartBrief').position();
        $(img).css({position: 'absolute'}).animate({
            right: objTo.right,
            top: objTo.top,
            width: 0,
            height: 0
        }, 600, function() {
            $(this).remove();
            $('.F_cartBrief').fadeOut().removeClass('dn');
            $.post(site_url + 'shop/addtocart', {'id': id, 'qty': qty}, function(data) {
                if (data.result === true) {
                    $('.F_cartBrief').html(data.content).fadeIn();
                }
                ;
                $(obj).stopLoading();
            });
        });
    });

    $('body').on('click', '.F_confirmCart', function(e) {
        e.preventDefault();
        var obj = $(this);
        $(obj).startLoading();
        $(obj).html("Completing Order...");
        $.post(site_url + 'shop/confirmcart', $('.F_cartForm').serialize(), function(data) {
            if (data.result === true) {
                $(obj).html("Order Complete");
                window.location.href = site_url + 'shop/order-complete';
            }
            ;
            if (data.error !== '') {
                $('.errorContainer').html(data.error).removeClass('dn');
            }
            ;
            $(obj).stopLoading();
        });
    });

    $('body').on('click', '.F_removeFromCart', function(e) {
        e.preventDefault();
        deleteElement = $(this);
        var data = $(deleteElement).data('opt'), id = data.ID;
        promptDelete('deleteCartItem(' + id + ')', lang['delete_cart_item']);
    });

    $('body').on('click', '.F_searchPlayers', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var q = $('.F_searchPlayersInput').val(), url = site_url + 'players/ajaxsearchplayers';
        $.post(url, {'q': q}, function(data) {
            $('.F_searchPlayersList tbody').html(data);
            if (data === '') {
                $('.F_zeroPlayersFound').removeClass('dn');
            }
            else {
                $('.F_zeroPlayersFound').addClass('dn');
            }
            ;
            loadCheckboxes();
            obj.stopLoading();
        });
    });

    $('body').on('click', '.F_searchGames', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var q = $('.F_searchGamesInput').val(), url = site_url + 'games/ajaxsearchgames';
        $.post(url, {'q': q}, function(data) {
            $('.F_searchGamesList tbody').html(data);
            if (data === '') {
                $('.F_zeroGamesFound').removeClass('dn');
            }
            else {
                $('.F_zeroGamesFound').addClass('dn');
            }
            ;
            loadCheckboxes();
            obj.stopLoading();
        });
    });

    $('body').on('click', '.F_searchGroups', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var q = $('.F_searchGroupsInput').val(), url = site_url + 'groups/ajaxsearchgroups';
        $.post(url, {'q': q}, function(data) {
            $('.F_searchGroupsList tbody').html(data);
            if (data === '') {
                $('.F_zeroGroupsFound').removeClass('dn');
            }
            else {
                $('.F_zeroGroupsFound').addClass('dn');
            }
            ;
            loadFancybox();
            obj.stopLoading();
        });
    });

    $('body').on('click', '.F_addToFriends', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var q = $('.F_searchPlayersInput').val(), url = site_url + 'players/ajaxaddfriends', ids = '';
        $('.F_addFriend:checked').each(function(index) {
            if (index !== 0) {
                ids += ',' + $(this).val();
            }
            else {
                ids += $(this).val();
            }
            ;
        });
        if (ids !== '') {
            $.post(url, {'ids': ids}, function(data) {
                $('.F_addFriend:checked').each(function(index) {
                    $('.F_player_' + $(this).val()).remove();
                });
                obj.stopLoading();
            });
        } else {
            obj.stopLoading();
        }
        ;
        loadCheckboxes();
    });

    $('body').on('click', '.F_addToGames', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var q = $('.F_searchGamesInput').val(), url = site_url + 'players/ajaxaddgames', ids = '';
        $('.F_addGame:checked').each(function(index) {
            if (index !== 0) {
                ids += ',' + $(this).val();
            }
            else {
                ids += $(this).val();
            }
            ;
        });
        if (ids !== '') {
            $.post(url, {'ids': ids}, function(data) {
                $('.F_addGame:checked').each(function(index) {
                    $('.F_game_' + $(this).val()).remove();
                });
                obj.stopLoading();
            });
        } else {
            obj.stopLoading();
        }
        ;
    });

    $('body').on('click', '.F_addToGroups', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var q = $('.F_searchGroupsInput').val(), url = site_url + 'players/ajaxaddgroups', ids = '';
        $('#F_addGroup:checked').each(function(index) {
            if (index !== 0) {
                ids += ',' + $(this).val();
            }
            else {
                ids += $(this).val();
            }
            ;
        });

        if (ids !== '') {
            $.post(url, {'ids': ids}, function(data) {
                $('#F_addGroup:checked').each(function(index) {
                    $('.F_group_' + $(this).val()).remove();
                });
                obj.stopLoading();
            });
        } else {
            obj.stopLoading();
        }
        ;
    });

    $('body').on('click', '.F_loginOpenInviter', function() {
        var obj = $(this);
        obj.startLoading();
        $.post(site_url + 'players/ajaxopeninviter', $('.F_openInviterForm').serialize(), function(data) {
            $('.F_openInviterBox').html(data);
            obj.stopLoading();
        });
    });

    $('body').on('click', '.F_sendSiteInvitations', function() {
        var obj = $(this);
        obj.startLoading();
        var emails = '';
        $('.F_inviteeEmail:checked').each(function(index) {
            if (index !== 0) {
                emails += ',' + $('#F_email_' + $(this).val()).val();
            }
            else {
                emails += $('#F_email_' + $(this).val()).val();
            }
            ;
        });

        $.post(site_url + 'players/ajaxsiteinvite', {'emails': emails}, function(data) {
            $('.F_openInviterBox').html(data);
            obj.stopLoading();
        });
    });

    $('body').on('click', '.F_inviterSelectAll', function() {
        var obj = $(this);
        $('.F_inviteeEmail').checkBox('changeCheckStatus', true);
    });

    $('body').on('click', '.F_inviterSelectNone', function() {
        var obj = $(this);
        $('.F_inviteeEmail').checkBox('changeCheckStatus', false);
    });
    
/* Moved to MainHelper::MakeValidation
    $('body').on('submit', '.F_FTUupdateProfile', function(e) {
        var $form = $(".F_FTUupdateProfile");
        $form.validate({
            rules: {
                firstName: {
                    required: true,
                    maxlength: 80
                },
                lastName: {
                    required: true,
                    maxlength: 80
                },
                displayName: {
                    minlength: 2,
                    maxlength: 40
                },
                city: {
                    required: true,
                    maxlength: 80
                },
                country: {
                    required: true
                },
                timezone: {
                    required: true,
                    min: 1
                },
                day: {
                    required: true,
                    min: 1,
                    max: 31
                },
                month: {
                    required: true,
                    min: 1,
                    max: 12
                },
                year: {
                    required: true,
                    min: 1900
                }
            },
            messages: {
                firstName: {
                    required: lang['enter_first_name'],
                    maxlength: lang['max_eighty_char']
                },
                lastName: {
                    required: lang['enter_last_name'],
                    maxlength: lang['max_eighty_char']
                },
                displayName: {
                    minlength: lang['min_two_char'],
                    maxlength: lang['max_forty_char']
                },
                city: {
                    required: lang['enter_city'],
                    maxlength: lang['max_eighty_char']
                },
                country: {
                    required: lang['select_country']
                },
                timezone: {
                    required: lang['select_timezone'],
                    min: lang['select_timezone']
                },
                day: {
                    required: lang['select_birth_day'],
                    min: lang['select_birth_day']
                },
                month: {
                    required: lang['select_birth_mon'],
                    min: lang['select_birth_mon']
                },
                year: {
                    required: lang['select_birth_year'],
                    min: lang['select_birth_year']
                }
            }
        });
        if ($form.valid()) {
            return true;
        } else {
            return false;
        }
        ;
    });
*/

    $('body').on('submit', '#F_eventCreateForm', function(e) {
        var $form = $(this);
        $form.validate({
            rules: {
                eventHeadline: {
                    required: true,
                    minlength: 3,
                    maxlength: 80
                },
                eventType: {
                    required: true
                },
                eventDate: {
                    required: true
                },
                eventTime: {
                    required: true,
                    min: 0,
                    max: 1410
                }
            }
        });
        if ($form.valid()) {
            return true;
        } else {
            return false;
        }
        ;
    });
    $('body').on('submit', '#F_eventEditForm', function(e) {
        var $form = $(this);
        $form.validate({
            rules: {
                eventHeadline: {
                    required: true,
                    minlength: 3,
                    maxlength: 80
                },
                eventType: {
                    required: true
                },
                eventDate: {
                    required: true
                },
                eventTime: {
                    required: true,
                    min: 0,
                    max: 1410
                },
                eventEndDate: {
                    required: true
                },
                eventEndTime: {
                    required: true,
                    min: 0,
                    max: 1410
                }
            }
        });
        if ($form.valid()) {
            return true;
        } else {
            return false;
        }
        ;
    });

    $('body').on('click', '.F_closeFancybox', function(e) {
        e.preventDefault();
        $.fancybox.close();
    });

    $('body').on('click', '.F_packageBuy', function(e) {
        e.preventDefault();
        var obj = $(this);
        $(obj).startLoading();
        var data = $(obj).data('opt');
        $.post(site_url + 'shop/confirm-membership', {'id': data.id}, function(data) {
            if (data.result === true) {
                $.fancybox.close();
                window.location.href = site_url + 'shop/order-complete';
            }
            ;
            $(obj).stopLoading();
        });
    });

    $('body').on('keyup', '#amountPD', function(e) {
        var convRate = 10, obj = $(this), maximum = obj.attr('rel'), amount = parseInt(obj.val(), 10), $form = $('#F_creditConverterForm');
        $form.validate({
            rules: {
                amountPD: {
                    required: true,
                    digits: true,
                    min: 0,
                    max: maximum
                }
            },
            errorPlacement: function(error, element) {
            }
        });
        if ($form.valid()) {
            $('#convertedPC').removeClass('fcr');
            $('#convertedPC').addClass('fcgr');
            $('#convertedPC').text(amount * convRate);
        } else {
            $('#convertedPC').removeClass('fcgr');
            $('#convertedPC').addClass('fcr');
            $('#convertedPC').text("Error");
        }
        ;
    });

    $('body').on('click', '.F_convertPD', function(e) {
        e.preventDefault();
        var obj = $(this);
        $(obj).startLoading();
        var maximum = $('#amountPD').attr('rel'), amount = $('#amountPD').val(), $form = $('#F_creditConverterForm');
        $form.validate({
            rules: {
                amountPD: {
                    required: true,
                    digits: true,
                    min: 0,
                    max: maximum
                }
            }
        });
        if ($form.valid()) {
            if (parseInt(amount, 10) > 0 && parseInt(amount, 10) <= maximum) {
                $.post(site_url + 'shop/ajaxconvertpd', {'pd': amount}, function(data) {
                    if (data.result === true) {
                        window.location.href = window.location.href;
                    }
                    else {
                        $('#convertedPC').removeClass('fcgr');
                        $('#convertedPC').addClass('fcr');
                        $('#convertedPC').text("There was an error converting credits");
                        $(obj).stopLoading();
                    }
                    ;
                });
            }
            ;
        } else {
            $('#convertedPC').removeClass('fcgr');
            $('#convertedPC').addClass('fcr');
            $('#convertedPC').text("Error");
            $(obj).stopLoading();
        }
        ;
    });

    $('body').on('click', '.F_loadFTUStep', function(e) {
        e.preventDefault();
        var obj = $(this), step = obj.attr('rel'), url = site_url + 'players/ajaxgetftustep';
        obj.startLoading();
        $.post(url, {'step': step}, function(data) {
            $('div.F_FTUwrapper').replaceWith(data);
            loadHelpBubbles();
            loadCheckboxes();
            loadFancybox();
            $('.jqTransSelect').jqTransSelect();
            if ($('#uploadProfilePhoto').length) {
                createUploader('uploadProfilePhoto', lang['upload_image'], 'players/ajaxuploadphoto');
            }
            ;
            if ($('.dropkick_lightWide').length) {
                $('.dropkick_lightWide').dropkick({theme: 'lightWide'});
            }
            ;
            if ($('.dropkick_lightNarrow').length) {
                $('.dropkick_lightNarrow').dropkick({theme: 'lightNarrow'});
            }
            ;
        });
    });

    loadHelpBubbles();

    $('body').on('click', '.F_showInviteByEmail', function(e) {
        e.preventDefault();
        $('.F_openInviterBox').addClass('dn');
        $('.F_inviteByEmail').removeClass('dn');
    });

    $('body').on('click', '.F_showInviter', function(e) {
        e.preventDefault();
        $('.F_openInviterBox').removeClass('dn');
        $('.F_inviteByEmail').addClass('dn');
    });

    $('body').on('click', '.F_sendInvitationsByEmail', function(e) {
        e.preventDefault();
        var form = $('#F_simpleInviter'), url = site_url + 'players/ajaxsimpleinvite';
        $.post(url, form.serialize(), function(data) {
            if (data !== null) {
                var count = parseInt($('#F_fieldsCount').val(), 10);
                $('.F_simpleInviterOutput').html('');
                for (var i = count; i >= 1; i--) {
                    var elem = $('.inviteByEmail_' + i);
                    if (data.results[i - 1][1]) {
                        if (elem.length) {
                            $('.F_simpleInviterOutput').prepend(lang['invitation_sent'] + ' ' + $('.inviteByEmail_' + i).val() + '<br />');
                            if (i !== 1) {
                                elem.remove();
                            }
                            ;
                        }
                        ;
                    } else {
                        $('.F_simpleInviterOutput').prepend($('.inviteByEmail_' + i).val() + ' ' + lang['invitation_notsent'] + '<br />');
                        if (i !== 1) {
                            elem.remove();
                        }
                        ;
                    }
                    ;
                }
                ;
                $('.inviteByEmail_1').val('');
                $('#F_fieldsCount').val(1);
                if ($('.F_simpleInviterOutput').html() !== '') {
                    $('.F_simpleInviterOutput').removeClass('dn');
                }
                else {
                    $('.F_simpleInviterOutput').addClass('dn');
                }
                ;
            }
            ;
        });
    });

    $('body').on('click', '.F_addInviteByEmail', function(e) {
        e.preventDefault();
        var count = parseInt($('#F_fieldsCount').val(), 10) + 1, field = '<div class="fl"><input class="text_input thTextbox inviteByEmail_' + count + ' mb0 mt5" type="text" name="inviteByEmail_' + count + '" value=""/><label for="inviteByEmail_' + count + '" class="errInviteByEmail_' + count + '" class="dn db"></label></div>';
        $(this).before(field);
        $('#F_fieldsCount').val(count);
    });

    if ($('.share_wall').length) {
        $('.share_wall').fancybox({
            'closeClick': false,
            'openEffect': 'elastic',
            'closeEffect': 'elastic',
            'openSpeed': 600,
            'closeSpeed': 200,
            'arrows': false,
            'type': 'ajax',
            'ajax': {type: 'post', url: site_url + 'ajaxshareonwall',
                data: {
                    otype: $('.share_wall').data('opt').otype,
                    oid: $('.share_wall').data('opt').oid,
                    olang: $('.share_wall').data('opt').olang
                }
            },
            'href': site_url + 'ajaxshareonwall',
            'helpers': {
                'title': null,
                'overlay': {
                    'showEarly': true,
                    'closeClick': false,
                    'css': {
                        'background': 'rgba(0, 0, 0, 0.58)'
                    }
                }
            },
            'afterShow': function() {
                $('.ta').elastic().trigger('update');
            }
        });
    }
    ;

    if ($('.share_group').length) {
        $('.share_group').fancybox({
            'closeClick': false,
            'openEffect': 'elastic',
            'closeEffect': 'elastic',
            'openSpeed': 600,
            'closeSpeed': 200,
            'arrows': false,
            'type': 'ajax',
            'ajax': {type: 'post', url: site_url + 'ajaxshareongroupwall', data:
                        {
                            otype: $('.share_wall').data('opt').otype,
                            oid: $('.share_wall').data('opt').oid,
                            olang: $('.share_wall').data('opt').olang
                        }},
            'href': site_url + 'ajaxshareongroupwall',
            'helpers': {
                'title': null,
                'overlay': {
                    'showEarly': true,
                    'closeClick': false,
                    'css': {
                        'background': 'rgba(0, 0, 0, 0.58)'
                    }
                }
            },
            'afterLoad': function() {
                $('.ta').elastic().trigger('update');
                $("#tags").tokenInput(site_url + 'player/ajaxfindplayergroups', {
                    searchDelay: 1000,
                    minChars: 2,
                    tokenDelimiter: "|",
                    theme: "gametek",
                    deleteText: "",
                    resultsFormatter: function(item) {
                        return "<li>" + "<img src='" + item.img + "' height='25px' width='25px' />" + "<div style='display: inline-block; padding-left: 10px;'><div class='full_name'>" + item.name + "</div></div></li>";
                    },
                    beforeAdd: function(item) {
                        $("#tags").tokenInput("clear");
                    }
                });
            }
        });
    }
    ;

    if ($('.share_message').length) {
        $('.share_message').fancybox({
            'closeClick': false,
            'openEffect': 'elastic',
            'closeEffect': 'elastic',
            'openSpeed': 600,
            'closeSpeed': 200,
            'arrows': false,
            'type': 'ajax',
            'ajax': {type: 'post', url: site_url + 'ajaxshowsharemessage', data:
                        {
                            shareOwnerType: $('.share_message').data('opt').otype,
                            shareOwnerId: $('.share_message').data('opt').oid,
                            olang: $('.share_message').data('opt').olang
                        }},
            'href': site_url + 'ajaxshowsharemessage',
            'helpers': {
                'title': null,
                'overlay': {
                    'showEarly': true,
                    'closeClick': false,
                    'css': {
                        'background': 'rgba(0, 0, 0, 0.58)'
                    }
                }
            },
            'afterLoad': function() {
                messageInit('', '');
            }
        });
    }
    ;

    $('body').on('click', '.F_shareOnWall', function(e) {
        e.preventDefault();
        var obj = $(this), dt = $(obj).data('opt'), p = $('#sharePost').val();
        $.post(site_url + 'ajaxsetpost', {
            type: dt.type,
            id: dt.id,
            post: p,
            otype: dt.otype,
            olang: dt.olang,
            oid: dt.oid
        }, function(data) {
            $.fancybox.close();
        });
    });

    $('body').on('click', '.F_shareOnGroupWall', function(e) {
        e.preventDefault();
        var obj = $(this), dt = $(obj).data('opt'), p = $('#sharePost').val();
        $.post(site_url + 'ajaxsetpost', {type: dt.type, id: $('.F_gid').val(), post: p, otype: dt.otype, oid: dt.oid, olang: dt.olang}, function(data) {
            $.fancybox.close();
        });
    });

    $('body').on('click', '.F_shareMessage', function(e) {
        e.preventDefault();
        var obj = $(this), dt = $(obj).data('opt'), p = $('#sharePost').val();
        $(obj).startLoading();
        var $selector = $("#tags").tokenInput("get");
        if ($selector.length > 0) {
            var recipients = {};
            $.each($selector, function(i, v) {
                recipients[i] = v.id;
            });
        }
        ;
        $.post(site_url + 'ajaxsharemessage', {otype: dt.otype, oid: dt.oid, recipients: recipients, olang: dt.olang, post: p}, function(data) {
            $.fancybox.close();
            $(obj).stopLoading();
        });
    });

    $('body').on('click', '.F_cancelNextMembership', function(e) {
        e.preventDefault();
        var obj = $(this);
        $(obj).startLoading();
        $.post(site_url + 'shop/membership/cancel-queue', {}, function(data) {
            if (data.result === true) {
                location.reload();
            }
            ;
        });
    });
    if ($('#regForm').length) {
        $('#regForm').validate({
            rules: {
                email: {
                    email: true,
                    required: true,
                    maxlength: 80,
                    remote: {
                        url: site_url + 'players/validatemail',
                        data: {
                            email: function() {
                                return $('#register-email').val();
                            }
                        }
                    }
                },
                password: {
                    required: true,
                    minlength: 8,
                    maxlength: 80
                },
                confirmPassword: {
                    required: true,
                    equalTo: '#password'
                },
                nickName: {
                    required: true,
                    minlength: 5,
                    maxlength: 40
                },
                terms: {
                    required: true
                }
            },
            messages: {
                email: {
                    required: lang['enter_email'],
                    email: lang['valid_email'],
                    remote: lang['exists_email']
                },
                password: {
                    required: lang['enter_pass'],
                    minlength: lang['min_eight_char']
                },
                confirmPassword: {
                    required: lang['confirm_pass'],
                    equalTo: lang['pass_nomatch']
                },
                nickName: {
                    required: lang['enter_nick'],
                    minlength: lang['min_five_char']
                },
                terms: {
                    required: lang['accept_terms']
                }
            }
        });
    }

    if ($('#editForm').length) {
        $('#editForm').validate({
            rules: {
                firstName: {
                    required: true,
                    maxlength: 80
                },
                lastName: {
                    required: true,
                    maxlength: 80
                },
                nickname: {
                    required: true,
                    minlength: 5,
                    maxlength: 40
                },
                displayName: {
                    required: false,
                    minlength: 2,
                    maxlength: 40
                },
                password: {
                    required: false,
                    minlength: 8,
                    maxlength: 80
                },
                confirmPassword: {
                    required: false,
                    equalTo: '#password'
                },
                day: {
                    required: true,
                    min: 1
                },
                month: {
                    required: true,
                    min: 1
                },
                year: {
                    required: true,
                    min: 1
                },
                city: {
                    required: true,
                    maxlength: 80
                },
                country: {
                    required: true
                            //min: 1
                }
            },
            messages: {
                firstName: {
                    required: lang['enter_first_name'],
                    maxlength: lang['max_eighty_char']
                },
                lastName: {
                    required: lang['enter_last_name'],
                    maxlength: lang['max_eighty_char']
                },
                nickname: {
                    required: lang['enter_nick'],
                    minlength: lang['min_five_char'],
                    maxlength: lang['max_forty_char']
                },
                displayName: {
                    minlength: lang['min_two_char'],
                    maxlength: lang['max_forty_char']
                },
                password: {
                    minlength: lang['min_eight_char'],
                    maxlength: lang['max_eighty_char']
                },
                confirmPassword: {
                    equalTo: lang['pass_nomatch']
                },
                day: {
                    required: lang['select_birth_day'],
                    min: lang['select_birth_day']
                },
                month: {
                    required: lang['select_birth_mon'],
                    min: lang['select_birth_mon']
                },
                year: {
                    required: lang['select_birth_year'],
                    min: lang['select_birth_year']
                },
                city: {
                    required: lang['enter_city'],
                    maxlength: lang['max_eighty_char']
                },
                country: {
                    required: lang['select_country']
                }
            }
        });
    }
    ;
    if ($('#regFormPage').length) {
        $('#regFormPage').validate({
            rules: {
                email: {
                    email: true,
                    required: true,
                    maxlength: 80,
                    remote: {
                        url: site_url + 'players/validatemail',
                        data: {
                            email: function() {
                                return $('#email').val();
                            }
                        }
                    }
                },
                password: {
                    required: true,
                    minlength: 8,
                    maxlength: 80
                },
                confirmPassword: {
                    required: true,
                    equalTo: '#password'
                },
                nickName: {
                    required: true,
                    minlength: 5,
                    maxlength: 40
                },
                terms: {
                    required: true
                }
            },
            messages: {
                email: {
                    required: lang['enter_email'],
                    email: lang['valid_email'],
                    remote: lang['exists_email']
                },
                password: {
                    required: lang['enter_pass'],
                    minlength: lang['min_eight_char']
                },
                confirmPassword: {
                    required: lang['confirm_pass'],
                    equalTo: lang['pass_nomatch']
                },
                nickName: {
                    required: lang['enter_nick'],
                    minlength: lang['min_five_char']
                },
                terms: {
                    required: lang['accept_terms']
                }
            }
        });
    }
    ;

    $('.F_showRefCodeField').change(function() {
        if ($(this).is(':checked')) {
            $('.refferalCode').removeClass('dn');
        }
        else {
            $('.refferalCode').addClass('dn');
        }
        ;
    });

    if ($('#recFormPage').length) {
        $('#recFormPage').validate({
            rules: {
                email: {
                    required: true,
                    email: true
                },
                name: {
                    required: true
                },
                age: {
                    required: true,
                    digits: true
                },
                links: {
                    required: true
                },
                description: {
                    required: true
                }
            }
        });
    }
    ;

    if ($("#roster").length) {
        $("#roster #add").click(function() {
            $("#roster #loader").toggle();
            $('#roster #fail').hide();
            $.post(site_url + "esport/ajaxsearchplayer", {email: $("#roster #email").val(), }, function(data) {
                var json = $.parseJSON(data);
                if (json.found === true) {
                    $('#roster #list').append("<tr><td>" + json.name + "</td><td>" + json.email + "</td><td><img id='" + json.email + "' class='delete_icon cp' /></td></tr>");
                    $('#editForm').append("<input type='hidden' name='roster[]' class='roster' value='" + json.email + "' />");
                } else if (json.found === false) {
                    $('#roster #email').val('player not found');
                }
                ;
                $("#roster #loader").toggle();
            });
            $("#roster #email").val('');
        });
        $(document.body).on("click", "#roster #list img", function() {
            $(this).parent().parent().remove();
            $("input[value='" + $(this).attr('id') + "']").attr('name', 'delete[]');
        });
        $("#roster #email").focus(function() {
            $(this).val('');
        });
    }
    ;

    $(elementById('search')).tokenInput(site_url + 'livesearch', {
        method: 'GET',
        queryParam: 'q',
        searchDelay: 300,
        minChars: 3,
        hintText: lang['search_hint'],
        noResultsText: lang['search_noresults'],
        searchingText: lang['search_searching'],
        deleteText: '',
        theme: 'globalsearch',
        resultsLimit: consts.search_limit,
        tokenDelimiter: '|',
        preventDuplicates: true,
        placeholder: lang['search_placeholder'],
        resultsFormatter: function(item) {
            return '<li class="result"><h3>' + item.name + '</h3><h4>' + item.type + '</h4></li>';
        },
        onAdd: function(item) {
            $(elementById('search')).tokenInput('clear');
            window.location.href = item.url;
        },
//        onResult: function(result) {
//            errLog(result);
//            return result;
//        }
    });

    $(elementById('token-input-search')).on({
        focus: function(e) {
            eatEvent(e);
            this.setAttribute('placeholder', '');
        },
        blur: function(e) {
            eatEvent(e);
            this.setAttribute('placeholder', lang['search_placeholder']);
        }
    });

    $(document).on("click", ".action_translate", function(e) {
        eatEvent(e);
        var denne = this;
        window.location.href = site_url + 'translate/' + denne.getAttribute('data-selec') + '/' + denne.getAttribute('rel');
    });

    $(elementById('T_saveButton')).on('click', function(e) {
        eatEvent(e);
        var origDescID = CKEDITOR.instances.T_origDesc, newDescID = CKEDITOR.instances.T_transDesc, transObj = {
            engName: elementById('T_origName').getAttribute('placeholder'),
            engDesc: (origDescID === null || origDescID === consts["undefined"]) ? '' : origDescID.getData(),
            newName: elementById('T_transName').value,
            newDesc: (newDescID === null || newDescID === consts["undefined"]) ? '' : newDescID.getData(),
            transLang: elementById('T_language').value,
        };
        $.get(site_url + 'translate/save', transObj, function(data) {
            if (checkData(data) && (JSON.parse(data) === "success")) {
                window.location.href = window.location.href;
            };
        });
    });

    $(elementById('newsOrigin')).on('change', function() {
        $.post(site_url + 'admin/news/ajaxgetnewslocale', {
            news_id: elementById('newsID').value,
            lang_id: elementById('newsOrigin').value
        }, function(data) {
            if(data.result) {
                intro = CKEDITOR.instances.messageIntro, text = CKEDITOR.instances.messageText;
                elementById('newsHeadline').value = data.result.Headline;
                intro.setData(data.result.IntroText);
                text.setData(data.result.NewsText);
            };
        });
    });

    $("body").on("click", ".choose_news_lang", function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var editUrl = $('#editUrl').val(), locale_id = $('#languages').val();
        var Url = editUrl + '/' + locale_id;
        $.fancybox.close();
        location = Url;
        obj.stopLoading();
    });

    if ($('.bg_choser').length) {
        $('input[name="bg_active"]:radio').change(function() {
            $('.bg_container').hide();
            $('.container_' + $(this).val()).show();
        });

        $('.cp-basic').ColorPicker({
            onSubmit: function(hsb, hex, rgb, el) {
                $(el).val('#' + hex);
                $(el).ColorPickerHide();
                $(el).siblings('.color_preview').css('background-color', '#' + hex);
            }
        })
                .bind('keyup', function() {
                    $(this).ColorPickerSetColor(this.value);
                });
    }
    ;

    $('body').on('click', '.adddownload_group', function(e) {
        e.preventDefault();
        var obj = $(this);
        obj.startLoading();
        var $form = $("#adddownload_group_form");
        $form.validate({
            rules: {
                download_filename: {
                    required: true,
                    minlength: 3,
                    maxlength: 40
                },
                download_filesize: {
                    required: true,
                    digits: true,
                    min: 1
                },
                download_fileurl: {
                    required: true,
                    url: true
                }
            }
        });

        if ($form.valid()) {
            $.post(site_url + 'group/savedownload', $('#adddownload_group_form').serialize(), function(data) {
                if (data.result === true) {
                    $.fancybox.close();
                    location.reload();
                }
                ;
                obj.stopLoading();
            });
        } else {
            obj.stopLoading();
        }
        ;
    });

    $('body').on('click', '.addtab_group', function(e) {
        e.preventDefault();
        var obj = $(this);
        $(obj).startLoading();
        var $form = $("#addtab_group_form");
        $form.validate({
            rules: {
                tab_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 15
                }
            }
        });

        if ($form.valid()) {
            $.post(site_url + 'group/savedownloadtab', $('#addtab_group_form').serialize(), function(data) {
                if (data.result === true) {
                    $.fancybox.close();
                    location.reload();
                }
                ;
                $(obj).stopLoading();
            });
        } else {
            $(obj).stopLoading();
        }
        ;
    });

    $('body').on('click', '.delete_group_download', function(e) {
        e.preventDefault();
        $obj = $(this);
        var id = $(this).attr('rel');
        deleteElement = $(this);
        promptDelete('deleteGroupDownload(' + id + ')', lang['delete_download']);
    });

    $('.cp-basic').ColorPicker({
        onSubmit: function(hsb, hex, rgb, el) {
            $(el).val('#' + hex);
            $(el).ColorPickerHide();
            $(el).siblings('.color_preview').css('background-color', '#' + hex);
        }
    })
            .bind('keyup', function() {
                $(this).ColorPickerSetColor(this.value);
            });

    if ($('.bg_choser2').length) {
        $('input[name="bg_active"]:radio').change(function() {
            $('.bg_container').hide();
            $('.container_' + $(this).val()).show();
        });

        $('.cp-basic2').ColorPicker({
            onSubmit: function(hsb, hex, rgb, el) {
                $(el).val('#' + hex);
                $(el).ColorPickerHide();
                $(el).parent().parent().find('.list_item_prefix').css('color', '#' + hex);
                ;
                //$(el).find( "tr td:nth-child(1)" ).find('div').css('background-color', '#' + hex);
                //console.log(e);

            }
        })
                .bind('keyup', function() {
                    $(this).ColorPickerSetColor(this.value);
                });
    };

});
