<?php
    $filepath = jssupportticket::$_path . 'includes/css/style.php';
    $filestring = file_get_contents($filepath);
    $color1 = JSSTincluder::getJSModel('jssupportticket')->getColorCode($filestring, 1);
    $color3 = JSSTincluder::getJSModel('jssupportticket')->getColorCode($filestring, 3);
?>
<span class="js-adminhead-title"><a class="jsanchor-backlink" href="<?php echo admin_url('admin.php?page=jssupportticket&jstlay=controlpanel');?>"><img src="<?php echo jssupportticket::$_pluginpath; ?>includes/images/back-icon.png" /></a><span class="jsheadtext"><?php echo __('Short Codes','js-support-ticket'); ?></span>
</span>

<div id="jsst-shortcode-wrapper">
	<div class="jsst-shortcode-1"><?php echo __('JS Support Ticket Control Panel','js-support-ticket'); ?></div>
	<div class="jsst-shortcode-2"><?php echo "[jssupportticket]"; ?></div>
	<div class="jsst-shortcode-3"><?php echo __("JS Support Ticket main control panel",'js-support-ticket'); ?></div>
</div>
<div id="jsst-shortcode-wrapper">
	<div class="jsst-shortcode-1"><?php echo __('Add Ticket','js-support-ticket'); ?></div>
	<div class="jsst-shortcode-2"><?php echo "[jssupportticket_addticket]"; ?></div>
	<div class="jsst-shortcode-3"><?php echo __("Add new ticket form for both user and staff",'js-support-ticket'); ?></div>
</div>
<div id="jsst-shortcode-wrapper">
	<div class="jsst-shortcode-1"><?php echo __('My Tickets','js-support-ticket'); ?></div>
	<div class="jsst-shortcode-2"><?php echo "[jssupportticket_mytickets]"; ?></div>
	<div class="jsst-shortcode-3"><?php echo __("My tickets for both user and staff",'js-support-ticket'); ?></div>
</div>
<div id="jsst-shortcode-wrapper">
	<div class="jsst-shortcode-1"><?php echo __('Downloads','js-support-ticket'); ?></div>
	<div class="jsst-shortcode-2"><?php echo "[jssupportticket_downloads]"; ?></div>
	<div class="jsst-shortcode-3"><?php echo __("List downloads",'js-support-ticket'); ?></div>
</div>
<div id="jsst-shortcode-wrapper">
	<div class="jsst-shortcode-1"><?php echo __('Lastest Downlods','js-support-ticket'); ?></div>
	<div class="jsst-shortcode-2"><?php echo "[jssupportticket_downloads_latest]"; ?></div>
	<div class="jsst-shortcode-3"><?php echo __("Show latest downloads. Options:",'js-support-ticket').' text_color="'.$color3.'" '.__("and",'js-support-ticket').' background_color="'.$color1.'" '.__("i.e.",'js-support-ticket').' [jssupportticket_downloads_latest text_color="'.$color3.'" background_color="'.$color1.'"]'; ?></div>
</div>
<div id="jsst-shortcode-wrapper">
	<div class="jsst-shortcode-1"><?php echo __('Popular Downloads','js-support-ticket'); ?></div>
	<div class="jsst-shortcode-2"><?php echo "[jssupportticket_downloads_popular]"; ?></div>
	<div class="jsst-shortcode-3"><?php echo __("Show popular downloads. Options:",'js-support-ticket').' text_color="'.$color3.'" '.__("and",'js-support-ticket').' background_color="'.$color1.'" '.__("i.e.",'js-support-ticket').' [jssupportticket_downloads_popular text_color="'.$color3.'" background_color="'.$color1.'"]'; ?></div>
</div>
<div id="jsst-shortcode-wrapper">
	<div class="jsst-shortcode-1"><?php echo __('Knowledge Base','js-support-ticket'); ?></div>
	<div class="jsst-shortcode-2"><?php echo "[jssupportticket_knowledgebase]"; ?></div>
	<div class="jsst-shortcode-3"><?php echo __("List knowledge base",'js-support-ticket'); ?></div>
</div>
<div id="jsst-shortcode-wrapper">
	<div class="jsst-shortcode-1"><?php echo __('Latest knowledge base','js-support-ticket'); ?></div>
	<div class="jsst-shortcode-2"><?php echo "[jssupportticket_knowledgebase_latest]"; ?></div>
	<div class="jsst-shortcode-3"><?php echo __("Show latest knowledge base. Options:",'js-support-ticket').' text_color="'.$color3.'" '.__("and",'js-support-ticket').' background_color="'.$color1.'" '.__("i.e.",'js-support-ticket').' [jssupportticket_knowledgebase_latest text_color="'.$color3.'" background_color="'.$color1.'"]'; ?></div>
</div>
<div id="jsst-shortcode-wrapper">
	<div class="jsst-shortcode-1"><?php echo __('Popular knoweldge base','js-support-ticket'); ?></div>
	<div class="jsst-shortcode-2"><?php echo "[jssupportticket_knowledgebase_popular]"; ?></div>
	<div class="jsst-shortcode-3"><?php echo __("Show popular knowledge base. Options:",'js-support-ticket').' text_color="'.$color3.'" '.__("and",'js-support-ticket').' background_color="'.$color1.'" '.__("i.e.",'js-support-ticket').' [jssupportticket_knowledgebase_popular text_color="'.$color3.'" background_color="'.$color1.'"]'; ?></div>
</div>
<div id="jsst-shortcode-wrapper">
	<div class="jsst-shortcode-1"><?php echo __("FAQ's",'js-support-ticket'); ?></div>
	<div class="jsst-shortcode-2"><?php echo "[jssupportticket_faqs]"; ?></div>
	<div class="jsst-shortcode-3"><?php echo __("List FAQ's",'js-support-ticket'); ?></div>
</div>
<div id="jsst-shortcode-wrapper">
	<div class="jsst-shortcode-1"><?php echo __("Latest FAQ's",'js-support-ticket'); ?></div>
	<div class="jsst-shortcode-2"><?php echo "[jssupportticket_faqs_latest]"; ?></div>
	<div class="jsst-shortcode-3"><?php echo __("Show latest FAQ's. Options:",'js-support-ticket').' text_color="'.$color3.'" '.__("and",'js-support-ticket').' background_color="'.$color1.'" '.__("i.e.",'js-support-ticket').' [jssupportticket_faqs_latest text_color="'.$color3.'" background_color="'.$color1.'"]'; ?></div>
</div>
<div id="jsst-shortcode-wrapper">
	<div class="jsst-shortcode-1"><?php echo __("Popular FAQ's",'js-support-ticket'); ?></div>
	<div class="jsst-shortcode-2"><?php echo "[jssupportticket_faqs_popular]"; ?></div>
	<div class="jsst-shortcode-3"><?php echo __("Show popular FAQ's. Options:",'js-support-ticket').' text_color="'.$color3.'" '.__("and",'js-support-ticket').' background_color="'.$color1.'" '.__("i.e.",'js-support-ticket').' [jssupportticket_faqs_popular text_color="'.$color3.'" background_color="'.$color1.'"]'; ?></div>
</div>
<div id="jsst-shortcode-wrapper">
	<div class="jsst-shortcode-1"><?php echo __('Announcements','js-support-ticket'); ?></div>
	<div class="jsst-shortcode-2"><?php echo "[jssupportticket_announcements]"; ?></div>
	<div class="jsst-shortcode-3"><?php echo __("List announcements",'js-support-ticket'); ?></div>
</div>
<div id="jsst-shortcode-wrapper">
	<div class="jsst-shortcode-1"><?php echo __('Latest Announcements','js-support-ticket'); ?></div>
	<div class="jsst-shortcode-2"><?php echo "[jssupportticket_announcements_latest]"; ?></div>
	<div class="jsst-shortcode-3"><?php echo __("Show latest announcements. Options:",'js-support-ticket').' text_color="'.$color3.'" '.__("and",'js-support-ticket').' background_color="'.$color1.'" '.__("i.e.",'js-support-ticket').' [jssupportticket_announcements_latest text_color="'.$color3.'" background_color="'.$color1.'"]'; ?></div>
</div>
<div id="jsst-shortcode-wrapper">
	<div class="jsst-shortcode-1"><?php echo __('Popular Announcements','js-support-ticket'); ?></div>
	<div class="jsst-shortcode-2"><?php echo "[jssupportticket_announcements_popular]"; ?></div>
	<div class="jsst-shortcode-3"><?php echo __("Show popular announcements. Options:",'js-support-ticket').' text_color="'.$color3.'" '.__("and",'js-support-ticket').' background_color="'.$color1.'" '.__("i.e.",'js-support-ticket').' [jssupportticket_announcements_popular text_color="'.$color3.'" background_color="'.$color1.'"]'; ?></div>
</div>
