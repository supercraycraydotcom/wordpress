<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till before </header>
 *
 * @package Warta
 */

// Warta Theme global variables
global  $friskamax_warta,
        $friskamax_warta_var;

?><!DOCTYPE html>
<html
    <?php   language_attributes();
    echo isset( $friskamax_warta_var['html_id'] ) ? " id='{$friskamax_warta_var['html_id']}' " : ''; ?>
    class="<?php warta_html_class() ?>"
    >
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53eaeb1319248feb"></script>
    <script type="text/javascript">
        window ._taboola = window._taboola || [];
        _taboola.push({article:'auto'});
        !function (e, f, u) {
            e.async = 1;
            e.src = u;
            f.parentNode.insertBefore(e, f);
        }(document.createElement('script'), document.getElementsByTagName('script')[0], 'http://cdn.taboola.com/libtrc/supercraycray/loader.js');
    </script>

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'before' ); ?>
<header>
    <!-- TOP NAVBAR
    =============== -->
    <?php           if( isset( $friskamax_warta['top_menu'] ) && !!$friskamax_warta['top_menu'] ): ?>
        <nav class="navbar navbar-inverse <?php if( $friskamax_warta['top_menu_hide_mobile'] ) echo 'hidden-xs hidden-sm' ?>" id="top-nav" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <a class="sr-only" href="#content"><?php _e( 'Skip to content', 'warta' ); ?></a>
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#top-nav-collapse">
                        <span class="sr-only"><?php _e( 'Menu', 'warta' ) ?></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="top-nav-collapse">
                    <?php                                   wp_nav_menu( array(
//                                                'menu'              => 'top',
                        'theme_location'    => 'top',
                        'depth'             => 2,
                        'container'         => false,
                        'menu_class'        => 'nav navbar-nav',
                        'fallback_cb'       => 'Warta_Bootstrap_Navwalker::fallback',
                        'walker'            => new Warta_Bootstrap_Navwalker()
                    ) );

                    // Search form
                    if( !!$friskamax_warta['top_menu_search_form'] ): ?>
                        <form class="navbar-form navbar-right" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
                            <?php                                                   if( is_rtl() ) : ?>
                                <button type="submit" >
                                    <span class="fa fa-search"></span>
                                    <span class="sr-only"><?php echo esc_attr( _x( 'Search', 'submit button', 'warta' ) ); ?></span>
                                </button>
                                <label class="sr-only" for="top_search_form"><?php _ex( 'Search for:', 'label', 'warta' ); ?></label>
                                <input id="top_search_form"
                                       name="s"
                                       type="search"
                                       placeholder="<?php echo esc_attr( _x( 'Search&hellip;', 'placeholder', 'warta' ) ); ?>"
                                       value="<?php echo esc_attr( get_search_query() ); ?>">
                            <?php                                                   else :  ?>
                                <label class="sr-only" for="top_search_form"><?php _ex( 'Search for:', 'label', 'warta' ); ?></label>
                                <input id="top_search_form"
                                       name="s"
                                       type="search"
                                       placeholder="<?php echo esc_attr( _x( 'Search&hellip;', 'placeholder', 'warta' ) ); ?>"
                                       value="<?php echo esc_attr( get_search_query() ); ?>">
                                <button type="submit" >
                                    <span class="fa fa-search"></span>
                                    <span class="sr-only"><?php echo esc_attr( _x( 'Search', 'submit button', 'warta' ) ); ?></span>
                                </button>
                            <?php                                                   endif ?>
                        </form>
                    <?php                                   endif; ?>

                    <!--Addon menu-->
                    <ul class="nav navbar-nav navbar-right">
                        <?php                                           // Social media icons
                        if( !!$friskamax_warta['top_menu_social_media'] ) {
                            warta_social_media( $friskamax_warta, 'sc-sm sc-dark');
                        }

                        // WooCommerce cart
                        if( !!$friskamax_warta['top_menu_wc_cart'] ) {
                            warta_menu_cart();
                        }  ?>
                    </ul>


                </div><!-- .navbar-collapse -->
            </div><!--.container-->
        </nav><!--#top-nav-->
    <?php endif ?>

    <!-- MAIN NAVIBAR
    ================= -->
    <nav class="navbar navbar-default" id="main-nav" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="sr-only" href="#content"><?php _e( 'Skip to content', 'warta' ); ?></a>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-nav-collapse">
                    <span class="sr-only"><?php _e( 'Menu', 'warta' ) ?></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php                                   warta_logo() ?>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="main-nav-collapse">
                <?php wp_nav_menu( array(
//                                            'menu'              => 'main',
                    'theme_location'    => 'main',
                    'depth'             => 2,
                    'container'         => false,
                    'menu_class'        => 'nav navbar-nav navbar-right',
                    'fallback_cb'       => 'Warta_Bootstrap_Navwalker::fallback',
                    'walker'            => new Warta_Bootstrap_Navwalker()
                ) ); ?>
            </div><!-- .navbar-collapse -->
        </div><!--.container-->
    </nav><!--#main-nav-->