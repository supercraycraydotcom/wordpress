<?php
/**
 * Tabs Widget
 * 
 * @package Warta
 */

if(!class_exists('Warta_Tabs')) :
class Warta_Tabs extends Warta_Widget {
        /**
         * Current option values
         * @var array
         */
        protected $current_form_data;
        
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
                        'warta_tabs', // Base ID
                        __('[Warta] Tabs', 'warta'), // Name
                        array( 'description' => __( 'Togglable tabs ', 'warta' ), ) // Args
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
                extract( wp_parse_args( $instance, array( 
                        'title'                 => array( __( 'New title', 'warta' )),
                        'data'                  => array( 'latest' ),
                        'sort'                  => array( 'comments' ),
                        'time_range'            => array( 'all' ),
                        'category'              => array( 0 ),                        
                        'tags'                  => array( '' ),
                        'top_review'            => array( 0 ),                        
                        'post_ids'              => array( '' ),
                        'posts_counts'          => array( 0 ),                        
                        'comment_excerpt'       => array( 50 ),                        
                        'count'                 => array( 4 ),                        
                        'date_format'           => array( 'F j, Y' ),
                        'display_featured_image'=> array( 1 ),
                        'ignore_sticky'         => array( 1 ),
                        'meta_date'             => array( 1 ),
                        'meta_format'           => array( 0 ),
                        'meta_category'         => array( 1 ),
                        'meta_categories'       => array( 0 ),
                        'meta_author'           => array( 0 ),
                        'meta_comments'         => array( 0 ),
                        'meta_views'            => array( 0 ),
                        'meta_review_score'     => array( 0 ),
                ) ) ); 
?>

                <!--Title that appears on widget settings page-->
                <input id="<?php echo $this->get_field_id( 'title' ); ?>"  type="hidden" value="<?php echo esc_attr(implode( ' / ', $title) ) ?>">

                <div class="fsmh-container">
<?php                   for ($i = 0; $i < count($title); $i++): ?>
                                <div class="fsmh-tab">
                                        <!--Title
                                        ========= -->
                                        <p>
                                                <label><?php _e( 'Title:', 'warta' ); ?>
                                                        <input class    ="widefat" 
                                                               name     ="<?php echo $this->get_field_name( 'title' ); ?>[]" 
                                                               type     ="text" 
                                                               value    ="<?php echo sanitize_text_field( $title[$i] ); ?>"
                                                        >
                                                </label> 
                                        </p>

                                        <!--Data
                                        ======== -->
                                        <p>
                                                <label><?php _e('Data:', 'warta') ?>
                                                        <select name    ="<?php echo $this->get_field_name( 'data' ) ?>[]" 
                                                                class   ="widefat"
                                                                data-id ="<?php echo $this->get_field_id( 'data' ) ?>"
                                                        >
                                                                <option value="latest"          <?php selected( $data[$i], 'latest' ) ?>>               <?php _e('Latest posts', 'warta') ?>            </option>
                                                                <option value="popular"         <?php selected( $data[$i], 'popular' ) ?>>              <?php _e('Popular posts', 'warta') ?>           </option>
                                                                <option value="category"        <?php selected( $data[$i], 'category' ) ?>>             <?php _e('Posts by category', 'warta') ?>       </option>
                                                                <option value="tags"            <?php selected( $data[$i], 'tags' ) ?>>                 <?php _e('Posts by tags', 'warta') ?>           </option>
                                                                <option value="review"          <?php selected( $data[$i], 'review' ) ?>>               <?php _e('Review posts', 'warta') ?>            </option>
                                                                <option value="post_ids"        <?php selected( $data[$i], 'post_ids' ) ?>>             <?php _e('Posts by selected IDs', 'warta') ?>   </option>
                                                                <option value="list_categories" <?php selected( $data[$i], 'list_categories' ) ?>>      <?php _e('List of main categories', 'warta') ?> </option>
                                                                <option value="popular_tags"    <?php selected( $data[$i], 'popular_tags' ) ?>>         <?php _e('Popular tags', 'warta') ?>            </option>
                                                                <option value="recent_comments" <?php selected( $data[$i], 'recent_comments' ) ?>>      <?php _e('Recent comments', 'warta') ?>         </option>
                                                        </select>
                                                </label>
                                        </p>

                                        <!--Data: popular > Sort By
                                        =========================== -->
                                        <p data-requires='<?php echo $this->get_attr_requires__data('popular') ?>'>
                                                <label><?php _e('Sort by:', 'warta') ?>
                                                        <select name="<?php echo $this->get_field_name( 'sort' ); ?>[]" class="widefat">
                                                                <option value="comments" <?php selected($sort[$i], 'comments') ?>><?php _e('Comments count', 'warta') ?></option>
                                                                <option value="views" <?php selected($sort[$i], 'views') ?>><?php _e('Views count', 'warta') ?></option>
                                                        </select>
                                                </label>
                                        </p>

                                        <!--Data: popular, review > time range
                                        ====================================== -->
                                        <p data-requires='<?php echo $this->get_attr_requires__data( array('popular', 'review') ) ?>'>
                                                <label><?php _e('Time range:', 'warta') ?>
                                                        <select name="<?php echo $this->get_field_name( 'time_range' ); ?>[]" class="widefat">
                                                                <option value="all"     <?php selected($time_range[$i], 'all') ?>>      <?php _e('All time', 'warta') ?>        </option>
                                                                <option value="year"    <?php selected($time_range[$i], 'year') ?>>     <?php _e('Last year', 'warta') ?>       </option>
                                                                <option value="month"   <?php selected($time_range[$i], 'month') ?>>    <?php _e('Last month', 'warta') ?>      </option>
                                                                <option value="week"    <?php selected($time_range[$i], 'week') ?>>     <?php _e('Last week', 'warta') ?>       </option>
                                                        </select>
                                                </label>
                                        </p>

                                        <!--Data: category > category
                                        ============================= -->
                                        <p data-requires='<?php echo $this->get_attr_requires__data('category') ?>'>
                                                <label>
<?php                                                   _e('Category:', 'warta');
                                                        wp_dropdown_categories(array(
                                                                'name'          => $this->get_field_name( 'category' ) . '[]',
                                                                'class'         => 'widefat',
                                                                'selected'      => $category[$i],
                                                                'hierarchical'  => TRUE
                                                        )) ?>
                                                </label>
                                        </p>

                                        <!--Data: Tags > selected tags
                                        ==============================-->
                                        <p data-requires='<?php echo $this->get_attr_requires__data('tags') ?>'>
                                                <label><?php _e('Tags:', 'warta') ?>
                                                        <input type="text" name="<?php echo $this->get_field_name( 'tags' ) ?>[]" value="<?php echo esc_attr( $tags[$i] ) ?>" class="widefat">
                                                </label>
                                                <small><?php _e('Enter the tag slugs, separated by commas.', 'warta') ?></small>
                                        </p>

                                        <!--Data: review > top review
                                        ============================= -->
                                        <p data-requires='<?php echo $this->get_attr_requires__data('review') ?>'>
                                                <label>
                                                        <input type="checkbox" name="warta_checkbox[]" <?php checked($top_review[$i], 1) ?>">
                                                        <input name="<?php echo $this->get_field_name( 'top_review' ); ?>[]" type="hidden" value="<?php echo $top_review[$i] ? 1 : 0 ?>">
<?php                                                   _e('Sort by review score', 'warta') ?>
                                                </label>
                                        </p>

                                        <!--Data: post_ids > the posts IDs
                                        ================================== -->
                                        <p data-requires='<?php echo $this->get_attr_requires__data('post_ids') ?>'>
                                                <label><?php _e('Post IDs:', 'warta') ?>
                                                        <input class="widefat" name="<?php echo $this->get_field_name( 'post_ids' ); ?>[]" type="text" value="<?php echo esc_attr( $post_ids[$i] ); ?>">
                                                </label>
                                                <small><?php _e('Enter the post IDs, separated by commas.', 'warta') ?></small>
                                        </p>

                                        <!--Data: list_categories > show post counts
                                        ============================================ -->
                                        <p data-requires='<?php echo $this->get_attr_requires__data('list_categories') ?>'>
                                                <label>
                                                        <input type="checkbox" name="warta_checkbox[]" <?php checked($posts_counts[$i], '1') ?>">
                                                        <input type="hidden" name="<?php echo $this->get_field_name( 'posts_counts' ); ?>[]" value="<?php echo $posts_counts[$i] ? 1 : 0 ?>"> 
                                                        <?php _e('Show post counts', 'warta') ?>
                                                </label>
                                        </p>

                                        <!--Data: recent_comments > comment excerpt
                                        =========================================== -->
                                        <p data-requires='<?php echo $this->get_attr_requires__data('recent_comments') ?>'>
                                                <label><?php _e( 'Excerpt length:', 'warta' ); ?>
                                                        <input class="widefat" name="<?php echo $this->get_field_name( 'comment_excerpt' ); ?>[]" type="number" value="<?php echo (int) $comment_excerpt[$i] ?>">
                                                </label> 
                                                <small><?php _e('How many characters do you want to show?', 'warta') ?></small>
                                        </p>

                                        <!--Data: latest, popular, category, tags, review, post_ids, popular_tags, recent_comments > number of items to show
                                        ==================================================================================================================== -->
                                        <p data-requires='<?php echo $this->get_attr_requires__data( array('latest', 'popular', 'category', 'tags', 'review', 'post_ids', 'popular_tags', 'recent_comments') ) ?>'>
                                                <label><?php _e('Number of items to show:', 'warta') ?>
                                                        <input class="widefat" name="<?php echo $this->get_field_name( 'count' ); ?>[]" type="number" value="<?php echo esc_attr( $count[$i] ); ?>">
                                                </label>
                                        </p>

                                        <!--Data: latest, popular, category, tags, review, post_ids, recent_comments > date format
                                        ==========================================================================================-->
                                        <p data-requires='<?php echo $this->get_attr_requires__data( array('latest', 'popular', 'category', 'tags', 'review', 'post_ids', 'recent_comments') ); ?>'>
                                                <label><?php _e('Date format:', 'warta') ?>
                                                        <input class="widefat" name="<?php echo $this->get_field_name( 'date_format' ); ?>[]" type="text" value="<?php echo esc_attr( $date_format[$i] ); ?>">
                                                </label>
                                                <small><?php _e('Click <a href="http://codex.wordpress.org/Formatting_Date_and_Time#Examples" target="_blank">here</a> to see some examples.', 'warta') ?> </small>
                                        </p>

                                        <!--Data: latest, popular, category, tags, review, post_ids > Display featured image
                                        ==================================================================================== -->
                                        <p data-requires='<?php echo $this->get_attr_requires__data( array('latest', 'popular', 'category', 'tags', 'review', 'post_ids') ) ?>'> 
                                                <label>
                                                        <input type="checkbox" <?php checked($display_featured_image[$i], '1') ?>">
                                                        <input type="hidden" name="<?php echo $this->get_field_name( 'display_featured_image' ); ?>[]" value="<?php echo $display_featured_image[$i] ? 1 : 0 ?>"> 
                                                        <?php _e('Display featured image', 'warta') ?>
                                                </label>
                                        </p>

                                        <!--Data: latest, popular, category, tags, review, post_ids > Ignore Sticky
                                        =========================================================================== -->
                                        <p data-requires='<?php echo $this->get_attr_requires__data( array('latest', 'popular', 'category', 'tags', 'review', 'post_ids') ) ?>'> 
                                                <label>
                                                        <input type="checkbox" <?php checked($ignore_sticky[$i], '1') ?>">
                                                        <input type="hidden" name="<?php echo $this->get_field_name( 'ignore_sticky' ); ?>[]" value="<?php echo $ignore_sticky[$i] ? 1 : 0 ?>"> 
                                                        <?php _e('Ignore sticky posts', 'warta') ?>
                                                </label>
                                        </p>

                                        <!--Data: latest, popular, category, tags, review, post_ids > Post Meta
                                        ======================================================================= -->
                                        <p data-requires='<?php echo $this->get_attr_requires__data( array('latest', 'popular', 'category', 'tags', 'review', 'post_ids') ) ?>'> 
<?php                                           _e('Post meta:', 'warta') ?><br>
                                                <label>
                                                        <input type="checkbox" name="warta_checkbox[]" <?php checked($meta_date[$i], '1') ?>">
                                                        <input type="hidden" name="<?php echo $this->get_field_name( 'meta_date' ); ?>[]" value="<?php echo $meta_date[$i] ? 1 : 0 ?>"> 
<?php                                                   _e('Date', 'warta') ?>
                                                </label><br>
                                                <label>
                                                        <input type="checkbox" name="warta_checkbox[]" <?php checked($meta_format[$i], '1') ?>">
                                                        <input type="hidden" name="<?php echo $this->get_field_name( 'meta_format' ); ?>[]" value="<?php echo $meta_format[$i] ? 1 : 0 ?>"> 
<?php                                                   _e('Post format', 'warta') ?>
                                                </label><br>
                                                <label>
                                                        <input type="checkbox" name="warta_checkbox[]" <?php checked($meta_category[$i], '1') ?>">
                                                        <input type="hidden" name="<?php echo $this->get_field_name( 'meta_category' ); ?>[]" value="<?php echo $meta_category[$i] ? 1 : 0 ?>"> 
<?php                                                   _e('First category', 'warta') ?>
                                                </label><br>
                                                <label>
                                                        <input type="checkbox" name="warta_checkbox[]" <?php checked($meta_categories[$i], '1') ?>"> 
                                                        <input type="hidden" name="<?php echo $this->get_field_name( 'meta_categories' ); ?>[]" value="<?php echo $meta_categories[$i] ? 1 : 0 ?>"> 
<?php                                                   _e('All categories', 'warta') ?>
                                                </label><br>
                                                <label>
                                                        <input type="checkbox" name="warta_checkbox[]" <?php checked($meta_author[$i], '1') ?>">
                                                        <input type="hidden" name="<?php echo $this->get_field_name( 'meta_author' ); ?>[]" value="<?php echo $meta_author[$i] ? 1 : 0 ?>"> 
<?php                                                   _e('Author', 'warta') ?>
                                                </label><br>
                                                <label>
                                                        <input type="checkbox" name="warta_checkbox[]" <?php checked($meta_comments[$i], '1') ?>">
                                                        <input type="hidden" name="<?php echo $this->get_field_name( 'meta_comments' ); ?>[]" value="<?php echo $meta_comments[$i] ? 1 : 0 ?>"> 
<?php                                                   _e('Comments count', 'warta') ?>
                                                </label><br>
                                                <label>
                                                        <input type="checkbox" name="warta_checkbox[]" <?php checked($meta_views[$i], '1') ?>">
                                                        <input type="hidden" name="<?php echo $this->get_field_name( 'meta_views' ); ?>[]" value="<?php echo $meta_views[$i] ? 1 : 0 ?>"> 
<?php                                                   _e('Views count', 'warta') ?>
                                                </label><br>
                                                <label>
                                                        <input type="checkbox" name="warta_checkbox[]" <?php checked($meta_review_score[$i], '1') ?>">
                                                        <input type="hidden" name="<?php echo $this->get_field_name( 'meta_review_score' ); ?>[]" value="<?php echo $meta_review_score[$i] ? 1 : 0 ?>"> 
<?php                                                   _e('Review score', 'warta') ?>
                                                </label>
                                        </p>

                                        <br>
                                        <button type="button" class="fsmh-tab-remove button button-small"><?php _e('Delete tab', 'warta') ?></button>
                                </div> 
<?php                   endfor; ?>
                                                
                        <button type="button" class="fsmh-tab-add button button-small"><?php _e('Add tab', 'warta') ?></button>
                        <br>
                        <br>
                        <hr>
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
                $instance = array();

                extract($new_instance);

                for ($i = 0; $i < count($title); $i++) {
                        $instance['title'][$i]                  = empty($title[$i]) ? __('New title', 'warta') : sanitize_text_field( $title[$i] );
                        $instance['data'][$i]                   = sanitize_text_field( $data[$i] );
                        $instance['sort'][$i]                   = sanitize_text_field( $sort[$i] );
                        $instance['time_range'][$i]             = sanitize_text_field( $time_range[$i] );
                        $instance['category'][$i]               = (int) $category[$i];
                        $instance['tags'][$i]                   = sanitize_text_field( $tags[$i] );
                        $instance['top_review'][$i]             = (int) $top_review[$i];
                        $instance['post_ids'][$i]               = sanitize_text_field( $post_ids[$i] );
                        $instance['posts_counts'][$i]           = (int) $posts_counts[$i];
                        $instance['comment_excerpt'][$i]        = (int) $comment_excerpt[$i];
                        $instance['count'][$i]                  = (int) $count[$i];
                        $instance['date_format'][$i]            = sanitize_text_field( $date_format[$i] );
                        $instance['display_featured_image'][$i] = (int) $display_featured_image[$i];
                        $instance['ignore_sticky'][$i]          = (int) $ignore_sticky[$i];
                        $instance['meta_date'][$i]              = (int) $meta_date[$i];
                        $instance['meta_format'][$i]            = (int) $meta_format[$i];
                        $instance['meta_category'][$i]          = (int) $meta_category[$i];
                        $instance['meta_categories'][$i]        = (int) $meta_categories[$i];
                        $instance['meta_author'][$i]            = (int) $meta_author[$i];
                        $instance['meta_comments'][$i]          = (int) $meta_comments[$i];
                        $instance['meta_views'][$i]             = (int) $meta_views[$i];
                        $instance['meta_review_score'][$i]      = (int) $meta_review_score[$i];
                }

                return $instance;
        }
        
        /**
         * Get WP_Query arguments
         * 
         * @param int $i Array key of $this->current_form_data
         * @return array
         */
        protected function get_query_args($i) {
                extract($this->current_form_data);
                
                $query_args     = array( 
                        'posts_per_page'        => $count[$i],
                        'ignore_sticky_posts'   => $ignore_sticky[$i]
                );

                // Query args
                switch ( $data[$i] ) {
                        case 'category':
                                $query_args['cat'] = $category[$i];
                                break;
                        case 'tags':
                                $query_args['tax_query'] = array(
                                        array(
                                                'taxonomy'  => 'post_tag',
                                                'field'     => 'slug',
                                                'terms'     => explode(',', $tags[$i])
                                        )
                                );
                                break;
                        case 'review':
                                $query_args['meta_key']     = 'friskamax_review_total'; 
                                $query_args['meta_value']   = 0;
                                $query_args['meta_compare'] = '>';      

                                if( $top_review[$i] ) {
                                        $query_args['orderby']  = 'meta_value_num';
                                }
                                break;
                        case 'popular':
                                if( $sort[$i] === 'comments' ) {    
                                        $query_args['orderby']  = 'comment_count'; 
                                } else {
                                        $query_args['meta_key'] = 'warta_post_views_count';
                                        $query_args['orderby']  = 'meta_value_num';
                                }                                        
                                break;
                        case 'post_ids':
                                $query_args['post__in']     = explode(',', $post_ids[$i]);
                                break;
                }

                // Time range
                if( $time_range[$i] != 'all' && ( $data[$i] == 'review' || $data[$i] == 'popular' ) ) {
                        switch ($time_range[$i]) {
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
         * Set unique tab IDs
         * 
         * @param string $widget_id
         */
        protected function set_tab_ids($widget_id) {
                foreach ($this->current_form_data['title'] as $value) {
                        $this->current_form_data['tab_id'][] = "$widget_id-" . rand();
                }
        } 
        
        protected function display_tab_menu() {
                extract($this->current_form_data);                
?>
                <ul class="nav nav-tabs">
<?php                   for( $i = 0; $i < count($title); $i++ ) : 
                                $title[$i] = strip_tags( apply_filters('widget_title', $title[$i]) ); ?>
                                <li class="<?php echo $i === 0 ? 'active' : '' ?>">
                                        <a href="#<?php echo $tab_id[$i] ?>" data-toggle="tab"><?php echo $title[$i] ?></a>
                                </li>
<?php                   endfor; ?>
                </ul>
<?php              
        }
        
        protected function display_list_categories($i) {
                extract($this->current_form_data);
                $categories = get_categories( array( 'parent' => 0 ) );
?>
                <ul class="categories">
<?php                   foreach( $categories as $category ) : ?>
                                <li>
                                        <a href="<?php echo esc_url( get_category_link( $category->term_id ) ) ?>"
                                           title="<?php echo esc_attr( sprintf( __( "View %d posts under %s category", 'warta' ), $category->count, $category->name ) ) ?>"
                                        >
                                                <i class="fa fa-angle-<?php echo is_rtl() ? 'left' : 'right' ?>"></i> <?php echo strip_tags( $category->name ); ?>
<?php                                           if($posts_counts[$i]) : ?>
                                                        <span class="post-counts"><?php echo $category->count ?></span>
<?php                                           endif; ?>
                                        </a>
                                </li>
<?php                   endforeach; ?>
                </ul>
<?php
        }
        
        protected function display_popular_tags($i) {
                extract($this->current_form_data);
                
                $tags = get_tags( array(
                        'orderby'   => 'count',
                        'order'     => 'DESC',
                        'number'    => $count[$i]
                ) );
?>
                <ul class="tags clearfix">
<?php                   foreach ($tags as $tag) : ?>
                                <li>
                                        <a href ="<?php echo esc_url( get_tag_link( $tag->term_id ) ) ?>" 
                                           title="<?php echo esc_attr( sprintf( __("View %d posts with %s tag", 'warta'), $tag->count, $tag->name ) ) ?>"
                                           >
<?php                                           echo strip_tags($tag->name) ?>
                                        </a>
                                </li>
<?php                   endforeach; ?>
                </ul>
<?php
        }
        
        protected function display_recent_comments($i) {                
                extract($this->current_form_data);
                
                $comments       = get_comments( array(
                                        'status'    => 'approve',
                                        'type'      => 'comment',
                                        'number'    => $count[$i]
                                ) );  
                $layer          = warta_is_footer($this->sidebar_args['id']) ? 'dark' : 'light'; // layer style
?>
                <ul class="recent-comments clearfix">
<?php                   foreach($comments as $comment) : ?> 
                                <li>
                                        <div class="avatar">
                                                <a href ="<?php echo esc_url($comment->comment_author_url) ?>" 
                                                   class="<?php echo $layer ?>" 
                                                   title="<?php echo esc_attr($comment->comment_author) ?>"
                                                >
<?php                                                   echo get_avatar( $comment->comment_author_email , 75) ?>
                                                        <div class="layer"></div>
                                                </a>
                                        </div>
                                        <div class="content">
                                                <div class="comment-content">
                                                        <a href="<?php echo esc_url( get_permalink($comment->comment_post_ID) ) ?>"> 
<?php                                                           echo warta_the_excerpt_max_charlength($comment_excerpt[$i], $comment->comment_content) ?>
                                                        </a>
                                                </div>
                                                <div class="comment-meta">
                                                        <a href="<?php echo esc_url($comment->comment_author_url) ?>">
                                                                <i class="fa fa-user"></i> <?php echo strip_tags($comment->comment_author) ?>
                                                        </a>&nbsp;
                                                        <a href="<?php echo esc_url( get_permalink($comment->comment_post_ID) ) ?>">
                                                                <i class="fa fa-clock-o"></i> <?php echo get_comment_date($date_format[$i], $comment->comment_ID) ?>
                                                        </a>
                                                </div>
                                        </div>
                                </li>
<?php                   endforeach; ?>
                </ul>
<?php
        }
        
        protected function display_articles($i) {
                extract($this->current_form_data);
                $display_featured_image = isset($display_featured_image[$i]) ? $display_featured_image[$i] : 1;

                $the_query  = new WP_Query( $this->get_query_args($i) ); 
                
                if ( $the_query->have_posts() ) :
                        while ( $the_query->have_posts() ) : 
                                $the_query->the_post(); 

                                $classes                = warta_is_footer($this->sidebar_args) ? 'image dark' : 'image';
                                $format                 = get_post_format() ? get_post_format() : 'standard';
?>
                                <article class="article-tiny">
<?php                                   if(!!$display_featured_image) : 
                                                if(has_post_thumbnail()) : ?>
                                                        <a href="<?php the_permalink() ?>" class="<?php echo $classes ?>">
<?php                                                           echo the_post_thumbnail('thumbnail') ?>
                                                                <div class="image-light"></div>
                                                                <div class="link">
                                                                        <span class="dashicons dashicons-format-<?php echo $format ?>"></span>
                                                                </div>
<?php                                                           echo warta_is_footer($this->sidebar_args) ? '<div class="layer"></div>' : ''; ?>
                                                        </a>
<?php                                           else : ?>
                                                        <div class="image">
                                                                <div class="format-placeholder dashicons dashicons-format-<?php echo $format ?>"></div>
                                                                <div class="image-light"></div>
                                                        </div>
<?php                                           endif; 
                                        endif; ?>

                                        <a href="<?php the_permalink() ?>"><h5><?php the_title() ?></h5></a>
<?php                                   echo warta_posted_on( array(
                                                'meta_date'         => $meta_date[$i],
                                                'date_format'       => $date_format[$i],
                                                'meta_format'       => $meta_format[$i],
                                                'meta_comments'     => $meta_comments[$i],
                                                'meta_views'        => $meta_views[$i],
                                                'meta_category'     => $meta_category[$i],
                                                'meta_categories'   => $meta_categories[$i],
                                                'meta_author'       => $meta_author[$i],
                                                'meta_review_score' => $meta_review_score[$i],
                                        ) ); 
?>
                                        <hr>
                                </article>
<?php                   endwhile;
                endif;
                wp_reset_postdata();      
        }
        
        protected function display_tab_content() {
                extract($this->current_form_data);
?>
                <div class="tab-content">
<?php                   for( $i = 0; $i < count($title); $i++ ) :
                                $active         = $i === 0 ? 'active' : '';
                                $in             = $i === 0 ? 'in' : '';
?>
                                <div class="tab-pane fade <?php echo "$active $in" ?>" id="<?php echo $tab_id[$i] ?>">
<?php                                   switch ($data[$i]) { 
                                                case 'list_categories':
                                                        $this->display_list_categories($i);
                                                        break;
                                                case 'popular_tags':
                                                        $this->display_popular_tags($i);
                                                        break;
                                                case 'recent_comments':
                                                        $this->display_recent_comments($i);
                                                        break;
                                                default:
                                                        $this->display_articles($i);
                                                    break;
                                        } ?>
                                </div>
<?php                   endfor; ?>
                </div>
<?php
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
                $this->set_tab_ids($args['widget_id']);                
                extract($this->current_form_data);
?>
                <section class="<?php warta_widget_class( $args['id'], 6, TRUE, isset($args['is_pb']) ) ?>">
<?php                   $this->display_tab_menu(); 
                        $this->display_tab_content(); ?>
                </section>
<?php 
                if( !isset($args['is_pb']) ) {
                        warta_add_clearfix( $args['id'], 6);
                }
        }

} 
endif; // Warta_Tabs