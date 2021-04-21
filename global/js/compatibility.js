/*
 * jQuery Easing Compatibility v1 - http://gsgd.co.uk/sandbox/jquery.easing.php
 * Adds compatibility for applications that use the pre 1.2 easing names
 * Copyright (c) 2007 George Smith
 * Licensed under the MIT License:
 *   http://www.opensource.org/licenses/mit-license.php
 */
jQuery.extend( jQuery.easing, {
	easeIn: function (x, t, b, c, d) { return jQuery.easing.easeInQuad(x, t, b, c, d); },
	easeOut: function (x, t, b, c, d) { return jQuery.easing.easeOutQuad(x, t, b, c, d); },
	easeInOut: function (x, t, b, c, d) { return jQuery.easing.easeInOutQuad(x, t, b, c, d); },
	expoin: function(x, t, b, c, d) { return jQuery.easing.easeInExpo(x, t, b, c, d); },
	expoout: function(x, t, b, c, d) { return jQuery.easing.easeOutExpo(x, t, b, c, d); },
	expoinout: function(x, t, b, c, d) { return jQuery.easing.easeInOutExpo(x, t, b, c, d); },
	bouncein: function(x, t, b, c, d) { return jQuery.easing.easeInBounce(x, t, b, c, d); },
	bounceout: function(x, t, b, c, d) { return jQuery.easing.easeOutBounce(x, t, b, c, d); },
	bounceinout: function(x, t, b, c, d) { return jQuery.easing.easeInOutBounce(x, t, b, c, d); },
	elasin: function(x, t, b, c, d) { return jQuery.easing.easeInElastic(x, t, b, c, d); },
	elasout: function(x, t, b, c, d) { return jQuery.easing.easeOutElastic(x, t, b, c, d); },
	elasinout: function(x, t, b, c, d) { return jQuery.easing.easeInOutElastic(x, t, b, c, d); },
	backin: function(x, t, b, c, d) { return jQuery.easing.easeInBack(x, t, b, c, d); },
	backout: function(x, t, b, c, d) { return jQuery.easing.easeOutBack(x, t, b, c, d); },
	backinout: function(x, t, b, c, d) { return jQuery.easing.easeInOutBack(x, t, b, c, d); }
});

/* support array filtering from JavaScript 1.6 (ECMA-262) */
if(!Array.prototype.filter) {
  Array.prototype.filter = function(fun /*, thisp*/) {
    'use strict';
    if(this === null) { throw new TypeError(); };
    var t = Object(this), len = t["length"] >>> 0, res, thisp, i, val;
    if(typeof fun !== 'function') { throw new TypeError(); };
    res = [], thisp = arguments[1];
    for(i = 0; i < len; ++i) {
      if(i in t) {
        val = t[i];
        if(fun["call"](thisp, val, i, t)) { res["push"](val); };
      };
    };
    return res;
  };
};

/* support array indexof from JavaScript 1.6 (ECMA-262) */
if(!Array.prototype.indexOf) {
  Array.prototype.indexOf = function(searchElement /*, fromIndex */ ) {
    'use strict';
    if(this === null) { throw new TypeError(); };
    var n, k, t = Object(this), len = t.length >>> 0;
    if(len === 0) { return -1; };
    n = 0;
    if(arguments.length > 1) {
      n = Number(arguments[1]);
      if(n != n) { n = 0; }  // shortcut for verifying if it's NaN
      else if(n !== 0 && n !== Infinity && n !== -Infinity) { n = (n > 0 || -1) * Math.floor(Math.abs(n)); };
    };
    if(n >= len) { return -1; };
    for(k = n >= 0 ? n : Math.max(len - Math.abs(n), 0); k < len; ++k) { if(k in t && t[k] === searchElement) { return k; }; };
    return -1;
  };
};

// Fallback if no cookies or html5 sessionstorage is available
var are_cookies_enabled = function() {
	var cookieEnabled = (navigator.cookieEnabled) ? true : false;
	if(navigator.cookieEnabled === consts.undefined && !cookieEnabled) { 
		document.cookie = "testcookie";
		cookieEnabled = (document.cookie.indexOf("testcookie") !== -1) ? true : false;
	};
	return (cookieEnabled);
};
if(are_cookies_enabled() === true) {
    var createCookie = function(name,value,days) {
        var expires;
        if(days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 86400000));
            expires = "; expires=" + date.toGMTString();
        } else { expires = ""; };
        document.cookie = name + "=" + value + expires + "; path=/";
    };
    var readCookie = function(name) {
        var nameEQ = name + "=", ca = document.cookie.split(';'), end = ca.length;
        for(var i = 0; i < end; ++i) {
            var c = ca[i];
            while(c.charAt(0) === ' ') { c = c.substring(1, c.length); };
            if(c.indexOf(nameEQ) === 0) { return c.substring(nameEQ.length, c.length); };
        };
        return null;
    };
    var eraseCookie = function(name) { createCookie(name, "", -1); };
} else if(window.sessionStorage) {
    createCookie = function(name, value, days) { window.sessionStorage.setItem(name, value); };
    readCookie = function(name) { return window.sessionStorage.getItem(name); };
    eraseCookie = function(name) { window.sessionStorage.removeItem(name); };
} else {
    /*
    sessvars ver 1.01
    - JavaScript based session object
    copyright 2008 Thomas Frank
    This EULA grants you the following rights:
    Installation and Use. You may install and use an unlimited number of copies of the SOFTWARE PRODUCT.
    Reproduction and Distribution. You may reproduce and distribute an unlimited number of copies of the SOFTWARE PRODUCT either in whole or in part; each copy should include all copyright and trademark notices, and shall be accompanied by a copy of this EULA. Copies of the SOFTWARE PRODUCT may be distributed as a standalone product or included with your own product.
    Commercial Use. You may sell for profit and freely distribute scripts and/or compiled scripts that were created with the SOFTWARE PRODUCT.
    */
    var sessvars = function() {
        var x = {};
        x.$ = {
            prefs : {
                memLimit : 2000,
                autoFlush : true,
                crossDomain : false,
                includeProtos : false,
                includeFunctions : false
            }, parent : x,
            clearMem : function() {
                for(var i in this.parent) { if(i !== "$") { this.parent[i] = undefined; }; };
                this.flush();
            },
            usedMem : function() {
                x={};
                return Math.round(this.flush(x)/1024);
            },
            usedMemPercent:function() { return Math.round(this.usedMem()/this.prefs.memLimit); },
            flush:function(x) {
                var y, o = {}, j = this.$$, x = x || top;
                for(var i in this.parent) { o[i] = this.parent[i]; };
                o.$ = this.prefs, j.includeProtos = this.prefs.includeProtos, j.includeFunctions = this.prefs.includeFunctions, y = this.$$.make(o);
                if(x !== top) { return y.length; };
                if(y.length/1024 > this.prefs.memLimit) { return false; };
                x.name = y;
                return true;
            },
            getDomain:function() {
                    var l = location.href, l = l.split("///").join("//"),  l = l.substring(l.indexOf("://")+3).split("/")[0];
                    while(l.split(".").length > 2) { l = l.substring(l.indexOf(".")+1); };
                    return l;
            },
            debug:function(t) {
                var t = t || this, a = arguments.callee;
                if(!document.body) { setTimeout(function() { a(t); }, 200); return; };
                t.flush();
                var d = document.getElementById("sessvarsDebugDiv");
                if(!d){ d = document.createElement("div"); document.body.insertBefore(d, document.body.firstChild); };
                d.id = "sessvarsDebugDiv";
                d.innerHTML = '<div style="line-height:20px;padding:5px;font-size:11px;font-family:Verdana,Arial,Helvetica;'+
                              'z-index:10000;background:#FFFFCC;border: 1px solid #333;margin-bottom:12px">'+
                              '<b style="font-family:Trebuchet MS;font-size:20px">sessvars.js - debug info:</b><br/><br/>'+
                              'Memory usage: '+t.usedMem()+' Kb ('+t.usedMemPercent()+'%)&nbsp;&nbsp;&nbsp;'+
                              '<span style="cursor:pointer"><b>[Clear memory]</b></span><br/>'+
                              top.name.split('\n').join('<br/>')+'</div>';
                d.getElementsByTagName('span')[0].onclick = function() { t.clearMem(); location.reload(); };
            },
            init:function() {
                var o = {}, t = this;
                try { o = this.$$.toObject(top.name); } catch(e) { o = {}; };
                this.prefs = o.$ || t.prefs;
                if(this.prefs.crossDomain || this.prefs.currentDomain === this.getDomain()){ for(var i in o) { this.parent[i]=o[i]; }; }
                else { this.prefs.currentDomain = this.getDomain(); };
                this.parent.$ = t;
                t.flush();
                var f = function() { if(t.prefs.autoFlush) { t.flush(); }; };
                if(window["addEventListener"]) { addEventListener("unload", f, false); }
                else if(window["attachEvent"]) { window.attachEvent("onunload", f); }
                else { this.prefs.autoFlush = false; };
            }
        };
        x.$.$$ = {
            compactOutput : false, 		
            includeProtos : false, 	
            includeFunctions : false,
            detectCirculars : true,
            restoreCirculars : true,
            make : function(arg, restore) {
                this.restore = restore, this.mem = [], this.pathMem = [];
                return this.toJsonStringArray(arg).join('');
            },
            toObject : function(x) {
                if(!this.cleaner) {
                    try { this.cleaner = new RegExp('^("(\\\\.|[^"\\\\\\n\\r])*?"|[,:{}\\[\\]0-9.\\-+Eaeflnr-u \\n\\r\\t])+?$'); }
                    catch(a) { this.cleaner = /^(true|false|null|\[.*\]|\{.*\}|".*"|\d+|\d+\.\d+)$/; };
                };
                if(!this.cleaner.test(x)) { return {}; };
                eval("this.myObj=" + x);
                if(!this.restoreCirculars || !alert) { return this.myObj; };
                if(this.includeFunctions) {
                    var x = this.myObj;
                    for(var i in x) {
                        if(typeof x[i] === "string" && !x[i].indexOf("JSONincludedFunc:")) {
                            x[i] = x[i].substring(17);
                            eval("x[i]=" + x[i]);
                        };
                    };
                };
                this.restoreCode = [];
                this.make(this.myObj, true);
                var r = this.restoreCode.join(";") + ";";
                eval('r=r.replace(/\\W([0-9]{1,})(\\W)/g,"[$1]$2").replace(/\\.\\;/g,";")');
                eval(r);
                return this.myObj;
            },
            toJsonStringArray : function(arg, out) {
                if(!out) { this.path = []; };
                out = out || [];
                var u; // undefined
                switch(typeof arg) {
                    case 'object':
                        this.lastObj = arg;
                        if(this.detectCirculars) {
                            var m = this.mem, n = this.pathMem, end = m.length;
                            for(var i = 0; i < end; ++i){ if(arg === m[i]) { out.push('"JSONcircRef:' + n[i] + '"'); return out; }; };
                            m.push(arg);
                            n.push(this.path.join("."));
                        };
                        if(arg) {
                            if(arg.constructor === Array) {
                                out.push('[');
                                for(var i = 0, end = arg.length; i < end; ++i) {
                                    this.path.push(i);
                                    if(i > 0) { out.push(',\n'); };
                                    this.toJsonStringArray(arg[i], out);
                                    this.path.pop();
                                };
                                out.push(']');
                                return out;
                            } else if(arg.toString !== consts.undefined) {
                                out.push('{');
                                var first = true;
                                for(var i in arg) {
                                    if(!this.includeProtos && arg[i] === arg.constructor.prototype[i]) { continue; };
                                    this.path.push(i);
                                    var curr = out.length; 
                                    if(!first) { out.push(this.compactOutput ? ',' : ',\n'); };
                                    this.toJsonStringArray(i, out);
                                    out.push(':');                    
                                    this.toJsonStringArray(arg[i], out);
                                    if(out[out.length - 1] === u) { out.splice(curr, out.length - curr); }
                                    else { first = false; };
                                    this.path.pop();
                                };
                                out.push('}');
                                return out;
                            };
                            return out;
                        };
                        out.push('null');
                        return out;
                    case 'unknown':
                    case consts.undefined:
                    case 'function':
                        if(!this.includeFunctions) { out.push(u); return out; };
                        arg = "JSONincludedFunc:" + arg;
                        out.push('"');
                        var a = ['\n','\\n','\r','\\r','"','\\"'];
                        arg += "";
                        for(var i = 0; i < 6; i += 2) { arg = arg.split(a[i]).join(a[i+1]); };
                        out.push(arg);
                        out.push('"');
                        return out;
                    case 'string':
                        if(this.restore && arg.indexOf("JSONcircRef:") === 0) { this.restoreCode.push('this.myObj.' + this.path.join(".") + "=" + arg.split("JSONcircRef:").join("this.myObj.")); };
                        out.push('"');
                        var a = ['\n','\\n','\r','\\r','"','\\"'];
                        arg += "";
                        for(var i = 0; i < 6; i += 2) { arg = arg.split(a[i]).join(a[i+1]); };
                        out.push(arg);
                        out.push('"');
                        return out;
                    default:
                        out.push(String(arg));
                        return out;
                };
            }
        };
        x.$.init();
        return x;
    }();
    createCookie = function(name, value, days) { sessvars[name] = value; };
    readCookie = function(name) { return sessvars[name]; };
    eraseCookie = function(name) { sessvars[name] = ""; };
};

/*
 * classList.js: Cross-browser full element.classList implementation.
 * 2014-01-31
 * By Eli Grey, http://eligrey.com
 * Public Domain.
 * NO WARRANTY EXPRESSED OR IMPLIED. USE AT YOUR OWN RISK.
 *global self, document, DOMException
 *! @source http://purl.eligrey.com/github/classList.js/blob/master/classList.js */
if("document" in self && !("classList" in document.createElement("_"))) {
    ;(function(view) {
        "use strict";
        if(!('Element' in view)) return;
        var classListProp = "classList"
            , protoProp = "prototype"
            , elemCtrProto = view.Element[protoProp]
            , objCtr = Object
            , strTrim = String[protoProp].trim || function() {
                return this.replace(/^\s+|\s+$/g, "");
            }
            , arrIndexOf = Array[protoProp].indexOf || function(item) {
                var i = 0, len = this.length;
                for(; i < len; i++) {
                    if(i in this && this[i] === item) {
                        return i;
                    };
                };
                return -1;
            }
            // Vendors: please allow content code to instantiate DOMExceptions
            , DOMEx = function(type, message) {
                this.name = type;
                this.code = DOMException[type];
                this.message = message;
            }
            , checkTokenAndGetIndex = function(classList, token) {
                if(token === "") {
                    throw new DOMEx(
                          "SYNTAX_ERR"
                        , "An invalid or illegal string was specified"
                    );
                };
                if(/\s/.test(token)) {
                    throw new DOMEx(
                          "INVALID_CHARACTER_ERR"
                        , "String contains an invalid character"
                    );
                };
                return arrIndexOf.call(classList, token);
            }
            , ClassList = function(elem) {
                var trimmedClasses = strTrim.call(elem.getAttribute("class") || "")
                    , classes = trimmedClasses ? trimmedClasses.split(/\s+/) : []
                    , i = 0
                    , len = classes.length;
                for(; i < len; i++) {
                    this.push(classes[i]);
                };
                this._updateClassName = function() {
                    elem.setAttribute("class", this.toString());
                };
            }
            , classListProto = ClassList[protoProp] = []
            , classListGetter = function() {
                return new ClassList(this);
            };
        // Most DOMException implementations don't allow calling DOMException's toString()
        // on non-DOMExceptions. Error's toString() is sufficient here.
        DOMEx[protoProp] = Error[protoProp];
        classListProto.item = function(i) {
            return this[i] || null;
        };
        classListProto.contains = function(token) {
            token += "";
            return checkTokenAndGetIndex(this, token) !== -1;
        };
        classListProto.add = function() {
            var tokens = arguments
                , i = 0
                , l = tokens.length
                , token
                , updated = false;
            do {
                token = tokens[i] + "";
                if(checkTokenAndGetIndex(this, token) === -1) {
                    this.push(token);
                    updated = true;
                };
            } while(++i < l);
            if(updated) {
                this._updateClassName();
            };
        };
        classListProto.remove = function() {
            var tokens = arguments
                , i = 0
                , l = tokens.length
                , token
                , updated = false;
            do {
                token = tokens[i] + "";
                var index = checkTokenAndGetIndex(this, token);
                if(index !== -1) {
                    this.splice(index, 1);
                    updated = true;
                };
            } while(++i < l);
            if(updated) {
                this._updateClassName();
            };
        };
        classListProto.toggle = function(token, force) {
            token += "";
            var result = this.contains(token)
                , method = result ?
                    force !== true && "remove"
                : force !== false && "add";
            if(method) {
                this[method](token);
            };
            return !result;
        };
        classListProto.toString = function() {
            return this.join(" ");
        };
        if(objCtr.defineProperty) {
            var classListPropDesc = {
                  get: classListGetter
                , enumerable: true
                , configurable: true
            };
            try {
                objCtr.defineProperty(elemCtrProto, classListProp, classListPropDesc);
            } catch(ex) { // IE 8 doesn't support enumerable:true
                if(ex.number === -0x7FF5EC54) {
                    classListPropDesc.enumerable = false;
                    objCtr.defineProperty(elemCtrProto, classListProp, classListPropDesc);
                };
            };
        } else if(objCtr[protoProp].__defineGetter__) {
            elemCtrProto.__defineGetter__(classListProp, classListGetter);
        };
    }(self));
};

// From https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/keys
if(!Object.keys) {
  Object.keys = (function() {
    'use strict';
    var hasOwnProperty = Object.prototype.hasOwnProperty,
        hasDontEnumBug = !({toString: null}).propertyIsEnumerable('toString'),
        dontEnums = [
          'toString',
          'toLocaleString',
          'valueOf',
          'hasOwnProperty',
          'isPrototypeOf',
          'propertyIsEnumerable',
          'constructor'
        ],
        dontEnumsLength = dontEnums.length;

    return function(obj) {
      if(typeof obj !== 'object' && (typeof obj !== 'function' || obj === null)) {
        throw new TypeError('Object.keys called on non-object');
      };
      var result = [], prop, i;
      for(prop in obj) {
        if(hasOwnProperty.call(obj, prop)) {
          result.push(prop);
        }
      };
      if(hasDontEnumBug) {
        for(i = 0; i < dontEnumsLength; ++i) {
          if(hasOwnProperty.call(obj, dontEnums[i])) {
            result.push(dontEnums[i]);
          };
        };
      };
      return result;
    };
  }());
};