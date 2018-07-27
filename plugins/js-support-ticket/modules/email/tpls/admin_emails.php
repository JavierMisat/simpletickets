<script type="text/javascript">
    function resetFrom() {
        document.getElementById('email').value = '';
        document.getElementById('jssupportticketform').submit();
    }
</script>
<?php JSSTmessage::getMessage(); ?>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('System Emails', 'js-support-ticket'); ?></span>
<a class="js-add-link button" href="?page=email&jstlay=addemail"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon.png" /><?php echo __('Add Email', 'js-support-ticket'); ?></a>
</span>
<span id="js-systemail" class="js-admin-infotitle"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/infoicon.png" /><?php echo __('System email used for sending email', 'js-support-ticket'); ?></span>
<form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="post" action="<?php echo admin_url("admin.php?page=email&jstlay=emails"); ?>">
    <?php echo JSSTformfield::text('email', jssupportticket::$_data['filter']['email'], array('placeholder' => __('Email', 'js-support-ticket'))); ?>
    <?php echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH'); ?>
    <?php echo JSSTformfield::submitbutton('go', __('Search', 'js-support-ticket'), array('class' => 'button')); ?>
    <?php echo JSSTformfield::button('reset', __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'resetFrom();')); ?>
</form>
<?php if (!empty(jssupportticket::$_data[0])) { ?>  		
    <div class="js-filter-form-list">
        <div class="js-filter-form-head js-filter-form-head-xs">
            <div class="js-col-xs-12 js-col-md-6 first"><?php echo __('Email Address', 'js-support-ticket'); ?></div>
            <div class="js-col-xs-12 js-col-md-2 js-textaligncenter second"><?php echo __('Autoresponse', 'js-support-ticket'); ?></div>
            <!-- <div class="js-col-xs-12 js-col-md-2 third"><?php /* echo __('Priority','js-support-ticket'); */ ?></div> -->
            <div class="js-col-xs-12 js-col-md-2 fourth"><?php echo __('Created', 'js-support-ticket'); ?></div>
            <div class="js-col-xs-12 js-col-md-2 fifth"><?php echo __('Action', 'js-support-ticket'); ?></div>
        </div>
        <?php
        foreach (jssupportticket::$_data[0] AS $email) {
            $autoresponse = ($email->autoresponse == 1) ? 'yes.png' : 'no.png';
            ?>			
            <div class="js-filter-form-data">
                <div class="js-col-xs-12 js-col-md-6 first"><span class="js-filter-form-data-xs"><?php echo __('Email Address', 'js-support-ticket');
        echo " : "; ?></span><a href="?page=email&jstlay=addemail&jssupportticketid=<?php echo $email->id; ?>"><?php echo $email->email; ?></a></div>
                <div class="js-col-xs-12 js-col-md-2 js-textaligncenter  second"><span class="js-filter-form-data-xs"><?php echo __('Autoresponse', 'js-support-ticket');
        echo " : "; ?></span><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/<?php echo $autoresponse; ?>" /></div>
                <!-- <div class="js-col-xs-12 js-col-md-2 third"><span class="js-filter-form-data-xs"><?php /* echo __('Priority','js-support-ticket');echo " : "; ?></span><?php echo $email->priority; */ ?></div> -->
                <div class="js-col-xs-12 js-col-md-2 fourth"><span class="js-filter-form-data-xs"><?php echo __('Created', 'js-support-ticket');
        echo " : "; ?></span><?php echo date_i18n(jssupportticket::$_config['date_format'], strtotime($email->created)); ?></div>
                <div class="js-col-xs-12 js-col-md-2 fifth js-filter-form-action-hl-xs">
                    <a href="?page=email&jstlay=addemail&jssupportticketid=<?php echo $email->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit.png" /></a>
                    <a onclick="return confirm('<?php echo __('Are you sure to delete', 'js-support-ticket'); ?>');" href="?page=email&task=deleteemail&action=jstask&emailid=<?php echo $email->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" /></a>
                </div>
            </div>
        <?php }
    ?>
    </div>
    <?php
    if (jssupportticket::$_data[1]) {
        echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
    }
} else {// User is guest
    JSSTlayout::getNoRecordFound();
}
?>
