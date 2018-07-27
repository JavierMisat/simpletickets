<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTpriorityController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'priorities');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_priorities':
                    JSSTincluder::getJSModel('priority')->getPriorities();
                    break;
                case 'admin_addpriority':
                    $id = JSSTrequest::getVar('jssupportticketid', 'get');
                    JSSTincluder::getJSModel('priority')->getPriorityForForm($id);
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'priority');
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

    static function savepriority() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('priority')->storePriority($data);
        if (is_admin()) {
            $url = admin_url("admin.php?page=priority&jstlay=priorities");
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=priority&jstlay=priorities");
        }
        wp_redirect($url);
        exit;
    }

    static function deletepriority() {
        $id = JSSTrequest::getVar('priorityid');
        JSSTincluder::getJSModel('priority')->removePriority($id);
        if (is_admin()) {
            $url = admin_url("admin.php?page=priority&jstlay=priorities");
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=priority&jstlay=priorities");
        }
        wp_redirect($url);
        exit;
    }

    static function makedefault() {
        $id = JSSTrequest::getVar('priorityid');
        JSSTincluder::getJSModel('priority')->makeDefault($id);
        $pagenum = JSSTrequest::getVar('pagenum');
        $url = "admin.php?page=priority&jstlay=priorities";
        if ($pagenum)
            $url .= '&pagenum=' . $pagenum;
        wp_redirect($url);
        exit;
    }

    static function ordering() {
        $id = JSSTrequest::getVar('priorityid');
        JSSTincluder::getJSModel('priority')->setOrdering($id);
        $pagenum = JSSTrequest::getVar('pagenum');
        $url = "admin.php?page=priority&jstlay=priorities";
        if ($pagenum)
            $url .= '&pagenum=' . $pagenum;
        wp_redirect($url);
        exit;
    }

}

$priorityController = new JSSTpriorityController();
?>
