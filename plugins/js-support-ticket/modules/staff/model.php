<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTstaffModel {

    private $errorcode = false;
    private $filename = '';

    function getStaffs() {
        $isadmin = is_admin();
        $uname = ($isadmin) ? 'username' : 'jsst-name';
        $statusname = ($isadmin) ? 'status' : 'jsst-status';
        $rolename = ($isadmin) ? 'roleid' : 'jsst-role';

        $username = JSSTrequest::getVar($uname);
        $statusid = JSSTrequest::getVar($statusname);
        $roleid = JSSTrequest::getVar($rolename);

        if ($isadmin) {
            $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
            if ($formsearch == 'JSST_SEARCH') {
                $_SESSION['JSST_SEARCH']['username'] = $username;
                $_SESSION['JSST_SEARCH']['status'] = $statusid;
                $_SESSION['JSST_SEARCH']['roleid'] = $roleid;
            }
        }
        if (JSSTrequest::getVar('pagenum', 'get', null) != null && $isadmin) {
            $username = (isset($_SESSION['JSST_SEARCH']['username']) && $_SESSION['JSST_SEARCH']['username'] != '') ? $_SESSION['JSST_SEARCH']['username'] : null;
            $statusid = (isset($_SESSION['JSST_SEARCH']['status']) && $_SESSION['JSST_SEARCH']['status'] != '') ? $_SESSION['JSST_SEARCH']['status'] : null;
            $roleid = (isset($_SESSION['JSST_SEARCH']['roleid']) && $_SESSION['JSST_SEARCH']['roleid'] != '') ? $_SESSION['JSST_SEARCH']['roleid'] : null;
        }
        $username = jssupportticket::parseSpaces($username);
        $condition = " WHERE ";
        $inquery = '';
        if ($username != null) {
            $inquery .=$condition . "user.user_login LIKE '%$username%'";
            $condition = " AND ";
        }
        if ($statusid > -1) {
            if (!is_numeric($statusid))
                return false;
            $inquery .=$condition . "staff.status=" . $statusid;
            $condition = " AND ";
        }
        if ($roleid) {
            if (!is_numeric($roleid))
                return false;
            $inquery .=$condition . "staff.roleid= " . $roleid;
        }

        jssupportticket::$_data['filter'][$uname] = $username;
        jssupportticket::$_data['filter'][$statusname] = $statusid;
        jssupportticket::$_data['filter'][$rolename] = $roleid;

        // Pagination
        $query = "SELECT COUNT(staff.id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff
                JOIN `" . jssupportticket::$_wpprefixforuser . "users` AS user on staff.uid = user.id
        ";
        $query .= $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        // Data
        $query = "SELECT staff.* ,role.name AS rolename, user.user_login AS username
            FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff
            JOIN `" . jssupportticket::$_db->prefix . "js_ticket_acl_roles` AS role on staff.roleid = role.id
            JOIN `" . jssupportticket::$_wpprefixforuser . "users` AS user on staff.uid = user.id
            ";
        $query .= $inquery;
        $query .= " ORDER BY staff.username ASC,staff.status ASC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);

        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }

        return;
    }

    function getStaffForForm($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
            $query = " SELECT staff.* ,role.name AS rolename
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff
                    JOIN `" . jssupportticket::$_db->prefix . "js_ticket_acl_roles` AS role on staff.roleid = role.id
                    WHERE staff.id = " . $id;
            jssupportticket::$_data[0] = jssupportticket::$_db->get_row($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            }
        }
        JSSTincluder::getJSModel('faq')->checkdata();
        return;
    }

    function getPermissionsForForm($staffid) {
        $permission_by_task = array();
        $role = "";
        if ($staffid) {
            if (!is_numeric($staffid))
                return false;
            $query = "SELECT role.*
            FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_roles` AS role
            JOIN `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_permissions` AS user_per ON user_per.roleid=role.id 
            WHERE user_per.staffid = " . $staffid;
            $role = jssupportticket::$_db->get_row($query);
            $query = "SELECT user_per.staffid, user_per.permissionid AS rolepermissionid,per.id,per.permission,per.permissiongroup AS pgroup 
            FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_permissions` AS per
            LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_permissions` AS user_per ON (user_per.permissionid=per.id AND user_per.staffid = " . $staffid . ")
            ORDER BY per.permissiongroup,per.id";
            jssupportticket::$_data[0]['permisssions'] = jssupportticket::$_db->get_results($query);

            $query = "SELECT access_dept.departmentid AS roledepartmentid,dep.id,dep.departmentname AS name
            FROM `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS dep
            LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_access_departments` AS access_dept ON (access_dept.staffid=" . $staffid . " AND access_dept.departmentid=dep.id )
            ORDER BY dep.id";
            $department_role = jssupportticket::$_db->get_results($query);

            $query = "SELECT firstname, lastname FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` WHERE id = " . $staffid;
            jssupportticket::$_data[0]['staff'] = jssupportticket::$_db->get_row($query);
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
        jssupportticket::$_data[0]['staffid'] = $staffid;
    }

    function storeStaff($data) {
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $task_allow = ($data['id'] == '') ? 'Add User' : 'Edit User';
            $allowed = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask($task_allow);
            if ($allowed != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket') . ' ' . __($task_allow, 'js-support-ticket'), 'error');
                return;
            }
        }
        if ($data['id']) {
            $updated = date_i18n('Y-m-d H:i:s');
            $created = $data['created'];
        } else { // newstaff
            if (!$this->validateStaff($data['uid'])) {
                JSSTmessage::setMessage(__('User already staff member', 'js-support-ticket'), 'error');
                return;
            }
            $created = date_i18n('Y-m-d H:i:s');
            $updated = $data['updated'];
        }
        $data['username'] = isset($data['username']) ? $data['username'] : '';
        $data['appendsignature'] = isset($data['appendsignature']) ? $data['appendsignature'] : '';
        $data['lastlogin'] = isset($data['lastlogin']) ? $data['lastlogin'] : '';
        
        $query_array = array('id' => $data['id'],
            'uid' => $data['uid'],
            'username' => $data['username'],
            'roleid' => $data['roleid'],
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'phoneext' => $data['phoneext'],
            'mobile' => $data['mobile'],
            'appendsignature' => $data['appendsignature'],
            'signature' => wpautop(wptexturize(stripslashes($data['signature']))),
            'status' => $data['status'],
            'updated' => $updated,
            'created' => $created,
            'lastlogin' => $data['lastlogin']
        );

        jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_staff', $query_array);
        $staffid = jssupportticket::$_db->insert_id;

        $result = JSSTincluder::getObjectClass('uploads')->uploadStaffLogo($staffid , $this);

        if (jssupportticket::$_db->last_error == null) {
            //Entries in user role permission table
            $query = "SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` WHERE id = " . jssupportticket::$_db->insert_id;
            $staff = jssupportticket::$_db->get_row($query);
            $storeuserpermissions = JSSTincluder::getJSModel('userpermissions')->assignRolePermissionsToUser($staff);
            if ($storeuserpermissions == false) {
                jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_staff', array('id' => $newstaff->id));
                if (jssupportticket::$_db->last_error != null) {
                    JSSTincluder::getJSModel('systemerror')->addSystemError();
                }
                JSSTmessage::setMessage(__('Staff member has not been stored', 'js-support-ticket'), 'error');
            } else {
                JSSTmessage::setMessage(__('Staff member has been stored', 'js-support-ticket'), 'updated');
            }
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Staff member has not been stored', 'js-support-ticket'), 'error');
        }

        return;
    }

    function storeStaffLogo($id , $filename){
        if(is_numeric($id)){
            $this->errorcode = true;
            $this->filename = $filename;
            jssupportticket::$_db->query("UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_staff` SET photo = '" . $filename . "' WHERE id = $id");
        }
    }

    function uploadStaffImage() {
        $id = JSSTrequest::getVar('id');
    
        $result = JSSTincluder::getObjectClass('uploads')->uploadStaffLogo($id , $this);

        $array['errorcode'] = $this->errorcode;

        $datadirectory = jssupportticket::$_config['data_directory'];
        $maindir = wp_upload_dir();
        $path = $maindir['baseurl'];
        $path = $path .'/'.$datadirectory;
        $path = $path . '/staffdata/staff_'.$id;

        $path .= '/' . $this->filename;
        $array['imagepath'] = $path;
        echo json_encode($array);
        exit;
    }

    private function validateStaff($userid) {
        if (!is_numeric($userid))
            return false;
        $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` WHERE uid = " . $userid;
        $result = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null)
            JSSTincluder::getJSModel('systemerror')->addSystemError();

        if ($result >= 1)
            return false;
        else
            return true;
    }

    function removeStaff($id) {
        if (!is_numeric($id))
            return false;
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $allowed = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Delete User');
            if ($allowed != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'error');
                return;
            }
        }
        if ($this->canRemoveStaff($id)) {
            //jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_staff', array('id' => $id));
            $query = "DELETE staff.*, user_permission.*
                    FROM `".jssupportticket::$_db->prefix . "js_ticket_staff` AS staff
                    LEFT JOIN `".jssupportticket::$_db->prefix . "js_ticket_acl_user_permissions` AS user_permission ON staff.id = user_permission.staffid
                    WHERE staff.id = ".$id;
            jssupportticket::$_db->query($query);

            if (jssupportticket::$_db->last_error == null) {
                $this->deleteStaffLogo( $id );
                JSSTmessage::setMessage(__('Staff member has been deleted', 'js-support-ticket'), 'updated');
            } else {
                JSSTincluder::getJSModel('systemerror')->addSystemError();
                JSSTmessage::setMessage(__('Staff member has not been deleted', 'js-support-ticket'), 'error');
            }
        } else {
            JSSTmessage::setMessage(__('Staff member in use cannot deleted', 'js-support-ticket'), 'error');
        }
        return;
    }

    private function deleteStaffLogo( $staffid ){

        $datadirectory = jssupportticket::$_config['data_directory'];
        
        $maindir = wp_upload_dir();
        $path = $maindir['basedir'];
        $path = $path .'/'.$datadirectory;

        $path = $path . '/staffdata/staff_'.$staffid;
        $files = glob($path . '/*.*');
        array_map('unlink', $files); // delete all file in the direcoty

        rmdir($path);
    }

    private function canRemoveStaff($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT (
                    (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` WHERE staffid = " . $id . ")
                    + (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_categories` WHERE staffid = " . $id . ")
                    + (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_articles` WHERE staffid = " . $id . ")
                    + (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_downloads` WHERE staffid = " . $id . ")
                    + (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_announcements` WHERE staffid = " . $id . ")
                    + (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_faqs` WHERE staffid = " . $id . ")
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

    function getStaffForCombobox() {
        $query = "SELECT id AS id,CONCAT(firstname ,'  ' ,lastname) AS text FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` WHERE status = 1 AND uid != '' AND uid IS NOT NULL ";
        $list = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $list;
    }

    function getStaffForMailCombobox() {
        $uid = get_current_user_id();
        $query = "SELECT id AS id,CONCAT(firstname ,'  ' ,lastname) AS text FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` WHERE status = 1 AND uid != '' AND uid IS NOT NULL AND uid != $uid";
        $list = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $list;
    }

    function getStaffId($uid) {
        if (!is_numeric($uid))
            return false;
        $query = "SELECT id FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` WHERE uid = " . $uid;
        $staffid = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $staffid;
    }

    function changeStatus($id) {
        if (!is_numeric($id))
            return false;
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_staff` SET status = 1-status WHERE id=" . $id;
        jssupportticket::$_db->query($query);

        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Staff','js-support-ticket').' '.__('status has been changed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Staff','js-support-ticket').' '.__('status has not been changed', 'js-support-ticket'), 'error');
        }
        return;
    }

    function getUsersForCombobox() {
        $query = "SELECT id, user_nicename AS text FROM `" . jssupportticket::$_wpprefixforuser . "users` WHERE user_status = 1";
        $query = "SELECT id, user_nicename AS text FROM `" . jssupportticket::$_wpprefixforuser . "users`";

        $list = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $list;
    }

    function isUserStaff($uid = null) {
        if ($uid == null)
            $uid = get_current_user_id();
        if ($uid == 0) {
            return false;
        } else {
            $query = "SELECT id FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` WHERE uid = " . $uid;
            $staffid = jssupportticket::$_db->get_var($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError();
            }
            if ($staffid) {
                $query = "SELECT id FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` WHERE uid = " . $uid . " AND status = 1";
                $staffenabled = jssupportticket::$_db->get_var($query);
                if (jssupportticket::$_db->last_error != null) {
                    JSSTincluder::getJSModel('systemerror')->addSystemError();
                }
                if ($staffenabled) {
                    jssupportticket::$_data['staff_enabled'] = true;
                } else {
                    jssupportticket::$_data['staff_enabled'] = false;
                }
                return true;
            } else {
                return false;
            }
        }
    }

    function getUserListForRegistration() {
        $query = "SELECT DISTINCT EXISTS( SELECT staff.id FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff WHERE user.ID = staff.uid) AS alreadyuser,user.ID AS userid, user.user_login AS username, user.user_email AS useremail, user.display_name AS userdisplayname
                    FROM `" . jssupportticket::$_wpprefixforuser . "users` AS user ORDER BY alreadyuser";
        $users = jssupportticket::$_db->get_results($query);
        return $users;
    }

    function getStaffListForReports() {
        $query = "SELECT DISTINCT EXISTS( SELECT staff.id FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff WHERE user.ID = staff.uid) AS alreadyuser,user.ID AS userid, user.user_login AS username, user.user_email AS useremail, user.display_name AS userdisplayname
                    FROM `" . jssupportticket::$_wpprefixforuser . "users` AS user ORDER BY alreadyuser";
        $users = jssupportticket::$_db->get_results($query);
        return $users;
    }

    function getusersearchajax() {
        $username = JSSTrequest::getVar('username');
        $name = JSSTrequest::getVar('name');
        $emailaddress = JSSTrequest::getVar('emailaddress');
        $canloadresult = false;
        $query = "SELECT DISTINCT user.ID AS userid, user.user_login AS username, user.user_email AS useremail, user.display_name AS userdisplayname
                    FROM `" . jssupportticket::$_wpprefixforuser . "users` AS user
                    WHERE NOT EXISTS( SELECT staff.id FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff WHERE user.ID = staff.uid)";
        if (strlen($name) > 0) {
            $query .= " AND user.display_name LIKE '%$name%'";
            $canloadresult = true;
        }
        if (strlen($emailaddress) > 0) {
            $query .= " AND user.user_email LIKE '%$emailaddress%'";
            $canloadresult = true;
        }
        if (strlen($username) > 0) {
            $query .= " AND user.user_login LIKE '%$username%'";
            $canloadresult = true;
        }
        if($canloadresult){
            $users = jssupportticket::$_db->get_results($query);
            if(!empty($users)){
                $result ='
                    <div class="js-col-md-2 js-title">'.__('User id','js-support-ticket').'</div>
                    <div class="js-col-md-3 js-title">'.__('Username','js-support-ticket').'</div>
                    <div class="js-col-md-4 js-title">'.__('Email address','js-support-ticket').'</div>
                    <div class="js-col-md-3 js-title">'.__('Name','js-support-ticket').'</div>';
                foreach ($users AS $user) {
                    $result .='
                        <div class="user-records-wrapper js-value" style="display:inline-block;width:100%;">
                            <div class="js-col-xs-12 js-col-md-2">
                                <span class="js-user-title-xs">'.__('User id','js-support-ticket').' : </span>'.$user->userid.'
                            </div>                            
                            <div class="js-col-xs-12 js-col-md-3">
                                <span class="js-user-title-xs">'.__('Username','js-support-ticket').' : </span>';
                                    $result .='<a href="#" class="js-userpopup-link" data-id="'.$user->userid.'" data-email="'.$user->useremail.'" data-name="'.$user->userdisplayname.'">'.$user->username.'</a> </div>';
                            $result .=
                            '<div class="js-col-xs-12 js-col-md-4">
                                <span class="js-user-title-xs">'.__('Email address','js-support-ticket').' : </span>'.$user->useremail.'
                            </div>
                            <div class="js-col-xs-12 js-col-md-3">
                                <span class="js-user-title-xs">'.__('Display name','js-support-ticket').' : </span>'.$user->userdisplayname.'
                            </div>
                        </div>';
                }
            }else{
                $result= JSSTlayout::getNoRecordFound();
            }
        }else{ // reset button
            //$result ='<div class="js-staff-searc-desc">'.__('Use Search Feature To Select The User','js-support-ticket').'</div>';
            $result = $this->getuserlistajax();
        }

        return $result;
    }

    function getusersearchstaffreportajax() {
        $userlimit = JSSTrequest::getVar('userlimit',null,0);
        $maxrecorded = 4;
        $name = JSSTrequest::getVar('name');
        $emailaddress = JSSTrequest::getVar('emailaddress');
        $query = "SELECT DISTINCT COUNT(user.ID)
                    FROM `" . jssupportticket::$_wpprefixforuser . "users` AS user
                    WHERE EXISTS(SELECT id FROM `".jssupportticket::$_db->prefix."js_ticket_staff` WHERE uid = user.ID) ";
        if (strlen($name) > 1) {
            $query .= " AND user.user_login LIKE '%$name%'";
        }
        if (strlen($emailaddress) > 1) {
            $query .= " AND user.user_email LIKE '%$emailaddress%'";
        }
        $total = jssupportticket::$_db->get_var($query);
        $limit = $userlimit * $maxrecorded;
        if($limit >= $total){
            $limit = 0;
        }
        $query = "SELECT DISTINCT user.ID AS userid, user.user_login AS username, user.user_email AS useremail, user.display_name AS userdisplayname
                    FROM `" . jssupportticket::$_wpprefixforuser . "users` AS user
                    WHERE EXISTS(SELECT id FROM `".jssupportticket::$_db->prefix."js_ticket_staff` WHERE uid = user.ID) ";
        if (strlen($name) > 1) {
            $query .= " AND user.user_login LIKE '%$name%'";
        }
        if (strlen($emailaddress) > 1) {
            $query .= " AND user.user_email LIKE '%$emailaddress%'";
        }
        $query .= " LIMIT $limit, $maxrecorded ";
        $users = jssupportticket::$_db->get_results($query);
        $html = $this->makeUserList($users,$total,$maxrecorded,$userlimit);
        return $html;
    }

    function getusersearchuserreportajax() {
        $userlimit = JSSTrequest::getVar('userlimit',null,0);
        $maxrecorded = 4;
        $name = JSSTrequest::getVar('name');
        $emailaddress = JSSTrequest::getVar('emailaddress');

        $query = "SELECT DISTINCT COUNT(user.ID)
                    FROM `" . jssupportticket::$_wpprefixforuser . "users` AS user
                    WHERE NOT EXISTS( SELECT staff.id FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff WHERE user.ID = staff.uid) ";
        if (strlen($name) > 1) {
            $query .= " AND user.user_login LIKE '%$name%'";
        }
        if (strlen($emailaddress) > 1) {
            $query .= " AND user.user_email LIKE '%$emailaddress%'";
        }
        $total = jssupportticket::$_db->get_results($query);
        $total = jssupportticket::$_db->get_var($query);
        $limit = $userlimit * $maxrecorded;
        if($limit >= $total){
            $limit = 0;
        }

        $query = "SELECT DISTINCT user.ID AS userid, user.user_login AS username, user.user_email AS useremail, user.display_name AS userdisplayname
                    FROM `" . jssupportticket::$_wpprefixforuser . "users` AS user
                    WHERE NOT EXISTS( SELECT staff.id FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff WHERE user.ID = staff.uid) ";
        if (strlen($name) > 1) {
            $query .= " AND user.user_login LIKE '%$name%'";
        }
        if (strlen($emailaddress) > 1) {
            $query .= " AND user.user_email LIKE '%$emailaddress%'";
        }
        $query .= " LIMIT $limit, $maxrecorded ";
        $users = jssupportticket::$_db->get_results($query);
        $html = $this->makeUserList($users,$total,$maxrecorded,$userlimit);
        return $html;
    }

    function getMySignature() {
        $uid = get_current_user_id();
        if (!is_numeric($uid))
            return false;
        $query = "SELECT signature FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` WHERE uid = $uid";
        $signature = jssupportticket::$_db->get_var($query);
        return $signature;
    }

    function getMyName($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT CONCAT(firstname,' ',lastname) AS name FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` WHERE id = $id";
        $staffname = jssupportticket::$_db->get_var($query);
        return $staffname;
    }

    function getUserNameById($id){
        if (!is_numeric($id))
            return false;
        $query = "SELECT user_nicename AS name FROM `" . jssupportticket::$_wpprefixforuser . "users` WHERE id = $id";
        $username = jssupportticket::$_db->get_var($query);
        return $username;
    }

    function getMyProfile() {
        $uid = get_current_user_id();
        if (!is_numeric($uid))
            return false;
        $query = "SELECT staff.*,role.name AS rolename ,user.user_login AS username
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff
                    JOIN `" . jssupportticket::$_db->prefix . "js_ticket_acl_roles` AS role ON role.id = staff.roleid
                    JOIN `" . jssupportticket::$_wpprefixforuser . "users` AS user ON user.id = staff.uid
                    WHERE uid = $uid";
        jssupportticket::$_data[0] = jssupportticket::$_db->get_row($query);
        return;
    }

    function getAllStaffMemberByDepId($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT staff.email ,
                    (SELECT usr_perm.grant 
                        FROM `".jssupportticket::$_db->prefix."js_ticket_acl_permissions` AS p
                        JOIN `".jssupportticket::$_db->prefix."js_ticket_acl_user_permissions` AS usr_perm ON usr_perm.permissionid = p.id
                        WHERE p.permission = 'New Ticket Notification' AND usr_perm.staffid = staff.id ) AS canemail
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_acl_user_access_departments` AS dep 
                    JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON staff.id = dep.staffid
                    WHERE dep.departmentid = $id";
        $staffmember = jssupportticket::$_db->get_results($query);
        return $staffmember;
    }

    function saveuserprofileajax() {
        $datafor = JSSTrequest::getVar('datafor');
        $value = JSSTrequest::getVar('value');
        $uid = get_current_user_id();
        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_staff` SET $datafor = '" . $value . "' WHERE uid = $uid";
        jssupportticket::$_db->query($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
            echo '0';
        } else {
            echo '1';
        }
        exit;
    }

    function getUidByStaffId($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT staff.uid 
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff
                    WHERE staff.id = $id";
        $uid = jssupportticket::$_db->get_var($query);
        return $uid;
    }

    function getRoleidByStaffId($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT staff.roleid 
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff
                    WHERE staff.id = $id";
        $roleid = jssupportticket::$_db->get_var($query);
        return $roleid;
    }

    function getuserlistajax(){
        $userlimit = JSSTrequest::getVar('userlimit',null,0);
        $maxrecorded = 4;
        $query = "SELECT DISTINCT COUNT(user.id)
                    FROM `" . jssupportticket::$_wpprefixforuser . "users` AS user
                    WHERE NOT EXISTS( SELECT staff.id FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff WHERE user.ID = staff.uid) ";
        $total = jssupportticket::$_db->get_var($query);
        $limit = $userlimit * $maxrecorded;
        if($limit >= $total){
            $limit = 0;
        }
        $query = "SELECT DISTINCT user.ID AS userid, user.user_login AS username, user.user_email AS useremail, user.display_name AS userdisplayname
                    FROM `" . jssupportticket::$_wpprefixforuser . "users` AS user
                    WHERE NOT EXISTS( SELECT staff.id FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff WHERE user.ID = staff.uid) 
                    LIMIT $limit, $maxrecorded";
        $users = jssupportticket::$_db->get_results($query);
        $html = $this->makeUserList($users,$total,$maxrecorded,$userlimit);
        return $html;

    }

    function makeUserList($users,$total,$maxrecorded,$userlimit){
        $html = '';
        if(!empty($users)){
            if(is_array($users)){
                $html ='
                    <div class="js-col-md-2 js-title">'.__('User id','js-support-ticket').'</div>
                    <div class="js-col-md-3 js-title">'.__('Username','js-support-ticket').'</div>
                    <div class="js-col-md-4 js-title">'.__('Email address','js-support-ticket').'</div>
                    <div class="js-col-md-3 js-title">'.__('Name','js-support-ticket').'</div>';
                foreach($users AS $user){
                    $html .='
                        <div class="user-records-wrapper js-value" style="display:inline-block;width:100%;">
                            <div class="js-col-xs-12 js-col-md-2">
                                <span class="js-user-title-xs">'.__('User id','js-support-ticket').' : </span>'.$user->userid.'
                            </div>                            
                            <div class="js-col-xs-12 js-col-md-3">
                                <span class="js-user-title-xs">'.__('Username','js-support-ticket').' : </span>';
                                    $html .='<a href="#" class="js-userpopup-link" data-id="'.$user->userid.'" data-email="'.$user->useremail.'" data-name="'.$user->userdisplayname.'">'.$user->username.'</a> </div>';
                            $html .=
                            '<div class="js-col-xs-12 js-col-md-4">
                                <span class="js-user-title-xs">'.__('Email address','js-support-ticket').' : </span>'.$user->useremail.'
                            </div>
                            <div class="js-col-xs-12 js-col-md-3">
                                <span class="js-user-title-xs">'.__('Display name','js-support-ticket').' : </span>'.$user->userdisplayname.'
                            </div>
                        </div>';
                }
                $num_of_pages = ceil($total / $maxrecorded);
                $num_of_pages = ($num_of_pages > 0) ? ceil($num_of_pages) : floor($num_of_pages);
                if($num_of_pages > 0){
                    $page_html = '';
                    $prev = $userlimit;
                    if($prev > 0){
                        $page_html .= '<a class="jsst_userlink" href="#" onclick="updateuserlist('.($prev - 1).');">'.__('Previous','js-support-ticket').'</a>';
                    }
                    for($i = 0; $i < $num_of_pages; $i++){
                        if($i == $userlimit)
                            $page_html .= '<span class="jsst_userlink selected" >'.($i + 1).'</span>';
                        else
                            $page_html .= '<a class="jsst_userlink" href="#" onclick="updateuserlist('.$i.');">'.($i + 1).'</a>';

                    }
                    $next = $userlimit + 1;
                    if($next < $num_of_pages){
                        $page_html .= '<a class="jsst_userlink" href="#" onclick="updateuserlist('.$next.');">'.__('Next','js-support-ticket').'</a>';
                    }
                    if($page_html != ''){
                        $html .= '<div class="jsst_userpages">'.$page_html.'</div>';
                    }
                }
            }
        }else{
            $html = JSSTlayout::getNoRecordFound();
        }
        return $html;        
    }
    
}

?>
