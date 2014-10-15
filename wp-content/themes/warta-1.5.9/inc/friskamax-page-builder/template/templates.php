<!--Element
===========-->
<script type="text/template" id="fsmpb-template-element">
        <div id="{{id}}" class="element">
                <h5><strong>{{title}}</strong></h5>
                <small>{{subtitle}}</small>
                        
                <div class="control bg-primary">
                        <a href="#" class="fa fa-pencil" title="<?php esc_attr_e('Edit', $this->text_domain) ?>"></a>
                        <a href="#" class="fa fa-copy" title="<?php esc_attr_e('Duplicate', $this->text_domain) ?>"></a>
                        <a href="#" class="fa fa-times" title="<?php esc_attr_e('Delete', $this->text_domain) ?>"></a>
                </div>
        </div>
</script>

<script type="text/template" id="fsmpb-template-col">
        <div class="col-xs-{{width}}">
                <div class="elements"></div>
        </div>
</script>

<!--Row Control
===============-->
<script type="text/template" id="fsmpb-template-row">
        <div class="row">
                <div class="control">
                        <a href="#" class="fa fa-arrows" title="<?php esc_attr_e('Move this row', $this->text_domain) ?>"></a>
                        <a href="#" class="fa fa-copy" title="<?php esc_attr_e('Duplicate this row', $this->text_domain) ?>"></a>
                        <a href="#" class="fa fa-times" title="<?php esc_attr_e('Delete this row', $this->text_domain) ?>"></a>
                </div>
        </div>
</script>