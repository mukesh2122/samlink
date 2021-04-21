var dayOfWeek, lastCall, cClass;
function ajaxLoader(selector) {
	$(selector).html('<img id="ajaxLoader" src="' + site_url + 'global/img/ajax-loader.gif" style="position:relative; margin: 83px auto 82px auto; display:block;">');
};
function initBindCalendar() {
	bindSetCalendarDate();
	bindPlayersDay();
	initBindEvent();
};
function initBindEvent() {
    bindEventText();
	bindToggle();
	bindEventClose();
	bindSetSchedule();
	bindRecurrenceEndDate();
	bindRecurrenceCount();
	bindEventButton();
	bindDeleteButtons();
	bindDatepicker();
};
function bindDatepicker() {
	// Datepicker
	$('.datepicker').datepicker({
		inline: true,
		firstDay: 1,
		monthNames:[lang['january'],lang['february'],lang['march'],lang['april'],lang['may'],lang['june'],lang['july'],lang['august'],lang['september'],lang['october'],lang['november'],lang['december']],
		dayNamesMin:[lang['sun'],lang['mon'],lang['tue'],lang['wed'],lang['thu'],lang['fri'],lang['sat']]
	});	
	//$( "input:submit").button();	
	//hover states on the static widgets
	$('#dialog_link, ul#icons li').hover( function() { $(this).addClass('ui-state-hover'); }, function() { $(this).removeClass('ui-state-hover'); } );		
};
// controls character input/counter
function bindEventText() {
	$('#eventText').keyup(function() {
		var charLength = $(this).val().length, leftLengt = 144-charLength;
		$('#eventSymbolCounter').html(lang['symbols_left']+' '+leftLengt);
	});
};
function bindToggle() {
	//generic toggle function
	$('.toggle').click(function(event) {
		event.preventDefault();
		var target = $(this).attr("href");
		$(target).fadeToggle("fast");
	});
};
function bindDeleteButtons() {
	$('.eventDelete').click(function(e) {
		e.preventDefault();
		lastCall = 'notEmpty';
		var eventTime = $(this).attr("href"), ID_EVENT = $(this).attr("rel"), future = 0;	
		ajaxLoader("#cMasterWrapper");
		$.post(site_url + 'events/ajax/deletecalendarnote', {
			'eventTime' : eventTime,
			'ID_EVENT' : ID_EVENT,
			'future':future
		}, function(data) {
			$(".F_calendarRight").replaceWith(data.content);
			initBindCalendar();
		});
	});
	$('.eventDeleteFuture').click(function(e) {
		e.preventDefault();
		lastCall = 'notEmpty';
		var eventTime = $(this).attr("href"), ID_EVENT = $(this).attr("rel"), future = 1;
		ajaxLoader("#cMasterWrapper");
		$.post(site_url + 'events/ajax/deletecalendarnote', {
			'eventTime' : eventTime,
			'ID_EVENT' : ID_EVENT,
			'future':future
		}, function(data) {
			$(".F_calendarRight").replaceWith(data.content);
			initBindCalendar();
		});
	});
};

function bindPlayersDay() {
	//switch the day to be viewed or added to
	$('.cDay').click(function(e) {
		e.preventDefault();
		var parent = $(this).parent('.cTd'), eventHolder = $(parent).find('.eventHolder');
		time = $(this).attr('rel');
		dayOfWeek = $(this).attr('href');
		$('#eventWrapper').fadeOut('fast').remove();
		if(lastCall !== time) {
			$.post(site_url + 'events/ajax/getplayersday', { 'time' : time }, function(data) {
				$(eventHolder).fadeIn('fast');
				$(eventHolder).html(data.content);
                switch(dayOfWeek) {
                    case 1:
                        cClass = 'cMo';
                        break;
                    case 2:
                        cClass = 'cTu';
                        break;
                    case 3:
                        cClass = 'cWe';
                        break;
                    case 4:
                        cClass = 'cTh';
                        break;
                    case 5:
                        cClass = 'cFr';
                        break;
                    case 6:
                        cClass = 'cSa';
                        break;
                    case 7:
                        cClass = 'cSu';
                        break;
                };
				$('#eventWrapper').find('.boxTop').addClass(cClass);
				$('#eventWrapper').css('position', 'absolute').css('left', 2);
				initBindEvent();
				lastCall = time;
			});
		} else { lastCall = 'notTime'; };	
	});
};
//switch the year or month of the calendar
function bindSetCalendarDate() {
	$('.ajaxSetCalendarDate').click(function(e) {
		ajaxLoader("#cMasterWrapper");
		lastCall = 'notEmpty';
		e.preventDefault();
		var date = $(this).attr('href');
		$.post(site_url + 'events/ajax/setcalendardate', { 'date' : date }, function(data) {
			$(".F_calendarRight").replaceWith(data.content);
			$("#cMasterWrapper").fadeIn('fast');
			initBindCalendar();
		});	
	});
};
	
function bindEventClose() {
	$('.eventClose').click(function(e) {
		e.preventDefault();
		var parent = $(this).parents("#eventWrapper");
		$(parent).empty();
		lastCall = 'notEmpty';
	});
};
function bindSetSchedule() {
	//eventSchedule form corrector
	$('.setSchedule').click(function(e) {
		e.preventDefault();
		var type = $(this).attr("rel"), parent = $(this).parent(".subBoxBody");
		if(type === 'off') {
			//reset form
			$(parent).find('.recurringEvent').val('0');
			$(parent).find('.recurrenceInterval').val('');
			$(parent).find('.recurrenceCount').val('0');
			$(parent).find('.recurrenceEndDate').val('0');
		} else {
			$(parent).find('.recurringEvent').val('1');
			if(type === 'weekly') { $(parent).find('.recurrenceInterval').val('weekly'); } 
            else if(type === 'monthly') { $(parent).find('.recurrenceInterval').val('monthly'); }
            else if(type === 'yearly') { $(parent).find('.recurrenceInterval').val('yearly'); };
		};
		//Switch selected
		$(parent).find('.setSchedule').removeClass("evScheduleSelect");
		$(this).addClass("evScheduleSelect");
	});
};
function bindRecurrenceEndDate() {
	//reset count on change on endDate
	$('.recurrenceEndDate').change(function(){
		var parent = $(this).parent(".subBoxBody");
		//set count to 0
		$(parent).find('.recurrenceCount').val('0');
	});
};
function bindRecurrenceCount() {
	//reset Enddate on change on count
	$('.recurrenceCount').change(function() {
		var parent = $(this).parent(".subBoxBody");
		//set count to 0
		$(parent).find('.recurrenceEndDate').val('0');
	});
};
function bindEventButton() {
	//Submit new note button handler
	$('.eventButton').click(function(e) {
		e.preventDefault();
		lastCall = 'empty';
		var eventText = $("#eventText").val(), day = $("#evDay").val(), month = $("#evMonth").val(), year = $("#evYear").val(), recurringEvent = $("#addEvent").find(".recurringEvent").val();
		var recurrenceCount = $("#addEvent").find(".recurrenceCount").val(), recurrenceInterval = $("#addEvent").find(".recurrenceInterval").val(), recurrenceEndDate = $("#addEvent").find(".recurrenceEndDate").val();
		ajaxLoader("#cMasterWrapper");
		$.post(site_url + 'events/ajax/addcalendarnote', {
			'eventText': eventText,
			'month': month,
			'year': year,
			'day': day,
			'recurringEvent': recurringEvent,
			'recurrenceCount': recurrenceCount,
            'recurrenceInterval': recurrenceInterval,
			'recurrenceEndDate': recurrenceEndDate
		} , function(data) {
			$(".F_calendarRight").replaceWith(data.content);
			initBindCalendar();
			//find current day
			//and re open it
			jQuery.each($(".cDay"), function(i, val) { if(day === $(val).html()) { $(this).triggerHandler("click"); }; });
		});	
	});
};
function bindEditEventButton() {
	//Submit new note button handler
	$('.eventEditButton').click(function(e) {
		e.preventDefault();
		lastCall = 'empty';
		var eventText = $("#eventText").val(), eventTime = $("#eventTime").val(), day = $("#evDay").val(), month = $("#evMonth").val(), year = $("#evYear").val();
		var ID_EVENT = $("#ID_EVENT").val(), recurringEvent = $("#eventEditor").find(".recurringEvent").val(), recurrenceCount = $("#eventEditor").find(".recurrenceCount").val();
		var recurrenceInterval = $("#eventEditor").find(".recurrenceInterval").val(), recurrenceEndDate = $("#eventEditor").find(".recurrenceEndDate").val();
		ajaxLoader("#cMasterWrapper");
		$.post(site_url + 'events/ajax/editnote', {
			'eventText': eventText,
			'eventTime': eventTime,
			'ID_EVENT': ID_EVENT,
			'month': month,
			'year': year,
			'day': day,
			'recurringEvent': recurringEvent,
			'recurrenceCount': recurrenceCount,
			'recurrenceInterval': recurrenceInterval,
			'recurrenceEndDate': recurrenceEndDate
		} , function(data) {
			$(".F_calendarRight").replaceWith(data.content);
			initBindCalendar();
		});	
	});
};
	
$(document).ready(function() {
	initBindCalendar();
	$(document).on('click', ".eventEdit", function(e) {
		e.preventDefault();
		var parent = $(this).parent('.cTd'), eventHolder = $(parent).find('.eventHolder');
		//day of the week gets set on get players day
        switch(dayOfWeek) {
            case 1:
                cClass = 'cMo';
                break;
            case 2:
                cClass = 'cTu';
                break;
            case 3:
                cClass = 'cWe';
                break;
            case 4:
                cClass = 'cTh';
                break;
            case 5:
                cClass = 'cFr';
                break;
            case 6:
                cClass = 'cSa';
                break;
            case 7:
                cClass = 'cSu';
                break;
            default:
                cClass = 'cMo';
                break;
        };
		ID_EVENT = $(this).attr("rel");
		eventTime = $(this).attr("href");
		$.post(site_url+'events/ajax/editcalendarnote', {
			'ID_EVENT':ID_EVENT,
			'eventTime':eventTime
		}, function(data) {
			$("#eventWrapper").replaceWith(data.content);
			$("#eventWrapper").css('position','absolute').css('left', 2);
			$("#eventWrapper").find('.boxTop').addClass(cClass);
			initBindEvent();
			bindEditEventButton();
			var charLength = $("#eventText").val().length, leftLengt = 144-charLength;
			$('#eventSymbolCounter').html(lang['symbols_left']+' '+leftLengt);
		});
	});
});