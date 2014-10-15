<?php

if(!class_exists('Fsmpb_Element_Widget_Area')) : 
        class Fsmpb_Element_Widget_Area {
                
                /**
                 * Domain to retrieve the translated text
                 * @var string
                 */
                protected $text_domain;
                
                /**
                 * Widget sidebar arguments
                 * @var array
                 */
                protected $widget_sidebar_args = array(
                        'main'  => array(
                                'name'          => '',
                                'description'   => '',
                                'class'         => '',
                                'before_widget' => '<aside class="widget %2s">',
                                'after_widget'  => '</aside>',
                                'before_title'  => '<h1 class="widget-title">',
                                'after_title'   => '</h1>',
                        )
                );
        
                /**
                 * Widget area form
                 */
                public function form() {
                        $old_widget_area        = isset($_POST['formData']['widget_area'])
                                                ? $_POST['formData']['widget_area']
                                                : '';
                        $fsmpb_widget_areas     = get_option('fsmpb_widget_areas', array());
?>
                        <div class="fsmpb-container fsmh-container">
                                <form id="fsmpb-modal-custom-element-widget-area" class="modal" data-type="element">
                                        <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                        <div class="modal-header">
                                                                <h4 class="modal-title"><?php echo strip_tags($_POST['title']) ?></h4>
                                                        </div>
                                                        <div class="modal-body">
                                                                <p>
                                                                        <label><?php echo strip_tags($_POST['title']) ?>
                                                                                <select name="widget_area" class="widefat">
<?php                                                                                   foreach ($GLOBALS['wp_registered_sidebars'] as $widget_area) : ?>
                                                                                                <option value="<?php echo $widget_area['id'] ?>" <?php selected($old_widget_area, $widget_area['id']) ?>>
<?php                                                                                                   echo $widget_area['name'] ?>
                                                                                                </option>
<?php                                                                                   endforeach ?>                                                                         
                                                                                        <option value="add_new"><?php _e('Add new', $this->text_domain) ?></option>
                                                                                </select>
                                                                        </label>
                                                                </p>
                                                                <p data-requires='<?php
                                                                        $requires = array();
                                                                        foreach (array_keys($fsmpb_widget_areas) as $value) {
                                                                                $requires[] = array(
                                                                                        'field'         => '[name=widget_area]',
                                                                                        'compare'       => 'equal',
                                                                                        'value'         => $value
                                                                                );
                                                                        }
                                                                        echo json_encode($requires); 
                                                                ?>'>
                                                                        <button data-delete type="button" class="button"><?php _e('Delete', $this->text_domain) ?></button>
                                                                </p>
                                                                <p data-requires='[{"field":"[name=widget_area]", "compare":"equal", "value":"add_new"}]'>
                                                                        <label><?php _e('Name', 'warta') ?>
                                                                                <input type="text" name="new_name" class="widefat">
                                                                        </label>
                                                                </p>
                                                                <p data-requires='[{"field":"[name=widget_area]", "compare":"equal", "value":"add_new"}]'>
                                                                        <label><?php _e('Description', 'warta') ?>
                                                                                <input type="text" name="new_description" class="widefat">
                                                                        </label>
                                                                </p>
                                                        </div>
                                                        <div class="modal-footer">
                                                                <button type="button" class="button" data-dismiss="modal"><?php _e('Close', $this->text_domain) ?></button>
                                                                <button type="submit" class="button button-primary"><?php _e('Insert', $this->text_domain) ?></button>
                                                        </div>
                                                </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                </form><!-- /.modal -->
                        </div>
                        <script>
                                +function($) { 'use strict';
                                        var     $modal          = $('#fsmpb-modal-custom-element-widget-area'),
                                                $widgetArea     = $modal.find('[name=widget_area]');
                                        
                                        $modal.find('[data-delete]').click(function() {
                                                if(confirm('<?php esc_attr_e('Are you sure want to delete this widget area?', $this->text_domain) ?>')) {
                                                        var widgetAreaId = $widgetArea.val();          
                                                        
                                                        $widgetArea.find('option[value="' + widgetAreaId + '"]').remove();
                                                        $widgetArea.trigger('change');
                                                        $modal.append( $('<input>', {
                                                                type    : 'hidden',
                                                                name    : 'delete[' + widgetAreaId + ']',
                                                        } ) );
                                                }
                                        });                   
                                        
                                        // Get title for page builder
                                        $modal.submit(function() {
                                                var title       = $widgetArea.val() !== 'add_new'
                                                                ? $widgetArea.find('option[value=' + $widgetArea.val() + ']').text()
                                                                : $modal.find('[name=new_name]').val();
                                                
                                                if(!!title) {
                                                        $modal.append( $('<input>', {
                                                                type    : 'hidden',
                                                                name    : 'title',
                                                                value   : title
                                                        } ) );
                                                }
                                                
                                        });
                                }(jQuery);
                        </script>
<?php
                        die();
                }
                
                /**
                 * Sanitize widget area option
                 */
                public function sanitize() {
                        parse_str($_POST['formData'], $data);
                        
                        $db_widget_areas        = get_option('fsmpb_widget_areas', array());
                        $data                   = stripslashes_deep($data);
                        $data['widget_area']    = sanitize_text_field($data['widget_area']);
                        
                        if($data['widget_area'] == 'add_new' && is_admin()) {
                                $data['widget_area']                            = 'fsmpb-' . strtolower( sanitize_html_class($data['new_name']) );
                                $data['new_name']                               = sanitize_text_field($data['new_name']); 
                                $data['new_description']                        = sanitize_text_field($data['new_description']);                                
                                
                                $db_widget_areas[ $data['widget_area'] ]        = array(
                                                                                        'id'            => $data['widget_area'],
                                                                                        'name'          => $data['new_name'],
                                                                                        'description'   => $data['new_description'],
                                                                                        'type'          => 'main'
                                                                                ); 
                                update_option('fsmpb_widget_areas', $db_widget_areas);
                        } 
                        
                        if(isset($data['delete']) && is_admin()) {
                                foreach (array_keys($data['delete']) as $key) {
                                        if(isset($db_widget_areas[$key])) {
                                                unset($db_widget_areas[$key]);
                                        }
                                }
                                update_option('fsmpb_widget_areas', $db_widget_areas);
                        }
                        
                        echo json_encode( $data );
                        
                        die();
                }
                
                /**
                 * Display the widget area
                 * @param object $formData User settings
                 */
                public function display($formData) {
                        echo '<div class="row">';
                        dynamic_sidebar($formData->widget_area);
                        echo '</div>';
                }
                
                /**
                 * Register widget areas
                 */
                public function register_widget_areas() {
                        foreach (get_option('fsmpb_widget_areas', array()) as $widget_area_args) {
                                if(isset($widget_area_args['type']) && $widget_area_args['type'] == 'main') {
                                        register_sidebar( wp_parse_args($widget_area_args, $this->widget_sidebar_args['main']) ); 
                                }
                        }
                }
                
                /**
                 * Initialize
                 * 
                 * @param string $text_domain 
                 */
                public function __construct( $text_domain = 'friskamax' ) {
                        $this->text_domain              = $text_domain;                        
                        $this->widget_sidebar_args      = apply_filters('fsmpb_element_widget_area__sidebar_args', $this->widget_sidebar_args);
                                                
                        // Register widget areas
                        add_action( 'widgets_init', array($this, 'register_widget_areas') );
                }
        }
endif;