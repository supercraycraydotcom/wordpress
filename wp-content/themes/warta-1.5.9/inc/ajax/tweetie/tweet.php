<?php

require_once( dirname(__FILE__) . "/twitteroauth/twitteroauth.php"); // Path to twitteroauth library        
    
if( !function_exists('warta_tweet') ) :
function warta_tweet() {
        global $friskamax_warta;
        
        $consumer_key       = trim( $friskamax_warta['twitter_consumer_key'] ); 
        $consumer_secret    = trim( $friskamax_warta['twitter_consumer_secret'] ); 
        $access_token       = trim( $friskamax_warta['twitter_access_token'] ); 
        $access_secret      = trim( $friskamax_warta['twitter_access_token_secret'] ); 
        
        // Check if keys are in place
        if ( !$consumer_key || !$consumer_secret || !$access_token || !$access_secret ) {
                echo 'You need a consumer key and secret keys. Get one from <a href="https://dev.twitter.com/apps">dev.twitter.com/apps</a>';
                exit();
        }
        
        // If count of tweets is not fall back to default setting
        $username               = $_GET['username'];
        $number                 = $_GET['count'];
        $exclude_replies        = $_GET['exclude_replies'];

        // Connect
        $connection     = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_secret);

        // Get Tweets
        $screenname     = (isset($username)) ? '&screen_name='.$username : '';
        $tweets         = $connection->get('https://api.twitter.com/1.1/statuses/user_timeline.json?count='.$number.$screenname.'&exclude_replies='.$exclude_replies);

        // Return JSON Object
        header('Content-Type: application/json');

        echo json_encode($tweets);
        
        die(); // this is required to return a proper result
}
endif; // warta_tweet
add_action( 'wp_ajax_warta_tweet', 'warta_tweet' );
add_action( 'wp_ajax_nopriv_warta_tweet', 'warta_tweet' );