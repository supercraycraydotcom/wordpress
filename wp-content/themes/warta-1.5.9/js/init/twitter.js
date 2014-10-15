/**
 * Twitter Feed
 * ============
 */  
+function($) { 'use strict';             
        $('.twitter-feed').each( function() {
                var $this = $(this);

                $this.twittie({
                        username     : $this.data('username'),
                        apiPath      : ajax_object.ajax_url,
                        template     : $this.find('script[type="text/template"]').html(),
                        dateFormat   : $this.data('date-format'),
                        count        : $this.data('count'),       
                        loadingText  : $this.data('loading-text')       
                 });
        } );   
        $('.twitter-feed').on('click', 'a:has(.fa-reply)', function (event) {
                event.preventDefault();
                window.open( $(this).attr('href'), '', 'width=710,height=540' );
        });
}(jQuery);