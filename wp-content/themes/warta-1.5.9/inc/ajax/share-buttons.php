<?php
/**
 * Display share buttons
 * 
 * @package Warta
 */

if( !class_exists('Warta_Share_Buttons') ) :
class Warta_Share_Buttons {
        /**
         * Post's permalink
         * @var string 
         */
        public $url;
        
        /**
         * Share counts
         * @var array
         */
        public $values = array();
        
        /**
         * Share URLs
         * @var array
         */
        public $share_url   = array(
                                    'facebook'      => "https://www.facebook.com/sharer/sharer.php?m2w&u=",
                                    'googleplus'    => "https://plus.google.com/share?url=",
                                    'linkedin'      => "http://www.linkedin.com/shareArticle?mini=true&url=",
                                    'pinterest'     => "javascript:void((function(){var%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)})());",
                                    'stumbleupon'   => "http://www.stumbleupon.com/submit?url=",
                                    'twitter'       => "http://twitter.com/share?url=",
            
                                    'digg'          => "http://www.digg.com/submit?url=",
                                    'mail'          => "mailto:?Subject=",
                                    'tumblr'        => "http://www.tumblr.com/share/link?url=",
                            );
        
        /**
         * API URLs
         * @var array
         */
        public $api_url     = array(
                                    'facebook'      => "https://api.facebook.com/method/links.getStats?format=json&urls=",
                                    'linkedin'      => "http://www.linkedin.com/countserv/count/share?format=json&url=",
                                    'pinterest'     => "http://widgets.pinterest.com/v1/urls/count.json?source=6&url=",
                                    'stumbleupon'   => "http://www.stumbleupon.com/services/1.01/badge.getinfo?url=",
                                    'twitter'       => "http://urls.api.twitter.com/1/urls/count.json?url=",
                            );
        
        /**
         * Get share counts functions
         * @param string $data API response value
         */
        
        protected function facebook( $data ) { 
                $data                       = json_decode( $data );
                $this->values['facebook']   = (int) $data[0]->total_count;
        }        
        protected function googleplus( $data ) { 
                $data                       = json_decode( $data );                    
                $this->values['googleplus'] = (int) $data->result->metadata->globalCounts->count;                 
        }        
        protected function linkedin( $data ) {                                          
                $data                       = json_decode( $data );                    
                $this->values['linkedin']   = (int) $data->count;                 
        }        
        protected function pinterest( $data ) {               
                $data                       = preg_replace('/^receiveCount\((.*)\)$/', "\\1", $data);
                $data                       = json_decode( $data );                    
                $this->values['pinterest']  = (int) $data->count;                 
        }        
        protected function stumbleupon( $data ) {
                $data                           = json_decode( $data );                    
                $this->values['stumbleupon']    = isset( $data->result->views )
                                                ? (int) $data->result->views
                                                : 0;                 
        }   
        protected function twitter( $data ) {
                $data                       = json_decode( $data ); 
                $this->values['twitter']    = (int) $data->count;   
        }

        /**
         * Get share values
         */
        protected function get_values() {         
                foreach ( $this->api_url as $key => $value) {
                        $url = ( is_array($value) && !empty($value['url']) ) ? $value['url'] : $value;                                                
                        
                        if ( is_array($value) && !empty($value['post']) ) // post?
                                $data = wp_remote_post( $url, $value['post']);
                        else 
                                $data = wp_remote_get($url, array( 'timeout' => 60 ));
                        
                        if( !is_wp_error( $data )  )
                                $this->$key( $data['body'] );
                }
        }

        /**
         * Format if has high value
         */
        protected function format_values() {
                foreach ($this->values as $key => $value) {
                        $this->values[$key] = warta_format_counts( $value );
                }
        }
        
        /**
         * Set share urls
         */
        protected function set_urls( $title ) {
                /**
                 * Share urls
                 * -------------------------------------------------------------
                 */
                $additional = array(
                                    'twitter'   => '&text=' . urlencode( $title ),
                            );
                $exception  = array(
                                    'pinterest',
                                    'mail',
                                    'tumblr'
                            );
                foreach ($this->share_url as $key => $value) {
                        if( ! in_array( $key, $exception) )
                                $this->share_url[$key] = $value . esc_url( $this->url ) . ( isset( $additional[$key] ) && !!$additional[$key] ? $additional[$key] : '' );
                }
                $this->share_url['mail']    .= esc_attr( $title ) . "&Body={$this->url}";
                $this->share_url['tumblr']  .= esc_attr( preg_replace('/http:\/\/|https:\/\//i', '', $this->url) ) . "&name=" . urlencode( $title );
                        
                /**
                 * API urls
                 * -------------------------------------------------------------
                 */
                foreach ($this->api_url as $key => $value) {
                        $this->api_url[$key] = $value . esc_url( $this->url );
                }
                // google api url and post value
                $this->api_url['googleplus']    = array(                                                                                
                                                        'url'           => 'https://clients6.google.com/rpc',
                                                        'post'          => array (
                                                                                'method'        => 'POST',
                                                                                'headers'       => array( 'content-type' => 'application/json' ),
                                                                                'sslverify'     => false,
                                                                                'timeout'       => 60,
                                                                                'body'          => json_encode( array( 
                                                                                        'method'    => 'pos.plusones.get',
                                                                                        'id'        => 'p',
                                                                                        'jsonrpc'   => '2.0',
                                                                                        'key'       => 'p',
                                                                                        'apiVersion'=> 'v1',
                                                                                        'params'    => array(
                                                                                                            'nolog'     => true,
                                                                                                            'id'        => $this->url,
                                                                                                            'source'    => 'widget',
                                                                                                            'userId'    => '@viewer',
                                                                                                            'groupId'   => '@self'
                                                                                                    ),
                                                                                ) ) 
                                                                        ),                                                        
                                                );
        }
        
        /**
         * Display the buttons
         * @param array $options Define what to display. ex: array( 'facebook' => 1, 'twitter' => 1 );
         */
        protected function display($options) {
                global $friskamax_warta, $friskamax_warta_var;
                
                if( $friskamax_warta['singular_share_text'] ) {                        
                        echo '<h5>' . $friskamax_warta['singular_share_text'] . '</h5>';
                }
?>
                <ul>                
<?php                   foreach ($this->share_url as $key => $value) :
                                if( isset( $options[$key] ) ) :
?>
                                        <li>
                                                <a href="<?php echo $value ?>" <?php if( preg_match('/^http.+$/i', $value) ) echo 'target="_blank"' ?> title="<?php echo esc_attr( $friskamax_warta_var['social_media_all'][$key] ) ?>">
                                                        <i class="sc-sm sc-<?php echo $key ?>"></i>
                        <?php                           if( isset( $this->values[$key] ) && !!$this->values[$key] ) 
                                                                echo "<span>{$this->values[$key]}</span>" 
                        ?>
                                                </a>
                                        </li>
<?php
                                endif;
                        endforeach; ?>
                </ul>
<?php
        }

        public function __construct( $args ) {               
                $this->url = esc_url( $args['permalink'] );      
                
                $this->set_urls( $args['title'] );
                $this->get_values();   
                $this->format_values();
                $this->display( $args['options'] );
        }
}
endif; // Warta_Share_Buttons



if( !function_exists('warta_share_buttons') ) :    
/**
 * Display share buttons
 * 
 * @global array $friskamax_warta Theme option values
 */
function warta_share_buttons() {
        global $friskamax_warta;          
        
        new Warta_Share_Buttons( array(
                'options'   => $friskamax_warta['singular_share_buttons'],
                'permalink' => $_POST['permalink'],
                'title'     => $_POST['title']
        ) );
        
        die(); // this is required to return a proper result
}    
endif; // warta_share_buttons
add_action( 'wp_ajax_warta_share_buttons', 'warta_share_buttons' );
add_action( 'wp_ajax_nopriv_warta_share_buttons', 'warta_share_buttons' );