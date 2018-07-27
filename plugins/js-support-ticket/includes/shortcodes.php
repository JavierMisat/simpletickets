<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTshortcodes {

    function __construct() {
        add_shortcode('jssupportticket', array($this, 'show_main_ticket'));
        add_shortcode('jssupportticket_addticket', array($this, 'show_form_ticket'));
        add_shortcode('jssupportticket_mytickets', array($this, 'show_my_ticket'));
        add_shortcode('jssupportticket_downloads', array($this, 'show_downloads'));
        add_shortcode('jssupportticket_downloads_latest', array($this, 'show_downloadslatest'));
        add_shortcode('jssupportticket_downloads_popular', array($this, 'show_downloadslatest'));
        add_shortcode('jssupportticket_knowledgebase', array($this, 'show_knowledgebase'));
        add_shortcode('jssupportticket_knowledgebase_latest', array($this, 'show_knowledgebaselatest'));
        add_shortcode('jssupportticket_knowledgebase_popular', array($this, 'show_knowledgebaselatest'));
        add_shortcode('jssupportticket_faqs', array($this, 'show_faqs'));
        add_shortcode('jssupportticket_faqs_latest', array($this, 'show_faqslatest'));
        add_shortcode('jssupportticket_faqs_popular', array($this, 'show_faqslatest'));
        add_shortcode('jssupportticket_announcements', array($this, 'show_announcements'));
        add_shortcode('jssupportticket_announcements_latest', array($this, 'show_announcementslatest'));
        add_shortcode('jssupportticket_announcements_popular', array($this, 'show_announcementslatest'));
    }

    function show_announcementslatest($raw_args, $content = null) {
        //default set of parameters for the front end shortcodes
        ob_start();
        $pageid = get_the_ID();
        jssupportticket::setPageID($pageid);
        $module = JSSTRequest::getVar('jstmod', '', 'announcement');
        $layout = JSSTRequest::getVar('jstlay', '', 'announcementsshortcode');
        if ($layout != 'announcementsshortcode') {
            JSSTincluder::include_file($module);
        } else {
            $filepath = jssupportticket::$_path . 'includes/css/style.php';
            $filestring = file_get_contents($filepath);
            $color1 = JSSTincluder::getJSModel('jssupportticket')->getColorCode($filestring, 1);
            $color3 = JSSTincluder::getJSModel('jssupportticket')->getColorCode($filestring, 3);
            $defaults = array(
                'jstmod' => '',
                'jstlay' => '',
                'background_color' => $color1,
                'text_color' => $color3
            );
            $sanitized_args = shortcode_atts($defaults, $raw_args);
            jssupportticket::$_data['sanitized_args'] = $sanitized_args;
            jssupportticket::$_data['short_code_header'] = 'announcements';
            $id = JSSTrequest::getVar('jssupportticketid');
            JSSTincluder::getJSModel('announcement')->getAnnouncements($id);
            JSSTincluder::include_file('announcementsshortcode', 'announcement');
        }
        $content .= ob_get_clean();
        return $content;
    }

    function show_announcements($raw_args, $content = null) {
        //default set of parameters for the front end shortcodes
        ob_start();
        $pageid = get_the_ID();
        jssupportticket::setPageID($pageid);
        $module = JSSTRequest::getVar('jstmod', '', 'announcement');
        $layout = JSSTRequest::getVar('jstlay', '', 'announcements');
        if ($layout != 'announcements') {
            JSSTincluder::include_file($module);
        } else {
            $defaults = array(
                'jstmod' => '',
                'jstlay' => '',
            );
            $sanitized_args = shortcode_atts($defaults, $raw_args);
            jssupportticket::$_data['sanitized_args'] = $sanitized_args;
            jssupportticket::$_data['short_code_header'] = 'announcements';
            $id = JSSTrequest::getVar('jssupportticketid');
            JSSTincluder::getJSModel('announcement')->getAnnouncements($id);
            JSSTincluder::include_file('announcements', 'announcement');
        }
        $content .= ob_get_clean();
        return $content;
    }

    function show_faqslatest($raw_args, $content = null) {
        //default set of parameters for the front end shortcodes
        ob_start();
        $pageid = get_the_ID();
        jssupportticket::setPageID($pageid);
        $module = JSSTRequest::getVar('jstmod', '', 'faq');
        $layout = JSSTRequest::getVar('jstlay', '', 'faqsshortcode');
        if ($layout != 'faqsshortcode') {
            JSSTincluder::include_file($module);
        } else {
            $filepath = jssupportticket::$_path . 'includes/css/style.php';
            $filestring = file_get_contents($filepath);
            $color1 = JSSTincluder::getJSModel('jssupportticket')->getColorCode($filestring, 1);
            $color3 = JSSTincluder::getJSModel('jssupportticket')->getColorCode($filestring, 3);
            $defaults = array(
                'jstmod' => '',
                'jstlay' => '',
                'background_color' => $color1,
                'text_color' => $color3
            );
            $sanitized_args = shortcode_atts($defaults, $raw_args);
            jssupportticket::$_data['sanitized_args'] = $sanitized_args;
            jssupportticket::$_data['short_code_header'] = 'faqs';
            $id = JSSTrequest::getVar('jssupportticketid');
            JSSTincluder::getJSModel('faq')->getFaqs($id);
            JSSTincluder::include_file('faqsshortcode', 'faq');
        }
        $content .= ob_get_clean();
        return $content;
    }

    function show_faqs($raw_args, $content = null) {
        //default set of parameters for the front end shortcodes
        ob_start();
        $pageid = get_the_ID();
        jssupportticket::setPageID($pageid);
        $module = JSSTRequest::getVar('jstmod', '', 'faq');
        $layout = JSSTRequest::getVar('jstlay', '', 'faqs');
        if ($layout != 'faqs') {
            JSSTincluder::include_file($module);
        } else {
            $defaults = array(
                'jstmod' => '',
                'jstlay' => '',
            );
            $sanitized_args = shortcode_atts($defaults, $raw_args);
            jssupportticket::$_data['sanitized_args'] = $sanitized_args;
            jssupportticket::$_data['short_code_header'] = 'faqs';
            $id = JSSTrequest::getVar('jssupportticketid');
            JSSTincluder::getJSModel('faq')->getFaqs($id);
            JSSTincluder::include_file('faqs', 'faq');
        }
        $content .= ob_get_clean();
        return $content;
    }

    function show_knowledgebaselatest($raw_args, $content = null) {
        //default set of parameters for the front end shortcodes
        ob_start();
        $pageid = get_the_ID();
        jssupportticket::setPageID($pageid);
        $module = JSSTRequest::getVar('jstmod', '', 'knowledgebase');
        $layout = JSSTRequest::getVar('jstlay', '', 'userknowledgebaseshortcode');
        if ($layout != 'userknowledgebaseshortcode') {
            JSSTincluder::include_file($module);
        } else {
            $filepath = jssupportticket::$_path . 'includes/css/style.php';
            $filestring = file_get_contents($filepath);
            $color1 = JSSTincluder::getJSModel('jssupportticket')->getColorCode($filestring, 1);
            $color3 = JSSTincluder::getJSModel('jssupportticket')->getColorCode($filestring, 3);
            $defaults = array(
                'jstmod' => '',
                'jstlay' => '',
                'background_color' => $color1,
                'text_color' => $color3
            );
            $sanitized_args = shortcode_atts($defaults, $raw_args);
            jssupportticket::$_data['sanitized_args'] = $sanitized_args;
            jssupportticket::$_data['short_code_header'] = 'userknowledgebase';
            JSSTincluder::getJSModel('knowledgebase')->getKnowledgebaseCat();
            JSSTincluder::include_file('userknowledgebaseshortcode', 'knowledgebase');
        }
        $content .= ob_get_clean();
        return $content;
    }

    function show_knowledgebase($raw_args, $content = null) {
        //default set of parameters for the front end shortcodes
        ob_start();
        $pageid = get_the_ID();
        jssupportticket::setPageID($pageid);
        $module = JSSTRequest::getVar('jstmod', '', 'knowledgebase');
        $layout = JSSTRequest::getVar('jstlay', '', 'userknowledgebase');
        if ($layout != 'userknowledgebase') {
            JSSTincluder::include_file($module);
        } else {
            $defaults = array(
                'jstmod' => '',
                'jstlay' => '',
            );
            $sanitized_args = shortcode_atts($defaults, $raw_args);
            jssupportticket::$_data['sanitized_args'] = $sanitized_args;
            jssupportticket::$_data['short_code_header'] = 'userknowledgebase';
            JSSTincluder::getJSModel('knowledgebase')->getKnowledgebaseCat();
            JSSTincluder::include_file('userknowledgebase', 'knowledgebase');
        }
        $content .= ob_get_clean();
        return $content;
    }

    function show_downloads($raw_args, $content = null) {
        //default set of parameters for the front end shortcodes
        ob_start();
        $pageid = get_the_ID();
        jssupportticket::setPageID($pageid);
        $module = JSSTRequest::getVar('jstmod', '', 'download');
        $layout = JSSTRequest::getVar('jstlay', '', 'downloads');
        if ($layout != 'downloads') {
            JSSTincluder::include_file($module);
        } else {
            $defaults = array(
                'jstmod' => '',
                'jstlay' => '',
            );
            $sanitized_args = shortcode_atts($defaults, $raw_args);
            jssupportticket::$_data['sanitized_args'] = $sanitized_args;
            jssupportticket::$_data['short_code_header'] = 'downloads';
            $id = JSSTrequest::getVar('jssupportticketid');
            JSSTincluder::getJSModel('download')->getDownloads($id);
            JSSTincluder::include_file('downloads', 'download');
        }
        $content .= ob_get_clean();
        return $content;
    }

    function show_downloadslatest($raw_args, $content = null) {
        //default set of parameters for the front end shortcodes
        ob_start();
        $pageid = get_the_ID();
        jssupportticket::setPageID($pageid);
        $module = JSSTRequest::getVar('jstmod', '', 'download');
        $layout = JSSTRequest::getVar('jstlay', '', 'downloadsshortcode');
        if ($layout != 'downloadsshortcode') {
            JSSTincluder::include_file($module);
        } else {
            $filepath = jssupportticket::$_path . 'includes/css/style.php';
            $filestring = file_get_contents($filepath);
            $color1 = JSSTincluder::getJSModel('jssupportticket')->getColorCode($filestring, 1);
            $color3 = JSSTincluder::getJSModel('jssupportticket')->getColorCode($filestring, 3);
            $defaults = array(
                'jstmod' => '',
                'jstlay' => '',
                'background_color' => $color1,
                'text_color' => $color3
            );
            $sanitized_args = shortcode_atts($defaults, $raw_args);
            jssupportticket::$_data['sanitized_args'] = $sanitized_args;
            jssupportticket::$_data['short_code_header'] = 'downloads';
            $id = JSSTrequest::getVar('jssupportticketid');
            JSSTincluder::getJSModel('download')->getDownloads($id);
            JSSTincluder::include_file('downloadsshortcode', 'download');
        }
        $content .= ob_get_clean();
        return $content;
    }

    function show_main_ticket($raw_args, $content = null) {
        //default set of parameters for the front end shortcodes
        ob_start();
        $defaults = array(
            'jstmod' => '',
            'jstlay' => '',
        );
        $sanitized_args = shortcode_atts($defaults, $raw_args);
        jssupportticket::$_data['sanitized_args'] = $sanitized_args;
        $pageid = get_the_ID();
        jssupportticket::setPageID($pageid);
        JSSTincluder::include_slug('');
        $content .= ob_get_clean();
        return $content;
    }

    function show_form_ticket($raw_args, $content = null) {
        //default set of parameters for the front end shortcodes
        ob_start();
        $pageid = get_the_ID();
        jssupportticket::setPageID($pageid);
        $module = JSSTRequest::getVar('jstmod', '', 'ticket');
        $layout = JSSTRequest::getVar('jstlay', '', 'addticket');
        if ($layout != 'addticket' && $layout != 'staffaddticket') {
            JSSTincluder::include_file($module);
        } else {
            $defaults = array(
                'job_type' => '',
                'city' => '',
                'company' => '',
            );
            $sanitized_args = shortcode_atts($defaults, $raw_args);
            jssupportticket::$_data['short_code_header'] = 'addticket';
            if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                $id = JSSTrequest::getVar('jssupportticketid');
                jssupportticket::$_data['permission_granted'] = true;
                if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                    $per_task = ($id == null) ? 'Add Ticket' : 'Edit Ticket';
                    jssupportticket::$_data['permission_granted'] = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask($per_task);
                }
                if (jssupportticket::$_data['permission_granted']) {
                    JSSTincluder::getJSModel('ticket')->getTicketsForForm($id);
                }
                JSSTincluder::include_file('staffaddticket', 'ticket');
            } else {
                JSSTincluder::getJSModel('ticket')->getTicketsForForm(null);
                JSSTincluder::include_file('addticket', 'ticket');
            }
        }
        $content .= ob_get_clean();
        return $content;
    }

    function show_my_ticket($raw_args, $content = null) {
        //default set of parameters for the front end shortcodes
        ob_start();
        $pageid = get_the_ID();
        jssupportticket::setPageID($pageid);
        $module = JSSTRequest::getVar('jstmod', '', 'ticket');
        $layout = JSSTRequest::getVar('jstlay', '', 'myticket');
        if ($layout != 'myticket' && $layout != 'staffmyticket') {
            JSSTincluder::include_file($module);
        } else {
            $defaults = array(
                'list' => '',
                'ticketid' => '',
            );
            $list = JSSTrequest::getVar('list', 'get', null);
            $ticketid = JSSTrequest::getVar('ticketid', null, null);
            $args = shortcode_atts($defaults, $raw_args);
            if ($list == null)
                $list = $args['list'];
            if ($ticketid == null)
                $ticketid = $args['ticketid'];
            jssupportticket::$_data['short_code_header'] = 'myticket';
            if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                JSSTincluder::getJSModel('ticket')->getStaffTickets();
                JSSTincluder::include_file('staffmyticket', 'ticket');
            } else {
                JSSTincluder::getJSModel('ticket')->getMyTickets($list, $ticketid);
                JSSTincluder::include_file('myticket', 'ticket');
            }
        }
        $content .= ob_get_clean();
        return $content;
    }

}

$shortcodes = new JSSTshortcodes();
?>
