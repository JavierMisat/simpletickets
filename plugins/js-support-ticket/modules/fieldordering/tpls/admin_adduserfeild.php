<?php 
//echo '<pre>';print_r(jssupportticket::$_data[0]);echo '</pre>';
wp_enqueue_script('formvalidate.js', jssupportticket::$_pluginpath . 'includes/js/jquery.form-validator.js'); ?>
<script type="text/javascript">
     ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    jQuery(document).ready(function ($) {
        $.validate();
    });
</script>
    <span class="js-adminhead-title">
        <a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=fieldordering');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext">
        <?php
            $heading = isset(jssupportticket::$_data[0]['fieldvalues']) ? __('Edit', 'js-jobs') : __('Add New', 'js-jobs');
            echo $heading . '&nbsp' . __('User Field', 'js-jobs');
        ?>
        </span>
    </span>
    <?php
    $yesno = array(
        (object) array('id' => 1, 'text' => __('JYes', 'js-jobs')),
        (object) array('id' => 0, 'text' => __('JNo', 'js-jobs')));
    $fieldtypes = array(
        (object) array('id' => 'text', 'text' => __('Text Field', 'js-jobs')),
        (object) array('id' => 'checkbox', 'text' => __('Check Box', 'js-jobs')),
        (object) array('id' => 'date', 'text' => __('Date', 'js-jobs')),
        (object) array('id' => 'combo', 'text' => __('Drop Down', 'js-jobs')),
        (object) array('id' => 'email', 'text' => __('Email Address', 'js-jobs')),
        (object) array('id' => 'textarea', 'text' => __('Text Area', 'js-jobs')),
        (object) array('id' => 'radio', 'text' => __('Radio Button', 'js-jobs')),
        (object) array('id' => 'depandant_field', 'text' => __('Depandent Field', 'js-jobs')),
        (object) array('id' => 'file', 'text' => __('upload file', 'js-jobs')),
        (object) array('id' => 'multiple', 'text' => __('Multi Select', 'js-jobs')));
    $fieldsize = array(
         (object) array('id' => 50, 'text' => __('50%', 'js-jobs')),
        (object) array('id' => 100, 'text' => __('100%', 'js-jobs')));
    ?>
    <form id="adminForm" method="post" action="<?php echo admin_url("admin.php?page=fieldordering&task=saveuserfeild"); ?>">
        <div class="js-form-wrapper">
            <div class="js-form-title"><?php echo __('Field Type', 'js-jobs'); ?><font class="required-notifier">*</font></div>
            <div class="js-form-field"><?php echo JSSTformfield::select('userfieldtype', $fieldtypes, isset(jssupportticket::$_data[0]['userfield']->userfieldtype) ? jssupportticket::$_data[0]['userfield']->userfieldtype : 'text', '', array('class' => 'inputbox one', 'data-validation' => 'required', 'onchange' => 'toggleType(this.options[this.selectedIndex].value);')); ?></div>
        </div>
<?php /*
        <div class="js-form-wrapper">
            <div class="js-form-title"><?php // echo __('Field Name', 'js-jobs'); ?><font class="required-notifier">*</font></div>
            <div class="js-form-field"><?php // echo JSSTformfield::text('field', isset(jssupportticket::$_data[0]['userfield']->field) ? jssupportticket::$_data[0]['userfield']->field : '', array('class' => 'inputbox one', 'data-validation' => 'required', 'onchange' => 'prep4SQL(this);')); ?></div>
        </div>
*/ ?>
        <div class="js-form-wrapper">
            <div class="js-form-title"><?php echo __('Field Title', 'js-jobs'); ?><font class="required-notifier">*</font></div>
            <div class="js-form-field"><?php echo JSSTformfield::text('fieldtitle', isset(jssupportticket::$_data[0]['userfield']->fieldtitle) ? jssupportticket::$_data[0]['userfield']->fieldtitle : '', array('class' => 'inputbox one', 'data-validation' => 'required')); ?></div>
        </div>
        <div class="js-form-wrapper" id="for-combo-wrapper" style="display:none;">
            <div class="js-form-title"><?php echo __('Select','js-jobs') .'&nbsp;'. __('Parent Field', 'js-jobs'); ?><font class="required-notifier">*</font></div>
            <div class="js-form-field" id="for-combo"></div>      
        </div>
        <div class="js-form-wrapper">
            <div class="js-form-title"><?php echo __('Show on listing', 'js-jobs'); ?></div>
            <div class="js-form-field"><?php echo JSSTformfield::select('showonlisting', $yesno, isset(jssupportticket::$_data[0]['userfield']->showonlisting) ? jssupportticket::$_data[0]['userfield']->showonlisting : 0, '', array('class' => 'inputbox one')); ?></div>
        </div>
        <div class="js-form-wrapper">
            <div class="js-form-title"><?php echo __('User Published', 'js-jobs'); ?></div>
            <div class="js-form-field"><?php echo JSSTformfield::select('published', $yesno, isset(jssupportticket::$_data[0]['userfield']->published) ? jssupportticket::$_data[0]['userfield']->published : 1, '', array('class' => 'inputbox one')); ?></div>
        </div>
        <div class="js-form-wrapper">
            <div class="js-form-title"><?php echo __('Visitor Published', 'js-jobs'); ?></div>
            <div class="js-form-field"><?php echo JSSTformfield::select('isvisitorpublished', $yesno, isset(jssupportticket::$_data[0]['userfield']->isvisitorpublished) ? jssupportticket::$_data[0]['userfield']->isvisitorpublished : 1, '', array('class' => 'inputbox one')); ?></div>
        </div>
        <div class="js-form-wrapper">
            <div class="js-form-title"><?php echo __('User Search', 'js-jobs'); ?></div>
            <div class="js-form-field"><?php echo JSSTformfield::select('search_user', $yesno, isset(jssupportticket::$_data[0]['userfield']->search_user) ? jssupportticket::$_data[0]['userfield']->search_user : 1, '', array('class' => 'inputbox one')); ?></div>
        </div>
        <div class="js-form-wrapper">
            <div class="js-form-title"><?php echo __('Visitor Search', 'js-jobs'); ?></div>
            <div class="js-form-field"><?php echo JSSTformfield::select('search_visitor', $yesno, isset(jssupportticket::$_data[0]['userfield']->search_visitor) ? jssupportticket::$_data[0]['userfield']->search_visitor : 1, '', array('class' => 'inputbox one')); ?></div>
        </div>
        <div class="js-form-wrapper">
            <div class="js-form-title"><?php echo __('Required', 'js-jobs'); ?></div>
            <div class="js-form-field"><?php echo JSSTformfield::select('required', $yesno, isset(jssupportticket::$_data[0]['userfield']->required) ? jssupportticket::$_data[0]['userfield']->required : 0, '', array('class' => 'inputbox one')); ?></div>
        </div>
        <div class="js-form-wrapper">
            <div class="js-form-title"><?php echo __('Field Size', 'js-jobs'); ?></div>
            <div class="js-form-field"><?php echo JSSTformfield::select('size', $fieldsize, isset(jssupportticket::$_data[0]['userfield']->size) ? jssupportticket::$_data[0]['userfield']->size : 0, '', array('class' => 'inputbox one')); ?></div>
        </div>
        <?php /*
        <div class="js-form-wrapper">
            <div class="js-form-title"><?php echo __('Java Script', 'js-jobs'); ?></div>
            <div class="js-form-field"><?php echo JSSTformfield::textarea('j_script', isset(jssupportticket::$_data[0]['userfield']->j_script) ? jssupportticket::$_data[0]['userfield']->j_script : '', array('class' => 'inputbox one')); ?></div>
        </div>
        */ ?>

        <div id="for-combo-options" >
            <?php
            $arraynames = '';
            $comma = '';
            if (isset(jssupportticket::$_data[0]['userfieldparams']) && jssupportticket::$_data[0]['userfield']->userfieldtype == 'depandant_field') {
                foreach (jssupportticket::$_data[0]['userfieldparams'] as $key => $val) {
                    $textvar = $key;
                    $textvar .='[]';
                    $arraynames .= $comma . "$key";
                    $comma = ',';
                    ?>
                    <div class="js-field-wrapper js-row no-margin">
                        <div class="js-field-title js-col-lg-3 js-col-md-3 no-padding">
                            <?php echo $key; ?>
                        </div>
                        <div class="js-col-lg-9 js-col-md-9 no-padding combo-options-fields" id="<?php echo $key; ?>">
                            <?php
                            if (!empty($val)) {
                                foreach ($val as $each) {
                                    ?>
                                    <span class="input-field-wrapper">
                                        <input name="<?php echo $textvar; ?>" id="<?php echo $textvar; ?>" value="<?php echo $each; ?>" class="inputbox one user-field" type="text">
                                        <img class="input-field-remove-img" src="<?php echo jssupportticket::$_pluginpath ?>includes/images/remove.png">
                                    </span><?php
                                }
                            }
                            ?>
                            <input id="depandant-field-button" onclick="getNextField( &quot;<?php echo $key; ?>&quot;, this );" value="Add More" type="button">
                        </div>
                    </div><?php
                }
            }
            ?>
        </div>

        <div id="divText" class="js-form-wrapper">
            <div class="js-form-title"><?php echo __('Max Length', 'js-jobs'); ?></div>
            <div class="js-form-field"><?php echo JSSTformfield::text('maxlength', isset(jssupportticket::$_data[0]['userfield']->maxlength) ? jssupportticket::$_data[0]['userfield']->maxlength : '', array('class' => 'inputbox one')); ?></div>
        </div>
        <div class="js-form-wrapper divColsRows">
            <div class="js-form-title"><?php echo __('Columns', 'js-jobs'); ?></div>
            <div class="js-form-field"><?php echo JSSTformfield::text('cols', isset(jssupportticket::$_data[0]['userfield']->cols) ? jssupportticket::$_data[0]['userfield']->cols : '', array('class' => 'inputbox one')); ?></div>
        </div>
        <div class="js-form-wrapper divColsRows">
            <div class="js-form-title"><?php echo __('Rows', 'js-jobs'); ?></div>
            <div class="js-form-field"><?php echo JSSTformfield::text('rows', isset(jssupportticket::$_data[0]['userfield']->rows) ? jssupportticket::$_data[0]['userfield']->rows : '', array('class' => 'inputbox one')); ?></div>
        </div>
        <div id="divValues" class="js-form-wrapper divColsRowsno-margin">
            <span class="js-admin-title"><?php echo __('Use The Table Below To Add New Values', 'js-jobs'); ?></span>
            <div class="page-actions no-margin">
                <div id="user-field-values" class="white-background" class="no-padding">
                    <?php
                    if (isset(jssupportticket::$_data[0]['userfield']) && jssupportticket::$_data[0]['userfield']->userfieldtype != 'depandant_field') {
                        if (isset(jssupportticket::$_data[0]['userfieldparams']) && !empty(jssupportticket::$_data[0]['userfieldparams'])) {
                            foreach (jssupportticket::$_data[0]['userfieldparams'] as $key => $val) {
                                ?>
                                <span class="input-field-wrapper">
                                    <?php echo JSSTformfield::text('values[]', isset($val) ? $val : '', array('class' => 'inputbox one user-field')); ?>
                                    <img class="input-field-remove-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" />
                                </span>
                            <?php
                            }
                        } else {
                            ?>
                            <span class="input-field-wrapper">
                            <?php echo JSSTformfield::text('values[]', isset($val) ? $val : '', array('class' => 'inputbox one user-field')); ?>
                                <img class="input-field-remove-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" />
                            </span>
                        <?php
                        }
                    }
                    ?>
                    <a class="js-button-link button user-field-val-button" id="user-field-val-button" onclick="insertNewRow();"><?php echo __('Add Value', 'js-jobs') ?></a>
                </div>  
            </div>
        </div>
        <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]['userfield']->id) ? jssupportticket::$_data[0]['userfield']->id : ''); ?>
        <?php echo JSSTformfield::hidden('fieldfor', 1); ?>
        <?php echo JSSTformfield::hidden('ordering', isset(jssupportticket::$_data[0]['userfield']->ordering) ? jssupportticket::$_data[0]['userfield']->ordering : '' ); ?>
        <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
        <?php echo JSSTformfield::hidden('isuserfield', 1); ?>
        <?php echo JSSTformfield::hidden('fieldname', isset(jssupportticket::$_data[0]['userfield']->field) ? jssupportticket::$_data[0]['userfield']->field : '' ); ?>
        <?php echo JSSTformfield::hidden('depandant_field', isset(jssupportticket::$_data[0]['userfield']->depandant_field) ? jssupportticket::$_data[0]['userfield']->depandant_field : '' ); ?>
        <?php echo JSSTformfield::hidden('arraynames2', $arraynames); ?>
        <div class="js-form-button">
<?php echo JSSTformfield::submitbutton('save', __('Save User Field', 'js-support-ticket'), array('class' => 'button')); ?>
            </div>
    </form>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            toggleType(jQuery('#userfieldtype').val());
        });
        function disableAll() {
            jQuery("#divValues").slideUp();
            jQuery(".divColsRows").slideUp();
            jQuery("#divText").slideUp();
        }
        function toggleType(type) {
            disableAll();
            //prep4SQL(document.forms['adminForm'].elements['field']);
            selType(type);
        }
        function prep4SQL(field) {
            if (field.value != '') {
                field.value = field.value.replace('js_', '');
                field.value = 'js_' + field.value.replace(/[^a-zA-Z]+/g, '');
            }
        }
        function selType(sType) {
            var elem;
            /*
             text
             checkbox
             date
             combo
             email
             textarea
             radio
             editor
             depandant_field
             multiple*/

            switch (sType) {
                case 'editor':
                    jQuery("#divText").slideUp();
                    jQuery("#divValues").slideUp();
                    jQuery(".divColsRows").slideUp();
                    jQuery("div#for-combo-wrapper").hide();
                    jQuery("div#for-combo-options").hide();
                    jQuery("div#for-combo-options-head").hide();
                    break;
                case 'textarea':
                    jQuery("#divText").slideUp();
                    jQuery(".divColsRows").slideDown();
                    jQuery("#divValues").slideUp();
                    jQuery("div#for-combo-wrapper").hide();
                    jQuery("div#for-combo-options").hide();
                    jQuery("div#for-combo-options-head").hide();
                    break;
                case 'email':
                case 'password':
                case 'text':
                    jQuery("#divText").slideDown();
                    jQuery("div#for-combo-wrapper").hide();
                    jQuery("div#for-combo-options").hide();
                    jQuery("div#for-combo-options-head").hide();
                    break;
                case 'combo':
                case 'multiple':
                    jQuery("#divValues").slideDown();
                    jQuery("div#for-combo-wrapper").hide();
                    jQuery("div#for-combo-options").hide();
                    jQuery("div#for-combo-options-head").hide();
                    break;
                case 'depandant_field':
                    comboOfFields();
                    break;
                case 'radio':
                case 'checkbox':
                    //jQuery(".divColsRows").slideDown();
                    jQuery("#divValues").slideDown();
                    jQuery("div#for-combo-wrapper").hide();
                    jQuery("div#for-combo-options").hide();
                    jQuery("div#for-combo-options-head").hide();
                    /*
                     if (elem=getObject('jsNames[0]')) {
                     elem.setAttribute('mosReq',1);
                     }
                     */
                    break;
                case 'delimiter':
                default:
            }
        }

        function comboOfFields() {
            ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            var ff = jQuery("input#fieldfor").val();
            var pf = jQuery("input#fieldname").val();
            jQuery.post(ajaxurl, {action: 'jsticket_ajax', jstmod: 'fieldordering', task: 'getFieldsForComboByFieldFor', fieldfor: ff,parentfield:pf}, function (data) {
                    console.log(data);
                if (data) {
                    var d = jQuery.parseJSON(data);
                    jQuery("div#for-combo").html(d);
                    jQuery("div#for-combo-wrapper").show();
                }
            });
        }

        function getDataOfSelectedField() {
            ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            var field = jQuery("select#parentfield").val();
            jQuery.post(ajaxurl, {action: 'jsticket_ajax', jstmod: 'fieldordering', task: 'getSectionToFillValues', pfield: field}, function (data) {
                if (data) {
                    console.log(data);
                    var d = jQuery.parseJSON(data);
                    jQuery("div#for-combo-options-head").show();
                    jQuery("div#for-combo-options").html(d);
                    jQuery("div#for-combo-options").show();
                }
            });
        }

        function getNextField(divid, object) {
            var textvar = divid + '[]';
            var fieldhtml = "<span class='input-field-wrapper' ><input type='text' name='" + textvar + "' class='inputbox one user-field'  /><img class='input-field-remove-img' src='<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png' /></span>";
            jQuery(object).before(fieldhtml);
        }

        function getObject(obj) {
            var strObj;
            if (document.all) {
                strObj = document.all.item(obj);
            } else if (document.getElementById) {
                strObj = document.getElementById(obj);
            }
            return strObj;
        }

        function insertNewRow() {
            var fieldhtml = '<span class="input-field-wrapper" ><input name="values[]" id="values[]" value="" class="inputbox one user-field" type="text" /><img class="input-field-remove-img" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" /></span>';
            jQuery("#user-field-val-button").before(fieldhtml);
        }
        jQuery(document).ready(function () {
            jQuery("body").delegate("img.input-field-remove-img", "click", function () {
                jQuery(this).parent().remove();
            });
        });

    </script>
