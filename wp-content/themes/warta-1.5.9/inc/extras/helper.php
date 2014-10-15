<?php

if(!class_exists('Warta_Helper')) :
        class Warta_Helper {
                /**
                 * Check if the user has input the twitter api keys
                 * @return boolean
                 */
                public static function isset_twitter_api() {
                        $friskamax_warta = get_option('friskamax_warta');
                        if( !!$friskamax_warta ) {
                                $consumer_key       = trim( $friskamax_warta['twitter_consumer_key'] ); 
                                $consumer_secret    = trim( $friskamax_warta['twitter_consumer_secret'] ); 
                                $access_token       = trim( $friskamax_warta['twitter_access_token'] ); 
                                $access_secret      = trim( $friskamax_warta['twitter_access_token_secret'] );  

                                return !!$consumer_key && !!$consumer_secret && !!$access_token && !!$access_secret;
                        }
                }
                
                public static function get_all_image_sizes_url($id = NULL) {
                        $id = !!$id ? $id : get_post_thumbnail_id();
                        
                        $thumbnail      = wp_get_attachment_image_src( $id, 'thumbnail');
                        $small          = wp_get_attachment_image_src( $id, 'small');   
                        $gallery        = wp_get_attachment_image_src( $id, 'gallery');                     
                        $medium         = wp_get_attachment_image_src( $id, 'medium');
                        $large          = wp_get_attachment_image_src( $id, 'large'); 
                        $huge           = wp_get_attachment_image_src( $id, 'huge');       
                        $full           = wp_get_attachment_image_src( $id, 'full');
                        
                        return array(
                                'thumbnail'      => $thumbnail[0],
                                'small'          => $small[0],   
                                'gallery'        => $gallery[0],                     
                                'medium'         => $medium[0],
                                'large'          => $large[0], 
                                'huge'           => $huge[0],       
                                'full'           => $full[0],
                        );
                                
                }
                
                public static function get_image_sizes_data_attr($id = NULL) {
                        $output = '';
                        foreach (self::get_all_image_sizes_url($id) as $key => $value) {
                                $output .= "data-img-size-$key='$value'" . PHP_EOL;
                        } 
                        return $output;
                }
        }
endif; // Warta_Helper