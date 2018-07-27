<?php
if (jssupportticket::$_config['offline'] == 2) {
    if (jssupportticket::$_data['permission_granted'] == 1) {
        if (get_current_user_id() != 0) {
            if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                if (jssupportticket::$_data['staff_enabled']) {
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
                    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
                    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>

                    <h1 class="js-ticket-heading"><?php echo __('Compose', 'js-support-ticket') ?></h1>
                    <div class="js-filter-add-button">
                        <span>  <a class="js-add-link button" href="index.php?page_id=<?php echo jssupportticket::getPageid(); ?>&jstmod=mail&jstlay=inbox"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/inbox.png">  <?php echo __('Inbox', 'js-support-ticket').' (';
                    echo $inbox;
                    echo ' )'; ?></a></span>
                        <span>	<a class="js-add-link button" href="index.php?page_id=<?php echo jssupportticket::getPageid(); ?>&jstmod=mail&jstlay=outbox"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/outbox.png"><?php echo __('Outbox', 'js-support-ticket').' (';
                    echo jssupportticket::$_data[0]['outboxmessages'];
                    echo __(' )  ', 'js-support-ticket'); ?></a></span>
                        <span>	<a class="js-add-link button active formmessage" href="index.php?page_id=<?php echo jssupportticket::getPageid(); ?>&jstmod=mail&jstlay=formmessage"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon2.png" /><?php echo __('Compose', 'js-support-ticket') ?></a></span>
                    </div>
                    <form class="js-ticket-form" method="post" action="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=mail&task=savemessage"); ?>">
                        <div class="js-col-md-12 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('To', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
                            <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::select('to', JSSTincluder::getJSModel('staff')->getStaffForMailCombobox(), isset(jssupportticket::$_data[0]->to) ? jssupportticket::$_data[0]->to : '', __('Select Staff', 'js-support-ticket'), array('class' => 'inputbox', 'data-validation' => 'required')); ?></div>
                        </div>
                        <div class="js-col-md-12 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('Subject', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
                            <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::text('subject', isset(jssupportticket::$_data[0]->subject) ? jssupportticket::$_data[0]->subject : '', array('class' => 'inputbox', 'data-validation' => 'required')) ?></div>
                        </div>
                        <div class="js-col-md-12 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('Message', 'js-support-ticket'); ?></div>
                            <div class="js-col-md-12 js-form-value"><?php echo wp_editor(isset(jssupportticket::$_data[0]->message) ? jssupportticket::$_data[0]->message : '', 'message', array('media_buttons' => false)); ?></div>
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
                    <?php
                } else {
                    JSSTlayout::getStaffMemberDisable();
                }
            } else { // user not Staff
                JSSTlayout::getNotStaffMember();
            }
        } else {
            $redirect_url = site_url('?page_id='.jssupportticket::getPageid().'&jstmod=mail&jstlay=formmessage');
            $redirect_url = base64_encode($redirect_url);
            JSSTlayout::getUserGuest($redirect_url);
        }
    } else { // User permission not granted
        JSSTlayout::getPermissionNotGranted();
    }
} else {
    JSSTlayout::getSystemOffline();
}