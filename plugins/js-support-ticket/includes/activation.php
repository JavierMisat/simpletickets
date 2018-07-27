<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTactivation {

    static function jssupportticket_activate() {
        // Install Database
        JSSTactivation::runSQL();
        JSSTactivation::insertMenu();
        JSSTactivation::addCapabilites();
    }

    static private function addCapabilites() {
        $role = get_role( 'administrator' );
        $role->add_cap( 'jsst_support_ticket' ); 
    }

    static private function insertMenu() {
        $pageexist = jssupportticket::$_db->get_var("Select COUNT(id) FROM `" . jssupportticket::$_db->prefix . "posts` WHERE ID = 'js-support-ticket-controlpanel'");
        if ($pageexist == 0) {
            $post = array(
                'post_name' => 'js-support-ticket-controlpanel',
                'post_title' => 'JS Support Ticket',
                'post_status' => 'publish',
                'post_content' => '[jssupportticket]',
                'post_type' => 'page'
            );
            wp_insert_post($post);
        } else {
            jssupportticket::$_db->get_var("UPDATE `" . jssupportticket::$_db->prefix . "posts` SET post_status = 'publish' WHERE ID = 'js-support-ticket-controlpanel'");
        }
        update_option('rewrite_rules', '');
    }

    static private function runSQL() {
        $pageid = jssupportticket::$_db->get_var("SELECT id FROM `" . jssupportticket::$_db->prefix . "posts` WHERE post_name = 'js-support-ticket-controlpanel'");
        // Run Sql to install the database;
        $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_config` (
					  `configname` varchar(100) NOT NULL DEFAULT '',
					  `configvalue` varchar(255) NOT NULL DEFAULT '',
					  `configfor` varchar(50) DEFAULT NULL,
					  PRIMARY KEY (`configname`),
					  FULLTEXT KEY `config_name` (`configname`),
					  FULLTEXT KEY `config_for` (`configfor`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
        jssupportticket::$_db->query($query);
        $uid = get_current_user_id();
        $runConfig = jssupportticket::$_db->get_var("SELECT COUNT(configname) FROM `" . jssupportticket::$_db->prefix . "js_ticket_config`");
        if ($runConfig == 0) {
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_acl_permissions` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `permission` varchar(45) DEFAULT NULL,
        						  `permissiongroup` int(11) DEFAULT NULL,
        						  `status` tinyint(1) DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58;";
            jssupportticket::$_db->query($query);
            $query = "INSERT INTO `" . jssupportticket::$_db->prefix . "js_ticket_acl_permissions` (`id`, `permission`, `permissiongroup`, `status`) VALUES (1, 'Add Ticket', 1, 1),(2, 'Edit Ticket', 1, 1),(3, 'Close Ticket', 1, 1),(4, 'Reopen Ticket', 1, 1),(5, 'Reply Ticket', 1, 1),(6, 'Assign Ticket To Staff', 1, 1),(7, 'Ticket Department Transfer', 1, 1),(8, 'Mark Overdue', 1, 1),(9, 'Mark In Progress', 1, 1),(10, 'Change Ticket Priority', 1, 1),(11, 'Unban Email', 1, 1),(12, 'Delete Ticket', 1, 1),(13, 'Ban Email And Close Ticket', 1, 1),(14, 'Lock Ticket', 1, 1),(15, 'Attachment', 1, 1),(16, 'Post Internal Note', 1, 1),(17, 'Add Role', 2, 1),(18, 'Assign Role Permissions', 2, 1),(19, 'Edit Role', 2, 1),(20, 'Assign Role To User', 2, 1),(21, 'Add User', 2, 1),(22, 'Edit User', 2, 1),(23, 'Assign User Permissions', 2, 1),(24, 'Add Department', 2, 1),(25, 'Edit Department', 2, 1),(26, 'Delete Department', 2, 1),(27, 'View Department', 2, 1),(28, 'Delete Role', 2, 1),(29, 'Delete User', 2, 1),(30, 'Mail To Staff', 2, 1),(31, 'Add Category', 3, 1),(32, 'Add Knowledge Base', 3, 1),(33, 'Edit Category', 3, 1),(34, 'Edit Knowledge Base', 3, 1),(35, 'View Category', 3, 1),(36, 'View Knowledge Base', 3, 1),(37, 'Delete Category', 3, 1),(38, 'Delete Knowledge Base', 3, 1),(39, 'Add FAQ', 4, 1),(40, 'Edit FAQ', 4, 1),(41, 'View FAQ', 4, 1),(42, 'Delete FAQ', 4, 1),(43, 'Add Download', 5, 1),(44, 'Edit Download', 5, 1),(45, 'View Download', 5, 1),(46, 'Delete Download', 5, 1),(47, 'Add Announcement', 6, 1),(48, 'Edit Announcement', 6, 1),(49, 'View Announcement', 6, 1),(50, 'Delete Announcement', 6, 1),(51, 'View Role', 2, 1),(52, 'View User', 2, 1),(53, 'Duedate Ticket', 1, 1),(54, 'View Ticket', 1, 1),(55, 'Release Ticket', 1, 1),(56, 'New Ticket Notification', 1, 1),(57, 'Allow Mail System', 7, 1);";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_acl_roles` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `name` varchar(255) DEFAULT NULL,
        						  `status` tinyint(1) DEFAULT NULL,
        						  `parentid` int(11) DEFAULT NULL,
        						  `created` datetime DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;";
            jssupportticket::$_db->query($query);
            $query = "INSERT INTO `" . jssupportticket::$_db->prefix . "js_ticket_acl_roles` (`id`, `name`, `status`, `parentid`, `created`) VALUES (1, 'Manager', 1, NULL, '" . date_i18n('Y-m-d H:i:s') . "');";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_acl_role_access_departments` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `roleid` int(11) DEFAULT NULL,
        						  `departmentid` int(11) DEFAULT NULL,
        						  `status` tinyint(4) DEFAULT NULL,
        						  `created` datetime DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;";
            jssupportticket::$_db->query($query);
            $query = "INSERT INTO `" . jssupportticket::$_db->prefix . "js_ticket_acl_role_access_departments` (`id`, `roleid`, `departmentid`, `status`, `created`) VALUES (1, 1, 1, 1, '" . date_i18n('Y-m-d H:i:s') . "');";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_acl_role_permissions` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `roleid` int(11) DEFAULT NULL,
        						  `permissionid` int(11) DEFAULT NULL,
        						  `grant` tinyint(4) DEFAULT NULL,
        						  `status` tinyint(4) DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58;";
            jssupportticket::$_db->query($query);
            $query = "INSERT INTO `" . jssupportticket::$_db->prefix . "js_ticket_acl_role_permissions` (`id`, `roleid`, `permissionid`, `grant`, `status`) VALUES (1, 1, 1, 1, 1),(2, 1, 2, 1, 1),(3, 1, 3, 1, 1),(4, 1, 4, 1, 1),(5, 1, 5, 1, 1),(6, 1, 6, 1, 1),(7, 1, 7, 1, 1),(8, 1, 8, 1, 1),(9, 1, 9, 1, 1),(10, 1, 10, 1, 1),(11, 1, 11, 1, 1),(12, 1, 12, 1, 1),(13, 1, 13, 1, 1),(14, 1, 14, 1, 1),(15, 1, 15, 1, 1),(16, 1, 16, 1, 1),(17, 1, 17, 1, 1),(18, 1, 18, 1, 1),(19, 1, 19, 1, 1),(20, 1, 20, 1, 1),(21, 1, 21, 1, 1),(22, 1, 22, 1, 1),(23, 1, 23, 1, 1),(24, 1, 24, 1, 1),(25, 1, 25, 1, 1),(26, 1, 26, 1, 1),(27, 1, 27, 1, 1),(28, 1, 28, 1, 1),(29, 1, 29, 1, 1),(30, 1, 30, 1, 1),(31, 1, 31, 1, 1),(32, 1, 32, 1, 1),(33, 1, 33, 1, 1),(34, 1, 34, 1, 1),(35, 1, 35, 1, 1),(36, 1, 36, 1, 1),(37, 1, 37, 1, 1),(38, 1, 38, 1, 1),(39, 1, 39, 1, 1),(40, 1, 40, 1, 1),(41, 1, 41, 1, 1),(42, 1, 42, 1, 1),(43, 1, 43, 1, 1),(44, 1, 44, 1, 1),(45, 1, 45, 1, 1),(46, 1, 46, 1, 1),(47, 1, 47, 1, 1),(48, 1, 48, 1, 1),(49, 1, 49, 1, 1),(50, 1, 50, 1, 1),(51, 1, 51, 1, 1),(52, 1, 52, 1, 1),(53, 1, 53, 1, 1),(54, 1, 54, 1, 1),(55, 1, 55, 1, 1),(56, 1, 56, 1, 1),(57, 1, 57, 1, 1);";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_access_departments` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `uid` int(11) DEFAULT NULL,
        						  `roleid` int(11) DEFAULT NULL,
        						  `staffid` int(11) DEFAULT NULL,
        						  `departmentid` int(11) DEFAULT NULL,
        						  `status` tinyint(4) DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_permissions` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `uid` int(11) DEFAULT NULL,
        						  `roleid` int(11) DEFAULT NULL,
        						  `staffid` int(11) DEFAULT NULL,
        						  `permissionid` int(11) DEFAULT NULL,
        						  `grant` tinyint(4) DEFAULT NULL,
        						  `status` tinyint(4) DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_activity_log` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `uid` int(11) DEFAULT NULL,
        						  `referenceid` int(11) DEFAULT NULL,
        						  `level` int(2) DEFAULT NULL,
        						  `eventfor` int(2) DEFAULT NULL,
        						  `event` varchar(255) DEFAULT NULL,
        						  `eventtype` varchar(255) DEFAULT NULL,
        						  `message` text,
        						  `messagetype` varchar(255) DEFAULT NULL,
        						  `datetime` timestamp NULL DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci' AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_announcements` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `categoryid` int(11) DEFAULT NULL,
        						  `title` varchar(255) DEFAULT NULL,
        						  `description` text,
        						  `staffid` int(11) DEFAULT NULL,
        						  `ordering` int(11) NOT NULL,
        						  `type` tinyint(3) DEFAULT NULL,
        						  `status` tinyint(1) DEFAULT NULL,
        						  `created` datetime DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_articles` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `categoryid` int(11) DEFAULT NULL,
        						  `staffid` int(11) DEFAULT NULL,
        						  `subject` varchar(255) DEFAULT NULL,
        						  `content` text,
        						  `views` int(11) DEFAULT NULL,
        						  `type` tinyint(4) DEFAULT NULL,
        						  `ordering` tinyint(4) DEFAULT NULL,
        						  `metadesc` varchar(60) DEFAULT NULL,
        						  `metakey` varchar(60) DEFAULT NULL,
        						  `status` tinyint(1) DEFAULT NULL,
        						  `created` datetime DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_articles_attachments` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `articleid` int(11) DEFAULT NULL,
        						  `filename` varchar(45) DEFAULT NULL,
        						  `filesize` varchar(45) DEFAULT NULL,
        						  `filetype` varchar(45) DEFAULT NULL,
        						  `staffid` int(11) DEFAULT NULL,
        						  `status` tinyint(1) DEFAULT NULL,
        						  `created` datetime DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_attachments` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `ticketid` int(11) DEFAULT NULL,
        						  `replyattachmentid` int(11) DEFAULT NULL,
        						  `filesize` varchar(32) DEFAULT NULL,
        						  `filename` varchar(128) DEFAULT NULL,
        						  `filekey` varchar(128) DEFAULT NULL,
        						  `deleted` tinyint(1) DEFAULT NULL,
        						  `status` tinyint(1) DEFAULT NULL,
        						  `created` datetime DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_autoresponces` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `autoresponce` tinyint(1) DEFAULT NULL,
        						  `priorityid` int(11) DEFAULT NULL,
        						  `departmentid` int(11) DEFAULT NULL,
        						  `email` varchar(125) DEFAULT NULL,
        						  `name` varchar(32) DEFAULT NULL,
        						  `created` datetime DEFAULT NULL,
        						  `update` datetime DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_banlist_log` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `loggeremail` varchar(255) DEFAULT NULL,
        						  `title` varchar(255) DEFAULT NULL,
        						  `log` text,
        						  `logger` varchar(64) DEFAULT NULL,
        						  `ipaddress` varchar(16) DEFAULT NULL,
        						  `created` datetime DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_categories` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `name` varchar(45) DEFAULT NULL,
        						  `parentid` int(11) DEFAULT NULL,
        						  `totalarticles` smallint(6) DEFAULT NULL,
        						  `hits` int(11) DEFAULT NULL,
        						  `metadesc` varchar(60) DEFAULT NULL,
        						  `metakey` varchar(60) DEFAULT NULL,
        						  `logo` varchar(45) DEFAULT NULL,
        						  `downloads` tinyint(4) DEFAULT NULL,
        						  `announcement` tinyint(4) DEFAULT NULL,
        						  `faqs` tinyint(4) DEFAULT NULL,
        						  `kb` tinyint(4) DEFAULT NULL,
        						  `staffid` int(11) DEFAULT NULL,
        						  `ordering` tinyint(4) DEFAULT NULL,
        						  `type` tinyint(4) DEFAULT NULL,
        						  `status` tinyint(1) DEFAULT NULL,
        						  `created` datetime DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "INSERT INTO `" . jssupportticket::$_db->prefix . "js_ticket_config` (`configname`, `configvalue`, `configfor`) VALUES ('title', 'JS Support Ticket System', 'default'),('offline', '2', 'default'),('offline_message', 'We are offline now please come back soon.\r\n\r\nThank you', 'default'),('data_directory', 'jssupportticketdata', 'default'),('date_format', 'd-m-Y', 'default'),('ticket_overdue', '5', 'default'),('ticket_auto_close', '5', 'default'),('no_of_attachement', '5', 'default'),('file_maximum_size', '3072', 'default'),('file_extension', 'doc,docx,odt,pdf,txt,png,jpeg,jpg', 'default'),('show_current_location', '2', 'default'),('maximum_tickets', '100', 'default'),('reopen_ticket_within_days', '5', 'default'),('visitor_can_create_ticket', '2', 'default'),('show_captcha_on_visitor_from_ticket', '1', 'default'),('default_alert_email', '1', 'default'),('default_admin_email', '1', 'default'),('new_ticket_mail_to_admin', '1', 'default'),('new_ticket_mail_to_staff_members', '1', 'default'),('banemail_mail_to_admin', '1', 'default'),('ticket_reassign_admin', '1', 'default'),('ticket_reassign_staff', '1', 'default'),('ticket_reassign_user', '0', 'default'),('ticket_close_admin', '1', 'default'),('ticket_close_staff', '1', 'default'),('ticket_close_user', '1', 'default'),('ticket_delete_admin', '1', 'default'),('ticket_delete_staff', '1', 'default'),('ticket_delete_user', '1', 'default'),('ticket_mark_overdue_admin', '1', 'default'),('ticket_mark_overdue_staff', '1', 'default'),('ticket_mark_overdue_user', '1', 'default'),('ticket_ban_email_admin', '1', 'default'),('ticket_ban_email_staff', '1', 'default'),('ticket_ban_email_user', '1', 'default'),('ticket_department_transfer_admin', '0', 'default'),('ticket_department_transfer_staff', '1', 'default'),('ticket_department_transfer_user', '0', 'default'),('ticket_reply_ticket_user_admin', '0', 'default'),('ticket_reply_ticket_user_staff', '1', 'default'),('ticket_reply_ticket_user_user', '1', 'default'),('ticket_response_to_staff_admin', '0', 'default'),('ticket_response_to_staff_staff', '1', 'default'),('ticket_response_to_staff_user', '1', 'default'),('ticker_ban_eamil_and_close_ticktet_admin', '1', 'default'),('ticker_ban_eamil_and_close_ticktet_staff', '1', 'default'),('ticker_ban_eamil_and_close_ticktet_user', '1', 'default'),('unban_email_admin', '1', 'default'),('unban_email_staff', '1', 'default'),('unban_email_user', '1', 'default'),('maximum_open_tickets', '25', 'deafult'),('pagination_default_page_size', '10', 'deafult'),('recaptcha_publickey', '', 'default'),('recaptcha_privatekey', '', 'default'),('captcha_selection', '2', 'default'),('owncaptcha_calculationtype', '1', 'default'),('owncaptcha_totaloperand', '2', 'default'),('owncaptcha_subtractionans', '1', 'default'),('ticket_lock_staff', '1', 'email'),('ticket_lock_admin', '1', 'email'),('ticket_lock_user', '1', 'email'),('ticket_unlock_staff', '1', 'email'),('ticket_unlock_admin', '1', 'email'),('ticket_unlock_user', '1', 'email'),('ticket_mark_progress_staff', '1', 'email'),('ticket_mark_progress_admin', '0', 'email'),('ticket_mark_progress_user', '1', 'email'),('ticket_priority_staff', '1', 'email'),('ticket_priority_admin', '0', 'email'),('ticket_priority_user', '1', 'email'),('new_ticket_message', '', 'default'),('cplink_openticket_staff', '1', 'cplink'),('cplink_myticket_staff', '1', 'cplink'),('cplink_addrole_staff', '2', 'cplink'),('cplink_roles_staff', '1', 'cplink'),('cplink_addstaff_staff', '2', 'cplink'),('cplink_staff_staff', '1', 'cplink'),('cplink_adddepartment_staff', '2', 'cplink'),('cplink_department_staff', '1', 'cplink'),('cplink_addcategory_staff', '2', 'cplink'),('cplink_category_staff', '1', 'cplink'),('cplink_addkbarticle_staff', '2', 'cplink'),('cplink_kbarticle_staff', '1', 'cplink'),('cplink_adddownload_staff', '2', 'cplink'),('cplink_download_staff', '1', 'cplink'),('cplink_addannouncement_staff', '2', 'cplink'),('cplink_announcement_staff', '1', 'cplink'),('cplink_addfaq_staff', '2', 'cplink'),('cplink_faq_staff', '1', 'cplink'),('cplink_mail_staff', '1', 'cplink'),('cplink_myprofile_staff', '1', 'cplink'),('cplink_openticket_user', '1', 'cplink'),('cplink_myticket_user', '1', 'cplink'),('cplink_checkticketstatus_user', '1', 'cplink'),('cplink_downloads_user', '1', 'cplink'),('cplink_announcements_user', '1', 'cplink'),('cplink_faqs_user', '1', 'cplink'),('cplink_knowledgebase_user', '1', 'cplink'),('tplink_home_staff', '1', 'tplink'),('tplink_tickets_staff', '1', 'tplink'),('tplink_knowledgebase_staff', '1', 'tplink'),('tplink_announcements_staff', '1', 'tplink'),('tplink_downloads_staff', '1', 'tplink'),('tplink_faqs_staff', '1', 'tplink'),('tplink_home_user', '1', 'tplink'),('tplink_tickets_user', '1', 'tplink'),('tplink_knowledgebase_user', '1', 'tplink'),('tplink_announcements_user', '1', 'tplink'),('tplink_downloads_user', '1', 'tplink'),('tplink_faqs_user', '1', 'tplink'),('show_breadcrumbs', '1', 'default'),('producttype', 'pro', 'default'),('versioncode', '1.0.3', 'default'),('productcode', 'jsticket', 'default'),('tve_enabled', '2', 'ticketviaemail'),('tve_mailreadtype', '3', 'ticketviaemail'),('tve_attachment', '1', 'ticketviaemail'),('tve_emailreadingdelay', '300', 'ticketviaemail'),('tve_hosttype', '4', 'ticketviaemail'),('tve_hostname', '', 'ticketviaemail'),('tve_emailaddress', '', 'ticketviaemail'),('tve_emailpassword', '', 'ticketviaemail'),('lastEmailReadingTime', '', 'default'),('count_on_myticket', '1', 'default'),('login_redirect', '1', 'default'),('default_pageid', '".$pageid."', 'default'),('support_screentag', '1', 'default'),('screentag_position', '1', 'default');;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_departments` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `emailtemplateid` int(11) DEFAULT NULL,
        						  `emailid` int(11) DEFAULT NULL,
        						  `autoresponceemailid` int(11) DEFAULT NULL,
        						  `managerid` int(11) DEFAULT NULL,
        						  `departmentname` varchar(32) DEFAULT NULL,
        						  `departmentsignature` text,
        						  `ispublic` tinyint(1) DEFAULT NULL,
        						  `ticketautoresponce` tinyint(1) DEFAULT NULL,
        						  `messageautoresponce` tinyint(1) DEFAULT NULL,
        						  `canappendsignature` tinyint(1) DEFAULT NULL,
        						  `ordering` int(11) NOT NULL,
        						  `updated` datetime DEFAULT NULL,
        						  `created` datetime DEFAULT NULL,
        						  `status` tinyint(1) DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;";
            jssupportticket::$_db->query($query);
            $query = "INSERT INTO `" . jssupportticket::$_db->prefix . "js_ticket_departments` (`id`, `emailtemplateid`, `emailid`, `autoresponceemailid`, `managerid`, `departmentname`, `departmentsignature`, `ispublic`, `ticketautoresponce`, `messageautoresponce`, `canappendsignature`, `ordering`, `updated`, `created`, `status`) VALUES (1, NULL, 1, NULL, NULL, 'Support', '-- \n\n Support Department.', 1, NULL, NULL, 1, 1, '" . date_i18n('Y-m-d H:i:s') . "', '" . date_i18n('Y-m-d H:i:s') . "', 1);";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_department_message_premade` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `departmentid` varchar(45) DEFAULT NULL,
        						  `title` varchar(125) DEFAULT NULL,
        						  `answer` text,
        						  `created` datetime NOT NULL,
        						  `updated` datetime DEFAULT NULL,
        						  `status` tinyint(1) DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_downloads` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `categoryid` int(11) DEFAULT NULL,
        						  `title` varchar(255) DEFAULT NULL,
        						  `description` text,
        						  `staffid` int(11) DEFAULT NULL,
        						  `ordering` tinyint(4) DEFAULT NULL,
        						  `downloads` int(11) DEFAULT NULL,
        						  `status` tinyint(1) DEFAULT NULL,
        						  `created` datetime DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_downloads_attachments` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `downloadid` int(11) DEFAULT NULL,
        						  `filename` varchar(45) DEFAULT NULL,
        						  `filesize` varchar(45) DEFAULT NULL,
        						  `filetype` varchar(45) DEFAULT NULL,
        						  `staffid` int(11) DEFAULT NULL,
        						  `created` datetime DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_email` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `autoresponse` tinyint(1) DEFAULT NULL,
        						  `priorityid` int(11) DEFAULT NULL,
        						  `email` varchar(125) DEFAULT NULL,
        						  `name` varchar(32) DEFAULT NULL,
        						  `uid` int(11) DEFAULT NULL,
        						  `password` varchar(125) DEFAULT NULL COMMENT '	',
        						  `status` tinyint(1) DEFAULT NULL,
        						  `mailhost` varchar(125) DEFAULT NULL,
        						  `mailprotocol` enum('pop','map') DEFAULT NULL,
        						  `mailencryption` enum('NONE','SSL') DEFAULT NULL,
        						  `mailport` smallint(6) DEFAULT NULL,
        						  `mailfetchfrequency` tinyint(3) DEFAULT NULL,
        						  `mailfetchmaximum` tinyint(4) DEFAULT NULL,
        						  `maildeleted` tinyint(1) DEFAULT NULL,
        						  `mailerrors` tinyint(3) DEFAULT NULL,
        						  `maillasterror` datetime DEFAULT NULL,
        						  `maillastfetch` datetime DEFAULT NULL,
        						  `smtpactive` tinyint(1) DEFAULT NULL,
        						  `smtphost` varchar(125) DEFAULT NULL,
        						  `smtpport` smallint(6) DEFAULT NULL,
        						  `smtpsecure` tinyint(1) DEFAULT NULL,
        						  `smtpauthencation` tinyint(1) DEFAULT NULL,
        						  `created` datetime DEFAULT NULL,
        						  `updated` datetime DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;";
            jssupportticket::$_db->query($query);
            $systememail = get_option('admin_email');
            $query = "INSERT INTO `" . jssupportticket::$_db->prefix . "js_ticket_email` (`id`,`autoresponse`, `priorityid`, `email`, `name`, `uid`, `password`, `status`, `mailhost`, `mailprotocol`, `mailencryption`, `mailport`, `mailfetchfrequency`, `mailfetchmaximum`, `maildeleted`, `mailerrors`, `maillasterror`, `maillastfetch`, `smtpactive`, `smtphost`, `smtpport`, `smtpsecure`, `smtpauthencation`, `created`, `updated`) VALUES
        						(1,1, 1, '" . $systememail . "', NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2014-10-02 10:38:48', '0000-00-00 00:00:00');";
            jssupportticket::$_db->query($query);

            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_emailtemplates` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `templatefor` varchar(50) DEFAULT NULL,
        						  `title` varchar(50) DEFAULT NULL,
        						  `subject` varchar(255) DEFAULT NULL,
        						  `body` text,
        						  `created` datetime DEFAULT NULL,
        						  `status` tinyint(1) DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26;";
            jssupportticket::$_db->query($query);
            $query = "INSERT INTO `" . jssupportticket::$_db->prefix . "js_ticket_emailtemplates` (`id`, `templatefor`, `title`, `subject`, `body`, `created`, `status`) VALUES
        						(1, 'ticket-new', '', 'JS Tickets: New Ticket Received ', 'Dear {USERNAME},\r\n\r\nYour support ticket <strong>{SUBJECT}</strong> has been submitted. We try to reply to all tickets as soon as possible, usually within 24 hours.\r\n\r\nYour tracking ID: {TRACKINGID}\r\n\r\nYour Email ID: {EMAIL}\r\n\r\nTicket message: {MESSAGE}\r\n\r\nYou can view the status of your ticket here:\r\n{TICKETURL}\r\n\r\nYou will receive an e-mail notification when our staff replies to your ticket.\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
        						(2, 'department-new', '', 'JS Tickets :  New Department {DEPARTMENT_TITLE} has beed received ', 'Hello Admin ,\r\n\r\nWe receive new department.\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
        						(3, 'group-new', '', 'JS Tickets :  New Group {GROUP_TITLE} has beed received ', 'Hello Admin ,\r\n\r\nWe receive new group.\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
        						(4, 'staff-new', '', 'JS Tickets :  New Staff Member {STAFF_MEMBER_NAME} has beed received ', 'Hello Admin ,\r\n\r\nWe receive new staff member.\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
        						(5, 'helptopic-new', '', 'JS Tickets :  New Help Topic {HELPTOPIC_TITLE} has beed received', 'Hello Admin ,\r\n\r\nWe receive new help topic {HELPTOPIC_TITLE} of department {DEPARTMENT_TITLE}.\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
        						(6, 'reassign-tk', '', 'JS Tickets: Reassign Ticket  ', 'Sucess: Ticket Reassign\r\n\r\nTicket Subject : {SUBJECT}\r\n\r\nYour ticket has been successfully Reassign! Ticket ID:{TRACKINGID} is Reassign to Staff Member:{STAFF_MEMBER_TITLE}\r\n\r\nYou can manage this ticket here\r\n\r\n{TICKETURL}\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
        						(7, 'close-tk', '', 'JS Tickets:  Close Ticket ', 'Ticket Close\r\n\r\nTicket Subject : {SUBJECT}\r\n\r\nTicket ID:{TRACKINGID} is Closed.\r\n\r\nYou can manage this ticket here\r\n\r\n{TICKETURL}\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
        						(8, 'delete-tk', '', 'JS Tickets:  Delete Ticket', 'Ticket Deleted\r\n\r\nTicket Subject : {SUBJECT}\r\n\r\nTicket ID:{TRACKINGID} is Deleted.\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
        						(9, 'moverdue-tk', '', 'JS Tickets:  Markoverdue Ticket ', 'Ticket Markoverdue\r\n\r\nTicket Subject : {SUBJECT}\r\n\r\nTicket ID:{TRACKINGID} is Markoverdue.\r\n\r\nYou can manage this ticket here\r\n\r\n{TICKETURL}\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
        						(10, 'banemail-tk', '', 'JS Tickets:  Email Baned ', 'Email Baned\r\n\r\nThis email {EMAIL_ADDRESS} is Baned.\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
        						(11, 'deptrans-tk', '', 'JS Tickets:  Ticket Transfer to Department{DEPARTMENT_TITLE} ', 'Ticket transfer to department\r\n\r\nTicket Subject : {SUBJECT}\r\n\r\nTicket ID: {TRACKINGID} is transfer to department{DEPARTMENT_TITLE}.\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
        						(12, 'banemailcloseticket-tk', '', 'JS Tickets: Email Baned and ticket close ', 'Email Baned and ticket close\r\n\r\nTicket Subject : {SUBJECT}\r\n\r\nThis email {EMAIL_ADDRESS} is Baned and ticket ID:{TICKETID} is closed.\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
        						(13, 'unbanemail-tk', '', 'JS Tickets:  Email Unbaned ', 'Email Unbaned\r\n\r\nThis email {EMAIL_ADDRESS} is Unbaned\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
        						(14, 'reply-tk', '', 'JS Tickets:  Ticket Reply  ', 'Hello,\r\n\r\nA new reply of ticket <strong>{SUBJECT} </strong>has been submitted.\r\n\r\nUser Name: {USERNAME}\r\n\r\nTracking ID: {TRACKINGID}\r\n\r\nEmail: {EMAIL}\r\n\r\nMessage: {MESSAGE}\r\n\r\nYou can manage this ticket here:\r\n{TICKETURL}\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
        						(15, 'responce-tk', '', 'JS Tickets:  Ticket Responce ', 'Hello,\r\n\r\nStaff just reply of your ticket <strong>{SUBJECT}</strong>.\r\n\r\nUser Name: {USERNAME}\r\n\r\nTracking ID: {TRACKINGID}\r\n\r\nEmail: {EMAIL}\r\n\r\nMessage: {MESSAGE}\r\n\r\nYou can manage this ticket here:\r\n{TICKETURL}\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
        						(16, 'ticket-staff', '', 'JS Tickets: New Ticket', 'Sucess: Ticket Submitted\r\n\r\nNew ticket <strong>{SUBJECT}</strong> has been submitted with the following details.\r\n\r\nTracking ID: {TRACKINGID}\r\n\r\nEmail ID: {EMAIL}\r\n\r\nTicket message: {MESSAGE}\r\n\r\nHelp Topic: {HELP_TOPIC}\r\n\r\nYou can view the status of your ticket here:\r\n{TICKETURL}\r\n\r\nYou will receive an e-mail notification when our staff replies to your ticket.\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
        						(17, 'banemail-trtk', '', 'JS Tickets: Banemail try new ticket ', 'Hello Admin ,\r\n\r\nThis email {EMAIL_ADDRESS} is baned and try open new ticket .\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
        						(18, 'ticket-new-admin', '', 'JS Tickets: New Ticket Received ', 'Hello,\r\n\r\nA new support ticket <strong>{SUBJECT}</strong> has been submitted. Ticket details.\r\n\r\nTracking ID: {TRACKINGID}\r\n\r\nEmail ID: {EMAIL}\r\n\r\nTicket message: {MESSAGE}\r\n\r\nYou can manage this ticket here:\r\n{TICKETURL}\r\n\r\n<span style=\"color: #ff0000;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
        						(19, 'lock-tk', '', 'JS Tickets :  Ticket {TRACKINGID} has been locked', 'Dear {USERNAME} ,\r\n\r\nYour Ticket {TRACKINGID} has been locked.\r\n\r\nUsername : {USERNAME}\r\nSubject : {SUBJECT}\r\nTicket ID : {TRACKINGID}\r\nEmail : {EMAIL}\r\n\r\nYou can manage ticket here {TICKETURL}\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
        						(21, 'unlock-tk', '', 'JS Tickets :  Ticket {TRACKINGID} has been unlocked', 'Dear {USERNAME} ,\r\n\r\nYour Ticket {TRACKINGID} has been unlocked.\r\n\r\nUsername : {USERNAME}\r\nSubject : {SUBJECT}\r\nTicket ID : {TRACKINGID}\r\nEmail : {EMAIL}\r\n\r\nYou can manage ticket here {TICKETURL}\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
        						(22, 'minprogress-tk', '', 'JS Tickets:  Mark in progress Ticket ', 'Ticket Mark in progress\r\n\r\nTicket Subject : {SUBJECT}\r\n\r\nTicket ID:{TRACKINGID} is Mark in progress.\r\n\r\nYou can manage this ticket here\r\n\r\n{TICKETURL}\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
        						(23, 'prtrans-tk', '', 'JS Tickets:  Ticket transfer to Priority{PRIORITY_TITLE} ', 'Ticket transfer to priority\r\n\r\nTicket Subject : {SUBJECT}\r\n\r\nTicket ID: {TRACKINGID} is transfer to department{PRIORITY_TITLE}.\r\n\r\nYou can manage this ticket here\r\n\r\n{TICKETURL}\r\n\r\n<span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span>\r\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!', NULL, 0),
        						(24, 'mail-new', '', 'JS Tickets:  New Mail has been sent by {STAFF_MEMBER_NAME}', '<p>New mail has been sent by the {STAFF_MEMBER_NAME}</p>\n<p>Mail Subject : {SUBJECT}</p>\n<p>Message : {MESSAGE}</p>\n<p><span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span><br />\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!</p>\n', NULL, 0),
        						(25, 'mail-rpy', '', 'JS Tickets:  New reply has been sent by {STAFF_MEMBER_NAME}', '<p>New reply has been sent by the {STAFF_MEMBER_NAME}</p>\n<p>Mail Subject : {SUBJECT}</p>\n<p>Message : {MESSAGE}</p>\n<p><span style=\"color: red;\"><strong>*DO NOT REPLY TO THIS E-MAIL*</strong></span><br />\nThis is an automated e-mail message sent from our support system. Do not reply to this e-mail as we wonot receive your reply!</p>\n', NULL, 0);";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_email_banlist` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `email` varchar(255) DEFAULT NULL,
        						  `submitter` varchar(126) DEFAULT NULL,
        						  `uid` int(11) NOT NULL,
        						  `created` datetime DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_faqs` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `categoryid` int(11) DEFAULT NULL,
        						  `staffid` int(11) DEFAULT NULL,
        						  `subject` varchar(255) DEFAULT NULL,
        						  `content` text,
        						  `views` tinyint(4) DEFAULT NULL,
        						  `ordering` int(11) NOT NULL,
        						  `created` datetime DEFAULT NULL,
        						  `status` tinyint(1) DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_fieldsordering` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `field` varchar(50) NOT NULL,
        						  `fieldtitle` varchar(50) DEFAULT NULL,
        						  `ordering` int(11) DEFAULT NULL,
        						  `section` varchar(20) DEFAULT NULL,
        						  `fieldfor` tinyint(2) DEFAULT NULL,
        						  `published` tinyint(1) DEFAULT NULL,
        						  `sys` tinyint(1) NOT NULL,
        						  `cannotunpublish` tinyint(1) NOT NULL,
        						  `required` tinyint(1) NOT NULL DEFAULT '0',
        						  PRIMARY KEY (`id`),
        						  KEY `fieldordering_filedfor` (`fieldfor`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14;";
            jssupportticket::$_db->query($query);
            $query = "INSERT INTO `" . jssupportticket::$_db->prefix . "js_ticket_fieldsordering` (`id`, `field`, `fieldtitle`, `ordering`, `section`, `fieldfor`, `published`, `sys`, `cannotunpublish`, `required`) VALUES (1, 'email', 'Email Address', 4, '10', 1, 1, 0, 1, 1),(2, 'fullname', 'Full Name', 2, '10', 1, 1, 0, 1, 1),(3, 'phone', 'Phone', 3, '10', 1, 1, 0, 0, 1),(4, 'department', 'Department', 5, '10', 1, 1, 0, 1, 1),(5, 'helptopic', 'Help Topic', 6, '10', 1, 1, 0, 1, 1),(6, 'priority', 'Priority', 1, '10', 1, 1, 0, 1, 1),(7, 'subject', 'Subject', 7, '10', 1, 1, 0, 1, 1),(8, 'premade', 'Premade', 8, '10', 1, 1, 0, 0, 1),(9, 'issuesummary', 'Issue Summary', 10, '10', 1, 1, 0, 1, 1),(10, 'attachments', 'Attachments', 9, '10', 1, 1, 0, 0, 1),(11, 'internalnotetitle', 'Internal Note Title', 11, '10', 1, 1, 0, 0, 1),(12, 'assignto', 'Assign To', 13, '10', 1, 1, 0, 0, 1),(13, 'duedate', 'Due Date', 12, '10', 1, 1, 0, 0, 1),(14, 'status', 'Status', 14, '10', 1, 1, 0, 0, 1),(15, 'users', 'Users', 14, '10', 1, 1, 0, 0, 0);";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_help_topics` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `isactive` tinyint(1) DEFAULT NULL,
        						  `autoresponce` tinyint(1) DEFAULT NULL,
        						  `departmentid` int(11) DEFAULT NULL,
        						  `priorityid` int(11) DEFAULT NULL,
        						  `topic` varchar(32) DEFAULT NULL,
        						  `ordering` int(11) NOT NULL,
        						  `created` datetime DEFAULT NULL,
        						  `updated` datetime DEFAULT NULL,
        						  `status` tinyint(1) DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_notes` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `ticketid` int(11) DEFAULT NULL,
        						  `staffid` int(11) DEFAULT NULL,
        						  `title` varchar(255) DEFAULT NULL,
        						  `note` text,
        						  `status` tinyint(1) DEFAULT NULL,
        						  `created` datetime DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_priorities` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `priority` varchar(60) DEFAULT NULL,
        						  `prioritycolour` varchar(7) DEFAULT NULL,
        						  `priorityurgency` int(1) DEFAULT NULL,
        						  `ispublic` varchar(45) DEFAULT NULL,
        						  `ordering` int(11) NOT NULL,
        						  `isdefault` tinyint(1) DEFAULT NULL,
        						  `status` tinyint(4) NOT NULL DEFAULT '0',
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5;";
            jssupportticket::$_db->query($query);
            $query = "INSERT INTO `" . jssupportticket::$_db->prefix . "js_ticket_priorities` (`id`, `priority`, `prioritycolour`, `priorityurgency`, `ispublic`, `ordering`, `isdefault`, `status`) VALUES (1, 'Low', '#86f793', 0, '1', 1, 1, 0),(2, 'High', '#ed8e00', 0, '1', 3, 0, 1),(3, 'Normal', '#c7cbf5', 0, '1', 2, 0, 1),(4, 'Urgent', '#c90000', 0, '', 4, 0, 0);";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_replies` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `uid` int(11) NOT NULL,
        						  `ticketid` int(11) DEFAULT NULL,
        						  `name` varchar(50) DEFAULT NULL,
        						  `message` text,
        						  `staffid` int(11) DEFAULT NULL,
        						  `rating` enum('1','5') DEFAULT NULL,
        						  `status` tinyint(1) DEFAULT NULL,
        						  `created` datetime DEFAULT NULL,
        						  `ticketviaemail` tinyint(1) NOT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_staff` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `uid` int(11) DEFAULT NULL,
        						  `groupid` int(11) DEFAULT NULL,
        						  `roleid` int(11) DEFAULT NULL,
        						  `departmentid` int(11) DEFAULT NULL,
        						  `firstname` varchar(128) DEFAULT NULL,
        						  `lastname` varchar(128) DEFAULT NULL,
        						  `username` varchar(45) DEFAULT NULL,
        						  `email` varchar(128) DEFAULT NULL,
        						  `phone` varchar(24) DEFAULT NULL,
        						  `phoneext` varchar(6) DEFAULT NULL,
        						  `mobile` varchar(24) DEFAULT NULL,
        						  `signature` text,
        						  `isadmin` tinyint(1) DEFAULT NULL,
        						  `isvisible` tinyint(1) DEFAULT NULL,
        						  `onvocation` tinyint(1) DEFAULT NULL,
        						  `appendsignature` tinyint(1) DEFAULT NULL,
        						  `autorefreshrate` tinyint(1) DEFAULT NULL,
        						  `photo` varchar(150) NOT NULL,
        						  `status` tinyint(1) DEFAULT NULL,
        						  `created` datetime DEFAULT NULL,
        						  `lastlogin` datetime DEFAULT NULL,
        						  `updated` datetime DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `from` int(11) DEFAULT NULL,
        						  `to` int(11) DEFAULT NULL,
        						  `message` text,
        						  `subject` varchar(255) DEFAULT NULL,
        						  `isread` tinyint(1) DEFAULT '0',
        						  `replytoid` int(11) DEFAULT NULL,
        						  `deletedby` int(11) DEFAULT NULL,
        						  `status` tinyint(1) DEFAULT NULL,
        						  `created` datetime DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_system_errors` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `uid` int(11) DEFAULT NULL,
        						  `error` text,
        						  `isview` tinyint(1) DEFAULT '0',
        						  `created` datetime DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_tickets` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `uid` int(11) DEFAULT NULL,
        						  `ticketid` varchar(11) DEFAULT NULL,
        						  `departmentid` int(11) DEFAULT NULL,
        						  `priorityid` int(11) DEFAULT NULL,
        						  `staffid` int(11) DEFAULT NULL,
        						  `email` varchar(255) DEFAULT NULL,
        						  `name` varchar(100) DEFAULT NULL,
        						  `subject` varchar(255) DEFAULT NULL,
        						  `message` text,
        						  `helptopicid` int(11) DEFAULT NULL,
        						  `phone` varchar(16) DEFAULT NULL,
        						  `phoneext` varchar(8) DEFAULT NULL,
        						  `status` tinyint(1) DEFAULT NULL,
        						  `isoverdue` tinyint(1) DEFAULT NULL,
        						  `isanswered` tinyint(1) NOT NULL DEFAULT '0',
        						  `duedate` datetime DEFAULT NULL,
        						  `reopened` datetime DEFAULT NULL,
        						  `closed` datetime DEFAULT NULL,
        						  `lastreply` datetime DEFAULT NULL,
        						  `created` datetime DEFAULT NULL,
        						  `updated` datetime DEFAULT NULL,
        						  `lock` tinyint(4) NOT NULL DEFAULT '0',
        						  `ticketviaemail` tinyint(1) NOT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_userfields` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `name` varchar(50) NOT NULL DEFAULT '',
        						  `title` varchar(255) NOT NULL,
        						  `description` mediumtext,
        						  `type` varchar(50) NOT NULL DEFAULT '',
        						  `maxlength` int(11) DEFAULT NULL,
        						  `size` int(11) DEFAULT NULL,
        						  `required` tinyint(4) DEFAULT '0',
        						  `ordering` int(11) DEFAULT NULL,
        						  `cols` int(11) DEFAULT NULL,
        						  `rows` int(11) DEFAULT NULL,
        						  `value` varchar(50) DEFAULT NULL,
        						  `default` int(11) DEFAULT NULL,
        						  `published` tinyint(1) NOT NULL DEFAULT '1',
        						  `fieldfor` tinyint(2) NOT NULL DEFAULT '0',
        						  `readonly` tinyint(1) NOT NULL DEFAULT '0',
        						  `calculated` tinyint(1) NOT NULL DEFAULT '0',
        						  `sys` tinyint(4) NOT NULL DEFAULT '0',
        						  `params` mediumtext,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_userfieldvalues` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `field` int(11) NOT NULL DEFAULT '0',
        						  `fieldtitle` varchar(255) NOT NULL DEFAULT '',
        						  `fieldvalue` varchar(255) NOT NULL,
        						  `ordering` int(11) NOT NULL DEFAULT '0',
        						  `sys` tinyint(4) NOT NULL DEFAULT '0',
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_userfield_data` (
        						  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        						  `referenceid` int(11) NOT NULL,
        						  `field` int(10) unsigned DEFAULT NULL,
        						  `data` varchar(1000) DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
            jssupportticket::$_db->query($query);
            $query = "CREATE TABLE IF NOT EXISTS `" . jssupportticket::$_db->prefix . "js_ticket_userrole` (
        						  `id` int(11) NOT NULL AUTO_INCREMENT,
        						  `uid` int(11) DEFAULT '0',
        						  `roleid` int(11) DEFAULT NULL,
        						  `status` tinyint(1) DEFAULT NULL,
        						  `update` datetime DEFAULT NULL,
        						  `created` datetime DEFAULT NULL,
        						  PRIMARY KEY (`id`)
        						) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
            jssupportticket::$_db->query($query);
        }
    }

}

?>
