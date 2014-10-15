<?php
/**
 * Breaking News Widget
 * 
 * @package Warta
 */

if(!class_exists('Warta_Breaking_News')) :
class Warta_Breaking_News extends WP_Widget {
        
        /**
         * Current option values
         * @var array
         */
        protected $current_form_data = array();

        /**
         * Register widget with WordPress.
         */
        function __construct() {
                parent::__construct(
                        'warta_breaking_news', // Base ID
                        __('[Warta] Breaking News', 'warta'), // Name
                        array( 'description' => __( 'Scrolling text links.', 'warta' ), ) // Args
                );                
        }
        
        /**
         * Get default option values
         * 
         * @param boolean $is_update Is it for $this->update()
         * @return array
         */
        protected function get_default_form_data($is_update = FALSE) {
                return array(
                        'title'                 => __( 'New title', 'warta' ),
                        'data'                  => 'latest',
                        'sort'                  => '',
                        'time_range'            => 'all',
                        'top_review'            => 0,                        
                        'category'              => 0,                        
                        'tags'                  => '',                        
                        'post_ids'              => '',
                        'count'                 => 4,       
                        'icon'                  => 'fa-angle-double-right',
                        'duration'              => 20000,
                        'direction'             => 'left',
                        'ignore_sticky'         => $is_update ? 0 : 1, 
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
                extract( wp_parse_args( $instance, $this->get_default_form_data() ) );                  
?>                    
                <div class="fsmh-container">                    
                        <!--Title
                        ========= -->
                        <p>
                                <label><?php _e( 'Title:', 'warta' ); ?>
                                        <input class    ="widefat" 
                                               id       ="<?php echo $this->get_field_id( 'title' ); ?>"
                                               name     ="<?php echo $this->get_field_name( 'title' ); ?>" 
                                               type     ="text"  
                                               value    ="<?php echo sanitize_text_field( $title ); ?>"
                                        >
                                </label> 
                        </p>

                        <!--Data
                        ======== -->
                        <p>
                                <label><?php _e('Data:', 'warta') ?>
                                        <select id="<?php echo $this->get_field_id('data') ?>" 
                                                name="<?php echo $this->get_field_name( 'data' ) ?>" 
                                                class="widefat"
                                        >
                                                <option value="latest"          <?php selected( $data, 'latest' ) ?>>   <?php _e('Latest posts', 'warta') ?>            </option>
                                                <option value="popular"         <?php selected( $data, 'popular' ) ?>>  <?php _e('Popular posts', 'warta') ?>           </option>
                                                <option value="review"          <?php selected( $data, 'review' ) ?>>   <?php _e('Review posts', 'warta') ?>            </option>
                                                <option value="category"        <?php selected( $data, 'category' ) ?>> <?php _e('Posts by category', 'warta') ?>       </option>
                                                <option value="tags"            <?php selected( $data, 'tags' ) ?>>     <?php _e('Posts by tags', 'warta') ?>           </option>
                                                <option value="post_ids"        <?php selected( $data, 'post_ids' ) ?>> <?php _e('Posts by IDs', 'warta') ?>            </option>
                                        </select>
                                </label>
                        </p>

                        <!--Data: popular > Sort by
                        =========================== -->
                        <p data-requires='[{ "field":"#<?php echo $this->get_field_id('data') ?>", "compare":"equal", "value":"popular" }]'>
                                <label>
<?php                                   _e('Sort by:', 'warta') ?>
                                        <select name="<?php echo $this->get_field_name( 'sort' ); ?>" class="widefat">
                                                <option value="comments"        <?php selected($sort, 'comments') ?>>   <?php _e('Comments count', 'warta') ?>  </option>
                                                <option value="views"           <?php selected($sort, 'views') ?>>      <?php _e('Views count', 'warta') ?>     </option>
                                        </select>
                                </label>
                        </p>

                        <!--Data: popular, review > time range
                        ======================================-->
                        <p data-requires='<?php echo json_encode(array(
                                array(
                                        "field"         => "#" . $this->get_field_id('data'),
                                        "compare"       => "equal", 
                                        "value"         => "popular"
                                ),
                                array(
                                        "field"         => "#" . $this->get_field_id('data'),
                                        "compare"       => "equal", 
                                        "value"         => "review"
                                ),
                        )) ?>'>
                                <label><?php _e('Time range:', 'warta') ?>
                                        <select name="<?php echo $this->get_field_name( 'time_range' ); ?>" class="widefat">
                                                <option value="all" <?php selected($time_range, 'all') ?>><?php _e('All time', 'warta') ?></option>
                                                <option value="year" <?php selected($time_range, 'year') ?>><?php _e('Last year', 'warta') ?></option>
                                                <option value="month" <?php selected($time_range, 'month') ?>><?php _e('Last month', 'warta') ?></option>
                                                <option value="week" <?php selected($time_range, 'week') ?>><?php _e('Last week', 'warta') ?></option>
                                        </select>
                                </label>
                        </p>

                        <!--Data: review > Top review
                        ============================= -->
                        <p data-requires='[{ "field":"#<?php echo $this->get_field_id('data') ?>", "compare":"equal", "value":"review" }]'>
                                <label>
                                        <input name="<?php echo $this->get_field_name( 'top_review' ); ?>" type="checkbox" value="1" <?php checked($top_review, 1) ?>>
                                        <?php _e('Sort by review score', 'warta') ?>
                                </label>
                        </p>

                        <!--Data: category > categories list
                        ==================================== -->
                        <p data-requires='[{ "field":"#<?php echo $this->get_field_id('data') ?>", "compare":"equal", "value":"category" }]'>
                                <label>
<?php                                   _e('Category:', 'warta'); 
                                        wp_dropdown_categories(array(
                                                'name'          => $this->get_field_name( 'category' ),
                                                'class'         => 'widefat',
                                                'selected'      => $category,
                                                'hierarchical'  => TRUE
                                        )); ?>
                                </label>
                        </p>

                        <!--Data: tags > selected tags
                        ==============================-->
                        <p data-requires='[{ "field":"#<?php echo $this->get_field_id('data') ?>", "compare":"equal", "value":"tags" }]'>
                                <label>
<?php                                   _e('Tags:', 'warta') ?>
                                        <input type="text" name="<?php echo $this->get_field_name( 'tags' ) ?>" value="<?php echo esc_attr( $tags ) ?>" class="widefat">
                                </label>
                                <small><?php _e('Enter the tag slugs, separated by commas.', 'warta') ?></small>
                        </p>

                        <!--Data: post_ids > The posts IDs
                        ================================== -->
                        <p data-requires='[{ "field":"#<?php echo $this->get_field_id('data') ?>", "compare":"equal", "value":"post_ids" }]'>
                                <label>
<?php                                   _e('Post IDs:', 'warta') ?>
                                        <input class="widefat" name="<?php echo $this->get_field_name( 'post_ids' ); ?>" type="text" value="<?php echo esc_attr( $post_ids ); ?>">
                                </label>
                                <small><?php _e('Enter the post IDs, separated by commas.', 'warta') ?></small>
                        </p>

                        <!--Number of Items 
                        =================== -->
                        <p>
                                <label>
<?php                                   _e('Number of items to show:', 'warta') ?>
                                        <input class="widefat" name="<?php echo $this->get_field_name( 'count' ); ?>" type="number" value="<?php echo esc_attr( $count ); ?>">
                                </label>
                        </p>

                        <!--Icons 
                        ========= -->
                        <p>
                                <label>
<?php                                   _e('Icon code:', 'warta') ?>
                                        <input class    ="widefat" 
                                               id       ="<?php echo $this->get_field_id('icon') ?>" 
                                               name     ="<?php echo $this->get_field_name( 'icon' ); ?>" 
                                               type     ="text" 
                                               value    ="<?php echo esc_attr( $icon ); ?>"
                                        >
                                </label>
                        </p>

                        <!--Duration 
                        ============ -->
                        <p>
                                <label>
<?php                                   _e('Duration:', 'warta') ?>
                                        <input class="widefat" name="<?php echo $this->get_field_name( 'duration' ); ?>" type="number" value="<?php echo (int) $duration; ?>">
                                </label>
                                <small><?php _e('Speed in milliseconds', 'warta') ?></small>
                        </p>

                        <!--Direction 
                        ============ -->
                        <p>
<?php                           _e('Direction:', 'warta') ?>
                                <br>
                                <label>
                                        <input class="widefat" name="<?php echo $this->get_field_name( 'direction' ); ?>" type="radio" value="left" <?php checked($direction, 'left') ?>>
<?php                                   _e('left', 'warta') ?>
                                </label>
                                <br>
                                <label>                                        
                                        <input class="widefat" name="<?php echo $this->get_field_name( 'direction' ); ?>" type="radio" value="right" <?php checked($direction, 'right') ?>>
<?php                                   _e('right', 'warta') ?>
                                </label>
                        </p>
                    
                        <!--Ignore Sticky
                        ================= -->
                        <p>
                                <label>
                                        <input type="checkbox" name="<?php echo $this->get_field_name('ignore_sticky') ?>" value="1" <?php checked($ignore_sticky, 1) ?>>
                                        <?php _e('Ignore sticky posts', 'warta') ?>
                                </label>
                        </p>                        
                </div>                    
                <script>
                        jQuery(function($) { 'use strict';
                                $('#<?php echo $this->get_field_id( 'icon' ); ?>').focus(function() {
                                        var     $this   = $(this),
                                                $modal  = $('#warta-modal-fontawesome-select').fsmhBsModal('show');
                                        
                                        $modal.off('click.warta.fa.widget').on('click.warta.fa.widget', '.fa', function() {
                                                $this.val( $(this).data('value') );
                                                $modal.fsmhBsModal('hide');
                                        });
                                });                                
                        });
                </script>
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
                extract( wp_parse_args( $new_instance, $this->get_default_form_data(TRUE) ) );  
                                
                return array(
                        'title'                 => sanitize_text_field($title),
                        'data'                  => sanitize_text_field($data),
                        'sort'                  => sanitize_text_field($sort),
                        'time_range'            => sanitize_text_field($time_range),
                        'top_review'            => (int) $top_review,                        
                        'category'              => (int) $category,                        
                        'tags'                  => sanitize_text_field($tags),                        
                        'post_ids'              => sanitize_text_field($post_ids),
                        'count'                 => (int) $count,       
                        'icon'                  => sanitize_text_field($icon),
                        'duration'              => (int) $duration,
                        'direction'             => sanitize_text_field($direction),
                        'ignore_sticky'         => (int) $ignore_sticky, 
                );                
        }  
        
        /**
         * Get WP_Query arguments
         * @return array
         */
        protected function get_query_args() {
                extract($this->current_form_data);
                
                $query_args     = array( 
                                        'posts_per_page'        => $count,
                                        'ignore_sticky_posts'   => $ignore_sticky
                                ); // query arguments

                // Set query arguments 
                switch ( $data ) {                
                        case 'category':
                                $query_args['cat']  = $category;
                                break;
                        case 'tags':
                                $query_args['tax_query'] = array(
                                        array(
                                                'taxonomy'  => 'post_tag',
                                                'field'     => 'slug',
                                                'terms'     => explode(',', $tags)
                                        )
                                );
                                break;
                        case 'review':
                                $query_args['meta_key']     = 'friskamax_review_total';  
                                $query_args['meta_value']   = 0;
                                $query_args['meta_compare'] = '>';                  

                                if( $top_review ) {
                                        $query_args['orderby'] = 'meta_value_num';
                                }
                                break;
                        case 'popular':
                                if( $sort  === 'comments' ) {    
                                        $query_args['orderby']  = 'comment_count'; 
                                } else {
                                        $query_args['meta_key'] = 'warta_post_views_count';
                                        $query_args['orderby']  = 'meta_value_num';
                                }                    
                                break;
                        case 'post_ids':
                                $query_args['post__in'] = explode(',', $post_ids);
                                $query_args['orderby']  = 'post__in';
                                break;
                }    
            
                // Query arguments > time Range
                if( ( $data == 'review' || $data == 'popular' ) && $time_range != 'all' ) {
                        switch ($time_range) {
                                case 'year':
                                        $query_args['date_query'] = array(
                                                array( 'year' => date('Y') - 1 ),
                                        );
                                        break;
                                case 'month':
                                        $query_args['date_query'] = array(
                                                'before'        => 'first day of this month midnight',
                                                'after'         => 'first day of last month midnight',
                                        );
                                        break;
                                case 'week':
                                        $query_args['date_query'] = array(
                                                'before'  => 'this week midnight',
                                                'after'   => 'last week midnight'
                                        );
                                        break;
                        }
                }
                
                return $query_args;
        }
        
        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         * 
         * @global array $friskamax_warta_var Warta theme variables
         *
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         */
        public function widget( $args, $instance ) {                 
                $this->current_form_data = $instance;                
                extract($instance);
                $title = apply_filters( 'widget_title', $title );
                
                $the_query = new WP_Query( $this->get_query_args() );
                if ( $the_query->have_posts() ) : ?>
                        <section class="<?php echo !isset($args['is_pb']) ? 'col-md-12' : '' ?> breaking-news">
<?php                           if(!!$title) : ?>
                                        <header>
                                            <h4><?php echo strip_tags($title) ?></h4>
                                            <i class="triangle"></i>
                                        </header>
<?php                           endif ?>
                                <div class              ="content" 
                                     data-duration      ="<?php echo (int) $duration ?>"
                                     data-direction     ="<?php echo esc_attr($direction) ?>"
<?php                                echo is_rtl() ? 'dir="ltr"' : '' ?>
                                >
                                        <ul <?php echo is_rtl() ? 'dir="rtl"' : '' ?>>
<?php                                           while ( $the_query->have_posts() ) : 
                                                        $the_query->the_post(); ?>
                                                        <li>
                                                                <a href="<?php the_permalink() ?>">
<?php                                                                   if(!!$icon) : ?>
                                                                                <i class="fa <?php echo esc_attr($icon) ?>"></i> 
<?php                                                                   endif; 
                                                                        the_title(); ?>
                                                                </a>
                                                        </li>
<?php                                           endwhile ?>
                                        </ul>
                                </div>
                        </section>
<?php           endif;
                wp_reset_postdata(); // Restore original Post Data                
        }

} // class Warta_Breaking_News
endif; 