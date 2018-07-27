<script type="text/javascript">
    function resetFrom() {
        document.getElementById('departmentname').value = '';
        document.getElementById('jssupportticketform').submit();
    }
</script>
<?php JSSTmessage::getMessage(); ?>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Department', 'js-support-ticket') ?></span>
<a class="js-add-link button" href="?page=department&jstlay=adddepartment"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon.png" /><?php echo __('Add Department', 'js-support-ticket') ?></a>
</span>
<form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="post" action="<?php echo admin_url("admin.php?page=department&jstlay=departments"); ?>">
    <?php echo JSSTformfield::text('departmentname', jssupportticket::$_data['filter']['departmentname'], array('placeholder' => __('Department Name', 'js-support-ticket'))); ?>
    <?php echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH'); ?>
    <?php echo JSSTformfield::submitbutton('go', __('Search', 'js-support-ticket'), array('class' => 'button')); ?>
    <?php echo JSSTformfield::button('reset', __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'resetFrom();')); ?>
</form>
<?php if (!empty(jssupportticket::$_data[0])) { ?>  		
    <div class="js-filter-form-list">
        <div class="js-filter-form-head js-filter-form-head-xs">
            <div class="js-col-md-2 first"><?php echo __('Department Name', 'js-support-ticket'); ?></div>
            <div class="js-col-md-3 second"><?php echo __('Outgoing Email', 'js-support-ticket'); ?></div>
            <div class="js-col-md-1 third js-textaligncenter"><?php echo __('Default', 'js-support-ticket'); ?></div>
            <div class="js-col-md-1 third js-textaligncenter"><?php echo __('Ordering', 'js-support-ticket'); ?></div>
            <div class="js-col-md-1 fourth js-textaligncenter"><?php echo __('Status', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 fifth js-textaligncenter"><?php echo __('Created', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 sixth"><?php echo __('Action', 'js-support-ticket'); ?></div>
        </div>
        <?php
        $number = 0;
        $count = COUNT(jssupportticket::$_data[0]) - 1; //For zero base indexing
        $pagenum = JSSTrequest::getVar('pagenum', 'get', 1);
        $islastordershow = JSSTpagination::isLastOrdering(jssupportticket::$_data['total'], $pagenum);
        foreach (jssupportticket::$_data[0] AS $department) {
            $default = ($department->isdefault == 1) ? 'yes.png' : 'no.png';
            $status = ($department->status == 1) ? 'yes.png' : 'no.png';
            ?>			
            <div class="js-filter-form-data">
                <div class="js-col-xs-12 js-col-md-2 first"><span class="js-filter-form-data-xs"><?php echo __('Department', 'js-support-ticket');
        echo " : "; ?></span><a href="?page=department&jstlay=adddepartment&jssupportticketid=<?php echo $department->id; ?>"><?php echo __($department->departmentname, 'js-support-ticket'); ?></a></div>
                <div class="js-col-xs-12 js-col-md-3 second"><span class="js-filter-form-data-xs"><?php echo __('Outgoing Email', 'js-support-ticket');
        echo " : "; ?></span><?php echo $department->outgoingemail; ?></div>
                <div class="js-col-xs-12 js-col-md-1 fourth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Status', 'js-support-ticket');
                echo " : "; ?></span><a href="?page=department&task=changedefault&action=jstask&departmentid=<?php echo $department->id; ?>&default=<?php echo $department->isdefault; ?>"> <img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $default; ?>"/> </a></div>
                <div class="js-col-md-1 js-col-xs-12 fourth js-textaligncenter">
                    <span class="js-filter-form-data-xs"><?php echo __('Ordering', 'js-support-ticket');
        echo " : "; ?></span>
                    <?php if ($number != 0 || $pagenum > 1) { ?>
                        <a href="?page=department&task=ordering&action=jstask&order=up&departmentid=<?php echo $department->id;
            echo ($pagenum > 1) ? '&pagenum=' . $pagenum : ''; ?>" ><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/uparrow.png" /></a>
                    <?php
                    }
                    echo $department->ordering;
                    if ($number < $count) {
                        ?>
                        <a href="?page=department&task=ordering&action=jstask&order=down&departmentid=<?php echo $department->id;
            echo ($pagenum > 1) ? '&pagenum=' . $pagenum : ''; ?>" ><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downarrow.png" /></a>
        <?php } elseif ($islastordershow) { ?>
                        <a href="?page=department&task=ordering&action=jstask&order=down&departmentid=<?php echo $department->id;
            echo ($pagenum > 1) ? '&pagenum=' . $pagenum : ''; ?>" ><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downarrow.png" /></a> <!-- last record on the page -->
                <?php } ?>
                </div>

                <div class="js-col-xs-12 js-col-md-1 fourth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Status', 'js-support-ticket');
                echo " : "; ?></span><a href="?page=department&task=changestatus&action=jstask&departmentid=<?php echo $department->id; ?>"> <img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $status; ?>"/> </a></div>
                <div class="js-col-xs-12 js-col-md-2 fifth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Created', 'js-support-ticket');
        echo " : "; ?></span><?php echo date_i18n(jssupportticket::$_config['date_format'], strtotime($department->created)); ?></div>
                <div class="js-col-xs-12 js-col-md-2 sixth js-filter-form-action-hl-xs">
                    <a href="?page=department&jstlay=adddepartment&jssupportticketid=<?php echo $department->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit.png" /></a>&nbsp;&nbsp;
                    <a onclick="return confirm('<?php echo __('Are you sure to delete', 'js-support-ticket'); ?>');
                                                                                "href="?page=department&task=deletedepartment&action=jstask&departmentid=<?php echo $department->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" /></a></div>
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
