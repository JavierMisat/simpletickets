<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class jssupportticketadmin {

    function __construct() {
        add_action('admin_menu', array($this, 'mainmenu'));
    }

    function mainmenu() {
        add_menu_page(__('JS Support Ticket Control Panel', 'js-support-ticket'), // Page title
                __('JS Support Ticket', 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'jssupportticket', //menu slug
                array($this, 'showAdminPage'), // function name
			  plugins_url('js-support-ticket/includes/images/admin_ticket.png')
        );
        add_submenu_page('jssupportticket', // parent slug
                __('Tickets', 'js-support-ticket'), // Page title
                __('Tickets', 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'ticket', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('jssupportticket', // parent slug
                __('Staff Members', 'js-support-ticket'), // Page title
                __('Staff Members', 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'staff', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('jssupportticket', // parent slug
                __('Configurations', 'js-support-ticket'), // Page title
                __('Configurations', 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'configuration', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('jssupportticket', // parent slug
                __('Knowledge Base', 'js-support-ticket'), // Page title
                __('Knowledge Base', 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'knowledgebase', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('jssupportticket', // parent slug
                __("FAQ's", 'js-support-ticket'), // Page title
                __("FAQ's", 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'faq', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('jssupportticket', // parent slug
                __('Downloads', 'js-support-ticket'), // Page title
                __('Downloads', 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'download', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('jssupportticket', // parent slug
                __('Announcements', 'js-support-ticket'), // Page title
                __('Announcements', 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'announcement', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('jssupportticket_hide', // parent slug
                __('Priorities', 'js-support-ticket'), // Page title
                __('Priority', 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'priority', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('jssupportticket_hide', // parent slug
                __('Department', 'js-support-ticket'), // Page title
                __('Departments', 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'department', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('jssupportticket_hide', // parent slug
                __('Emails', 'js-support-ticket'), // Page title
                __('System Emails', 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'email', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('jssupportticket_hide', // parent slug
                __('System Error', 'js-support-ticket'), // Page title
                __('System Errors', 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'systemerror', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('jssupportticket_hide', // parent slug
                __('Email Templates', 'js-support-ticket'), // Page title
                __('Email Templates', 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'emailtemplate', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('jssupportticket_hide', // parent slug
                __('User Fields', 'js-support-ticket'), // Page title
                __('User Fields', 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'userfeild', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('jssupportticket_hide', // parent slug
                __('Premade Messages', 'js-support-ticket'), // Page title
                __('Premade Messages', 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'premademessage', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('jssupportticket_hide', // parent slug
                __('Help topics', 'js-support-ticket'), // Page title
                __('Help Topics', 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'helptopic', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('jssupportticket_hide', // parent slug
                __('Roles', 'js-support-ticket'), // Page title
                __('Roles', 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'role', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('jssupportticket_hide', // parent slug
                __('Mail', 'js-support-ticket'), // Page title
                __('Mail', 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'mail', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('jssupportticket_hide', // parent slug
                __('Ban email', 'js-support-ticket'), // Page title
                __('Ban Emails', 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'banemail', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('jssupportticket_hide', // parent slug
                __('Banlist log', 'js-support-ticket'), // Page title
                __('Banlist log', 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'banemaillog', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('jssupportticket_hide', // parent slug
                __('Field Ordering', 'js-support-ticket'), // Page title
                __('Field Ordering', 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'fieldordering', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('jssupportticket_hide', // parent slug
                __('Update', 'js-support-ticket'), // Page title
                __('Update', 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'proinstaller', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('jssupportticket_hide', // parent slug
                __('JS Support Ticket', 'js-support-ticket'), // Page title
                __('Ticket Via Email', 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'ticketviaemail', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('jssupportticket_hide', // parent slug
                __('JS Support Ticket', 'js-support-ticket'), // Page title
                __('Reports', 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'reports', //menu slug
                array($this, 'showAdminPage') // function name
        );
        add_submenu_page('jssupportticket_hide', // parent slug
                __('Export', 'js-support-ticket'), // Page title
                __('Export', 'js-support-ticket'), // menu title
                'jsst_support_ticket', // capability
                'export', //menu slug
                array($this, 'showAdminPage') // function name
        );
    }

    function showAdminPage() {
        $page = JSSTrequest::getVar('page');
        JSSTincluder::include_file($page);
    }

}

$jssupportticketAdmin = new jssupportticketadmin();
?>
