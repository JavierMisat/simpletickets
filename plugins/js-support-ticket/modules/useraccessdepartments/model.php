<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTuseraccessdepartmentsModel {

    function storeUserAccessDepartments($departmentaccess, $roleid, $staffid) {
        if (!is_numeric($roleid))
            return false;
        if (!is_numeric($staffid))
            return false;
        $staff_uid = JSSTincluder::getJSModel('staff')->getUidByStaffId($staffid);
        $new_departments = array();
        $query = "SELECT departmentid 
				FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_access_departments` WHERE staffid = " . $staffid;
        $old_departments = jssupportticket::$_db->get_results($query);
        if ($departmentaccess)
            foreach ($departmentaccess AS $key => $value) {
                $new_departments[] = $value;
            }
        $error = array();
        foreach ($old_departments AS $olddepid) {
            $match = false;
            foreach ($new_departments AS $depid) {
                if ($olddepid->departmentid == $depid) {
                    $match = true;
                    break;
                }
            }
            if ($match == false) {
                $query = "DELETE FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_access_departments` WHERE staffid = " . $staffid . " AND departmentid=" . $olddepid->departmentid;
                jssupportticket::$_db->query($query);
                if (jssupportticket::$_db->last_error != null) {
                    JSSTincluder::getJSModel('systemerror')->addSystemError();
                }
            }
        }

        foreach ($new_departments AS $depid) {
            $insert = true;
            foreach ($old_departments AS $olddepid) {
                if ($olddepid->departmentid == $depid) {
                    $insert = false;
                    break;
                }
            }
            if ($insert) {
                // replace query;
                $query_array = array('id' => '',
                    'uid' => $staff_uid,
                    'roleid' => $roleid,
                    'departmentid' => $depid,
                    'staffid' => $staffid,
                    'status' => 1
                );
                jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_acl_user_access_departments', $query_array);
                //echo "<pre>" ; print_r(jssupportticket::$_db);exit;
                if (jssupportticket::$_db->last_error != null) {
                    JSSTincluder::getJSModel('systemerror')->addSystemError();
                }
            } else { // update permission
                /* no need to update the recored b/c permission level is no more exist
                  $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_access_departments`
                  SET permissionlevel = " . $permissionlevel[$depid] . "
                  WHERE roleid = " . $roleid . " AND departmentid=" . $depid . " AND staffid = " . $staffid;
                  jssupportticket::$_db->query($query);
                  if (jssupportticket::$_db->last_error != null) {
                  JSSTincluder::getJSModel('systemerror')->addSystemError();
                  }
                 * 
                 */
            }
        }
    }

}

?>
