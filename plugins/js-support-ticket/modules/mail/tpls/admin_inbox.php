<?php
wp_enqueue_script('jquery-ui-datepicker');
wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
?>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('.custom_date').datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });
    function resetFrom() {
        document.getElementById('subject').value = '';
        document.getElementById('jssupportticketform').submit();
    }
</script>
<?php
JSSTmessage::getMessage();
if (isset(jssupportticket::$_data[0]['unreadmessages']) && jssupportticket::$_data[0]['unreadmessages'] >= 1) {
    $inbox = jssupportticket::$_data[0]['unreadmessages'];
} else {
    $inbox = isset(jssupportticket::$_data[0]['totalInboxboxmessages']) ? jssupportticket::$_data[0]['totalInboxboxmessages'] : 0;
}
$type = array(
    (object) array('id' => '1', 'text' => __('Read', 'js-support-ticket')),
    (object) array('id' => '2', 'text' => __('Unread', 'js-support-ticket'))
);

?>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Inbox', 'js-support-ticket') ?></span>
</span>
<form  name="jssupportticketform" id="jssupportticketform" method="post" action="<?php echo admin_url("admin.php?page=mail&jstlay=inbox"); ?>">
    <?php echo __('Subject', 'js-support-ticket'); ?>&nbsp;&nbsp;
    <?php echo JSSTformfield::text('subject', isset(jssupportticket::$_data['filter']['subject']) ? jssupportticket::$_data['filter']['subject'] : '', array('placeholder' => __('Subject', 'js-support-ticket'))); ?>        
    <?php echo JSSTformfield::select('type', $type, isset(jssupportticket::$_data['filter']['type']) ? jssupportticket::$_data['filter']['type'] : '', __('Select Type', 'js-support-ticket'), array('class' => 'inputbox')); ?>
    <?php echo JSSTformfield::text('date_start', isset(jssupportticket::$_data['filter']['date_start']) ? jssupportticket::$_data['filter']['date_start'] : '', array('class' => 'custom_date','placeholder' => __('Start Date','js-support-ticket'))); ?>
    <?php echo JSSTformfield::text('date_end', isset(jssupportticket::$_data['filter']['date_end']) ? jssupportticket::$_data['filter']['date_end'] : '', array('class' => 'custom_date','placeholder' => __('End Date','js-support-ticket'))); ?>
    <?php echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH'); ?>
    <?php echo JSSTformfield::submitbutton('go', __('Search', 'js-support-ticket'), array('class' => 'button')); ?>
<?php echo JSSTformfield::button('reset', __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'resetFrom();')); ?>
</form>
<div class="js-admin-content-button">
    <span>  <a class="js-add-link button active" href="<?php if(!JSSTincluder::getJSModel('staff')->isUserStaff()) echo '#'; else echo '?page=mail&jstlay=inbox'; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/inboxadmin.png">  <?php echo __('Inbox', 'js-support-ticket').' (';
echo $inbox;
echo ' )'; ?></a></span>
    <span>	<a class="js-add-link button" href="<?php if(!JSSTincluder::getJSModel('staff')->isUserStaff()) echo '#'; else echo '?page=mail&jstlay=outbox'; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/outboxadmin.png"><?php echo __('Outbox', 'js-support-ticket').' (';
echo isset(jssupportticket::$_data[0]['outboxmessages']) ? jssupportticket::$_data[0]['outboxmessages'] : 0;
echo __(' )  ', 'js-support-ticket'); ?></a></span>
    <span>	<a class="js-add-link button" href="<?php if(!JSSTincluder::getJSModel('staff')->isUserStaff()) echo '#'; else echo '?page=mail&jstlay=formmessage'; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon.png" /><?php echo __('Compose', 'js-support-ticket') ?></a></span>
</div>
<?php if(!JSSTincluder::getJSModel('staff')->isUserStaff()){ ?>
    <font color="orangered">[<?php echo __('To Use This Feature You Must Be Staff Memeber','js-support-ticket'); ?>]</font>
<?php } ?>
<?php
if (!empty(jssupportticket::$_data[0]['inbox'])) {
    ?>  
    <div class="js-filter-form-list">
        <div class="js-filter-form-head js-filter-form-head-xs">
            <div class="js-col-md-4 js-col-xs-12 first"><?php echo __('Subject', 'js-support-ticket'); ?></div>
            <div class="js-col-md-3 js-col-xs-12 second js-textaligncenter"><?php echo __('From', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 js-col-xs-12 third js-textaligncenter"><?php echo __('Created', 'js-support-ticket'); ?></div>
            <div class="js-col-md-3 js-col-xs-12 seventh"><?php echo __('Action', 'js-support-ticket'); ?></div>
        </div>			
        <?php
        foreach (jssupportticket::$_data[0]['inbox'] AS $inbox) {
            if ($inbox->isread == 2) // unread message
                $inboxtitle = "<b>" . $inbox->subject . "<b>";
            elseif ($inbox->count != 0) //replied message
                $inboxtitle = $inbox->subject . ' ' . "<B> ( " . __('Re', 'js-support-ticket') . " ) </B>";
            elseif ($inbox->isread == 1) //read message
                $inboxtitle = $inbox->subject;
            ?>			
            <div class="js-filter-form-data">
                <div class="js-col-md-4 js-col-xs-12 first"><span class="js-filter-form-data-xs"><?php echo __('Subject', 'js-support-ticket');
            echo " : "; ?></span><a href="admin.php?page=mail&jstlay=message&jssupportticketid=<?php echo $inbox->id; ?>"><?php echo $inboxtitle; ?></a></div>
                <div class="js-col-md-3 js-col-xs-12 second js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('From', 'js-support-ticket');
            echo " : "; ?></span><?php echo $inbox->staffname; ?></div>
                <div class="js-col-md-2 js-col-xs-12 third js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Created', 'js-support-ticket');
            echo " : "; ?></span><?php echo date_i18n(jssupportticket::$_config['date_format'], strtotime($inbox->created)); ?></div>
                <div class="js-col-md-3 js-col-xs-12 seventh js-filter-form-action-hl-xs">
                    <a href="admin.php?page=mail&jstlay=message&jssupportticketid=<?php echo $inbox->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit.png" /></a>&nbsp;&nbsp;
                    <a onclick="return confirm('<?php echo __('Are you sure to delete', 'js-support-ticket'); ?>');" href="?page=mail&task=deletemail&action=jstask&mailid=<?php echo $inbox->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" /></a>
                    <a href="admin.php?page=mail&task=markasread&mailid=<?php echo $inbox->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/mark_read.png" /></a>&nbsp;&nbsp;
                    <a href="admin.php?page=mail&task=markasunread&mailid=<?php echo $inbox->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/mark_unread.png" /></a>
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
