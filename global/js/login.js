function login(type) {
    var formType = type, form = $(elementById(formType)), loader = elementById('loaderDim');
    loader.style.display = 'block';
    form.startLoading();
    form.validate({
        rules: {
            email: {
                email: true,
                required: true,
                maxlength: 80
            },
            pass: {
                required: true,
                minlength: 8,
                maxlength: 80
            }
        },
        messages: {
            email: {
                email: lang['valid_email'],
                required: lang['enter_your_email'],
                maxlength: lang['max_eighty_char']
            },
            pass: {
                required: lang['enter_your_pass'],
                minlength: lang['min_eight_char'],
                maxlength: lang['max_eighty_char']
            }
        },
        onkeyup: function(element, event) {
            if (!form.valid()) {
                $('#' + formType + ' .login_error').addClass('dn');
            }
        }
    });
    if(form.valid()) {
        $.ajax({
            async : true,
            cache : false,
            contentType: "application/json; charset=UTF-8",
            crossDomain : true,
            data : form.serialize(),
            headers : {"X-Requested-With": "XMLHttpRequest"},
            type : "GET",
            url : site_url + "login/ajaxloginvalidate",
        }).done(function(data) {
            if(!checkData(data)) {
                alert(lang['error'] + ' ' + lang['no_data']);
            } else {
                if((data) && (data.result) && (data.result === true) && (data.url)) {
                    window.location.href = data.url;
                } else {
                    $('#' + formType + ' .login_error').removeClass('dn').html(data.message);
                };
            };
            form.stopLoading();
            loader.style.display = 'none';
        }).fail(function(data) {
            $('#' + formType + ' .login_error').removeClass('dn').html(data);
            form.stopLoading();
            loader.style.display = 'none';
        });
    } else {
        form.stopLoading();
        loader.style.display = 'none';
    };
};

function register(type) {
    var formType = type, form = $(elementById(formType)), loader = elementById('loaderDim');
    loader.style.display = 'block';
    form.startLoading();
    if(form.valid()) {
        $.get(site_url + 'login/ajaxregister', form.serialize(), function(data) {
            if(!checkData(data)) {
                alert(lang['error'] + ' ' + lang['no_data']);
            } else {
                if((data) && (data.result) && (data.result === true)) {
                    window.location.href = site_url + 'login/registration-successful';
                } else {
                    alert(data); // TODO : use fancybox or other beautified method to display error
                };
            };
            form.stopLoading();
            loader.style.display = 'none';
        });
    } else {
        form.stopLoading();
        loader.style.display = 'none';
    };
};

function registerValidate(type) {
    var formType = type, emailID = 'register-email', passID = '#register-pass';
    if(formType === 'register_form_page') {
        emailID += '-page', passID += '-page'
    };
    $(elementById(formType)).validate({
        rules: {
            email: {
                email: true,
                required: true,
                maxlength: 80,
                remote: {
                    url: site_url + 'login/validatemail',
                    type: 'get',
                    data: {
                        email: function() {
                            return elementById(emailID).value;
                        }
                    }
                }
            },
            pass: {
                required: true,
                minlength: 8,
                maxlength: 80
            },
            confirm_pass: {
                required: true,
                minlength: 8,
                maxlength: 80,
                equalTo: passID
            },
            nick: {
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
            pass: {
                required: lang['enter_pass'],
                minlength: lang['min_eight_char'],
                maxlength: lang['max_eighty_char']
            },
            confirmpass: {
                required: lang['confirm_pass'],
                minlength: lang['min_eight_char'],
                maxlength: lang['max_eighty_char'],
                equalTo: lang['pass_nomatch']
            },
            nick: {
                required: lang['enter_nick'],
                minlength: lang['min_five_char'],
                maxlength: lang['max_forty_char']
            },
            terms: {
                required: lang['accept_terms']
            }
        }
    });
};

$(document).ready(function() {
/* LOGIN */
    if(elementById('login_form_page')) {
        $(elementById('login_form_page')).on('keyup', function(event) {
            var e = event, code = (e.keyCode) ? e.keyCode : e.which;
            eatEvent(e);
            if(code === 13) { login('login_form_page'); };
        });
        $(elementById('action_login_page')).on('click', function(event) {
            eatEvent(event);
            login('login_form_page');
        });
    };

    if(elementById('login_form')) {
        $(elementById('login_form')).on('keyup', function(event) {
            var e = event, code = (e.keyCode) ? e.keyCode : e.which;
            eatEvent(e);
            if(code === 13) { login('login_form'); };
        });
        $(elementById('action_login')).on('click', function(event) {
            eatEvent(event);
            login('login_form');
        });
    };

/* REGISTRATION */
    if(elementById('register_form')) {
        registerValidate('register_form');
        $(elementById('register_form')).on('keyup', function(event) {
            var e = event, code = (e.keyCode) ? e.keyCode : e.which;
            eatEvent(e);
            if(code === 13) { register('register_form'); };
        });
        $(elementById('action_register')).on('click', function(event) {
            eatEvent(event);
            register('register_form');
        });
    };

    if(elementById('register_form_page')) {
        registerValidate('register_form_page');
        $(elementById('register_form_page')).on('keyup', function(event) {
            var e = event, code = (e.keyCode) ? e.keyCode : e.which;
            eatEvent(e);
            if(code === 13) { register('register_form_page'); };
        });
        $(elementById('action_register_page')).on('click', function(event) {
            eatEvent(event);
            register('register_form_page');
        });
    };

/* FACEBOOK */
    $(elementById('facebook_login')).on('click', function(e) {
        e.preventDefault();
        window.location.href = site_url + 'login/fblogin';
//        $.post(site_url+'login/fblogin', {}, function(data){
//            console.log("Response: "+data);
//        });
    });
    /*
     function fbLogin() {
     FB.login(function(response) {
     if (response.authResponse) {
     // connected
     $.post(site_url+'login/fblogin', {}, function(data){
     console.log("Response: "+data);
     });
     } else {
     // cancelled
     }
     });
     }
     */
    //TWITTER
    $(elementById('twitter_login')).on('click', function(e) {
        e.preventDefault();
        $.post(site_url + 'twitter', {}, function(data) {
            console.log("Response: " + data);
        });
    });
    $('#login_tab li').on('click', 'a', function(e) {
        e.preventDefault();
        if (!$(this).parents('li').hasClass('active')) {
            $('.loader').removeClass('dn');
            $('.primary_login_content').addClass('dn');
            $('#login_tab li.active').removeClass('active');
            $(this).parents('li').addClass('active');
            $.get($(this).attr('href'), function(data) {
                $('.loader').addClass('dn');
                $(elementById('login_cont')).html(data.content);
                $('.primary_login_content').removeClass('dn');
                FB.XFBML.parse(elementById('login_form'));
            });
        };
    });

    $(elementById('link_forgot')).on('click', function(e) {
        e.preventDefault();
        var buble = $(this);
        buble.CreateBubblePopup({
            manageMouseEvents: false,
            position: 'bottom',
            align: 'center',
            themeName: 'grey',
            themePath: site_url + 'global/js/images/jquerybubblepopup-theme'
        });
        if(buble.IsBubblePopupOpen()) {
            buble.HideBubblePopup();
            hideOverlay();
        } else {
            showOverlay();
            $.get(site_url + 'login/ajaxforgotpass', function(data) {
                buble.SetBubblePopupInnerHtml(data.content, true);
                buble.ShowBubblePopup();
                $(elementById('form_recovery')).on('submit', function(e) {
                    e.preventDefault();
                    var actionRecov = $(elementById('action_recover'));
                    actionRecov.startLoading();
                    if($(this).valid()) {
                        $.get(site_url + 'players/ajaxpassrecovery', {
                            'mail': elementById('login_email').value
                        }, function(data) {
                            if(data.result === true) {
                                var bubleOne = $(elementById('link_forgot')), buble = $(elementById('link_forgot_page'));
                                if(bubleOne.IsBubblePopupOpen()) {
                                    bubleOne.HideBubblePopup();
                                    hideOverlay();
                                };
                                if(buble.IsBubblePopupOpen()) {
                                    buble.HideBubblePopup();
                                    hideOverlay();
                                };
                            } else { $('.remind_error').removeClass('dn').html(data.message); };
                            actionRecov.stopLoading();
                        });
                    } else { actionRecov.stopLoading(); };
                });
                $(elementById('action_recover')).on('click', function(e) {
                    e.preventDefault();
                    $(elementById('form_recovery')).submit();
                });
            });
        };
    });
    $(elementById('link_forgot_page')).on('click', function(e) {
        e.preventDefault();
        var buble = $(this);
        buble.CreateBubblePopup({
            manageMouseEvents: false,
            position: 'bottom',
            align: 'center',
            themeName: 'grey',
            themePath: site_url + 'global/js/images/jquerybubblepopup-theme'
        });
        if (buble.IsBubblePopupOpen()) {
            buble.HideBubblePopup();
            hideOverlay();
        } else {
            showOverlay();
            $.get(site_url + 'login/ajaxforgotpass', function(data) {
                buble.SetBubblePopupInnerHtml(data.content, true);
                buble.ShowBubblePopup();
            });
        };
    });

//		$("body").on('change', "#email-element", function() {
//				$("#email-element").removeData("previousValue");
//				$("#register_form").validate().element('#email-element');
//		});

    //login password field changement
    $(this).on('focus', '.login_pass_fake, .login_pass', function() {
        if($(this).hasClass('login_pass_fake')) {
            $('.login_pass_fake').addClass('dn');
            $('.login_pass').removeClass('dn').focus();
        };
    });
    $(this).on('blur', '.login_pass_fake, .login_pass', function() {
        if($(this).hasClass('login_pass')) {
            if($(this).val() === '') {
                $('.login_pass_fake').removeClass('dn');
                $('.login_pass').addClass('dn');
            };
        };
    });

    if(elementById('editForm')) {
        $(elementById('editForm')).validate({
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
    };
});