<script type="text/javascript">
    function resetFrom() {
        document.getElementById('title').value = '';
        document.getElementById('jssupportticketform').submit();
    }
</script>
<?php JSSTmessage::getMessage(); ?>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Priorities', 'js-support-ticket'); ?></span>
    <a class="js-add-link button" href="?page=priority&jstlay=addpriority"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon.png" /><?php echo __('Add Priority', 'js-support-ticket'); ?></a>
</span>
<form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="post" action="<?php echo admin_url("admin.php?page=priority&jstlay=priorities"); ?>">
    <?php echo JSSTformfield::text('title', jssupportticket::$_data['filter']['title'], array('placeholder' => __('Title', 'js-support-ticket'))); ?>
    <?php echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH'); ?>
    <?php echo JSSTformfield::submitbutton('go', __('Search', 'js-support-ticket'), array('class' => 'button')); ?>
    <?php echo JSSTformfield::button(__('Reset', 'js-support-ticket'), __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'resetFrom();')); ?>
</form>

<?php
foreach (jssupportticket::$_data[0] AS $faq) {
    $status = ($faq->status == 1) ? 'yes.png' : 'no.png';
    ?>			

<?php }
?>
<?php if (!empty(jssupportticket::$_data[0])) { ?>
    <div class="js-filter-form-list">
        <div class="js-filter-form-head js-filter-form-head-xs">
            <div class="js-col-md-4 js-col-xs-12 first"><?php echo __('Title', 'js-support-ticket'); ?></div>
            <div class="js-col-md-1 js-col-xs-12 second js-textaligncenter"><?php echo __('Public', 'js-support-ticket'); ?></div>
            <div class="js-col-md-1 js-col-xs-12 third js-textaligncenter"><?php echo __('Default', 'js-support-ticket'); ?></div>
            <div class="js-col-md-1 js-col-xs-12 fourth js-textaligncenter"><?php echo __('Order', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 js-col-xs-12 fifth"><?php echo __('Color', 'js-support-ticket'); ?></div>
            <div class="js-col-md-3 js-col-xs-12 sixth"><?php echo __('Action', 'js-support-ticket'); ?></div>
        </div>

        <?php
        $number = 0;
        $count = COUNT(jssupportticket::$_data[0]) - 1; //For zero base indexing
        $pagenum = JSSTrequest::getVar('pagenum', 'get', 1);
        $islastordershow = JSSTpagination::isLastOrdering(jssupportticket::$_data['total'], $pagenum);
        foreach (jssupportticket::$_data[0] AS $priority) {
            $isdefault = ($priority->isdefault == 1) ? 'yes.png' : 'no.png';
            $ispublic = ($priority->ispublic == 1) ? 'yes.png' : 'no.png';
            ?>				

            <div class="js-filter-form-data">
                <div class="js-col-md-4 js-col-xs-12 first"><span class="js-filter-form-data-xs"><?php
                        echo __('Title', 'js-support-ticket');
                        echo " : ";
                        ?></span><a href="?page=priority&jstlay=addpriority&jssupportticketid=<?php echo $priority->id; ?>"><?php echo __($priority->priority, 'js-support-ticket'); ?></a></div>
                <div class="js-col-md-1 js-col-xs-12 second js-textaligncenter"><span class="js-filter-form-data-xs"><?php
                        echo __('Public', 'js-support-ticket');
                        echo " : ";
                        ?></span> <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/<?php echo $ispublic; ?>" /></div>
                <div class="js-col-md-1 js-col-xs-12 third js-textaligncenter"><span class="js-filter-form-data-xs"><?php
                    echo __('Default', 'js-support-ticket');
                    echo " : ";
                    ?></span> <a href="?page=priority&task=makedefault&action=jstask&priorityid=<?php
                    echo $priority->id;
                    echo ($pagenum > 1) ? '&pagenum=' . $pagenum : '';
                    ?>" ><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/<?php echo $isdefault; ?>" /></a></div>

                <div class="js-col-md-1 js-col-xs-12 fourth js-textaligncenter">
                    <span class="js-filter-form-data-xs"><?php
                    echo __('Ordering', 'js-support-ticket');
                    echo " : ";
                    ?></span>
                       <?php if ($number != 0 || $pagenum > 1) { ?>
                        <a href="?page=priority&task=ordering&action=jstask&order=up&priorityid=<?php
                           echo $priority->id;
                           echo ($pagenum > 1) ? '&pagenum=' . $pagenum : '';
                           ?>" ><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/uparrow.png" /></a>
                        <?php
                       }
                       echo $priority->ordering;
                       if ($number < $count) {
                           ?>
                        <a href="?page=priority&task=ordering&action=jstask&order=down&priorityid=<?php
                           echo $priority->id;
                           echo ($pagenum > 1) ? '&pagenum=' . $pagenum : '';
                           ?>" ><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downarrow.png" /></a>
                        <?php } elseif ($islastordershow) { ?>
                        <a href="?page=priority&task=ordering&action=jstask&order=down&priorityid=<?php
                            echo $priority->id;
                            echo ($pagenum > 1) ? '&pagenum=' . $pagenum : '';
                            ?>" ><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downarrow.png" /></a> <!-- last record on the page -->
        <?php } ?>
                </div>

                <div class="js-col-md-2 js-col-xs-12 fifth js-textaligncenter js-nullpadding"><span class="js-filter-form-data-xs"><?php
            echo __('Color', 'js-support-ticket');
            echo " : ";
            ?></span> <div class="js-ticket-admin-prirrity-color" style="background:<?php echo $priority->prioritycolour; ?>;color:#ffffff;"> <?php echo $priority->prioritycolour; ?></div></div>
                <div class="js-col-md-3 js-col-xs-12 sixth js-filter-form-action-hl-xs">
                    <a href="?page=priority&jstlay=addpriority&jssupportticketid=<?php echo $priority->id; ?>" alt=""><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit.png" /></a>&nbsp;&nbsp;
                    <a onclick="return confirm('<?php echo __('Are you sure to delete', 'js-support-ticket'); ?>');" href="?page=priority&task=deletepriority&action=jstask&priorityid=<?php echo $priority->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" /></a>
                </div>
            </div>
        <?php
        $number++;
    }
    ?>		</div>
    <?php
    if (jssupportticket::$_data[1]) {
        echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
    }
} else {
    JSSTlayout::getNoRecordFound();
}
?>
