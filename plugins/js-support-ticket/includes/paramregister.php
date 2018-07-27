<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

add_filter('wp_insert_post_data', 'filter_handler_jssupportticket_slug', '99', 2);

function filter_handler_jssupportticket_slug($data, $postarr) {
    // do something with the post data
    $query = 'SELECT configvalue FROM `' . jssupportticket::$_db->prefix . 'js_ticket_config` WHERE configname = "system_slug"';
    $system_slug = jssupportticket::$_db->get_var($query);
    if ($data['post_name'] == $system_slug) {
        $data['post_name'] = $system_slug . '1';
    }
    return $data;
}

add_action('save_post', 'jsticket_update_rules');

function jsticket_update_rules($post_id) {
    update_option('rewrite_rules', '');
}

add_action('customize_save_after', 'jsst_customizersaveafter');

function jsst_customizersaveafter() {
    update_option('rewrite_rules', '');
}

function getParamsForJSSTTICKET(){
    $frontpage_id = get_option('page_on_front');
    $query = 'SELECT configvalue FROM `' . jssupportticket::$_db->prefix . 'js_ticket_config` WHERE configname = "system_slug"';
    $system_slug = jssupportticket::$_db->get_var($query);

    //Layout Edit specific rules here
    //ticketdetail
    $new_rules['(.?.+?)/'.$system_slug.'/ticketdetail/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=$matches[2]';
    $new_rules[$system_slug.'/ticketdetail/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=$matches[1]';
    

    //staffaddticket
    $new_rules['(.?.+?)/'.$system_slug.'/staffaddticket/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=ticket&jstlay=staffaddticket&jssupportticketid=$matches[2]';
    $new_rules[$system_slug.'/staffaddticket/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=ticket&jstlay=staffaddticket&jssupportticketid=$matches[1]';
    
    //announcements
    $new_rules['(.?.+?)/'.$system_slug.'/announcements/(.?.+?)/jsst-search/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=announcement&jstlay=announcements&jssupportticketid=$matches[2]&jsst-search=$matches[3]';
    $new_rules[$system_slug.'/announcements/(.?.+?)/jsst-search/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=announcement&jstlay=announcements&jssupportticketid=$matches[1]&jsst-search=$matches[2]';
    $new_rules['(.?.+?)/'.$system_slug.'/announcements/jsst-search/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=announcement&jstlay=announcements&jsst-search=$matches[2]';
    $new_rules[$system_slug.'/announcements/jsst-search/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=announcement&jstlay=announcements&jsst-search=$matches[1]';
    $new_rules['(.?.+?)/'.$system_slug.'/announcements/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=announcement&jstlay=announcements&jssupportticketid=$matches[2]';
    $new_rules[$system_slug.'/announcements/jsst-search/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=announcement&jstlay=announcements&jsst-search=$matches[1]';
    $new_rules[$system_slug.'/announcements/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=announcement&jstlay=announcements&jssupportticketid=$matches[1]';
    
    //rolepermission
    $new_rules['(.?.+?)/'.$system_slug.'/rolepermission/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=role&jstlay=rolepermission&jssupportticketid=$matches[2]';
    $new_rules[$system_slug.'/rolepermission/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=role&jstlay=rolepermission&jssupportticketid=$matches[1]';
    
    //downloads
    $new_rules[$system_slug.'/downloads/(.?.+?)/jsst-search/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=download&jstlay=downloads&jssupportticketid=$matches[1]&jsst-search=$matches[2]';
    $new_rules['(.?.+?)/'.$system_slug.'/downloads/(.?.+?)/jsst-search/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=download&jstlay=downloads&jssupportticketid=$matches[2]&jsst-search=$matches[3]';
    $new_rules[$system_slug.'/downloads/jsst-search/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=download&jstlay=downloads&jsst-search=$matches[1]';
    $new_rules['(.?.+?)/'.$system_slug.'/downloads/jsst-search/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=download&jstlay=downloads&jsst-search=$matches[2]';
    $new_rules['(.?.+?)/'.$system_slug.'/downloads/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=download&jstlay=downloads&jssupportticketid=$matches[2]';
    $new_rules[$system_slug.'/downloads/jsst-search/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=download&jstlay=downloads&jsst-search=$matches[1]';
    $new_rules[$system_slug.'/downloads/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=download&jstlay=downloads&jssupportticketid=$matches[1]';
    
    //faqs
    $new_rules['(.?.+?)/'.$system_slug.'/faqs/(.?.+?)/jsst-search/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=faq&jstlay=faqs&jssupportticketid=$matches[2]&jsst-search=$matches[3]';
    $new_rules[$system_slug.'/faqs/(.?.+?)/jsst-search/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=faq&jstlay=faqs&jssupportticketid=$matches[1]&jsst-search=$matches[2]';
    $new_rules['(.?.+?)/'.$system_slug.'/faqs/jsst-search/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=faq&jstlay=faqs&jsst-search=$matches[2]';
    $new_rules[$system_slug.'/faqs/jsst-search/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=faq&jstlay=faqs&jsst-search=$matches[1]';
    $new_rules['(.?.+?)/'.$system_slug.'/faqs/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=faq&jstlay=faqs&jssupportticketid=$matches[2]';
    $new_rules[$system_slug.'/faqs/jsst-search/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=faq&jstlay=faqs&jsst-search=$matches[1]';
    $new_rules[$system_slug.'/faqs/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=faq&jstlay=faqs&jssupportticketid=$matches[1]';

    //faqdetails
    $new_rules['(.?.+?)/'.$system_slug.'/faqdetails/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=faq&jstlay=faqdetails&jssupportticketid=$matches[2]';
    $new_rules[$system_slug.'/faqdetails/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=faq&jstlay=faqdetails&jssupportticketid=$matches[1]';
	$new_rules['(.?.+?)/'.$system_slug.'/faqdetails/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=faq&jstlay=faqdetails&jssupportticketid=$matches[2]';
	$new_rules[$system_slug.'/faqdetails/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=faq&jstlay=faqdetails&jssupportticketid=$matches[1]';
    
    //announcementdetails
    $new_rules['(.?.+?)/'.$system_slug.'/announcementdetails/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=announcement&jstlay=announcementdetails&jssupportticketid=$matches[2]';
    $new_rules['(.?.+?)/'.$system_slug.'/announcementdetails/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=announcement&jstlay=announcementdetails&jssupportticketid=$matches[2]';
    $new_rules[$system_slug.'/announcementdetails/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=announcement&jstlay=announcementdetails&jssupportticketid=$matches[1]';
    $new_rules[$system_slug.'/announcementdetails/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=announcement&jstlay=announcementdetails&jssupportticketid=$matches[1]';
    
    //addannouncement
    $new_rules['(.?.+?)/'.$system_slug.'/addannouncement/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=announcement&jstlay=addannouncement&jssupportticketid=$matches[2]';
    $new_rules[$system_slug.'/addannouncement/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=announcement&jstlay=addannouncement&jssupportticketid=$matches[1]';
    
    //adddepartment
    $new_rules['(.?.+?)/'.$system_slug.'/adddepartment/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=department&jstlay=adddepartment&jssupportticketid=$matches[2]';
    $new_rules[$system_slug.'/adddepartment/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=department&jstlay=adddepartment&jssupportticketid=$matches[1]';
    
    //adddownload
    $new_rules['(.?.+?)/'.$system_slug.'/adddownload/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=download&jstlay=adddownload&jssupportticketid=$matches[2]';
    $new_rules[$system_slug.'/adddownload/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=download&jstlay=adddownload&jssupportticketid=$matches[1]';
    
    //addfaq
    $new_rules['(.?.+?)/'.$system_slug.'/addfaq/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=faq&jstlay=addfaq&jssupportticketid=$matches[2]';
    $new_rules[$system_slug.'/addfaq/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=faq&jstlay=addfaq&jssupportticketid=$matches[1]';
    
    //addarticle
    $new_rules['(.?.+?)/'.$system_slug.'/addarticle/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=knowledgebase&jstlay=addarticle&jssupportticketid=$matches[2]';
    $new_rules[$system_slug.'/addarticle/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=knowledgebase&jstlay=addarticle&jssupportticketid=$matches[1]';
    
    //addcategory
    $new_rules['(.?.+?)/'.$system_slug.'/addcategory/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=knowledgebase&jstlay=addcategory&jssupportticketid=$matches[2]';
    $new_rules[$system_slug.'/addcategory/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=knowledgebase&jstlay=addcategory&jssupportticketid=$matches[1]';
    
    //userknowledgebasearticles
    $new_rules['(.?.+?)/'.$system_slug.'/userknowledgebasearticles/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=knowledgebase&jstlay=userknowledgebasearticles&jssupportticketid=$matches[2]';
    $new_rules[$system_slug.'/userknowledgebasearticles/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=knowledgebase&jstlay=userknowledgebasearticles&jssupportticketid=$matches[1]';
    
    //articledetails
    $new_rules['(.?.+?)/'.$system_slug.'/articledetails/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=knowledgebase&jstlay=articledetails&jssupportticketid=$matches[2]';
    $new_rules[$system_slug.'/articledetails/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=knowledgebase&jstlay=articledetails&jssupportticketid=$matches[1]';
    
    //formessage
    $new_rules['(.?.+?)/'.$system_slug.'/formmessage/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=mail&jstlay=formmessage&jssupportticketid=$matches[2]';
    $new_rules[$system_slug.'/formmessage/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=mail&jstlay=formmessage&jssupportticketid=$matches[1]';
    
    //message
    $new_rules['(.?.+?)/'.$system_slug.'/message/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=mail&jstlay=message&jssupportticketid=$matches[2]';
    $new_rules[$system_slug.'/message/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=mail&jstlay=message&jssupportticketid=$matches[1]';
    
    //inbox
    $new_rules[$system_slug.'/inbox/jsst-subject/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=mail&jstlay=inbox&jsst-subject=$matches[1]';
    $new_rules['(.?.+?)/'.$system_slug.'/inbox/jsst-subject/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=mail&jstlay=inbox&jsst-subject=$matches[2]';
    $new_rules[$system_slug.'/inbox/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=mail&jstlay=inbox&jssupportticketid=$matches[1]';
    $new_rules['(.?.+?)/'.$system_slug.'/inbox/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=mail&jstlay=inbox&jssupportticketid=$matches[2]';
    
    //outbox
    $new_rules['(.?.+?)/'.$system_slug.'/outbox/jsst-subject/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=mail&jstlay=outbox&jsst-subject=$matches[2]';
    $new_rules[$system_slug.'/outbox/jsst-subject/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=mail&jstlay=outbox&jsst-subject=$matches[1]';
    $new_rules['(.?.+?)/'.$system_slug.'/outbox/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=mail&jstlay=outbox&jssupportticketid=$matches[2]';
    $new_rules[$system_slug.'/outbox/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=mail&jstlay=outbox&jssupportticketid=$matches[1]';
    
    //addrole
    $new_rules['(.?.+?)/'.$system_slug.'/addrole/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=role&jstlay=addrole&jssupportticketid=$matches[2]';
    $new_rules[$system_slug.'/addrole/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=role&jstlay=addrole&jssupportticketid=$matches[1]';
    
    //addstaff
    $new_rules['(.?.+?)/'.$system_slug.'/addstaff/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=staff&jstlay=addstaff&jssupportticketid=$matches[2]';
    $new_rules[$system_slug.'/addstaff/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=staff&jstlay=addstaff&jssupportticketid=$matches[1]';
    
    //staffpermissions
    $new_rules['(.?.+?)/'.$system_slug.'/staffpermissions/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=staff&jstlay=staffpermissions&jssupportticketid=$matches[2]';
    $new_rules[$system_slug.'/staffpermissions/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=staff&jstlay=staffpermissions&jssupportticketid=$matches[1]';

    //myticket
    $new_rules['(.?.+?)/'.$system_slug.'/myticket/(.?.+?)/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=ticket&jstlay=myticket&list=$matches[2]&sortby=$matches[3]';
	$new_rules['(.?.+?)/'.$system_slug.'/myticket/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=ticket&jstlay=myticket&list=$matches[2]';
    $new_rules['(.?.+?)/'.$system_slug.'/myticket/jsst-ticketsearchkeys/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=ticket&jstlay=myticket&jsst-ticketsearchkeys=$matches[2]';
    $new_rules[$system_slug.'/myticket/(.?.+?)/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=ticket&jstlay=myticket&list=$matches[1]&sortby=$matches[2]';
    $new_rules[$system_slug.'/myticket/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=ticket&jstlay=myticket&list=$matches[1]';
    $new_rules[$system_slug.'/myticket/jsst-ticketsearchkeys/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=ticket&jstlay=myticket&jsst-ticketsearchkeys=$matches[1]';
    
    //staffmyticket
    $new_rules['(.?.+?)/'.$system_slug.'/staffmyticket/(.?.+?)/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=ticket&jstlay=staffmyticket&list=$matches[2]&sortby=$matches[3]';
    $new_rules['(.?.+?)/'.$system_slug.'/staffmyticket/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=ticket&jstlay=staffmyticket&list=$matches[2]';
    $new_rules['(.?.+?)/'.$system_slug.'/staffmyticket/jsst-ticketsearchkeys/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=ticket&jstlay=staffmyticket&jsst-ticketsearchkeys=$matches[2]';
    $new_rules[$system_slug.'/staffmyticket/(.?.+?)/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=ticket&jstlay=staffmyticket&list=$matches[1]&sortby=$matches[2]';
    $new_rules[$system_slug.'/staffmyticket/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=ticket&jstlay=staffmyticket&list=$matches[1]';
    $new_rules[$system_slug.'/staffmyticket/jsst-ticketsearchkeys/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=ticket&jstlay=staffmyticket&jsst-ticketsearchkeys=$matches[1]';

    //announcements
    $new_rules['(.?.+?)/'.$system_slug.'/announcements/jsst-search/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=announcement&jstlay=announcements&jsst-search=$matches[2]';
    $new_rules[$system_slug.'/announcements/jsst-search/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=announcement&jstlay=announcements&jsst-search=$matches[1]';

    //faqs
    $new_rules['(.?.+?)/'.$system_slug.'/faqs/jsst-search/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=faq&jstlay=faqs&jsst-search=$matches[2]';
    $new_rules[$system_slug.'/faqs/jsst-search/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=faq&jstlay=faqs&jsst-search=$matches[1]';

    //userknowledegbase
    $new_rules['(.?.+?)/'.$system_slug.'/userknowledgebase/jsst-search/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=knowledgebase&jstlay=userknowledgebase&jsst-search=$matches[2]';
    $new_rules[$system_slug.'/userknowledgebase/jsst-search/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=knowledgebase&jstlay=userknowledgebase&jsst-search=$matches[1]';
    
    //departments
    $new_rules['(.?.+?)/'.$system_slug.'/departments/jsst-search/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=department&jstlay=departments&jsst-search=$matches[2]';
    $new_rules['(.?.+?)/'.$system_slug.'/departments/jsst-dept/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=department&jstlay=departments&jsst-dept=$matches[2]';
    $new_rules[$system_slug.'/departments/jsst-search/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=department&jstlay=departments&jsst-search=$matches[1]';
    $new_rules[$system_slug.'/departments/jsst-dept/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=department&jstlay=departments&jsst-dept=$matches[1]';
    
    //inbox
    $new_rules['(.?.+?)/'.$system_slug.'/inbox/jsst-subject/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=mail&jstlay=inbox&jsst-subject=$matches[2]';
    $new_rules[$system_slug.'/inbox/jsst-subject/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=mail&jstlay=inbox&jsst-subject=$matches[1]';
    
    //outbox
    $new_rules['(.?.+?)/'.$system_slug.'/outbox/jsst-subject/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=mail&jstlay=outbox&jsst-subject=$matches[2]';
    $new_rules[$system_slug.'/outbox/jsst-subject/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=mail&jstlay=outbox&jsst-subject=$matches[1]';
    
    //roles
    $new_rules['(.?.+?)/'.$system_slug.'/roles/jsst-role/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=role&jstlay=roles&jsst-role=$matches[2]';
    $new_rules[$system_slug.'/roles/jsst-role/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=role&jstlay=roles&jsst-role=$matches[1]';
    
    //stafflistcategories
    $new_rules['(.?.+?)/'.$system_slug.'/stafflistcategories/jsst-cat/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=knowledgebase&jstlay=stafflistcategories&jsst-cat=$matches[2]';
    $new_rules[$system_slug.'/stafflistcategories/jsst-cat/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=knowledgebase&jstlay=stafflistcategories&jsst-cat=$matches[1]';
    
    //staffs
    $new_rules['(.?.+?)/'.$system_slug.'/staffs/jsst-name/(.?.+?)/jsst-status/(.?.+?)/jsst-role/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=staff&jstlay=staffs&jsst-name=$matches[2]&jsst-status=$matches[3]&jsst-role=$matches[4]';
    $new_rules['(.?.+?)/'.$system_slug.'/staffs/jsst-name/(.?.+?)/jsst-status/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=staff&jstlay=staffs&jsst-name=$matches[2]&jsst-status=$matches[3]';
    $new_rules['(.?.+?)/'.$system_slug.'/staffs/jsst-name/(.?.+?)/jsst-role/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=staff&jstlay=staffs&jsst-name=$matches[2]&jsst-role=$matches[3]';
    $new_rules['(.?.+?)/'.$system_slug.'/staffs/jsst-status/(.?.+?)/jsst-role/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=staff&jstlay=staffs&jsst-status=$matches[2]&jsst-role=$matches[3]';
    $new_rules['(.?.+?)/'.$system_slug.'/staffs/jsst-name/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=staff&jstlay=staffs&jsst-name=$matches[2]';
    $new_rules['(.?.+?)/'.$system_slug.'/staffs/jsst-status/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=staff&jstlay=staffs&jsst-status=$matches[2]';
    $new_rules['(.?.+?)/'.$system_slug.'/staffs/jsst-role/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=staff&jstlay=staffs&jsst-role=$matches[2]';
    $new_rules[$system_slug.'/staffs/jsst-name/(.?.+?)/jsst-status/(.?.+?)/jsst-role/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=staff&jstlay=staffs&jsst-name=$matches[1]&jsst-status=$matches[2]&jsst-role=$matches[3]';
    $new_rules[$system_slug.'/staffs/jsst-name/(.?.+?)/jsst-status/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=staff&jstlay=staffs&jsst-name=$matches[1]&jsst-status=$matches[2]';
    $new_rules[$system_slug.'/staffs/jsst-name/(.?.+?)/jsst-role/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=staff&jstlay=staffs&jsst-name=$matches[1]&jsst-role=$matches[2]';
    $new_rules[$system_slug.'/staffs/jsst-status/(.?.+?)/jsst-role/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=staff&jstlay=staffs&jsst-status=$matches[1]&jsst-role=$matches[2]';
    $new_rules[$system_slug.'/staffs/jsst-name/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=staff&jstlay=staffs&jsst-name=$matches[1]';
    $new_rules[$system_slug.'/staffs/jsst-status/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=staff&jstlay=staffs&jsst-status=$matches[1]';
    $new_rules[$system_slug.'/staffs/jsst-role/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=staff&jstlay=staffs&jsst-role=$matches[1]';
    
    //stafflistarticles
    $new_rules['(.?.+?)/'.$system_slug.'/stafflistarticles/jsst-subject/(.?.+?)/jsst-cat/(.?.+?)/jsst-type/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=knowledgebase&jstlay=stafflistarticles&jsst-subject=$matches[2]&jsst-cat=$matches[3]&jsst-type=$matches[4]';
    $new_rules['(.?.+?)/'.$system_slug.'/stafflistarticles/jsst-subject/(.?.+?)/jsst-cat/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=knowledgebase&jstlay=stafflistarticles&jsst-subject=$matches[2]&jsst-cat=$matches[3]';
    $new_rules['(.?.+?)/'.$system_slug.'/stafflistarticles/jsst-subject/(.?.+?)/jsst-type/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=knowledgebase&jstlay=stafflistarticles&jsst-subject=$matches[2]&jsst-type=$matches[3]';
    $new_rules['(.?.+?)/'.$system_slug.'/stafflistarticles/jsst-cat/(.?.+?)/jsst-type/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=knowledgebase&jstlay=stafflistarticles&jsst-cat=$matches[2]&jsst-type=$matches[3]';
    $new_rules['(.?.+?)/'.$system_slug.'/stafflistarticles/jsst-type/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=knowledgebase&jstlay=stafflistarticles&jsst-type=$matches[2]';
    $new_rules['(.?.+?)/'.$system_slug.'/stafflistarticles/jsst-cat/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=knowledgebase&jstlay=stafflistarticles&jsst-cat=$matches[2]';
    $new_rules['(.?.+?)/'.$system_slug.'/stafflistarticles/jsst-subject/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=knowledgebase&jstlay=stafflistarticles&jsst-subject=$matches[2]';
    $new_rules[$system_slug.'/stafflistarticles/jsst-subject/(.?.+?)/jsst-cat/(.?.+?)/jsst-type/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=knowledgebase&jstlay=stafflistarticles&jsst-subject=$matches[1]&jsst-cat=$matches[2]&jsst-type=$matches[3]';
    $new_rules[$system_slug.'/stafflistarticles/jsst-subject/(.?.+?)/jsst-cat/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=knowledgebase&jstlay=stafflistarticles&jsst-subject=$matches[1]&jsst-cat=$matches[2]';
    $new_rules[$system_slug.'/stafflistarticles/jsst-subject/(.?.+?)/jsst-type/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=knowledgebase&jstlay=stafflistarticles&jsst-subject=$matches[1]&jsst-type=$matches[2]';
    $new_rules[$system_slug.'/stafflistarticles/jsst-cat/(.?.+?)/jsst-type/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=knowledgebase&jstlay=stafflistarticles&jsst-cat=$matches[1]&jsst-type=$matches[2]';
    $new_rules[$system_slug.'/stafflistarticles/jsst-type/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=knowledgebase&jstlay=stafflistarticles&jsst-type=$matches[1]';
    $new_rules[$system_slug.'/stafflistarticles/jsst-cat/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=knowledgebase&jstlay=stafflistarticles&jsst-cat=$matches[1]';
    $new_rules[$system_slug.'/stafflistarticles/jsst-subject/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=knowledgebase&jstlay=stafflistarticles&jsst-subject=$matches[1]';
    
    //staffannouncements
    $new_rules['(.?.+?)/'.$system_slug.'/staffannouncements/jsst-title/(.?.+?)/jsst-cat/(.?.+?)/jsst-type/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=announcement&jstlay=staffannouncements&jsst-title=$matches[2]&jsst-cat=$matches[3]&jsst-type=$matches[4]';
    $new_rules['(.?.+?)/'.$system_slug.'/staffannouncements/jsst-title/(.?.+?)/jsst-cat/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=announcement&jstlay=staffannouncements&jsst-title=$matches[2]&jsst-cat=$matches[3]';
    $new_rules['(.?.+?)/'.$system_slug.'/staffannouncements/jsst-title/(.?.+?)/jsst-type/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=announcement&jstlay=staffannouncements&jsst-title=$matches[2]&jsst-type=$matches[3]';
    $new_rules['(.?.+?)/'.$system_slug.'/staffannouncements/jsst-cat/(.?.+?)/jsst-type/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=announcement&jstlay=staffannouncements&jsst-cat=$matches[2]&jsst-type=$matches[3]';
    $new_rules['(.?.+?)/'.$system_slug.'/staffannouncements/jsst-type/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=announcement&jstlay=staffannouncements&jsst-type=$matches[2]';
    $new_rules['(.?.+?)/'.$system_slug.'/staffannouncements/jsst-cat/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=announcement&jstlay=staffannouncements&jsst-cat=$matches[2]';
    $new_rules['(.?.+?)/'.$system_slug.'/staffannouncements/jsst-title/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=announcement&jstlay=staffannouncements&jsst-title=$matches[2]';
    $new_rules[$system_slug.'/staffannouncements/jsst-title/(.?.+?)/jsst-cat/(.?.+?)/jsst-type/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=announcement&jstlay=staffannouncements&jsst-title=$matches[1]&jsst-cat=$matches[2]&jsst-type=$matches[3]';
    $new_rules[$system_slug.'/staffannouncements/jsst-title/(.?.+?)/jsst-cat/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=announcement&jstlay=staffannouncements&jsst-title=$matches[1]&jsst-cat=$matches[2]';
    $new_rules[$system_slug.'/staffannouncements/jsst-title/(.?.+?)/jsst-type/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=announcement&jstlay=staffannouncements&jsst-title=$matches[1]&jsst-type=$matches[2]';
    $new_rules[$system_slug.'/staffannouncements/jsst-cat/(.?.+?)/jsst-type/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=announcement&jstlay=staffannouncements&jsst-cat=$matches[1]&jsst-type=$matches[2]';
    $new_rules[$system_slug.'/staffannouncements/jsst-type/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=announcement&jstlay=staffannouncements&jsst-type=$matches[1]';
    $new_rules[$system_slug.'/staffannouncements/jsst-cat/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=announcement&jstlay=staffannouncements&jsst-cat=$matches[1]';
    $new_rules[$system_slug.'/staffannouncements/jsst-title/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=announcement&jstlay=staffannouncements&jsst-title=$matches[1]';

    //staffdownloads
    $new_rules['(.?.+?)/'.$system_slug.'/staffdownloads/jsst-title/(.?.+?)/jsst-cat/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=download&jstlay=staffdownloads&jsst-title=$matches[2]&jsst-cat=$matches[3]';
    $new_rules['(.?.+?)/'.$system_slug.'/staffdownloads/jsst-cat/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=download&jstlay=staffdownloads&jsst-cat=$matches[2]';
    $new_rules['(.?.+?)/'.$system_slug.'/staffdownloads/jsst-title/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=download&jstlay=staffdownloads&jsst-title=$matches[2]';
    $new_rules[$system_slug.'/staffdownloads/jsst-title/(.?.+?)/jsst-cat/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=download&jstlay=staffdownloads&jsst-title=$matches[1]&jsst-cat=$matches[2]';
    $new_rules[$system_slug.'/staffdownloads/jsst-cat/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=download&jstlay=staffdownloads&jsst-cat=$matches[1]';
    $new_rules[$system_slug.'/staffdownloads/jsst-title/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=download&jstlay=staffdownloads&jsst-title=$matches[1]';
    
    //stafffaqs
    $new_rules['(.?.+?)/'.$system_slug.'/stafffaqs/jsst-subject/(.?.+?)/jsst-cat/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=faq&jstlay=stafffaqs&jsst-subject=$matches[2]&jsst-cat=$matches[3]';
    $new_rules['(.?.+?)/'.$system_slug.'/stafffaqs/jsst-cat/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=faq&jstlay=stafffaqs&jsst-cat=$matches[2]';
    $new_rules['(.?.+?)/'.$system_slug.'/stafffaqs/jsst-subject/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=faq&jstlay=stafffaqs&jsst-subject=$matches[2]';
    $new_rules[$system_slug.'/stafffaqs/jsst-subject/(.?.+?)/jsst-cat/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=faq&jstlay=stafffaqs&jsst-subject=$matches[1]&jsst-cat=$matches[2]';
    $new_rules[$system_slug.'/stafffaqs/jsst-cat/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=faq&jstlay=stafffaqs&jsst-cat=$matches[1]';
    $new_rules[$system_slug.'/stafffaqs/jsst-subject/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=faq&jstlay=stafffaqs&jsst-subject=$matches[1]';

    //addticket
    $new_rules['(.?.+?)/'.$system_slug.'/addticket/?$'] = 'index.php?pagename=$matches[1]&jstmod=ticket&jstlay=addticket';
    $new_rules[$system_slug.'/addticket/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=ticket&jstlay=addticket';

    //login
    $new_rules['(.?.+?)/'.$system_slug.'/login/?$'] = 'index.php?pagename=$matches[1]&jstmod=jssupportticket&jstlay=login';
    $new_rules[$system_slug.'/login/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=jssupportticket&jstlay=login';

    //myticket
    $new_rules['(.?.+?)/'.$system_slug.'/myticket/?$'] = 'index.php?pagename=$matches[1]&jstmod=ticket&jstlay=myticket';
    $new_rules[$system_slug.'/myticket/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=ticket&jstlay=myticket';
    
    //staffaddticket
    $new_rules['(.?.+?)/'.$system_slug.'/staffaddticket/?$'] = 'index.php?pagename=$matches[1]&jstmod=ticket&jstlay=staffaddticket';
    $new_rules[$system_slug.'/staffaddticket/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=ticket&jstlay=staffaddticket';
    
    //staffmyticket
    $new_rules['(.?.+?)/'.$system_slug.'/staffmyticket/?$'] = 'index.php?pagename=$matches[1]&jstmod=ticket&jstlay=staffmyticket';
    $new_rules[$system_slug.'/staffmyticket/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=ticket&jstlay=staffmyticket';
    
    //ticketstatus
    $new_rules['(.?.+?)/'.$system_slug.'/ticketstatus/?$'] = 'index.php?pagename=$matches[1]&jstmod=ticket&jstlay=ticketstatus';
    $new_rules[$system_slug.'/ticketstatus/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=ticket&jstlay=ticketstatus';
    
    //addannouncement
    $new_rules['(.?.+?)/'.$system_slug.'/addannouncement/?$'] = 'index.php?pagename=$matches[1]&jstmod=announcement&jstlay=addannouncement';
    $new_rules[$system_slug.'/addannouncement/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=announcement&jstlay=addannouncement';
    
    //announcements
    $new_rules['(.?.+?)/'.$system_slug.'/announcements/?$'] = 'index.php?pagename=$matches[1]&jstmod=announcement&jstlay=announcements';
    $new_rules[$system_slug.'/announcements/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=announcement&jstlay=announcements';
    
    //announcementsshortcode
    $new_rules['(.?.+?)/'.$system_slug.'/announcementsshortcode/?$'] = 'index.php?pagename=$matches[1]&jstmod=announcement&jstlay=announcementsshortcode';
    $new_rules[$system_slug.'/announcementsshortcode/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=announcement&jstlay=announcementsshortcode';
    
    //staffannouncements
    $new_rules['(.?.+?)/'.$system_slug.'/staffannouncements/?$'] = 'index.php?pagename=$matches[1]&jstmod=announcement&jstlay=staffannouncements';
    $new_rules[$system_slug.'/staffannouncements/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=announcement&jstlay=staffannouncements';
    
    //adddepartment
    $new_rules['(.?.+?)/'.$system_slug.'/adddepartment/?$'] = 'index.php?pagename=$matches[1]&jstmod=department&jstlay=adddepartment';
    $new_rules[$system_slug.'/adddepartment/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=department&jstlay=adddepartment';
    
    //departments
    $new_rules['(.?.+?)/'.$system_slug.'/departments/?$'] = 'index.php?pagename=$matches[1]&jstmod=department&jstlay=departments';
    $new_rules[$system_slug.'/departments/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=department&jstlay=departments';
    
    //adddownload
    $new_rules['(.?.+?)/'.$system_slug.'/adddownload/?$'] = 'index.php?pagename=$matches[1]&jstmod=download&jstlay=adddownload';
    $new_rules[$system_slug.'/adddownload/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=download&jstlay=adddownload';
    
    //downloads
    $new_rules['(.?.+?)/'.$system_slug.'/downloads/?$'] = 'index.php?pagename=$matches[1]&jstmod=download&jstlay=downloads';
    $new_rules[$system_slug.'/downloads/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=download&jstlay=downloads';
    
    //downloadsshortcode
    $new_rules['(.?.+?)/'.$system_slug.'/downloadsshortcode/?$'] = 'index.php?pagename=$matches[1]&jstmod=download&jstlay=downloadsshortcode';
    $new_rules[$system_slug.'/downloadsshortcode/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=download&jstlay=downloadsshortcode';
    
    //staffdownloads
    $new_rules['(.?.+?)/'.$system_slug.'/staffdownloads/?$'] = 'index.php?pagename=$matches[1]&jstmod=download&jstlay=staffdownloads';
    $new_rules[$system_slug.'/staffdownloads/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=download&jstlay=staffdownloads';
    
    //addfaq
    $new_rules['(.?.+?)/'.$system_slug.'/addfaq/?$'] = 'index.php?pagename=$matches[1]&jstmod=faq&jstlay=addfaq';
    $new_rules[$system_slug.'/addfaq/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=faq&jstlay=addfaq';
    
    //faqs
    $new_rules['(.?.+?)/'.$system_slug.'/faqs/?$'] = 'index.php?pagename=$matches[1]&jstmod=faq&jstlay=faqs';
    $new_rules[$system_slug.'/faqs/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=faq&jstlay=faqs';
    
    //faqsshortcode
    $new_rules['(.?.+?)/'.$system_slug.'/faqsshortcode/?$'] = 'index.php?pagename=$matches[1]&jstmod=faq&jstlay=faqsshortcode';
    $new_rules[$system_slug.'/faqsshortcode/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=faq&jstlay=faqsshortcode';
    
    //faqsshortcode
    $new_rules['(.?.+?)/'.$system_slug.'/stafffaqs/?$'] = 'index.php?pagename=$matches[1]&jstmod=faq&jstlay=stafffaqs';
    $new_rules[$system_slug.'/stafffaqs/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=faq&jstlay=stafffaqs';
    
    //controlpanel
    $new_rules['(.?.+?)/'.$system_slug.'/controlpanel/?$'] = 'index.php?pagename=$matches[1]&jstmod=jssupportticket&jstlay=controlpanel';
    $new_rules[$system_slug.'/controlpanel/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=jssupportticket&jstlay=controlpanel';
    
    //addarticle
    $new_rules['(.?.+?)/'.$system_slug.'/addarticle/?$'] = 'index.php?pagename=$matches[1]&jstmod=knowledgebase&jstlay=addarticle';
    $new_rules[$system_slug.'/addarticle/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=knowledgebase&jstlay=addarticle';
    
    //addcategory
    $new_rules['(.?.+?)/'.$system_slug.'/addcategory/?$'] = 'index.php?pagename=$matches[1]&jstmod=knowledgebase&jstlay=addcategory';
    $new_rules[$system_slug.'/addcategory/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=knowledgebase&jstlay=addcategory';
    
    //stafflistarticles
    $new_rules['(.?.+?)/'.$system_slug.'/stafflistarticles/?$'] = 'index.php?pagename=$matches[1]&jstmod=knowledgebase&jstlay=stafflistarticles';
    $new_rules[$system_slug.'/stafflistarticles/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=knowledgebase&jstlay=stafflistarticles';
    
    //stafflistcategories
    $new_rules['(.?.+?)/'.$system_slug.'/stafflistcategories/?$'] = 'index.php?pagename=$matches[1]&jstmod=knowledgebase&jstlay=stafflistcategories';
    $new_rules[$system_slug.'/stafflistcategories/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=knowledgebase&jstlay=stafflistcategories';
    
    //userknowledgebase
    $new_rules['(.?.+?)/'.$system_slug.'/userknowledgebase/?$'] = 'index.php?pagename=$matches[1]&jstmod=knowledgebase&jstlay=userknowledgebase';
    $new_rules[$system_slug.'/userknowledgebase/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=knowledgebase&jstlay=userknowledgebase';
    
    //userknowledgebase
    $new_rules['(.?.+?)/'.$system_slug.'/userknowledgebasearticles/?$'] = 'index.php?pagename=$matches[1]&jstmod=knowledgebase&jstlay=userknowledgebasearticles';
    $new_rules[$system_slug.'/userknowledgebasearticles/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=knowledgebase&jstlay=userknowledgebasearticles';
    
    //userknowledgebaseshortcode
    $new_rules['(.?.+?)/'.$system_slug.'/userknowledgebaseshortcode/?$'] = 'index.php?pagename=$matches[1]&jstmod=knowledgebase&jstlay=userknowledgebaseshortcode';
    $new_rules[$system_slug.'/userknowledgebaseshortcode/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=knowledgebase&jstlay=userknowledgebaseshortcode';
    
    //formmessage
    $new_rules['(.?.+?)/'.$system_slug.'/formmessage/?$'] = 'index.php?pagename=$matches[1]&jstmod=mail&jstlay=formmessage';
    $new_rules[$system_slug.'/formmessage/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=mail&jstlay=formmessage';
    
    //message
    $new_rules['(.?.+?)/'.$system_slug.'/message/?$'] = 'index.php?pagename=$matches[1]&jstmod=mail&jstlay=message';
    $new_rules[$system_slug.'/message/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=mail&jstlay=message';
    
    //inbox
    $new_rules['(.?.+?)/'.$system_slug.'/inbox/?$'] = 'index.php?pagename=$matches[1]&jstmod=mail&jstlay=inbox';
    $new_rules[$system_slug.'/inbox/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=mail&jstlay=inbox';
    
    //outbox
    $new_rules['(.?.+?)/'.$system_slug.'/outbox/?$'] = 'index.php?pagename=$matches[1]&jstmod=mail&jstlay=outbox';
    $new_rules[$system_slug.'/outbox/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=mail&jstlay=outbox';
    
    //addrole
    $new_rules['(.?.+?)/'.$system_slug.'/addrole/?$'] = 'index.php?pagename=$matches[1]&jstmod=role&jstlay=addrole';
    $new_rules[$system_slug.'/addrole/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=role&jstlay=addrole';
    
    //rolepermission
    $new_rules['(.?.+?)/'.$system_slug.'/rolepermission/?$'] = 'index.php?pagename=$matches[1]&jstmod=role&jstlay=rolepermission';
    $new_rules[$system_slug.'/rolepermission/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=role&jstlay=rolepermission';
    
    //roles
    $new_rules['(.?.+?)/'.$system_slug.'/roles/?$'] = 'index.php?pagename=$matches[1]&jstmod=role&jstlay=roles';
    $new_rules[$system_slug.'/roles/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=role&jstlay=roles';
    
    //addstaff
    $new_rules['(.?.+?)/'.$system_slug.'/addstaff/?$'] = 'index.php?pagename=$matches[1]&jstmod=staff&jstlay=addstaff';
    $new_rules[$system_slug.'/addstaff/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=staff&jstlay=addstaff';

    //myprofile
    $new_rules['(.?.+?)/'.$system_slug.'/myprofile/?$'] = 'index.php?pagename=$matches[1]&jstmod=staff&jstlay=myprofile';
    $new_rules[$system_slug.'/myprofile/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=staff&jstlay=myprofile';
    
    //staffpermissions
    $new_rules['(.?.+?)/'.$system_slug.'/staffpermissions/?$'] = 'index.php?pagename=$matches[1]&jstmod=staff&jstlay=staffpermissions';
    $new_rules[$system_slug.'/staffpermissions/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=staff&jstlay=staffpermissions';

    //staffs
    $new_rules['(.?.+?)/'.$system_slug.'/staffs/?$'] = 'index.php?pagename=$matches[1]&jstmod=staff&jstlay=staffs';
    $new_rules[$system_slug.'/staffs/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=staff&jstlay=staffs';

    //staffreports
    $new_rules['(.?.+?)/'.$system_slug.'/staffdetailreport/jsst-id/(.?.+?)/jsst-date-start/(.?.+?)/jsst-date-end/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=reports&jstlay=staffdetailreport&jsst-id=$matches[2]&jsst-date-start=$matches[3]&jsst-date-end=$matches[4]';
    $new_rules[$system_slug.'/staffdetailreport/jsst-id/(.?.+?)/jsst-date-start/(.?.+?)/jsst-date-end/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=reports&jstlay=staffdetailreport&jsst-id=$matches[1]&jsst-date-start=$matches[2]&jsst-date-end=$matches[3]';

    $new_rules['(.?.+?)/'.$system_slug.'/staffreports/jsst-id/(.?.+?)/jsst-date-start/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=reports&jstlay=staffreports&jsst-id=$matches[2]&jsst-date-start=$matches[3]';
    $new_rules[$system_slug.'/staffreports/jsst-id/(.?.+?)/jsst-date-start/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=reports&jstlay=staffreports&jsst-id=$matches[1]&jsst-date-start=$matches[2]';

    $new_rules['(.?.+?)/'.$system_slug.'/staffreports/jsst-id/(.?.+?)/jsst-date-end/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=reports&jstlay=staffreports&jsst-id=$matches[2]&jsst-date-end=$matches[3]';
    $new_rules[$system_slug.'/staffreports/jsst-id/(.?.+?)/jsst-date-end/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=reports&jstlay=staffreports&jsst-id=$matches[1]&jsst-date-end=$matches[2]';

    $new_rules['(.?.+?)/'.$system_slug.'/staffreports/jsst-date-start/(.?.+?)/jsst-date-end/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=reports&jstlay=staffreports&jsst-date-start=$matches[2]&jsst-date-end=$matches[3]';
    $new_rules[$system_slug.'/staffreports/jsst-date-start/(.?.+?)/jsst-date-end/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=reports&jstlay=staffreports&jsst-date-start=$matches[1]&jsst-date-end=$matches[2]';

    $new_rules['(.?.+?)/'.$system_slug.'/staffdetailreport/jsst-id/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=reports&jstlay=staffdetailreport&jsst-id=$matches[2]';
    $new_rules[$system_slug.'/staffdetailreport/jsst-id/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=reports&jstlay=staffdetailreport&jsst-id=$matches[1]';

    $new_rules['(.?.+?)/'.$system_slug.'/staffdetailreport/jsst-date-start/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=reports&jstlay=staffdetailreport&jsst-date-start=$matches[2]';
    $new_rules[$system_slug.'/staffdetailreport/jsst-date-start/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=reports&jstlay=staffdetailreport&jsst-date-start=$matches[1]';

    $new_rules['(.?.+?)/'.$system_slug.'/staffdetailreport/jsst-date-end/(.?.+?)/?$'] = 'index.php?pagename=$matches[1]&jstmod=reports&jstlay=staffdetailreport&jsst-date-end=$matches[2]';
    $new_rules[$system_slug.'/staffdetailreport/jsst-date-end/(.?.+?)/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=reports&jstlay=staffdetailreport&jsst-date-end=$matches[1]';

    $new_rules['(.?.+?)/'.$system_slug.'/staffdetailreport/?$'] = 'index.php?pagename=$matches[1]&jstmod=reports&jstlay=staffdetailreport';
    $new_rules[$system_slug.'/staffdetailreport/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=reports&jstlay=staffdetailreport';


    //reports
    $new_rules['(.?.+?)/'.$system_slug.'/staffreports/jsst-date-start/(.?.+?)?$'] = 'index.php?pagename=$matches[1]&jstmod=reports&jstlay=staffreports&jsst-date-start=$matches[2]';
    $new_rules[$system_slug.'/staffreports/jsst-date-start/(.?.+?)?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=reports&jstlay=staffreports&jsst-date-start=$matches[1]';
    $new_rules['(.?.+?)/'.$system_slug.'/staffreports/jsst-date-end/(.?.+?)?$'] = 'index.php?pagename=$matches[1]&jstmod=reports&jstlay=staffreports&jsst-date-end=$matches[2]';
    $new_rules[$system_slug.'/staffreports/jsst-date-end/(.?.+?)?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=reports&jstlay=staffreports&jsst-date-end=$matches[1]';
    $new_rules['(.?.+?)/'.$system_slug.'/staffreports/?$'] = 'index.php?pagename=$matches[1]&jstmod=reports&jstlay=staffreports';
    $new_rules[$system_slug.'/staffreports/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=reports&jstlay=staffreports';



    $new_rules['(.?.+?)/'.$system_slug.'/departmentreports/?$'] = 'index.php?pagename=$matches[1]&jstmod=reports&jstlay=departmentreports';
    $new_rules[$system_slug.'/departmentreports/?$'] = 'index.php?page_id='.$frontpage_id.'&jstmod=reports&jstlay=departmentreports';
	
	return $new_rules;
}

add_action('init', 'jsst_add_rules', 10, 0);
add_action('generate_rewrite_rules', 'jsst_add_rule');

function jsst_add_rule($wp_rewrite) {
	$new_rules = getParamsForJSSTTICKET();
	$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;
}

function jsst_add_rules() {
	$new_rules = getParamsForJSSTTICKET();
	foreach($new_rules AS $key => $value){
		add_rewrite_rule($key, $value, 'top');
	}    
}

add_action('init', 'jsst_rewrite_tag', 10, 0);

function jsst_rewrite_tag() {
    add_rewrite_tag('%jstmod%', '([^&]+)');
    add_rewrite_tag('%jstlay%', '([^&]+)');
    add_rewrite_tag('%task%', '([^&]+)');
    add_rewrite_tag('%list%', '([^&]+)');
    add_rewrite_tag('%sortby%', '([^&]+)');
    add_rewrite_tag('%jssupportticketid%', '([^&]+)');
    // Search Variables
    add_rewrite_tag('%jsst-title%', '([^&]+)');
    add_rewrite_tag('%jsst-cat%', '([^&]+)');
    add_rewrite_tag('%jsst-type%', '([^&]+)');
    add_rewrite_tag('%jsst-search%', '([^&]+)');
    add_rewrite_tag('%jsst-dept%', '([^&]+)');
    add_rewrite_tag('%jsst-subject%', '([^&]+)');
    add_rewrite_tag('%jsst-role%', '([^&]+)');
    add_rewrite_tag('%jsst-name%', '([^&]+)');
    add_rewrite_tag('%jsst-status%', '([^&]+)');
    add_rewrite_tag('%jsst-ticketsearchkeys%', '([^&]+)');
    add_rewrite_tag('%jsst-id%', '([^&]+)');
    add_rewrite_tag('%jsst-date-start%', '([^&]+)');
    add_rewrite_tag('%jsst-date-end%', '([^&]+)');
}

add_action('parse_request', 'parse_request1');

function parse_request1($q) {
//    echo '<pre style="color:#fff;">';print_r($q->query_vars);echo '</pre>';
}

add_filter('redirect_canonical', 'jsst_redirect_canonical', 10, 2);

function jsst_redirect_canonical($redirect_url, $requested_url) {

    global $wp_rewrite;

    // if url already include, do not include it again. Fix for polylang
    $query = 'SELECT configvalue FROM `' . jssupportticket::$_db->prefix . 'js_ticket_config` WHERE configname = "system_slug"';
    $system_slug = jssupportticket::$_db->get_var($query);
    if(strstr($redirect_url,'/'.$system_slug.'/')){
        return;
    }

    // Abort if not using pretty permalinks, is a feed, or not an archive for the post type 'book'
    if (!$wp_rewrite->using_permalinks() || is_feed())
        return $redirect_url;

    // Get the original query parts
    $redirect = @parse_url($requested_url);
    $original = $redirect_url;
    if (!isset($redirect['query']))
        $redirect['query'] = '';

    // If is year/month/day - append year
    if (is_year() || is_month() || is_day()) {
        $year = get_query_var('year');
        $redirect['query'] = remove_query_arg('year', $redirect['query']);
        $redirect_url = user_trailingslashit(get_post_type_archive_link('book')) . $year;
    }

    // If is month/day - append month
    if (is_month() || is_day()) {
        $month = zeroise(intval(get_query_var('monthnum')), 2);
        $redirect['query'] = remove_query_arg('monthnum', $redirect['query']);
        $redirect_url .= '/' . $month;
    }

    // If is day - append day
    if (is_day()) {
        $day = zeroise(intval(get_query_var('day')), 2);
        $redirect['query'] = remove_query_arg('day', $redirect['query']);
        $redirect_url .= '/' . $day;
    }

    // If is page_id
    if (get_query_var('page_id')) {
        $page_id = get_query_var('page_id');
        $redirect['query'] = remove_query_arg('page_id', $redirect['query']);
        $redirect_url = user_trailingslashit(get_page_link($page_id));
    }
    // If is module
    if (get_query_var(jstmod)) {
        $module = get_query_var('jstmod');
        $redirect['query'] = remove_query_arg('jstmod', $redirect['query']);
        $query = 'SELECT configvalue FROM `' . jssupportticket::$_db->prefix . 'js_ticket_config` WHERE configname = "system_slug"';
        $system_slug = jssupportticket::$_db->get_var($query);
        $lastcharactor = substr($redirect_url, -1);
        if($lastcharactor != '/'){
            $redirect_url .= '/';
        }
        $redirect_url .= $system_slug;
    }
    // If is layout
    if (get_query_var('jstlay')) {
        $layout = get_query_var('jstlay');
        $redirect['query'] = remove_query_arg('jstlay', $redirect['query']);
        $redirect_url .= '/' . $layout;
    }
    // If is list
    if (get_query_var('list')) {
        $list = get_query_var('list');
        $redirect['query'] = remove_query_arg('list', $redirect['query']);
        $redirect_url .= '/' . $list;
    }
    // If is sortby
    if (get_query_var('sortby')) {
        $sortby = get_query_var('sortby');
        $redirect['query'] = remove_query_arg('sortby', $redirect['query']);
        $redirect_url .= '/' . $sortby;
    }
    // If is jssupportticket_ticketid
    if (get_query_var('jssupportticketid')) {
        $jssupportticket_ticketid = get_query_var('jssupportticketid');
        $redirect['query'] = remove_query_arg('jssupportticketid', $redirect['query']);
        $redirect_url .= '/' . $jssupportticket_ticketid;
    }

    //Search Variables
    switch ($layout) {
        case 'staffannouncements':
            if (get_query_var('jsst-title')) {
                $title = get_query_var('jsst-title');
                $redirect_url .= '/jsst-title/' . $title;
            }
            if (get_query_var('jsst-cat')) {
                $cat = get_query_var('jsst-cat');
                $redirect_url .= '/jsst-cat/' . $cat;
            }
            if (get_query_var('jsst-type')) {
                $type = get_query_var('jsst-type');
                $redirect_url .= '/jsst-type/' . $type;
            }
            break;
        case 'staffdetailreport':
        case 'staffreports':
            if (get_query_var('jsst-id')) {
                $title = get_query_var('jsst-id');
                $redirect_url .= '/jsst-id/' . $title;
            }
            if (get_query_var('jsst-date-start')) {
                $cat = get_query_var('jsst-date-start');
                $redirect_url .= '/jsst-date-start/' . $cat;
            }
            if (get_query_var('jsst-date-end')) {
                $type = get_query_var('jsst-date-end');
                $redirect_url .= '/jsst-date-end/' . $type;
            }
            break;
        case 'announcements':
        case 'downloads':
        case 'faqs':
        case 'staffknowledgebase':
        case 'userknowledgebase':
            if (get_query_var('jsst-search')) {
                $search = get_query_var('jsst-search');
                $redirect_url .= '/jsst-search/' . $search;
            }
            break;
        case 'staffdownloads':
            if (get_query_var('jsst-title')) {
                $title = get_query_var('jsst-title');
                $redirect_url .= '/jsst-title/' . $title;
            }
            if (get_query_var('jsst-cat')) {
                $cat = get_query_var('jsst-cat');
                $redirect_url .= '/jsst-cat/' . $cat;
            }
            break;
        case 'stafffaqs':
            if (get_query_var('jsst-subject')) {
                $subject = get_query_var('jsst-subject');
                $redirect_url .= '/jsst-subject/' . $subject;
            }
            if (get_query_var('jsst-cat')) {
                $cat = get_query_var('jsst-cat');
                $redirect_url .= '/jsst-cat/' . $cat;
            }
            break;
        case 'stafflistarticles':
            if (get_query_var('jsst-subject')) {
                $subject = get_query_var('jsst-subject');
                $redirect_url .= '/jsst-subject/' . $subject;
            }
            if (get_query_var('jsst-cat')) {
                $cat = get_query_var('jsst-cat');
                $redirect_url .= '/jsst-cat/' . $cat;
            }
            if (get_query_var('jsst-type')) {
                $type = get_query_var('jsst-type');
                $redirect_url .= '/jsst-type/' . $type;
            }
            break;
        case 'departments':
            if (get_query_var('jsst-dept')) {
                $dept = get_query_var('jsst-dept');
                $redirect_url .= '/jsst-dept/' . $dept;
            }
            break;
        case 'stafflistcategories':
            if (get_query_var('jsst-cat')) {
                $cat = get_query_var('jsst-cat');
                $redirect_url .= '/jsst-cat/' . $cat;
            }
            break;
        case 'inbox':
        case 'outbox':
            if (get_query_var('jsst-subject')) {
                $subject = get_query_var('jsst-subject');
                $redirect_url .= '/jsst-subject/' . $subject;
            }
            break;
        case 'roles':
            if (get_query_var('jsst-role')) {
                $role = get_query_var('jsst-role');
                $redirect_url .= '/jsst-role/' . $role;
            }
            break;
        case 'myticket':
        case 'staffmyticket':
            if (get_query_var('jsst-ticketsearchkeys')) {
                $ticketsearchkeys = get_query_var('jsst-ticketsearchkeys');
                $redirect_url .= '/jsst-ticketsearchkeys/' . $ticketsearchkeys;
            }
            break;
        case 'staffs':
            if (get_query_var('jsst-name')) {
                $name = get_query_var('jsst-name');
                $redirect_url .= '/jsst-name/' . $name;
            }
            if (get_query_var('jsst-status')) {
                $status = get_query_var('jsst-status');
                $redirect_url .= '/jsst-status/' . $status;
            }
            if (get_query_var('jsst-role')) {
                $role = get_query_var('jsst-role');
                $redirect_url .= '/jsst-role/' . $role;
            }
            break;
    }
    $redirect['query'] = remove_query_arg('jsst-title', $redirect['query']);
    $redirect['query'] = remove_query_arg('jsst-cat', $redirect['query']);
    $redirect['query'] = remove_query_arg('jsst-type', $redirect['query']);
    $redirect['query'] = remove_query_arg('jsst-search', $redirect['query']);
    $redirect['query'] = remove_query_arg('jsst-dept', $redirect['query']);
    $redirect['query'] = remove_query_arg('jsst-subject', $redirect['query']);
    $redirect['query'] = remove_query_arg('jsst-role', $redirect['query']);
    $redirect['query'] = remove_query_arg('jsst-name', $redirect['query']);
    $redirect['query'] = remove_query_arg('jsst-status', $redirect['query']);
    $redirect['query'] = remove_query_arg('jsst-ticketsearchkeys', $redirect['query']);
    $redirect['query'] = remove_query_arg('jsst-go', $redirect['query']);
    $redirect['query'] = remove_query_arg('jsst-reset', $redirect['query']);
    $redirect['query'] = remove_query_arg('jsst-id', $redirect['query']);
    $redirect['query'] = remove_query_arg('jsst-date-start', $redirect['query']);
    $redirect['query'] = remove_query_arg('jsst-date-end', $redirect['query']);
    // If paged, apppend pagination
    if (get_query_var('paged') > 0) {
        $paged = (int) get_query_var('paged');
        $redirect['query'] = remove_query_arg('paged', $redirect['query']);

        if ($paged > 1)
            $redirect_url .= user_trailingslashit("/page/$paged", 'paged');
    }
    if ($redirect_url == $original)
        return $original;
    // tack on any additional query vars
    $redirect['query'] = preg_replace('#^\??&*?#', '', $redirect['query']);
    if ($redirect_url && !empty($redirect['query'])) {
        parse_str($redirect['query'], $_parsed_query);
        $_parsed_query = array_map('rawurlencode', $_parsed_query);
        $redirect_url = add_query_arg($_parsed_query, $redirect_url);
    }

    // if($redirect_url == $requested_url) return false;
    // wp_redirect( $redirect_url, 301 );
    // exit();

    return $redirect_url;
}

?>