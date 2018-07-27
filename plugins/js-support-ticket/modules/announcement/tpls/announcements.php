<?php
if (jssupportticket::$_config['offline'] == 2) {
    ?>
    <script type="text/javascript">
        function resetFrom() {
            document.getElementById('jsst-search').value = '';
            return true;
        }
        function addSpaces() {
            document.getElementById('jsst-search').value = fillSpaces(document.getElementById('jsst-search').value);
            return true;
        }
    </script>
    <?php JSSTmessage::getMessage(); ?>
    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>

    <h1 class="js-ticket-heading"><?php echo __('Announcements', 'js-support-ticket') ?></h1>
    <form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="GET" action="">
        <?php echo "<input type='hidden' name='page_id' value='" . jssupportticket::getPageId() . "'/>"; ?>
        <?php echo "<input type='hidden' name='jstmod' value='announcement'/>"; ?>
        <?php echo "<input type='hidden' name='jstlay' value='announcements'/>"; ?>
        <div class="row js-filter-wrapper">
            <div class="js-col-md-12">
                <div class="js-col-md-12 js-filter-title">
                    <?php echo __('Search Announcement', 'js-support-ticket'); ?>
                </div>
                <div class="js-col-md-12 js-filter-value">
                    <?php echo JSSTformfield::text('jsst-search', jssupportticket::parseSpaces(JSSTrequest::getVar('jsst-search')), array('placeholder' => __('Search', 'js-support-ticket'))); ?>
                </div>
            </div>
            <div class="js-col-md-12 js-filter-wrapper">
                <div class="js-filter-button">
                    <?php echo JSSTformfield::submitbutton('jsst-go', __('Search', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'return addSpaces();')); ?>
                    <?php echo JSSTformfield::submitbutton('jsst-reset', __('Reset', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'return resetFrom();')); ?>
                </div>
            </div>
        </div>
    </form>
    <?php
    $counter = 1;
    if (jssupportticket::$_data[0]['categories']) {
        ?>
        <div class="js-col-md-12 js-ticket-head">
            <span class="js-ticket-head-text">
        <?php echo __('Categories', 'js-support-ticket'); ?>
            </span>
        </div>
        <div class="js-col-md-12">
            <div class="js-col-md-12 js-ticket-body">
                <?php foreach (jssupportticket::$_data[0]['categories'] as $category) { ?>
                    <div class="js-col-md-4 js-ticket-body-data">	
                        <a href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=announcement&jstlay=announcements&jssupportticketid=" . $category->id); ?>">
                            <div class="js-col-md-12 js-ticket-body-border">
                                <span class="js-ticket-body-text">
                                    <?php echo $counter . ".  " . $category->name; ?>
                                </span>
                                <div class="js-ticket-body-icon">
                                    <div class="js-ticket-body-image"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/arrowicon.png" /></div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                    $counter ++;
                }
                ?>
            </div>		
        </div>
        <?php }
    ?>
    <div class="js-col-md-12 js-ticket-head">
        <span class="js-ticket-head-text">
    <?php echo __('Announcements', 'js-support-ticket');
    if (jssupportticket::$_data[0]['categoryname']) echo ' > ' . jssupportticket::$_data[0]['categoryname']->name; ?>
        </span>
    </div>
    <div class="js-col-md-12">			
        <?php
        if (jssupportticket::$_data[0]['announcements']) {
            foreach (jssupportticket::$_data[0]['announcements'] as $announcement) {
                ?>
                <div class="js-col-md-12 js-ticket-body-row">
                    <div class="js-col-md-10 js-ticket-body-padding">
                        <span class="js-ticket-body-row-text">
                            <a href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=announcement&jstlay=announcementdetails&jssupportticketid=" . $announcement->id); ?>"> <?php echo $announcement->title; ?></a>
                        </span>
                    </div>
                </div>
                <?php
            }

            if (isset(jssupportticket::$_data[1])) {
                echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
            }
        } else {
            JSSTlayout::getNoRecordFound();
        }
        ?>
    </div>	
    <?php
} else {
    JSSTlayout::getSystemOffline();
} ?>