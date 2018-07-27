<?php
if (jssupportticket::$_config['offline'] == 2) {
    if (jssupportticket::$_data['permission_granted'] == 1) {
        if (get_current_user_id() != 0) {
            if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                if (jssupportticket::$_data['staff_enabled']) {
                    ?>
                    <script type="text/javascript">
                        function resetFrom() {
                            document.getElementById('jsst-subject').value = '';
                            return true;
                        }
                    </script>
                    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
                    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>
                    <h1 class="js-ticket-heading"><?php echo __('Outbox', 'js-support-ticket') ?></h1>
                    <form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="GET" action="">
                        <?php echo "<input type='hidden' name='page_id' value='" . jssupportticket::getPageId() . "'/>"; ?>
                        <?php echo "<input type='hidden' name='jstmod' value='mail'/>"; ?>
                        <?php echo "<input type='hidden' name='jstlay' value='outbox'/>"; ?>
                        <div class="row js-filter-wrapper">
                            <div class="js-col-md-12">
                                <div class="js-col-md-12 js-filter-title">
                                    <?php echo __('Subject', 'js-support-ticket'); ?>
                                </div>
                                <div class="js-col-md-12 js-filter-value">
                                    <?php echo JSSTformfield::text('jsst-subject', JSSTrequest::getVar('jsst-subject'), array('placeholder' => __('Subject', 'js-support-ticket'))); ?>
                                </div>
                            </div>
                            <div class="js-col-md-12 js-filter-wrapper">
                                <div class="js-filter-button">
                                    <?php echo JSSTformfield::submitbutton('jsst-go', __('Search', 'js-support-ticket'), array('class' => 'button')); ?>
                                    <?php echo JSSTformfield::submitbutton('jsst-reset', __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'return resetFrom();')); ?>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
                    JSSTmessage::getMessage();
                    if (jssupportticket::$_data[0]['unreadmessages'] >= 1) {
                        $inbox = jssupportticket::$_data[0]['unreadmessages'];
                    } else {
                        $inbox = jssupportticket::$_data[0]['totalInboxboxmessages'];
                    }
                    ?>
                    <div class="js-filter-add-button">
                        <span><a class="js-add-link button" href="index.php?page_id=<?php echo jssupportticket::getPageid(); ?>&jstmod=mail&jstlay=inbox"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/inbox.png"><?php echo __('Inbox', 'js-support-ticket').' (';
                    echo $inbox;
                    echo ' )'; ?></a></span>
                        <span><a class="js-add-link button active" href="index.php?page_id=<?php echo jssupportticket::getPageid(); ?>&jstmod=mail&jstlay=outbox"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/outbox.png"><?php echo __('Outbox', 'js-support-ticket').' (';
                    echo jssupportticket::$_data[0]['outboxmessages'];
                    echo __(' )  ', 'js-support-ticket'); ?></a></span>
                        <span><a class="js-add-link button" href="index.php?page_id=<?php echo jssupportticket::getPageid(); ?>&jstmod=mail&jstlay=formmessage"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon2.png" /><?php echo __('Compose', 'js-support-ticket') ?></a></span>
                    </div>

                    <?php
                    if (!empty(jssupportticket::$_data[0]['outbox'])) {
                        ?>  		
                        <div class="js-filter-form-list">
                            <div class="js-filter-form-head js-filter-form-head-xs">
                                <div class="js-col-md-4 js-col-xs-12"><?php echo __('Subject', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-3 js-col-xs-12"><?php echo __('To', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-2 js-col-xs-12"><?php echo __('Created', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-3 js-col-xs-12"><?php echo __('Action', 'js-support-ticket'); ?></div>
                            </div>
                        <?php
                        foreach (jssupportticket::$_data[0]['outbox'] AS $inbox) {
                            ?>			
                                <div class="js-filter-form-data">
                                    <div class="js-col-md-4 js-col-xs-12" ><span class="js-filter-form-data-xs"><?php echo __('Subject', 'js-support-ticket');
                            echo " : "; ?></span><a href="index.php?page_id=<?php echo jssupportticket::getPageid(); ?>&jstmod=mail&jstlay=message&jssupportticketid=<?php echo $inbox->id; ?>"><?php echo $inbox->subject; ?></a></div>
                                    <div class="js-col-md-3 js-col-xs-12" ><span class="js-filter-form-data-xs"><?php echo __('To', 'js-support-ticket');
                            echo " : "; ?></span><?php echo $inbox->staffname ?></div>
                                    <div class="js-col-md-2 js-col-xs-12"><span class="js-filter-form-data-xs"><?php echo __('Created', 'js-support-ticket');
                            echo " : "; ?></span><?php echo date_i18n(jssupportticket::$_config['date_format'], strtotime($inbox->created)); ?></div>
                                    <div class="js-col-md-3 js-col-xs-12 js-filter-form-action-hl-xs">			     		
                                        <a onclick="return confirm('<?php echo __('Are you sure to delete', 'js-support-ticket'); ?>');" href="index.php?page_id=<?php echo jssupportticket::getPageid(); ?>&jstmod=mail&task=deletemail&action=jstask&mailid=<?php echo $inbox->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" /></a>
                                    </div>
                                </div>
                            <?php
                        }
                        ?>
                        </div>		
                        <?php
                        if (jssupportticket::$_data[1]) {
                            echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
                        }
                    } else { // Record Not FOund
                        JSSTlayout::getNoRecordFound();
                    }
                } else {
                    JSSTlayout::getStaffMemberDisable();
                }
            } else { // user not Staff
                JSSTlayout::getNotStaffMember();
            }
        } else {// User is guest
            $redirect_url = site_url('?page_id='.jssupportticket::getPageid().'&jstmod=mail&jstlay=outbox');
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