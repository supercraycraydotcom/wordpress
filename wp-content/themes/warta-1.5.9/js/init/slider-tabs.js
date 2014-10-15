/*
 * Slider Tabs
 * ===========
 */
+function($) { 'use strict';        
        $('.slider-tabs').each(function() {
                var widget = $(this).attr('id');

                $(this).find('.tab-content .tab-pane').each(function () {
                        new $.Slider({
                                widget  : '#' + widget,             // The widget ID
                                tab     : '#' + $(this).attr('id')  // The tab ID
                        });
                });
        });        
}(jQuery);