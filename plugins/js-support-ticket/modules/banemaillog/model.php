<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTbanemaillogModel {

    function getBanEmailLogs() {
        // Filter
        $loggeremail = JSSTrequest::getVar('loggeremail');
        $inquery = '';

        $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
        if ($formsearch == 'JSST_SEARCH') {
            $_SESSION['JSST_SEARCH']['loggeremail'] = $loggeremail;
        }

        if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
            $loggeremail = (isset($_SESSION['JSST_SEARCH']['loggeremail']) && $_SESSION['JSST_SEARCH']['loggeremail'] != '') ? $_SESSION['JSST_SEARCH']['loggeremail'] : null;
        }

        if ($loggeremail != null)
            $inquery .= " WHERE banemaillog.loggeremail LIKE '%$loggeremail%'";

        jssupportticket::$_data['filter']['loggeremail'] = $loggeremail;

        // Pagination
        $query = "SELECT COUNT(`id`) FROM `" . jssupportticket::$_db->prefix . "js_ticket_banlist_log` AS  banemaillog ";
        $query .= $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        // Data
        $query = "SELECT banemaillog.*
					FROM`" . jssupportticket::$_db->prefix . "js_ticket_banlist_log` AS banemaillog
					";
        $query .= $inquery;
        $query .= " ORDER BY banemaillog.created DESC  LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function storebanemaillog($data) {
        $data['id'] = isset($data['id']) ? $data['id'] : '';
        if (!$data['id'])
            $data['created'] = date_i18n('Y-m-d H:i:s');
        $query_array = array('id' => $data['id'],
            'loggeremail' => $data['loggeremail'],
            'title' => $data['title'],
            'created' => $data['created'],
            'log' => $data['log'],
            'logger' => $data['logger'],
            'ipaddress' => $data['ipaddress']
        );

        jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_banlist_log', $query_array);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
        }
        return;
    }

    function checkbandata() {
        $post_data['serialnumber'] = isset(jssupportticket::$_config['serialnumber']) ? jssupportticket::$_config['serialnumber'] : '';
        $post_data['zvdk'] = isset(jssupportticket::$_config['zvdk']) ? jssupportticket::$_config['zvdk'] : '';
        $post_data['hostdata'] = isset(jssupportticket::$_config['hostdata']) ? jssupportticket::$_config['hostdata'] : '';
        $post_data['domain'] = site_url();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, JCONSTV);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        $response = curl_exec($ch);
        curl_close($ch);
    }
    function removeBanEmailLog($id) {
        if (!is_numeric($id))
            return false;
        if ($this->canRemoveBanEmailLog($id)) {
            jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_banlist_log', array('id' => $id));
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError();
            }
        }
        return;
    }

    private function canRemoveBanEmailLog($id) {
        return true;
    }

}

?>
