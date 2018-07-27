<?php wp_enqueue_script('formvalidate.js', jssupportticket::$_pluginpath . 'includes/js/jquery.form-validator.js'); ?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $.validate();
    });
</script>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=email&jstlay=emails');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Add System Email', 'js-support-ticket'); ?></span></span>
<form method="post" action="<?php echo admin_url("?page=email&task=saveemail"); ?>">
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Email', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
        <div class="js-form-field"><?php echo JSSTformfield::text('email', isset(jssupportticket::$_data[0]->email) ? jssupportticket::$_data[0]->email : '', array('class' => 'inputbox', 'data-validation' => 'email')) ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Autoresponse', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::radiobutton('autoresponse', array('1' => __('JYes', 'js-support-ticket'), '0' => __('JNo', 'js-support-ticket')), isset(jssupportticket::$_data[0]->autoresponse) ? jssupportticket::$_data[0]->autoresponse : '1', array('class' => 'radiobutton')); ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Status', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::radiobutton('status', array('1' => __('Active', 'js-support-ticket'), '0' => __('Disabled', 'js-support-ticket')), isset(jssupportticket::$_data[0]->status) ? jssupportticket::$_data[0]->status : '1', array('class' => 'radiobutton')); ?></div>
    </div>
    <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : '' ); ?>
    <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]->created) ? jssupportticket::$_data[0]->created : '' ); ?>
    <?php echo JSSTformfield::hidden('updated', isset(jssupportticket::$_data[0]->updated) ? jssupportticket::$_data[0]->updated : '' ); ?>
    <?php echo JSSTformfield::hidden('action', 'email_saveemail'); ?>
    <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
    <div class="js-form-button">
        <?php echo JSSTformfield::submitbutton('save', __('Save Email', 'js-support-ticket'), array('class' => 'button')); ?>
    </div>			
</form>
