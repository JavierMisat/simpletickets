<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTpremademessageController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'premademessages');
        if (self::canaddfile()) {
            switch ($layout) {
                /* listing of all premade */
                case 'admin_premademessages':
                    JSSTincluder::getJSModel('premademessage')->getPremadeMessages();
                    break;
                /* form for premade */
                case 'admin_addpremademessage':
                    $id = JSSTrequest::getVar('jssupportticketid', 'get');
                    JSSTincluder::getJSModel('premademessage')->getPremadeMessageForForm($id);
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'premademessage');
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

    static function savepremademessage() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('premademessage')->storePreMadeMessage($data);
        $url = admin_url("admin.php?page=premademessage&jstlay=premademessages");
        wp_redirect($url);
        exit;
    }

    static function deletepremademessage() {
        $id = JSSTrequest::getVar('premademessageid');
        JSSTincluder::getJSModel('premademessage')->removePreMadeMessage($id);
        $url = admin_url("admin.php?page=premademessage&jstlay=premademessages");
        wp_redirect($url);
        exit;
    }

    static function changestatus() {
        $id = JSSTrequest::getVar('premadeid');
        JSSTincluder::getJSModel('premademessage')->changeStatus($id);
        $url = admin_url("admin.php?page=premademessage&jstlay=premademessages");
        wp_redirect($url);
        exit;
    }

}

$premademessageController = new JSSTpremademessageController();
?>
