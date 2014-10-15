<?php

/**
 * Sub Categories Widget
 * 
 * @package Warta
 */

if(!class_exists('Warta_Sub_Categories')) :
class Warta_Sub_Categories extends Warta_Widget {

        /**
         * Register widget with WordPress.
         */
        function __construct() {
                parent::__construct(
                        'warta_sub_categories', // Base ID
                        __('[Warta] Sub Categories', 'warta'), // Name
                        array( 'description' => __( 'Displays sub categories of a selected parent category.', 'warta' ), ) // Args
                );
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form( $instance ) { 
                extract( wp_parse_args( $this->set_category_slug($instance), array(
                        'title'         => __( 'New title', 'warta' ),
                        'category'      => ''
                ) ) );                 
?>
                <div>
                        <!--Title
                        ========= -->
                        <p>
                                <label><?php _e('Title:', 'warta') ?> 
                                        <input class    ="widefat" 
                                               id       ="<?php echo $this->get_field_id( 'title' ); ?>" 
                                               name     ="<?php echo $this->get_field_name( 'title' ); ?>" 
                                               type     ="text" 
                                               value    ="<?php echo esc_attr( $title ); ?>"
                                        >
                                </label>
                        </p>

                        <!--Category
                        ============ -->
                        <p>
                                <label><?php _e('Parent Category:', 'warta') ?>
                                        <select name="<?php echo $this->get_field_name( 'category' ) ?>" class="widefat">
<?php                                           $categories = get_categories( array( 'parent' => 0 ) ); 
                                                foreach ($categories as $cat) :  ?>
                                                        <option value="<?php echo $cat->slug ?>" <?php selected($category, $cat->slug) ?>>
<?php                                                           echo $cat->cat_name ?>
                                                        </option>
<?php                                           endforeach; ?>
                                        </select>
                                </label>
                        </p>
                </div>
<?php 
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update( $new_instance, $old_instance ) {
                $instance               = array();
                $instance['title']      = sanitize_text_field( $new_instance['title'] );
                $instance['category']   = sanitize_text_field( $new_instance['category'] );

                return $instance;
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         */
        public function widget( $args, $instance ) {
                extract($this->set_category_slug($instance)); 
                
                $title          = apply_filters( 'widget_title', $title );
                $category_obj   = get_category_by_slug($category);
                $categories     = get_categories( array( 'parent' => $category_obj->term_id ) );
?>
                <section class="<?php warta_widget_class( $args['id'], 6, TRUE, isset($args['is_pb']) ) ?>">
<?php                   echo $args['before_title'] ?>
                                <a href="<?php echo esc_url( get_category_link($category_obj) ) ?>">
<?php                                   if ( ! empty( $title ) )  {
                                                echo $title; 
                                        } else {
                                                echo get_cat_name( $category_obj->term_id );
                                        } ?>	
                                </a>
<?php                   echo $args['after_title'] ?>

                        <ul class="categories">
<?php                           foreach( $categories as $category ) : ?>
                                        <li>
                                                <a href ="<?php echo esc_url( get_category_link( $category ) ) ?>" 
                                                   title="<?php echo esc_attr( sprintf( __( "View %d posts under %s category", 'warta' ), $category->count, $category->name ) ) ?>"
                                                >
                                                        <i class="fa <?php echo is_rtl() ? 'fa-angle-left' : 'fa-angle-right' ?>"></i> <?php echo strip_tags( $category->name ) ?>
                                                </a>
                                        </li>
<?php                           endforeach ?>
                        </ul>
                </section>
<?php 
                if( !isset($args['is_pb'])) {
                        warta_add_clearfix( $args['id'], $col = 6 );
                }
        }

} 
endif; // Sub Categories