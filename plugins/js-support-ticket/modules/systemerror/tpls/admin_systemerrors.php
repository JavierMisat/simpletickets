<script type="text/javascript">
    function resetFrom() {
        document.getElementById('error').value = '';
        document.getElementById('jssupportticketform').submit();
    }
</script>
<?php JSSTmessage::getMessage(); ?>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('System Errors', 'js-support-ticket'); ?></span></span>

<?php
if (!empty(jssupportticket::$_data[0])) {
    ?>  		
    <div class="js-filter-form-list">
        <div class="js-filter-form-head js-filter-form-head-xs">
            <div class="js-col-xs-12 js-col-md-9 first"><?php echo __('Error', 'js-support-ticket'); ?></div>
            <div class="js-col-xs-12 js-col-md-1 js-textaligncenter second"><?php echo __('View', 'js-support-ticket'); ?></div>
            <div class="js-col-xs-12 js-col-md-2 js-textaligncenter third"><?php echo __('Created', 'js-support-ticket'); ?></div>
        </div>
        <?php
        foreach (jssupportticket::$_data[0] AS $systemerror) {
            $isview = ($systemerror->isview == 1) ? 'no.png' : 'yes.png';
            ?>
            <div class="js-filter-form-data">
                <div class="js-col-xs-12 js-col-md-9 first"><span class="js-filter-form-data-xs"><?php
                        echo __('Error', 'js-support-ticket');
                        echo " : ";
                        ?></span><?php echo $systemerror->error; ?></div>
                <div class="js-col-xs-12 js-col-md-1 js-textaligncenter second"><span class="js-filter-form-data-xs"><?php
                        echo __('View', 'js-support-ticket');
                        echo " : ";
                        ?></span><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/<?php echo $isview; ?>" /></div>
                <div class="js-col-xs-12 js-col-md-2 js-textaligncenter third"><span class="js-filter-form-data-xs"><?php
                echo __('Created', 'js-support-ticket');
                echo " : ";
                        ?></span><?php echo date_i18n(jssupportticket::$_config['date_format'], strtotime($systemerror->created)); ?></div>
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