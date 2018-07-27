<script type="text/javascript">
    function resetFrom() {
        document.getElementById('title').value = '';
        document.getElementById('status').value = '';
        document.getElementById('departmentid').value = '';
        document.getElementById('jssupportticketform').submit();
    }
</script>
<?php
$status = array(
    (object) array('id' => '1', 'text' => __('Active', 'js-support-ticket')),
    (object) array('id' => '0', 'text' => __('Offline', 'js-support-ticket'))
);
?>
<?php JSSTmessage::getMessage(); ?>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Premade Messages', 'js-support-ticket') ?></span>
<a class="js-add-link button" href="?page=premademessage&jstlay=addpremademessage"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon.png" /><?php echo __('Add Premade Message', 'js-support-ticket') ?></a>
</span>
<form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="post" action="<?php echo admin_url("admin.php?page=premademessage&jstlay=premademessages"); ?>">
    <?php echo JSSTformfield::text('title', jssupportticket::$_data['filter']['title'], array('placeholder' => __('Title', 'js-support-ticket'))); ?>
    <?php echo JSSTformfield::select('departmentid', JSSTincluder::getJSModel('department')->getDepartmentForCombobox(), jssupportticket::$_data['filter']['departmentid'], __('Select Department', 'js-support-ticket'), array('class' => 'inputbox')); ?>
    <?php echo JSSTformfield::select('status', $status, jssupportticket::$_data['filter']['status'], __('Select Status', 'js-support-ticket'), array('class' => 'inputbox')); ?>
    <?php echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH'); ?>
    <?php echo JSSTformfield::submitbutton('go', __('Search', 'js-support-ticket'), array('class' => 'button')); ?>
<?php echo JSSTformfield::button('reset', __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'resetFrom();')); ?>
</form>
<?php
if (!empty(jssupportticket::$_data[0])) {
    ?>  		
    <div class="js-filter-form-list">
        <div class="js-filter-form-head js-filter-form-head-xs">
            <div class="js-col-md-4 js-col-xs-12 first"><?php echo __('Title', 'js-support-ticket'); ?></div>
            <div class="js-col-md-3 js-col-xs-12 second js-textaligncenter"><?php echo __('Department', 'js-support-ticket'); ?></div>
            <div class="js-col-md-1 js-col-xs-12 third js-textaligncenter"><?php echo __('Status', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 js-col-xs-12 fourth js-textaligncenter"><?php echo __('Last Updated', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 js-col-xs-12 fifth"><?php echo __('Action', 'js-support-ticket'); ?></div>
        </div>	
        <?php
        foreach (jssupportticket::$_data[0] AS $premade) {
            $status = ($premade->status == 1) ? 'yes.png' : 'no.png';
            if (empty($premade->updated) || $premade->updated == '0000-00-00 00:00:00') {
                $updated = __('Not updated', 'js-support-ticket');
            } else {
                $updated = date_i18n(jssupportticket::$_config['date_format'], strtotime($premade->updated));
            }
            ?>			
            <div class="js-filter-form-data">
                <div class="js-col-md-4 js-col-xs-12 first"><span class="js-filter-form-data-xs"><?php echo __('Title', 'js-support-ticket');
            echo " : "; ?></span><a href="?page=premademessage&jstlay=addpremademessage&jssupportticketid=<?php echo $premade->id; ?>"><?php echo $premade->title; ?></a></div>
                <div class="js-col-md-3 js-col-xs-12 second js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Department', 'js-support-ticket');
            echo " : "; ?></span><?php echo $premade->departmentname; ?></div>
                <div class="js-col-md-1 js-col-xs-12 third js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Status', 'js-support-ticket');
            echo " : "; ?></span> <a href="?page=premademessage&task=changestatus&action=jstask&premadeid=<?php echo $premade->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $status; ?>"/></a></div>
                <div class="js-col-md-2 js-col-xs-12 fourth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Last Updated', 'js-support-ticket');
            echo " : "; ?></span><?php echo $updated ?></div>
                <div class="js-col-md-2 js-col-xs-12 seventh js-filter-form-action-hl-xs">
                    <a href="?page=premademessage&jstlay=addpremademessage&jssupportticketid=<?php echo $premade->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit.png" /></a>&nbsp;&nbsp;
                    <a onclick="return confirm('<?php echo __('Are you sure to delete', 'js-support-ticket'); ?>');" href="?page=premademessage&task=deletepremademessage&action=jstask&premademessageid=<?php echo $premade->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" /></a>
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
} else { // Record Not FOund
    JSSTlayout::getNoRecordFound();
}
?>
