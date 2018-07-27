<?php
   if(!defined('ABSPATH'))
    die('Restricted Access');
?>
<div id="jssupportticketadmin-wrapper">
    <?php JSSTmessage::getMessage(); ?>

<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Translations','js-support-ticket'); ?></span></span>

    <div id="jssupportticket-content">
        <div id="black_wrapper_translation"></div>
        <div id="jstran_loading">
            <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/spinning-wheel.gif" />
        </div>

        <div id="js-language-wrapper">
            <div class="jstopheading"><?php echo __('Get JS Support Ticket Translations','js-support-ticket'); ?></div>
            <div id="gettranslation" class="gettranslation"><img style="width:18px; height:auto;" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/download-icon.png" /><?php echo __('Get Translations','js-support-ticket'); ?></div>
            <div id="js_ddl">
                <span class="title"><?php echo __('Select Translation','js-support-ticket'); ?>:</span>
                <span class="combo" id="js_combo"></span>
                <span class="button" id="jsdownloadbutton"><img style="width:14px; height:auto;" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/download-icon.png" /><?php echo __('Download','js-support-ticket'); ?></span>
                <div id="jscodeinputbox" class="js-some-disc"></div>
                <div class="js-some-disc"><img style="width:18px; height:auto;" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/info-icon.png" /><?php echo __('When WordPress language change to ro, JS Support Ticket language will auto change to ro'); ?></div>
            </div>
            <div id="js-emessage-wrapper">
                <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/c_error.png" />
                <div id="jslang_em_text"></div>
            </div>
            <div id="js-emessage-wrapper_ok">
                <img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/saved.png" />
                <div id="jslang_em_text_ok"></div>
            </div>
        </div>
        <div id="js-lang-toserver">
            <div class="js-col-xs-12 js-col-md-8 col"><a class="anc one" href="https://www.transifex.com/joom-sky/js-support-ticket" target="_blank"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/translation-icon.png" /><?php echo __('Contribute In Translation','js-support-ticket'); ?></a></div>
            <div class="js-col-xs-12 js-col-md-4 col"><a class="anc two" href="http://www.joomsky.com/translations.html" target="_blank"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/manual-download.png" /><?php echo __('Mannual Download','js-support-ticket'); ?></a></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var ajaxurl = "<?php echo admin_url('admin-ajax.php') ?>";
    jQuery(document).ready(function(){
        jQuery('#gettranslation').click(function(){
            jsShowLoading();
            jQuery.post(ajaxurl, {action: 'jsticket_ajax', jstmod: 'jssupportticket', task: 'getListTranslations'}, function (data) {
                if (data) {
                    console.log(data);
                    jsHideLoading();
                    data = JSON.parse(data);
                    if(data['error']){
                        jQuery('#js-emessage-wrapper div').html(data['error']);
                        jQuery('#js-emessage-wrapper').show();
                    }else{
                        jQuery('#js-emessage-wrapper').hide();
                        jQuery('#gettranslation').hide();
                        jQuery('div#js_ddl').show();
                        jQuery('span#js_combo').html(data['data']);
                    }
                }
            });
        });
        
        jQuery(document).on('change', 'select#translations' ,function() {
            var lang_name = jQuery( this ).val();
            if(lang_name != ''){
                jQuery('#js-emessage-wrapper_ok').hide();
                jsShowLoading();
                jQuery.post(ajaxurl, {action: 'jsticket_ajax', jstmod: 'jssupportticket', task: 'validateandshowdownloadfilename',langname:lang_name}, function (data) {
                    console.log(data);
                    if (data) {
                        jsHideLoading();
                        data = JSON.parse(data);
                        if(data['error']){
                            jQuery('#js-emessage-wrapper div').html(data['error']);
                            jQuery('#js-emessage-wrapper').show();
                            jQuery('#jscodeinputbox').slideUp('400' , 'swing' , function(){
                                jQuery('input#languagecode').val("");
                            });
                        }else{
                            jQuery('#js-emessage-wrapper').hide();
                            jQuery('#jscodeinputbox').html(data['path']+': '+data['input']);
                            jQuery('#jscodeinputbox').slideDown();
                        }
                    }
                });
            }
        });

        jQuery('#jsdownloadbutton').click(function(){
            jQuery('#js-emessage-wrapper_ok').hide();
            var lang_name = jQuery('#translations').val();
            var file_name = jQuery('#languagecode').val();
            if(lang_name != '' && file_name != ''){
                jsShowLoading();
                jQuery.post(ajaxurl, {action: 'jsticket_ajax', jstmod: 'jssupportticket', task: 'getlanguagetranslation',langname:lang_name , filename: file_name}, function (data) {
                    if (data) {
                        console.log(data);
                        jsHideLoading();
                        data = JSON.parse(data);
                        if(data['error']){
                            jQuery('#js-emessage-wrapper div').html(data['error']);
                            jQuery('#js-emessage-wrapper').show();
                        }else{
                            jQuery('#js-emessage-wrapper').hide();
                            jQuery('#js-emessage-wrapper_ok div').html(data['data']);
                            jQuery('#js-emessage-wrapper_ok').slideDown();
                        }
                    }
                });
            }
        });
    });
    
    function jsShowLoading(){
        jQuery('div#black_wrapper_translation').show();
        jQuery('div#jstran_loading').show();
    }    

    function jsHideLoading(){
        jQuery('div#black_wrapper_translation').hide();
        jQuery('div#jstran_loading').hide();
    }
</script>