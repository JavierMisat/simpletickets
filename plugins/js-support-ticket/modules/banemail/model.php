<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTbanemailModel {

    function getbanemails() {
        // Filter
        $email = JSSTrequest::getVar('email');
        $inquery = '';

        $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
        if ($formsearch == 'JSST_SEARCH') {
            $_SESSION['JSST_SEARCH']['email'] = $email;
        }

        if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
            $email = (isset($_SESSION['JSST_SEARCH']['email']) && $_SESSION['JSST_SEARCH']['email'] != '') ? $_SESSION['JSST_SEARCH']['email'] : null;
        }

        if ($email != null)
            $inquery .= " WHERE banemail.email LIKE '%$email%'";

        jssupportticket::$_data['filter']['email'] = $email;

        // Pagination
        $query = "SELECT COUNT(`id`) FROM `" . jssupportticket::$_db->prefix . "js_ticket_email_banlist` AS  banemail";
        $query .= $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        // Data
        $query = "SELECT banemail.*,concat(staff.firstname,' ',staff.lastname) AS staffname,user.user_nicename
					FROM`" . jssupportticket::$_db->prefix . "js_ticket_email_banlist` AS banemail
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON banemail.submitter = staff.id
					LEFT JOIN `" . jssupportticket::$_wpprefixforuser . "users` AS user ON banemail.uid = user.ID";
        $query .= $inquery;
        $query .= " ORDER BY banemail.created DESC ,banemail.email ASC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function getBanEmailForForm($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
            $query = "SELECT banemail.*
						FROM `" . jssupportticket::$_db->prefix . "js_ticket_email_banlist` AS banemail 
						WHERE banemail.id = " . $id;
            jssupportticket::$_data[0] = jssupportticket::$_db->get_row($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            }
        }
        return;
    }

    function storeBanEmail($data) {
        if (!$data['id'])
            $data['created'] = date_i18n('Y-m-d H:i:s'); // new
        $query_array = array('id' => $data['id'],
            'email' => $data['email'],
            'submitter' => $data['submitter'],
            'uid' => get_current_user_id(),
            'created' => $data['created']
        );

        jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_email_banlist', $query_array);
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Ban Email has been stored', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Ban Email has not been stored', 'js-support-ticket'), 'error');
        }
        return;
    }

    function removeBanEmail($id) {
        if (!is_numeric($id))
            return false;
        if ($this->canRemoveBanEmail($id)) {
            jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_email_banlist', array('id' => $id));
            if (jssupportticket::$_db->last_error == null) {
                JSSTmessage::setMessage(__('Ban email has been deleted', 'js-support-ticket'), 'updated');
            } else {
                JSSTincluder::getJSModel('systemerror')->addSystemError();
                JSSTmessage::setMessage(__('Ban Email has not been deleted', 'js-support-ticket'), 'error');
            }
        } else {
            JSSTmessage::setMessage(__('Ban email does not exist', 'js-support-ticket'), 'error');
        }
        return;
    }

    private function canRemoveBanEmail($id) {
        return true;
    }

    function isEmailBan($emailaddress) {
        $query = "SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_email_banlist` WHERE email = '" . $emailaddress . "'";
        $result = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        if ($result > 0)
            return true;
        else
            return false;
    }

}

?>
