<?php
if (jssupportticket::$_config['offline'] == 2) {
    if (get_current_user_id() != 0 || jssupportticket::$_config['visitor_can_create_ticket'] == 1) {
        JSSTmessage::getMessage();
        ?>
        <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
        <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>
        <form class="js-ticket-form" action="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&task=showticketstatus"); ?>" method="post" id="adminForm" class="form-validate" enctype="multipart/form-data">
            <div class="js-col-md-6 js-form-wrapper">
                <div class="js-col-md-12 js-form-title"><label id="emailmsg" for="email"><?php echo __('Email', 'js-support-ticket'); ?></label>&nbsp;<font color="red">*</font></div>
                <div class="js-col-md-12 js-form-value"><input class="inputbox required validate-email" type="text" name="email" id="email" size="40" maxlength="255" value="<?php if (isset(jssupportticket::$_data['0']->email)) echo jssupportticket::$_data['0']->email; ?>" /></div>
            </div>                      
            <div class="js-col-md-6 js-form-wrapper">
                <div class="js-col-md-12 js-form-title"><label id="emailmsg" for="email"><?php echo __('Ticket ID', 'js-support-ticket'); ?></label>&nbsp;<font color="red">*</font></div>
                <div class="js-col-md-12 js-form-value"><input class="inputbox required" type="text" name="ticketid" id="ticketid" size="40" maxlength="255" value="" /></div>
            </div>                      
            <div class="js-form-button">
                <input class="tk_dft_btn" type="submit" name="submit_app" value="<?php echo __('View Ticket', 'js-support-ticket'); ?>" />
            </div>                      
            <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
            <?php echo JSSTformfield::hidden('checkstatus', 1); ?>
        </form>
        <?php
    }else {// User is guest
        $redirect_url = site_url('?page_id='.jssupportticket::getPageid().'&jstmod=ticket&jstlay=ticketstatus');
        $redirect_url = base64_encode($redirect_url);
        JSSTlayout::getUserGuest($redirect_url);
    }
} else { // System is offline
    JSSTlayout::getSystemOffline();
}
?>