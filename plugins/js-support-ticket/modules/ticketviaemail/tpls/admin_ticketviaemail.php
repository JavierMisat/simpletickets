<?php
JSSTmessage::getMessage();
wp_enqueue_script('jquery-ui-tabs');
$enableddisabled = array(
    (object) array('id' => '1', 'text' => __('Enabled', 'js-support-ticket')),
    (object) array('id' => '2', 'text' => __('Disabled', 'js-support-ticket'))
);
$mailreadtype = array(
    (object) array('id' => '1', 'text' => __('Only New Tickets', 'js-support-ticket')),
    (object) array('id' => '2', 'text' => __('Only Replies', 'js-support-ticket')),
    (object) array('id' => '3', 'text' => __('Both', 'js-support-ticket'))
);
$hosttype = array(
    (object) array('id' => '1', 'text' => __('Gmail', 'js-support-ticket')),
    (object) array('id' => '2', 'text' => __('Yahoo', 'js-support-ticket')),
    (object) array('id' => '3', 'text' => __('Aol', 'js-support-ticket')),
    (object) array('id' => '5', 'text' => __('Hotmail', 'js-support-ticket')),
    (object) array('id' => '4', 'text' => __('Other', 'js-support-ticket'))
);
$yesno = array(
    (object) array('id' => '1', 'text' => __('JYes', 'js-support-ticket')),
    (object) array('id' => '2', 'text' => __('JNo', 'js-support-ticket'))
);
?>
<script>
    jQuery(document).ready(function () {
        jQuery(".tabs").tabs();
        jQuery("a#js-admin-ticketviaemail").click(function(e){
        	e.preventDefault();
        	var enable = jQuery('select#tve_enabled').val();
        	if(enable == 1){
        		var tve_hosttype = jQuery('select#tve_hosttype').val();
                var hostname = jQuery('input#tve_hostname').val();
        		if(tve_hosttype == 4){
        			var tve_hostname = jQuery('input#tve_hostname').val();
        			if(tve_hostname != ''){
                        var hostname = jQuery('input#tve_hostname').val();
                    }else{
                        alert('<?php echo __('Please enter the hostname first','js-support-ticket'); ?>');
                        return;
                    }
                }
				var hosttype = jQuery('select#tve_hosttype').val();
				var emailaddress = jQuery('input#tve_emailaddress').val();
				var password = jQuery('input#tve_emailpassword').val();
                var ssl = jQuery('select#tve_ssl').val();
                var hostportnumber = jQuery('input#tve_hostportnumber').val();
				jQuery("div#js-admin-ticketviaemail-bar").show();
				jQuery("div#js-admin-ticketviaemail-text").show();
	            jQuery.post(ajaxurl, {action: 'jsticket_ajax', hosttype: hosttype,hostname:hostname, emailaddress: emailaddress,password:password,ssl:ssl,hostportnumber:hostportnumber, jstmod: 'ticketviaemail', task: 'readEmailsAjax'}, function (data) {
	                if (data) {
                        jQuery("div#js-admin-ticketviaemail-bar").hide();
                        jQuery("div#js-admin-ticketviaemail-text").hide();
					    try {
		                	var obj = jQuery.parseJSON(data);
		                	if(obj.type == 0){
		                		jQuery("div#js-admin-ticketviaemail-msg").html(obj.msg).addClass('no-error');
		                	}else if(obj.type == 1){
		                		jQuery("div#js-admin-ticketviaemail-msg").html(obj.msg).addClass('imap-error');
		                	}else if(obj.type == 2){
		                		jQuery("div#js-admin-ticketviaemail-msg").html(obj.msg).addClass('email-error');
		                	}
					    } catch (e) {
					        jQuery("div#js-admin-ticketviaemail-msg").html(data).addClass('server-error');
					    }
					    jQuery("div#js-admin-ticketviaemail-msg").show();
	                }
	            });//jquery closed
        	}else{
        		alert('<?php echo __('Please enable ticket via email setting first','js-support-ticket'); ?>');
        	}        	
        });
    });
    function showhidehostname(value){
        if(value == 4){
            jQuery("div#tve_hostname").show();
        }else{
            jQuery("div#tve_hostname").hide();
        }
    }
</script>
<form method="post" action="<?php echo admin_url("?page=ticketviaemail&task=saveticketviaemail"); ?>">
<span class="js-adminhead-title js-relative"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Ticket via email', 'js-support-ticket'); ?></span><img class="js-relative-image" src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/beta_icon.png" /></span>
<div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
    <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Enabled', 'js-support-ticket') ?></div>
    <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-value"><?php echo JSSTformfield::select('tve_enabled', $enableddisabled, jssupportticket::$_data[0]['tve_enabled']); ?></div>
    <div class="js-col-xs-12 js-col-md-4"><small><?php echo __('Enable ticket via email', 'js-support-ticket'); ?></small></div>
</div>
<div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
    <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Ticket Type', 'js-support-ticket') ?></div>
    <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-value"><?php echo JSSTformfield::select('tve_mailreadtype', $mailreadtype, jssupportticket::$_data[0]['tve_mailreadtype']); ?></div>
    <div class="js-col-xs-12 js-col-md-4"><small><?php echo __('Which email type to read', 'js-support-ticket'); ?></small></div>
</div>
<div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
    <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Attachments', 'js-support-ticket') ?></div>
    <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-value"><?php echo JSSTformfield::select('tve_attachment', $yesno, jssupportticket::$_data[0]['tve_attachment']); ?></div>
    <div class="js-col-xs-12 js-col-md-4"><small><?php echo __('Save attachments if found in email', 'js-support-ticket'); ?></small></div>
</div>
<div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
    <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Host Type', 'js-support-ticket') ?></div>
    <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-value"><?php echo JSSTformfield::select('tve_hosttype', $hosttype, jssupportticket::$_data[0]['tve_hosttype'],null,array('onchange'=>'showhidehostname(this.value);')); ?></div>
    <div class="js-col-xs-12 js-col-md-4"><small><?php echo __('Select your email service provider', 'js-support-ticket'); ?></small></div>
</div>
<div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row" id="tve_hostname">
    <div class="js-nullpadding js-col-md-12">
        <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Host Name', 'js-support-ticket') ?></div>
        <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-value"><?php echo JSSTformfield::text('tve_hostname', jssupportticket::$_data[0]['tve_hostname']); ?></div>
        <div class="js-col-xs-12 js-col-md-4"><small><?php echo __('Host Name','js-support-ticket').' www.joomsky.com '.__('Or','js-support-ticket').' www.abc.com'; ?></small></div>
    </div>
    <div class="js-nullpadding js-col-md-12">
        <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Enabled SSL', 'js-support-ticket') ?></div>
        <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-value"><?php echo JSSTformfield::select('tve_ssl', $yesno, jssupportticket::$_data[0]['tve_ssl']); ?></div>
        <div class="js-col-xs-12 js-col-md-4"><small><?php echo __('Do you have enabled SSL on your domain','js-support-ticket'); ?></small></div>
    </div>
    <div class="js-nullpadding js-col-md-12">
        <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Host Port Number', 'js-support-ticket') ?></div>
        <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-value"><?php echo JSSTformfield::text('tve_hostportnumber', jssupportticket::$_data[0]['tve_hostportnumber']); ?></div>
        <div class="js-col-xs-12 js-col-md-4"><small><?php echo __('Host port number to read email from','js-support-ticket'); ?></small></div>
    </div>
</div>
<div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
    <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Email Address', 'js-support-ticket') ?></div>
    <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-value"><?php echo JSSTformfield::text('tve_emailaddress', jssupportticket::$_data[0]['tve_emailaddress']); ?></div>
    <div class="js-col-xs-12 js-col-md-4"><small><?php echo __('Email address to read emails', 'js-support-ticket'); ?></small></div>
</div>
<div class="js-col-xs-12 js-col-md-12 js-ticket-configuration-row">
    <div class="js-col-xs-12 js-col-md-3 js-ticket-configuration-title"><?php echo __('Password', 'js-support-ticket') ?></div>
    <div class="js-col-xs-12 js-col-md-4 js-ticket-configuration-value"><?php echo JSSTformfield::password('tve_emailpassword', jssupportticket::$_data[0]['tve_emailpassword']); ?></div>
    <div class="js-col-xs-12 js-col-md-4"><small><?php echo __('Password for given email address', 'js-support-ticket'); ?></small></div>
</div>
<div class="js-col-md-12 js-col-md-offset-2 js-admin-ticketviaemail-wrapper-checksetting">
	<a href="#" id="js-admin-ticketviaemail"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/tick_ticketviaemail.png" /><?php echo __('Check Settings','js-support-ticket'); ?></a>
	<div id="js-admin-ticketviaemail-bar"></div>
	<div class="js-col-md-12" id="js-admin-ticketviaemail-text"><?php echo __('If system not respond in 30 seconds','js-support-ticket').', '.__('it means system unable to connect email server','js-support-ticket'); ?></div>
    <div class="js-col-md-12">
	   <div id="js-admin-ticketviaemail-msg"></div>
   </div>
</div>
<div class="js-form-button">
    <?php echo JSSTformfield::submitbutton('save', __('Save Settings', 'js-support-ticket'), array('class' => 'button')); ?>
</div>
<h3 class="js-ticket-configuration-heading-main"><?php echo __('Cron Job','js-support-ticket') ?></h3>
<div id="cp_wraper">
    <?php $array = array('even', 'odd');
    $k = 0; ?>
    <div id="tabs" class="tabs">
        <ul>
            <li><a class="selected" data-css="controlpanel" href="#webcrown"><?php echo __('Web Cron Job','js-support-ticket'); ?></a></li>
            <li><a  data-css="controlpanel" href="#wget"><?php echo __('Wget','js-support-ticket'); ?></a></li> 
            <li><a  data-css="controlpanel" href="#curl"><?php echo __('Curl','js-support-ticket'); ?></a></li> 
            <li><a  data-css="controlpanel" href="#phpscript"><?php echo __('PHP Script','js-support-ticket'); ?></a></li> 
            <li><a  data-css="controlpanel" href="#url"><?php echo __('URL','js-support-ticket'); ?></a></li> 
        </ul>
        <div class="tabInner">
        <div id="webcrown">
            <div id="cron_job">
                <span class="crown_text"><?php echo __('Configuration of a backup job with webcron org','js-support-ticket'); ?></span>
                <div id="cron_job_detail_wrapper" class="<?php echo $array[$k];$k = 1 - $k; ?>">
                    <span class="crown_text_left">
                        <?php echo __('Name of cron job','js-support-ticket'); ?>
                    </span>
                    <span class="crown_text_right"><?php echo __('Log in to webcron org in the cron area click on','js-support-ticket'); ?></span>
                </div>
                <div id="cron_job_detail_wrapper" class="<?php echo $array[$k];$k = 1 - $k; ?>">
                    <span class="crown_text_left">
                        <?php echo __('Timeout','js-support-ticket'); ?>
                    </span>
                    <span class="crown_text_right"><?php echo __('180 sec if the doesnot complete increase it most sites will work with a setting of 180 600','js-support-ticket'); ?></span>
                </div>
                <div id="cron_job_detail_wrapper" class="<?php echo $array[$k];$k = 1 - $k; ?>">
                    <span class="crown_text_left"><?php echo __('URL you want to execute','js-support-ticket'); ?></span>
                    <span class="crown_text_right">
                        <?php echo site_url('index.php?page_id='.jssupportticket::getPageID().'&jstmod=ticketviaemail&action=jstask&task=readEmails'); ?>
                    </span>
                </div>
                <div id="cron_job_detail_wrapper" class="<?php echo $array[$k];$k = 1 - $k; ?>">
                    <span class="crown_text_left"><?php echo __('Login','js-support-ticket'); ?></span>
                    <span class="crown_text_right">
                        <?php echo __('Leave this blank','js-support-ticket'); ?>
                    </span>
                </div>
                <div id="cron_job_detail_wrapper" class="<?php echo $array[$k];$k = 1 - $k; ?>">
                    <span class="crown_text_left"><?php echo __('Password','js-support-ticket'); ?></span>
                    <span class="crown_text_right"><?php echo __('Leave this blank','js-support-ticket'); ?></span>
                </div>
                <div id="cron_job_detail_wrapper" class="<?php echo $array[$k];$k = 1 - $k; ?>">
                    <span class="crown_text_left">
                        <?php echo __('Execution time','js-support-ticket'); ?>
                    </span>
                    <span class="crown_text_right">
                        <?php echo __('That the grid below the other options select when and how','js-support-ticket'); ?>
                    </span>
                </div>
                <div id="cron_job_detail_wrapper" class="<?php echo $array[$k];$k = 1 - $k; ?>">
                    <span class="crown_text_left"><?php echo __('Alerts','js-support-ticket'); ?></span>
                    <span class="crown_text_right">
                    <?php echo __('If you have already set up alerts methods in webcron org interface we recommend choosing an alert','js-support-ticket'); ?>
                    </span>
                </div>
            </div>  
        </div>
        <div id="wget">
            <div id="cron_job">
                <span class="crown_text"><?php echo __('Cron scheduling using wget','js-support-ticket'); ?></span>
                <div id="cron_job_detail_wrapper" class="even">
                    <span class="crown_text_right fullwidth">
                    <?php echo 'wget --max-redirect=10000 "' . site_url('index.php?page_id='.jssupportticket::getPageID().'&jstmod=ticketviaemail&action=jstask&task=readEmails').'" -O - 1>/dev/null 2>/dev/null '; ?>
                    </span>
                </div>
            </div>  
        </div>
        <div id="curl">
            <div id="cron_job">
                <span class="crown_text"><?php echo __('Cron scheduling using Curl','js-support-ticket'); ?></span>
                <div id="cron_job_detail_wrapper" class="even">
                    <span class="crown_text_right fullwidth">
                    <?php echo 'curl "' . site_url('index.php?page_id='.jssupportticket::getPageID().'&jstmod=ticketviaemail&action=jstask&task=readEmails').'"<br>' . __('OR','js-support-ticket') . '<br>'; ?>
                    <?php echo 'curl -L --max-redirs 1000 -v "' . site_url('index.php?page_id='.jssupportticket::getPageID().'&jstmod=ticketviaemail&action=jstask&task=readEmails').'" 1>/dev/null 2>/dev/null '; ?>
                    </span>
                </div>
            </div>  
        </div>
        <div id="phpscript">
            <div id="cron_job">
                <span class="crown_text">
                        <?php echo __('Custom PHP script to run the cron job','js-support-ticket'); ?>
                </span>
                <div id="cron_job_detail_wrapper" class="even">
                    <span class="crown_text_right fullwidth">
                        <?php
                        echo '  $curl_handle=curl_init();<br>
                                    curl_setopt($curl_handle, CURLOPT_URL, \'' . site_url('index.php?page_id='.jssupportticket::getPageID().'&jstmod=ticketviaemail&action=jstask&task=readEmails').'\');<br>
                                    curl_setopt($curl_handle,CURLOPT_FOLLOWLOCATION, TRUE);<br>
                                    curl_setopt($curl_handle,CURLOPT_MAXREDIRS, 10000);<br>
                                    curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER, 1);<br>
                                    $buffer = curl_exec($curl_handle);<br>
                                    curl_close($curl_handle);<br>
                                    if (empty($buffer))<br>
                                    &nbsp;&nbsp;echo "' . __('Sorry the cron job didnot work','js-support-ticket') . '";<br>
                                    else<br>
                                    &nbsp;&nbsp;echo $buffer;<br>
                                    ';
                        ?>
                    </span>
                </div>
            </div>  
        </div>
        <div id="url">
            <div id="cron_job">
                <span class="crown_text"><?php echo __('URL for use with your won scripts and third party','js-support-ticket'); ?></span>
                <div id="cron_job_detail_wrapper" class="even">
                    <span class="crown_text_right fullwidth"><?php echo site_url('index.php?page_id='.jssupportticket::getPageID().'&jstmod=ticketviaemail&action=jstask&task=readEmails'); ?></span>
                </div>
            </div>  
        </div>
        <div id="cron_job">
            <span style="float:left;margin-right:4px;"><?php echo __('Recommended run script hourly','js-support-ticket'); ?></span>
        </div>  
        </div>
    </div>
</div>
    <?php echo JSSTformfield::hidden('action', 'ticketviaemail_saveticketviaemail'); ?>
    <?php echo JSSTformfield::hidden('form_request', 'jssupportticket'); ?>
</form>
<script type="text/javascript">
    showhidehostname(<?php echo jssupportticket::$_data[0]['tve_hosttype']; ?>);
</script>
