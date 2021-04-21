function getSelectedDate(date) {
	d = date.toISOString().split("T")[0].split("-");
	if(d[2].substr(0, 1) === '0') { d[2] = d[2].substr(1, 1); };
	var day = parseInt(d[2], 10)+1;
	if(d[1].substr(0, 1) === '0') { d[1] = d[1].substr(1, 1); };
	var month = parseInt(d[1], 10), year = parseInt(d[0], 10);
	if(day > 31) {
		day = day - 31;
		month++;
	};
	if(month > 12) {
		month = month - 12;
		year++;
	};
	if(day < 10) { day = "0"+day; };
	if(month < 10) { month = "0"+month; };
	return day+'-'+month+'-'+year;
};

function joinEvent(eid) { $.post(site_url+'event/ajaxjoinevent', { 'eid': eid }, function(data) { if(data.result === true) { $('a.event_id_'+eid).fadeOut(); }; }); };

function scrollToReplyForm() {
	var offset = 20;

	$('html, body').animate({
		scrollTop: $(".replyForm").offset().top + offset
	});
}

$(document).ready(function() {
	if($('textarea.taEl').length) { $('textarea.taEl').elastic(); };
	if($('#add_event_picture').length) { createUploader('add_event_picture', lang['add_picture'], 'event/ajaxuploadphoto/'+$('#add_event_picture').attr('rel')); };
	if($('#change_event_picture').length) { createUploader('change_event_picture', lang['change_picture'], 'event/ajaxuploadphoto/'+$('#change_event_picture').attr('rel')); };
//	$('input#pickTimeFrom').timepicker({});
//	$('input#pickTimeTo').timepicker({});
//	$('#eventDateRange').focus(function() { $('#datePickContainer').slideDown(); });
//	$('#closeDatePickers').click(function() { $('#datePickContainer').slideUp(); });
//	$('input#pickTimeFrom, input#pickTimeTo').change(function(){
//		var startDate = $('#pickFrom').datepicker('getDate');
//		$('#pickFromInp').val(getSelectedDate(startDate));
//		var endDate = $('#pickTo').datepicker('getDate');
//		$('#pickToInp').val(getSelectedDate(endDate));
//		var full = $('#pickFromInp').val()+' '+$('input#pickTimeFrom').val()+' - '+$('#pickToInp').val()+' '+$('input#pickTimeTo').val();
//		$('#eventDateRange').val(full);
//	});
//	$('#datePickContainer #pickFrom, #datePickContainer #pickTo').datepicker({
//		gotoCurrent: true,
//		firstDay: 1,
//		monthNames:[lang['january'],lang['february'],lang['march'],lang['april'],lang['may'],lang['june'],lang['july'],lang['august'],lang['september'],lang['october'],lang['november'],lang['december']],
//		dayNamesMin:[lang['sun'],lang['mon'],lang['tue'],lang['wed'],lang['thu'],lang['fri'],lang['sat']],
//		dateFormat: 'dd-mm-yy',
//		minDate: 0,
//		onSelect: function( selectedDate ) {
//				var pck = this.id === "pickTo" ? "pickFrom" : "pickTo", option = this.id === "pickFrom" ? "minDate" : "maxDate", instance = $( this ).data( "datepicker" ), date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings );
//				$('#'+pck).datepicker( "option", option, date );
//				var startDate = $('#pickFrom').datepicker('getDate');
//				$('#pickFromInp').val(getSelectedDate(startDate));
//				var endDate = $('#pickTo').datepicker('getDate');
//				$('#pickToInp').val(getSelectedDate(endDate));
//				var full = $('#pickFromInp').val()+' '+$('input#pickTimeFrom').val()+' - '+$('#pickToInp').val()+' '+$('input#pickTimeTo').val();
//				$('#eventDateRange').val(full);
//		}
//	});
//	$('#datePickRecur').datepicker({
//		gotoCurrent: true,
//		firstDay: 1,
//		monthNames:[lang['january'],lang['february'],lang['march'],lang['april'],lang['may'],lang['june'],lang['july'],lang['august'],lang['september'],lang['october'],lang['november'],lang['december']],
//		dayNamesMin:[lang['sun'],lang['mon'],lang['tue'],lang['wed'],lang['thu'],lang['fri'],lang['sat']],
//		dateFormat: 'dd-mm-yy'
//	});
	if($('.multipleRadiosEvent').length > 0) {
		$('.multipleRadiosEvent input[name=eventRecurType]').change(function() {
			var val = $('.multipleRadiosEvent input[name=eventRecurType]:checked').val();
			if(val === 0) {
				// Limited by date selected
				$('#datePickRecur').removeClass('dn');
				$('#numberOfTimesRecur').addClass('dn');
				$('#foreverRecur').addClass('dn');
			} else if(val === 1) {
				// Limited number of times selected
				$('#datePickRecur').addClass('dn');
				$('#numberOfTimesRecur').removeClass('dn');
				$('#foreverRecur').addClass('dn');
			} else if(val === 2) {
				//Forever selected
				$('#datePickRecur').addClass('dn');
				$('#numberOfTimesRecur').addClass('dn');
				$('#foreverRecur').removeClass('dn');
			};
			$('.eventRecurTypeChoose.isShown').fadeOut();
		});
	};
	$('#datePickRecur, #numberOfTimesRecur, #foreverRecur').focus(function() {
		var pos = $(this).position();
		$('.eventRecurTypeChoose').css({'top' : (pos.top - 80), 'left' : (pos.left)});
		$('.eventRecurTypeChoose').fadeIn();
	});
	$('#datePickRecur, #numberOfTimesRecur, #foreverRecur').blur(function() {
		var pos = $(this).position();
		$('.eventRecurTypeChoose').fadeOut();
	});

	if($('#newPostText').length > 0) {
		nic = new nicEditor({
			iconsPath : site_url+'global/js/images/nicEditorIcons.gif',
			width : '470px',
			border : 'none',
			buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','fontSize','indent','outdent','image','link','unlink']
		}).panelInstance('newPostText');

		$(".nicEdit-panelContain").parent("div").css({
			width: '470px'
		}).addClass('nic-panel sprite_3');
	};

	if($('#newPostTextPoll').length > 0) {
		nic = new nicEditor({
			iconsPath : site_url+'global/js/images/nicEditorIcons.gif',
			width : '470px',
			border : 'none',
			buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','fontSize','indent','outdent','image','link','unlink']
		}).panelInstance('newPostTextPoll');

		$(".nicEdit-panelContain").parent("div").css({
			width: '470px'
		}).addClass('nic-panel sprite_3');
	};

	/*
	 * Select box
	 */
	$("select.jumpBox").selectBox({
		'menuTransition': 'slide', 
		'menuSpeed' : 'fast'
	});
	$(".forums select.jumpBox").selectBox().change(function() { window.location.href = site_url + 'forum/' + $(this).val(); });
	$(".events_page select.jumpBox").selectBox().change(function() { window.location.href = site_url + 'events/' + $(this).val(); });
	$('a.moveUpCategory').click(function(e) {
		e.preventDefault();
		var cid = $(this).attr('rel'), id = $('input#id').val(), type = $('input#type').val(), $obj = $(this), obj = $(this);
		obj.startLoading();
		$.post(site_url+'forum/ajaxmovecatup', {
			'cid': cid, 
			'id' : id, 
			'type' : type
		}, function(data) {
			if(data.result === true) { $('table.cat_'+type+'_'+id+'_'+cid).prev('table').before($('table.cat_'+type+'_'+id+'_'+cid)); };
			obj.stopLoading();
		});
	});
	$('a.moveDownCategory').click(function(e) {
		e.preventDefault();
		var cid = $(this).attr('rel'), id = $('input#id').val(), type = $('input#type').val(), obj = $(this);
		obj.startLoading();
		$.post(site_url+'forum/ajaxmovecatdown', {
			'cid': cid, 
			'id' : id, 
			'type' : type
		}, function(data) {
			if(data.result === true) { $('table.cat_'+type+'_'+id+'_'+cid).next('table').after($('table.cat_'+type+'_'+id+'_'+cid)); };
			obj.stopLoading();
		});
	});
	$('.content_middle').on('click', 'a.deleteCategory', function(e) {
		e.preventDefault();
		var cid = $(this).attr('rel');
		deleteElement = $(this);
		promptDelete("deleteCategory("+cid+")", lang['delete_category']);
	});
	$('.content_middle').on('click', 'a.deleteBoard', function(e) {
		e.preventDefault();
		var bid = $(this).attr('rel');
		deleteElement = $(this);
		promptDelete("deleteBoard("+bid+")", lang['delete_board']);
	});
	$('.content_middle').on('click', 'a.deleteMessage', function(e) {
		e.preventDefault();
		var mid = $(this).attr('rel');
		deleteElement = $(this);
		var brd = 0;
		if($(this).hasClass('firstMsg')){ brd = 1; };
		promptDelete("deleteMessage("+mid+", "+brd+")", lang['delete_message']);
	});

	$('.content_middle').on('click', 'a.editMessage', function(e) {
		e.preventDefault();
		var mid = $(this).attr('rel'), id = $('input#id').val(), type = $('input#type').val(), board = $('input#board').val(), original = $('div.message_'+type+'_'+id+'_'+board+'_'+mid+" .postBody").html(), body = $('div.message_'+type+'_'+id+'_'+board+'_'+mid+" .postText").html();
		var editionForm = '<div id="createForm" class="editForm"><form method="POST"><p><div><div class="textMid"><textarea id="editPostText" class="elasticTextA inputTextArea" title="" name="messageText"></textarea></div><div class="sprite_3 textBotCorn"><div class="createButton grey insideInput"><div class="sprite_3 fml fl"></div><input class="fl createButtonInput" type="submit" value="'+ lang['edit'] +'" /><div class="sprite_3 fmr fl"></div></div></div></div></p></form></div>';
		$('div.message_'+type+'_'+id+'_'+board+'_'+mid+' .postBody').html(editionForm);
		if($('#editPostText').length > 0) {
			nic = new nicEditor({
				iconsPath : site_url+'global/js/images/nicEditorIcons.gif',
				width : '470px',
				border : 'none',
				buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','fontSize','indent','outdent','image','link','unlink']
			}).panelInstance('editPostText');
			$(".editForm .nicEdit-panelContain").parent("div").css({ width: '470px' }).addClass('nic-panel sprite_3');
		};
		$('.editForm .nicEdit-main').html(body);
		$('#createForm.editForm form').submit(function(e) {
			e.preventDefault();
			var updatedBody = $('.editForm .nicEdit-main').html();
			$.post(site_url+'forum/ajaxeditmessage', {
				'mid': mid, 
				'id' : id, 
				'type' : type, 
				'body' : updatedBody
			}, function(data) {
				if(data.result === true) {
					$('div.message_'+type+'_'+id+'_'+board+'_'+mid+' .postBody').html(original);
					$('div.message_'+type+'_'+id+'_'+board+'_'+mid+' .postText').html(updatedBody);
				};
			});
		});
	});

	$('a.F_joinEvent').click(function(e) {
		e.preventDefault();
		var eid = $(this).attr('rel');
		joinEvent(eid);
		$(this).fadeOut();
	});
	/**
	 * form input field interaction
	 */
	$("input.inputText").focus(function() {
		if($(this).attr('title') === $(this).val()) { $(this).val(''); };
		$(this).addClass('notDefault');
	}).blur(function() {
		if($(this).val() === '') {
			$(this).val($(this).attr('title'));
			$(this).removeClass('notDefault');
		};
	});
	/*
	 * Search box
	 */
	$(".forum_search input").focus(function() { if($(this).attr('title') === $(this).val()) { $(this).val(''); }; }).blur(function() { if($(this).val() === '') { $(this).val($(this).attr('title')); }; });

	$(".quoteButton").click(function(e) {
		e.preventDefault();
		$(this).startLoading();
		var poster = $(this).attr('rel'), 
			message = $(this).children('#messageClass'), 
			txt = '<blockquote class=\"fclg\">';

		txt += '<small class=\"fclg\">' + poster + '</small><br />';
		txt += '<p class=\"quoteText\">' + message.parents('.forumL3Post').find('.forumL3PostText p').html()+'</p>';
		txt += '</blockquote><br/>';

		if ($('.replyForm .nicEdit-main').text() === '') { 
			$('.replyForm .nicEdit-main').html(txt); 
		} else { 
			$('.replyForm .nicEdit-main').append(txt); 
		}
		scrollToReplyForm();
		$(this).stopLoading();
	});

	$("a#src_but").click(function(e) {
		e.preventDefault();
		$("form#searchForm").submit();
	});
	$('.events_page #createForm form').validate({
		rules: {
			eventTitle: {
				valEqTitle:true,
				required:true,
				minlength:3,
				maxlength:255
			},
			eventLocation: {
				valEqTitle:true,
				required:true,
				minlength:2,
				maxlength:255
			},
			eventDate: {
				valEqTitle:true,
				required:true
			}
		}
	});

	$('body').on('keyup', '.friendSearchBox', function() {
		var search = $('.friendSearchBox').val();
		if(search.length === 0) { $('.friendsInviteList tr').removeClass('dn'); }
		else {
			$('td.searchPlayerName').each(function(){
				//console.log($(this).html()+' vs '+search+' = '+$(this).html().toString().toLowerCase().indexOf(search.toString().toLowerCase()));
				if($(this).html().toString().toLowerCase().indexOf(search.toString().toLowerCase()) !== -1) { $(this).parent('tr').removeClass('dn'); }
				else { $(this).parent('tr').addClass('dn'); };
			});
		};
		$('.JscrollPane').data('jsp').reinitialise();
	});
	$(".postBody .postText img").click(function() { $(this).attr('href', $(this).attr('src')); });
	$(".postBody .postText img").fancybox({ 'type' : 'image' });

	$('body').on('click', '.formSubmitUniversal', function(e) {
        e.preventDefault();
        if(elementById('createForm')) {
            var leng = $('.nicEdit-main').html().length,
                createForm = $('#createForm'),
                showError;

            if(leng < 10) {
                $('<p class="error">The field should be at least 10 characters.</p>').appendTo(createForm);
                showError = window.setTimeout(function() {
                    createForm.find('.error').remove();
                }, 2000);
            } else {
                if ($('.hiddenSubmitButton').length > 0) { $('.hiddenSubmitButton').click(); }
                else { $(this).closest('form').submit(); };
            }
        } else {
            if ($('.hiddenSubmitButton').length > 0) { $('.hiddenSubmitButton').click(); }
            else { $(this).closest('form').submit(); };
        };
	});

	$(".replyToTopic").on("click", function(e) {
		e.preventDefault();
		scrollToReplyForm();
	});

	$(".replyPost").on("click", "a", function(e) {
		e.preventDefault();
		scrollToReplyForm();
	});
});