<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTdownloadattachmentController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'downloadattachments');
        if (self::canaddfile()) {
            switch ($layout) {
                // case 'attachment_getattachments':
                // 	$id = $_GET['jssupportticket_ticketid'];
                // 	JSSTincluder::getJSModel('replies')->getrepliesForForm($id);
                // break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'downloadattachment');
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

    static function deleteattachment() {
        $id = JSSTrequest::getVar('id');
        JSSTincluder::getJSModel('downloadattachment')->removeAttachment($id);
        if (is_admin()) {
            $url = admin_url("admin.php?page=download&jstlay=adddownload&jssupportticketid=" . JSSTrequest::getVar('downloadid'));
        }else{            
            $url = site_url("index.php?page_id=".jssupportticket::getPageID()."&jstmod=download&jstlay=adddownload&jssupportticketid=".JSSTRequest::getVar('downloadid'));
        }
        wp_redirect($url);
        exit;
    }

}

$downloadattachmentController = new JSSTdownloadattachmentController();
?>
