<?php
/**
 * Slider Tabs Widget
 * 
 * @package Warta
 */

if(!class_exists('Warta_Slider_Tabs')) :
class Warta_Slider_Tabs extends Warta_Widget {
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
                        'warta_slider_tabs', // Base ID
                        __('[Warta] Slider Tabs', 'warta'), // Name
                        array( 'description' => __( 'Items slider in togglable tabs.', 'warta' ), ) // Args
                );
        }
        
        /**
         * Get data-requires attribute for a field that requires field 'data'
         * 
         * @param array $fields
         * @return array
         */
        protected function get_attr_requires__data($fields) {                 
                $output         = array();
                $required_field = '[data-id=' . $this->get_field_id( 'data' ) . ']';
                
                foreach ( (array) $fields as $value ) {                        
                        $output[] = array(
                                'field'      => $required_field,
                                'compare'    => 'equal',
                                'value'      => $value
                        );
                }
                
                return json_encode($output);
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
                extract( wp_parse_args( $instance, array( 
                        'title'                 => array( __( 'New title', 'warta' ) ),
                        'data'                  => array( 'latest' ),
                        'category'              => array( '' ),
                        'tags'                  => array( '' ),
                        'gallery_post'          => array( 0 ),
                        'caption_length'        => array( 60 ),
                        'sort'                  => array( 'comments' ),
                        'time_range'            => array( 'all' ),
                        'post_ids'              => array( '' ),
                        'top_review'            => array( 0 ),
                        'count'                 => array( 12 ),
                        'date_format'           => array( 'M j, Y' ),
                        'ignore_sticky'         => array( 1 ),
                        'meta_date'             => array( 1 ),
                        'meta_format'           => array( 0 ),
                        'meta_category'         => array( 1 ),
                        'meta_author'           => array( 0 ),
                        'meta_comments'         => array( 0 ),
                        'meta_views'            => array( 0 ),
                        'meta_review_score'     => array( 0 ),
                        'hide_mobile'           => 1,
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
                                                                class   ="widefat warta-option-choice"
                                                                data-id ="<?php echo $this->get_field_id( 'data' ) ?>"
                                                        >
                                                                <option value="latest"          <?php selected( $data[$i], 'latest' ) ?>>       <?php _e('Latest posts', 'warta') ?>            </option>
                                                                <option value="popular"         <?php selected( $data[$i], 'popular' ) ?>>      <?php _e('Popular posts', 'warta') ?>           </option>
                                                                <option value="category"        <?php selected( $data[$i], 'category' ) ?>>     <?php _e('Posts by category', 'warta') ?>       </option>
                                                                <option value="tags"            <?php selected( $data[$i], 'tags' ) ?>>         <?php _e('Posts by tags', 'warta') ?>           </option>
                                                                <option value="gallery"         <?php selected( $data[$i], 'gallery' ) ?>>      <?php _e('Gallery images', 'warta') ?>          </option>
                                                                <option value="review"          <?php selected( $data[$i], 'review' ) ?>>       <?php _e('Review posts', 'warta') ?>            </option>
                                                                <option value="post_ids"        <?php selected( $data[$i], 'post_ids' ) ?>>     <?php _e('Posts by IDs', 'warta') ?>            </option>
                                                        </select>
                                                </label>
                                        </p>
                                        
                                        <!--Data: category > list categories
                                        ====================================-->
                                        <p data-requires='<?php echo $this->get_attr_requires__data('category') ?>'>
                                                <label><?php _e('Category:', 'warta') ?>
                                                        <?php wp_dropdown_categories(array(
                                                                'name'          => $this->get_field_name( 'category' ) . '[]',
                                                                'class'         => 'widefat',
                                                                'selected'      => $category[$i],
                                                                'hierarchical'  => TRUE,
                                                                'walker'        => new Warta_Walker_CategoryDropdown_SlugValue()
                                                        )) ?>
                                                </label>
                                        </p>

                                        <!--Data: tags > selected tags
                                        ==============================-->
                                        <p data-requires='<?php echo $this->get_attr_requires__data('tags') ?>'>
                                                <label><?php _e('Tags:', 'warta') ?>
                                                        <input type="text" name="<?php echo $this->get_field_name( 'tags' ) ?>[]" value="<?php echo esc_attr( $tags[$i] ) ?>" class="widefat">
                                                </label>
                                                <small><?php _e('Enter the tag slugs, separated by commas.', 'warta') ?></small>
                                        </p>

                                        <!--Data: gallery > gallery posts
                                        =================================-->
                                        <p data-requires='<?php echo $this->get_attr_requires__data('gallery') ?>'>
                                                <label><?php _e('Gallery post:', 'warta') ?>
                                                        <select name="<?php echo $this->get_field_name( 'gallery_post' ) ?>[]" class="widefat">
<?php                                                           $the_query = new WP_Query( array(
                                                                        'tax_query' => array(
                                                                                array(
                                                                                        'taxonomy'  => 'post_format',
                                                                                        'field'     => 'slug',
                                                                                        'terms'     => array( 'post-format-gallery' )
                                                                                )
                                                                        )
                                                                ) );

                                                                if ( $the_query->have_posts() ) : 
                                                                        while ( $the_query->have_posts() ) : 
                                                                                $the_query->the_post(); ?>
                                                                                <option value="<?php the_ID() ?>" <?php selected($gallery_post[$i], get_the_ID()) ?>>
<?php                                                                                   the_title() ?>
                                                                                </option>
<?php                                                                   endwhile; 
                                                                endif;
                                                                wp_reset_postdata()  ?>
                                                        </select>
                                                </label>
                                        </p>

                                        <!--Data: gallery > caption length
                                        ==================================-->
                                        <p data-requires='<?php echo $this->get_attr_requires__data('gallery') ?>'>
                                                <label><?php _e('Caption Length:', 'warta') ?>
                                                        <input class="widefat" name="<?php echo $this->get_field_name( 'caption_length' ); ?>[]" type="number" value="<?php echo (int) $caption_length[$i] ?>">
                                                </label>
                                                <small>How many characters of the caption do you want to show?</small>
                                        </p>

                                        <!--Data: popular > sort by
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

                                        <!--Data: post_ids > The posts IDs
                                        ==================================-->
                                        <p data-requires='<?php echo $this->get_attr_requires__data('post_ids') ?>'>
                                                <label><?php _e('Post IDs:', 'warta') ?>
                                                        <input class="widefat" name="<?php echo $this->get_field_name( 'post_ids' ); ?>[]" type="text" value="<?php echo esc_attr( $post_ids[$i] ); ?>">
                                                </label>
                                                <small><?php _e('Enter the post IDs, separated by commas.', 'warta') ?></small>
                                        </p>

                                        <!--Data: review > Top review
                                        =============================-->
                                        <p data-requires='<?php echo $this->get_attr_requires__data('review') ?>'> 
                                                <label>
                                                        <input type="checkbox" <?php checked($top_review[$i], 1) ?>">
                                                        <input name="<?php echo $this->get_field_name( 'top_review' ); ?>[]" type="hidden" value="<?php echo $top_review[$i] ? 1 : 0 ?>">
                                                        <?php _e('Sort by review score', 'warta') ?>
                                                </label>
                                        </p>

                                        <!--Data: latest, popular, category, tags, post_ids, review  > Number of Items to Show
                                        ====================================================================================== -->
                                        <p data-requires='<?php echo $this->get_attr_requires__data( array('latest', 'popular', 'category', 'tags', 'post_ids', 'review' ) ) ?>'>                                          
                                                <label><?php _e('Number of items to show:', 'warta') ?>
                                                        <input class="widefat" name="<?php echo $this->get_field_name( 'count' ); ?>[]" type="number" value="<?php echo esc_attr( $count[$i] ); ?>">
                                                </label>
                                        </p>

                                        <!--Data: latest, popular, category, tags, post_ids, review  > Date Format
                                        ========================================================================== -->
                                        <p data-requires='<?php echo $this->get_attr_requires__data( array('latest', 'popular', 'category', 'tags', 'post_ids', 'review') ) ?>'> 
                                                <label><?php _e('Date format:', 'warta') ?>
                                                        <input class="widefat" name="<?php echo $this->get_field_name( 'date_format' ); ?>[]" type="text" value="<?php echo esc_attr( $date_format[$i] ); ?>">
                                                </label>
                                                <small><?php _e('Click <a href="http://codex.wordpress.org/Formatting_Date_and_Time#Examples" target="_blank">here</a> to see some examples.', 'warta') ?> </small>
                                        </p>

                                        <!--Data: latest, popular, category, tags, post_ids, review  > Ignore Sticky
                                        ============================================================================ -->
                                        <p data-requires='<?php echo $this->get_attr_requires__data( array('latest', 'popular', 'category', 'tags', 'post_ids', 'review') ) ?>'>  
                                                <label>
                                                        <input type="checkbox" <?php checked($ignore_sticky[$i], '1') ?>">
                                                        <input type="hidden" name="<?php echo $this->get_field_name( 'ignore_sticky' ); ?>[]" value="<?php echo $ignore_sticky[$i] ? 1 : 0 ?>"> 
                                                        <?php _e('Ignore sticky posts', 'warta') ?>
                                                </label>
                                        </p>

                                        <!--Data: latest, popular, category, tags, post_ids, review  > Post Meta
                                        ======================================================================== -->
                                        <p data-requires='<?php echo $this->get_attr_requires__data( array('latest', 'popular', 'category', 'tags', 'post_ids', 'review') ) ?>'> 
                                                <?php _e('Post meta:', 'warta') ?><br>
                                                <label>
                                                        <input type="checkbox" <?php checked($meta_date[$i], '1') ?>">
                                                        <input type="hidden" name="<?php echo $this->get_field_name( 'meta_date' ); ?>[]" value="<?php echo $meta_date[$i] ? 1 : 0 ?>"> 
                                                        <?php _e('Date', 'warta') ?>
                                                </label><br>
                                                <label>
                                                        <input type="checkbox" <?php checked($meta_format[$i], '1') ?>">
                                                        <input type="hidden" name="<?php echo $this->get_field_name( 'meta_format' ); ?>[]" value="<?php echo $meta_format[$i] ? 1 : 0 ?>"> 
                                                        <?php _e('Post format', 'warta') ?>
                                                </label><br>
                                                <label>
                                                        <input type="checkbox" <?php checked($meta_category[$i], '1') ?>">
                                                        <input type="hidden" name="<?php echo $this->get_field_name( 'meta_category' ); ?>[]" value="<?php echo $meta_category[$i] ? 1 : 0 ?>"> 
                                                        <?php _e('Category', 'warta') ?>
                                                </label><br>
                                                <label>
                                                        <input type="checkbox" <?php checked($meta_author[$i], '1') ?>">
                                                        <input type="hidden" name="<?php echo $this->get_field_name( 'meta_author' ); ?>[]" value="<?php echo $meta_author[$i] ? 1 : 0 ?>"> 
                                                        <?php _e('Author', 'warta') ?>
                                                </label><br>
                                                <label>
                                                        <input type="checkbox" <?php checked($meta_comments[$i], '1') ?>">
                                                        <input type="hidden" name="<?php echo $this->get_field_name( 'meta_comments' ); ?>[]" value="<?php echo $meta_comments[$i] ? 1 : 0 ?>"> 
                                                        <?php _e('Comments count', 'warta') ?>
                                                </label><br>
                                                <label>
                                                        <input type="checkbox" <?php checked($meta_views[$i], '1') ?>">
                                                        <input type="hidden" name="<?php echo $this->get_field_name( 'meta_views' ); ?>[]" value="<?php echo $meta_views[$i] ? 1 : 0 ?>"> 
                                                        <?php _e('Views count', 'warta') ?>
                                                </label><br>
                                                <label>
                                                        <input type="checkbox" <?php checked($meta_review_score[$i], '1') ?>">
                                                        <input type="hidden" name="<?php echo $this->get_field_name( 'meta_review_score' ); ?>[]" value="<?php echo $meta_review_score[$i] ? 1 : 0 ?>"> 
                                                        <?php _e('Review score', 'warta') ?>
                                                </label>
                                        </p>

                                        <!--Delete Tab
                                        ============== -->
                                        <br>
                                        <button  type="button" class="fsmh-tab-remove button button-small">Delete tab</button>
                                </div><!--.warta-tab-->  
<?php                   endfor; ?>

                        <!--Add Tab
                        =========== -->
                        <button type="button" class="fsmh-tab-add button button-small">Add tab</button>
                        <br>            
                        <br>            

                        <!--Hide on mobile devices
                        ========================== -->
                        <p>
                                <label>
                                        <input type="checkbox" value="1" <?php checked( $hide_mobile, 1) ?>> 
                                        <input type="hidden" name="<?php echo $this->get_field_name( 'hide_mobile' ); ?>" value="<?php echo $hide_mobile ? 1 : 0 ?>"> 
                                        <?php _e('Hide on mobile devices', 'warta') ?>
                                </label><br>
                                <small><?php _e('Recommended for better performance.', 'warta') ?></small>
                        </p>
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
                extract($new_instance);
                $instance = array();

                for ($i = 0; $i < count($title); $i++) {
                        $instance['title'][$i]              = empty($title[$i]) ? __('New title', 'warta') : sanitize_text_field($title[$i]);
                        $instance['data'][$i]               = sanitize_text_field( $data[$i] );
                        $instance['category'][$i]           = sanitize_text_field( $category[$i] );
                        $instance['tags'][$i]               = sanitize_text_field( $tags[$i] );
                        $instance['gallery_post'][$i]       = (int) $gallery_post[$i];
                        $instance['caption_length'][$i]     = (int) $caption_length[$i];
                        $instance['sort'][$i]               = sanitize_text_field( $sort[$i] );
                        $instance['time_range'][$i]         = sanitize_text_field( $time_range[$i] );
                        $instance['post_ids'][$i]           = sanitize_text_field( $post_ids[$i] );
                        $instance['top_review'][$i]         = (int) $top_review[$i];
                        $instance['count'][$i]              = (int) $count[$i];
                        $instance['date_format'][$i]        = sanitize_text_field( $date_format[$i] );
                        $instance['ignore_sticky'][$i]      = (int) $ignore_sticky[$i];
                        $instance['meta_date'][$i]          = (int) $meta_date[$i];
                        $instance['meta_format'][$i]        = (int) $meta_format[$i];
                        $instance['meta_category'][$i]      = (int) $meta_category[$i];
                        $instance['meta_author'][$i]        = (int) $meta_author[$i];
                        $instance['meta_comments'][$i]      = (int) $meta_comments[$i];
                        $instance['meta_views'][$i]         = (int) $meta_views[$i];
                        $instance['meta_review_score'][$i]  = (int) $meta_review_score[$i];
                }

                $instance['hide_mobile'] = (int) $hide_mobile;

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

                switch ( $data[$i] ) {
                        case 'category':
                                $query_args['category_name']  = $category[$i];
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
                                        $query_args['orderby'] = 'meta_value_num';
                                }
                                break;

                        case 'gallery':
                                $query_args['p'] = $gallery_post[$i];
                                break;

                        case 'popular':
                                if( $sort[$i]    === 'comments' ) {    
                                        $query_args['orderby']  = 'comment_count'; 
                                } else {
                                        $query_args['meta_key'] = 'warta_post_views_count';
                                        $query_args['orderby']  = 'meta_value_num';
                                }
                                break;

                        case 'post_ids':
                                $query_args['post__in'] = explode(',', $post_ids[$i]);
                                $query_args['orderby']  = 'post__in';
                                break;
                }

                // Time range
                if( ( $data[$i] == 'review' || $data[$i] == 'popular' ) && $time_range[$i] != 'all' ) {
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
<?php                   for($i = 0; $i < count($title); $i++) : 
                                $title[$i]      = strip_tags($title[$i]);
                                $active         = $i === 0 ? 'active'   : '';
                                $current        = $i === 0 ? 'current'  : ''; 
?>
                                <li class="<?php echo $active ?>"><a href="#<?php echo $tab_id[$i] ?>" data-toggle="tab"><?php echo $title[$i] ?></a></li>
<?php                           if(is_rtl()) : ?>
                                        <li class="control <?php echo $current ?>">
                                                <a href="#<?php echo $tab_id[$i] ?>" data-slide="prev"><span class="fa fa-chevron-left"></span></a>
                                        </li>
                                        <li class="control <?php echo $current ?>">
                                                <a href="#<?php echo $tab_id[$i] ?>" data-slide="next"><span class="fa fa-chevron-right"></span></a>
                                        </li>
<?php                           else : ?>
                                        <li class="control <?php echo $current ?>">
                                                <a href="#<?php echo $tab_id[$i] ?>" data-slide="next"><span class="fa fa-chevron-right"></span></a>
                                        </li>
                                        <li class="control <?php echo $current ?>">
                                                <a href="#<?php echo $tab_id[$i] ?>" data-slide="prev"><span class="fa fa-chevron-left"></span></a>
                                        </li>
<?php                           endif; 
                        endfor; ?>
                </ul>
<?php
        } 
        
        protected function display_gallery($i) {
                extract($this->current_form_data);
                
                $matches_gallery        = warta_match_gallery();
                $attachments            = get_posts( array(
                                                'include'               => implode(',', $matches_gallery['image_ids']), 
                                                'post_status'           => 'inherit', 
                                                'post_type'             => 'attachment', 
                                                'post_mime_type'        => 'image',
                                        ) );

                if ( $attachments ) {
                        foreach ( $attachments as $attachment ) {  
                                $caption                = wptexturize($attachment->post_excerpt);
                                $caption_excerpt        = !!$caption
                                                        ? '<span>' . warta_the_excerpt_max_charlength($caption_length[$i], $caption) . '</span>'
                                                        : '';
                                $attachment_huge        = wp_get_attachment_image_src($attachment->ID, 'huge');
                                $attachment_gallery     = wp_get_attachment_image_src($attachment->ID, 'gallery');
?>
                                <li>
                                        <a href                         ="<?php echo esc_url($attachment_huge[0]) ?>" 
                                           title                        ="<?php echo $caption ?>" 
                                           data-lightbox-gallery        ="<?php echo $tab_id[$i] ?>"
                                        >
<?php                                           if( $hide_mobile) : ?>
                                                        <div data-src="<?php echo esc_url( $attachment_gallery[0] ) ?>" data-alt="<?php echo $caption ?>"></div>
<?php                                           else : ?>
                                                        <img src="<?php echo esc_url( $attachment_gallery[0] ) ?>" alt="<?php echo $caption ?>">
<?php                                           endif; ?>
                                                        
                                                <div class="image-caption"><?php echo $caption_excerpt ?></div>
                                                <span class="image-light"></span>
                                        </a>
                                </li>
<?php
                        }
                }
        }
        
        protected function display_article($i) {
                extract($this->current_form_data);
                $format = get_post_format() ? get_post_format() : 'standard';
?>
                <li class="article-small">
<?php                   if(has_post_thumbnail()) :
                                $attachment_sm  = wp_get_attachment_image_src( get_post_thumbnail_id(), 'small');
?>
                                <a href="<?php the_permalink() ?>" class="image">
<?php                                   if($hide_mobile) : ?>
                                                <div data-src="<?php echo esc_url($attachment_sm[0]) ?>" data-alt="<?php the_title() ?>"></div>
<?php                                   else : ?>
                                                <img src="<?php echo esc_url( $attachment_sm[0] ) ?>" alt="<?php the_title() ?>">                                                
<?php                                   endif; ?>
                                        <div class="image-light"></div>
                                        <div class="link">
                                                <span class="dashicons dashicons-format-<?php echo $format ?>"></span>
                                        </div>
                                </a>
<?php                   else : ?>
                                <div class="image">
                                        <div class="format-placeholder dashicons dashicons-format-<?php echo $format ?>"></div>
                                        <div class="image-light"></div>
                                </div>
<?php                   endif; ?>

                        <a href="<?php the_permalink() ?>"><h5><?php the_title() ?></h5></a>
<?php                   echo warta_posted_on( array(
                                'meta_date'             => $meta_date[$i],
                                'date_format'           => $date_format[$i],
                                'meta_format'           => $meta_format[$i],
                                'meta_comments'         => $meta_comments[$i],
                                'meta_views'            => $meta_views[$i],
                                'meta_category'         => $meta_category[$i],
                                'meta_author'           => $meta_author[$i],
                                'meta_review_score'     => $meta_review_score[$i],
                        ) ); 
?>
                </li>
<?php
        }
        
        protected function display_tab_content() {                
                extract($this->current_form_data);
?>
                <div class="tab-content">
<?php                   for($i = 0; $i < count($title); $i++) :
                                $active         = $i === 0 ? 'active' : '';
                                $in             = $i === 0 ? 'in' : '';
                                $gallery_class  = $data[$i] === 'gallery' ? 'da-thumbs' : '';
                                $article_class  = $data[$i] !== 'gallery' ? 'article' : '';

                                $the_query      = new WP_Query( $this->get_query_args($i) );
?>                            
                                <div class="tab-pane fade <?php echo "$active $in"; ?>" id="<?php echo $tab_id[$i] ?>">
                                        <div class="slider-container <?php echo $article_class ?>">
                                                <ul class="<?php echo $gallery_class ?>">
<?php                                                   if ( $the_query->have_posts() ) {
                                                                while ( $the_query->have_posts() ) { 
                                                                        $the_query->the_post();                                                                         

                                                                        if( $data[$i] === 'gallery' && get_post_gallery() ) {  
                                                                                $this->display_gallery($i);
                                                                        } else {          
                                                                                $this->display_article($i);
                                                                        }
                                                                }
                                                        } 
?>
                                                </ul>
                                        </div>
                                </div>
<?php                   endfor; ?> 
                </div>
<?php           wp_reset_postdata();
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
                global $friskamax_warta;

                $this->current_form_data = $this->set_category_slug($instance);                     
                $this->set_tab_ids($args['widget_id']);

                extract($instance);

                if( isset($args['is_pb']) ) {
                        $widget_class = 'widget';
                } else if( warta_is_sidebar( $args['id'] ) ) {
                        $widget_class = 'widget col-sm-6 col-md-12';
                } else if( warta_is_footer( $args['id'] ) ) {
                        $widget_class = $friskamax_warta['footer_layout'] == 1 ? 'col-md-2 col-sm-4' : 'col-md-3 col-sm-6';
                } else {
                        $widget_class = 'widget col-sm-12';
                }
?>
                <section id="slider-tabs-<?php echo rand() ?>" class="<?php echo($hide_mobile) ? 'no-mobile' : '' ?> slider-tabs <?php echo $widget_class ?>">
<?php                   $this->display_tab_menu(); 
                        $this->display_tab_content(); ?>
                </section>

<?php
        }

} 
endif; // Warta_Slider_Tabs