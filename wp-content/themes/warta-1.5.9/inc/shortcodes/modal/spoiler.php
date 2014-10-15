<?php 
/**
 * TinyMCE modal content: button shortcode.
 *
 * @package Warta
 */

ob_start();
?>

<div class="fsmh-container">
        <p>
                <label><?php _e('Button', 'warta') ?>
                        <select data-name="button" class="widefat">
                                <option value="default"><?php _e('Default button', 'warta') ?></option>
                                <option value="primary"><?php _e('Primary button', 'warta') ?></option>
                                <option value="success"><?php _e('Success button', 'warta') ?></option>
                                <option value="info"><?php _e('Info button', 'warta') ?></option>
                                <option value="warning"><?php _e('Warning button', 'warta') ?></option>
                                <option value="danger"><?php _e('Danger button', 'warta') ?></option>
                        </select>
                </label>
        </p>
        <p>
                <label><?php _e('Spoiler type', 'warta') ?>
                        <select data-name="type" class="widefat">
                                <option value="inline"><?php _e('Inline', 'warta') ?></option>
                                <option value="block" selected><?php _e('Block', 'warta') ?></option>
                        </select>
                </label>
        </p>
        <p>
                <label><?php _e('Show text', 'warta') ?>
                        <input type="text" data-name="show_text" class="widefat" value="<?php _e('Show', 'warta') ?>">
                </label>
        </p>
        <p data-requires='[{ "field":"[data-name=type]", "compare":"equal", "value":"block" }]'>
                <label><?php _e('Hide text', 'warta') ?>
                        <input type="text" data-name="hide_text" class="widefat" value="<?php _e('Hide', 'warta') ?>">
                </label>
        </p>
        <p data-requires='[{ "field":"[data-name=type]", "compare":"equal", "value":"block" }]'>
                <label><?php _e('Button type', 'warta') ?>
                        <select data-name="button_type" class="widefat">
                                <option value="inline"><?php _e('Inline', 'warta') ?></option>
                                <option value="block"><?php _e('Block', 'warta') ?></option>
                        </select>
                </label>
        </p>
        
</div>

<script>    
jQuery(function($) { 'use strict';        
        var $modal = $('#warta-modal-shortcode-spoiler');
        $modal.on('submit.fsmh.modal', function() {
                var     $this           = $(this),
                        button          = $this.find('[data-name="button"]').val(),
                        type            = $this.find('[data-name="type"]').val(),
                        showText        = $this.find('[data-name="show_text"]').val(),
                        hideText        = $this.find('[data-name="hide_text"]').val(),
                        hideText        = type === 'block' ? ' hide_text="' + hideText + '"' : '',
                        buttonType      = $this.find('[data-name="button_type"]').val(),
                        buttonType      = type === 'block' ? ' button_type="' + buttonType + '"' : '',
                        content         = tinyMCE.activeEditor.selection.getContent().replace( /(^(?:<p>|)\[spoiler.*?\])(.*?)(\[\/spoiler\](?:<\/p>|)$)/gi, '$2' ),
                        output          = '[spoiler button="' + button + '" show_text="' + showText + '"' + hideText + ' type="' + type + '"' + buttonType + ']' + content + '[/spoiler]';
                
                tinyMCE.activeEditor.insertContent(output);
                $modal.fsmhBsModal('hide');
        });  
});
</script>

<?php
FriskaMax_Helper::modal(array(
        'id'            => 'warta-modal-shortcode-spoiler',
        'title'         => __('Spoiler', 'warta'),
        'content'       => ob_get_clean(),
));