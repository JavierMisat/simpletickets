<?php wp_enqueue_script('formvalidate.js', jssupportticket::$_pluginpath . 'includes/js/jquery.form-validator.js'); ?>
<script type="text/javascript">
    function resetFrom() {
        document.getElementById('email').value = '';
        document.getElementById('jssupportticketform').submit();
    }
</script>
<?php JSSTmessage::getMessage(); ?>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Banned Emails', 'js-support-ticket') ?></span>
<a class="js-add-link button" href="?page=banemail&jstlay=addbanemail"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon.png" /><?php echo __('Add Email', 'js-support-ticket') ?></a>
</span>
<form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="post" action="<?php echo admin_url("admin.php?page=banemail&jstlay=banemails"); ?>">
    <?php echo JSSTformfield::text('email', jssupportticket::$_data['filter']['email'], array('placeholder' => __('Email', 'js-support-ticket'))); ?>
    <?php echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH'); ?>
    <?php echo JSSTformfield::submitbutton('go', __('Search', 'js-support-ticket'), array('class' => 'button')); ?>
    <?php echo JSSTformfield::button('reset', __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'resetFrom();')); ?>
</form>
<?php if (!empty(jssupportticket::$_data[0])) { ?>  		
    <div class="js-filter-form-list">
        <div class="js-filter-form-head js-filter-form-head-xs">
            <div class="js-col-md-4 js-col-xs-12 first"><?php echo __('Emails', 'js-support-ticket'); ?></div>
            <div class="js-col-md-3 js-col-xs-12 second js-textaligncenter"><?php echo __('Submitter', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 js-col-xs-12 third js-textaligncenter"><?php echo __('Created', 'js-support-ticket'); ?></div>
            <div class="js-col-md-3 js-col-xs-12 seventh"><?php echo __('Action', 'js-support-ticket'); ?></div>
        </div>	

        <?php
        foreach (jssupportticket::$_data[0] AS $email) {
            ?>			
            <div class="js-filter-form-data">
                <div class="js-col-md-4 js-col-xs-12 first"><span class="js-filter-form-data-xs"><?php echo __('Emails', 'js-support-ticket');
        echo " : "; ?></span><a href="?page=banemail&jstlay=addbanemail&jssupportticketid=<?php echo $email->id; ?>"><?php echo $email->email; ?></a></div>
                <div class="js-col-md-3 js-col-xs-12 second js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Submitter', 'js-support-ticket');
        echo " : "; ?></span><?php if($email->staffname) echo $email->staffname; else echo $email->user_nicename; ?></div>
                <div class="js-col-md-2 js-col-xs-12 third js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Created', 'js-support-ticket');
        echo " : "; ?></span><?php echo date_i18n(jssupportticket::$_config['date_format'], strtotime($email->created)); ?></div>
                <div class="js-col-md-3 js-col-xs-12 seventh js-filter-form-action-hl-xs">
                    <a href="?page=banemail&jstlay=addbanemail&jssupportticketid=<?php echo $email->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit.png" /></a>&nbsp;&nbsp;
                    <a onclick="return confirm('<?php echo __('Are you sure to delete', 'js-support-ticket'); ?>');" href="?page=banemail&task=deletebanemail&action=jstask&banemailid=<?php echo $email->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" /></a>
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
