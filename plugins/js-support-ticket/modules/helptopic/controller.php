<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSThelptopicController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'helptopics');
        if (self::canaddfile()) {
            switch ($layout) {
                /* listing of all help topics */
                case 'admin_helptopics':
                    JSSTincluder::getJSModel('helptopic')->getHelpTopics();
                    break;

                case 'admin_addhelptopic':
                    $id = JSSTrequest::getVar('jssupportticketid');
                    JSSTincluder::getJSModel('helptopic')->getHelpTopicForForm($id);
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'helptopic');
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

    static function savehelptopic() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('helptopic')->storeHelpTopic($data);
        $url = admin_url("admin.php?page=helptopic&jstlay=helptopics");
        wp_redirect($url);
        exit;
    }

    static function deletehelptopic() {
        $id = JSSTrequest::getVar('helptopicid');
        JSSTincluder::getJSModel('helptopic')->removeHelpTopic($id);
        $url = admin_url("admin.php?page=helptopic&jstlay=helptopics");
        wp_redirect($url);
        exit;
    }

    static function changestatus() {
        $id = JSSTrequest::getVar('helptopicid');
        JSSTincluder::getJSModel('helptopic')->changeStatus($id);
        $url = admin_url("admin.php?page=helptopic&jstlay=helptopics");
        $pagenum = JSSTrequest::getVar('pagenum');
        if ($pagenum)
            $url .= '&pagenum=' . $pagenum;
        wp_redirect($url);
        exit;
    }

    static function ordering() {
        $id = JSSTrequest::getVar('helptopicid');
        JSSTincluder::getJSModel('helptopic')->setOrdering($id);
        $pagenum = JSSTrequest::getVar('pagenum');
        $url = "admin.php?page=helptopic&jstlay=helptopics";
        if ($pagenum)
            $url .= '&pagenum=' . $pagenum;
        wp_redirect($url);
        exit;
    }

}

$helptopicController = new JSSThelptopicController();
?>
