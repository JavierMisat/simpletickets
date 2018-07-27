<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTjssupportticketController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'controlpanel');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_controlpanel':
                    JSSTincluder::getJSModel('jssupportticket')->getControlPanelData();
                    break;
                case 'controlpanel':
                    JSSTincluder::getJSModel('jssupportticket')->getControlPanelData();
                    break;
                case 'admin_themes':
                    JSSTincluder::getJSModel('jssupportticket')->getCurrentTheme();
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'jssupportticket');
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
    static function savetheme() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('jssupportticket')->storeTheme($data);
        $url = admin_url("admin.php?page=jssupportticket&jstlay=themes");
        wp_redirect($url);
        exit;
    }

}

$controlpanelController = new JSSTjssupportticketController();
?>
