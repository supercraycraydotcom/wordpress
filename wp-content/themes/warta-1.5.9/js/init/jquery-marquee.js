/*
 * jQuery Marquee 
 * ==============
 */
+function($) { 'use strict';
        $('.breaking-news .content').marquee({   
                delayBeforeStart: 0,
                duplicated      : true,
                gap             : 0,
                pauseOnHover    : true
        });
}(jQuery);