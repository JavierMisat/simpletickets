<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTreplyModel {

    function getReplies($id) {
        if (!is_numeric($id))
            return false;
        // Data
        $query = "SELECT replies.*,replies.id AS replyid,tickets.id, staff.id AS staffid, staff.photo AS staffphoto 
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_replies` AS replies 
                    JOIN `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS tickets ON  replies.ticketid = tickets.id 
                    LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON replies.staffid = staff.id
                    WHERE tickets.id = " . $id . " ORDER By replies.id ASC";
        jssupportticket::$_data[4] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        $attachmentmodel = JSSTincluder::getJSModel('attachment');
        foreach (jssupportticket::$_data[4] AS $reply) {
            $reply->attachments = $attachmentmodel->getAttachmentForReply($reply->id, $reply->replyid);
        }
        return;
    }

    function getTicketNameForReplies() {
        $query = "SELECT id, ticketid AS text FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets`";
        $list = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $list;
    }

    function getRepliesForForm($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
            $query = "SELECT replies.*,tickets.id 
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_replies` AS replies 
                        JOIN `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS tickets ON  replies.ticketid = tickets.id 
                        WHERE replies.id = " . $id;
            jssupportticket::$_data[0] = jssupportticket::$_db->get_row($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            }
        }
        return;
    }

    function storeReplies($data) {
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $allowed = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Reply Ticket');
            if ($allowed != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'updated');
                return;
            }
        }

        $sendEmail = true;
        if (is_user_logged_in()) {
            $current_user = get_userdata(get_current_user_id());
            $currentUserName = $current_user->display_name;
            $staffid = JSSTincluder::getJSModel('staff')->getStaffId($current_user->ID);
        } else {
            $currentUserName = '';
            $staffid = 0;
        }
        //check the assign to me on reply
        if (isset($data['assigntome']) && $data['assigntome'] == 1) {
            JSSTincluder::getJSModel('ticket')->ticketAssignToMe($data['ticketid'], $staffid);
        }
        //check signature
        if (!isset($data['nonesignature'])) {
            if (isset($data['ownsignature']) && $data['ownsignature'] == 1) {
                $data['jsticket_message'] .= '<br/>' . JSSTincluder::getJSModel('staff')->getMySignature();
            }
            if (isset($data['departmentsignature']) && $data['departmentsignature'] == 1) {
                $data['jsticket_message'] .= '<br/>' . JSSTincluder::getJSModel('department')->getSignatureByID($data['departmentid']);
            }
        }
        if(isset($data['ticketviaemail'])){
            if($data['ticketviaemail'] == 1)
                $currentUserName = $data['name'];
        }
        $data['id'] = isset($data['id']) ? $data['id'] : '';
        $data['status'] = isset($data['status']) ? $data['status'] : '';
        $data['closeonreply'] = isset($data['closeonreply']) ? $data['closeonreply'] : '';
        $data['ticketviaemail'] = isset($data['ticketviaemail']) ? $data['ticketviaemail'] : 0;
        $data['message'] = wpautop(wptexturize(stripslashes($data['jsticket_message'])));
        if(empty($data['message'])){
            JSSTmessage::setMessage(__('Message field cannot be empty', 'js-support-ticket'), 'error');
            return false;
        }
        $query_array = array('id' => $data['id'],
            'uid' => $data['uid'],
            'ticketid' => $data['ticketid'],
            'name' => $currentUserName,
            'message' => $data['message'],
            'staffid' => $staffid,
            'status' => $data['status'],
            'ticketviaemail' => $data['ticketviaemail'],
            'created' => date_i18n('Y-m-d H:i:s')
        );
        jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_replies', $query_array);
        $replyid = jssupportticket::$_db->insert_id;
        if (jssupportticket::$_db->last_error == null) {
            //tickets attachments store
            $data['replyattachmentid'] = jssupportticket::$_db->insert_id;
            JSSTincluder::getJSModel('attachment')->storeAttachments($data);
            //reply stored change action		
            if (is_admin())
                JSSTincluder::getJSModel('ticket')->setStatus(3, $data['ticketid']); // 3 -> waiting for customer reply
            else {
                if (JSSTincluder::getJSModel('staff')->isUserStaff())
                    JSSTincluder::getJSModel('ticket')->setStatus(3, $data['ticketid']); // 3 -> waiting for customer reply
                else
                    JSSTincluder::getJSModel('ticket')->setStatus(1, $data['ticketid']); // 1 -> waiting for admin/staff reply
            }
            JSSTincluder::getJSModel('ticket')->updateLastReply($data['ticketid']);
            JSSTmessage::setMessage(__('Reply has been posted', 'js-support-ticket'), 'updated');
            $messagetype = __('Successfully', 'js-support-ticket');
        }else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Reply has not been posted', 'js-support-ticket'), 'error');
            $messagetype = __('Error', 'js-support-ticket');
            $sendEmail = false;
        }

        /* for activity log */
        $ticketid = $data['ticketid']; // get the ticket id
        $current_user = wp_get_current_user(); // to get current user name
        $currentUserName = $current_user->display_name;
        $eventtype = 'REPLIED_TICKET';
        $message = __('Ticket is replied by', 'js-support-ticket') . " ( " . $currentUserName . " ) ";
        JSSTincluder::getJSModel('activitylog')->addActivityLog($ticketid, 1, $eventtype, $message, $messagetype);

        // Send Emails
        if ($sendEmail == true) {
            if (is_admin()) {
                JSSTincluder::getJSModel('email')->sendMail(1, 4, $ticketid); // Mailfor, Reply Ticket
            } else {
                JSSTincluder::getJSModel('email')->sendMail(1, 5, $ticketid); // Mailfor, Reply Ticket
            }
            $ticketreplyobject = jssupportticket::$_db->get_row("SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_replies` WHERE id = " . $replyid);
            do_action('jsst-ticketreply', $ticketreplyobject);
        }
        // if Close on reply is cheked
        if ($data['closeonreply'] == 1) {
            JSSTincluder::getJSModel('ticket')->closeTicket($ticketid);
        }

        return;
    }

    function getLastReply($ticketid) {
        if (!is_numeric($ticketid))
            return false;
        $query = "SELECT created FROM `" . jssupportticket::$_db->prefix . "js_ticket_replies` WHERE ticketid =  " . $ticketid . " ORDER BY created desc";
        $lastreply = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
        }
        return $lastreply;
    }

    function removeTicketReplies($ticketid) {
        if(!is_numeric($ticketid)) return false;
        jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_replies', array('ticketid' => $ticketid));
        return;
    }
}

?>
