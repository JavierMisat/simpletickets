<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTreplyController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $task = JSSTrequest::getLayout('task', null, 'replies_replies');
        if (self::canaddfile()) {
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'reply');
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

    static function savereply() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('reply')->storeReplies($data);
        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . JSSTrequest::getVar('ticketid'));
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=" . JSSTrequest::getVar('ticketid'));
        }
        wp_redirect($url);
        exit;
    }

}

$replyController = new JSSTreplyController();
?>
