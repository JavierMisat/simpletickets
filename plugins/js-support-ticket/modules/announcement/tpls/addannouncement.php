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
                        (object) array('id' => '2', 'text' => __('Private', 'js-support-ticket'))
                    );
                    $status = array((object) array('id' => '1', 'text' => __('Active', 'js-support-ticket')),
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
                    <h1 class="js-ticket-heading"><?php echo __('Add Announcement', 'js-support-ticket') ?></h1>
                    <form class="js-ticket-form" method="post" action="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=announcement&task=saveannouncement"); ?>" enctype="multipart/form-data" >
                        <div class="js-col-md-12 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('Title', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
                            <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::text('title', isset(jssupportticket::$_data[0]->title) ? jssupportticket::$_data[0]->title : '', array('class' => 'inputbox', 'data-validation' => 'required')) ?></div>

                        </div>
                        <div class="js-col-md-6 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('Parent Category', 'js-support-ticket'); ?></div>
                            <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::select('categoryid', JSSTincluder::getJSModel('knowledgebase')->getCategoryForCombobox('announcement'), isset(jssupportticket::$_data[0]->categoryid) ? jssupportticket::$_data[0]->categoryid : '', __('Select Category', 'js-support-ticket'), array('class' => 'inputbox', 'data-validation' => '')); ?></div>
                        </div>
                        <div class="js-col-md-6 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('Type', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
                            <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::select('type', $type, isset(jssupportticket::$_data[0]->type) ? jssupportticket::$_data[0]->type : '', __('Select Type', 'js-support-ticket'), array('class' => 'inputbox', 'data-validation' => 'required')); ?></div>
                        </div>
                        <div class="js-col-md-12 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('Description', 'js-support-ticket'); ?></div>
                            <div class="js-col-md-12 js-form-value"><?php echo wp_editor(isset(jssupportticket::$_data[0]->description) ? jssupportticket::$_data[0]->description : '', 'description', array('media_buttons' => false)); ?></div>
                        </div>
                        <div class="js-col-md-4 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('Status', 'js-support-ticket'); ?></div>
                            <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::select('status', $status, isset(jssupportticket::$_data[0]->status) ? jssupportticket::$_data[0]->status : '', __('Select Status', 'js-support-ticket'), array('class' => 'inputbox')); ?></div>
                        </div>
                        <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : '' ); ?>
                        <?php echo JSSTformfield::hidden('ordering', isset(jssupportticket::$_data[0]->ordering) ? jssupportticket::$_data[0]->ordering : '' ); ?>
                        <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]->created) ? jssupportticket::$_data[0]->created : ''); ?>
                        <?php echo JSSTformfield::hidden('action', 'announcement_saveannouncement'); ?>
                        <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                        <div class="js-col-md-12 js-form-button">
                            <?php echo JSSTformfield::submitbutton('save', __('Save Announcement', 'js-support-ticket'), array('class' => 'button')); ?>
                        </div>
                    </form>
                    <?php
                } else {
                    JSSTlayout::getStaffMemberDisable();
                }
            } else {
                JSSTlayout::getNotStaffMember();
            }
        } else {
            $redirect_url = site_url('?page_id='.jssupportticket::getPageid().'&jstmod=announcement&jstlay=addannouncement');
            $redirect_url = base64_encode($redirect_url);
            JSSTlayout::getUserGuest($redirect_url);
        }
    } else { // User permission not granted
        JSSTlayout::getPermissionNotGranted();
    }
} else {
    JSSTlayout::getSystemOffline();
} ?>