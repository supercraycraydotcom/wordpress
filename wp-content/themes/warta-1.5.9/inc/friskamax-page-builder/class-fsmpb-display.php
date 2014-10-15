<?php
/**
 * FriskaMax Page Builder Display
 * 
 * @author Fahri Rusliyadi
 */

if(!class_exists('Fsmpb_Display')) :
        /**
         * Displays page builder content
         */
        class Fsmpb_Display {
                /**
                 * Layout data
                 * @var JSON
                 */
                protected $data;

                /**
                 * Post ID
                 * @var int
                 */
                protected $id;
                
                /**
                 * Widget sidebar arguments
                 * @var array
                 */
                protected $widget_sidebar_args = array(
                        'main'  => array(
                                'name'          => '',
                                'description'   => '',
                                'class'         => '',
                                'before_widget' => '<aside class="widget %2s">',
                                'after_widget'  => '</aside>',
                                'before_title'  => '<h1 class="widget-title">',
                                'after_title'   => '</h1>',
                                'is_pb'         => TRUE
                        )
                );

                public function __construct($widget_sidebar_args = array()) {
                        $this->id       = get_the_ID();
                        $this->data     = get_post_meta($this->id, 'fsmpb_main', TRUE);
                        $this->data     = json_decode($this->data);
                        
                        if( isset($widget_sidebar_args['main']) ) {
                                $this->widget_sidebar_args['main'] = wp_parse_args($widget_sidebar_args['main'], $this->widget_sidebar_args['main']);
                        }
                }

                /**
                 * Is current page using page builder?
                 * @return boolean
                 */
                public function is_pb() {
                        return !!$this->data;
                }
                
                /**
                 * Calculate width for small devices
                 * @param array $cols
                 */
                protected function set_sm_widths(&$cols) {
                        if(count($cols) <= 2) { // Set sm width to 12 if there's only 1 or 2 columns
                                foreach(array_keys($cols) as $key) {
                                        $cols[$key]->sm_width = 12;
                                }
                        } else {
                                $sm_widths_1    = array();
                                $sm_widths_2    = array();
                                
                                // Break into 2 rows
                                foreach ($cols as $col) {
                                        if( array_sum($sm_widths_1) < 12 ) {
                                                $sm_widths_1[] = $col->width * 2;
                                        } else {
                                                $sm_widths_2[] = $col->width * 2;
                                        }
                                }                                
                                                      
                                // Move middle column to $temp_width
                                if(array_sum($sm_widths_1) > 12) {
                                        $temp_width     = array_pop($sm_widths_1);
                                } elseif (array_sum($sm_widths_1) < 12) {
                                        $temp_width     = array_pop($sm_widths_1);
                                }                                
                                
                                if(isset($temp_width)) {
                                        // Move middle columns to narrowest row 
                                        if(array_sum($sm_widths_1) > array_sum($sm_widths_2)) {
                                                array_unshift($sm_widths_2, $temp_width);
                                        } else {
                                                $sm_widths_1[] = $temp_width; 
                                        }
                                        
                                        // Make the width 1st row to be 12
                                        while(array_sum($sm_widths_1) != 12) {                                                
                                                foreach ($sm_widths_1 as $key => $value) {
                                                        if(array_sum($sm_widths_1) > 12) {
                                                                $sm_widths_1[$key] -= 1;
                                                        } else if(array_sum($sm_widths_1) < 12) {
                                                                $sm_widths_1[$key] += 1;
                                                        }
                                                }                                                         
                                        }
                                        
                                        // Make the width 2nd row to be 12
                                        while (array_sum($sm_widths_2) != 12) {   
                                                foreach ($sm_widths_2 as $key => $value) {
                                                        if(array_sum($sm_widths_2) > 12) {
                                                                $sm_widths_2[$key] -= 1;
                                                        } else if(array_sum($sm_widths_2) < 12) {
                                                                $sm_widths_2[$key] += 1;
                                                        }
                                                }                                                        
                                        }
                                }   
                                
                                // Set the sm widths
                                $i = 0;
                                foreach ($sm_widths_1 as $key => $value) {
                                        $cols[$i++]->sm_width = $value;
                                }
                                foreach ($sm_widths_2 as $key => $value) {
                                        $cols[$i++]->sm_width = $value;
                                }                                
                        }                        
                }
                
                /**
                 * Display widget type element 
                 * @param object $element
                 */
                protected function display_element_widget($element) {
                        $args                   = $this->widget_sidebar_args['main'];
                        $args['before_widget']  = sprintf($args['before_widget'], $element->args->css_class);
                        $args['widget_id']      = $element->args->css_class . '-' . rand();                        
                        $args['widget_name']    = $element->title;
                                                                                        
                        the_widget($element->args->php_class, $element->formData, $args );
                }
                
                /**
                 * Display the elements
                 * @param array $elements
                 */
                protected function display_elements($elements) {
                        foreach ($elements as $element) {
                                switch ($element->type) { 
                                        case 'widget':
                                                $this->display_element_widget($element);
                                                break;
                                        case 'custom':
                                                $GLOBALS['fsmpb_custom_elements'][$element->args->php_class]->display($element->formData);
                                                break;
                                        
                                        case 'widget_area':
                                                $GLOBALS['fsmpb_custom_elements']['Fsmpb_Element_Widget_Area']->display($element->formData);
                                                break;

                                        default:
                                                break;
                                }
                        }
                }
                
                /**
                 * Display sub-row columns
                 * @param array $sub_row_cols
                 */
                protected function display_sub_row_cols($sub_row_cols) {
//                        $this->set_sm_widths($sub_row_cols);        
                        
                        foreach ($sub_row_cols as $sub_row_col) {
//                                echo '<div class="col-md-' . (int) $sub_row_col->width . ' col-sm-' . $sub_row_col->sm_width . '">';                                
                                echo '<div class="col-sm-' . (int) $sub_row_col->width . '">';                                
                                        $this->display_elements($sub_row_col->elements);
                                echo '</div>';                        
                        }  
                }
                
                /**
                 * Display sub rows
                 * @param array $sub_rows
                 */
                protected function display_sub_rows($sub_rows) {
                        foreach ($sub_rows as $sub_row_cols) {
                                echo '<div class="row">';
                                        $this->display_sub_row_cols($sub_row_cols);
                                echo '</div>';
                        }
                }

                /**
                 * Display row columns
                 * @param array $cols
                 */
                protected function display_cols($cols) {
                        $this->set_sm_widths($cols);
                        
                        foreach ($cols as $col) {
                                echo '<div class="col-md-' . (int) $col->width . ' col-sm-' . $col->sm_width . '">';
                                        $this->display_sub_rows($col->subRows);
                                echo '</div>';                        
                        }                                        
                }

                /**
                 * Display rows
                 */
                public function display() {                           
                        foreach ($this->data as $cols) {
                                echo '<div class="row">';
                                        $this->display_cols($cols);
                                echo '</div>';
                        }                 
                }
        }
endif; // Fsmpb_Display