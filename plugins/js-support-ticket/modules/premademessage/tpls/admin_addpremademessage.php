<?php wp_enqueue_script('formvalidate.js', jssupportticket::$_pluginpath . 'includes/js/jquery.form-validator.js'); ?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $.validate();
    });
</script>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=premademessage');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Add Premade Message', 'js-support-ticket'); ?></span></span>
<form method="post" action="<?php echo admin_url("admin.php?page=premademessage&task=savepremademessage"); ?>">
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Title', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
        <div class="js-form-field"><?php echo JSSTformfield::text('title', isset(jssupportticket::$_data[0]->title) ? jssupportticket::$_data[0]->title : '', array('class' => 'inputbox', 'data-validation' => 'required')) ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Status', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::radiobutton('status', array('1' => __('Active', 'js-support-ticket'), '0' => __('Disabled', 'js-support-ticket')), isset(jssupportticket::$_data[0]->status) ? jssupportticket::$_data[0]->status : '1', array('class' => 'radiobutton')); ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Department', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
        <div class="js-form-field">
            <?php 
                $departmentid = isset(jssupportticket::$_data[0]->departmentid) ? jssupportticket::$_data[0]->departmentid : JSSTincluder::getJSModel('department')->getDefaultDepartmentID();
                echo JSSTformfield::select('departmentid', JSSTincluder::getJSModel('department')->getDepartmentForCombobox(), $departmentid, __('Select Department', 'js-support-ticket'), array('class' => 'inputbox', 'data-validation' => 'required')); 
            ?>
        </div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Department Under Which The Answer Will Be Made Available', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo wp_editor(isset(jssupportticket::$_data[0]->answer) ? jssupportticket::$_data[0]->answer : '', 'answer', array('media_buttons' => false)); ?></div>
    </div>
    <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : ''); ?>
    <?php echo JSSTformfield::hidden('updated', isset(jssupportticket::$_data[0]->updated) ? jssupportticket::$_data[0]->updated : ''); ?>
    <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]->created) ? jssupportticket::$_data[0]->created : ''); ?>
    <?php echo JSSTformfield::hidden('action', 'premademessage_savepremademessage'); ?>
    <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
    <div class="js-form-button">
        <?php echo JSSTformfield::submitbutton('save', __('Save premade message', 'js-support-ticket'), array('class' => 'button')); ?>
    </div>
</form>
