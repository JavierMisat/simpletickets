<script type="text/javascript">
    function resetFrom() {
        document.getElementById('title').value = '';
        document.getElementById('categoryid').value = '';
        document.getElementById('jssupportticketform').submit();
    }
</script>
<?php
JSSTmessage::getMessage();
?>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Downloads', 'js-support-ticket') ?></span>
<a class="js-add-link button" href="?page=download&jstlay=adddownload"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon.png" /><?php echo __('Add Download', 'js-support-ticket') ?></a>
</span>

<form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="post" action="<?php echo admin_url("admin.php?page=download&jstlay=downloads"); ?>">
    <?php echo JSSTformfield::text('title', jssupportticket::$_data['filter']['title'], array('placeholder' => __('Title', 'js-support-ticket'))); ?>
    <?php echo JSSTformfield::select('categoryid', JSSTincluder::getJSModel('knowledgebase')->getCategoryForCombobox('downloads'), jssupportticket::$_data['filter']['categoryid'], __('Select Category', 'js-support-ticket'), array('class' => 'inputbox')); ?>
    <?php echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH'); ?>
    <?php echo JSSTformfield::submitbutton('go', __('Search', 'js-support-ticket'), array('class' => 'button')); ?>
    <?php echo JSSTformfield::button('reset', __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'resetFrom();')); ?>
</form>

<?php if (!empty(jssupportticket::$_data[0])) { ?>
    <div class="js-filter-form-list">
        <div class="js-filter-form-head js-filter-form-head-xs">
            <div class="js-col-md-3 js-col-xs-12 first"><?php echo __('Title', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 js-col-xs-12 second js-textaligncenter"><?php echo __('Category', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 js-col-xs-12 third js-textaligncenter"><?php echo __('Attachments', 'js-support-ticket'); ?></div>
            <div class="js-col-md-1 js-col-xs-12 fourth js-textaligncenter"><?php echo __('Status', 'js-support-ticket'); ?></div>
            <div class="js-col-md-1 js-col-xs-12 fourth js-textaligncenter"><?php echo __('Ordering', 'js-support-ticket'); ?></div>
            <div class="js-col-md-1 js-col-xs-12 fifth"><?php echo __('Created', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 js-col-xs-12 seventh"><?php echo __('Action', 'js-support-ticket'); ?></div>
        </div>
        <?php
        $number = 0;
        $count = COUNT(jssupportticket::$_data[0]) - 1; //For zero base indexing
        $pagenum = JSSTrequest::getVar('pagenum', 'get', 1);
        $islastordershow = JSSTpagination::isLastOrdering(jssupportticket::$_data['total'], $pagenum);
        foreach (jssupportticket::$_data[0] AS $download) {
            $status = ($download->status == 1) ? 'yes.png' : 'no.png';
            ?>			
            <div class="js-filter-form-data">
                <div class="js-col-md-3 js-col-xs-12 first"><span class="js-filter-form-data-xs"><?php echo __('Title', 'js-support-ticket'); echo " : "; ?></span><a href="?page=download&jstlay=adddownload&jssupportticketid=<?php echo $download->id; ?>"><?php echo $download->title; ?></a></div>
                <div class="js-col-md-2 js-col-xs-12 second js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Category', 'js-support-ticket'); echo " : "; ?></span><?php echo $download->categoryname; ?></div>
                <div class="js-col-md-2 js-col-xs-12 third js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Attachment', 'js-support-ticket'); echo " : "; ?></span> <?php echo $download->totalattachment; ?></div>
                <div class="js-col-md-1 js-col-xs-12 fourth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Status', 'js-support-ticket'); echo " : "; ?></span><a href="?page=download&task=changestatus&action=jstask&downloadid=<?php echo $download->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $status; ?>"/> </a></div>

                <div class="js-col-md-1 js-col-xs-12 fourth js-textaligncenter">
                    <span class="js-filter-form-data-xs"><?php echo __('Ordering', 'js-support-ticket'); echo " : "; ?></span>
                    <?php if ($number != 0 || $pagenum > 1) { ?>
                        <a href="?page=download&task=ordering&action=jstask&order=up&downloadid=<?php echo $download->id; echo ($pagenum > 1) ? '&pagenum=' . $pagenum : ''; ?>" ><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/uparrow.png" /></a>
                    <?php
                    }
                    echo $download->ordering;
                    if ($number < $count) {
                        ?>
                        <a href="?page=download&task=ordering&action=jstask&order=down&downloadid=<?php echo $download->id;
                        echo ($pagenum > 1) ? '&pagenum=' . $pagenum : ''; ?>" ><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downarrow.png" /></a>
        <?php } elseif ($islastordershow) { ?>
                        <a href="?page=download&task=ordering&action=jstask&order=down&downloadid=<?php echo $download->id;
            echo ($pagenum > 1) ? '&pagenum=' . $pagenum : ''; ?>" ><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/downarrow.png" /></a> <!-- last record on the page -->
        <?php } ?>
                </div>

                <div class="js-col-md-1 js-col-xs-12 fifth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Created', 'js-support-ticket');
        echo " : "; ?></span> <?php echo date_i18n(jssupportticket::$_config['date_format'], strtotime($download->created)); ?></div>
                <div class="js-col-md-2 js-col-xs-12 seventh js-textaligncenter js-filter-form-action-hl-xs">
                    <a href="?page=download&jstlay=adddownload&jssupportticketid=<?php echo $download->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit.png" /></a>&nbsp;&nbsp;
                    <a onclick="return confirm('<?php echo __('Are you sure to delete', 'js-support-ticket'); ?>');" href="?page=download&task=deletedownload&action=jstask&downloadid=<?php echo $download->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" /></a>
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
