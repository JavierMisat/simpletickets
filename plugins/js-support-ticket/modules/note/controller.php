<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTnoteController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'notes');
        if (self::canaddfile()) {
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'note');
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

    static function savenote() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('note')->storeTicketInternalNote($data, $data['internalnote']);
        if (is_admin()) {
            $url = admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . JSSTrequest::getVar('ticketid'));
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=" . JSSTrequest::getVar('ticketid'));
        }
        wp_redirect($url);
        exit;
    }

    function downloadbyid(){
        $id = JSSTrequest::getVar('id');
        JSSTincluder::getJSModel('note')->getDownloadAttachmentById($id);
    }


}

$noteController = new JSSTnoteController();
?>
