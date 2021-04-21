function deleteCategory(cid) {
	var id = $('input#id').val(), type = $('input#type').val();
	console.log('running');
	$.post(site_url+'forum/ajaxdeletecategory', {
		'cid': cid, 
		'id' : id, 
		'type' : type
	}, function(data) {
        if(data.result === true) {
            $('.cat_'+type+'_'+id+'_'+cid+'_wrap').hide();
            location.reload();
        };
    });
};

$(document).ready(function() {
    if(elementById('hour')) { $(elementById('hour')).timepicker({timeOnly:true}); };
	/* LEVEL 1: OVERVIEW OF CATEGORIES, AND THEIR BOARDS  - OK*/
		$(".content_middle").on("click", '.collapseCategory', function(e) {
			e.preventDefault();
			var id = $('input#id').val(), type = $('input#type').val(), cid = $(this).attr('rel'), obj = $(this), url = site_url+'forum/ajaxcollapsecat';
			obj.startLoading();
			$('.cat_'+type+'_'+id+'_'+cid).slideUp();
			obj.addClass('expandCategory').removeClass('collapseCategory').text('+').attr('title', 'Click to expand.');
			$.post(url, {'id' : id, 'type' : type, 'cid' : cid}, function(data) {
				if(data.result === true) {
					$('.cat_'+type+'_'+id+'_'+cid).html('');
				} else { 
					$('.cat_'+type+'_'+id+'_'+cid).slideDown();
				};
				obj.stopLoading();
			});
		});

		$(".content_middle").on("click", '.expandCategory', function(e) {
			e.preventDefault();
			var id = $('input#id').val(), 
				type = $('input#type').val(), 
				cid = $(this).attr('rel'), 
				obj = $(this),
				url = site_url+'forum/ajaxexpandcat',
				catClass = ".cat_"+type+"_"+id+"_"+cid;
				catLoader = $('<span class="catLoader"></span>');

			obj.startLoading();

			$(catClass).append(catLoader).show();
			obj.addClass('collapseCategory').removeClass('expandCategory').text('-').attr('title', 'Click to collapse.');

			$.post(url, {'id' : id, 'type' : type, 'cid' : cid}, function(data) {
				if(data.result === true) {
					$('.catLoader').remove();
					$(catClass).append(data.data).slideDown();
				};
				obj.stopLoading();
			});
		});

	/* LEVEL 2 - OVERVIEW OF BOARD AND THIS TOPICS */
		// create topic / thread
			$('body').on('submit', '#createForumTopic', function(e) {
				console.log('running');
				var $form = $(this);
				$form.validate({
				    rules: {
				        topicName: {
				            required: true,
				            minlength: 3,
				            maxlength: 40
				        },
				        messageText: {
				            required: true
				        }
				    },
				    messages: {
				        topicName: {
				            required: 'The subject is required',
				            minlength: 'At least 3 characters',
				            maxlength: 'max 40 characters long'
				        },
				        messageText: {
				            required: 'The first message is required'
				        }
				    }
				});
				if ($form.valid()) {
					console.log('return true');
				    return true;
				} else {
					console.log('return false');
				    return false;
				}
				;
			});


		// create topic / poll
			$('body').on('submit', '#createForumTopicPoll', function(e) {
				console.log('running');
				var $form = $(this);
				$form.validate({
				    rules: {
				        topicName: {
				            required: true,
				            minlength: 3,
				            maxlength: 34
				        },
				        enddate: {
				            required: true
				        },
				        hour: {
				            required: true
				        }
				    },
				    messages: {
				        topicName: {
				            required: 'You make a question',
				            minlength: 'At least 3 characters',
				            maxlength: 'max 34 characters long'
				        },
				        enddate: {
				            required: 'Select a date when the poll ends'
				        },
				        hour: {
				            required: 'Select the time for when the poll ends'
				        }
				    }
				});
				if ($form.valid()) {
					console.log('return true');
				    return true;
				} else {
					console.log('return false');
				    return false;
				}
				;
			});

		// add answeroption in create poll
			$('#add_input').on('click', function() {
				var element = document.createElement('div');
				var static_inputs = 4;
				var inputs = document.forms["createForumTopicPoll"].getElementsByTagName("input").length;
				var i = inputs - static_inputs;
				// console.log('there was '+i+' input-elements ');

				// if max inputs is 15  i <= 14  if  max input is 10 the  i <= 9
				if (i <= 14) {
				    $('<div class="textMid"><input type="text" name="options[]"  class="mt10 w300">  </div>').appendTo(pollcontainer);
				}
				;
				var inputtotal = document.forms["createForumTopicPoll"].getElementsByTagName("input").length;
				//  var inputcount = inputtotal - static_inputs;
				//  console.log('there are '+inputcount+' input-elements at the moment');
			});


	/* LEVEL 3 -  TOPIC/POLL */
		// cast vote 
			$('body').on('click', '.vote', function() { 
			 console.log('running ajax');
			 var type = $('#otype').val(), id = $('#oid').val(), url = $('#url').val(), board = $('#board_id').val(), topic = $('#topic_id').val(), poll_id = $('#poll_id').val(), pollchoice = $("input[name='pollchoice']:checked").val();
				//  console.log(site_url + 'forum/' +type+ '/' +url+ '/' +board+ '/' +topic+ '/' +poll_id);

				$.post(site_url + 'forum/vote',{
				
						'type' : type,
						'id' : id,
						'url' : url,
						'board' : board,
						'topic' : topic,
						'poll_id' : poll_id,
						'pollchoice' : pollchoice

				}, function(data) { 
						console.log(data.result);
						if(data.result === true) { 
								location.reload(true);
						}; 
						
				}); 
			});

		// make a player board moderator
			$('#makemod').on('click', '.makeBoardMod', function() { 
				console.log('running ajax');
				var type = $('#mod_otype').val(), id = $('#mod_oid').val(), url = $('#mod_url').val(), board = $('#mod_board_id').val(), topic = $('#mod_topic_id').val(), poll_id = $('#mod_poll_id').val(), id_player=$('#mod_id_player').val();
			 
				//console.log('type:'+type+'id:'+id+'board:'+board+'playerid:'+id_player);
				$.post(site_url + 'forum/addboardmod',{
				
						'type' : type,
						'id' : id,
						'url' : url,
						'board' : board,
						'topic' : topic,
						'poll_id' : poll_id,
						'id_player' : id_player

				}, function(data) { 
					console.log('data: ' +data.result);
						if(data.result === true) { 
									
									console.log("Result was true!");
									location.reload(true);
						
								
						}; 
						
				}, "json"); 
			});       

		// ban user
			$('body').on('click', '.add_ban_user', function() { 
				var type = $('#type').val(), 
				id = $('#id').val(), 
				id_player = $('#id_player').val(), 
				PosterIP = $('#playersIP').val(), 
				bantime = $("input[name='ban_time']:checked").val(), 
				banfrom = $("input[name='ban_from']:checked").val();

				$.post(site_url + 'forum/banuser',{
						'type' : type,
						'id' : id,
						'id_player': id_player,
						'PosterIP': PosterIP,
						'bantime' : bantime,
						'banfrom' : banfrom
				}, function(data) {
						if(data.result === true) {
							location.reload(true);
						};
				});
			});

		// add answeroption in edit poll
			$('#addinput_edit').on('click', function() {
				var element = document.createElement('div');
				var static_inputs = 10;
				var inputs = document.forms["editPoll"].getElementsByTagName("input").length;
				var i = inputs - static_inputs;
				 console.log('there was '+i+' input-elements ');
				// if max inputs is 15  i <= 14  if  max input is 10 the  i <= 9
				if (i <= 14) {
				    $('<div class="textMid"><input type="text" name="new_options[]"  class="mt10 w300">  </div>').appendTo(PollCon);
				}
				;
				var inputtotal = document.forms["editPoll"].getElementsByTagName("input").length;
				 var inputcount = inputtotal - static_inputs;
				// console.log('there are '+inputcount+' input-elements at the moment');
			});

		//edit replies on topicstarter
			$('body').on('click', '.updateMessage_yes', function(e) {
				console.log('running');
				e.preventDefault();
				var $obj = $(this);
				$obj.startLoading();
				var $form = $("#EditMessageForm");
				$form.validate({
					rules: {
						msgbody: {
							required:true,
							minlength:10,
							
						}
					}
				});

				if($form.valid()) {
					console.log('form valid');
					//console.log($('#EditMessageForm').serialize());
					$.post(site_url+'forum/editmessage', $('#EditMessageForm').serialize(), function(data) {
							//var x = window.open(); x.document.open(); x.document.write(data);
						console.log(data);
						if(data.result !== false) {
							$.fancybox.close();
							location.reload();
						};
						$obj.stopLoading();
					});
				} else { $obj.stopLoading(); };
			});

 		// delete replies
 			$('body').on('click', '.deleteMessage_yes', function(e) {
				var id = $('#id').val(), 
				type = $('#type').val(),
				board_id = $('#board_id').val(),
				topic_id = $('#topic_id').val(),
				msg_id = $('#msg_id').val();
				console.log('running');
				$.post(site_url+'forum/ajaxdeletemessage', {
					'id' : id, 
					'type' : type,
					'board_id': board_id,
					'topic_id' : topic_id,
					'msg_id':msg_id
				}, function(data) {
					console.log(data);
			        if(data.result === true) {
			            $.fancybox.close();
						location.reload();
			        };
			    });
			});

		// cancel delete replies 
			$('body').on('click', '.deleteMessage_no', function(e) {
				$.fancybox.close();
				//location.reload();
			});

		// delete thread ( fm messages and fm topics)
			$('body').on('click', '.deleteThread_yes', function(e) {
				var id = $('#id').val(), 
				type = $('#type').val(),
				board_id = $('#board_id').val(),
				topic_id = $('#topic_id').val(),
				msg_id = $('#msg_id').val(),
				createdBy = $('#createdBy').val();
				//console.log('running');
				$.post(site_url+'forum/ajaxdeletethread', {
					'id' : id, 
					'type' : type,
					'board_id': board_id,
					'topic_id' : topic_id,
					'msg_id': msg_id,
					'createdBy':createdBy
					
				}, function(data) {
					console.log(data);
			        if(data.result === true) {
			            $.fancybox.close();
			            window.location.href = data.url;
			            
			        };
			    });
			});

		// cancel delete Thread
			$('body').on('click', '.deleteThread_no', function(e) {
				$.fancybox.close();
				//location.reload();
			});

		// delete polls 
			$('body').on('click', '.deletePoll_yes', function(e) {
				var id = $('#id').val(), 
				type = $('#type').val(),
				board_id = $('#board_id').val(),
				topic_id = $('#topic_id').val(),
				msg_id = $('#msg_id').val(),
				poll_id = $('#poll_id').val();
				console.log('running');
				$.post(site_url+'forum/ajaxdeletePoll', {
					'id' : id, 
					'type' : type,
					'board_id': board_id,
					'topic_id' : topic_id,
					'msg_id': msg_id,
					'poll_id':poll_id
					
				}, function(data) {
					console.log(data);
			        if(data.result === true) {
			            $.fancybox.close();
			            window.location.href = data.url;
			            
			        };
			    });
			});

		// cancel delete polls	
			$('body').on('click', '.deletePoll_no', function(e) {
				$.fancybox.close();
				//location.reload();
			});

	/* ADMIN PANAL */
		// create and edit category  - click on the button
			$('body').on('click', '.add_forum_cat', function(e) {
				console.log('running');
				e.preventDefault();
				var $obj = $(this);
				$obj.startLoading();
				var $form = $("#add_forum_cat_form");
				$form.validate({
					rules: {
						cat_name: {
							required:true,
							minlength:1,
							maxlength:80
						}
					}
				});

				if($form.valid()) {
					console.log('form valid');
					$.post(site_url+'forum/savecategory', $('#add_forum_cat_form').serialize(), function(data) {
						console.log(data);
						if(data.result === true) {
							$.fancybox.close();
							location.reload();
						};
						$obj.stopLoading();
					});
				} else { $obj.stopLoading(); };
			});

		// create and edit category - hit enter!
			$('body').on('keypress', '.add_forum_cat', function(event) {
				if(event.which === 13) {
					event.preventDefault();
					var $obj = $(this);
					$obj.startLoading();
					var $form = $("#add_forum_cat_form");
					$form.validate({
						rules: {
							cat_name: {
								required:true,
								minlength:1,
								maxlength:80
							}
						}
					});

					if($form.valid()) {
						$.post(site_url+'forum/savecategory', $('#add_forum_cat_form').serialize(), function(data) {
							if(data.result === true) {
								$.fancybox.close();
								location.reload();
							};
							$obj.stopLoading();
						});
					} else { $obj.stopLoading(); };
				};
			});

		// update the catorder by click
			$('body').on('click', '.UpdateCatOrder', function(e) {
				e.preventDefault();
				var $obj = $(this);
				$obj.startLoading();
				var $form = $("#ChangeCatOrder");
				$form.validate({
					rules: {
						CatOrderNr: {
							required:true,
							minlength:1,
							maxlength:80
						}
					}
				});

				if($form.valid()) {
					$.post(site_url+'forum/ajaxmovecat', $('#ChangeCatOrder').serialize(), function(data) {
						if(data.result === true) {
							$.fancybox.close();
							location.reload();
						};
						$obj.stopLoading();
					});
				} else { $obj.stopLoading(); };
			});


		// create ( and edit? ) board
			$('body').on('click', '.add_forum_board', function(e) { 
				console.log('running');
				e.preventDefault();
				var $obj = $(this);
				$obj.startLoading();
				var $form = $("#add_forum_board_form");
				$form.validate({
					rules: {
						board_name: {
							required:true,
							maxlength:80
						}
					}
				});

				if($form.valid()) {
					console.log('valid form');
					$.post(site_url+'forum/saveboard', $('#add_forum_board_form').serialize(), function(data) {
						console.log(data);
						if(data.result === true) {
							$.fancybox.close();
							location.reload();
						};
						$obj.stopLoading();
					});
				} else {
					 // console.log("stop");
						$obj.stopLoading();
				};
			});

		// update board order by click
			$('body').on('click', '.UpdateBoardOrder', function(e) {
				e.preventDefault();
				var $obj = $(this);
				$obj.startLoading();
				var $form = $("#ChangeBoardOrder");
				$form.validate({
					rules: {
						BoardOrderNr: {
							required:true,
							minlength:1,
							maxlength:11
						}
					}
				});

				if($form.valid()) {
					$.post(site_url+'forum/ajaxmoveboard', $('#ChangeBoardOrder').serialize(), function(data) {
						if(data.result === true) {
							$.fancybox.close();
							location.reload();
						};
						$obj.stopLoading();
					});
				} else { $obj.stopLoading(); };
			});

		// delete boards
			$('body').on('click', '.deleteboard_yes', function(e) {
				// console.log('im running!');
				e.preventDefault();
				var $obj = $(this);
				$obj.startLoading();
				var $form = $("#DeleteBoard");
				$form.validate({
					rules: {
						board_id: {
							required:true,
							minlength:1,
							maxlength:80
						}
					}
				});

				if($form.valid()) {
					 //console.log('im running! a valid form');
					$.post(site_url+'forum/ajaxdeleteboard', $('#DeleteBoard').serialize(), function(data) {
						//  console.log(' i have called  a onther function');
						if(data.result === true) {
							// console.log('the data i return is true' );
							$.fancybox.close();
							location.reload();
						};
						$obj.stopLoading();
					});
				} else { $obj.stopLoading(); };
			});

	/* BANNED MEMBERS PAGE */
		// deactive an Unlimited ban
			$('body').on('click', '.DeactivateBan', function() { 
				console.log('Im running');
				var type = $('#type').val(), 
				id = $('#id').val(),
				url = $('#url').val(),
				ID_SUSPEND = $('#ID_SUSPEND').val();
				
				$.post(site_url + 'forum/bannedmembers/' +type+ '/' +url+ '/deactivateban',{
						'type' : type,
						'id' : id,
						'url':url,
						'ID_SUSPEND': ID_SUSPEND		
				}, function(data) {
					console.log(data);
						if(data.result === true) {
							location.reload(true);
						};
				});
			});

		// bans that has passed can be moved 
			$('body').on('click', '.MoveToBanHistory', function() { 
				console.log('Im running move');
				var type = $('#type').val(), 
				id = $('#id').val(),
				url = $('#url').val(),
				ID_SUSPEND = $('#ID_SUSPEND').val();
				
				$.post(site_url + 'forum/bannedmembers/' +type+ '/' +url+ '/movetohistory',{
						'type' : type,
						'id' : id,
						'url':url,
						'ID_SUSPEND': ID_SUSPEND		
				}, function(data) {
					console.log(data);
						if(data.result === true) {
							location.reload(true);
						};
				});
			});
	
	/*old js  - not been used*/
		/*
		function deleteBoard(bid) {
			var id = $('input#id').val(), type = $('input#type').val();
			$.post(site_url+'forum/ajaxdeleteboard', {
				'bid': bid, 
				'id' : id, 
				'type' : type
			}, function(data) { if(data.result === true) { $('tr.board_'+type+'_'+id+'_'+bid).hide(); }; });
		};
		function deleteMessage(mid, brd) {
			var id = $('input#id').val(), type = $('input#type').val(), board = $('input#board').val(), murl = $('input#url').val();
			$.post(site_url+'forum/ajaxdeletemessage', {
				'mid': mid, 
				'id' : id, 
				'type' : type, 
				'board' : board
			}, function(data) { if(data.result === true) { $('div.message_'+type+'_'+id+'_'+board+'_'+mid).hide(); if(brd === 1) { window.location.href = site_url + 'forum/' + type + '/' + murl + '/' + board; }; }; });
		};
	*/
});