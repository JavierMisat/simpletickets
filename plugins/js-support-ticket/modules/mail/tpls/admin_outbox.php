<script type="text/javascript">
    function resetFrom() {
        document.getElementById('subject').value = '';
        document.getElementById('jssupportticketform').submit();
    }
</script>
<?php
JSSTmessage::getMessage();
if (jssupportticket::$_data[0]['unreadmessages'] >= 1) {
    $inbox = jssupportticket::$_data[0]['unreadmessages'];
} else {
    $inbox = jssupportticket::$_data[0]['totalInboxboxmessages'];
}
?>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=mail&jstlay=inbox');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Outbox', 'js-support-ticket') ?></span>
</span>
<form name="jssupportticketform" id="jssupportticketform" method="post" action="<?php echo admin_url("admin.php?page=mail&jstlay=outbox"); ?>">	
    <?php echo __('Subject', 'js-support-ticket'); ?>&nbsp;&nbsp;
    <?php echo JSSTformfield::text('subject', jssupportticket::$_data['filter']['subject'], array('placeholder' => __('Subject', 'js-support-ticket'))); ?>
    <?php echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH'); ?>
    <?php echo JSSTformfield::submitbutton('go', __('Search', 'js-support-ticket'), array('class' => 'button')); ?>
<?php echo JSSTformfield::button('reset', __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'resetFrom();')); ?>
</form>
<span><a class="js-add-link button" href="?page=mail&jstlay=inbox"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/inboxadmin.png"><?php echo __('Inbox', 'js-support-ticket').' (';
echo $inbox;
echo ' )'; ?></a></span>
<span><a class="js-add-link button active" href="?page=mail&jstlay=outbox"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/outboxadmin.png"><?php echo __('Outbox', 'js-support-ticket').' (';
    echo jssupportticket::$_data[0]['outboxmessages'];
    echo __(' )  ', 'js-support-ticket'); ?></a></span></span>
<span><a class="js-add-link button" href="?page=mail&jstlay=formmessage"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon.png" /><?php echo __('Compose', 'js-support-ticket') ?></a>

<?php
if (!empty(jssupportticket::$_data[0]['outbox'])) {
    ?>  		
        <div class="js-filter-form-list">
            <div class="js-filter-form-head js-filter-form-head-xs">
                <div class="js-col-md-4 js-col-xs-12 first"><?php echo __('Subject', 'js-support-ticket'); ?></div>
                <div class="js-col-md-3 js-col-xs-12 second js-textaligncenter"><?php echo __('To', 'js-support-ticket'); ?></div>
                <div class="js-col-md-2 js-col-xs-12 third js-textaligncenter"><?php echo __('Created', 'js-support-ticket'); ?></div>
                <div class="js-col-md-3 js-col-xs-12 seventh"><?php echo __('Action', 'js-support-ticket'); ?></div>
            </div>			

    <?php
    foreach (jssupportticket::$_data[0]['outbox'] AS $inbox) {
        ?>			
                <div class="js-filter-form-data">
                    <div class="js-col-md-4 js-col-xs-12 first"><span class="js-filter-form-data-xs"><?php echo __('Subject', 'js-support-ticket');
        echo " : "; ?></span><a href="?page=mail&jstlay=message&jssupportticketid=<?php echo $inbox->id; ?>"><?php echo $inbox->subject; ?></a></div>
                    <div class="js-col-md-3 js-col-xs-12 second js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('To', 'js-support-ticket');
        echo " : "; ?></span><?php echo $inbox->staffname; ?></div>
                    <div class="js-col-md-2 js-col-xs-12 third js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Created', 'js-support-ticket');
        echo " : "; ?></span><?php echo date_i18n(jssupportticket::$_config['date_format'], strtotime($inbox->created)); ?></div>
                    <div class="js-col-md-3 js-col-xs-12 seventh js-filter-form-action-hl-xs">
                        <a href="?page=mail&jstlay=message&jssupportticketid=<?php echo $inbox->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit.png" /></a>&nbsp;&nbsp;
                        <a onclick="return confirm('<?php echo __('Are you sure to delete', 'js-support-ticket'); ?>');" href="?page=mail&task=deletemail&action=jstask&mailid=<?php echo $inbox->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" /></a>
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
    } else {
        JSSTlayout::getNoRecordFound();
    }
    ?>
