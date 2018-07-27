<?php JSSTmessage::getMessage(); ?>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Email Templates', 'js-support-ticket') ?></span></span>
<form method="post" action="<?php echo admin_url("?page=emailtemplate&task=saveemailtemplate"); ?>">
    <div class="js-email-menu">
        <span class="js-email-menu-link <?php if (jssupportticket::$_data[1] == 'tk-nw') echo 'selected'; ?>"><a class="js-email-link" href="?page=emailtemplate&for=tk-nw"><?php echo __('New Ticket', 'js-support-ticket'); ?></a></span>
        <span class="js-email-menu-link <?php if (jssupportticket::$_data[1] == 'sntk-tk') echo 'selected'; ?>"><a class="js-email-link" href="?page=emailtemplate&for=sntk-tk"><?php echo __('Staff Ticket', 'js-support-ticket'); ?></a></span>
        <span class="js-email-menu-link <?php if (jssupportticket::$_data[1] == 'ew-md') echo 'selected'; ?>"><a class="js-email-link" href="?page=emailtemplate&for=ew-md"><?php echo __('New Department', 'js-support-ticket'); ?></a></span>
        <span class="js-email-menu-link <?php if (jssupportticket::$_data[1] == 'ew-sm') echo 'selected'; ?>"><a class="js-email-link" href="?page=emailtemplate&for=ew-sm"><?php echo __('New Staff', 'js-support-ticket'); ?></a></span>
        <span class="js-email-menu-link <?php if (jssupportticket::$_data[1] == 'ew-ht') echo 'selected'; ?>"><a class="js-email-link" href="?page=emailtemplate&for=ew-ht"><?php echo __('New Help Topic', 'js-support-ticket'); ?></a></span>
        <span class="js-email-menu-link <?php if (jssupportticket::$_data[1] == 'rs-tk') echo 'selected'; ?>"><a class="js-email-link" href="?page=emailtemplate&for=rs-tk"><?php echo __('Reassign Ticket', 'js-support-ticket'); ?></a></span>
        <span class="js-email-menu-link <?php if (jssupportticket::$_data[1] == 'cl-tk') echo 'selected'; ?>"><a class="js-email-link" href="?page=emailtemplate&for=cl-tk"><?php echo __('Close Ticket', 'js-support-ticket'); ?></a></span>
        <span class="js-email-menu-link <?php if (jssupportticket::$_data[1] == 'dl-tk') echo 'selected'; ?>"><a class="js-email-link" href="?page=emailtemplate&for=dl-tk"><?php echo __('Delete Ticket', 'js-support-ticket'); ?></a></span>
        <span class="js-email-menu-link <?php if (jssupportticket::$_data[1] == 'mo-tk') echo 'selected'; ?>"><a class="js-email-link" href="?page=emailtemplate&for=mo-tk"><?php echo __('Mark Overdue', 'js-support-ticket'); ?></a></span>
        <span class="js-email-menu-link <?php if (jssupportticket::$_data[1] == 'be-tk') echo 'selected'; ?>"><a class="js-email-link" href="?page=emailtemplate&for=be-tk"><?php echo __('Ban Email', 'js-support-ticket'); ?></a></span>
        <span class="js-email-menu-link <?php if (jssupportticket::$_data[1] == 'be-trtk') echo 'selected'; ?>"><a class="js-email-link" href="?page=emailtemplate&for=be-trtk"><?php echo __('Ban email try to create ticket', 'js-support-ticket'); ?></a></span>
        <span class="js-email-menu-link <?php if (jssupportticket::$_data[1] == 'dt-tk') echo 'selected'; ?>"><a class="js-email-link" href="?page=emailtemplate&for=dt-tk"><?php echo __('Department Transfer', 'js-support-ticket'); ?></a></span>
        <span class="js-email-menu-link <?php if (jssupportticket::$_data[1] == 'ebct-tk') echo 'selected'; ?>"><a class="js-email-link" href="?page=emailtemplate&for=ebct-tk"><?php echo __('Ban Email and Close Ticket', 'js-support-ticket'); ?></a></span>
        <span class="js-email-menu-link <?php if (jssupportticket::$_data[1] == 'ube-tk') echo 'selected'; ?>"><a class="js-email-link" href="?page=emailtemplate&for=ube-tk"><?php echo __('Unban Email', 'js-support-ticket'); ?></a></span>
        <span class="js-email-menu-link <?php if (jssupportticket::$_data[1] == 'rsp-tk') echo 'selected'; ?>"><a class="js-email-link" href="?page=emailtemplate&for=rsp-tk"><?php echo __('Response Ticket', 'js-support-ticket'); ?></a></span>
        <span class="js-email-menu-link <?php if (jssupportticket::$_data[1] == 'rpy-tk') echo 'selected'; ?>"><a class="js-email-link" href="?page=emailtemplate&for=rpy-tk"><?php echo __('Reply Ticket', 'js-support-ticket'); ?></a></span>
        <span class="js-email-menu-link <?php if (jssupportticket::$_data[1] == 'tk-ew-ad') echo 'selected'; ?>"><a class="js-email-link" href="?page=emailtemplate&for=tk-ew-ad"><?php echo __('New Ticket Admin Alert', 'js-support-ticket'); ?></a></span>
        <span class="js-email-menu-link <?php if (jssupportticket::$_data[1] == 'lk-tk') echo 'selected'; ?>"><a class="js-email-link" href="?page=emailtemplate&for=lk-tk"><?php echo __('Lock Ticket', 'js-support-ticket'); ?></a></span>
        <span class="js-email-menu-link <?php if (jssupportticket::$_data[1] == 'ulk-tk') echo 'selected'; ?>"><a class="js-email-link" href="?page=emailtemplate&for=ulk-tk"><?php echo __('Unlock Ticket', 'js-support-ticket'); ?></a></span>
        <span class="js-email-menu-link <?php if (jssupportticket::$_data[1] == 'minp-tk') echo 'selected'; ?>"><a class="js-email-link" href="?page=emailtemplate&for=minp-tk"><?php echo __('In Progress Ticket', 'js-support-ticket'); ?></a></span>
        <span class="js-email-menu-link <?php if (jssupportticket::$_data[1] == 'pc-tk') echo 'selected'; ?>"><a class="js-email-link" href="?page=emailtemplate&for=pc-tk"><?php echo __('Ticket Priority Is Changed By', 'js-support-ticket'); ?></a></span>
        <span class="js-email-menu-link <?php if (jssupportticket::$_data[1] == 'ml-ew') echo 'selected'; ?>"><a class="js-email-link" href="?page=emailtemplate&for=ml-ew"><?php echo __('New Mail Received', 'js-support-ticket'); ?></a></span>
        <span class="js-email-menu-link <?php if (jssupportticket::$_data[1] == 'ml-rp') echo 'selected'; ?>"><a class="js-email-link" href="?page=emailtemplate&for=ml-rp"><?php echo __('New Mail Message Received', 'js-support-ticket'); ?></a></span>
    </div>
    <div class="js-email-body">
        <div class="js-form-wrapper">
            <div class="a-js-form-title"><?php echo __('Subject', 'js-support-ticket'); ?></div>
            <div class="a-js-form-field"><?php echo JSSTformfield::text('subject', jssupportticket::$_data[0]->subject, array('class' => 'inputbox', 'style' => 'width:100%;')) ?></div>
        </div>
        <div class="js-form-wrapper">
            <div class="a-js-form-title"><?php echo __('Body', 'js-support-ticket'); ?></div>
            <div class="a-js-form-field"><?php echo wp_editor(jssupportticket::$_data[0]->body, 'body', array('media_buttons' => false)); ?></div>
        </div>
        <div class="js-email-parameters">
            <span class="js-email-parameter-heading"><?php echo __('Parameters', 'js-support-ticket') ?></span>
            <?php
            if (jssupportticket::$_data[1] == 'tk-nw') {
                ?>
                <span class="js-email-paramater">{USERNAME} : <?php echo __('Username', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{SUBJECT} : <?php echo __('Subject', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TRACKINGID} : <?php echo __('Tracking ID', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{HELP_TOPIC} : <?php echo __('Help Topic', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{EMAIL} : <?php echo __('Email', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{MESSAGE} : <?php echo __('Message', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TICKETURL} : <?php echo __('Ticket URL', 'js-support-ticket'); ?></span>
                <?php
            } elseif (jssupportticket::$_data[1] == 'sntk-tk') {
                ?>
                <span class="js-email-paramater">{USERNAME} : <?php echo __('Username', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{SUBJECT} : <?php echo __('Subject', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TRACKINGID} : <?php echo __('Tracking ID', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{HELP_TOPIC} : <?php echo __('Help Topic', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{EMAIL} : <?php echo __('Email', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{MESSAGE} : <?php echo __('Message', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TICKETURL} : <?php echo __('Ticket URL', 'js-support-ticket'); ?></span>
                <?php
            } elseif (jssupportticket::$_data[1] == 'ew-md') {
                ?>
                <span class="js-email-paramater">{DEPARTMENT_TITLE} : <?php echo __('Department title', 'js-support-ticket'); ?></span>
                <?php
            } elseif (jssupportticket::$_data[1] == 'ew-gr') {
                ?>
                <span class="js-email-paramater">{GROUP_TITLE} : <?php echo __('Group Title', 'js-support-ticket'); ?></span>
                <?php
            } elseif (jssupportticket::$_data[1] == 'ew-sm') {
                ?>
                <span class="js-email-paramater">{STAFF_MEMBER_NAME} : <?php echo __('Staff member name', 'js-support-ticket'); ?></span>
                <?php
            } elseif (jssupportticket::$_data[1] == 'ew-ht') {
                ?>
                <span class="js-email-paramater">{HELPTOPIC_TITLE} : <?php echo __('Help topic title', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{DEPARTMENT_TITLE} : <?php echo __('Department title', 'js-support-ticket'); ?></span>
                <?php
            } elseif (jssupportticket::$_data[1] == 'rs-tk') {
                ?>
                <span class="js-email-paramater">{SUBJECT} : <?php echo __('Subject', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TRACKINGID} : <?php echo __('Tracking ID', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{STAFF_MEMBER_NAME} : <?php echo __('Staff member name', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TICKETURL} : <?php echo __('Ticket URL', 'js-support-ticket'); ?></span>
                <?php
            } elseif (jssupportticket::$_data[1] == 'cl-tk') {
                ?>
                <span class="js-email-paramater">{SUBJECT} : <?php echo __('Subject', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TRACKINGID} : <?php echo __('Tracking ID', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TICKETURL} : <?php echo __('Ticket URL', 'js-support-ticket'); ?></span>
                <?php
            } elseif (jssupportticket::$_data[1] == 'dl-tk') {
                ?>
                <span class="js-email-paramater">{SUBJECT} : <?php echo __('Subject', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TRACKINGID} : <?php echo __('Tracking ID', 'js-support-ticket'); ?></span>
                <?php
            } elseif (jssupportticket::$_data[1] == 'mo-tk') {
                ?>
                <span class="js-email-paramater">{SUBJECT} : <?php echo __('Subject', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TRACKINGID} : <?php echo __('Tracking ID', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TICKETURL} : <?php echo __('Ticket URL', 'js-support-ticket'); ?></span>
                <?php
            } elseif (jssupportticket::$_data[1] == 'be-tk') {
                ?>
                <span class="js-email-paramater">{EMAIL_ADDRESS} : <?php echo __('Email Address', 'js-support-ticket'); ?></span>
                <?php
            } elseif (jssupportticket::$_data[1] == 'be-trtk') {
                ?>
                <span class="js-email-paramater">{EMAIL_ADDRESS} : <?php echo __('Email Address', 'js-support-ticket'); ?></span>
                <?php
            } elseif (jssupportticket::$_data[1] == 'dt-tk') {
                ?>
                <span class="js-email-paramater">{SUBJECT} : <?php echo __('Subject', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TRACKINGID} : <?php echo __('Tracking ID', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{DEPARTMENT_TITLE} : <?php echo __('Department title', 'js-support-ticket'); ?></span>
                <?php
            } elseif (jssupportticket::$_data[1] == 'ebct-tk') {
                ?>
                <span class="js-email-paramater">{SUBJECT} : <?php echo __('Subject', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{EMAIL_ADDRESS} : <?php echo __('Email Address', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TICKETID} : <?php echo __('Ticket ID', 'js-support-ticket'); ?></span>
                <?php
            } elseif (jssupportticket::$_data[1] == 'ube-tk') {
                ?>
                <span class="js-email-paramater">{EMAIL_ADDRESS} : <?php echo __('Email Address', 'js-support-ticket'); ?></span>
                <?php
            } elseif (jssupportticket::$_data[1] == 'rsp-tk') {
                ?>
                <span class="js-email-paramater">{USERNAME} : <?php echo __('Username', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{SUBJECT} : <?php echo __('Subject', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TRACKINGID} : <?php echo __('Tracking ID', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{EMAIL} : <?php echo __('Email', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{MESSAGE} : <?php echo __('Message', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TICKETURL} : <?php echo __('Ticket URL', 'js-support-ticket'); ?></span>
                <?php
            } elseif (jssupportticket::$_data[1] == 'rpy-tk') {
                ?>
                <span class="js-email-paramater">{USERNAME} : <?php echo __('Username', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{SUBJECT} : <?php echo __('Subject', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TRACKINGID} : <?php echo __('Tracking ID', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{EMAIL} : <?php echo __('Email', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{MESSAGE} : <?php echo __('Message', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TICKETURL} : <?php echo __('Ticket URL', 'js-support-ticket'); ?></span>
                <?php
            } elseif (jssupportticket::$_data[1] == 'tk-ew-ad') {
                ?>
                <span class="js-email-paramater">{USERNAME} : <?php echo __('Username', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{SUBJECT} : <?php echo __('Subject', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TRACKINGID} : <?php echo __('Tracking ID', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{EMAIL} : <?php echo __('Email', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{MESSAGE} : <?php echo __('Message', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TICKETURL} : <?php echo __('Ticket URL', 'js-support-ticket'); ?></span>
                <?php
            } elseif (jssupportticket::$_data[1] == 'lk-tk') {
                ?>
                <span class="js-email-paramater">{USERNAME} : <?php echo __('Username', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{SUBJECT} : <?php echo __('Subject', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TRACKINGID} : <?php echo __('Tracking ID', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{EMAIL} : <?php echo __('Email', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TICKETURL} : <?php echo __('Ticket URL', 'js-support-ticket'); ?></span>
                <?php
            } elseif (jssupportticket::$_data[1] == 'ulk-tk') {
                ?>
                <span class="js-email-paramater">{USERNAME} : <?php echo __('Username', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{SUBJECT} : <?php echo __('Subject', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TRACKINGID} : <?php echo __('Tracking ID', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{EMAIL} : <?php echo __('Email', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TICKETURL} : <?php echo __('Ticket URL', 'js-support-ticket'); ?></span>
                <?php
            } elseif (jssupportticket::$_data[1] == 'minp-tk') {
                ?>
                <span class="js-email-paramater">{SUBJECT} : <?php echo __('Subject', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TRACKINGID} : <?php echo __('Tracking ID', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TICKETURL} : <?php echo __('Ticket URL', 'js-support-ticket'); ?></span>
                <?php
            } elseif (jssupportticket::$_data[1] == 'pc-tk') {
                ?>
                <span class="js-email-paramater">{SUBJECT} : <?php echo __('Subject', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TRACKINGID} : <?php echo __('Tracking ID', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{PRIORITY_TITLE} : <?php echo __('Priority', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{TICKETURL} : <?php echo __('Ticket URL', 'js-support-ticket'); ?></span>
                <?php
            } elseif (jssupportticket::$_data[1] == 'ml-ew') {
                ?>
                <span class="js-email-paramater">{SUBJECT} : <?php echo __('Subject', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{STAFF_MEMBER_NAME} : <?php echo __('Staff member name', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{MESSAGE} : <?php echo __('Message', 'js-support-ticket'); ?></span>
                <?php
            } elseif (jssupportticket::$_data[1] == 'ml-rp') {
                ?>
                <span class="js-email-paramater">{SUBJECT} : <?php echo __('Subject', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{STAFF_MEMBER_NAME} : <?php echo __('Staff member name', 'js-support-ticket'); ?></span>
                <span class="js-email-paramater">{MESSAGE} : <?php echo __('Message', 'js-support-ticket'); ?></span>
                <?php
            }
            ?>
        </div>
        <div class="js-form-button">
            <?php echo JSSTformfield::submitbutton('save', __('Save email template', 'js-support-ticket'), array('class' => 'button')); ?>
        </div>			
    </div>
    <?php echo JSSTformfield::hidden('id', jssupportticket::$_data[0]->id); ?>
    <?php echo JSSTformfield::hidden('created', jssupportticket::$_data[0]->created); ?>
    <?php echo JSSTformfield::hidden('templatefor', jssupportticket::$_data[0]->templatefor); ?>
    <?php echo JSSTformfield::hidden('for', jssupportticket::$_data[1]); ?>
    <?php echo JSSTformfield::hidden('action', 'emailtemplate_saveemailtemplate'); ?>
    <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
</form>