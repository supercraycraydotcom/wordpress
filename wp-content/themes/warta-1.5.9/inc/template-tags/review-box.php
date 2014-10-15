<?php
/**
 * Display review box
 * 
 * @package Warta
 */


if( !class_exists('Warta_Review_Box') ) :
class Warta_Review_Box {        
        protected       $read_only      = '',
                        $vote_value     = '';
        
        function __construct() {
                global $friskamax_warta;
                
                $this->op = wp_parse_args( $friskamax_warta, array(
                        'review_box_position'           => 'top',
                        'review_box_enable_categories'  => 0,
                        'review_box_enable_user_rating' => 0,
                        'review_box_score_text'         => __('Bad, Poor, Average, Good, Super', 'warta'),
                        'review_box_title'              => __('Review Scores', 'warta'),
                        'review_box_score_type'         => 'bar'
                ) );                
                
                $this->post_id                  = get_the_ID();
                $this->titles                   = (array)       get_post_meta( $this->post_id, 'friskamax_review_titles', true );
                $this->scores                   =               get_post_meta( $this->post_id, 'friskamax_review_scores', true );
                $this->total                    = (float)       get_post_meta( $this->post_id, 'friskamax_review_total', true );
                $this->summary                  =               get_post_meta( $this->post_id, 'friskamax_review_summary', true );
                $this->user_rating              = (array)       get_post_meta( $this->post_id, 'friskamax_review_user_rating', true );

                $this->score_texts              = explode( ',', $this->op['review_box_score_text'] ); 

                $this->user_rating['value']     = isset( $this->user_rating['value'] ) ? $this->user_rating['value'] : 0;

                if( $this->has_voted() ) {
                        $this->vote_value       = isset( $_COOKIE['friskamax_review_user_rating'][ $this->post_id ] )
                                                ? (float) $_COOKIE['friskamax_review_user_rating'][ $this->post_id ]
                                                : (float) $_SESSION['friskamax_review_user_rating'][ $this->post_id ];
                        $this->read_only        = 'data-rateit-readonly="true"';
                }
                
                $this->advanced_options();
        }
        
        protected function advanced_options() {
                if( !! get_post_meta( $this->post_id, 'friskamax_review_advanced', true ) ) {
                        $this->title                    = strip_tags( get_post_meta( $this->post_id, 'friskamax_review_title', true ) );
                        $this->type                     = get_post_meta( $this->post_id, 'friskamax_review_type', true );
                        $this->position                 = get_post_meta( $this->post_id, 'friskamax_review_position', true );
                        $this->score_text               = strip_tags( get_post_meta( $this->post_id, 'friskamax_review_score_text', true ) );
                        $this->enable_categories        = get_post_meta( $this->post_id, 'friskamax_review_enable_categories', true );
                        $this->enable_user_rating       = get_post_meta( $this->post_id, 'friskamax_review_enable_user_rating', true );
                        $this->enable_categories        = $this->enable_categories != '' ? $this->enable_categories : 1;
                        $this->enable_user_rating       = $this->enable_user_rating != '' ? $this->enable_user_rating : 1;
                } else {
                        $this->title                    = strip_tags( $this->op['review_box_title'] );
                        $this->type                     = $this->op['review_box_score_type'];
                        $this->position                 = $this->op['review_box_position'];
                        
                        $score_index                    = $this->total != 0 ? ceil( $this->total ) - 1 : 0;
                        $this->score_text                = trim( strip_tags( $this->score_texts[ $score_index ] ) );
                        
                        $this->enable_categories        = $this->op['review_box_enable_categories'];
                        $this->enable_user_rating       = $this->op['review_box_enable_user_rating'];
                }
        }
        
        /**
         * Check if current post has a review box
         * @return boolean
         */
        function is_review() {
                return !!get_post_meta( get_the_ID(), 'friskamax_review_total', true );
        }
        
        /**
         * Get review box position
         * @return string
         */
        function position() {
                return  $this->is_review()
                        ? $this->position
                        : '';
        }
        
        /**
         * Check if current review box template is full width
         * @return boolean
         */
        function is_full_width() {
                return $this->position() == 'bottom';
        }
        
        /**
         * Checks if the user has already voted
         * @return boolean
         */
        function has_voted() {
                return  isset( $_COOKIE['friskamax_review_user_rating'][ $this->post_id ] ) 
                        || isset( $_SESSION['friskamax_review_user_rating'][ $this->post_id ] );
        }
        
        /**
         * Get first column contents
         * @return string
         */
        protected function col_1() {
                ob_start(); 
                        foreach ( $this->titles as $key => $value ) :
                                $score = (float) $this->scores[$key]; 

                                echo strip_tags($value) . ': ' . $score;    
                                
                                if( $this->type == 'star' ) : // Star Score ?>        
                                        <span data-rateit-value="<?php echo $score ?>" data-rateit-readonly="true" class="rateit <?php echo is_rtl() ? 'pull-left' : 'pull-right' ?>"></span>
                                        <hr>                
<?php                           else : // Bar Score ?>        
                                        <div class="progress progress-striped <?php if( $this->type == 'bar_animated') { echo 'active'; } ?>">
                                            <div class="progress-bar" style="width: <?php echo $score / 5 * 100 ?>%"></div>
                                        </div>        
<?php                           endif; // $this->op['review_box_score_type']
                        endforeach; // scores 
        
                        if( $this->type != 'star' ) {
                                echo '<hr>';
                        }                        
                
                return ob_get_clean(); 
        }
        
        /**
         * Get second column content
         * @return string
         */
        protected function col_2() {
                ob_start(); ?>
                        <div class="review-total-score">
                                <h1 class="rating"><?php echo $this->total ?></h1>
                                <?php echo $this->score_text ?>
                        </div><!--.review-total-score-->

                        <div class="review-summary summary"><?php echo wp_kses_post( $this->summary ) ?></div>
                        <hr>
<?php
                        if( $this->enable_user_rating ) : ?>
                                <div class="user-rating">
<?php
                                        if( $this->user_rating['value'] ) {
                                                echo wp_kses_post( 
                                                        sprintf( 
                                                                $this->op['review_box_user_rating_text'], 
                                                                '<span class="vote-value">' . (float)   $this->user_rating['value'] . '</span>', 
                                                                '<span class="vote-count">' . (int)     $this->user_rating['count'] . '</span>'
                                                        ) );
                                        } else {
                                                echo wp_kses_post( $this->op['review_box_user_rating_not_rated'] );
                                        }
?> 
                                        <span <?php echo $this->read_only ?> data-rateit-value="<?php echo (float) $this->user_rating['value'] ?>" class="rateit <?php echo is_rtl() ? 'pull-left' : 'pull-right' ?>" data-id="<?php echo $this->post_id ?>"></span>
                                        <small class="after-vote"><?php echo wp_kses_post( $this->op['review_box_user_rating_after_vote'] ) ?></small>
<?php 
                                        if( $this->has_voted() ) {
                                                echo '<br><small>' . wp_kses_post( sprintf( $this->op['review_box_user_rating_has_voted'], $this->vote_value )  ) . '</small>';
                                        } // already voted
?>
                                </div><!--.user-rating-->
                                <hr>            
<?php                   endif; // enable_user_rating 

                return ob_get_clean(); 
        }
        
        /**
         * Display the review box
         */
        function display() {  ?>                      
                <section class="widget review no-margin-top hreview <?php if( $this->is_full_width() ) echo 'full-width' ?>">        
<?php                   if( !!$this->title ) {
                                echo '<header><h5><strong>' . $this->title . '</strong></h5></header>'; 
                        } // header
                        
                        if( !$this->enable_categories ) {
                                echo $this->col_2();
                        } else if( $this->is_full_width() ) : ?>
                                <div class="row">
                                        <div class="col-sm-6"><?php echo $this->col_1() ?></div>
                                        <div class="col-sm-6"><?php echo $this->col_2() ?></div>
                                </div>
<?php                   else :
                                echo $this->col_1();                        
                                echo $this->col_2();
                        endif; ?>          
                        
                        <span class="hidden reviewer vcard">
                                <span class="fn"><?php the_author() ?></span>
                                <span class="dtreviewed"><?php the_date() ?></span>
                        </span>
                </section><!--.widget-->
<?php           
        } // review_box()
}
endif; // Warta_Review_Box