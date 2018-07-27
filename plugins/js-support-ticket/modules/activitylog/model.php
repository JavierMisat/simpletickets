<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTactivitylogModel {

    function getactivitylogs() {
        // Filter
        $event = JSSTrequest::getVar('event');
        $inquery = '';
        if ($event != null)
            $inquery .= " WHERE activitylog.event LIKE '%$event%'";

        // Pagination
        $query = "SELECT COUNT(`id`) FROM `" . jssupportticket::$_db->prefix . "js_ticket_activity_log`";
        $query .= $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        // Data
        $query = "SELECT activitylog.*
				FROM `" . jssupportticket::$_db->prefix . "js_ticket_activity_log` AS activitylog ";
        $query .= $inquery;
        $query .= " ORDER BY activitylog.id DESC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function addActivityLog($referenceid, $eventfor, $eventtype, $message, $messagetype) {
        if (is_admin()) {
            $level = 3; // 3 for admin 
        } else {
            $level = 1; // 1 for other activities
        }
        switch ($eventfor) {
            case 1:
                $event = __('Ticket', 'js-support-ticket');
                break;
        }
        if(!is_numeric($referenceid)) return false;
        $data['datetime'] = date_i18n('Y-m-d H:i:s');
        jssupportticket::$_db->replace(
                jssupportticket::$_db->prefix . 'js_ticket_activity_log', //table
                array('uid' => get_current_user_id(),
            'referenceid' => $referenceid,
            'level' => $level,
            'eventfor' => $eventfor,
            'event' => $event,
            'eventtype' => $eventtype,
            'message' => $message,
            'messagetype' => $messagetype,
            'datetime' => date_i18n('Y-m-d H:i:s')
        ));
        return;
    }

}

?>
