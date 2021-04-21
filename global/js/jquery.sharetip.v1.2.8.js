/**
 * jQuery Tools - Tooltip v1.3.0 - UI essentials
 * NO COPYRIGHTS OR LICENSES. DO WHAT YOU LIKE.
 * Since: November 2008
 */
(function($) {
	$.tools = $.tools || {version: "1.2.8"};
	$.tools.tooltip = {
		conf: {
			effect: 'toggle',
			fadeOutSpeed: "fast",
			predelay: 0,
			delay: 30,
			opacity: 1,
			tip: 0,
            fadeIE: false, // enables fade effect in IE
			position: ['top', 'center'],
			offset: [0, 0],
			relative: false,
			cancelDefault: true,
			events: {
				def: "mouseenter,mouseleave",
				input: "focus,blur",
				widget: "focus mouseenter,blur mouseleave",
				tooltip: "mouseenter,mouseleave"
			},
			layout: '<div/>',
			tipClass: 'tooltip'
		},
		addEffect: function(name, loadFn, hideFn) { effects[name] = [loadFn, hideFn]; }
	};
	var effects = {
		toggle: [
			function(done) {
				var conf = this.getConf(), tip = this.getTip(), o = conf.opacity;
				if(o < 1) { tip.css({opacity: o}); };
				tip.show();
				done.call();
			},
			function(done) {
				this.getTip().hide();
				done.call();
			}
		],
		fade: [
			function(done) {
				var conf = this.getConf();
				if(!/msie/.test(navigator.userAgent.toLowerCase()) || conf.fadeIE) { this.getTip().fadeTo(conf.fadeInSpeed, conf.opacity, done); }
				else {
					this.getTip().show();
					done();
				};
			},
			function(done) {
				var conf = this.getConf();
				if(!/msie/.test(navigator.userAgent.toLowerCase()) || conf.fadeIE) { this.getTip().fadeOut(conf.fadeOutSpeed, done); }
				else {
					this.getTip().hide();
					done();
				};
			}
		]
	};
	function getPosition(trigger, tip, conf) {
		var top = conf.relative ? trigger.position().top : trigger.offset().top, 
			 left = conf.relative ? trigger.position().left : trigger.offset().left,
			 pos = conf.position[0];
		top -= tip.outerHeight() - conf.offset[0];
		left += trigger.outerWidth() + conf.offset[1];
		if(/iPad/i.test(navigator.userAgent)) { top -= $(window).scrollTop(); };
		var height = tip.outerHeight() + trigger.outerHeight();
		if(pos === 'center') { top += height / 2; };
		if(pos === 'bottom') { top += height; };
        pos = conf.position[1];
		var width = tip.outerWidth() + trigger.outerWidth();
		if(pos === 'center') { left -= width / 2; };
		if(pos === 'left') { left -= width; };
		return {top: top, left: left};
	};
	function Tooltip(trigger, conf) {
		var self = this,
			 fire = trigger.add(self),
			 tip,
			 timer = 0,
			 pretimer = 0,
			 title = trigger.attr("title"),
			 tipAttr = trigger.attr("data-tooltip"),
			 effect = effects[conf.effect],
			 shown,
			 isInput = trigger.is(":input"),
			 isWidget = isInput && trigger.is(":checkbox, :radio, select, :button, :submit"),
			 type = trigger.attr("type"),
			 evt = conf.events[type] || conf.events[isInput ? (isWidget ? 'widget' : 'input') : 'def'];
		if(!effect) { throw "Nonexistent effect \"" + conf.effect + "\""; };
		evt = evt.split(/,\s*/);
		if(evt.length !== 2) { throw "Tooltip: bad events configuration for " + type; };
		trigger.on(evt[0], function(e) {
			clearTimeout(timer);
			if(conf.predelay) { pretimer = setTimeout(function() { self.show(e); }, conf.predelay);	}
            else { self.show(e); };
		}).on(evt[1], function(e) {
			clearTimeout(pretimer);
			if(conf.delay) { timer = setTimeout(function() { self.hide(e); }, conf.delay); }
            else { self.hide(e); };
		});
		if(title && conf.cancelDefault) {
			trigger.removeAttr("title");
			trigger.data("title", title);
		};
		$.each("onHide,onBeforeShow,onShow,onBeforeHide".split(","), function(i, name) {
			if($.isFunction(conf[name])) { $(self).on(name, conf[name]); };
			self[name] = function(fn) {
				if(fn) { $(self).on(name, fn); };
				return self;
			};
		});
		$.extend(self, {
			show: function(e) {
				if(!tip) {
					if(tipAttr) { tip = $(tipAttr); }
                    else if(conf.tip) { tip = $(conf.tip).eq(0); }
                    else if(title) { tip = $(conf.layout).addClass(conf.tipClass).appendTo(document.body).hide().append(title); }
                    else {
						tip = trigger.find('.' + conf.tipClass);
						if(!tip.length) { tip = trigger.next(); };
						if(!tip.length) { tip = trigger.parent().next(); };
					};
					if(!tip.length) { throw "Cannot find tooltip for " + trigger; };
				};
			 	if(self.isShown()) { return self; };
			 	tip.stop(true, true);
				var pos = getPosition(trigger, tip, conf);
				if(conf.tip) { tip.html(trigger.data("title")); };
				e = $.Event();
				e.type = "onBeforeShow";
				fire.trigger(e, [pos]);
				if(e.isDefaultPrevented()) { return self; };
				pos = getPosition(trigger, tip, conf);
				tip.css({position:'absolute', top: pos.top, left: pos.left});
				shown = true;
				effect[0].call(self, function() {
					e.type = "onShow";
					shown = 'full';
					fire.trigger(e);
				});
				var event = conf.events.tooltip.split(/,\s*/);
				if(!tip.data("__set")) {
					tip.off(event[0]).on(event[0], function() {
						clearTimeout(timer);
						clearTimeout(pretimer);
					});
					if(event[1] && !trigger.is("input:not(:checkbox, :radio), textarea")) {
						tip.off(event[1]).on(event[1], function(e) {
							if(e.relatedTarget !== trigger[0]) { trigger.trigger(evt[1].split(" ")[0]); };
						});
					};
					if(!conf.tip) tip.data("__set", true);
				};
				return self;
			},
			hide: function(e) {
				if(!tip || !self.isShown()) { return self; };
				e = $.Event();
				e.type = "onBeforeHide";
				fire.trigger(e);
				if(e.isDefaultPrevented()) { return; };
				shown = false;
				effects[conf.effect][1].call(self, function() {
					e.type = "onHide";
					fire.trigger(e);
				});
				return self;
			},
			isShown: function(fully) { return fully ? shown === 'full' : shown; },
			getConf: function() { return conf; },
			getTip: function() { return tip; },
			getTrigger: function() { return trigger; }
		});
	};
	$.fn.tooltip = function(conf) {
		conf = $.extend(true, {}, $.tools.tooltip.conf, conf);
		if(typeof conf.position === 'string') { conf.position = conf.position.split(/,?\s/); };
		this.each(function() {
			if($(this).data("tooltip") === consts.undefined) {
			    api = new Tooltip($(this), conf);
			    $(this).data("tooltip", api);
			};
		});
		return conf.api ? api: this;
	};
})(jQuery);
/**
 * Tooltip Slide Effect
 * Since: September 2009
 */
(function($) {
	var t = $.tools.tooltip;
	$.extend(t.conf, {
		direction: 'up',
		bounce: false,
		slideOffset: 10,
		slideInSpeed: 200,
		slideOutSpeed: 200,
		slideFade: !/msie/.test(navigator.userAgent.toLowerCase())
	});
	var dirs = {
		up: ['-', 'top'],
		down: ['+', 'top'],
		left: ['-', 'left'],
		right: ['+', 'left']
	};
	t.addEffect("slide", function(done) {
			var conf = this.getConf(),
				 tip = this.getTip(),
				 params = conf.slideFade ? {opacity: conf.opacity} : {},
				 dir = dirs[conf.direction] || dirs.up;
			params[dir[1]] = dir[0] +'='+ conf.slideOffset;
			if(conf.slideFade) { tip.css({opacity:0}); };
			tip.show().animate(params, conf.slideInSpeed, done);
		},
		function(done) {
			var conf = this.getConf(),
				 offset = conf.slideOffset,
				 params = conf.slideFade ? {opacity: 0} : {},
				 dir = dirs[conf.direction] || dirs.up;
			var sign = "" + dir[0];
			if(conf.bounce) { sign = sign === '+' ? '-' : '+'; };
			params[dir[1]] = sign + '=' + offset;
			this.getTip().animate(params, conf.slideOutSpeed, function() {
				$(this).hide();
				done.call();
			});
		}
	);
})(jQuery);
/**
 * Tooltip Dynamic Positioning
 * Since: July 2009
 */
(function($) {
	var t = $.tools.tooltip;	
	t.dynamic = { conf: { classNames: "top right bottom left" } };
	function getCropping(el) {
		var w = $(window), right = w.width() + w.scrollLeft(), bottom = w.height() + w.scrollTop();
		return [
			el.offset().top <= w.scrollTop(),
			right <= el.offset().left + el.width(),
			bottom <= el.offset().top + el.height(),
			w.scrollLeft() >= el.offset().left
		];
	};
	function isVisible(crop) {
		var i = crop.length;
		while(i--) { if(crop[i]) { return false; }; };
		return true;
	};
	$.fn.dynamic = function(conf) {
		if(typeof conf === 'number') { conf = {speed: conf}; };
		conf = $.extend({}, t.dynamic.conf, conf);
		var confOrigin = $.extend(true, {}, conf), cls = conf.classNames.split(/\s/), orig, ret;
		this.each(function() {
			var api = $(this).tooltip().onBeforeShow(function(e, pos) {
				var tip = this.getTip(), tipConf = this.getConf();
				if(!orig) {
					orig = [
						tipConf.position[0],
						tipConf.position[1],
						tipConf.offset[0],
						tipConf.offset[1],
						$.extend({}, tipConf)
					];
				};
				$.extend(tipConf, orig[4]);
				tipConf.position = [orig[0], orig[1]];
				tipConf.offset = [orig[2], orig[3]];
				tip.css({
					visibility: 'hidden',
					position: 'relative',
					top: pos.top,
					left: pos.left
				}).show();
				var conf = $.extend(true,{},confOrigin), crop = getCropping(tip);
				if(!isVisible(crop)) {
					if(crop[2]) { $.extend(tipConf, conf.top); tipConf.position[0] = 'top'; tip.addClass(cls[0]); };
					if(crop[3]) { $.extend(tipConf, conf.right); tipConf.position[1] = 'right'; tip.addClass(cls[1]); };
					if(crop[0]) { $.extend(tipConf, conf.bottom); tipConf.position[0] = 'bottom'; tip.addClass(cls[2]); };
					if(crop[1]) { $.extend(tipConf, conf.left); tipConf.position[1] = 'left'; tip.addClass(cls[3]); };
					if(crop[0] || crop[2]) { tipConf.offset[0] *= -1; };
					if(crop[1] || crop[3]) { tipConf.offset[1] *= -1; };
				};
				tip.css({visibility: 'visible'}).hide();
			});
			api.onBeforeShow(function() {
				var c = this.getConf(), tip = this.getTip();
				setTimeout(function() {
					c.position = [orig[0], orig[1]];
					c.offset = [orig[2], orig[3]];
				}, 0);
			});
			api.onHide(function() {
				var tip = this.getTip;
				tip.removeClass(conf.classNames);
			});
			ret = api;
		});
		return conf.api ? ret : this;
	};
})(jQuery);