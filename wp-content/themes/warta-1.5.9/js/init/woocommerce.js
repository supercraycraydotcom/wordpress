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