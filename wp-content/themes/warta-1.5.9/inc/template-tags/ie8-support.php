<?php

if( !function_exists('warta_ie8_support')):
function warta_ie8_support() {
?>      
        <!--[if lt IE 9]>
           <link href="<?php echo get_template_directory_uri() ?>/css/ie8.css" rel="stylesheet">        
           <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
           <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
           <script src="<?php echo get_template_directory_uri() ?>/js/ie8.js"></script>
        <![endif]-->
<?php
}
endif; // warta_ie8_support
add_action('wp_head', 'warta_ie8_support', 666);

