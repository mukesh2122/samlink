$(document).ready( function() {
    if($(elementById('developerbar'))) {
        $(elementById('usergroup')).on('change', function() {
            $.post(site_url+'ajaxsetrole', { 'id' : this.value }, function() { location.reload(); });
        });
        $(elementById('usergroup')).dropkick({theme : 'light_narrow'});
    };
    if(elementById('bottomDevBut')) {
        $('a', '#bottomDevMenu').fancybox({
            'closeBtn'      : true,
            'closeClick'    : false,
            'openEffect'    : 'elastic',
            'closeEffect'   : 'elastic',
            'openSpeed'     : 600,
            'closeSpeed'    : 200,
            'loop'          : true,
            'arrows'        : false,
            'type'          : 'ajax',
            'scrolling'     : 'yes',
            'autoResize'    : true,
            'autoSize'      : true,
            'autoWidth'     : true,
            'helpers'       : {
                'title'     : null,
                'overlay'   : {
                    'showEarly' : true,
                    'closeClick': false,
                    'css'   : {
                        'background': 'rgba(0, 0, 0, 0.58)'
                    }
                }
            }
        });
        $(elementById('bottomDevBut')).on('click', function(event) {
            eatEvent(event);
            var devBut = this, devMenuCss = elementById('bottomDevMenu').style;
            devBut.classList.toggle('devButClicked');
            if($(devBut).hasClass('devButClicked')) {
                devMenuCss.display = 'block';
                $(document).on('click.devnamespace', function() {
                    devMenuCss.display = 'none';
                    devBut.className = '';
                    $(document).off('click.devnamespace');
                });
            } else {
                devMenuCss.display = 'none';
                $(document).off('click.devnamespace');
            };
        });
        $(elementById('devResendMailForm')).on('submit', function(event) {
            eatEvent(event);
            var form = this, but = elementById('devVerificationMail');
            $(form).validate({
                rules : {
                    devVerificationMail : {
                        required : true
                    }
                },
                messages : {
                    devVerificationMail : {
                        required : 'You must select an option'
                    }
                }
            });
            if($(form).valid() && (but.checked === true)) {
                $.post(form.action, $(form), function(data) {
                    if(!checkData(data) && (data === 'working')) {
                        $.fancybox.close();
                    };
                });
            };
        });
    };
});