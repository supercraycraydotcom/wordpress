<?php

// Ensure cart contents update when products are added to the cart via AJAX  
if(!function_exists('warta_add_to_cart_fragment')) :
        function warta_add_to_cart_fragment( $fragments ) {
                global $woocommerce;
                ob_start(); 
?>
                        <a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>">
                                <i class="fa fa-shopping-cart"></i> 
                                <?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'warta'), $woocommerce->cart->cart_contents_count);?> - 
                                <?php echo $woocommerce->cart->get_cart_total(); ?>
                        </a>
<?php
                $fragments['a.cart-contents'] = ob_get_clean();
                return $fragments;
        }
endif;
add_filter('add_to_cart_fragments', 'warta_add_to_cart_fragment');


if( !function_exists('warta_menu_cart') ) :
        /**
         * Display cart on menu
         * @global type $woocommerce
         */
        function warta_menu_cart() {
                global $woocommerce;
                                
                if ( !!$woocommerce && !is_cart() && !is_checkout() ) : ?>
                        <li class="dropdown menu-cart">
                                <a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>">
                                        <i class="fa fa-shopping-cart"></i> 
                                        <?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'warta'), $woocommerce->cart->cart_contents_count);?> - 
                                        <?php echo $woocommerce->cart->get_cart_total(); ?>
                                </a>

                                <div class="dropdown-menu">
<?php                                   the_widget( 'WC_Widget_Cart', 'title= ' ); ?>
                                </div>
                        </li>
<?php           endif;
        }
endif;