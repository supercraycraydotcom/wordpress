/**
 * RateIt
 * ======
 */
+function($) { 'use strict';
         $(".rateit").rateit({
                step        : .5,
                resetable   : false
         } ).on('over', function ( event, value ) { 
                $(this).attr('title', value ? parseFloat(value).toFixed(1) : 0.0 ); 
         } ).on('rated', function ( event, value ) {
                var $this = $(this);

                value   = value 
                        ? parseFloat(value).toFixed(1) 
                        : 0.0;

                $.getJSON( ajax_object.ajax_url, {
                        action  : 'warta_review_user_rating',
                        id      : $this.data('id'),
                        value   : value
                }, function( response ) {            
                        var wrapper = $this.closest('.user-rating');

                        $this
                            .rateit('readonly', true)
                            .attr('title', value );

                        wrapper.find('.after-vote').css('display', 'block');
                        wrapper.find('.vote-value').text( response.value );
                        wrapper.find('.vote-count').text( response.count );
                } );
         } );
}(jQuery);