<script type="text/javascript">
    function resetFrom() {
        document.getElementById('title').value = '';
        document.getElementById('categoryid').value = '';
        document.getElementById('type').value = '';
        document.getElementById('jssupportticketform').submit();
    }
</script>
<?php JSSTmessage::getMessage(); ?>
<?php
$type = array(
    (object) array('id' => '1', 'text' => __('Public', 'js-support-ticket')),
    (object) array('id' => '2', 'text' => __('Private', 'js-support-ticket'))
);
?>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Announcements', 'js-support-ticket') ?></span>
<a class="js-add-link button" href="?page=announcement&jstlay=addannouncement"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon.png" /><?php echo __('Add Announcement', 'js-support-ticket') ?></a>
</span>
<form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="post" action="<?php echo admin_url("admin.php?page=announcement&jstlay=announcements"); ?>">
    <?php echo JSSTformfield::text('title', jssupportticket::$_data['filter']['title'], array('placeholder' => __('Title', 'js-support-ticket'))); ?>
    <?php echo JSSTformfield::select('categoryid', JSSTincluder::getJSModel('knowledgebase')->getCategoryForCombobox('announcement'), jssupportticket::$_data['filter']['categoryid'], __('Select Category', 'js-support-ticket'), array('class' => 'inputbox')); ?>
    <?php echo JSSTformfield::select('type', $type, jssupportticket::$_data['filter']['type'], __('Select Type', 'js-support-ticket'), array('class' => 'inputbox')); ?>
    <?php echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH'); ?>
    <?php echo JSSTformfield::submitbutton('go', __('Search', 'js-support-ticket'), array('class' => 'button')); ?>
    <?php echo JSSTformfield::button('reset', __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'resetFrom();')); ?>
</form>

<?php if (!empty(jssupportticket::$_data[0])) { ?>  		
    <div class="js-filter-form-list">
        <div class="js-filter-form-head js-filter-form-head-xs">
            <div class="js-col-md-3 js-col-xs-12 first"><?php echo __('Title', 'js-support-ticket'); ?></div>
            <div class="js-col-md-3 js-col-xs-12 second js-textaligncenter"><?php echo __('Category', 'js-support-ticket'); ?></div>
            <div class="js-col-md-1 js-col-xs-12 third js-textaligncenter"><?php echo __('Type', 'js-support-ticket'); ?></div>
            <div class="js-col-md-1 js-col-xs-12 third js-textaligncenter"><?php echo __('Ordering', 'js-support-ticket'); ?></div>
            <div class="js-col-md-1 js-col-xs-12 fourth js-textaligncenter"><?php echo __('Status', 'js-support-ticket'); ?></div>
            <div class="js-col-md-1 js-col-xs-12 fifth"><?php echo __('Created', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 js-col-xs-12 seventh"><?php echo __('Action', 'js-support-ticket'); ?></div>
        </div>	

        <?php
        $number = 0;
        $count = COUNT(jssupportticket::$_data[0]) - 1; //For zero base indexing
        $pagenum = JSSTrequest::getVar('pagenum', 'get', 1);
        $islastordershow = JSSTpagination::isLastOrdering(jssupportticket::$_data['total'], $pagenum);
        foreach (jssupportticket::$_data[0] AS $announcement) {
            $listtype = '';
            if ($announcement->type == 1)
                $listtype = __('Public', 'js-support-ticket');
            elseif ($announcement->type == 2)
                $listtype = __('Private', 'js-support-ticket');
            $status = ($announcement->status == 1) ? 'yes.png' : 'no.png';
            ?>			
            <div class="js-filter-form-data">
                <div class="js-col-md-3 js-col-xs-12 first"><span class="js-filter-form-data-xs"><?php echo __('Title', 'js-support-ticket');
        echo " : "; ?></span><a href="?page=announcement&jstlay=addannouncement&jssupportticketid=<?php echo $announcement->id; ?>"><?php echo $announcement->title; ?></a></div>
                <div class="js-col-md-3 js-col-xs-12 second js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Category', 'js-support-ticket');
        echo " : "; ?></span><?php echo $announcement->categoryname; ?></div>
                <div class="js-col-md-1 js-col-xs-12 third js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Type', 'js-support-ticket');
        echo " : "; ?></span> <?php echo $listtype ?></div>

                <div class="js-col-md-1 js-col-xs-12 fourth js-textaligncenter">
                    <span class="js-filter-form-data-xs"><?php echo __('Ordering', 'js-support-ticket');
        echo " : "; ?></span>
                    <?php if ($number != 0 || $pagenum > 1) { ?>
                        <a href="?page=announcement&task=ordering&action=jstask&order=up&announcementid=<?php echo $announcement->id;
            echo ($pagenum > 1) ? '&pagenum=' . $pagenum : ''; ?>" ><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/uparrow.png" /></a>
                    <?php
                    }
                    echo $announcement->ordering;
                    if ($number < $count) {
                        ?>
                        <a href="?page=announcement&task=ordering&action=jstask&order=down&announcementid=<?php echo $announcement->id;
                        echo ($pagenum > 1) ? '&pagenum=' . $pagenum : ''; ?>" ><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downarrow.png" /></a>
        <?php } elseif ($islastordershow) { ?>
                        <a href="?page=announcement&task=ordering&action=jstask&order=down&announcementid=<?php echo $announcement->id;
            echo ($pagenum > 1) ? '&pagenum=' . $pagenum : ''; ?>" ><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downarrow.png" /></a> <!-- last record on the page -->
        <?php } ?>
                </div>

                <div class="js-col-md-1 js-col-xs-12 fourth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Status', 'js-support-ticket');
        echo " : "; ?></span><a href="?page=announcement&task=changestatus&action=jstask&announcementid=<?php echo $announcement->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $status; ?>" /></a></div>
                <div class="js-col-md-1 js-col-xs-12 fifth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Created', 'js-support-ticket');
        echo " : "; ?></span><?php echo date_i18n(jssupportticket::$_config['date_format'], strtotime($announcement->created)); ?></div>
                <div class="js-col-md-2 js-col-xs-12 seventh js-filter-form-action-hl-xs js-textaligncenter">
                    <a href="?page=announcement&jstlay=addannouncement&jssupportticketid=<?php echo $announcement->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit.png" /></a>&nbsp;&nbsp;
                    <a onclick="return confirm('<?php echo __('Are you sure to delete'); ?>');" href="?page=announcement&task=deleteannouncement&action=jstask&announcementid=<?php echo $announcement->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" /></a>
                </div>
            </div>

        <?php
        $number ++;
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
