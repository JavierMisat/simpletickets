<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTdownloadController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'downloads');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_downloads':
                case 'staffdownloads':
                    jssupportticket::$_data['permission_granted'] = true;
                    if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                        jssupportticket::$_data['permission_granted'] = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('View Download');
                    }
                    if (jssupportticket::$_data['permission_granted']) {
                        JSSTincluder::getJSModel('download')->getStaffDownloads();
                    }
                    break;
                case 'downloads':
                    $id = JSSTrequest::getVar('jssupportticketid');
                    JSSTincluder::getJSModel('download')->getDownloads($id);
                    break;
                case 'admin_adddownload':
                case 'adddownload':
                    $id = JSSTrequest::getVar('jssupportticketid');
                    jssupportticket::$_data['permission_granted'] = true;
                    if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                        $per_task = ($id == null) ? 'Add Download' : 'Edit Download';
                        jssupportticket::$_data['permission_granted'] = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask($per_task);
                    }
                    if (jssupportticket::$_data['permission_granted']) {
                        JSSTincluder::getJSModel('download')->getDownloadForForm($id);
                    }
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'download');
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

    static function savedownload() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('download')->storeDownload($data);
        if (is_admin()) {
            $url = admin_url("admin.php?page=download&jstlay=downloads");
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=download&jstlay=staffdownloads");
        }
        wp_redirect($url);
        exit;
    }

    static function downloadall() {
        JSSTincluder::getJSModel('download')->getAllDownloads();
        /*        if (is_admin()) {
          $url = admin_url("admin.php?page=download&jstlay=downloads");
          } else {
          $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=download&jstlay=staffdownloads");
          }
          wp_redirect($url);
         */ exit;
    }

    static function deletedownload() {
        $id = JSSTrequest::getVar('downloadid');
        JSSTincluder::getJSModel('download')->removeDownload($id);
        if (is_admin()) {
            $url = admin_url("admin.php?page=download&jstlay=downloads");
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=download&jstlay=staffdownloads");
        }
        wp_redirect($url);
        exit;
    }

    static function changestatus() {
        $id = JSSTrequest::getVar('downloadid');
        JSSTincluder::getJSModel('download')->changeStatus($id);
        $url = admin_url("admin.php?page=download&jstlay=downloads");
        $pagenum = JSSTrequest::getVar('pagenum');
        if ($pagenum)
            $url .= '&pagenum=' . $pagenum;
        wp_redirect($url);
        exit;
    }

    static function ordering() {
        $id = JSSTrequest::getVar('downloadid');
        JSSTincluder::getJSModel('download')->setOrdering($id);
        $pagenum = JSSTrequest::getVar('pagenum');
        $url = "admin.php?page=download&jstlay=downloads";
        if ($pagenum)
            $url .= '&pagenum=' . $pagenum;
        wp_redirect($url);
        exit;
    }

    function downloadbyid(){
        $id = JSSTrequest::getVar('id');
        JSSTincluder::getJSModel('download')->getDownloadAttachmentById($id);
    }
}

$downloadController = new JSSTdownloadController();
?>
