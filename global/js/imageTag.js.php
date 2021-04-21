<script type="text/javascript">
<?php if(isset($photoPopup) && (TRUE === $photoPopup)): ?>
    var frames = {
        <?php if(!empty($tagsList)) {
            foreach($tagsList as $tag) {
                echo $tag->ID_TAGGED, ' = ', $tag->Frame, ',';
            };
        }; ?>
    };

    $(document).ready(function() {
        $('img', elementById('ug_image_container')).Jcrop({allowSelect: false}, function() { // Initialize jCrop
            window.JcropApi = this;
        });

        $('.ug_prev').on('click', $.fancybox.prev);
        $('.ug_next').on('click', $.fancybox.next);

        $('.ug_full').on('click', function(e) {
            eatEvent(e);
            $('.fancybox-outer').on('mousewheel', function(event) {   // Disable mousewheel in full size view
                eatEvent(event);
            });

            elementById('popupcontainer').style.display = 'none';
            elementById('ug_fullimage_container').style.display = 'block';
            $.fancybox.update();
        });

        $('.ug_preview').on('click', function(e) {
            eatEvent(e);
            elementById('ug_fullimage_container').style.display = 'none';
            elementById('popupcontainer').style.display = 'block';
            $.fancybox.update();
            $('.fancybox-outer').off('mousewheel'); // Return mousewheel to its previous state
        });

        $(elementById('tagList')).on({
            mouseenter : function(e) {
                eatEvent(e);
                var frame = frames[this.getAttribute('rel')];
                if(checkData(frame) && checkData(frame.x)) {
                    window.JcropApi.animateTo([frame.x, frame.y, frame.w, frame.h]);
                };
            },
            mouseleave : function(e) {
                eatEvent(e);
                window.JcropApi.nudge();
            }
        }, 'a');
    });

<?php elseif(isset($photoTag) && (TRUE === $photoTag)): ?>

	var waiting = false, restoreFrame = {}, frames = {
        <?php if(!empty($friendsList)) {
            foreach($friendsList as $friend) {
                if(!empty($friend['ID_TAGGED']) && !empty($friend['Frame'])) {
                    echo $friend['ID_TAGGED'], ' : ', $friend['Frame'], ',';
                };
            };
        }; ?>
    }, friends = {
        <?php if(!empty($taggedList)) {
            foreach($taggedList as $tagged) {
                echo $tagged['ID_TAGGED'], ' : ', $tagged['Frame'], ',';
            };
        }; ?>
    }, data = {
        tag : {
            ownertype : '<?php echo $tagType; ?>',
            idwallitem : <?php echo $item->ID_WALLITEM; ?>,
            idtaggedby : <?php echo $player->ID_PLAYER; ?>,
            tagged : []
        }
    };

	$(document).ready(function() {
		$('img', elementById('ug_image_container')).Jcrop({ // Initiate jCrop
			aspectRatio : 1,
			minSize     : [20, 20],
            onSelect    : function(e) {
                window.JcropApi.setOptions({canDrag: true,canResize: true});
                var coords = e, playerID = $('input:checked', elementById('friendList')).parent().parent().attr('rel');
                if(checkData(playerID)) {
                    frames[playerID] = coords;
                };
            },
		}, function() {
			window.JcropApi = this;
		});

		$('li.individual', elementById('friendList')).on({
            click : function(e) {
                e.stopPropagation();
                var denne = this, checked = denne.checked, parent = denne.parentNode.parentNode.parentNode, boxList = parent.getElementsByTagName('input');
                for(var i = 0, iEnd = boxList.length; i < iEnd; ++i) {
                    boxList[i].checked = false;
                };
                denne.checked = (checked) ? true : false;
                return true;
            },
            change : function(e) {
                eatEvent(e);
                var denne = this, Jcrop = window.JcropApi, sel = Jcrop.ui.selection;
                if(checkData(sel)) {
                    var cont = sel.core.container;
                    Jcrop.setOptions({canDrag: false,canResize: false});
                    Jcrop.animateTo([cont.clientLeft, cont.clientTop, cont.clientWidth, cont.clientHeight]);
                };
                if(denne.checked) {
                    var playerID = denne.parentNode.parentNode.getAttribute('rel'), frame = frames[playerID];
                    if(checkData(frame) && checkData(frame.x)) {
                        Jcrop.setOptions({canDrag: true,canResize: true});
                        Jcrop.animateTo([frame.x, frame.y, frame.w, frame.h]);
                    };
                };
                return true;
            }
        }, 'input');

		$(elementById('tagList')).on({
            mouseenter : function(e) {
                eatEvent(e);
                var friend = friends[this.getAttribute('rel')], Jcrop = window.JcropApi, sel = Jcrop.ui.selection;
                if(checkData(sel)) {
                    restoreFrame = sel.get();
                };
                if(checkData(friend) && checkData(friend.x)) {
                    Jcrop.setOptions({canDrag: false,canResize: false});
                    Jcrop.animateTo([friend.x, friend.y, friend.w, friend.h]);
                };
            },
            mouseleave : function(e) {
                eatEvent(e);
                var playerID = $('input:checked', elementById('friendList')).parent().parent().attr('rel'), frame = frames[playerID], Jcrop = window.JcropApi;
                if(checkData(restoreFrame) && checkData(restoreFrame.x)) {
                    Jcrop.animateTo([restoreFrame.x, restoreFrame.y, restoreFrame.w, restoreFrame.h]);
                } else if(checkData(playerID) && checkData(frame) && checkData(frame.x)) {
                    Jcrop.animateTo([frame.x, frame.y, frame.w, frame.h]);
                };
                Jcrop.setOptions({canDrag: true,canResize: true});
                restoreFrame = {};
            }
        }, 'a');

//        $(elementById('friendList')).on({
//            mouseenter : function(e) {
//                eatEvent(e);
//                var friend = friends[this.getAttribute('rel')], Jcrop = window.JcropApi, sel = Jcrop.ui.selection;
//                if(checkData(sel) && !(checkData(restoreFrame) && checkData(restoreFrame.x))) {
//                    restoreFrame = sel.get();
//                };
//                if(checkData(friend) && checkData(friend.x)) {
//                    Jcrop.setOptions({canDrag: false,canResize: false});
//                    Jcrop.animateTo([friend.x, friend.y, friend.w, friend.h]);
//                };
//            },
//            mouseleave : function(e) {
//                eatEvent(e);
//                var playerID = $('input:checked', elementById('friendList')).parent().parent().attr('rel'), frame = frames[playerID], Jcrop = window.JcropApi;
//                if(checkData(restoreFrame) && checkData(restoreFrame.x)) {
//                    Jcrop.animateTo([restoreFrame.x, restoreFrame.y, restoreFrame.w, restoreFrame.h]);
//                } else if(checkData(playerID) && checkData(frame) && checkData(frame.x)) {
//                    Jcrop.animateTo([frame.x, frame.y, frame.w, frame.h]);
//                };
//                Jcrop.setOptions({canDrag: true,canResize: true});
//                restoreFrame = {};
//            }
//        }, 'li.individual');

        $(elementById('ug_canceltag')).on('click', function(e) {
            eatEvent(e);
            $.fancybox.close();
        });
        $(elementById('ug_savetag')).on('click', function(e) {
            eatEvent(e);
            if(true === waiting) { return; };
            errLog('clicked');
            waiting = true;
            var tagID = '', butID = this, txt = butID.innerHTML, loader = document.createElement('IMG'), keyList = Object.keys(frames), tmpArr = [];
            loader.src = site_url + 'global/img/ajax-loader-small.gif';
            loader.id = 'ug_ajaxLoader';
            loader.style.margin = '1px ' + Math.abs(Math.round((butID.clientWidth/2)-13)) + 'px';
            emptyElement(butID);
            butID.classList.remove('button_auto');
            butID.appendChild(loader);
//            for(var key in frames) {
//                data.tag.tagged.push({id : key, frame : JSON.stringify(frames[key])});
//            };
            for(var i = 0, iEnd = keyList.length, curItem; i < iEnd; ++i) {
                curItem = keyList[i];
                tmpArr.push({id : curItem, frame : JSON.stringify(frames[curItem])});
            };
            data.tag.tagged = tmpArr;
            $.post(site_url+'players/ajaxphototag', data, function(result) {
                waiting = false;
                emptyElement(butID);
                butID.insertAdjacentHTML('beforeend', txt);
                butID.classList.add('button_auto');
                if(checkData(result)) {
                    if(checkData(result.tagnames)) {
                        $.fancybox.close();
                        tagID = elementById('tags');
                        emptyElement(tagID);
                        tagID.insertAdjacentHTML('beforeend', result.tagnames);
                    } else if(checkData(result.error)) { alert('ERROR : ', result.error); }
                    else { alert('ERROR! received weird data : ', result); };
                } else { alert('ERROR : no data received'); };
            });
        });
    });
<?php endif; ?>
</script>