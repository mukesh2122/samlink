function autoSize() { $('.autoSize').autosize(); };

$(document).ready(function() {
	autoSize(); // Initialize autosize for textarea

	// Helper tooltips
	$('.tooltipHelper').tooltip({
		position: 'top center',
		relative: 'true',
		effect: 'slide',
		tipClass: 'tooltipHelperBox',
		bounce: 'true'
	});

	$('a.tooltipHelper').on('click', function(e) {
		eatEvent(e);
	});

	//ShareTip
	$('.shareTipTrigger').tooltip({
		position: 'bottom center',
		relative: 'true',
		offset: [25, 0],
		effect: 'slide',
		direction: 'up',
		delay: 300,
		predelay: 300,
		tipClass: 'shareTip',
		bounce: true
	});
		/* DYNAMIC POSITIONING IS BROKEN IN CURRENT VERSION OF SHARETIP */
//    .dynamic({
//		top: { direction: 'down' },
//		right: {
//            direction: 'left',
//			offset: [-94, -30]
//		},
//		left: {
//			direction: 'right',
//			offset: [-94, 30]
//		}
//	});

	$('a.shareTipTrigger').on('click', function(e) {
		eatEvent(e);
	});

	$('.copy_link').on('click', function () {
		var $this = $(this);
		if(!$this.hasClass('link_selected')) { $this.addClass('link_selected'); };
		$this.on('focusout', function() { $this.removeClass('link_selected'); });
		$this.nextAll('input').select();
	});

	// DropKick Initialize
	if($('.dropkick_lightWide').length) {
		$('.change').dropkick({
			change: function() { dropkickChange(); },
			theme: 'lightWide'
		});
		$('.changeOwner').dropkick({
			change: function() { newsAdminChangeOwner(); },
			theme: 'lightWide'
		});
		$('.dropkick_lightWide').dropkick({ theme: 'lightWide' });
	};

	if($('.dropkick_lightNarrow').length) { $('.dropkick_lightNarrow').dropkick({ theme: 'lightNarrow' }); };

	// Global navigation action dropdowns
	$('a.global_nav_action_trigger').on('click', function(e) {
		eatEvent(e);
		var $this = $(this);
		if(!$this.hasClass('open')) {
			$('a.global_nav_action_trigger.open').next('div.global_nav_action_dropdown').toggle();
			$('a.global_nav_action_trigger.open').removeClass('open');
			$this.addClass('open').next('div.global_nav_action_dropdown').toggle();
			$('.first_child_input').focus();
		} else {
			$this.removeClass('open').next('div.global_nav_action_dropdown').toggle();
		};
	});

	var mouse_is_inside = false;
	$('div.global_nav_action_dropdown').hover(function() { mouse_is_inside = true; }, function(){ mouse_is_inside = false; });

	$('a.global_nav_action_trigger.open').on('click', function() {
		if(!mouse_is_inside) {
			$(this).removeClass('open').next('div.global_nav_action_dropdown').toggle();
		};
	});

	// Shop filter dropdown
	$('a.shop_filter_trigger').on('click', function(e) {
		eatEvent(e);
		var $this = $(this);
		if(!$this.hasClass('open')) {
			$('a.shop_filter_trigger.open').removeClass('open').next('ul.shop_filter_dropdown').toggle();
			$this.addClass('open').next('ul.shop_filter_dropdown').toggle();
		} else {
			$this.removeClass('open').next('ul.shop_filter_dropdown').toggle();
		};
	});

	$('a.shop_filter_trigger.open').on('click', function() {
		$(this).removeClass('open').find('ul.shop_filter_dropdown').toggle();
	});

	// Show option dropdown on list items
	// Show option dropdown on wall items
	$(elementById('container')).on({
        mouseenter : function(e) {
            eatEvent(e);
            $(this).find('a.list_item_dropdown_trigger').show();
        },
        mouseleave : function(e) {
            eatEvent(e);
            $(this).find('a.list_item_dropdown_trigger').hide();
        }
    }, 'div.list_item, div.new_list_item, div.wall_item');

	// Show option dropdown on comment items
	$('div.wall_item_comment').on({
        mouseenter : function(e) {
            eatEvent(e);
            $(this).find('a.comment_item_delete_trigger').show();
        },
        mouseleave : function(e) {
            eatEvent(e);
            $(this).find('a.comment_item_delete_trigger').hide();
        }
    });
	// Option dropdown
	$('a.item_dropdown_trigger').on('click', function(e) {
		eatEvent(e);
		var $this = $(this);
		if($this.hasClass('open')) {
			$this.removeClass('open').find('ul.item_dropdown_options').removeClass('open').toggle();
		} else {
			$this.addClass('open');
            $(document).on('click.dropdownnamespace', function() {
                $this.removeClass('open').find('ul.item_dropdown_options').removeClass('open').toggle();
                $this.next('ul.item_dropdown_options').toggle();
                $(document).off('click.dropdownnamespace');
            });
		};
        $this.next('ul.item_dropdown_options').toggle();
	});

	// Read more function
	$('.revealmore').on('click', function(e) {
		eatEvent(e);
		var denne = this, item_meta = denne.parentNode.parentNode.parentNode, id = denne.getAttribute('data-id'), shortdes = $('.short_desc_'+id), icon = '<i class="readmore_icon"></i>';
		if(shortdes.hasClass('dn')) {
			item_meta.parentNode.style.height = '100px';
			item_meta.style.marginTop = '0';
			item_meta.style.position = 'absolute';
			emptyElement(denne);
			denne.insertAdjacentHTML('beforeend', icon + denne.getAttribute('data-open'));
		} else {
			item_meta.style.marginTop = '-100px';
			item_meta.style.position = 'relative';
			item_meta.parentNode.style.height = '100%';
			emptyElement(denne);
			denne.insertAdjacentHTML('beforeend', icon + denne.getAttribute('data-close'));
		};
		shortdes.toggleClass('dn');
		$('.long_desc_'+id).toggleClass('dn');
	});

	// Hide/show content functions
	var contentHidden = $('.content_hidden'), contentShown = $('.content_shown'), hideContent = $('.hide_content'), showContent = $('.show_content');
	hideContent.on('click', 'a', function(e) {
		eatEvent(e);
		var val = this.getAttribute('rel');
		$.post(site_url+'block-visibility/'+val+'/0');
		contentShown.addClass('dn');
		contentHidden.removeClass('dn');
		hideContent.addClass('dn');
	});
	showContent.on('click', 'a', function(e) {
		eatEvent(e);
		var val = this.getAttribute('rel');
		$.post(site_url+'block-visibility/'+val+'/1');
		contentHidden.addClass('dn');
		contentShown.removeClass('dn');
		hideContent.removeClass('dn');
	});

	// Usage statistics
	$('.usage_statistics_ribbon').on('click', function(e) {
		eatEvent(e);
		$(this).slideUp(100);
		$('.usage_statistics').delay(400).slideDown(200, 'swing');
	});

	$('.usage_statistics_close').on('click', function(e) {
        eatEvent(e);
		$('.usage_statistics').slideUp(200, 'swing');
		$('.usage_statistics_ribbon').delay(400).slideDown(100);
	});

	$('.widgets').on('submit', function(event) {
		var select = $(this).find('select'), selectedValues = [], errors = [];
		$('.errors').remove();
		// loop through every select
		select.each(function(index, value) {
			// this
			var self = this;
			// return -1 if the value is not found in the selectedValues array
			if($.inArray(self.value, selectedValues) == -1) {
				selectedValues.push(self.value);
			} else {
				// return -1 if the value is not found in the errors array
				if($.inArray(self.value, errors) == -1) {
					errors.push(self.value);
				};
			};
		});
		if(errors.length > 0) {
			event.preventDefault();
			errors.sort(function(a,b){return a-b});
			$(errors).each(function(index, element) {
				$('<p>There can be only one widget on position ' + element + '.</p>').addClass('errors').insertBefore('.standard_form_footer');
			});
		};
	});

	if(elementById('accept-cookie-bar')) {
		$(elementById('accept-cookie-but')).on('click', function() {
			createCookie('EUCookieLaw', 'accepted', 365);
		});
	};

	$(elementById('right_column')).on('click', '.slide-icon', function() {
		var that = $(this),
			parentElem = that.parents('.widget'),
			id = elementById('user').value,
			widgetId = parentElem.data('id'),
			widgetState = (parentElem.data('state') === 'open') ? 1 : 0;
		parentElem.find('.widget-body').slideToggle();
		parentElem.startLoading();
		$.post(site_url + 'players/ajaxwidgetstatus', {
			'isOpen': widgetState,
			'widgetId': widgetId
		}, function(data) {
			if (data.isOpen === true) {
				parentElem.data('state', 'open');
				that[0].setAttribute('title', 'Collapse this widget.');
			} else {
				parentElem.data('state', 'closed');
				that[0].setAttribute('title', 'Expand this widget.');
			};
		});
		parentElem.stopLoading();
	});

	$(elementById('right_column')).on('click', '.close-icon', function() {
		var that = $(this),
			parentElem = that.parents('.widget'),
			id = elementById('user').value,
			widgetId = parentElem.data('id');
		parentElem.startLoading();
		$.post(site_url + 'players/ajaxwidgetvisibility', {
			widgetId: widgetId
		}, function(data) {
			if (data.isVisible === false) {
				parentElem.slideUp(function() {
					$('<p class="widget-is-hidden">This widget is now hidden. Bring it back from <a href="' + site_url + 'players/edit/widgets">Widgets Settings</a>.</p>').insertAfter(parentElem);
					parentElem.remove();
				});
			};
		});
		parentElem.stopLoading();
	});

	if ($(".recent-forum-threads").data("state") === "open") {
		$(".forum-threads").hide(); // Hide all content
		$(".forum-threads:first").addClass("active").show(); // Activate first tab
	}

	// Tabs - On Click
	$(".change-forum").on('click', 'a', function(e) {
		e.preventDefault();

		var that = $(this),
			thisParentElem = that.parents('.forum-threads');

		$(".forum-threads").removeClass("active"); // Remove any "active" class
		$(".forum-threads").hide(); // Hide all content

		if (that.hasClass('next-forum')) {
			var nextParentElem = thisParentElem.next();
			nextParentElem.addClass("active").fadeIn(); // Add "active" class to selected tab
		} else {
			var prevParentElem = thisParentElem.prev();
			prevParentElem.addClass("active").fadeIn(); // Add "active" class to selected tab
		}
	});
});
