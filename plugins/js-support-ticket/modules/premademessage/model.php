<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTpremademessageModel {

    function getPremadeMessages() {
        // Filter
        $condition = " WHERE ";
        $title = JSSTrequest::getVar('title');
        $statusid = JSSTrequest::getVar('status');
        $departmentid = JSSTrequest::getVar('departmentid');
        $inquery = '';

        $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
        if ($formsearch == 'JSST_SEARCH') {
            $_SESSION['JSST_SEARCH']['title'] = $title;
            $_SESSION['JSST_SEARCH']['status'] = $statusid;
            $_SESSION['JSST_SEARCH']['departmentid'] = $departmentid;
        }

        if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
            $title = (isset($_SESSION['JSST_SEARCH']['title']) && $_SESSION['JSST_SEARCH']['title'] != '') ? $_SESSION['JSST_SEARCH']['title'] : null;
            $statusid = (isset($_SESSION['JSST_SEARCH']['status']) && $_SESSION['JSST_SEARCH']['status'] != '') ? $_SESSION['JSST_SEARCH']['status'] : null;
            $departmentid = (isset($_SESSION['JSST_SEARCH']['departmentid']) && $_SESSION['JSST_SEARCH']['departmentid'] != '') ? $_SESSION['JSST_SEARCH']['departmentid'] : null;
        }


        if ($title != null) {
            $inquery .=$condition . "premade.title LIKE '%$title%'";
            $condition = " AND ";
        }
        if ($departmentid) {
            if (!is_numeric($departmentid))
                return false;
            $inquery .=$condition . "premade.departmentid = " . $departmentid;
            $condition = " AND ";
        }
        if ($statusid > -1) {
            if (!is_numeric($statusid))
                return false;
            $inquery .=$condition . "premade.status= " . $statusid;
        }

        jssupportticket::$_data['filter']['title'] = $title;
        jssupportticket::$_data['filter']['status'] = $statusid;
        jssupportticket::$_data['filter']['departmentid'] = $departmentid;

        // Pagination
        $query = "SELECT COUNT(`id`) FROM `" . jssupportticket::$_db->prefix . "js_ticket_department_message_premade` AS premade";
        $query .= $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        // Data
        $query = "SELECT premade.*,department.departmentname AS departmentname
					FROM `" . jssupportticket::$_db->prefix . "js_ticket_department_message_premade` AS premade 
					JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON premade.departmentid = department.id";
        $query .= $inquery;
        $query .= " ORDER BY premade.status ASC,premade.title ASC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function getPremadeMessageForForm($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
            $query = "SELECT premade.*,department.departmentname AS departmentname
								FROM `" . jssupportticket::$_db->prefix . "js_ticket_department_message_premade` AS premade 
								JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON premade.departmentid = department.id 
								WHERE premade.id = " . $id;
            jssupportticket::$_data[0] = jssupportticket::$_db->get_row($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            }
        }
        return;
    }

    function checkPremadeDeprt() {
        if(JSSTincluder::getJSModel('ticket')->totalTicket() < 100) return true;
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
    function storePreMadeMessage($data) {
        if ($data['id'])
            $data['updated'] = date_i18n('Y-m-d H:i:s');
        elseif (!$data['id']) {
            $data['created'] = date_i18n('Y-m-d H:i:s');
        }
        $query_array = array('id' => $data['id'],
            'title' => $data['title'],
            'departmentid' => $data['departmentid'],
            'answer' => wpautop(wptexturize(stripslashes($data['answer']))),
            'status' => $data['status'],
            'updated' => $data['updated'],
            'created' => $data['created']
        );

        jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_department_message_premade', $query_array);
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Premade department message has been stored', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Premade department message has not been stored', 'js-support-ticket'), 'error');
        }
        $this->checkPremadeDeprt();
        return;
    }

    function removePreMadeMessage($id) {
        if (!is_numeric($id))
            return false;
        jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_department_message_premade', array('id' => $id));
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Premade department message has been deleted', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
            JSSTmessage::setMessage(__('Premade department message has not been deleted', 'js-support-ticket'), 'error');
        }
        return;
    }

    function getPreMadeMessageForCombobox() {
        $query = "SELECT id, title  AS text FROM `" . jssupportticket::$_db->prefix . "js_ticket_department_message_premade` WHERE status = 1";
        $list = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $list;
    }

    function getpremadeajax() {
        $premadeid = JSSTrequest::getVar('val');
        if ($premadeid) {
            if (!is_numeric($premadeid))
                return '';
            $premade = jssupportticket::$_db->get_var("SELECT answer FROM `" . jssupportticket::$_db->prefix . "js_ticket_department_message_premade`  WHERE status = 1 AND id = " . $premadeid);
        } else
            $premade = '';
        return $premade;
    }

    function changeStatus($id) {

        if (!is_numeric($id))
            return false;

        $query = "UPDATE `" . jssupportticket::$_db->prefix . "js_ticket_department_message_premade` SET status = 1-status WHERE id=" . $id;
        jssupportticket::$_db->query($query);

        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Premade message','js-support-ticket').' '.__('status has been changed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Premade message','js-support-ticket').' '.__('status has not been changed', 'js-support-ticket'), 'error');
        }
        return;
    }

}

?>
