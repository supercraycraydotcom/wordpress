













/*
 * Carousel Caption Animation
 * ==========================
 */
+function( $ ) { 'use strict';
        new $.CarouselAnimation('.carousel-large, .carousel-medium');
}( jQuery );
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
/*
 * Flickr
 * ======
 */
+function($) { 'use strict';
        $('.flickr-feed').each(function() {
                var $this = $(this);

                new $.FlickrFeed({
                        element : $this, // Your element id to place the photos.
                        items   : $this.data('count'), // How many items do you want to show.
                        id      : $this.data('id'), // A single user ID. This specifies a user to fetch for. eg: '685365@N25'.
                        ids     : $this.data('ids'), // A comma delimited list of user IDs. This specifies a list of users to fetch for.
                        tags    : $this.data('tags'), // A comma delimited list of tags to filter the feed by.
                        tagmode : $this.data('tagmode')  // Control whether items must have ALL the tags (tagmode=all), or ANY (tagmode=any) of the tags. Default is ALL.
                });
        });
}(jQuery);
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
/*
 * gmaps.js 
 * ========
 */
+function($) { 'use strict';
        if( typeof GMaps != "undefined" ) {
                var mapContainer = $('#map').height( $(window).height() / 2 ); // set the map container's height

                new GMaps({
                        div: '#map',
                        lat: mapContainer.data('lat'), 
                        lng: mapContainer.data('long'),
                        scrollwheel: false
                }).addMarker({
                        lat: mapContainer.data('lat'), 
                        lng: mapContainer.data('long'),
                        title: mapContainer.data('marker')
                });
        }
}(jQuery);
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
/**
 * Auto change images
 * ==================
 */   
+function($) { 'use strict';             
        var     dataImgSizesTimer,
                $dataImgSizes = $('[data-img-size-thumbnail]');             
        $(window).on('resize.dataImgSizes', function() {
                var x = 0;
                clearTimeout(dataImgSizesTimer);
                dataImgSizesTimer = setTimeout(function() {
                        $dataImgSizes.each(function() {                                
                                var     $this           = $(this),                                        
                                        thumbmail       = $this.data('img-size-thumbnail'),
                                        small           = $this.data('img-size-small'),
                                        gallery         = $this.data('img-size-gallery'),
                                        medium          = $this.data('img-size-medium'),
                                        large           = $this.data('img-size-large'),
                                        huge            = $this.data('img-size-huge'),
                                        full            = $this.data('img-size-full'),
                                        $wrapper        = !!$this.data('img-sizes-wrapper') ? $( $this.data('img-sizes-wrapper') ) : $this,
                                        width           = $wrapper.width();

                                $this = $this.is('img') ? $this : $this.find('img');
                                if(!$this.length || !width) {
                                        return true;
                                }
                                
                                if(width <= 95) {
                                        $this.attr('src', thumbmail);
                                } else if(width <= 165 && !!small) {
                                        $this.attr('src', small);
                                } else if(width <= 180 && !!gallery) {
                                        $this.attr('src', gallery);
                                } else if(width <= 350 && !!medium) {
                                        $this.attr('src', medium);
                                } else if(width <= 730 && !!large) {
                                        $this.attr('src', large);
                                } else if(width <= 1366 && !!huge) {
                                        $this.attr('src', huge);
                                } else if(!!full) {
                                        $this.attr('src', full);
                                }
                        });
                }, 500);
        });
        $dataImgSizes.imagesLoaded(function() {
                $( window ).trigger( 'resize.dataImgSizes' );
        });
}(jQuery);
/**
 * Created on : May 24, 2014, 9:55:06 PM
 * Author     : Fahri
 */
+function($) { 'use strict';       
        
        /**
         * Show/hide menu cart
         */
        
        var $menuCart = $('li.menu-cart');

        if ( !!$.cookie && $.cookie( 'woocommerce_items_in_cart' ) > 0 ) {
                $menuCart.show();
        } else {
                $menuCart.hide();
        }        
        
        $('body').on('added_to_cart', function(event, fragments, cart_hash) {
                $menuCart.show();
        }); 
}(jQuery);
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