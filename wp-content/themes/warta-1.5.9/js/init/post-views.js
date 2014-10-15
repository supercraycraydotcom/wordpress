/**
 * Post Views Counter
 */
+function($) { 'use strict';
        
        if( $('html').is('.ajax-post-views') ) {                
                var     $body           = $('body'),
                        $postViewCount  = $('.post-view-count'),
                        ids             = [];

                // Post view counter on single post
                if( $body.is('.single-post') ) {
                        $.post( ajax_object.ajax_url, {
                                action  : 'warta_set_post_views',
                                id      : $body.attr('class').match(/postid-(\d*)/)[1]
                        } );
                }
                
                // Update all meta view in current page (usefull when using caching plugin)
                /**
                $postViewCount.each(function() {
                        ids.push( $(this).data('id') );
                });                
                if(ids.length > 0) {
                        $.getJSON( ajax_object.ajax_url, {
                                action  : 'warta_get_post_views',
                                ids     : ids
                        }, function(response) {                        
                                $postViewCount.each(function() {
                                        var     $this   = $(this),
                                                data    = response[ $this.data('id') ];                                

                                        $this.text( data.value );
                                        $this.closest('a').attr('title', data.title);
                                });
                        } );
                }
                */
        }        
        
}(jQuery);