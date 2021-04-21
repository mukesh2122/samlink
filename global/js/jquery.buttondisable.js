function disableLink(e) {
    e.preventDefault();
    return false;
};

;(function($){ 
    jQuery.fn.extend({  
//        startLoading: function(sel) {
//            $(sel).die('click');
//            return true;
//        },
        startLoading: function() {
            $(this).on('click', disableLink);
            return this;
        },
		
//        stopLoading: function(sel, func, args) {
//            $(sel).live('click', function(e){
//                var opt = $.merge(new Array(e, $(this)), args);
//                window[func].apply(window, opt);
//            });
//			
//            return true; 
//        },
        stopLoading: function() {
             $(this).off('click', disableLink);
             return this;
        }
		
    })
}(jQuery));