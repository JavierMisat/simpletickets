<?php
if (jssupportticket::$_config['offline'] == 2) {
    if (jssupportticket::$_data['permission_granted'] == 1) {
        if (get_current_user_id() != 0) {
            if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                if (jssupportticket::$_data['staff_enabled']) {
                    ?>
                    <script type="text/javascript">
                        function resetFrom() {
                            document.getElementById('jsst-name').value = '';
                            document.getElementById('jsst-status').value = '';
                            document.getElementById('jsst-role').value = '';
                            return true;
                        }
                        function addSpaces() {
                            document.getElementById('jsst-name').value = fillSpaces(document.getElementById('jsst-name').value);
                            return true;
                        }
                    </script>
                    <?php
                    $status = array(
                        (object) array('id' => '1', 'text' => __('Active', 'js-support-ticket')),
                        (object) array('id' => '2', 'text' => __('Disabled', 'js-support-ticket'))
                    );
                    ?>
                    <?php JSSTmessage::getMessage(); ?>
                    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
                    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>
                    <h1 class="js-ticket-heading"><?php echo __('Staff Members', 'js-support-ticket') ?>
                        <a href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=staff&jstlay=addstaff"); ?> "><?php echo __('Add Staff Member', 'js-support-ticket') ?></a>
                    </h1>
                    <form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="GET" action="">
                        <?php echo "<input type='hidden' name='page_id' value='" . jssupportticket::getPageId() . "'/>"; ?>
                        <?php echo "<input type='hidden' name='jstmod' value='staff'/>"; ?>
                        <?php echo "<input type='hidden' name='jstlay' value='staffs'/>"; ?>
                        <div class="row js-filter-wrapper">
                            <div class="js-col-md-4 js-filter-wrapper">
                                <div class="js-col-md-12 js-filter-title"><?php echo __('Username', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-12 js-filter-value"><?php echo JSSTformfield::text('jsst-name', jssupportticket::parseSpaces(JSSTrequest::getVar('jsst-name')), array('placeholder' => __('Username', 'js-support-ticket'))); ?></div>
                            </div>
                            <div class="js-col-md-4 js-filter-wrapper">
                                <div class="js-col-md-12 js-filter-title"><?php echo __('Status', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-12 js-filter-value"><?php echo JSSTformfield::select('jsst-status', $status, JSSTrequest::getVar('jsst-status'), __('Select Status', 'js-support-ticket'), array('class' => 'inputbox')); ?></div>
                            </div>
                            <div class="js-col-md-4 js-filter-wrapper">
                                <div class="js-col-md-12 js-filter-title"><?php echo __('Roles', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-12 js-filter-value"><?php echo JSSTformfield::select('jsst-role', JSSTincluder::getJSModel('role')->getRolesForCombobox(), JSSTrequest::getVar('jsst-role'), __('Select Role', 'js-support-ticket'), array('class' => 'inputbox')); ?></div>
                            </div>
                            <div class="js-col-md-12 js-filter-wrapper">
                                <div class="js-filter-button">
                                    <?php echo JSSTformfield::submitbutton('jsst-go', __('Search', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'return addSpaces();')); ?>
                                    <?php echo JSSTformfield::submitbutton('jsst-reset', __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'return resetFrom();')); ?>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
                    if (!empty(jssupportticket::$_data[0])) {
                        ?>  		
                        <div class="js-filter-form-list">
                            <div class="js-filter-form-head js-filter-form-head-xs">
                                <div class="js-col-md-3 first"><?php echo __('Full Name', 'js-support-ticket'); ?></div>
                                <!-- <div class="js-col-md-2 second"><?php echo __('Username', 'js-support-ticket'); ?></div> -->
                                <div class="js-col-md-2 third"><?php echo __('Role', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-1 fourth js-textaligncenter"><?php echo __('Status', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-2 fifth js-textaligncenter"><?php echo __('Created', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-2 sixth js-textaligncenter"><?php echo __('Permissions', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-2 seventh"><?php echo __('Action', 'js-support-ticket'); ?></div>
                            </div>
                            <?php
                            foreach (jssupportticket::$_data[0] AS $staff) {
                                $status = ($staff->status == 1) ? 'yes.png' : 'no.png';
                                $fullname = $staff->firstname . '  ' . $staff->lastname;
                                ?>			
                                <div class="js-filter-form-data">
                                    <div class="js-col-xs-12 js-col-md-3 first"><span class="js-filter-form-data-xs"><?php echo __('Full Name', 'js-support-ticket');
                            echo " : "; ?></span><a href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=staff&jstlay=addstaff&jssupportticketid=" . $staff->id); ?>"><?php echo $fullname; ?></a></div>
                            <!-- <div class="js-col-xs-12 js-col-md-2 second"><span class="js-filter-form-data-xs"><?php echo __('Username', 'js-support-ticket');
                            echo " : "; ?></span><?php echo $staff->username; ?></div> -->
                                    <div class="js-col-xs-12 js-col-md-2 third"><span class="js-filter-form-data-xs"><?php echo __('Role', 'js-support-ticket');
                            echo " : "; ?></span><?php echo $staff->rolename; ?></div>
                                    <div class="js-col-xs-12 js-col-md-1 fourth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Status', 'js-support-ticket');
                            echo " : "; ?></span><img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $status; ?>" /></div>
                                    <div class="js-col-xs-12 js-col-md-2 fifth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Created', 'js-support-ticket');
                            echo " : "; ?></span><?php echo date_i18n(jssupportticket::$_config['date_format'], strtotime($staff->created)); ?></div>
                                    <div class="js-col-xs-12 js-col-md-2 sixth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Permissions', 'js-support-ticket');
                            echo " : "; ?></span><a href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=staff&jstlay=staffpermissions&jssupportticketid=" . $staff->id); ?>"><?php echo __('Permissions', 'js-support-ticket'); ?></a></div>
                                    <div class="js-col-xs-12 js-col-md-2 seventh js-filter-form-action-hl-xs">
                                        <a href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=staff&jstlay=addstaff&jssupportticketid=" . $staff->id); ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit.png" /></a>
                                        <a onclick="return confirm('<?php echo __('Are you sure to delete', 'js-support-ticket'); ?>');" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=staff&task=deletestaff&action=jstask&staffid=" . $staff->id); ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" /></a>
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
            $redirect_url = site_url('?page_id='.jssupportticket::getPageid().'&jstmod=staff&jstlay=staffs');
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