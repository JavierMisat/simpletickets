<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTbanemailController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'banemails');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_banemails':
                    JSSTincluder::getJSModel('banemail')->getBanEmails();
                    break;

                case 'admin_addbanemail':
                    $id = JSSTrequest::getVar('jssupportticketid');
                    JSSTincluder::getJSModel('banemail')->getBanEmailForForm($id);
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'banemail');
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

    static function savebanemail() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('banemail')->storeBanEmail($data);
        $url = admin_url("admin.php?page=banemail&jstlay=banemails");
        wp_redirect($url);
        exit;
    }

    static function deletebanemail() {
        $id = JSSTrequest::getVar('banemailid');
        JSSTincluder::getJSModel('banemail')->removeBanEmail($id);
        $url = admin_url("admin.php?page=banemail&jstlay=banemails");
        wp_redirect($url);
        exit;
    }

}

$banemailController = new JSSTbanemailController();
?>
