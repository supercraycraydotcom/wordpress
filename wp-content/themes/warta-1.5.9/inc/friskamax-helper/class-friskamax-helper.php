<?php

if(!class_exists('FriskaMax_Helper')) :
class FriskaMax_Helper {
        public static $text_domain = 'friskamax';
        
        public static function modal_font_awesome_select($icon_classes) {
                asort($icon_classes);
                ob_start();
?>
                <p>
                        <label><?php _e('Search:', 'warta') ?>
                                <input type="search" class="widefat">
                        </label>
                </p>
<?php
                foreach ($icon_classes as $value) {  
                        $title = str_replace( '-', ' ', substr($value, 3) );
                        echo "<i class='fa {$value}' data-value='{$value}' title='{$title}'></i>";
                }
                
                FriskaMax_Helper::modal(array(
                        'id'            => 'warta-modal-fontawesome-select',
                        'title'         => __('Icons', 'warta'),
                        'size'          => 'modal-lg',
                        'content'       => ob_get_clean(),
                        'submit'        => ''
                ));
        }
        
        public static function modal($options) {                
                extract(wp_parse_args($options, array(
                        'size'          => '',
                        'cancel'        => __('Cancel', self::$text_domain),
                        'submit'        => __('Insert', self::$text_domain),
                )));
?>              
                <div class="fsmh-container">
                        <div id="<?php echo $id ?>"  class="modal modal-fsmh hidden">
                                <div class="modal-dialog <?php echo $size ?>">
                                        <div class="modal-content">
                                                <div class="modal-header">
                                                        <h4 class="modal-title"><?php echo $title ?></h4>
                                                </div>
                                                <div class="modal-body">
                                                        <?php echo $content; ?>
                                                </div>
                                                <div class="modal-footer">
                                                        <button type="button" class="button" data-dismiss="modal"><?php echo $cancel ?></button>
<?php                                                   if(!!$submit) : ?>
                                                                <button type="button" class="button-primary button-submit"><?php echo $submit ?></button>
<?php                                                   endif; ?>
                                                </div>
                                        </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                </div><!-- /.fsmh-container -->
<?php
        }
}
endif;