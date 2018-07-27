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
    <?php JSSTbreadcrumbs::getBreadcrumbs(); ?>
    <?php include_once(jssupportticket::$_path . 'includes/header.php'); ?>
    <h1 class="js-ticket-heading"><?php echo __('Downloads', 'js-support-ticket') ?> </h1>
    <form class="js-filter-form" name="jssupportticketform" id="jssupportticketform" method="GET" action="">
        <?php echo "<input type='hidden' name='page_id' value='" . jssupportticket::getPageId() . "'/>"; ?>
        <?php echo "<input type='hidden' name='jstmod' value='download'/>"; ?>
        <?php echo "<input type='hidden' name='jstlay' value='downloads'/>"; ?>
        <div class="row js-filter-wrapper">
            <div class="js-col-md-12">
                <div class="js-col-md-12 js-filter-title">
                    <?php echo __('Search Download', 'js-support-ticket'); ?>
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
                        <a href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=download&jstlay=downloads&jssupportticketid=" . $category->id); ?>">
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
            <?php echo __('Downloads', 'js-support-ticket'); ?>
        </span>
    </div>
    <div class="js-col-md-12">			
        <?php
        if (jssupportticket::$_data[0]['downloads']) {
            foreach (jssupportticket::$_data[0]['downloads'] as $download) {
                ?>
                <div class="js-col-xs-12 js-col-md-12 js-ticket-body-row">
                    <div class="js-col-xs-12 js-col-md-8 js-ticket-body-padding">
                        <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/userdownloads.png" />
                        <span class="js-ticket-body-row-text">
                            <?php echo $download->title; ?>
                        </span>
                    </div>
                    <div class="js-col-xs-12 js-col-md-4">
                        <div class="js-col-md-12 js-ticket-body-row-button">
                            <?php echo JSSTformfield::button('download', __('Download', 'js-support-ticket'), array('class' => 'button', 'onclick' => 'getDownloadById(' . $download->downloadid . ');')); ?>
                        </div>
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
// main if  
} else { // System is offline
    JSSTlayout::getSystemOffline();
}
?>