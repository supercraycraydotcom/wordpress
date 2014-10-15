<?php
/**
 * The template for displaying search forms in Warta
 *
 * @package Warta
 */
?>
<form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label class="sr-only" for="warta_search-form"><?php _ex( 'Search for:', 'label', 'warta' ); ?></label>
    <input type="search" class="input-light" name="s" id="warta_search-form"
           placeholder="<?php echo esc_attr_x( 'Enter keywords', 'placeholder', 'warta' ); ?>" 
           value="<?php echo esc_attr( get_search_query() ); ?>">
    <input type="submit" class="btn btn-primary" value="<?php echo esc_attr_x( 'Search', 'submit button', 'warta' ); ?>">
</form>