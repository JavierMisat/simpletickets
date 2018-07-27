<?php
if (jssupportticket::$_config['offline'] == 2) {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            jQuery("div#js-ticket-main-black-background,span#js-ticket-popup-close-button").click(function () {
                jQuery("div#js-ticket-main-popup").slideUp();
                setTimeout(function () {
                    jQuery("div#js-ticket-main-black-background").hide();
                }, 600);

            });
        });
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
        function getAllDownloads(value) {
            ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
            jQuery.post(ajaxurl, {action: 'jsticket_ajax', downloadid: value, jstmod: 'download', task: 'getAllDownloads'}, function (data) {
                console.log(data);
                /*			
                 if(data){
                 var obj = jQuery.parseJSON(data);
                 alert(obj.helloworld);
                 }
                 */		});
        }
    </script>
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
    <div id="js-ticket-main-black-background" style="display:none;">
    </div>
    <div id="js-ticket-main-popup" style="display:none;">
        <span id="js-ticket-popup-title">abc title</span>
        <span id="js-ticket-popup-close-button"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/close.png" /></span>
        <div id="js-ticket-main-content">
        </div>
        <div id="js-ticket-main-downloadallbtn">
        </div>

    </div>
    <div class="js-col-md-12 js-ticket-head" style="background:<?php echo jssupportticket::$_data['sanitized_args']['background_color']; ?>">
        <span class="js-ticket-head-text" style="color:<?php echo jssupportticket::$_data['sanitized_args']['text_color']; ?>">
            <?php echo __('Downloads', 'js-support-ticket'); ?>
        </span>
    </div>
    <div class="js-col-md-12">			
        <?php
        if (jssupportticket::$_data[0]['downloads']) {
            foreach (jssupportticket::$_data[0]['downloads'] as $download) {
                ?>
                <div class="js-col-xs-12 js-col-md-12 js-ticket-body-row">
                    <div class="js-col-xs-12 js-col-md-10 js-ticket-body-padding">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/userdownloads.png" />
                        <span class="js-ticket-body-row-text">
                            <?php echo $download->title; ?>
                        </span>
                    </div>
                    <div class="js-col-xs-12 js-col-md-2">
                        <div class="js-col-md-12 js-ticket-body-row-button">
                            <?php echo JSSTformfield::button('download', __('Download', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'getDownloadById(' . $download->downloadid . ');')); ?>
                        </div>
                    </div>
                </div>
                <?php
            }
            if (isset(jssupportticket::$_data[1])) {
                // echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0">' . jssupportticket::$_data[1] . '</div></div>';
            }
        } else {
            JSSTlayout::getNoRecordFound();
        }
        ?>
    </div>

    <?php
// main if  
} else { // System is offline
    JSSTlayout::getSystemOffline();
}
?>