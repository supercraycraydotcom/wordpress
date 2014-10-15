/*
 * JQUERY ZOOM
 * ===========
 */   
+function($) { 'use strict';
        if( !$('html').is('.no-zoom-effect') && $(window).width() >= 768 ) {       
                $('.article-large .frame [data-zoom] img').imagesLoaded(function() {
                        $(this.elements).each(function() {
                                if(this.naturalWidth >= 730) {
                                        var $a = $(this).closest('[data-zoom]');
                                        $a.zoom({ url: $a.attr('href') });
                                }
                        });
                });
                
                // Warta zoom
                $('#content .image img').zoomImg();
        }
}(jQuery);