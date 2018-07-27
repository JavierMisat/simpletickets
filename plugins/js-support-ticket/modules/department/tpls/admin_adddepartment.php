<?php wp_enqueue_script('formvalidate.js', jssupportticket::$_pluginpath . 'includes/js/jquery.form-validator.js'); ?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $.validate();
    });
</script>

<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=department&jstlay=departments');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Add Department', 'js-support-ticket'); ?></span></span>
<form method="post" action="<?php echo admin_url("admin.php?page=department&task=savedepartment"); ?>">
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Title', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
        <div class="js-form-field"><?php echo JSSTformfield::text('departmentname', isset(jssupportticket::$_data[0]->departmentname) ? jssupportticket::$_data[0]->departmentname : '', array('class' => 'inputbox', 'data-validation' => 'required')) ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Outgoing Email', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
        <div class="js-form-field"><?php echo JSSTformfield::select('emailid', JSSTincluder::getJSModel('email')->getEmailForDepartment(), isset(jssupportticket::$_data[0]->emailid) ? jssupportticket::$_data[0]->emailid : '', __('Select Email', 'js-support-ticket'), array('class' => 'inputbox', 'data-validation' => 'required')); ?><small>&nbsp;&nbsp;(<?php echo __('User of this department will receive email on new ticket','js-support-ticket'); ?>)</small></div>
    </div>
    <div class="js-form-wrapper" style="display:none;">
        <div class="js-form-title"><?php echo __('Public', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::radiobutton('ispublic', array('1' => __('Public', 'js-support-ticket'), '0' => __('Private', 'js-support-ticket')), isset(jssupportticket::$_data[0]->ispublic) ? jssupportticket::$_data[0]->ispublic : '1', array('class' => 'radiobutton')); ?></div>
    </div>
    <div class="js-form-wrapper" >
        <div class="js-form-title"><?php echo __('Receive Email', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::radiobutton('sendmail', array('1' => __('JYes', 'js-support-ticket'), '0' => __('JNo', 'js-support-ticket')), isset(jssupportticket::$_data[0]->sendmail) ? jssupportticket::$_data[0]->sendmail : '0', array('class' => 'radiobutton')); ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Signature', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo wp_editor(isset(jssupportticket::$_data[0]->departmentsignature) ? jssupportticket::$_data[0]->departmentsignature : '', 'departmentsignature', array('media_buttons' => false)); ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Append Signature', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::checkbox('canappendsignature', array('1' => __('Append signature with reply', 'js-support-ticket')), isset(jssupportticket::$_data[0]->canappendsignature) ? jssupportticket::$_data[0]->canappendsignature : '1', array('class' => 'radiobutton')); ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Status', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::radiobutton('status', array('1' => __('Enabled', 'js-support-ticket'), '0' => __('Disabled', 'js-support-ticket')), isset(jssupportticket::$_data[0]->status) ? jssupportticket::$_data[0]->status : '1', array('class' => 'radiobutton')); ?></div>
    </div>
    <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : ''); ?>
    <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]->created) ? jssupportticket::$_data[0]->created : ''); ?>
    <?php echo JSSTformfield::hidden('updated', isset(jssupportticket::$_data[0]->updated) ? jssupportticket::$_data[0]->updated : ''); ?>
    <?php echo JSSTformfield::hidden('ordering', isset(jssupportticket::$_data[0]->ordering) ? jssupportticket::$_data[0]->ordering : ''); ?>
    <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
    <div class="js-form-button">
        <?php echo JSSTformfield::submitbutton('save', __('Save Department', 'js-support-ticket'), array('class' => 'button')); ?>
    </div>
</form>
