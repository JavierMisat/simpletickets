<script type="text/javascript">
    function resetFrom() {
        document.getElementById('topic').value = '';
        document.getElementById('status').value = '';
        document.getElementById('jssupportticketform').submit();
    }
</script>
<?php
$status = array((object) array('id' => '1', 'text' => __('Active', 'js-support-ticket')),
    (object) array('id' => '0', 'text' => __('Disabled', 'js-support-ticket'))
);
?>
<?php JSSTmessage::getMessage(); ?>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Help Topics', 'js-support-ticket') ?></span>
<a class="js-add-link button" href="?page=helptopic&jstlay=addhelptopic"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon.png" /><?php echo __('Add Help Topic', 'js-support-ticket') ?></a>
</span>
<form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="post" action="<?php echo admin_url("admin.php?page=helptopic&jstlay=helptopics"); ?>">
    <?php echo JSSTformfield::text('topic', jssupportticket::$_data['filter']['topic'], array('placeholder' => __('Help Topic', 'js-support-ticket'))); ?>
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
            <div class="js-col-md-2 js-col-xs-12 first"><?php echo __('Help Topic', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 js-col-xs-12 second js-textaligncenter"><?php echo __('Department', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 js-col-xs-12 third js-textaligncenter"><?php echo __('Auto Response', 'js-support-ticket'); ?></div>
            <div class="js-col-md-1 js-col-xs-12 fourth js-textaligncenter"><?php echo __('Status', 'js-support-ticket'); ?></div>
            <div class="js-col-md-1 js-col-xs-12 fourth js-textaligncenter"><?php echo __('Ordering', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 js-col-xs-12 fifth"><?php echo __('Last Updated', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 js-col-xs-12 sixth"><?php echo __('Action', 'js-support-ticket'); ?></div>
        </div>	
        <?php
        $number = 0;
        $count = COUNT(jssupportticket::$_data[0]) - 1; //For zero base indexing
        $pagenum = JSSTrequest::getVar('pagenum', 'get', 1);
        $islastordershow = JSSTpagination::isLastOrdering(jssupportticket::$_data['total'], $pagenum);
        foreach (jssupportticket::$_data[0] AS $helptopic) {
            $status = ($helptopic->status == 1) ? 'yes.png' : 'no.png';
            $autoreponce = ($helptopic->autoresponce == 1) ? 'yes.png' : 'no.png';
            if (empty($helptopic->updated) || $helptopic->updated == '0000-00-00 00:00:00') {
                $updated = __('Not updated', 'js-support-ticket');
            } else {
                $updated = date_i18n(jssupportticket::$_config['date_format'], strtotime($helptopic->updated));
            }
            ?>
            <div class="js-filter-form-data">
                <div class="js-col-md-2 js-col-xs-12 first"><span class="js-filter-form-data-xs"><?php echo __('Help Topic', 'js-support-ticket');
            echo " : "; ?></span><a href="?page=helptopic&jstlay=addhelptopic&jssupportticketid=<?php echo $helptopic->id; ?>"><?php echo $helptopic->topic; ?></a></div>
                <div class="js-col-md-2 js-col-xs-12 second js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Department', 'js-support-ticket');
            echo " : "; ?></span><?php echo $helptopic->departmentname; ?></div>
                <div class="js-col-md-2 js-col-xs-12 third js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Auto Response', 'js-support-ticket');
            echo " : "; ?></span> <img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $autoreponce; ?>" /></div>
                <div class="js-col-md-1 js-col-xs-12 fourth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Status', 'js-support-ticket');
            echo " : "; ?></span><a href="?page=helptopic&task=changestatus&action=jstask&helptopicid=<?php echo $helptopic->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $status; ?>"/> </a></div>

                <div class="js-col-md-1 js-col-xs-12 fourth js-textaligncenter">
                    <span class="js-filter-form-data-xs"><?php echo __('Ordering', 'js-support-ticket');
            echo " : "; ?></span>
                    <?php if ($number != 0 || $pagenum > 1) { ?>
                        <a href="?page=helptopic&task=ordering&action=jstask&order=up&helptopicid=<?php echo $helptopic->id;
            echo ($pagenum > 1) ? '&pagenum=' . $pagenum : ''; ?>" ><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/uparrow.png" /></a>
                    <?php
                    }
                    echo $helptopic->ordering;
                    if ($number < $count) {
                        ?>
                        <a href="?page=helptopic&task=ordering&action=jstask&order=down&helptopicid=<?php echo $helptopic->id;
                        echo ($pagenum > 1) ? '&pagenum=' . $pagenum : ''; ?>" ><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downarrow.png" /></a>
        <?php } elseif ($islastordershow) { ?>
                        <a href="?page=helptopic&task=ordering&action=jstask&order=down&helptopicid=<?php echo $helptopic->id;
            echo ($pagenum > 1) ? '&pagenum=' . $pagenum : ''; ?>" ><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downarrow.png" /></a> <!-- last record on the page -->
            <?php } ?>
                </div>

                <div class="js-col-md-2 js-col-xs-12 fifth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Last Updated', 'js-support-ticket');
            echo " : "; ?></span><?php echo $updated; ?></div>
                <div class="js-col-md-2 js-col-xs-12 seventh js-filter-form-action-hl-xs">
                    <a href="?page=helptopic&jstlay=addhelptopic&jssupportticketid=<?php echo $helptopic->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit.png" /></a>&nbsp;&nbsp;
                    <a onclick="return confirm('<?php echo __('Are you sure to delete', 'js-support-ticket'); ?>');" href="?page=helptopic&task=deletehelptopic&action=jstask&helptopicid=<?php echo $helptopic->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" /></a>
                </div>
            </div>			

        <?php
        $number++;
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
