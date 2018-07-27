<?php
if (jssupportticket::$_config['offline'] == 2) {
    ?>
    <script type="text/javascript">
        function getDownloadById(value) {
            ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            jQuery.post(ajaxurl, {action: 'jsticket_ajax', downloadid: value, jstmod: 'download', task: 'getDownloadById'}, function (data) {
                if (data) {
                    var obj = jQuery.parseJSON(data);
                    jQuery("div#js-ticket-main-content").html(obj.data);
                    jQuery("span#js-ticket-popup-title").html(obj.title);
                    jQuery("div#js-ticket-main-downloadallbtn").html(obj.downloadallbtn);
                    jQuery("div#js-ticket-main-black-background").show();
                    jQuery("div#js-ticket-main-popup").slideDown("slow");
                }
            });
        }
    </script>
    <?php JSSTmessage::getMessage(); ?>
    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>

    <h1 class="js-ticket-heading"><?php echo __('Knowledge Base Detail', 'js-support-ticket') ?></h1>
    <?php if (jssupportticket::$_data[0]['articledetails']) { ?>
        <div class="js-col-md-12 js-ticket-mainhead-details">
            <?php echo __('Category Name', 'js-support-ticket');
            echo ' > ' . jssupportticket::$_data[0]['articledetails']->name; ?>
        </div>
        <div class="js-col-md-12">
            <div class="js-col-md-12 js-ticket-head-details">
                <?php echo jssupportticket::$_data[0]['articledetails']->subject; ?>
            </div>
            <div class="js-col-md-12">
                <div class="js-col-md-12 js-ticket-details">
                    <?php echo jssupportticket::$_data[0]['articledetails']->content; ?>
                </div>
            </div>
        </div>
        <div class="js-col-md-12">
            <div class="js-col-md-12 js-ticket-head-details">
                <?php echo __('Article Attachment', 'js-support-ticket'); ?>
            </div>			
            <?php foreach (jssupportticket::$_data[0]['articledownloads'] as $download) { ?>
                <div class="js-col-md-12">
                    <div class="js-col-md-12 js-ticket-body-row-detail">
                        <div class="js-col-md-8 js-ticket-body-padding-detail">
                            <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/userdownloads.png" />
                            <span class="js-ticket-body-row-text-detail">
                                <?php echo $download->filename; ?>
                            </span>
                        </div>
                        <div class="js-col-md-4 js-ticket-body-row-button-detail">
                        <?php
                            $path = site_url('?page_id='.jssupportticket::getPageid()."&action=jstask&jstmod=articleattachmet&task=downloadbyid&id=".$download->id);
                        ?>
                            <a target="_blank" style="text-align:center;padding:5px 20px;" href="<?php echo $path; ?>" class="js-ticket-popup-row-button-a">
                            <?php echo __('Download','js-support-ticket'); ?>
                            </a>                        
                        </div>
                    </div>
                </div>
                <?php }
            ?>
        </div>
        <?php
    } else {
        JSSTlayout::getNoRecordFound();
    }
} else {
    JSSTlayout::getSystemOffline();
} ?>