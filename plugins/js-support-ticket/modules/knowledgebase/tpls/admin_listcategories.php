<script type="text/javascript">
    function resetFrom() {
        document.getElementById('catname').value = '';
        document.getElementById('jssupportticketform').submit();
    }
</script>
<?php JSSTmessage::getMessage();
// echo "<pre>";print_r(jssupportticket::$_data[8]);exit; 
?>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Categories', 'js-support-ticket') ?></span>
<a class="js-add-link button" href="?page=knowledgebase&jstlay=addcategory"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon.png" /><?php echo __('Add Category', 'js-support-ticket') ?></a>
</span>
<form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="post" action="<?php echo admin_url("admin.php?page=knowledgebase&jstlay=listcategories"); ?>">
    <?php echo JSSTformfield::text('catname', jssupportticket::$_data['filter']['catname'], array('placeholder' => __('Name', 'js-support-ticket'))); ?>
    <?php echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH'); ?>
    <?php echo JSSTformfield::submitbutton('go', __('Search', 'js-support-ticket'), array('class' => 'button')); ?>
<?php echo JSSTformfield::button('reset', __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'resetFrom();')); ?>
</form>
<?php
if (!empty(jssupportticket::$_data[8])) {
    ?>  		
    <div class="js-filter-form-list">
        <div class="js-filter-form-head js-filter-form-head-xs">
            <div class="js-col-md-6 js-col-xs-12 first"><?php echo __('Category Title', 'js-support-ticket'); ?></div>
            <div class="js-col-md-1 js-col-xs-12 second js-textaligncenter"><?php echo __('Type', 'js-support-ticket'); ?></div>
            <div class="js-col-md-1 js-col-xs-12 third js-textaligncenter"><?php echo __('Status', 'js-support-ticket'); ?></div>

            <div class="js-col-md-2 js-col-xs-12 fourth js-textaligncenter"><?php echo __('Created', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 js-col-xs-12 seventh"><?php echo __('Action', 'js-support-ticket'); ?></div>
        </div>	
        <?php
        foreach (jssupportticket::$_data[8] AS $category) {
            $type = ($category->type == 1) ? __('Public', 'js-support-ticket') : __('Private', 'js-support-ticket');
            $status = ($category->status == 1) ? 'yes.png' : 'no.png';
            ?>			
            <div class="js-filter-form-data">
                <div class="js-col-md-6 js-col-xs-12 first"><span class="js-filter-form-data-xs"><?php echo __('Category Title', 'js-support-ticket');
        echo " : "; ?></span><a href="?page=knowledgebase&jstlay=addcategory&jssupportticketid=<?php echo $category->id; ?>"><?php echo $category->name; ?></a></div>
                <div class="js-col-md-1 js-col-xs-12 second js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Type', 'js-support-ticket');
        echo " : "; ?></span><?php echo $type; ?></div>
                <div class="js-col-md-1 js-col-xs-12 third js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Status', 'js-support-ticket');
        echo " : "; ?></span> <a href="?page=knowledgebase&task=changestatuscategory&action=jstask&categoryid=<?php echo $category->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath . 'includes/images/' . $status; ?>" /> </a></div>



                <div class="js-col-md-2 js-col-xs-12 fourth js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Created', 'js-support-ticket');
        echo " : "; ?></span><?php echo date_i18n(jssupportticket::$_config['date_format'], strtotime($category->created)); ?></div>
                <div class="js-col-md-2 js-col-xs-12 seventh js-filter-form-action-hl-xs js-textaligncenter">
                    <a href="?page=knowledgebase&jstlay=addcategory&jssupportticketid=<?php echo $category->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit.png" /></a>&nbsp;&nbsp;
                    <a onclick="return confirm('<?php echo __('Are you sure to delete', 'js-support-ticket'); ?>');" href="?page=knowledgebase&task=deletecategory&action=jstask&categoryid=<?php echo $category->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" /></a>
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
} else {// User is guest
    JSSTlayout::getNoRecordFound();
}
?>
