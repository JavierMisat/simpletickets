<?php
if (jssupportticket::$_config['offline'] == 2) {
    if (jssupportticket::$_data['permission_granted'] == 1) {
        if (get_current_user_id() != 0) {
            if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                if (jssupportticket::$_data['staff_enabled']) {
                    wp_enqueue_script('formvalidate.js', jssupportticket::$_pluginpath . 'includes/js/jquery.form-validator.js');
                    ?>
                    <?php
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
                    <h1 class="js-ticket-heading"><?php echo __('Add FAQ', 'js-support-ticket') ?>
                    </h1>
                    <form class="js-ticket-form" method="post" action="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=faq&task=savefaq"); ?>">
                        <div class="js-col-md-12 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('Subject', 'js-support-ticket'); ?>&nbsp;<font color="red">*</font></div>
                            <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::text('subject', isset(jssupportticket::$_data[0]->subject) ? jssupportticket::$_data[0]->subject : '', array('class' => 'inputbox', 'data-validation' => 'required')) ?></div>
                        </div>
                        <div class="js-col-md-12 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('Parent Category', 'js-support-ticket'); ?></div>
                            <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::select('categoryid', JSSTincluder::getJSModel('knowledgebase')->getCategoryForCombobox('faqs'), isset(jssupportticket::$_data[0]->categoryid) ? jssupportticket::$_data[0]->categoryid : '', __('Select Category', 'js-support-ticket'), array('class' => 'inputbox', 'data-validation' => '')); ?></div>
                        </div>
                        <div class="js-col-md-12 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('Content', 'js-support-ticket'); ?></div>
                            <div class="js-col-md-12 js-form-value"><?php echo wp_editor(isset(jssupportticket::$_data[0]->content) ? jssupportticket::$_data[0]->content : '', 'faqcontent', array('media_buttons' => false)); ?></div>
                        </div>
                        <div class="js-col-md-4 js-form-wrapper">
                            <div class="js-col-md-12 js-form-title"><?php echo __('Status', 'js-support-ticket'); ?></div>
                            <div class="js-col-md-12 js-form-value"><?php echo JSSTformfield::select('status', $status, isset(jssupportticket::$_data[0]->status) ? jssupportticket::$_data[0]->status : '', __('Select Status', 'js-support-ticket'), array('class' => 'inputbox')); ?></div>
                        </div>
                        <?php echo JSSTformfield::hidden('id', isset(jssupportticket::$_data[0]->id) ? jssupportticket::$_data[0]->id : ''); ?>
                        <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]->created) ? jssupportticket::$_data[0]->created : '' ); ?>
                        <?php echo JSSTformfield::hidden('ordering', isset(jssupportticket::$_data[0]->ordering) ? jssupportticket::$_data[0]->ordering : '' ); ?>
                        <?php echo JSSTformfield::hidden('action', 'faq_savefaq'); ?>
                        <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
                        <div class="js-form-button">
                            <?php echo JSSTformfield::submitbutton('save', __('Save FAQ', 'js-support-ticket'), array('class' => 'button')); ?>
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
            $redirect_url = site_url('?page_id='.jssupportticket::getPageid().'&jstmod=faq&jstlay=addfaq');
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