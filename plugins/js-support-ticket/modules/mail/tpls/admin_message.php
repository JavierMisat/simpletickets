<?php
JSSTmessage::getMessage();
if (jssupportticket::$_data[0]['unreadmessages'] >= 1) {
    $inbox = jssupportticket::$_data[0]['unreadmessages'];
} else {
    $inbox = jssupportticket::$_data[0]['totalInboxboxmessages'];
}
?>

<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=mail&jstlay=inbox');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Subject', 'js-support-ticket'); ?> &nbsp;&nbsp;<?php echo jssupportticket::$_data[0]['message']->subject ?></span>
</span>
<form method="post" action="<?php echo admin_url("admin.php?page=mail&task=savereply"); ?>">
    <div class="js-ticket-thread-upperpart">
        <span class="js-ticket-thread-replied"><?php echo __('Replied By', 'js-support-ticket'); ?>&nbsp;:&nbsp;</span>
        <span class="js-ticket-thread-person"><?php echo isset(jssupportticket::$_data[0]['message']->staffname) ? jssupportticket::$_data[0]['message']->staffname : ''; ?></span>
        <span class="js-ticket-thread-date">(&nbsp;<?php echo date_i18n("l F d, Y, h:i:s", strtotime(jssupportticket::$_data[0]['message']->created)); ?>&nbsp;)</span>
    </div>
    <div class="js-ticket-thread-middlepart">
        <?php echo __('Message', 'js-support-ticket') ?>
    <?php echo jssupportticket::$_data[0]['message']->message; ?>
    </div>
    <?php
    if (!empty(jssupportticket::$_data[0]['replies']))
        foreach (jssupportticket::$_data[0]['replies'] AS $reply):
            ?>
            <div class="js-col-md-2 js-ticket-thread-pic"><img src="<?php echo jssupportticket::$_pluginpath . '/includes/images/ticketmanbig.png'; ?>" /></div>
            <div class="js-col-md-9 js-ticket-thread-wrapper ">
                <div class="js-ticket-thread-upperpart">
                    <span class="js-ticket-thread-replied"><?php echo __('Replied By', 'js-support-ticket'); ?>&nbsp;:&nbsp;</span>
                    <span class="js-ticket-thread-person"><?php echo $reply->staffname; ?></span>
                    <span class="js-ticket-thread-date">(&nbsp;<?php echo date_i18n("l F d, Y, h:i:s", strtotime($reply->created)); ?>&nbsp;)</span>
                </div>
                <div class="js-ticket-thread-middlepart">
        <?php echo $reply->message; ?>
                </div>
            </div>
        <?php endforeach; ?>
<?php // Reply Area  ?>
    <span class="js-admin-title"><?php echo __('Reply', 'js-support-ticket'); ?></span>
    <span> <a class="js-add-link button" href="admin.php?page=mail&jstlay=inbox"><?php echo __('Inbox', 'js-support-ticket').' (';
echo $inbox;
echo ' )'; ?></a></span>
    <span> <a class="js-add-link button" href="admin.php?page=mail&jstlay=outbox"><?php echo __('Outbox', 'js-support-ticket').' (';
echo jssupportticket::$_data[0]['outboxmessages'];
echo __(' )  ', 'js-support-ticket'); ?></a></span>
    <span> <a class="js-add-link button" href="admin.php?page=mail&jstlay=formmessage"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon.png" /><?php echo __('Compose', 'js-support-ticket') ?></a></span>

    <div id="postreply">
        <div class="js-form-wrapper">
            <div class="js-form-title"><label id="responcemsg" for="responce"><?php echo __('Reply', 'js-support-ticket'); ?><font color="red">*</font></label></div>
            <div class="js-form-field"><?php echo wp_editor('', 'message', array('media_buttons' => false)); ?></div>
        </div>
    </div>
    <?php echo JSSTformfield::hidden('jssupportticketid', jssupportticket::$_data[0]['message']->id); ?>
    <?php echo JSSTformfield::hidden('created', isset(jssupportticket::$_data[0]['replies']->created) ? jssupportticket::$_data[0]['replies']->created : ''); ?>
    <?php echo JSSTformfield::hidden('isread', 2); ?>
        <?php echo JSSTformfield::hidden('status', 1); ?>
        <?php echo JSSTformfield::hidden('replytoid', isset(jssupportticket::$_data[0]['message']->id) ? jssupportticket::$_data[0]['message']->id : ''); ?>
<?php echo JSSTformfield::hidden('from', get_current_user_id()); ?>
<?php echo JSSTformfield::hidden('action', 'mail_savereply'); ?>
<?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
    <div class="js-form-button">
<?php echo JSSTformfield::submitbutton('save', __('Send', 'js-support-ticket'), array('class' => 'button')); ?>
    </div>
</form>