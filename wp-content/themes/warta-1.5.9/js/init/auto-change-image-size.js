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