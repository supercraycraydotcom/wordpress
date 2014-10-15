<?php
/**
 * Review Box Settings.
 *
 * @package Warta
 */

$this->sections[] = array(
    'title'     => __('Review Box', 'warta'),
    'icon'      => 'el-icon-edit',
    'fields'    => array(
        array(
            'id'       => 'review_box_title',
            'type'     => 'text',
            'title'    => __('Title', 'warta'),
            'validate' => 'no_html',
            'default'  => __('Review Scores', 'warta'),
        ),
        array(
            'id'       => 'review_box_enable_categories',
            'type'     => 'switch', 
            'title'    => __('Enable score categories', 'warta'),
            'default'  => 1,
            'validate_callback' => 'warta_validate_integer',
        ),
        array(
            'id'       => 'review_box_score_type',
            'type'     => 'radio',
            'title'    => __('Score Type', 'warta'), 
            'options'  => array(
                'bar'           => _x('Bar', 'Review score type', 'warta'), 
                'bar_animated'  => _x('Bar animated', 'Review score type', 'warta'), 
                'star'          => _x('Star', 'Review score type', 'warta'),
            ),
            'default' => 'bar',
            'required'=> array('review_box_enable_category', '=', 1)
        ),
        array(
            'id'       => 'review_box_position',
            'type'     => 'radio',
            'title'    => __('Position', 'warta'), 
            'options'  => array(
                'top'           => __('Top', 'warta'), 
                'bottom'        => __('Bottom', 'warta'), 
            ),
            'default' => 'top'
        ),
        array(
            'id'       => 'review_box_score_text',
            'type'     => 'text',
            'title'    => __('Score Text', 'warta'),
            'subtitle' => __('Separated by commas, from 1 to 5.', 'warta'),
            'validate' => 'no_html',
            'default'  => __('Bad, Poor, Average, Good, Super', 'warta'),
        ),
        array(
            'id'       => 'review_box_enable_user_rating',
            'type'     => 'switch', 
            'title'    => __('Enable user rating', 'warta'),
            'default'  => 1,
             'validate_callback' => 'warta_validate_integer'
        ),
        array(
            'id'       => 'review_box_user_rating_text',
            'type'     => 'text',
            'title'    => __('User Rating Text', 'warta'),
            'validate' => 'html',
            'default'  => __('User Rating: %1$s (%2$s votes)', 'warta'),
            'desc'     => __( 'The %1$s is the total user rating, and the %2$s is the number of total voters.', 'warta' ),
            'required' => array( 'review_box_enable_user_rating', '=', 1 )
        ),
        array(
            'id'       => 'review_box_user_rating_not_rated',
            'type'     => 'text',
            'title'    => __('User Rating: Not Rated Text', 'warta'),
            'validate' => 'html',
            'default'  => __('User rating: not rated yet, be the first!', 'warta'),
            'required' => array( 'review_box_enable_user_rating', '=', 1 )
        ),
        array(
            'id'       => 'review_box_user_rating_after_vote',
            'type'     => 'text',
            'title'    => __('User Rating: After Vote Text', 'warta'),
            'validate' => 'html',
            'default'  => __('Thank you. Your vote has been saved.', 'warta'),
            'required' => array( 'review_box_enable_user_rating', '=', 1 )
        ),
        array(
            'id'       => 'review_box_user_rating_has_voted',
            'type'     => 'text',
            'title'    => __('Text for those who have voted', 'warta'),
            'validate' => 'html',
            'default'  => __('You have voted: %s.', 'warta'),
            'desc'     => __('%s is the number he/she voted.', 'warta'),
            'required' => array( 'review_box_enable_user_rating', '=', 1 )
        ),
    )
);