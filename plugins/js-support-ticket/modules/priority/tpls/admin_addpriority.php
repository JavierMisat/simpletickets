<?php
wp_enqueue_script('colorpicker.js', jssupportticket::$_pluginpath . 'includes/js/colorpicker.js');
wp_enqueue_style('colorpicker', jssupportticket::$_pluginpath . 'includes/css/colorpicker.css');
wp_enqueue_script('formvalidate.js', jssupportticket::$_pluginpath . 'includes/js/jquery.form-validator.js');
?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $.validate();
    });
</script>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=priority&jstlay=priorities');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Add Priority', 'js-support-ticket'); ?></span></span>
<form method="post" action="<?php echo admin_url("?page=priority&task=savepriority"); ?>">
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Priority', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
        <div class="js-form-field"><?php echo JSSTformfield::text('priority', isset(jssupportticket::$_data[0]->priority) ? jssupportticket::$_data[0]->priority : '', array('class' => 'inputbox', 'data-validation' => 'required')) ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Color', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
        <div class="js-form-field"><?php echo JSSTformfield::text('prioritycolor', isset(jssupportticket::$_data[0]->prioritycolour) ? jssupportticket::$_data[0]->prioritycolour : '', array('class' => 'inputbox', 'data-validation' => 'required')); ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Public', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::radiobutton('ispublic', array('1' => __('JYes', 'js-support-ticket'), '0' => __('JNo', 'js-support-ticket')), isset(jssupportticket::$_data[0]->ispublic) ? jssupportticket::$_data[0]->ispublic : '1', array('class' => 'radiobutton')); ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Default', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::radiobutton('isdefault', array('1' => __('JYes', 'js-support-ticket'), '0' => __('JNo', 'js-support-ticket')), isset(jssupportticket::$_data[0]->isdefault) ? jssupportticket::$_data[0]->isdefault : '1', array('class' => 'radiobutton')); ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Status', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::radiobutton('status', array('1' => __('Enabled', 'js-support-ticket'), '0' => __('Disabled', 'js-support-ticket')), isset(jssupportticket::$_data[0]->status) ? jssupportticket::$_data[0]->status : '1', array('class' => 'radiobutton')); ?></div>
    </div>
    <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : '' ); ?>
    <?php echo JSSTformfield::hidden('ordering', isset(jssupportticket::$_data[0]->ordering) ? jssupportticket::$_data[0]->ordering : '' ); ?>
    <?php echo JSSTformfield::hidden('action', 'priority_savepriority'); ?>
    <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
    <?php echo JSSTformfield::hidden('uid', get_current_user_id()); ?>
    <div class="js-form-button">
        <?php echo JSSTformfield::submitbutton('save', __('Save Priority', 'js-support-ticket'), array('class' => 'button')); ?>
    </div>	
</form>
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery('input#prioritycolor').ColorPicker({
            color: jQuery('input#prioritycolor').val(),
            onShow: function (colpkr) {
                jQuery(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                jQuery(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                jQuery('input#prioritycolor').css('backgroundColor', '#' + hex).val('#' + hex);
            }
        });
    });

</script>
