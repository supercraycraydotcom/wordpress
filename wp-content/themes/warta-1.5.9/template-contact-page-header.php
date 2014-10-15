<?php
/**
 * Contact Page Header
 * 
 * @package Warta
 */

$error_name             = false;
$error_email            = false;
$error_website          = false;
$error_message          = false;
$email_sent_error       = false;
$email_sent             = false;

// Initialize the variables
$name       = '';
$email      = '';
$website    = '';
$message    = '';

if (isset($_POST['contact_submit'])) {        
    $name       = stripslashes( trim( $_POST['contact_name'] ) );
    $email      = sanitize_email( trim( $_POST['contact_email'] ) );
    $website    = esc_url( trim($_POST['contact_website']) );
    $message    = stripslashes( trim($_POST['contact_message'] ) );

    if ( !$name )                       $error_name     = true;
    if ( !$email || !is_email($email) ) $error_email    = true;   
    if ( !$message )                    $error_message  = true;
    
    // Check if we have errors
    if (!$error_name && !$error_email && !$error_message ) {
        
        // Get the receiver 
        $receiver_email = sanitize_email( $friskamax_warta['contact_page_receiver_email'] );        

        $subject     = sprintf( __('[%1$s] Message from %2$s', 'warta'), wp_specialchars_decode(get_bloginfo('name'), ENT_QUOTES), $name );
        $body        = sprintf( __("Name: %s", 'warta'), $name ) . PHP_EOL;
        $body       .= sprintf( __("Email: %s", 'warta'), $email ) . PHP_EOL;
        $body       .= sprintf( __("Website: %s", 'warta'), $website ) . PHP_EOL . PHP_EOL;
        $body       .= $message;

        $headers     = "From: \"{$name}\" <{$email}>" . PHP_EOL;
        $headers    .= "Reply-To: {$email}" . PHP_EOL;

        // If all is good, we send the email
        if (wp_mail($receiver_email, $subject, $body, $headers)) {
            $email_sent = true;
            
            $name       = '';
            $email      = '';
            $website    = '';
            $message    = '';
        } else {
            $email_sent_error = true;
        }
    }
}
        
        

global $friskamax_warta, $friskamax_warta_var;                  // Get Warta Theme global variables
$friskamax_warta_var['page']      = 'page';           // set the current page
$friskamax_warta_var['html_id']   = 'contact-page';   // Set html ID

get_header();

if( isset( $friskamax_warta['contact_page_map'] ) && !!$friskamax_warta['contact_page_map'] ) : ?>

    <!-- MAP
    ======== -->
    <div id="map"
         data-lat="<?php echo esc_attr( $friskamax_warta['contact_page_lat'] ) ?>"
         data-long="<?php echo esc_attr( $friskamax_warta['contact_page_long'] ) ?>"
         data-marker="<?php echo esc_attr( $friskamax_warta['contact_page_marker'] ) ?>">
    </div>
    
<?php else : warta_page_title( get_the_title(), '' ); endif; // print page title ?>

</header><!--header-->