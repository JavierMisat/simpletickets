<?php
if (jssupportticket::$_config['offline'] == 2) {
    ?>
    <?php JSSTmessage::getMessage(); ?>
    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>
    <h1 class="js-ticket-heading"><?php echo __('FAQ Detail', 'js-support-ticket') ?>
    </h1>
    <?php if (jssupportticket::$_data[0]['faqdetails']) { ?>
        <div class="js-col-md-12 js-ticket-head-details">
            <?php echo jssupportticket::$_data[0]['faqdetails']->subject; ?>
        </div>
        <div class="js-col-md-12">
            <div class="js-col-md-12 js-ticket-details">
                <?php echo jssupportticket::$_data[0]['faqdetails']->content; ?>
            </div>
        </div>
        <?php
    } else {
        JSSTlayout::getNoRecordFound();
    }
} else {
    JSSTlayout::getSystemOffline();
} ?>