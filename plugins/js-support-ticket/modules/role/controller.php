<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTroleController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'roles');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_roles':
                    JSSTincluder::getJSModel('role')->getRoles();
                    break;

                case 'admin_addrole':
                case 'admin_rolepermission':
                case 'addrole':
                case 'rolepermission':
                    $id = JSSTrequest::getVar('jssupportticketid');
                    jssupportticket::$_data['permission_granted'] = true;
                    if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                        $per_task = ($id == null) ? 'Add Role' : 'Edit Role';
                        jssupportticket::$_data['permission_granted'] = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask($per_task);
                    }
                    if (jssupportticket::$_data['permission_granted'])
                        JSSTincluder::getJSModel('role')->getRoleForForm($id);
                    break;
                case 'roles':
                    jssupportticket::$_data['permission_granted'] = true;
                    if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                        jssupportticket::$_data['permission_granted'] = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('View Role');
                    }
                    if (jssupportticket::$_data['permission_granted']) {
                        JSSTincluder::getJSModel('role')->getRoles();
                    }
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'role');
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

    static function saverole() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('role')->storeRole($data);
        if (is_admin()) {
            $url = admin_url("admin.php?page=role&jstlay=roles");
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=role&jstlay=roles");
        }
        wp_redirect($url);
        exit;
    }

    static function deleterole() {
        $id = JSSTrequest::getVar('roleid');
        JSSTincluder::getJSModel('role')->removeRole($id);
        if (is_admin()) {
            $url = admin_url("admin.php?page=role&jstlay=roles");
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=role&jstlay=roles");
        }
        wp_redirect($url);
        exit;
    }

}

$roleController = new JSSTroleController();
?>
