/*
 * INITIALIZE
 * =============================================================================
 */
+function ($) { "use strict";
    
        /*
         * HTML5 PLACEHOLDER
         * -----------------
         */
        $('input, textarea').placeholder(); 

        /**
         * Fix for iPhone that doesn't have hover effect
         * ---------------------------------------------
         */ 
        $('.article-medium .image').click( function() {
                var     $this           = $(this),
                        container       = $this.find('.container-link'),
                        link            = $this.find('.container-link .link');
                                
                setTimeout(function () {
                        if( container.css('opacity') == 0 ) {
                                container.css('opacity', 1);
                                link.css('top', '50%');
                                $this.data('force-hover', true);                                
                        } else if( $this.data('force-hover') ) {
                                container.css('opacity', 0);
                                $this.data('force-hover', false);                                
                        }                      
                }, 300);
        });
    
        // Disable .fa-flip-horizontal on IE9 and older
        if( ! Modernizr.csstransitions ) {               
                    $('.fa-flip-horizontal').removeClass('fa-flip-horizontal'); 
        }
        
} (jQuery);