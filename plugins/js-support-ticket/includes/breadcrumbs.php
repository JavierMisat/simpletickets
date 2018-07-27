<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTbreadcrumbs {

    static function getBreadcrumbs() {
        if (jssupportticket::$_config['show_breadcrumbs'] != 1)
            return false;
        if (!is_admin()) {
            $editid = JSSTrequest::getVar('jssupportticketid');
            $isnew = ($editid == null) ? true : false;
            //$array[] = array('link' => site_url(home_url()), 'text' => __('Home','js-support-ticket'));
            $array[] = array('link' => site_url("?page_id=" . jssupportticket::getPageid()."&jstmod=jssupportticket&jstlay=controlpanel"), 'text' => __('Control Panel', 'js-support-ticket'));
            $module = JSSTrequest::getVar('jstmod');
            $layout = JSSTrequest::getVar('jstlay');
            if (isset(jssupportticket::$_data['short_code_header'])) {
                switch (jssupportticket::$_data['short_code_header']){
                    case 'myticket':
                        $module = 'ticket';
                        $layout = (JSSTincluder::getJSModel('staff')->isUserStaff()) ? 'staffmyticket' : 'myticket';
                        break;
                    case 'addticket':
                        $module = 'ticket';
                        $layout = (JSSTincluder::getJSModel('staff')->isUserStaff()) ? 'staffaddticket' : 'addticket';
                        break;
                    case 'downloads':
                        $module = 'download';
                        $layout = 'downloads';
                        break;
                    case 'faqs':
                        $module = 'faq';
                        $layout = 'faqs';
                        break;
                    case 'announcements':
                        $module = 'announcement';
                        $layout = 'announcements';
                        break;
                    case 'userknowledgebase':
                        $module = 'knowledgebase';
                        $layout = 'userknowledgebase';
                        break;
                }
            }

            if ($module != null) {
                switch ($module) {
                    case 'announcement':
                        switch ($layout) {
                            case 'announcements':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Announcements', 'js-support-ticket'));
                                break;
                            case 'announcementdetails':
                                $layout1 = (JSSTincluder::getJSModel('staff')->isUserStaff()) ? 'staffannouncement' : 'announcements';
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout1), 'text' => __('Announcements', 'js-support-ticket'));
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Announcement Detail', 'js-support-ticket'));
                                break;
                            case 'addannouncement':
                                $layout1 = (JSSTincluder::getJSModel('staff')->isUserStaff()) ? 'staffannouncements' : 'announcements';
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout1), 'text' => __('Announcements', 'js-support-ticket'));
                                $text = ($isnew) ? __('Add Announcement', 'js-support-ticket') : __('Edit Announcement', 'js-support-ticket');
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => $text);
                                break;
                            case 'staffannouncements':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Announcements', 'js-support-ticket'));
                                break;
                        }
                        break;
                    case 'department':
                        switch ($layout) {
                            case 'adddepartment':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=departments'), 'text' => __('Departments', 'js-support-ticket'));
                                $text = ($isnew) ? __('Add Department', 'js-support-ticket') : __('Edit Department', 'js-support-ticket');
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => $text);
                                break;
                            case 'departments':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Departments', 'js-support-ticket'));
                                break;
                        }
                        break;
                    case 'reports':
                        switch ($layout) {
                            case 'staffdetailreport':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=staffreports'), 'text' => __('Staff reports', 'js-support-ticket'));
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Staff report', 'js-support-ticket'));
                                break;
                            case 'staffreports':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Staff reports', 'js-support-ticket'));
                                break;
                            case 'departmentreports':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Departments report', 'js-support-ticket'));
                                break;
                        }
                        break;
                    case 'download':
                        switch ($layout) {
                            case 'adddownload':
                                $layout1 = (JSSTincluder::getJSModel('staff')->isUserStaff()) ? 'staffdownloads' : 'downloads';
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout1), 'text' => __('Downloads', 'js-support-ticket'));
                                $text = ($isnew) ? __('Add Download', 'js-support-ticket') : __('Edit Download', 'js-support-ticket');
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => $text);
                                break;
                            case 'downloads':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Downloads', 'js-support-ticket'));
                                break;
                            case 'staffdownloads':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Downloads', 'js-support-ticket'));
                                break;
                        }
                        break;
                    case 'faq':
                        switch ($layout) {
                            case 'addfaq':
                                $layout1 = (JSSTincluder::getJSModel('staff')->isUserStaff()) ? 'stafffaqs' : 'faqs';
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout1), 'text' => __("FAQ's", 'js-support-ticket'));
                                $text = ($isnew) ? __('Add FAQ', 'js-support-ticket') : __('Edit FAQ', 'js-support-ticket');
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => $text);
                                break;
                            case 'faqdetails':
                                $layout1 = (JSSTincluder::getJSModel('staff')->isUserStaff()) ? 'stafffaqs' : 'faqs';
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout1), 'text' => __("FAQ's", 'js-support-ticket'));
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('FAQ Detail', 'js-support-ticket'));
                                break;
                            case 'faqs':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __("FAQ's", 'js-support-ticket'));
                                break;
                            case 'stafffaqs':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __("FAQ's", 'js-support-ticket'));
                                break;
                        }
                        break;
                    case 'jssupportticket':
                        break;
                    case 'knowledgebase':
                        switch ($layout) {
                            case 'addarticle':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=stafflistarticles'), 'text' => __('Knowledge Base', 'js-support-ticket'));
                                $text = ($isnew) ? __('Add Knowledge Base', 'js-support-ticket') : __('Edit Knowledge Base', 'js-support-ticket');
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => $text);
                                break;
                            case 'addcategory':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=stafflistcategories'), 'text' => __('Categories', 'js-support-ticket'));
                                $text = ($isnew) ? __('Add Category', 'js-support-ticket') : __('Edit Category', 'js-support-ticket');
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => $text);
                                break;
                            case 'articledetails':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=userknowledgebase'), 'text' => __('Knowledge Base', 'js-support-ticket'));
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Knowledge Base Detail', 'js-support-ticket'));
                                break;
                            case 'listarticles':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Knowledge Base', 'js-support-ticket'));
                                break;
                            case 'listcategories':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Categories', 'js-support-ticket'));
                                break;
                            case 'stafflistarticles':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Knowledge Base', 'js-support-ticket'));
                                break;
                            case 'stafflistcategories':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Categories', 'js-support-ticket'));
                                break;
                            case 'userknowledgebase':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Knowledge Base', 'js-support-ticket'));
                                break;
                            case 'userknowledgebasearticles':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Knowledge Base', 'js-support-ticket'));
                                break;
                        }
                        break;
                    case 'mail':
                        switch ($layout) {
                            case 'formmessage':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Message', 'js-support-ticket'));
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Send Message', 'js-support-ticket'));
                                break;
                            case 'inbox':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Message', 'js-support-ticket'));
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Inbox', 'js-support-ticket'));
                                break;
                            case 'outbox':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Message', 'js-support-ticket'));
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Outbox', 'js-support-ticket'));
                                break;
                            case 'message':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . 'inbox'), 'text' => __('Message', 'js-support-ticket'));
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Message', 'js-support-ticket'));
                                break;
                        }
                        break;
                    case 'role':
                        switch ($layout) {
                            case 'addrole':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=roles'), 'text' => __('Roles', 'js-support-ticket'));
                                $text = ($isnew) ? __('Add Role', 'js-support-ticket') : __('Edit Role', 'js-support-ticket');
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => $text);
                                break;
                            case 'rolepermission':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=roles'), 'text' => __('Roles', 'js-support-ticket'));
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Role permissions', 'js-support-ticket'));
                                break;
                            case 'roles':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Roles', 'js-support-ticket'));
                                break;
                        }
                        break;
                    case 'staff':
                        switch ($layout) {
                            case 'addstaff':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=staffs'), 'text' => __('Staffs', 'js-support-ticket'));
                                $text = ($isnew) ? __('Add Staff', 'js-support-ticket') : __('Edit Staff', 'js-support-ticket');
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => $text);
                                break;
                            case 'staffpermissions':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Staff Permissions', 'js-support-ticket'));
                                break;
                            case 'staffs':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=' . $module . '&jstlay=' . $layout), 'text' => __('Staffs', 'js-support-ticket'));
                                break;
                        }
                        break;
                    case 'ticket':
                        // Add default module link
                        //$array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=ticket&jstlay=myticket'), 'text' => __('Tickets', 'js-support-ticket'));
                        switch ($layout) {
                            case 'addticket':
                                $layout1 = (JSSTincluder::getJSModel('staff')->isUserStaff()) ? 'staffmyticket':'myticket';
                                $array[] = array('link' => site_url('?page_id='.jssupportticket::getPageid().'&jstmod=ticket&jstlay='.$layout1), 'text'=>__('My Tickets','js-support-ticket'));
                                $text = ($isnew) ? __('Add Ticket', 'js-support-ticket') : __('Edit Ticket', 'js-support-ticket');
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=ticket&jstlay=addticket'), 'text' => $text);
                                break;
                            case 'myticket':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=ticket&jstlay=myticket'), 'text' => __('My Tickets', 'js-support-ticket'));
                                break;
                            case 'staffaddticket':
                                $layout1 = (JSSTincluder::getJSModel('staff')->isUserStaff()) ? 'staffmyticket':'myticket';
                                $array[] = array('link' => site_url('?page_id='.jssupportticket::getPageid().'&jstmod=ticket&jstlay='.$layout1), 'text'=>__('My Tickets','js-support-ticket'));
                                $text = ($isnew) ? __('Add Ticket', 'js-support-ticket') : __('Edit Ticket', 'js-support-ticket');
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=ticket&jstlay=staffaddticket'), 'text' => $text);
                                break;
                            case 'staffmyticket':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=ticket&jstlay=staffmyticket'), 'text' => __('My Tickets', 'js-support-ticket'));
                                break;
                            case 'ticketdetail':
                                $layout1 = (JSSTincluder::getJSModel('staff')->isUserStaff()) ? 'staffmyticket' : 'myticket';
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=ticket&jstlay=' . $layout1), 'text' => __('My Tickets', 'js-support-ticket'));
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=ticket&jstlay=ticketdetail'), 'text' => __('Ticket Detail', 'js-support-ticket'));
                                break;
                            case 'ticketstatus':
                                $array[] = array('link' => site_url('?page_id=' . jssupportticket::getPageid() . '&jstmod=ticket&jstlay=ticketstatus'), 'text' => __('Ticket Status', 'js-support-ticket'));
                                break;
                        }
                        break;
                }
            }
        }

        if (isset($array)) {
            $count = count($array);
            $i = 0;
            echo '<div id="jsst_breadcrumbs_parent">';
            foreach ($array AS $obj) {
                if ($i == 0) {
                    echo '<div class="home"><a href="' . $obj['link'] . '"><img class="homeicon" src="' . jssupportticket::$_pluginpath . 'includes/images/homeicon.png"/></a></div>';
                } else {
                    if ($i == ($count - 1)) {
                        echo '<div class="lastlink">' . $obj['text'] . '</div>';
                    } else {
                        echo '<div class="links"><a class="links" href="' . $obj['link'] . '">' . $obj['text'] . '</a></div>';
                    }
                }
                $i++;
            }
            echo '</div>';
        }
    }

}

$jsbreadcrumbs = new JSSTbreadcrumbs;
?>
