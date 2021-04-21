$(document).ready( function() {
    if(window["location"]["pathname"]["indexOf"]("esport") !== -1) {
        if($('#fanclub_useProfile').length){
            toggle();
			
            $('#fanclub_useProfile').click(function(){
                $(this).parent().parent().parent().parent().next('.clearfix').toggle();
            });
            
            function toggle(){
                if($('input:checkbox[id="fanclub_useProfile"]').is(':checked')){
                    $('input:checkbox[id="fanclub_useProfile"]').parent().parent().parent().parent().next('.clearfix').toggle();
                }
            }
        }
		
        if($('.esport_search').length){
            $('#searchstring').focus(function(){
                $(this).val(''); 
            });
    
            $('#searchstring').focusout(function(){
                if($(this).val() === '') {
                    $(this).val('Search tournaments');
                }
            });
        }
        
        if($('.esport_infobox').length){
            if($('.esport_infobox > div').size() === 0){
                $('.esport_infobox').hide();           
            }
        }
        
        $(function() {
            $( "#datepicker" ).datepicker({
                dateFormat: "yy-mm-dd",
                showButtonPanel: true
            });
        });
        
        $('.boxsweep').focus(function(){
            $(this).val('');
        });

/***************************GAMELOBBY*****************************************/
    
    
    if($('#lobby_notification').length){
        setInterval(function() {
            var quickmatch_challenge = 'QuickMatchChallenge', quickmatch_accept = 'ChallengeAccepted', quickmatch_reject = 'ChallengeRejected';
            $.post(site_url+"esport/ajaxchecknotes",{id: $('#userid').val()}, function(data){
                if(data !== "" && data !== null) {
                    var json = $.parseJSON(data), date = new Date();
                    if(json.type === quickmatch_challenge) {
                        $('#lobby_notification').prepend('<li><p><strong>'+date.getHours()+':'+date.getMinutes()+'</strong> - '+json.fromName+' accepted your challenge</p><div class="tournament_buttons"><a class="button red reject" id="'+json.from+'_'+json.match+'" href="javascript:void(0)">Reject</a><a class="button red accept" id="'+json.from+'_'+json.match+'" href="javascript:void(0)">Let\'s go</a></div></li>');
                        $('#myMatchstate').html('State: Pending request');
                    } else if(json.type === quickmatch_accept) {
                        $('#lobby_notification').prepend('<li><p><strong>'+date.getHours()+':'+date.getMinutes()+'</strong> - '+json.fromName+' is ready for you</p><div class="tournament_buttons"><a class="button red ok" href="javascript:void(0)">Let\'s go</a></div></li>');
                        $('#myMatchstate').html('State: Match in progress');
                    } else if(json.type === quickmatch_reject) {
                        $('#lobby_notification').prepend('<li><p><strong>'+date.getHours()+':'+date.getMinutes()+'</strong> - '+json.fromName+' backed out</p><div class="tournament_buttons"><a class="button red ok">Too bad</a></div></li>');
                        $('#myMatchstate').html('State: Waiting for opponent');
                    };
                };
            });
        }, 5000);

        $(document.body).on('click','.reject', function(event){
                var s = $(this).attr('id');
                var subs = s.split('_');

                $.post(site_url+"esport/ajaxrejectquickmatch",{
                     to: subs[0],
                     match: subs[1]
                }, function(data){
                });  
                $('#myMatchstate').html('State: Waiting for opponent');
        });

        $(document.body).on('click','#lobby_notification .tournament_buttons a', function(event){
                $(this).parent().parent('li').remove(); 
        });



        $(document.body).on('click','.accept', function(event){
                var s = $(this).attr('id');
                var subs = s.split('_');

                $.post(site_url+"esport/ajaxacceptquickmatch",{
                    to: subs[0],
                    match: subs[1],
                    }, function(data){
                });    
        });

        $(document.body).on('click','.delete', function(event){
                $(this).remove();
                $('#myMatchstate').html('State: Canceling. Please Wait.');
                $.post(site_url+"esport/deletequickmatch",{
                    id: $(this).attr('id'),
                    }, function(data){

                        window.location = site_url+"esport/gamelobby";
                });    
        });

        $(document.body).on('click','.join', function(event){
                var date = new Date();
                $(this).siblings('span').html('<strong>Request send</strong>');
                $.post(site_url+"esport/ajaxjoinquickmatch",{match: $(this).attr('id')}, function(data){
                });
                $('#lobby_notification').append('<li><p><strong>'+date.getHours()+':'+date.getMinutes()+'</strong> - Request send to '+$(this).parent().siblings('h2').children('span').html()+'</p><div class="tournament_buttons"><a class="button red ok">Ok</a></div></li>');
                $(this).remove();
        }); 
    }
    $(document.body).on('click','#create_qm_button', function(event){
        $('#error_note #loader').show();
        $.post(site_url+"esport/createquickmatch",{
            id: $('#create_qm_game').val(),
            gametype: $('#create_qm_type').val(),
            betsize: $('#create_qm_bet').val()
        }, function(data){
            var json = $.parseJSON(data);
            if(json.error === true){
                $('#error_note #loader').hide();
                $('#error_note p').html(json.note);
            }
            else{
                window.location = site_url+"esport/gamelobby";
                $('#error_note').hide();
            }
        });    
    }); 
    
    $( "#create_qm_type" ).change(function() {
        
        if($('#create_qm_type').val() === '2' || $('#create_qm_type').val() === '4'){
            $("#create_qm_bet" ).show();
        }
        else{
            $("#create_qm_bet" ).hide();
        }
    });
    
    $(document.body).on('click','.accordion', function(event){
        $(this).children('.tournament_list').toggle();
    }); 
    
    
    if($('#create_qm_bet').length){
        $('#create_qm_bet').focus(function(){
            $(this).val(''); 
        });

        $('#create_qm_bet').focusout(function(){
            if($(this).val() === '') {
                $(this).val('Betsize');
            }
        });
    }
        
    $(document.body).on('click','#create_qm_bet', function(event){
        if($('#create_qm_bet').length){
            $('#create_qm_bet').focus(function(){
                $(this).val(''); 
            });

            $('#create_qm_bet').focusout(function(){
                if($(this).val() === '') {
                    $(this).val('Betsize');
                }
            });
        }
    }); 
    
    if($('.online_count').length) {
        idleTime = 0;
        //Increment the idle time counter every minute.
        var idleInterval = setInterval(function(){timerIncrement()}, 60000); // 1 minute check

        //Zero the idle timer on mouse movement.
        $(this).mousemove(function (e) {
            idleTime = 0;
        });
        $(this).keypress(function (e) {
            idleTime = 0;
        });

        function timerIncrement() {
            idleTime = idleTime + 1;
            if (idleTime > 30) { // 30 minutes inactivity sets to offline
                $.post(site_url+"esport/ajaxcheckstatus",{id: $('#userid').val(), online:false}, function(data){});
            }
            else { //report player to be online
                $.post(site_url+"esport/ajaxcheckstatus",{id: $('#userid').val(), online:true}, function(data){});
            }
        }
        
        $(window).bind('beforeunload',function() {
            $('#infobox').append('<span>'+$('#username').val()+' left...</span>');
            $.post(site_url+"esport/ajaxcheckstatus",{id: $('#userid').val(), online:false}, function(data){
            });
        });
        $(window).unload(function() {
            $('#infobox').append('<span>'+$('#username').val()+' left...</span>');
            $.post(site_url+"esport/ajaxcheckstatus",{id: $('#userid').val(), online:false}, function(data){
            });
        });
    };
    
 /**************************END OF GAMELOBBY*********************************/
 
 /**************************CHATBOX******************************************/       
        if($('.chatbox').length){
            
            var state = $('#commentbox_startstate').val();

            $('#commentbox').focus(function(){
                $(this).val(''); 
            });
    
            $('#commentbox').focusout(function(){
                if($(this).val() === '') {
                    $(this).val('Write message...');
                }
            });
            
            $("#commentbox").keypress(function(e){
                if(e.which === 13){ //if enter is pressed while in messagebox
                    submitMessage();
                } 
            }); 
            
            $("#sendChatButton").click(function(){
                submitMessage(); 
            });
            
            setInterval(function () {
                $.post(site_url+"esport/gamelobby/chatupdate",{state: state}, function(data){
                      var json = $.parseJSON(data);
                    state = json.state;
                    
                    if(json.you === false){
                        $("#commentlist ul").append(json.msg);
                    }
                });
            }, 5500);
            
            function submitMessage(){
                $("#commentlist ul").append('<li><strong>'+$("#username").val()+': </strong>'+$("#commentbox").val()+'</li>');
                $.post(site_url+"esport/gamelobby/chat",{
                    shout: '<li><strong>'+$("#username").val()+': </strong>'+$("#commentbox").val()+'</li>'
                }, function(data){
                });
                $("#commentbox").val('');
            }
        }
 /***********************END OF CHATBOX***************************************/       

/************************COVERAGE*********************************************/
        if($('.channel_accordion_header').length){
            $('.channel_accordion_header').click(function(){
                if($(this).next().css("display") === 'none'){
                    $(this).next().slideDown('medium');
                }
                else
                    $(this).next().slideUp('medium');
            });
        }
        if($('#esport_channelviewer').length){
            $('iframe').load(function(){
               $('iframe').show(); 
               $('.chat_loader').hide();
               $('#esport_video_wrapper').show();
               $('.stream_loader').hide();
            });
        }
/************************END OF COVERAGE**************************************/

/************************TRANSACTION******************************************/
        if($('#ttype').length){
            $('#ttype').change(function(){
                $('#player_account').toggle();
                $('#team_account').toggle();
            });
        }
/************************END OF TRANSACTION***********************************/

/************************LADDER******************************************/
        if($('#ladder_gamelist_bigimage').length){   
            $('#ladder_gamelist_bigimage').mouseenter(function(){
                $('#ladder_gamelist').show(); 
            }); 
            $('#ladder_gamelist_bigimage').mouseleave(function(){
                $('#ladder_gamelist').hide(); 
            }); 
        }
/************************END OF LADDER***********************************/
    }
    $('#newsPlatform').change(function(){        
        if($(this).val() === '22'){
            $('.border').addClass('esport_newsbox');
        }
        else{
            $('.border').removeClass('esport_newsbox');
        }
    });
    
    $('.search_for_team input[type=button]').click(function(){
        window.location.href = site_url+"esport/browseteams/search/"+$('.game_filter select').val()+"/"+$('.search_for_team input[type=text]').val();
    });
    
    $('.search_for_player input[type=button]').click(function(){
        window.location.href = site_url+"esport/browseplayers/search/"+$('.game_filter select').val()+"/"+$('.search_for_player input[type=text]').val();
    });
    
/**********************CHALLENGES*********************************************/

/*********************END OF CHALLENGES****************************************/
/**********************SPOTLIGHT*********************************************/

    $('div.like_me a').click(function(){
       if($(this).hasClass('like')){
           var count = +($('.fans').children('p').children('span').text()) + 1;
           $('.fans').children('p').children('span').text(count);
       } 
       else if($(this).hasClass('unlike')){
           var count = +($('.fans').children('p').children('span').text()) - 1;
           $('.fans').children('p').children('span').text(count);
       }
    });
    
    $('.bottom_menu a').click(function(){
        $('.bottom_menu a').removeClass()
        $(this).addClass('active');
        
        $('.bot_content').hide();
        $('.'+$(this).attr('id')+'_content').show();
    });
    
    $('.subscribe_feed a').click(function(){
        if($(this).hasClass('active')){
            $(this).removeClass('active');
        } 
        else{
            $(this).addClass('active');
        }
    });
    
    $('.feed_footer .newcomment').click(function(){
       $(this).parent().parent().next('li').toggle(); 
    });
    
    $('.feed_footer .post').click(function(){
       submitWallComment($("textarea[rel^='"+$(this).attr('rel')+"']").val(), $(this).attr('rel'));
    });
    
    $('.feed_footer .showhide').click(function(){
       $(this).parent().parent().nextUntil('.self').toggle();
    });
    
    $('.feed_footer .like').click(function(){
       $.post(site_url+"esport/wallpost/like",{
                    reply: $(this).hasClass('reply'),
                    post: $(this).attr('rel'),
                    like: true
                }, function(data){
        });
        
        $(this).addClass('dn');
        $(this).siblings().removeClass('dn');
        
        var count = +($(this).siblings('.info').children('p').children('span').text()) + 1;
        $(this).siblings('.info').children('p').children('span').text(count);
    });
    
    $('.feed_footer .unlike').click(function(){

        $(this).addClass('dn');
        $(this).siblings().removeClass('dn');
        
       $.post(site_url+"esport/wallpost/like",{
                    reply: $(this).hasClass('reply'),
                    post: $(this).attr('rel'),
                    like: false
                }, function(data){
        });
        
        var count = +($(this).siblings('.info').children('p').children('span').text()) - 1;
        $(this).siblings('.info').children('p').children('span').text(count);
    });
    
    $(".commentbox").keypress(function(e){
        if(e.which === 13){ //if enter is pressed while in messagebox
            submitWallComment($(this.val()),$(this).attr('rel'));
        } 
    }); 
    
    function submitWallComment(comment, post){
                $.post(site_url+"esport/wallpost/newcomment",{
                    comment: comment,
                    post: post
                }, function(data){
                });
                
                var date = new Date();
                
                $("textarea[rel^='"+post+"']").parent().prepend('<p>'+comment+'</p>');
                $("textarea[rel^='"+post+"']").hide();
                $("a[rel^='"+post+"']").siblings('.date').append('<p>'+date.toLocaleDateString()+' '+date.toLocaleTimeString()+'</p>')
                $("a[rel^='"+post+"']").addClass('dn');
    }
/*********************END OF SPOTLIGHT****************************************/
/**********************EDIT SPOTLIGHT*****************************************/
     $(function() {
        $('.game_cancel').each(function(){
            $('.gamecollection option[value="'+$(this).attr('rel')+'"]').hide();
        });
    });
    
    $(document.body).on('click','.game_cancel',function(){
        $(this).parent().remove();
        $('.gamecollection option[value="'+$(this).attr('rel')+'"]').show();
        
         $.post(site_url+"esport/ajaxremovegame", { id: $(this).attr('rel'), team: $('.teaminfo').val() }, function(data) {});
    });
    
    $('.add_games .add_game').click(function(e){
        
        $('.gc_container img').show();
        
        $.post(site_url+"esport/ajaxaddgame", { id: $(".gamecollection").val(), team: $('.teaminfo').val() }, function(data) {
                    var json = $.parseJSON(data);
                    if(json.found === true) {
                        var name = json.name;
                        var id = json.id;
                        var img = json.img;
                        
                    $('.gamelist').append('<div class="visual_item game pr">'+ 
                            '<img class="game_cancel cp" rel="'+id+'" src="'+site_url+'global/img/esport_cross.jpg'+'" style="width:16px;height:16px;top:-4px;right:-4px;position:absolute;" />'+
                            img+
                            '<p>'+name+'</p>'+
                        '</div>');
                
                        $(".gamecollection").val('0');
                        $('.gamecollection option[value="'+id+'"]').hide();
                    }
                     else if(json.found === false) { 
                    };
                    
                    $('.gc_container img').hide();
            });

        e.preventDefault();
    });
/*********************END OF EDIT SPOTLIGHT************************************/
/*********************CREATE CHALLENGE*****************************************/
    $(document.body).on('click','.game img', function(){
        $('.game img').parent().removeClass('selected');
        $(this).parent().addClass('selected');
        $('.gameinfo').val($(this).parent().attr('rel'));
    });
    $(document.body).on('click','.player img', function(){
        $('.player img').parent().removeClass('selected');
        $(this).parent().addClass('selected');
        $('.opponentinfo').val($(this).parent().attr('rel'));
    });
    
    function noImage(){
        var noimage = site_url+"global/img/noimage/no_player_95x95.png";
           
        $('#player_list .visual_item img').each(function(){
            if($(this).context.naturalWidth === 0){
                $(this).unbind('error').attr('src',noimage);
            }
           
        });
        
    }
    $('a.create_challenge_input').click(function(){
        $('.teamsearch_container img').show();
        $.post(site_url+"esport/ajaxsearchteams", { searchstring: $("input.create_challenge_input[type='text']").val(), }, function(data) {
                    var json = $.parseJSON(data);
                    if(json.found === true) {
                        var names = $.parseJSON(json.name);
                        var path = site_url+"global/pub_img/esport/teams";
                        
                        $.each(names, function(index, value){
                            var fullPath = path+'/'+value.Avatar.substr(0,1)+'/'+value.Avatar.substr(1,1)+'/'+value.Avatar;
                            if(value.ID_TEAM !== '0'){
                                $('#player_list').append('<div class="visual_item player" rel="'+value.ID_TEAM+'">'+
                                                            '<img src="'+fullPath+'" />'+
                                                            '<p>'+value.DisplayName+'</p>'+
                                                        '</div>');
                                
                            }
                        });
                        
                        noImage();
                    }
                     else if(json.found === false) { 
                    };
                    $('.teamsearch_container img').hide();
            });
    });
    
    $( "#slider" ).slider({
        range: "max",
        min: 10,
        max: parseInt($('#available_amount').text()),
        value: parseInt($('.betsize').val()),
        slide: function( event, ui ) {
            $( "#amount" ).text( ui.value );
            $( ".betsize" ).val( ui.value );
        }
        });
        $( "#amount" ).text( $( "#slider" ).slider( "value" ) );
    });

    $('.amount').click(function(){
        $('.amount').removeClass('selected');
        $(this).addClass('selected');
        var newAmount = parseInt($(this).children('h1').text());
        var maxAmount = parseInt($( "#slider" ).slider( "option", "max"));

        if(newAmount <= maxAmount){
            $( "#slider" ).slider( "option", "value", newAmount );
            $( ".betsize" ).val( newAmount );
            $( "#amount" ).text( newAmount );
        }
        else{
            $( "#slider" ).slider( "option", "value", maxAmount );
            $( ".betsize" ).val( maxAmount );
            $( "#amount" ).text( maxAmount );
        }
    });
    
    $(function() {
        $('.create_p4f_form input[type="submit"]').click(function(){
                var status = true;
                $('.form_error').addClass('dn');
                if($('.gameinfo').val()==="")
                {
                    $('.error_game').removeClass('dn');
                    status = false;
                }
                if($('.serverdetails').val() === "")
                {
                    $('.error_server').removeClass('dn');
                    status = false;
                }
                if($('.date').val() === "")
                {
                    $('.error_time').removeClass('dn');
                    status = false;
                }
                if($('.time').val() === "")
                {
                    $('.error_time').removeClass('dn');
                    status = false;
                }
                if($('.timezone').val() === "" || $('.timezone').val() === "0")
                {
                    $('.error_time').removeClass('dn');
                    status = false;
                }

                if(status === true){
                    $(this).submit();
                }
                else return false;
        });
    });
    
    $('.create_p4c_form input[type="submit"]').click(function(){
            var status = true;
            $('.form_error').addClass('dn');
            if($('.gameinfo').val()==="")
            {
                $('.error_game').removeClass('dn');
                status = false;
            }
            if($('.serverdetails').val() === "")
            {
                $('.error_server').removeClass('dn');
                status = false;
            }
            if($('.date').val() === "")
            {
                $('.error_time').removeClass('dn');
                status = false;
            }
            if($('.time').val() === "")
            {
                $('.error_time').removeClass('dn');
                status = false;
            }
            if($('.timezone').val() === "" || $('.timezone').val() === "0")
            {
                $('.error_time').removeClass('dn');
                status = false;
            }
            
            if(status === true){
                $(this).submit();
            }
            else return false;
    });
    
    $('.p4c_infobox').mouseenter(function(){
        $(this).children('div').show();
    });
    $('.p4c_infobox').mouseleave(function(){
        $(this).children('div').hide();
    });
/**********************END OF CREATE CHALLENGE*********************************/
    $('.search_player').click(function(){
        $.post(site_url+"esport/ajaxsearchplayer", { searchstring: $(".searchbox").val(), }, function(data) {
                    var json = $.parseJSON(data);
                    if(json.found === true) {
                        var names = $.parseJSON(json.name);

                        $.each(names, function(index, value){
                            if(value.ID_TEAM !== '0'){
                                $('.search_result').append('<ul class="ladder_info">'+
                                                                '<li class="displayname"><p>'+value.DisplayName+'</p></li>'+
                                                                '<li>'+value.City+','+value.Country+'</li>'+
                                                                '<li><a rel="'+value.ID_TEAM+'" class="add_player button button_small grey btn_red_gradient_bg" href="javascript:void(0)">Add</a>'+
                                                            '</li></ul>');
                            }
                        });
                    } else if(json.found === false) { 
                    };

            });
    });
    
    $(document.body).on("click",".add_player",function(){
            $('.roster').append(
                    '<div class="information_section">'+
                    '<select id="rolebox" name="player[]" class="text_input w290 pull_right">'+                  
                    '<option value="0">Select role...</option>'+
                      '<option value="1_'+$(this).attr('rel')+'">Captain</option>'+
                      '<option value="2_'+$(this).attr('rel')+'">Vicecaptain</option>'+
                      '<option value="3_'+$(this).attr('rel')+'">Member</option>'+
                    '</select>'+
                    '<p rel="" class="user">'+$(this).parent().siblings('.displayname').children('p').text()+'</p>'+
                    '<p>Player</p>'+
                    '</div>');
            
            $(this).remove();
    });