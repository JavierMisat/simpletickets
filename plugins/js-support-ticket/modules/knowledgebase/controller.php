<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTknowledgebaseController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'listarticles');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_listcategories':
                case 'stafflistcategories':
                    jssupportticket::$_data['permission_granted'] = true;
                    if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                        jssupportticket::$_data['permission_granted'] = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('View Category');
                    }
                    if (jssupportticket::$_data['permission_granted']) {
                        JSSTincluder::getJSModel('knowledgebase')->getAllStaffCategories();
                    }
                    break;
                case 'userknowledgebasearticles':
                    $id = JSSTrequest::getVar('jssupportticketid');
                    JSSTincluder::getJSModel('knowledgebase')->getKnowledgebase($id);
                    break;
                case 'userknowledgebase':
                    JSSTincluder::getJSModel('knowledgebase')->getKnowledgebaseCat();
                    break;
                case 'articledetails':
                    $id = JSSTrequest::getVar('jssupportticketid');
                    JSSTincluder::getJSModel('knowledgebase')->getArticleDetails($id);
                    break;
                case 'admin_addcategory':
                case 'addcategory':
                    $id = JSSTrequest::getVar('jssupportticketid');
                    jssupportticket::$_data['permission_granted'] = true;
                    if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                        $per_task = ($id == null) ? 'Add Category' : 'Edit Category';
                        jssupportticket::$_data['permission_granted'] = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask($per_task);
                    }
                    if (jssupportticket::$_data['permission_granted']) {
                        JSSTincluder::getJSModel('knowledgebase')->getCategoryForForm($id);
                    }
                    break;
                case 'stafflistarticles':
                case 'admin_listarticles':
                    jssupportticket::$_data['permission_granted'] = true;
                    if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                        jssupportticket::$_data['permission_granted'] = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('View Knowledge Base');
                    }
                    if (jssupportticket::$_data['permission_granted']) {
                        JSSTincluder::getJSModel('knowledgebase')->getStaffArticles();
                    }
                    break;

                case 'admin_addarticle':
                case 'addarticle':
                    $id = JSSTrequest::getVar('jssupportticketid');
                    jssupportticket::$_data['permission_granted'] = true;
                    if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                        $per_task = ($id == null) ? 'Add Knowledge Base' : 'Edit Knowledge Base';
                        jssupportticket::$_data['permission_granted'] = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask($per_task);
                    }
                    if (jssupportticket::$_data['permission_granted']) {
                        JSSTincluder::getJSModel('knowledgebase')->getArticleForForm($id);
                    }
                    break;
            }
            //echo $layout; exit();
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'knowledgebase');
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

    static function savecategory() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('knowledgebase')->storeCategory($data);
        if (is_admin()) {
            $url = admin_url("admin.php?page=knowledgebase&jstlay=listcategories");
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=knowledgebase&jstlay=stafflistcategories");
        }
        wp_redirect($url);
        exit;
    }

    static function deletecategory() {
        $id = JSSTrequest::getVar('categoryid');
        JSSTincluder::getJSModel('knowledgebase')->removeCategory($id);
        if (is_admin()) {
            $url = admin_url("admin.php?page=knowledgebase&jstlay=listcategories");
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=knowledgebase&jstlay=stafflistcategories");
        }
        wp_redirect($url);
        exit;
    }

    static function changestatuscategory() {
        $id = JSSTrequest::getVar('categoryid');
        JSSTincluder::getJSModel('knowledgebase')->changeStatusCategory($id);
        $url = admin_url("admin.php?page=knowledgebase&jstlay=listcategories");
        wp_redirect($url);
        exit;
    }

    static function savearticle() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('knowledgebase')->storeArticle($data);
        if (is_admin()) {
            $url = admin_url("admin.php?page=knowledgebase&jstlay=listarticles");
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=knowledgebase&jstlay=stafflistarticles");
        }
        wp_redirect($url);
        exit;
    }

    static function deletearticle() {
        $id = JSSTrequest::getVar('articleid');
        JSSTincluder::getJSModel('knowledgebase')->removeArticle($id);
        if (is_admin()) {
            $url = admin_url("admin.php?page=knowledgebase&jstlay=listarticles");
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=knowledgebase&jstlay=stafflistarticles");
        }
        wp_redirect($url);
        exit;
    }

    static function changestatusarticle() {
        $id = JSSTrequest::getVar('articleid');
        JSSTincluder::getJSModel('knowledgebase')->changeStatusArticle($id);
        $url = admin_url("admin.php?page=knowledgebase&jstlay=listarticles");
        $pagenum = JSSTrequest::getVar('pagenum');
        if ($pagenum)
            $url .= '&pagenum=' . $pagenum;
        wp_redirect($url);
        exit;
    }

    static function ordering() {
        $id = JSSTrequest::getVar('articleid');
        JSSTincluder::getJSModel('knowledgebase')->setOrdering($id);
        $pagenum = JSSTrequest::getVar('pagenum');
        $url = "admin.php?page=knowledgebase&jstlay=listarticles";
        if ($pagenum)
            $url .= '&pagenum=' . $pagenum;
        wp_redirect($url);
        exit;
    }

}

$knowledgebaseController = new JSSTknowledgebaseController();
?>
