<?php

if(!class_exists('Warta_Walker_CategoryDropdown_SlugValue')) : 
/**
 * Create HTML dropdown list of Categories.
 * Change option value from $category->id to $category->slug
 *
 * @package WordPress
 * @since 2.1.0
 * @uses Walker
 */
class Warta_Walker_CategoryDropdown_SlugValue extends Walker_CategoryDropdown {
        /**
         * Start the element output.
         *
         * @see Walker::start_el()
         * @since 2.1.0
         *
         * @param string $output   Passed by reference. Used to append additional content.
         * @param object $category Category data object.
         * @param int    $depth    Depth of category. Used for padding.
         * @param array  $args     Uses 'selected' and 'show_count' keys, if they exist. @see wp_dropdown_categories()
         */
        function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
            $pad = str_repeat('&nbsp;', $depth * 3);

            /** This filter is documented in wp-includes/category-template.php */
            $cat_name = apply_filters( 'list_cats', $category->name, $category );

            $output .= "\t<option class=\"level-$depth\" value=\"".$category->slug."\"";
            if ( $category->slug == $args['selected'] )
                $output .= ' selected="selected"';
            $output .= '>';
            $output .= $pad.$cat_name;
            if ( $args['show_count'] )
                $output .= '&nbsp;&nbsp;('. number_format_i18n( $category->count ) .')';
            $output .= "</option>\n";
        }
}
endif;