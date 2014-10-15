<?php

// disable page title
add_filter('woocommerce_show_page_title', '__return_false');


// Change number of products displayed per page
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );



// output related products args
if(!function_exists('warta_woocommerce_output_related_products_args')) :
function warta_woocommerce_output_related_products_args() {
		return array(
                'posts_per_page' => 4,
                'columns' => 4,
                'orderby' => 'rand'
		);
}
endif;
add_filter('woocommerce_output_related_products_args', 'warta_woocommerce_output_related_products_args');



// content-single-product.php > reorder
remove_action   ('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
add_action      ('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 11);
remove_action   ('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
add_action      ('woocommerce_single_product_summary', 'woocommerce_template_single_price', 12);






// Remove each style one by one
add_filter( 'woocommerce_enqueue_styles', 'jk_dequeue_styles' );
function jk_dequeue_styles( $enqueue_styles ) {
        unset( $enqueue_styles['woocommerce-general'] ); // Remove the gloss
//        unset( $enqueue_styles['woocommerce-layout'] ); // Remove the layout
//        unset( $enqueue_styles['woocommerce-smallscreen'] ); // Remove the smallscreen optimisation
        return $enqueue_styles;
}