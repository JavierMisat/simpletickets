<?php
wp_enqueue_script('formvalidate.js', jssupportticket::$_pluginpath . 'includes/js/jquery.form-validator.js');
if (jssupportticket::$_data[0]['unreadmessages'] >= 1) {
    $inbox = jssupportticket::$_data[0]['unreadmessages'];
} else {
    $inbox = jssupportticket::$_data[0]['totalInboxboxmessages'];
}
?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $.validate();
    });
</script>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=mail&jstlay=inbox');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Compose', 'js-support-ticket'); ?></span>
</span>
<div class="js-admin-content-button">
    <span>  <a class="js-add-link button" href="?page=mail&jstlay=inbox"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/inboxadmin.png">  <?php echo __('Inbox', 'js-support-ticket').' (';
echo $inbox;
echo ' )'; ?></a></span>
    <span>	<a class="js-add-link button" href="?page=mail&jstlay=outbox"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/outboxadmin.png"><?php echo __('Outbox', 'js-support-ticket').' (';
echo jssupportticket::$_data[0]['outboxmessages'];
echo __(' )  ', 'js-support-ticket'); ?></a></span>
    <span>	<a class="js-add-link button active" href="?page=mail&jstlay=formmessage"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon.png" /><?php echo __('Compose', 'js-support-ticket') ?></a></span>
</div>
<form method="post" action="<?php echo admin_url("admin.php?page=mail&task=savemessage"); ?>">
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('To', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
        <div class="js-form-field"><?php echo JSSTformfield::select('to', JSSTincluder::getJSModel('staff')->getStaffForMailCombobox(), isset(jssupportticket::$_data[0]->to) ? jssupportticket::$_data[0]->to : '', __('Select Staff', 'js-support-ticket'), array('class' => 'inputbox', 'data-validation' => 'required')); ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Subject', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
        <div class="js-form-field"><?php echo JSSTformfield::text('subject', isset(jssupportticket::$_data[0]->subject) ? jssupportticket::$_data[0]->subject : '', array('class' => 'inputbox', 'data-validation' => 'required')) ?></div>
    </div>
    <div class="js-form-wrapper">
        <div class="js-form-title"><?php echo __('Message', 'js-support-ticket'); ?></div>
        <div class="js-form-field"><?php echo wp_editor(isset(jssupportticket::$_data[0]->message) ? jssupportticket::$_data[0]->message : '', 'message', array('media_buttons' => false)); ?></div>
    </div>
    <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : '' ); ?>
    <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]->created) ? jssupportticket::$_data[0]->created : ''); ?>
    <?php echo JSSTformfield::hidden('isread', 2); ?>
    <?php echo JSSTformfield::hidden('status', 1); ?>
        <?php echo JSSTformfield::hidden('from', JSSTincluder::getJSModel('staff')->getStaffId(get_current_user_id())); ?>
        <?php echo JSSTformfield::hidden('action', 'mail_savemessage'); ?>
<?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
    <div class="js-form-button">
<?php echo JSSTformfield::submitbutton('save', __('Send', 'js-support-ticket'), array('class' => 'button')); ?>
    </div>
</form>