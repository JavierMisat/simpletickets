<script type="text/javascript">
    function resetFrom() {
        document.getElementById('rolename').value = '';
        document.getElementById('jssupportticketform').submit();
    }
</script>
<?php JSSTmessage::getMessage(); ?>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Roles', 'js-support-ticket') ?></span>
    <a class="js-add-link button" href="?page=role&jstlay=addrole"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/add_icon.png" /><?php echo __('Add Role', 'js-support-ticket') ?></a>
</span>
<form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="post" action="<?php echo admin_url("admin.php?page=role&jstlay=roles"); ?>">
    <?php echo JSSTformfield::text('rolename', jssupportticket::$_data['filter']['rolename'], array('placeholder' => __('Name', 'js-support-ticket'))); ?>
    <?php echo JSSTformfield::hidden('JSST_form_search', 'JSST_SEARCH'); ?>
    <?php echo JSSTformfield::submitbutton('go', __('Search', 'js-support-ticket'), array('class' => 'button')); ?>
    <?php echo JSSTformfield::button('reset', __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'resetFrom();')); ?>
</form>
<?php
if (!empty(jssupportticket::$_data[0])) {
    ?>  		
    <div class="js-filter-form-list">
        <div class="js-filter-form-head js-filter-form-head-xs">
            <div class="js-col-md-4 js-col-xs-12 first"><?php echo __('Role Name', 'js-support-ticket'); ?></div>
            <div class="js-col-md-4 js-col-xs-12 second js-textaligncenter"><?php echo __('Role Permission', 'js-support-ticket'); ?></div>
            <div class="js-col-md-4 js-col-xs-12 third js-textaligncenter"><?php echo __('Action', 'js-support-ticket'); ?></div>
        </div>	
        <?php
        if (!empty(jssupportticket::$_data[0])) {
            foreach (jssupportticket::$_data[0] AS $role) {
                $status = ( isset($role->status) == 1 ) ? 'yes.png' : 'no.png';
                ?>			
                <div class="js-filter-form-data">
                    <div class="js-col-md-4 js-col-xs-12 first"><span class="js-filter-form-data-xs"><?php echo __('Role Name', 'js-support-ticket');
                echo " : "; ?></span><a href="?page=role&jstlay=addrole&jssupportticketid=<?php echo $role->id; ?>"><?php echo $role->name; ?></a></div>
                    <div class="js-col-md-4 js-col-xs-12 second js-textaligncenter"><span class="js-filter-form-data-xs"><?php echo __('Role Permission', 'js-support-ticket');
                echo " : "; ?></span><a href="?page=role&jstlay=rolepermission&jssupportticketid=<?php echo $role->id; ?>"><?php echo $role->name . ' ' . __('Permissions', 'js-support-ticket'); ?></a></div>
                    <div class="js-col-md-4 js-col-xs-12 seventh js-textaligncenter js-filter-form-action-hl-xs">
                        <a href="?page=role&jstlay=addrole&jssupportticketid=<?php echo $role->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/edit.png" /></a>&nbsp;&nbsp;
                        <a onclick="return confirm('<?php echo __('Are you sure to delete', 'js-support-ticket'); ?>');" href="?page=role&task=deleterole&action=jstask&roleid=<?php echo $role->id; ?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/remove.png" /></a>
                    </div>
                </div>

                <?php
            }
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
