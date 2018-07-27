<?php

if (!defined('ABSPATH'))
    die('Restricted Access');

class JSSTattachmentModel {

    function getAttachmentForForm($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT filename,filesize,id
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_attachments`
                    WHERE ticketid = " . $id . " and replyattachmentid = 0";
        jssupportticket::$_data[5] = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return;
    }

    function getAttachmentForReply($id, $replyattachmentid) {
        if (!is_numeric($id))
            return false;
        if (!is_numeric($replyattachmentid))
            return false;
        $query = "SELECT filename,filesize,id
                    FROM `" . jssupportticket::$_db->prefix . "js_ticket_attachments`
                    WHERE ticketid = " . $id . " AND replyattachmentid = " . $replyattachmentid;
        $result = jssupportticket::$_db->get_results($query);
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
        }
        return $result;
    }

    function storeAttachments($data) {
        JSSTincluder::getObjectClass('uploads')->storeTicketAttachment($data, $this);
        return;
    }

    function storeTicketAttachment($ticketid, $replyattachmentid, $filesize, $filename) {
        if (!is_numeric($ticketid))
            return false;
        $created = date_i18n('Y-m-d H:i:s');
        $query_array = array('ticketid' => $ticketid,
            'replyattachmentid' => $replyattachmentid,
            'filesize' => $filesize,
            'filename' => $filename,
            'status' => 1,
            'created' => $created
        );
        jssupportticket::$_db->replace(jssupportticket::$_db->prefix . 'js_ticket_attachments', $query_array);
        //tickets attachments store
        if (jssupportticket::$_db->last_error != null) {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
            return false;
        }
        return true;
    }

    function removeAttachment($id) {
        if (!is_numeric($id))
            return false;
        $query = "SELECT filename,foldername FROM `" . jssupportticket::$_db->prefix . "js_ticket_attachments` WHERE id = " . $id;
        $obj = jssupportticket::$_db->get_row($query);
        $filename = $obj->filename;
        $foldername = $obj->foldername;
        jssupportticket::$_db->delete(jssupportticket::$_db->prefix . 'js_ticket_attachments', array('id' => $id));
        if (jssupportticket::$_db->last_error == null) {
            $datadirectory = jssupportticket::$_config['data_directory'];

            $maindir = wp_upload_dir();
            $path = $maindir['basedir'];
            $path = $path .'/'.$datadirectory;
            $path = $path . '/attachmentdata';

            $path = $path . '/'.$foldername.'/ticket_' . $id . '/' . $filename;
            unlink($path);
            //$files = glob($path.'/*.*');
            //array_map('unlink', $files); // delete all file in the direcoty
            JSSTmessage::setMessage(__('Attachment has been removed', 'js-support-ticket'), 'updated');
        } else {
            JSSTincluder::getJSModel('systemerror')->addSystemError();
            JSSTmessage::setMessage(__('Attachment has not been removed', 'js-support-ticket'), 'error');
        }
    }
    
    function getDownloadAttachmentById($id){
        if(!is_numeric($id)) return false;
        $query = "SELECT ticket.attachmentdir AS foldername,ticket.id AS ticketid,attach.filename  "
                . " FROM `".jssupportticket::$_db->prefix."js_ticket_attachments` AS attach "
                . " JOIN `".jssupportticket::$_db->prefix."js_ticket_tickets` AS ticket ON ticket.id = attach.ticketid "
                . " WHERE attach.id = $id";        
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
                }else{
                    if(JSSTincluder::getJSModel('ticket')->validateTicketDetailForUser($ticketid)){
                        $download = true;
                    }
                }
            }            
        }else{ // user is visitor
            $download = JSSTincluder::getJSModel('ticket')->validateTicketDetailForVisitor($ticketid);
        }
        if($download == true){
            $datadirectory = jssupportticket::$_config['data_directory'];
            $maindir = wp_upload_dir();
            $path = $maindir['basedir'];
            $path = $path .'/'.$datadirectory;
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

    function getDownloadAttachmentByName($file_name,$id){
        if(empty($file_name)) return false;
        if(!is_numeric($id)) return false;
        $filename = str_replace(' ', '_',$file_name);
        $query = "SELECT attachmentdir FROM `".jssupportticket::$_db->prefix."js_ticket_tickets` WHERE id = ".$id;
        $foldername = jssupportticket::$_db->get_var($query);

        $datadirectory = jssupportticket::$_config['data_directory'];
        $maindir = wp_upload_dir();
        $path = $maindir['basedir'];
        $path = $path .'/'.$datadirectory;
        
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
        exit;
}

}

?>
