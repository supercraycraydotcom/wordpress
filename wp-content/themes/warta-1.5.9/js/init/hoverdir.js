/*
 * HOVER DIRECTION AWARE
 * =====================
 */
+function($) { 'use strict';
        $(' .da-thumbs > li ').each( function() { 
                $(this).hoverdir({
                        hoverDelay : 75
                }); 
        } );
}(jQuery);