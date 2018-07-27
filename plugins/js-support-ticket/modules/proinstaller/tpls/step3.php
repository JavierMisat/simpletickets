<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=proinstaller&jstlay=step2');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __("Tickets Updater", 'js-support-ticket') ?></span></span>
<div id="jsst-main-wrapper" >
    <div id="jsst-upper-wrapper">
        <span class="jsst-title"><?php echo __('JS Support Ticket Pro Installer','js-support-ticket'); ?></span>
        <span class="jsst-logo"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/jsticketpro.png" /></span>
    </div>
    <div id="jsst-middle-wrapper">
        <div class="js-col-md-4 active"><span class="jsst-number">1</span><span class="jsst-text"><?php echo __('Configuration', 'js-support-ticket'); ?></span></div>
        <div class="js-col-md-4 active"><span class="jsst-number">2</span><span class="jsst-text"><?php echo __('Permissions', 'js-support-ticket'); ?></span></div>
        <div class="js-col-md-4 active"><span class="jsst-number">3</span><span class="jsst-text"><?php echo __('Installation', 'js-support-ticket'); ?></span></div>
        <div class="js-col-md-4"><span class="jsst-number">4</span><span class="jsst-text"><?php echo __('Finish', 'js-support-ticket'); ?></span></div>        
    </div>
    <div id="jsst-lower-wrapper" class="last">
        <span class="fill_form_title"><?php echo __('Please insert activation key and press start','js-support-ticket'); ?></span>
        <div class="form">
            <input type="text" name="transactionkey" id="transactionkey" value="" placeholder="<?php echo __('Activation key','js-support-ticket'); ?>"/>
            <a href="#" class="nextbutton" id="startpress"><?php echo __('Start','js-support-ticket'); ?></a>
            <input type="hidden" name="productcode" id="productcode" value="<?php echo isset(jssupportticket::$_config['productcode']) ? jssupportticket::$_config['productcode'] : 'jsticket'; ?>" />
            <input type="hidden" name="productversion" id="productversion" value="<?php echo isset(jssupportticket::$_config['versioncode']) ? jssupportticket::$_config['versioncode'] : '102'; ?>" />
            <input type="hidden" name="producttype" id="producttype" value="pro" />
            <input type="hidden" name="domain" id="domain" value="<?php echo site_url(); ?>" />
            <input type="hidden" name="JVERSION" id="JVERSION" value="<?php echo get_bloginfo('version'); ?>" />
        </div>
    </div>
    <div id="jsst_error_message"></div>
    <div id="jsst_next_form"></div>
    <div class="last-message">
        <?php echo __('It may take few minutes','js-support-ticket'); ?>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function($){
        $("a#startpress").click(function(e){
            e.preventDefault();
            var transactionkey = $("input#transactionkey").val();
            var productcode = $("input#productcode").val();
            var productversion = $("input#productversion").val();
            var producttype = $("input#producttype").val();
            var domain = $("input#domain").val();
            var JVERSION = $("input#JVERSION").val();
            if(transactionkey.length < 5){
                setTimeout(function() {
                    // Do something after 5 seconds
                    $("div#jsst_error_message").html('Invalid transaction key.').show();
                }, 4000);
            }else{
                $.post(ajaxurl,{action:'jsticket_ajax',jstmod:'proinstaller',task:'getmyversionlist',transactionkey:transactionkey,productcode:productcode,productversion:productversion,domain:domain,JVERSION:JVERSION,producttype:producttype},function(data){
                        if(data){
                            var array = $.parseJSON(data);
                            if(array[0] == 0){
                                $("div#jsst_error_message").html(array[1]).show();
                            }else{
                                $("div#jsst_next_form").html(array[1]).show();
                            }
                        }
                    });
            }
        });
    });
</script>
