<?php
if (jssupportticket::$_config['offline'] == 2) {
    if (jssupportticket::$_data['permission_granted'] == 1) {
        if (get_current_user_id() != 0) {
            if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                if (jssupportticket::$_data['staff_enabled']) {
                    wp_enqueue_script('formvalidate.js', jssupportticket::$_pluginpath . 'includes/js/jquery.form-validator.js');
                    ?>
                    <?php
                    $type = array((object) array('id' => '1', 'text' => __('Public', 'js-support-ticket')),
                        (object) array('id' => '0', 'text' => __('Private', 'js-support-ticket'))
                    );
                    $status = array((object) array('id' => '1', 'text' => __('Enabled', 'js-support-ticket')),
                        (object) array('id' => '0', 'text' => __('Disabled', 'js-support-ticket'))
                    );
                    ?>
                    <script type="text/javascript">
                        jQuery(document).ready(function ($) {
                            $.validate();
                        });
                    </script>
                    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
                    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>

                    <h1 class="js-ticket-heading"><?php echo __('Add Department', 'js-support-ticket') ?></h1>
                    <form class="js-ticket-form" method="post" action="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=department&task=savedepartment"); ?>">
                        <div class="js-col-md-12 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('Title', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
                            <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::text('departmentname', isset(jssupportticket::$_data[0]->departmentname) ? jssupportticket::$_data[0]->departmentname : '', array('class' => 'inputbox', 'data-validation' => 'required')) ?></div>
                        </div>
                        <div class="js-col-md-12 js-form-wrapper leftrightnull">
                            <div class="js-col-md-6 js-form-wrapper">
                                <div class="js-col-md-12 js-form-title"><?php echo __('Type', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
                                <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::select('ispublic', $type, isset(jssupportticket::$_data[0]->ispublic) ? jssupportticket::$_data[0]->ispublic : '1', __('Select Type', 'js-support-ticket'), array('class' => 'inputbox', 'data-validation' => 'required')); ?></div>
                            </div>
                        </div>
                        <div class="js-col-md-12 js-form-wrapper leftrightnull">
                            <div class="js-col-md-6 js-form-wrapper">
                                <div class="js-col-md-12 js-form-title"><?php echo __('Outgoing Email', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font><small>&nbsp;&nbsp;(<?php echo __('User of this department will receive email on new ticket','js-support-ticket'); ?>)</small></div>
                                <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::select('emailid', JSSTincluder::getJSModel('email')->getEmailForDepartment(), isset(jssupportticket::$_data[0]->emailid) ? jssupportticket::$_data[0]->emailid : '', __('Select Email', 'js-support-ticket'), array('class' => 'inputbox', 'data-validation' => 'required')); ?></div>
                            </div>
                            <div class="js-col-md-6 js-form-wrapper">
                                <div class="js-col-md-12 js-form-title"><?php echo __('Receive Email', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::radiobutton('sendmail', array('1' => __('JYes', 'js-support-ticket'), '0' => __('JNo', 'js-support-ticket')), isset(jssupportticket::$_data[0]->sendmail) ? jssupportticket::$_data[0]->sendmail : '0', array('class' => 'radiobutton')); ?></div>
                            </div>                            
                        </div>
                        <div class="js-col-md-12 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title">
                                <?php echo __('Append Signature', 'js-support-ticket'); ?>
                            </div>
                            <div class="js-col-md-12 js-form-value">
                                <div class="js-form-value-signature">
                                    <?php echo JSSTformfield::checkbox('canappendsignature', array('1' => __('Append signature with reply', 'js-support-ticket')), isset(jssupportticket::$_data[0]->canappendsignature) ? jssupportticket::$_data[0]->canappendsignature : '', array('class' => 'radiobutton')); ?></div>
                            </div>
                        </div>
                        <div class="js-col-md-12 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('Signature', 'js-support-ticket'); ?></div>
                            <div class="js-col-md-12 js-form-value"><?php echo wp_editor(isset(jssupportticket::$_data[0]->departmentsignature) ? jssupportticket::$_data[0]->departmentsignature : '', 'departmentsignature', array('media_buttons' => false)); ?></div>
                        </div>

                        <div class="row js-form-wrapper">
                            <div class="js-col-md-6 js-form-wrapper">
                                <div class="js-col-md-12 js-form-title"><?php echo __('Status', 'js-support-ticket'); ?></div>
                                <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::select('status', $status, isset(jssupportticket::$_data[0]->status) ? jssupportticket::$_data[0]->status : '', __('Select Status', 'js-support-ticket'), array('class' => 'inputbox')); ?></div>
                            </div>
                        </div>
                        <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : ''); ?>
                        <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]->created) ? jssupportticket::$_data[0]->created : ''); ?>
                        <?php echo JSSTformfield::hidden('updated', isset(jssupportticket::$_data[0]->updated) ? jssupportticket::$_data[0]->updated : ''); ?>
                        <?php echo JSSTformfield::hidden('ordering', isset(jssupportticket::$_data[0]->ordering) ? jssupportticket::$_data[0]->ordering : ''); ?>
                        <?php echo JSSTformfield::hidden('action', 'department_savedepartment'); ?>
                        <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                        <div class="js-col-md-6 js-form-button">
                            <?php echo JSSTformfield::submitbutton('save', __('Save Department', 'js-support-ticket'), array('class' => 'button')); ?>
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
            $redirect_url = site_url('?page_id='.jssupportticket::getPageid().'&jstmod=department&jstlay=adddepartment');
            $redirect_url = base64_encode($redirect_url);
            JSSTlayout::getUserGuest($redirect_url);
        }
    } else { // User permission not granted
        JSSTlayout::getPermissionNotGranted();
    }
} else {
    JSSTlayout::getSystemOffline();
} ?>
