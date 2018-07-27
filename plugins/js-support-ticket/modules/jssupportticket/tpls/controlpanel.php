<?php
if (jssupportticket::$_config['offline'] == 2) {	
    include_once(jssupportticket::$_path . 'includes/header.php');
    ?>
    <h1 class="js-ticket-heading"><?php echo jssupportticket::$_config['title']; ?></h1>
    <?php if (!JSSTincluder::getJSModel('staff')->isUserStaff()) { ?>
        <?php if (jssupportticket::$_config['cplink_openticket_user'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=addticket"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Open Ticket', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner1">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/open_ticket.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_myticket_user'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=myticket"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('My Tickets', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">            
                    <div class="js-ticket-frontend-manu-circle-inner2">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/my_tickets.png'; ?>"/>
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_checkticketstatus_user'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=ticketstatus"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Check Ticket Status', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner3">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/status.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_downloads_user'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=download&jstlay=downloads"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Downloads', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner4">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/downloads.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_announcements_user'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=announcement&jstlay=announcements"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Announcements', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">    
                    <div class="js-ticket-frontend-manu-circle-inner6">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/annoncements.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_faqs_user'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=faq&jstlay=faqs"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __("FAQ's", 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner5">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/faqs.png'; ?>"/>
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_knowledgebase_user'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=knowledgebase&jstlay=userknowledgebase"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Knowledge Base', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner7">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/knowledge_base.png'; ?>" />
                    </div>    
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_login_logout_user'] == 1){ ?>
        <?php if (!is_user_logged_in()): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=jssupportticket&jstlay=login"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Log In', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner1">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/login.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (is_user_logged_in()): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo wp_logout_url( home_url() ); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Log Out', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner1">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/logout.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif;
        } ?>
    <?php } ?>
    <?php if (JSSTincluder::getJSModel('staff')->isUserStaff()) { ?>
        <?php if (jssupportticket::$_config['cplink_openticket_staff'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=staffaddticket"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Open Ticket', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner1">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/open_ticket.png'; ?>">
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_myticket_staff'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=staffmyticket"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('My Tickets', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner2">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/my_tickets.png'; ?>">
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_addrole_staff'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=role&jstlay=addrole"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Add Role', 'js-support-ticket'); ?></span>        
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner7">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/add_role.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_roles_staff'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=role&jstlay=roles"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Roles', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner4">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/roles.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_addstaff_staff'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=staff&jstlay=addstaff"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Add Staff', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner6">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/adduser.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_staff_staff'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=staff&jstlay=staffs"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Staff', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner3">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/user.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_adddepartment_staff'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=department&jstlay=adddepartment"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Add Department', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner5">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/add_department.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_department_staff'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=department&jstlay=departments"); ?> ">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Departments', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner6">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/department.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_addcategory_staff'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=knowledgebase&jstlay=addcategory"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Add Category', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner1">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/add_category.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_category_staff'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=knowledgebase&jstlay=stafflistcategories"); ?> ">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Categories', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner7">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/categories.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_addkbarticle_staff'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=knowledgebase&jstlay=addarticle"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Add Knowledge Base', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner3">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/add_knowledgebase.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_kbarticle_staff'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=knowledgebase&jstlay=stafflistarticles"); ?> ">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Knowledge Base', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner2">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/knowledge_base.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_adddownload_staff'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=download&jstlay=adddownload"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Add Download', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner4">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/add_downloads.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_download_staff'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=download&jstlay=staffdownloads"); ?> ">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Downloads', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner1">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/downloads.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_addannouncement_staff'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=announcement&jstlay=addannouncement"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Add Announcement', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner6">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/add_nnoncements.png'; ?>" />
                    </div>
                </div>
            </a> 
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_announcement_staff'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=announcement&jstlay=staffannouncements"); ?> ">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Announcements', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner5">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/annoncements.png'; ?>" />
                    </div>
                </div>
            </a>    
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_addfaq_staff'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=faq&jstlay=addfaq"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Add FAQ', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner4">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/add_faqs.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_faq_staff'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=faq&jstlay=stafffaqs"); ?> ">
                <span class="js-ticket-frontend-manu-text"><?php echo __("FAQ's", 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner5">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/faqs.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_mail_staff'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=mail&jstlay=inbox"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Mail', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner3">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/mail_1.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_staff_report_staff'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=reports&jstlay=staffreports"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Staff Reports', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner2">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/staff-report.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_department_report_staff'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=reports&jstlay=departmentreports"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Departments Reports', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner4">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/department-report.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_myprofile_staff'] == 1): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=staff&jstlay=myprofile"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('My Profile', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner2">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/my_profile.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (jssupportticket::$_config['cplink_login_logout_staff'] == 1){ ?>
        <?php if (!is_user_logged_in()): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=jssupportticket&jstlay=login"); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Log In', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner1">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/login.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; ?>
        <?php if (is_user_logged_in()): ?>
            <a class="js-col-xs-12 js-col-sm-6 js-col-md-4 js-ticket-frontend-manu" href="<?php echo wp_logout_url( home_url() ); ?>">
                <span class="js-ticket-frontend-manu-text"><?php echo __('Log Out', 'js-support-ticket'); ?></span>
                <div class="js-ticket-frontend-manu-circle">
                    <div class="js-ticket-frontend-manu-circle-inner1">
                        <img class="js-ticket-frontend-manu-icon" src="<?php echo jssupportticket::$_pluginpath . 'includes/images/logout.png'; ?>" />
                    </div>
                </div>
            </a>
        <?php endif; 
        } ?>

    <?php } ?>
    <?php
} else {
    JSSTlayout::getSystemoffline();
} ?>