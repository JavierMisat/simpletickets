<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTattachmentController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'getattachments');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'getattachments':
                    $id = JSSTrequest::getVar('jssupportticketid', 'get', null);
                    JSSTincluder::getJSModel('replies')->getrepliesForForm($id);
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'attachment');
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

    static function saveattachments() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('attachment')->storeAttachments($data);
        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . JSSTrequest::getVar('ticketid'));
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=replies&jstlay=replies");
        }
        wp_redirect($url);
        exit;
    }

    static function deleteattachment() {
        $id = JSSTrequest::getVar('id');
        JSSTincluder::getJSModel('attachment')->removeAttachment($id);
        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket&jstlay=addticket&jssupportticketid=" . JSSTrequest::getVar('ticketid'));
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=replies&jstlay=replies");
        }
        wp_redirect($url);
        exit;
    }

}

$attachmentController = new JSSTattachmentController();
?>
