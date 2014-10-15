<?php
/**
 * FriskaMax Page Builder Helper
 * 
 * @author Fahri Rusliyadi
 */

if(!class_exists('Fsmpb_Helper')) :
        class Fsmpb_Helper {                
                /**
                 * Widget classess that have been used
                 * @var array
                 */
                protected $widget_classes = array();
                                                
                /**
                 * Get element args for widget type
                 * @param array $widget_classes
                 * @return array
                 */
                public function get_element_args__widget($widget_classes) {
                        $this->widget_classes   = array_merge($this->widget_classes, $widget_classes);
                        $items                  = array();
                        
                        foreach ($widget_classes as $php_class) {
                                $items[] = array(
                                        'type'          => 'widget',
                                        'php_class'     => $php_class
                                );
                        } 
                        
                        return $items;
                }
        
                /**
                 * Get element args for WordPress widgets
                 * @return array
                 */
                public function get_element_args__wp_widgets() {
                        $widget_classes = array(
                                                "WP_Widget_Archives",
                                                "WP_Widget_Calendar",
                                                "WP_Widget_Categories",
                                                "WP_Widget_Meta",
                                                "WP_Widget_Pages",
                                                "WP_Widget_Recent_Comments",
                                                "WP_Widget_Recent_Posts",
                                                "WP_Widget_RSS",
                                                "WP_Widget_Search",
                                                "WP_Widget_Tag_Cloud",
                                                "WP_Widget_Text",
                                                "WP_Nav_Menu_Widget"    
                                        );
                        if ( get_option('link_manager_enabled') ) {
                                $widget_classes[] = 'WP_Widget_Links';
                        }
                        asort($widget_classes);
                                                
                        return  $this->get_element_args__widget($widget_classes);
                }
                
                /**
                 * Get element args for plugin widgets
                 * @return array
                 */
                public function get_element_args__plugin_widgets() {                        
                        $other_widget_classes = array();                        
                        foreach ( array_keys($GLOBALS['wp_widget_factory']->widgets) as $widget_class ) {                                
                                if( !in_array($widget_class, $this->widget_classes) ) {
                                        $other_widget_classes[] = $widget_class;
                                }
                        }        
                                                                        
                        return  !!$other_widget_classes
                                ? $this->get_element_args__widget($other_widget_classes)
                                : NULL;
                }
        }
endif;