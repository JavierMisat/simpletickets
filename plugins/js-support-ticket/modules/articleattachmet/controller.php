<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTarticleattachmetController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'articleattachmets');
        if (self::canaddfile()) {
            switch ($layout) {
                // case 'attachment_getattachments':
                // 	$id = $_GET['jssupportticket_ticketid'];
                // 	JSSTincluder::getJSModel('replies')->getrepliesForForm($id);
                // break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'articleattachment');
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
        $articleid = JSSTrequest::getVar('articleid');
        JSSTincluder::getJSModel('articleattachmet')->removeAttachment($id , $articleid);
        if (is_admin()) {
            $url = admin_url("admin.php?page=knowledgebase&jstlay=addarticle&jssupportticketid=" . JSSTrequest::getVar('articleid'));
        }
        wp_redirect($url);
        exit;
    }

    function downloadbyid(){
        $id = JSSTrequest::getVar('id');
        JSSTincluder::getJSModel('articleattachmet')->getDownloadAttachmentById($id);
    }
}

$articleattachmetController = new JSSTarticleattachmetController();
?>
