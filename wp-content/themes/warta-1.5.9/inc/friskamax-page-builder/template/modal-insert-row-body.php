<!--Modal: Insert Row - Body
============================ -->
<div class="modal-body">
        <?php _e('Choose Layout:', $this->text_domain) ?>
        <div class="columns clearfix">
                <div class="col-12"             title="12"></div>
                <div class="col-6-6"            title="6-6"></div>
                <div class="col-4-4-4"          title="4-4-4"></div>
                <div class="col-3-3-3-3"        title="3-3-3-3"></div>
                <div class="col-2-2-2-2-2-2"    title="2-2-2-2-2-2"></div>
                <div class="col-4-8"            title="4-8"></div>
                <div class="col-8-4"            title="8-4"></div>
                <div class="col-3-6-3"          title="3-6-3"></div>
                <div class="col-3-3-6"          title="3-3-6"></div>
                <div class="col-6-3-3"          title="6-3-3"></div>
        </div>
        <br>

        <p>
                <label><?php _e('Custom Layout:', $this->text_domain) ?><br> 
                        <input type="text" name="fsmpb[row]" value="12">
                </label><br>
                <small><?php _e('The sum of the columns should be 12. Example: 3-6-3', $this->text_domain) ?></small>
        </p>
</div>
<div class="modal-footer">
        <button type="button" class="button" data-dismiss="modal"><?php _e('Close', $this->text_domain) ?></button>
        <button type="button" class="button button-primary" data-insert><?php _e('Insert', $this->text_domain) ?></button>
</div>