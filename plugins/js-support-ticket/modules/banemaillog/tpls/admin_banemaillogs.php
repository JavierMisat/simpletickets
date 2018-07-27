<script type="text/javascript">
    function resetFrom() {
        document.getElementById('loggeremail').value = '';
        document.getElementById('jssupportticketform').submit();
    }
</script>
<?php JSSTmessage::getMessage(); ?>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Ban Email Log List', 'js-support-ticket') ?></span></span>
<form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="post" action="<?php echo admin_url("admin.php?page=banemaillog&jstlay=banemaillogs"); ?>">
    <?php echo JSSTformfield::text('loggeremail', jssupportticket::$_data['filter']['loggeremail'], array('placeholder' => __('Logger Email', 'js-support-ticket'))); ?>
    <?php echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH'); ?>
    <?php echo JSSTformfield::submitbutton('go', __('Search', 'js-support-ticket'), array('class' => 'button')); ?>
    <?php echo JSSTformfield::button('reset', __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'resetFrom();')); ?>
</form>
<?php if (!empty(jssupportticket::$_data[0])) { ?>  		
    <div class="js-filter-form-list">
        <div class="js-filter-form-head js-filter-form-head-xs">
            <div class="js-col-md-2 js-col-xs-12 first"><?php echo __('Title', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 js-col-xs-12 second js-textaligncenter"><?php echo __('Log', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 js-col-xs-12 third js-textaligncenter"><?php echo __('Logger', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 js-col-xs-12 fourth js-textaligncenter"><?php echo __('Logger Email', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 js-col-xs-12 fifth"><?php echo __('IP Address', 'js-support-ticket'); ?></div>
            <div class="js-col-md-1 js-col-xs-12 sixth"><?php echo __('Created', 'js-support-ticket'); ?></div>
            <div class="js-col-md-1 js-col-xs-12 seventh"><?php echo __('Action', 'js-support-ticket'); ?></div>
        </div>
        <?php
        foreach (jssupportticket::$_data[0] AS $email) {
            ?>			
            <div class="js-filter-form-data">
                <div class="js-col-md-2 js-col-xs-12 first"><span class="js-filter-form-data-xs"><?php echo __('Title', 'js-support-ticket');
        echo " : "; ?></span><?php echo $email->title; ?></div>
                <div class="js-col-md-2 js-col-xs-12 second js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Log', 'js-support-ticket');
        echo " : "; ?></span><?php echo $email->log; ?></div>
                <div class="js-col-md-2 js-col-xs-12 third js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Logger', 'js-support-ticket');
        echo " : "; ?></span> <?php echo $email->logger; ?></div>
                <div class="js-col-md-2 js-col-xs-12 fourth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Logger Email', 'js-support-ticket');
        echo " : "; ?></span><?php echo $email->loggeremail; ?></div>
                <div class="js-col-md-2 js-col-xs-12 fifth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('IP Address', 'js-support-ticket');
        echo " : "; ?></span><?php echo $email->ipaddress; ?></div>
                <div class="js-col-md-1 js-col-xs-12 sixth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Created', 'js-support-ticket');
        echo " : "; ?></span><?php echo date_i18n(jssupportticket::$_config['date_format'], strtotime($email->created)); ?></div>
                <div class="js-col-md-1 js-col-xs-12 seventh js-filter-form-action-hl-xs">
                    <a onclick="return confirm('<?php echo __('Are you sure to delete', 'js-support-ticket'); ?>');" href="?page=banemaillog&task=deletebanemaillog&action=jstask&banemaillogid=<?php echo $email->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" /></a>
                </div>
            </div>

        <?php }
    ?>
    </div>
    <?php
    if (jssupportticket::$_data[1]) {
        echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
    }
} else {
    JSSTlayout::getNoRecordFound();
}
?>
