<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTstaffController {

    function __construct() {
        self::handleRequest();
    }

    function handleRequest() {
        $layout = JSSTrequest::getLayout('jstlay', null, 'staffs');
        if (self::canaddfile()) {
            switch ($layout) {
                case 'admin_staffs':
                case 'staffs':
                    jssupportticket::$_data['permission_granted'] = true;
                    if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                        jssupportticket::$_data['permission_granted'] = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('View User');
                    }
                    if (jssupportticket::$_data['permission_granted']) {
                        JSSTincluder::getJSModel('staff')->getStaffs();
                    }
                    break;
                case 'admin_addstaff':
                case 'addstaff':
                    $id = JSSTrequest::getVar('jssupportticketid');
                    jssupportticket::$_data['permission_granted'] = true;
                    if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                        $per_task = ($id == null) ? 'Add User' : 'Edit User';
                        jssupportticket::$_data['permission_granted'] = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask($per_task);
                    }
                    if (jssupportticket::$_data['permission_granted']) {
                        JSSTincluder::getJSModel('staff')->getStaffForForm($id);
                    }
                    break;
                case 'admin_staffpermissions':
                case 'staffpermissions':
                    $id = JSSTrequest::getVar('jssupportticketid');
                    jssupportticket::$_data['permission_granted'] = true;
                    if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
                        if ($layout != 'admin_staffpermissions')
                            jssupportticket::$_data['permission_granted'] = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Assign User Permissions');
                    }
                    if (jssupportticket::$_data['permission_granted']) {

                        JSSTincluder::getJSModel('staff')->getPermissionsForForm($id);
                    }
                    break;
                case 'myprofile':
                    JSSTincluder::getJSModel('staff')->getMyProfile();
                    break;
            }
            $module = (is_admin()) ? 'page' : 'jstmod';
            $module = JSSTrequest::getVar($module, null, 'staff');
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

    static function savestaff() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('staff')->storeStaff($data);
        if (is_admin()) {
            $url = admin_url("admin.php?page=staff&jstlay=staffs");
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=staff&jstlay=staffs");
        }
        wp_redirect($url);
        exit;
    }

    static function deletestaff() {
        $id = JSSTrequest::getVar('staffid');
        JSSTincluder::getJSModel('staff')->removeStaff($id);
        if (is_admin()) {
            $url = admin_url("admin.php?page=staff&jstlay=staffs");
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=staff&jstlay=staffs");
        }
        wp_redirect($url);
        exit;
    }

    static function changestatus() {
        $id = JSSTrequest::getVar('staffid');
        JSSTincluder::getJSModel('staff')->changeStatus($id);
        $url = admin_url("admin.php?page=staff&jstlay=staffs");
        wp_redirect($url);
        exit;
    }

    static function savepermissions() {
        $data = JSSTrequest::get('post');
        JSSTincluder::getJSModel('userpermissions')->storeUserPermissions($data);
        if (is_admin()) {
            $url = admin_url("admin.php?page=staff&jstlay=staffs");
        } else {
            $url = site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=staff&jstlay=staffs");
        }
        wp_redirect($url);
        exit;
    }

    function getStaffPhoto(){
       $staffid = JSSTrequest::getVar('jssupportticketid');
       $query = "SELECT photo FROM `".jssupportticket::$_db->prefix."js_ticket_staff` WHERE id = ".$staffid;
       $filename = jssupportticket::$_db->get_var($query);
        $maindir = wp_upload_dir();
        $path = $maindir['baseurl'];

       $file = $path.'/'.jssupportticket::$_config['data_directory'].'/staffdata/staff_'.$staffid.'/'.$filename;
       $image_mime = image_type_to_mime_type(exif_imagetype($file));
       header("Content-type: $image_mime");
       echo file_get_contents($file);
       die();
   }
}

$staffController = new JSSTstaffController();
?>
