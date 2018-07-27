<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTpermissions {

    static function checkPermission($userid, $permissionfor) {
        $query = "SELECT perm_allowed.status
					FROM `" . jsjobs::$_db->prefix . "jsjobs_permissions` AS perm
					JOIN `" . jsjobs::$_db->prefix . "jsjobs_permissions_allowed` AS perm_allowed ON perm_allowed.permissionid = perm.id
					WHERE perm.permissions = '$permissionfor' AND perm_allowed.userid = $userid";
        $result = jsjobs::$_db->get_var($query);
        return $result;
    }

}

?>
