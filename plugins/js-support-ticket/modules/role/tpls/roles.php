<?php
if (jssupportticket::$_config['offline'] == 2) {
    if (jssupportticket::$_data['permission_granted'] == 1) {
        if (get_current_user_id() != 0) {
            if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                if (jssupportticket::$_data['staff_enabled']) {
                    ?>
                    <script type="text/javascript">
                        function resetFrom() {
                            document.getElementById('jsst-role').value = '';
                            return true;
                        }
                        function addSpaces() {
                            document.getElementById('jsst-role').value = fillSpaces(document.getElementById('jsst-role').value);
                            return true;
                        }
                    </script>
                    <?php JSSTmessage::getMessage(); ?>
                    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
                    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>

                    <h1 class="js-ticket-heading"><?php echo __('Roles', 'js-support-ticket') ?>
                        <a href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=role&jstlay=addrole"); ?> "><?php echo __('Add Role', 'js-support-ticket') ?></a>	 		

                    </h1>
                    <form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="GET" action="">
                        <?php echo "<input type='hidden' name='page_id' value='" . jssupportticket::getPageId() . "'/>"; ?>
                        <?php echo "<input type='hidden' name='jstmod' value='role'/>"; ?>
                        <?php echo "<input type='hidden' name='jstlay' value='roles'/>"; ?>
                        <div class="row js-filter-wrapper">
                            <div class="js-col-md-12 js-filter-wrapper">
                                <div class="js-col-md-12 js-filter-title"><?php echo __('Name', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-12 js-filter-value"><?php echo JSSTformfield::text('jsst-role', jssupportticket::parseSpaces(JSSTrequest::getVar('jsst-role')), array('placeholder' => __('Name', 'js-support-ticket'))); ?></div>
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
                                <div class="js-col-md-6 first"><?php echo __('Name', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-4 second"><?php echo __('Permissions', 'js-support-ticket'); ?></div>
                                <div  class="js-col-md-2 third"><?php echo __('Action', 'js-support-ticket'); ?></div>
                            </div>
                            <?php
                            if (!empty(jssupportticket::$_data[0])) {
                                foreach (jssupportticket::$_data[0] AS $role) {
                                    $status = ( isset($role->status) == 1 ) ? 'yes.png' : 'no.png';
                                    ?>			
                                    <div class="js-filter-form-data">
                                        <div class="js-col-xs-12 js-col-md-6 first"><span class="js-filter-form-data-xs"><?php echo __('Name', 'js-support-ticket');
                                echo " : "; ?></span><a href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=role&jstlay=addrole&jssupportticketid=" . $role->id); ?>"><?php echo $role->name; ?></a></div>
                                        <div class="js-col-xs-12 js-col-md-4 second"><span class="js-filter-form-data-xs"><?php echo __('Permissions', 'js-support-ticket');
                                echo " : "; ?></span><a href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=role&jstlay=rolepermission&jssupportticketid=" . $role->id); ?>"><?php echo __('Permissions', 'js-support-ticket'); ?></a></div>
                                        <div class="js-col-xs-12 js-col-md-2 third js-filter-form-action-hl-xs">
                                            <a href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=role&jstlay=addrole&jssupportticketid=" . $role->id); ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit.png" /></a>&nbsp;&nbsp;  
                                            <a onclick="return confirm('<?php echo __('Are you sure to delete', 'js-support-ticket'); ?>');" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=role&task=deleterole&action=jstask&roleid=" . $role->id); ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" /></a>
                                        </div>
                                    </div>
                                    <?php
                                }
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
            $redirect_url = site_url('?page_id='.jssupportticket::getPageid().'&jstmod=role&jstlay=roles');
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