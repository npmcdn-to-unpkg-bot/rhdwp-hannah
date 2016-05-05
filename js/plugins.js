// Avoid `console` errors in browsers that lack a console.
(function() {
    var method;
    var noop = function () {};
    var methods = [
        'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
        'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
        'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
        'timeStamp', 'trace', 'warn'
    ];
    var length = methods.length;
    var console = (window.console = window.console || {});

    while (length--) {
        method = methods[length];

        // Only stub undefined methods.
        if (!console[method]) {
            console[method] = noop;
        }
    }
}());

// Place any jQuery/helper plugins in here.

/* ==========================================================================
   Visiblity Toggle
   ========================================================================== */

jQuery.fn.visible = function() {
    return this.css('visibility', 'visible');
};

jQuery.fn.invisible = function() {
    return this.css('visibility', 'hidden');
};

jQuery.fn.visibilityToggle = function() {
    return this.css('visibility', function(i, visibility) {
        return (visibility == 'visible') ? 'hidden' : 'visible';
    });
};


/* ==========================================================================
	closestStyle
   ========================================================================== */

// $().closestStyle()
// find the closest CSS style of a parent for a DOM element and apply it
// to the selected element. I use this mainly before calling
// .effect('highlight') so the backgroundColor will mesh properly.
// @example:
// $('.row').closestStyle('backgroundColor').effect('highlight');
//
// Gist: https://gist.github.com/lifo101/3169552.js

(function($){
    $.fn.closestStyle = function(attr, val){
        var me = $(this);
        me.parents().each(function(i){
            var c = $(this).css(attr);
            if (c != 'transparent') {
                me.css(attr, c);
                return false; // stop
            }
            return true; // strict compliance
        });
        return this;
    };
})(jQuery);