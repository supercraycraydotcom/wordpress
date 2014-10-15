<?php
/**
 * Posts Carousel Widget
 * 
 * @package Warta
 */

if(!class_exists('Warta_Posts_Carousel')) :
class Warta_Posts_Carousel extends WP_Widget {        
        /**
         * Current option values
         * @var array
         */
        protected $current_form_data = array();
        
        /**
         * Display arguments including before_title, after_title, before_widget, and after_widget
         * @var array
         */
        protected $sidebar_args;
        
        /**
         * Register widget with WordPress.
         */
        function __construct() {
                parent::__construct(
                        'warta_posts_carousel', // Base ID
                        __('[Warta] Posts Carousel', 'warta'), // Name
                        array( 'description' => __( 'Images carousel from posts', 'warta' ), ) // Args
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
                        'sort'                  => 'comments',
                        'time_range'            => 'all',
                        'category'              => 0,
                        'tags'                  => '',
                        'post_ids'              => '',
                        'count'                 => 4,
                        'excerpt'               => 320,                        
                        'interval'              => 8000,
                        'animation'             => 'slide',
                        'animation_speed'       => 2000,
                        'ignore_sticky'         => $is_update ? 0 : 1,
                        'hide_mobile'           => 0,                        
                );
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         * @param boolean $is_meta_box Is it called from meta_box
         */
        public function form( $instance, $is_meta_box = FALSE ) {          
                extract( wp_parse_args( $instance, $this->get_default_form_data() ) ); 
?>
                <div class="fsmh-container">
                        <!--Title
                        =========-->
                        <p class="<?php echo $is_meta_box ? 'hidden' : '' ?>">
                                <label><?php _e( 'Title:', 'warta' ); ?>
                                        <input class    ="widefat" 
                                               id       ="<?php echo $this->get_field_id( 'title' ); ?>" 
                                               name     ="<?php echo $this->get_field_name( 'title' ); ?>" 
                                               type     ="text" 
                                               value    ="<?php echo esc_attr( $title ); ?>"
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

                        <!--Data: popular > time range
                        ======================================-->
                        <p data-requires='<?php echo json_encode(array(
                                array(
                                        "field"         => "#" . $this->get_field_id('data'),
                                        "compare"       => "equal", 
                                        "value"         => "popular"
                                )
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
                                        <input class="widefat" name="<?php echo $this->get_field_name( 'count' ); ?>" type="number" value="<?php echo (int) $count; ?>">
                                </label>
                        </p>

                        <!--Excerpt length
                        ================== -->
                        <p>
                                <label>
<?php                                   _e('Excerpt Length:', 'warta') ?>
                                        <input class="widefat" name="<?php echo $this->get_field_name( 'excerpt' ); ?>" type="number" value="<?php echo (int) $excerpt; ?>">
                                </label>
                                <small><?php _e('How many characters do you want to show?', 'warta') ?></small>
                        </p>

                        <!--Interval
                        ============ -->
                        <p>
                                <label>
<?php                                   _e('Interval:', 'warta') ?>
                                        <input class="widefat" name="<?php echo $this->get_field_name('interval'); ?>" type="number" value="<?php echo (int) $interval; ?>">
                                </label>
                                <small><?php _e('The amount of time to delay between automatically cycling an item (in miliseconds)', 'warta') ?></small>
                        </p>

                        <!--Caption Animation
                        ===================== -->
                        <p>
                                <label>
<?php                                   _e('Caption Animation:', 'warta') ?>
                                        <select class="widefat" name="<?php echo $this->get_field_name('animation'); ?>">
                                                <option value="slide"   <?php selected($animation, 'slide') ?>> <?php _ex('Slide', 'Animation type', 'warta') ?>        </option>
                                                <option value="fade"    <?php selected($animation, 'fade') ?>>  <?php _ex('Fade', 'Animation type', 'warta') ?>         </option>
                                                <option value="bounce"  <?php selected($animation, 'bounce') ?>><?php _ex('Bounce', 'Animation type', 'warta') ?>       </option>
                                        </select>
                                </label>
                        </p>

                        <!--Caption Animation Speed
                        =========================== -->
                        <p>
                                <label>
<?php                                   _e('Caption Animation Speed:', 'warta') ?>
                                        <input class="widefat" name="<?php echo $this->get_field_name('animation_speed'); ?>" type="number" value="<?php echo (int) $animation_speed; ?>">
                                </label>
                                <small><?php _e('The amount of time to animate the caption (in miliseconds)', 'warta') ?></small>
                        </p>
                    
                        <!--Ignore Sticky
                        ================= -->
                        <p>
                                <label>
                                        <input type="checkbox" name="<?php echo $this->get_field_name('ignore_sticky') ?>" value="1" <?php checked($ignore_sticky, 1) ?>>
                                        <?php _e('Ignore sticky posts', 'warta') ?>
                                </label>
                        </p>

                        <!--Hide on mobile devices
                        ========================== -->
                        <p>
                                <label>
                                        <input type="checkbox" name="<?php echo $this->get_field_name( 'hide_mobile' ); ?>" value="1" <?php checked( $hide_mobile, 1) ?>> 
                                        <?php _e('Hide on mobile devices', 'warta') ?>
                                </label><br>
                                <small><?php _e('Recommended for better performance.', 'warta') ?></small>
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
        public function update( $new_instance, $old_instance = array() ) {
                extract( wp_parse_args($new_instance, $this->get_default_form_data(TRUE)) );                 
                
                return array(
                        'title'                 => sanitize_text_field($title),
                        'data'                  => sanitize_text_field($data),
                        'sort'                  => sanitize_text_field($sort),
                        'time_range'            => sanitize_text_field($time_range),
                        'category'              => (int) $category,
                        'tags'                  => sanitize_text_field($tags),
                        'post_ids'              => sanitize_text_field($post_ids),
                        'count'                 => (int) $count,
                        'excerpt'               => (int) $excerpt,                        
                        'interval'              => (int) $interval,
                        'animation'             => sanitize_text_field($animation),
                        'animation_speed'       => (int) $animation_speed,
                        'ignore_sticky'         => (int) $ignore_sticky,
                        'hide_mobile'           => (int) $hide_mobile
                );
        }
        
        /**
         * Get WP_Query arguments
         * @return array
         */
        protected function get_query_args() {
                extract($this->current_form_data);
                
                $query_args     = array( 
                                        'meta_key'              => '_thumbnail_id',
                                        'post_type'             => 'post',
                                        'posts_per_page'        => $count,
                                        'ignore_sticky_posts'   => $ignore_sticky,
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
                if( $data == 'popular' && $time_range != 'all' ) {
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
        
        protected function display_indicators($the_query, $id) {
                $counter = 0; 
?>
                <ol class="carousel-indicators">
<?php                   while ( $the_query->have_posts() ) :
                                $the_query->the_post(); ?>
                                <li data-target="#<?php echo $id ?>" data-slide-to="<?php echo $counter++ ?>" class="<?php echo $counter == 0 ? 'active' : ''; ?>"></li>
<?php                   endwhile; ?>
                </ol>
<?php
        }
        
        protected function display_items($the_query) {
                extract($this->current_form_data);
                $is_large       = isset($this->sidebar_args['is_large']);
                $counter        = 0;
                
                while ( $the_query->have_posts() ) : 
                        $the_query->the_post();

                        if( has_post_thumbnail() ) :
                                $full       = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full');
                                $huge       = wp_get_attachment_image_src( get_post_thumbnail_id(), 'huge');
                                $large      = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
?>
                                <div class="item <?php echo $counter++ == 0 ? 'active' : ''; ?>">
<?php                                   if( $hide_mobile ) : ?>
                                                <div    data-alt="<?php the_title() ?>"                
<?php                                                   if($is_large) : ?>
                                                                data-small      ="<?php echo $large[0] ?>"
                                                                data-medium     ="<?php echo $huge[0] ?>"
                                                                data-large      ="<?php echo $full[0] ?>"
<?php                                                   else : ?> 
                                                                data-src        ="<?php echo $large[0] ?>"
<?php                                                   endif; ?>
                                                >
                                                </div>
<?php                                   else : ?>
                                                <img    alt     ="<?php the_title() ?>"
                                                        src     ="<?php echo $large[0] ?>"
<?php                                                   if($is_large) : ?>
                                                                data-small      ="<?php echo $large[0] ?>"
                                                                data-medium     ="<?php echo $huge[0] ?>"
                                                                data-large      ="<?php echo $full[0] ?>"
<?php                                                   endif; ?> 
                                                >
<?php                                   endif; ?>
                                        
                                        <div class              ="carousel-caption" 
                                             data-animation     ="<?php echo $animation ?>" 
                                             data-speed         ="<?php echo $animation_speed ?>"
                                        >
                                                <div><a href="<?php the_permalink() ?>"><h1><?php the_title() ?></h1></a></div>
<?php                                           if( !!$excerpt && get_the_excerpt() != '' ) : ?>                          
                                                        <div class="hidden-xs hidden-sm">
                                                                <p><?php echo warta_the_excerpt_max_charlength( $excerpt ) ?></p>
                                                        </div>
<?php                                           endif ?>
                                        </div>
                                </div>
<?php                           
                        endif; 
                endwhile;
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
                $this->current_form_data        = $instance; 
                $this->sidebar_args             = $args;            
                extract($this->current_form_data);
               
                $the_query = new WP_Query( $this->get_query_args() );

                if ( $the_query->have_posts() ) :
                        $title          = apply_filters( 'widget_title', $title );
                        $id             = $this->id_base . '-' . rand();
                        $no_mobile      = $hide_mobile ? 'no-mobile' : '';
                        $is_large       = isset($args['is_large']);

                        if( !$is_large ) : ?>
                                <section class="widget <?php echo !isset($args['is_pb']) ? "col-md-12 " : ""; echo $no_mobile; ?>">
<?php                                   echo !empty($title) && !$is_large ? $args['before_title'] . $title . $args['after_title'] : '' ?>
                                        <div class="frame thick">
<?php                   endif ?>
                                                <div id                 ="<?php echo $id ?>" 
                                                     class              ="<?php echo "$no_mobile ";  echo $is_large ? 'carousel-large' : 'carousel-medium'; ?> carousel slide" 
                                                     data-ride          ="carousel" 
                                                     data-interval      ="<?php echo $interval ?>">
        
<?php                                                   if( $is_large ) {
                                                                $this->display_indicators($the_query, $id);
                                                        } ?>
                                                        
                                                        <div class="carousel-inner"><?php $this->display_items($the_query) ?></div>
                                                        <div class="image-light"></div>
                                                        <a class="left carousel-control" href="#<?php echo $id ?>" data-slide="prev"><span class="fa fa-chevron-left"></span></a>
                                                        <a class="right carousel-control" href="#<?php echo $id ?>" data-slide="next"><span class="fa fa-chevron-right"></span></a>                                                
                                                </div>  
                                        </div>
<?php                   if( !$is_large ) : ?>
<?php                           echo warta_image_shadow() ?>
                                </section>
<?php                   endif; 
                endif;

                wp_reset_postdata();
        }
} 
endif; // Warta_Posts_Carousel