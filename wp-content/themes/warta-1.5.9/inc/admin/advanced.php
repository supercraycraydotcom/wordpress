<?php
/**
 * Advanced Settings.
 *
 * @package Warta
 */

$this->sections[] = array(
        'icon'  => 'el-icon-wrench',
        'title' => __('Advanced Settings', 'warta'),
        'fields'=> array(
                array(
                           'id'                 =>'tracking_code',
                           'type'               => 'ace_editor',
                           'title'              => __('Tracking Code', 'warta'), 
                           'subtitle'           => __('Paste your Google Analytics (or other) tracking code here.', 'warta'),
                           'theme'              => 'chrome',
                           'validate_callback'  => 'warta_validate_unfiltered_html',
                           'mode'               => 'html',
                           'default'            => '',
                ),

                array(
                        'id'                    => 'css_code',
                        'type'                  => 'ace_editor',
                        'title'                 => __('CSS Code', 'warta'), 
                        'subtitle'              => __('Paste your CSS code here.', 'warta'),
                        'mode'                  => 'css',
                        'theme'                 => 'chrome',
                        'validate_callback'     => 'warta_validate_unfiltered_html',
                        'default'               => '',
                ),
                array(
                        'id'                =>'js_code',
                        'type'              => 'ace_editor',
                        'title'             => __('JS Code', 'warta'), 
                        'subtitle'          => __('Paste your JS code here.', 'warta'),
                        'mode'              => 'javascript',
                        'theme'             => 'chrome',
                        'validate_callback' => 'warta_validate_unfiltered_html',
                        'default'           => '',
                ),
                array(
                        'id'       => 'ajax_post_views',
                        'type'     => 'switch',
                        'title'    => __('Use AJAX on post views counter', 'warta'),
                        'subtitle' => __('Useful when using a cache plugin', 'warta'),
                        'default'  => FALSE,
                ),
        )
);