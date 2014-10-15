<?php
/**
 * Singular Page Settings.
 *
 * @package Warta
 */

$this->sections[] = array(
    'icon'      => 'el-icon-phone',
    'title'     => __('Contact Page', 'warta'),
    'fields'    => array(   
        array(
            'id'       => 'contact_page_receiver_email',
            'type'     => 'text',
            'title'    => __('Receiver Email Address', 'warta'),
            'validate' => 'email',
            'default'  => get_option('admin_email')
        ),
        array(
            'id'       => 'contact_page_map',
            'type'     => 'switch', 
            'title'    => __('Display Map', 'warta'),
             'validate_callback' => 'warta_validate_integer'
        ),
        array(
            'id'        => 'contact_page_lat',
            'type'      => 'text',
            'title'     => __('Latitude coordinate', 'warta'),
            'subtitle'  => __('Format: Decimal degrees (DDD). Example: -6.1753500.', 'warta'),
            'desc'      => __('You can find the tutorial in <a href="https://support.google.com/maps/answer/18539" target="_blank">Google Support: Latitude and longitude coordinates</a>. ', 'warta'),
            'validate'  => 'no_html',
            'default'   => -6.1753500,
            'required'  => array( 'contact_page_map', '=', 1 )
        ),
        array(
            'id'        => 'contact_page_long',
            'type'      => 'text',
            'title'     => __('Longitude  coordinate', 'warta'),
            'subtitle'  => __('Format: Decimal degrees (DDD). Example: -6.1753500.', 'warta'),
            'desc'      => __('You can find the tutorial in <a href="https://support.google.com/maps/answer/18539" target="_blank">Google Support: Latitude and longitude coordinates</a>.', 'warta'),
            'validate'  => 'no_html',
            'default'   => 106.8271667,
            'required'  => array( 'contact_page_map', '=', 1 )
        ),
        array(
            'id'       => 'contact_page_marker',
            'type'     => 'text',
            'title'    => __('Marker Text', 'warta'),
            'validate' => 'no_html',
            'required'  => array( 'contact_page_map', '=', 1 )
        ),
        array(
            'id'       => 'contact_page_contact_info_title',
            'type'     => 'text',
            'title'    => __('Contact Info Title', 'warta'),
            'validate' => 'no_html',
            'default'  => __('Contact Info', 'warta')
        ),
        array(
            'id'       => 'contact_page_contact_form_title',
            'type'     => 'text',
            'title'    => __('Contact Form Title', 'warta'),
            'validate' => 'no_html',
            'default'  => __('Get in touch', 'warta')
        ),
        array(
            'id'                => 'contact_page_before_form',
            'type'              => 'editor',
            'title'             => __('Text Before Contact Form', 'warta'), 
            'validate'          => 'html',
        ),
    )
);