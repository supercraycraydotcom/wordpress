<?php

$this->sections[] = array(  
        'icon' => 'el-icon-font',
        'title' => __('Typography', 'warta'),
        'fields' => array(
                array(
                        'id'       => 'typography_google_api_key',
                        'type'     => 'text',
                        'title'    => __('Google API Key', 'warta'),
                        'subtitle' => __('You will need a Google API key if you want to use Google Fonts. '
                                        . 'Click <a href="https://developers.google.com/fonts/docs/developer_api#Auth" target="_blank">'
                                        . 'here</a> to get the API key.', 'warta'),
                        'validate' => 'no_special_chars',
                        'default'  => '', 
                ),
                array(
                        'id'            => 'typography_body',
                        'type'          => 'typography',
                        'title'         => __('Body Text', 'warta'),
                        'color'         => FALSE,
                        'font-backup'   => TRUE,
                        'font-size'     => FALSE,
                        'line-height'   => FALSE,
                        'text-transform'=> TRUE,
                        'text-align'    => FALSE,                        
                        'google'        => TRUE,                        
                        'output'        => array(
                                                'body', 
                                                'p', 
                                                'blockquote', 
                                                'dt', 
                                                'dd'
                                        ),
                        'preview'       => array(
                                                'font-size'     => '40px'
                                        ),
                ),
                array(
                        'id'            => 'typography_headings',
                        'type'          => 'typography',
                        'title'         => __('Headings', 'warta'),
                        'color'         => FALSE,
                        'font-backup'   => TRUE,
                        'font-size'     => FALSE,
                        'line-height'   => FALSE,
                        'text-transform'=> TRUE,
                        'text-align'    => FALSE,
                        'google'        => TRUE,
                        'output'        => array(
                                                'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 
                                                '.widget .nav-tabs li a', 
                                                '.author.widget .name', 
                                                '.widget_rss li > a.rsswidget',
                                                '.widget_recent_comments .recentcomments a:last-child',
                                                '.widget_recent_entries a',
                                                
                                                // WooCommerce
                                                '.cart_list li a',
                                                '.product_list_widget li a'
                                        ),
                        'preview'       => array(
                                                'font-size'     => '40px'
                                        ),
                        'default'       => array(
                                                'font-weight'   => '700'
                                        ),
                ),
                array(
                        'id'            => 'typography_widget_header',
                        'type'          => 'typography',
                        'title'         => __('Widget Header', 'warta'),
                        'color'         => FALSE,
                        'font-backup'   => TRUE,
                        'font-size'     => FALSE,
                        'line-height'   => FALSE,
                        'text-transform'=> TRUE,
                        'text-align'    => FALSE,
                        'google'        => TRUE,
                        'output'        => array(
                                                '.widget header h4', 
                                                '.widget .nav-tabs li a', 
                                                '.breaking-news header h4',
                                                '#footer-main .title h4', 
                                                '#footer-main .nav-tabs a'
                                        ),
                        'preview'       => array(
                                                'font-size'     => '40px'
                                        ),
                        'default'       => array(
                                                'font-weight'   => '700'
                                        ),
                ),
                array(
                        'id'            => 'typography_main_menu',
                        'type'          => 'typography',
                        'title'         => __('Menu', 'warta'),
                        'color'         => FALSE,
                        'font-backup'   => TRUE,
                        'font-size'     => FALSE,
                        'line-height'   => FALSE,
                        'text-transform'=> TRUE,
                        'text-align'    => FALSE,
                        'google'        => TRUE,
                        'output'        => array('.navbar'),
                        'preview'       => array(
                                                'font-size'     => '40px'
                                        ),
                ),
                array(
                        'id'            => 'typography_page_title',
                        'type'          => 'typography',
                        'title'         => __('Page Title', 'warta'),
                        'color'         => FALSE,
                        'font-backup'   => TRUE,
                        'font-size'     => FALSE,
                        'line-height'   => FALSE,
                        'text-transform'=> TRUE,
                        'text-align'    => FALSE,
                        'google'        => TRUE,
                        'output'        => array('#title .container .title-container .primary'),                        
                        'preview'       => array(
                                                'font-size'     => '40px'
                                        ),
                        'default'       => array(
                                                'font-weight'   => '700'
                                        ),
                ),
                array(
                        'id'            => 'typography_page_subtitle',
                        'type'          => 'typography',
                        'title'         => __('Page Subtitle', 'warta'),
                        'color'         => FALSE,
                        'font-backup'   => TRUE,
                        'font-size'     => FALSE,
                        'line-height'   => FALSE,
                        'text-transform'=> TRUE,
                        'text-align'    => FALSE,
                        'google'        => TRUE,
                        'output'        => array('#title .container .title-container .secondary'),
                        'preview'       => array(
                                                'font-size'     => '40px'
                                        ),
                ),
                array(
                        'id'            => 'typography_post_meta',
                        'type'          => 'typography',
                        'title'         => __('Post Meta', 'warta'),
                        'color'         => FALSE,
                        'font-backup'   => TRUE,
                        'font-size'     => FALSE,
                        'line-height'   => FALSE,
                        'text-transform'=> TRUE,
                        'text-align'    => FALSE,
                        'google'        => TRUE,
                        'output'        => array(
                                                '.post-meta a', 
                                                '.comment-meta a', 
                                                '.comment-container .reply a',
                                
                                                // WooCommerce
                                                '#reviews #comments ol.commentlist li .meta'
                                        ),
                        'preview'       => array(
                                                'font-size'     => '40px'
                                        ),
                ),
                array(
                        'id'            => 'typography_button',
                        'type'          => 'typography',
                        'title'         => __('Button', 'warta'),
                        'color'         => FALSE,
                        'font-backup'   => TRUE,
                        'font-size'     => FALSE,
                        'line-height'   => FALSE,
                        'text-transform'=> TRUE,
                        'text-align'    => FALSE,
                        'google'        => TRUE,
                        'output'        => array(
                                                'button', 
                                                'input[type=button]', 
                                                'input[type=reset]', 
                                                'input[type=submit]', 
                                                '.btn',
                                
                                                // WooCommerce
                                                '.button', 
                                                '#respond input#submit'
                                        ),                        
                        'preview'       => array(
                                                'font-size'     => '40px'
                                        ),
                        'default'       => array(
                                                'font-weight'   => '700'
                                        ),
                ),
        )
);
