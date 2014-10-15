<?php
/**
 * Base warta widget class
 * 
 * @package Warta
 */

if(!class_exists('Warta_Widget')) :
class Warta_Widget extends WP_Widget {        
        /**
         * Get data-requires attribute for a field that requires field 'data'
         * 
         * @param array $fields
         * @return array
         */
        protected function get_attr_requires__data($fields) {                 
                $output         = array();
                $required_field = '[data-id=' . $this->get_field_id( 'data' ) . ']';
                
                foreach ( (array) $fields as $value) {                        
                        $output[] = array(
                                'field'      => $required_field,
                                'compare'    => 'equal',
                                'value'      => $value
                        );
                }
                
                return json_encode($output);
        }
        
        /**
         * Convert category ID to category slug
         * @param array $instance
         * @return array
         */
        protected function set_category_slug($instance) {
                if( !isset($instance['category']) ) {
                        return $instance;
                }
                
                if( is_array($instance['category']) ) {
                        foreach ( $instance['category'] as $key => $value) {
                                if( !!(int) $value ) {
                                        $category                       = get_category($value);
                                        $instance['category'][$key]     = !!$category ? $category->slug : '';
                                }
                        } 
                } else if( !!(int) $instance['category'] ) {
                        $category               = get_category($instance['category']);
                        $instance['category']   = !!$category ? $category->slug : '';
                }
                
                return $instance;
        }
}
endif;