<?php
/**
 * Articles Widget
 * 
 * @package Warta
 */

if(!class_exists('Warta_Articles')) :
class Warta_Articles extends Warta_Widget {
        
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
                        'warta_articles', // Base ID
                        __('[Warta] Articles', 'warta'), // Name
                        array( 'description' => __( 'Articles box.', 'warta' ), ) // Args
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
                        'layout'                => 1,
                        'title'                 => __( 'New title', 'warta' ),
                        'data'                  => 'latest',
                        'sort'                  => '',
                        'time_range'            => 'all',
                        'top_review'            => 0,                        
                        'category'              => '',                        
                        'tags'                  => '',                        
                        'post_ids'              => '',
                        'count'                 => 4,
                        'excerpt'               => 160,
                        'date_format'           => 'F j, Y',                        
                        'ignore_sticky'         => $is_update ? 0 : 1,                        
                        'meta_date'             => $is_update ? 0 : 1,
                        'meta_format'           => 0,
                        'meta_category'         => $is_update ? 0 : 1,
                        'meta_categories'       => 0,
                        'meta_author'           => 0,                        
                        'meta_comments'         => $is_update ? 0 : 1,
                        'meta_views'            => $is_update ? 0 : 1,
                        'meta_review_score'     => 0,
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
                $instance = $this->set_category_slug($instance);
                extract( wp_parse_args( $instance, $this->get_default_form_data() ) ); 
?>                    
                <div class="fsmh-container">                    
                        <!--Layout
                        ========== -->
                        <p>
<?php                           _e('Layout:', 'warta') ?><br>
                                <label class="fsmh-image-radio">
                                        <input type="radio" name="<?php echo $this->get_field_name( 'layout' ); ?>" value="1" <?php checked($layout, 1) ?>>
                                        <img src="<?php echo get_template_directory_uri() . '/img/admin/layout-article-v1.jpg' ?>">
                                </label>
                                <label class="fsmh-image-radio">
                                        <input type="radio" name="<?php echo $this->get_field_name( 'layout' ); ?>" value="2" <?php checked($layout, 2) ?>>
                                        <img src="<?php echo get_template_directory_uri() . '/img/admin/layout-article-v2.jpg' ?>">
                                </label>
                                <label class="fsmh-image-radio">
                                        <input type="radio" name="<?php echo $this->get_field_name( 'layout' ); ?>" value="3" <?php checked($layout, 3) ?>>
                                        <img src="<?php echo get_template_directory_uri() . '/img/admin/layout-article-v3.jpg' ?>">
                                </label>
                                <label class="fsmh-image-radio">
                                        <input type="radio" name="<?php echo $this->get_field_name( 'layout' ); ?>" value="4" <?php checked($layout, 4) ?>>
                                        <img src="<?php echo get_template_directory_uri() . '/img/admin/layout-article-v4.jpg' ?>">
                                </label>
                        </p>

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
                                                'hierarchical'  => TRUE,
                                                'walker'        => new Warta_Walker_CategoryDropdown_SlugValue()
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

                        <!--Excerpt length
                        ================== -->
                        <p>
                                <label>
<?php                                   _e('Excerpt Length:', 'warta') ?>
                                        <input class="widefat" name="<?php echo $this->get_field_name( 'excerpt' ); ?>" type="number" value="<?php echo esc_attr( $excerpt ); ?>">
                                </label>
                                <small><?php _e('How many characters do you want to show?', 'warta') ?></small>
                        </p>

                        <!--Date Format
                        =============== -->
                        <p>
                                <label>
<?php                                   _e('Date format:', 'warta') ?>
                                        <input class="widefat" name="<?php echo $this->get_field_name( 'date_format' ); ?>" type="text" value="<?php echo esc_attr( $date_format ); ?>">
                                </label>
                                <small>
<?php                                   _e('Click <a href="http://codex.wordpress.org/Formatting_Date_and_Time#Examples" target="_blank">here</a> to see some examples.', 'warta') ?> 
                                </small>
                        </p>
                    
                        <!--Ignore Sticky
                        ================= -->
                        <p>
                                <label>
                                        <input type="checkbox" name="<?php echo $this->get_field_name('ignore_sticky') ?>" value="1" <?php checked($ignore_sticky, 1) ?>>
                                        <?php _e('Ignore sticky posts', 'warta') ?>
                                </label>
                        </p>

                        <!--Post Meta
                        ============= -->
                        <p>
<?php                           _e('Post meta:', 'warta') ?><br>
                                <label>
                                        <input type="checkbox" name="<?php echo $this->get_field_name( 'meta_date' ); ?>" value="1" <?php checked($meta_date, '1') ?>"> 
<?php                                   _e('Date', 'warta') ?>
                                </label><br>
                                <label>
                                        <input type="checkbox" name="<?php echo $this->get_field_name( 'meta_format' ); ?>" value="1" <?php checked($meta_format, '1') ?>"> 
<?php                                   _e('Post format', 'warta') ?>
                                </label><br>
                                <label>
                                        <input type="checkbox" name="<?php echo $this->get_field_name( 'meta_category' ); ?>" value="1" <?php checked($meta_category, '1') ?>"> 
<?php                                   _e('First category', 'warta') ?>
                                </label><br>
                                <label>
                                        <input type="checkbox" name="<?php echo $this->get_field_name( 'meta_categories' ); ?>" value="1" <?php checked($meta_categories, '1') ?>"> 
<?php                                   _e('All categories', 'warta') ?>
                                </label><br>
                                <label>
                                        <input type="checkbox" name="<?php echo $this->get_field_name( 'meta_author' ); ?>" value="1" <?php checked($meta_author, '1') ?>"> 
<?php                                   _e('Author', 'warta') ?>
                                </label><br>
                                <label>
                                        <input type="checkbox" name="<?php echo $this->get_field_name( 'meta_comments' ); ?>" value="1" <?php checked($meta_comments, '1') ?>"> 
<?php                                   _e('Comments count', 'warta') ?>
                                </label><br>
                                <label>
                                        <input type="checkbox" name="<?php echo $this->get_field_name( 'meta_views' ); ?>" value="1" <?php checked($meta_views, '1') ?>"> 
<?php                                   _e('Views count', 'warta') ?>
                                </label><br>
                                <label>
                                        <input type="checkbox" name="<?php echo $this->get_field_name( 'meta_review_score' ); ?>" value="1" <?php checked($meta_review_score, '1') ?>"> 
<?php                                   _e('Review score', 'warta') ?>
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
                $new_instance   = wp_parse_args( $new_instance, $this->get_default_form_data(TRUE) );                
                $instance       = array();
                
                $instance['layout']             = (int) $new_instance['layout'];
                $instance['title']              = sanitize_text_field( $new_instance['title'] );
                $instance['data']               = sanitize_text_field( $new_instance['data'] );
                $instance['sort']               = sanitize_text_field( $new_instance['sort'] );
                $instance['time_range']         = sanitize_text_field( $new_instance['time_range'] );
                $instance['top_review']         = (int) $new_instance['top_review'];
                $instance['category']           = sanitize_text_field( $new_instance['category'] );
                $instance['tags']               = sanitize_text_field( $new_instance['tags'] );
                $instance['post_ids']           = sanitize_text_field( $new_instance['post_ids'] );
                $instance['count']              = (int) $new_instance['count'];
                $instance['excerpt']            = (int) $new_instance['excerpt'];
                $instance['date_format']        = sanitize_text_field( $new_instance['date_format'] );                
                $instance['ignore_sticky']      = (int) $new_instance['ignore_sticky'];                
                $instance['meta_date']          = (int) $new_instance['meta_date'];
                $instance['meta_format']        = (int) $new_instance['meta_format'];
                $instance['meta_category']      = (int) $new_instance['meta_category'];
                $instance['meta_categories']    = (int) $new_instance['meta_categories'];
                $instance['meta_author']        = (int) $new_instance['meta_author'];                
                $instance['meta_comments']      = (int) $new_instance['meta_comments'];
                $instance['meta_views']         = (int) $new_instance['meta_views'];
                $instance['meta_review_score']  = (int) $new_instance['meta_review_score'];

                return $instance;
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
                                $query_args['category_name']  = $category;
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
         * Get warta_featured_image() arguments
         * @param boolean $caption
         * @return array
         */
        protected function get_featured_image_args($caption = TRUE) {
                $featured_media = warta_match_featured_media();
                $matches_image  = warta_match_image();
                
                switch ( get_post_format() ) {
                        case 'audio': 
                        case 'video': 
                                return array(
                                        'size'                  => 'medium',
                                        'featured_media'        => $featured_media,
                                        'caption'               => $caption,
                                ); 
                        case 'image': 
                                return array(
                                        'size'                  => 'medium',
                                        'featured_media'        => $featured_media,
                                        'image'                 => isset( $matches_image['image'] ) ? $matches_image['image'] : '',
                                        'image_url'             => isset( $matches_image['image_url'] ) ? $matches_image['image_url'] : '',
                                        'caption'               => $caption               
                                 ); 
                        default: 
                                return array(
                                        'size'      => 'medium',
                                        'caption'   => $caption
                                );
                }
        }
        
        protected function display_widget_more_link() {
                extract($this->current_form_data);
                
                if( $data == 'category' ){
                        $url = esc_url( get_category_link( get_category_by_slug($category) ) ); 
                } else if( $data == 'latest' && get_option('page_for_posts') ) {
                        $url = esc_url( get_page_link( get_option('page_for_posts') ) );
                } 

                if(isset($url)) : ?>
                        <a href="<?php echo $url ?>" class="control" title="<?php _e('More posts', 'warta') ?>">
                                <i class="fa fa-plus"></i>
                        </a>
<?php           endif;
        }
        
        protected function display_title() {
                extract($this->current_form_data);
                
                $title = apply_filters( 'widget_title', $title );
                
                if( !empty($title) ) :  ?>
                        <header class="clearfix">
                                <h4><?php echo strip_tags($title) ?></h4>           
<?php                           $this->display_widget_more_link() ?>
                        </header>
<?php           endif; // title 
        }
        
        protected function display_post_meta() {
                extract($this->current_form_data);
                
                echo warta_posted_on(array(
                        'meta_date'         => $meta_date,
                        'date_format'       => $date_format,
                        'meta_format'       => $meta_format,
                        'meta_author'       => $meta_author,
                        'meta_comments'     => $meta_comments,
                        'meta_views'        => $meta_views,
                        'meta_category'     => $meta_category,
                        'meta_categories'   => $meta_categories,
                        'meta_review_score' => $meta_review_score,
                ));
        }
        
        protected function display_article_tiny() {
?>
                <article class="article-tiny">
<?php                   warta_featured_image( array( 'size' => 'tiny') ) ?>  
                        <h5><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h5>
<?php                   $this->display_post_meta(); ?> 
                        <hr>
                </article>
<?php
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
                global  $friskamax_warta_var,  
                        $content_width;
                
                $tmp_content_width              = $content_width;
                $content_width                  = 360;
                $this->current_form_data        = $this->set_category_slug($instance); 
                
                extract($instance);
                
                $counter        = 0; // articles counter
                $template       = dirname(__FILE__) . "/templates/articles-{$layout}.php";

                $the_query = new WP_Query( $this->get_query_args() );
                if ( $the_query->have_posts() && file_exists( $template ) ) {
                        require $template; // get the template
                        
                        // add clearfix
                        if( !isset($args['is_pb']) ) {
                                warta_add_clearfix( $args['id'] ); 
                        }
                } 
                wp_reset_postdata(); // Restore original Post Data
                
                $content_width = $tmp_content_width;
        }

} // class Warta_Articles
endif; 