<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTuserpermissionsModel {

    function assignRolePermissionsToUser($staff) {
        //delete any other acl user permissions which is not the current role id
        $query = "DELETE FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_permissions` WHERE uid = " . $staff->uid;
        jssupportticket::$_db->query($query);
        $query = "INSERT INTO `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_permissions` (uid, roleid, staffid, permissionid, `grant`, status)
	              SELECT '" . $staff->uid . "' AS uid,'" . $staff->roleid . "' AS roleid,'" . $staff->id . "' AS staffid, permissionid, `grant`, status FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_role_permissions` WHERE roleid = " . $staff->roleid;
        jssupportticket::$_db->query($query);
        //delete any other acl user permissions which is not the current role id
        $query = "DELETE FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_access_departments` WHERE uid = " . $staff->uid;
        jssupportticket::$_db->query($query);
        $query = "INSERT INTO `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_access_departments` (uid, roleid, staffid, departmentid, status)
	              SELECT '" . $staff->uid . "' AS uid,'" . $staff->roleid . "' AS roleid,'" . $staff->id . "' AS staffid, departmentid, status FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_role_access_departments` WHERE roleid = " . $staff->roleid;
        jssupportticket::$_db->query($query);
        /*
          $new_permissions=array();
          $query = "SELECT permissionid,roleid,uid FROM `".jssupportticket::$_db->prefix."js_ticket_acl_user_permissions` WHERE staffid=".$staffid;
          $old_permissions= jssupportticket::$_db->get_results($query);
          foreach ($userpermissions AS $key=>$value) {
          $new_permissions[] = $value;
          }
          $error = false;
          foreach ($old_permissions AS $oldperid) {
          $match = false;
          foreach ($new_permissions AS $perid) {
          if ($oldperid->permissionid == $perid && $oldperid->roleid==$roleid && $oldperid->uid==$uid) {
          $match = true;
          break;
          }
          }
          if ($match == false) {
          $query = "DELETE FROM `".jssupportticket::$_db->prefix."js_ticket_acl_user_permissions` WHERE permissionid=" . $oldperid->permissionid." AND staffid=".$staffid ;
          jssupportticket::$_db->query($query);
          if(jssupportticket::$_db->last_error  != null){
          JSSTincluder::getJSModel('systemerror')->addSystemError();
          $error = true;
          }
          }
          }

          foreach ($new_permissions AS $perid) {
          $insert = true;
          foreach ($old_permissions AS $oldperid) {
          if ($oldperid->permissionid == $perid && $oldperid->roleid==$roleid && $oldperid->uid==$uid ) {
          $insert = false;
          break;
          }
          }
          if ($insert) {
          $query_array = array('id' => '',
          'uid' => $uid,
          'roleid' => $roleid,
          'staffid' => $staffid,
          'permissionid' => $perid,
          'grant' => 1,
          'status' => 1
          );
          jssupportticket::$_db->replace(jssupportticket::$_db->prefix.'js_ticket_acl_user_permissions',$query_array);
          if(jssupportticket::$_db->last_error  != null){
          JSSTincluder::getJSModel('systemerror')->addSystemError();
          $error = true;
          }

          }
          }
         */
        //echo "iam here"; exit;
        /*
          if ($error)
          return false;
         */
        return true;
    }

    //rough function nedd to change for wp
    // function getUserPermissions($staffid){
    // 	$db = $this->getDBO();
    // 	if (is_numeric($staffid) == false) return false;
    // 		$query = "SELECT u_per.permissionid AS userpermissionid,per.id,per.permission,per.permissiongroup AS pgroup 
    // 					FROM `#__js_ticket_acl_permissions` AS per
    //                        LEFT JOIN `#__js_ticket_acl_user_permissions` AS u_per ON (u_per.staffid=".$staffid." AND u_per.permissionid=per.id )
    // 					ORDER BY per.permissiongroup,per.id";
    // 		$db->setQuery($query);
    // 		$permission_user = $db->loadObjectList();
    // 		$query = "SELECT u_da.departmentid AS userdepartmentid,dep.id,dep.departmentname AS name
    // 					FROM `#__js_ticket_departments` AS dep
    // 					LEFT JOIN `#__js_ticket_acl_user_access_departments` AS u_da ON (u_da.staffid=".$staffid." AND u_da.departmentid=dep.id )
    // 					ORDER BY dep.id";
    // 		$db->setQuery($query);
    // 		$department_user = $db->loadObjectList();
    // 		$result[1] = $permission_user;
    // 		$result[2] = $department_user;
    // 		return $result;
    // }

    function storeUserPermissions($data) {
        $data['staffperdata'] = isset($data['staffperdata']) ? $data['staffperdata'] : '';
        $permissions = $data['staffperdata'];
        $staffid = $data['staffid'];
        $roleid = $data['roleid'];
        if (!is_numeric($staffid))
            return false;
        $staff_uid = JSSTincluder::getJSModel('staff')->getUidByStaffId($staffid);
        if (!$roleid)
            $roleid = JSSTincluder::getJSModel('staff')->getRoleidByStaffId($staffid);
        $new_permissions = array();
        $query = "SELECT permissionid FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_permissions` WHERE staffid = " . $staffid;
        $old_permissions = jssupportticket::$_db->get_results($query);
        if ($permissions)
            foreach ($permissions AS $key => $value) {
                $new_permissions[] = $value;
            }
        foreach ($old_permissions AS $oldperid) {
            $match = false;
            foreach ($new_permissions AS $perid) {
                if ($oldperid->permissionid == $perid) {
                    $match = true;
                    break;
                }
            }
            if ($match == false) {
                $query = "DELETE FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_permissions` WHERE staffid = " . $staffid . " AND permissionid=" . $oldperid->permissionid;
                jssupportticket::$_db->query($query);
                if (jssupportticket::$_db->last_error != null) {
                    JSSTincluder::getJSModel('systemerror')->addSystemError();
                }
            }
        }

        foreach ($new_permissions AS $perid) {
            $insert = true;
            foreach ($old_permissions AS $oldperid) {
                if ($oldperid->permissionid == $perid) {
                    $insert = false;
                    break;
                }
            }
            if ($insert) {
                // replace query;
                $query_array = array('id' => '',
                    'roleid' => $roleid,
                    'staffid' => $staffid,
                    'uid' => $staff_uid,
                    'permissionid' => $perid,
                    'grant' => 1,
                    'status' => 1
                );
                jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_acl_user_permissions', $query_array);
                if (jssupportticket::$_db->last_error != null) {
                    JSSTincluder::getJSModel('systemerror')->addSystemError();
                }
            }
        }
        $data['userdepdata'] = isset($data['userdepdata']) ? $data['userdepdata'] : '';
        JSSTincluder::getJSModel('useraccessdepartments')->storeUserAccessDepartments($data['userdepdata'], $roleid, $staffid);
    }

    static function checkStaffPermissionForTask($task) {
        if (is_admin())
            return true; // full access for admins
        $uid = get_current_user_id();
        $query = "SELECT count(user_per.id)
					FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_permissions` AS user_per
					JOIN `" . jssupportticket::$_db->prefix . "js_ticket_acl_permissions` AS per ON per.id = user_per.permissionid
					JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON staff.id = user_per.staffid
					WHERE per.permission='" . $task . "' AND staff.uid=" . $uid;
        echo $query;
        $allow_permission = jssupportticket::$_db->get_var($query);

        if ($allow_permission > 0)
            return true;
        else
            return false;
    }

    function checkPermissionGrantedForTask($task) {
        if(is_admin()){
          return true;
        }      
        // when calling from frotend then $task=Assign User Permissions
        $currentuserid = get_current_user_id();
        $query = "SELECT COUNT(user_per.id)"
                . "FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_permissions` AS per "
                . "JOIN `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_permissions` AS user_per ON user_per.permissionid = per.id "
                . "JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON staff.id = user_per.staffid "
                . "WHERE per.permission = '" . $task . "' AND staff.uid = $currentuserid";
        $allowed = jssupportticket::$_db->get_var($query);
        if ($allowed > 0)
            return true;
        else
            return false;
    }

}

?>
