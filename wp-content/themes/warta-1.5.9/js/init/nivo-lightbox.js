/*
 * Nivo Lightbox 
 * =============
 */
+function($) { 'use strict';
        $(
                 '#gallery a,' +
                 '.image a:has(.fa-search-plus),' + 
                 '.da-thumbs a:not(.link-to-attachment-page),' +  
                 '#main-content article .frame > a:has(img),' +
                 'a[data-lightbox]'
         ).nivoLightbox({
                effect: 'fadeScale'
         });
}(jQuery);