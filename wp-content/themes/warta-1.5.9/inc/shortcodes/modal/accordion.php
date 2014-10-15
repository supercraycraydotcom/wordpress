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
                <p>
                        <label>
                                <input type="checkbox" class="active">
<?php                           _e('Show the content in first load', 'warta') ?>
                        </label>
                </p>
                <button type="button" class="fsmh-tab-remove button button-small"><?php _e('Delete section', 'warta') ?></button>
        </div>
        <button type="button" class="fsmh-tab-add button button-small"><?php _e('Add section', 'warta') ?></button>
</div>

<script>
    
        jQuery(function($) { 'use strict';
                var $modal = $('#warta-modal-shortcode-accordion');
                $modal.on('submit.fsmh.modal', function() {
                        var     $this           = $(this),
                                contents        = $this.find('.content'),
                                actives         = $this.find('.active'),
                                output          = '[accordion]';

                        $this.find('.title').each(function( i ) {   
                                var active = !!actives.eq(i).is(':checked') ? ' active="true"' : '';
                                output += '[accordion_section title="' + $(this).val() + '"' + active + ']' + contents.eq(i).val() + '[/accordion_section]';                
                        });

                        output += '[/accordion]';

                        tinyMCE.activeEditor.insertContent(output);  
                        $modal.fsmhBsModal('hide');
                }).on('show.bs.modal', function() {
                        var $this = $(this);
                        
                        $this.find('.fsmh-tab+.fsmh-tab').remove();
                        $this.find(':input').val('');
                        $this.find('[type=checkbox]').prop('checked', false);
                }).on('add.fsmh.tab', '.fsmh-tab', function() {
                        var $this = $(this);
                        
                        $this.find(':input').val('');
                        $this.find('[type=checkbox]').prop('checked', false);
                });
        });

</script>

<?php
FriskaMax_Helper::modal(array(
        'id'            => 'warta-modal-shortcode-accordion',
        'title'         => __('Accordion', 'warta'),
        'content'       => ob_get_clean(),
));