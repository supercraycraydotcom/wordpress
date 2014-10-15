<?php
/**
 * Translate TinyMCE custom plugins
 * 
 * @package Warta
 */

if( !function_exists('warta_mce_translation') ) :
function warta_mce_translation() {
        
    $array = array(
        'general'   => array (
                        'align'         => __('Alignment', 'warta'),
                        'alignLeft'     => __('Align left', 'warta'),
                        'alignCenter'   => __('Align center', 'warta'),
                        'alignRight'    => __('Align right', 'warta'),
                        'alignJustify'  => __('Justify', 'warta'),
                        'block'         => __('Block', 'warta'),
                        'cancel'        => __('Cancel', 'warta'),
                        'content'       => __('Content', 'warta'),
                        'insert'        => __('Insert', 'warta'),
                        'inline'        => __('Inline', 'warta'),
                        'maxWidth'      => __('Max width', 'warta'),
                        'maxHeight'     => __('Max height', 'warta'),
                        'newWindow'     => _x('New window', 'Link target, open in new window', 'warta'),
                        'reverse'       => __('Reverse', 'warta'),
                        'sameWindow'    => _x('Same window', 'Link target, open in same window', 'warta'),
                        'style'         => __('Display style', 'warta'),
                        'target'        => _x('Target', 'Link target, open link in current tab/new tab', 'warta'),
                        'title'         => __('Title', 'warta'),
                        'type'          => __('Type', 'warta'),
                        'url'           => _x('URL', 'Uniform Resource Locator', 'warta'),
                    ),
        'columns'   => array(
                        'title'     => __('Columns', 'warta'),
                        'numberCol' => __('Number of columns', 'warta'),
                        'col2'      => __('2 columns', 'warta'),
                        'col3'      => __('3 columns', 'warta'),
                        'col4'      => __('4 columns', 'warta'),
                    ),
        'dropcaps'  => array(
                        'title' => __('Dropcaps', 'warta')
                    ),
        'smallFont' => array(
                        'title' => __('Small Font', 'warta')
                    ),
        'button'    => array (
                        'title'     => __('Button', 'warta'),
                        'type'      => __('Button type', 'warta'),
                        'default'   => __('Default button', 'warta'),
                        'primary'   => __('Primary button', 'warta'),
                        'success'   => __('Success button', 'warta'),
                        'info'      => __('Info button', 'warta'),
                        'warning'   => __('Warning button', 'warta'),
                        'danger'    => __('Danger button', 'warta'),
                        'size'      => __('Button Size', 'warta'),
                        'large'     => __('Large button', 'warta'),
                        'small'     => __('Small button', 'warta'),
                        'extraSmall'=> __('Extra Small button', 'warta'),
                    ),
        'label'     => array(
                        'title'     => __('Label', 'warta'),
                        'type'      => __('Label type', 'warta'),
                        'default'   => __('Default label', 'warta'),
                        'primary'   => __('Primary label', 'warta'),
                        'success'   => __('Success label', 'warta'),
                        'info'      => __('Info label', 'warta'),
                        'warning'   => __('Warning label', 'warta'),
                        'danger'    => __('Danger label', 'warta'),
                    ),
        'alert'     => array(
                        'title'     => __('Alert', 'warta'),
                        'type'      => __('Alert type', 'warta'),
                        'success'   => __('Success alert', 'warta'),
                        'info'      => __('Info alert', 'warta'),
                        'warning'   => __('Warning alert', 'warta'),
                        'danger'    => __('Danger alert', 'warta'),
                    ),
        'quote'     => array(
                        'title'         => __('Custom blockquote', 'warta'),
                        'source'        => __('Source title', 'warta'),
                        'sourceURL'     => __('Source URL', 'warta'),
                    ),
        'embed'     => array(
                        'title'     => __('Embed', 'warta'),
                        'sites'     => __('Click here to see all sites that can be embedded.', 'warta')
                    ),
        'icons'     => array(
                        'title'     => __('Font Awesome Icons', 'warta'),
                    ),
        'tabs'      => array(
                        'title'     => __('Tabs', 'warta'),
                        'add'       => __('Add tab', 'warta'),
                        'remove'    => __('Remove tab', 'warta')
                    ),
        'accordion' => array(
                        'title'     => __('Accordion', 'warta'),
                        'remove'    => __('Remove section', 'warta'),
                        'add'       => __('Add section', 'warta')
                    ),
        'carousel'  => array(
                        'title'     => __('Carousel', 'warta'),
                        'create'    => __('Create Carousel', 'warta')
                    ),
        'spoiler'   => array(
                        'title'         => __('Spoiler', 'warta'),
                        'hideText'      => __('Hide text', 'warta'),
                        'showText'      => __('Show text', 'warta'),
                        'type'          => __('Spoiler type', 'warta'),
                        'buttonType'    => __('Button type', 'warta'),
                    ),
        'divider'   => array(
                        'title'     => __('Divider Line', 'warta')
                    ),
        'nextPage'  => array(
                        'title'     => __('Page Break', 'warta')
                    )
    );
    
    $locale     = _WP_Editors::$mce_locale;    
    $translated = '';
        
    foreach ( $array as $key => $value ) {        
        $translated .= 'tinyMCE.addI18n( "' . $locale . '.warta' . ucfirst($key) . '", ' . json_encode( $value ) . ' );';
    }
    
    return $translated;
}
endif; // warta_mce_translation

$strings = warta_mce_translation();

