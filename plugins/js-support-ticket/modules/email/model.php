<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTemailModel {
    /*
      $mailfor
      For which purpose you want to send mail
      1 => Ticket

      $action
      For which action of $mailfor you want to send the mail
      1 => New Ticket Create
      2 => Close Ticket
      3 => Delete Ticket
      4 => Reply Ticket (Admin/Staff Member)
      5 => Reply Ticket (Ticket member)
      6 => Lock Ticket

      $id
      id required when recever emailaddress is stored in record
     */

    function sendMail($mailfor, $action, $id = null, $tablename = null) {
        if (!is_numeric($mailfor))
            return false;
        if (!is_numeric($action))
            return false;
        if ($id != null)
            if (!is_numeric($id))
                return false;
        $pageid = jssupportticket::getPageid();
        switch ($mailfor) {
            case 1: // Mail For Tickets
                switch ($action) {
                    case 1: // New Ticket Created
                        $ticketRecord = $this->getRecordByTablenameAndId('js_ticket_tickets', $id);
                        $Username = $ticketRecord->name;
                        $Subject = $ticketRecord->subject;
                        $TrackingId = $ticketRecord->ticketid;
                        $Email = $ticketRecord->email;
                        $DepName = $ticketRecord->departmentname;
                        $HelptopicName = $ticketRecord->topic;
                        $Message = $ticketRecord->message;
                        $matcharray = array(
                            '{USERNAME}' => $Username,
                            '{SUBJECT}' => $Subject,
                            '{TRACKINGID}' => $TrackingId,
                            '{DEPARTMENT}' => $DepName,
                            '{HELP_TOPIC}' => $HelptopicName,
                            '{EMAIL}' => $Email,
                            '{MESSAGE}' => $Message
                        );
                        $object = $this->getSenderEmailAndName($id);
                        $senderEmail = $object->email;
                        $senderName = $object->name;
                        // New ticket mail to admin
                        if (jssupportticket::$_config['new_ticket_mail_to_admin'] == 1) {
                            $adminEmailid = jssupportticket::$_config['default_admin_email'];
                            $adminEmail = $this->getEmailById($adminEmailid);
                            $template = $this->getTemplateForEmail('ticket-new-admin');
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $link = "<a href=" . admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                            $matcharray['{TICKETURL}'] = $link;
                            $msgBody .= '<input type="hidden" name="ticketid:' . $TrackingId . '###admin####" />';
                            $msgBody .= '<span style="display:none;" ticketid:' . $TrackingId . '###admin#### ></span>';
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($adminEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        //Check to send email to department
                        $query = "SELECT dept.sendmail, email.email AS emailaddress 
                                    FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` AS ticket 
                                    LEFT JOIN `".jssupportticket::$_db->prefix."js_ticket_departments` AS dept ON dept.id = ticket.departmentid
                                    LEFT JOIN `".jssupportticket::$_db->prefix."js_ticket_email` AS email ON email.id = dept.emailid 
                                    WHERE ticket.id = ".$id;
                        $dept_result = jssupportticket::$_db->get_row($query);
                        if($dept_result){
                            if(isset($dept_result->sendmail) && $dept_result->sendmail == 1){
                                $deptemail = $dept_result->emailaddress;
                                $template = $this->getTemplateForEmail('ticket-new-admin');
                                $msgSubject = $template->subject;
                                $msgBody = $template->body;
                                $link = "<a href=" . admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                                $matcharray['{TICKETURL}'] = $link;
                                $msgBody .= '<input type="hidden" name="ticketid:' . $TrackingId . '###admin####" />';
                                $msgBody .= '<span style="display:none;" ticketid:' . $TrackingId . '###admin#### ></span>';
                                $this->replaceMatches($msgSubject, $matcharray);
                                $this->replaceMatches($msgBody, $matcharray);
                                $this->sendEmail($deptemail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                            }
                        }
                        // New ticket mail to User
                        $template = $this->getTemplateForEmail('ticket-new');
                        //Parsing template
                        $msgSubject = $template->subject;
                        $msgBody = $template->body;
                    //token encrption
                        $tokenarray['emailaddress']=$Email;
                        $tokenarray['trackingid']=$TrackingId;
                        $token = json_encode($tokenarray);
                        include_once jssupportticket::$_path . 'includes/encoder.php';
                        $encoder = new JSSTEncoder(jssupportticket::$_config['encoder_key']);
                        $encryptedtext = $encoder->encrypt($token);
                    // end token encryotion    
                        $link = "<a href=" . site_url("?page_id=" . $pageid . "&jstmod=ticket&jstlay=ticketdetail&task=showticketstatus&action=jstask&token=" . $encryptedtext) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                        $matcharray['{TICKETURL}'] = $link;
                        $this->replaceMatches($msgSubject, $matcharray);
                        $this->replaceMatches($msgBody, $matcharray);
                        $msgBody .= '<input type="hidden" name="ticketid:' . $TrackingId . '###user####" />';
                        $msgBody .= '<span style="display:none;" ticketid:' . $TrackingId . '###user#### ></span>';
                        $this->sendEmail($Email, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);

                        $template = $this->getTemplateForEmail('ticket-staff');
                        $msgSubject = $template->subject;
                        $msgBody = $template->body;
                        $link = "<a href=" . site_url("?page_id=" . $pageid ."&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=" .$id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                        $matcharray['{TICKETURL}'] = $link;
                        $this->replaceMatches($msgSubject, $matcharray);
                        $this->replaceMatches($msgBody, $matcharray);
                        $msgBody .= '<input type="hidden" name="ticketid:' . $TrackingId . '###" />';
                        //New ticket mail to staff member
                        if (jssupportticket::$_config['new_ticket_mail_to_staff_members'] == 1) {
                            // Get All Staff member of the department of Current Ticket
                            $staffmembers = JSSTincluder::getJSModel('staff')->getAllStaffMemberByDepId($ticketRecord->departmentid);
                            if(is_array($staffmembers) && !empty($staffmembers)){
	                            foreach ($staffmembers AS $staff) {
	                                if($staff->canemail == 1){
	                                    $msgBody .= '<input type="hidden" name="ticketid:' . $TrackingId . '###staff####" />';
	                                    $msgBody .= '<span style="display:none;" ticketid:' . $TrackingId . '###staff#### ></span>';
	                                    $this->sendEmail($staff->email, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
	                                }
	                            }
	                        }
                        }
                        break;
                    case 2: // Close Ticket
                        $ticketRecord = $this->getRecordByTablenameAndId('js_ticket_tickets', $id);
                        $Username = $ticketRecord->name;
                        $Subject = $ticketRecord->subject;
                        $TrackingId = $ticketRecord->ticketid;
                        $Email = $ticketRecord->email;
                        $DepName = $ticketRecord->departmentname;
                        $HelptopicName = $ticketRecord->topic;
                        $Message = $ticketRecord->message;
                        $matcharray = array(
                            '{USERNAME}' => $Username,
                            '{SUBJECT}' => $Subject,
                            '{TRACKINGID}' => $TrackingId,
                            '{DEPARTMENT}' => $DepName,
                            '{HELP_TOPIC}' => $HelptopicName,
                            '{EMAIL}' => $Email,
                            '{MESSAGE}' => $Message
                        );
                        $object = $this->getSenderEmailAndName($id);
                        $senderEmail = $object->email;
                        $senderName = $object->name;
                        $template = $this->getTemplateForEmail('close-tk');
                        // Close ticket mail to admin
                        if (jssupportticket::$_config['ticket_close_admin'] == 1) {
                            $adminEmailid = jssupportticket::$_config['default_admin_email'];
                            $adminEmail = $this->getEmailById($adminEmailid);
                            $link = "<a href=" . admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                            $matcharray['{TICKETURL}'] = $link;
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($adminEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // Close ticket mail to staff member
                        if (jssupportticket::$_config['ticket_close_staff'] == 1) {
                            $staffEmail = $this->getStaffEmailAddressByStaffId($ticketRecord->staffid);
                            $link = "<a href=" . site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                            $matcharray['{TICKETURL}'] = $link;
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($staffEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // New ticket mail to User
                        if (jssupportticket::$_config['ticket_close_user'] == 1) {
                            $link = "<a href=" . site_url("?page_id=" . $pageid . "&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                            $matcharray['{TICKETURL}'] = $link;
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($Email, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        break;
                    case 3: // Delete Ticket
                        $TrackingId = jssupportticket::$_data['ticketid'];
                        $Email = jssupportticket::$_data['ticketemail'];
                        $Subject = jssupportticket::$_data['ticketsubject'];
                        $matcharray = array(
                            '{TRACKINGID}' => $TrackingId,
                            '{SUBJECT}' => $Subject
                        );
                        $object = $this->getSenderEmailAndName(null);
                        $senderEmail = $object->email;
                        $senderName = $object->name;
                        $template = $this->getTemplateForEmail('delete-tk');
                        // Delete ticket mail to admin
                        if (jssupportticket::$_config['ticket_delete_admin'] == 1) {
                            $adminEmailid = jssupportticket::$_config['default_admin_email'];
                            $adminEmail = $this->getEmailById($adminEmailid);
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($adminEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // Delete ticket mail to staff
                        if (jssupportticket::$_config['ticket_delete_staff'] == 1) {
                            $staff_id = jssupportticket::$_data['staffid'];
                            $staffEmail = $this->getStaffEmailAddressByStaffId($staff_id);
                            if( ! empty($staffEmail)){
                                $msgSubject = $template->subject;
                                $msgBody = $template->body;
                                $this->replaceMatches($msgSubject, $matcharray);
                                $this->replaceMatches($msgBody, $matcharray);
                                $this->sendEmail($staffEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                            }
                        }
                        // New ticket mail to User
                        if (jssupportticket::$_config['ticket_delete_user'] == 1) {
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($Email, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        break;
                    case 4: // Reply Ticket (Admin/Staff Member)
                        $ticketRecord = $this->getRecordByTablenameAndId('js_ticket_tickets', $id);
                        $Username = $ticketRecord->name;
                        $Subject = $ticketRecord->subject;
                        $TrackingId = $ticketRecord->ticketid;
                        $DepName = $ticketRecord->departmentname;
                        $HelptopicName = $ticketRecord->topic;
                        $Email = $ticketRecord->email;
                        $Message = $this->getLatestReplyByTicketId($id);
                        $matcharray = array(
                            '{USERNAME}' => $Username,
                            '{SUBJECT}' => $Subject,
                            '{TRACKINGID}' => $TrackingId,
                            '{DEPARTMENT}' => $DepName,
                            '{HELP_TOPIC}' => $HelptopicName,
                            '{EMAIL}' => $Email,
                            '{MESSAGE}' => $Message
                        );
                        $object = $this->getSenderEmailAndName($id);
                        $senderEmail = $object->email;
                        $senderName = $object->name;
                        $template = $this->getTemplateForEmail('reply-tk');
                        // Reply ticket mail to admin
                        if (jssupportticket::$_config['ticket_response_to_staff_admin'] == 1) {
                            $adminEmailid = jssupportticket::$_config['default_admin_email'];
                            $adminEmail = $this->getEmailById($adminEmailid);
                            $link = "<a href=" . admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                            $matcharray['{TICKETURL}'] = $link;
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $msgBody .= '<input type="hidden" name="ticketid:' . $TrackingId . '###admin####" />';
                            $this->sendEmail($adminEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // Reply ticket mail to staff
                        if (jssupportticket::$_config['ticket_response_to_staff'] == 1) {
                            $staffEmail = $this->getStaffEmailAddressByStaffId($ticketRecord->staffid);
                            $link = "<a href=" . site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                            $matcharray['{TICKETURL}'] = $link;
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $msgBody .= '<input type="hidden" name="ticketid:' . $TrackingId . '###staff####" />';
                            $this->sendEmail($staffEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // New ticket mail to User
                        $template = $this->getTemplateForEmail('responce-tk');
                        if (jssupportticket::$_config['ticket_response_to_staff_user'] == 1) {
                        //token encrption
                            $tokenarray['emailaddress']=$Email;
                            $tokenarray['trackingid']=$TrackingId;
                            $token = json_encode($tokenarray);
                            include_once jssupportticket::$_path . 'includes/encoder.php';
                            $encoder = new JSSTEncoder(jssupportticket::$_config['encoder_key']);
                            $encryptedtext = $encoder->encrypt($token);
                        // end token encryotion    
                            $link = "<a href=" . site_url("?page_id=" . $pageid . "&jstmod=ticket&jstlay=ticketdetail&task=showticketstatus&action=jstask&token=".$encryptedtext) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                            $matcharray['{TICKETURL}'] = $link;
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $msgBody .= '<input type="hidden" name="ticketid:' . $TrackingId . '###user####" />';
                            $this->sendEmail($Email, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        break;
                    case 5: // Reply Ticket (Ticket Member)
                        $ticketRecord = $this->getRecordByTablenameAndId('js_ticket_tickets', $id);
                        $Username = $ticketRecord->name;
                        $Subject = $ticketRecord->subject;
                        $TrackingId = $ticketRecord->ticketid;
                        $DepName = $ticketRecord->departmentname;
                        $HelptopicName = $ticketRecord->topic;
                        $Email = $ticketRecord->email;
                        $Message = $this->getLatestReplyByTicketId($id);
                        $matcharray = array(
                            '{USERNAME}' => $Username,
                            '{SUBJECT}' => $Subject,
                            '{TRACKINGID}' => $TrackingId,
                            '{DEPARTMENT}' => $DepName,
                            '{HELP_TOPIC}' => $HelptopicName,
                            '{EMAIL}' => $Email,
                            '{MESSAGE}' => $Message
                        );
                        $object = $this->getSenderEmailAndName($id);
                        $senderEmail = $object->email;
                        $senderName = $object->name;
                        $template = $this->getTemplateForEmail('reply-tk');
                        // New ticket mail to admin
                        if (jssupportticket::$_config['ticket_reply_ticket_user_admin'] == 1) {
                            $adminEmailid = jssupportticket::$_config['default_admin_email'];
                            $adminEmail = $this->getEmailById($adminEmailid);
                            $link = "<a href=" . admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                            $matcharray['{TICKETURL}'] = $link;
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $msgBody .= '<input type="hidden" name="ticketid:' . $TrackingId . '###admin####" />';
                            $this->sendEmail($adminEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // New ticket mail to staff
                        if (jssupportticket::$_config['ticket_reply_ticket_user_staff'] == 1) {
                            $staffEmail = $this->getStaffEmailAddressByStaffId($ticketRecord->staffid);
                            $link = "<a href=" . site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                            $matcharray['{TICKETURL}'] = $link;
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $msgBody .= '<input type="hidden" name="ticketid:' . $TrackingId . '###staff####" />';
                            $this->sendEmail($staffEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // New ticket mail to User
                        if (jssupportticket::$_config['ticket_reply_ticket_user_user'] == 1) {
                        //token encrption
                            $tokenarray['emailaddress']=$Email;
                            $tokenarray['trackingid']=$TrackingId;
                            $token = json_encode($tokenarray);
                            include_once jssupportticket::$_path . 'includes/encoder.php';
                            $encoder = new JSSTEncoder(jssupportticket::$_config['encoder_key']);
                            $encryptedtext = $encoder->encrypt($token);
                        // end token encryotion    
                            $link = "<a href=" . site_url("?page_id=" . $pageid . "&jstmod=ticket&jstlay=ticketdetail&task=showticketstatus&action=jstask&token=".$encryptedtext) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                            $matcharray['{TICKETURL}'] = $link;
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $msgBody .= '<input type="hidden" name="ticketid:' . $TrackingId . '###user####" />';
                            $this->sendEmail($Email, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        break;
                    case 6: // Lock Ticket 
                        $ticketRecord = $this->getRecordByTablenameAndId('js_ticket_tickets', $id);
                        $Username = $ticketRecord->name;
                        $Subject = $ticketRecord->subject;
                        $TrackingId = $ticketRecord->ticketid;
                        $DepName = $ticketRecord->departmentname;
                        $HelptopicName = $ticketRecord->topic;
                        $Email = $ticketRecord->email;
                        $matcharray = array(
                            '{USERNAME}' => $Username,
                            '{SUBJECT}' => $Subject,
                            '{TRACKINGID}' => $TrackingId,
                            '{DEPARTMENT}' => $DepName,
                            '{HELP_TOPIC}' => $HelptopicName,
                            '{EMAIL}' => $Email
                        );
                        $object = $this->getSenderEmailAndName($id);
                        $senderEmail = $object->email;
                        $senderName = $object->name;
                        $template = $this->getTemplateForEmail('lock-tk');
                        // New ticket mail to admin
                        if (jssupportticket::$_config['ticket_lock_admin'] == 1) {
                            $adminEmailid = jssupportticket::$_config['default_admin_email'];
                            $adminEmail = $this->getEmailById($adminEmailid);
                            $link = "<a href=" . admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $matcharray['{TICKETURL}'] = $link;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($adminEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // New ticket mail to staff
                        if (jssupportticket::$_config['ticket_lock_staff'] == 1) {
                            $staffEmail = $this->getStaffEmailAddressByStaffId($ticketRecord->staffid);
                            $link = "<a href=" . site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $matcharray['{TICKETURL}'] = $link;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($staffEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // New ticket mail to User
                        if (jssupportticket::$_config['ticket_lock_user'] == 1) {
                            $link = "<a href=" . site_url("?page_id=" . $pageid . "&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $matcharray['{TICKETURL}'] = $link;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($Email, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        break;
                    case 7: // Unlock Ticket 
                        $ticketRecord = $this->getRecordByTablenameAndId('js_ticket_tickets', $id);
                        $Username = $ticketRecord->name;
                        $Subject = $ticketRecord->subject;
                        $TrackingId = $ticketRecord->ticketid;
                        $DepName = $ticketRecord->departmentname;
                        $HelptopicName = $ticketRecord->topic;
                        $Email = $ticketRecord->email;
                        $matcharray = array(
                            '{USERNAME}' => $Username,
                            '{SUBJECT}' => $Subject,
                            '{TRACKINGID}' => $TrackingId,
                            '{DEPARTMENT}' => $DepName,
                            '{HELP_TOPIC}' => $HelptopicName,
                            '{EMAIL}' => $Email
                        );
                        $object = $this->getSenderEmailAndName($id);
                        $senderEmail = $object->email;
                        $senderName = $object->name;
                        $template = $this->getTemplateForEmail('unlock-tk');
                        // New ticket mail to admin
                        if (jssupportticket::$_config['ticket_unlock_admin'] == 1) {
                            $adminEmailid = jssupportticket::$_config['default_admin_email'];
                            $adminEmail = $this->getEmailById($adminEmailid);
                            $link = "<a href=" . admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $matcharray['{TICKETURL}'] = $link;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($adminEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // New ticket mail to staff
                        if (jssupportticket::$_config['ticket_unlock_staff'] == 1) {
                            $staffEmail = $this->getStaffEmailAddressByStaffId($ticketRecord->staffid);
                            $link = "<a href=" . site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $matcharray['{TICKETURL}'] = $link;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($staffEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // New ticket mail to User
                        if (jssupportticket::$_config['ticket_unlock_user'] == 1) {
                            $link = "<a href=" . site_url("?page_id=" . $pageid . "&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $matcharray['{TICKETURL}'] = $link;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($Email, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        break;
                    case 8: // Markoverdue Ticket 
                        $ticketRecord = $this->getRecordByTablenameAndId('js_ticket_tickets', $id);
                        $TrackingId = $ticketRecord->ticketid;
                        $DepName = $ticketRecord->departmentname;
                        $HelptopicName = $ticketRecord->topic;
                        $Email = $ticketRecord->email;
                        $Subject = $ticketRecord->subject;
                        $matcharray = array(
                            '{TRACKINGID}' => $TrackingId,
                            '{DEPARTMENT}' => $DepName,
                            '{HELP_TOPIC}' => $HelptopicName,
                            '{SUBJECT}' => $Subject
                        );
                        $object = $this->getSenderEmailAndName($id);
                        $senderEmail = $object->email;
                        $senderName = $object->name;
                        $template = $this->getTemplateForEmail('moverdue-tk');
                        // New ticket mail to admin
                        if (jssupportticket::$_config['ticket_mark_overdue_admin'] == 1) {
                            $adminEmailid = jssupportticket::$_config['default_admin_email'];
                            $adminEmail = $this->getEmailById($adminEmailid);
                            $link = "<a href=" . admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $matcharray['{TICKETURL}'] = $link;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($adminEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // New ticket mail to staff
                        if (jssupportticket::$_config['ticket_mark_overdue_staff'] == 1) {
                            $staffEmail = $this->getStaffEmailAddressByStaffId($ticketRecord->staffid);
                            $link = "<a href=" . site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $matcharray['{TICKETURL}'] = $link;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($staffEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // New ticket mail to User
                        if (jssupportticket::$_config['ticket_mark_overdue_user'] == 1) {
                            $link = "<a href=" . site_url("?page_id=" . $pageid . "&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $matcharray['{TICKETURL}'] = $link;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($Email, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        break;
                    case 9: // Mark in progress Ticket 
                        $ticketRecord = $this->getRecordByTablenameAndId('js_ticket_tickets', $id);
                        $TrackingId = $ticketRecord->ticketid;
                        $DepName = $ticketRecord->departmentname;
                        $HelptopicName = $ticketRecord->topic;
                        $Email = $ticketRecord->email;
                        $Subject = $ticketRecord->subject;
                        $matcharray = array(
                            '{TRACKINGID}' => $TrackingId,
                            '{DEPARTMENT}' => $DepName,
                            '{HELP_TOPIC}' => $HelptopicName,
                            '{SUBJECT}' => $Subject
                        );
                        $object = $this->getSenderEmailAndName($id);
                        $senderEmail = $object->email;
                        $senderName = $object->name;
                        $template = $this->getTemplateForEmail('minprogress-tk');
                        // New ticket mail to admin
                        if (jssupportticket::$_config['ticket_mark_progress_admin'] == 1) {
                            $adminEmailid = jssupportticket::$_config['default_admin_email'];
                            $adminEmail = $this->getEmailById($adminEmailid);
                            $link = "<a href=" . admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $matcharray['{TICKETURL}'] = $link;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($adminEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // New ticket mail to staff
                        if (jssupportticket::$_config['ticket_mark_progress_staff'] == 1) {
                            $staffEmail = $this->getStaffEmailAddressByStaffId($ticketRecord->staffid);
                            $link = "<a href=" . site_url("?page_id=" . jssupportticket::getPageid() . "&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $matcharray['{TICKETURL}'] = $link;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($staffEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // New ticket mail to User
                        if (jssupportticket::$_config['ticket_mark_progress_user'] == 1) {
                            $link = "<a href=" . site_url("?page_id=" . $pageid . "&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                            $msgSubject = $template->subject;
                            $msgBody = $template->body;
                            $matcharray['{TICKETURL}'] = $link;
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($Email, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        break;
                    case 10: // Ban email and close Ticket 
                        $ticketRecord = $this->getRecordByTablenameAndId('js_ticket_tickets', $id);
                        $TrackingId = $ticketRecord->ticketid;
                        $DepName = $ticketRecord->departmentname;
                        $HelptopicName = $ticketRecord->topic;
                        $Email = $ticketRecord->email;
                        $Subject = $ticketRecord->subject;
                        $matcharray = array(
                            '{EMAIL_ADDRESS}' => $Email,
                            '{SUBJECT}' => $Subject,
                            '{DEPARTMENT}' => $DepName,
                            '{HELP_TOPIC}' => $HelptopicName,
                            '{TRACKINGID}' => $TrackingId
                        );
                        $object = $this->getSenderEmailAndName($id);
                        $senderEmail = $object->email;
                        $senderName = $object->name;
                        $template = $this->getTemplateForEmail('banemailcloseticket-tk');
                        $msgSubject = $template->subject;
                        $msgBody = $template->body;
                        // New ticket mail to admin
                        if (jssupportticket::$_config['ticker_ban_eamil_and_close_ticktet_admin'] == 1) {
                            $adminEmailid = jssupportticket::$_config['default_admin_email'];
                            $adminEmail = $this->getEmailById($adminEmailid);
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($adminEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // New ticket mail to staff
                        if (jssupportticket::$_config['ticker_ban_eamil_and_close_ticktet_staff'] == 1) {
                            $staffEmail = $this->getStaffEmailAddressByStaffId($ticketRecord->staffid);
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($staffEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // New ticket mail to User
                        if (jssupportticket::$_config['ticker_ban_eamil_and_close_ticktet_user'] == 1) {
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($Email, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        break;
                    case 11: // Priority change ticket 
                        $ticketRecord = $this->getRecordByTablenameAndId('js_ticket_tickets', $id);
                        $TrackingId = $ticketRecord->ticketid;
                        $Subject = $ticketRecord->subject;
                        $DepName = $ticketRecord->departmentname;
                        $HelptopicName = $ticketRecord->topic;
                        $Email = $ticketRecord->email;
                        $Priority = JSSTincluder::getJSModel('priority')->getPriorityById($ticketRecord->priorityid);
                        $matcharray = array(
                            '{PRIORITY_TITLE}' => $Priority,
                            '{SUBJECT}' => $Subject,
                            '{DEPARTMENT}' => $DepName,
                            '{HELP_TOPIC}' => $HelptopicName,
                            '{TRACKINGID}' => $TrackingId
                        );
                        $object = $this->getSenderEmailAndName($id);
                        $senderEmail = $object->email;
                        $senderName = $object->name;
                        $template = $this->getTemplateForEmail('prtrans-tk');
                        $msgSubject = $template->subject;
                        $msgBody = $template->body;
                        // New ticket mail to admin
                        if (jssupportticket::$_config['ticket_priority_admin'] == 1) {
                            $link = "<a href=" . admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                            $matcharray['{TICKETURL}'] = $link;
                            $adminEmailid = jssupportticket::$_config['default_admin_email'];
                            $adminEmail = $this->getEmailById($adminEmailid);
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($adminEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        $msgSubject = $template->subject;
                        $msgBody = $template->body;
                        $link = "<a href=" . site_url("?page_id=" . $pageid . "&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                        $matcharray['{TICKETURL}'] = $link;
                        // New ticket mail to staff
                        if (jssupportticket::$_config['ticket_priority_staff'] == 1) {
                            $staffEmail = $this->getStaffEmailAddressByStaffId($ticketRecord->staffid);
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($staffEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // New ticket mail to User
                        if (jssupportticket::$_config['ticket_priority_user'] == 1) {
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($Email, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        break;
                    case 12: // DEPARTMENT TRANSFER 
                        $ticketRecord = $this->getRecordByTablenameAndId('js_ticket_tickets', $id);
                        $TrackingId = $ticketRecord->ticketid;
                        $Subject = $ticketRecord->subject;
                        $DepName = $ticketRecord->departmentname;
                        $HelptopicName = $ticketRecord->topic;
                        $Email = $ticketRecord->email;
                        $Department = JSSTincluder::getJSModel('department')->getDepartmentById($ticketRecord->departmentid);
                        $matcharray = array(
                            '{DEPARTMENT_TITLE}' => $Department,
                            '{SUBJECT}' => $Subject,
                            '{DEPARTMENT}' => $DepName,
                            '{HELP_TOPIC}' => $HelptopicName,
                            '{TRACKINGID}' => $TrackingId
                        );
                        $object = $this->getSenderEmailAndName($id);
                        $senderEmail = $object->email;
                        $senderName = $object->name;
                        $template = $this->getTemplateForEmail('deptrans-tk');
                        $msgSubject = $template->subject;
                        $msgBody = $template->body;
                        // New ticket mail to admin
                        if (jssupportticket::$_config['ticket_department_transfer_admin'] == 1) {
                            $adminEmailid = jssupportticket::$_config['default_admin_email'];
                            $adminEmail = $this->getEmailById($adminEmailid);
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($adminEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // New ticket mail to staff
                        if (jssupportticket::$_config['ticket_department_transfer_staff'] == 1) {
                            $staffEmail = $this->getStaffEmailAddressByStaffId($ticketRecord->staffid);
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($staffEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // New ticket mail to User
                        if (jssupportticket::$_config['ticket_department_transfer_user'] == 1) {
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($Email, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        break;
                    case 13: // REASSIGN TICKET TO STAFF 
                        $ticketRecord = $this->getRecordByTablenameAndId('js_ticket_tickets', $id);
                        $TrackingId = $ticketRecord->ticketid;
                        $DepName = $ticketRecord->departmentname;
                        $HelptopicName = $ticketRecord->topic;
                        $Email = $ticketRecord->email;
                        $Subject = $ticketRecord->subject;
                        $Staff = JSSTincluder::getJSModel('staff')->getMyName($ticketRecord->staffid);
                        $matcharray = array(
                            '{STAFF_MEMBER_NAME}' => $Staff,
                            '{SUBJECT}' => $Subject,
                            '{DEPARTMENT}' => $DepName,
                            '{HELP_TOPIC}' => $HelptopicName,
                            '{TRACKINGID}' => $TrackingId
                        );
                        $object = $this->getSenderEmailAndName($id);
                        $senderEmail = $object->email;
                        $senderName = $object->name;
                        $template = $this->getTemplateForEmail('reassign-tk');
                        $msgSubject = $template->subject;
                        $msgBody = $template->body;
                        // New ticket mail to admin
                        $link = "<a href=" . admin_url("admin.php?page=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                        $matcharray['{TICKETURL}'] = $link;
                        if (jssupportticket::$_config['ticket_reassign_admin'] == 1) {
                            $adminEmailid = jssupportticket::$_config['default_admin_email'];
                            $adminEmail = $this->getEmailById($adminEmailid);
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($adminEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        $msgSubject = $template->subject;
                        $msgBody = $template->body;
                        $matcharray = array(
                            '{STAFF_MEMBER_NAME}' => $Staff,
                            '{SUBJECT}' => $Subject,
                            '{DEPARTMENT}' => $DepName,
                            '{HELP_TOPIC}' => $HelptopicName,
                            '{TRACKINGID}' => $TrackingId
                        );
                        $link = "<a href=" . site_url("?page_id=" . $pageid . "&jstmod=ticket&jstlay=ticketdetail&jssupportticketid=" . $id) . ">" . __('Ticket Detail', 'js-support-ticket') . "</a>";
                        $matcharray['{TICKETURL}'] = $link;
                        // New ticket mail to staff
                        if (jssupportticket::$_config['ticket_reassign_staff'] == 1) {
                            $staffEmail = $this->getStaffEmailAddressByStaffId($ticketRecord->staffid);
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($staffEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // New ticket mail to User
                        if (jssupportticket::$_config['ticket_reassign_user'] == 1) {
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($Email, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        break;
                }
                break;
            case 2: // Ban Email
                switch ($action) {
                    case 1: // Ban Email
                        if ($tablename != null)
                            $banemailRecord = $this->getRecordByTablenameAndId($tablename, $id);
                        else
                            $banemailRecord = $this->getRecordByTablenameAndId('js_ticket_email_banlist', $id);
                        $Email = $banemailRecord->email;
                        $matcharray = array(
                            '{EMAIL_ADDRESS}' => $Email
                        );
                        $object = $this->getDefaultSenderEmailAndName();
                        $senderEmail = $object->email;
                        $senderName = $object->name;
                        $template = $this->getTemplateForEmail('banemail-tk');
                        $msgSubject = $template->subject;
                        $msgBody = $template->body;
                        // New ticket mail to admin
                        if (jssupportticket::$_config['ticket_ban_email_admin'] == 1) {
                            $adminEmailid = jssupportticket::$_config['default_admin_email'];
                            $adminEmail = $this->getEmailById($adminEmailid);
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($adminEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // New ticket mail to staff
                        if (jssupportticket::$_config['ticket_ban_email_staff'] == 1) {
                            if ($tablename != null)
                                $staffEmail = $this->getStaffEmailAddressByStaffId($banemailRecord->staffid);
                            else
                                $staffEmail = $this->getStaffEmailAddressByStaffId($banemailRecord->submitter);
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($staffEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // New ticket mail to User
                        if (jssupportticket::$_config['ticket_ban_email_user'] == 1) {
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($Email, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        break;
                    case 2: // Unban Email
                        if ($tablename != null)
                            $ticketRecord = $this->getRecordByTablenameAndId($tablename, $id);
                        else
                            $ticketRecord = $this->getRecordByTablenameAndId('js_ticket_tickets', $id);
                        $Email = $ticketRecord->email;
                        $matcharray = array(
                            '{EMAIL_ADDRESS}' => $Email
                        );
                        $object = $this->getSenderEmailAndName($id);
                        $senderEmail = $object->email;
                        $senderName = $object->name;
                        $template = $this->getTemplateForEmail('unbanemail-tk');
                        $msgSubject = $template->subject;
                        $msgBody = $template->body;
                        // New ticket mail to admin
                        if (jssupportticket::$_config['unban_email_admin'] == 1) {
                            $adminEmailid = jssupportticket::$_config['default_admin_email'];
                            $adminEmail = $this->getEmailById($adminEmailid);
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($adminEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // New ticket mail to staff
                        if (jssupportticket::$_config['unban_email_staff'] == 1) {
                            if ($tablename != null)
                                $staffEmail = $this->getStaffEmailAddressByStaffId($ticketRecord->staffid);
                            else
                                $staffEmail = $this->getStaffEmailAddressByStaffId($ticketRecord->submitter);
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($staffEmail, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        // New ticket mail to User
                        if (jssupportticket::$_config['unban_email_user'] == 1) {
                            $this->replaceMatches($msgSubject, $matcharray);
                            $this->replaceMatches($msgBody, $matcharray);
                            $this->sendEmail($Email, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        }
                        break;
                }
                break;
            case 3: // Sending email alerts on mail system
                switch ($action) {
                    case 1: // Store message
                        $mailRecord = $this->getMailRecordById($id);
                        $matcharray = array(
                            '{STAFF_MEMBER_NAME}' => $mailRecord->sendername,
                            '{SUBJECT}' => $mailRecord->subject,
                            '{MESSAGE}' => $mailRecord->message
                        );
                        $object = $this->getSenderEmailAndName(null);
                        $senderEmail = $object->email;
                        $senderName = $object->name;
                        $template = $this->getTemplateForEmail('mail-new');
                        $msgSubject = $template->subject;
                        $msgBody = $template->body;
                        $Email = $mailRecord->receveremail;
                        $this->replaceMatches($msgSubject, $matcharray);
                        $this->replaceMatches($msgBody, $matcharray);
                        $this->sendEmail($Email, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        break;
                    case 2: // Store reply
                        $mailRecord = $this->getMailRecordById($id, 1);
                        $matcharray = array(
                            '{STAFF_MEMBER_NAME}' => $mailRecord->sendername,
                            '{SUBJECT}' => $mailRecord->subject,
                            '{MESSAGE}' => $mailRecord->message
                        );
                        $object = $this->getSenderEmailAndName(null);
                        $senderEmail = $object->email;
                        $senderName = $object->name;
                        $template = $this->getTemplateForEmail('mail-rpy');
                        $msgSubject = $template->subject;
                        $msgBody = $template->body;
                        $Email = $mailRecord->receveremail;
                        $this->replaceMatches($msgSubject, $matcharray);
                        $this->replaceMatches($msgBody, $matcharray);
                        $this->sendEmail($Email, $msgSubject, $msgBody, $senderEmail, $senderName, '', $action);
                        break;
                }
                break;
        }
    }

    function getMailRecordById($id, $replyto = null) {
        if (!is_numeric($id))
            return false;
        if ($replyto == null) {
            $query = "SELECT mail.subject,mail.message,CONCAT(staff.firstname,' ',staff.lastname) AS sendername 
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` AS mail 
                        JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON staff.id = mail.from 
                        WHERE mail.id = " . $id;
        } else {
            $query = "SELECT mail.subject,reply.message,CONCAT(staff.firstname,' ',staff.lastname) AS sendername 
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` AS reply 
                        JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff_mail` AS mail ON mail.id = reply.replytoid 
                        JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON staff.id = reply.from 
                        WHERE reply.id = " . $id;
        }
        $result = jssupportticket::$_db->get_row($query);
        return $result;
    }

    private function getStaffEmailAddressByStaffId($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT staff.email 
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff
                    WHERE staff.id = $id";
        $emailaddress = jssupportticket::$_db->get_var($query);
        return $emailaddress;
    }

    private function getLatestReplyByTicketId($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT reply.message FROM `" . jssupportticket::$_db->prefix . "js_ticket_replies` AS reply WHERE reply.ticketid = " . $id . " ORDER BY reply.created DESC LIMIT 1";
        $message = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $message;
    }

    private function replaceMatches(&$string, $matcharray) {
        foreach ($matcharray AS $find => $replace) {
            $string = str_replace($find, $replace, $string);
        }
    }

    private function sendEmail($recevierEmail, $subject, $body, $senderEmail, $senderName, $attachments = '', $action) {
        /*
          $attachments = array( WP_CONTENT_DIR . '/uploads/file_to_attach.zip' );
          $headers = 'From: My Name <myname@example.com>' . "\r\n";
          wp_mail('test@example.org', 'subject', 'message', $headers, $attachments );

          $action
          For which action of $mailfor you want to send the mail
          1 => New Ticket Create
          2 => Close Ticket
          3 => Delete Ticket
          4 => Reply Ticket (Admin/Staff Member)
          5 => Reply Ticket (Ticket member)
         */
        switch ($action) {
            case 1:
                do_action('jsst-beforeemailticketcreate', $recevierEmail, $subject, $body, $senderEmail);
                break;
            case 2:
                do_action('jsst-beforeemailticketreply', $recevierEmail, $subject, $body, $senderEmail);
                break;
            case 3:
                do_action('jsst-beforeemailticketclose', $recevierEmail, $subject, $body, $senderEmail);
                break;
            case 4:
                do_action('jsst-beforeemailticketdelete', $recevierEmail, $subject, $body, $senderEmail);
                break;
        }
        if (!$senderName)
            $senderName = jssupportticket::$_config['title'];
        $headers = 'From: ' . $senderName . ' <' . $senderEmail . '>' . "\r\n";
        add_filter('wp_mail_content_type', create_function('', 'return "text/html"; '));
        $body = preg_replace('/\r?\n|\r/', '<br/>', $body);
        $body = str_replace(array("\r\n", "\r", "\n"), "<br/>", $body);
        $body = nl2br($body);

        if(!wp_mail($recevierEmail, $subject, $body, $headers, $attachments)){
            if($GLOBALS['phpmailer']->ErrorInfo)
                JSSTincluder::getJSModel('systemerror')->addSystemError($GLOBALS['phpmailer']->ErrorInfo);
        }
    }

    private function getSenderEmailAndName($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
            $query = "SELECT email.email,email.name
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_tickets` AS ticket
                        JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON department.id = ticket.departmentid
                        JOIN `" . jssupportticket::$_db->prefix . "js_ticket_email` AS email ON email.id = department.emailid
                        WHERE ticket.id = " . $id;
            $email = jssupportticket::$_db->get_row($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError();
            }
        } else {
            $email = '';
        }
        if (empty($email)) {
            $email = $this->getDefaultSenderEmailAndName();
        }
        return $email;
    }

    private function getDefaultSenderEmailAndName() {
        $emailid = jssupportticket::$_config['default_alert_email'];
        $query = "SELECT email,name FROM `" . jssupportticket::$_db->prefix . "js_ticket_email` WHERE id = " . $emailid;
        $email = jssupportticket::$_db->get_row($query);
        return $email;
    }

    private function getTemplateForEmail($templatefor) {
        $query = "SELECT * FROM `" . jssupportticket::$_db->prefix . "js_ticket_emailtemplates` WHERE templatefor = '" . $templatefor . "'";
        $template = jssupportticket::$_db->get_row($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $template;
    }

    private function getRecordByTablenameAndId($tablename, $id) {
        if (!is_numeric($id))
            return false;
        switch($tablename){
            case 'js_ticket_tickets':
                $query = "SELECT ticket.*,department.departmentname,helptopic.topic "
                    . " FROM `" . jssupportticket::$_db->prefix . $tablename . "` AS ticket "
                    . " LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_departments` AS department ON department.id = ticket.departmentid "
                    . " LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_help_topics` AS helptopic ON helptopic.id = ticket.helptopicid "
                    . " WHERE ticket.id = " . $id;
            break;
            default:
                $query = "SELECT * FROM `" . jssupportticket::$_db->prefix . $tablename . "` WHERE id = " . $id;
            break;
        }
        $record = jssupportticket::$_db->get_row($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $record;
    }

    function getEmails() {
        // Filter
        $email = JSSTrequest::getVar('email');
        $inquery = '';
        if ($email != null)
            $inquery .= " WHERE email.email LIKE '%$email%'";

        $formsearch = JSSTrequest::getVar('JSST_form_search', 'post');
        if ($formsearch == 'JSST_SEARCH') {
            $_SESSION['JSST_SEARCH']['email'] = $email;
        }

        if (JSSTrequest::getVar('pagenum', 'get', null) != null) {
            $email = (isset($_SESSION['JSST_SEARCH']['email']) && $_SESSION['JSST_SEARCH']['email'] != '') ? $_SESSION['JSST_SEARCH']['email'] : null;
        }

        jssupportticket::$_data['filter']['email'] = $email;

        // Pagination
        $query = "SELECT COUNT(email.id) 
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_email` AS email ";
        $query .= $inquery;
        $total = jssupportticket::$_db->get_var($query);
        jssupportticket::$_data[1] = JSSTpagination::getPagination($total);

        // Data
        $query = " SELECT email.id, email.email, email.autoresponse, email.created, email.updated,email.status
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_email` AS email ";
        $query .= $inquery;
        $query .= " ORDER BY email.email DESC LIMIT " . JSSTpagination::getOffset() . ", " . JSSTpagination::getLimit();
        jssupportticket::$_data[0] = jssupportticket::$_db->get_results($query);
        jssupportticket::$_data['email'] = $email;
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function getAllEmailsForCombobox() {
        $query = "SELECT id AS id, email AS text FROM `" . jssupportticket::$_db->prefix . "js_ticket_email` WHERE status = 1 AND autoresponse = 1";
        $emails = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $emails;
    }

    function getEmailForForm($id) {
        if ($id) {
            if (!is_numeric($id))
                return false;
            $query = "SELECT email.id, email.email, email.autoresponse, email.created, email.updated,email.status
                        FROM `" . jssupportticket::$_db->prefix . "js_ticket_email` AS email 
                        WHERE email.id = " . $id;
            jssupportticket::$_data[0] = jssupportticket::$_db->get_row($query);
            if (jssupportticket::$_db->last_error != null) {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            }
        }
        return;
    }

    function storeEmail($data) {
        if ($data['id'])
            $data['updated'] = date_i18n('Y-m-d H:i:s');
        //echo $data['id']; exit;
        else
            $data['created'] = date_i18n('Y-m-d H:i:s');
        $query_array = array('id' => $data['id'],
            'email' => $data['email'],
            'autoresponse' => $data['autoresponse'],
            'priorityid' => $data['priority'],
            'status' => $data['status'],
            'created' => $data['created'],
            'updated' => $data['updated']
        );
        jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_email', $query_array);
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Email has been stored', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Email has not been stored', 'js-support-ticket'), 'error');
        }
        return;
    }

    function removeEmail($id) {
        if (!is_numeric($id))
            return false;
        if ($this->canRemoveEmail($id)) {
            jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_email', array('id' => $id));
            if (jssupportticket::$_db->last_error == null) {
                JSSTmessage::setMessage(__('Email has been deleted', 'js-support-ticket'), 'updated');
            } else {
                JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
                JSSTmessage::setMessage(__('Email has not been deleted', 'js-support-ticket'), 'error');
            }
        } else {
            JSSTmessage::setMessage(__('Email','js-support-ticket').' '.__('in use cannot deleted', 'js-support-ticket'), 'error');
        }
        return;
    }

    private function canRemoveEmail($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT (
                        (SELECT COUNT(id) FROM `" . jssupportticket::$_db->prefix . "js_ticket_departments` WHERE emailid = " . $id . ")
                        + (SELECT COUNT(*) FROM `" . jssupportticket::$_db->prefix . "js_ticket_config` WHERE configname = 'default_alert_email' AND configvalue = " . $id . ")
                        + (SELECT COUNT(*) FROM `" . jssupportticket::$_db->prefix . "js_ticket_config` WHERE configname = 'default_admin_email' AND configvalue = " . $id . ")
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

    function getEmailForDepartment() {
        $query = "SELECT id, email AS text FROM `" . jssupportticket::$_db->prefix . "js_ticket_email`";
        $emails = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $emails;
    }

    function getEmailById($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT email  FROM `" . jssupportticket::$_db->prefix . "js_ticket_email` WHERE id = " . $id;
        $email = jssupportticket::$_db->get_var($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $email;
    }

}

?>
