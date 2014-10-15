<?php
/**
 * Twitter API Keys Settings.
 *
 * @package Warta
 */

$this->sections[] = array(
    'title'     => __('Twitter API Keys', 'warta'),
    'desc'      => __("These keys are required in order to be able to use Twitter Feed Widget. "
                . "I you don't have one, you can get it from <a href='https://dev.twitter.com/apps' target='_blank'>https://dev.twitter.com/apps</a>."),
    'icon'      => 'el-icon-twitter',
    'fields'    => array(
        array(
            'id'       => 'twitter_consumer_key',
            'type'     => 'text',
            'title'    => __('API Key/Consumer Key', 'warta'),
            'validate' => 'no_special_chars',
            'default'  => '', 
        ),
        array(
            'id'       => 'twitter_consumer_secret',
            'type'     => 'text',
            'title'    => __('API Secret/Consumer Secret', 'warta'),
            'validate' => 'no_special_chars',
            'default'  => '',
        ),
        array(
            'id'       => 'twitter_access_token',
            'type'     => 'text',
            'title'    => __('Access Token', 'warta'),
            'validate' => 'no_special_chars',
            'default'  => '',
        ),
        array(
            'id'       => 'twitter_access_token_secret',
            'type'     => 'text',
            'title'    => __('Access Token Secret', 'warta'),
            'validate' => 'no_special_chars',
            'default'  => '',
        ),
    )
);