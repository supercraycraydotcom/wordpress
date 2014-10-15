<?php
/**
 * Advertisement Widget
 * 
 * @package Warta
 */

if(!class_exists('Warta_Text_Editor')) :
class Warta_Text_Editor extends WP_Widget {
        
        /**
         * Default options for this widget
         * @var array
         */
        protected $default_form_data = array();

        public function add_wp_editor() {
?>      
                <div class="fsmh-container">
                        <div id="warta_wp_editor_modal" class="modal modal-wp-editor-widget hidden">
                                <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                                <div class="modal-header">
                                                        <h4 class="modal-title"><?php _e('Text Editor', 'warta') ?></h4>
                                                </div>
                                                <div class="modal-body">
                                                        <?php wp_editor('', 'warta_wp_editor_content'); ?>
                                                </div>
                                                <div class="modal-footer">
                                                        <button type="button" class="button" data-dismiss="modal"><?php _e('Close', 'warta') ?></button>
                                                        <button type="button" class="button-primary"><?php _e('Save changes', 'warta') ?></button>
                                                </div>
                                        </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                </div>

                <script>                        
                        +function($) { "use strict";                                
                                $('body').on('click', '.warta-text-editor-edit-content-button', function() {
                                        var     $modal          = $('#warta_wp_editor_modal').fsmhBsModal('show'),
                                                $contentField   = $(this).prev().find('textarea'),
                                                $editorTextField= $('#warta_wp_editor_content');
                                        
                                        if( $editorTextField.is(':visible') ) {
                                                $editorTextField.val( $contentField.val() );
                                        } else {
                                                tinyMCE.get('warta_wp_editor_content').setContent( $contentField.val() ); 
                                        }
                                        
                                        $modal.find('.button-primary').off('click').click(function() {
                                                if( $editorTextField.is(':visible') ) {
                                                        $contentField.val( $editorTextField.val() );
                                                } else {
                                                        $contentField.val( tinyMCE.get('warta_wp_editor_content').getContent() );
                                                }
                                                
                                                $modal.fsmhBsModal('hide');
                                        });
                                });                                        
                        }(jQuery);     
                </script>
<?php
        }
        
        /**
         * Register widget with WordPress
         */
        function __construct() {
                parent::__construct(
                        'warta_text_editor', // Base ID
                        __('[Warta] Text Editor', 'warta'), // Name
                        array( 'description' => __( 'TinyMce text editor.', 'warta' ), ) // Args
                );
                
                $this->default_form_data = array(
                        'title'         => __( 'New title', 'warta' ),
                        'content'       => '',
                );
                
                add_action('sidebar_admin_page', array($this, 'add_wp_editor'));
                add_action('edit_form_after_editor', array($this, 'add_wp_editor'));
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args     Widget arguments.
         * @param array $instance Saved values from database.
         */
        public function widget( $args, $instance ) {                
                extract($instance);

                $title          = apply_filters( 'widget_title', $title );
                $content        = apply_filters( 'the_content', $content );
                $content        = str_replace( ']]>', ']]&gt;', $content );
?>
                <section class="widget <?php echo !isset($args['is_pb']) ? 'col-md-12' : '' ?>">            
<?php                   echo !empty($title) ? $args['before_title'] . $title . $args['after_title'] : ''; ?>
                        <div class="entry-content"><?php echo  $content; ?></div> 
                </section>
<?php
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form( $instance ) {                        
                extract( wp_parse_args( $instance, $this->default_form_data ) );
?>
                <div class="fsmh-container">                    
                        <!--Title
                        ========= -->
                        <p>
                                <label>
                                        <?php _e('Title:', 'warta') ?> 
                                        <input class    = "widefat" 
                                               id       = "<?php echo $this->get_field_id( 'title' ); ?>" 
                                               name     = "<?php echo $this->get_field_name( 'title' ); ?>" 
                                               type     = "text" 
                                               value    = "<?php echo esc_attr( $title ); ?>"
                                        >
                                </label>
                        </p>
                    
                        <!--Content
                        ===========-->
                        <p>
                                <label>
                                        <?php _e('Content:', 'warta') ?>
                                        <textarea class="widefat"  name="<?php echo $this->get_field_name('content') ?>" rows="10"><?php echo $content ?></textarea>    
                                </label>
                        </p>
                        
                        <p class="warta-text-editor-edit-content-button">
                                <button type="button" class="button"><?php _e('Open editor', 'warta') ?></button>
                        </p>
                </div>                
<?php 
        }

        /**
         * Sanitize widget form values as they are saved.
         *
         * @see WP_Widget::update()
         *
         * @param array $new_instance Values just sent to be saved.
         * @param array $old_instance Previously saved values from database.
         *
         * @return array Updated safe values to be saved.
         */
        public function update( $new_instance, $old_instance ) { 
                extract( wp_parse_args($new_instance, $this->default_form_data) );

                return array(
                        'title'         => sanitize_text_field($title),
                        'content'       => wp_kses_post($content)
                );
        }
} 
endif; 
