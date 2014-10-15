/**
 * Share buttons
 * =============
 */
+function($) { 'use strict';
        var shareButtonsWrapper = $('[data-share-buttons]');   
        if( shareButtonsWrapper.length > 0 ) {
                 $.post( ajax_object.ajax_url, {
                         action      : 'warta_share_buttons',
                         permalink   : shareButtonsWrapper.data('permalink'),
                         title       : shareButtonsWrapper.data('title')
                 }, function ( response ) {       
                         if( response ) {
                                 shareButtonsWrapper.addClass('share-post').append( response ); 

                                 $('.share-post a').click(function ( event ) {
                                         var href = $(this).attr('href');

                                         if( /^http.+$/.test( href ) ) {   
                                                 window.open( href, '', 'width=800,height=550' );
                                                 event.preventDefault();     
                                         }
                                 });
                         }
                 } );
        }
}(jQuery);