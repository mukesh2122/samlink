<?php
return array('js' => array(
                    // PLUGINS (ORDER IS IMPORTANT!)
                    'global/js/jquery-migrate-1.2.1.js',                // support and tracker for deprecated jquery functions - NOT FOR PROD
                    'global/js/modernizr.v2.7.1.js',                    // detect client browser features
                    'global/js/compatibility.js',                       // various support and compatibility functions
					'global/js/jquery.hoverIntent.r7.js',               // detect users mousemoving intentions
					'global/js/jquery.superfish.v1.7.4.js',             // dropdown menu enhancer
					'global/js/jquery.mousewheel.v3.1.9.js',            // crossbrowser mousewheel support
                    'global/js/jquery.jscrollpane.v2.0.19.js',          // style scrollbars  --  TODO: change slider on the front page to this one
                    'global/js/jquery.autosize.v1.18.6.js',             // dynamic resize of textareas
					'global/js/jquery.waypoints.v2.0.4.js',             // execute functions on scroll-to-element
					'global/js/jquery.form.v3.50.js',                   // form handling
					'global/js/jquery.validate.v1.11.1.js',             // form validation
                    'global/js/jquery.jcrop.v2.0RC1.js',                // cropping images
					'global/js/jquery.tokeninput.v1.6.1.js',            // search tokens
					'global/js/jquery.cycle.v2.1.2.js',                 // slideshow
					'global/js/jquery.nivo.slider.v3.2.js',             // slideshow
					'global/js/jquery.ui.checkbox.v1.4.4.js',           // style checkboxes
                    'global/js/uploadify3.2.1/jquery.uploadify.js',     // upload
                    'global/js/jquery.switchy.v0.1.1.js',               // on/off button
                    'global/js/jquery.ui-timepicker-addon.v1.4.4.js',   // pick time like html5 calender
                    'global/js/jquery.jstree.v3.0.0.js',                // graphic tree generator
/* FIXED-AskeFC */ 	'global/js/jquery.fancybox-2.1.5.js',               // fancy popups
/* FIXED-AskeFC */ 	'global/js/jquery.dropkick.v1.4.js',                // style select dropdowns

					'global/js/jquery.sharetip.v1.2.8.js', // Probably abandoned, Dynamic positioning is broken. We should use qTip2 instead.
/* FIXED-AskeFC */ 	'global/js/jquery.bubblepopup.v3.js', // ABANDONED PROJECT, we should use qTip2/fancybox instead.
					'global/js/nicEdit.v0.9r24.js', // ABANDONED PROJECT, we shold use ckeditor instead.
					'global/js/jquery.resize.v1.1.js',  // ABANDONED PROJECT, use builtin jquery methods instead.
					'global/js/jquery.elastic.v1.6.11.js',  // ABANDONED PROJECT, Use autosize instead.
					'global/js/jquery.selectbox-0.2.js', // ABANDONED PROJECT, Use dropkick instead.
					'global/js/jquery.jqtransform.js', // ABANDONED PROJECT, Use dropkick instead. Author recommends it even.
					'global/js/fileuploader.js', // CHANGED to commercialized - Fineuploader.com - We should move away from this plugin.
					'global/js/jquery.buttondisable.js', // is this needed ?
                    // OUR OWN SCRIPTS (ORDER IS IMPORTANT!)
                    'global/js/custom.js',
					'global/js/login.js',                       // login/out, registration, pass reset, etc...
					'global/js/twitch.js',                      // bottombar twitch
					'global/js/chat.js',                        // bottombar chat
					'global/js/developerbar.js',
					'global/js/esport.js',
					'global/js/loadm.js',
					'global/js/load.js',
                    'global/js/forum.js',                       // forum
					'global/js/loadk.js',
					'global/js/adminNews.js', // AJAX SCRIPT FOR SELECTS IN NEWS-ADMIN
					'global/js/raidscheduler.js',
                    'global/js/colorpicker/js/colorpicker.js',
),

    'css' => array(
					'global/css/jquery.fancybox-2.1.5.css', // Keep this on top to avoid weird bug, it's confused by named/titled stylesheets loaded before
                    'global/css/cookieBar.css',
	 				'global/css/jquery.superfish.v1.7.4.css',
					'global/css/jquery.tokeninput.v1.6.1.css',
					'global/css/custom.tokeninput.v1.6.1.css', // our customizations overwrite the original tokeninput when loaded after
	 				'global/css/jquery.uploadify.v3.2.1.css',
					'global/css/fileuploader.css',
					'global/css/forum.css',
					'global/css/960.css',
                    'global/css/jstree-themes/default/style.css',
//					'global/css/jquery.datepick.css', // already included in jquery-ui
//					'global/css/smoothness.datepick.css', // already included in jquery-ui
					'global/css/jquery.bubble-popup-v3.css',
//					'global/css/jquery.cleditor.css', // IS THIS EVEN USED ????
					'global/css/jqtransform.css',
					'global/css/jquery.jscrollpane.v2.0.19.css',
					'global/css/jquery.jscrollpane.lozenge.css',
					'global/css/jquery.jcrop.v2.0RC1.css',
                    'global/css/jquery.dropkick.v1.4.css',
                    'global/css/custom.dropkick.v1.4.css', // our customizations overwrite the original dropkick when loaded after
	 				'global/css/jquery.ui.checkbox.v1.4.4.css',
					'global/css/style.css',
					'global/css/template.css',
					'global/css/page.css',
					'global/css/ui.css',
					'global/css/global.css',
					'global/css/new_style.css',
					'global/css/twitch.css',
//					'global/css/esports_style.css',
					'global/css/esports_cuptree.css',
					'global/css/chat.css',
                    'global/css/bottombar.css',
					'global/css/design_lmenu.css',
					'global/css/design_icons.css',
					'global/css/ug_popup.css',
                    'global/css/achievement_style.css',
					'global/css/jquery.switchy.v0.1.1.css',
                    'global/css/raidscheduler.css',
                    'global/css/jquery.ui-timepicker-addon.v1.4.4.css',
                    'global/css/translation.css',
                    'global/js/colorpicker/css/colorpicker.css',

                    'global/css/design_top.css',
                    'global/css/base.css',
                    'global/css/design_footer.css',
                    'global/css/design_colors.css',

//                    'global/css/defaultNewCss.css',
                    'global/css/css_recruitment.css',
//                    'global/css/css_companies.css',
                    'global/css/login.css',
));
?>