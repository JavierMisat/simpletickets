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
    <div class="js-col-md-12 js-ticket-head" style="background:<?php echo jssupportticket::$_data['sanitized_args']['background_color']; ?>">
        <span class="js-ticket-head-text" style="color:<?php echo jssupportticket::$_data['sanitized_args']['text_color']; ?>">
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
                //echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
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