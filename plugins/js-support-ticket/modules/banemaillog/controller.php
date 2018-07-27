<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTbanemaillogController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'banemaillogs');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_banemaillogs':
                    JSSTincluder::getJSModel('banemaillog')->getBanEmailLogs();
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'banemaillog');
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

    static function savebanemaillog() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('banemaillog')->storebanemaillog($data);
        $url = admin_url("admin.php?page=banemaillog&jstlay=banemaillogs");
        wp_redirect($url);
        exit;
    }

    static function deletebanemaillog() {
        $id = JSSTrequest::getVar('banemaillogid');
        JSSTincluder::getJSModel('banemaillog')->removeBanEmailLog($id);
        $url = admin_url("admin.php?page=banemaillog&jstlay=banemaillogs");
        wp_redirect($url);
        exit;
    }

}

$banemaillogController = new JSSTbanemaillogController();
?>
