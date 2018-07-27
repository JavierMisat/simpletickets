<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTroleModel {

    function getRoles() {
        $isadmin = is_admin();
        $rolename = ($isadmin) ? 'rolename' : 'jsst-role';
        $name = JSSTrequest::getVar($rolename);

        if ($isadmin) {
            $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
            if ($formsearch == 'JSST_SEARCH') {
                $_SESSION['JSST_SEARCH']['rolename'] = $name;
            }
        }

        if (JSSTrequest::getVar('pagenum', 'get', null) != null && $isadmin) {
            $name = (isset($_SESSION['JSST_SEARCH']['rolename']) && $_SESSION['JSST_SEARCH']['rolename'] != '') ? $_SESSION['JSST_SEARCH']['rolename'] : null;
        }
        $name = jssupportticket::parseSpaces($name);
        $inquery = '';
        if ($name != null)
            $inquery .= " AND aclrole.name LIKE '%$name%'";

        jssupportticket::$_data['filter'][$rolename] = $name;

        // Pagination
        $query = "SELECT COUNT(`id`) FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_roles` AS aclrole WHERE 1=1 ";
        $query .= $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        // Data
        $query = "SELECT  id, name FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_roles` AS aclrole WHERE status = 1 ";
        $query .= $inquery;
        $query .= " ORDER BY aclrole.status ASC,aclrole.name ASC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function getRoleForForm($id) {
        $permission_by_task = array();

        $role = "";
        if ($id) {
            if (is_numeric($id) == false)
                return false;
            $query = "SELECT role.*
			FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_roles` AS role
			WHERE role.id = " . $id;
            $role = jssupportticket::$_db->get_row($query);

            $query = "SELECT r_per.permissionid AS rolepermissionid,per.id,per.permission,per.permissiongroup AS pgroup 
			FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_permissions` AS per
            LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_acl_role_permissions` AS r_per ON (r_per.roleid=" . $id . " AND r_per.permissionid=per.id )
			ORDER BY per.permissiongroup,per.id";
            jssupportticket::$_data[0]['permisssions'] = jssupportticket::$_db->get_results($query);

            $query = "SELECT role_dept.departmentid AS roledepartmentid,dep.id,dep.departmentname AS name
			FROM `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS dep
            LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_acl_role_access_departments` AS role_dept ON (role_dept.roleid=" . $id . " AND role_dept.departmentid=dep.id )
			ORDER BY dep.id";
            //echo $query;
            $department_role = jssupportticket::$_db->get_results($query);
        }else {
            $query = "SELECT per.id,per.permission,per.permissiongroup AS pgroup
			FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_permissions` AS per
			WHERE per.status= 1 ORDER BY per.permissiongroup,id";
            jssupportticket::$_data[0]['permisssions'] = jssupportticket::$_db->get_results($query);

            $query = "SELECT dep.id,dep.departmentname AS name
			FROM `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS dep
			WHERE dep.status= 1 ORDER BY dep.id";
            $department_role = jssupportticket::$_db->get_results($query);
        }
        foreach (jssupportticket::$_data[0]['permisssions'] AS $roleper) {
            $rolepermissionid = "";
            if (isset($roleper->rolepermissionid)) {
                $rolepermissionid = $roleper->rolepermissionid;
            }
            switch ($roleper->pgroup) {
                case 1:
                    $permission_by_task['ticket_section'][] = (object) array('id' => $roleper->id, 'permission' => $roleper->permission, 'pgroup' => $roleper->pgroup, 'rolepermissionid' => $rolepermissionid);
                    break;
                case 2:
                    $permission_by_task['staff_section'][] = (object) array('id' => $roleper->id, 'permission' => $roleper->permission, 'pgroup' => $roleper->pgroup, 'rolepermissionid' => $rolepermissionid);
                    break;
                case 3:
                    $permission_by_task['kb_section'][] = (object) array('id' => $roleper->id, 'permission' => $roleper->permission, 'pgroup' => $roleper->pgroup, 'rolepermissionid' => $rolepermissionid);
                    break;
                case 4:
                    $permission_by_task['faq_section'][] = (object) array('id' => $roleper->id, 'permission' => $roleper->permission, 'pgroup' => $roleper->pgroup, 'rolepermissionid' => $rolepermissionid);
                    break;
                case 5:
                    $permission_by_task['download_section'][] = (object) array('id' => $roleper->id, 'permission' => $roleper->permission, 'pgroup' => $roleper->pgroup, 'rolepermissionid' => $rolepermissionid);
                    break;
                case 6:
                    $permission_by_task['announcement_section'][] = (object) array('id' => $roleper->id, 'permission' => $roleper->permission, 'pgroup' => $roleper->pgroup, 'rolepermissionid' => $rolepermissionid);
                    break;
                case 7:
                    $permission_by_task['mail_section'][] = (object) array('id' => $roleper->id, 'permission' => $roleper->permission, 'pgroup' => $roleper->pgroup, 'rolepermissionid' => $rolepermissionid);
                    break;
            }
        }
        jssupportticket::$_data[0]['role'] = $role;
        jssupportticket::$_data[0]['department_role'] = $department_role;
        jssupportticket::$_data[0]['permission_by_task'] = $permission_by_task;
    }

    function storeRole($data) {
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $task_allow = ($data['id'] == '') ? 'Add Role' : 'Edit Role';
            $allowed = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask($task_allow);
            if ($allowed != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket') . ' ' . __($task_allow, 'js-support-ticket'), 'error');
                return;
            }
        }
        if ($data['id'] == '') { //new
            $isexist = self::checkRoleExist($data['name']);
            if ($isexist == 2) {
                JSSTmessage::setMessage(__('Already exisits', 'js-support-ticket'), 'error');
                return;
            }
        }
        $query_array = array('id' => $data['id'],
            'name' => $data['name'],
            'status' => 1,
            'created' => date_i18n('Y-m-d H:i:s')
        );
        jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_acl_roles', $query_array);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        $last_role_id = jssupportticket::$_db->insert_id;
        JSSTincluder::getJSModel('roleaccessdepartments')->storeRoleAccessDepartments($data['roledepdata'], $last_role_id);
        JSSTincluder::getJSModel('rolepermissions')->storeRolePermissions($data['roleperdata'], $last_role_id);
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Role has been stored', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Role has not been stored', 'js-support-ticket'), 'error');
        }
    }

    function checkRoleExist($name) {
        $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_roles` AS role ";
        $query.=" WHERE role.name = '" . $name . "'";
        $total = jssupportticket::$_db->get_var($query);
        if ($total > 0)
            return 2;
        return false;
    }

    function removeRole($id) {
        if (!is_numeric($id))
            return false;
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $allowed = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Delete Role');
            if ($allowed != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'error');
                return;
            }
        }
        if ($this->CanRemoveRole($id) == true) {
            if ($this->deleteRolePermissions($id) == true) {
                jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_acl_roles', array('id' => $id));
                if (jssupportticket::$_db->last_error == null) {
                    JSSTmessage::setMessage(__('Role has been deleted', 'js-support-ticket'), 'updated');
                } else {
                    JSSTincluder::getJSModel('systemerror')->addSystemError();
                    JSSTmessage::setMessage(__('Role has not been deleted', 'js-support-ticket'), 'error');
                }
            }
            return;
        } else {
            JSSTmessage::setMessage(__('Role','js-support-ticket').' '.__('in use cannot deleted', 'js-support-ticket'), 'error');
            return;
        }
    }

    private function deleteRolePermissions($roleid) {
        if (!is_numeric($roleid))
            return false;
        $query = "DELETE FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_role_access_departments` WHERE roleid = " . $roleid;
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
            return false;
        }
        $query = "DELETE FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_role_permissions` WHERE roleid = " . $roleid;
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
            return false;
        }
        return true;
    }

    private function CanRemoveRole($id) { //staffMemberCanDelete
        if (is_numeric($id) == false)
            return false;
        $query = "SELECT( 
                (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_access_departments` WHERE roleid = " . $id . ")   
                + 
                (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_permissions` WHERE roleid = " . $id . ")   
                + (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` WHERE roleid = " . $id . ")   
                ) AS total";
        $result = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        if ($result == 0)
            return true;
        else
            return false;
    }

    function getRolesForCombobox() {
        $query = "SELECT id, name AS text FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_roles` WHERE status = 1";
        $list = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $list;
    }

}

?>
