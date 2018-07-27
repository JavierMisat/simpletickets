<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTemailtemplateController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'emailtemplates');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_emailtemplates':
                    $tempfor = JSSTrequest::getVar('for', null, 'tk-nw');
                    jssupportticket::$_data[1] = $tempfor;
                    JSSTincluder::getJSModel('emailtemplate')->getTemplate($tempfor);
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'emailtemplate');
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

    static function saveemailtemplate() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('emailtemplate')->storeEmailTemplate($data);
        if (is_admin()) {
            $url = admin_url("admin.php?page=emailtemplate&for=" . JSSTrequest::getVar('for'));
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=priority&jstlay=priorities");
        }
        wp_redirect($url);
        exit;
    }

}

$emailtemplateController = new JSSTemailtemplateController();
?>
