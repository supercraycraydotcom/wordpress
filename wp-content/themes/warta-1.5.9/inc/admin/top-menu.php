<?php
/**
 * Top Menu Settings.
 *
 * @package Warta
 */

$top_menu_fields = array(
    array(
        'id'                    => 'top_menu',
        'type'                  => 'switch', 
        'title'                 => __('Display Top Menu', 'warta'),
         'validate_callback'    => 'warta_validate_integer',
        'default'               => 1
    ),
    array(
        'id'       => 'top_menu_search_form',
        'type'     => 'switch', 
        'title'    => __('Display Search Form', 'warta'),
         'validate_callback' => 'warta_validate_integer',
        'default'  => 1,
        'required'  => array( 'top_menu', '=', 1 )
    ),
    array(
        'id'       => 'top_menu_social_media',
        'type'     => 'switch', 
        'title'    => __('Display Social Media', 'warta'),
         'validate_callback' => 'warta_validate_integer',
        'default'  => 1,
        'required'  => array( 'top_menu', '=', 1 )
    ),
    array(
        'id'                    => 'top_menu_wc_cart',
        'type'                  => 'switch', 
        'title'                 => __('Display WooCommerce Cart', 'warta'),
        'validate_callback'     => 'warta_validate_integer',
        'default'               => 1,
        'required'              => array( 'top_menu', '=', 1 )
    ),
    array(
        'id'       => 'top_menu_hide_mobile',
        'type'     => 'switch', 
        'title'    => __('Hide on Mobile Devices', 'warta'),
         'validate_callback' => 'warta_validate_integer',
        'default'  => 0,
        'required'  => array( 'top_menu', '=', 1 )
    ),
);

foreach ($friskamax_warta_var['social_media'] as $key => $value) {
    $top_menu_fields[] = array(
        'id'       => $key,
        'type'     => 'text',
        'title'    => $value,
        'subtitle' => $value . ' URL',
        'validate' => 'url',
        'required'  => array( 'top_menu', '=', 1 )
    );
}

$this->sections[] = array(
    'title'     => __('Top Menu', 'warta'),
    'desc'      => __('Top menu navigation settings', 'warta'),
    'icon'      => 'el-icon-website',
    'fields'    => $top_menu_fields
);