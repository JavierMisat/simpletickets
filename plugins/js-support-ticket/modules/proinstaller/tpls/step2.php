<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=proinstaller&jstlay=step1');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __("Tickets Updater", 'js-support-ticket') ?></span></span>
<div id="jsst-main-wrapper" >
    <div id="jsst-upper-wrapper">
        <span class="jsst-title"><?php echo __('JS Support Ticket Pro Installer', 'js-support-ticket'); ?></span>
        <span class="jsst-logo"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/jsticketpro.png" /></span>
    </div>
    <div id="jsst-middle-wrapper">
        <div class="js-col-md-4 active"><span class="jsst-number">1</span><span class="jsst-text"><?php echo __('Configuration', 'js-support-ticket'); ?></span></div>
        <div class="js-col-md-4 active"><span class="jsst-number">2</span><span class="jsst-text"><?php echo __('Permissions', 'js-support-ticket'); ?></span></div>
        <div class="js-col-md-4"><span class="jsst-number">3</span><span class="jsst-text"><?php echo __('Installation', 'js-support-ticket'); ?></span></div>
        <div class="js-col-md-4"><span class="jsst-number">4</span><span class="jsst-text"><?php echo __('Finish', 'js-support-ticket'); ?></span></div>        
    </div>
    <div id="jsst-lower-wrapper">
        <span class="jsst-main-title"><?php echo __('Permissions', 'js-support-ticket'); ?></span>
        <?php if ((jssupportticket::$_data['step2']['dir'] < 755 ) || (jssupportticket::$_data['step2']['create_table'] != 1) || (jssupportticket::$_data['step2']['insert_record'] != 1) || (jssupportticket::$_data['step2']['update_record'] != 1 ) || (jssupportticket::$_data['step2']['delete_record'] != 1 ) || (jssupportticket::$_data['step2']['drop_table'] != 1 ) || (jssupportticket::$_data['step2']['file_downloaded'] != 1 )) { ?>
            <div class="js-row jsst-main-error" id="jsst-table-data">
                <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/error_icon.png" />
                <div class="js-row">
                    <span class="jsst-main-error"><?php echo __('Error occured', 'js-support-ticket'); ?></span>
                        <?php if (jssupportticket::$_data['step2']['dir'] < 755) { ?>
                            <span class="jsst-error-line"><?php echo __('Directory permissions error', 'js-support-ticket'); ?>&nbsp;"<?php echo jssupportticket::$_path; ?>"&nbsp;<?php echo __('directory is not writeable','js-support-ticket'); ?></span>
                        <?php } ?>
                        <?php if (jssupportticket::$_data['step2']['tmpdir'] < 755) { ?>
                            <span class="jsst-error-line"><?php echo __('Directory permissions error', 'js-support-ticket'); ?>&nbsp;"<?php echo ABSPATH.'/tmp'; ?>"&nbsp;<?php echo __('directory is not writeable','js-support-ticket'); ?></span>
                        <?php } ?>
                        <?php if (jssupportticket::$_data['step2']['create_table'] != 1) { ?>
                            <span class="jsst-error-line"><?php echo __('Database create table not allowed', 'js-support-ticket'); ?></span>
                        <?php } ?>
                        <?php if (jssupportticket::$_data['step2']['insert_record'] != 1) { ?>
                            <span class="jsst-error-line"><?php echo __('Database insert record not allowed', 'js-support-ticket'); ?></span>
                        <?php } ?>
                        <?php if (jssupportticket::$_data['step2']['update_record'] != 1) { ?>
                            <span class="jsst-error-line"><?php echo __('Database update record not allowed', 'js-support-ticket'); ?></span>
                        <?php } ?>
                        <?php if (jssupportticket::$_data['step2']['delete_record'] != 1) { ?>
                            <span class="jsst-error-line"><?php echo __('Database delete record not allowed', 'js-support-ticket'); ?></span>
                        <?php } ?>
                        <?php if (jssupportticket::$_data['step2']['drop_table'] != 1) { ?>
                            <span class="jsst-error-line"><?php echo __('Database drop table not allowed', 'js-support-ticket'); ?></span>
                        <?php } ?>
                        <?php if (jssupportticket::$_data['step2']['file_downloaded'] != 1) { ?>
                            <span class="jsst-error-line"><?php echo __('Error file not downloaded', 'js-support-ticket'); ?></span>
                        <?php } ?>
                    </div>
            </div>
        <?php } ?>
        <div class="js-row" id="jsst-table-head">
            <div class="js-col-md-8"><?php echo __('Setting', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2"><?php echo __('Recomended', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2"><?php echo __('Current', 'js-support-ticket'); ?></div>
        </div>
        <div class="js-row <?php if(jssupportticket::$_data['step2']['dir'] < 755 || jssupportticket::$_data['step2']['tmpdir'] < 755) echo 'error'; ?>" id="jsst-table-data">
            <div class="js-col-md-8"><?php echo __('Directory', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 image"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/tick.png" /></div>
            <div class="js-col-md-2 image"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/<?php
                if (jssupportticket::$_data['step2']['dir'] >= 755 && jssupportticket::$_data['step2']['tmpdir'] >= 755)
                    echo "tick";
                else
                    echo "cross";
                ?>.png" /></div>
        </div>
        <div class="js-row <?php if((jssupportticket::$_data['step2']['create_table'] != 1) || (jssupportticket::$_data['step2']['insert_record'] != 1) || (jssupportticket::$_data['step2']['update_record'] != 1 ) || (jssupportticket::$_data['step2']['delete_record'] != 1 ) && (jssupportticket::$_data['step2']['drop_table'] != 1 )) echo 'error'; ?>" id="jsst-table-data">
            <div class="js-col-md-8"><?php echo __('Database CRUD', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 image"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/tick.png" /></div>
            <div class="js-col-md-2 image"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/<?php
                if (jssupportticket::$_data['step2']['create_table'] == 1 && jssupportticket::$_data['step2']['insert_record'] == 1 && jssupportticket::$_data['step2']['update_record'] == 1 && jssupportticket::$_data['step2']['delete_record'] == 1 && jssupportticket::$_data['step2']['drop_table'] == 1)
                    echo "tick";
                else
                    echo "cross";
                ?>.png" /></div>
        </div>
        <div class="js-row <?php if(jssupportticket::$_data['step2']['file_downloaded'] != 1) echo 'error'; ?>" id="jsst-table-data">
            <div class="js-col-md-8"><?php echo __('File download', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 image"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/tick.png" /></div>
            <div class="js-col-md-2 image"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/<?php
                if (jssupportticket::$_data['step2']['file_downloaded'] == 1)
                    echo "tick";
                else
                    echo "cross";
                ?>.png" /></div>
        </div>
        <div class="js-row">
            <?php if ((jssupportticket::$_data['step2']['dir'] >= 755 ) && (jssupportticket::$_data['step2']['tmpdir'] >= 755 ) && (jssupportticket::$_data['step2']['create_table'] == 1) && (jssupportticket::$_data['step2']['insert_record'] == 1) && (jssupportticket::$_data['step2']['update_record'] == 1 ) && (jssupportticket::$_data['step2']['delete_record'] == 1 ) && (jssupportticket::$_data['step2']['drop_table'] == 1 ) && (jssupportticket::$_data['step2']['file_downloaded'] == 1 )) { ?>
                <a class="nextbutton" href="<?php echo admin_url("admin.php?page=proinstaller&jstlay=step3"); ?>"><?php echo __('Next step', 'js-support-ticket'); ?></a>
            <?php } ?>
        </div>
    </div>

</div>