<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTsystemerrorModel {

    function getSystemErrors() {
        $inquery = '';
        // Pagination
        $query = "SELECT COUNT(`id`) FROM `" . jssupportticket::$_db->prefix . "js_ticket_system_errors`";
        $query .= $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        // Data
        $query = " SELECT systemerror.*
					FROM `" . jssupportticket::$_db->prefix . "js_ticket_system_errors` AS systemerror ";
        $query .= $inquery;
        $query .= " ORDER BY systemerror.created DESC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            $this->addSystemError();
        }
        return;
    }

    function addSystemError($error = null) {
        if($error == null) $error = jssupportticket::$_db->last_error;
        $query_array = array('error' => $error,
            'uid' => get_current_user_id(),
            'isview' => 0,
            'created' => date_i18n('Y-m-d H:i:s')
        );
        jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_system_errors', $query_array);
        if (jssupportticket::$_db->last_error != null) {
            $this->addSystemError();
        }
        return;
    }

    function updateIsView($id) {
        if (!is_numeric($id))
            return false;
        $query = "UPDATE " . jssupportticket::$_db->prefix . "`js_ticket_system_errors` set isview = 1 WHERE id = " . $id;
        jssupportticket::$_db->Query($query);
        if (jssupportticket::$_db->last_error != null) {
            $this->addSystemError();
        }
    }

}

?>
