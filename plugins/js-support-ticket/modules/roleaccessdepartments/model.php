<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTroleaccessdepartmentsModel {

    function storeRoleAccessDepartments($departmentaccess, $roleid) {
        if (!is_numeric($roleid))
            return false;
        $new_departments = array();
        $query = "SELECT departmentid 
				FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_role_access_departments` WHERE roleid = " . $roleid;
        $old_departments = jssupportticket::$_db->get_results($query);
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
                $query = "DELETE FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_role_access_departments` WHERE roleid = " . $roleid . " AND departmentid=" . $olddepid->departmentid;
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
                    'roleid' => $roleid,
                    'departmentid' => $depid,
                    'status' => 1,
                    'created' => date_i18n('Y-m-d H:i:s')
                );
                jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_acl_role_access_departments', $query_array);
                if (jssupportticket::$_db->last_error != null) {
                    JSSTincluder::getJSModel('systemerror')->addSystemError();
                }
            } else { // update permission
                /*
                  $query = "UPDATE `".jssupportticket::$_db->prefix."js_ticket_acl_role_access_departments`
                  SET permissionlevel = ".$permissionlevel[$depid]."
                  WHERE roleid = " . $roleid . " AND departmentid=" . $depid;
                  jssupportticket::$_db->query($query);
                  if(jssupportticket::$_db->last_error  != null){
                  JSSTincluder::getJSModel('systemerror')->addSystemError();
                  }
                 */
            }
        }
    }

}

?>
