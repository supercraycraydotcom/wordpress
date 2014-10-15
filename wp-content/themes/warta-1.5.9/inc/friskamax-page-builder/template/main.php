<div id="fsmpb-container">                                
        <button type="button" class="button" data-toggle="modal" data-target="#fsmpb-modal-insert-row"><?php _e('Insert Row', $this->text_domain) ?></button>
        <button type="button" id="fsmpb-btn-insert-sub-row" class="button button-disabled"><?php _e('Insert Sub Row', $this->text_domain) ?></button>
        <button type="button" id="fsmpb-btn-insert-element" class="button button-disabled"><?php _e('Insert Element', $this->text_domain) ?></button>
        <button type="button" class="button" data-toggle="full-screen"><?php _e('Full Screen', $this->text_domain) ?></button>
        <br>
        <br>
        
        <!--Main content
        ================ -->
        <div id="fsmpb-main-content"></div><!--#fsmpb-main-content-->
        
        <div class="fsmh-container">
<?php   
                $dir = dirname(__FILE__);
                require $dir . '/modal-insert-row.php';
                require $dir . '/modal-insert-element.php'; 
                require $dir . '/modal-loading.php'; 
                require $dir . '/templates.php'; 
?>
        </div>
</div><!--#fsmpb-container-->

