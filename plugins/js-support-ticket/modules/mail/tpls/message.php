<?php
if (jssupportticket::$_config['offline'] == 2) {
    if (jssupportticket::$_data['permission_granted'] == 1) {
        if (get_current_user_id() != 0) {
            if (JSSTincluder::getJSModel('staff')->isUserStaff()) {

                if (jssupportticket::$_data['staff_enabled']) {
                    ?>
                    <?php
                    JSSTmessage::getMessage();
                    if (jssupportticket::$_data[0]['unreadmessages'] >= 1) {
                        $inbox = jssupportticket::$_data[0]['unreadmessages'];
                    } else {
                        $inbox = jssupportticket::$_data[0]['totalInboxboxmessages'];
                    }
                    ?>
                    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
                    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>
                    <h1 class="js-ticket-heading"><?php echo __('Message', 'js-support-ticket') ?></h1>
                    <div class="js-filter-add-button">
                        <span><a class="js-add-link button" href="index.php?page_id=<?php echo jssupportticket::getPageid(); ?>&jstmod=mail&jstlay=inbox"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/inbox.png"><?php echo __('Inbox', 'js-support-ticket').' (';
                    echo $inbox;
                    echo ' )'; ?></a></span>
                        <span><a class="js-add-link button" href="index.php?page_id=<?php echo jssupportticket::getPageid(); ?>&jstmod=mail&jstlay=outbox"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/outbox.png"><?php echo __('Outbox', 'js-support-ticket').' (';
                    echo jssupportticket::$_data[0]['outboxmessages'];
                    echo __(' )  ', 'js-support-ticket'); ?></a></span>
                        <span><a class="js-add-link button" href="index.php?page_id=<?php echo jssupportticket::getPageid(); ?>&jstmod=mail&jstlay=formmessage"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon2.png" /><?php echo __('Compose', 'js-support-ticket') ?></a></span>
                    </div>
                    <h1 class="js-ticket-sub-heading"><?php echo __('Message', 'js-support-ticket'); ?></h1>
                    <div class="js-col-xs-3 js-col-md-2 js-ticket-thread-pic">
                        <span class="js-ticket-mail-subject"><?php echo __('Subject', 'js-support-ticket'); ?></span>
                    </div>
                    <div class="js-col-xs-9 js-col-md-10 js-ticket-thread-wrapper colored">
                        <span class="js-ticket-mail-subject-data"> <?php echo jssupportticket::$_data[0]['message']->subject; ?></span>    
                    </div>

                    <div class="js-col-xs-3 js-col-md-2 js-ticket-thread-pic">
                    <?php if (jssupportticket::$_data[0]['message']->staffphoto) {
                        $maindir = wp_upload_dir();
                        $path = $maindir['baseurl'];

                     ?>
                            <img  src="<?php echo $path ."/". jssupportticket::$_config['data_directory'] . "/staffdata/staff_" . jssupportticket::$_data[0]['message']->staffphotoid . "/" . jssupportticket::$_data[0]['message']->staffphoto; ?>">
                    <?php } else { ?>
                            <img src="<?php echo jssupportticket::$_pluginpath . '/includes/images/ticketmanbig.png'; ?>" />
                    <?php } ?>
                    </div>
                    <div class="js-col-xs-9 js-col-md-10 js-ticket-thread-wrapper colored">
                        <div class="js-ticket-detail-corner"></div>
                        <div class="js-ticket-thread-upperpart">
                            <span class="js-ticket-thread-replied"><?php echo __('Replied By', 'js-support-ticket'); ?></span>
                            <span class="js-ticket-thread-person"><?php echo isset(jssupportticket::$_data[0]['message']->staffname) ? jssupportticket::$_data[0]['message']->staffname : ''; ?></span>
                            <span class="js-ticket-thread-date">(&nbsp;<?php echo date_i18n("l F d, Y, h:i:s", strtotime(jssupportticket::$_data[0]['message']->created)); ?>&nbsp;)</span>
                        </div>
                        <div class="js-ticket-thread-middlepart">
                        <?php echo jssupportticket::$_data[0]['message']->message; ?>
                        </div>
                        <?php
                        if (!empty(jssupportticket::$_data['ticket_attachment'])) {
                            $datadirectory = jssupportticket::$_config['data_directory'];
                            $maindir = wp_upload_dir();
                            $path = $maindir['baseurl'];
                            $path = $path.'/' . $datadirectory;
                            $path = $path . '/attachmentdata';
                            $path = $path . '/ticket/ticket_' . jssupportticket::$_data[0]->id . '/';
                            foreach (jssupportticket::$_data['ticket_attachment'] AS $attachment) {
                                echo '
                  <div class="js_ticketattachment">
                    ' . $attachment->filename . ' ( ' . $attachment->filesize . ' ) ' . '              
                    <a class="button" target="_blank" href="' . site_url($path . $attachment->filename) . '">' . __('Download', 'js-support-ticket') . '</a>
                  </div>';
                            }
                        }
                        ?>
                    </div>
                        <?php if (!empty(jssupportticket::$_data[0]['replies'])) { ?>
                        <h1 class="js-ticket-sub-heading"><?php echo __('Replies', 'js-support-ticket'); ?></h1>
                            <?php foreach (jssupportticket::$_data[0]['replies'] AS $reply) { ?>
                            <div class="js-col-xs-3 js-col-md-2 js-ticket-thread-pic"> 
                                <?php if ($reply->staffphoto) {
                                    $maindir = wp_upload_dir();
                                    $path = $maindir['baseurl'];
                                 ?>
                                    <img  src="<?php echo $path."/". jssupportticket::$_config['data_directory'] . "/staffdata/staff_" . $reply->staffphotoid . "/" . $reply->staffphoto; ?>">
                                <?php } else { ?>
                                    <img src="<?php echo jssupportticket::$_pluginpath . '/includes/images/ticketmanbig.png'; ?>" />
                            <?php } ?>
                            </div>
                            <div class="js-col-xs-9 js-col-md-10 js-ticket-thread-wrapper colored">
                                <div class="js-ticket-detail-corner"></div>
                                <div class="js-ticket-thread-upperpart">
                                    <span class="js-ticket-thread-replied"><?php echo __('Replied By', 'js-support-ticket'); ?></span>
                                    <span class="js-ticket-thread-person"><?php echo $reply->staffname; ?></span>
                                    <span class="js-ticket-thread-date">(&nbsp;<?php echo date_i18n("l F d, Y, h:i:s", strtotime($reply->created)); ?>&nbsp;)</span>
                                </div>
                                <div class="js-ticket-thread-middlepart">
                            <?php echo $reply->message; ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <h1 class="js-ticket-sub-heading"><?php echo __('Reply', 'js-support-ticket'); ?></h1>
                    <form method="post" action="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=mail&task=savereply"); ?>">  
                        <div id="postreply">
                            <div class="js-form-wrapper">
                                <div class="js-form-title"><label id="responcemsg" for="responce"><?php echo __('Reply', 'js-support-ticket'); ?><font color="red">*</font></label></div>
                                <div class="js-form-field"><?php echo wp_editor('', 'message', array('media_buttons' => false)); ?></div>
                            </div>
                        </div>
                        <?php echo JSSTformfield::hidden('jssupportticketid', jssupportticket::$_data[0]['message']->id); ?>
                        <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]['replies']->created) ? jssupportticket::$_data[0]['replies']->created : ''); ?>
                        <?php echo JSSTformfield::hidden('isread', 2); ?>
                        <?php echo JSSTformfield::hidden('status', 1); ?>
                        <?php echo JSSTformfield::hidden('replytoid', isset(jssupportticket::$_data[0]['message']->id) ? jssupportticket::$_data[0]['message']->id : ''); ?>
                        <?php echo JSSTformfield::hidden('from', JSSTincluder::getJSModel('staff')->getStaffId(get_current_user_id())); ?>
                            <?php echo JSSTformfield::hidden('action', 'mail_savereply'); ?>
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
        } else {// User is guest
            $redirect_url = site_url('?page_id='.jssupportticket::getPageid().'&jstmod=mail&jstlay=message');
            $redirect_url = base64_encode($redirect_url);
            JSSTlayout::getUserGuest($redirect_url);
        }
    } else { // User permission not granted
        JSSTlayout::getPermissionNotGranted();
    }
} else { // System is offline
    JSSTlayout::getSystemOffline();
}
?>