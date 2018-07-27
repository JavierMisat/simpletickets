<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __("Tickets Updater", 'js-support-ticket') ?></span></span>
<div id="jsst-main-wrapper" >
    <div id="jsst-upper-wrapper">
        <span class="jsst-title"><?php echo __('JS Support Ticket Pro Installer', 'js-support-ticket'); ?></span>
        <span class="jsst-logo"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/jsticketpro.png" /></span>
    </div>
    <div id="jsst-middle-wrapper">
        <div class="js-col-md-4 active"><span class="jsst-number">1</span><span class="jsst-text"><?php echo __('Configuration', 'js-support-ticket'); ?></span></div>
        <div class="js-col-md-4"><span class="jsst-number">2</span><span class="jsst-text"><?php echo __('Permissions', 'js-support-ticket'); ?></span></div>
        <div class="js-col-md-4"><span class="jsst-number">3</span><span class="jsst-text"><?php echo __('Installation', 'js-support-ticket'); ?></span></div>
        <div class="js-col-md-4"><span class="jsst-number">4</span><span class="jsst-text"><?php echo __('Finish', 'js-support-ticket'); ?></span></div>        
    </div>
    <div id="jsst-lower-wrapper">
        <span class="jsst-main-title"><?php echo __('Quick Configuration', 'js-support-ticket'); ?></span>
        <?php if ((jssupportticket::$_data['phpversion'] < 5) || (jssupportticket::$_data['curlexist'] != 1) || (jssupportticket::$_data['gdlib'] != 1) || (jssupportticket::$_data['ziplib'] != 1)) { ?>
            <div class="js-row jsst-main-error" id="jsst-table-data">
                <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/error_icon.png" />
                <div class="js-row">
                    <span class="jsst-main-error"><?php echo __('Error occured', 'js-support-ticket'); ?></span>
                        <?php if (jssupportticket::$_data['phpversion'] < 5) { ?>
                            <span class="jsst-error-line"><?php echo __('PHP version smaller then recomended', 'js-support-ticket'); ?></span>
                        <?php } ?>
                        <?php if (jssupportticket::$_data['curlexist'] != 1) { ?>
                            <span class="jsst-error-line"><?php echo __('CURL not exist', 'js-support-ticket'); ?></span>
                        <?php } ?>
                        <?php if (jssupportticket::$_data['gdlib'] != 1) { ?>
                            <span class="jsst-error-line"><?php echo __('GD library not exist', 'js-support-ticket'); ?></span>
                        <?php } ?>
                        <?php if (jssupportticket::$_data['ziplib'] != 1) { ?>
                            <span class="jsst-error-line"><?php echo __('Zip library not exist', 'js-support-ticket'); ?></span>
                        <?php } ?>
                    </div>
            </div>
        <?php } ?>
        <div class="js-row" id="jsst-table-head">
            <div class="js-col-md-8"><?php echo __('Setting', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2"><?php echo __('Recomended', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2"><?php echo __('Current', 'js-support-ticket'); ?></div>
        </div>
        <div class="js-row <?php if(jssupportticket::$_data['phpversion'] < 5) echo 'error'; ?>" id="jsst-table-data">
            <div class="js-col-md-8"><?php echo __('PHP', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2"><?php echo __('5.0', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 <?php
            if (jssupportticket::$_data['phpversion'] < 5)
                echo "red";
            else
                echo "green";
            ?>"><?php echo jssupportticket::$_data['phpversion']; ?></div>
        </div>
        <div class="js-row <?php if(jssupportticket::$_data['curlexist'] != 1) echo 'error'; ?>" id="jsst-table-data">
            <div class="js-col-md-8"><?php echo __('CURL exist', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 image"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/tick.png" /></div>
            <div class="js-col-md-2 image"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/<?php
                if (jssupportticket::$_data['curlexist'])
                    echo "tick";
                else
                    echo "cross";
                ?>.png" /></div>
        </div>
        <div class="js-row <?php if(jssupportticket::$_data['gdlib'] != 1) echo 'error'; ?>" id="jsst-table-data">
            <div class="js-col-md-8"><?php echo __('GD library', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 image"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/tick.png" /></div>
            <div class="js-col-md-2 image"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/<?php
                if (jssupportticket::$_data['gdlib'])
                    echo "tick";
                else
                    echo "cross";
                ?>.png" /></div>
        </div>
        <div class="js-row <?php if(jssupportticket::$_data['ziplib'] != 1) echo 'error'; ?>" id="jsst-table-data">
            <div class="js-col-md-8"><?php echo __('Zip library', 'js-support-ticket'); ?></div>
            <div class="js-col-md-2 image"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/tick.png" /></div>
            <div class="js-col-md-2 image"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/<?php
                if (jssupportticket::$_data['ziplib'])
                    echo "tick";
                else
                    echo "cross";
                ?>.png" /></div>
        </div>
        <div class="js-row">
            <?php if ((jssupportticket::$_data['phpversion'] > 5) && (jssupportticket::$_data['curlexist'] == 1) && (jssupportticket::$_data['gdlib'] == 1) && (jssupportticket::$_data['ziplib'] == 1)) { ?>
                <a class="nextbutton" href="<?php echo admin_url("admin.php?page=proinstaller&jstlay=step2"); ?>"><?php echo __('Next step', 'js-support-ticket'); ?></a>
            <?php } ?>
        </div>
    </div>

</div>