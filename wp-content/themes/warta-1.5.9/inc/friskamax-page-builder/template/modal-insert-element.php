<!--Modal: Insert Element
========================= -->
<div class="modal insert-element">
        <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                        <div class="modal-body">   
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs"><?php $this->display_insert_element__tabs() ?></ul>
                                
                                <!-- Tab panes -->
                                <div class="tab-content"><?php $this->display_insert_element__tab_panes() ?></div>
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="button" data-dismiss="modal"><?php _e('Close', $this->text_domain) ?></button>
                        </div>
                </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
</div><!-- /.modal -->