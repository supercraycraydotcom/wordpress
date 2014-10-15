<?php 
/**
 * TinyMCE modal content: tabs shortcode.
 *
 * @package Warta
 */

ob_start();
?>

<div class="fsmh-container">
        <div class="fsmh-tab">
                <p>
                        <label><?php _e('Title', 'warta') ?>
                                <input type="text" class="title widefat" required>
                        </label>
                </p>
                <p>
                        <label><?php _e('Content', 'warta') ?>
                                <textarea class="content widefat" rows="8"></textarea>
                        </label>
                </p>
                <button type="button" class="fsmh-tab-remove button button-small"><?php _e('Delete tab', 'warta') ?></button>
        </div>
        <button type="button" class="fsmh-tab-add button button-small"><?php _e('Add tab', 'warta') ?></button>
</div>

<script>
    
        jQuery(function($) { 'use strict';
                var $modal = $('#warta-modal-shortcode-tabs');
                $modal.on('submit.fsmh.modal', function() {
                        var     $this           = $(this),
                                contents        = $this.find('.content'),
                                head            = '',
                                body            = '';

                        $this.find('.title').each(function( i ) {
                                var title   = $(this).val(),
                                    active  = '';

                                if( i === 0 ) {
                                        active = ' active="true"';
                                }

                                head += '[tab_title' + active + ']' + title + '[/tab_title]';
                                body += '[tab_content for="' + title + '"' + active + ']' + contents.eq(i).val() + '[/tab_content]';
                        });

                        tinyMCE.activeEditor.insertContent('[tabs][tab_head]' + head + '[/tab_head][tab_body]' + body + '[/tab_body][/tabs]');  
                        $modal.fsmhBsModal('hide');
                }).on('show.bs.modal', function() {
                        $(this).find('.fsmh-tab+.fsmh-tab').remove();
                        $(this).find(':input').val('');
                }).on('add.fsmh.tab', '.fsmh-tab', function() {
                        $(this).find(':input').val('');
                });
        });

</script>

<?php
FriskaMax_Helper::modal(array(
        'id'            => 'warta-modal-shortcode-tabs',
        'title'         => __('Tabs', 'warta'),
        'content'       => ob_get_clean(),
));