/*
 * DropKick 2.0.0
 *
 * Highly customizable <select> lists
 * https://github.com/robdel12/DropKick
 *
*/

// Enable some stuff for IE 8
;(function(){Array.prototype.indexOf||(Array.prototype.indexOf=function(a,b){var c,e,d=b?b:0;if(!this)throw new TypeError;if(e=this.length,0===e||d>=e)return-1;for(0>d&&(d=e-Math.abs(d)),c=d;e>c;c++)if(this[c]===a)return c;return-1});if(Event.prototype.preventDefault||(Event.prototype.preventDefault=function(){this.returnValue=!1}),Event.prototype.stopPropagation||(Event.prototype.stopPropagation=function(){this.cancelBubble=!0}),!Element.prototype.addEventListener){var a=[],b=function(b,c){var d=this,e=function(a){a.target=a.srcElement,a.currentTarget=d,c.handleEvent?c.handleEvent(a):c.call(d,a)};if("DOMContentLoaded"==b){var f=function(a){"complete"==document.readyState&&e(a)};if(document.attachEvent("onreadystatechange",f),a.push({object:this,type:b,listener:c,wrapper:f}),"complete"==document.readyState){var g=new Event;g.srcElement=window,f(g)}}else this.attachEvent("on"+b,e),a.push({object:this,type:b,listener:c,wrapper:e})},c=function(b,c){for(var d=0;d<a.length;){var e=a[d];if(e.object==this&&e.type==b&&e.listener==c){"DOMContentLoaded"==b?this.detachEvent("onreadystatechange",e.wrapper):this.detachEvent("on"+b,e.wrapper);break}++d}};Element.prototype.addEventListener=b,Element.prototype.removeEventListener=c,HTMLDocument&&(HTMLDocument.prototype.addEventListener=b,HTMLDocument.prototype.removeEventListener=c),Window&&(Window.prototype.addEventListener=b,Window.prototype.removeEventListener=c)}})();

;(function( window, document, undefined ) {

window.isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test( navigator.userAgent );

var

  // Cache of DK Objects
  dkCache = [],

  // The Dropkick Object
  Dropkick = function( sel, opts ) {
    var i;

    // Prevent DK on mobile
    if ( window.isMobile && !opts.mobile ) {
      return false;
    }

    // Safety if `Dropkick` is called without `new`
    if ( this === window ) {
      return new Dropkick( sel, opts );
    }

    // Check if select has already been DK'd and return the DK Object
    if ( i = sel.getAttribute( "data-dkCacheId" ) ) {
      _.extend( dkCache[ i ].data.settings, opts );
      return dkCache[ i ];
    }

    if ( sel.nodeName === "SELECT" ) {
      return this.init( sel, opts );
    }
  },


  noop = function() {},

  // DK default options
  defaults = {

    // Called once after the DK element is inserted into the DOM
    initialize: noop,

    // Called every time the select changes value
    change: noop,
  },

  // The templates
  tmpl = {

    // The select template; The original select element is passed
    select: [
      '<div class="dk-select',
      '<%=( select.multiple ? "-multi" : "" )%> ',
      '<%=( select.className )%>" ',
      '<%=( select.id ? "id=\'dk-" + select.id + "\'" : "" )%> ',
      'tabindex="<%=( select.tabindex || 0 )%>">',
        '<% if ( !select.multiple ) { %>',
          '<div class="dk-selected">',
            '<%= select.options[ select.selectedIndex ].text %>',
          '</div>',
        '<% } %>',
        '<ul class="dk-select-options">',
          '<%=( options )%>',
        '</ul>',
      '</div>'
    ].join(""),

    // The optgroup template; An HTML string containing any sub-options is passed
    optgroup: [
      '<li class="dk-optgroup">',
        '<ul class="dk-optgroup-options">',
          '<%=( options )%>',
        '</ul>',
      '</li>'
    ].join(""),

    // The option template; The original option element is passed
    option: [
      '<li class="dk-option ',
      '<%=( option.className )%>',
      '<%=( option.selected ? " dk-option-selected" : "")%>',
      '<%=( option.disabled ? " dk-option-disabled" : "")%>" ',
      'data-value="<%=( option.value )%>">',
        '<%=( option.text )%>',
      '</li>'
    ].join("")
  },

  // Common Utilities
  _ = {

    hasClass: function( elem, classname ) {
      var reg = new RegExp( "(^|\\s+)" + classname + "(\\s+|$)" ); 
      return reg.test( elem.className );
    },

    addClass: function( elem, classname ) {
      if( !_.hasClass( elem, classname ) ) { 
        elem.className += " " + classname; 
      }
    },

    removeClass: function( elem, classname ) {
      var reg = new RegExp( "(^|\\s+)" + classname + "(\\s+|$)" );
      elem && ( elem.className = elem.className.replace( reg, " " ) );
    },

    toggleClass: function( elem, classname ) {
      var fn = _.hasClass( elem, classname ) ? "remove" : "add";
      _[ fn + "Class" ]( elem, classname );
    },

    // jQuery-like extend
    extend: function() {
      var p, options, i,
        target = arguments[ 0 ];

      for ( i = 1; i < arguments.length; i++ ) {
        options = arguments[ i ];
        for ( p in options ) {
          if ( options.hasOwnProperty( p ) ) {
            try {
              if ( options[ p ].constructor == Object ) {
                target[ p ] = _.extend( target[ p ], options[ p ] );
              } else {
                target[ p ] = options[ p ];
              }
            } catch( e ) {
              target[ p ] = options[ p ];
            }
          }
        }
      }

      return target;
    },

    // Modified John Resig's Micro-Templating
    tmpl: function( str, data ) {
      var fn = new Function( "obj",
        "p=[]; with(obj){p.push('" +
        str.replace(/[\r\t\n]/g, " ")
          .split("<%").join("\t")
          .replace(/((^|%>)[^\t]*)'/g, "$1\r")
          .replace(/\t=(.*?)%>/g, "',$1,'")
          .split("\t").join("');")
          .split("%>").join("p.push('")
          .split("\r").join("\\'") +
        "')} return p.join('')");
      return data ? fn( data ) : fn;
    },

    // Converts an HTML string to a single DOM node
    parseHTML: function( html ) {
      var tmp = document.createElement( "div" );
      tmp.innerHTML = html;
      return tmp.lastChild;
    },

    // Returns the x and y offset of an element
    position: function( elem, relative ) {
      var pos = { x: 0, y: 0 };

      relative = relative || document.body;

      while ( elem !== relative ) {
        pos.x += elem.offsetLeft;
        pos.y += elem.offsetTop;
        elem = elem.parentNode;
      }

      return pos;
    },

    // Returns the closest ancestor element of the child or false if not found
    closest: function( child, ancestor ) {
      while ( child ) {
        if ( child === ancestor ) {
          return child;
        }
        child = child.parentNode;
      }
      return false;
    }
  };


// Extends the DK objects's Prototype
Dropkick.prototype = {

  // Emulate some of HTMLSelectElement's methods

  /**
   * Adds an element to the select
   * @param {Node}         elem   HTMLOptionElement
   * @param {Node/Integer} before HTMLOptionElement/Index of Element
   */
  add: function( elem, before ) {
    var dkHTML, dkElem;

    if ( elem.nodeName === "OPTION" ) {
      dkHTML = _.tmpl( tmpl.option, { option: elem });
      dkElem = _.parseHTML( dkHTML );

      this.data.select.add( elem, before );

      if ( typeof before === "number" ) {
        before = this.item( before );
      } 

      if ( this.options.indexOf( before ) > -1 ) {
        before.parentNode.insertBefore( dkElem, before );
      } else {
        this.data.dk.lastChild.appendChild( dkElem );
      }

      if ( elem.selected ) {
        this.selectedOptions.push( dkElem );
      }

      this.options.push( dkElem );
    }
  },

  /**
   * Selects an option in the lists at the desired index
   * (negative numbers select from the end)
   * @param  {Integer} index Index of element (positive or negative)
   * @return {Node}          The DK option from the list, or null if not found
   */
  item: function( index ) {
    index = index < 0 ? this.options.length + index : index;
    return this.options[ index ] || null;
  },

  /**
   * Removes and element at the given index
   * @param  {Integer} index Index of element (positive or negative)
   */
  remove: function( index ) {
    var dkOption = this.item( index );
    dkOption.parentNode.removeChild( dkOption );
    this.options.splice( index, 1 );
    this.data.select.remove( index );
    this.select( this.data.select.selectedIndex );
  },

  /**
   * Initializes the DK Object
   * @param  {Node}   sel  [description]
   * @param  {Object} opts Options to override defaults
   * @return {Object}      The DK Object
   */
  init: function( sel, opts ) {
    var i;

    // Set some data on the DK Object
    this.data = {};
    this.data.dk = Dropkick.build( sel );
    this.data.select = sel;
    this.data.settings = _.extend( {}, defaults, opts );

    // Emulate some of HTMLSelectElement's properties
    this.value = sel.value;
    this.disabled = sel.disabled;
    this.form = sel.form;
    this.length = sel.length;
    this.options = Dropkick.findOptions( this.data.dk.children );
    this.multiple = sel.multiple;
    this.selectedIndex = sel.selectedIndex;
    this.selectedOptions = Dropkick.getSelected( this.options );

    // Insert the DK element before the original select
    sel.parentNode.insertBefore( this.data.dk, sel );

    // Bind events
    this.data.dk.addEventListener( "click", this );
    this.data.dk.addEventListener( "keydown", this );
    this.data.dk.addEventListener( "keypress", this );

    if ( this.form ) {
      this.form.addEventListener( "reset", this );
    }

    if ( !this.multiple ) {
      for ( i = 0; i < this.options.length; i++ ) {
        this.options[ i ].addEventListener( "mouseover", this );
      }
    }

    if ( dkCache.length == 0 ) {
      document.addEventListener( "click", Dropkick.onDocClick );
    }

    // Add the DK Object to the cache
    this.cacheID = dkCache.length;
    sel.setAttribute( "data-dkCacheId", this.cacheID );
    dkCache.push( this );

    // Call the optional initialize function
    this.data.settings.initialize( this );

    return this;
  },

  /**
   * Closes the DK dropdown
   */
  close: function() {
    var dk = this.data.dk;

    if ( this.multiple ) {
      return false;
    }

    for ( i = 0; i < this.options.length; i++ ) {
      _.removeClass( this.options[ i ], "dk-option-highlight" );
    }

    _.removeClass( dk.lastChild, "dk-select-options-highlight" );
    _.removeClass( dk, "dk-select-open-(up|down)" );
    this.isOpen = false;
  },

  /**
   * Opens the DK dropdown
   */
  open: function() {
    var dropHeight, above, below,
      dk = this.data.dk,
      dkOptsList = dk.lastChild,
      dkTop = _.position( dk ).y - window.scrollY,
      dkBottom = window.innerHeight - ( dkTop + dk.offsetHeight );

    if ( this.multiple ) {
      return false;
    }

    dkOptsList.style.display = "block";
    dropHeight = dkOptsList.offsetHeight;
    dkOptsList.style.display = "";

    above = dkTop > dropHeight;
    below = dkBottom > dropHeight;
    direction = above && !below ? "-up" : "-down";

    this.isOpen = true;
    _.addClass( dk, "dk-select-open" + direction );
    this._scrollTo( this.options.length - 1 );
    this._scrollTo( this.selectedIndex );
  },


  /**
   * Selects an option from the list
   * @param  {Node/Integer} elem     The element or index to select
   * @param  {Boolean}      disabled INTERNAL Selects disabled options
   * @return {Node}                  The selected element
   */
  select: function( elem, /* internal */ disabled ) {
    var index, option,
      select = this.data.select;

    if ( typeof elem === "number" ) {
      elem = this.item( elem );
    }

    if ( !disabled && _.hasClass( elem, "dk-option-disabled" ) ) {
      return;
    }

    if ( _.hasClass( elem, "dk-option" ) ) {
      index = this.options.indexOf( elem );
      option = select.options[ index ];

      if ( this.multiple ) {
        _.toggleClass( elem, "dk-option-selected" );
        option.selected = !option.selected;

        if ( _.hasClass( elem, "dk-option-selected" ) ) {
          this.selectedOptions.push( elem );
        } else {
          index = this.selectedOptions.indexOf( elem );
          this.selectedOptions.splice( index, 1 );
        }
      } else {
        _.removeClass( this.selectedOptions[0], "dk-option-selected" );
        _.addClass( elem, "dk-option-selected" );
        this.data.dk.firstChild.innerHTML = option.text;
        this.selectedOptions[0] = elem;
        option.selected = true;
      }

      this.selectedIndex = select.selectedIndex;
      this.value = select.value;
      this.data.settings.change( this );

      return elem;
    }
  },

  /**
   * Finds the first occurence given a string
   * @param  {String} string The string to search for
   * @return {Node/Boolean}  The found element or False if not found
   */
  search: function( string ) {
    var i,
      reg = new RegExp( "^" + string, "i" ),
      options = this.data.select.options;

    for ( i = 0; i < options.length; i++ ) {
      if ( reg.test( options[ i ].text )
          && i !== this.selectedIndex ) {
        return this.options[ i ];
      }
    }

    return false;
  },

  /**
   * Resets the DK and select element
   * @param  {Boolean} clear Defaults to first option if True
   */
  reset: function( clear ) {
    var i,
      select = this.data.select;

    this.selectedOptions.length = 0;

    for ( i = 0; i < select.options.length; i++ ) {
      select.options[ i ].selected = false;
      _.removeClass( this.options[ i ], "dk-option-selected" );
      if ( !clear && select.options[ i ].defaultSelected ) {
        this.select( i, true );
      }
    }

    if ( !this.selectedOptions.length ) {
      this.select( 0, true );
    }
  },

  /**
   * Rebuilds the DK Object 
   * (use if HTMLSelectElement has changed)
   */
  refresh: function() {
    dkCache.splice( this.cacheID, 1 );
    this.data.dk.parentNode.removeChild( this.data.dk );
    this.init( this.data.select, {});
  },


  // Private Methods

  handleEvent: function( event ) {
    switch ( event.type ) {
    case "click":
      this._delegate( event );
      break;
    case "keydown":
      this._keyHandler( event );
      break;
    case "keypress":
      this._searchOptions( event );
      break;
    case "mouseover":
      this._highlight( event );
      break;
    case "reset":
      this.reset();
      break;
    }
  },

  _delegate: function( event ) {
    var target = event.target;

    if ( _.hasClass( target, "dk-option-disabled" ) ) {
      return false;
    }

    if ( !this.multiple ) {
      this[ this.isOpen ? "close" : "open" ]();
    }

    if ( _.hasClass( target, "dk-option" ) ) {
      this.select( target );
    }
  },

  _highlight: function( event ) {
    var i, option = event.target; 

    if ( !this.multiple ) {
      for ( i = 0; i < this.options.length; i++ ) {
        _.removeClass( this.options[ i ], "dk-option-highlight" );
      }

      _.addClass( this.data.dk.lastChild, "dk-select-options-highlight" );
      _.addClass( option, "dk-option-highlight" );
    }
  },

  _keyHandler: function( event ) {
    var lastSelected,
      selected = this.selectedOptions,
      options = this.options,
      i = 1,
      keys = {
        tab: 9,
        enter: 13,
        esc: 27,
        space: 32,
        up: 38,
        down: 40
      };

    switch ( event.keyCode ) {
    case keys.up:
      i = -1;
    case keys.down:
      event.preventDefault();
      lastSelected = selected[ selected.length - 1 ];
      i = options.indexOf( lastSelected ) + i;

      if ( i > options.length - 1 ) {
        i = options.length - 1;
      } else if ( i < 0 ) {
        i = 0;
      }
      
      if ( !this.data.select.options[ i ].disabled ) {
        this.reset( true );
        this.select( i );
        this._scrollTo( i );
      }
      break;
    case keys.tab:
    case keys.enter:
      for ( i = 0; i < options.length; i++ ) {
        if ( _.hasClass( options[ i ], "dk-option-highlight" ) ) {
          this.select( i );
        }
      }
    case keys.esc:
      if ( this.isOpen ) {
        event.preventDefault();
        this.close();
      }
      break;
    case keys.space:
      break;
    }
  },

  _searchOptions: function( event ) {
    var result,
      self = this,
      keyChar = String.fromCharCode( event.keyCode ),

      waitToReset = function() {
        if ( self.data.searchTimeout ) {
          clearTimeout( self.data.searchTimeout );
        }

        self.data.searchTimeout = setTimeout(function() { 
          self.data.searchString = ""; 
        }, 1000 );
      };

    if ( this.data.searchString === undefined ) {
      this.data.searchString = "";
    }

    waitToReset();

    this.data.searchString += keyChar;
    result = this.search( this.data.searchString );


    if ( result ) {
      if ( !_.hasClass( result, "dk-option-disabled" ) ) {
        this.reset( true );
        this.select( result );
        this._scrollTo( result );
      }
    }
  },

  _scrollTo: function( option ) {
    var optPos, optTop, optBottom,
      dkOpts = this.data.dk.lastChild;

    if ( !this.isOpen && !this.multiple ) {
      return false;
    }

    if ( typeof option === "number" ) {
      option = this.item( option );
    }

    optPos = _.position( option, dkOpts ).y;
    optTop = optPos - dkOpts.scrollTop;
    optBottom = optTop + option.offsetHeight;

    if ( optBottom > dkOpts.offsetHeight ) {
      optPos += option.offsetHeight;
      dkOpts.scrollTop = optPos - dkOpts.offsetHeight;
    } else if ( optTop < 0 ) {
      dkOpts.scrollTop = optPos;
    }
  }
};

// Static Methods

/**
 * Builds a DK element from the passed select
 * @param  {Node} select The HTMLSelectElement
 * @return {Node}        The New DK dropdown element
 */
Dropkick.build = function( select ) {
  var dkHTML, dkSelect,

    buildInner = function( children ) {
      var child, i,
        inner = "";

      for ( i = 0; i < children.length; i++ ) {
        child = children[ i ];
        if ( child.nodeName === "OPTION" ) {
          inner += _.tmpl( tmpl.option, { option: child });
        } else if ( child.nodeName === "OPTGROUP" ) {
          inner += _.tmpl( tmpl.optgroup, {
            options: buildInner( child.children )
          });
        }
      }

      return inner;
    };
  
  if ( select.nodeName === "SELECT" ) {

    dkHTML = _.tmpl( tmpl.select, {
      select: select,
      options: buildInner( select.children )
    });

    dkSelect = _.parseHTML( dkHTML );

    return dkSelect;
  }
};

/**
 * Finds all DK options in the DK element
 * @param  {NodeList} elems Elements to sort through
 * @return {Array}          Array of DK option elements
 */
Dropkick.findOptions = function( elems ) {
  var el, i,
    options = [];

  for ( i = 0; i < elems.length; i++ ) {
    el = elems[ i ];
    if ( _.hasClass( el, "dk-option" ) ) {
      options.push( el );
    } 
    if ( el.children.length ) {
      options = options.concat( 
        Dropkick.findOptions( el.children ) 
      );
    }
  }

  return options;
};

/**
 * Finds any selected options out of the passed DK options
 * @param  {Array} dkOptions Array of DK option elements
 * @return {Array}           Array of selected DK option elements
 */
Dropkick.getSelected = function( dkOptions ) {
  var opt, i,
    selected = [];

  for ( i = 0; i < dkOptions.length; i++ ) {
    opt = dkOptions[ i ];
    if ( _.hasClass( opt, "dk-option-selected" ) ) {
      selected.push( opt );
    }
  }

  return selected;
};

/**
 * Focus DK Element when corresponding label is clicked; close all other DK's
 */
Dropkick.onDocClick = function( event ) {
  var target, i;
  
  if ( target = document.getElementById( event.target.htmlFor ) ) {
    target.getAttribute( "data-dkCacheId" ) && Dropkick( target ).data.dk.focus();  
  }

  for ( i = 0; i < dkCache.length; i++ ) {
    if ( !_.closest( event.target, dkCache[ i ].data.dk ) ) {
      dkCache[ i ].close();
    }
  }
};
// Expose Dropkick Globally
window.Dropkick = Dropkick;
}( window, document ));