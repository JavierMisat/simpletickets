<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTticketController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        if (is_admin()) {
            $defaultlayout = "tickets";
        } else
            $defaultlayout = "myticket";
        $layout = JSSTrequest::getLayout('jstlay', null, $defaultlayout);
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_tickets':
                    $list = null;
                    if (isset($_POST['list']))
                        $list = $_POST['list'];
                    JSSTincluder::getJSModel('ticket')->getTicketsForAdmin($list);
                    //JSSTincluder::getJSModel('ticketviaemail')->readEmails();
                    break;
                case 'admin_addticket':
                case 'addticket':
                case 'staffaddticket':
                    $id = JSSTrequest::getVar('jssupportticketid');
                    jssupportticket::$_data['permission_granted'] = true;
                    if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                        $per_task = ($id == null) ? 'Add Ticket' : 'Edit Ticket';
                        jssupportticket::$_data['permission_granted'] = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask($per_task);
                    }
                    if (jssupportticket::$_data['permission_granted']) {
                        JSSTincluder::getJSModel('ticket')->getTicketsForForm($id);
                    }
                    break;
                case 'admin_ticketdetail':
                case 'ticketdetail':
                    $id = JSSTrequest::getVar('jssupportticketid');
                    jssupportticket::$_data['permission_granted'] = true;
                    jssupportticket::$_data['user_staff'] = JSSTincluder::getJSModel('staff')->isUserStaff();
                    if (jssupportticket::$_data['user_staff']) {
                        jssupportticket::$_data['permission_granted'] = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('View Ticket');
                    }
                    if (jssupportticket::$_data['permission_granted']) {
                        JSSTincluder::getJSModel('ticket')->getTicketForDetail($id);
                    }
                    break;
                case 'myticket':
                    JSSTincluder::getJSModel('ticket')->getMyTickets();
                    break;
                case 'staffmyticket':
                    JSSTincluder::getJSModel('ticket')->getStaffTickets();
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'ticket');
            JSSTincluder::include_file($layout, $module);
        }
    }

    function canaddfile() {
        if (isset($_POST['form_request']) && $_POST['form_request'] == 'jssupportticket')
            return false;
        elseif (isset($_GET['action']) && $_GET['action'] == 'jstask')
            return false;
        else
            return true;
    }

    function closeticket() {
        $id = JSSTrequest::getVar('ticketid');
        JSSTincluder::getJSModel('ticket')->closeTicket($id);
        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket&jstlay=tickets");
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=myticket&list=2");
        }
        wp_redirect($url);
        exit;
    }

    function lockticket() {
        $id = JSSTrequest::getVar('ticketid');
        JSSTincluder::getJSModel('ticket')->lockTicket($id);
        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $id);
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=" . $id);
        }
        wp_redirect($url);
        exit;
    }

    function unlockticket() {
        $id = JSSTrequest::getVar('ticketid');
        JSSTincluder::getJSModel('ticket')->unLockTicket($id);
        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $id);
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=" . $id);
        }
        wp_redirect($url);
        exit;
    }

    static function saveticket() {
        $data = JSSTrequest::get('post');
        $result = JSSTincluder::getJSModel('ticket')->storeTickets($data);
        if (is_admin()) {
            if($result == false){
                $url = admin_url("admin.php?page=ticket&jstlay=addticket");
            }else{
                $url = admin_url("admin.php?page=ticket&jstlay=tickets");
            }
        } else {
            if (get_current_user_id() == 0) { // visitor
                if ($result != 1) { // error on captcha or ticket validation
                    $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=addticket");
                } else { // all things perfect
                    $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=ticketstatus");
                }
            } else {
                if ($result == false) { // error on captcha or ticket validation
                    $addticket = (JSSTincluder::getJSModel('staff')->isUserStaff()) ? 'staffaddticket' : 'addticket';
                    $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=$addticket");
                } else {
                    $myticket = (JSSTincluder::getJSModel('staff')->isUserStaff()) ? 'staffmyticket' : 'myticket';
                    $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=$myticket");
                }
            }
        }
        if($result == false){
            JSSTformfield::setFormData($data);
        }
        wp_redirect($url);
        exit;
    }

    static function transferdepartment() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('ticket')->tickDepartmentTransfer($data);
        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid']);
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid']);
        }
        wp_redirect($url);
        exit;
    }

    static function assigntickettostaff() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('ticket')->assignTicketToStaff($data);
        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid']);
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid']);
        }
        wp_redirect($url);
        exit;
    }

    static function deleteticket() {
        $id = JSSTrequest::getVar('ticketid');
        JSSTincluder::getJSModel('ticket')->removeTicket($id);
        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket&jstlay=tickets");
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=myticket");
        }
        wp_redirect($url);
        exit;
    }

    static function enforcedeleteticket() {
        $id = JSSTrequest::getVar('ticketid');
        JSSTincluder::getJSModel('ticket')->removeEnforceTicket($id);
        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket&jstlay=tickets");
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=myticket");
        }
        wp_redirect($url);
        exit;
    }

    static function changepriority() {
        $id = JSSTrequest::getVar('ticketid');
        $priorityid = JSSTrequest::getVar('priority');
        JSSTincluder::getJSModel('ticket')->changeTicketPriority($id, $priorityid);
        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $id);
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=" . $id);
        }
        wp_redirect($url);
        exit;
    }

    static function reopenticket() { // for user
        $ticketid = JSSTrequest::getVar('ticketid');
        $data['ticketid'] = $ticketid;
        JSSTincluder::getJSModel('ticket')->reopenTicket($data);
        $url = "&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid'];
        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket" . $url);
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket" . $url);
        }
        wp_redirect($url);
        exit;
    }

    static function actionticket() {
        $data = JSSTrequest::get('post');
        /* to handle actions */
        switch ($data['actionid']) {
            case 1: /* Change Priority Ticket */
                JSSTincluder::getJSModel('ticket')->changeTicketPriority($data['ticketid'], $data['priority']);
                $url = "&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid'];
                break;
            case 2: /* close ticket */
                JSSTincluder::getJSModel('ticket')->closeTicket($data['ticketid']);
                $url = "&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid'];
                break;
            case 3: /* Reopen Ticket */
                JSSTincluder::getJSModel('ticket')->reopenTicket($data);
                $url = "&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid'];
                break;
            case 4: /* Lock Ticket */
                JSSTincluder::getJSModel('ticket')->lockTicket($data['ticketid']);
                $url = "&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid'];
                break;
            case 5: /* Unlock ticket */
                JSSTincluder::getJSModel('ticket')->unLockTicket($data['ticketid']);
                $url = "&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid'];
                break;
            case 6: /* Banned Email */
                JSSTincluder::getJSModel('ticket')->banEmail($data);
                $url = "&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid'];
                break;
            case 7: /* Unban Email */
                JSSTincluder::getJSModel('ticket')->unbanEmail($data);
                $url = "&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid'];
                break;
            case 8: /* Mark over due */
                JSSTincluder::getJSModel('ticket')->markOverDueTicket($data);
                $url = "&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid'];
                break;
            case 9: /* In Progress */
                JSSTincluder::getJSModel('ticket')->markTicketInProgress($data);
                $url = "&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid'];
                break;
            case 10: /* ban Email & close ticket */
                JSSTincluder::getJSModel('ticket')->banEmailAndCloseTicket($data);
                $url = "&jstlay=ticketdetail&jssupportticketid=" . $data['ticketid'];
                break;
        }

        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket" . $url);
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket" . $url);
        }
        wp_redirect($url);
        exit;
    }

    static function showticketstatus() {
        $token = JSSTrequest::getVar('token');
        if ($token == null) { // in case it come from ticket status form
            $emailaddress = JSSTrequest::getVar('email');
            $trackingid = JSSTrequest::getVar('ticketid');
            $token = JSSTincluder::getJSModel('ticket')->createTokenByEmailAndTrackingId($emailaddress, $trackingid);
        }
        $_SESSION['js-support-ticket']['token'] = $token;
        $ticketid = JSSTincluder::getJSModel('ticket')->getTicketidForVisitor($token);
        if ($ticketid) {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=" . $ticketid);
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=ticketstatus");
            JSSTmessage::setMessage(__('Record not found', 'js-support-ticket'), 'error');
        }
        wp_redirect($url);
        exit;
    }
    
    function downloadbyid(){
        $id = JSSTrequest::getVar('id');
        JSSTincluder::getJSModel('attachment')->getDownloadAttachmentById($id);
    }

    
    function downloadbyname(){
        $name = JSSTrequest::getVar('name');
        $id = JSSTrequest::getVar('id');
        JSSTincluder::getJSModel('attachment')->getDownloadAttachmentByName($name,$id);
    }

}

$ticketController = new JSSTticketController();
?>
