<?php wp_enqueue_script('formvalidate.js', jssupportticket::$_pluginpath . 'includes/js/jquery.form-validator.js'); ?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $.validate();
    });
</script>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=helptopic&jstlay=helptopics');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Add Help Topic', 'js-support-ticket'); ?></span>
</span>
<form method="post" action="<?php echo admin_url("admin.php?page=helptopic&task=savehelptopic"); ?>">
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Help Topic', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
        <div class="js-form-field"><?php echo JSSTformfield::text('topic', isset(jssupportticket::$_data[0]->topic) ? jssupportticket::$_data[0]->topic : '', array('class' => 'inputbox', 'data-validation' => 'required')) ?></div>
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
        <div class="js-form-title"><?php echo __('Auto Response', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo JSSTformfield::checkbox('autoresponce', array('1' => __('Auto response for this topic','js-support-ticket').' ( '.__('override department setting', 'js-support-ticket').' )'), isset(jssupportticket::$_data[0]->autoresponce) ? jssupportticket::$_data[0]->autoresponce : '1', array('class' => 'radiobutton')); ?></div>
    </div>
    <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : '' ); ?>
    <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]->created) ? jssupportticket::$_data[0]->created : '' ); ?>
    <?php echo JSSTformfield::hidden('updated', isset(jssupportticket::$_data[0]->updated) ? jssupportticket::$_data[0]->updated : '' ); ?>
    <?php echo JSSTformfield::hidden('action', 'helptopic_savehelptopic'); ?>
    <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
    <div class="js-form-button">
        <?php echo JSSTformfield::submitbutton('save', __('Save Help Topic', 'js-support-ticket'), array('class' => 'button')); ?>
    </div>
</form>	
