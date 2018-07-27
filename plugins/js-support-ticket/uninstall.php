<?php

/**
 * JS Support Ticket Uninstall
 *
 * Uninstalling JS Support Ticket tables, and pages.
 *
 * @author 		Ahmed Bilal
 * @category 	Core
 * @package 	JS Support Ticket/Uninstaller
 * @version     1.0
 */
if (!defined('WP_UNINSTALL_PLUGIN'))
    exit();

global $wpdb;
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_staff_mail" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_staff" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_notes" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_help_topics" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_fieldsordering" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_faqs" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_email_banlist" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_downloads_attachments" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_downloads" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_department_message_premade" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_departments" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_categories" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_banlist_log" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_autoresponces" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_attachments" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_articles_attachments" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_articles" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_announcements" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_activity_log" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_acl_user_permissions" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_acl_user_access_departments" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_acl_role_permissions" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_acl_role_access_departments" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_acl_roles" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_acl_permissions" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_config" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_email" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_emailtemplates" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_priorities" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_replies" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_system_errors" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_tickets" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_userrole" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_userfields" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_userfieldvalues" );		
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}js_ticket_userfield_data" );		
